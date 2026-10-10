<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rejects form submissions that look automated: the hidden honeypot field
 * was filled in, the signed start time is missing or tampered with, or the
 * form was submitted faster than a person could fill it in.
 *
 * Pair with the <x-honeypot /> component inside the form.
 */
class BlockSpamBots
{
    public const HONEYPOT_FIELD = 'website';

    public const TIMESTAMP_FIELD = 'form_started_at';

    public const MIN_SECONDS = 2;

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

        return null;
    }
}
