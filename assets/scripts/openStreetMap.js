import * as L from 'leaflet';
import m from "../images/icons/camera-outline.svg"

function centeredView(myLatitude, myLongitude) {
    return L.map('map').setView([myLatitude, myLongitude], 15);
}

const defaultIcon = L.icon({
    iconUrl: m,
    iconSize: [40, 50],
    iconAnchor: [2, 2],
    popupAnchor: [0, -2]
});

function oneArt(id) {
    //call a la route
    fetch('/getArtCoordinates/' + id)
        .then(response => response.json())
        .then(data => {
            //Recuperation de latitude et longitude dans le controller
            const {latitude, longitude} = data;
            let myMap = centeredView(latitude, longitude)
            // Initialisation de la carte avec la centrée sur un point donnée avec en utilisant latitude et longitude
            L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                minZoom: 5,
                maxZoom: 20
            }).addTo(myMap)
            //L.marker([latitude, longitude]).addTo(myMap);
            L.marker([latitude, longitude], {icon: defaultIcon
            }).addTo(myMap)
            // On affiche un marker sur la carte
        })
}


if (document.getElementById("getHomeArtId") !== null) {
    let getHomeArtId = document.getElementById("getHomeArtId").value;
    oneArt(getHomeArtId)
} else {
    let getShowArtId = document.getElementById("getShowArtId").value;
    oneArt(getShowArtId)
}
