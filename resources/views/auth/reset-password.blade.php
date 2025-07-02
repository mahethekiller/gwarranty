       <x-common-layout>
           <div class="row align-items-center form-login-bg">
               <div class="col-md-12 col-lg-12">
                   <form method="POST" class="signin-left" action="{{ route('password.store') }}">
                       @csrf

                       <!-- Password Reset Token -->
                       <input type="hidden" name="token" value="{{ $request->route('token') }}">

                       <!-- Email Address -->
                       <div class="form-group">
                           <x-input-label for="email" :value="__('Email')" />
                           <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                               :value="old('email', $request->email)" required autofocus autocomplete="username" />
                           <x-input-error :messages="$errors->get('email')" class="mt-2" />
                       </div>

                       <!-- Password -->
                       <div class="form-group">
                           <x-input-label for="password" :value="__('Password')" />
                           <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                               required autocomplete="new-password" />
                           <x-input-error :messages="$errors->get('password')" class="mt-2" />
                       </div>

                       <!-- Confirm Password -->
                       <div class="form-group">
                           <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                           <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                               name="password_confirmation" required autocomplete="new-password" />

                           <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                       </div>

                       <div class="flex items-center justify-end mt-4">
                           <x-primary-button class="custom-btn3">
                               {{ __('Reset Password') }}
                           </x-primary-button>
                       </div>
                   </form>
               </div>
           </div>
       </x-common-layout>
