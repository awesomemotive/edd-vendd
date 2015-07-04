/**
 * Adds parallax background effect
 *
 * @package Vendd
 */
jQuery(document).ready(function($){
	$('body').css('background-attachment','fixed');
	$(window).scroll(function(){
		document.body.style.backgroundPosition = "0px " + (0 - (Math.max(document.documentElement.scrollTop, document.body.scrollTop) / 4)) + "px";
	});
});