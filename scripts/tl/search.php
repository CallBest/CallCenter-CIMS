<?php
  $searchname = str_replace(' ','%',$_REQUEST['searchname']);
  
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
    select * from " . TABLE_CLIENTS . " a 
    inner join " . TABLE_LISTS . " b on (a.listid=b.listid)
    where ((completename like '%$searchname%') or (concatname like '%$searchname%'))
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

