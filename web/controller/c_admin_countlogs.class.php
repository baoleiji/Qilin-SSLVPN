<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_countlogs  extends c_base {
	function index() {
		$orderby1= $this->getInput('orderby1');
		$orderby2= $this->getInput('orderby2');
		$listType = $this->getInput('listType');
		$contentType = $this->getInput('contentType');
		if(empty($_GET['f_rangeStart'])){
			$_GET['f_rangeStart'] = date('Y-m-d');
		}
		$f_rangeStart = $this->getInput('f_rangeStart');
		
		if(empty($orderby1)){
			$orderby1 = 'seq';
		}
		if(empty($orderby2)){
			$orderby2 = 'desc';
		}

		$this->assign("orderby2", $orderby2);
		
		

		if($listType){
			$setName = 'countlogs_'.$listType.'_'.$contentType.'_set';
			$tplName = 'countlogs_'.$listType.'_'.$contentType.'.tpl';
		}
		else{
			$setName = 'countlogs_day_detailed_set';
			$tplName = 'countlogs_day_detailed.tpl';
		}

		$query = ' 1=1';
		if($f_rangeStart){
			$query = " date='$f_rangeStart'";
			if($listType=='week'){
				$query = " week_num= DATE_FORMAT('$f_rangeStart','%v') and TIMESTAMPDIFF(DAY,date_start,'$f_rangeStart')<7 ";
			}
			
			if($listType=='month'){
				$query = " MONTH('$f_rangeStart')= MONTH(date_start)";
			}
		}
		
		
		$page_num = $this->getInput('page');
		$row_num = $this->$setName->select_count($query);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$all = $this->$setName->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$query,$orderby1,$orderby2);
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
		
		$this->assign('listType', $listType);
		$this->assign('contentType', $contentType);
		$this->assign('f_rangeStart', $f_rangeStart);

 
		$this->display($tplName);
	}
	
	function delete_all() {
		$seq = get_request('chk_member', 1, 1);
		$table= $_GET['t'];
		$idName = 'seq';

		$this->countlogs_set->base_delete_all($table,$idName,$seq);
		alert_and_back('成功删除记录');
	}
	
	function graph() {
//		$date = $this->last_sunday();
//		echo 'date1'.$date.'<br>';
//		
//		$date = $this->lastmonth_lastday();
//		echo 'date2'.$date.'<br>';
//		

		$date = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
	 
		//服务器日志统计
		$query = "select count(*) num,host from log_countlogs_day_detailed   where date='$date' group by host order by num desc limit 10";
		$day_detailed = $this->countlogs_day_detailed_set->base_select($query);
		
		//级别(天)
		$query = "select sum(alllog) num,level from log_countlogs_day_level   where date='$date' group by level order by num desc limit 10";
		$day_level = $this->countlogs_day_detailed_set->base_select($query);

		//级别(时)
		$query = "select sum(alllog) num,date from log_countlogs_hour_level   group by date order by date desc limit 24";
		$hour_level = $this->countlogs_day_detailed_set->base_select($query);
		
		if(is_array($hour_level))
			$hour_level = array_reverse($hour_level);
	
		//来源ip
	//	echo $date;
		$query = "select count(*) num,srcip from log_login_day_count  where date='$date' group by srcip order by num desc limit 10";
		$day_count_srcip = $this->countlogs_day_detailed_set->base_select($query);
		
		//服务器登录统计
		$query = "select count(*) num,server from log_login_day_count  where date='$date'  group by server order by num desc limit 10";
		$day_count_server = $this->countlogs_day_detailed_set->base_select($query);

		
		$query = "select count(*) num,protocol from log_login_day_count  where date='$date'  group by protocol order by num desc limit 10";
		$day_count_protocol = $this->countlogs_day_detailed_set->base_select($query);
 
		$this->assign('day_detailed', json_encode($day_detailed));
		$this->assign('day_level', json_encode($day_level));
		$this->assign('hour_level', json_encode($hour_level));
		$this->assign('day_count_srcip', json_encode($day_count_srcip));
		$this->assign('day_count_server', json_encode($day_count_server));
		$this->assign('day_count_protocol', json_encode($day_count_protocol));
 
		$this->display('daygraph.tpl');
	}
	
	
	function weekgraph() {

		$date = $this->last_sunday();
		
		//服务器日志统计
		$query = "select count(*) num,host from log_countlogs_week_detailed   where date_end='$date' group by host order by num desc limit 10";
		$week_detailed = $this->countlogs_week_detailed_set->base_select($query);
		
		//级别(天)
		$query = "select sum(alllog) num,level from log_countlogs_week_level   where date_end='$date' group by level order by num desc limit 10";
		$week_level = $this->countlogs_week_detailed_set->base_select($query);

		//级别(时)
		$query = "select sum(alllog) num,date_end from log_countlogs_week_level    group by date_end order by date_end desc limit 7";
		$week_level_line = $this->countlogs_week_detailed_set->base_select($query);
		
		if(is_array($week_level_line))
			$week_level_line = array_reverse($week_level_line);
	
		//来源ip
	//	echo $date;
		$query = "select count(*) num,srcip from log_login_week_count  where date_end='$date' group by srcip order by num desc limit 10";
		$week_count_srcip = $this->countlogs_week_detailed_set->base_select($query);
		
		//服务器登录统计
		$query = "select count(*) num,server from log_login_week_count  where date_end='$date'  group by server order by num desc limit 10";
		$week_count_server = $this->countlogs_week_detailed_set->base_select($query);

		
		$query = "select count(*) num,protocol from log_login_week_count  where date_end='$date'  group by protocol order by num desc limit 10";
		$week_count_protocol = $this->countlogs_week_detailed_set->base_select($query);
 

		$this->assign('week_detailed', json_encode($week_detailed));
		$this->assign('week_level', json_encode($week_level));
		$this->assign('hour_level', json_encode($week_level_line));
		$this->assign('week_count_srcip', json_encode($week_count_srcip));
		$this->assign('week_count_server', json_encode($week_count_server));
		$this->assign('week_count_protocol', json_encode($week_count_protocol));

		$this->display('weekgraph.tpl');
	}
	
		
	function monthgraph() {

		$date = $this->lastmonth_lastday();
		
		//服务器日志统计
		$query = "select count(*) num,host from log_countlogs_month_detailed   where date_end='$date' group by host order by num desc limit 10";
		$month_detailed = $this->countlogs_month_detailed_set->base_select($query);
		
		//级别(天)
		$query = "select sum(alllog) num,level from log_countlogs_month_level   where date_end='$date' group by level order by num desc limit 10";
		$month_level = $this->countlogs_month_detailed_set->base_select($query);

		//级别(时)
		$query = "select sum(alllog) num,date_end from log_countlogs_month_level   group by date_end order by date_end desc limit 30";
		$month_level_line = $this->countlogs_month_detailed_set->base_select($query);
 
		if(is_array($month_level_line))
			$month_level_line = array_reverse($month_level_line);
		//来源ip
	//	echo $date;
		$query = "select count(*) num,srcip from log_login_month_count  where date_end='$date' group by srcip order by num desc limit 10";
		$month_count_srcip = $this->countlogs_month_detailed_set->base_select($query);
		
		//服务器登录统计
		$query = "select count(*) num,server from log_login_month_count  where date_end='$date'  group by server order by num desc limit 10";
		$month_count_server = $this->countlogs_month_detailed_set->base_select($query);

		
		$query = "select count(*) num,protocol from log_login_month_count  where date_end='$date'  group by protocol order by num desc limit 10";
		$month_count_protocol = $this->countlogs_month_detailed_set->base_select($query);
 

		$this->assign('month_detailed', json_encode($month_detailed));
		$this->assign('month_level', json_encode($month_level));
		$this->assign('hour_level', json_encode($month_level_line));
		$this->assign('month_count_srcip', json_encode($month_count_srcip));
		$this->assign('month_count_server', json_encode($month_count_server));
		$this->assign('month_count_protocol', json_encode($month_count_protocol));

		$this->display('monthgraph.tpl');
	}
	

	function export(){
		$table = $_GET['table'];
		$setName = substr($table,4).'_set';
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM $table" ;

		$listType = $this->getInput('listType');
		$contentType = $this->getInput('contentType');
		$f_rangeStart = $this->getInput('f_rangeStart');


		if($f_rangeStart){
			
			if(strpos($table,'week')){
				$query = $query." where week_num= DATE_FORMAT('$f_rangeStart','%v') and TIMESTAMPDIFF(DAY,date_start,'$f_rangeStart')<7 ";
			}elseif(strpos($table,'month')){
				$query = $query." where MONTH('$f_rangeStart')= MONTH(date_start)";
			}else{
				$query =$query. " where date='$f_rangeStart'";
			}
		}
		
		$results =  $this->$setName->query($query);
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
		header("Content-type: application/vnd.ms-excel;");
		header("Content-Disposition: attachment; filename=".$table.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$str = "$header\n$data";
		$str = mb_convert_encoding($str, "GB2312", "UTF-8");
		echo $str;
	}
	
	function derivetoHTML(){

		$table = $_GET['table'];
		$setName = substr($table,4).'_set';	
		$tplName = 'html_for_countlogs_detailed.tpl';	
		if(strpos($table,"level")){
			$tplName = 'html_for_countlogs_level.tpl';				
		}elseif(strpos($table,"server")){
			$tplName = 'html_for_countlogs_server.tpl';	
		}	
//		echo $tplName;
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM $table" ;
		
				$listType = $this->getInput('listType');
		$contentType = $this->getInput('contentType');
		$f_rangeStart = $this->getInput('f_rangeStart');


		if($f_rangeStart){
			
			if(strpos($table,'week')){
				$query = $query." where week_num= DATE_FORMAT('$f_rangeStart','%v') and TIMESTAMPDIFF(DAY,date_start,'$f_rangeStart')<7 ";
			}elseif(strpos($table,'month')){
				$query = $query." where MONTH('$f_rangeStart')= MONTH(date_start)";
			}else{
				$query =$query. " where date='$f_rangeStart'";
			}
		}
		
		$results =  $this->$setName->query($query);
		$fields = mysql_num_fields($results);
		for ($i = 0; $i < $fields; $i++) {
			$head[] =  mysql_field_name($results, $i) . "\t";
		}
		while($row = mysql_fetch_assoc($results)) {
				$data[] = $row;
		}
		ob_start();
		
		
		$this->assign('table', $table);
		$this->assign('all', $data);
		$this->assign('head', $head);
		$this->display($tplName);
		$str = ob_get_clean();

		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=".$table.".html"); 
		echo $str;
		exit();
	}
	
	
function last_sunday($timestamp=0,$is_return_timestamp=false){  

    static $cache ;  
    $id = $timestamp.$is_return_timestamp;  
    if(!isset($cache[$id])){  
        if(!$timestamp) $timestamp = time();  
        $thissunday = $this->this_sunday($timestamp) - /*7*86400*/604800;  
        if($is_return_timestamp){  
            $cache[$id] = $thissunday;  
        }else{  
            $cache[$id] = date('Y-m-d',$thissunday);  
        }  
    }  
    return $cache[$id];  
  
}  
	
	
function this_sunday($timestamp=0,$is_return_timestamp=true){  
    static $cache ;  
    $id = $timestamp.$is_return_timestamp;  
    if(!isset($cache[$id])){  
        if(!$timestamp) $timestamp = time();  
        $sunday = $this->this_monday($timestamp) + /*6*86400*/518400;  
        if($is_return_timestamp){  
            $cache[$id] = $sunday;  
        }else{  
            $cache[$id] = date('Y-m-d',$sunday);  
        }  
    }  
    return $cache[$id];  
} 

function this_monday($timestamp=0,$is_return_timestamp=true){  
    static $cache ;  
   $id = $timestamp.$is_return_timestamp;  
    if(!isset($cache[$id])){  
        if(!$timestamp) $timestamp = time();  
        $monday_date = date('Y-m-d', $timestamp-86400*date('w',$timestamp)+(date('w',$timestamp)>0?86400:-/*6*86400*/518400));  
        if($is_return_timestamp){  
            $cache[$id] = strtotime($monday_date);  
        }else{  
            $cache[$id] = $monday_date;  
        }  
    }  
    return $cache[$id];  
  
} 

function lastmonth_firstday($timestamp = 0, $is_return_timestamp=true){  
    static $cache ;  
    $id = $timestamp.$is_return_timestamp;  
    if(!isset($cache[$id])){  
        if(!$timestamp) $timestamp = time();  
        $firstday = date('Y-m-d', mktime(0,0,0,date('m',$timestamp)-1,1,date('Y',$timestamp)));  
        if($is_return_timestamp){  
            $cache[$id] = strtotime($firstday);  
        }else{  
            $cache[$id] = $firstday;  
        }  
    }  
    return $cache[$id];  
}  

function lastmonth_lastday($timestamp = 0, $is_return_timestamp=false){  
    static $cache ;  
    $id = $timestamp.$is_return_timestamp;  
    if(!isset($cache[$id])){  
        if(!$timestamp) $timestamp = time();  
        $lastday = date('Y-m-d', mktime(0,0,0,date('m',$timestamp)-1, date('t',$this->lastmonth_firstday($timestamp)),date('Y',$timestamp)));  
        if($is_return_timestamp){  
            $cache[$id] = strtotime($lastday);  
        }else{  
            $cache[$id] =  $lastday;  
        }  
    }  
    return $cache[$id];  
} 

	
}
?>
