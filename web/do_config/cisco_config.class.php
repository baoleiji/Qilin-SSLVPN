<?php
class cisco_config {
	function get($facility, $config) {
		global $_CONFIG;
		if(file_exists('tmp/audit.tmp')) {
			unlink('tmp/audit.tmp');
		}
		$localip = $_CONFIG['TFTP_SERVER_IP'];
		$filename = 'audit.' . $facility['ip'] . '.' . $config['name'];
		$localfile = $_CONFIG['TFTP_ROOT'] . '/' . $filename;
		command("touch $localfile", $out);
		command("chmod 777 $localfile", $out);
		$config_type = get_config_type_by_name($config['name']);
		$cmd = "snmpset -v 1 -c {$facility['community']} {$facility['ip']} ";
		$out = '';
		$result = array();
		$ret = command($cmd . '.1.3.6.1.4.1.9.9.96.1.1.1.1.2.83119 i 1', $out);
		if($ret != 0) {
			$result[1] = $out;
			$result[0] = 1;
			command("rm $localfile", $out);
			return $result;
		}
		if($config['name'] == 'running-config') {
			command($cmd . '.1.3.6.1.4.1.9.9.96.1.1.1.1.3.83119 i 4', $out);
		}
		else {
			command($cmd . '.1.3.6.1.4.1.9.9.96.1.1.1.1.3.83119 i 3', $out);
		}
		command($cmd . '.1.3.6.1.4.1.9.9.96.1.1.1.1.4.83119 i 1', $out);
		command($cmd . ".1.3.6.1.4.1.9.9.96.1.1.1.1.5.83119 a $localip", $out);
		command($cmd . ".1.3.6.1.4.1.9.9.96.1.1.1.1.6.83119 s $filename", $out);
		command($cmd . '.1.3.6.1.4.1.9.9.96.1.1.1.1.14.83119 i 1', $out);
		if(!file_exists($localfile)) {
			$result[0] = 1;
			$result[1] = $out;
			return "$localfile Not Found";
		}


		file_put_contents("/tmp/audit.tmp", file_get_contents($localfile));
		command("rm $localfile", $out);
		$result[1] = $out;
		if($ret == 0) {
			$result[0] = 0;
		}
		else {
			$result[0] = 1;
		}
		
		return $result;
	}

	function compare($old, $new) {
		return diff($old, $new);
	}
}
?>
