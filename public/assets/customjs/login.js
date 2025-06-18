let loginTimer;
let loginTimerDuration = 60;

function startLoginOtpTimer() {
    $("#login-resend-btn").prop("disabled", true);
    loginTimerDuration = 60;
    loginTimer = setInterval(() => {
        loginTimerDuration--;
        $("#login-timer").text(`Resend in ${loginTimerDuration}s`);
        if (loginTimerDuration <= 0) {
            clearInterval(loginTimer);
            $("#login-resend-btn").prop("disabled", false);
            $("#login-timer").text("");
        }
    }, 1000);
}

$("#login-form").on("submit", function (e) {
    e.preventDefault();
    $(".error").text("");
    $.ajax({
        url: $(this).attr("action"),
        method: "POST",
        data: $(this).serialize(),
        success: function (res) {
            // response = JSON.parse(res);
            $("#temp_otp").html("OTP: "+res.otp);
            $("#login-form").hide();
            $("#login-otp-section").show();
            startLoginOtpTimer();
        },
        error: function (xhr) {
            let errors = xhr.responseJSON.errors;
            for (let field in errors) {
                $(`#login-error-${field}`).text(errors[field][0]);
            }
        },
    });
});

$("#login-verify-form").on("submit", function (e) {
    e.preventDefault();
    $(".error").text("");
    $.ajax({
        url: $(this).attr("action"),
        method: "POST",
        data: $(this).serialize(),
        success: function (res) {
            window.location.href = res.redirect;
        },
        error: function (xhr) {
            $("#login-error-otp").text(
                xhr.responseJSON.message || "Invalid OTP"
            );
        },
    });
});

$("#login-resend-btn").on("click", function () {
    $.post(
        "resend-otp",
        {
            phone_number: $("#login-phone").val(),
        },
        function (res) {
            if (res.success) startLoginOtpTimer();
        }
    );
});
