<?php
if (!defined('CAN_RUN')) {
    exit('Access Denied');
}


class c_admin_session extends c_base
{
    function index($where = NULL, $interface=false)
    {
		global $_CONFIG;
        $back = get_request('back');
		
		$backupdb_id = get_request('backupdb_id');
		
		if(!empty($backupdb_id)){
			
			$backupdb = $this->backup_setting_set->select_by_id($backupdb_id);
			
			$dbhost = $backupdb['ip'];
			
			$dbuser = $backupdb['mysqluser'];
			
			$dbpwd = $this->backup_setting_set->udf_decrypt($backupdb['mysqlpasswd']);
			
			$dbname=$backupdb['dbname'];
			
			$dbcharset = 'utf8';
			
			$link = mysql_connect($dbhost, $dbuser, $dbpwd) ;
			
			if(empty($link)){
				
				alert_and_close('目标服务器无法访问');
				
				exit;
			
			}
			
			$rs = mysql_select_db($dbname);
			
			if(empty($rs)){
				
				alert_and_close('目标服务器没有数据库');
				
				exit;
			
			}
		
			
			mysql_query("SET character_set_connection=$dbcharset, character_set_results=$dbcharset, character_set_client=binary");
			
			$this->assign("backupdb_id", $backupdb_id);
		
		}
		
        if ($back) {
            if (is_array($_SESSION[$_GET['controller'] . '_' . ($_GET['action'] ? $_GET['action'] : 'index') . '_' . 'QUERY_STRING'])) {
                $_GET                    = array_merge($_SESSION[$_GET['controller'] . '_' . ($_GET['action'] ? $_GET['action'] : 'index') . '_' . 'QUERY_STRING'], $_GET);
                $_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'] . '_' . ($_GET['action'] ? $_GET['action'] : 'index') . '_' . 'QUERY_STRING']);
            }
        } else {
            $_SESSION[$_GET['controller'] . '_' . $_GET['action'] . '_' . 'QUERY_STRING'] = null;
        }
        
        $this->assign("logindebug", $_CONFIG['LOGIN_DEBUG']);
        $page_num = get_request('page');
        
        $derive = get_request('derive');
		
        $delete = get_request('delete');
        $where  = "1=1";
        $member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
        $this->assign('member', $member);
        
        $orderby1 = get_request('orderby1', 0, 1);
        $orderby2 = get_request('orderby2', 0, 1);
        $sid      = get_request('sid', 0, 1);
        $sid1     = get_request('sid1', 0, 1);
        $sid2     = get_request('sid2', 0, 1);
        $addr     = get_request('addr', 0, 1);
        $type     = get_request('type', 0, 1);
        $user     = get_request('user', 0, 1);
        $luser    = get_request('luser', 0, 1);
        $addr     = get_request('addr', 0, 1);
        $start1   = get_request('start1', 0, 1);
        $end1     = get_request('end1', 0, 1);
        $start2   = get_request('start2', 0, 1);
        $end2     = get_request('end2', 0, 1);
        $time     = get_request('time', 0, 1);
        $realname     = get_request('realname', 0, 1);
        $command  = get_request('command', 0, 1);
        $srcaddr  = get_request('srcaddr', 0, 1);
        $usergroup  = get_request('usergroup', 0, 1);
        
        $filter = get_request('filter');
		if($filter){
			$where .= " AND total_cmd>0 ";
		}
		$this->assign("filter", $filter);
		if (empty($orderby1)) {
			$orderby1 = 'sid';
		}
		if (strcasecmp($orderby2, 'asc') != 0) {
			$orderby2 = 'desc';
		} else {
			$orderby2 = 'asc';
		}
        $this->assign("orderby2", $orderby2=='desc' ? 'asc' : 'desc');
        
        
        if ($addr) {
            if (is_ip($addr)) {
                $where .= " AND addr = '$addr'";
            } else {
                $where .= " AND addr LIKE '%$addr%'";
            }
        }
        
        if ($srcaddr) {
            if (is_ip($srcaddr)) {
                $where .= " AND cli_addr = '$srcaddr'";
            } else {
                $where .= " AND cli_addr LIKE '%$srcaddr%'";
            }
        }
        
        if ($type) {
            if ($type != 'all') {
                $where .= " AND type = '$type'";
            }
        }
        
        
        $sql = "SELECT devicesid FROM " . $this->luser_set->get_table_name();
        //if($_SESSION['ADMIN_LEVEL']==0)
            {
            $sql .= " WHERE memberid=" . $_SESSION['ADMIN_UID'];
        }
        $sql .= " UNION SELECT devicesid FROM " . $this->lgroup_set->get_table_name();
        //if($_SESSION['ADMIN_LEVEL']==0)
            {
            $sql .= " WHERE groupid=" . $_SESSION['ADMIN_GROUP'];
        }
        $sql .= " UNION SELECT devicesid FROM " . $this->resgroup_set->get_table_name() . " WHERE groupname IN (SELECT b.groupname FROM " . $this->luser_resourcegrp_set->get_table_name() . " a LEFT JOIN " . $this->resgroup_set->get_table_name() . " b ON a.resourceid=b.id ";
        //if($_SESSION['ADMIN_LEVEL']==0)
            {
            $sql .= "WHERE  a.memberid=" . $_SESSION['ADMIN_UID'];
        }
        $sql .= ")";
		$sql .= " union select distinct devices.id devicesid from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and  a.memberid=" . $_SESSION['ADMIN_UID'];
        $sql .= " UNION SELECT devicesid FROM " . $this->resgroup_set->get_table_name() . " WHERE groupname IN (SELECT b.groupname FROM " . $this->lgroup_resourcegrp_set->get_table_name() . " a LEFT JOIN " . $this->resgroup_set->get_table_name() . " b ON a.resourceid=b.id ";
		
        //if($_SESSION['ADMIN_LEVEL']==0)
            {
            $sql .= "WHERE a.groupid=" . $_SESSION['ADMIN_GROUP'];
        }
        $sql .= ")";
		$sql .= " union select distinct devices.id devicesid from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and devices.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.groupid=" . $_SESSION['ADMIN_GROUP'];
        $alldevid = $this->member_set->base_select($sql);
        for ($i = 0; $i < count($alldevid); $i++) {
            $alldevsid[] = $alldevid[$i]['devicesid'];
        }
        if (empty($alldevsid)) {
            $alldevsid[] = 0;
        }
        if ($_SESSION['ADMIN_LEVEL'] == 0) {
            $where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN (SELECT device_ip FROM " . $this->devpass_set->get_table_name() . " WHERE id IN (" . implode(",", $alldevsid) . ")) and luser='" . $_SESSION['ADMIN_USERNAME'] . "'";
        }
        
        if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			$alltmpip = array(0);
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				if($_CONFIG['DEPART_ADMIN']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
					if($alltmpip)
					$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')";
				}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND luser IN ('".implode("','", $alltmpuser)."')";
				}
			}
        }
        $multipleselect=1;
		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$alltmpip = array(0);
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$alltmpip[]=$allips[$i]['device_ip'];
			}
			if($alltmpip)
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')";
		}

        
        if ($user) {
            $where .= " AND user like '%$user%'";
        }
        
        if ($luser) {
            $where .= " AND luser like '%$luser%'";
        }

		if ($realname) {
            $where .= " AND realname like '%$realname%'";
        }

		if($usergroup){
			$where .= " AND member.groupid='$usergroup'";
		}
        
        if ($sid1 !== NULL && $sid2 !== NULL) {
            $where .= " AND (sid >= $sid1 AND sid <= $sid2)";
        }
        
        if ($start1) {
            $where .= " AND (start >= '$start1') ";
        }
        
        if ($start2) {
            $where .= " AND (start <= '$start2') ";
        }

		if ($end2) {
            $where .= " AND (end <= '$end2') ";
        }
        
        if ($end1 && $end2) {
            $where .= " AND (end >= '$end1' AND end <= '$end2')";
        }
        
        if ($time) {
            //$where .= " AND (start <= '$time' AND end >= '$time')";
            $where .= " AND (start <= '$time')";
        }
        
        if ($command) {
            $where .= " AND (SELECT COUNT(*) FROM `commands` WHERE cmd LIKE '%$command%' AND commands.sid = sessions.sid) > 0";
        }
        
        if ($delete) {
            if ($_SESSION['ADMIN_LEVEL'] == 1) {
                $this->delete($where);
            } else {
                die('æ²¡ææé');
            }
        } else {
            //$table_list = $this->get_table_list();
            $curr_url = $_SERVER['PHP_SELF'] . "?";
            if (strstr($_SERVER['QUERY_STRING'], "&page=")) {
                $curr_url .= substr($_SERVER['QUERY_STRING'], 0, strpos($_SERVER['QUERY_STRING'], "&page="));
            } else {
                $curr_url .= $_SERVER['QUERY_STRING'];
            }
            parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'] . '_' . ($_GET['action'] ? $_GET['action'] : 'index') . '_' . 'QUERY_STRING']);
            //echo $curr_url;
			$select = "select sessions.*,member.realname,(select min(parent_cmd) from sub_sessions ss where sessions.sid=ss.parent_sid ) as sub_sid,(select min(if(dangerlevel=0,10,dangerlevel)) from commands where sid=sessions.sid) cmd_danger ";
			$sqltotal = "from sessions WHERE $where";
			$sql = "from sessions LEFT JOIN member ON sessions.luser=member.username WHERE $where ";
			if($usergroup) $sqltotal = $sql;
            
            $row_num  = $this->sessions_set->base_select("select count(0) ct $sqltotal ");
			$row_num = $row_num[0]['ct'];
            $newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
            $this->assign('page_list', $newpager->showSerialList());
            $this->assign('session_num', $row_num);
            $this->assign('curr_page', $newpager->intCurrentPageNumber);
            $this->assign('total_page', $newpager->intTotalPageCount);
            $this->assign('items_per_page', $newpager->intItemsPerPage);
            $this->assign('curr_url', $curr_url);
            $this->assign('command', $command);
            if (!$orderby1) {
                $orderby1 = "sid";
            }
            $sql .=" ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
            $allsession = $this->sessions_set->base_select($select.$sql);
            if($interface){
	        	return $allsession;
	        }
            //$this->assign('allsession', $this->sessions_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2));
            $this->assign('allsession', $allsession);
            
			$usergroup = $this->usergroup_set->select_all(" level=0 and attribute!=1 ".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''), 'groupname', 'asc');
			$this->assign('usergroup', $usergroup);
			$this->assign('allgroup', $usergroup);
            //$this->assign('now_table_name', $table_name);
            //$this->assign('table_list', $table_list);
            $this->display("session_list.tpl");
        }
    }
    
    function search()
    {
        //$table_list = $this->get_table_list();
        //$this->assign('table_list', $table_list);
        if ($_SESSION['ADMIN_LEVEL'] != 1) {
            $allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).") order by device_ip asc");
            $this->assign('alldev', $allips);
        } else {
            $this->assign('alldev', $this->dev_set->select_all('1', 'device_ip', 'asc'));
        }
		$member = $this->member_set->select_all('1', 'username', 'asc');
		$this->assign('member', $member);
        $this->display("session_search.tpl");
    }
    
    //function get_table_list() {
    //	$result = $this->info_set->base_select("SHOW TABLES LIKE 'info%'");
    //	$table_list = array();
    //	foreach($result as $table_name) {
    //		$table_list[] = $table_name['Tables_in_log (info%)'];
    //	}
    //	return $table_list;
    //}
    
    
    function view($interface=false)
    {
        global $_CONFIG;
		$backupdb_id = get_request('backupdb_id');
		if(!empty($backupdb_id)){
			$backupdb = $this->backup_setting_set->select_by_id($backupdb_id);
			$dbhost = $backupdb['ip'];
			$dbuser = $backupdb['mysqluser'];
			$dbpwd = $this->backup_setting_set->udf_decrypt($backupdb['mysqlpasswd']);
			$dbname = $backupdb['dbname'];			$dbcharset = 'utf8';
			$link = mysql_connect($dbhost, $dbuser, $dbpwd) ;
			if(empty($link)){
				alert_and_close('目标服务器无法访问');
				exit;
			}
			$rs = mysql_select_db($dbname);
			if(empty($rs)){
				alert_and_close('目标服务器没有数据库');
				exit;
			}
			mysql_query("SET character_set_connection=$dbcharset, character_set_results=$dbcharset, character_set_client=binary");
			$this->assign("backupdb_id", $backupdb_id);
		}
        $this->assign("logindebug", $_CONFIG['LOGIN_DEBUG']);
        $sid      = get_request('sid');
        $where    = "sid = '$sid'";
        $page_num = get_request('page');
        $command  = get_request('command', 0, 1);
        $startcid = get_request('startcid', 0, 1);
		$derive = get_request('derive');
        if ($startcid) {
            $where .= " AND cid > $startcid";
        }
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->sessions_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}

		if($derive==1){
			$sql = "SELECT b.addr,b.luser,b.user,b.type,a.at,a.cmd,m.realname FROM ".$this->commands_set->get_table_name()." a LEFT JOIN ".$this->sessions_set->get_table_name()." b ON a.sid=b.sid LEFT JOIN ".$this->member_set->get_table_name()." m ON b.luser=m.username WHERE a.sid='$sid'";
			$reports = $this->commands_set->base_select($sql);
			$str = "";
			$str .= language("序号")."\t".language("设备IP")."\t".language("堡垒机用户")."\t".language("设备用户")."\t".language("协议")." \t".language("执行时间")." \t".language("命令")."\t\n";
			$id=1;
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['addr']."\t".$report['luser']."(".$report['realname'].")\t".$report['user']."\t".$report['type']."\t".$report['at']."\t".$report['cmd'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=CommandReport.xls"); 
			echo iconv("UTF-8", "GB2312", $str);
			exit();
		
		}else if($derive==2){
			$sql = "SELECT b.addr,b.luser,b.user,b.type,a.at,a.cmd,m.realname FROM ".$this->commands_set->get_table_name()." a LEFT JOIN ".$this->sessions_set->get_table_name()." b ON a.sid=b.sid LEFT JOIN ".$this->member_set->get_table_name()." m ON b.luser=m.username WHERE a.sid='$sid'";
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('commands_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=auditreports.html"); 
			echo $str;
			exit();
		}
        
        $row_num  = $this->commands_set->select_count($where);
        $newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
        $this->assign('page_list', $newpager->showSerialList());
        $this->assign('command_num', $row_num);
        $this->assign('curr_page', $newpager->intCurrentPageNumber);
        $this->assign('total_page', $newpager->intTotalPageCount);
        $this->assign('items_per_page', $newpager->intItemsPerPage);
        
        $allcommand = $this->commands_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, '', 'asc');
        if($interface){
        	return $allcommand;
        }
        for ($j = 0; $j < count($allcommand); $j++) {
			$allcommand[$j]['cmd'] = htmlspecialchars($allcommand[$j]['cmd']);
            if ($command) {
                $allcommand[$j]['cmd'] = preg_replace("/($command)/i", "<font color='red'>\$1</font>", $allcommand[$j]['cmd']);
            }
        }
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);

        $this->assign('allcommand', $allcommand);
        $ha = $this->config_set->base_select("SELECT * FROM defaultpolicy LIMIT 1");
        $this->assign("default_control", $ha[0]['default_control']);
        $member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
        $this->assign('member', $member);
        $this->assign('sid', $sid);
        $this->assign('action', 'index');
        $this->display('session_view.tpl');
    }
    
    function del_command()
    {
		$cid = get_request('cid');
		$s = $this->commands_set->select_by_id($cid);
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->sessions_set->select_by_id($s['sid'])){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限');
					exit;
				}
			}
		}

       
        $this->commands_set->delete($cid);
        alert_and_back('删除成功');
    }
    
    function del_session()
    {
        $sid    = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->sessions_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
        $result = mysql_query("select logfile from " . $this->sessions_set->get_table_name() . " WHERE sid=$sid");
        while ($row = mysql_fetch_assoc($result)) {
            if (file_exists($row["logfile"])) {
                unlink($row["logfile"]);
                unlink($row["logfile"] . "onlight");
            }
        }
        $this->sessions_set->delete($sid);
        $this->commands_set->query("DELETE FROM `" . $this->commands_set->get_table_name() . "` WHERE sid = '$sid'");
        alert_and_back('删除成功');
    }
    
    function delete($where)
    {
        /*===============lwm===============*/
        //        print "select logfile from " . $this->sessions_set->get_table_name() . " WHERE $where";
        $result = mysql_query("select logfile from " . $this->sessions_set->get_table_name() . " WHERE $where");
        while ($row = mysql_fetch_assoc($result)) {
            if (file_exists($row["logfile"])) {
                unlink($row["logfile"]);
                unlink($row["logfile"] . "onlight");
            }
        }
        /*==============lwm================*/
        
        $this->commands_set->query("DELETE FROM `" . $this->commands_set->get_table_name() . "` WHERE `sid` IN (SELECT `sid` FROM `sessions` WHERE $where)");
        $this->sessions_set->query("DELETE FROM `" . $this->sessions_set->get_table_name() . "` WHERE $where");
        alert_and_back('删除成功');
    }
    
    function download()
    {
        header("Content-Type:text/html;charset=UTF-8");
        $sid        = get_request('sid');
		$command = get_request('command',0,1);
		$topage = get_request('topage',1,0);
		$backupdb_id = get_request('backupdb_id',0,1);
        $start_page = $_GET["start_page"];
		if(empty($start_page)) $start_page=1;
		if($_POST['dosearch']){
			$_SESSION['search_page_keyword'] = null;
			$_SESSION['search_page_array'] = array();
		}

        if (!defined($sid)) {
            $sid = $_GET["sid"];
        }
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->sessions_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
        $sessions   = $this->sessions_set->select_by_id($sid);
		if(!empty($backupdb_id)){
			$backupdb_info = $this->backup_setting_set->select_by_id($backupdb_id);
			header("Content-type: text/html; charset=utf-8");
			echo '录像文件名称:'.$backupdb_info['path'].'/'.$sessions['replayfile']."<br />";
			echo '文本文件名称:'.$backupdb_info['path'].'/'.$sessions['logfile']."<br />";
			exit;
		}else{
			echo "<form action='admin.php?controller=admin_session&action=download&sid=$sid' method='post'><a href='admin.php?controller=admin_session&action=downloadfile&sid=$sid'>录相文件下载</a>&nbsp;&nbsp;&nbsp;&nbsp;搜索：<input name='search' ><input type='submit' name='dosearch' value='搜索'></form><br />";
		}
        $logfile    = $sessions['logfile'];
        $replayfile = $sessions['replayfile'];
        $tarname    = substr($sessions['end'], 0, 7) . ".tar.gz";
        if (!$sessions) {
            //echo("log file backuped,please look up for it in the backup tar package<br>
            //logfile name:$logfile<br>
            //backup tar package:$tarname<br>");
            //die();
        }
        if ($logfile == NULL) {
            echo ("no logfile<br>");
            die();
            
        }
        if (!file_exists($logfile)) {
            echo ("no found logfile name:$logfile<br>");
            die();
        }
        
        $total_line = ceil(count(file($logfile))/500);
		if($_POST['search']){
			$_SESSION['search_page_keyword'] = $_POST['search'];
			$_SESSION['search_page_array'] = array();
			for($i=0; $i<$total_line; $i++){
				if(getFileLines($logfile, $i*500+1, ($i+1)*500 - 1, $_POST['search'])===true){
					$_SESSION['search_page_array'][]=$i;
				}
			}
			$topage = $_SESSION['search_page_array'][0]+1;
		}
		if($_SESSION['search_page_array']){
			
			echo '关键字"'.$_SESSION['search_page_keyword'].'" 在以下页中出现 ';
			for($i=0; $i<count($_SESSION['search_page_array']); $i++){
				echo "<a href=\"admin.php?controller=admin_session&action=download&sid=$sid&start_page=".($_SESSION['search_page_array'][$i]*500)."\">".($_SESSION['search_page_array'][$i]+1)."</a>&nbsp;&nbsp;";
			}
			echo "<br /><br /><br />";
		}
        //$value   =   file($logfile);
		if($topage){
			if($topage>=$total_line){
				$topage = $total_line;
			}
			$start_page = ($topage-1)*500;
		}
        $maxline   = count($value);
        $next_page = $start_page + 500;
        $pre_page  = $start_page - 500;
        if (empty($start_page)) {
            $start_page = 1;
            $pre_page   = 1;
        }
        $buffer_array = array();
		
		
        $buffer_array = getFileLines($logfile, $start_page, $next_page - 1);
		//$tmp2 = exec("cat $logfile | wc -l",$total_line,$return);
		
        //$tmp1 = exec("sed -n '$start_page,$next_page p' $logfile",$buffer_array,$return);
        //$tmp2 = exec("cat $logfile | wc -l",$total_line,$return);
        //print "<font color=red size=4px>Replay file run: display -s  $replayfile</font><br>";
        //print "<font color=blue size=4px>From line $start_page To line $next_page &nbsp &nbsp Totally $total_line[0] lines<br>Logfilename: $logfile</font><br><br>";
       
        
        foreach ($buffer_array as $tmp) {
			if($command)
				$tmp = preg_replace("/($command)/i", "<font color='red'>\$1</font>", htmlspecialchars($tmp));
			elseif($_SESSION['search_page_keyword'])
				$tmp = preg_replace("/(".$_SESSION['search_page_keyword'].")/i", "<font color='red'>\$1</font>", htmlspecialchars($tmp));
			else
				$tmp = htmlspecialchars($tmp);
            echo  $tmp. " <br>";
        }
		print "<br /><form action='admin.php?controller=admin_session&action=download&sid=$sid' method='post'>页码：".ceil(($start_page+1)/500).'/'.$total_line;

		if ($start_page > 500) {
            print "<a href=\"admin.php?controller=admin_session&action=download&sid=$sid&start_page=$pre_page\">上一页</a>";
        }
        
        if (count($buffer_array) == 500) {
            print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_session&action=download&sid=$sid&start_page=$next_page\">下一页</a>";
        }
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		 print "&nbsp &nbsp &nbsp 跳转:<input name='topage' ><input type='submit' value='提交'></form><br><br />";
		 if ($start_page > 500) {
          //  print "<a href=\"admin.php?controller=admin_session&action=download&sid=$sid&start_page=$pre_page\">pre page<br></a>";
        }
    }

	function downloadfile(){
		$sid = get_request('sid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->sessions_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_close('您没有权限查看');
					exit;
				}
			}
		}
        $sessions   = $this->sessions_set->select_by_id($sid);
		$sessions['replayfile']=str_replace("\"", "", $sessions['replayfile']);
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		header("Content-Disposition:filename=".$sessions['replayfile']);
		echo file_get_contents($sessions['replayfile']);
		exit();
	}
    
    function dangerlist()
    {
        $page_num = get_request('page');
        
        $row_num  = $this->dangercmd_set->select_count("1 = 1");
        $newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
        $this->assign('page_list', $newpager->showSerialList());
        $this->assign('command_num', $row_num);
        $this->assign('curr_page', $newpager->intCurrentPageNumber);
        $this->assign('total_page', $newpager->intTotalPageCount);
        $this->assign('items_per_page', $newpager->intItemsPerPage);
        
        $allcommand = $this->dangercmd_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage);
        
        $this->assign("allcommand", $allcommand);
        
        $this->display("dangercmd_list.tpl");
    }
    function forbidden_groups_list()
    {
        $page_num = get_request('page');
        $add      = get_request('add', 1, 1);
        $gname    = get_request('gname', 1, 1);
        if ($add == 'new') {
            $forbiddengps = new forbiddengps();
            $forbiddengps->set_data('gname', $gname);
            $this->forbiddengps_set->add($forbiddengps);
            alert_and_back('Success', 'admin.php?controller=admin_session&action=forbidden_groups_list');
            
        }
        
        $row_num  = $this->forbiddengps_set->select_count("1 = 1", 'black_or_white', 'asc');
        $newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
        $this->assign('page_list', $newpager->showSerialList());
        $this->assign('command_num', $row_num);
        $this->assign('curr_page', $newpager->intCurrentPageNumber);
        $this->assign('total_page', $newpager->intTotalPageCount);
        $this->assign('items_per_page', $newpager->intItemsPerPage);
        
        $allcommand = $this->forbiddengps_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage);
        
        $this->assign("allcommand", $allcommand);
        
        $this->display("forbiddengps_list.tpl");
    }
    function forbiddengps_cmd()
    {
        $page_num = get_request('page');
        $gid      = get_request('gid');
        $ginfo    = $this->forbiddengps_set->select_by_id($gid);
        $add      = get_request('add', 1, 1);
        $cmd      = get_request('cmd', 1, 1);
        $level    = get_request('level', 1, 1);
        if ($add == 'new') {
            $forbiddengpscommand = new forbiddengpscommand();
            $forbiddengpscommand->set_data('cmd', $cmd);
            $forbiddengpscommand->set_data('level', $level);
            $forbiddengpscommand->set_data('gid', $ginfo['gname']);
            $this->forbiddengpscommand_set->add($forbiddengpscommand);
            alert_and_back('Success', 'admin.php?controller=admin_session&action=forbiddengps_cmd&gid=' . $gid);
            
        }
        
        $row_num  = $this->forbiddengpscommand_set->select_count("1 = 1 AND gid='" . $ginfo['gname'] . "'");
        $newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
        $this->assign('page_list', $newpager->showSerialList());
        $this->assign('command_num', $row_num);
        $this->assign('curr_page', $newpager->intCurrentPageNumber);
        $this->assign('total_page', $newpager->intTotalPageCount);
        $this->assign('items_per_page', $newpager->intItemsPerPage);
        $this->assign("gid", $gid);
        
        $allcommand = $this->forbiddengpscommand_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, "1 = 1 AND gid='" . $ginfo['gname'] . "'");
        
        $this->assign("allcommand", $allcommand);
        
        $this->display("forbiddengps_cmd.tpl");
    }
    function forbiddengps_user()
    {
        $page_num = get_request('page');
        $gid      = get_request('gid');
        $ginfo    = $this->forbiddengps_set->select_by_id($gid);
        
        $add   = get_request('add', 1, 1);
        $cmd   = get_request('cmd', 1, 1);
        $level = get_request('level', 1, 1);
        
        $row_num  = $this->forbiddengpsuser_set->select_count("1 = 1 AND gid='" . $ginfo['gname'] . "'");
        $newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
        $this->assign('page_list', $newpager->showSerialList());
        $this->assign('command_num', $row_num);
        $this->assign('curr_page', $newpager->intCurrentPageNumber);
        $this->assign('total_page', $newpager->intTotalPageCount);
        $this->assign('items_per_page', $newpager->intItemsPerPage);
        $this->assign("gid", $gid);
        
        $allcommand = $this->forbiddengpsuser_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, "1 = 1 AND gid='" . $ginfo['gname'] . "'");
        
        $this->assign("allcommand", $allcommand);
        
        $this->display("forbiddengps_user.tpl");
    }
    
    function protect_group()
    {
        $uid         = get_request('uid');
        $member      = $this->member_set->select_by_id($uid);
        $alldevgroup = $this->sgroup_set->select_all();
        $allpass     = $this->devpass_set->select_all(" luser like '%,$uid,%'");
        $s_dev       = array();
        $alltem      = $this->tem_set->select_all();
        if (!empty($allpass))
            foreach ($allpass as $pass) {
                if ($pass['device_ip'] != $ip) {
                    $s_dev[] = $pass;
                    $ip      = $pass['device_ip'];
                }
            }
        $num = count($allpass);
        for ($ii = 0; $ii < $num; $ii++) {
            foreach ($alltem as $tem) {
                if ($allpass[$ii]['login_method'] == $tem['id']) {
                    $allpass[$ii]['login_method'] = $tem['login_method'];
                }
                
            }
        }
        $this->assign('title', language('选择要绑定的设备'));
        $this->assign('id', $uid);
        $this->assign('username', $member['username']);
        $this->assign('s_dev', $s_dev);
        $this->assign('alldevgroup', $alldevgroup);
        $this->assign('allpass', $allpass);
        $this->display('forbidden_group_user.tpl');
    }
    
    function forbiddengps_alluser()
    {
        $allmem = $this->member_set->select_all("uid not in (SELECT radiususer FROM " . $this->devpass_set->get_table_name() . " WHERE radiususer>0)");
        $this->assign("allmem", $allmem);
        $this->display("forbiddengps_alluser.tpl");
    }
    function del_forbiddengps_cmd()
    {
        $cid = get_request('cid');
        $gid = get_request('gid');
        $this->forbiddengpscommand_set->delete($cid);
        alert_and_back('Success', 'admin.php?controller=admin_session&action=forbiddengps_cmd&gid=' . $gid);
        
    }
    function del_forbiddengps()
    {
        $gid = get_request('gid');
        $this->forbiddengps_set->delete($gid);
        alert_and_back('Success', 'admin.php?controller=admin_session&action=forbidden_groups_list');
        
    }
    
    function add_cmd()
    {
        $cmd = trim(get_request('cmd', 1, 1));
        if ($cmd != "") {
            $level     = get_request('level', 1, 0);
            $dangercmd = new dangercmd();
            $dangercmd->set_data('cmd', $cmd);
            $dangercmd->set_data('level', $level);
            $this->dangercmd_set->add($dangercmd);
            alert_and_back('Success', 'admin.php?controller=admin_session&action=dangerlist');
            
        } else {
            alert_and_back('Error', 'admin.php?controller=admin_session&action=dangerlist');
        }
    }
    
    
    function del_dangercmd()
    {
        $id = get_request('id');
        $this->dangercmd_set->delete($id);
        alert_and_back('Success', 'admin.php?controller=admin_session&action=dangerlist');
        
    }
    function get_eth0_ip()
    {
        global $_CONFIG;
        $eth0 = explode(":", $_SERVER["HTTP_HOST"]);
        return array(
            'eth0' => $eth0[0]
        );
        $filename = $_CONFIG['CONFIGFILE']['IFGETH0'];
        //$filename = 'controller/ifcfg-eth0';
        $return   = array();
        if (file_exists($filename)) {
            $lines = file($filename);
            for ($ii = 0; $ii < count($lines); $ii++) {
                if (strstr(strtoupper($lines[$ii]), "IPADDR")) {
                    $tmp                        = explode("=", $lines[$ii]);
                    $network['IPADDR']['value'] = $tmp[1];
                    $network['IPADDR']['file']  = $filename;
                }
            }
        } else {
            //alert_and_back('配置文件不存在');
        }
        $return['eth0'] = trim($network['IPADDR']['value']);
        return $return;
    }
    
    function replay()
    {
        global $_CONFIG;
        $this->assign("activex_version", $_CONFIG['ACTIVEX_VERSION']);
        $this->assign("logindebug", $_CONFIG['LOGIN_DEBUG']);
        $sid     = get_request('sid');
        $cid     = get_request('cid');
        $tool    = get_request('tool', 0, 1);
        $app_act = get_request('app_act', 0, 1);
        $a       = $this->get_eth0_ip();

		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->sessions_set->select_by_id($sid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					echo ('alert("您没有权限查看");');
					exit;
				}
			}
		}
        if(empty($cid)){
			$_cid=$this->commands_set->base_select("select cid from ".$this->commands_set->get_table_name()." limit 1");
			if($_cid) $cid=$_cid[0]['cid'];
		}
        $this->assign("sid", $sid);
        $this->assign("cid", $cid);
        $this->assign("app_act", $app_act);
        
        $session = $this->sessions_set->select_by_id($sid);
		//var_dump(str_replace("\"", "", $session['replayfile']));var_dump(file_exists(str_replace("\"", "", $session['replayfile'])));
        if(!file_exists(str_replace("\"", "", $session['replayfile']))){
			echo ('alert("回放文件不存在");');
			exit;
		}
        if ($cid) {
            $guestaddr = ip2long($_SERVER['REMOTE_ADDR']);
            $proxyips  = $this->proxyip_set->select_all("source!='0.0.0.0'");
            $outip     = $this->proxyip_set->select_all("source='0.0.0.0'");
            $eth0      = $outip[0]['proxyip'];
            for ($i = 0; $i < count($proxyips); $i++) {
                //long2ip(ip2long('192.168.1.2')&ip2long('255.255.255.0'))
                if (long2ip($guestaddr & ip2long($proxyips[$i]['network'])) == $proxyips[$i]['source']) {
                    $eth0 = $proxyips[$i]['proxyip'];
                }
            }
            if (empty($eth0)) {
                $eth0 = $a['eth0'];
            }
            
            //$session['host']=$eth0;
            $this->assign("s", $session);
            $this->assign("tool", $tool);
            $this->assign("proxy_addr", $eth0);
            $this->assign("monitorport", $_CONFIG['MONITORPORT']);
            $this->assign("monitoruser", $_CONFIG['MONITORUSER']);
            $this->assign("monitorpassword", $_CONFIG['MONITORPASSWORD']);
            $this->assign("cid", $cid);
            
            $str    = genRandomString(8);
            $random = new random();
            $random->set_data('device_ip', '127.0.0.1');
            $random->set_data('username', $session['luser']);
            $random->set_data('luser', $session['luser'] . '--monitor1--' . $sid . '--' . $cid);
            $random->set_data('time', date('Y-m-d H:i:s'));
            $random->set_data('code', $str);
            $this->random_set->add($random);
            
            $this->assign('random', $str);
            $this->display('replay.tpl');
            exit;
        } elseif ($tool) {
            $guestaddr = ip2long($_SERVER['REMOTE_ADDR']);
            $proxyips  = $this->proxyip_set->select_all("source!='0.0.0.0'");
            $outip     = $this->proxyip_set->select_all("source='0.0.0.0'");
            $eth0      = $outip[0]['proxyip'];
            for ($i = 0; $i < count($proxyips); $i++) {
                //long2ip(ip2long('192.168.1.2')&ip2long('255.255.255.0'))
                if (long2ip($guestaddr & ip2long($proxyips[$i]['network'])) == $proxyips[$i]['source']) {
                    $eth0 = $proxyips[$i]['proxyip'];
                }
            }
            if (empty($eth0)) {
                $eth0 = $a['eth0'];
            }
            $this->assign("s", $session);
            $this->assign("tool", $tool);
            $this->assign("proxy_addr", $eth0);
            $this->assign("cid", $cid ? $cid : 0);
            $this->assign("monitorport", $_CONFIG['MONITORPORT']);
            $this->assign("monitoruser", $_CONFIG['MONITORUSER']);
            $this->assign("monitorpassword", $_CONFIG['MONITORPASSWORD']);
            
            $str    = genRandomString(8);
            $random = new random();
            $random->set_data('device_ip', '127.0.0.1');
            $random->set_data('username', $session['luser']);
            $random->set_data('luser', $session['luser'] . '--monitor1--' . $sid . '--' . $cid);
            $random->set_data('time', date('Y-m-d H:i:s'));
            $random->set_data('code', $str);
            $this->random_set->add($random);
            $this->assign('random', $str);
            $this->display('replay.tpl');
            exit;
        }
        
        $this->assign('serveradd', $_SERVER['SERVER_NAME']);
        $this->assign('serverport', $_SERVER[SERVER_PORT]);
        //		$this->assign('filename',str_replace('"','''," -S ".strtotime($time)." ".$session['replayfile']));
        $this->assign('filename', str_replace('"', '', $session['replayfile']));
        
        $this->display('replays.tpl');
    }
    function forbiddencms_edit()
    {
        $id          = get_request('id');
        $ac          = get_request('ac', 1, 1);
        $addr        = get_request('addr', 1, 1);
        $cmd         = get_request('cmd', 1, 1);
        $radius_user = get_request('radius_user', 1, 1);
        $this->assign('ip', $ip);
        if ($ac == 'new') {
            $forbiddencmds = new forbiddencmds();
            $forbiddencmds->set_data("addr", $addr);
            $forbiddencmds->set_data("cmd", $cmd);
            $forbiddencmds->set_data("radius_user", $radius_user);
            $this->forbiddencmds_set->add($forbiddencmds);
            alert_and_back('Success', 'admin.php?controller=admin_session&action=forbidden_commands_list');
        }
        
        $allmem = $this->member_set->select_all("uid not in (SELECT radiususer FROM " . $this->devpass_set->get_table_name() . " WHERE radiususer>0)");
        
        
        $alladdrtmp = $this->devpass_set->select_all(' 1=1 ');
        $num        = count($alladdrtmp);
        $alladdr    = array();
        for ($ii = 0; $ii < $num; $ii++) {
            if (!in_array($alladdrtmp[$ii][device_ip], $alladdr)) {
                $alladdr[] = $alladdrtmp[$ii][device_ip];
            }
        }
        
        $this->assign("alladdr", $alladdr);
        $this->assign('allmem', $allmem);
        
        $this->assign('title', langauge("管理用户"));
        $this->display('forbiddencmds_edit.tpl');
    }
    
    function running_list()
    {
        //exec("ps -ef | grep SSH",$output);
        exec("ps -o ruser,pid,cmd,stime -C ssh", $output);
        //$output = file("./controller/1.txt");
        $targets = array();
        $i       = 0;
        $j       = 0;
        foreach ($output as $line) {
            if ($j == 0) {
                $j++;
                continue;
            }
            
            $arr                  = preg_split("/\s{1,}/", $line);
            $targets[$i]["ruser"] = $arr[0];
            $targets[$i]["pid"]   = $arr[1];
            for ($ii = 2; $ii < count($arr) - 1; $ii++) {
                $targets[$i]["cmd"] .= ' ' . $arr[$ii];
            }
            $targets[$i]["time"] = $arr[count($arr) - 1];
            $i++;
        }
        $output = 0;
        //exec("ps -ef | grep TELNET",$output);
        $j      = 0;
        exec("ps -o ruser,pid,cmd,stime -C telnet", $output);
        //$output = file("./controller/2.txt");
        foreach ($output as $line) {
            if ($j == 0) {
                $j++;
                continue;
            }
            $arr                  = preg_split("/\s{1,}/", $line);
            $targets[$i]["ruser"] = $arr[0];
            $targets[$i]["pid"]   = $arr[1];
            
            for ($ii = 2; $ii < count($arr); $ii++) {
                $targets[$i]["cmd"] .= ' ' . $arr[$ii];
            }
            $i++;
            
        }
        $this->assign("allsession", $targets);
        $this->display("running_list.tpl");
    }
    
    function gateway_running_list($r=0, $pre='')
    {
        global $_CONFIG;
		
        $this->assign("logindebug", $_CONFIG['LOGIN_DEBUG']);
        //网关
        $targets = array();
        $i       = 0;
        $j       = 0;
        /*
        exec(" ps -ef | grep ssh-audit", $output);
		$s = array();
		for($i=0; $i<count($output); $i++){
			$_s = preg_split("/[\s]+/", $output[$i]);
			if($_s[2]==1){
				$mainid= $_s[1];
			}else{
				$s[]=$_s;
			}
			
		}
		for($i=0; $i<count($s); $i++){
			if($s[$i][2]==$mainid){
				$sess[]=$s[$i][1];
			}
		}*/
		
		$where = 'type="ssh"';
		$page_num = get_request('page');
		$ip = get_request('addr', 0, 1);
		$user = get_request('user', 0, 1);
		$luser = get_request('luser', 0, 1);
		$start = get_request('start1', 0, 1);
		if(intval($page_num)<1){
			if(!$_CONFIG['DB_DEBUG'])
			ob_start();
			$sshrun=1;
			require_once("sshrun.php");
			if(!$_CONFIG['DB_DEBUG'])
			$ob=ob_get_clean();	
		}
		if($ip){
			$where .= " AND addr like '%$ip%'";
		}
		if($user){
			$where .= " AND user like '%$user%'";
		}
		if($luser){
			$where .= " AND luser like '%$luser%'";
		}
		if($start){
			$where .= " AND start >= '$start'";
		}

		$multipleselect=1;
		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$alltmpip = array(0);
			$allips = $this->sessionsrun_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$g_id.") or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$g_id."))");
			for($i=0; $i<count($allips); $i++){
				$alltmpip[]=$allips[$i]['device_ip'];
			}
			if($alltmpip)
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')";
		}
		
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			$allips = $this->sessionsrun_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
			for($i=0; $i<count($allips); $i++){
				$alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')";
		}
		$s=null;
		$row_num = $this->sessionsrun_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign($pre.'page_list', $newpager->showSerialList());
		$this->assign($pre.'command_num', $row_num);
		$this->assign($pre.'curr_page', $newpager->intCurrentPageNumber);
		$this->assign($pre.'total_page', $newpager->intTotalPageCount);
		$this->assign($pre.'items_per_page', $newpager->intItemsPerPage);
		$this->assign($pre.'curr_url', $curr_url);
		$this->assign($pre.'command', $command);
		if (!$orderby1) {
			$orderby1 = "sid";
		}
		
		//$targets=$this->sessions_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		$targets = $this->sessionsrun_set->base_select("SELECT * FROM ".$this->sessionsrun_set->get_table_name()." WHERE $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		if($r==1) return $targets;

        //echo '<pre>';print_r($targets);echo '</pre>';
        $member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
        $this->assign("member", $member);
        $this->assign("allsession", $targets);
		$usergroup = $this->usergroup_set->select_all(" level=0 and attribute!=1".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''), 'groupname', 'asc');
		$this->assign('usergroup', $usergroup);
		$this->assign('allgroup', $usergroup);
		$this->assign('_config',$_CONFIG);
        $this->display("gateway_running_list.tpl");
    }
    
    function gateway_running_telnet($r=0, $pre='')
    {
        global $_CONFIG;
        $this->assign("logindebug", $_CONFIG['LOGIN_DEBUG']);
        //网关
        $targets = array();
        $i       = 0;
        $j       = 0;
        
        //堡垒
       /* //exec("ps -ef | grep SSH",$output);
        //echo '<pre>';print_r($targets);echo '</pre>';
        $output = null;
        exec("ps  -o stime,cmd -C freesvr_sshproxy_telnet.pl", $output);
        //$output = file("./controller/3.txt");
        //$targets = array();
        $j = 0;
        
        if (!empty($output))
            foreach ($output as $line) {
                if ($j % 2 == 0) {
                    $j++;
                    continue;
                }
                $j++;
                if (!strstr($line, '/usr/bin/perl')) {
                    $line = '/usr/bin/perl ' . $line;
                }
                $arr = preg_split("/\s{1,}/", $line);
                
                $tmp = explode("=", $arr[3]);
                
                $targets[$i]["pid"]        = $tmp[1];
                $targets[$i]["dest"]       = $arr[4];
                $targets[$i]["source"]     = $arr[5];
                $targets[$i]["radiususer"] = $arr[6];
                $targets[$i]['time']       = $arr[0];
                $targets[$i]["mtype"]      = 'fort';
                if (strstr($tmp[0], "ssh")) {
                    $targets[$i]["type"]       = 'ssh';
                    $tmp2                      = explode(".", $tmp[1]);
                    $targets[$i]["pid"]        = $tmp2[0];
                    $targets[$i]["id"]         = $tmp2[1];
                    $tmp3                      = explode(":", $arr[4]);
                    $targets[$i]["dest"]       = $tmp3[0];
                    $tmp3                      = explode(":", $arr[5]);
                    $targets[$i]["soruce"]     = $tmp3[0];
                    $targets[$i]["loginuser"]  = $arr[6];
                    $targets[$i]["radiususer"] = $arr[7];
                } elseif (strstr($tmp[0], "telnet")) {
                    $targets[$i]["type"] = 'telnet';
                } else {
                    continue;
                }
                $first3 = strtolower(substr($targets[$i]["time"], 0, 3));
                
                switch ($first3) {
                    case "jan":
                        $targets[$i]["order"] = '01' . substr($targets[$i]["time"], 3);
                        break;
                    case "feb":
                        $targets[$i]["order"] = '02' . substr($targets[$i]["time"], 3);
                        break;
                    case "mar":
                        $targets[$i]["order"] = '03' . substr($targets[$i]["time"], 3);
                        break;
                    case "apr":
                        $targets[$i]["order"] = '04' . substr($targets[$i]["time"], 3);
                        break;
                    case "may":
                        $targets[$i]["order"] = '05' . substr($targets[$i]["time"], 3);
                        break;
                    case "jun":
                        $targets[$i]["order"] = '06' . substr($targets[$i]["time"], 3);
                        break;
                    case "jul":
                        $targets[$i]["order"] = '07' . substr($targets[$i]["time"], 3);
                        break;
                    case "aug":
                        $targets[$i]["order"] = '08' . substr($targets[$i]["time"], 3);
                        break;
                    case "sep":
                        $targets[$i]["order"] = '09' . substr($targets[$i]["time"], 3);
                        break;
                    case "oct":
                        $targets[$i]["order"] = '10' . substr($targets[$i]["time"], 3);
                        break;
                    case "nov":
                        $targets[$i]["order"] = '11' . substr($targets[$i]["time"], 3);
                        break;
                    case "dec":
                        $targets[$i]["order"] = '12' . substr($targets[$i]["time"], 3);
                        break;
                    default:
                        $targets[$i]["order"] = '2' . str_replace(":", "", $targets[$i]["time"]);
                        break;
                }
                $i++;
            }
        if ($targets)
            foreach ($targets AS $key => $val) {
                $keys[$key] = $val['order'];
            }
        //
        
		exec(" ps -ef | grep telnet", $output);
		$s = array();
		for($i=0; $i<count($output); $i++){
			$_s = preg_split("/[\s]+/", $output[$i]);
			$s[]=$_s[1];
		}
		*/
		$where = 'type="telnet"';
		$ip = get_request('addr', 0, 1);
		$user = get_request('user', 0, 1);
		$luser = get_request('luser', 0, 1);
		$start = get_request('start1', 0, 1);
		if($ip){
			$where .= " AND addr like '%$ip%'";
		}
		if($user){
			$where .= " AND user like '%$user%'";
		}
		if($luser){
			$where .= " AND luser like '%$luser%'";
		}
		if($start){
			$where .= " AND start >= '$start'";
		}
		if(intval($page_num)<1){
			if(!$_CONFIG['DB_DEBUG'])
			ob_start();
			$telnetrun=1;
			require_once("sshrun.php");
			if(!$_CONFIG['DB_DEBUG'])
			ob_end_clean();	
		}
		
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
			for($i=0; $i<count($allips); $i++){
				$alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')";
		}
		$multipleselect=1;
		$g_id=$groupid = $_POST['groupid'];
		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$alltmpip = array(0);
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$alltmpip[]=$allips[$i]['device_ip'];
			}
			if($alltmpip)
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')";
		}
			
		$s=null;
		$row_num = $this->sessionsrun_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign($pre.'page_list', $newpager->showSerialList());
		$this->assign($pre.'session_num', $row_num);
		$this->assign($pre.'curr_page', $newpager->intCurrentPageNumber);
		$this->assign($pre.'total_page', $newpager->intTotalPageCount);
		$this->assign($pre.'items_per_page', $newpager->intItemsPerPage);
		$this->assign($pre.'curr_url', $curr_url);
		$this->assign($pre.'command', $command);
		if (!$orderby1) {
			$orderby1 = "sid";
		}
		//$targets=$this->sessions_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		$targets = $this->sessionsrun_set->base_select("SELECT * FROM ".$this->sessionsrun_set->get_table_name()." WHERE $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		if($r==1) return $targets;
        //echo '<pre>';print_r($targets);echo '</pre>';
        $member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
        $this->assign("member", $member);
		$usergroup = $this->usergroup_set->select_all(" level=0 and attribute!=1".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''), 'groupname', 'asc');
		$this->assign('usergroup', $usergroup);
		$this->assign('allgroup', $usergroup);
        $this->assign("allsession", $targets);
        $this->display("gateway_running_telnet.tpl");
    }
    
    function monitor()
    {
        global $_CONFIG;
        $this->assign("activex_version", $_CONFIG['ACTIVEX_VERSION']);
        $luser   = get_request('luser', 0, 1);
        $app_act = get_request('app_act', 0, 1);
        $pid     = get_request("pid");
        $b       = explode(".", $pid);
        $_sid = $b[1];
        $type = get_request("type", 0, 1);
        $ltype = get_request("ltype", 0, 1);
        $tool = get_request('tool', 0, 1);
        if ($ltype == 'ssh') {
            $b[1] = '0';
        }else{
			$b[1] = 'baolei';
		}
        $guestaddr = ip2long($_SERVER['REMOTE_ADDR']);
        $proxyips  = $this->proxyip_set->select_all("source!='0.0.0.0'");
        $outip     = $this->proxyip_set->select_all("source='0.0.0.0'");
        $eth0      = $outip[0]['proxyip'];
        $guestaddr = ip2long($_SERVER['REMOTE_ADDR']);
        for ($i = 0; $i < count($proxyips); $i++) {
            //long2ip(ip2long('192.168.1.2')&ip2long('255.255.255.0'))
            if (long2ip($guestaddr & ip2long($proxyips[$i]['network'])) == $proxyips[$i]['source']) {
                $eth0 = $proxyips[$i]['proxyip'];
            }
        }
        $a = $this->get_eth0_ip();
        if (empty($eth0)) {
            $eth0 = $a['eth0'];
        }
        $session = $this->sessionsrun_set->select_by_id($_sid);
        $session['host'] =  $session['baoleiip'];
        $this->assign("app_act", $app_act);
        $this->assign("type", $type);
        $this->assign("tool", $tool);
        $this->assign("s", $session);
        $this->assign("monitorport", $_CONFIG['MONITORPORT']);
        $this->assign("monitoruser", $_CONFIG['MONITORUSER']);
        $this->assign("sid", $b[0]);
        $this->assign("cid", $b[1]);
        $this->assign("luser", $luser);
        
        $str    = genRandomString(8);
        $random = new random();
        $random->set_data('device_ip', '127.0.0.1');
        $random->set_data('username', $luser);
        $random->set_data('luser', $luser . '--monitor2--' . $b[0] . '--' . $b[1]);
        $random->set_data('time', date('Y-m-d H:i:s'));
        $random->set_data('code', $str);
        $this->random_set->add($random);
        
        $this->assign('random', $str);
        $this->display("monitor.tpl");
    }
    
    
    function cut_running()
    {
		$cutoff=1;
		$stype='ssh';
		require_once('sshrun.php');
		exit;
        global $_CONFIG;
        $pid = get_request('pid', 0, 1);
        $b   = explode(".", $pid);
        $cmd = 'sudo ' . $_CONFIG['RUNNING_CUTOFF'] . ' ' . $b[0];
        exec($cmd, $out, $return);
        if ($return == 0) {
            alert_and_back('执行成功');
            exit;
        } else {
            alert_and_back('执行失败');
            exit;
        }
        
    }
    
    function search_html_log()
    {
        global $_CONFIG;
        $ac = get_request("ac", 1, 1);
		$page_num = get_request('page');
		 $contents    = get_request("content", 0, 1);
		$ssh_or_rdp  = get_request("ssh_or_rdp", 0, 1);
		$start_date  = get_request("start_date", 0, 1);
		$end_date    = get_request("end_date", 0, 1);
		$ip          = get_request("ip", 0, 1);
		$remote_user = get_request("remote_user", 0, 1);
		$radius_user = get_request("radius_user", 0, 1);
		$where = " search_user='".$_SESSION['ADMIN_USERNAME']."' ";
		
		if (empty($start_date)) {
			$start_date = 'ANY';
		}
		if (empty($end_date)) {
			$end_date = 'ANY';
		}
		if (empty($ip)) {
			$ip = 'ANY';
		}
		if (empty($remote_user)) {
			$remote_user = 'ANY';
		}
		if (empty($radius_user)) {
			$radius_user = 'ANY';
		}
        if ($contents) {
    
            
			if($page_num<2){
				$cmd = $_CONFIG['SEARCH_HTML_LOG'] . ' ' . $_SESSION['ADMIN_USERNAME'] . ' 1000000  ' . ($start_date == 'ANY' ? $start_date : "'".$start_date."'") . ' ' .  ($end_date == 'ANY' ? $end_date : "'".$end_date."'") . ' ' . $ip . ' ' . $remote_user . ' ' . $radius_user. ' '. $contents  ;
				if ($ssh_or_rdp == 'rdp') {
					$cmd = $_CONFIG['SEARCH_RDP_LOG'] . ' ' . $_SESSION['ADMIN_USERNAME'] . ' 1000000  ' . ($start_date == 'ANY' ? $start_date : "'".$start_date."'") . ' ' . ($end_date == 'ANY' ? $end_date : "'".$end_date."'") . ' ' . $ip . ' ' . $remote_user . ' ' . $radius_user. ' '. $contents ;
					
				}
				$cmd = iconv("UTF-8", "GB2312", $cmd);
				if($_CONFIG['LOGIN_DEBUG']){
					echo $cmd;
				}

				exec($cmd, $output);
			}
            $member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
            $this->assign('member', $member);
             
            $this->assign("ssh_or_rdp", $ssh_or_rdp);
			/*
            if ($output)
                foreach ($output AS $line) {
                    $linearr = preg_split("/,/", $line);
                    if (!is_numeric($linearr[0])) {
                        continue;
                    }
                    $alllog[] = $linearr;
                }
            */
			$curr_url = $_SERVER['PHP_SELF'] . "?";
			if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
				$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
			}
			else {
				$curr_url .= $_SERVER['QUERY_STRING'];
			}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

			if($ssh_or_rdp == 'rdp'){
				$row_num = $this->search_rdp_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$alllog = $this->search_rdp_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, 'start', 'desc');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);
				$this->assign('curr_url', $curr_url);		

			}else{
				$row_num = $this->search_html_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$alllog = $this->search_html_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, 'line_num', 'asc');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);
				$this->assign('curr_url', $curr_url);		
			}

            $this->assign("alllog", $alllog);
        }
        $this->assign("title", language("内容查找"));
        $this->assign("logindebug", $_CONFIG['LOGIN_DEBUG']);
        $this->display('search_html_log.tpl');
    }
    
    function search_html_log_download()
    {
        header("Content-Type:text/html;charset=GB2312");
        $sid        = get_request('sid');
		$nodirect   = get_request('nodirect');
        $start_page = $_GET["start_page"];
        $file       = $_GET['file'];
        $line       = $_GET['line'];
        if (!defined($sid)) {
            $sid = $_GET["sid"];
        }

		$lines = $this->search_html_set->select_all("logfile='".$file."' AND line_num > ".(($line-$line%500)*500)." AND line_num < ".(($line-$line%500+1)*500 ),'line_num', 'asc');
		if(empty($lines)){
			echo 'no such file';
			exit;
		}
		for($i=0; $i<count($lines); $i++){
			$line_num_array[]=$lines[$i]['line_num']%500;
		}
//var_dump($line_num_array);
        if($line > $start_page && empty($nodirect)){
			$start_page = $line-$line%500+1;
		}
        $logfile = $file;
        
        $tarname = substr($sessions['end'], 0, 7) . ".tar.gz";
        
        if ($logfile == NULL) {
            echo ("log file backuped,please look up for it in the backup tar package<br>
			logfile name:$logfile<br>
			backup tar package:$tarname<br>");
            die();
            
        }
        if (!file_exists($logfile)) {
            echo ("log file backuped,please look up for it in the backup tar package<br>
			logfile name:$logfile<br>
			backup tar package:$tarname<br>");
            die();
        }
        $next_page = $start_page + 500;
        $pre_page  = $start_page - 500;
        if (empty($start_page)) {
            $start_page = 1;
            $pre_page   = 1;
        }
        $buffer_array = array();
        $total_line   = array();
		
        $buffer_array = getFileLines($logfile, $start_page, $next_page - 1);
        print "<font color=blue size=4px>From line $start_page To line $next_page &nbsp &nbsp Totally $total_line[0] lines</font> --><br><br>";
        if ($start_page > 500) {
            print "<a href=\"admin.php?controller=admin_session&action=search_html_log_download&file=$logfile&start_page=$pre_page&nodirect=1&line=".$line."\">pre page<br></a>";
        }
        
        if (count($buffer_array) == 500) {
            print "&nbsp &nbsp &nbsp <a href=\"admin.php?controller=admin_session&action=search_html_log_download&file=$logfile&start_page=$next_page&nodirect=1&line=".$line."\">next page</a><br>";
        }
		

        $i = 1;		
		
		foreach ($buffer_array as $tmp) {
			if (in_array($i,$line_num_array)) {
				echo ($i+$start_page-1)." <font color='red'>" . $tmp . "</font><br>";
			} else {
				echo ($i+$start_page-1)." ".$tmp . "<br>";
			}
			$i++;
		}
    }
    
    
    
    function batch_del()
    {
        $ac             = get_request('ac', 1, 1);
        $ssh            = get_request('ssh', 1, 1);
        $rdp            = get_request('rdp', 1, 1);
        $sqlnet         = get_request('sqlnet', 1, 1);
        $sybase         = get_request('sybase', 1, 1);
        $mysql          = get_request('mysql', 1, 1);
        $db2            = get_request('db2', 1, 1);
        $http           = get_request('http', 1, 1);
        $ftp            = get_request('ftp', 1, 1);
        $sftp           = get_request('sftp', 1, 1);
        $as400          = get_request('as400', 1, 1);
        $apppub         = get_request('apppub', 1, 1);
        $vnc            = get_request('vnc', 1, 1);
        $sqlserver      = get_request('sqlserver', 1, 1);
        $loginacct      = get_request('loginacct', 1, 1);
        $f_rangeStart   = get_request('f_rangeStart', 1, 1);
        $f_rangeEnd     = get_request('f_rangeEnd', 1, 1);
        $f_rangeStart2  = get_request('f_rangeStart2', 1, 1);
        $f_rangeEnd2    = get_request('f_rangeEnd2', 1, 1);
        $where          = " 1=1 ";
        $whereloginacct = " 1=1 ";
        if ($f_rangeStart) {
            $where .= " AND start >= '" . $f_rangeStart . "'";
            $whereloginacct .= " AND time >= '" . $f_rangeStart . "'";
        }
        if ($f_rangeEnd) {
            $where .= " AND end >= '" . $f_rangeEnd . "'";
        }
        if ($f_rangeStart2) {
            $where .= " AND start <= '" . $f_rangeStart2 . "'";
            $whereloginacct .= " AND time <= '" . $f_rangeStart2 . "'";
        }
        if ($f_rangeEnd2) {
            $where .= " AND end <= '" . $f_rangeEnd2 . "'";
        }
	
        if ($ac == 'del') {
			set_time_limit(0);
			$total = 0;
			if ($ssh) {
				$resource .= 'session/telnet';
				if($_POST['device_ip'])
				$whereIp = " AND addr IN('".implode("','", $_POST['device_ip'])."')";
				$total += $this->sessions_set->select_count($where.$whereIp);
            }
            if ($rdp) {
				$resource .= ' rdp';
				if($_POST['device_ip'])
				$whereIp = " AND addr IN('".implode("','", $_POST['device_ip'])."')";
                $total += $this->rdp_set->select_count($where.$whereIp . " AND (login_template=8 or login_template=22)");
            }
            if ($http) {
				$resource .= ' http';
				if($_POST['device_ip'])
				$whereIp = " AND addr IN('".implode("','", $_POST['device_ip'])."')";
                $total += $this->rdp_set->select_count($where.$whereIp . " AND login_template=14 ");
            }
            if ($ftp) {
				$resource .= ' ftp';
				if($_POST['device_ip'])
				$whereIp = " AND svraddr IN('".implode("','", $_POST['device_ip'])."')";
                $total += $this->ftpsession_set->select_count($where.$whereIp);
                
            }
            if ($sftp) {
				$resource .= ' sftp';
				if($_POST['device_ip'])
				$whereIp = " AND svraddr IN('".implode("','", $_POST['device_ip'])."')";
                $total += $this->sftpsession_set->select_count($where.$whereIp);
                
            }
            if ($as400) {
				$resource .= ' as400';
				if($_POST['device_ip'])
				$whereIp = " AND addr IN('".implode("','", $_POST['device_ip'])."')";
                $total += $this->AS400_sessions_set->select_count($where.$whereIp);
            }
            if ($vnc) {
				$resource .= ' vnc';
				if($_POST['device_ip'])
				$whereIp = " AND addr IN('".implode("','", $_POST['device_ip'])."')";
                $total += $this->rdp_set->select_count($where.$whereIp . " AND (login_template=21)");
            }
$width = 500;                       //显示的进度条长度，单位 px  
if($total>0)
$pix = $width / $total;             //每条记录的操作所占的进度条单位长度  
else
$pix = $width;
$progress = 0;                      //当前进度条长度  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/transitional.dtd">  
<html>  
<head>  
    <title>动态显示服务器运行程序的进度条</title>  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />  
    <style>  
    body, div input { font-family: Tahoma; font-size: 9pt }  
    </style>  
    <script language="JavaScript">  
    <!--  
    function updateProgress(sMsg, iWidth)  
    {    
        document.getElementById("status").innerHTML = sMsg;  
        document.getElementById("progress").style.width = iWidth + "px";  
        document.getElementById("percent").innerHTML = parseInt(iWidth / <?php echo $width; ?> * 100) + "%";  
     }  
    //-->  
    </script>       
</head>  
  
<body>  
<div style="margin: 4px; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: <?php echo $width+8; ?>px">  
    <div><font color="gray">操作进度</font></div>  
    <div style="padding: 0; background-color: white; border: 1px solid navy; width: <?php echo $width; ?>px">  
    <div id="progress" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center;   height: 16px"></div>              
    </div>  
    <div id="status"> </div>  
    <div id="percent" style="position: relative; top: -30px; text-align: center; font-weight: bold; font-size: 8pt">0%</div>  
</div>  
<?php
flush();
			$resource = "";
            if ($ssh) {
				$resource .= 'session/telnet';
				if($_POST['device_ip'])
				$whereIp = " AND addr IN('".implode("','", $_POST['device_ip'])."')";
				while(1){
					$sessions = $this->sessions_set->select_limit(0, 1000,$where.$whereIp);
					$rows = count($sessions);
					if(empty($rows)){
						break;
					}
					for($i=0; $i<$rows; $i++){
						$this->sessions_set->delete($sessions[$i]['sid']);
						$sessions[$i]['replayfile']=str_replace('"', '', $sessions[$i]['replayfile']);
						@unlink($sessions[$i]['replayfile']);
						@unlink($sessions[$i]['logfile']);
					}
					?>
<script language="JavaScript">  
    updateProgress("正在操作“<?php echo intval($progress); ?>” ....", <?php echo min($width, intval($progress)); ?>);  
</script>  
<?php  
   flush();    //将输出发送给客户端浏览器，使其可以立即执行服务器端输出的 JavaScript 程序。  
   $progress += $pix*$rows;      
?>
<?php
				}
                //$this->sessions_set->delete_all($where.$whereIp);
                $this->commands_set->delete_all(" sid NOT IN(SELECT sid FROM " . $this->sessions_set->get_table_name() . " )");
                
            }
            if ($rdp) {
				$resource .= ' rdp';
				if($_POST['device_ip'])
				$whereIp = " AND addr IN('".implode("','", $_POST['device_ip'])."')";
				while(1){
					$sessions = $this->rdp_set->select_limit(0, 1000,$where.$whereIp . " AND (login_template=8 or login_template=22)");
					$rows = count($sessions);
					if(empty($rows)){
						break;
					}
					for($i=0; $i<$rows; $i++){
						$this->rdp_set->delete($sessions[$i]['sid']);
						$sessions[$i]['replayfile']=str_replace('"', '', $sessions[$i]['replayfile']);
						@unlink($sessions[$i]['replayfile']);
						@unlink($sessions[$i]['keydir']);
					}
					?>
<script language="JavaScript">  
    updateProgress("正在操作“<?php echo intval($progress); ?>” ....", <?php echo min($width, intval($progress)); ?>);  
</script>  
<?php  
   flush();    //将输出发送给客户端浏览器，使其可以立即执行服务器端输出的 JavaScript 程序。  
   $progress += $pix*$rows; 
?>
<?php
				}
                //$this->rdp_set->delete_all($where.$whereIp . " AND (login_template=8 or login_template=22)");
            }
            if ($http) {
				$resource .= ' http';
				if($_POST['device_ip'])
				$whereIp = " AND addr IN('".implode("','", $_POST['device_ip'])."')";
				while(1){
					$sessions = $this->rdp_set->select_limit(0, 1000,$where.$whereIp . " AND login_template=14 ");
					$rows = count($sessions);
					if(empty($rows)){
						break;
					}
					for($i=0; $i<$rows; $i++){
						$this->rdp_set->delete($sessions[$i]['sid']);
						$sessions[$i]['replayfile']=str_replace('"', '', $sessions[$i]['replayfile']);
						@unlink($sessions[$i]['replayfile']);
						@unlink($sessions[$i]['keydir']);
					}
					?>
<script language="JavaScript">  
    updateProgress("正在操作“<?php echo intval($progress); ?>” ....", <?php echo min($width, intval($progress)); ?>);  
</script>  
<?php  
   flush();    //将输出发送给客户端浏览器，使其可以立即执行服务器端输出的 JavaScript 程序。  
   $progress += $pix*$rows;   
?>
<?php
				}
                //$this->rdp_set->delete_all($where.$whereIp . " AND login_template=14 ");
            }
            if ($ftp) {
				$resource .= ' ftp';
				if($_POST['device_ip'])
				$whereIp = " AND svraddr IN('".implode("','", $_POST['device_ip'])."')";
				while(1){
					$sessions = $this->ftpsession_set->select_limit(0, 1000,$where.$whereIp);
					$rows = count($sessions);
					if(empty($rows)){
						break;
					}
					for($i=0; $i<$rows; $i++){
						$this->ftpsession_set->delete($sessions[$i]['sid']);
						$sessions[$i]['replayfile']=str_replace('"', '', $sessions[$i]['replayfile']);
						@unlink($sessions[$i]['replayfile']);
					}
					?>
<script language="JavaScript">  
    updateProgress("正在操作'<?php echo intval($progress); ?>' ....", <?php echo min($width, intval($progress)); ?>);  
</script>  
<?php  
   flush();    //将输出发送给客户端浏览器，使其可以立即执行服务器端输出的 JavaScript 程序。  
   $progress += $pix*$rows;       
?>
<?php
				}
               // $this->ftpsession_set->delete_all($where.$whereIp);
                $this->ftpcmd_set->delete_all(" sid NOT IN(SELECT sid FROM " . $this->ftpsession_set->get_table_name() . " )");
                
            }
            if ($sftp) {
				$resource .= ' sftp';
				if($_POST['device_ip'])
				$whereIp = " AND svraddr IN('".implode("','", $_POST['device_ip'])."')";
				while(1){
					$sessions = $this->sftpsession_set->select_limit(0, 1000,$where.$whereIp);
					$rows = count($sessions);
					if(empty($rows)){
						break;
					}
					for($i=0; $i<$rows; $i++){
						$this->sftpsession_set->delete($sessions[$i]['sid']);
						$sessions[$i]['replayfile']=str_replace('"', '', $sessions[$i]['replayfile']);
						@unlink($sessions[$i]['replayfile']);
					}
					?>
<script language="JavaScript">  
    updateProgress("正在操作“<?php echo intval($progress); ?>” ....", <?php echo min($width, intval($progress)); ?>);  
</script>  
<?php  
   flush();    //将输出发送给客户端浏览器，使其可以立即执行服务器端输出的 JavaScript 程序。  
   $progress += $pix*$rows;   
?>
<?php
				}
                //$this->sftpsession_set->delete_all($where.$whereIp);
                $this->sftpcmd_set->delete_all(" sid NOT IN(SELECT sid FROM " . $this->sftpsession_set->get_table_name() . " )");
                
            }
            if ($as400) {
				$resource .= ' as400';
				if($_POST['device_ip'])
				$whereIp = " AND addr IN('".implode("','", $_POST['device_ip'])."')";
				while(1){
					$sessions = $this->AS400_sessions_set->select_limit(0, 1000,$where.$whereIp);
					$rows = count($sessions);
					if(empty($rows)){
						break;
					}
					for($i=0; $i<$rows; $i++){
						$this->AS400_sessions_set->delete($sessions[$i]['sid']);
						$sessions[$i]['replayfile']=str_replace('"', '', $sessions[$i]['replayfile']);
						@unlink($sessions[$i]['replayfile']);
						@unlink($sessions[$i]['keydir']);
					}
					?>
<script language="JavaScript">  
    updateProgress("正在操作“<?php echo intval($progress); ?>” ....", <?php echo min($width, intval($progress)); ?>);  
</script>  
<?php  
   flush();    //将输出发送给客户端浏览器，使其可以立即执行服务器端输出的 JavaScript 程序。  
   $progress += $pix*$rows;       
}   //end foreach  
//   最后将进度条设置成最大值 $width，同时显示操作完成  
?>
<?php
                //$this->AS400_sessions_set->delete_all($where.$whereIp);
                $this->AS400_commands_set->delete_all(" sid NOT IN(SELECT sid FROM " . $this->AS400_sessions_set->get_table_name() . " )");
            }
            if ($apppub) {
				$resource .= ' 应用';
				if($_POST['device_ip'])
				$whereIp = " AND serverip IN('".implode("','", $_POST['device_ip'])."')";
                $this->appcomm_set->delete_all(" sid NOT IN(SELECT sid FROM " . $this->sqlserver_set->get_table_name() . " )".$whereIp);
            }
            if ($vnc) {
				$resource .= ' vnc';
				if($_POST['device_ip'])
				$whereIp = " AND addr IN('".implode("','", $_POST['device_ip'])."')";
				while(1){
					$sessions = $this->rdp_set->select_limit(0, 1000,$where.$whereIp. " AND (login_template=21)");
					$rows = count($sessions);
					if(empty($rows)){
						break;
					}
					for($i=0; $i<$rows; $i++){
						$this->rdp_set->delete($sessions[$i]['sid']);
						$sessions[$i]['replayfile']=str_replace('"', '', $sessions[$i]['replayfile']);
						@unlink($sessions[$i]['replayfile']);
						@unlink($sessions[$i]['keydir']);
					}
					?>
<script language="JavaScript">  
    updateProgress("正在操作“<?php echo intval($progress); ?>” ....", <?php echo min($width, intval($progress)); ?>);  
</script>  
<?php  
   flush();    //将输出发送给客户端浏览器，使其可以立即执行服务器端输出的 JavaScript 程序。  
   $progress += $pix*$rows;
?>
<?php
				}
               // $this->rdp_set->delete_all($where.$whereIp . " AND (login_template=21)");
            }
            if ($loginacct) {
				$resource .= ' 登录统计';
				if($_POST['device_ip'])
				$whereIp = " AND serverip IN('".implode("','", $_POST['device_ip'])."')";
                $this->loginacct_set->delete_all($whereloginacct.$whereIp);
            }
			?>
<script language="JavaScript">  
    updateProgress("操作完成！", <?php echo $width; ?>);  
</script>  
<?php  
flush();  
?>  
<?php
			$adminlog = new admin_log();
			$adminlog->set_data('resource', $resource);
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('action', language('批量删除'));
			$adminlog->set_data('type', 15);
			$this->admin_log_set->add($adminlog);
            alert_and_back('删除成功');
        }

		$servers = $this->server_set->select_all('1', 'device_ip', 'asc');
		$allgroup = $this->sgroup_set->select_all('attribute!=1','groupname', 'asc');
		$this->assign("servers", $servers);
		$this->assign("allgroup", $allgroup);
        $this->display('batch_del.tpl');
    }
	
	function autodelete()
    {
        global $_CONFIG;
		$name = array(
				"audit_sec"=>"操作审计表",
				"log"=>"日志记录表",
				"dbaudit"=>"数据库审计表",
				"/opt/freesvr/audit/ftp-audit/backup/download"=>"FTP下载备份",
				"/opt/freesvr/audit/ftp-audit/backup/upload"=>"FTP上传备份",
				"/opt/freesvr/audit/gateway/log/db2"=>"DB2文件备份",
				"/opt/freesvr/audit/gateway/log/mysql"=>"MYSQL文件备份",
				"/opt/freesvr/audit/gateway/log/oracle"=>"ORACLE文件备份",
				"/opt/freesvr/audit/gateway/log/sybase"=>"Sybase文件备份",
				"/opt/freesvr/audit/gateway/log/sqlserver"=>"SQLServer文件备份",
				"/opt/freesvr/audit/gateway/log/telnet/cache"=>"TELNET文本记录",
				"/opt/freesvr/audit/gateway/log/telnet/replay"=>"TELNET录相",
				"/opt/freesvr/audit/gateway/log/ssh/cache"=>"SSH文本记录",
				"/opt/freesvr/audit/gateway/log/ssh/replay"=>"SSH录相",
				"/opt/freesvr/audit/gateway/log/rdp/replay"=>"图形录相",
				"/opt/freesvr/audit/gateway/log/rdp/key"=>"图形键盘记录"
		);
		$page_num = get_request('page');
        $where = "1=1";
        $row_num  = $this->autodelete_set->select_count($where);
        $newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
        $this->assign('page_list', $newpager->showSerialList());
        $this->assign('command_num', $row_num);
        $this->assign('curr_page', $newpager->intCurrentPageNumber);
        $this->assign('total_page', $newpager->intTotalPageCount);
        $this->assign('items_per_page', $newpager->intItemsPerPage);
        $autodelete = $this->autodelete_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, '', 'asc');
		for($i=0; $i<count($autodelete); $i++){
			$autodelete[$i]['zhname']=$name[$autodelete[$i]['name']];
		}
        $this->assign("name", $name);
        $this->assign('autodelete', $autodelete);
        $this->display('autodelete.tpl');
    }

	function autodelete_edit(){
		$id = get_request('id');
		$name = array(
				"audit_sec"=>"操作审计表",
				"log"=>"日志记录表",
				"dbaudit"=>"数据库审计表",
				"/opt/freesvr/audit/ftp-audit/backup/download"=>"FTP下载备份",
				"/opt/freesvr/audit/ftp-audit/backup/upload"=>"FTP上传备份",
				"/opt/freesvr/audit/gateway/log/db2"=>"DB2文件备份",
				"/opt/freesvr/audit/gateway/log/mysql"=>"MYSQL文件备份",
				"/opt/freesvr/audit/gateway/log/oracle"=>"ORACLE文件备份",
				"/opt/freesvr/audit/gateway/log/sybase"=>"Sybase文件备份",
				"/opt/freesvr/audit/gateway/log/sqlserver"=>"SQLServer文件备份",
				"/opt/freesvr/audit/gateway/log/telnet/cache"=>"TELNET文本记录",
				"/opt/freesvr/audit/gateway/log/telnet/replay"=>"TELNET录相",
				"/opt/freesvr/audit/gateway/log/ssh/cache"=>"SSH文本记录",
				"/opt/freesvr/audit/gateway/log/ssh/replay"=>"SSH录相",
				"/opt/freesvr/audit/gateway/log/rdp/replay"=>"图形录相",
				"/opt/freesvr/audit/gateway/log/rdp/key"=>"图形键盘记录"
		);
		$autodelete = $this->autodelete_set->select_by_id($id);
		$autodelete['zhname']=$name[$autodelete['name']];
		$this->assign("autodelete", $autodelete);
		$this->display('autodelete_edit.tpl');
	}

	function autodelete_save(){
		
		$id = get_request('id');
		$time = get_request('time',1,0);
		$autodelete = new autodelete();
		$autodelete->set_data('seq', $id);
		$autodelete->set_data('time', $time);
		$this->autodelete_set->edit($autodelete);
		 alert_and_back('操作成功' ,'admin.php?controller=admin_session&action=autodelete');
	}

	function showcommit(){
		$id = get_request('commit');
		$logininfo = $this->logincommit_set->select_by_id($id);
		$this->assign('logininfo', $logininfo);
		$this->display('sessioncommit.tpl');
	}

	function docommit(){
		$id = get_request('id', 1, 1);
		$prelogincommit = get_request('prelogincommit', 1, 1);
		$postloggincommit = get_request('postloggincommit', 1, 1);
		$logincommit = new logincommit();
		$logincommit->set_data('prelogincommit', $prelogincommit);
		$logincommit->set_data('postloggincommit', $postloggincommit);
		$logincommit->set_data('id', $id);
		$this->logincommit_set->edit($logincommit);
		$tem = $this->tem_set->select_by_id($dev['login_method']);
		echo '<script>alert(\'操作成功\');window.parent.closeWindow();</script>';
		exit;
	}
	
	function logincommit(){
		$commit = get_request('commit');
		if($commit){
			echo "<script>window.parent.loadurl('admin.php?controller=admin_session&action=showcommit&commit=".$commit."&type=".$type."&".time()."');</script>";
			exit;
		}
		alert_and_back('该会话没有登录说明' );
	}

	function showdesc(){
		$id = get_request('desc');
		$sessionid = get_request('sessionid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->sessions_set->select_by_id($sessionid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					echo('您没有权限查看');
					exit;
				}
			}
		}
		$type = get_request('type',0,1);
		$logininfo = $this->sessiondesc_set->select_by_id($id);
		$this->assign('logininfo', $logininfo);
		$this->assign('sessionid', $sessionid);
		$this->assign('type', $type);
		$this->display('sessiondesc.tpl');
	}

	function dodesc(){
		$id = get_request('id', 1, 1);
		$type = get_request('type',1,1);
		$sessionid = get_request('sessionid', 1, 1);
		$desc = get_request('desc', 1, 1);
		$sessiondesc = new sessiondesc();
		$sessiondesc->set_data('content', $desc);

		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->sessions_set->select_by_id($sessionid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_back('您没有权限查看');
					exit;
				}
			}
		}

		if($id){
			$sessiondesc->set_data('id', $id);
			$this->sessiondesc_set->edit($sessiondesc);
		}else{			
			$this->sessiondesc_set->add($sessiondesc);
			$newid = mysql_insert_id();
			switch($type){
				case 'ssh':
					$up_sql = "UPDATE ".$this->sessions_set->get_table_name()." SET `desc`='$newid' WHERE sid='$sessionid'";
				break;
				case 'sftp':
					$up_sql = "UPDATE ".$this->sftpsession_set->get_table_name()." SET `desc`='$newid' WHERE sid='$sessionid'";
				break;
				case 'ftp':
					$up_sql = "UPDATE ".$this->ftpsession_set->get_table_name()." SET `desc`='$newid' WHERE sid='$sessionid'";
				break;
				case 'as400':
					$up_sql = "UPDATE ".$this->AS400_sessions_set->get_table_name()." SET `desc`='$newid' WHERE sid='$sessionid'";
				break;
				case 'rdp':
					$up_sql = "UPDATE ".$this->rdp_set->get_table_name()." SET `desc`='$newid' WHERE sid='$sessionid'";
				break;
				case 'vnc':
					$up_sql = "UPDATE ".$this->rdp_set->get_table_name()." SET `desc`='$newid' WHERE sid='$sessionid'";
				break;
				case 'x11':
					$up_sql = "UPDATE ".$this->rdp_set->get_table_name()." SET `desc`='$newid' WHERE sid='$sessionid'";
				break;
				case 'scp':
					$up_sql = "UPDATE ".$this->scpsession_set->get_table_name()." SET `desc`='$newid' WHERE cid='$sessionid'";
				break;

			}
			$this->sessiondesc_set->query($up_sql);
		}
		echo '<script>alert(\'操作成功\');window.parent.closeWindow();window.parent.location.reload();</script>';
		exit;
	}
	
	function logindesc(){
		$desc = get_request('desc');
		$sessionid = get_request('sessionid');
		if($_SESSION['ADMIN_LEVEL']==0){
			if($row=$this->sessions_set->select_by_id($sessionid)){
				if($row['luser']!=$_SESSION['ADMIN_USERNAME']){
					alert_and_back('您没有权限查看');
					exit;
				}
			}
		}
		$type = get_request('type',0,1);
		echo "<script>window.parent.loadurl('admin.php?controller=admin_session&action=showdesc&desc=".$desc."&type=".$type."&sessionid=".$sessionid."&".time()."');</script>";
		exit;
	}

}
?>
