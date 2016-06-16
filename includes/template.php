<?php 

class Template {
	protected $file;
	protected $values = array();
	var $output;

	public function set_template($file) {
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

	function template_loop($tag,$array,$ads=""){
		// TEMPLATE DURING THE LOOP
		ereg("<loop $tag>(.*)</loop $tag>",$this->output, $tloop);
					
		if (is_array($array)) {
			$ret = '';
			foreach($array as $key => $arr) {
				$temp = $tloop[1];	
				
				foreach ($arr as $arkey => $arval) {
					$temp = str_replace("{@".$arkey."}", $arval, $temp);
				}
				$ret .= $temp;
				//	INSERT ADS
				if($ads){
					$i++;
					$d=(count($array)/2);
					if($i==$d||$i==($d+0.5)){
						$ret.=$ads;
					}
				}
			}
		} else {
			$ret=$ads;
		}			
		$this->output=str_replace($tloop[0], $ret, $this->output);  	  
	}

	public function create() {
			foreach ($this->values as $key => $value) {
					$tagToReplace = "{@$key}";
					$this->output = str_replace($tagToReplace, $value, $this->output);
			}
	  
			return $this->output;
	}
	
}

?>