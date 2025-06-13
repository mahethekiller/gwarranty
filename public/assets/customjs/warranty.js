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

// function toggleDiv() {
//     const select = document.getElementById("mySelect");
//     const div = document.getElementById("myDivMikasaDoors");
//     if (select.value === "Mikasa Doors") {
//         div.style.display = "block";
//     } else {
//         div.style.display = "none";
//     }
// }

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



$("#qty_purchased").on("input", function (e) {
    this.value = this.value.replace(/[^0-9]/g, "");
});

$("#place_of_purchase").on("input", function (e) {
    this.value = this.value.replace(/[^a-zA-Z]/g, "");
});


$("#handover_certificate").on("change", function () {
    const file = this.files[0];
    const fileURL = URL.createObjectURL(file);
    const previewLink = document.createElement("a");
    previewLink.href = fileURL;
    previewLink.download = file.name;
    previewLink.innerHTML = "Preview";
    previewLink.classList.add("btn", "btn-primary", "mt-2", "btn-sm");
    const previewContainer = document.getElementById("handover_certificate_preview");
    previewContainer.innerHTML = "";
    previewContainer.appendChild(previewLink);
});
$("#upload_invoice").on("change", function () {
    const file = this.files[0];
    const fileURL = URL.createObjectURL(file);
    const previewLink = document.createElement("a");
    previewLink.href = fileURL;
    previewLink.download = file.name;
    previewLink.innerHTML = "Preview";
    previewLink.classList.add("btn", "btn-primary", "mt-2", "btn-sm");
    const previewContainer = document.getElementById("upload_invoice_preview");
    previewContainer.innerHTML = "";
    previewContainer.appendChild(previewLink);
});



$("#product_type").on("change", function () {
    const value = $(this).val();
    const div = document.getElementById("myDivMikasaDoors");
    if (value === "Greenlam Clads" || value === "Greenlam Sturdo") {
        $("#application").prop("disabled", true).closest(".form-group").hide();
    } else {
        $("#application").prop("disabled", false).closest(".form-group").show();
    }


    if (value === "Mikasa Doors") {
        div.style.display = "block";
    } else {
        div.style.display = "none";
    }
});
