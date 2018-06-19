"use strict";
(function($) {
	$(".language-trigger").click(function() {
	    $('.langdropdown').toggleClass('open');
	});

	$('.social-toggle').on('click', function() {
		$('.social-networks').toggleClass('open-menu');
	});
})(jQuery);

import cheet from 'cheet.js';
cheet('s c h m u s', function () {
	alert('god mode enabled');
	$("[data-href]").attr('href',$("[data-href]").data('href'));
    cheet.disable('s c h m u s');
});

import './pages/landing.js';
import './pages/gallery';
