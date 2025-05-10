
$(function(){
    $("footer .footer-container .footer-data-container .footer-toggle").on('click', function(){
        const footer_navbar = $(this).parent().find('ul');
        if (footer_navbar.css('display') === "none") {
            footer_navbar.removeClass('d-responsive-none');
        }else{
            footer_navbar.addClass('d-responsive-none');
        }
    });
    $(".search-modal .close-btn").on('click', function(){
        $('.search-modal').addClass('d-none');
        $("body").css("overflow", "auto")
    });
    $(".search_icon").on('click', function(){
        $('.search-modal').removeClass('d-none');
        $("body").css("overflow", "hidden");
    })
});
$(document).ready(function () {
    $(".collapse").collapse("hide");

    $(".navbar-toggler").click(function () {
        $(".collapse").collapse("show");
    });
});