function countdown() {

    var countDownDate = new Date("Jun 20, 2018 00:00:00").getTime();

    var containerRoot = document.getElementsByClassName("section-countdown")[0];

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    containerRoot.getElementsByClassName("cdays")[0].innerHTML = days;
    containerRoot.getElementsByClassName("chours")[0].innerHTML = hours;
    containerRoot.getElementsByClassName("cminutes")[0].innerHTML = minutes;
    containerRoot.getElementsByClassName("cseconds")[0].innerHTML = seconds;
    containerRoot.getElementsByClassName("cexpired")[0].style.visibility = "hidden";
    containerRoot.getElementsByClassName("ccount")[0].style.visibility = "visible";

    // If the count down is finished, write some text
    if (distance < 0) {
        clearInterval(javascriptCountdown);
        containerRoot.getElementsByClassName("cexpired")[0].style.visibility = "hidden";
        containerRoot.getElementsByClassName("ccount")[0].style.visibility = "visible";
    }
}

var javascriptCountdown = setInterval(function() {countdown();}, 1000);