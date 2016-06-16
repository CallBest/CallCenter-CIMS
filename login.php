<?php

require_once("includes/cookie.php");
require_once("includes/user.php");
require_once("includes/template.php");

$body = new Template();

$errmsg = "";
if ($_POST) {
	$profile = new UserClass();
	$row = $profile->dologin($_POST['loginusername'],$_POST['loginpassword']);
	if (!$row) {
		$errmsg = "Invalid username or password.";
	}
	else {
    $cookie = new CookieInfo("CMS" . $row['usertype']);
		$cookie->addkey("userid", $row['userid']);
    $cookie->addkey("firstname", $row['firstname']);
    $cookie->addkey("lastname", $row['lastname']);
    $cookie->addkey("extension", $row['extension']);
    $cookie->addkey("hostaddress", $row['hostaddress']);
    $cookie->addkey("teamid", $row['teamid']);
    $cookie->addkey("usertype", $row['usertype']);
    $cookie->setcookies();
    if ($cookie->array['usertype'] == 1) {
      header("Location: agent.php");
    } else if ($cookie->array['usertype'] == 2) {
		  header("Location: tl.php");
    } else if ($cookie->array['usertype'] == 3) {
      header("Location: dc.php");
    } else if ($cookie->array['usertype'] == 4) {
      header("Location: gh.php");
    } else if ($cookie->array['usertype'] == 5) {
      header("Location: it.php");
    }
		exit;
	}
}

$body->set_template("templates/index.html");
$body->add_key("errmsg",$errmsg);
echo $body->create();

?>