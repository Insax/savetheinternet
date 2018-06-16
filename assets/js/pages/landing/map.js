export default class Map {
    constructor() {
        this.map = null;
        this.mapContainer = document.getElementById('map');
        this.frameContainer = this.mapContainer.getElementsByTagName('iframe')[0];

        this.loadMap();
    }

    loadMap() {
        this.frameContainer.src = `https://www.google.com/maps/d/u/0/embed?mid=11FTfbx7UKU_MznD8wevgqnSTMII8_hjS&ll=51.631131202713426%2C9.005876179687448&z=7`;
        this.frameContainer.onload = () => this.mapContainer.classList.remove('map-loader');
    }
}

let map = new Map();
