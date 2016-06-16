<?php

require_once("dbase.php");
require_once("settings.php");
require_once("encryption.php");

class UserClass {
  
  function dologin($username, $password) {
		$enc = new Encryption();
		$password = $enc->oneway_encode($password);
    $db = new dbconnection();
    $db->dbconnect();
    $db->query = "select * from ".TABLE_USERS." where username='$username' and password='$password'";
    $db->execute();
    if ($db->rowcount() > 0) {
      $row = $db->fetchrow(0);
      $userid = $row['userid'];
      $ipaddr = $_SERVER['REMOTE_ADDR'];
      $lastlogin = Date("Y-m-d H:i:s");
      $db->query = "update ".TABLE_USERS." set lastlogin='$lastlogin' where userid=$userid";
      $db->execute();
      $db->query = "insert into ".TABLE_USERLOGS." (userid,ipaddress,logdate,action)
        values ($userid,'$ipaddr','$lastlogin','LOGIN')
        ";
      $db->execute();
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
      $db->query = "insert into ".TABLE_USERLOGS." (userid,ipaddress,logdate,action)
        values ($userid,'$ipaddr','$lastlogin','LOGOUT')
        ";
        echo $db->query;
      $db->execute();
      return true;
    } else {
      return false;
    }
  }
  
  function changepassword($userid,$oldpass,$newpass,$newpassrepeat) {
    if ($newpass == $newpassrepeat) {
      $enc = new Encryption();
      $db = new dbconnection();
      $db->dbconnect();
      //check oldpass, update password if ok, send message if not
      $password = $enc->oneway_encode($oldpass);
      $db->query = "select userid from ".TABLE_USERS." where userid=$userid and password='$password'";
      $db->execute();
      if ($db->rowcount() > 0) {
        $newpass = $enc->oneway_encode($newpass);
        $db->query = "update ".TABLE_USERS." set password='$newpass' where userid=$userid";
        $db->execute();
        $msg = 'Password updated.';
      } else {
        $msg = 'Incorrect old password.';
      }
    } else {
      $msg = 'New password does not match.';
    }
    return $msg;
  }
  
}



?>