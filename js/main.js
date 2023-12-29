$j=jQuery.noConflict();
    $j(document).ready(function() {
        var stickyNavigation = $j('nav.navbar.navbar-dark');
        $j(window).scroll(function() {
            if( $j(this).scrollTop() > 200 ) {
                stickyNavigation.addClass('sticky');
            } else {
                stickyNavigation.removeClass('sticky');
            }
        });

        //Empty search string
        $j(".search-form button").on( "click", function(){
            var search = $j(this).parent().siblings("input");
            if( search.val() === "" ) {
                search.focus();
                return false;
            }
        } );

        //Back to top
        $j(window).scroll(function () {
            $j(this).scrollTop() > 400 ? $j("#back-top").fadeIn() : $j("#back-top").fadeOut()
        });
        $j("#back-top").click(function () {
            return $j("body,html").animate({scrollTop: 0}, 800), !1
        });

        $j(function() {
            $j("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
                event.preventDefault();
                event.stopPropagation();

                $j(this).siblings().toggleClass("show");


                if (!$j(this).next().hasClass('show')) {
                    $j(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                $j(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                    $j('.dropdown-submenu .show').removeClass("show");
                });

            });
        });

    });