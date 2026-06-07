<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="department" :value="__('Department')" />
            <select id="department" name="department" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="" disabled {{ old('department', $user->department) ? '' : 'selected' }}>Select a Department</option>
                <option value="Customer Excellence" {{ old('department', $user->department) == 'Customer Excellence' ? 'selected' : '' }}>Customer Excellence</option>
                <option value="Finance" {{ old('department', $user->department) == 'Finance' ? 'selected' : '' }}>Finance</option>
                <option value="Information Technology (IT)" {{ old('department', $user->department) == 'Information Technology (IT)' ? 'selected' : '' }}>Information Technology (IT)</option>
                <option value="Marketing" {{ old('department', $user->department) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                <option value="Human Resources (HR)" {{ old('department', $user->department) == 'Human Resources (HR)' ? 'selected' : '' }}>Human Resources (HR)</option>
                <option value="Supply Chain" {{ old('department', $user->department) == 'Supply Chain' ? 'selected' : '' }}>Supply Chain</option>
                <option value="Quality Assurance" {{ old('department', $user->department) == 'Quality Assurance' ? 'selected' : '' }}>Quality Assurance</option>
                <option value="Research & Development (R&D)" {{ old('department', $user->department) == 'Research & Development (R&D)' ? 'selected' : '' }}>Research & Development (R&D)</option>
                <option value="Operations" {{ old('department', $user->department) == 'Operations' ? 'selected' : '' }}>Operations</option>
                <option value="Procurement" {{ old('department', $user->department) == 'Procurement' ? 'selected' : '' }}>Procurement</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('department')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
