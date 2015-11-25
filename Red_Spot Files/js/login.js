$(document).ready(function () {
    //Variables containing the HTML elements
    var loginModal = $('#loginModal');
    var loginUserNameInput = $('#loginUserNameInput');
    var loginUserNameFormGroup = $('#loginUserNameFormGroup');
    var loginPasswordInput = $('#loginPasswordInput');

    var loginUserNameInput = $('#loginUserNameInput');
    var loginPasswordFormGroup = $('#loginPasswordFormGroup');
    var loginPasswordInput = $('#loginPasswordInput');

    var loginUserNameErrorParagraph = $('#loginUserNameErrorParagraph');
    var loginUserNameSpaceErrorParagraph = $('#loginUserNameSpaceErrorParagraph');
    var invalidLoginParagraph = $('#invalidLoginParagraph');
    
    var loginButton = $('#loginButton');

    //When the user types in the username field
    loginUserNameInput.on('keyup', function () {
        var currentText = {"username": $(this).val()};
        var theInformation = JSON.stringify(currentText);
        if (hasWhiteSpace($(this).val())) {
            loginUserNameFormGroup.removeClass('has-error');
            loginUserNameFormGroup.addClass('has-error');
            loginUserNameSpaceErrorParagraph.slideDown("slow", function () {
                // Animation complete.
            });
        }
        else {
            loginUserNameSpaceErrorParagraph.hide();
            if (!$(this).val()) {
                loginUserNameFormGroup.removeClass('has-error');
                loginUserNameSpaceErrorParagraph.hide();
                loginUserNameErrorParagraph.hide();
            }
            else {
                //AJAX request
                $.ajax({
                    method: "POST",
                    url: "scripts/login_user_functions.php",
                    data: {theFunction: "validateLoginUsername", theData: theInformation}
                })
                        .done(function (response) {
                            if (response == 1) {
                                loginUserNameFormGroup.removeClass('has-error');
                                loginUserNameErrorParagraph.hide();
                            }
                            else {
                                loginUserNameFormGroup.removeClass('has-error');
                                loginUserNameFormGroup.addClass('has-error');
                                loginUserNameErrorParagraph.slideDown("slow", function () {
                                    // Animation complete.
                                });
                            }
                        });
                //AJAX request END
            }
        }



    });
    
    //When the user clicks on the login button
    loginButton.on('click', function () {
                //AJAX request
                $.ajax({
                    method: "POST",
                    url: "scripts/login_user_functions.php",
                    data: {theFunction: "login", theData: JSON.stringify({"username": loginUserNameInput.val(), "password": loginPasswordInput.val()})}
                })
                        .done(function (response) {
                            if ($.trim(response) == $.trim("OK")) {
                                loginUserNameFormGroup.removeClass('has-error');
                                loginUserNameErrorParagraph.hide();
                                window.location = "/views/userHome.php";
                            }
                            else {
                                loginUserNameFormGroup.removeClass('has-error');
                                loginUserNameFormGroup.addClass('has-error');
                                invalidLoginParagraph.slideDown("slow", function () {
                                    // Animation complete.
                                });
                            }
                        });
                //AJAX request END
    });

    function hasWhiteSpace(s) {
        return /\s/g.test(s);
    }
});
