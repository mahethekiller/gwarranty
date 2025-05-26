function toggleDiv1(show) {
    document.getElementById("targetDiv2").style.display = "none";
    document.getElementById("targetDiv1").style.display = show
        ? "block"
        : "none";
}

function toggleDiv2(show) {
    document.getElementById("targetDiv1").style.display = "none";
    document.getElementById("targetDiv2").style.display = show
        ? "block"
        : "none";
}

function toggleDiv() {
    const select = document.getElementById("mySelect");
    const div = document.getElementById("myDivMikasaDoors");
    if (select.value === "Mikasa Doors") {
        div.style.display = "block";
    } else {
        div.style.display = "none";
    }
}

$("#warrantyForm").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr("action"),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#errorMessages").addClass("d-none").html("");
        },
        success: function (response) {
            alert("Warranty registered successfully");
            $("#warrantyForm")[0].reset();
        },
        error: function (xhr) {
            let errors = xhr.responseJSON.errors;
            for (let field in errors) {
                console.log(errors[field][0]);

                $(`#error-${field}`).text(errors[field][0]);
            }
        },
    });
});
