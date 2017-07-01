(function($){
	$(document).ready(function(){

        var body = $(document.body);

		/**
		 * skip link focus
		 */
		var is_webkit = navigator.userAgent.toLowerCase().indexOf('webkit') > -1,
			is_opera  = navigator.userAgent.toLowerCase().indexOf('opera')  > -1,
			is_ie     = navigator.userAgent.toLowerCase().indexOf('msie')   > -1;
		if ((is_webkit || is_opera || is_ie) && document.getElementById && window.addEventListener){
			window.addEventListener('hashchange', function(){
				var element = document.getElementById(location.hash.substring(1));
				if (element){
					if ( ! /^(?:a|select|input|button|textarea)$/i.test(element.tagName)){
						element.tabIndex = -1;
					}
					element.focus();
				}
			}, false);
		}

		/**
		 * EDD cart information in the header
		 */
		var header_cart_total = $('.header-cart-total');
		body.on('edd_cart_item_added',function(event, response){
			header_cart_total.html(response.subtotal);
		});
		body.on('edd_cart_item_removed',function(event, response){
			header_cart_total.html (response.subtotal);
		});

		/**
		 * Main Menu search form expand
		 */
		body.on('click', '.nav-search-anchor', function(e){
			e.preventDefault();
			$(this).siblings('#search-form').find('#search-input').focus();
		});


		/**
		 * EDD [downloads] shortcode button behavior
		 */
        body.on('click', '.vendd-show-button', function(e){
			e.preventDefault();
			$(this).toggleClass('vendd-price-button-displayed').siblings('.vendd-price-button-container').slideToggle();
			$(this).parents('.edd_download').siblings().find('.vendd-price-button-container').slideUp().prev('.vendd-show-button').removeClass('vendd-price-button-displayed');
		});

		/**
		 * responsive menu behavior
		 */
		var container, button, menu;
		container = document.getElementById('site-navigation');
		if (!container){
			return;
		}
		button = container.getElementsByTagName('span')[0];
		if ('undefined' === typeof button){
			return;
		}
		menu = container.getElementsByTagName('ul')[0];
		if ('undefined' === typeof menu){
			button.style.display = 'none';
			return;
		}
		button.onclick = function(){
			if (-1 !== container.className.indexOf('toggled')){
				container.className = container.className.replace(' toggled','');
			} else {
				container.className += ' toggled';
			}
		};
	});
})(jQuery);