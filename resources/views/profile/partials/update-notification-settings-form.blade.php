<section id="notifications" class="scroll-mt-20">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Email notifications</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Replies always show under <a href="{{ route('notifications.index') }}" class="text-accent-600 hover:underline dark:text-accent-400">Notifications</a>. Choose whether you also get an email.
        </p>
    </header>

    <form method="post" action="{{ route('profile.notifications') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <label class="flex items-start gap-3">
            <input type="checkbox" name="notify_replies" value="1" @checked($user->notify_replies)
                class="mt-0.5 rounded border-gray-300 text-accent-600 focus:ring-accent-500 dark:border-gray-700 dark:bg-gray-900">
            <span>
                <span class="block text-sm font-medium">Email me when someone replies to my question</span>
                <span class="block text-sm text-gray-500 dark:text-gray-400">At most one email per question every {{ \App\Notifications\NewReply::EMAIL_COOLDOWN_MINUTES }} minutes.</span>
            </span>
        </label>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'notifications-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
