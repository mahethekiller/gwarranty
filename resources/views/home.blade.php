<x-common-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">
    <section class="home py-5">
        <div class="row">
            <div class="col-md-6 col-lg-6 mb-3">
                <h1>Sign in to your account and get access to these services:</h1>
                <ul class="custom-list">
                    <li>Submit warranty claims for your Greenlam industries products</li>
                    <li>View your warranty claims and get updates on your returns</li>
                    <li>Manage your account profile and settings</li>
                </ul>
                <a href="{{ route('loginotp') }}" class="custom-nav-btn">Sign In</a>
            </div>
            <div class="col-md-6 col-lg-6">
                <h1>Create an Account:</h1>
                <p>It is free to sign up for an Greenlam Industries account and registration is quick and simple.</p>
                <ul class="custom-list">
                    <li>Business users, please provide your company e-mail address for full access to licensing,
                        support, and services.</li>
                    <li>All other users, please use your personal e-mail address.</li>
                </ul>
                <p class="mt-1 mb-5">Click on <a href="#">Create an Account</a> to begin.</p>
                <a href="{{ route('registerotp') }}" class="custom-nav-btn">Create An Account</a>

            </div>
        </div>
    </section>
</x-common-layout>
