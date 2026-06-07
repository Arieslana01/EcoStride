<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Department -->
        <div class="mt-4">
            <x-input-label for="department" :value="__('Department')" />
            <select id="department" name="department" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="" disabled {{ old('department') ? '' : 'selected' }}>Select a Department</option>
                <option value="Customer Excellence" {{ old('department') == 'Customer Excellence' ? 'selected' : '' }}>Customer Excellence</option>
                <option value="Finance" {{ old('department') == 'Finance' ? 'selected' : '' }}>Finance</option>
                <option value="Information Technology (IT)" {{ old('department') == 'Information Technology (IT)' ? 'selected' : '' }}>Information Technology (IT)</option>
                <option value="Marketing" {{ old('department') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                <option value="Human Resources (HR)" {{ old('department') == 'Human Resources (HR)' ? 'selected' : '' }}>Human Resources (HR)</option>
                <option value="Supply Chain" {{ old('department') == 'Supply Chain' ? 'selected' : '' }}>Supply Chain</option>
                <option value="Quality Assurance" {{ old('department') == 'Quality Assurance' ? 'selected' : '' }}>Quality Assurance</option>
                <option value="Research & Development (R&D)" {{ old('department') == 'Research & Development (R&D)' ? 'selected' : '' }}>Research & Development (R&D)</option>
                <option value="Operations" {{ old('department') == 'Operations' ? 'selected' : '' }}>Operations</option>
                <option value="Procurement" {{ old('department') == 'Procurement' ? 'selected' : '' }}>Procurement</option>
            </select>
            <x-input-error :messages="$errors->get('department')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
