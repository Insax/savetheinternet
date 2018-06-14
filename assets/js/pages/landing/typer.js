'use strict';
import Typed from 'typed.js';
$( document ).ready(function() {
    var typed = new Typed('#typed', {
        stringsElement: '#typed-strings',
        // typing speed
        typeSpeed: 30,
        // time before typing starts
        startDelay: 1200,
        // backspacing speed
        backSpeed: 20,
        // time before backspacing
        backDelay: 500,
        // loop
        loop: true,
    });
});
