<?php
/*------------------------------------------------------
 *	Encryption class (temporary)
 *------------------------------------------------------
 */
 
define("CRYPT_KEY", "merchantsrock");

class Encryption {
	function encode($string) {
		return base64_encode($string);
	}
	
	function decode($string) {
		return base64_decode($string);
	}
	
	function oneway_encode($string) {
		return crypt(md5(CRYPT_KEY), md5($string));
	}
}

?>