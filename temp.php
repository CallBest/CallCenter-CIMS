<?php

require_once("includes/encryption.php");
$enc = new Encryption();
echo $enc->oneway_encode('pass');

?>

