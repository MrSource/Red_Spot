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
            textarea{
                resize: none;
            }
        </style>
    </head><body>
        <script type="text/javascript">
            var theCurrentUser = "<?php echo $_SESSION['Username'] ?>";
            var userRole = "<?php echo $_SESSION['Role'] ?>";
        </script>
        <!-- Navigation -->
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
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <p class="lead">Establishment Information</p>
                    <form role="form">
                        <div class="form-group">
                            <label class="control-label" for="establishmentNameInput">Establishment Name</label>
                            <input class="form-control" id="establishmentNameInput" placeholder="Establishment Name" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="operatingHoursInput">Operating Hours:</label>
                            <input class="form-control" id="operatingHoursInput" placeholder="8:00 AM - 5:00 PM" type="text">
                        </div>
                    </form>
                    <form class="form-inline">
                        <p>Parking:</p>
                        <label class="radio-inline">
                            <input type="radio" name="parkingRadioOptions" id="parkingRadioOptionYes" value="option1">Yes</label>
                        <label class="radio-inline">
                            <input type="radio" name="parkingRadioOptions" id="parkingRadioOptionNo" value="option2">No</label>
                    </form>
                    <form role="form">
                        <div class="form-group">
                            <label>Establishment Information:</label>
                            <textarea id="establishmentInformation" rows="8" placeholder="Write a description about your establishment for your clients to see."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Category:</label>
                            <input class="form-control" placeholder="Restaurant, Bar/Pop" id="categoryInput" type="text">
                        </div>
                        <div class="form-group">
                            <label>Telephone:</label>
                            <input id="telephoneInput" type="text" class="form-control" placeholder="787-555-5000">
                        </div>
                        <div class="form-group">
                            <a href="#" data-target="#selectLocationModal" data-toggle="modal" class="btn btn-primary">Select establishment location</a>
                            <br>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Lat</span>
                                <input id="selectedLatitudeInput" type="text" class="form-control" placeholder="Latitude" aria-describedby="basic-addon1" disabled="">
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Lon</span>
                                <input id="selectedLongitudeInput" type="text" class="form-control" placeholder="Longitude" aria-describedby="basic-addon1" disabled="">
                            </div>
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
                    </form>
                </div>
                <div class="col-md-9">
                    <div class="thumbnail">
                        <img src="http://placehold.it/800x300" alt="" id="establishmentPicture" class="img-responsive">
                        <div class="caption-full">
                            <h4>
                                <p id="establishmentNameParagraph"></p>
                            </h4>
                            <p id="establishmentInformationParagraph"></p>
                            <p id="operatingHoursParagraph"></p>
                            <p id="parkingParagraph"></p>
                            <p id="categoryParagraph"></p>
                            <p id="telephoneParagraph"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container -->
        <div class="container">
            <hr>
            <a class="btn btn-success pull-right" id="addEstablishmentButton">Submit</a>
        </div>
        <!-- /.container -->
        <div class="modal fade" id="selectLocationModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Establishment Location</h4>
                    </div>
                    <div class="modal-body">
                        <p>Select the place where the establishment is located:</p>
                        <div id="map"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <h3>Custom location:</h3>
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
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">Close</a>
                    </div>
                </div>
            </div>
        </div>
        <script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS1BgbDZPl2E3wT1-31XClidfG3b2Z2nY&amp;callback=initMap">
        </script>
        <script src="../js/existing_establishment.js"></script>
    </body></html>