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
var establishmentFeedWithPhotoWellsContainer = $('#establishmentFeedWithPhotoWellsContainer');
var establishmentFeedWithoutPhotoWellsContainer = $('#establishmentFeedWithoutPhotoWellsContainer');
var friendFeedCount = 0;

//Extract the spot feed
extractEstablishmentFeed();

function extractEstablishmentFeed() {
    var theInformation = JSON.stringify({"username": theCurrentUser});

    //AJAX request
    $.ajax({
        method: "POST",
        url: "../scripts/establishment_feed_post.php",
        data: {theFunction: "getEstablishmentFeed", theData: theInformation}
    }).done(function (response) {
        console.log(response);
        returnedData = JSON.parse(response);
        //First let's populate the ordinary data
        for (var i = 0; i < returnedData.length; i++) {
            var hasPhoto = false;
            for (var j = 0; j < returnedData.length; j++) {
                if ($.trim(returnedData[i].photo)) {
                    hasPhoto = true;
                    break;
                }
            }
            if (hasPhoto) {
                var establishmentFeedWithPhotoEventHeadingHTML = '<div id="establishmentWell' + i + '" class="well spotfeed-container"><h2 class="spotfeed-center-title" id="establishmentFeedWithPhotoEventHeading' +
                        i + '">' + returnedData[i].establishmentName +
                        '<div class="pull-right"><a href="#" id="removeEstablishmentEvent' + i + '"><span class="glyphicon glyphicon-remove"></span></a></div><br><br><img src="http://placehold.it/800x300" alt="" id="establishmentPicture' +
                        i + '" class="img-responsive center-block" style="max-width: 800px; max-height: 300px;">' +
                        '<h4>' +
                        '<p id="establishmentNameParagraph' +
                        i + '"></p>' +
                        '</h4>' +
                        '<p id="establishmentInformationParagraph' +
                        i + '"></p>' +
                        '<span class="glyphicon glyphicon-time" aria-hidden="true" aria-label="Operating Hours"></span><p id="operatingHoursParagraph' +
                        i + '"></p>' +
                        '<p id="parkingParagraph' +
                        i + '"></p>' +
                        '<span class="glyphicon glyphicon-tag" aria-hidden="true" aria-label="Establishment Category"> </span><p id="categoryParagraph' +
                        i + '"></p>' +
                        '<span class="glyphicon glyphicon-earphone" aria-hidden="true" aria-label="Telephone"> </span><p id="telephoneParagraph' +
                        i + '"></p>' +
                        '<a href="#" id="establishmentLocationLink' +
                        i + '" style="display: none;"></a>' +
                        '</div>';
                establishmentFeedWithPhotoWellsContainer.append(establishmentFeedWithPhotoEventHeadingHTML);
                
                $("#establishmentPicture" + i).attr('src', returnedData[i].photo);
                $("#establishmentNameParagraph" + i).html(returnedData[i].establishmentName);
                $("#establishmentInformationParagraph" + i).html(returnedData[i].information);
                $("#operatingHoursParagraph" + i).html(returnedData[i].schedule);
                if(returnedData[i].parking === 1){
                    $("#parkingParagraph" + i).html("Parking: Yes");
                }
                else{
                    $("#parkingParagraph" + i).html("Parking: No");
                }
                $("#categoryParagraph" + i).html(returnedData[i].category);
                $("#telephoneParagraph" + i).html(returnedData[i].telephone);
                if (returnedData[i].latitude !== 0 && returnedData[i].longitude !== 0) {
                    var establishmentLocationLink = $(('#establishmentLocationLink' + i).toString());
                    establishmentLocationLink.show();
                    establishmentLocationLink.attr("href", "https://www.google.com/maps?q=" + returnedData[i].latitude + "," +
                            returnedData[i].longitude);
                    establishmentLocationLink.html("Location");
                }
                $("#removeEstablishmentEvent" + i).on("click", function(){
                    var theNumber = $(this).attr('id').replace(/[^\d]/g, "");
                    $("#establishmentWell" + theNumber).remove();
                });
            }
            else {
                var establishmentFeedWithPhotoEventHeadingHTML = '<div class="well spotfeed-container"><h2 class="spotfeed-center-title" id="establishmentFeedWithPhotoEventHeading' +
                        i + '">' + returnedData[i].establishmentName + '<div class="container">'
                        '<div class="row">' +
                        '<div class="col-md-12">' +
                        '<div class="thumbnail">' +
                        '<img src="http://placehold.it/800x300" alt="" id="establishmentPicture' +
                        i + '" class="img-responsive" style="display: none;">' +
                        '<div class="caption-full">' +
                        '<h4>' +
                        '<p id="establishmentNameParagraph' +
                        i + '"></p>' +
                        '</h4>' +
                        '<p id="establishmentInformationParagraph' +
                        i + '"></p>' +
                        '<span class="glyphicon glyphicon-time" aria-hidden="true" aria-label="Operating Hours"> </span><p id="operatingHoursParagraph' +
                        i + '"></p>' +
                        '<p id="parkingParagraph' +
                        i + '"></p>' +
                        '<span class="glyphicon glyphicon-tag" aria-hidden="true" aria-label="Establishment Category"> </span><p id="categoryParagraph' +
                        i + '"></p>' +
                        '<span class="glyphicon glyphicon-earphone" aria-hidden="true" aria-label="Telephone"> </span><p id="telephoneParagraph' +
                        i + '"></p>' +
                        '<a href="#" id="establishmentLocationLink' +
                        i + '" style="display: none;"></a>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                establishmentFeedWithPhotoWellsContainer.append(establishmentFeedWithPhotoEventHeadingHTML);
                $("#establishmentNameParagraph" + i).html(returnedData[i].establishmentName);
                $("#establishmentInformationParagraph" + i).html(returnedData[i].information);
                $("#operatingHoursParagraph" + i).html(returnedData[i].schedule);
                if(returnedData[i].parking === 1){
                    $("#parkingParagraph" + i).html("Yes");
                }
                else{
                    $("#parkingParagraph" + i).html("No");
                }
                $("#categoryParagraph" + i).html(returnedData[i].category);
                $("#telephoneParagraph" + i).html(returnedData[i].telephone);
                if (returnedData[i].latitude !== 0 && returnedData[0][i].longitude !== 0) {
                    var establishmentLocationLink = $(('#establishmentLocationLink' + i).toString());
                    establishmentLocationLink.show();
                    establishmentLocationLink.attr("href", "https://www.google.com/maps?q=" + returnedData[i].latitude + "," +
                            returnedData[i].longitude);
                }
            }
        }
    });
    //AJAX request END
}