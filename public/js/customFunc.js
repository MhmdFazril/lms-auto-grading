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
