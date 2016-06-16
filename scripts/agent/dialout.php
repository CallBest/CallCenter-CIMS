<?php
require_once("../../includes/settings.php");
$ext = $_REQUEST["ext"];
$num = str_replace(" ","",$_REQUEST["num"]);
$hos = $_REQUEST["hostadd"];
$leadid = $_REQUEST["appid"];

$handle = fsockopen("$hos",5038,$errno,$errstr,30);

$localpos = strpos(strtoupper($num),"L");
if (!($localpos===false)) {
	$num = substr($num,0,$localpos);
}

fputs($handle,"Action: Login\r\n");
fputs($handle,"Username: astman\r\n");
fputs($handle,"Secret: n3tw0rk+\r\n");
fputs($handle,"\r\n");

fputs($handle,"Action: Originate\r\n");
fputs($handle,"Channel: SIP/".$ext."\r\n");
fputs($handle,"Exten: 72771".$num."\r\n");
fputs($handle,"Context: default\r\n");
fputs($handle,"CallerID: \"027716130\" <".$num.">\r\n");
fputs($handle,"Priority: 1\r\n");
fputs($handle,"Account: $ext\r\n");
fputs($handle,"Async: 1\r\n");
fputs($handle,"Timeout: 30000\r\n");
fputs($handle,"\r\n");

fputs($handle,"Action: Logoff\r\n\r\n");
fclose($handle);
?>
