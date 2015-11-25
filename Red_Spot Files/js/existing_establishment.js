//HTML elements
var establishmentNameInput = $("#establishmentNameInput");
var operatingHoursInput = $("#operatingHoursInput");
var parkingRadioOptionYes = $("#parkingRadioOptionYes");
var parkingRadioOptionNo = $("#parkingRadioOptionNo");
var establishmentInformation = $("#establishmentInformation");
var categoryInput = $("#categoryInput");
var selectedLatitudeInput = $("#selectedLatitudeInput");
var selectedLongitudeInput = $("#selectedLongitudeInput");
var addAPictureUploadButton = $("#addAPictureUploadButton");
var addAPictureUploadProgressDesign = $("#addAPictureUploadProgressDesign");
var addAPictureProgressBar = $("#addAPictureProgressBar");
var establishmentPicture = $("#establishmentPicture");
var establishmentNameParagraph = $("#establishmentNameParagraph");
var operatingHoursParagraph = $("#operatingHoursParagraph");
var parkingParagraph = $("#parkingParagraph");
var categoryParagraph = $("#categoryParagraph");
var telephoneParagraph = $("#telephoneParagraph");
var establishmentInformationParagraph = $("#establishmentInformationParagraph");
var selectLocationModal = $("#selectLocationModal");
var currentLocationRadioButton = $("#currentLocationRadioButton");
var currentLatitudeInput = $("#currentLatitudeInput");
var currentLongitudeInput = $("#currentLongitudeInput");
var customLocationRadioButton = $("#customLocationRadioButton");
var markerLatitudeInput = $("#markerLatitudeInput");
var markerLongitudeInput = $("#markerLongitudeInput");
var telephoneInput = $('#telephoneInput');
var inputFile = $('#inputFile');
var addEstablishmentButton = $('#addEstablishmentButton');

var pictureURL = "";

establishmentNameInput.on("keyup", function () {
    establishmentNameParagraph.html($(this).val());
});
operatingHoursInput.on("keyup", function () {
    operatingHoursParagraph.html($(this).val());
});
establishmentInformation.on("keyup", function () {
    establishmentInformationParagraph.html($(this).val());
});
categoryInput.on("keyup", function () {
    categoryParagraph.html($(this).val());
});
telephoneInput.on("keyup", function () {
    telephoneParagraph.html($(this).val());
});

parkingRadioOptionYes.on("change", function () {
    if ($(this).is(":checked")) {
        parkingParagraph.html("Parking: Yes");
    }
});

parkingRadioOptionNo.on("change", function () {
    if ($(this).is(":checked")) {
        parkingParagraph.html("Parking: No");
    }
});

currentLocationRadioButton.on("change", function () {
    if ($(this).is(":checked")) {
        selectedLatitudeInput.val(currentLatitudeInput.val());
        selectedLongitudeInput.val(currentLongitudeInput.val());
    }
});

customLocationRadioButton.on("change", function () {
    if ($(this).is(":checked")) {
        selectedLatitudeInput.val(markerLatitudeInput.val());
        selectedLongitudeInput.val(markerLongitudeInput.val());
    }
});

/*************************************************************************************
 ********************************* Map code ******************************************
 *************************************************************************************/
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

// Resize map to show on a Bootstrap's modal
selectLocationModal.on('shown.bs.modal', function () {
    var currentCenter = map.getCenter();  // Get current center before resizing
    google.maps.event.trigger(map, "resize");
    map.setCenter(currentCenter); // Re-set previous center
});
/*************************************************************************************
 ******************************* Map code END ****************************************
 *************************************************************************************/

/*************************************************************************************
 ******************************* Upload picture code *********************************
 *************************************************************************************/
addAPictureUploadButton.on("click", function () {
    inputFile.trigger('click');
});

//Delegate file selection events (only once)
inputFile.change(function () {
    var filename = inputFile.val();
    if (/\.jpg$/.test(filename) || /\.jpeg$/.test(filename) || /\.png$/.test(filename) || /\.gif$/.test(filename)) {
        var file;
        var file = inputFile[0].files[0];
        var theSize = file.size;
        if (theSize > 5242880) {
            alert("The file size exceeds the 5MB limit. Please try uploading a smaller file.")
        }
        else {
            var formData = new FormData();
            formData.append('file', file);
            $.ajax({
                type: "POST",
                url: "../scripts/establishmentOwnerPictureUpload.php",
                dataType: 'text',
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
                xhr: function () {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        //Set the progress bar design for the upload
                        addAPictureUploadProgressDesign.removeAttr("style");
                        addAPictureUploadProgressDesign.removeClass("progress-success");
                        addAPictureUploadProgressDesign.removeClass("progress-danger");
                        addAPictureUploadProgressDesign.removeClass("progress-primary");
                        addAPictureUploadProgressDesign.removeClass("active");
                        addAPictureUploadProgressDesign.addClass("progress-info");
                        addAPictureUploadProgressDesign.addClass("active");
                        if (myXhr.upload.addEventListener) {
                            myXhr.upload.addEventListener('progress', function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    //Update progress bar with upload value
                                    addAPictureProgressBar.attr("style", ("width: " + (percentComplete * 100).toString() + "%;").toString());
                                    addAPictureProgressBar.html((Math.round(percentComplete * 100)).toString() + "%");
                                    if (percentComplete * 100 == 100) {
                                        addAPictureUploadProgressDesign.removeClass("progress-info");
                                        addAPictureUploadProgressDesign.removeClass("progress-success");
                                        addAPictureUploadProgressDesign.removeClass("progress-danger");
                                        addAPictureUploadProgressDesign.removeClass("progress-primary");
                                        addAPictureUploadProgressDesign.removeClass("active");
                                        addAPictureUploadProgressDesign.addClass("progress-success");
                                        addAPictureProgressBar.html('File uploaded');
                                        if (filename.indexOf(" ") >= 0) {
                                            filename = filename.split("\\");
                                            filename = encodeURIComponent(filename[filename.length - 1]);
                                            establishmentPicture.attr("src", '../uploads/establishmentOwnerPics/' + filename + '');
                                            pictureURL = '../uploads/establishmentOwnerPics/' + filename;
                                        }
                                        else {
                                            var newFileName = filename.split("\\");
                                            establishmentPicture.attr("src", '../uploads/establishmentOwnerPics/' + newFileName[newFileName.length - 1] + '');
                                            pictureURL = '../uploads/establishmentOwnerPics/' + newFileName[newFileName.length - 1];
                                        }

                                    }
                                }
                            }, false);
                        } else if (myXhr.upload.attachEvent) {
                            myXhr.upload.attachEvent('progress', function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    addAPictureProgressBar.attr("style", ("width: " + (percentComplete * 100).toString() + "%;").toString());
                                    addAPictureProgressBar.html((Math.round(percentComplete * 100)).toString() + "%");
                                    if (percentComplete * 100 == 100) {
                                        //Update progress bar with upload value
                                        addAPictureUploadProgressDesign.removeClass("progress-info");
                                        addAPictureUploadProgressDesign.removeClass("progress-success");
                                        addAPictureUploadProgressDesign.removeClass("progress-danger");
                                        addAPictureUploadProgressDesign.removeClass("progress-primary");
                                        addAPictureUploadProgressDesign.removeClass("active");
                                        addAPictureUploadProgressDesign.addClass("progress-success");
                                        addAPictureProgressBar.html('File uploaded');
                                        if (filename.indexOf(" ") >= 0) {
                                            filename = filename.split("\\");
                                            filename = encodeURIComponent(filename[filename.length - 1]);
                                            establishmentPicture.attr("src", '../uploads/establishmentOwnerPics/' + filename + '');
                                            pictureURL = '../uploads/establishmentOwnerPics/' + filename;
                                        }
                                        else {
                                            var newFileName = filename.split("\\");
                                            establishmentPicture.attr("src", '../uploads/establishmentOwnerPics/' + newFileName[newFileName.length - 1] + '');
                                            pictureURL = '../uploads/establishmentOwnerPics/' + newFileName[newFileName.length - 1];
                                        }

                                    }
                                }
                            });
                        }
                    }
                    return myXhr;
                }
            })
                    .done(function (response) {
                        var responseObject = JSON.parse(response);
                        if (responseObject.msg != null && responseObject.msg != undefined) {
                            console.log(responseObject.msg);
                            if (responseObject.msg.toString() == "File size exceeded") {
                                //Update progress bar with upload value
                                addAPictureUploadProgressDesign.removeClass("progress-info");
                                addAPictureUploadProgressDesign.removeClass("progress-success");
                                addAPictureUploadProgressDesign.removeClass("progress-danger");
                                addAPictureUploadProgressDesign.removeClass("progress-primary");
                                addAPictureUploadProgressDesign.removeClass("active");
                                addAPictureUploadProgressDesign.addClass("progress-danger");
                                addAPictureProgressBar.html('File could not be uploaded. File size exceeded.');
                                profilePictureParagraph.html("<p>File size exceeded.</p>");
                            }
                            else if (responseObject.msg.toString() == "The file already exists.") {
                                //Update progress bar with upload value
                                addAPictureUploadProgressDesign.removeClass("progress-info");
                                addAPictureUploadProgressDesign.removeClass("progress-success");
                                addAPictureUploadProgressDesign.removeClass("progress-danger");
                                addAPictureUploadProgressDesign.removeClass("progress-primary");
                                addAPictureUploadProgressDesign.removeClass("active");
                                addAPictureUploadProgressDesign.addClass("progress-danger");
                                addAPictureProgressBar.html('File could not be uploaded. It already exists.');
                            }
                            else if (responseObject.msg.toString() == "There was an error while trying to upload the file.") {
                                //Update progress bar with upload value
                                addAPictureUploadProgressDesign.removeClass("progress-info");
                                addAPictureUploadProgressDesign.removeClass("progress-success");
                                addAPictureUploadProgressDesign.removeClass("progress-danger");
                                addAPictureUploadProgressDesign.removeClass("progress-primary");
                                addAPictureUploadProgressDesign.removeClass("active");
                                addAPictureUploadProgressDesign.addClass("progress-danger");
                                addAPictureProgressBar.html('File could not be uploaded. Please contact administrator and ask to change folder permissions.');
                            }
                        }
                    });
        }
    }
    else {
        alert('The selected file is not supported, please choose a JPG, JPEG, PNG or GIF picture');
    }
});
/*************************************************************************************
 ***************************** Upload picture code END *******************************
 *************************************************************************************/

addEstablishmentButton.on("click", function () {
    var establishmentName = "";
    var schedule = "";
    var parking = -1;
    var information = "";
    var telephone = "";
    var category = "";
    var latitude = 0;
    var longitude = 0;
    var photo = "";
    var 
    //Get the data if available
    establishmentName = establishmentNameInput.val();
    schedule = operatingHoursInput.val();
    if(parkingRadioOptionYes.is(":checked")) parking = 1;
    if(parkingRadioOptionNo.is(":checked")) parking = 0;
    telephone = telephoneInput.val();
    category = categoryInput.val();
    latitude = selectedLatitudeInput.val();
    longitude = selectedLongitudeInput.val();
    photo = pictureURL;
    var theInformation = {"username": theCurrentUser, "establishmentName": establishmentName,
        "schedule": schedule,
        "parking": parking,
        "information": information,
        "telephone": telephone,
        "category": category,
        "latitude": latitude,
        "longitude": longitude,
        "photo": photo};

    $.ajax({
        url: "../scripts/existing_establishment.php",
        method: "POST",
        data: {theFunction: "addEstablishment", theData: JSON.stringify(theInformation)}
    }).done(function (response) {
        console.log(response);
        if (response.indexOf("Success") > -1) {
            alert("Establishment added!");
             window.location.replace("userHome.php");
        }
    });
});