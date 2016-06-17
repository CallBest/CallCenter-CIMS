<?php
  // do not set 0 to these 4 variables!
  $dailytargetleads = 250;
  $dailytargetver = 15;
  $dailytargetturnin = 8;
  $dailytargetapproval = 3;

  $disposed = 0;
  $contacted = 0;
  $uncontacted = 0;
  $verified = 0;
  $turnin = 0;
  $approved = 0;
  $dateupdated = 'Nan';
  $nextupdate = 'Nan';


  $currentdate = Date("l, F j, Y");
  $body->add_key('currentdate',$currentdate);
  $body->add_key('todaydisposed',$disposed);
  $body->add_key('todaydisposedwidth',intval(($disposed/$dailytargetleads)*100));
  $body->add_key('todaycontacted',$contacted);
  $body->add_key('todayuncontacted',$uncontacted);
  $todaytotal = $contacted + $uncontacted;
  $body->add_key('todaytotal',$todaytotal);
  if ($todaytotal==0) {
    $body->add_key('todaycontactedwidth',0);
    $body->add_key('todayuncontactedwidth',0);
  } else {
    $body->add_key('todaycontactedwidth',intval(($contacted/$todaytotal)*100));
    $body->add_key('todayuncontactedwidth',intval(($uncontacted/$todaytotal)*100));
  }
  $body->add_key('todayverified',$verified);
  $body->add_key('todayverifiedwidth',intval(($verified/$dailytargetver)*100));
  $body->add_key('todayturnin',$turnin);
  $body->add_key('todayturninwidth',intval(($turnin/$dailytargetturnin)*100));
  $body->add_key('todayapproved',$approved);
  $body->add_key('todayapprovedwidth',intval(($approved/$dailytargetapproval)*100));
  $body->add_key('todaydateupdated',$dateupdated);
  $nextupdatediff = strtotime($nextupdate)-time();
  $nextupdate = intval($nextupdatediff/60);
  if ($nextupdate>0) {
    if ($nextupdate==1) {
      $nextupdate = strval($nextupdate) . ' minute';
    } else {
      $nextupdate = strval($nextupdate) . ' minutes';
    }
  } else {
    if ($nextupdatediff>1) {
      $nextupdate = strval($nextupdatediff % 60) . ' seconds';
    } else {
      $nextupdate = strval($nextupdatediff % 60) . ' second';
    }
  }
  $body->add_key('todaynextupdate',$nextupdate);
?>