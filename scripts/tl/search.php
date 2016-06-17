<?php
  $searchname = str_replace(' ','%',$_REQUEST['searchname']);
  $searchtin = str_replace(' ','%',$_REQUEST['searchtin']);
  $searchemail = str_replace(' ','%',$_REQUEST['searchemail']);
  
  require_once('includes/dbase.php');
  require_once('includes/settings.php');
  
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
//actual query
  $db->query = "
    select * from " . TABLE_SEARCH . " a 
    inner join " . TABLE_CLIENTS . " b on (a.leadid=b.leadid)
    inner join " . TABLE_LISTS . " c on (b.listid=c.listid)
    inner join " . TABLE_DISPO . " d on (b.disposition=d.disposition)
    where ((a.concatname like '%$searchname%') OR (b.completename like '%$searchname%')) and a.email like '%$searchemail%' and a.tin like '%$searchtin%'
    and d.campaignid>1 and b.disposition<>'Call Back'
    order by $sort limit $start, $end";
  $db->execute();
  $gridvalues = array();
  $rowcount = $db->rowcount();
  for ($x = 0; $x < $rowcount; $x++) {
    $row = $db->fetchrow($x);
    $row['clickaction'] = 'onclick="showlead('.$row['leadid'].')"';
    $gridvalues[$x] = $row;
  }
 
  $body->template_loop('gridvalues',$gridvalues);
  $body->add_key('prev',$start-10);
  $body->add_key('next',$start+10);
?>

