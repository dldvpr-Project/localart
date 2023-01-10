// On initialise la latitude et la longitude de Paris (centre de la carte)
import * as L from 'leaflet';


// Call à la route /home-api
fetch('/home-api')
    .then(response => response.json())
    .then(data => {
        //Recuperation de latitude et longitude
        let latitude = data.latitude;
        let longitude = data.longitude;

        // Initialisation de la carte
        let myMap = L.map('map').setView([latitude, longitude], 15);
        // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
        L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
            // Il est toujours bien de laisser le lien vers la source des données
            attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
            minZoom: 1,
            maxZoom: 20
        }).addTo(myMap);
        // On affiche un marker sur la carte
        let marker = L.marker([latitude, longitude]).addTo(myMap)
    });
