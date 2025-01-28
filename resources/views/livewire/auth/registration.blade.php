<div>
    <div class="card p-4 d-flex justify-items-center">
        <div class="row">
            @if(!$create)
            <div class="col-md-4">
                <h4 class="text-center text-uppercase heading mb-4"> Registration </h4>
                <img src="{{asset('/images/auth.svg')}}" alt="authentication" width="100%" height="auto">
            </div>
            @endif
            <div class="@if($create)col-md- 12 @else col-md-8 @endif">
                <form wire:submit="save">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="heading">General Information</p>
                        </div>
                        <!-- First Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" class="block mt-1 w-full" type="text" wire:model.live="form.first_name" :value="old('first_name')" autofocus autocomplete="first_name" />
                                <x-input-error :messages="$errors->get('form.first_name')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full" type="text" wire:model.live="form.last_name" :value="old('last_name')" autofocus autocomplete="last_name" />
                                <x-input-error :messages="$errors->get('form.last_name')" class="mt-2" />
                            </div>
                        </div>

                        <!-- DOB -->
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <x-input-label for="dob" :value="__('Date Of Birth')" />
                                <x-text-input id="dob" class="block mt-1 w-full" type="date" wire:model.live="form.dob" :value="old('dob')" autofocus autocomplete="dob" />
                                <x-input-error :messages="$errors->get('form.dob')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" wire:model.live="form.phone" :value="old('phone')" autofocus autocomplete="phone" />
                                <x-input-error :messages="$errors->get('form.phone')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <x-input-label for="gender" :value="__('Gender')" />
                                <x-select id="gender" class="block mt-1 w-full" wire:model.live="form.gender" :value="old('form.gender')" :secondary_model="$gender_types" autofocus autocomplete="gender" />
                                <x-input-error :messages="$errors->get('form.gender')" class="mt-2" />
                            </div>
                        </div>

                        @if($create)
                            <!-- Roles -->
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <x-input-label for="role_type" :value="__('Role')" />
                                    <x-select id="role_type" class="block mt-1 w-full" wire:model.live="form.role_type" :value="old('form.role_type')" :secondary_model="$role_types" autofocus autocomplete="role_type" />
                                    <x-input-error :messages="$errors->get('form.role_type')" class="mt-2" />
                                </div>
                            </div>
                        @endif

                        <div class="col-md-12 mt-3">
                            <p class="heading">Contact Information</p>
                        </div>

                        <!-- Address -->
                        <div class="col-md-6">
                            <div class="form-group">

                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" class="block mt-1 w-full" type="text" wire:model.live="form.address" :value="old('address')" autofocus autocomplete="address" />
                                <x-input-error :messages="$errors->get('form.address')" class="mt-2" />
                            </div>
                        </div>
                        <!-- Email Address -->
                        <div class="col-md-6">
                            <div class="form-group">

                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" wire:model.live="form.email" :value="old('email')" autocomplete="username" />
                                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mt-3">
                            <div class="form-group">

                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" class="block mt-1 w-full"
                                              type="password"
                                              wire:model.live="form.password"
                                              autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mt-3">
                            <div class="form-group">

                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                              type="password"
                                              wire:model.live="form.password_confirmation" autocomplete="new-password" />

                                <x-input-error :messages="$errors->get('form.password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if(!$create)
                            <a class="text-decoration-underline text-muted small rounded focus-outline-none focus-ring focus-ring-offset-2" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>
                        @endif

                        <x-primary-button class="ms-4">
                            {{ ($create) ? __('Submit')  : __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
