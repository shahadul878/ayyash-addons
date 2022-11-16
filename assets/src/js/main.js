/* global themeoo_ajax, Plyr */


// noinspection JSUnusedGlobalSymbols
let Themeoo;

(function ($, window, document, themeoo_ajax) {

    let $themeoo_body, $back_to_top,
        $themeoo_masthead, $themeoo_main, $window,
        themeoo_is_device,
        themeoo_is_sticky,
        themeoo_has_admin_bar, themeoo_admin_bar_height,
        themeoo_header_height,
        $themeoo_admin_bar,
        $themeoo_hasBoxLayout,
        $themeoo_BoxWidth;

    Themeoo = {
        staticVariables: function () {
            $window = $(window);
            // $themeoo_document = $(document);
            $themeoo_body = $('body');
            $back_to_top = $('.cd-top');
            $themeoo_admin_bar = $('#wpadminbar');
            $themeoo_masthead = $('#masthead');
            $themeoo_main = $('#main');
            themeoo_is_device = !!(navigator.userAgent.toLowerCase().match(/(android|webos|blackberry|ipod|iphone|ipad|opera mini|iemobile|windows phone|windows mobile)/));
            themeoo_is_sticky = !!(parseInt(themeoo_ajax.sticky));
            themeoo_has_admin_bar = !!$themeoo_body.hasClass('admin-bar');
            $themeoo_hasBoxLayout = $themeoo_body.hasClass('boxed');
            $themeoo_BoxWidth = $('.boxed').outerWidth();
            //themeoo_sticky_height = ( parseInt(themeoo_ajax.header)) ? parseInt(themeoo_ajax.header) : 50;

            const self = this;
            self.getAdminBarHeight();
            self.getHeaderHeight();
            self.getHeaderTop();
        },
        getAdminBarHeight: function () {
            themeoo_admin_bar_height = (themeoo_has_admin_bar) ? $themeoo_admin_bar.height() : 0;
            return themeoo_admin_bar_height;
        },
        getHeaderHeight: function () {
            themeoo_header_height = ($themeoo_masthead) ? $themeoo_masthead.outerHeight() : 0;
            return themeoo_header_height;
        },
        getHeaderTop: function () {
            return ($themeoo_masthead && $themeoo_masthead.offset()) ? $themeoo_masthead.offset().top : 0;
        },
        initFormPlaceHolder: function () {
            const isOperaMini = window.operamini && Object.prototype.toString.call(window.operamini) === '[object OperaMini]',
                isInputSupported = 'placeholder' in document.createElement('input') && !isOperaMini,
                isTextareaSupported = 'placeholder' in document.createElement('textarea') && !isOperaMini;

            if (!isInputSupported || !isTextareaSupported) {
                const selector = [];
                if (!isInputSupported) {
                    selector.push('input[placeholder]');
                }
                if (!isTextareaSupported) {
                    selector.push('textarea[placeholder]');
                }
                $(selector.join(',')).each(function () {
                    const el = $(this),
                        placeholder = el.attr('placeholder');

                    if (el.val() === '') {
                        el.val(placeholder);
                    }

                    el.focus(function () {
                        if (this.value === placeholder) {
                            this.value = '';
                        }
                    }).blur(function () {
                        if ($.trim(this.value) === '') {
                            this.value = placeholder;
                        }
                    });
                });

                // Clear default placeholder values on form submit
                $('form').submit(function () {
                    $(this).find(selector).each(function () {
                        if (this.value === $(this).attr('placeholder')) {
                            this.value = '';
                        }
                    });
                });
            }
        },
        initTooltip: function () {
            $('[data-bs-toggle=tooltip]').tooltip();
            $('.toast').toast();
            $('[data-bs-toggle="popover"]').popover({container: 'body'});
        },
        showBackToTop: function () {
            const offset = 300;
            const offset_opacity = 1200; //browser window scroll (in pixels) after which the 'back to top' link opacity is reduced

            if ($window.scrollTop() > offset) {
                $back_to_top.addClass('cd-is-visible');
                $themeoo_body.addClass('scrolled');
            } else {
                $back_to_top.removeClass('cd-is-visible cd-fade-out');
            }

            if ($window.scrollTop() > offset_opacity) {
                $back_to_top.addClass('cd-fade-out');
            }
        },
        initBackToTop: function () {
            //smooth scroll to top
            $back_to_top.on('click', function (e) {
                e.preventDefault();
                $('body,html').animate({
                    scrollTop: 0,
                }, 700);
            });
        },
        initTransparentHeader: function () {
            if ($themeoo_body.hasClass('transparent-header')) {
                return;
            }

            $('.transparent-header .page-builder .themeoo-row:first-of-type .container:first-of-type, .transparent-header .page-builder .themeoo-row:first-of-type .container-fluid:first-of-type')
                .css('padding-top', $themeoo_masthead.height() + 20);
        },
        initMegaMenu: function () {
            // cached window width.
            let windowWidth = $(window).width();
            // reset cached window width on resize.
            $(window).resize(function () {
                windowWidth = $(window).width();
            });
            $('.main-navigation').superfish({
                delay: 200, // Default: 800
                /*animation: {
                    opacity: 'show', // Default: show
                },*/
                speed: 'fast', // Default: normal
                speedOut: 'fast', // Default: fast
                cssArrows: false, // Default: true
                onBeforeShow: function () {
                    // Change direction of submenu if it is out of the ui boundary.
                    // @TODO handle rtl.
                    const self = this;
                    // maybe we should use '.main-navigation>li:not(.themeoo-mega-menu) ul.submenu' to selected multilevel submenus.
                    if (!self.is('.main-navigation>li:not(.themeoo-mega-menu)>ul')) {
                        const parentLi = self.parent();
                        const parentWidth = parentLi.width();
                        const subMenuRight = parentLi.offset()?.left + parentWidth + self.width();
                        if (subMenuRight > windowWidth) {
                            self.css({
                                'left': 'auto',
                                'right': parentWidth + 'px'
                            });
                        } else {
                            self.css({
                                'left': '',
                                'right': ''
                            });
                        }
                    }
                },
            });
        },
        initMobileMenu: function () {

            $('#themeoo-mobile-toggle').on('click', function (e) {
                e.preventDefault();
                $(this).toggleClass('cs-collapse');
                $('#navigation-mobile').slideToggle(500, 'easeInOutExpo');

            });

            $('#navigation-mobile li:has(ul) > .themeoo-dropdown-plus').on('click', function (e) {
                e.preventDefault();
                $(this).toggleClass('cs-times');
                $(this).parent().find('> ul').slideToggle(500, 'easeInOutExpo');
            });

            $('#navigation-mobile li:has(ul) > a:not(.themeoo-dropdown-plus)').on('click', function (e) {
                if ($(this).attr('href') === '#') {
                    e.preventDefault();
                    const $parent = $(this).parent();
                    $parent.find('> .themeoo-dropdown-plus').toggleClass('cs-times');
                    // noinspection JSValidateTypes
                    $parent.find('> ul').slideToggle(500, 'easeInOutExpo');
                }
            });

        },
        themeoo_is_small: function () {
            return (window.innerWidth < parseInt(themeoo_ajax.viewport));
        },
        initStickyHeader: function () {
            if (themeoo_is_sticky && !themeoo_is_device) {
                let _header_top = this.getHeaderTop(), _header_height, _scroll_top;
                if (themeoo_has_admin_bar) {
                    _header_top = parseInt('' + (this.getHeaderTop() - this.getAdminBarHeight()));
                }
                $window.scroll(function () {
                    if (!Themeoo.themeoo_is_small()) {
                        _header_height = themeoo_header_height;
                        _scroll_top = $(this).scrollTop();
                        if (_scroll_top > _header_top) {
                            $themeoo_masthead.trigger('close-modals').addClass('is-sticky');
                            // match sticky menu width with box layout
                            if ($themeoo_hasBoxLayout) {
                                $themeoo_masthead.css('width', $themeoo_BoxWidth + 'px');
                            }
                            $themeoo_main.css('padding-top', _header_height);
                        } else {
                            $themeoo_masthead.removeClass('is-sticky');
                            $themeoo_main.removeAttr('style');
                        }
                        if (_scroll_top > (_header_height + _header_top)) {
                            $themeoo_masthead.addClass('is-compact');
                        } else {
                            $themeoo_masthead.removeClass('is-compact');
                        }
                    }
                });
            }
        },
        initFixSticky: function () {
            if (themeoo_is_sticky && Themeoo.themeoo_is_small()) {
                $themeoo_masthead.removeClass('is-sticky is-compact');
                $themeoo_main.removeAttr('style');
                // @TODO check with @Niamul vai for transparent header feature.
                // if (themeoo_is_transparent) {
                //     $themeoo_body.addClass('is-transparent cs-is-small');
                //     $window.scroll();
                // }
            } else {
                $themeoo_body.removeClass('cs-is-small');
            }
        },
        initContentProduct: function () {
            const productItems = $('.product-item');
            $(".largeGrid").click(function () {
                $(this).find('a').addClass('active');
                $('.smallGrid a').removeClass('active');
                productItems.addClass('large');
                setTimeout(function () {
                    $('.info-large').show();
                }, 200);
                setTimeout(function () {
                    $('.view_gallery').trigger("click");
                }, 400);

                return false;
            });

            $(".smallGrid").click(function () {
                $(this).find('a').addClass('active');
                $('.largeGrid a').removeClass('active');

                productItems.removeClass('large');
                $(".make3D").removeClass('animate');
                $('.info-large').fadeOut("fast");
                setTimeout(function () {
                    $('div.flip-back').trigger("click");
                }, 400);
                return false;
            });

            $('.colors-large a').click(function () {
                return false;
            });

            productItems.each(function (i, el) {
                // Flip card to the back side
                $(el).find('.view_gallery').click(function () {
                    $(el).find('div.carouselNext, div.carouselPrev').removeClass('visible');
                    const make3D = $(el).find('.make3D');
                    if (make3D.length) {
                        make3D.addClass('flip-10');
                        setTimeout(function () {
                            make3D.removeClass('flip-10').addClass('flip90').find('div.shadow').show().fadeTo(80, 1, function () {
                                $(el).find('.product-front, .product-front div.shadow').hide();
                            });
                        }, 50);
                        setTimeout(function () {
                            make3D.removeClass('flip90').addClass('flip190');
                            $(el).find('.product-back').show().find('div.shadow').show().fadeTo(90, 0);
                            setTimeout(function () {
                                make3D.removeClass('flip190').addClass('flip180').find('div.shadow').hide();
                                setTimeout(function () {
                                    make3D.css('transition', '100ms ease-out');
                                    $(el).find('.cx, .cy').addClass('s1');
                                    setTimeout(function () {
                                        $(el).find('.cx, .cy').addClass('s2');
                                    }, 100);
                                    setTimeout(function () {
                                        $(el).find('.cx, .cy').addClass('s3');
                                    }, 200);
                                    $(el).find('div.carouselNext, div.carouselPrev').addClass('visible');
                                }, 100);
                            }, 100);
                        }, 150);
                    }
                });
                // Flip card back to the front side
                $(el).find('.flip-back').click(function (e) {
                    e.preventDefault();
                    const make3D = $(el).find('.make3D');
                    if (make3D.length) {
                        make3D.removeClass('flip180').addClass('flip190');
                        setTimeout(function () {
                            make3D.removeClass('flip190').addClass('flip90');
                            $(el).find('.product-back div.shadow').css('opacity', 0).fadeTo(100, 1, function () {
                                $(el).find('.product-back, .product-back div.shadow').hide();
                                $(el).find('.product-front, .product-front div.shadow').show();
                            });
                        }, 50);

                        setTimeout(function () {
                            make3D.removeClass('flip90').addClass('flip-10');
                            $(el).find('.product-front div.shadow').show().fadeTo(100, 0);
                            setTimeout(function () {
                                $(el).find('.product-front div.shadow').hide();
                                make3D.removeClass('flip-10').css('transition', '100ms ease-out');
                                $(el).find('.cx, .cy').removeClass('s1 s2 s3');
                            }, 100);
                        }, 150);
                    }
                });
                makeCarousel(el);
            });

            /* ----  Image Gallery Carousel   ---- */
            function makeCarousel(el) {
                const carousel = $(el).find('.carousel ul');
                const carouselSlideWidth = productItems.outerWidth();
                let carouselWidth = 0;
                let isAnimating = false;
                let currSlide = 0;

                $(carousel).attr('rel', currSlide);

                // building the width of the carousel
                $(carousel).find('li').each(function () {
                    carouselWidth += carouselSlideWidth;
                });
                $(carousel).css('width', carouselWidth);

                $('.carousel li').css('width', carouselSlideWidth);
                $('.carousel').css('width', carouselSlideWidth);
                $('.arrows-perspective').css('width', carouselSlideWidth);

                // Load Next Image
                $(el).find('div.carouselNext').on('click', function () {
                    const currentLeft = Math.abs(parseInt($(carousel).css("left")));
                    const newLeft = currentLeft + carouselSlideWidth;
                    if (newLeft === carouselWidth || isAnimating === true) {
                        return;
                    }
                    $(carousel).css({
                        'left': "-" + newLeft + "px",
                        "transition": "300ms ease-out"
                    });
                    isAnimating = true;
                    currSlide++;
                    $(carousel).attr('rel', currSlide);
                    setTimeout(function () {
                        // maybe a rate limit for click event?
                        isAnimating = false;
                    }, 300);
                });

                // Load Previous Image
                $(el).find('div.carouselPrev').on('click', function () {
                    const currentLeft = Math.abs(parseInt($(carousel).css("left")));
                    const newLeft = currentLeft - carouselSlideWidth;
                    if (newLeft < 0 || isAnimating === true) {
                        return;
                    }
                    $(carousel).css({
                        'left': "-" + newLeft + "px",
                        "transition": "300ms ease-out"
                    });
                    isAnimating = true;
                    currSlide--;
                    $(carousel).attr('rel', currSlide);
                    setTimeout(function () {
                        isAnimating = false;
                    }, 300);
                });
            }

            $('.sizes a span, .categories a span').each(function (i, el) {
                $(el).append('<span class="x"></span><span class="y"></span>');

                $(el).parent().on('click', function () {
                    if ($(this).hasClass('checked')) {
                        $(el).find('.y').removeClass('animate');
                        setTimeout(function () {
                            $(el).find('.x').removeClass('animate');
                        }, 50);
                        $(this).removeClass('checked');
                        return false;
                    }

                    $(el).find('.x').addClass('animate');
                    setTimeout(function () {
                        $(el).find('.y').addClass('animate');
                    }, 100);
                    $(this).addClass('checked');
                    return false;
                });
            });
            //$themeoo_body.append('<div class="floating-cart"></div>');
            $('.add_to_cart').click(function () {
                const productCard = $(this).parent();
                const position = productCard.offset();
                // const productImage = $(productCard).find('img').get(0).src;
                // const productName = $(productCard).find('.product_name').get(0).innerHTML;

                $themeoo_body.append('<div class="floating-cart"></div>');
                const cart = $('div.floating-cart');
                productCard.clone().appendTo(cart);
                $(cart).css({
                    'top': position.top + 'px',
                    "left": position.left + 'px'
                }).fadeIn("slow").addClass('moveToCart');
                setTimeout(function () {
                    $themeoo_body.addClass("MakeFloatingCart");
                }, 800);
                // setTimeout(function(){
                //     $('div.floating-cart').remove();
                //     $themeoo_body.removeClass("MakeFloatingCart");
                //
                //
                //     var cartItem = "<div class='cart-item'><div class='img-wrap'><img src='"+productImage+"' alt='' /></div><span>"+productName+"</span><strong>$39</strong><div class='cart-item-border'></div><div class='delete-item'></div></div>";
                //
                //     $("#cart .empty").hide();
                //     $("#cart").append(cartItem);
                //     $("#checkout").fadeIn(500);
                //
                //     $("#cart .cart-item").last()
                //         .addClass("flash")
                //         .find(".delete-item").click(function(){
                //         $(this).parent().fadeOut(300, function(){
                //             $(this).remove();
                //             if($("#cart .cart-item").size() == 0){
                //                 $("#cart .empty").fadeIn(500);
                //                 $("#checkout").fadeOut(500);
                //             }
                //         })
                //     });
                //     setTimeout(function(){
                //         $("#cart .cart-item").last().removeClass("flash");
                //     }, 10 );
                //
                // }, 1000);
            });
        },
        responsiveEmbed: function () {
            $('iframe').each(function () {
                if (this.width && this.height) {
                    // Calculate the proportion/ratio based on the width & height.
                    const proportion = parseFloat(this.width) / parseFloat(this.height);
                    // Get the parent element's width.
                    const parentWidth = parseFloat(window.getComputedStyle(this.parentElement, null).width.replace('px', ''));
                    // Set the max-width & height.
                    this.style.maxWidth = '100%';
                    this.style.maxHeight = Math.round(parentWidth / proportion).toString() + 'px';
                }
            });
        },
        onResize: function () {
            this.initTransparentHeader();
            this.responsiveEmbed();
        },
        onScroll: function () {
            this.showBackToTop();
        },
        init: function () {

            const self = this;

            self.onResize = self.onResize.bind(self);
            self.onScroll = self.onScroll.bind(self);

            self.staticVariables();

            self.onResize();
            self.onScroll();

            self.initTooltip();
            self.initBackToTop();
            self.initFormPlaceHolder();
            self.initMegaMenu();
            self.initMobileMenu();
            self.initStickyHeader();
            self.initFixSticky();

            // self.initContentProduct();
        }
    };

    $(document).ready(function () {
        Themeoo.init();
        $window.resize(Themeoo.onResize).resize();
        $window.scroll(Themeoo.onScroll).scroll();

        new Plyr('.player');

        /*       const $container = $('.grid-container');
                function masonryInit() {
                    if ($container.length > 0) {
                        $container.imagesLoaded(() => {
                            // noinspection JSUnresolvedFunction
                            $container.masonry({
                                itemSelector: '.post-grid-wrap',
                                percentPosition: true,
                                fitWidth: true,
                            });
                        });
                    }
                }
                const $lazy = $('.lazy');
                if ( $lazy.length ) {
                    $lazy.lazy({
                        effect: 'fadeIn',
                        effectTime: 2000,
                        threshold: 0,
                        afterLoad: element => {
                            element.removeClass('lazy');
                            element.removeClass('loaded');
                            masonryInit();
                        },
                    });
                } else {
                    masonryInit();
                }*/

        /*let container = $('.post-grid');
        container.each(function () {
            let containerHeight = $(this).innerHeight();
            $(this).closest('.post-grid-wrap').css('height', containerHeight);
        })*/
    });

    /**
     * Transparent Mobile Header
     */

    $('#themeoo-mobile-toggle').on('click', function () {
        let menuHeight,
            mobileMenuIcon = $('#themeoo-mobile-toggle i'),
            mainTransHeader = $('.main-header.transparent-header '),
            secondaryHeader = $('.secondary-header'),
            hasAdminBar = $themeoo_body.hasClass('admin-bar'),
            backdropBG = $('.themeoo-menu-overlay');


        // Check user is logged in ( if has admin bar ) and activated secondary header to measure top position for transparent header
        if (hasAdminBar && secondaryHeader.length === 1) {
            menuHeight = mainTransHeader.outerHeight() + $('#wpadminbar').outerHeight() + secondaryHeader.outerHeight();
        } else if (hasAdminBar) {
            menuHeight = mainTransHeader.outerHeight() + $('#wpadminbar').outerHeight();
        } else if (secondaryHeader.length === 1) {
            menuHeight = mainTransHeader.outerHeight() + secondaryHeader.outerHeight();
        } else {
            menuHeight = mainTransHeader.outerHeight();
        }

        // Mobile menu backdrop background
        $(backdropBG).toggleClass('active');

        // Set transparent header top position
        $('#navigation-mobile').css({
            'top': menuHeight + 'px'
        });

        // Toggle menu icon and close icon for mobile menu
        if (mobileMenuIcon.hasClass('ti-menu')) {
            mobileMenuIcon.removeClass('ti-menu').addClass('ti-close');
        } else {
            mobileMenuIcon.removeClass('ti-close').addClass('ti-menu');
        }
    });


}(jQuery, window, document, themeoo_ajax));
