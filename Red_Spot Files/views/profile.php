<?php
session_start();
?>
<html><head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Core CSS -->
        <link href="../css/lavish-bootstrap.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="../css/landing-page.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script type="text/javascript">
            var theCurrentUser = "<?php echo $_SESSION['Username'] ?>";
        </script>
        <style>
            .spotfeed-container {
                height: auto;
                border-radius: 10px;
                border-top: 50px solid #e81354;
                background: #ffffff;
                display: block;
            }
            .spotfeed-left-title{
                position: relative;
                top: -80px;
                text-align: left;
                color: white;
            }
            .spotfeed-center-title{
                position: relative;
                top: -80px;
                text-align: center;
                color: white;
            }
        </style>
    </head><body>
        <div class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><span>Red Spot</span></a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active">
                            <a href="userHome.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;Home</a>
                        </li>
                        <li>
                            <a href="#" id="userHomeProfileLink"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;<?php echo $_SESSION['Username'] ?></a>
                        </li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-bell" aria-hidden="true"></span>&nbsp;&nbsp;Notifications&nbsp;&nbsp;<span class="badge">0</span></a>
                        </li>
                        <li>
                            <a id="logoutButton" href="#">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="well">
                            <ul class="nav nav-list">
                                <li class="nav-header">List header</li>
                                <li class="active">
                                    <a href="userHome.php">Home</a>
                                </li>
                                <li>
                                    <a href="#">Notifications</a>
                                </li>
                                <li>
                                    <a id="invitationsButton" href="#">Invitations</a>
                                </li>
                                <li>
                                    <a id="userSettingsButton" href="#">User Settings</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8" id="userProfileContentDivision">
                            <div class="col-sm-6 col-md-6">
                                <div class="thumbnail">
                                    <img src="..." alt="Profile Picture" id="profilePicture" style="max-width: 250px; max-height: 250px;" class="img-responsive img-rounded">
                                    <div class="caption">
                                        <h3><?php echo $_SESSION['Username'] ?></h3>
                                        <div>
                                            <a class="btn btn-success" id="profilePictureUploadButton">Profile Picture</a>
                                            <br><br>
                                        </div>
                                        <input type="file" accept=".jpg, .jpeg, .png, .gif" id="inputFile" name="inputFile" class="btn btn-success" style="display: none"/>
                                        <div style="display: none" class="active progress progress-striped" id="profilePictureUploadProgressDesign">
                                            <div class="bar" style="width: 0%;" id="profilePictureProgressBar">
                                            </div>
                                            <br><br>
                                        </div>
                                        <div class="permalink_section" id="profilePictureParagraph"></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../js/profile_update.js"></script>
        <script src="../js/profile_default_data_update.js"></script>
    </body></html>