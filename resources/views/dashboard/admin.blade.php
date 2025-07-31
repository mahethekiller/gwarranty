<x-userdashboard-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}





        <h2>Welcome {{ auth()->user()->roles->first()->display_name }}</h2>
</x-userdashboard-layout>
