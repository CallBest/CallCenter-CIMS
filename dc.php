<?php

require_once("includes/cookie.php");
require_once("includes/template.php");

$body = new Template("templates/admin.html");

$cookie = new CookieInfo("CMS");

if ($cookie->check()) {
	$cookie->getcookies();
	$body->add_key('firstname',$cookie->array['firstname']);
	$body->add_key('lastname',$cookie->array['lastname']);
}

if (isset($_REQUEST['show'])) {
  $show = $_REQUEST['show'];
  if (isset($_REQUEST['act'])) {
    $act = $_REQUEST['act'];
  } else {
    $act = '';
  }
  switch ($show) {
    case 'users':
      switch ($act) {
        case 'add':
          $content = new Template('templates/admin/adduser.html');
          $body->add_key('content',$content->create());
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
    case 'departments':
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
    case 'customers':
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
    case 'jobs':
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
    case 'statuses':
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
  $content = new Template('templates/admin/dashboard.html');
  $body->add_key('content',$content->create());
}

echo $body->create();

?>