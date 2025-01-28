<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
            <div class="row">
                <div class="col-md-12">
                    <code>General Information</code>
                </div>
            <!-- Name -->
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>



            <!-- DOB -->
            <div class="col-md-6 mt-3">
                <div class="form-group">

                <x-input-label for="dob" :value="__('Date Of Birth')" />
                <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')" required autofocus autocomplete="dob" />
                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                </div>
            </div>

            <!-- Phone -->
            <div class="col-md-6 mt-3">
                <div class="form-group">

                <x-input-label for="phone" :value="__('Phone Number')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
            </div>
            <!-- Gender -->
            <div class="col-md-6 mt-3">
                <div class="form-group">

                <label for="gender" class="block font-medium text-sm text-gray-700">Gender</label>
                <div class="mt-1">
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="male" class="form-radio" {{ old('gender') == 'male' ? 'checked' : '' }}>
                        <span class="ml-2 p-2">Male</span>
                    </label>
                    <label class="inline-flex items-center ml-4">
                        <input type="radio" name="gender" value="female" class="form-radio" {{ old('gender') == 'female' ? 'checked' : '' }}>
                        <span class="ml-2 p-2">Female</span>
                    </label>
                    <label class="inline-flex items-center ml-4">
                        <input type="radio" name="gender" value="other" class="form-radio" {{ old('gender') == 'other' ? 'checked' : '' }}>
                        <span class="ml-2 p-2">Other</span>
                    </label>
                </div>
                @error('gender')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                </div>
            </div>
            <hr class="mt-2"/>
            <div class="col-md-12">
                <code>Contact Information</code>
            </div>

                <!-- Address -->
                <div class="col-md-6 mt-3">
                    <div class="form-group">

                        <x-input-label for="address" :value="__('Address')" />
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus autocomplete="address" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                </div>

            <!-- Email Address -->
            <div class="col-md-6 mt-3">
                <div class="form-group">

                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>

            <!-- Password -->
            <div class="col-md-6 mt-3">
                <div class="form-group">

                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="col-md-6 mt-3">
                <div class="form-group">

                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
