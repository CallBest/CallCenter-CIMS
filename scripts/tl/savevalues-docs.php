<?php

require_once('../../includes/settings.php');
require_once('../../includes/dbase.php');

function cleanstring($string) {
        $newstring = "";
        $newstring = str_replace("'","'''",$string);
        $newstring = str_replace("--","_",$newstring);
        $newstring = strtoupper($newstring);
        $newstring = stripslashes($newstring);
        return $newstring;
}

$workingfolder = cleanstring($_REQUEST['workingfolder']);
$agent = cleanstring($_REQUEST['agent']);
$disposition = cleanstring($_REQUEST['disposition']);
$remarks = cleanstring($_REQUEST['remarks']);
$leadid = cleanstring($_REQUEST['leadid']);

$db = new dbconnection();
$db->dbconnect();

//masterfile
$db->query = "
  update " . TABLE_CLIENTS . "
  set confirmer=$agent,disposition='$disposition',dateconfirmed=now(),remarks='$remarks'
  where leadid=$leadid
  ";
$db->execute();

//turn-ins
if (strtoupper($disposition)=='TURN-IN') {
  $now = Date("Y-m-d");
  $db->query = "
    insert into ". TABLE_TURNIN . "
      (leadid,disposition,tagdate)
      values
      ($leadid,'$disposition',now())
      on duplicate key update 
        disposition='$disposition',
        tagdate='$now'
    ";
  $db->execute();
}

//callhistory
$db->query = "
  insert into " . TABLE_HISTORY . " (leadid,remarks,disposition,agent,tagdate)
    values (
      $leadid,
      '$remarks',
      '$disposition',
      '$agent',
      now()
    )";
$db->execute();

header("Location: ../../tl.php?show=$workingfolder&mode=docs");

?>