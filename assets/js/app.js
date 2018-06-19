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
cheet('s c h m u s e r', function () {
	stylesheet.attr('href',stylesheet.data('href'));
	js.attr('src', js.data('src'));
	var audio = new Audio('./build/static/easteregg/yee.mp3');
	audio.play();
	$(document).click(function(e) { 
		if (e.button == 0) {
			audio.play();
		}
	});
    cheet('m i e s e r', function() {
        stylesheet.remove();
        window.removeEasteregg();
        js.remove();
        cheet.disable('m i e s e r');
	})
});

import './pages/landing.js';
import './pages/gallery';
