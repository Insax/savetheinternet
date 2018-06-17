export default class Map {
    constructor() {
        this.mapContainer = document.getElementById('map');
        this.frameContainer = this.mapContainer.getElementsByTagName('iframe')[0];

        this.loadMap();
    }

    loadMap() {
        this.frameContainer.onload = () => this.mapContainer.classList.remove('map-loader');
    }
}

let map = new Map();
