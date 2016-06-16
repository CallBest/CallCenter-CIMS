<?php

$userid = $_REQUEST['userid'];
$oldpass = $_REQUEST['oldpass'];
$newpass = $_REQUEST['newpass'];
$newpassrepeat = $_REQUEST['newpassrepeat'];

require_once("../../includes/user.php");

$profile = new UserClass();
$msg = $profile->changepassword($userid,$oldpass,$newpass,$newpassrepeat);
header('Location:'.$_SERVER['HTTP_REFERER'].'&msg='.$msg);
?>