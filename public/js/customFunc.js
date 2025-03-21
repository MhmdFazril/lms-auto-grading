function upCase(element) {
    let start = element.selectionStart;
    let end = element.selectionEnd;

    $(element).val($(element).val().toUpperCase());

    element.setSelectionRange(start, end);
}

function onlyNumbers(element) {
    $(element).on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });
}

function onlyDecimal(element) {
    $(element).on("input", function () {
        this.value = this.value.replace(/[^0-9.]/g, "");
        this.value = this.value.replace(/(\..*)\./g, "$1");
    });
}

function validateEmail(element) {
    $(element).on("input", function () {
        let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(this.value)) {
            $(this).addClass("border-red-500");
        } else {
            $(this).removeClass("border-red-500");
        }
    });
}

function LettersAndNumbers(element) {
    $(element).on("input", function () {
        this.value = this.value.replace(/[^a-zA-Z0-9]/g, "");
    });
}

function sendAjax(route, formData) {
    return new Promise((resolve, reject) => {
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
        $.ajax({
            url: route,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                resolve(response); // Mengembalikan hasil sukses
            },
            error: function (xhr) {
                reject(xhr); // Mengembalikan hasil error
            },
        });
    });
}

function loading() {
    $.LoadingOverlay("show", {
        // image: "",
        // text: "Harap tunggu...",
        // fontawesome: "fa fa-cog fa-spin",
        textColor: "#fff",
        background: "rgba(0, 0, 0, 0.1)",
    });
}

function unloading() {
    $.LoadingOverlay("hide");
}
