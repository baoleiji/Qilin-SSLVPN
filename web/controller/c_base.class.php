<?php
class c_base {
	protected $smarty;
	protected $config;

	
	function init($smarty, $config) {
		$this->smarty = $smarty;
		$this->config = $config;
		$this->config_type = $config['config_type'];

		$dh = opendir('model/');
		while(false !== ($filename = readdir($dh))) {
			$files[] = $filename;
			if(strpos($filename, '_set') !== false) {
				if($filename != 'base_set.class.php') {
					$filename = substr($filename, 0, strpos($filename, '.'));
					//echo $filename . "<br />";
					if(strpos($filename, '_set') !== false) {
						$this->$filename = new $filename;
					}
				}
			}
		}
		
		$dh = opendir('do_config/');
		while(false !== ($filename = readdir($dh))) {
			$files[] = $filename;
			if(strpos($filename, '.class.php') !== false) {
				$filename = substr($filename, 0, strpos($filename, '.'));
				//echo $filename . "<br />";
				if($filename != '') {
					$this->do_config[$filename] = new $filename;
				}
			}
		}
		$this->assign("site_title", $this->config['site']['title']);
		$this->assign("config", $this->config);
	}

	function assign($key, $value) {
		$this->smarty->assign($key, $value);
	}

	function display($tpl) {
		return $this->smarty->display($tpl);
	}

	function fetch($tpl) {
		return $this->smarty->fetch($tpl);
	}

	function get_set($name) {
		return $this->$name;
	}
	
	function get_user_flist() {
		$member = $this->member_set->select_all(" username = '{$_SESSION['ADMIN_USERNAME']}'");
		$flist = $member[0]['flist'];
		$flist = unserialize($flist);
		if($flist)
		$flist = $this->facility_set->base_select("SELECT ip FROM facility WHERE fid IN (" . implode(",", $flist) . ")");
		$iplist = array();
		if($flist)
		foreach($flist as $t) {
			$iplist[] = "'{$t['ip']}'";
		}
		return $iplist;
	}

	function getInput($varName) {
		$value="";
		if(isset($_COOKIE[$varName])) {
			$value = $_COOKIE[$varName];
		}
		if(isset($_GET[$varName])) {
			$value = $_GET[$varName];
		}
		if(isset($_POST[$varName])) {
			$value = $_POST[$varName];
		}

		if($value && !get_magic_quotes_gpc()) {
			if(!is_array($value)) {
				$value = addslashes($value);
			}
			else {
				foreach($value as $key => $arrValue) {
					$value[$key] = addslashes($arrValue);
				}
			}
		}

		return $value;
	}
}
?>
