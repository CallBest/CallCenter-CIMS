<?php

$tin = $_REQUEST['tin'];
$leadid = $_REQUEST['id'];

require_once("../../includes/settings.php");
require_once("../../includes/dbase.php");
$db = new dbconnection();
$db->dbconnect();
$db->query = "select tin from ".TABLE_SEARCH." where tin='$tin' and leadid<>$leadid";
$db->execute();

if ($db->rowcount() > 0) {
  echo "<h5><a href=\"#\" class=\"text-danger\"><span class=\"glyphicon glyphicon-exclamation-sign text-danger\"></span> Duplicate found.</a></h5>";
}

?>