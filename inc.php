<?php
// ini_set('display_errors',1);
// ini_set('display_startup_errors',1);
// error_reporting(-1);

/* === Settings === */
$dbhost = 'localhost';
$dbuser = '';
$dbpass = '';
$dbname = '';

$admin_id = "";
$admin_pw = "";

$google_api_key = 'AIzaSyBNjcDkNlEoYSU7SI4UG************';

/* === Database Connection === */
$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if($db->connect_errno) 
{
	echo "Connection Failed: " . $db->connect_errno;
	exit();
}
if (!$db->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
}date_default_timezone_set("Asia/Taipei");


/* === Functions === */
function generateRandomString($length = 10) {
    $characters = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getClassByToken($token) {
    global $db;
    $result = $db->query("SELECT * FROM class WHERE token = '".$token."' LIMIT 1");
    $data = $result->fetch_assoc();

    $result->close();
    return $data;
}

function getClassByID($class_id) {
    global $db;
    $result = $db->query("SELECT * FROM class WHERE id = ".$class_id." LIMIT 1");
    $data = $result->fetch_assoc();

    $result->close();
    return $data;
}

function getClassByCID($class_id) {
    global $db;
    $result = $db->query("SELECT * FROM class WHERE course_id = ".$class_id."");
    $i = 0;
    while($row = $result->fetch_assoc()) {
        $data[$i++] = $row;
    }
    $result->close();
    return $data;
}

function getCourse($course_id) {
    global $db;
    $result = $db->query("SELECT * FROM course WHERE id = ".$course_id." LIMIT 1");
    $data = $result->fetch_assoc();

    $result->close();
    return $data;
}

function getAllCourse() {
    global $db;
    $result = $db->query("SELECT * FROM course");
    $i = 0;
    while($row = $result->fetch_assoc()) {
        $data[$i++] = $row;
    }
    $result->close();
    return $data;
}

function getCheck($class_id, $student_id) {
    global $db;
    $result = $db->query("SELECT * FROM `check` WHERE `class_id` = ".$class_id." AND `sid` = '".$student_id."'");
    $data = $result->fetch_assoc();

    $result->close();
    return $data;
}

function getAllCheck($class_id) {
    global $db;
    $result = $db->query("SELECT * FROM `check` WHERE `class_id` = ".$class_id." ORDER BY `sid` ASC");
    $i = 0;
    while($row = $result->fetch_assoc()) {
        $data[$i++] = $row;
    }
    $result->close();
    return $data;
}

function getCheckByID($id) {
    global $db;
    $result = $db->query("SELECT * FROM `check` WHERE `id` = ".$id);
    $data = $result->fetch_assoc();

    $result->close();
    return $data;
}

function makeCheck($class_id, $student_id, $name, $auth_cookie) {
    global $db;
    $result = $db->query("INSERT INTO `check` (`id`, `sid`, `class_id`, `name`, `time`, `auth_cookie`) VALUES (NULL, '$student_id', '$class_id', '".htmlspecialchars($name)."', CURRENT_TIMESTAMP, '$auth_cookie');");
    
    // Why should I need to comment this line ? But it works!
    //$result->close();
}

function isChecked($class_id, $student_id) {
    global $db;
    $result = $db->query("SELECT count(*) FROM `check` WHERE `class_id` = ".$class_id." AND `sid` = '".$student_id."'");
    $data = $result->fetch_array();

    $result->close();
    return $data[0];
}

function modifyCheckName($check_id, $name) {
    global $db;
    $db->query("UPDATE `check` SET `name` = '".$name."' WHERE `id` = ".$check_id.";");
}

function makeQuestion($check_id, $content) {
    global $db;
    $result = $db->query("INSERT INTO `question` (`id`, `check_id`, `content`, `deleted`, `time`) VALUES (NULL, '".$check_id."', '".htmlspecialchars($content)."', 0, CURRENT_TIMESTAMP)");
//      $result->close();
    return $result;
}

function getQuestions($check_id, $deleted = 1) {
    global $db;
    if(!$deleted)
        $result = $db->query("SELECT * FROM `question` WHERE `check_id` = ".$check_id." ORDER BY id DESC");
    else
        $result = $db->query("SELECT * FROM `question` WHERE `check_id` = ".$check_id." AND `deleted` != 1 ORDER BY id DESC");
    $i = 0;
    while($row = $result->fetch_assoc()) {
        $data[$i++] = $row;
    }

    $result->close();
    return $data;
}

function getAllQuestions($class_id) {
    global $db;
    $result = $db->query("SELECT * FROM `question` WHERE `check_id` IN (SELECT `id` FROM `check` WHERE `class_id` = ".$class_id.") ORDER BY id DESC");
    $i = 0;
    while($row = $result->fetch_assoc()) {
        $data[$i++] = $row;
    }

    $result->close();
    return $data;
}
function getQuestionSelected($question_id) {
    global $db;
    $result = $db->query("SELECT * FROM `question` WHERE `id` = ".$question_id." LIMIT 1");
    $row = $result->fetch_assoc();
    $result->close();
    return $row['selected'];
}

function makeQuestionSelected($question_id) {
    global $db;
    $result = $db->query("UPDATE `question` SET `selected` = 1 WHERE `id` = ".$question_id);
    return $result;
}

function makeQuestionUnSelected($question_id) {
    global $db;
    $result = $db->query("UPDATE `question` SET `selected` = 0 WHERE `id` = ".$question_id);
    return $result;
}

function makeQuestionDeleted($question_id) {
    global $db;
    $result = $db->query("UPDATE `question` SET `deleted` = 1 WHERE `id` = ".$question_id);
    return $result;
}

function countCheck($class_id){
    global $db;
    $result = $db->query("SELECT COUNT(*) FROM `check` WHERE `class_id` = ".$class_id);
    $data = $result->fetch_array();

    $result->close();
    return $data[0];
}

function countQuestion($class_id){
    global $db;
    $result = $db->query("SELECT COUNT(*) FROM `question` WHERE `check_id` IN ( SELECT id FROM `check` WHERE `class_id` = ".$class_id.")");
    $data = $result->fetch_array();

    $result->close();
    return $data[0];
}

function echoDate($dateStr) {
    $date = new DateTime($dateStr);
    echo $date->format('F j, Y');
}
/* === Session Starter === */
function start_session($expire = 0) {
    if ($expire == 0) {
        $expire = ini_get('session.gc_maxlifetime');
    } else {
        ini_set('session.gc_maxlifetime', $expire);
    }

    if (empty($_COOKIE['PHPSESSID'])) {
        session_set_cookie_params($expire);
        session_start();
    } else {
        session_start();
        setcookie('PHPSESSID', session_id(), time() + $expire);
    }
}
/* === Google URL API === */
$googer = new GoogleURLAPI($google_api_key);
class GoogleUrlApi {
    public $key = "";
    // Constructor
    function GoogleURLAPI($key, $apiURL = 'https://www.googleapis.com/urlshortener/v1/url') {
        // Keep the API Url
        $this->apiURL = $apiURL."?key=".$key;
        $this->key = $key;
    }
    
    // Shorten a URL
    function shorten($url) {
        // Send information along
        $response = $this->send($url);
        // Return the result
        return isset($response['id']) ? $response['id'] : false;
    }
    
    // Expand a URL
    function expand($url) {
        // Send information along
        $response = $this->send($url,false);
        // Return the result
        return isset($response['longUrl']) ? $response['longUrl'] : false;
    }
    
    // Send information to Google
    function send($url,$shorten = true) {
        // Create cURL
        $ch = curl_init();
        // If we're shortening a URL...
        if($shorten) {
            curl_setopt($ch,CURLOPT_URL,$this->apiURL);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode(array("longUrl"=>$url,"key"=>$this->key)));
            curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: application/json"));
        }
        else {
            curl_setopt($ch,CURLOPT_URL,$this->apiURL.'&shortUrl='.$url);
        }
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        // Execute the post
        $result = curl_exec($ch);
        // Close the connection
        curl_close($ch);
        // Return the result
        return json_decode($result,true);
    }       
}