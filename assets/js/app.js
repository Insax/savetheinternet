"use strict";
import 'bootstrap';
import ResponsiveVideo from './components/responsive-video';
import Typed from 'typed.js';
import moment from 'moment';

//Comment für @Inf4m0u5
// (function () {
// 	'use strict';
// 	var t = Typed;
// 	debugger;
// })();

window.moment = moment;

(function($) {
	new ResponsiveVideo('.responsive-video').activate();

	$(".language-trigger").click(function() {
	    $('.langdropdown').toggleClass('open');
	});
	
	$('.social-toggle').on('click', function() {
		$('.social-networks').toggleClass('open-menu');
	});
})(jQuery);

import './pages/landing.js';
import './pages/gallery';
