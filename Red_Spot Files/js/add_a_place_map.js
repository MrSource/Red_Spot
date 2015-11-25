/* 
 * Copyright 2015 Red Spot.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

//Variables of the HTML elements
var whatLocationRadioButton = $("#whatLocationRadioButton");
var currentLatitudeInput = $("#currentLatitudeInput");
var currentLongitudeInput = $("#currentLongitudeInput");
var currentLocationRadioButton = $("#currentLocationRadioButton");
var customLocationRadioButton = $("#customLocationRadioButton");
var markerLatitudeInput = $("#markerLatitudeInput");
var markerLongitudeInput = $("#markerLongitudeInput");
var establishmentNameInput = $("#establishmentNameInput");
var establishmentReview = $("#establishmentReview");
var establishmentPicture = $("#establishmentPicture");
var addAPictureUploadButton = $("#addAPictureUploadButton");
var inputFile = $("#inputFile");
var addAPictureUploadProgressDesign = $("#addAPictureUploadProgressDesign");
var addAPictureProgressBar = $("#addAPictureProgressBar");
var submitReviewButton = $('#submitReviewButton');
var establishmentScaleClearButton = $('#establishmentScaleClearButton');

//Variable to store the picture url
var pictureURL = "";

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
                url: "../scripts/establishmentPictureUpload.php",
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
                                            establishmentPicture.attr("src", '../uploads/establishmentPics/' + filename + '');
                                            pictureURL = '../uploads/establishmentPics/' + filename;
                                        }
                                        else {
                                            var newFileName = filename.split("\\");
                                            establishmentPicture.attr("src", '../uploads/establishmentPics/' + newFileName[newFileName.length - 1] + '');
                                            pictureURL = '../uploads/establishmentPics/' + newFileName[newFileName.length - 1];
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
                                            establishmentPicture.attr("src", '../uploads/establishmentPics/' + filename + '');
                                            pictureURL = '../uploads/establishmentPics/' + filename;
                                        }
                                        else {
                                            var newFileName = filename.split("\\");
                                            establishmentPicture.attr("src", '../uploads/establishmentPics/' + newFileName[newFileName.length - 1] + '');
                                            pictureURL = '../uploads/establishmentPics/' + newFileName[newFileName.length - 1];
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
                                profilePictureParagraph.html("<p>File already exists.</p>");
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
                                profilePictureParagraph.html("<p>Please contact administrator and ask to change folder permissions.</p>");
                            }
                        }
                    });
        }
    }
    else {
        alert('The selected file is not supported, please choose a JPG, JPEG, PNG or GIF picture');
    }
});

submitReviewButton.on("click", function () {
    //Get latitude and longitude
    var latitude = 0.0;
    var longitude = 0.0;
    if (currentLocationRadioButton.is(":checked")) {
        latitude = currentLatitudeInput.val();
        longitude = currentLongitudeInput.val();
    }
    else if (customLocationRadioButton.is(":checked")) {
        latitude = markerLatitudeInput.val();
        longitude = markerLongitudeInput.val();
    }

    //Get establishment name
    var establishmentName = establishmentNameInput.val();
    //Get review
    var review = establishmentReview.val();
    var scale = 0;
    //Let's fill our data into variables if we can
    //Count for the last active of establishment scale
    $("#establishmentScale li.active").each(function (index) {
        switch (index) {
            case 0:
                scale = 1;
                break;
            case 1:
                scale = 2;
                break;
            case 2:
                scale = 3;
                break;
            case 3:
                scale = 4;
                break;
            case 4:
                scale = 5;
                break;
        }
    });
    var theInformation = {"username": theCurrentUser, "latitude": latitude, "longitude": longitude, "establishmentName": establishmentName,
        "review": review, "scale": scale};

    //Check if the user uploaded a picture, in which case let's add it and call the corresponding ajax
    if ($.trim(pictureURL)) {
        theInformation['photo'] = pictureURL;
        $.ajax({
            url: "../scripts/add_a_place_map.php",
            data: {theFunction: "addEstablishmentLocationWithPicture", theData: JSON.stringify(theInformation)},
            method: "POST"
        }).done(function (response) {
            if (response.indexOf("Success") > -1) {
                alert("Spot review added!");
                window.location.replace("userHome.php");
            }
        });
    }
    else {
        $.ajax({
            url: "../scripts/add_a_place_map.php",
            data: {theFunction: "addEstablishmentLocation", theData: JSON.stringify(theInformation)},
            method: "POST"
        }).done(function (response) {
            if (response.indexOf("Success") > -1) {
                alert("Spot review added!");
                window.location.replace("userHome.php");
            }
        });
    }
});

$('#establishmentScale li').click(function () {
    $(this).removeClass("active");
    $(this).addClass("active");
    var lastActiveIndex = 0;
    var justActivatedIndex = $(this).index();
    //Get the last element with active class
    lastActiveIndex = $("li.active", $("#establishmentScale")).last().index();
    //Activate all circles before the last clicked element
    $("#establishmentScale li").each(function (index) {
        if ($(this).index() <= lastActiveIndex) {
            $(this).removeClass("active");
            $(this).addClass("active");
        }
        if ($(this).index() > justActivatedIndex) {
            $(this).removeClass("active");
        }
    });
});

establishmentScaleClearButton.on("click", function () {
    //Clear all circles values
    $(("#establishmentScale li").toString()).each(function (index) {
        $(this).removeClass("active");
    });
});