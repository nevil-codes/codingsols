{{-- Spam trap for public forms; checked by the BlockSpamBots middleware. --}}
<div aria-hidden="true" class="absolute -left-[10000px] h-px w-px overflow-hidden">
    <label for="{{ App\Http\Middleware\BlockSpamBots::HONEYPOT_FIELD }}">Leave this field empty</label>
    <input type="text" id="{{ App\Http\Middleware\BlockSpamBots::HONEYPOT_FIELD }}" name="{{ App\Http\Middleware\BlockSpamBots::HONEYPOT_FIELD }}" value="" tabindex="-1" autocomplete="off">
</div>
<input type="hidden" name="{{ App\Http\Middleware\BlockSpamBots::TIMESTAMP_FIELD }}" value="{{ App\Http\Middleware\BlockSpamBots::timestamp() }}">
@if (App\Http\Middleware\BlockSpamBots::turnstileEnabled())
    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="auto" data-size="flexible"></div>
    @once
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endonce
@endif
<x-input-error :messages="$errors->get('form')" />
