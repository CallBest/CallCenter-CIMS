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
    inner join " . TABLE_USERS . " d on (a.agent=d.userid)  
    inner join " . TABLE_LISTS . " e on (a.listid=e.listid)
    where a.leadid=$leadid";
  $db->execute();
  if  ($db->rowcount()==1) {
    $row = $db->fetchrow(0);
    $clientdispo = $row['disposition'];
    $body->add_keys($row);

    // Enable/disable print/send choices
    $row['chinabank']=='checked'    ? $menucbc = '' : $menucbc = 'class="disabled"';
    $row['eastwestbank']=='checked' ? $menuewb = '' : $menuewb = 'class="disabled"';
    $row['maybank']=='checked'      ? $menumpi = '' : $menumpi = 'class="disabled"';
    $row['metrobank']=='checked'    ? $menumcc = '' : $menumcc = 'class="disabled"';
    $row['rcbc']=='checked'         ? $menurcbc = '' : $menurcbc = 'class="disabled"';
    $body->add_key('menucbc',$menucbc);
    $body->add_key('menuewb',$menuewb);
    $body->add_key('menumpi',$menumpi);
    $body->add_key('menumcc',$menumcc);
    $body->add_key('menurcbc',$menurcbc);

    include('contactnumbers.php');
    if (strtoupper($clientdispo)=='VERIFIED') {
      include('scripts/tl/dispositions.php');
    } else {
      include('scripts/tl/dispositions-docs.php');
    }
    include('scripts/tl/loaddocuments.php');
    include('scripts/tl/loademailaccounts.php');
  } else {
    exit;
  }
?>