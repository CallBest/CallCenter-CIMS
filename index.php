<?php

require_once("includes/cookie.php");
require_once("includes/template.php");

$body = new Template();
$cookie = new CookieInfo("CMS");

if ($cookie->check()) {
	$cookie->getcookies();
	if ($cookie->array['usertype'] == 2) {
		header("Location: tl.php");
	} else if ($cookie->array['usertype'] == 3) {
		header("Location: dc.php");
	} else if ($cookie->array['usertype'] == 4) {
		header("Location: agent.php");
	} else if ($cookie->array['usertype'] == 5) {
		header("Location: it.php");
	} else if ($cookie->array['usertype'] == 1) {
		header("Location: agent.php");
	}
	exit;
}

$body->set_template("templates/index.html");
$body->add_key('errmsg','');
echo $body->create();

?>