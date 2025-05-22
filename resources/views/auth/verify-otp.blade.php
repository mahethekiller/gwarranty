@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if ($errors->any())
    <p style="color: red;">{{ $errors->first() }}</p>
@endif

<form method="POST" action="{{ route('verify-otp') }}">
    @csrf
    <input type="text" name="otp" placeholder="Enter OTP" required>
    <button type="submit">Verify OTP</button>
</form>

<!-- Resend OTP Button -->
<form method="POST" action="{{ route('resend-otp') }}" style="margin-top: 10px;">
    @csrf
    <button type="submit">Resend OTP</button>
</form>
