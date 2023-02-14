/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import './scripts/openStreetMap'
import './scripts/rotateArtistCard'
import './scripts/scrollButton'

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
import 'bootstrap'
require('bootstrap');

import '../node_modules/@fortawesome/fontawesome-free/css/all.min.css'
import '../node_modules/leaflet/dist/leaflet.css';