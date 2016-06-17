<?php
$db->query = "select * from " . TABLE_FILES . " where leadid=$leadid";
$db->execute();
$rowcount = $db->rowcount();
if ($rowcount>0) {
  for ($x=0; $x < $rowcount; $x++) {
    $row = $db->fetchrow($x);
    $files[$x] = $row;
  }
} else {
  $files = array(1 => array(
    'filename' => '',
    'doctype' => '',
    'dateuploaded' => '',
    'agent' => ''
    )
  );
}

$body->template_loop('files',$files);

?>