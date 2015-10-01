$(document).ready(function(){

    // hide #back-top first
    $(".toTop").hide();

    // fade in #back-top
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > $(document).height() - 700 ) {
                $('.toTop').fadeIn();
            } else {
                $('.toTop').fadeOut();
            }
        });
    });
});