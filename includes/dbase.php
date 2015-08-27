<?php

class dbconnection {
	var $connection;
	var $query;
	var $result;
	var $row;

	function dbconnect($host='localhost',$user='cmsonline',$pass='cmsonlineadmin!',$schema='CMSv2') {
		if ($this->connection = @mysql_connect($host, $user, $pass)) {
			@mysql_select_db($schema, $this->connection) or $this->errorout();
		}
		else {
			$this->errorout();
		}
	}
	
	function execute() {
		if (isset($this->result)) {
			@mysql_free_result($this->result);
		}
		if (!$this->result = @mysql_query($this->query, $this->connection)) {
			$this->errorout();
		}
	}
	
	function rowcount() {
		if (isset($this->result)) {
			return @mysql_num_rows($this->result);
		}
		else {
			return -1;
		}
	}

	function dbclose() {
		if (isset($this->result)) {
			@mysql_free_result($this->result);
		}
		@mysql_close($this->connection);
	}
	
	function getfield($field) {
		if (isset($this->result)) {
			@mysql_data_seek($this->result, 0);
			$row = @mysql_fetch_array($this->result);
		}
		return $row[$field];
	}
	
	function dbtablelink($link,$col) {
		if (isset($this->result)) {
			$x=0;
			print "<table border=1 cellspacing=0 cellpadding=5>";
			while(@mysql_data_seek($this->result, $x)) {
				$row = @mysql_fetch_row($this->result);
				print "<tr>";
				for ($i=0;$i<=@mysql_num_fields($this->result);$i++) {
					if (strtolower($col)==strtolower(@mysql_field_name($this->result,$i))) {
							print "<td><a href='$link?$col=$row[$i]'>$row[$i]</a></td>";
					}
					elseif ($row[$i]=="") {
						print "<td>&nbsp;</td>";
					}
					else {
						print "<td>$row[$i]</td>";
					}
				}
				print "</tr>\n";
				$x++;
			}
			print "</table>";
		}
	}
	
	function display() {
		if (isset($this->result)) {
			$x=0;
			print "<table border=1 cellspacing=0 cellpadding=5>";
			while(@mysql_data_seek($this->result, $x)) {
				$row = @mysql_fetch_row($this->result);
				print "<tr>";
				for ($i=0;$i<=@mysql_num_fields($this->result);$i++) {
					if ($row[$i]=="") {
						print "<td>&nbsp;</td>";
					}
					else {
						print "<td>$row[$i]</td>";
					}
				}
				print "</tr>\n";
				$x++;
			}
			print "</table>";
		}
	}
	
	function fetchrow($i) {
		if (isset($this->result)) {
			if (@mysql_data_seek($this->result, $i)) {
				$row = @mysql_fetch_array($this->result);
				return $row;
			}
		}
	}
	
	function errorout() {
		die("Cannot connect to database");
	}
}
?>