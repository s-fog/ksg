class Header {
    constructor(root) {
        this.root = root;

        this.timeOut = '';
        this.minicartInterval = '';
        this.animate = false;
        this.animate2 = false;

        this._cacheNodes();
        this._bindEvents();
        this._ready();
    }

    _cacheNodes() {
        this.nodes = {
            mainHeader: $('.mainHeader'),
            filterTrigger: $('.filterTrigger'),
            container: $('.mainHeader .container'),
            mainHeader__menuLink: $('.mainHeader__menuLink'),
            js_hovered: $('.js-hovered'),
            mainHeader__hovered: $('.mainHeader__hovered'),
            mainHeader__contactsItem: $('.mainHeader__contactsItem'),
            mainHeader__cart: $('.mainHeader__cart'),
            mainHeader__popup: $('.mainHeader__popup'),
            mainHeader__contactsItem_address: $('.mainHeader__contactsItem_address'),
            mainHeader__popupTriangle: $('.mainHeader__popupTriangle'),
            mainHeader__search: $('.mainHeader__search'),
            mainHeader__searchTrigger: $('.mainHeader__searchTrigger'),
            mainHeader__right: $('.mainHeader__right'),
            mainHeader__searchInput: $('.mainHeader__searchInput'),
            mainHeader__searchSubmit: $('.mainHeader__searchSubmit'),
            mainHeader__searchClose: $('.mainHeader__searchClose'),
            mainHeader__menu: $('.mainHeader__menu'),
            mainHeader__contacts: $('.mainHeader__contacts'),
            js_popup: $('.js-popup'),
            mainHeader__popupMenuPicked: $('.mainHeader__popupMenuPicked'),
            mainHeader__popupMenuTab: $('.mainHeader__popupMenuTab'),
            mainHeader__popupMenuItems: $('.mainHeader__popupMenuItems'),
            mainHeader__popupSearchItem: $('.mainHeader__popupSearchItem'),
            mainHeader__popupLink: $('.js-main-header-popup-link'),
            mainHeader__popupLinkContent: $('.js-main-header-popup-content'),
        }
    }

    _bindEvents() {
        $(window).scroll(() => {
            let scrollTop = $(window).scrollTop();
            let body = $('body');
            let prevScroll = body.data('scroll');
            let mainHeaderHeight = this.nodes.mainHeader.height();

            if (/*!this.animate*/true) {
                if (scrollTop < prevScroll || (scrollTop >= 0 && scrollTop <= 100)) {
                    this.mainHeaderShow();
                } else {
                    this.animate = true;
                    this.nodes.mainHeader.addClass('hide');
                    this.nodes.filterTrigger.css({
                        'top': '0'
                    });

                    setTimeout(() => {
                        this.animate = false;
                    }, 500);
                }

                body.data('scroll', scrollTop);
            } else {
                if (scrollTop >= 0 && scrollTop <= 100) {
                    this.mainHeaderShow();
                }
            }

            if (scrollTop >= mainHeaderHeight-5) {
                this.nodes.filterTrigger.addClass('fixed');
            } else {
                this.nodes.filterTrigger.removeClass('fixed');
                this.nodes.filterTrigger.css({
                    'top': 'auto'
                });
            }
        });

        $('html').click((event) => {
            if (this.nodes.mainHeader__popup.hasClass('active')) {
                if (
                    !$(event.target).parents('.mainHeader__popup').get(0)
                    &&
                    !$(event.target).parents('.js-popup').data('popup')
                    &&
                    !$(event.target).parents('.mainHeader__cart').data('popup')
                    &&
                    !$(event.target).parents('.mainHeader__search').get(0)
                    &&
                    !$(event.target).parents('.filter').get(0)
                    &&
                    !$(event.target).data('popup')
                ) {
                    this.nodes.mainHeader__popup.removeClass('active');
                    setTimeout(() => {
                        this.nodes.mainHeader__popup.removeClass('unhidden');
                    }, 500);
                    this.nodes.js_popup.removeClass('active');
                    this.nodes.mainHeader__popupTriangle.removeClass('active');

                    if (this.nodes.mainHeader__right.hasClass('active')) {
                        this.searchClose();
                    }

                    return false;
                }
            }

            /*if ($('.filter').get(0)) {
                if ($('.filter').css('display') != 'none') {
                    if (!$(event.target).parents('.filter').get(0)) {
                        $('.filter').slideUp(500);
                        $('html').removeClass('html-hidden');

                        return false;
                    }
                }
            }*/
        });

        var ua = navigator.userAgent.toLowerCase();
        var isSafari = false;
        try {
            isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);
        }
        catch(err) {}
        isSafari = (isSafari || ((ua.indexOf('safari') != -1)&& (!(ua.indexOf('chrome')!= -1) && (ua.indexOf('version/')!= -1))));

        if (isSafari) {
            $('body').addClass('this_is_safari');
        } else {
            $('body').addClass('this_is_not_safari');
        }

        if ($(window).width() < 980) {
            if (!isSafari) {
                this.nodes.js_hovered.hover(
                    (event) => {
                        this.onHover($(event.currentTarget));
                    },
                    (event) => {
                        this.onUnHover($(event.currentTarget));
                    }
                );
            }
        } else {
            this.nodes.js_hovered.hover(
                (event) => {
                    this.onHover($(event.currentTarget));
                },
                (event) => {
                    this.onUnHover($(event.currentTarget));
                }
            );
        }

        this.nodes.js_popup.click((event) => {
            let active = $('.js-popup.active');
            let popup = $('.mainHeader__popup.active');

            if (popup.get(0)) {
                this.close();
            } else {
                this.popupHeader($(event.currentTarget));
            }

            if (active.get(0)) {
                if (active.get(0) != $(event.currentTarget).get(0)) {
                    setTimeout(() => {
                        this.popupHeader($(event.currentTarget));
                    }, 200);
                }
            }

            return false;
        });

        $(window).resize(() => {
            if ($('.js-hovered.hovered').get(0)) {
                this.onHover($('.js-hovered.hovered'));
            }
            //////////////////////////////////////////////////////////////////
            if ($('.js-triangle.active').get(0)) {
                this.triangleLeft($('.js-triangle.active'));
            }
        });

        this.nodes.mainHeader__searchTrigger.click(() => {
            if (this.nodes.mainHeader__right.hasClass('active')) {
                this.searchClose();
            } else {
                this.nodes.mainHeader__right.css({
                    'flex-grow': 1
                }).addClass('active');
                this.nodes.mainHeader__search.addClass('grow');
                this.nodes.mainHeader__searchInput.addClass('active grow');
                this.nodes.mainHeader__searchSubmit.addClass('active');
                this.nodes.mainHeader__searchClose.addClass('active');
                this.nodes.mainHeader__menu.addClass('hide');
                this.nodes.mainHeader__contacts.addClass('hide');
                this.nodes.mainHeader__cart.addClass('hide');
                $('.mainHeader__rightOnMobile').addClass('hide');
            }
        });

        this.nodes.mainHeader__searchClose.click(() => {
            this.nodes.mainHeader__searchTrigger.click();
        });

        this.nodes.mainHeader__popupSearchItem.click((event) => {
            this.nodes.mainHeader__searchInput.val($(event.currentTarget).text());
        });

        this.nodes.mainHeader__popupMenuTab.click((event) => {
            let thisElement = $(event.currentTarget);
            let index = thisElement.index();

            this.nodes.mainHeader__popupMenuTab.removeClass('active');
            thisElement.addClass('active');

            this.nodes.mainHeader__popupMenuItems.removeClass('active');
            this.nodes.mainHeader__popupMenuItems.eq(index).addClass('active');

            this.picked(thisElement);
        });

        $('.js-footer__bottomLink').on('click', () => {
            var body = $("html, body");
            body.stop().animate({scrollTop:0}, 500, 'swing');

            setTimeout(() => {
                this.nodes.mainHeader__searchTrigger.click();
            }, 500);
        });

        let timeout;
        this.nodes.mainHeader__popupLink.on({
            mouseenter:  (event) => {
                timeout = setTimeout(() => {
                    const thisElement = $(event.currentTarget),
                        container = thisElement.parent(),
                        elements = container.children();

                    let someSiblingsIsActive = false;

                    elements.each((i, e) => {
                        if ($(e).hasClass('active')) {
                            someSiblingsIsActive = true;
                        }
                    })

                    if (someSiblingsIsActive === true) {
                        elements.removeClass('active');
                        thisElement.addClass('active');
                    } else {
                        thisElement.addClass('active');
                    }

                    elements.each((i, e) => {
                        $('>.js-main-header-popup-content', $(e)).removeClass('active')
                    })
                    $('>.js-main-header-popup-content', thisElement).addClass('active')
                }, 150);
            },
            mouseleave: (event) => {
                clearTimeout(timeout)
            }
        })


        /*this.nodes.mainHeader__popupLink.on('click', (event) => {
            event.preventDefault();
            const thisElement = $(event.currentTarget);

            this.nodes.mainHeader__popupLink.removeClass('active');
            thisElement.addClass('active');

            this.nodes.mainHeader__popupLinkContent.removeClass('active');
            $(thisElement).siblings(this.nodes.mainHeader__popupLinkContent).addClass('active');
        })*/

        $('.js-mobile-header-link[data-ankor]').on('click', (event) => {
            if (this.animate2 === false) {
                this.animate2 = true;

                const thisElement = $(event.currentTarget),
                    ankor = thisElement.data('ankor'),
                    foundItem = $(`.js-mobile-header-item[data-ankor="${ankor}"]`);

                $('.js-mobile-header-item.active').removeClass('active');
                foundItem.addClass('found-next');

                setTimeout(() => {
                    foundItem.addClass('go-left')
                }, 10)
                setTimeout(() => {
                    foundItem.addClass('remove-transition').removeClass('found-next').removeClass('go-left').addClass('active');
                    setTimeout(() => {
                        foundItem.removeClass('remove-transition');
                        this.animate2 = false;
                    }, 100)
                }, 410)
            }
        })

        $('.js-mobile-header-prev').on('click', (event) => {
            if (this.animate2 === false) {
                this.animate2 = true;

                const thisElement = $(event.currentTarget),
                    ankor = thisElement.data('ankor'),
                    foundItem = $(`.js-mobile-header-item[data-ankor="${ankor}"]`),
                    activeItem = $('.js-mobile-header-item.active');

                activeItem.addClass('move-active-right').addClass('remove-transition');
                setTimeout(() => {
                    activeItem.addClass('remove-transition')
                        .removeClass('active')
                        .removeClass('move-active-right');
                    setTimeout(() => {
                        activeItem.removeClass('remove-transition');
                        this.animate2 = false;
                    }, 100)
                }, 400)

                foundItem.addClass('active');
            }
        })

        $('.js-mobile-header-close').on('click', (event) => {
            this.close();
            $('.js-mobile-header-prev[data-ankor="main"]').get(0).click();
        })
    }

    picked(element) {
        let w1 = (($('.mainHeader__popupOuter').width() - $('.mainHeader__popupMenuInner').width()) / 2);
        let left = element.offset().left + ((element.outerWidth() / 2) - (this.nodes.mainHeader__popupMenuPicked.width() / 2)) - w1;
        let top = element.position().top + 30;

        this.nodes.mainHeader__popupMenuPicked.css({
            'left': `${left}px`,
            'top': `${top}px`
        });
    }

    _ready() {
        this.minicartAnimation();
    }

    mainHeaderShow() {
        this.animate = true;
        this.nodes.mainHeader.removeClass('hide');
        this.nodes.filterTrigger.css({
            'top': '50px'
        });

        setTimeout(() => {
            this.animate = false;
        }, 500);
    }

    close() {
        let popup = $('.mainHeader__popup.active');

        popup.removeClass('active');
        setTimeout(() => {
            popup.removeClass('unhidden');
        }, 500);
        this.nodes.mainHeader__popupTriangle.removeClass('active');
        $('.js-popup.active').removeClass('active');
        bodyScrollLock.clearAllBodyScrollLocks();
    }

    onHover(thisElement) {
        clearTimeout(this.timeOut);

        let left = thisElement.offset().left - (($(window).width() - this.nodes.container.width()) / 2);
        let mainHeader__hoveredWidth = this.nodes.mainHeader__hovered.width();
        let currentElementWidth = thisElement.outerWidth();

        if (currentElementWidth >= mainHeader__hoveredWidth) {
            left = left + ((currentElementWidth - mainHeader__hoveredWidth) / 2);
        } else {
            left = left - ((mainHeader__hoveredWidth - currentElementWidth) / 2);
        }

        thisElement.addClass('hovered');

        this.nodes.mainHeader__hovered.css({
            'transform': `translate(${left}px, 0)`
        });

        if (!this.nodes.mainHeader__hovered.hasClass('active')) {
            setTimeout(() => {
                this.nodes.mainHeader__hovered.addClass('active');
            }, 10);
        }
    }

    onUnHover(element) {
        this.timeOut = setTimeout(() => {
            this.nodes.mainHeader__hovered.removeClass('active');
        }, 2000);
        element.removeClass('hovered');
    }

    minicartAnimation() {
        if (this.nodes.mainHeader__cart.hasClass('not_empty') && this.nodes.mainHeader__cart.hasClass('favourite')) {
            this.minicartInterval = setInterval(() => {
                let gNotEmpty = this.nodes.mainHeader__cart.find('g.not_empty');
                let gFavourite = this.nodes.mainHeader__cart.find('g.favourite');

                if (gNotEmpty.css('display') != 'none') {
                    gNotEmpty.hide();
                    gFavourite.show();
                } else {
                    gNotEmpty.show();
                    gFavourite.hide();
                }
            }, 2000);
        }
    }

    popupHeader(element) {
        let dataPopup = element.data('popup');
        let popup = $('.mainHeader__popup[data-popup="'+dataPopup+'"]');
        this.nodes.mainHeader__hovered.removeClass('active');

        if (!element.hasClass('active')) {
            this.triangleLeft(element);

            popup.addClass('active unhidden');
            element.addClass('active');

            if (dataPopup == 'cart') {
                let left = element.offset().left - ((popup.outerWidth() / 2) - (element.outerWidth() / 2));

                popup.css({
                    'left': `${left}px`
                });
            } else if (dataPopup == 'search') {
                this.nodes.mainHeader__popupTriangle.css({
                    'left': `0`,
                    'right': `0`,
                });
                this.nodes.mainHeader__searchInput.focus();
            } else if (dataPopup == 'menu') {
                setTimeout(() => {
                    //this.picked($('.mainHeader__popupMenuTab.active'));
                }, 500);
            }
            //////////////////////////////////////////////////////
            let windowHeight = window.innerHeight;
            let mainHeaderHeight = this.nodes.mainHeader.height();
            let height = windowHeight - mainHeaderHeight;

            popup.css('max-height', `${height}px`);
        } else {
            popup.removeClass('active');

            setTimeout(() => {
                popup.removeClass('unhidden');
            }, 500);

            this.nodes.mainHeader__popupTriangle.removeClass('active');
            element.removeClass('active');
        }

        if (dataPopup === 'menu') {
            if (popup.hasClass('mobile')) {
                $('.mobileHeaderPopup__item').each((i, e) => {
                    bodyScrollLock.disableBodyScroll(e);
                });
            } else {
                bodyScrollLock.disableBodyScroll(popup.get(0));
            }

        } else {
            bodyScrollLock.clearAllBodyScrollLocks();
        }
    }

    triangleLeft(element) {
        let left = element.offset().left + (element.outerWidth() / 2) - 11;

        this.nodes.mainHeader__popupTriangle.addClass('active');
        this.nodes.mainHeader__popupTriangle.css({
            'left': `${left}px`,
            'right': `auto`,
        });
    }

    searchClose() {
        this.nodes.mainHeader__right.css({
            'flex-grow': 0
        }).removeClass('active');
        setTimeout(() => {
            this.nodes.mainHeader__search.removeClass('grow');
            this.nodes.mainHeader__searchInput.removeClass('grow');
            this.nodes.mainHeader__menu.removeClass('hide');
            this.nodes.mainHeader__contacts.removeClass('hide');
            this.nodes.mainHeader__cart.removeClass('hide');
        }, 500);
        setTimeout(() => {
            $('.mainHeader__rightOnMobile').removeClass('hide');
        }, 100);
        this.nodes.mainHeader__searchSubmit.removeClass('active');
        this.nodes.mainHeader__searchSubmit.removeClass('active');
        this.nodes.mainHeader__searchInput.removeClass('active');
    }
}

class MainSlider {
    constructor(root) {
        this.root = root;

        this._cacheNodes();
        this._bindEvents();
        this._ready();
    }

    _cacheNodes() {
        this.nodes = {
            mainSlider: $('.mainSlider'),
        }
    }

    _bindEvents() {

    }

    _ready() {
        this.nodes.mainSlider.owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            checkVisible: false,
            smartSpeed: 1000
        });
    }
}

class Compare {
    constructor(root) {
        this.root = root;

        this.itemsCount = 0;
        this.itemWidth = 0;
        this.itemsInCont = 0;
        this.animate = false;

        this._cacheNodes();
        this._fillOptions();
        this._bindEvents();
        this._ready();
    }

    _cacheNodes() {
        this.nodes = {
            cont: $('.compare__products .compare__container'),
            jsCompareContainer: $('.js-compare-container'),
            compare__productsItem: $('.compare__productsItem'),
            compare__tab: $('.compare__tab'),
            compare__prev: $('.compare__prev'),
            compare__next: $('.compare__next'),
            compare__products: $('.compare__products'),
            compare: $('.compare'),
        };
    }

    _fillOptions() {
        this.itemsCount = this.nodes.compare__productsItem.length;
        this.itemWidth = this.nodes.compare__productsItem.eq(0).width();
        this.itemsInCont = this.nodes.cont.width() / this.itemWidth;
        this.nodes.compare__products.data('top', this.nodes.compare__products.offset().top);
    }
    _bindEvents() {
        this.nodes.compare__tab.unbind('click');

        this.nodes.compare__tab.click((event) => {
            let thisElement = $(event.currentTarget);

            if (thisElement.hasClass('active')) {
                thisElement.removeClass('active');
                thisElement.parents('.compare__item').next('.compare__tabContent').slideUp();
            } else {
                thisElement.addClass('active');
                thisElement.parents('.compare__item').next('.compare__tabContent').slideDown();
            }
        });

        $(window).resize(() => {
            this._fillOptions();
            this.resize();
            this.showHideButtons();
        });

        $(window).scroll((event) => {
            let scrollTop = $(window).scrollTop();
            let productTop = this.nodes.compare__products.data('top');
            let heightCC = this.nodes.compare__products.height();

            if (scrollTop > productTop) {
                this.nodes.compare.css({
                    'padding-top': `${heightCC}px`
                });
                this.nodes.compare__products.addClass('fixed');
            } else {
                this.nodes.compare.css({
                    'padding-top': `20px`
                });
                this.nodes.compare__products.removeClass('fixed');
            }
        });

        this.nodes.compare__next.click((event) => {
            if (!this.animate) {
                this.animate = true;
                let offsetLeft = Math.abs(parseInt(this.nodes.jsCompareContainer.data('left'))) || 0;
                let index = offsetLeft / this.itemWidth;
                let newOffsetLeft = 0;

                if ((index + this.itemsInCont) != this.itemsCount) {
                    newOffsetLeft = (index + 1) * this.itemWidth;
                } else {
                    newOffsetLeft = offsetLeft;
                }

                if (((index + 1 + this.itemsInCont) == this.itemsCount) || ((index + this.itemsInCont) == this.itemsCount)) {
                    this.nodes.compare__next.addClass('disabled');
                } else {
                    this.nodes.compare__next.removeClass('disabled');
                }

                this.nodes.compare__prev.removeClass('disabled');

                this.nodes.jsCompareContainer.css({
                    'transform': `translate(-${newOffsetLeft}px, 0)`
                }).data('left', newOffsetLeft);

                setTimeout(() => {this.animate = false}, 800);
            }
        });

        this.nodes.compare__prev.click((event) => {
            if (!this.animate) {
                this.animate = true;
                let offsetLeft = Math.abs(parseInt(this.nodes.jsCompareContainer.data('left'))) || 0;
                let index = offsetLeft / this.itemWidth;
                let newOffsetLeft = 0;

                if (index > 0) {
                    newOffsetLeft = (index - 1) * this.itemWidth;
                } else {
                    newOffsetLeft = offsetLeft;
                }

                if ((index == 0) || ((index - 1) == 0)) {
                    this.nodes.compare__prev.addClass('disabled');
                } else {
                    this.nodes.compare__prev.removeClass('disabled');
                }

                this.nodes.compare__next.removeClass('disabled');

                this.nodes.jsCompareContainer.css({
                    'transform': `translate(-${newOffsetLeft}px, 0)`
                }).data('left', newOffsetLeft);

                setTimeout(() => {this.animate = false}, 800);
            }
        });
    }

    _ready() {
        this.resize();
        this.showHideButtons();
        this.nodes.compare__prev.addClass('disabled');
    }

    resize() {
        let width = this.itemsCount * this.itemWidth;

        this.nodes.jsCompareContainer.width(width);
    }

    showHideButtons() {
        if (this.itemsInCont >= this.itemsCount) {
            this.nodes.compare__prev.hide();
            this.nodes.compare__next.hide();
        } else {
            this.nodes.compare__prev.show();
            this.nodes.compare__next.show();
        }
    }
}

class ProductTabs {
    constructor(root) {
        this.root = root;

        this._cacheNodes();
        this._bindEvents();
        this._ready();
    }

    _cacheNodes() {
        this.nodes = {
            properties__tabUnderline: $('.properties__tabUnderline'),
            properties__tab: $('.properties__tab'),
            properties__content: $('.properties__content'),
            properties__feature: $('.properties__feature'),
            properties__featureList: $('.properties__featureList'),
        }
    }

    _bindEvents() {
        this.nodes.properties__tab.click((event) => {
            let thisElement = $(event.currentTarget);
            let index = thisElement.index();

            this.nodes.properties__tab.removeClass('active');
            this.nodes.properties__content.removeClass('active');

            thisElement.addClass('active');
            this.nodes.properties__content.eq(index).addClass('active');

            this.doIt();
            flexGridAddElements('newsBlock__inner', 'newsBlock__item', 'newsBlock__item_hide');
        });

        this.nodes.properties__feature.click((event) => {
            let thisElement = $(event.currentTarget);
            let index = thisElement.index();

            if (!thisElement.hasClass('active')) {
                this.nodes.properties__feature.removeClass('active');
                this.nodes.properties__featureList.slideUp(500);

                thisElement.addClass('active');
                thisElement.find('.properties__featureList').slideDown(500);
            }
        });

        $(window).resize(() => {
            this.doIt();
        });
    }

    _ready() {
        this.doIt();
    }

    doIt() {
        if (this.nodes.properties__tabUnderline.get(0)) {
            setTimeout(() => {
                let activeTab = $('.properties__tab.active');
                let activeTabLeft = activeTab.offset().left;
                let activeTabWidth = activeTab.outerWidth();
                let properties__tabUnderlineWidth = 106;
                let left = activeTabLeft + ((activeTabWidth - properties__tabUnderlineWidth) / 2);

                this.nodes.properties__tabUnderline.css({
                    'left': `${left}px`
                });
            }, 10);
        }
    }
}

class ProductSliders {
    constructor(root) {
        this.root = root;
        this.needToChange = true;

        this._cacheNodes();
        this._init();
    }

    _cacheNodes() {
        this.nodes = {
            slider: null,
            sliderThumbs: null
        }
    }

    _init() {
        this.nodes.slider = $('.product__slider').owlCarousel({
            items: 1,
            dots: false,
            nav: true,
            navText: [
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.49 24.9"><g><path class="sliderButton__outer" d="M7.25,24.9h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.26,7.26,0,0,0,32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4Z"></path><path class="sliderButton__inner" d="M25.65,18.3V6.7a.82.82,0,0,0-1.1-.7l-13.9,5.8a.8.8,0,0,0,0,1.5l13.9,5.8A.89.89,0,0,0,25.65,18.3Z"></path></g></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.51 24.9"><g><path class="sliderButton__outer" d="M32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.24,7.24,0,0,0,32.25,0Z"></path><path class="sliderButton__inner" d="M13.85,6.6V18.2a.78.78,0,0,0,1.1.7l13.9-5.8a.8.8,0,0,0,0-1.5L15,5.8A.83.83,0,0,0,13.85,6.6Z"></path></g></svg>'
            ],
            navClass: [
                'owl-prev sliderButton',
                'owl-next sliderButton'
            ],
            loop: true
        });
        this.nodes.sliderThumbs = $('.product__sliderThumbs').owlCarousel({
            items: 3,
            dots: false,
            nav: false,
            center: true,
            loop: true,
            touchDrag: false,
            pullDrag: false,
        });

        this.nodes.sliderThumbs.on('click', '.product__sliderThumbsItem', (event) => {
            const thisElement = $(event.currentTarget),
                index = thisElement.data('index');

            this.needToChange = false;

            this.nodes.slider.trigger('to.owl.carousel', index, [150]);
            this.nodes.sliderThumbs.trigger('to.owl.carousel', index, [150]);

            setTimeout(() => {
                this.needToChange = true;
            }, 15)
        })

        this.nodes.slider.on('changed.owl.carousel', (event) => {
            if (this.needToChange === true) {
                setTimeout(() => {
                    const index = this.nodes.slider.find('.owl-item.active .product__sliderItem').data('index')
                    this.nodes.sliderThumbs.trigger('to.owl.carousel', index, [150]);
                }, 10);
            }
        })
    }

    _ready() {

    }
}

class Cart {
    constructor(root) {
        this.root = root;

        this._cacheNodes();
        this._bindEvents();
        this._ready();
    }

    _cacheNodes() {
        this.nodes = {
            cart: $('.cart'),
            cart__countMinus: $('.cart__countMinus'),
            cart__countInput: $('.cart__countInput'),
            cart__countPlus: $('.cart__countPlus'),
            address: $('.cartForm__itemAddress input'),
            addressMap__inner: $('#addressMap__inner'),
            cartForm__addressTrigger: $('#cartForm__addressTrigger'),
            addressMap__centerAddress: $('.addressMap__centerAddress'),
            addressMap__centerPick: $('.addressMap__centerPick'),
            myMap: new Object(),
            mainHeader: $('.mainHeader'),
            mainHeader__cart: $('.mainHeader__cart'),
            mainHeader__popupSuccess: $('.mainHeader__popupSuccess'),
            mainHeader__popupSuccess_cart: $('.mainHeader__popupSuccess_cart'),
            mainHeader__popupSuccess_compare: $('.mainHeader__popupSuccess_compare'),
            mainHeader__popupSuccess_favourite: $('.mainHeader__popupSuccess_favourite'),
            mainHeader__popupSuccessTriangle: $('.mainHeader__popupSuccessTriangle'),
            catalog__itemCart: $('.js-add-to-cart'),
            catalog__itemCompare: $('.js-add-to-compare'),
            catalog__itemFavourite: $('.js-add-to-favourite'),
            js_delete_from_favourite: $('.js-delete-from-favourite'),
            js_delete_from_compare: $('.js-delete-from-compare'),
            addToCart__tocart: $('.addToCart__tocart'),
            js_service_change: $('.js-service-change'),
        }
    }

    _bindEvents() {
        $('.select-jquery-ui').selectmenu();

        $('.sort-select').selectmenu({
            open: function() {
                $('div.ui-selectmenu-menu').addClass('selectmenu-sort');
            }
        });

        $('.product__seeAllImage, .product__allPhoto').click(function() {
            $('.product__mainImage').click();
        });

        $('[data-fancybox="oneClick"]').fancybox({
            animationEffect: "zoom-in-out",
            btnTpl: {
                smallBtn: '<button data-fancybox-close class="fancybox-close-small" title="{{CLOSE}}"><img src="/img/clouse2.svg"></button>',
            },
            touch: false,
            baseTpl:
                '<div class="fancybox-container productImage__wrapper" role="dialog" tabindex="-1">' +
                '<div class="fancybox-bg"></div>' +
                '<div class="fancybox-inner">' +
                '<div class="fancybox-stage"></div>' +
                '<div class="fancybox-caption"></div>' +
                "</div>" +
                "</div>",
            beforeLoad: (instance, slide) => {
                let thisElement = $(slide.opts.$orig);
                let name;
                let image;
                let product_id;
                let paramsV;
                let pp1 = thisElement.parents('.catalog__item');
                let pp2 = thisElement.parents('.product');
                let oneCLick = $('#oneClick');


                if (!paramsV) {
                    paramsV = '';
                }

                if (pp1.get(0)) {
                    name = pp1.find('.catalog__itemName span').text();
                    image = pp1.find('.catalog__itemImage img').prop('src');
                    product_id = pp1.data('id');
                    paramsV = pp1.find('.catalog__itemToCart').data('paramsv');
                } else {
                    name = pp2.find('h1').text();
                    product_id = pp2.data('id');
                    paramsV = this.getParamsv();
                    //image = pp2.find('.product__sliderImage[data-paramsv="'+paramsV+'"]').prop('src');
                    image = $('[data-currentVariant="1"]').prop('src');
                    console.log(image);
                }

                oneCLick.find('.addToCart__header').text(name);
                oneCLick.find('.addToCart__image div').css('background-image', 'url("' + image + '")');
                $('[name="OneClickForm[paramsV]"]').val(paramsV);
                $('[name="OneClickForm[product_id]"]').val(product_id);
            }
        });

        $.widget('custom.customselectmenu', $.ui.selectmenu, {
            _renderButtonItem: function( item ) {
                var buttonItem = $( "<span>", {
                    "class": "ui-selectmenu-text"
                });

                this._setText( buttonItem, item.label );
                buttonItem.prepend('<span class="ui-selectmenu-text-colorDot" style="background-color: '+$(item.element).data('color')+';">');

                return buttonItem;
            }
        });

        $('.js-product-jquery-ui-select').customselectmenu({
            change: (event, ui) => {
                const isMainParam = $(event.target).hasClass('js-product-main-param');
                const selects = $(event.target).parents('.js-product-jquery-ui-selects'),
                    mainParamSelect = $('.js-product-main-param'),
                    data = {
                        getProduct: true,
                        fancyboxOpened: $('.fancybox-container').get(0) !== undefined,
                        mainParam: mainParamSelect.val()
                    }

                    if (!isMainParam) {
                        data.additionalParam = $(event.target).val()
                    }

                $.post(location.pathname, data, (response) => {
                    location = response;
                })
            }
        });

        this.nodes.cart.on('change', '.'+this.nodes.js_service_change.attr('class'), (event) => {
            this.cartReload();
        });

        this.nodes.cart.on('change', '.'+this.nodes.cart__countInput.attr('class'), (event) => {
            this.cartReload();
        });

        $('body').on('click', '.'+this.nodes.cart__countPlus.attr('class'), (event) => {
            let input = $(event.currentTarget).siblings('input');
            let val = parseInt(input.val());
            input.val(val + 1);
            input.change();
        });

        $('body').on('click', '.'+this.nodes.cart__countMinus.attr('class'),(event) => {
            let input = $(event.currentTarget).siblings('input');
            let val = parseInt(input.val());

            if (input.hasClass('js-cant-zero')) {
                if (val > 1) {
                    input.val(val - 1);
                }
            } else {
                if (val > 0) {
                    input.val(val - 1);
                }
            }

            input.change();
        });

        this.nodes.addressMap__centerPick.click(() => {
            this.nodes.address.val($('.addressMap__centerAddress').text());
            $.fancybox.close();
        });

        $(window).resize(() => {
            this.popupLeft();
        });

        this.nodes.catalog__itemCart.click((event) => {
            let thisElement = $(event.currentTarget);
            let id = thisElement.data('id');
            let paramsV = thisElement.data('paramsv');
            let quantity = thisElement.data('quantity');

            this.addToCart(id, paramsV, quantity);

            return false;
        });

        this.nodes.addToCart__tocart.click((event) => {
            let thisElement = $(event.currentTarget);
            let wrapper = $(thisElement).parents('.addToCart__wrapper');
            let id = wrapper.data('id');
            let paramsV = this.getParamsv(true, wrapper);
            let quantity = wrapper.find('.cart__countInput').val();
            let delivery_date = wrapper.data('delivery_date');
            let present_artikul = wrapper.data('present_artikul');

            this.addToCart(id, paramsV, quantity, wrapper, present_artikul, delivery_date);

            return false;
        });

        this.nodes.catalog__itemCompare.click((event) => {
            let thisElement = $(event.currentTarget);
            let id = thisElement.data('id');
            let data = `id=${id}`;

            if (!thisElement.hasClass('added')) {
                $.post('/compare/add', data, (response) => {
                    if (response === 'success') {
                        thisElement.find('svg').addClass('active');
                        thisElement.attr('title', 'Перейти к сравнению');
                        $('span', thisElement).text('Перейти к сравнению');
                        thisElement.attr('href', thisElement.data('url'));
                        thisElement.addClass('added');
                        this.nodes.mainHeader__popupSuccess_compare.addClass('unhidden');
                        this.nodes.mainHeader__popupSuccess_compare.addClass('active');
                        this.nodes.mainHeader__popupSuccessTriangle.addClass('active');
                        this.nodes.mainHeader.removeClass('hide');

                        setTimeout(() => {
                            this.nodes.mainHeader__popupSuccess_compare.removeClass('active');
                            this.nodes.mainHeader__popupSuccessTriangle.removeClass('active');

                            setTimeout(() => {
                                this.nodes.mainHeader__popupSuccess_compare.removeClass('unhidden');
                            }, 500)
                        }, 2000);

                        this.minicartReload();
                    } else if (response == 'already') {
                        /*let already = $('.mainHeader__popupSuccess_compareAlready');
                        already.addClass('unhidden');
                        already.addClass('active');
                        this.nodes.mainHeader__popupSuccessTriangle.addClass('active');
                        this.nodes.mainHeader.removeClass('hide');

                        setTimeout(() => {
                            already.removeClass('active');
                            this.nodes.mainHeader__popupSuccessTriangle.removeClass('active');

                            setTimeout(() => {
                                already.removeClass('unhidden');
                            }, 500)
                        }, 2000);*/
                    } else {

                    }
                });

                return false;
            }
        });

        this.nodes.catalog__itemFavourite.click((event) => {
            let thisElement = $(event.currentTarget);
            let id = thisElement.data('id');
            let data = `id=${id}`;

            $.post('/favourite/add', data, (response) => {
                if (response == 'success') {
                    thisElement.find('svg').addClass('active');
                    thisElement.attr('title', 'Товар в избранном');
                    this.nodes.mainHeader__popupSuccess_favourite.addClass('unhidden');
                    this.nodes.mainHeader__popupSuccess_favourite.addClass('active');
                    this.nodes.mainHeader__popupSuccessTriangle.addClass('active');
                    this.nodes.mainHeader.removeClass('hide');

                    setTimeout(() => {
                        this.nodes.mainHeader__popupSuccess_favourite.removeClass('active');
                        this.nodes.mainHeader__popupSuccessTriangle.removeClass('active');

                        setTimeout(() => {
                            this.nodes.mainHeader__popupSuccess_favourite.removeClass('unhidden');
                        }, 500)
                    }, 2000);

                    this.minicartReload();
                } else if (response == 'already') {
                    let already = $('.mainHeader__popupSuccess_favouriteAlready');
                    already.addClass('unhidden');
                    already.addClass('active');
                    this.nodes.mainHeader__popupSuccessTriangle.addClass('active');
                    this.nodes.mainHeader.removeClass('hide');

                    setTimeout(() => {
                        already.removeClass('active');
                        this.nodes.mainHeader__popupSuccessTriangle.removeClass('active');

                        setTimeout(() => {
                            already.removeClass('unhidden');
                        }, 500)
                    }, 2000);
                } else {

                }
            });

            return false;
        });

        this.nodes.js_delete_from_favourite.click((event) => {
            let thisElement = $(event.currentTarget);
            let id = thisElement.data('id');
            let data = `id=${id}`;

            $.post('/favourite/delete', data, (response) => {
                location.reload();
            });

            return false;
        });

        this.nodes.js_delete_from_compare.click((event) => {
            let thisElement = $(event.currentTarget);
            let id = thisElement.data('id');
            let data = `id=${id}`;

            $.post('/compare/delete', data, (response) => {
                location.reload();
            });

            return false;
        });

        $('[data-fancybox="productImages"]').fancybox({
            'loop': true,
            buttons: [
                "close"
            ],
            touch: false,
            animationEffect: "zoom-in-out",
            btnTpl: {
                close: '<button data-fancybox-close class="fancybox-button fancybox-button--close" title="{{CLOSE}}"><img src="/img/close.svg"></button>',
                arrowLeft: '<button data-fancybox-prev class="sliderButton fancybox-button fancybox-button--arrow_left" title="{{PREV}}" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.49 24.9"><g><path class="sliderButton__outer" d="M7.25,24.9h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.26,7.26,0,0,0,32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4Z"></path><path class="sliderButton__inner" d="M25.65,18.3V6.7a.82.82,0,0,0-1.1-.7l-13.9,5.8a.8.8,0,0,0,0,1.5l13.9,5.8A.89.89,0,0,0,25.65,18.3Z"></path></g></svg></button>',
                arrowRight: '<button data-fancybox-next class="sliderButton fancybox-button fancybox-button--arrow_right" title="{{NEXT}}" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.51 24.9"><g><path class="sliderButton__outer" d="M32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.24,7.24,0,0,0,32.25,0Z"></path><path class="sliderButton__inner" d="M13.85,6.6V18.2a.78.78,0,0,0,1.1.7l13.9-5.8a.8.8,0,0,0,0-1.5L15,5.8A.83.83,0,0,0,13.85,6.6Z"></path></g></svg></button>',
                smallBtn: '<button data-fancybox-close class="fancybox-close-small" title="{{CLOSE}}"><img src="/img/close.svg"></button>',
            },
            baseTpl:
                '<div class="fancybox-container productImage__wrapper" role="dialog" tabindex="-1">' +
                '<div class="fancybox-bg"></div>' +
                '<div class="fancybox-inner">' +
                '<div class="fancybox-infobar">' +
                "<span data-fancybox-index></span>&nbsp;/&nbsp;<span data-fancybox-count></span>" +
                "</div>" +
                '<div class="fancybox-toolbar" style="display: none;">{{buttons}}</div>' +
                '<div class="fancybox-navigation" style="display: none;">{{arrows}}</div>' +
                '<div class="fancybox-stage"></div>' +
                '<div class="fancybox-caption"></div>' +
                "</div>" +
                "</div>",
            beforeLoad: (instance, slide) => {
                let thisElement = $(slide.opts.$orig);
                let header = thisElement.data('header');
                let text = thisElement.data('text');
                let image = thisElement.data('image');

                if (header.length == 0) {
                    $('.productImages__info').addClass('empty');
                    $('.productImages__header').text('');
                    $('.productImages__text').text('');
                } else {
                    $('.productImages__info').removeClass('empty');
                    $('.productImages__header').text(header);
                    $('.productImages__text').text(text);
                }

                $('.productImages__image img').prop('src', image);
            },
        });

        $('.js-product-in-js').fancybox({
            beforeLoad: (instance, slide) => {
                let thisElement = $(slide.opts.$orig);
                let productArtikul = $('[name="present_artikul"]:checked').val();
                let deliveryDate = $('[name="delivery_date"] option:selected').val();
                let addToCart = $('#addToCart');

                addToCart.attr('data-present_artikul', productArtikul);
                addToCart.attr('data-delivery_date', deliveryDate);
            }
        })
    }

    _ready() {
        this.popupLeft();
        this.address();
        this.addressMap();
        //this.initProductSlider();

        $('.productImages__arrowLeft').click(() => {
            $('.fancybox-button--arrow_left').click();
        });
        $('.productImages__arrowRight').click(() => {
            $('.fancybox-button--arrow_right').click();
        });

        $('.productImages__arrowLeft, .productImages__arrowRight').attr('unselectable', 'on')
            .css('user-select', 'none')
            .on('selectstart', false);
    }

    initProductSlider() {
        /*$('.product__slider').owlCarousel({
            items: 1,
            dots: false,
            nav: true,
            navText: [
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.49 24.9"><g><path class="sliderButton__outer" d="M7.25,24.9h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.26,7.26,0,0,0,32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4Z"></path><path class="sliderButton__inner" d="M25.65,18.3V6.7a.82.82,0,0,0-1.1-.7l-13.9,5.8a.8.8,0,0,0,0,1.5l13.9,5.8A.89.89,0,0,0,25.65,18.3Z"></path></g></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.51 24.9"><g><path class="sliderButton__outer" d="M32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.24,7.24,0,0,0,32.25,0Z"></path><path class="sliderButton__inner" d="M13.85,6.6V18.2a.78.78,0,0,0,1.1.7l13.9-5.8a.8.8,0,0,0,0-1.5L15,5.8A.83.83,0,0,0,13.85,6.6Z"></path></g></svg>'
            ],
            navClass: [
                'owl-prev sliderButton',
                'owl-next sliderButton'
            ],
            loop: false,
        });*/
    }

    cartReload() {
        $.post('/cart/reload-cart', $('.cart').serialize(), (response) => {
            if (response == 'empty') {
                location.reload();
            } else {
                let result = JSON.parse(response);

                $('.cart__table').replaceWith(result[0]);
                $('.cart__services').html(result[1]);
                $('.cartForm__total').html(result[2]);
            }
        });
    }

    getParamsv(popup = false, wrapper = false) {
        let array = new Array();
        let params = '';
        let selects = $('.select-product-jquery-ui');

        if (popup) {
            selects = wrapper.find('.select-jquery-ui-popup');
        }

        selects.each((index, element) => {
            let value = $(element).val();
            let name = $(element).siblings('.product__selectName').html();

            name = name.substring(0, name.length - 1);
            array[index] = `${name} -> ${value}`;
        });

        for(let i = 0; i < array.length; i++) {
            params += array[i]+'|';
        }

        params = params.substring(0, params.length - 1);

        return params;
    }

    addToCart(id, paramsV, quantity, fromPopupWrapper = false, presentArtikul = false, deliveryDate = false) {
        let data = `id=${id}&quantity=${quantity}`;

        if (paramsV) {
            data += `&paramsV=${paramsV}`;
        } else {
            data += `&paramsV=`;
        }

        if (presentArtikul) {
            data += `&presentArtikul=${presentArtikul}`;
        }

        if (deliveryDate) {
            data += `&deliveryDate=${deliveryDate}`;
        }

        $.post('/cart/add', data, (response) => {
            if (response == 'success') {
                if (fromPopupWrapper) {
                    fromPopupWrapper.find('.addToCart__bottomTop').addClass('hide');
                    fromPopupWrapper.find('.addToCart__bottomBottom').addClass('active');
                } else {
                    $.fancybox.open($('#addToCartNoParams'));

                    setTimeout(() => {
                        $.fancybox.close();
                    }, 5000);
                }

                this.minicartReload();
            } else {
                console.log(data);
                alert('Ошибка');
            }
        });
    }

    address() {
        if (this.nodes.address.get(0)) {
            this.nodes.address.kladr({
                oneString: true,
                change: function (obj) {
                    var $log, i;

                    $('.js-log li').hide();

                    for (i in obj) {
                        $log = $('#' + i);

                        if ($log.length) {
                            $log.find('.value').text(obj[i]);
                            $log.show();
                        }
                    }
                }
            });
        }
    }

    addressMap() {
        if (this.nodes.addressMap__inner.get(0)) {
            ymaps.ready(() => {
                var center = [55.753994, 37.622093];
                this.nodes.myMap = new ymaps.Map(this.nodes.addressMap__inner.attr('id'), {
                    center: center,
                    zoom: 10,
                    controls: ['zoomControl', 'geolocationControl']
                });

                this.nodes.myMap.events.add('actionend', (e) => {
                    this.getAddress(this.nodes.myMap.getCenter())
                });

                this.getAddress(center)
            });
        }
    }

    getAddress(coords) {
        ymaps.geocode(coords).then((res) => {
            var firstGeoObject = res.geoObjects.get(0);
            this.nodes.addressMap__centerAddress.text(firstGeoObject.getAddressLine());
        });
    }

    popupLeft() {
        if (this.nodes.mainHeader__cart.get(0)) {
            let mainHeader__cartLeft = this.nodes.mainHeader__cart.offset().left;
            let triangleLeft = mainHeader__cartLeft + 3;
            let popupLeft = mainHeader__cartLeft - 145;

            this.nodes.mainHeader__popupSuccessTriangle.css({
                'left': `${triangleLeft}px`
            });

            this.nodes.mainHeader__popupSuccess.css({
                'left': `${popupLeft}px`
            });
        }
    }

    minicartReload() {
        $.post('/cart/minicart', '', (response) => {
            $('.mainHeader__popupCart .mainHeader__popupOuter').replaceWith(response);
        });
    }
}

class Sorting {
    constructor(root) {
        this.root = root;

        this._cacheNodes();
        this._bindEvents();
        this._ready();
    }

    _cacheNodes() {
        this.nodes = {
            per_page: $('[name="per_page"]'),
            sort: $('[name="sort"]'),
            sorting: $('.sorting'),
        }
    }

    _bindEvents() {
        this.nodes.per_page.change(() => {
            this.nodes.sorting.submit();
        });

        this.nodes.sort.on( "selectmenuchange", () => {
            this.nodes.sorting.submit();
        });

        this.nodes.sorting.submit(() => {
            let sortVal = this.nodes.sort.val();
            let perPageVal = $('[name="per_page"]:checked').val();
            let data = `per_page=${perPageVal}`;

            if (sortVal.length > 1) {
                data += `&sort=${sortVal}`;
            }

            let filterSerialize = $('.filter').serialize();

            location = `${location.pathname}?${data}&${filterSerialize}`;

            return false;
        });
    }

    _ready() {

    }
}

class Filter {
    constructor(root) {
        this.root = root;

        this.closing = false;

        this._cacheNodes();
        this._bindEvents();
        this._ready();
    }

    _cacheNodes() {
        this.nodes = {
            filter: $('.filter'),
            filter__inner: $('.filter__inner'),
            filter__itemHeader: $('.filter__itemHeader'),
            filter__priceInput: $('.filter__priceInput'),
            filterSubmit: $('.js-filter-submit'),
            filter__showMore: $('.filter__showMore'),
            filter__fixedSubmit: $('.filter__fixedSubmit'),
            catalogTop__sort: $('.catalogTop__sort'),
            filter__mobileOpen: $('.filter__mobileOpen'),
            categoryFilter: $('.js-category-filter'),
        }
    }

    _bindEvents() {
        this.nodes.categoryFilter.on('click', (event) => {
            let thisElement = $(event.currentTarget);
            let hasActive = false;

            this.nodes.categoryFilter.each((index, element) => {
                if ($(element).data('id') != thisElement.data('id')) {
                    $(element).removeClass('active');
                }
            });

            thisElement.toggleClass('active');
            Filter.submit();
        });

        this.nodes.filter__itemHeader.on('click', (event) => {
            if (!this.closing) {
                let thisElement = $(event.currentTarget);

                this.closing = true;

                if (thisElement.hasClass('closed')) {
                    thisElement.removeClass('closed');
                    thisElement.next().slideDown('fast', () => {
                        this.closing = false;
                    });
                } else {
                    thisElement.addClass('closed');
                    thisElement.next().slideUp('fast', () => {
                        this.closing = false;
                    });
                }

                this.nodes.filter__fixedSubmit.css({
                    'opacity': 0
                });
            }
        });

        this.nodes.filter__priceInput.on('keyup', (event) => {
            let thisElement = $(event.currentTarget);

            this.price(thisElement, false);

            let header = $('.filter__itemContent_prices').prev();
            let top = header.position().top - 12;
            this.nodes.filter__fixedSubmit.css({
                'top': `${top}px`,
                'opacity': 1
            });

            Filter.getFilterUrl();
        });

        this.nodes.filter__priceInput.on('change', (event) => {
            let thisElement = $(event.currentTarget);

            this.price(thisElement, true);
            Filter.getFilterUrl();
        });

        this.nodes.filter__showMore.on('click', (event) => {
            let thisElement = $(event.currentTarget);

            thisElement.siblings('.filter__itemLabel_hidden').removeClass('filter__itemLabel_hidden');
            thisElement.hide();
        });

        this.nodes.filter__mobileOpen.on('click', (event) => {
            let thisElement = $(event.currentTarget);
            let set_filter_opened;

            if (thisElement.hasClass('active')) {
                thisElement.removeClass('active');
                this.nodes.filter__inner.slideUp();
                set_filter_opened = 0;
            } else {
                thisElement.addClass('active');
                this.nodes.filter__inner.slideDown();
                set_filter_opened = 1;
            }

            $.post(location.pathname, 'set_filter_opened='+set_filter_opened);
        });

        this.nodes.filterSubmit.on('click', () => {
            Filter.submit();
            return false;
        });

        this.nodes.catalogTop__sort.on( "selectmenuchange", () => {
            Filter.submit();
        });

        $('.js-filter-clear').on("click", () => {
            location = this.nodes.filter.data('parent-url')
            /*this.nodes.filter.find('[type="checkbox"]').prop('checked', false);
            this.nodes.filter.find('[type="text"]').val('');
            Filter.submit();*/
        });

        $('.filter__itemContent [type="checkbox"]').on('change', (event) => {
            let thisElement = $(event.currentTarget);
            let parentTop = thisElement.parent().position().top - 7;

            this.nodes.filter__fixedSubmit.css({
                'top': `${parentTop}px`,
                'opacity': 1
            });

            Filter.getFilterUrl();
        });
    }

    _ready() {
        this.setStartSort();
    }

    setStartSort() {
        const catalogTop__sort = $('.catalogTop__sort');

        catalogTop__sort.attr('data-start-value', catalogTop__sort.val());
    }

    price(thisElement, checkMaxMin) {
        let val = parseInt(thisElement.val().replace(/\s+/g, '').trim());

        /*if (checkMaxMin) {
            let minPrice = thisElement.data('minprice');
            let maxPrice = thisElement.data('maxprice');

            if (val < parseInt(minPrice)) {
                val = parseInt(minPrice);
            } else if (val > parseInt(maxPrice)) {
                val = parseInt(maxPrice);
            }
        }*/
        const vv = number_format(val, 0, '', ' ') === '0' ? '' : number_format(val, 0, '', ' ');
        thisElement.val(vv);
    }

    static getFilterUrl() {
        const filter = $('.filter'),
            $location = location.origin+filter.attr('data-parent-url')+Filter.getData();

        filter.addClass('pending');

        $.post('/catalog/get-filter-url', `url=${encodeURIComponent($location)}`, function (response) {
            if (response.found_category_url !== undefined) {
                filter.attr('data-filter-url', response.found_category_url);
            } else {
                filter.removeAttr('data-filter-url');
            }

            filter.removeClass('pending');
        });
    }

    static getData() {
        return '?'+$(':input', '.filter')
            .filter(function(index, element) {
                return $(element).val() != '';
            }).serialize();
    }

    static submit() {
        const filter = $('.filter'),
            catalogTop__sort = $('.catalogTop__sort');
        let $location = filter.attr('data-parent-url'),
            sortStr = '',
            interval;

        if (catalogTop__sort.attr('data-start-value') !== catalogTop__sort.val() ||
            catalogTop__sort.attr('data-default-value') !== catalogTop__sort.val()) {
            sortStr = 'sort='+$('.catalogTop__sort').val();
        }

        interval = setInterval(function() {
            if (filter.hasClass('pending')) {
                return false;
            }

            clearInterval(interval);

            if (filter.attr('data-filter-url') !== undefined) {
                $location = filter.attr('data-filter-url');

                if (sortStr.length > 0) {
                    $location += `?${sortStr}`;
                }
            } else {
                $location += Filter.getData();

                if (sortStr.length > 0) {
                    $location += `&${sortStr}`;
                }
            }

            let ids = [];
            let i = 0;
            $('.js-category-filter').each(function(index, element) {
                if ($(element).hasClass('active')) {
                    ids[i] = $(element).data('id');
                    i++;
                }
            });

            if (ids.length > 0) {
                $location += '&cats='+ids.join();
            }

            location = $location;
        }, 50);
    }
}

class Application {
    constructor() {
        this._mainScripts();
        this._initClasses();
    }

    _mainScripts() {
        $('.brands__inner').owlCarousel({
            dots: false,
            nav: true,
            navText: [
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.7 30.35"><defs><style>.slider-left-svg{fill:#e83a4a;}</style></defs><g><path class="slider-left-svg" d="M35.7,28.55V1.75A1.76,1.76,0,0,0,33.2.15l-32,13.3a1.88,1.88,0,0,0,0,3.5l32,13.3A1.9,1.9,0,0,0,35.7,28.55Z"/></g></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.7 30.35"><defs><style>.slider-right-svg{fill:#e83a4a;}</style></defs><g><path class="slider-right-svg" d="M0,1.8V28.6a1.76,1.76,0,0,0,2.5,1.6l32-13.3a1.88,1.88,0,0,0,0-3.5L2.5.1A1.83,1.83,0,0,0,0,1.8Z"/></g></svg>'
            ],
            loop: true,
            responsive: {
                0: {
                    items: 1
                },
                650: {
                    items: 2
                },
                900: {
                    items: 3
                },
            }
        });

        $('.category__slider').owlCarousel({
            dots: false,
            nav: true,
            navText: [
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.49 24.9"><g><path class="sliderButton__outer" d="M7.25,24.9h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.26,7.26,0,0,0,32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4Z"></path><path class="sliderButton__inner" d="M25.65,18.3V6.7a.82.82,0,0,0-1.1-.7l-13.9,5.8a.8.8,0,0,0,0,1.5l13.9,5.8A.89.89,0,0,0,25.65,18.3Z"></path></g></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.51 24.9"><g><path class="sliderButton__outer" d="M32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.24,7.24,0,0,0,32.25,0Z"></path><path class="sliderButton__inner" d="M13.85,6.6V18.2a.78.78,0,0,0,1.1.7l13.9-5.8a.8.8,0,0,0,0-1.5L15,5.8A.83.83,0,0,0,13.85,6.6Z"></path></g></svg>'
            ],
            navClass: [
                'owl-prev sliderButton',
                'owl-next sliderButton'
            ],
            loop: false,
            responsive: {
                0: {
                    items: 1
                },
                370: {
                    items: 2
                },
                500: {
                    items: 3
                },
                650: {
                    items: 4
                },
                800: {
                    items: 5
                },
                930: {
                    items: 6
                },
                1080: {
                    items: 7
                },
            }
        });

        $('.productSlider__inner').owlCarousel({
            dots: false,
            nav: true,
            navText: [
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.49 24.9"><g><path class="sliderButton__outer" d="M7.25,24.9h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.26,7.26,0,0,0,32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4Z"></path><path class="sliderButton__inner" d="M25.65,18.3V6.7a.82.82,0,0,0-1.1-.7l-13.9,5.8a.8.8,0,0,0,0,1.5l13.9,5.8A.89.89,0,0,0,25.65,18.3Z"></path></g></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.51 24.9"><g><path class="sliderButton__outer" d="M32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.24,7.24,0,0,0,32.25,0Z"></path><path class="sliderButton__inner" d="M13.85,6.6V18.2a.78.78,0,0,0,1.1.7l13.9-5.8a.8.8,0,0,0,0-1.5L15,5.8A.83.83,0,0,0,13.85,6.6Z"></path></g></svg>'
            ],
            navClass: [
                'owl-prev sliderButton',
                'owl-next sliderButton'
            ],
            loop: true,
            responsive: {
                0: {
                    items: 1
                },
                750: {
                    items: 2
                },
                1130: {
                    items: 3
                },
            }
        });

        flexGridAddElements('catalog__innerRightItems', 'catalog__item', 'catalog__item_hide');
        flexGridAddElements('newsBlock__inner', 'newsBlock__item', 'newsBlock__item_hide');
        flexGridAddElements('mostCatalog__inner', 'mostCatalog__item', 'mostCatalog__item_hide');
        flexGridAddElements('catalog__inner_search', 'catalog__item', 'catalog__item_hide');

        $('[data-fancybox]').fancybox({
            'loop': true,
            buttons: [
                "close"
            ],
            btnTpl: {
                close: '<button data-fancybox-close class="fancybox-button fancybox-button--close" title="{{CLOSE}}"><img src="/img/close.svg"></button>',
                arrowLeft: '<button data-fancybox-prev class="sliderButton fancybox-button fancybox-button--arrow_left" title="{{PREV}}" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.49 24.9"><g><path class="sliderButton__outer" d="M7.25,24.9h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.26,7.26,0,0,0,32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4Z"></path><path class="sliderButton__inner" d="M25.65,18.3V6.7a.82.82,0,0,0-1.1-.7l-13.9,5.8a.8.8,0,0,0,0,1.5l13.9,5.8A.89.89,0,0,0,25.65,18.3Z"></path></g></svg></button>',
                arrowRight: '<button data-fancybox-next class="sliderButton fancybox-button fancybox-button--arrow_right" title="{{NEXT}}" href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.51 24.9"><g><path class="sliderButton__outer" d="M32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.24,7.24,0,0,0,32.25,0Z"></path><path class="sliderButton__inner" d="M13.85,6.6V18.2a.78.78,0,0,0,1.1.7l13.9-5.8a.8.8,0,0,0,0-1.5L15,5.8A.83.83,0,0,0,13.85,6.6Z"></path></g></svg></button>',
                smallBtn: '<button data-fancybox-close class="fancybox-close-small" title="{{CLOSE}}"><img src="/img/close.svg"></button>',
            },
        });

        $('[data-fancybox="addressMap"]').fancybox({
            touch : false,
            btnTpl: {
                smallBtn: '<button data-fancybox-close class="fancybox-close-small" title="{{CLOSE}}"><img src="/img/clouse2.svg"></button>',
            },
        });

        $('.infs__tab').click(function() {
            $('.infs__tab').removeClass('active');
            $('.infs__content').removeClass('active');

            $(this).addClass('active');
            $('.infs__content').eq($(this).index()).addClass('active');
        });

        $('.addToCart__continue').click(function() {
            $.fancybox.close();
            $('.mainHeader__popupSuccess_cart').addClass('active unhidden');
            $('.mainHeader__popupSuccessTriangle').addClass('active');

            setTimeout(() => {
                $('.mainHeader__popupSuccess_cart').removeClass('active');
                $('.mainHeader__popupSuccessTriangle').removeClass('active');
                setTimeout(() => {
                    $('.mainHeader__popupSuccess_cart').removeClass('unhidden');
                }, 500);
            }, 2000)
        });

        $('.category__tagSeeAll').click(function() {
            if ($(this).hasClass('active')) {
                $(this).html('<span>посмотреть все -&gt;</span>').removeClass('active');
                $('.category__tag').css({
                    'display': 'none'
                });
                $('.category__tag:nth-child(n+10)').css({
                    'display': 'inline-block'
                });
            } else {
                $(this).html('<span>свернуть &lt;-</span>').addClass('active');
                $('.category__tag').css({
                    'display': 'inline-block'
                });

            }

            return false;
        });

        $('.alphabet__tab').click(function() {
            let id = $(this).data('id');
            let top = $('.alphabet__content[data-id="'+id+'"]').offset().top - 50;

            $("html, body").stop().animate({scrollTop: top}, 400, 'swing');
        });

        $('body').on('beforeSubmit', '.sendForm', (event) => {
            var form = $(event.currentTarget);
            var submitButton = form.find('[type="submit"]');

            if (!submitButton.hasClass('loading')) {
                var formData = new FormData(form.get(0));
                var xhr = new XMLHttpRequest();
                let buttonHtml = submitButton.html();

                if (form.attr('id') == 'subscribe') {
                    xhr.open("POST", "/site/subscribe");
                } else {
                    xhr.open("POST", "/mail/index");
                }

                xhr.send(formData);
                submitButton.addClass('loading');

                xhr.upload.onprogress = () => {

                };

                xhr.onreadystatechange = () => {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            var response = xhr.responseText;
                            submitButton.removeClass('loading');

                            if (form.attr('id') == 'oneClick' || form.attr('id') == 'delayPayment') {
                                if (response) {
                                    location = '/cart/success/' + response;
                                }
                            } else {
                                if (response == 'success') {
                                    form[0].reset();

                                    if (submitButton.find('span').get(0)) {
                                        submitButton.addClass('send');
                                        submitButton.find('span').text('Спасибо!');
                                    } else {
                                        submitButton.addClass('send').text('Спасибо!');
                                    }

                                    setTimeout(() => {
                                        $.fancybox.close();
                                        submitButton.removeClass('send').html(buttonHtml);
                                    }, 3000);
                                } else {
                                    alert('Ошибка');
                                }
                            }
                        } else {
                            console.log('error status');
                        }
                    }
                };
                return false;
            }
        });

        $('[href^="tel:"]').click(() => {
            if ($(window).width() < 900) {
                return true;
            } else {
                return false;
            }
        });

        var redirect__number = $('.redirect__number')
        if (redirect__number.get(0)) {
            setInterval(() => {
                let value = parseInt(redirect__number.text());
                let newVal = value - 1;

                if (newVal == 0) {
                    $('.to-yandex').submit();
                }

                if (newVal >= 0) {
                    redirect__number.text(newVal);
                }
            }, 1000);
        }

        if (location.search.indexOf('priceFrom') > 0) {
            setTimeout(function() {
                var body = $("html, body");
                body.stop().animate({scrollTop: $('.catalog').offset().top - 100}, 300, 'swing');
            }, 1000);
        }

        $(document).on('click', '.js-product-compare', (event) => {
            let thisElement = $(event.currentTarget);
            let id = thisElement.data('id');
            let data = `id=${id}`;

            function textC(thisElement) {
                let newText = thisElement.data('text');

                thisElement.data('text', thisElement.text());
                thisElement.text(newText);
            }

            if (thisElement.hasClass('in')) {
                $.post('/compare/delete', data, (response) => {
                    if (response === 'success') {
                        textC(thisElement);
                        thisElement.removeClass('in');
                    }
                });
            } else {
                $.post('/compare/add', data, (response) => {
                    if (response == 'success') {
                        textC(thisElement);
                        thisElement.addClass('in');
                    }
                });
            }

            return false;
        });

        $(document).on('click', '.js-product-preorder', (event) => {
            $('#product-to-cart-add').click();
        });

        if (location.search === '?fancybox=1') {
            $('#product-to-cart-add').click();
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        const catalogTagsMore = $('.js-catalog-tags-more'),
            catalogTagsContainer = $('.js-catalog-tags-container');

        if ($('.js-catalog-tags-inner').height() > catalogTagsContainer.height() + 5) {
            catalogTagsMore.removeClass('hidden');
        }

        catalogTagsMore.on('click', () => {
            catalogTagsContainer.addClass('show');
            catalogTagsMore.addClass('hidden');
        });
    }

    _initClasses() {
        new Header();
        new MainSlider();
        new ProductTabs();
        new ProductSliders();
        new Cart();
        new Filter();
        new Sorting();
        if ($('.compare').get(0)) {
            new Compare();
        }
    }
}

(function () {
    new Application();
})();

function number_format( number, decimals, dec_point, thousands_sep ) {	// Format a number with grouped thousands
    //
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +	 bugfix by: Michael White (http://crestidg.com)

    var i, j, kw, kd, km;

    // input sanitation & defaults
    if( isNaN(decimals = Math.abs(decimals)) ){
        decimals = 2;
    }
    if( dec_point == undefined ){
        dec_point = ",";
    }
    if( thousands_sep == undefined ){
        thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    if( (j = i.length) > 3 ){
        j = j % 3;
    } else{
        j = 0;
    }

    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    //kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


    return km + kw + kd;
}
