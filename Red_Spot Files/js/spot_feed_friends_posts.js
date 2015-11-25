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

//Variables containing the HTML elements
var firendSpotFeedWithPhotoWellsContainer = $('#firendSpotFeedWithPhotoWellsContainer');
var friendSpotFeedWithoutPhotoWellsContainer = $('#friendSpotFeedWithoutPhotoWellsContainer');
var friendFeedCount = 0;

//Extract the spot feed
extractSpotFeed();

function extractSpotFeed() {
    var theInformation = JSON.stringify({"username": theCurrentUser});

    //AJAX request
    $.ajax({
        method: "POST",
        url: "../scripts/spot_feed_friends_posts.php",
        data: {theFunction: "getSpotFeed", theData: theInformation}
    }).done(function (response) {
        console.log(response);
        returnedData = JSON.parse(response);
        console.log(returnedData[0][0]['username']);
        //First let's populate the ordinary data
        for (var i = 0; i < returnedData[0].length; i++) {
            var hasPhoto = false;
            for (var j = 0; j < returnedData[1].length; j++) {
                if (returnedData[1][j].username === returnedData[0][i].username) {
                    hasPhoto = true;
                    break;
                    friendSpotFeedPhoto.attr("src", returnedData[1][j].photo);
                }
            }
            if (hasPhoto) {
                var friendSpotFeedWithPhotoEventHeadingHTML = '<div class="well spotfeed-container"><h2 class="spotfeed-center-title" id="friendSpotFeedWithPhotoEventHeading' +
                        i + '">' + returnedData[0][i].establishmentName + '</h2><div class="section">' +
                        '<div class="container">' +
                        '<div class="row">' +
                        '<div class="col-md-6">' +
                        '<img src="../img/3704766447_f59c3d5aa5_o.jpg" class="img-responsive" id="friendSpotFeedPhoto' +
                        i + '">' +
                        '</div>' +
                        '<div class="col-md-5">' +
                        '<h3 id="friendSpotFeedSubtitle' +
                        i + '">' + returnedData[0][i].establishmentName + '</h3>' +
                        '<p id="friendSpotFeedReview' + i + '">' + returnedData[0][i].review + '</p>' +
                        '<p id="friendSpotFeedReviewAuthor' + i + '"><small>Posted by: ' + returnedData[0][i].username + '</small></p>' +
                        '<div class="row"><p>Rating:</p><ul id="firendSpotFeedEstablishmentScale' +
                        i + '" style="position:relative; left: -20px;">' +
                        '<li class="scale">' +
                        '<a style="position: absolute; top: -5px; left: 5px;">1</a>' +
                        '</li>' +
                        '<li class="scale">' +
                        '<a style="position: absolute; top: -5px; left: 6px;">2</a>' +
                        '</li>' +
                        '<li class="scale">' +
                        '<a style="position: absolute; top: -5px; left: 6px;">3</a>' +
                        '</li>' +
                        '<li class="scale">' +
                        '<a style="position: absolute; top: -5px; left: 5.5px;">4</a>' +
                        '</li>' +
                        '<li class="scale">' +
                        '<a style="position: absolute; top: -5px; left: 6px;">5</a>' +
                        '</li>' +
                        '</ul></div>' +
                        '<div><a href="#" id="friendSpotFeedMapURL' +
                        i + '" style="display: none;">Location</a></div>'+
                        '<div id="commentsDivision' + i + '">' +
                        '<br><textarea rows="3" placeholder="Comments" style="width: 100%;" id="userCommentOnSpotFeedTextArea' +
                        i + '"></textarea>' +
                        '<br><br><a href="#" class="btn btn-primary pull-right" id="submitUserCommentOnSpotFeedButton' +
                        i + '">Submit comment</a><br><br>' +
                        '</div><div>' +
                        '<h4>Comments:</h4><p class="text-info"><small id="commentUser' + i + '"></small></p>' +
                        '<p class="text-info" id="comment' + i + '"></p>'
                '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                firendSpotFeedWithPhotoWellsContainer.append(friendSpotFeedWithPhotoEventHeadingHTML);

                $("#firendSpotFeedEstablishmentScale" + i + " li").each(function (index) {
                    if ($(this).index() < returnedData[0][i].scale) {
                        $(this).removeClass("active");
                        $(this).addClass("active");
                    }
                    if ($(this).index() > returnedData[0][i].scale) {
                        $(this).removeClass("active");
                    }
                });
                if (returnedData[0][0].latitude !== 0 && returnedData[0][i].longitude !== 0) {
                    var friendSpotFeedMapURL = $(('#friendSpotFeedMapURL' + i).toString());
                    friendSpotFeedMapURL.show();
                    friendSpotFeedMapURL.attr("href", "https://www.google.com/maps?q=" + returnedData[0][i].latitude + "," +
                            returnedData[0][0].longitude);
                }

                var friendSpotFeedPhoto = $('#friendSpotFeedPhoto' + i);
                for (var j = 0; j < returnedData[1].length; j++) {
                    if (returnedData[1][j].username === returnedData[0][i].username) {
                        friendSpotFeedPhoto.attr("src", returnedData[1][j].photo);
                    }
                }
                
                //Set the comments if available
                $('#commentUser' + i).html(returnedData[2][i].username);
                $('#comment' + i).html(returnedData[2][i].comment);
                
                var submitUserCommentOnSpotFeedButton = $('#submitUserCommentOnSpotFeedButton' + i).on("click", function () {
                    //Get the control number
                    var theNumber = $(this).attr('id').replace(/[^\d]/g, "");

                    //Get the textbox associated with the submit comment button
                    var userCommentOnSpotFeedTextArea = $('#userCommentOnSpotFeedTextArea' + theNumber);

                    //Store the information on the comment
                    //Check if there is something to comment
                    if ($.trim(userCommentOnSpotFeedTextArea.val())) {
                        var theInformation = {"username": theCurrentUser, "comment": userCommentOnSpotFeedTextArea.val(),
                            "establishmentName": $('#friendSpotFeedWithoutPhotoEventHeading' + theNumber).html()};
                        //AJAX request
                        $.ajax({
                            method: "POST",
                            url: "../scripts/spot_feed_friends_comment.php",
                            data: {theFunction: "submitComment", theData: JSON.stringify(theInformation)}
                        }).done(function (response) {
                            console.log(response);
                            //Set the user who just posted the comment
                            $('#commentUser' + theNumber).html(theCurrentUser);
                            $('#comment' + theNumber).html(userCommentOnSpotFeedTextArea.val());
                            userCommentOnSpotFeedTextArea.hide();
                            $('#submitUserCommentOnSpotFeedButton' + theNumber).hide();
                            $('#commentsDivision' + theNumber).hide();
                        });
                    }
                });
            }
            else {
                var friendSpotFeedWithoutPhotoEventHTML = '<div class="well spotfeed-container">' +
                        '<h2 class="spotfeed-left-title" id="friendSpotFeedWithoutPhotoEventHeading' + i + '">' + returnedData[0][i].establishmentName + '</h2>' +
                        '<h3>' + returnedData[0][i].establishmentName + '</h3>' +
                        '<p id="friendSpotFeedWithoutPhotoReview' + i + '">' + returnedData[0][i].review + '</p>' +
                        '<p id="friendSpotFeedWithoutPhotoReviewAuthor' + i + '"><small>Posted by: ' + returnedData[0][i].username + '</small></p>' +
                        '<div class="row"><p>Rating:</p><ul id="firendSpotFeedWithoutPhotoEstablishmentScale' +
                        i + '" style="position:relative; left: -20px;">' +
                        '<li class="scale">' +
                        '<a style="position: absolute; top: -5px; left: 5px;">1</a>' +
                        '</li>' +
                        '<li class="scale">' +
                        '<a style="position: absolute; top: -5px; left: 6px;">2</a>' +
                        '</li>' +
                        '<li class="scale">' +
                        '<a style="position: absolute; top: -5px; left: 6px;">3</a>' +
                        '</li>' +
                        '<li class="scale">' +
                        '<a style="position: absolute; top: -5px; left: 5.5px;">4</a>' +
                        '</li>' +
                        '<li class="scale">' +
                        '<a style="position: absolute; top: -5px; left: 6px;">5</a>' +
                        '</li>' +
                        '</ul></div>' +
                        '<div><a href="#" id="friendSpotFeedWithoutPhotoMapURL' +
                        i + '" style="display: none;">Location</a></div>' +
                        '<div id="commentsDivision' + i + '">' +
                        '<br><textarea rows="3" placeholder="Comments" style="width: 100%;" id="userCommentOnSpotFeedTextArea' +
                        i + '"></textarea>' +
                        '<br><br><a href="#" class="btn btn-primary pull-right" id="submitUserCommentOnSpotFeedButton' +
                        i + '">Submit comment</a><br><br>' +
                        '</div><div>' +
                        '<h4>Comments:</h4><p class="text-info"><small id="commentUser' + i + '"></small></p>' +
                        '<p class="text-info" id="comment' + i + '"></p>'
                '</div>' +
                        '</div>';

                friendSpotFeedWithoutPhotoWellsContainer.append(friendSpotFeedWithoutPhotoEventHTML);

                $("#firendSpotFeedWithoutPhotoEstablishmentScale" + i + " li").each(function (index) {
                    if ($(this).index() < returnedData[0][i].scale) {
                        $(this).removeClass("active");
                        $(this).addClass("active");
                    }
                    if ($(this).index() > returnedData[0][i].scale) {
                        $(this).removeClass("active");
                    }
                });
                if (returnedData[0][0].latitude !== 0 && returnedData[0][i].longitude !== 0) {
                    var friendSpotFeedMapURL = $(('#friendSpotFeedWithoutPhotoMapURL' + i).toString());
                    friendSpotFeedMapURL.show();
                    friendSpotFeedMapURL.attr("href", "https://www.google.com/maps?q=" + returnedData[0][i].latitude + "," +
                            returnedData[0][0].longitude);
                }

                //Set the comments if available
                $('#commentUser' + i).html(returnedData[2][i].username);
                $('#comment' + i).html(returnedData[2][i].comment);

                var submitUserCommentOnSpotFeedButton = $('#submitUserCommentOnSpotFeedButton' + i).on("click", function () {
                    //Get the control number
                    var theNumber = $(this).attr('id').replace(/[^\d]/g, "");

                    //Get the textbox associated with the submit comment button
                    var userCommentOnSpotFeedTextArea = $('#userCommentOnSpotFeedTextArea' + theNumber);

                    //Store the information on the comment
                    //Check if there is something to comment
                    if ($.trim(userCommentOnSpotFeedTextArea.val())) {
                        var theInformation = {"username": theCurrentUser, "comment": userCommentOnSpotFeedTextArea.val(),
                            "establishmentName": $('#friendSpotFeedWithoutPhotoEventHeading' + theNumber).html()};
                        //AJAX request
                        $.ajax({
                            method: "POST",
                            url: "../scripts/spot_feed_friends_comment.php",
                            data: {theFunction: "submitComment", theData: JSON.stringify(theInformation)}
                        }).done(function (response) {
                            console.log(response);
                            //Set the user who just posted the comment
                            $('#commentUser' + theNumber).html(theCurrentUser);
                            $('#comment' + theNumber).html(userCommentOnSpotFeedTextArea.val());
                            userCommentOnSpotFeedTextArea.hide();
                            $('#submitUserCommentOnSpotFeedButton' + theNumber).hide();
                            $('#commentsDivision' + theNumber).hide();
                        });
                    }
                });
            }
        }
    });
    //AJAX request END
}