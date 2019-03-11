let grid = require('./vendor/grid');
require('./vendor/globe');

let globe;

let data = JSON.parse($("#globe").attr('data-visits'));

function createGlobe() {
    const contWidth = $('.c-link-header__globe').width() - 40;
    var newData = [];
    globe = new ENCOM.Globe(contWidth, contWidth, {
        font: "Raleway",
        //data: newData, // copy the data array
        data: data,
        tiles: grid.tiles,
        baseColor: "#000",
        dayLength: 28000,
        introLinesDuration: 2000,
        markerColor: "#ffcc00",
        maxMarkers: 50,
        maxPins: 500,
        pinColor: "#8FD8D8",
        satelliteColor: "#ff0000",
        scale: 1,
        viewAngle: 0.1
    });
    $("#globe").append(globe.domElement);
    globe.init();
}

function animate() {
    if (globe) {
        globe.tick();
    }
    lastTickTime = Date.now();
    requestAnimationFrame(animate);
}

createGlobe();
animate();
