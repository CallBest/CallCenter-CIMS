<?php
$phones = array();  
$phones = explode("/",$row['phone']);
$phones[] = $row['homephone'];
$phones[] = $row['companyphone'];
$phones[] = $row['mobilephone'];
$phonesfiltered = array_unique($phones);

$db->query = "select leadid,phonenumber,disposition from " . TABLE_PHONES . " where leadid=$leadid";
$db->execute();
$rowcount = $db->rowcount();
if ($rowcount>0) {
  for ($x=0; $x < $rowcount; $x++) {
    $row = $db->fetchrow($x);
    $num = $row['phonenumber'];
    $phonenum[$num] = $row['disposition'];
  }
} else {
  foreach ($phonesfiltered as $item) {
    if ($item<>'') {
      $db->query = "insert into " . TABLE_PHONES . " (leadid,phonenumber) values ($leadid,'$item')";
      $db->execute();
      $phonenum['$item'] = '';
    }
  }
}

$radioopts = '';
$phonenumbers = array();
foreach ($phonesfiltered as $item) {
  if ($item<>'') {
    if (array_key_exists($item,$phonenum)) {
      $phonenumbers[$item]['phonenumber'] = $item;
      $phonenumbers[$item]['phonedispo'] = $phonenum[$item];
    } else {
      $phonenumbers[$item]['phonenumber'] = $item;
      $phonenumbers[$item]['phonedispo'] = '';
    }
  }
}

$body->template_loop('phonenumbers',$phonenumbers);

?>