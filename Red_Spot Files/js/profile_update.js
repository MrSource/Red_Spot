/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Load user_settings to html
 */

$(document).ready(function(){
    var userSettingsButton = $('#userSettingsButton');
    var invitationsButton = $('#invitationsButton');
    var userProfileContentDivision = $('#userProfileContentDivision');
    
    userSettingsButton.on('click',function(){
        //Here is the Load 
        userProfileContentDivision.load("../views/userSettings.php");
    });
    
    invitationsButton.on('click',function(){
        //Here is the load of the invitation button
        userProfileContentDivision.load("../views/userInvitations.php");
    });
});