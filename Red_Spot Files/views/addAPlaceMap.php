<!DOCTYPE html>
<?php
session_start();
?>
<html><head>
        <meta charset="utf-8">
        <title>Place Establishment</title>
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../jquery-ui-1.11.4/jquery-ui.min.css">
        <script src="../jquery-ui-1.11.4/jquery-ui.min.js"></script>
        <!-- Bootstrap -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <meta charset="UTF-8">
        <!-- Bootstrap Core CSS -->
        <link href="../css/lavish-bootstrap.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../css/landing-page.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
        <!-- jQuery -->
        <script src="../js/bootstrap3-typeahead.min.js"></script>
        <style type="text/css">
            html, body { height: 100%; margin: 0; padding: 0; }
            #map { height: 50%; }
  .scale {
                width: 2em;
                height: 2em;
                text-align: center;
                line-height: 2em;
                border-radius: 2em;
                background: white;
                border: 0.3em solid #94221C;
                margin: 0 1em;
                display: inline-block;
                color: black;
                position: relative;
                cursor: pointer; 
                cursor: hand;
              }
              
              .scale::before{
                content: '';
                position: absolute;
                top: .6em;
                left: -4em;
                width: 4em;
                height: .2em;
                background: #94221C;
                z-index: -1;
              }


              .scale:first-child::before {
                display: none;
              }

              .active.scale {
                  background: lightblue;
              }

              .active ~ .scale::before{
                background: #94221C;
              }
              textarea{
                resize: none;
              }
        </style>
    </head><body>
        <script type="text/javascript">
        var theCurrentUser = "<?php echo $_SESSION['Username'] ?>";
        </script>
        <div class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><span>Red Spot</span></a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                        <ul class="nav navbar-form navbar-left">
                            <input class="form-control typeahead" type="text" placeholder="Search spotters" data-provide="typeahead" autocomplete="off">
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active">
                                <a href="userHome.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;Home</a>
                            </li>
                            <li>
                                <a href="profile.php" id="userHomeProfileLink"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;<?php echo $_SESSION['Username'] ?></a>
                            </li>
                            <li>
                                <a href="#"><span class="glyphicon glyphicon-bell" aria-hidden="true"></span>&nbsp;&nbsp;Notifications&nbsp;&nbsp;<span class="badge">0</span></a>
                            </li>
                            <li>
                                <a href="#" id="logoutButton">Logout</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        <div id="map"></div>
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Current Location:</h3>
                        <div id="currentLocationWell">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="whatLocationRadioButton" id="currentLocationRadioButton">Use current location</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Lat</span>
                                <input id="currentLatitudeInput" type="text" class="form-control" placeholder="Latitude" aria-describedby="basic-addon1" disabled="">
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Lon</span>
                                <input id="currentLongitudeInput" type="text" class="form-control" placeholder="Longitude" aria-describedby="basic-addon1" disabled="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>Custom selection of location:</h3>
                        <div class="radio">
                            <label>
                                <input type="radio" name="whatLocationRadioButton" id="customLocationRadioButton">Use custom location</label>
                        </div>
                        <div id="userSelectedPlaceWell">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Lat</span>
                                <input id="markerLatitudeInput" type="text" class="form-control" placeholder="Latitude" aria-describedby="basic-addon1" disabled="">
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Lon</span>
                                <input id="markerLongitudeInput" type="text" class="form-control" placeholder="Longitude" aria-describedby="basic-addon1" disabled="">
                            </div>
                            <br>
                            <p>Click anywhere to place a marker and get the corresponding latitude and
                                longitude</p>
                        </div>
                    </div>
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
                        <label for="establishmentNameInput">Review:</label>
                        <br>
                        <div class="row">
                            <ul id="establishmentScale" style="position:relative; left: -20px;">
                             <li class="scale">
                                 <a style="position: absolute; top: -5px; left: 5px;">1</a>
                             </li>
                             <li class="scale">
                                 <a style="position: absolute; top: -5px; left: 6px;">2</a>
                             </li>
                             <li class="scale">
                                 <a style="position: absolute; top: -5px; left: 6px;">3</a>
                             </li>
                             <li class="scale">
                                 <a style="position: absolute; top: -5px; left: 5.5px;">4</a>
                             </li>
                             <li class="scale">
                                 <a style="position: absolute; top: -5px; left: 6px;">5</a>
                             </li>
                         </ul>
                            <button class="btn btn-xs btn-primary" type="button" id="establishmentScaleClearButton">Clear</button>
                            
                        </div>
                        <br>
                        <textarea rows="4" placeholder="What do you think of this place?" id="establishmentReview" style="width: 30%;"></textarea>
                    </div>
                    <div class="col-md-12 text-center">
                        <img id="establishmentPicture" src="" alt="Establishment Picture" class="img-responsive center-block" style="max-width: 640px; max-height: 480px;">
                    </div>
                    <div class="form-group">
                        <label for="inputPicture">Upload a picture</label>
                        <div>
                            <a class="btn btn-success" id="addAPictureUploadButton">Add a Picture</a>
                            <br>
                            <br>
                        </div>
                        <input type="file" accept=".jpg, .jpeg, .png, .gif" id="inputFile" name="inputFile" class="btn btn-success" style="display: none">
                        <div style="display: none" class="active progress progress-striped" id="addAPictureUploadProgressDesign">
                            <div class="bar" style="width: 0%;" id="addAPictureProgressBar"></div>
                            <br>
                            <br>
                        </div>
                    </div>
                    <a class="btn btn-primary" id="submitReviewButton">Submit review</a>
                </form>
                <br><br>
            </div>
        </div>
        <script type="text/javascript">
            var map;
            var markers = [];
            var useCurrentLocationButton = $('#useCurrentLocationButton');
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 18.207851, lng: -66.522963},
                    zoom: 8
                });
                var infoWindow = new google.maps.InfoWindow({map: map});
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
                var marker = new google.maps.Circle({map: map,
                    radius: 100,
                    center: location,
                    fillColor: '#777',
                    fillOpacity: 0.1,
                    strokeColor: '#AA0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    draggable: true, // Dragable
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
        <script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS1BgbDZPl2E3wT1-31XClidfG3b2Z2nY&amp;callback=initMap">
        </script>
        <script src="../js/add_a_place_map.js"></script>
        <script src="../js/logout_script.js"></script>
        <script src="../js/search_spotters.js"></script>
    </body></html>