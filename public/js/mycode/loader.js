function loader() {
    $(window).on('load', function() {
        // Animate loader off screen
        $(".preloader").delay(200).fadeOut();

        /*** AOS */
        AOS.init({
            once: true,
            offset: 100,
            duration: 900,
        });
    });
}
loader();