<?php
/*------------------------------------------------------
 *	Cookie Classes
 *------------------------------------------------------
 */

define("TIMEOUT", 36000);

include("encryption.php");

class CookieInfo {
	var $array;
	var $name;
	
	function CookieInfo($name) {
		$this->array = array();
		$this->name = $name;
	}
	
	function addkey($key, $value) {
		$array = array($key => $value);
		$this->array = array_merge($this->array, $array);
	}
	
	function merge($array) {
		if (is_array($array)) {
			$this->array = array_merge($this->array, $array);
		}
	}
	
	function setcookies() {
		$crypt = new Encryption();
		foreach ($this->array as $key => $value) {
			setcookie($this->name."[$key]", $crypt->encode($value), time() + TIMEOUT);
		}
	}
	
	function deletecookies() {
		if (isset($_COOKIE[$this->name])) {
			if (is_array($_COOKIE[$this->name])) {
				foreach ($_COOKIE[$this->name] as $key => $value) {
					setcookie($this->name."[$key]", "", time() - 3600);
				}
			}
			else {
				setcookie($this->name, "", time() - 3600);
			}
		}
	}
	
	function getcookies() {
		$crypt = new Encryption();
		$this->array = array();
		if (isset($_COOKIE[$this->name])) {
			foreach ($_COOKIE[$this->name] as $key => $value) {
				$this->array[$key] = $crypt->decode($value);
			}
		}
	}
	
	function check() {
		if (isset($_COOKIE[$this->name])) {
			return true;
		}
		else {
			return false;
		}
	}
}

?>