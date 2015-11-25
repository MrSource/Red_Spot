//Variables containing the html elements
    var logoutButton = $('#logoutButton');
    
    //When we click the logout button...
    logoutButton.on("click", function () {
        //Make an AJAX request to the file logout_functions.php
        //Get the response and redirect the user if we successfully logged out
        //AJAX request
        $.ajax({
            method: "POST",
            url: "../scripts/logout_functions.php"
        })
                .done(function (response) {
                    //Check if we were successful in logging the user out
                    if ($.trim(response) == $.trim("Logged Out")) {
                        //Redirect
                        window.location = "../index.php";
                    }
                });
        //AJAX request END
    });