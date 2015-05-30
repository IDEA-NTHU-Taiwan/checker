<?php
require_once("../inc.php");
$class = getClassByID($_GET['id']);
$course = getCourse($class['course_id']);

$qs = getAllQuestions($class['id']);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checker - Question of <?=$course['title']?></title>

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
        <h2>Questions of <?=echoDate($class['date'])?> <small><?=$course['title']?></small></h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th style="width:50px;">#</th>
              <th>Question</th>
              <th style="width:200px;">Student</th>
              <th style="width:200px;">Time</th>
              <th style="width:200px;">Control</th>
            </tr>
          </thead>
          <tbody>
          <?php
          	$i=1;
          	foreach($qs as $q){
          		$check = getCheckByID($q['check_id']);
          ?>
            <tr class="<?if($q['selected'])echo "success"?> <?if($q['deleted'])echo "hide"?>">
              <td><?=$i++?></td>
              <td><?=nl2br($q['content'])?></td>
              <td>(<?=$check['sid']?>) <?=$check['name']?></td>
              <td><?=$q['time']?></td>
              <td>
                <div class="btn-group btn-group-xs" role="group">
                <?php
                  if($q['selected']){
                ?>
                  <button type="button" class="select btn btn-success" id="select<?=$q['id']?>" data-id="<?=$q['id']?>">Selected</button>
                <?php
                  }else{
                ?>
                  <button type="button" class="select btn btn-default" id="select<?=$q['id']?>" data-id="<?=$q['id']?>">Unselected</button>
                <?php
                  }
                ?>
                  <button type="button" class="btn btn-danger" disabled>Delete</button>
                </div>
              </td>
            </tr>
          <?php
          	}
          ?>
          </tbody>
        </table>
        <center><a href="class.php?id=<?=$course['id']?>" class="btn btn-primary">Back to Class</a></center>

    </div><!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script>
      $(".select").click( function(e){
        console.log(e.target.dataset.id);
        if($("#"+e.target.id).parents('tr').hasClass('success')==true){
          console.log("Y");
          $("#"+e.target.id).text("Unselected");
          $("#"+e.target.id).removeClass('btn-success').addClass('btn-default');
          $("#"+e.target.id).parents('tr').removeClass('success');
        } else {
          console.log("F");
          $("#"+e.target.id).text("Selected");
          $("#"+e.target.id).addClass('btn-default').addClass('btn-success');
          $("#"+e.target.id).parents('tr').addClass('success');
        }
        $.ajax({
          url: "process.php?act=selected",
              data: { id: e.target.dataset.id },
              type:"POST",
              dataType:'text',
              success: function(msg){
                console.log(msg);
              },
              error: function(msg){
                console.log(msg);
              }
        });
      });
    </script>
  </body>
</html>