/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';
import './main';
var Masonry = require('masonry-layout');


$(function() {
    console.log( "ready!" );
    var msnry = new Masonry( '.grid', {
        itemSelector: '.grid-item',
        columnWidth: '.grid-sizer',
        percentPosition: true
    });

    console.log(msnry);
});