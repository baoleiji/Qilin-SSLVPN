<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_searchlogs extends c_base {
	function index() {
		$hostname = $this->getInput('hostname');
		$query = ' 1=1';
		if($hostname){
			$query =$query. " and name='$hostname'";
		}
		
		if($_SESSION['ADMIN_LEVEL'] != 1) {
			$username = $_SESSION['ADMIN_USERNAME'];
			$query =$query. " and username='$username'";
		}
		
		$page_num = $this->getInput('page');
		$row_num = $this->searchlogs_set->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->searchlogs_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query);
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
		$this->assign('all', $all);

		$this->display('searchlogs.tpl');
	}
	
	function delete_all() {
		$seq = get_request('chk_member', 1, 1);
		$table= 'searchlogs';
		$idName = 'seq';

	
		$this->host_set->base_delete_all($table,$idName,$seq);
		
		$query = "select * FROM `$table` WHERE $idName IN(". "'" . implode("', '", $seq) . "')";
		$result = $this->logs_set->base_select($query);
		for($i=0;$i<count($result);$i++) {
				$t = $result[$i]['tables'];
				
				$sql = "DROP TABLE IF EXISTS `$t` ";
				$this->logs_set->query($sql);
	 
			}
 
		alert_and_back('成功删除记录');
	}
	
function queryTable(){

	$seq = $this->getInput('seq');
	$where = "select * from searchlogs where seq=$seq";
	$result = $this->logs_set->base_select($where);
	$status = $result[0]['status'];
	$tables = $result[0]['tables'];
	if($status==0){
		alert_and_back('查询未结束');
	}else{
		$this->queryResult($tables);
	}
 
}

function queryResult($tables){
	
		$table = $this->get_input('table');
		
	 
		if($table) {
			$srcTable = $table;
		}
		else {
			$srcTable = $tables;
		}
		
		$query0 = "SELECT count(*) num FROM ".$srcTable." ";
		$query = "SELECT  * FROM ".$srcTable." ";
		
		$results = $this->logs_set->query($query0);
		$num_results_array = mysql_fetch_array($results);

		$num_results = $num_results_array['num'];

		$page_num = get_request('page');
		$row_num = $num_results;
			
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		
		$offset = $newpager->intStartPosition;
		$limit = $newpager->intItemsPerPage;
		
		$query = $query . " LIMIT ".$offset.", ".$limit;
	
		$results = $this->logs_set->query($query);
	//	echo $query
		$n = 0;
		while($row = mysql_fetch_array($results)) {
			//	$row['count'] = 1;
				$result_array[$n] = $row;
				$n++;
		}

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="))."&table=$srcTable";
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING']."&table=$srcTable";
		
		}
		
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
	
	
		$this->assign('all', $result_array);

		$this->display('searchlogs_result.tpl');
}


	function edit(){

		$table_list = $this->get_table_list();
		if($_SESSION['ADMIN_LEVEL'] == 1) {
			$allhost = $this->host_set->select_all();
		}
		else {
			$user = $this->user_set->select_all("username = '" . $_SESSION['ADMIN_USERNAME'] ."'");
			$hostlist = $user[0]['hostlist'];
			if($hostlist != '') {
				$hostlist = explode('||', $hostlist);
				$query = " `group` in ('".implode("','", $hostlist)."')";
				$allhost = $this->host_set->select_all($query);
				
			}
		}
		
		$this->assign('allhost', $allhost);
		$this->assign("table_list", $table_list);
		$this->display('searchlogs_edit.tpl');
	}
	
	function save(){
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
		$date = $this->get_input('date');
		$date2 = $this->get_input('date2');
		$time = $this->get_input('time');
		$time2 = $this->get_input('time2');

		$orderby = $this->get_input('orderby');
		$order = $this->get_input('order');
		
		$limit = $this->get_input('limit');
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
		if($date && !$this->validate_input($date, 'date')) {
			array_push($inputValError, "date1");
		}
		if($date2 && !$this->validate_input($date2, 'date')) {
			array_push($inputValError, "date2");
		}
		if($time && !$this->validate_input($time, 'time')) {
			array_push($inputValError, "time1");
		}
		if($time2 && !$this->validate_input($time2, 'time')) {
			array_push($inputValError, "time2");
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

		$datetime = "";
		$datetime2 = "";

		if($date) {
			$ParamsGET=$ParamsGET."date=".$date."&time=".$time."&";
			if(strcasecmp($date, 'now') == 0 || strcasecmp($date, 'today') == 0) {
				$date = date("Y-m-d");
			}
			elseif(strcasecmp($date, 'yesterday') == 0) {
				$date = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
			}
			if(!$time) {
				$time = "00:00:00";
			}
			elseif(strcasecmp($time, 'now') == 0) {
				$time = date("H:i:s");
			}
			$datetime = $date." ".$time ;
		}
		if($date2) {
			$ParamsGET=$ParamsGET."date2=".$date2."&time2=".$time2."&";
			if(strcasecmp($date2, 'now') == 0 || strcasecmp($date2, 'today') == 0) {
				$date2 = date("Y-m-d");
			}
			elseif(strcasecmp($date2, 'yesterday') == 0) {
				$date2 = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
			}
			if(!$time2) {
				$time2 = "23:59:59";
			}
			elseif(strcasecmp($time2, 'now') == 0) {
				$time2 = date("H:i:s");
			}
			$datetime2 = $date2." ".$time2 ;
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

		$query = "SELECT   * FROM ".$srcTable." ";

		if($type == 'today') {
			if($where != '') {
				$where .= " AND DATE(`datetime`) = CURDATE()";
			}
			else {
				$where = "DATE(`datetime`) = CURDATE()";
			}
		}
	
		$where = $this->get_where_for_level($where);
		
//		if($orderby =='seq') {
//			if($order == 'ASC') {
//				$dayuxiaoyu = '>=';
//			}
//			else {
//				$dayuxiaoyu = '<=';
//			}
//
//			if($where) {
//				$query = "$query WHERE ($where) AND seq $dayuxiaoyu (SELECT seq FROM $srcTable WHERE $where ORDER BY seq $order LIMIT $offset, 1) ORDER BY seq $order LIMIT $limit";
//			}
//			else {
//				$query = "$query WHERE seq $dayuxiaoyu (SELECT seq FROM $srcTable ORDER BY seq $order LIMIT $offset, 1) ORDER BY seq $order LIMIT $limit";
//			}
//		}
//		else {
//			if($where) {
//				$query = $query."WHERE ".$where." ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$limit;
//			}
//			else {
//				$query = $query."ORDER BY ".$orderby." ".$order." LIMIT ".$offset.", ".$limit;
//			}
//		}
		
		if($where) {
				$query = $query."WHERE ".$where." ORDER BY ".$orderby." ".$order ;
			}
			else {
				$query = $query."ORDER BY ".$orderby." ".$order ;
			}

/*****************************************************/		
		$searchlogs = new searchlogs();
		$name = $_GET['queryname'];
		$sql = str_replace("'","\'",$query);

//		
//		echo $sql;
//		exit;
		
		$searchlogs->set_data('name', $name);
		$searchlogs->set_data('sql', $sql);
		$searchlogs->set_data('username',  $_SESSION['ADMIN_USERNAME']);

		if($name == '') {
							alert_and_back('查询名称不能为空!');
							exit();
			}else {
							$this->searchlogs_set->add($searchlogs);
							alert_and_back('添加成功!', 'admin.php?c=admin_searchlogs');
			}	

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
	
function get_table_list() {
		global $dbname;
		$result = $this->logs_set->base_select("SHOW TABLES LIKE 'logs%'");
		$table_list = array();
		foreach($result as $table_name) {
			$table_list[] = $table_name["Tables_in_$dbname (logs%)"];
		}
		return $table_list;	
	}
}



?>
