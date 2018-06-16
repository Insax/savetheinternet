export default class Map {
    constructor() {
        this.map = null;
        this.container = document.getElementById('map-list');
        this.apiKey = 'AIzaSyB2-bnT7GwECse_lvi-_DbeT3P8neYM4EI'; // Dev-Keys, working with localhost. Replace before build!
        this.list = [];
        this.urls = {
            get: 'http://localhost:8080/build/static/locations.json',
            post: '',
        };

        this.buildList().then(() => this.loadMap());
    }

    buildList() {
        return new Promise((resolve, reject) => {
            fetch(this.urls.get).then(r => r.json()).then(list => {
                this.list = list;

                list.forEach(entry => {
                    this.container.appendChild(this.buildEntry(entry));
                });

                resolve(list);
            }).catch(e => reject(e));
        });
    }

    buildEntry(data) {
        let elem = document.createElement('div');
        elem.innerHTML = `
            <div class="demo-entry">
                <div class="title">${data.title}</div>
                <div class="footer">
                     <span class="date">
                        <i class="fa fa-clock-o"></i> ${moment.unix(data.timestamp).format('DD.MM.YYYY - HH:mm')}
                    </span>
                    <span class="location">
                        <i class="fa fa-map-marker"></i> Dummy
                    </span>
                </div>
            </div>
        `;

        elem.querySelector('.title').onclick = () => this.scrollToMarker(data);

        return elem;
    }

    loadMap() {
        let scriptTag = document.createElement('script');
        scriptTag.src = `https://maps.googleapis.com/maps/api/js?key=${this.apiKey}`;
        scriptTag.onload = () => this.initMap();

        document.body.appendChild(scriptTag);
    }

    initMap() {
        let location = {};
        this.getUserLocation()
            .then(loc => location = loc)
            .catch(() =>  location = { longitude: 9.7759953, latitude: 49.3447052, zoom: 4.5 })
            .finally(() => {
                this.map = new google.maps.Map(document.getElementById('map'), {
                    zoom: location.zoom ? location.zoom : 10,
                    center: new google.maps.LatLng(location.latitude, location.longitude),
                    mapTypeId: 'roadmap',
                });

                this.list.forEach(data => {
                    new google.maps.Marker({
                        position: new google.maps.LatLng(data.lat, data.lng),
                        map: this.map,
                        title: data.title,
                    })
                })
            });
    }

    getUserLocation() {
        return new Promise((resolve, reject) => {
            if ('geolocation' in navigator) {
                navigator.geolocation.getCurrentPosition(
                    position => resolve(position.coords),
                    err => reject(err.message)
                );
            } else {
                reject('Geolocation is not supported by your browser.');
            }
        });
    }

    scrollToMarker(data) {
        this.map.panTo(new google.maps.LatLng(data.lat, data.lng));
    }
}

let map = new Map();
