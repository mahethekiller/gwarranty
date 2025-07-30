$(document).on("click", '[data-bs-target="#userEditModal"]', function (e) {
    e.preventDefault();
    var userId = $(this).data("id"); // Retrieve ID from the clicked element's data-id attribute
    $("#userEditModal form").data("warranty-id", userId);

    // Fetch warranty data from server
    $.ajax({
        url: "/admin/user/" + userId + "/edit/",
        type: "GET",
        success: function (response) {
            // debugger

            if (response.message) {
                alert(response.message);
            } else {
                $("#userEditModalBody").html(response);
            }
        },
        error: function (xhr) {
            alert("Error fetching data");
            console.log(xhr.responseText);
        },
    });
});

function toggleProductType() {
    var selectedRole = $("#role option:selected").data("role-name");

    if (selectedRole === "country_admin") {
        $("#product-type-wrapper").show();
    } else {
        $("#product-type-wrapper").hide();
    }
}
function toggleBranchNameDiv() {
    var selectedRole = $("#role option:selected").data("role-name");

    if (selectedRole === "branch_admin") {
        $("#branch_name_div").show();
    } else {
        $("#email").prop("readonly", false).val("");
        $("#branch_name_div").hide();
    }
}

$(document).ready(function () {
    toggleProductType(); // on page load
    toggleBranchNameDiv();
    $("#role").on("change", function () {
        toggleProductType();
        toggleBranchNameDiv();
    });
});

$("#branch_name").on("change", function () {
    var branchName = $(this).val();

    if (branchName) {
        $.ajax({
            url: adminurl + "/get-branch-email",
            method: "GET",
            data: { branch_name: branchName },
            success: function (response) {
                $("#email").val(response.email || "");
                $("#email").prop("readonly", true);


                if (response.exists) {
                    $("#error-email").text("A user with this branch email already exists!");
                    $("#email").addClass("is-invalid");
                } else {
                    $("#email").removeClass("is-invalid");
                    $("#error-email").text("");
                }
            },
            error: function () {
                $("#email").val("");
                $("#email").removeClass("is-invalid");
            },
        });
    } else {
        $("#email").val("");
        $("#email").removeClass("is-invalid");
    }
});
