<?php 

class Template {
	protected $file;
	protected $values = array();
	var $output;

	public function __construct($file) {
			$this->file = $file;
			if (!file_exists($this->file)) {
					return "Error loading template file ($this->file).<br />";
			}
			$this->output = file_get_contents($this->file);
	}
	 
	public function set($key, $value) {
			$this->values[$key] = $value;
	}

	public function add_keys($array) {
			$this->values = array_merge($this->values,$array);
	}

	public function add_key($key, $value) {
			if (!array_key_exists($key, $this->values)) {
					$array[$key] = $value;
					$this->values = array_merge($this->values, $array);
			}
	}

	public function loop($tag,$array) {
			if (is_array($array)) {
					$list = "";
					preg_match_all("/<loop ".$tag.">(.*)<\/loop>/s",$this->output, $tloop);
					foreach ($array as $arrkey => $arrval) {
							$temp = $tloop[0][0];
							foreach ($arrval as $field => $tablevalue) {
									$tagToReplace = "{@$field}";
									$temp = str_replace($tagToReplace, $tablevalue, $temp);
							}   
							$list .= $temp;
					}
			}
			
			$this->output = str_replace($tloop[0][0],$list,$this->output);
	}

	public function create() {
			foreach ($this->values as $key => $value) {
					$tagToReplace = "{@$key}";
					$this->output = str_replace($tagToReplace, $value, $this->output);
			}
	  
			echo $this->output;
	}
	
}

?>