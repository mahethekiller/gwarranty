{{-- <x-guest-layout> --}}
<x-common-layout>
    <div class="row align-items-center form-login-bg">
        <div class="col-md-12 col-lg-12">
            <!-- Session Status -->


            <form method="POST" class="signin-left" action="{{ route('password.email') }}">
                <x-auth-session-status class="mb-4" :status="session('status')" />
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>


                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="custom-btn4">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-common-layout>
{{-- </x-guest-layout> --}}
