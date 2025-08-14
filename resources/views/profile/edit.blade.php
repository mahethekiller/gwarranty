<x-userdashboard-layout :pageTitle="$pageTitle" :pageDescription="$pageDescription" :pageScript="$pageScript">

   @if (Auth::user()->hasRole('user'))
        @include('profile.partials.user-profile')
    @else
        @include('profile.partials.admin-profile')
    @endif

</x-userdashboard-layout>
