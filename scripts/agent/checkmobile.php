<?php

$mobile = $_REQUEST['mobile'];
$leadid = $_REQUEST['id'];

require_once("../../includes/settings.php");
require_once("../../includes/dbase.php");
$db = new dbconnection();
$db->dbconnect();
$db->query = "select mobilephone from ".TABLE_SEARCH." where mobilephone='$mobile' and leadid<>$leadid";
$db->execute();

if ($db->rowcount() > 0) {
  echo "<h5><a href=\"#\" class=\"text-danger\"><span class=\"glyphicon glyphicon-exclamation-sign text-danger\"></span> Duplicate found.</a></h5>";
}

?>