<?php
$db->query = "select * from " . TABLE_EMAILACCOUNTS . " where userid=$userid";
$db->execute();
$rowcount = $db->rowcount();
if ($rowcount>0) {
  for ($x=0; $x < $rowcount; $x++) {
    $row = $db->fetchrow($x);
    $row['template'] = file_get_contents('templates/tl/emailtemplates/' . $row['usedfor'] . '.html');
    $accounts[$x] = $row;
  }
} else {
  $accounts = array(1 => array(
    'usedfor' => '',
    'emailname' => '',
    'emailusername' => '',
    'emailpassword' => '',
    'emailhost' => '',
    'emailport' => ''
    )
  );
}

$body->template_loop('accounts',$accounts);

?>