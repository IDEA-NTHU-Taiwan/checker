<?php
require_once("inc.php");
$class = getClassByToken($_GET['token']);
$course = getCourse($class['course_id']);
if (!isset($_COOKIE['auth_cookie'])) {
	setcookie("auth_cookie", generateRandomString(4), time()+36000, "/~kojima/checker/", "idea.cs.nthu.edu.tw");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checker - <?=$course['title']?></title>

    <!-- Bootstrap -->
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header" >
          <a class="navbar-brand" href="#" style="font-size:85%;"><?=$course['title']?> (<?=echoDate($class['date'])?>)</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" style="margin-top:60px;">

      <div>
      <div class="alert alert-info">
  	  	Please input your student ID and name (for display).
  	  </div>
        <form class="form-horizontal" method="POST" action="user.php">
          <div class="form-group">
            <label class="col-sm-2 control-label">Student ID</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="studentid" name="studentid" placeholder="Student ID">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="name" name="name" placeholder="Name">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" class="btn btn-primary" value="Sign in">
            </div>
          </div>
          <input type="hidden" name="token" value="<?=$_GET['token']?>">
        </form>
      </div>
      <!-- <?=$_COOKIE['auth_cookie']?> -->
    </div><!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script>
      $('form').submit(function() {
          if ($.trim($("#studentid").val()) === "" || $.trim($("#name").val()) === "") {
              alert('Please do not leave any field blank.');
              return false;
          }
      });
    </script>
  </body>
</html>