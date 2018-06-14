import 'bootstrap';
import ResponsiveVideo from './components/responsive-video';
import Typed from 'typed.js';

//Comment für @Inf4m0u5
// (function () {
// 	'use strict';
// 	var t = Typed;
// 	debugger;
// })();

(function($) {
	new ResponsiveVideo('.responsive-video').activate();
})(jQuery);

import './pages/landing.js';
