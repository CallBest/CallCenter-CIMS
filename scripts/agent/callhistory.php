<?php

require_once("../../includes/settings.php");
require_once("../../includes/dbase.php");
require_once("../../includes/template.php");

if (isset($_REQUEST['leadid'])) {
  $leadid = $_REQUEST['leadid'];
} else {
  exit;
}
if (isset($_REQUEST['cname'])) {
  $cname = $_REQUEST['cname'];
} else {
  exit;
}

$db = new dbconnection();
$db->dbconnect();
$db->query = "
  select * from " . TABLE_HISTORY . " a
  inner join " . TABLE_USERS . " b on (a.agent=b.userid)
  where leadid=$leadid order by tagdate desc
  ";
$db->execute();

$history = array();
$rowcount = $db->rowcount();
if ($rowcount>0) {
  for ($x=0; $x < $rowcount; $x++) {
    $row = $db->fetchrow($x);
    $history[$x] = $row;
  }
}

$body = new Template();
$body->set_template("../../templates/agent/callhistory.html");
$body->add_key('cname',$cname);
$body->template_loop('history',$history);
echo $body->create();