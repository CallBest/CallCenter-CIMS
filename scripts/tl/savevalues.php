<?php

require_once('../../includes/settings.php');
require_once('../../includes/dbase.php');

function cleanstring($string) {
        $newstring = "";
        $newstring = str_replace("'","''",$string);
        $newstring = str_replace("--","_",$newstring);
        $newstring = strtoupper($newstring);
        $newstring = stripslashes($newstring);
        return $newstring;
}

$workingfolder = cleanstring($_REQUEST['workingfolder']);
$agent = cleanstring($_REQUEST['agent']);
$disposition = cleanstring($_REQUEST['disposition']);
$remarks = cleanstring($_REQUEST['remarks']);
$leadid = cleanstring($_REQUEST['leadid']);

$datafields = array (
  'clfirstname'
  ,'clmiddlename'
  ,'cllastname'
  ,'embossname'
  ,'dobm'
  ,'dobd'
  ,'doby'
  ,'pob'
  ,'civilstatus'
  ,'gender'
  ,'dependents'
  ,'citizenship'
  ,'mobilephone'
  ,'homephone'
  ,'permhomephone'
  ,'homeaddress1'
  ,'homeaddress2'
  ,'homeaddress3'
  ,'homeaddress4'
  ,'homezipcode'
  ,'permaddress1'
  ,'permaddress2'
  ,'permaddress3'
  ,'permaddress4'
  ,'permzipcode'
  ,'homeownership'
  ,'lengthofstay'
  ,'numberofcars'
  ,'carmodelyear'
  ,'education'
  ,'email'
  ,'mfmn'
  ,'tin'
  ,'sss'
  ,'sourceoffunds'
  ,'company'
  ,'companyphone'
  ,'companyprovidedphone'
  ,'companyemail'
  ,'empposition'
  ,'emppositiontype'
  ,'occupation'
  ,'nob'
  ,'coaddress1'
  ,'coaddress2'
  ,'coaddress3'
  ,'coaddress4'
  ,'cozipcode'
  ,'emptenure'
  ,'emptenuretotal'
  ,'empstatus'
  ,'annualincome'
  ,'cardissuer'
  ,'cardnumber'
  ,'cardlimit'
  ,'membersince'
  ,'spfirstname'
  ,'spmiddlename'
  ,'splastname'
  ,'spdobm'
  ,'spdobd'
  ,'spdoby'
  ,'spcompany'
  ,'spposition'
  ,'spnob'
  ,'spcompanyphone'
  ,'spcoaddress1'
  ,'spcoaddress2'
  ,'spcoaddress3'
  ,'spcoaddress4'
  ,'spcozipcode'
  ,'supfirstname'
  ,'supmiddlename'
  ,'suplastname'
  ,'supaddress1'
  ,'supaddress2'
  ,'supaddress3'
  ,'supaddress4'
  ,'supzipcode'
  ,'supcontact'
  ,'supsourceoffunds'
  ,'supnob'
  ,'supcompany'
  ,'suprelation'
  ,'supcitizenship'
  ,'supdobm'
  ,'supdobd'
  ,'supdoby'
  ,'suppob'
  ,'suptin'
  ,'supsss'
  ,'supembossname'
  ,'supspendlimit'
  ,'reffirstname'
  ,'refmiddlename'
  ,'reflastname'
  ,'refrelation'
  ,'refaddress1'
  ,'refaddress2'
  ,'refaddress3'
  ,'refaddress4'
  ,'refzipcode'
  ,'refcontact'
);

$setfields = "";
foreach ($datafields as $key => $value) {
  if (!(($value=='email') || ($value=='companyemail'))) {
    $curfield = cleanstring($_POST["$value"]);
    $$value = $curfield;
  } else {
    $curfield = $_POST["$value"];
    $$value = $curfield;
  }
  $setfields .= "$value='$curfield',";
}

$db = new dbconnection();
$db->dbconnect();

//masterfile
$concatname = str_replace(' ','',$clfirstname . $clmiddlename . $cllastname);
$db->query = "
  update " . TABLE_CLIENTS . "
  set verifier=$agent,disposition='$disposition',dateverified=now(),remarks='$remarks',concatname='$concatname'
  where leadid=$leadid
  ";
$db->execute();

//clientinfo
$db->query = "
  update " . TABLE_CLIENTINFO . "
  set 
    $setfields
    leadid=$leadid
  where leadid=$leadid
  ";
$db->execute();

//verifications
if (strtoupper($disposition)=='CALL BACK') {
  $now = Date("Y-m-d");
  $db->query = "
    update ". TABLE_VER . "
      set disposition='$disposition',tagdate='$now'
      where leadid=$leadid
    ";
  $db->execute();
}

//turn-ins
if (strtoupper($disposition)=='TURN-IN') {
  $now = Date("Y-m-d");
  $db->query = "
    insert into ". TABLE_TURNIN . "
      (leadid,disposition,tagdate)
      values
      ($leadid,'$disposition',now())
      on duplicate key update 
        disposition='$disposition',
        tagdate='$now'
    ";
  $db->execute();
}

//phonenumbers
$db->query = "select leadid,phonenumber from ". TABLE_PHONES ." where leadid=$leadid";
$db->execute();
$queries = array();
$rowcount = $db->rowcount();
for ($x=0; $x < $rowcount; $x++) {
  $row = $db->fetchrow($x);
  $phonenum = $row['phonenumber'];
  $queries[$x] = "update ". TABLE_PHONES ." set disposition='".$_REQUEST[$phonenum]."',tagdate=now() where leadid=$leadid and phonenumber='$phonenum'";
}
foreach ($queries as $key=>$value) {
  $db->query = $value;
  $db->execute();
}

//cardchoice
$datafields = array (
  'prefdelivery'
  ,'prefdeliveryday'
  ,'prefdeliverytime'
  ,'chinabank'
  ,'eastwestbank'
  ,'metrobank'
  ,'rcbc'
  ,'maybank'
  ,'cbccardtype'
  ,'ewbcardtype'
  ,'ewbexisting'
  ,'ewbclient'
  ,'mcccardtype'
  ,'mccothercard'
  ,'mccsaveswap'
  ,'mccother'
  ,'rcbccardtype'
  ,'rcbcvisitday'
  ,'rcbcvisittime'
  ,'rcbcvisitaddress1'
  ,'rcbcvisitaddress2'
  ,'rcbcvisitaddress3'
  ,'rcbcvisitaddress4'
  ,'rcbcvisitzipcode'
  ,'mpicardtype'
);

$setfields = "";
foreach ($datafields as $key => $value) {
  $curfield = $_POST["$value"];
  $$value = $curfield;
  $setfields .= "$value='$curfield',";
}

$db->query = "
  update " . TABLE_CARDS . "
  set 
    $setfields
    leadid=$leadid
  where leadid=$leadid
  ";
$db->execute();

//searchfields
$db->query = "
  insert into ". TABLE_SEARCH . "
    (leadid,concatname,email,tin,mobilephone)
    values
    ($leadid,'$concatname','$email','$tin','$mobilephone')
    on duplicate key update 
    concatname = '$concatname',
    email = '$email',
    tin = '$tin',
    mobilephone ='$mobilephone' 
  ";
$db->execute();

//callhistory
$db->query = "
  insert into " . TABLE_HISTORY . " (leadid,remarks,disposition,agent,tagdate)
    values (
      $leadid,
      '$remarks',
      '$disposition',
      '$agent',
      now()
    )";
$db->execute();

header("Location: ../../tl.php?show=$workingfolder");

?>