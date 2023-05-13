$('.input_search_name').on('keyup', function() {
    if ($(this).val().length > 0) {
        $('.submit_search').removeAttr('disabled');
    } else {
        $('.submit_search').attr('disabled', 'disabled');
    }
});

var timer1, timer2;

function notification_complete() {
    clearTimeout(timer1);
    clearTimeout(timer2);
    $('.complete_progress').removeClass('active_notification');


    $('.complete_toast').addClass('active_notification');


    setTimeout(() => {
        $('.complete_progress').addClass('active_notification');
    }, 10);

    timer1 = setTimeout(() => {
        $('.complete_toast').removeClass('active_notification');
    }, 5000);

    timer2 = setTimeout(() => {
        $('.complete_progress').removeClass('active_notification');
    }, 5300);
}




function notification_error() {
    clearTimeout(timer1);
    clearTimeout(timer2);
    $('.error_progress').removeClass('active_notification');


    $('.error_toast').addClass('active_notification');

    setTimeout(() => {
        $('.error_progress').addClass('active_notification');
    }, 10);

    timer1 = setTimeout(() => {
        $('.error_toast').removeClass('active_notification');
    }, 5000);

    timer2 = setTimeout(() => {
        $('.error_progress').removeClass('active_notification');
    }, 5300);


}


$('.close').on('click', function() {
    $('.my_toast').removeClass('active_notification');
    setTimeout(() => {
        $('.progress').removeClass('active_notification');
    }, 300);
    clearTimeout(timer1);
    clearTimeout(timer2);
})
AOS.init();
