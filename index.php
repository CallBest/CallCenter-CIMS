<?php

require_once("includes/cookie.php");
require_once("includes/template.php");

$body = new Template("templates/index.html");

$cookie = new CookieInfo("CMS");

if ($cookie->check()) {
	$cookie->getcookies();
	if ($cookie->array['accesstype'] == 9) {
		//header("Location: admin.php");
		//exit;
	}
	else {
		//header("Location: agent.php");
		//exit;
	}
}

$body->create();

?>