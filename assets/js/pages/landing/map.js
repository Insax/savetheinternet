export default class Map {
    constructor() {
        this.map = null;
        this.mapContainer = document.getElementById('map');
        this.container = document.querySelector('#map-list .list');
        this.spinner = document.getElementsByClassName('map-loader')[0];
        this.infoContainer = null;
        this.apiKey = 'AIzaSyB2-bnT7GwECse_lvi-_DbeT3P8neYM4EI'; // Dev-Key!
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
                    let oCity = null;
                    entry.time = moment.unix(entry.timestamp).format('DD.MM.YYYY - HH:mm');
                    entry.descr = 'To Do!';

                    this.getCityName(entry)
                    .then(city => oCity = city)
                    .catch(() => oCity = 'unknown')
                    .finally(() => {
                        entry.city = oCity;
                        this.container.insertBefore(this.buildEntry(entry), this.container.firstChild);
                    });
                });

                resolve(list);
            }).catch(e => reject(e));
        });
    }

    buildEntry(data) {
        let elem = $(`
            <div class="demo-entry">
                <div class="title">${data.title}</div>
                <div class="footer">
                     <span class="date">
                        <i class="fa fa-clock-o"></i> ${data.time}
                    </span>
                    <span class="location">
                        <i class="fa fa-map-marker"></i> ${data.city}
                    </span>
                </div>
            </div>
        `)[0];

        elem.onclick = () => this.scrollToMarker(data);

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
                    });
                });

                this.spinner.classList.remove('map-loader');
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
        this.addInfo(data);
    }

    addInfo(data) {
        if (!this.infoContainer) {
            this.infoContainer = document.createElement('div');
            this.infoContainer.className = 'map-info';
            this.infoContainer.innerHTML = `
                <div class="head">
                    <span class="fa fa-angle-left"></span> 
                    <span class="title">${data.title}</span>
                </div>
                <div class="content">
                    <div class="location">
                        <i class="fa fa-map-marker"></i> 
                        <span class="val">${data.city}</span>
                    </div>
                    <div class="time">
                        <i class="fa fa-clock-o"></i> 
                        <span class="val">${data.time}</span>
                    </div>
                    <div class="description"><span class="val">${data.descr}</span></div>
                </div>
            `;

            this.mapContainer.insertBefore(this.infoContainer, this.mapContainer.firstChild);
            window.getComputedStyle(this.infoContainer).marginLeft; // Animation-hack
            this.infoContainer.classList.add('visible');
            this.infoContainer.querySelector('.head').onclick = () => this.removeInfo(this.infoContainer);
        } else {
            this.infoContainer.classList.add('visible');
            this.infoContainer.querySelector('.title').innerText = data.title;
            this.infoContainer.querySelector('.content .location .val').innerText = data.city;
            this.infoContainer.querySelector('.content .time .val').innerText = data.time;
            this.infoContainer.querySelector('.content .description .val').innerText = data.descr;
        }
    }

    removeInfo() {
        console.log('remove');
        this.infoContainer.classList.remove('visible');
    }

    getCityName(data) {
        return new Promise((resolve, reject) => {
            fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${data.lat},${data.lng}&sensor=true`)
            .then(r => r.json()).then(res => {
                res = res.results[res.results.length - 2];
                res ? resolve(res.formatted_address.split(',')[0]) : reject(false);
            })
            .catch(e => reject(e));
        });
    }
}

let map = new Map();
