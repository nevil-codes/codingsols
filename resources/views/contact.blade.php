<x-app-layout title="Contact">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h1 class="text-3xl font-bold tracking-tight">Contact us</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Feedback, a bug report or a category you'd like to see? Send us a message.</p>

        <form method="POST" action="{{ route('contact.store') }}" class="relative mt-8 space-y-5">
            @csrf
            <x-honeypot />
            <div>
                <x-input-label for="name" value="Name" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', auth()->user()?->name)" required maxlength="255" autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', auth()->user()?->email)" required maxlength="255" autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="message" value="Message" />
                <x-textarea id="message" name="message" rows="6" class="mt-1 font-sans" required>{{ old('message') }}</x-textarea>
                <x-input-error :messages="$errors->get('message')" class="mt-2" />
            </div>
            <x-button class="w-full sm:w-auto">Send message</x-button>
        </form>
    </div>
</x-app-layout>
