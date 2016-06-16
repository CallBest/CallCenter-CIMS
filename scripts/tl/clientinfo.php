<?php
  require_once("includes/dbase.php");
  require_once("includes/settings.php");
  
  isset($_REQUEST['leadid']) ? $leadid = $_REQUEST['leadid'] : $leadid = 0;
  
  $db = new dbconnection();
  $db->dbconnect();
  
  $db->query = "
    select * from " . TABLE_CLIENTS . " a
    inner join " . TABLE_CLIENTINFO . " b on (a.leadid=b.leadid)
    inner join " . TABLE_CARDS . " c on (a.leadid=c.leadid)  
    where a.leadid=$leadid";
  $db->execute();
  if  ($db->rowcount()==1) {
    $row = $db->fetchrow(0);
    $body->add_keys($row);
    include('contactnumbers.php');
    include('dispositions.php');
  }
?>