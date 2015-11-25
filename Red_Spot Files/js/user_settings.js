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

/*
 * Variables containing the HTML elements
 */

//From groups
var editFirstNameFormGroup = $('#editFirstNameFormGroup');
var editNameFormGroup = $('#editNameFormGroup');
var editUserNameFormGroup = $('#editUserNameFormGroup');
var editEmailFormGroup = $('#editEmailFormGroup');
var changeCurrentPasswordFormGroup = $('#changeCurrentPasswordFormGroup');
var changeNewPasswordFormGroup = $('#changeNewPasswordFormGroup');
var changePasswordConfirmFormGroup = $('#changePasswordConfirmFormGroup');

//Inputs
var editFirstNameInput = $('#editFirstNameInput');
var editLastNameInput = $('#editLastNameInput');
var editEmailInput = $('#editEmailInput');
var changeCurrentPasswordInput = $('#changeCurrentPasswordInput');
var changeNewPasswordInput = $('#changeNewPasswordInput');
var changePasswordConfirmInput = $('#changePasswordConfirmInput');

//Paragraph elements
var changeEmailErrorParagraph = $('#changeEmailErrorParagraph');
var passwordMismatchError = $('#passwordMismatchError');

//Buttons
var saveChangesButton = $('#saveChangesButton');

//Checkboxes
var changePasswordCheckBox = $('#changePasswordCheckBox');

//Message divisions
var userSettingsMessageDivision = $('#userSettingsMessageDivision');
/*
 * Variables containing the HTML elements END
 */

/*
 * When the page loads
 */
//AJAX request
//Get the user data
$.ajax({
    url: "../scripts/change_user_settings_functions.php ",
    method: "POST",
    data: {theFunction: "extractUserData", theData: JSON.stringify({"username": theCurrentUser})}
}).done(function (response) {
    var userObject = JSON.parse(response);
    //Populate user first name
    if ($.trim(userObject.firstName)) {
        editFirstNameInput.val(userObject.firstName);
    }
    //Populate user last name
    if ($.trim(userObject.lastName)) {
        editLastNameInput.val(userObject.lastName);
    }
    //Populate user email
    editEmailInput.val(userObject.email);
});
//AJAX request END

/*
 * Event when the user changes the email
 */
editEmailInput.on("keyup", function () {
    var email = $(this).val();
    //AJAX request
    $.ajax({
        url: "../scripts/create_account_functions.php ",
        method: "POST",
        data: {theFunction: "validateEmail", theData: JSON.stringify({"email": email})}
    }).done(function (response) {
        if (response == 1) {
            editEmailFormGroup.removeClass('has-error');
            editEmailFormGroup.addClass('has-error');
            changeEmailErrorParagraph.slideDown("slow", function () {
                // Animation complete.
            });
        }
        else {
            editEmailFormGroup.removeClass('has-error');
            changeEmailErrorParagraph.removeAttr("style");
            changeEmailErrorParagraph.hide();
        }
    });
    //AJAX request END
});

//Event for when the user clicks on the checkbox to change the use password
changePasswordCheckBox.on("change", function () {
    if (changePasswordCheckBox.is(":checked")) {
        //Enable the inputs of change password
        changeCurrentPasswordInput.removeAttr("disabled");
        changeNewPasswordInput.removeAttr("disabled");
        changePasswordConfirmInput.removeAttr("disabled");
    }
    else {
        //Disable the inputs of change passsword
        changeCurrentPasswordInput.attr("disabled", "disabled");
        changeNewPasswordInput.attr("disabled", "disabled");
        changePasswordConfirmInput.attr("disabled", "disabled");
    }

});

//Confirm password event
changePasswordConfirmInput.on("keyup", function () {
    if ($(this).val() !== changeNewPasswordInput.val()) {
        passwordMismatchError.slideDown("slow", function () {
            // Animation complete.
        });
    }
    else {
        passwordMismatchError.hide();
    }
    if (!$.trim($(this).val())) {
        passwordMismatchError.hide();
    }
});

//When the user erases the new password field
changeNewPasswordInput.on("keyup", function () {
    if (!$.trim($(this).val())) {
        passwordMismatchError.hide();
    }
    if (!$.trim(changePasswordConfirmInput.val())) {
        passwordMismatchError.hide();
    }
});

//When the user decides to save the changes
saveChangesButton.on("click", function () {
    //For ordinary changes
    if (!changePasswordCheckBox.is(":checked")) {
        var theInformation = {"username": theCurrentUser, "firstName": editFirstNameInput.val(),
            "lastName": editLastNameInput.val()};
        if ($.trim(editEmailInput.val())) {
            theInformation["email"] = editEmailInput.val();
        }
        //AJAX request
        $.ajax({
            method: "POST",
            url: "../scripts/change_user_settings_functions.php",
            data: {theFunction: "changeUserDataNoPassword", theData: JSON.stringify(theInformation)}
        })
                .done(function (response) {
                    if ($.trim(response) === "Success") {
                        userSettingsMessageDivision.html('<div style="position:relative; right: -200px;" class="alert alert-success text-center" id="success-alert"><button type="button" class="close" data-dismiss="alert">&times;</button>Changes saved.</div>');
                        $("#success-alert").animate({
                            right: "+=200px"
                        }, 500);
                        $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                            $("#success-alert").alert('close');
                        });
                    }
                });
        //AJAX request END
    }
    else {
        var theInformation = {"username": theCurrentUser, "firstName": editFirstNameInput.val(),
            "lastName": editLastNameInput.val()};
        if ($.trim(editEmailInput.val())) {
            theInformation["email"] = editEmailInput.val();
        }
        if (changeNewPasswordInput.val() === changePasswordConfirmInput.val()) {
            theInformation["oldPassword"] = changeCurrentPasswordInput.val();
            theInformation["newPassword"] = changeNewPasswordInput.val();
            //AJAX request
            $.ajax({
                method: "POST",
                url: "../scripts/change_user_settings_functions.php",
                data: {theFunction: "changeUserData", theData: JSON.stringify(theInformation)}
            })
                    .done(function (response) {
                        console.log(response);
                        if ($.trim(response) === "Success") {
                            changeCurrentPasswordFormGroup.removeClass("has-error");
                            userSettingsMessageDivision.html('<div style="position:relative; right: -200px;" class="alert alert-success text-center" id="success-alert"><button type="button" class="close" data-dismiss="alert">&times;</button>Changes saved.</div>');
                            $("#success-alert").animate({
                                right: "+=200px"
                            }, 500);
                            $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                                $("#success-alert").alert('close');
                            });
                        }
                        else if($.trim(response) === "Wrong password"){
                            userSettingsMessageDivision.html('<div style="position:relative; right: -200px;" class="alert alert-danger text-center" id="success-alert"><button type="button" class="close" data-dismiss="alert">&times;</button>Wrong password!</div>');
                            $("#success-alert").animate({
                                right: "+=200px"
                            }, 500);
                            $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                                $("#success-alert").alert('close');
                            });
                            changeCurrentPasswordFormGroup.removeClass("has-error");
                            changeCurrentPasswordFormGroup.addClass("has-error");
                        }
                    });
            //AJAX request END
        }
    }
});