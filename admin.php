<?php

require_once("includes/cookie.php");
require_once("includes/template.php");

$body = new Template("templates/admin.html");

$cookie = new CookieInfo("CMS");

if ($cookie->check()) {
	$cookie->getcookies();
	$body->add_key('realname',$cookie->array['realname']);
}

if (isset($_REQUEST['show'])) {
  if (isset($_REQUEST['act'])) {
    $act = $_REQUEST['act'];
  } else {
    $act = '';
  }
  switch ($show) {
    case 'users':
      switch ($act) {
        case 'add':
          break;
        case 'edit':
          break;
        case 'delete':
          break;
        case 'search':
          break;
        default:
        
      }
      break;
    case 'teams':
      switch ($act) {
        case 'add':
          break;
        case 'edit':
          break;
        case 'delete':
          break;
        case 'search':
          break;
        default:
        
      }
      break;
    case 'campaigns':
      switch ($act) {
        case 'add':
          break;
        case 'edit':
          break;
        case 'delete':
          break;
        case 'search':
          break;
        default:
        
      }
      break;
    case 'lists':
      switch ($act) {
        case 'add':
          break;
        case 'edit':
          break;
        case 'delete':
          break;
        case 'search':
          break;
        default:
        
      }
      break;
    case 'dispositions':
      switch ($act) {
        case 'add':
          break;
        case 'edit':
          break;
        case 'delete':
          break;
        case 'search':
          break;
        default:
        
      }
      break;
    case 'reports':
      switch ($act) {
        case 'add':
          break;
        case 'edit':
          break;
        case 'delete':
          break;
        case 'search':
          break;
        default:
        
      }
      break;
    default:
      
  }
} else {
  $body->add_key('content','USERS');
}

$body->create();

?>