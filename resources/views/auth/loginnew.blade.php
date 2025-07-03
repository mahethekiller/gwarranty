<x-common-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">

    <div class="row align-items-center form-login-bg">
        <div class="col-md-12 col-lg-12">
            <form class="signin-left" id="login-form" action="{{ route('login') }}" method="POST">
                <h1 class="h3 mb-3">Sign In</h1>
                @csrf

              <div class="row">
               <div class="col-lg-6">
                    <div class="form-group mb-0">
                    <label for="email">Email*</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Enter Your Email*" required>
                    <span class="error" id="login-error-email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </span><br>
                </div>
                </div>

                <div class="col-lg-6">
                <div class="form-group mb-0">
                    <label for="password">Password*</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter Your Password*" required>
                    <span class="error" id="login-error-password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </span><br>
                </div>
                </div>
                </div>

                <div class="block mb-4 text-center">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <button type="submit" class="custom-btn4 display-flex" style="margin: 0px auto; display: flex;">Login</button>

                <div class="flex items-center justify-end mt-4 text-center">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    {{-- <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button> --}}
                </div>



                {{-- <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div> --}}

            </form>
        </div>



</x-common-layout>
