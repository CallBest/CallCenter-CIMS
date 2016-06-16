<?php

function phonelist($phone_array) {
  $list = array();
  $newlist = array();
  foreach ($phone_array as $item) {
    $item = str_replace("(","",$item);
    $item = str_replace(")","",$item);
    $item = str_replace("-","",$item);
    $item = str_replace(" ","",$item);
    $item = str_replace(" ","",$item);
    $item = str_replace(" ","",$item);
    $item = str_replace(" ","",$item);
    $item = str_replace(" ","",$item);

    //remove 0
    if (strpos($item,"0")===0) {
      $item = substr($item,1,strlen($item));
    }

    if ($item<>"") {
      if (strpos($item,"/")) {
        $list = array_merge($list,explode("/",$item));
      } else {
        $list[] = $item;
      }
    }
  }
  return $list;
}

?>