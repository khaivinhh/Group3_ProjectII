var acc = document.getElementsByClassName("accordion");
var i;
for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight == 'max-content' || panel.style.maxHeight == '') {
            panel.style.maxHeight = 0;
        } else {
            panel.style.maxHeight = 'max-content';
        }
    });
}