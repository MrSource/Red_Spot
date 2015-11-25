$(document).ready(function () {
    //Variables containing the HTML elements
    var registerModal = $('#registerModal');
    var firstNameInput = $('#firstNameInput');
    var lastNameInput = $('#lastNameInput');
    var registerUserNameInput = $('#registerUserNameInput');
    var registerEmailInput = $('#registerEmailInput');
    var registerPasswordInput = $('#registerPasswordInput');
    var registerPasswordConfirmInput = $('#registerPasswordConfirmInput');
    var createAccountButton = $('#createAccountButton');

    //Form groups
    var firstNameFormGroup = $('#firstNameFormGroup');
    var lastNameFormGroup = $('#lastNameFormGroup');
    var registerUserNameFormGroup = $('#registerUserNameFormGroup');
    var registerEmailFormGroup = $('#registerEmailFormGroup');
    var registerPasswordFormGroup = $('#registerPasswordFormGroup');
    var registerPasswordConfirmFormGroup = $('#registerPasswordConfirmFormGroup');
    var loginUserNameFormGroup = $('#loginUserNameFormGroup');

    var passwordMismatchError = $('#passwordMismatchError');
    var registerUserNameErrorParagraph = $('#registerUserNameErrorParagraph');
    var registerEmailErrorParagraph = $('#registerEmailErrorParagraph');
    var registerUserNameSpaceErrorParagraph = $('#registerUserNameSpaceErrorParagraph');

    var establishmentOwnerCheckBox = $('#establishmentOwnerCheckBox');

    //When the user clicks on the create account button
    createAccountButton.on("click", function () {
        //Validate fields by adding and removing classes accordingly
        if (!$.trim(registerUserNameInput.val())) {
            registerUserNameFormGroup.removeClass('has-error');
            registerUserNameFormGroup.addClass('has-error');
        }
        if (!$.trim(registerEmailInput.val())) {
            registerEmailFormGroup.removeClass('has-error');
            registerEmailFormGroup.addClass('has-error');
        }
        if (!$.trim(registerPasswordInput.val())) {
            registerPasswordFormGroup.removeClass('has-error');
            registerPasswordFormGroup.addClass('has-error');
        }
        if (!$.trim(registerPasswordConfirmInput.val())) {
            registerPasswordConfirmFormGroup.removeClass('has-error');
            registerPasswordConfirmFormGroup.addClass('has-error');
        }
        //Check if passwords match
        if (registerPasswordInput.val() !== registerPasswordConfirmInput.val()) {
            registerPasswordFormGroup.removeClass('has-error');
            registerPasswordFormGroup.addClass('has-error');
            registerPasswordConfirmFormGroup.removeClass('has-error');
            registerPasswordConfirmFormGroup.addClass('has-error');
            passwordMismatchError.slideDown("slow", function () {
                // Animation complete.
            });
        }

        //Proceed to check if all fields have been validated
        var validatedFields = 0;
        if (!registerUserNameFormGroup.hasClass("has-error")) {
            validatedFields++;
        }
        if (!registerEmailFormGroup.hasClass("has-error")) {
            validatedFields++;
        }
        if (!registerPasswordFormGroup.hasClass("has-error")) {
            validatedFields++;
        }
        if (!registerPasswordConfirmFormGroup.hasClass("has-error")) {
            validatedFields++;
        }
        if (validatedFields == 4) {
            //All the information is valid, let's create an account
            var username = registerUserNameInput.val();
            var email = registerEmailInput.val();
            var password = registerPasswordInput.val();
            var firstName = firstNameInput.val();
            var lastName = lastNameInput.val();
            var role = "User";
            if (establishmentOwnerCheckBox.is(":checked")) {
                role = "Establishment Owner";
            }

            var theInformation = {"username": username, "email": email, "password": password,
                "firstName": firstName, "lastName": lastName, "role": role};
            $.ajax({
                method: "POST",
                url: "scripts/create_account_functions.php",
                data: {theFunction: "insertData", theData: JSON.stringify(theInformation)}
            })
                    .done(function (response) {
                        if($.trim(response) == $.trim("Success")){
                            window.location = "/views/userHome.php";
                        }
                    });

        }
    });

    //Check if passwords match
    registerPasswordConfirmInput.on("keyup", function () {
        if ($(this).val() !== registerPasswordInput.val()) {
            registerPasswordFormGroup.removeClass('has-error');
            registerPasswordFormGroup.addClass('has-error');
            registerPasswordConfirmFormGroup.removeClass('has-error');
            registerPasswordConfirmFormGroup.addClass('has-error');
            passwordMismatchError.slideDown("slow", function () {
                // Animation complete.
            });
        }
        else {
            registerPasswordFormGroup.removeClass('has-error');
            registerPasswordConfirmFormGroup.removeClass('has-error');
            passwordMismatchError.hide();
        }
        if (!$.trim($(this).val()) || !$.trim(registerPasswordInput.val())) {
            registerPasswordFormGroup.removeClass('has-error');
            registerPasswordConfirmFormGroup.removeClass('has-error');
            passwordMismatchError.hide();
        }
    });

    //Check if username exists or not
    registerUserNameInput.on("keyup", function () {
        var currentText = {"username": $(this).val()};
        var theInformation = JSON.stringify(currentText);
        if (hasWhiteSpace($(this).val())) {
            registerUserNameFormGroup.removeClass('has-error');
            registerUserNameFormGroup.addClass('has-error');
            registerUserNameSpaceErrorParagraph.slideDown("slow", function () {
                // Animation complete.
            });
        }
        else {
            registerUserNameFormGroup.removeClass('has-error');
            registerUserNameSpaceErrorParagraph.hide();
        }
        $.ajax({
            method: "POST",
            url: "scripts/create_account_functions.php",
            data: {theFunction: "validateUsername", theData: theInformation}
        })
                .done(function (response) {
                    if (response == 1) {
                        registerUserNameFormGroup.removeClass('has-error');
                        registerUserNameFormGroup.addClass('has-error');
                        registerUserNameErrorParagraph.slideDown("slow", function () {
                            // Animation complete.
                        });
                    }
                    else {
                        registerUserNameFormGroup.removeClass('has-error');
                        registerUserNameErrorParagraph.removeAttr("style");
                        registerUserNameErrorParagraph.hide();
                    }
                });
    });

    //Check if email exists or not
    registerEmailInput.on("keyup", function () {
        var currentText = {"email": $(this).val()};
        var theInformation = JSON.stringify(currentText);
        $.ajax({
            method: "POST",
            url: "scripts/create_account_functions.php",
            data: {theFunction: "validateEmail", theData: theInformation}
        })
                .done(function (response) {
                    if (response == 1) {
                        registerEmailFormGroup.removeClass('has-error');
                        registerEmailFormGroup.addClass('has-error');
                        registerEmailErrorParagraph.slideDown("slow", function () {
                            // Animation complete.
                        });
                    }
                    else {
                        registerEmailFormGroup.removeClass('has-error');
                        registerEmailErrorParagraph.removeAttr("style");
                        registerEmailErrorParagraph.hide();
                    }
                });
    });

    function hasWhiteSpace(s) {
        return /\s/g.test(s);
    }
});