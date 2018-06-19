'use strict';
import Typed from 'typed.js';
$(document).ready(function() {
    document.getElementById('typed-strings').style = '';
    var typed = new Typed('#typed', {
        stringsElement: '#typed-strings',
        // typing speed
        typeSpeed: 150,
        // backspacing speed
        backSpeed: 150,
        // time before backspacing
        backDelay: 500,
        // loop
        loop: true,
    });
});
