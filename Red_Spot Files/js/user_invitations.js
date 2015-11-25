/*
 * Variables containing the HTML elements
 */

//Form variables
var createEventNameForm = $('#createEventNameForm');
var eventInformationForm = $('#eventInformationForm');
var dateTimeForm = $('#dateTimeForm');
var spotForm = $('#spotForm');
var spottersToInviteForm = $('#spottersToInviteForm');

//Inputs of the form
var createEventNameInput = $('#createEventNameInput');
var eventInformationInput = $('#eventInformationInput');
var dateTimeInput = $('#dateTimeInput');
var spotInput = $('#spotInput');
var spottersToInviteInput = $('#spottersToInviteInput');

//Button
var createEventButton = $('#createEventButton');

/*
 * Variables containing the HTML elements END
 */

createEventButton.on('click', function () {
    if (createEventNameInput.val() != "" && eventInformationInput.val() != "" && dateTimeInput.val() != "" && spotInput.val() != "" && spottersToInviteInput.val() != "") {
        //split spotters and store in array
        var spottersInvited = spottersToInviteInput.val().split(",");
        /*
         * When the page loads
         */
        
        var EventInfo = JSON.stringify({"currentUser": theCurrentUser, "userInvited": spottersInvited, "eventName": createEventNameInput.val(), "eventInformation": eventInformationInput.val(), "date": dateTimeInput.val(), "spot": spotInput.val()});
        //AJAX request 
        $.ajax({
            url: "../scripts/create_event_functions.php",
            method: "POST",
            data: {theFunction: "extractEventData", eventData:EventInfo}
        }).done(function (response) {
            //var eventObject = JSON.parse(response); //Create an Object in JS to acceder el php
        });
//AJAX request END
    }

});