<?php
  require_once("includes/dbase.php");
  require_once("includes/settings.php");
  require_once("includes/preloadvalues.php");
  $db = new dbconnection();
  $db->dbconnect();

//pagination variables start
  if (isset($_REQUEST['start'])) {
    $start = $_REQUEST['start'];
    if (!(is_numeric($start))) {
      $start = 0;
    }
  } else {
    $start = 0;
  }
  if ($start < 0) {
    $start = 0;
  }
  $end = $start + 10;
//set sorting order
  if (isset($_REQUEST['sort'])) {
    $sort = $_REQUEST['sort'];
  } else {
    $sort = 'completename';
  }
//filter list name
  if (isset($_REQUEST['listid'])) {
    if ($_REQUEST['listid']=='') {
      $listid = '';
    } else {
      $listid = ' and a.listid='.$_REQUEST['listid'];
    }
  } else {
    $listid = '';
  }
//applied cards?
  if (isset($_REQUEST['appliedcard'])) {
    if ($_REQUEST['appliedcard']=='') {
      $appliedcard = '';
    } else {
      $appliedcard = $_REQUEST['appliedcard'];
    }
  } else {
    $appliedcard = '';
  }

  if (isset($_REQUEST['applied'])) {
    $checked = $_REQUEST['applied'];
  } else {
    $checked = '';
  }

//actual query
  if ($appliedcard<>'') {
    $db->query = "
      select * from " . TABLE_CLIENTS . " a
      inner join " . TABLE_LISTS . " b on (a.listid=b.listid)
      inner join " . TABLE_USERS . " c on (a.agent=c.userid)
      inner join " . TABLE_CARDS . " d on (a.leadid=d.leadid)
      where disposition='$dispo' and teamid=$teamid $listid and $appliedcard='$checked' order by $sort limit $start, $end
    ";
    $db->execute();  
  } else {
    $db->query = "
      select * from " . TABLE_CLIENTS . " a
      inner join " . TABLE_LISTS . " b on (a.listid=b.listid)
      inner join " . TABLE_USERS . " c on (a.agent=c.userid)
      where disposition='$dispo' and teamid=$teamid $listid order by $sort limit $start, $end";
    $db->execute();
  }

  $gridvalues = array();
  $tablebody = "";
  $rowcount = $db->rowcount();
  for ($x = 0; $x < $rowcount; $x++) {
    $row = $db->fetchrow($x);
    $gridvalues[$x] = $row;
  }
 
  $body->template_loop('gridvalues',$gridvalues);
  $body->add_key('prev',$start-10);
  $body->add_key('next',$start+10);

  $activelist = preload_lists();
  $body->template_loop('list',$activelist);