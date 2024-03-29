import * as L from 'leaflet';
import marker from "../images/icons/camera.png"

function centeredView(myLatitude, myLongitude) {
    return L.map('map').setView([myLatitude, myLongitude], 15);
}

const defaultIcon = L.icon({
    iconUrl: marker,
    iconSize:     [40, 40],
    iconAnchor:   [20, 40], // CHANGE HERE
    popupAnchor:  [0, -35],
});

function oneArt(id) {
    fetch('/getArtCoordinates/' + id)
        .then(response => response.json())
        .then(data => {
            const {latitude, longitude} = data;
            let myMap = centeredView(latitude, longitude)
            L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                minZoom: 5,
                maxZoom: 20
            }).addTo(myMap)

            L.marker([latitude, longitude], {
                icon: defaultIcon
            }).addTo(myMap)
        })
}

function registerMap() {
    let map = L.map('map').setView([0, 0], 2);
    let marker;
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        attribution: 'données © <a href="//openstreetmap.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 5,
        maxZoom: 20
    }).addTo(map);
    marker = L.marker([0, 0], {
        icon: defaultIcon
    }).addTo(map);
    marker.bindPopup("Cliquez pour déplacer le marqueur").openPopup();
    map.on('click', updateMarkerPosition);

    function updateMarkerPosition(e) {
        let coord = e.latlng;
        marker.setLatLng(coord);
        document.querySelector("#art_card_latitude").value = coord.lat;
        document.querySelector("#art_card_longitude").value = coord.lng;
    }

    function onLocationFound(e) {
        marker.setLatLng(e.latlng);
        map.setView(e.latlng, 15);
        document.querySelector("#art_card_latitude").value = e.latlng.lat;
        document.querySelector("#art_card_longitude").value = e.latlng.lng;
    }

    function onLocationError() {
        setTimeout(function() {
            map.locate({setView: true, maxZoom: 15});
        }, 5000);
    }

    map.locate({setView: true, maxZoom: 15});
    map.on('locationfound', onLocationFound);
    map.on('locationerror', onLocationError);
}


if (document.getElementById('art_card_longitude') !== null && document.getElementById('art_card_latitude') !== null) {
    registerMap()
}

if (document.getElementById("getHomeArtId") !== null) {
    let getHomeArtId = document.getElementById("getHomeArtId").value;
    oneArt(getHomeArtId)
}
if (document.getElementById('getShowArtId') !== null) {
    let getShowArtId = document.getElementById("getShowArtId").value;
    oneArt(getShowArtId)
}


