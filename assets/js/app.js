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
let link = $("[data-href]");
cheet('s c h m u s', function () {
	link.attr('href',link.data('href'));
    cheet.disable('s c h m u s e r');

    cheet('m i e s e r', function() {
        link.remove();
        cheet.disable('m i e s e r');
    })
});

import './pages/landing.js';
import './pages/gallery';
