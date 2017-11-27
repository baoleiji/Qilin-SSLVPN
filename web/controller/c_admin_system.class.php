<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_system extends c_base {
	function index() {
		$table_list = $this->get_table_list(0);
		$this->assign('alltable', $table_list);
		$applogtable_list = $this->get_applogtable_list(0);
		$this->assign('allapplogtable', $applogtable_list);

		$r_table_list = $this->get_table_list(1);
		$this->assign('r_alltable', $r_table_list);
		$r_applogtable_list = $this->get_applogtable_list(1);
		$this->assign('r_allapplogtable', $r_applogtable_list);
		
		$this->display('system.tpl');
	}	

	function ctime() {
		$pc = explode(" ", get_request('dt', 1, 1));
		if(!ereg("/", $pc[0])) {			
			$pc[0] = strtr($pc[0],"-","/");
			exec("/usr/bin/sudo /bin/date -s $pc[0]");
			exec("/usr/bin/sudo /bin/date -s $pc[1]");
			exec("/sbin/clock -w");
			alert_and_back("系统时间更新为:" . get_request('dt', 1, 1), 'admin.php?controller=admin_system'); 
		}
	}
	
	function backup() {
		global $dbname;
	
		$table_name = $this->logs_set->get_table_name();
		$tmp_table_name = 'temp' . $table_name;
		$today_table_name = $table_name . date("Ymd");

		//Query if today's table exists
		$query = "SHOW TABLES FROM `$dbname` LIKE '$today_table_name'";
		$result = $this->logs_set->base_select($query);
		if($result != NULL) {
			alert_and_back("今天已经备份过了!", 'admin.php?controller=admin_system');
			exit();
		}
		// Drop temp table if it exists

		$query = "DROP TABLE IF EXISTS `$tmp_table_name`";
		$this->logs_set->query($query);

		// Create new temp table
		$query = "SHOW CREATE TABLE `$table_name`";

		$result = $this->logs_set->base_select($query);
		$query = $result[0]['Create Table'];
		$search = "CREATE TABLE `$table_name`";
		$replace = "CREATE TABLE `$tmp_table_name`";
		$query = str_replace($search, $replace, $query);
		$result = $this->logs_set->query($query);
		if($result !== false) {
			//echo "<br \>成功创建临时表!<br \>";
		}
		else {
			alert_and_back("创建临时表失败!");
			exit();
		}
		// Rename the two tables
		$query = "RENAME TABLE `$dbname`.`$table_name` TO `$dbname`.`$today_table_name`, `$dbname`.`$tmp_table_name` TO `$dbname`.`$table_name`";
		$result = $this->logs_set->query($query);
		if($result !== false) {
			//echo "<br \>重命名表成功!<br \>";
		}
		else {
			alert_and_back("重命名表失败!");
			exit();	
		}
		$query = "OPTIMIZE TABLE `$dbname`.`$today_table_name`";
		$result = $this->logs_set->query($query);

		if($result !== false) {
			//echo "<br \>优化$dbname.{$today_table_name}成功!<br \>";
		}
		else {
			alert_and_back("优化$dbname.{$today_table_name}失败!");
			exit();	
		}
		alert_and_back("备份成功完成!", 'admin.php?controller=admin_system');
	}

	function applog() {
		global $dbname;
	
		$table_name = $this->applog_set->get_table_name();
		$tmp_table_name = 'temp' . $table_name;
		$today_table_name = $table_name . date("Ymd");

		//Query if today's table exists
		$query = "SHOW TABLES FROM `$dbname` LIKE '$today_table_name'";
		$result = $this->applog_set->base_select($query);
		if($result != NULL) {
			alert_and_back("今天已经备份过了!", 'admin.php?controller=admin_system');
			exit();
		}
		// Drop temp table if it exists

		$query = "DROP TABLE IF EXISTS `$tmp_table_name`";
		$this->applog_set->query($query);

		// Create new temp table
		$query = "SHOW CREATE TABLE `$table_name`";

		$result = $this->applog_set->base_select($query);
		$query = $result[0]['Create Table'];
		$search = "CREATE TABLE `$table_name`";
		$replace = "CREATE TABLE `$tmp_table_name`";
		$query = str_replace($search, $replace, $query);
		$result = $this->applog_set->query($query);
		if($result !== false) {
			//echo "<br \>成功创建临时表!<br \>";
		}
		else {
			alert_and_back("创建临时表失败!");
			exit();
		}
		// Rename the two tables
		$query = "RENAME TABLE `$dbname`.`$table_name` TO `$dbname`.`$today_table_name`, `$dbname`.`$tmp_table_name` TO `$dbname`.`$table_name`";
		$result = $this->applog_set->query($query);
		if($result !== false) {
			//echo "<br \>重命名表成功!<br \>";
		}
		else {
			alert_and_back("重命名表失败!");
			exit();	
		}
		$query = "OPTIMIZE TABLE `$dbname`.`$today_table_name`";
		$result = $this->applog_set->query($query);

		if($result !== false) {
			//echo "<br \>优化$dbname.{$today_table_name}成功!<br \>";
		}
		else {
			alert_and_back("优化$dbname.{$today_table_name}失败!");
			exit();	
		}
		alert_and_back("备份成功完成!", 'admin.php?controller=admin_system');
	}

	function cntp() {
		$pc = get_request('ntp', 1, 1);
		exec("/usr/sbin/ntpdate $pc");
		$now = exec('/bin/date');
		alert_and_back("系统时间更新为:" . $now, 'admin.php?controller=admin_system'); 

	}

	function reboot() {
		alert_and_back("系统重启中...", 'admin.php?controller=admin_system'); 
	}
	
	function reload() {
		exec("sudo /usr/bin/killall /opt/freesvr/log/sbin/log");
		exec("sudo /opt/freesvr/log/sbin/log -f /opt/freesvr/log/etc/log.conf");
	
		alert_and_back("日志服务重启完毕!", 'admin.php?controller=admin_system'); 
			
	}

	function get_table_list($r=0) {
		if($r){
			global $log_dbhost, $log_dbuser, $log_dbpwd, $log_dbname, $log_dbcharset;
			$link = mysql_connect($log_dbhost, $log_dbuser, _encrypt($log_dbpwd, 'D', 'freesvr' )) or die(mysql_error());

			mysql_select_db($log_dbname) or die(mysql_error());
			mysql_query("SET character_set_connection=$log_dbcharset, character_set_results=$log_dbcharset, character_set_client=binary");
		}
		global $dbname;
		$result = $this->logs_set->base_select("SHOW TABLES LIKE 'log_logs%'");
		$table_list = array();
		foreach($result as $table_name) {
			if(preg_match('/^[0-9]{8}$/', substr($table_name["Tables_in_$dbname (log_logs%)"], 8)))
			$table_list[] = $table_name["Tables_in_$dbname (log_logs%)"];
		}
		return $table_list;	
	}

	function get_applogtable_list() {
		if($r){
			global $log_dbhost, $log_dbuser, $log_dbpwd, $log_dbname, $log_dbcharset;
			$link = mysql_connect($log_dbhost, $log_dbuser, _encrypt($log_dbpwd, 'D', 'freesvr' )) or die(mysql_error());

			mysql_select_db($log_dbname) or die(mysql_error());
			mysql_query("SET character_set_connection=$log_dbcharset, character_set_results=$log_dbcharset, character_set_client=binary");
		}
		global $dbname;
		$result = $this->logs_set->base_select("SHOW TABLES LIKE 'applog%'");
		$table_list = array();
		foreach($result as $table_name) {//var_dump($table_name["Tables_in_$dbname (applog%)"]);var_dump(substr($table_name["Tables_in_$dbname (applog%)"], 6));var_dump(preg_match('/^[0-9]{8}$/', substr($table_name["Tables_in_$dbname (applog%)"], 6)));
			if(preg_match('/^[0-9]{8}$/', substr($table_name["Tables_in_$dbname (applog%)"], 6)))
				$table_list[] = $table_name["Tables_in_$dbname (applog%)"];
		}//var_dump($table_list);
		return $table_list;	
	}

	function refresh_host() {
		$this->logs_set->set_table_name(get_request('logstable', 1, 1));
		$result = $this->host_set->select_all();
		$olddev = array();
		if($result) {
			foreach($result as $t) {
				$olddev[] = $t['hname'];
			}
		}

		$dev = $this->logs_set->base_select("SELECT `host` FROM `" . $this->logs_set->get_table_name() . "` GROUP BY `host`");
		if($dev) {
			foreach($dev as $t) {
				$addr = $t['host'];
				if($olddev == NULL || !in_array($addr, $olddev)) {
					$newdev = new host();
					$newdev->set_data('hname', $addr);
					$this->host_set->add($newdev);
				}
			}
		}
		alert_and_back('更新成功!');
	}
	
	function delete_table() {
		//var_dump($_POST);
		$table_name = get_request('table', 1, 1);
		if($this->logs_set->query("DROP TABLE `$table_name`")) {
			alert_and_back("删除数据表{$table_name}成功!", 'admin.php?controller=admin_system');
		}
		else {
			alert_and_back("删除数据表{$table_name}失败!", 'admin.php?controller=admin_system');
		}

	}

	function audit_server2log_hosts() {
		//var_dump($_POST);
		$this->logs_set->query("INSERT INTO log_host(hname, hostname) SELECT device_ip,hostname FROM audit_sec.servers WHERE device_ip NOT IN(SELECT hname FROM host)");
		alert_and_back("操作成功", 'admin.php?controller=admin_system');
	}

	function truncate_alllogs() {
		//var_dump($_POST);
		if($this->logs_set->query("TRUNCATE TABLE `log_alllogs`")) {
			alert_and_back("清空alllogs数据表成功!", 'admin.php?controller=admin_system');
		}
		else {
			alert_and_back("清空alllogs数据表失败!", 'admin.php?controller=admin_system');
		}

	}

	function truncate_applogs() {
		//var_dump($_POST);
		if($this->logs_set->query("TRUNCATE TABLE `applog`")) {
			alert_and_back("清空applogs数据表成功!", 'admin.php?controller=admin_system');
		}
		else {
			alert_and_back("清空applogs数据表失败!", 'admin.php?controller=admin_system');
		}

	}
	
}
?>
