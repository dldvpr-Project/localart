import * as L from 'leaflet';
import marker from "../images/icons/camera.png"

function centeredView(myLatitude, myLongitude) {
    return L.map('map').setView([myLatitude, myLongitude], 15);
}

const defaultIcon = L.icon({
    iconUrl: marker,
    iconSize: [50, 50],
    iconAnchor: [2, 2],
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

if (document.getElementById("getHomeArtId") !== null) {
    let getHomeArtId = document.getElementById("getHomeArtId").value;
    oneArt(getHomeArtId)
}
if (document.getElementById('getShowArtId') !== null) {
    let getShowArtId = document.getElementById("getShowArtId").value;
    oneArt(getShowArtId)
}
