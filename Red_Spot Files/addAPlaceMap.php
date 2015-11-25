<?php

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <style type="text/css">
          html, body { height: 100%; margin: 0; padding: 0; }
          #map { height: 50%; }
        </style>
        <meta charset="utf-8" />
        <title>Place Establishment</title>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="jquery-ui-1.11.4/jquery-ui.css">
        <script src="jquery-ui-1.11.4/jquery-ui.js"></script>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="map"></div>
        <div id="accordion">
        <h3>Current Location:</h3>
        <div id="currentLocationWell">
            <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
            <button type="button" class="btn btn-primary" id="useCurrentLocationButton">Use current location</button>
            <br>
            <br>
            <div class="row">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1">Lat</span>
                  <input id="currentLatitudeInput" type="text" class="form-control" placeholder="Latitude" aria-describedby="basic-addon1" disabled>
                </div>
                <br>
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1">Lon</span>
                  <input id="currentLongitudeInput" type="text" class="form-control" placeholder="Longitude" aria-describedby="basic-addon1" disabled>
                </div>
            </div>
        </div>
        <h3>Custom selection of location:</h3>
        <div id="userSelectedPlaceWell">
            <p>Click anywhere to place a marker and get the corresponding latitude and longitude</p>
            <div class="row text-center">
                <p class="text-center">Marker Location:</p>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Lat</span>
                    <input id="markerLatitudeInput" type="text" class="form-control" placeholder="Latitude" aria-describedby="basic-addon1" disabled>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">Lon</span>
                    <input id="markerLongitudeInput" type="text" class="form-control" placeholder="Longitude" aria-describedby="basic-addon1" disabled>
                </div>
                <br>
                <button type="button" class="btn btn-primary" id="useMarkerLocationButton">Use selected location</button>
            </div>
        </div>
            </div>
        <div class="container">
            <div class="row centered text-center">
                <form>
                  <div class="form-group">
                    <label for="establishmentNameInput">Establishment Name:</label>
                    <input type="text" class="form-control" id="establishmentNameInput" placeholder="Establishment Name">
                  </div>
                    <div class="form-group">
                    <label for="establishmentNameInput">Review:</label><br>
                    <textarea rows="4" placeholder="What do you think of this place?" id="establishmentReview" style="width: 30%;"></textarea>
                    </div>
                  <div class="form-group">
                    <label for="inputPicture">Upload a picture</label>
                    <input type="file" id="inputPicture">
                  </div>
                  <button type="submit" class="btn btn-default">Submit review</button>
                </form>
            </div>
        </div>
        <script>
              $(function() {
                $( "#accordion" ).accordion();
              });
        </script>
        <script type="text/javascript">
            var map;
            var markers = [];
            var useCurrentLocationButton = $('#useCurrentLocationButton');
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: { lat: 18.207851, lng: -66.522963 },
                    zoom: 8
                });
                var infoWindow = new google.maps.InfoWindow({ map: map });
                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        infoWindow.setPosition(pos);
                        infoWindow.setContent('Your current location.');
                        //Make the well visible
                        $('#currentLocationWell').removeAttr("style");
                        //Fill the current latitude and longitude data
                        $('#currentLatitudeInput').val(pos.lat);
                        $('#currentLongitudeInput').val(pos.lng);

                    }, function () {
                        handleLocationError(true, infoWindow, map.getCenter());
                    });
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                }

                //When the user clicks the map
                map.addListener('click', function (event) {
                    clearMarkers();
                    deleteMarkers();
                    addMarker(event.latLng);
                    //Fill the marked latitude and longitude data
                    $('#markerLatitudeInput').val(event.latLng.lat());
                    $('#markerLongitudeInput').val(event.latLng.lng());
                });
            }
            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                                    'Error: The Geolocation service failed.' :
                                    'Error: Your browser doesn\'t support geolocation.');
            }

            // Adds a marker to the map and push to the array.
            function addMarker(location) {
                var marker = new google.maps.Circle({ map: map,
                        radius: 100,
                        center: location,
                        fillColor: '#777',
                        fillOpacity: 0.1,
                        strokeColor: '#AA0000',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        draggable: true,    // Dragable
                        editable: true      // Resizable
                    });
                markers.push(marker);
            }

            // Sets the map on all markers in the array.
            function setMapOnAll(map) {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(map);
                }
            }

            // Removes the markers from the map, but keeps them in the array.
            function clearMarkers() {
                setMapOnAll(null);
            }

            // Shows any markers currently in the array.
            function showMarkers() {
                setMapOnAll(map);
            }

            // Deletes all markers in the array by removing references to them.
            function deleteMarkers() {
                clearMarkers();
                markers = [];
            }
        </script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS1BgbDZPl2E3wT1-31XClidfG3b2Z2nY&callback=initMap">
        </script>
    </body>
</html>