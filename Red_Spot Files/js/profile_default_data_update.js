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

var profilePictureUploadButton = $('#profilePictureUploadButton');
var inputFile = $('#inputFile');
var profilePictureUploadProgressDesign = $('#profilePictureUploadProgressDesign');
var profilePictureProgressBar = $('#profilePictureProgressBar');
var profilePictureParagraph = $('#profilePictureParagraph');
var profilePicture = $('#profilePicture');

extractData();

profilePictureUploadButton.on("click", function () {
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
                url: "../scripts/profilePhotoUpload.php",
                dataType: 'text',
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
                xhr: function () {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        //Set the progress bar design for the upload
                        profilePictureUploadProgressDesign.removeAttr("style");
                        profilePictureUploadProgressDesign.removeClass("progress-success");
                        profilePictureUploadProgressDesign.removeClass("progress-danger");
                        profilePictureUploadProgressDesign.removeClass("progress-primary");
                        profilePictureUploadProgressDesign.removeClass("active");
                        profilePictureUploadProgressDesign.addClass("progress-info");
                        profilePictureUploadProgressDesign.addClass("active");
                        if (myXhr.upload.addEventListener) {
                            myXhr.upload.addEventListener('progress', function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    //Update progress bar with upload value
                                    profilePictureProgressBar.attr("style", ("width: " + (percentComplete * 100).toString() + "%;").toString());
                                    profilePictureProgressBar.html((Math.round(percentComplete * 100)).toString() + "%");
                                    if (percentComplete * 100 == 100) {
                                        profilePictureUploadProgressDesign.removeClass("progress-info");
                                        profilePictureUploadProgressDesign.removeClass("progress-success");
                                        profilePictureUploadProgressDesign.removeClass("progress-danger");
                                        profilePictureUploadProgressDesign.removeClass("progress-primary");
                                        profilePictureUploadProgressDesign.removeClass("active");
                                        profilePictureUploadProgressDesign.addClass("progress-success");
                                        profilePictureProgressBar.html('File uploaded');
                                        if (filename.indexOf(" ") >= 0) {
                                            filename = filename.split("\\");
                                            filename = encodeURIComponent(filename[filename.length - 1]);
                                            profilePicture.attr("src", '../uploads/profilePics/' + filename + '');
                                            profilePictureParagraph.html('<a href="../uploads/profilePics/' + filename + '">' + decodeURIComponent(filename) + '</a>');
                                            insertData('../uploads/profilePics/' + filename);
                                        }
                                        else {
                                            var newFileName = filename.split("\\");
                                            profilePicture.attr("src", '../uploads/profilePics/' + newFileName[newFileName.length - 1] + '');
                                            profilePictureParagraph.html('<a href="../uploads/profilePics/' + newFileName[newFileName.length - 1] + '">' + newFileName[newFileName.length - 1] + '</a>');
                                            insertData('../uploads/profilePics/' + newFileName[newFileName.length - 1]);
                                        }
                                        
                                    }
                                }
                            }, false);
                        } else if (myXhr.upload.attachEvent) {
                            myXhr.upload.attachEvent('progress', function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    profilePictureProgressBar.attr("style", ("width: " + (percentComplete * 100).toString() + "%;").toString());
                                    profilePictureProgressBar.html((Math.round(percentComplete * 100)).toString() + "%");
                                    if (percentComplete * 100 == 100) {
                                        //Update progress bar with upload value
                                        profilePictureUploadProgressDesign.removeClass("progress-info");
                                        profilePictureUploadProgressDesign.removeClass("progress-success");
                                        profilePictureUploadProgressDesign.removeClass("progress-danger");
                                        profilePictureUploadProgressDesign.removeClass("progress-primary");
                                        profilePictureUploadProgressDesign.removeClass("active");
                                        profilePictureUploadProgressDesign.addClass("progress-success");
                                        profilePictureProgressBar.html('File uploaded');
                                        if (filename.indexOf(" ") >= 0) {
                                            filename = filename.split("\\");
                                            filename = encodeURIComponent(filename[filename.length - 1]);
                                            profilePicture.attr("src", '../uploads/profilePics/' + filename + '');
                                            profilePictureParagraph.html('<a href="../uploads/profilePics/' + filename + '">' + decodeURIComponent(filename) + '</a>');
                                            insertData('../uploads/profilePics/' + filename);
                                        }
                                        else {
                                            var newFileName = filename.split("\\");
                                            profilePicture.attr("src", '../uploads/profilePics/' + newFileName[newFileName.length - 1] + '');
                                            profilePictureParagraph.html('<a href="../uploads/profilePics/' + newFileName[newFileName.length - 1] + '">' + newFileName[newFileName.length - 1] + '</a>');
                                            insertData('../uploads/profilePics/' + newFileName[newFileName.length - 1]);
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
                                profilePictureUploadProgressDesign.removeClass("progress-info");
                                profilePictureUploadProgressDesign.removeClass("progress-success");
                                profilePictureUploadProgressDesign.removeClass("progress-danger");
                                profilePictureUploadProgressDesign.removeClass("progress-primary");
                                profilePictureUploadProgressDesign.removeClass("active");
                                profilePictureUploadProgressDesign.addClass("progress-danger");
                                profilePictureProgressBar.html('File could not be uploaded. File size exceeded.');
                                profilePictureParagraph.html("<p>File size exceeded.</p>");
                            }
                            else if (responseObject.msg.toString() == "The file already exists.") {
                                //Update progress bar with upload value
                                profilePictureUploadProgressDesign.removeClass("progress-info");
                                profilePictureUploadProgressDesign.removeClass("progress-success");
                                profilePictureUploadProgressDesign.removeClass("progress-danger");
                                profilePictureUploadProgressDesign.removeClass("progress-primary");
                                profilePictureUploadProgressDesign.removeClass("active");
                                profilePictureUploadProgressDesign.addClass("progress-danger");
                                profilePictureProgressBar.html('File could not be uploaded. It already exists.');
                                profilePictureParagraph.html("<p>File already exists.</p>");
                            }
                            else if (responseObject.msg.toString() == "There was an error while trying to upload the file.") {
                                //Update progress bar with upload value
                                profilePictureUploadProgressDesign.removeClass("progress-info");
                                profilePictureUploadProgressDesign.removeClass("progress-success");
                                profilePictureUploadProgressDesign.removeClass("progress-danger");
                                profilePictureUploadProgressDesign.removeClass("progress-primary");
                                profilePictureUploadProgressDesign.removeClass("active");
                                profilePictureUploadProgressDesign.addClass("progress-danger");
                                profilePictureProgressBar.html('File could not be uploaded. Please contact administrator and ask to change folder permissions.');
                                profilePictureParagraph.html("<p>Please contact administrator and ask to change folder permissions.</p>");
                            }
                        }
                    });
        }
    }
    else {
        alert('The selected file is not supported, please choose a PDF, XLS, or XLSX document');
    }
});

function insertData(profilePicture) {
    var theInformation = {"username": theCurrentUser, "profilePicture": profilePicture};
    alert(profilePicture);
        //AJAX request
        $.ajax({
            method: "POST",
            url: "../scripts/profile_default_data_update_functions.php",
            data: {theFunction: "profilePictureUpload", theData: JSON.stringify(theInformation)}
        })
                .done(function (response) {

                });
        //AJAX request END
}

function extractData(){
    var theInformation = {"username": theCurrentUser};
    //AJAX request
        $.ajax({
            method: "POST",
            url: "../scripts/profile_default_data_update_functions.php",
            data: {theFunction: "getProfilePicture", theData: JSON.stringify(theInformation)}
        })
                .done(function (response) {
                    var profilePictureObject = JSON.parse(response);
                     profilePicture.attr("src", profilePictureObject.profilePicture);
                });
        //AJAX request END
}
