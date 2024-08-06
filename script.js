jQuery(document).ready(function() {

    $('#top-sale .owl-carousel').owlCarousel({
        loop: false,
        margin: 30,
        nav: true,
        dots: false,
        navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        responsive : {
            0: {
                items: 1
            },

            360: {
                items: 1
            },

            599 : {
                items: 2
            },

            600 : {
                items: 3
            },

            1000: {
                items: 5
            },

            1300 : {
                items: 6
            }
        },
        //autoWidth: true

        
    });
    

        $('#new .owl-carousel').owlCarousel({
            loop: false,
            margin: 30,
            nav: true,
            dots: false,
            navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            responsive : {
                0: {
                    items: 1
                },
    
                599 : {
                    items: 2
                },
    
                600 : {
                    items: 3
                },
    
                1000: {
                    items: 5
                },
    
                1300 : {
                    items: 6
                }
            },
            //autoWidth: true
    
            
        });


        $('#best-fantasy .owl-carousel').owlCarousel({
            loop: false,
            margin: 30,
            nav: true,
            dots: false,
            navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            responsive : {
                0: {
                    items: 1
                },

                360: {
                    items: 1
                },
    
                599 : {
                    items: 2
                },
    
                600 : {
                    items: 3
                },
    
                1000: {
                    items: 5
                },
    
                1300 : {
                    items: 6
                }
            },
            //autoWidth: true
    
            
        });

        $('#product-best-fantasy .owl-carousel').owlCarousel({
            loop: false,
            margin: 30,
            nav: true,
            dots: false,
            navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            responsive : {
                0: {
                    items: 1
                },

                360: {
                    items: 1
                },
    
                599 : {
                    items: 2
                },
    
                600 : {
                    items: 3
                },
    
                1000: {
                    items: 5
                },
    
                1300 : {
                    items: 6
                }
            },
            //autoWidth: true
    
            
        });


window.onscroll = function(){
    if(window.scrollY > 80){
        document.querySelector('.header .header-2').classList.add('active');
    }
    else {
        document.querySelector('.header .header-2').classList.remove('active');
    }

}

//=======================SUBNAV-MENUS SCRIPTS=======================

var subnav = document.getElementsByClassName('drop-down categories'), //collection of submenus, currently has 1 item
    nav3 = document.getElementById('nav_categories'); //the corresponding navbar item 

    nav3.addEventListener('mouseenter', function(){
        subnav[0].classList.add('active');

    });

    var notActive = function() {
        subnav[0].classList.remove('active');
    }


    var navbarItem = document.getElementsByClassName('navbar-item');
    navbarItem[1].addEventListener('mouseleave', notActive);
});