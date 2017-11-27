<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_search extends c_base {
	function index() {
		if($_SESSION['ADMIN_LEVEL'] == 1) {
			$allhost = $this->server_set->select_all('1=1','device_ip');
		}
		else {
			$user = $this->user_set->select_all("username = '" . $_SESSION['ADMIN_USERNAME'] ."'");
			
	//		$all = $this->relationlog_set->base_select("SELECT t.*,t2.desc FROM `relationlog` t left join `relation` t2 on(t.relationid=t2.seq) WHERE $query ORDER BY `seq` desc LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
			
			
			$hostlist = $user[0]['hostlist'];
			if($hostlist != '') {
				$hostlist = explode('||', $hostlist);
				$query = " `group` in ('".implode("','", $hostlist)."')";
				$allhost = $this->host_set->select_all($query,'hname');
				
			}
		}

		global $log_dbhost, $log_dbuser, $log_dbpwd, $log_dbname, $log_dbcharset;
		$link = mysql_connect($log_dbhost, $log_dbuser, _encrypt($log_dbpwd, 'D', 'freesvr' )) or die(mysql_error());

		mysql_select_db($log_dbname) or die(mysql_error());
		mysql_query("SET character_set_connection=$log_dbcharset, character_set_results=$log_dbcharset, character_set_client=binary");

		$table_list = $this->get_table_list();
		
		$this->assign('level', $_SESSION['ADMIN_LEVEL']);
		$this->assign('allhost', $allhost);
		$this->assign("table_list", $table_list);
		$this->display("search.tpl");	
	}

	//------------------------------------------------------------------------
	// Function used to retrieve input values and if neccessary add slashes.
	//------------------------------------------------------------------------
	function get_input($varName) {
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


	//------------------------------------------------------------------------
	// Function used to validate user supplied variables.
	//------------------------------------------------------------------------
	function validate_input($value, $regExpName) {
		return true;
		global $regExpArray;

		if(!$regExpArray[$regExpName]) {
			return FALSE;
		}

		if(is_array($value)) {
			foreach($value as $arrval) {
				if(!preg_match("$regExpArray[$regExpName]", $arrval)) {
					return FALSE;
				}
			}
			return TRUE;
		}
		elseif(preg_match("$regExpArray[$regExpName]", $value)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	function get_where_for_level($where) {
		if($_SESSION['ADMIN_LEVEL'] == 0) {
			$user = $this->user_set->select_all("username = '" . $_SESSION['ADMIN_USERNAME'] . "'");
			$hostlist = $user[0]['hostlist'];
			if($hostlist) {
				$hostlist = explode('||', $hostlist);
				$hostlist = implode("','", $hostlist);
				$hostlist = "'" . $hostlist . "'";
				if($where != '') {
					$where .= " AND host IN($hostlist)";
				}
				else {
					$where .= " host IN($hostlist)";
				}
			}
			else {
				if($where != '') {
					$where .= " AND 0";
				}
				else {
					$where = ' 0';
				}
			}
			return $where;
		}
		else {
			return $where;
		}
	}
	function search() {
	//	$this->display('include/header.tpl');
		global $log_dbhost, $log_dbuser, $log_dbpwd, $log_dbname, $log_dbcharset;
		$link = mysql_connect($log_dbhost, $log_dbuser, _encrypt($log_dbpwd, 'D', 'freesvr' )) or die(mysql_error());

		mysql_select_db($log_dbname) or die(mysql_error());
		mysql_query("SET character_set_connection=$log_dbcharset, character_set_results=$log_dbcharset, character_set_client=binary");
		
		$limit =  $this->get_input('limit');
		$offset = $this->get_input('offset');

		//========================================================================
		// BEGIN: GET THE INPUT VARIABLES
		//========================================================================

		
		$type = $this->get_input('type');
		$host = $this->get_input('host');
		
		if($_SESSION['ADMIN_LEVEL']==0&&!$host){
			alert_and_back('请选择要查询的主机地址');
		}
		
		$host2 = $this->get_input('host2');
		$excludeHost = $this->get_input('excludeHost');
		$facility = $this->get_input('facility');
		$excludeFacility = $this->get_input('excludeFacility');
		$priority = $this->get_input('priority');
		$excludePriority = $this->get_input('excludePriority');
		$datetime = $this->get_input('datetime');
		$datetime2 = $this->get_input('datetime2');
 
		$orderby = $this->get_input('orderby');
		$order = $this->get_input('order');
		
	
		
		if(!$offset) {
			$offset = 0;
		}
		$collapse = $this->get_input('collapse');
		$table = $this->get_input('table');

		// Set an arbitrary number of msg# and ExcludeMsg# vars
		$msgvarnum=1;
		$msgvarname="msg".$msgvarnum;
		$excmsgvarname="ExcludeMsg".$msgvarnum;

		while($this->get_input($msgvarname)) {
			${$msgvarname} = $this->get_input($msgvarname);
			${$excmsgvarname} = $this->get_input($excmsgvarname);

			$msgvarnum++;
			$msgvarname="msg".$msgvarnum;
			$excmsgvarname="ExcludeMsg".$msgvarnum;
		}
		//========================================================================
		// END: GET THE INPUT VARIABLES
		//========================================================================


		//========================================================================
		// BEGIN: INPUT VALIDATION
		//========================================================================
		$inputValError = array();

		if($excludeHost && !$this->validate_input($excludeHost, 'excludeX')) {
			array_push($inputValError, "excludeHost");
		}
		if($host && !$this->validate_input($host, 'host')) {
			array_push($inputValError, "host1");
		}
		if($host2 && !$this->validate_input($host2, 'host')) {
			array_push($inputValError, "host2");
		}
		if($excludeFacility && !$this->validate_input($excludeFacility, 'excludeX')) {
			array_push($inputValError, "excludeFacility");
		}
		if($facility && !$this->validate_input($facility, 'facility')) {
			array_push($inputValError, "facility");
		}
		if($excludePriority && !$this->validate_input($excludePriority, 'excludeX')) {
			array_push($inputValError, "excludePriority");
		}
		if($priority && !$this->validate_input($priority, 'priority')) {
			array_push($inputValError, "priority");
		}


		if($limit && !$this->validate_input($limit, 'limit')) {
			array_push($inputValError, "limit");
		}
		if($orderby && !$this->validate_input($orderby, 'orderby')) {
			array_push($inputValError, "orderby");
		}
		if($order && !$this->validate_input($order, 'order')) {
			array_push($inputValError, "order");
		}
		if(!$this->validate_input($offset, 'offset')) {
			array_push($inputValError, "offset");
		}
		if($collapse && !$this->validate_input($collapse, 'collapse')) {
			array_push($inputValError, "collapse");
		}
		if($table && !$this->validate_input($table, 'table')) {
			array_push($inputValError, "table");
		}

		if($inputValError) {
			echo "Input validation error! The following fields had the wrong format:<p>";
			foreach($inputValError as $value) {
				echo $value."<br>";
			}
			require_once 'template/admin/include/footer.tpl';
			exit;
		}
		//========================================================================
		// END: INPUT VALIDATION
		//========================================================================


		//========================================================================
		// BEGIN: BUILD AND EXECUTE SQL STATEMENT
		// AND BUILD PARAMETER LIST FOR HTML GETS
		//========================================================================
		//------------------------------------------------------------------------
		// Create WHERE statement and GET parameter list
		//------------------------------------------------------------------------
		$where = "";
		$ParamsGET = "&";

		if($table) {
			$ParamsGET=$ParamsGET."table=".$table."&";
		}

		if($limit) {
			$ParamsGET=$ParamsGET."limit=".$limit."&";
		}

		if($orderby) {
			$ParamsGET=$ParamsGET."orderby=".$orderby."&";
		}

		if($order) {
			$ParamsGET=$ParamsGET."order=".$order."&";
		}

		if($collapse) {
			$ParamsGET=$ParamsGET."collapse=".$collapse."&";
		}

		if($pageId) {
			$ParamsGET=$ParamsGET."pageId=".$pageId."&";
		}

		if($host2) {
			if ($where!="") {
				$where=$where." and ";
			}
			if($excludeHost==1) {
				$where = $where." host not like '%".$host2."%' ";
			}
			else {
				$where = $where." host like '%".$host2."%' ";
			}
			$ParamsGET=$ParamsGET."host2=".$host2."&excludeHost=".$excludeHost."&";
		}	

		if($host) {
			$hostGET=implode("&host[]=",$host);
			$hostSQL=implode("','",$host);
			if($where!="") {
				$where = $where." and ";
			}
			if($excludeHost==1) {
				$where = $where." host not in ('".$hostSQL."') ";
			}
			else {
				$where = $where." host in ('".$hostSQL."') ";
			}
			$ParamsGET=$ParamsGET."host[]=".$hostGET."&excludeHost=".$excludeHost."&";	
		}

		if($facility) {
			$facilityGET=implode("&facility[]=",$facility);
			$facilitySQL=implode("','",$facility);
			if($where!="") {
				$where = $where." and ";
			}
			if($excludeFacility==1) {
				$where = $where." facility not in ('".$facilitySQL."') ";
			}
			else {
				$where = $where." facility in ('".$facilitySQL."') ";
			}
			$ParamsGET=$ParamsGET."facility[]=".$facilityGET."&excludeFacility=".$excludeFacility."&";
		}

		if($priority) {
			$priorityGET=implode("&priority[]=",$priority);
			$prioritySQL=implode("','",$priority);
			if($where!="") {
				$where = $where." and ";
			}
			if($excludePriority==1) {
				$where = $where." priority not in ('".$prioritySQL."') ";
			}
			else {
				$where = $where." priority in ('".$prioritySQL."') ";
			}
			$ParamsGET=$ParamsGET."priority[]=".$priorityGET."&excludePriority=".$excludePriority."&";
		}


		if($datetime) {
			$ParamsGET=$ParamsGET."datetime=".$datetime."&";

		}
		if($datetime2) {
			$ParamsGET=$ParamsGET."datetime2=".$datetime2."&";

		}

		if($datetime && $datetime2) {
			if($where != "") {
				$where = $where." and ";
			}
			$where = $where." datetime between '".$datetime."' and '".$datetime2."' ";
		}
		elseif($datetime) {
			if($where != "") {
				$where = $where." and ";
			}
			$where = $where." datetime > '".$datetime."' ";
		}
		elseif($datetime2) {
			if($where != "") {
				$where = $where." and ";
			}
			$where = $where." datetime < '".$datetime2."' ";
		}

		$msgvarnum=1;
		$msgvarname="msg".$msgvarnum;
		$excmsgvarname="ExcludeMsg".$msgvarnum;

		while(${$msgvarname}) {
			if($where !="") {
				$where = $where." and ";
			}
			if(${$excmsgvarname} == "on") {
				$where = $where." msg not like '%".${$msgvarname}."%' ";
				$ParamsGET=$ParamsGET.$excmsgvarname."=".${$excmsgvarname}."&";
			}
			else {
				$where = $where." msg like '%".${$msgvarname}."%' ";
			}
			$ParamsGET=$ParamsGET.$msgvarname."=".${$msgvarname}."&";
			$msgvarnum++;
			$msgvarname="msg".$msgvarnum;
			$excmsgvarname="ExcludeMsg".$msgvarnum;
		}

		//------------------------------------------------------------------------
		// Create the GET string without host variables
		//------------------------------------------------------------------------
		$pieces = explode("&", $ParamsGET);
		$hostParamsGET = "";
		foreach($pieces as $value) {
			if(!strstr($value, "host[]=") && !strstr($value, 'excludeHost=') && !strstr($value, 'offset=') && $value) {
				$hostParamsGET = $hostParamsGET.$value."&";
			}
		}

		//------------------------------------------------------------------------
		// Create the complete SQL statement
		// SQL_CALC_FOUND_ROWS is a MySQL 4.0 feature that allows you to get the
		// total number of results if you had not used a LIMIT statement. Using
		// it saves an extra query to get the total number of rows.
		//------------------------------------------------------------------------
		if($table) {
			$srcTable = $table;
		}
		else {
			$srcTable = 'logs';
		}

		$query0 = "SELECT count(*) num FROM ".$srcTable." ";
		$query = "SELECT  * FROM ".$srcTable." ";

		if($type == 'today') {
			if($where != '') {
				$where .= " AND DATE(`datetime`) = CURDATE()";
			}
			else {
				$where = "DATE(`datetime`) = CURDATE()";
			}
		}

		$where = $this->get_where_for_level($where);
		
	if($orderby =='id') {
			if($order == 'ASC') {
				$dayuxiaoyu = '>=';
			}
			else {
				$dayuxiaoyu = '<=';
			}

			if($where) {
				$query0 = "$query0 WHERE ($where) AND id $dayuxiaoyu (SELECT id FROM $srcTable WHERE $where ORDER BY id $order LIMIT 1) ORDER BY id $order  ";
			}
			else {
				$query0 = "$query0 WHERE id $dayuxiaoyu (SELECT id FROM $srcTable ORDER BY id $order LIMIT  1) ORDER BY id $order  ";
			}
		}
		else {
			if($where) {
				$query0 = $query0."WHERE ".$where." ORDER BY ".$orderby." ".$order ;
			}
			else {
				$query0 = $query0."ORDER BY ".$orderby." ".$order ;
			}
		}
		//------------------------------------------------------------------------
		// Execute the query
		// The FOUND_ROWS function returns the value from the SQL_CALC_FOUND_ROWS
		// count.
		//------------------------------------------------------------------------
		
		$results = $this->logs_set->query($query0);
		$num_results_array = mysql_fetch_array($results);
	
//		$num_results_array = $this->logs_set->query("SELECT FOUND_ROWS()", $dbLink);
//		$num_results_array = mysql_fetch_array($num_results_array);
		$num_results = $num_results_array['num'];


		$page_num = get_request('page');
		$row_num = $num_results;
			
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		
		$offset = $newpager->intStartPosition;
		$limit = $newpager->intItemsPerPage;

		
		if($orderby =='id') {
			if($order == 'ASC') {
				$dayuxiaoyu = '>=';
			}
			else {
				$dayuxiaoyu = '<=';
			}

			if($where) {
				$query = "$query WHERE ($where) AND id $dayuxiaoyu (SELECT id FROM $srcTable WHERE $where ORDER BY id $order LIMIT $offset, 1) ORDER BY id $order LIMIT $limit";
			}
			else {
				$query = "$query WHERE id $dayuxiaoyu (SELECT id FROM $srcTable ORDER BY id $order LIMIT $offset, 1) ORDER BY id $order LIMIT $limit";
			}
		}
		else {
			if($where) {
				$query = $query."WHERE ".$where." ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$limit;
			}
			else {
				$query = $query."ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$limit;
			}
		}
		
		$results = $this->logs_set->query($query);
	//	echo $query
		$n = 0;
		while($row = mysql_fetch_array($results)) {
				$row['count'] = 1;
				$result_array[$n] = $row;
				$n++;
		}

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('result_array', $result_array);
		$this->display('search_result.tpl');
	
	}
	function get_table_list() {
		global $dbname;
		$result = $this->logs_set->base_select("SHOW TABLES LIKE 'log_logs%'");
		$table_list = array();
		foreach($result as $table_name) {
			$table_list[] = $table_name["Tables_in_$dbname (log_logs%)"];
		}
		return $table_list;	
	}

	

	function export() {
		global $log_dbhost, $log_dbuser, $log_dbpwd, $log_dbname, $log_dbcharset;
		$link = mysql_connect($log_dbhost, $log_dbuser, _encrypt($log_dbpwd, 'D', 'freesvr' )) or die(mysql_error());

		mysql_select_db($log_dbname) or die(mysql_error());
		mysql_query("SET character_set_connection=$log_dbcharset, character_set_results=$log_dbcharset, character_set_client=binary");
		//========================================================================
		// BEGIN: GET THE INPUT VARIABLES
		//========================================================================
		$host = $this->get_input('host');
		$host2 = $this->get_input('host2');
		$excludeHost = $this->get_input('excludeHost');
		$facility = $this->get_input('facility');
		$excludeFacility = $this->get_input('excludeFacility');
		$priority = $this->get_input('priority');
		$excludePriority = $this->get_input('excludePriority');
		$datetime = $this->get_input('datetime');
		$datetime2 = $this->get_input('datetime2');

		$limit = $this->get_input('limit');
		$orderby = $this->get_input('orderby');
		$order = $this->get_input('order');
		$offset = $this->get_input('offset');
		if(!$offset) {
			$offset = 0;
		}
		$collapse = $this->get_input('collapse');
		$table = $this->get_input('table');

		// Set an arbitrary number of msg# and ExcludeMsg# vars
		$msgvarnum=1;
		$msgvarname="msg".$msgvarnum;
		$excmsgvarname="ExcludeMsg".$msgvarnum;

		while($this->get_input($msgvarname)) {
			${$msgvarname} = $this->get_input($msgvarname);
			${$excmsgvarname} = $this->get_input($excmsgvarname);

			$msgvarnum++;
			$msgvarname="msg".$msgvarnum;
			$excmsgvarname="ExcludeMsg".$msgvarnum;
		}
		//========================================================================
		// END: GET THE INPUT VARIABLES
		//========================================================================


		//========================================================================
		// BEGIN: INPUT VALIDATION
		//========================================================================
		$inputValError = array();

		if($excludeHost && !$this->validate_input($excludeHost, 'excludeX')) {
			array_push($inputValError, "excludeHost");
		}
		if($host && !$this->validate_input($host, 'host')) {
			array_push($inputValError, "host1");
		}
		if($host2 && !$this->validate_input($host2, 'host')) {
			array_push($inputValError, "host2");
		}
		if($excludeFacility && !$this->validate_input($excludeFacility, 'excludeX')) {
			array_push($inputValError, "excludeFacility");
		}
		if($facility && !$this->validate_input($facility, 'facility')) {
			array_push($inputValError, "facility");
		}
		if($excludePriority && !$this->validate_input($excludePriority, 'excludeX')) {
			array_push($inputValError, "excludePriority");
		}
		if($priority && !$this->validate_input($priority, 'priority')) {
			array_push($inputValError, "priority");
		}

		if($limit && !$this->validate_input($limit, 'limit')) {
			array_push($inputValError, "limit");
		}
		if($orderby && !$this->validate_input($orderby, 'orderby')) {
			array_push($inputValError, "orderby");
		}
		if($order && !$this->validate_input($order, 'order')) {
			array_push($inputValError, "order"); }
		if(!$this->validate_input($offset, 'offset')) {
			array_push($inputValError, "offset");
		}
		if($collapse && !$this->validate_input($collapse, 'collapse')) {
			array_push($inputValError, "collapse");
		}
		if($table && !$this->validate_input($table, 'table')) {
			array_push($inputValError, "table");
		}

		if($inputValError) {
			require_once 'includes/html_header.php';
			echo "Input validation error! The following fields had the wrong format:<p>";
			foreach($inputValError as $value) {
				echo $value."<br>";
			}
			require_once 'includes/html_footer.php';
			exit;
		}
		//========================================================================
		// END: INPUT VALIDATION
		//========================================================================


		//========================================================================
		// BEGIN: BUILD AND EXECUTE SQL STATEMENT
		// AND BUILD PARAMETER LIST FOR HTML GETS
		//========================================================================
		//------------------------------------------------------------------------
		// Create WHERE statement and GET parameter list
		//------------------------------------------------------------------------
		$where = "";
		$ParamsGET = "&";

		if($table) {
			$ParamsGET=$ParamsGET."table=".$table."&";
		}

		if($limit) {
			$ParamsGET=$ParamsGET."limit=".$limit."&";
		}

		if($orderby) {
			$ParamsGET=$ParamsGET."orderby=".$orderby."&";
		}

		if($order) {
			$ParamsGET=$ParamsGET."order=".$order."&";
		}

		if($collapse) {
			$ParamsGET=$ParamsGET."collapse=".$collapse."&";
		}

		if($pageId) {
			$ParamsGET=$ParamsGET."pageId=".$pageId."&";
		}

		if($host2) {
			if ($where!="") {
				$where=$where." and ";
			}
			if($excludeHost==1) {
				$where = $where." host not like '%".$host2."%' ";
			}
			else {
				$where = $where." host like '%".$host2."%' ";
			}
			$ParamsGET=$ParamsGET."host2=".$host2."&excludeHost=".$excludeHost."&";
		}	

		if($host) {
			$hostGET=implode("&host[]=",$host);
			$hostSQL=implode("','",$host);
			if($where!="") {
				$where = $where." and ";
			}
			if($excludeHost==1) {
				$where = $where." host not in ('".$hostSQL."') ";
			}
			else {
				$where = $where." host in ('".$hostSQL."') ";
			}
			$ParamsGET=$ParamsGET."host[]=".$hostGET."&excludeHost=".$excludeHost."&";	
		}

		if($facility) {
			$facilityGET=implode("&facility[]=",$facility);
			$facilitySQL=implode("','",$facility);
			if($where!="") {
				$where = $where." and ";
			}
			if($excludeFacility==1) {
				$where = $where." facility not in ('".$facilitySQL."') ";
			}
			else {
				$where = $where." facility in ('".$facilitySQL."') ";
			}
			$ParamsGET=$ParamsGET."facility[]=".$facilityGET."&excludeFacility=".$excludeFacility."&";
		}

		if($priority) {
			$priorityGET=implode("&priority[]=",$priority);
			$prioritySQL=implode("','",$priority);
			if($where!="") {
				$where = $where." and ";
			}
			if($excludePriority==1) {
				$where = $where." priority not in ('".$prioritySQL."') ";
			}
			else {
				$where = $where." priority in ('".$prioritySQL."') ";
			}
			$ParamsGET=$ParamsGET."priority[]=".$priorityGET."&excludePriority=".$excludePriority."&";
		}



		if($datetime) {
			$ParamsGET=$ParamsGET."datetime=".$datetime."&";

		}
		if($datetime2) {
			$ParamsGET=$ParamsGET."datetime2=".$datetime2."&";
		}

		if($datetime && $datetime2) {
			if($where != "") {
				$where = $where." and ";
			}
			$where = $where." datetime between '".$datetime."' and '".$datetime2."' ";
		}
		elseif($datetime) {
			if($where != "") {
				$where = $where." and ";
			}
			$where = $where." datetime > '".$datetime."' ";
		}
		elseif($datetime2) {
			if($where != "") {
				$where = $where." and ";
			}
			$where = $where." datetime < '".$datetime2."' ";
		}

		$msgvarnum=1;
		$msgvarname="msg".$msgvarnum;
		$excmsgvarname="ExcludeMsg".$msgvarnum;

		while(${$msgvarname}) {
			if($where !="") {
				$where = $where." and ";
			}
			if(${$excmsgvarname} == "on") {
				$where = $where." msg not like '%".${$msgvarname}."%' ";
				$ParamsGET=$ParamsGET.$excmsgvarname."=".${$excmsgvarname}."&";
			}
			else {
				$where = $where." msg like '%".${$msgvarname}."%' ";
			}
			$ParamsGET=$ParamsGET.$msgvarname."=".${$msgvarname}."&";
			$msgvarnum++;
			$msgvarname="msg".$msgvarnum;
			$excmsgvarname="ExcludeMsg".$msgvarnum;
		}

		//------------------------------------------------------------------------
		// Create the GET string without host variables
		//------------------------------------------------------------------------
		$pieces = explode("&", $ParamsGET);
		$hostParamsGET = "";
		foreach($pieces as $value) {
			if(!strstr($value, "host[]=") && !strstr($value, 'excludeHost=') && !strstr($value, 'offset=') && $value) {
				$hostParamsGET = $hostParamsGET.$value."&";
			}
		}
//		echo $hostParamsGET;
//		exit;
		//------------------------------------------------------------------------
		// Create the complete SQL statement
		// SQL_CALC_FOUND_ROWS is a MySQL 4.0 feature that allows you to get the
		// total number of results if you had not used a LIMIT statement. Using
		// it saves an extra query to get the total number of rows.
		//------------------------------------------------------------------------
		if($table) {
			$srcTable = $table;
		}
		else {
			$srcTable = "logs";
		}

		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM ".$srcTable." ";
	

		$where = $this->get_where_for_level($where);
		if($orderby =='seq') {
			if($order == 'ASC') {
				$dayuxiaoyu = '>=';
			}
			else {
				$dayuxiaoyu = '<=';
			}

			if($where) {
				$query = "$query WHERE ($where) AND seq $dayuxiaoyu (SELECT seq FROM $srcTable WHERE $where ORDER BY seq $order LIMIT $offset, 1) ORDER BY seq $order LIMIT $limit";
			}
			else {
				$query = "$query WHERE seq $dayuxiaoyu (SELECT seq FROM $srcTable ORDER BY seq $order LIMIT $offset, 1) ORDER BY seq $order LIMIT $limit";
			}
		}
		else {
			if($where) {
				$query = $query."WHERE ".$where." ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$limit;
			}
			else {
				$query = $query."ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$limit;
			}
		}

		//------------------------------------------------------------------------
		// Execute the query
		// The FOUND_ROWS function returns the value from the SQL_CALC_FOUND_ROWS
		// count.
		//------------------------------------------------------------------------
		$results = $this->logs_set->query($query);
		$num_results_array =  $this->logs_set->query("SELECT FOUND_ROWS()");
		$num_results_array = mysql_fetch_array($num_results_array);
		$num_results = $num_results_array[0];
		$num_log_files = (int)($num_results / $limit) + 1;
	

		$this->assign('items_per_page', $limit);		
		$this->assign('num_log_files', $num_log_files);
		$this->assign('num_results', $num_results);
		
		$this->display('search_report_result.tpl');

	}

	function do_export() {
		global $log_dbhost, $log_dbuser, $log_dbpwd, $log_dbname, $log_dbcharset;
		$link = mysql_connect($log_dbhost, $log_dbuser, _encrypt($log_dbpwd, 'D', 'freesvr' )) or die(mysql_error());

		mysql_select_db($log_dbname) or die(mysql_error());
		mysql_query("SET character_set_connection=$log_dbcharset, character_set_results=$log_dbcharset, character_set_client=binary");
		//========================================================================
		// BEGIN: GET THE INPUT VARIABLES
		//========================================================================
		$type = $this->get_input('type');
		$host = $this->get_input('host');
		$host2 = $this->get_input('host2');
		$excludeHost = $this->get_input('excludeHost');
		$facility = $this->get_input('facility');
		$excludeFacility = $this->get_input('excludeFacility');
		$priority = $this->get_input('priority');
		$excludePriority = $this->get_input('excludePriority');
		$datetime = $this->get_input('datetime');
		$datetime2 = $this->get_input('datetime2');

		$limit = $this->get_input('limit');
		$orderby = $this->get_input('orderby');
		$order = $this->get_input('order');
		$offset = $this->get_input('offset');
		if(!$offset) {
			$offset = 0;
		}
		$collapse = $this->get_input('collapse');
		$table = $this->get_input('table');

		// Set an arbitrary number of msg# and ExcludeMsg# vars
		$msgvarnum=1;
		$msgvarname="msg".$msgvarnum;
		$excmsgvarname="ExcludeMsg".$msgvarnum;

		while($this->get_input($msgvarname)) {
			${$msgvarname} = $this->get_input($msgvarname);
			${$excmsgvarname} = $this->get_input($excmsgvarname);

			$msgvarnum++;
			$msgvarname="msg".$msgvarnum;
			$excmsgvarname="ExcludeMsg".$msgvarnum;
		}
		//========================================================================
		// END: GET THE INPUT VARIABLES
		//========================================================================


		//========================================================================
		// BEGIN: INPUT VALIDATION
		//========================================================================
		$inputValError = array();

		if($excludeHost && !$this->validate_input($excludeHost, 'excludeX')) {
			array_push($inputValError, "excludeHost");
		}
		if($host && !$this->validate_input($host, 'host')) {
			array_push($inputValError, "host1");
		}
		if($host2 && !$this->validate_input($host2, 'host')) {
			array_push($inputValError, "host2");
		}
		if($excludeFacility && !$this->validate_input($excludeFacility, 'excludeX')) {
			array_push($inputValError, "excludeFacility");
		}
		if($facility && !$this->validate_input($facility, 'facility')) {
			array_push($inputValError, "facility");
		}
		if($excludePriority && !$this->validate_input($excludePriority, 'excludeX')) {
			array_push($inputValError, "excludePriority");
		}
		if($priority && !$this->validate_input($priority, 'priority')) {
			array_push($inputValError, "priority");
		}

		if($limit && !$this->validate_input($limit, 'limit')) {
			array_push($inputValError, "limit");
		}
		if($orderby && !$this->validate_input($orderby, 'orderby')) {
			array_push($inputValError, "orderby");
		}
		if($order && !$this->validate_input($order, 'order')) {
			array_push($inputValError, "order");
		}
		if(!$this->validate_input($offset, 'offset')) {
			array_push($inputValError, "offset");
		}
		if($collapse && !$this->validate_input($collapse, 'collapse')) {
			array_push($inputValError, "collapse");
		}
		if($table && !$this->validate_input($table, 'table')) {
			array_push($inputValError, "table");
		}

		if($inputValError) {
			echo "Input validation error! The following fields had the wrong format:<p>";
			foreach($inputValError as $value) {
				echo $value."<br>";
			}
			require_once 'template/admin/include/footer.tpl';
			exit;
		}
		//========================================================================
		// END: INPUT VALIDATION
		//========================================================================


		//========================================================================
		// BEGIN: BUILD AND EXECUTE SQL STATEMENT
		// AND BUILD PARAMETER LIST FOR HTML GETS
		//========================================================================
		//------------------------------------------------------------------------
		// Create WHERE statement and GET parameter list
		//------------------------------------------------------------------------
		$where = "";
		$ParamsGET = "&";

		if($table) {
			$ParamsGET=$ParamsGET."table=".$table."&";
		}

		if($limit) {
			$ParamsGET=$ParamsGET."limit=".$limit."&";
		}

		if($orderby) {
			$ParamsGET=$ParamsGET."orderby=".$orderby."&";
		}

		if($order) {
			$ParamsGET=$ParamsGET."order=".$order."&";
		}

		if($collapse) {
			$ParamsGET=$ParamsGET."collapse=".$collapse."&";
		}

		if($pageId) {
			$ParamsGET=$ParamsGET."pageId=".$pageId."&";
		}

		if($host2) {
			if ($where!="") {
				$where=$where." and ";
			}
			if($excludeHost==1) {
				$where = $where." host not like '%".$host2."%' ";
			}
			else {
				$where = $where." host like '%".$host2."%' ";
			}
			$ParamsGET=$ParamsGET."host2=".$host2."&excludeHost=".$excludeHost."&";
		}	

		if($host) {
			$hostGET=implode("&host[]=",$host);
			$hostSQL=implode("','",$host);
			if($where!="") {
				$where = $where." and ";
			}
			if($excludeHost==1) {
				$where = $where." host not in ('".$hostSQL."') ";
			}
			else {
				$where = $where." host in ('".$hostSQL."') ";
			}
			$ParamsGET=$ParamsGET."host[]=".$hostGET."&excludeHost=".$excludeHost."&";	
		}

		if($facility) {
			$facilityGET=implode("&facility[]=",$facility);
			$facilitySQL=implode("','",$facility);
			if($where!="") {
				$where = $where." and ";
			}
			if($excludeFacility==1) {
				$where = $where." facility not in ('".$facilitySQL."') ";
			}
			else {
				$where = $where." facility in ('".$facilitySQL."') ";
			}
			$ParamsGET=$ParamsGET."facility[]=".$facilityGET."&excludeFacility=".$excludeFacility."&";
		}

		if($priority) {
			$priorityGET=implode("&priority[]=",$priority);
			$prioritySQL=implode("','",$priority);
			if($where!="") {
				$where = $where." and ";
			}
			if($excludePriority==1) {
				$where = $where." priority not in ('".$prioritySQL."') ";
			}
			else {
				$where = $where." priority in ('".$prioritySQL."') ";
			}
			$ParamsGET=$ParamsGET."priority[]=".$priorityGET."&excludePriority=".$excludePriority."&";
		}

		if($datetime) {
			$ParamsGET=$ParamsGET."datetime=".$datetime."&";

		}
		if($datetime2) {
			$ParamsGET=$ParamsGET."datetime2=".$datetime2."&";
			
		}

		if($datetime && $datetime2) {
			if($where != "") {
				$where = $where." and ";
			}
			$where = $where." datetime between '".$datetime."' and '".$datetime2."' ";
		}
		elseif($datetime) {
			if($where != "") {
				$where = $where." and ";
			}
			$where = $where." datetime > '".$datetime."' ";
		}
		elseif($datetime2) {
			if($where != "") {
				$where = $where." and ";
			}
			$where = $where." datetime < '".$datetime2."' ";
		}

		$msgvarnum=1;
		$msgvarname="msg".$msgvarnum;
		$excmsgvarname="ExcludeMsg".$msgvarnum;

		while(${$msgvarname}) {
			if($where !="") {
				$where = $where." and ";
			}
			if(${$excmsgvarname} == "on") {
				$where = $where." msg not like '%".${$msgvarname}."%' ";
				$ParamsGET=$ParamsGET.$excmsgvarname."=".${$excmsgvarname}."&";
			}
			else {
				$where = $where." msg like '%".${$msgvarname}."%' ";
			}
			$ParamsGET=$ParamsGET.$msgvarname."=".${$msgvarname}."&";
			$msgvarnum++;
			$msgvarname="msg".$msgvarnum;
			$excmsgvarname="ExcludeMsg".$msgvarnum;
		}

		//------------------------------------------------------------------------
		// Create the GET string without host variables
		//------------------------------------------------------------------------
		$pieces = explode("&", $ParamsGET);
		$hostParamsGET = "";
		foreach($pieces as $value) {
			if(!strstr($value, "host[]=") && !strstr($value, 'excludeHost=') && !strstr($value, 'offset=') && $value) {
				$hostParamsGET = $hostParamsGET.$value."&";
			}
		}


		//------------------------------------------------------------------------
		// Create the complete SQL statement
		// SQL_CALC_FOUND_ROWS is a MySQL 4.0 feature that allows you to get the
		// total number of results if you had not used a LIMIT statement. Using
		// it saves an extra query to get the total number of rows.
		//------------------------------------------------------------------------
		if($table) {
			$srcTable = $table;
		}
		else {
			$srcTable = 'logs';
		}

		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM ".$srcTable." ";

		if($type == 'today') {
			if($where != '') {
				$where .= " AND DATE(`datetime`) = CURDATE()";
			}
			else {
				$where = "DATE(`datetime`) = CURDATE()";
			}
		}
		
		$offset =  (((int)($this->get_input('filenum')) - 1) * 20);
		//$limit =  20;
		
		$where = $this->get_where_for_level($where);
		
		if($orderby =='seq') {
			if($order == 'ASC') {
				$dayuxiaoyu = '>=';
			}
			else {
				$dayuxiaoyu = '<=';
			}

			if($where) {
				$query = "$query WHERE ($where) AND seq $dayuxiaoyu (SELECT seq FROM $srcTable WHERE $where ORDER BY seq $order LIMIT $offset, 1) ORDER BY seq $order LIMIT $limit";
			}
			else {
				$query = "$query WHERE seq $dayuxiaoyu (SELECT seq FROM $srcTable ORDER BY seq $order LIMIT $offset, 1) ORDER BY seq $order LIMIT $limit";
			}
		}
		else {
			if($where) {
				$query = $query."WHERE ".$where." ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$limit;
			}
			else {
				$query = $query."ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$limit;
			}
		}

		//------------------------------------------------------------------------
		// Execute the query
		// The FOUND_ROWS function returns the value from the SQL_CALC_FOUND_ROWS
		// count.
		//------------------------------------------------------------------------
		$results = $this->logs_set->query($query);

		$num_results_array = $this->logs_set->query("SELECT FOUND_ROWS()", $dbLink);
		$num_results_array = mysql_fetch_array($num_results_array);
		$num_results = $num_results_array[0];
		if($orderby =='seq') {
			$num_results += $offset;
		}
		//========================================================================
		// END: BUILD AND EXECUTE SQL STATEMENT
		// AND BUILD PARAMETER LIST FOR HTML GETS
		//========================================================================	
		//Begin: formating an excel document.

		$data = "";
		$fields = mysql_num_fields($results);
		for ($i = 0; $i < $fields; $i++) {
			$header .= mysql_field_name($results, $i) . "\t";
		}

		while ($row = mysql_fetch_row($results)) {
			$line = '';
			foreach ($row as $value) {
				if ((!isset($value)) || ($value == "")) {
					$value = "\t";
				} else {
					$value = str_replace('"', '""', $value);
					$value = '"' . $value . '"' . "\t";
				}
				$line .= $value;
			}
			$data .= trim($line) . "\n";
		}
		$data = str_replace("\r", "", $data);

		//End: formating an excel document.

		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=log_"
				. $this->get_input('filenum') . '.xls');
		header("Pragma: no-cache");
		header("Expires: 0");

		echo "$header\n$data";
	}
	

	function detail() {
		global $log_dbhost, $log_dbuser, $log_dbpwd, $log_dbname, $log_dbcharset;
		$link = mysql_connect($log_dbhost, $log_dbuser, _encrypt($log_dbpwd, 'D', 'freesvr' )) or die(mysql_error());
		mysql_select_db($log_dbname) or die(mysql_error());
		mysql_query("SET character_set_connection=$log_dbcharset, character_set_results=$log_dbcharset, character_set_client=binary");
		$seq= $_GET['seq'];		
		$idName = 'id';		
		$result =  $this->logs_set->base_select("SELECT * FROM `log_logs` WHERE $idName = '$seq' ");
		$this->assign("detail", $result[0]);
		$this->display('logs_detail.tpl');

	}
}
?>
