<?php
require_once('../../includes/settings.php');
require_once('../../includes/dbase.php');

isset($_REQUEST['leadid']) ? $leadid = $_REQUEST['leadid'] : exit;

$db = new dbconnection();
$db->dbconnect();
$db->query = "select * from " . TABLE_FILES . " where leadid=$leadid";
$db->execute();
$rowcount = $db->rowcount();
$files = '';
if ($rowcount>0) {
  for ($x=0; $x < $rowcount; $x++) {
    $row = $db->fetchrow($x);
    $filename = $row['filename'];
    $files .= "<option value='../../uploads/$filename'>$filename</option>" ;
  }
}

echo $files;

?>