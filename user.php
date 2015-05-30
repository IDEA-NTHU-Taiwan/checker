<?php
require_once("inc.php");
start_session(10800);

if(isset($_POST['token']))
  $_SESSION['token'] = $_POST['token'];
if(isset($_POST['studentid']))
  $_SESSION['studentid'] = $_POST['studentid'];
if(isset($_POST['name']))
  $_SESSION['name'] = $_POST['name'];

$class = getClassByToken($_SESSION['token']);
$course = getCourse($class['course_id']);



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
<?php
if(isChecked($class['id'], $_SESSION['studentid']) == 0 ){
	makeCheck($class['id'], $_SESSION['studentid'], $_SESSION['name'], $_COOKIE['auth_cookie']);
	$first_register = 1;
}


$check = getCheck($class['id'], $_SESSION['studentid']);

if(isset($_SESSION['name']))
	if($_SESSION['name'] != $check['name']) {
		modifyCheckName($check['id'], $_SESSION['name']);
		$check = getCheck($class['id'], $_SESSION['studentid']);
	}
?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#" style="font-size:85%;"><?=$course['title']?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="#">[<?=$check['sid']?> <?=$check['name']?>]</a></li>
            <li><a href="#">Attendance: <?=$check['time']?></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" style="margin-top:50px;">
    <?php
    	if($first_register){
    ?>
      <div class="alert alert-success">
      	You have been checked for your attendence! 
      </div>
    <?php 
		}
    ?>

      <div>
        <h1>Submit a Question for the class on <?=echoDate($class['date'])?></h1>
        <div class="form-group">
          <textarea class="form-control" rows="3" placeholder="Your Quesiton..." id="q_content" name="q_content"></textarea>
        </div>
        <button class="btn btn-primary" id="q_submit">Submit</button>
      </div>
      <hr />
      <div>
        <h1>Submitted Questions</h1>
        <div id="q_list">

        <?php
        	$qs = getQuestions($check['id']);
        	foreach($qs AS $q){
        ?>
	        <div class="panel panel-default" id="q-<?=$q['id']?>">
	          <div class="panel-heading">
	            <h3 class="panel-title">Submitted at <?=$q['time']?>. <a href="#" class="delete"><span data-id="<?=$q['id']?>"  class="pull-right glyphicon glyphicon-remove-sign
	" aria-hidden="true"></span></a></h3>
	          </div>
	          <div class="panel-body">
	            <?=htmlspecialchars_decode(nl2br($q['content']))?>
	          </div>
	        </div>
	    <?php
	    	}
	    ?>

        </div>
      </div>
      <!--<?=$_COOKIE['auth_cookie']?>-->
    </div><!-- /.container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    function nl2br( str ) {
      return str.replace(/([^>])\n/g, '$1<br/>\n');
    } 

		function getDateTime() {
		    var now     = new Date(); 
		    var year    = now.getFullYear();
		    var month   = now.getMonth()+1; 
		    var day     = now.getDate();
		    var hour    = now.getHours();
		    var minute  = now.getMinutes();
		    var second  = now.getSeconds(); 
		    if(month.toString().length == 1) {
		        var month = '0'+month;
		    }
		    if(day.toString().length == 1) {
		        var day = '0'+day;
		    }   
		    if(hour.toString().length == 1) {
		        var hour = '0'+hour;
		    }
		    if(minute.toString().length == 1) {
		        var minute = '0'+minute;
		    }
		    if(second.toString().length == 1) {
		        var second = '0'+second;
		    }   
		    var dateTime = year+'/'+month+'/'+day+' '+hour+':'+minute+':'+second;   
		     return dateTime;
		}


    $(function() {
        $("#q_submit").click( function(){
          console.log($('#q_content').serialize());
          if ($.trim($("#q_content").val()) === "") {
              alert('Please do not leave any field blank.');
              return false;
          }
          $.ajax({
            url: "process.php?act=q_submit",
                data: { id: "<?=$check['id']?>", name: "<?=$check['name']?>",content : $('#q_content').serialize().replace(/'/g, "\\'")},
                type:"POST",
                dataType:'text',
                success: function(msg){
                    console.log("R:"+msg);
                    if(msg.indexOf("success") > -1){
                      $("#q_list").prepend("<div class=\"panel panel-default\"><div class=\"panel-heading\"><h3 class=\"panel-title\">Submitted at "+getDateTime()+" <a href=\"#\"><span class=\"pull-right hide aria-hidden glyphicon glyphicon-remove-sign\" aria-hidden=\"true\"></span></a></h3></div><div class=\"panel-body\">"+nl2br($('#q_content').val())+"</div></div>");
                      $("#q_content").val("");
                    }
                }
          });
        });

        $(".delete").click( function(e){  
          var r = confirm("Deleted?");
          if(!r)
            return false;
          console.log(e.target.dataset.id);
          $.ajax({
            url: "process.php?act=q_delete",
                data: { id: e.target.dataset.id },
                type:"POST",
                dataType:'text',
                success: function(msg){
                    console.log("R:"+msg);
                    $("#q-"+e.target.dataset.id).addClass('hide');
                }
          });
        });
    });
    </script>
  </body>
</html>