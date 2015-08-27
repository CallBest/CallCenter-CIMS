<?php

require_once("dbase.php");
require_once("settings.php");

class UserClass {
  
  function dologin($username, $password) {
    $db = new dbconnection();
    $db->dbconnect();
    $db->query = "select * from CMS.users where username='$username' and password='$password'";
    $db->execute();
    if ($db->rowcount() > 0) {
      $row = $db->fetchrow(0);
      $userid = $row['userid'];
      $ipaddr = $_SERVER['REMOTE_ADDR'];
      $lastlogin = Date("Y-m-d H:i:s");
      $db->query = "update CMS.users set lastlogin='$lastlogin' where userid=$userid";
      $db->execute();
      $db->query = "insert into CMSLogs.agentlog (userid,ipaddress,logdate,agentaction)
        values ($userid,'$ipaddr','$lastlogin','LOGIN')
        ";
      $db->execute();
      echo $db->query;
      return $row;
    } else {
      $db->dbclose();
      return false;
    }
  }

  function dologout($userid) {
    if ($userid > 0) {
      $db = new dbconnection();
      $db->dbconnect();
      $ipaddr = $_SERVER['REMOTE_ADDR'];
      $lastlogin = Date("Y-m-d H:i:s");
      $db->query = "insert into CMSLogs.agentlog (userid,ipaddress,logdate,agentaction)
        values ($userid,'$ipaddr','$lastlogin','LOGOUT')
        ";
      $db->execute();
      return true;
    } else {
      return false;
    }
  }
  
}



?>