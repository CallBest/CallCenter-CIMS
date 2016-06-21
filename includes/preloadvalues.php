<?php
require_once("includes/dbase.php");
require_once("includes/settings.php");

function preload_dispositions($campaignid = 1) {
  $db = new dbconnection();
  $db->dbconnect();
  $db->query = "select disposition from " . TABLE_DISPO . " where campaignid=$campaignid and selectable=1";
  $db->execute();
  $rowcount = $db->rowcount();
  if ($rowcount>0) {
    for ($x=0; $x < $rowcount; $x++) {
      $row = $db->fetchrow($x);
      $dispo[$x] = $row;
    }
  }
  return $dispo;
}

function preload_lists() {
  $db = new dbconnection();
  $db->dbconnect();
  $db->query = "select listid,listname from " . TABLE_LISTS . " where active=1";
  $db->execute();
  $rowcount = $db->rowcount();
  if ($rowcount>0) {
    for ($x=0; $x < $rowcount; $x++) {
      $row = $db->fetchrow($x);
      $list[$x] = $row;
    }
  }
  return $list;
}

?>