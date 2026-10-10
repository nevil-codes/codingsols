<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rejects form submissions that look automated: the hidden honeypot field
 * was filled in, the signed start time is missing or tampered with, the
 * form was submitted faster than a person could fill it in, or (when
 * Cloudflare Turnstile keys are configured) the Turnstile check failed.
 *
 * Pair with the <x-honeypot /> component inside the form.
 */
class BlockSpamBots
{
    public const HONEYPOT_FIELD = 'website';

    public const TIMESTAMP_FIELD = 'form_started_at';

    public const MIN_SECONDS = 2;

    public const TURNSTILE_FIELD = 'cf-turnstile-response';

    public const TURNSTILE_VERIFY_URL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

    public function handle(Request $request, Closure $next): Response
    {
        if ($reason = $this->spamReason($request)) {
            Log::info('Blocked spam submission', ['reason' => $reason, 'ip' => $request->ip(), 'path' => $request->path()]);

            throw ValidationException::withMessages([
                'form' => "We couldn't verify this submission. Please wait a moment and try again.",
            ]);
        }

        return $next($request);
    }

    public static function timestamp(): string
    {
        return Crypt::encryptString((string) now()->getTimestamp());
    }

    private function spamReason(Request $request): ?string
    {
        if (filled($request->input(self::HONEYPOT_FIELD))) {
            return 'honeypot';
        }

        try {
            $startedAt = (int) Crypt::decryptString((string) $request->input(self::TIMESTAMP_FIELD));
        } catch (DecryptException) {
            return 'missing or invalid timestamp';
        }

        if (now()->getTimestamp() - $startedAt < self::MIN_SECONDS) {
            return 'submitted too fast';
        }

        return $this->turnstileReason($request);
    }

    public static function turnstileEnabled(): bool
    {
        return filled(config('services.turnstile.site_key')) && filled(config('services.turnstile.secret_key'));
    }

    private function turnstileReason(Request $request): ?string
    {
        if (! static::turnstileEnabled()) {
            return null;
        }

        $token = (string) $request->input(self::TURNSTILE_FIELD);
        if ($token === '') {
            return 'missing turnstile token';
        }

        try {
            $passed = Http::asForm()->timeout(5)->post(self::TURNSTILE_VERIFY_URL, [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $token,
                'remoteip' => $request->ip(),
            ])->json('success') === true;
        } catch (\Throwable $e) {
            // Fail open if Cloudflare is unreachable; the honeypot, timing
            // check and rate limits still apply.
            Log::warning('Turnstile verification unavailable', ['error' => $e->getMessage()]);

            return null;
        }

        return $passed ? null : 'turnstile failed';
    }
}
