<?php
require_once("inc.php");
if($_GET['act']=="q_submit"){
	parse_str($_POST['content'],$content);
	makeQuestion($_POST['id'],$content['q_content']);
	echo "success";
	echo $content['q_content'];
}
if($_GET['act']=="q_delete"){
	makeQuestionDeleted($_POST['id']);
}