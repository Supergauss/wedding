/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';
import './main';

var jQueryBridget = require('jquery-bridget');
var Isotope = require('isotope-layout');
jQueryBridget( 'isotope', Isotope, $ );

$('.grid').isotope({
    // options
    itemSelector: '.grid-item',
    masonry: {
        columnWidth: 200
    }
});
