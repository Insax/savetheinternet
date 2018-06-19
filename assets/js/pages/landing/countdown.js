export default class Countdown {
    constructor() {
        this.countdownDate = new Date('Jun 20, 2018 09:30:00').getTime();
        this.element = document.getElementsByClassName('countdown');
        this.containerRoot = null;
        this.hoursElement = null;
        this.minutesElement = null;
        this.countdownInterval = null;

        this.init();
    }

    init() {
        if (this.element.length !== 0) {
            this.containerRoot = this.element[0];
            this.hoursElement = this.containerRoot.getElementsByClassName('chours')[0];
            this.minutesElement = this.containerRoot.getElementsByClassName('cminutes')[0];

            this.countdownTick();

            this.countdownInterval = setInterval(() => {
                this.countdownTick();
            }, 10000);
        }
    }

    countdownTick() {
        const distance = this.countdownDate - new Date().getTime();
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

        //const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        //const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if (distance > 0) {
            this.hoursElement.innerText = hours;
            this.minutesElement.innerText = minutes;
        } else {
            clearInterval(this.countdownInterval);

            let cexpired = this.containerRoot.getElementsByClassName('cexpired')[0];
            cexpired.style.visibility = 'visible';
            cexpired.style.display = 'inline-block';

            this.containerRoot
                .getElementsByClassName("countdown-output")[0]
                .removeChild(this.containerRoot.getElementsByClassName('ccount')[0]);
        }
    }
}

let jsCountdown = new Countdown();
