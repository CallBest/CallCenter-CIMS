<?php
$db->query = "select disposition from " . TABLE_DISPO . " where campaignid=2 and selectable=1";
$db->execute();
$rowcount = $db->rowcount();
if ($rowcount>0) {
  for ($x=0; $x < $rowcount; $x++) {
    $row = $db->fetchrow($x);
    $dispo[$x] = $row;
  }
}

$body->template_loop('dispositions',$dispo);

?>