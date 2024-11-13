


<?php
require_once 'config/database.php';
require_once 'config/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">PeopleOne Technology</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="fa fa-user"></span>
                <?= $_SESSION['users']['first_name'].' '.$_SESSION['users']['last_name']; ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <!-- <li><a href="#">Profile</a></li> -->
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
    </nav>
    
    <div class="container" style="margin-top:100px;">
      <div class="jumbotron">
        <h2>Welcome, <?= $_SESSION['users']['first_name']; ?>!</h2>
        <p>Bring your organization’s workplace to life with a modern intranet — built on MS SharePoint — that empowers collaboration,
        knowledge sharing, team building, and company-wide communication.</p>
        <p>
          <a class="btn btn-lg btn-primary" href="https://www.peopleone.io/" role="button">Website »</a>
        </p>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>



