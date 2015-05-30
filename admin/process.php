<?php
require_once("../inc.php");
if($_GET['act']=="selected"){
	echo $_POST['id'];
	if(getQuestionSelected($_POST['id']))
		makeQuestionUnSelected($_POST['id']);
	else
		makeQuestionSelected($_POST['id']);
}
?>