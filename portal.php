<?php
require_once("inc.php");
if(isset($_GET['id']))
  $class = getClassByID($_GET['id']);
if(isset($_GET['token']))
  $class = getClassByToken($_GET['token']);
$course = getCourse($class['course_id']);

$shortURL = $googer->shorten("http://idea.cs.nthu.edu.tw/~kojima/checker/login.php?token=".$class['token']);

echo $googer->shorten("http://idea.cs.nthu.edu.tw/~kojima/checker/login.php?token=".$class['token']);

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
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?=$course['title']?> (<?=echoDate($class['date'])?>)</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Portal</a></li>
            <li><a href="admin/auth.html">Auth</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" style="margin-top:50px;">

      <div class="starter-template">
        <center><img id="qrcode" src="http://chart.apis.google.com/chart?chs=400x400&cht=qr&chld=|1&chl=<?=htmlspecialchars($shortURL)?>" /></center>
        <h1>Check your Attendance and Submit your Question!</h1>
        <p class="lead">If you can not scan above QR code, please use <a href="<?=$shortURL?>"><?=$shortURL?></a><br/>Or you can find TA to confirm your attendance and submit your question.</p>
      </div>

    </div><!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script>
      $(document).ready(function(){
        resizeDiv();
      });
      function resizeDiv() {
        vpw = $(window).width();
        vph = $(window).height()-150;
        $('#qrcode').css({'height': vph + 'px'});
      }
    </script>
  </body>
</html>