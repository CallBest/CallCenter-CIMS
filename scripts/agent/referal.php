<?php

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
if (isset($_REQUEST['userid'])) {
  $userid = $_REQUEST['userid'];
} else {
  exit;
}

if (isset($_REQUEST['referalname'])) {
  require_once("../../includes/settings.php");
  require_once("../../includes/dbase.php");

  $referalname = $_REQUEST['referalname'];
  $referalcontact = $_REQUEST['referalcontact'];

  $curdatetime = Date("Y-m-d H:i:s");
  $db = new dbconnection();
  $db->dbconnect();
  $db->query = "
    insert into ".TABLE_CLIENTS."
      (completename,phone,disposition,dateuploaded,tagdate,dateexpires,listid,opener,agent,referencecode)
      values
      ('$referalname','$referalcontact','Referal',curdate(),'$curdatetime',CURDATE() + INTERVAL 30 DAY,2,$userid,$userid,'$leadid')
    ";
  $db->execute();
  $db->query = "
    select leadid from ".TABLE_CLIENTS."
    where agent=$userid and disposition='Referal' and tagdate='$curdatetime'
    ";
  $db->execute();
  if ($db->rowcount()==1) {
    $row = $db->fetchrow(0);
    $db->query = "insert into " . TABLE_CLIENTINFO . " (leadid) values (".$row['leadid'].")";
    $db->execute();
    $db->query = "insert into " . TABLE_CARDS . " (leadid) values (".$row['leadid'].")";
    $db->execute(); 
  } else {
    //temporary error handler
    $db->query = "update " . TABLE_CLIENTS . " set disposition='ERROR' where agent=$userid and disposition='Referal' and tagdate='$curdatetime'";
    $db->execute();
  }
}

$body = new Template();
$body->set_template("../../templates/agent/referal.html");
$body->add_key('cname',$cname);
$body->add_key('userid',$userid);
$body->add_key('leadid',$leadid);
echo $body->create();