<?php

require_once("includes/cookie.php");
require_once("includes/user.php");

$cookie = new CookieInfo("CMS");

if ($cookie->check()) {
	$cookie->getcookies();
	$userid = $cookie->array['userid'];
  $profile = new UserClass();
  $profile->dologout($userid);
	$cookie->deletecookies();
  header('Location: index.php');
} else {
  header('Location: index.php');
}

?>