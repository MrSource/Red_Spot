//Variables containing the HTML elements
var userActionsDivision = $('#userActionsDivision');

if(userRole === "Establishment Owner"){
    userActionsDivision.append('&nbsp;&nbsp;<a href="existingEstablishment.php" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Add a spot</a>');
}