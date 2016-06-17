<?php
  require_once("includes/dbase.php");
  require_once("includes/settings.php");
  
  isset($_REQUEST['leadid']) ? $leadid = $_REQUEST['leadid'] : $leadid = 0;
  
  $db = new dbconnection();
  $db->dbconnect();
  
  $db->query = "
    select * from " . TABLE_CLIENTS . " a
    inner join " . TABLE_CLIENTINFO . " b on (a.leadid=b.leadid) 
    where a.leadid=$leadid and a.agent=$userid
    ";
  $db->execute();
  if  ($db->rowcount()==1) {
    $row = $db->fetchrow(0);
    $body->add_keys($row);
    if (strtoupper($row['disposition'])=='VERIFIED') {
      $body->add_key('disabledispo','disabled');
    } else {
      $body->add_key('disabledispo','');
    }
    include('contactnumbers.php');
    include('dispositions.php');

    $db->query = "
      select * from " . TABLE_CARDS . "
      where leadid=$leadid
      ";
    $db->execute();
    if  ($db->rowcount()==1) {
      $row = $db->fetchrow(0);
      $body->add_keys($row);
    } else {
      $row = array (
        prefdelivery => '',
        chinabank => '',
        eastwestbank => '',
        metrobank => '',
        rcbc => '',
        maybank => '',
        cbccardtype => '',
        ewbcardtype => '',
        ewbexisting => '',
        ewbclient => '',
        mcccardtype => '',
        mccothercard => '',
        mccsaveswap => '',
        mccother => '',
        rcbccardtype => '',
        mpicardtype => '',
        rcbcvisittime => '',
        rcbcvisitday => ''
      );
    }
  }
?>