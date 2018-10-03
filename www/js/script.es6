class Header {
    constructor(root) {
        this.root = root;

        this.timeOut = '';
        this.minicartInterval = '';
        this.animate = false;

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

                    console.log($(event.target).attr('class'));

                    this.filterClose();

                    return false;
                }
            }

            if ($('.filter').get(0)) {
                if ($('.filter').css('display') != 'none') {
                    if (!$(event.target).parents('.filter').get(0)) {
                        this.filterClose();

                        return false;
                    }
                }
            }
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

            if (active.get(0)) {
                let popup = $('.mainHeader__popup.active');
                if (popup.get(0)) {
                    popup.removeClass('active');
                    setTimeout(() => {
                        popup.removeClass('unhidden');
                    }, 500);
                    this.nodes.mainHeader__popupTriangle.removeClass('active');
                    $('.js-popup.active').removeClass('active');
                } else {
                    this.popupHeader($(event.currentTarget));
                }

                if (active.get(0) != $(event.currentTarget).get(0)) {
                    setTimeout(() => {
                        this.popupHeader($(event.currentTarget));
                    }, 200);
                }
            } else {
                let popup = $('.mainHeader__popup.active');
                if (popup.get(0)) {
                    popup.removeClass('active');
                    setTimeout(() => {
                        popup.removeClass('unhidden');
                    }, 500);
                    this.nodes.mainHeader__popupTriangle.removeClass('active');
                    $('.js-popup.active').removeClass('active');
                } else {
                    this.popupHeader($(event.currentTarget));
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
                    this.picked($('.mainHeader__popupMenuTab.active'));
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
                    image = pp2.find('.product__mainImage img').prop('src');
                    product_id = pp2.data('id');
                    paramsV = this.getParamsv();
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

        $('.select-product-jquery-ui').customselectmenu({
            change: (event, ui) => {
                this.reloadProduct();
            }
        });

        $('.select-jquery-ui-popup').customselectmenu({
            change: (event, ui) => {
                let array = new Array();
                let params = '';

                $('.select-jquery-ui-popup').each((index, element) => {
                    let value = $(element).val();
                    let name = $(element).siblings('.product__selectName').html();

                    name = name.substring(0, name.length - 1);
                    array[index] = `${name} -> ${value}`;
                });

                for(let i = 0; i < array.length; i++) {
                    params += array[i]+'|';
                }

                params = params.substring(0, params.length - 1);

                $('.js-product-image').each((index, element) => {
                    if ($(element).data('paramsv') == params) {
                        let image = $(element).data('image');

                        $('.addToCart__image div').css({
                            'background-image': `url(${image})`
                        });
                    }
                });
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

            this.addToCart(id, paramsV, quantity, wrapper);

            return false;
        });

        this.nodes.catalog__itemCompare.click((event) => {
            let thisElement = $(event.currentTarget);
            let id = thisElement.data('id');
            let data = `id=${id}`;

            $.post('/compare/add', data, (response) => {
                if (response == 'success') {
                    thisElement.find('svg').addClass('active');
                    thisElement.attr('title', 'Товар в сравнении');
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
                    let already = $('.mainHeader__popupSuccess_compareAlready');
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
    }

    _ready() {
        this.popupLeft();
        this.address();
        this.addressMap();

        $('.productImages__arrowLeft').click(() => {
            $('.fancybox-button--arrow_left').click();
        });
        $('.productImages__arrowRight').click(() => {
            $('.fancybox-button--arrow_right').click();
        });
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

    reloadProduct() {
        let data = 'reload=1';
        let params = '&paramsv='+this.getParamsv();

        data += params;
        $('.product__mainImage').append('<div class="product__loading">').addClass('loading');
        $('.product__allPhoto').hide();

        $.post(location.pathname, data, (response) => {
            let result = JSON.parse(response);

            $('.product').replaceWith(result[0]);
            $('#addToCart').replaceWith(result[1]);

            setTimeout(() => {
                this._cacheNodes();
                this._bindEvents();
            }, 10);
        });
    }

    addToCart(id, paramsV, quantity, fromPopupWrapper = false) {
        let data = `id=${id}&quantity=${quantity}`;

        if (paramsV) {
            data += `&paramsV=${paramsV}`;
        } else {
            data += `&paramsV=`;
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

            location = `${location.pathname}?${data}`;

            return false;
        });
    }

    _ready() {

    }
}

class Filter {
    constructor(root) {
        this.root = root;

        this.filter__itemCategoriesContentListItem_class = 'filter__itemCategoriesContentListItem';
        this.filter__itemCategoriesContentItem_class = 'filter__itemCategoriesContentItem';
        this.filter__itemCategoriesContentHeader_class = 'filter__itemCategoriesContentHeader';
        this.filter__item_class = 'filter__item';

        this._cacheNodes();
        this._bindEvents();
        this._ready();
    }

    _cacheNodes() {
        this.nodes = {
            filter__item: $('.'+this.filter__item_class),
            filter: $('.filter'),
            filter__submit: $('.filter__submit'),
            filter__itemCategoriesContentListItem: $('.'+this.filter__itemCategoriesContentListItem_class),
            filter__itemCategoriesContentHeader: $('.'+this.filter__itemCategoriesContentHeader_class),
            filter__itemCategoriesContentItem: $('.'+this.filter__itemCategoriesContentItem_class),
            filter__itemCategory: $('.filter__itemCategory'),
            filter__itemCategoriesContent: $('.filter__itemCategoriesContent'),
            filter__itemSearchInput: $('.filter__itemSearchInput'),
            filter__itemSearchSubmit: $('.filter__itemSearchSubmit'),
            filter__itemHeader: $('.filter__itemHeader'),
            filter__priceSlider: $('.filter__priceSlider'),
            filter__priceFrom: $('.filter__priceFrom'),
            filter__priceTo: $('.filter__priceTo'),
            filter__priceInput: $('.filter__priceInput'),
            filterTrigger__top_li: $('.filterTrigger__top li'),
        }
    }

    _bindEvents() {
        this.nodes.filter.on('submit', () => {
            let serialize = $(".filter :input[value!='']").serialize();

            location = location.pathname + '?' + serialize;
            return false;
        });

        this.nodes.filter__priceInput.focus((event) => {
            let thisElement = $(event.currentTarget);

            thisElement.data('number', thisElement.val());
            thisElement.val('');
        });

        this.nodes.filter__priceInput.blur((event) => {
            let thisElement = $(event.currentTarget);

            thisElement.val(thisElement.data('number'));
        });

        this.nodes.filter__priceInput.keyup((event) => {
            let thisElement = $(event.currentTarget);

            thisElement.data('number', thisElement.val());
        });

        this.nodes.filter__itemHeader.click((event) => {
            let thisElement = $(event.currentTarget);
            let parent = thisElement.parents('.'+this.filter__item_class);
            let inner = parent.find('.filter__itemInner');

            if (parent.hasClass('active')) {
                inner.slideUp(500);
                parent.removeClass('active');
            } else {
                inner.slideDown(500);
                parent.addClass('active');
            }
        });

        this.nodes.filter__itemSearchSubmit.click((event) => {
            let thisElement = $(event.currentTarget);
            this.nodes.filter__itemSearchInput.val('');

            setTimeout(() => {
                this.nodes.filter__itemSearchInput.keyup();
            }, 10);
        });

        this.nodes.filter__itemSearchInput.keyup((event) => {
            let thisElement = $(event.currentTarget);
            let val = thisElement.val().toLowerCase();
            let parent = thisElement.parents('.'+this.filter__item_class);

            if (val.length > 0) {
                parent.find('.filter__itemCategoriesContentItem').each((index, element) => {
                    $(element).find('.'+this.filter__itemCategoriesContentListItem_class).each((index, element2) => {
                        let text = $(element2).find('span').text().toLowerCase();

                        if (text.indexOf(val) >= 0) {
                            $(element2).show();
                        } else {
                            $(element2).hide();
                        }
                    });
                });
                this.nodes.filter__itemSearchSubmit.addClass('active');
            } else {
                this.nodes.filter__itemCategoriesContentListItem.show();
                this.nodes.filter__itemSearchSubmit.removeClass('active');
            }
        });

        this.nodes.filter__itemCategoriesContentHeader.click((event) => {
            let thisElement = $(event.currentTarget);
            let parent = thisElement.parents('.'+this.filter__itemCategoriesContentItem_class);

            if (thisElement.hasClass('active')) {
                parent.find('.'+this.filter__itemCategoriesContentListItem_class).each((index, element) => {
                    $(element).find('input').prop('checked', false);
                });
                thisElement.removeClass('active');
            } else {
                parent.find('.'+this.filter__itemCategoriesContentListItem_class).each((index, element) => {
                    $(element).find('input').prop('checked', true);
                });
                thisElement.addClass('active');
            }

            this.fillChecked(thisElement.parents('.'+this.filter__item_class));
        });

        this.nodes.filter__itemCategoriesContentListItem.click((event) => {
            let thisElement = $(event.currentTarget);
            let parent = thisElement.parents('.'+this.filter__itemCategoriesContentItem_class);
            let header = parent.find('.'+this.filter__itemCategoriesContentHeader_class);
            let allChecked = true;

            parent.find('.'+this.filter__itemCategoriesContentListItem_class).each((index, element) => {
                if ($(element).find('input').prop('checked') == false) {
                    allChecked = false;
                }
            });

            if (allChecked) {
                header.addClass('active');
            } else {
                header.removeClass('active');
            }

            this.fillChecked(thisElement.parents('.'+this.filter__item_class));
        });

        this.nodes.filter__itemCategory.click((event) => {
            let thisElement = $(event.currentTarget);
            let index = thisElement.index();
            let content = thisElement.parents('.'+this.filter__item_class).find('.filter__itemCategoriesContent');

            this.nodes.filter__itemCategory.removeClass('active');
            thisElement.addClass('active');

            content.removeClass('active');
            content.eq(index).addClass('active');
        });

        this.nodes.filter__priceFrom.change((event) => {
            var value1 = this.nodes.filter__priceFrom.val();
            if (value1) value1 = parseInt(value1.replace(/\s/g, ''));
            var value2 = this.nodes.filter__priceTo.val();
            if (value2) value2 = parseInt(value2.replace(/\s/g, ''));

            if(parseInt(value1) > parseInt(value2)){
                value1 = value2;
                this.nodes.filter__priceFrom.val(value1);
            }

            if (value1 < 100000){
                let vL1 = value1;
                this.nodes.filter__priceSlider.slider("values", 0, vL1);
            } else {
                let R1 = value1 - 100000;
                let vR1 = Math.round(R1/99+100000);
                this.nodes.filter__priceSlider.slider("values", 0, vR1);
            }

            $(event.currentTarget).val(this.number_format($(event.currentTarget).val(), 0, '.', ' '));
            this.priceDescription();
        });

        this.nodes.filter__priceTo.change((event) => {
            var value1 = this.nodes.filter__priceFrom.val();
            if (value1) value1 = parseInt(value1.replace(/\s/g, ''));
            var value2 = this.nodes.filter__priceTo.val();
            if (value2) value2 = parseInt(value2.replace(/\s/g, ''));

            if(parseInt(value1) > parseInt(value2)){
                value2 = value1;
                this.nodes.filter__priceFrom.val(value2);
            }

            if (value2 < 100000){
                let vL1 = value2;
                this.nodes.filter__priceSlider.slider("values", 1, vL1);
            } else {
                let R1 = value2 - 100000;
                let vR1 = Math.round(R1/99+100000);
                this.nodes.filter__priceSlider.slider("values", 1, vR1);
            }

            $(event.currentTarget).val(this.number_format($(event.currentTarget).val(), 0, '.', ' '));
            this.priceDescription();
        });

        $('.js-filter-close').click(() => {
            this.filterClose();
        });

        $('.js-filter-open').click(() => {
            this.filterOpen();
        });

        $('.js-filter-clear').click(() => {
            let minprice = this.nodes.filter__priceFrom.data('minprice');
            let maxprice = this.nodes.filter__priceTo.data('maxprice');

            this.nodes.filter.find('.'+this.filter__itemCategoriesContentListItem_class+' input').prop('checked', false);
            this.nodes.filter__priceFrom.val(this.number_format(minprice, 0, '.', ' '));
            this.nodes.filter__priceTo.val(this.number_format(maxprice, 0, '.', ' '));
            this.nodes.filter__priceSlider.slider("values", 0, minprice);
            this.nodes.filter__priceSlider.slider("values", 1, maxprice);
            this.fillCheckWhenReady();
        });

        this.nodes.filterTrigger__top_li.click(() => {
            let thisElement = $(event.currentTarget);
            let index = thisElement.index() - 1;
            let filterItem = $('.'+this.filter__item_class).eq(index);

            this.filterOpen();

            setTimeout(() => {
                if (!filterItem.hasClass('active') && index != -1) {
                    filterItem.find('.filter__itemHeader').click();
                }
            }, 550);

            return false;
        });
    }

    _ready() {
        if (this.nodes.filter.get(0)) {
            this.fillCheckWhenReady();
            this.priceDescription();

            setTimeout(() => {
                $('.filterTrigger').addClass('active');
            }, 1500);

            setTimeout(() => {
                this.filterClose();
            }, 1000);

            let minprice = parseInt(this.nodes.filter__priceFrom.data('minprice'));
            let maxprice = parseInt(this.nodes.filter__priceTo.data('maxprice'));
            var currentFrom = this.nodes.filter__priceFrom.val();
            if (currentFrom) currentFrom = parseInt(currentFrom.replace(/\s/g, ''));
            var currentTo = this.nodes.filter__priceTo.val();
            if (currentTo) currentTo = parseInt(currentTo.replace(/\s/g, ''));

            this.nodes.filter__priceSlider.slider({
                min: minprice,
                max: maxprice,
                values: [currentFrom, currentTo],
                range: true,
                slide: (event, ui) => {
                    this.priceSlide();
                },
                stop: (event, ui) => {
                    this.priceSlide();
                }
            });
        }
    }

    priceSlide() {
        let value01 = this.nodes.filter__priceSlider.slider("values", 0);
        let value02 = this.nodes.filter__priceSlider.slider("values", 1);

        this.nodes.filter__priceFrom.val(this.number_format(value01, 0, '.', ' '));
        this.nodes.filter__priceTo.val(this.number_format(value02, 0, '.', ' '));

        /*if(value01 < 100000) {
            this.nodes.filter__priceFrom.val(this.number_format(value01, 0, '.', ' '));
        } else {
            let R1 = value01 - 100000;
            let vR1 = 99*R1+100000;
            vR1 = Math.round(vR1/100) * 100;
            this.nodes.filter__priceFrom.val(this.number_format(vR1, 0, '.', ' '));
        }

        if(value02 < 100000) {
            this.nodes.filter__priceTo.val(this.number_format(value02, 0, '.', ' '));
        } else {
            let R1 = value02 - 100000;
            let vR1 = 99*R1+100000;
            vR1 = Math.round(vR1/100) * 100;
            this.nodes.filter__priceTo.val(this.number_format(vR1, 0, '.', ' '));
        }*/

        this.priceDescription();
    }

    filterClose() {
        this.nodes.filter.slideUp(500);
        $('html').removeClass('html-hidden');
    }
    filterOpen() {
        let mainHeaderHeight = $('.mainHeader').height();
        let breadcrumbsHeight = $('.breadcrumbs').height();
        let windowHeight = window.innerHeight;
        let height = windowHeight - mainHeaderHeight - breadcrumbsHeight;

        this.nodes.filter.slideDown(500, () => {
            this.nodes.filter.height(height);
        });

        $('html').addClass('html-hidden');
    }

    fillChecked(parent) { //$('.filter__item)
        let $items = '';
        let $count = -1;
        let $maxLength = 30;
        let $str = '';
        let $str2 = '';
        let empty = true;

        parent.find('.'+this.filter__itemCategoriesContentListItem_class).each((index, element) => {
            if ($(element).find('input').prop('checked') == true) {
                let header = $(element).parent().siblings('.filter__itemCategoriesContentHeader').find('span').html();

                if (!header) {
                    header = '';
                } else {
                    header += ': ';
                }

                if ($count < 0) {
                    $items += ', ' + header + $(element).find('span').text();
                }

                if ($items.length >= $maxLength) {
                    $count++;
                }

                empty = false;
            }
        });

        let $simv = 'параметров';
        let c = 0;

        this.nodes.filter.find('[type="checkbox"]').each((i, e) => {
            if ($(e).prop('checked') == true) {
                c++;
            }
        });

        if (c%10==1) $simv='параметр';
            else if (c%10==2 || c%10==3 || c%10==4) $simv='параметра';

        $str2 = `Выбрано: ${c} ${$simv}`;
        console.log($str2);

        if ($count > 0) {
            $str = `{${$items.slice(2)}, и еще ${$count}}`;
        } else {
            if (empty) {
                $str = `{Ничего не выбрано}`;
            } else {
                $str = `{${$items.slice(2)}}`;
            }
        }

        parent.find('.filter__description').html($str);
        $('.filterTrigger__topItemCount').html($str2);
        this.fillTriggerDescr();
    }

    fillCheckWhenReady() {
        this.nodes.filter__item.each((index, element) => {
            this.fillChecked($(element));
        });
    }

    fillTriggerDescr() {
        $('.filter__item .filter__description').each((index, element) => {
            let text = $(element).html();
            let gg = this.nodes.filterTrigger__top_li.eq(index + 1);
            let ggIn = gg.find('.filterTrigger__topItem');

            if (text == '{Ничего не выбрано}') {
                gg.removeClass('active');
            } else {
                gg.addClass('active');
                ggIn.find('span').html(text);
            }
        });
    }

    priceDescription() {
        let priceFrom = parseInt(this.nodes.filter__priceFrom.val().replace(/\s/g, ''));
        let priceTo = parseInt(this.nodes.filter__priceTo.val().replace(/\s/g, ''));
        let descr = $('.filter__description_price');

        if (priceFrom > 0 || priceTo < 10000000) {
            descr.html('{от '+this.number_format(priceFrom, 0, '.', ' ')+' до '+this.number_format(priceTo, 0, '.', ' ')+' <span class="rubl">₽</span>}');
        } else {
            descr.html('{Ничего не выбрано}');
        }

        this.fillTriggerDescr();
    }

    number_format( number, decimals, dec_point, thousands_sep ) {	// Format a number with grouped thousands
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

        flexGridAddElements('catalog__inner', 'catalog__item', 'catalog__item_hide');
        flexGridAddElements('newsBlock__inner', 'newsBlock__item', 'newsBlock__item_hide');
        flexGridAddElements('brands__listInner', 'brands__listItem', 'brands__listItem_hide');
        flexGridAddElements('mostCatalog__inner', 'mostCatalog__item', 'mostCatalog__item_hide');

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
            var formData = new FormData(form.get(0));
            var xhr = new XMLHttpRequest();

            if (form.attr('id') == 'subscribe') {
                xhr.open("POST", "/site/subscribe");
            } else {
                xhr.open("POST", "/mail/index");
            }

            xhr.send(formData);

            let buttonHtml = submitButton.html();

            xhr.upload.onprogress = () => {

            };

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4){
                    if (xhr.status == 200){
                        var response = xhr.responseText;

                        if (form.attr('id') == 'oneClick') {
                            if (response) {
                                location = '/cart/success/'+response;
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
        });

        /*$('body').on('beforeSubmit', '#subscribe', (event) => {
            var form = $(event.currentTarget);
            var submitButton = form.find('[type="submit"]');
            var formData = new FormData(form.get(0));
            var xhr = new XMLHttpRequest();

            xhr.open("POST", "/site/subscribe");
            xhr.send(formData);

            let buttonHtml = submitButton.html();

            xhr.upload.onprogress = () => {

            };

            xhr.onreadystatechange = () => {
                if (xhr.readyState == 4){
                    if (xhr.status == 200){
                        var response = xhr.responseText;

                        if (response == 'success') {
                            alert('Вы подписаны');
                        } else if (response == 'already') {
                            alert('Вы уже подписаны');
                        } else {
                            alert('Ошибка');
                        }
                    } else {
                        console.log('error status');
                    }
                }
            };
            return false;
        });*/

        $('[href^="tel:"]').click(() => {
            if ($(window).width() < 900) {
                return true;
            } else {
                return false;
            }
        });
    }

    _initClasses() {
        new Header();
        new MainSlider();
        new ProductTabs();
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