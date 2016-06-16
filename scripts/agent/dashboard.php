<?php
  // do not set 0 to these 4 variables!
  $dailytargetleads = 250;
  $dailytargetver = 15;
  $dailytargetturnin = 8;
  $dailytargetapproval = 3;

  require_once("includes/dbase.php");
  require_once("includes/settings.php");
  
  $db = new dbconnection();
  $db->dbconnect();
  
  $db->query = "
    select * from " . TABLE_AGENTDASH . "
    where agent=$userid and reporttype='Daily'
    ";
  $db->execute();
  if  ($db->rowcount()==0) {
    $db->query = "
      insert into " . TABLE_AGENTDASH . " (agent,reporttype)
      values ($userid,'Daily')
      ";
    $db->execute();
    $db->query = "
      select * from " . TABLE_AGENTDASH . "
      where agent=$userid and reporttype='Daily'
      ";
    $db->execute();
  }
  $row = $db->fetchrow(0);
  $now = Date("Y-m-d H:i:s");
  $datenow = Date("Y-m-d");
  $nextupdate = Date("Y-m-d H:i:s",mktime(Date("H"),Date("i")+10,Date("s"),Date("m"),Date("d"),Date("Y")));
  if ($row['nextupdate']<$now) {
    $db->query = "
      select
      (select count(leadid) from " . TABLE_CLIENTS . " where agent=$userid and tagdate>'$datenow') as disposed,
      (select count(leadid) from " . TABLE_CLIENTS . " where agent=$userid and tagdate>'$datenow' and disposition in (select disposition from " . TABLE_DISPO . " where livecall=1 or campaignid>2)) as contacted,
      (select count(leadid) from " . TABLE_CLIENTS . " where agent=$userid and tagdate>'$datenow' and disposition in (select disposition from " . TABLE_DISPO . " where livecall=0 and campaignid=1)) as uncontacted,
      (select count(leadid) from " . TABLE_CLIENTS . " where agent=$userid and tagdate>'$datenow' and disposition in (select disposition from " . TABLE_DISPO . " where disposition='Verified' or campaignid>2)) as verified,
      (select count(leadid) from " . TABLE_CLIENTS . " where agent=$userid and dateverified>'$datenow' and disposition in (select disposition from " . TABLE_DISPO . " where disposition='Turn-in')) as turnin,
      (select count(leadid) from " . TABLE_CLIENTS . " where agent=$userid and dateconfirmed>'$datenow' and disposition in (select disposition from " . TABLE_DISPO . " where disposition='Approved')) as approved
      ";
    $db->execute();
    if ($db->rowcount()==1) {
      $row = $db->fetchrow(0);
      $disposed = $row['disposed'];
      $contacted = $row['contacted'];
      $uncontacted = $row['uncontacted'];
      $verified = $row['verified'];
      $turnin = $row['turnin'];
      $approved = $row['approved'];
      $dateupdated = $now;
      $nextupdate = $nextupdate;
    } else {
      $disposed = 0;
      $contacted = 0;
      $uncontacted = 0;
      $verified = 0;
      $turnin = 0;
      $approved = 0;
      $dateupdated = 'Nan';
      $nextupdate = 'Nan';
    }
    $db->query = "
      update " . TABLE_AGENTDASH . "
        set
        disposed=$disposed,
        contacted=$contacted,
        uncontacted=$uncontacted,
        verified=$verified,
        turnin=$turnin,
        approved=$approved,
        dateupdated='$now',
        nextupdate='$nextupdate'
        where agent=$userid and reporttype='Daily'
      ";
    $db->execute();
  } else {
    $row = $db->fetchrow(0);
    $disposed = $row['disposed'];
    $contacted = $row['contacted'];
    $uncontacted = $row['uncontacted'];
    $verified = $row['verified'];
    $turnin = $row['turnin'];
    $approved = $row['approved'];
    $dateupdated = $row['dateupdated'];
    $nextupdate = $row['nextupdate'];
  }
  
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