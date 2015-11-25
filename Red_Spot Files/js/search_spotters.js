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


$('input.typeahead').typeahead({
    source: function (query, process) {
        $.ajax({
            url: '../scripts/spotterSearch.php',
            type: 'POST',
            data: {'query': query, currentUser: theCurrentUser}}).done(function (response) {
            var newData = JSON.parse(response);
            var data = new Array();
            for (var i = 0; i < newData.length; i++) {
                data.push(newData[i].username + "#" + newData[i].role + "#" + newData[i].related);
            }
            console.log(response);
            console.log(data);
            return process(data);
        });
    }, highlighter: function (item) {
        var parts = item.split('#'), html = '<div class="typeahead">';
        html += '<div class="pull-left margin-small">';
        html += '<div class="text-left"><strong>' + parts[0] + '</strong></div>';
        html += '<div class="text-left"><small>' + parts[1] + '</small></div>';
        html += '</div>';
        if (parts[0] != theCurrentUser) {
            if (parts[2] === "false") {
                html += '<div class="pull-right margin-small">';
                html += '<div class="text-right"><span class="glyphicon glyphicon-plus-sign" id="span" aria-hidden=true></span></div>';
                html += '</div>';
            }
            else {
                html += '<div class="pull-right margin-small">';
                html += '<div class="text-right"><span class="glyphicon glyphicon-minus-sign" id="span" aria-hidden=true></span></div>';
                html += '</div>';
            }

        }


        html += '<div class="clearfix"></div>';
        html += '</div>';
        return html;
    },
    updater: function (item) {
        var parts = item.split('#');
        var spans = document.getElementById('span');
        if (parts[2] === "true") {
            eliminateRelation(parts[0], parts[1]);
        }
        else if (parts[2] === "false") {
            spans = doSomething(parts[0], parts[1]);
        }
        return parts[0];
    },
});

function doSomething(userName, role) {
    theInformation = JSON.stringify({userName: userName, currentUser: theCurrentUser, role: role});
    $.ajax({
        method: "POST",
        url: "../scripts/add_friend_functions.php",
        data: {theFunction: "addFriend", theData: theInformation}

    }).done(function (response) {
        alert("gd");
        console.log(response);
    });
}

function eliminateRelation(userName, role) {
    theInformation = JSON.stringify({userName: userName, currentUser: theCurrentUser, role: role});
    $.ajax({
        method: "POST",
        url: "../scripts/add_friend_functions.php",
        data: {theFunction: "removeFriend", theData: theInformation}

    }).done(function (response) {

    });
}