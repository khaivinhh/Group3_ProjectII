function validate_fields(item) {
    if (item.checkValidity() == false) {
        $("." + item.id + "").css('display', 'contents')
        $("#" + item.id + "").css('border', '1px solid red')
        
    } else {
        $("." + item.id + "").css('display', 'none')
        $("#" + item.id + "").css('border', '1px solid rgb(205, 205, 205)')
    }
}

function validate_form(nameform) {
    var invalidInputs = $("#"+nameform+"")[0].querySelectorAll(':invalid');
    var missingFields = Array.from(invalidInputs).map(function(tag) {
        $("." + tag.id + "").css('display', 'contents')
        $("#" + tag.id + "").css('border', '1px solid red')
    });
}