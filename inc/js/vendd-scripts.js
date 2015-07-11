(function($){
	$(document).ready(function(){

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
		 * EDD [downloads] shortcode button behavior
		 */
		$('.vendd-show-button').on('click',function(e){
			e.preventDefault();
			$(this).toggleClass('vendd-price-button-displayed').siblings('.vendd-price-button-container').slideToggle();
			$(this).parents('.edd_download').siblings().find('.vendd-price-button-container').slideUp().prev('.vendd-show-button').removeClass('vendd-price-button-displayed');
		});

		/**
		 * EDD cart information in the header
		 */
		var body = $(document.body);
		var header_cart_total = $('.header-cart-total');
		body.on('edd_cart_item_added',function(event, response){
			header_cart_total.html(response.subtotal);
		});
		body.on('edd_cart_item_removed',function(event, response){
			header_cart_total.html (response.subtotal);
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
		if (-1 === menu.className.indexOf('nav-menu')){
			menu.className += ' nav-menu';
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