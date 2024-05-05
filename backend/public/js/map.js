import { Loader } from "@googlemaps/js-api-loader";

const loader = new Loader({
    apiKey: 'AIzaSyAS2h9uH4kS9814ij58Sz9Lu5nY1PRbVaI',
    version: 'weekly'
})

loader.load().then(async () => {
    const { Map } = await google.maps.importLibrary("maps");
    let map = new Map(document.getElementById("map"), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 8,
    });
});
