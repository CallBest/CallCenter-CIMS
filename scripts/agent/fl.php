<?php
  require_once("includes/dbase.php");
  require_once("includes/settings.php");
  $db = new dbconnection();
  $db->dbconnect();
  // select lead assigned to agent with FL disposition '' or NEW 
  $db->query = "
    select * from " . TABLE_CLIENTS . "
    where agent=$userid and disposition=''
    limit 1 
    ";
  $db->execute();
  if ($db->rowcount()==0) {
    // select unused or recycled lead
    $db->query = "
      select * from " . TABLE_CLIENTS . "
      where agent=0 and dateexpires < now()
      limit 1 
      ";
    $db->execute();
  }
  
  if ($db->rowcount()==1) {
    $row = $db->fetchrow(0);
    $leadid = $row['leadid'];
    // set lead expiration to 30 days 
    $db->query = "update " . TABLE_CLIENTS . " set agent=$userid,dateexpires=CURDATE() + INTERVAL 30 DAY where leadid=$leadid";
    $db->execute();


    $db->query = "select leadid from " . TABLE_CLIENTINFO . " where leadid=$leadid";
    $db->execute();
    if ($db->rowcount()==0) {
      $db->query = "insert into " . TABLE_CLIENTINFO . " (leadid) values ($leadid)";
      $db->execute(); 
    }

    $db->query = "select leadid from " . TABLE_CARDS . " where leadid=$leadid";
    $db->execute();
    if ($db->rowcount()==0) {
      $db->query = "insert into " . TABLE_CARDS . " (leadid) values ($leadid)";
      $db->execute(); 
    }
    
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
  } else {
    echo "<script language=\"javascript\">alert('No more leads.')</script>";
    exit;
  }
?>