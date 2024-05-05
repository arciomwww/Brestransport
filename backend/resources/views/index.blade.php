<!DOCTYPE html>
<html>
<head>
    <title>БресТранспорт</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        #map {
            width: 1215px;
            height: 552px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div id="map"></div>
<div id="show__popup"></div>

<script src="{{ asset('js/script.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS2h9uH4kS9814ij58Sz9Lu5nY1PRbVaI&callback=initMap"
        async
        defer></script>
</body>
</html>
