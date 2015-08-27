<?php

require_once("includes/cookie.php");
require_once("includes/user.php");
require_once("includes/template.php");

$body = new Template("templates/login.html");

$cookie = new CookieInfo("CMS");
$errmsg = $_POST['loginusername'];

if ($_POST) {
  $errmsg = "";
	$profile = new UserClass();
	$row = $profile->dologin($_POST['loginusername'],$_POST['loginpassword']);
	if (!$row) {
		$errmsg = "Invalid username or password.";
	}
	else {
		$info = new CookieInfo("CMS");
		$info->addkey("userid", $row['userid']);
    $info->addkey("teamid", $row['team']);
    $info->addkey("realname", $row['realname']);
    $info->addkey("accesstype", $row['accesstype']);
    $info->addkey("exten", $row['extension']);
    $info->addkey("host", $row['hostaddress']);
		$info->setcookies();
    if ($row["accesstype"]==9) {
      header("Location: admin.php");
    } else {
      header("Location: agent.php");
    }
		exit;
	}
}

$body->add_key("errmsg",$errmsg);
$body->create();

?>