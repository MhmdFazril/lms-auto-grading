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
