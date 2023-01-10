import * as L from 'leaflet';

function centeredView(myLatitude, myLongitude) {
    return L.map('map').setView([myLatitude, myLongitude], 15);
}

function oneArt(apiUrl) {
    //call a la route
    fetch(apiUrl)
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
                .addLayer(L.marker([latitude, longitude]));
            // On affiche un marker sur la carte
        })
}
// Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
window.onload = function () {
    oneArt('/oneArt/' + id);
}
