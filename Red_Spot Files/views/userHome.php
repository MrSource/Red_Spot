<html><head>
    <meta charset="UTF-8">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="../css/lavish-bootstrap.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/landing-page.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <!-- jQuery -->
    <script src="../js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap3-typeahead.min.js"></script>
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
            .scale {
                width: 2em;
                height: 2em;
                text-align: center;
                line-height: 2em;
                border-radius: 2em;
                background: white;
                border: 0.3em solid #94221C;
                margin: 0 1em;
                display: inline-block;
                color: black;
                position: relative;
                cursor: pointer; 
                cursor: hand;
            }

            .scale::before{
                content: '';
                position: absolute;
                top: .6em;
                left: -4em;
                width: 4em;
                height: .2em;
                background: #94221C;
                z-index: -1;
            }

            .scale:first-child::before {
                display: none;
            }

            .active.scale {
                background: lightblue;
            }

            .active ~ .scale::before{
                background: #94221C;
            }
            textarea{
                resize: none;
            }
    </style>
    <title>User Home</title>
  </head><body>
    <?php session_start(); ?>
    <div class="cover">
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
            <ul class="nav navbar-form navbar-left">
              <input class="form-control typeahead" type="text" placeholder="Search spotters" data-provide="typeahead" autocomplete="off">
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="active">
                <a href="userHome.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;Home</a>
              </li>
              <li>
                <a href="profile.php" id="userHomeProfileLink"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;<?php echo $_SESSION['Username'] ?></a>
              </li>
              <li>
                <a href="#"><span class="glyphicon glyphicon-bell" aria-hidden="true"></span>&nbsp;&nbsp;Notifications&nbsp;&nbsp;<span class="badge">0</span></a>
              </li>
              <li>
                <a href="#" id="logoutButton">Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="cover-image"></div>
      <div class="container">
        <div class="well" id="userActionsDivision">
          <a href="addAPlaceMap.php" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Review a spot</a>
        </div>
        <h1 class="text-center">Spot Feed</h1>
        <div id="friendSpotFeedWithoutPhotoWellsContainer"></div>
        <div id="firendSpotFeedWithPhotoWellsContainer"></div>
        <div id="establishmentFeedWithPhotoWellsContainer"></div>
        <div id="establishmentFeedWithoutPhotoWellsContainer"></div>
      </div>
    </div>
    <script src="../js/logout_script.js"></script>
    <script type="text/javascript">
      var theCurrentUser = "<?php echo $_SESSION['Username'] ?>";
                var userRole = "<?php echo $_SESSION['Role'] ?>";
    </script>
    <script src="../js/search_spotters.js"></script>
    <script src="../js/spot_feed_friends_posts.js"></script>
    <script src="../js/establishment_feed_posts.js"></script>
    <script src="../js/user_actions.js"></script>
  

</body></html>