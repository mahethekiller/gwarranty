let timer;
let countdownTime = 100; // 5 minutes in seconds

function startCountdown() {
    timer = setInterval(function () {
        countdownTime--;

        let minutes = Math.floor(countdownTime / 60);
        let seconds = countdownTime % 60;

        if (seconds < 10) seconds = "0" + seconds;

        $("#countdown-timer").text(`OTP expires in ${minutes}:${seconds}`);

        if (countdownTime <= 0) {
            clearInterval(timer);
            $("#countdown-timer").text("OTP has expired. Please resend.");
            $("#resendOtp").prop("disabled", false); // Enable Resend OTP
            $("#verify-button").prop("disabled", true);
        }
    }, 1000);
}

// Register and send OTP
$("#registerForm").on("submit", function (e) {
    e.preventDefault();
    $(".error-text").text("");
    $("#success-message").text("");

    $.ajax({
        url: $(this).attr("action"),
        type: "POST",
        data: $(this).serialize(),
        success: function (response) {
            if (response.success) {
                $("#temp_otp").html("OTP: "+response.otp);
                $("#success-message").text(response.message);
                $("#registerForm").hide();
                debugger;
                $("#verifyOtpFormDiv").show();
                countdownTime = 100; // reset countdown time
                $("#verify-button").prop("disabled", false); // re-enable button
                startCountdown(); // start countdown timer
            }
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    $("#" + key + "-error").text(value[0]);
                });
            }
        },
    });
});

// Verify OTP
$("#verifyOtpForm").on("submit", function (e) {
    e.preventDefault();
    $("#otp-error").text("");

    $.ajax({
        url: "verify-otp",
        type: "POST",
        data: {
            phone_number: $("input[name='phone_number']").val(),
            otp: $("input[name='otp']").val(),
            name: $("input[name='name']").val(),
            email: $("input[name='email']").val(),
            address: $("input[name='address']").val(),
        },
        success: function (response) {
            if (response.success) {
                $("#success-message").text(response.message);
                setTimeout(function () {
                    window.location.href = response.redirect_url;
                }, 2000); // Redirect after 2 seconds
            } else {
                $("#otp-error").text(response.message);
            }
        },
    });
});

// Resend OTP
// Resend OTP
$("#resendOtp").on("click", function () {
    $.ajax({
        url: "{{ route('resend.otp') }}",
        type: "POST",
        data: {
            phone_number: $("input[name='phone_number']").val(),
        },
        success: function (response) {
            $("#success-message").text(response.message);

            // Reset countdown timer and buttons
            clearInterval(timer);
            countdownTime = 100;
            $("#resendOtp").prop("disabled", true); // Disable Resend OTP
            $("#verify-button").prop("disabled", false); // Enable verify button
            startCountdown(); // Restart countdown
        },
    });
});
