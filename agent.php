<?php

require_once("includes/cookie.php");
require_once("includes/template.php");

$body = new Template();
$cookie = new CookieInfo("CMS1");

// check existing credentials before proceeding with tha application
// redirect to login if no valid credentials found 
if ($cookie->check()) {
	$cookie->getcookies();
  $userid = $cookie->array['userid'];
  $teamid = $cookie->array['teamid'];
  $extension = $cookie->array['extension'];
  $hostaddress = $cookie->array['hostaddress'];
  $body->add_key('userid',$userid);
	$body->add_key('firstname',$cookie->array['firstname']);
	$body->add_key('lastname',$cookie->array['lastname']);
  $body->add_key('extension',$extension);
  $body->add_key('hostaddress',$hostaddress);
  $body->add_key('teamid',$teamid);
} else {
  header('Location: index.php');
}

// set the header menu
$body->set_template("templates/agent/header.html");
echo $body->create();

//set the main content
$page = isset($_REQUEST['show']) ? strtolower(str_replace("'","",$_REQUEST['show'])) : 'dashboard';
$body->add_key('mainpage',$_SERVER['SCRIPT_NAME']);
$body->add_key('workingfolder',$page);
switch($page){
  case 'dashboard':
    $body->set_template("templates/agent/dashboard.html");
    include('scripts/agent/dashboard.php');
    break;
  case 'search':
    if (isset($_REQUEST['searchname'])) {
      $body->set_template("templates/agent/searchresults.html");
      include('scripts/agent/search.php');
      $body->add_key('searchname',$_REQUEST['searchname']);
      break;
    } else if (isset($_REQUEST['leadid'])) {
      $body->set_template("templates/agent/clientform.html");
      include('scripts/agent/clientinfo.php');
      break;
    } else {
      $body->set_template("templates/agent/search.html");
      break;
    }
  case 'settings':
    $body->set_template("templates/agent/usersettings.html");
    if (isset($_REQUEST['msg'])){
      $body->add_key('msg',$_REQUEST['msg']);
    } else {
      $body->add_key('msg','');
    }
    break;
  case 'fl':
    $body->set_template("templates/agent/clientform.html");
    include('scripts/agent/fl.php');
    break;
  case 'clientinfo':
    $body->set_template("templates/agent/clientform.html");
    include('scripts/agent/clientinfo.php');
    break;
  default:
    if (isset($_REQUEST['leadid'])) {
      $body->set_template("templates/agent/clientform.html");
      include('scripts/agent/clientinfo.php');
    } else {
      $dispo = str_replace('_',' ',$page);
      $body->set_template("templates/agent/gridview.html");
      include('scripts/agent/gridview.php');
    }
}
echo $body->create();

// set the footer, if any.
$body->set_template("templates/agent/footer.html");
echo $body->create();

?>