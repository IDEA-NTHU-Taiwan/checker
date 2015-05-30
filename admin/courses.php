<?php
require_once("../inc.php");
start_session(600);
$_SEESION['checker_admin'] = True;
if(isset($_SEESION['checker_admin'])){
  if($_SEESION['checker_admin']!=True){
    echo "not true";
    exit();
  }
}else{
  echo "not existed";
  exit();
}

$courses = getAllCourse();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checker - Courses</title>

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
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Checker</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="courses.php">Courses</a></li>
            <li><a href="#">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" style="margin-top:50px;">

      <div>
        <h1>Courses <button type="button" class="pull-right btn btn-primary" disabled>Add</button></h1>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Course</th>
              <th style="width:150px;">Control</th>
            </tr>
          </thead>
          <tbody>
          <?php
            foreach($courses as $c){
          ?>
            <tr>
              <td><?=$c['id']?></td>
              <td><a href="class.php?id=<?=$c['id']?>"><?=$c['title']?></a></td>
              <td>
                <div class="btn-group btn-group-xs" role="group">
                  <button type="button" class="btn btn-default" disabled>Edit</button>
                  <button type="button" class="btn btn-danger" disabled>Delete</button>
                </div>
              </td>
            </tr>
          <?php
            }
          ?>
          </tbody>
        </table>

    </div><!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  </body>
</html>