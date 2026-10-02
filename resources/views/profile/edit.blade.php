<x-app-layout title="Profile">
    <x-slot name="header">
        <h1 class="text-2xl font-bold tracking-tight">Profile settings</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage your name, email and password.</p>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <x-card class="p-6 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </x-card>

        <x-card class="p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </x-card>

        <x-card class="p-6 sm:p-8 border-red-200 dark:border-red-900/50">
            @include('profile.partials.delete-user-form')
        </x-card>
    </div>
</x-app-layout>
