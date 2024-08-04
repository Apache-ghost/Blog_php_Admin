/* ============================================================
 
 Template Name: Maro-News - News and Blog HTML Template.
 Author: Marwa El-Manawy -- https://elmanawy.info
 Description: Maro-News - News and Blog HTML Template.
 Version: 1.0
 
 ===============================================================
 */

jQuery(document).ready(function () {
    'use strict';

    //News Tracking
    $(".demo1").bootstrapNews({
        newsPerPage: 1,
        autoplay: true,
        pauseOnHover: true,
        direction: 'up',
        newsTickerInterval: 2500,
        onToDo: function () {
        }
    });
    
    //Responsive Header
    $('.responsive-menu li.menu-item-has-children > a').on('click', function () {
        var parent = $(this).parent();
        var parent_sibling = $(this).parent().siblings();
        parent_sibling.children('ul').slideUp();
        parent_sibling.removeClass('active');
        parent.children('ul').slideToggle();
        parent.toggleClass('active');
        return false;
    });

    $('#nav-icons-head').on('click', function () {
        $('.responsive-menu').toggleClass('slidein');
        return false;
    });

    // Seraching Responsive
    $('.res-search').on('click', function () {
        $('.search-insite').addClass('open');
        return false;
    });
    $('.search-insite > i').on('click', function () {
        $('.search-insite').removeClass('open');
        return false;
    });

    //for open and close button rotation
    $('#nav-icons-head').on('click', function () {
        $(this).toggleClass('open');
        return false;
    });


    //Header Search Desktop
    $('.header-search > a').on('click', function () {
        $('.search-here').addClass('active');
        return false;
    });
    $('.search-here > i').on('click', function () {
        $('.search-here').removeClass('active');
        return false;
    });

    //Login dropdown	
    $('.login-register a').on('click', function () {
        $('.login-wraper').addClass('active');
        return false;
    });

    $('.close').on('click', function () {
        $('.login-wraper').removeClass('active');
        return false;
    });
    $('.login-responsive a').on('click', function () {
        $('.login-wraper').addClass('active');
        return false;
    });

    //Dropdown
    var drop = $('nav > ul > li > ul > li')
    $('nav > ul > li').each(function () {
        var delay = 0;
        $(this).find(drop).each(function () {
            $(this).css({transitionDelay: delay + 'ms'});
            delay += 50;
        });
    });
    var drop2 = $('nav  > ul > li > ul > li >  ul > li')
    $('nav > ul > li > ul > li').each(function () {
        var delay2 = 0;
        $(this).find(drop2).each(function () {
            $(this).css({transitionDelay: delay2 + 'ms'});
            delay2 += 50;
        });
    });


    //footer carousel	
    $('.footer-popu-posts').owlCarousel({
        loop: true,
        margin: 0,
        smartSpeed: 1000,
        responsiveClass: true,
        nav: false,
        dots: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
                loop: false,
            }
        }
    });
    
    //progress Post Carousel	
    $('.progress-posts-slide').owlCarousel({
        loop: true,
        margin: 0,
        smartSpeed: 1000,
        responsiveClass: true,
        nav: false,
        dots: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
                nav: false,
                dots: false
            },
            600: {
                items: 1,
                nav: false
            },
            1000: {
                items: 1,
                nav: false,
                loop: false,
                dots: true
            }
        }
    });
    
    //Recent Post Carousel
    $('.category-recent-post').owlCarousel({
        loop: true,
        margin: 0,
        smartSpeed: 500,
        responsiveClass: true,
        nav: true,
        dots: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                dots: false
            },
            600: {
                items: 1,
                nav: true
            },
            1000: {
                items: 1,
                nav: true,
                loop: false,
                dots: false
            }
        }
    });

    //progress posts widget carousel
    $('.carousel-btn').owlCarousel({
        items: 3,
        loop: true,
        margin: 4,
        smartSpeed: 1000,
        responsiveClass: true,
        nav: false,
        dots: false,
        autoplay: true,
        URLhashListener: true,
        startPosition: 'URLHash',
        responsive: {
            0: {
                items: 3,
                nav: false,
                dots: false
            },
            600: {
                items: 5,
                nav: false
            },
            1000: {
                items: 3,
                nav: false,
                loop: false,
                dots: false
            }
        }
    });
    
    //Popular Videos Carousel
    $('.popular-video').owlCarousel({
        items: 1,
        loop: false,
        center: true,
        margin: 0,
        dots: false,
        URLhashListener: true,
        autoplayHoverPause: true,
        startPosition: 'URLHash'
    });

    //related posts carousel
    $('.related-post-caro').owlCarousel({
        loop: false,
        margin: 30,
        smartSpeed: 1000,
        responsiveClass: true,
        nav: false,
        dots: false,
        autoplay: false,
        responsive: {
            0: {
                items: 2,
            },
            600: {
                items: 4,
            },
            1000: {
                items: 6,
                loop: false,
            }
        }
    });
    
    // featured post carousel 
    $('.pp-featured-caro').owlCarousel({
        stagePadding: 250,
        loop: true,
        autoplay: true,
        autoplayTimeout: 2000,
        margin: 10,
        nav: false,
        dots: false,
        smartSpeed: 2000,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });

});
