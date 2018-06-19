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
let stylesheet = $("link[data-href]");
let js = $("script[data-src]");
cheet('s c h m u s', function () {
	stylesheet.attr('href',stylesheet.data('href'));
	js.attr('src', js.data('src'));
    cheet.disable('s c h m u s e r');

    cheet('m i e s e r', function() {
        stylesheet.remove();
        js.remove();
        cheet.disable('m i e s e r');
    })
});

import './pages/landing.js';
import './pages/gallery';
