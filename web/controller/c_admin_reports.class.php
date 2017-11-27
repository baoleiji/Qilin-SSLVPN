<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_reports extends c_base {
	var $templates=array(
						array('name'=>'commandreport', 'title'=>'命令总计'),
						array('name'=>'appreport', 'title'=>'应用报表'),
						array('name'=>'sftpreport', 'title'=>'SFTP命令报表'),
						array('name'=>'ftpreport', 'title'=>'FTP命令报表'),
						array('name'=>'dangercmdreport', 'title'=>'违规报表'),
						array('name'=>'reportgraph', 'title'=>'图形输出'),
						array('name'=>'logintims', 'title'=>'登录统计'),
						array('name'=>'loginacct', 'title'=>'登录明细'),
						array('name'=>'loginfailed', 'title'=>'登录尝试')
					);
	function index($where = NULL) {
		$back = get_request('back');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = " WHERE 1=1 ";

		$timetype = get_request('timetype', 0, 1);		
		$types = get_request('types', 0, 1);
		

		switch($timetype){
			case "month":
				$selecttime = " DATE_FORMAT(`start`,\"%Y-%m\") AS startym ";
				$month = get_request('month',0,1);
				$where .= " AND DATE_FORMAT( `start`, \"%Y-%m\")='$month'";
				break;
			case "week":
				
				$week = get_request('week');
				if($week==1) {
					$selecttime = " '上一周'  AS startym ";
					$datestart = mktime(0,0,0,date('m'),date('d')-date('w')-7,date('Y'));
					$dateend = mktime(0,0,0,date('m'),date('d')-date('w'),date('Y'));
				}
				else if($week==2) {
					$selecttime = " '上二周'  AS startym ";
					$datestart = mktime(0,0,0,date('m'),date('d')-date('w')-14,date('Y'));
					$dateend = mktime(0,0,0,date('m'),date('d')-date('w'),date('Y'));
				}
				else if($week==3) {
					$selecttime = " '上三周'  AS startym ";
					$datestart = mktime(0,0,0,date('m'),date('d')-date('w')-21,date('Y'));
					$dateend = mktime(0,0,0,date('m'),date('d')-date('w'),date('Y'));
				}
				else if($week==4) {
					$selecttime = " '上四周'  AS startym ";
					$datestart = mktime(0,0,0,date('m'),date('d')-date('w')-28,date('Y'));
					$dateend = mktime(0,0,0,date('m'),date('d')-date('w'),date('Y'));
				}
				$where .= " AND UNIX_TIMESTAMP(`start`)>$datestart AND  UNIX_TIMESTAMP(`start`)<$dateend ";				
				break;
			case "day":
				$selecttime = " DATE_FORMAT(`start`,\"%Y-%m-%d\") AS startym ";
				$f_rangeStart = get_request('f_rangeStart', 0, 1);
				$where .= " AND DATE_FORMAT(`start`,\"%Y-%m-%d\")='$f_rangeStart' ";
				break;
			default:
				$selecttime = " DATE_FORMAT(`start`,\"%Y-%m-%d\") AS startym ";
				$where .= " AND DATE_FORMAT(`start`,\"%Y-%m-%d\")='".date('Y-m-d')."' ";
		}
		switch($types){
			case "logintype":
				$groupby = " GROUP BY type ";
				$groupbykey = 'type';
				break;
			default:
				$groupby = " GROUP BY user";
				$groupbykey = 'user';
		}
		$having = " HAVING loginnum > 0 ";
		
		$sql = "SELECT t.*,m.realname FROM ("
."SELECT IFNULL(s.type,'unknown') type,s.user,s.luser,COUNT(sid) AS loginnum,$selecttime,IFNULL(t.cmdnum,0) cmdnum FROM sessions s LEFT JOIN (SELECT COUNT(cid) AS cmdnum,sid csid FROM commands c GROUP BY sid) t ON s.sid=t.csid ".$where." GROUP BY $groupbykey "
." UNION SELECT 'sftp' type,s.sftp_user user,NULL,COUNT(sid) AS loginnum,$selecttime,IFNULL(t.cmdnum,0) cmdnum FROM  sftpsessions s LEFT JOIN (SELECT COUNT(cid) AS cmdnum,sid csid FROM sftpcomm c  GROUP BY sid) t ON s.sid=t.csid ".$where." GROUP BY $groupbykey "
." UNION SELECT 'oracle' type,s.user,NULL,COUNT(sid) AS loginnum,$selecttime,IFNULL(t.cmdnum,0) cmdnum FROM  oracle_sessions s LEFT JOIN (SELECT COUNT(cid) AS cmdnum,sid csid FROM oracle_commands c  GROUP BY sid) t ON s.sid=t.csid ".$where." GROUP BY $groupbykey "
." UNION SELECT 'db2' type,s.user,NULL,COUNT(sid) AS loginnum,$selecttime,IFNULL(t.cmdnum,0) cmdnum FROM  oracle_sessions s LEFT JOIN (SELECT COUNT(cid) AS cmdnum,sid csid FROM oracle_commands c  GROUP BY sid) t ON s.sid=t.csid ".$where." GROUP BY $groupbykey "
." UNION SELECT 'sybase' type,s.user,NULL,COUNT(sid) AS loginnum,$selecttime,IFNULL(t.cmdnum,0) cmdnum FROM  sybase_sessions s LEFT JOIN (SELECT COUNT(cid) AS cmdnum,sid csid FROM sybase_commands c  GROUP BY sid) t ON s.sid=t.csid ".$where." GROUP BY $groupbykey "
." UNION SELECT 'mysql' type,s.user,NULL,COUNT(sid) AS loginnum,$selecttime,IFNULL(t.cmdnum,0) cmdnum FROM  mysql_sessions s LEFT JOIN (SELECT COUNT(cid) AS cmdnum,sid csid FROM mysql_commands c  GROUP BY sid) t ON s.sid=t.csid ".$where." GROUP BY $groupbykey "
." UNION SELECT 'AS400' type,s.user,NULL,COUNT(sid) AS loginnum,$selecttime,IFNULL(t.cmdnum,0) cmdnum FROM  AS400_sessions s LEFT JOIN (SELECT COUNT(cid) AS cmdnum,sid csid FROM AS400_commands c  GROUP BY sid) t ON s.sid=t.csid ".$where." GROUP BY $groupbykey "

." UNION SELECT 'ftp' type,s.user,NULL,COUNT(sid) AS loginnum,$selecttime,IFNULL(t.cmdnum,0) cmdnum FROM  ftp_sessions s LEFT JOIN (SELECT COUNT(cid) AS cmdnum,sid csid FROM ftp_command c WHERE c.session_desc='cmd' GROUP BY sid) t ON s.sid=t.csid ".$where." GROUP BY $groupbykey "
." UNION SELECT 'rdp' type,s.user,NULL,COUNT(sid) AS loginnum,$selecttime,0 FROM  rdpsessions s ".$where." GROUP BY $groupbykey "
." UNION SELECT 'vnc' type,s.user,NULL,COUNT(sid) AS loginnum,$selecttime,0 FROM  vncsessions s ".$where." GROUP BY $groupbykey "
.") t LEFT JOIN member m ON t.luser=m.username $groupby $having ";
	

		if($delete) {
			
		}
		else if($derive) {		
			if($derive==1){	
				$this->derive($sql);
				exit;
			}else if($derive==2){
				$this->derivetoHTML($sql);
				return;
			}
		}
		else {		
			//$table_list = $this->get_table_list();

			$curr_url = $_SERVER['PHP_SELF'] . "?";
			if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
				$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
			}
			else {
				$curr_url .= $_SERVER['QUERY_STRING'];
			}
			//echo $curr_url;
			
			$row_num = $this->sessions_set->base_select("SELECT count(*) ct FROM ($sql) t");
			$row_num = $row_num[0]['ct'];
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('session_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			//$sql = "SELECT COUNT(sid) AS loginnum,DATE_FORMAT(`start`,\"%Y�?m�?d日\") AS startym,s.*,IFNULL(t.cmdnum,0) cmdnum FROM ".$this->sessions_set->get_table_name()." s LEFT JOIN (SELECT COUNT(cid) AS cmdnum,sid csid FROM commands c GROUP BY sid) t ON s.sid=t.csid ".$where.$groupby." LIMIT ".$newpager->intStartPosition.", ".$newpager->intItemsPerPage;
		    $sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
			$allsession = $this->sessions_set->base_select($sql);
			
			
			$this->assign('allsession', $allsession);
			if(!empty($allsession)){
			
				for($ii=0; $ii<count($allsession); $ii++){
					$datastr .= 'data[]='.$allsession[$ii]['loginnum'].'&';
					$infostr .= 'info[]='.($types=='logintype' ? $allsession[$ii]['type'] : $allsession[$ii]['user']).'&';
				}
				$infostr=str_replace('?',"__wenhao__",$infostr);
				$infostr=str_replace('#',"__jinhao__",$infostr);
				$this->assign('data', $datastr);
				$this->assign('info', $infostr);
			}
			//$this->assign('now_table_name', $table_name);
			//$this->assign('table_list', $table_list);
			$curr_url = $_SERVER['PHP_SELF'] . "?";
			if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
				$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
			}
			else {
				$curr_url .= $_SERVER['QUERY_STRING'];
			
			}
			parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			$this->display("reports_list.tpl");
		}
	}

	function deriveExcel($sql){//未完成
		$timetype = get_request('timetype', 0, 1);		
		$types = get_request('types', 0, 1);
		error_reporting(E_ALL);
		require_once ROOT.'/include/phpExcel/PHPExcel.php';
		$columns=array('A','B','C','D','E','F','G','H','I');
		$result = $this->sessions_set->base_select($sql);
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', "序号");
		$objPHPExcel->getActiveSheet()->setCellValue('B1', "用户名");
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "telnet/ssh");
		$objPHPExcel->getActiveSheet()->setCellValue('D1', "rdp");
		$objPHPExcel->getActiveSheet()->setCellValue('E1', "ftp");
		$objPHPExcel->getActiveSheet()->setCellValue('F1', "sftp");
		$objPHPExcel->getActiveSheet()->setCellValue('G1', "合计");
		$row=2;
		$datastr="";
		$infostr="";
		foreach($result as $info) {
			$col = 0;				
			$objPHPExcel->getActiveSheet()->setCellValue($columns[$col++]."$row", $row-1);
			foreach($info as $t) {
				$objPHPExcel->getActiveSheet()->setCellValue($columns[$col++]."$row", $t);					
			}
			$data[]=$result[$row-1]['loginnum'];
			$info[]=($types=='logintype' ? $result[$row-1]['type'] : $result[$row-1]['user']);
			$row++;
		}
		$infostr=str_replace('?',"__wenhao__",$infostr);
		$infostr=str_replace('#',"__jinhao__",$infostr);
		$_GET['data']=$data;
		$_GET['info']=$info;
		$_GET['filename']=ROOT.'/tmp/a.png';
		include(ROOT."/include/pChart/graphgenerate.php");
		
		
		
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
		$objDrawing->setName('Sample image');
		$objDrawing->setDescription('Sample image');
		$objDrawing->setImageResource(imagecreatefrompng($gdImage));
		$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG);
		$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
		$objDrawing->setHeight(36);

		$objPHPExcel->setActiveSheetIndex(0);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="loginreport.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory:: createWriter($objPHPExcel, 'Excel2007');
$objWriter->save( 'php://output');
	}
	
	function derive($sql){
		$allsession = $this->sessions_set->base_select($sql);
		$str = language("时间")."\t".language("登录次数")."\t".language("命令数量")."\t".language("会话类型")."\t".language("登录用户名")." \t". language("本地用户名")."\t\n";
			$id=1;
			if($allsession)
			foreach ($allsession AS $report){		
				
				$str .= $report['startym']."\t".$report['loginnum']."\t".$report['cmdnum']."\t".$report['type']."\t".$report['user']."\t".$report['luser'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=ReportList.csv"); 
			$str= mb_convert_encoding($str, "GBK", "UTF-8");
			echo $str;			
			exit;
	}
	function derivetoHTML($sql){
		$allsession = $this->sessions_set->base_select($sql);
		ob_start();
		$this->assign('allsession', $allsession);
		$this->display('reports_list_for_export.tpl');
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

	function derivetoDoc($sql){
		$allsession = $this->sessions_set->base_select($sql);
		ob_start();
		$this->assign('allsession', $allsession);
		$this->display('reports_list_for_export.tpl');
		$str = ob_get_clean();
		if($_GET['derive_forcron']){
			echo $str;
			return ;
		}
		Header('Cache-Control: private, must-revalidate, max-age=0');
		header("Content-type:application/vnd.ms-doc;");
		header("Content-Disposition: attachment;filename=auditreports.doc");
		echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
				xmlns:w=urn:schemas-microsoft-com:office:word 
				xmlns= target=_blank>";
		echo $str;
		echo "</html>"; 
		exit();
	}
	

	function logintims(){
		global $_CONFIG;
		$page_num = get_request('page');
		$derive = get_request('derive');
		$usergroup = get_request('usergroup', 0, 1);
		$f_rangeEnd = get_request('f_rangeEnd', 1, 1);
		$f_rangeStart = get_request('f_rangeStart', 1, 1);
		if(!$f_rangeStart){
			$f_rangeStart = get_request('f_rangeStart', 0, 1);
		}
		if(!$f_rangeEnd){
			$f_rangeEnd = get_request('f_rangeEnd', 0, 1);
		}
		if(!$f_rangeStart){
			$f_rangeStart = date('Y-m-d',mktime(0,0,0,date('m')-1,date('d'),date('Y')));
		}
		if(!$f_rangeEnd){
			$f_rangeEnd = date('Y-m-d',mktime(23,23,59,date('m'),date('d'),date('Y')));
		}
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		$alltmpip = array(0);
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			$alltmpip = array(0);
			if($_SESSION['ADMIN_MSERVERGROUP']){
				if($_CONFIG['DEPART_ADMIN']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
				}
			}
        }

		

		$cronreport_ugroupid = $_GET['cornreport_param']['ugroupid'];
		$cronreport_sgroupid = $_GET['cornreport_param']['sgroupid'];
		$cronreport_username = $_GET['cornreport_param']['username'];
		$cronreport_server = $_GET['cornreport_param']['server'];

		if(empty($cronreport_ugroupid)){
			if($cronreport_ldapid2_u){
				$cronreport_ugroupid = $cronreport_ldapid2_u;
			}else if($cronreport_ldapid1_u){
				$cronreport_ugroupid = $cronreport_ldapid1_u;
			}
		}
		if(empty($cronreport_sgroupid)){
			if($ldapid2){
				$cronreport_sgroupid = $cronreport_ldapid2;
			}else if($cronreport_ldapid1){
				$cronreport_sgroupid = $cronreport_ldapid1;
			}
		}
		$cronreport_alltmpusername = array(0);
		$cronreport_alltmpip = array(0);
		if(empty($cronreport_username)){
			$allusers = mysql_query("SELECT uid,username FROM member WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allusers)
			while($row = mysql_fetch_array($allusers)){
				$cronreport_alltmpusername[]=$row['uid'];
			}
		}
		if(empty($cronreport_server)){
			$allips = mysql_query("SELECT device_ip FROM servers WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allips)
			while($row = mysql_fetch_array($allips)){
				$cronreport_alltmpip[]=$row['device_ip'];
			}
		}
		$wherecron = '1';
		$wherecron .= (!empty($cronreport_username) ? ' AND member.username="'.$cronreport_username.'" ' : (!empty($cronreport_ugroupid) ? ' AND member.uid IN("'.implode('","', $cronreport_alltmpusername).'")' : '')).(!empty($cronreport_server) ? ' AND servers.device_ip="'.$cronreport_server.'" ' : (!empty($cronreport_sgroupid) ? ' AND servers.device_ip IN("'.implode('","', $cronreport_alltmpip).'")' : ''));

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
		}

		$this->assign('f_rangeStart', $f_rangeStart);
		$this->assign('f_rangeEnd', $f_rangeEnd);
		$sql = "select SQL_CALC_FOUND_ROWS IFNULL(m.username,'') username,IFNULL(m.realname,'') realname,ug.groupname,IFNULL(s.sct,0) sct,IFNULL(t.tct,0) tct, IFNULL(r.rct,0) rct,IFNULL(a.act,0) act, IFNULL(f.fct,0) fct, IFNULL(sf.sfct,0) sfct, IFNULL(web.webct,0) webct,IFNULL(v.vct,0) vct,IFNULL(x.xct,0) xct,(IFNULL(s.sct,0)+IFNULL(a.act,0)+IFNULL(t.tct,0)+IFNULL(r.rct,0)+IFNULL(f.fct,0)+IFNULL(sf.sfct,0)+IFNULL(web.webct,0)+IFNULL(v.vct,0)+IFNULL(x.xct,0)) as ct  from (select member.username,member.realname,member.groupid,servers.device_ip from member join servers WHERE $wherecron GROUP BY username) m left join (select count(*) sct,luser from sessions where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' AND type='ssh' ".($cronreport_alltmpip[1]? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')" : '')." AND ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? "LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : "luser IN('".implode("','", $alltmpuser)."')") : '1')." group by luser) s on m.username=s.luser left join (select count(*) tct,luser from sessions where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' AND type='telnet' ".($cronreport_alltmpip[1]? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')" : '')." AND ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? "LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : "luser IN('".implode("','", $alltmpuser)."')") : '1')." group by luser) t on m.username=t.luser left join (select count(*) rct,luser from rdpsessions where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' AND (LOGIN_TEMPLATE=8 ) ".($cronreport_alltmpip[1]? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')" : '')." AND ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? "LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : "luser IN('".implode("','", $alltmpuser)."')") : '1')." group by luser) r on m.username=r.luser left join (select count(*) act,luser from rdpsessions where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' AND (LOGIN_TEMPLATE=26) ".($cronreport_alltmpip[1]? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')" : '')." AND ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? "LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : "luser IN('".implode("','", $alltmpuser)."')") : '1')." group by luser) a on m.username=a.luser left join (select count(*) vct,luser from rdpsessions where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' AND (LOGIN_TEMPLATE=21) ".($cronreport_alltmpip[1]? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')" : '')." AND ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? "LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : "luser IN('".implode("','", $alltmpuser)."')") : '1')." group by luser) v on m.username=v.luser left join (select count(*) xct,luser from rdpsessions where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' AND (LOGIN_TEMPLATE=22) ".($cronreport_alltmpip[1]? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')" : '')." AND ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? "LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : "luser IN('".implode("','", $alltmpuser)."')") : '1')." group by luser) x on m.username=x.luser left join (select count(*) fct,radius_user from ftpsessions where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' ".($cronreport_alltmpip[1]? " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $cronreport_alltmpip)."')" : '')." AND ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? "LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $alltmpip)."')" : "radius_user IN('".implode("','", $alltmpuser)."')") : '1')." group by radius_user) f on m.username=f.radius_user left join (select count(*) sfct,radius_user from sftpsessions where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' ".($cronreport_alltmpip[1]? " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $cronreport_alltmpip)."')" : '')." AND ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? "LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $alltmpip)."')" : "radius_user IN('".implode("','", $alltmpuser)."')") : '1')." group by radius_user) sf on m.username=sf.radius_user left join (select count(*) webct,audituser from loginacct where time >= '$f_rangeStart 00:00:00' AND time <= '$f_rangeEnd 23:59:59' and portocol='web' ".($cronreport_alltmpip[1]? " AND LEFT(serverip,IF(LOCATE(':',serverip)>0,LOCATE(':',serverip)-1,LENGTH(serverip))) IN ('".implode("','", $cronreport_alltmpip)."')" : '')." AND ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? "LEFT(serverip,IF(LOCATE(':',serverip)>0,LOCATE(':',serverip)-1,LENGTH(serverip))) IN ('".implode("','", $alltmpip)."')" : "audituser IN('".implode("','", $alltmpuser)."')") : '1')." group by audituser) web on m.username=web.audituser LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON m.groupid=ug.id WHERE ".($usergroup ? " ug.id='$usergroup' " : '1')." ".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : '')." ORDER BY ct DESC";			

		if($derive==1){
			//$result = $this->sessions_set->base_select($sql);
			//$handle = fopen(ROOT . 'tmp/loginreport.xls', 'w');

			$str = "日期:\t".$f_rangeStart."\t 到 \t".$f_rangeEnd."\n";
			$str .= language("序号")."\t".language("用户名")."\t".language("别名")."\t".language("运维组")."\t"."ssh\t"."telnet\t"."rdp\t"."应用\t"."ftp\t"."sftp\t"."前台\t"."VNC\t"."X11\t".language("合计")."\t\n";
			$row = 1;
			$i=0;
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
			}else{
				$f = @fopen('tmp/loginreport.xls', "wa+");
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}

			while(1){
				$str='';
				$result = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($result)) break;
				foreach($result as $info) {//var_dump($info);
					$col = 0;
					$str .= "$row\t";
					foreach($info as $t) {
						$str .= "$t\t";
						$col++;
					}
					$str .= "\n";
					$row++;
				}
				if($_GET['derive_forcron']){
					echo mb_convert_encoding($str, "GBK", "UTF-8");
				}else{
					@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
				}
			}
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
				return ;
			}else{
				fclose($f);
				go_url('tmp/loginreport.xls?'.time());
			}
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=loginreport.xls"); 
			$str= mb_convert_encoding($str, "GBK", "UTF-8");
			echo $str;
			*/
			exit();
		}else if($derive==4){
			$result = $this->sessions_set->base_select($sql);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','用户名'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','ssh'), iconv('UTF-8','GBK','telnet'), iconv('UTF-8','GBK','rdp'), iconv('UTF-8','GBK','应用'), iconv('UTF-8','GBK','ftp'), iconv('UTF-8','GBK','sftp'), iconv('UTF-8','GBK','前台'), iconv('UTF-8','GBK','VNC'), iconv('UTF-8','GBK','X11'), iconv('UTF-8','GBK','合计'));
			$w = array(12, 15, 15, 15, 15, 15, 15, 15, 13, 13, 15, 15, 13, 13);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			foreach ($result AS $report){//var_dump($report);
				$pdf->Row(array(++$id, iconv('UTF-8','GBK',$report['username']), iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['sct']), iconv('UTF-8','GBK',$report['tct']), iconv('UTF-8','GBK',$report['rct']), iconv('UTF-8','GBK',$report['act']), iconv('UTF-8','GBK',$report['fct']), iconv('UTF-8','GBK',$report['sfct']), iconv('UTF-8','GBK',$report['webct']), iconv('UTF-8','GBK',$report['vct']), iconv('UTF-8','GBK',$report['xct']), iconv('UTF-8','GBK',$report['ct'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			
			if($_GET['derive_forcron']){
				echo $pdf->Output();
				return ;
			}
			$pdf->Output();
			exit;
		}elseif($derive==2){
			ob_start();
			$allsession = $this->sessions_set->base_select($sql);
			$this->assign('allsession', $allsession);
			$this->display("loginreports_list_for_export.tpl");
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
		}else if($derive==3){//word
			$allsession = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('allsession', $allsession);
			$this->display('loginreports_list_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=auditreports.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();
		//$row_num = $this->member_set->select_count();
		if($page_num==1||empty($page_num)){
			$row_num=10000000;
		}elseif($_SESSION['app_priority_search_num']){
			$row_num = $_SESSION['app_priority_search_num'];
		}
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$allsession = $this->sessions_set->base_select($sql);
		$_rows = $this->server_set->base_select("SELECT FOUND_ROWS() row_num");
		$_SESSION['app_priority_search_num']=$row_num = $_rows[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('allsession', $allsession);
		$usergroup = $this->usergroup_set->select_all('level=0 and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');		
		$this->assign('usergroup', $usergroup);
		$this->assign('allgroup', $usergroup);
		
		$this->assign('session_num', $row_num);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
loading_end();
		$this->display("loginreports_list.tpl");
	}

	function derive_logintimes_tohtml($sql){
		
	}
	
	function derive2($sql){
		
	
	}

	function dangercmdreport(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$usergroup = get_request('usergroup', 0, 1);
		if(empty($start)&&empty($end)){
			$start = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$end = date('Y-m-d');
		}
		if(empty($orderby1)){
			$orderby1 = 'ct';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($start){
			$where .= " AND a.start >='".$start." 00:00:00'";
		}
		if($end){
			$where .= " AND a.start <='".$end." 23:59:59'";
		}
		if($usergroup){
			$where .=" AND ug.`id`='$usergroup'";
		}

		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')";
				
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND luser IN ('".implode("','", $alltmpuser)."')";
				}
			if($_SESSION['ADMIN_MUSERGROUP']){
					$where .= " AND 0";
				}
		}
		$cronreport_ugroupid = $_GET['cornreport_param']['ugroupid'];
		$cronreport_sgroupid = $_GET['cornreport_param']['sgroupid'];
		$cronreport_username = $_GET['cornreport_param']['username'];
		$cronreport_server = $_GET['cornreport_param']['server'];

		if(empty($cronreport_ugroupid)){
			if($cronreport_ldapid2_u){
				$cronreport_ugroupid = $cronreport_ldapid2_u;
			}else if($cronreport_ldapid1_u){
				$cronreport_ugroupid = $cronreport_ldapid1_u;
			}
		}
		if(empty($cronreport_sgroupid)){
			if($ldapid2){
				$cronreport_sgroupid = $cronreport_ldapid2;
			}else if($cronreport_ldapid1){
				$cronreport_sgroupid = $cronreport_ldapid1;
			}
		}
		
		$cronreport_alltmpusername = array(0);
		$cronreport_alltmpip = array(0);
		if(empty($cronreport_username)){
			$allusers = mysql_query("SELECT uid,username FROM member WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allusers)
			while($row = mysql_fetch_array($allusers)){
				$cronreport_alltmpusername[]=$row['uid'];
			}
		}
		if(empty($cronreport_server)){
			$allips = mysql_query("SELECT device_ip FROM servers WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allips)
			while($row = mysql_fetch_array($allips)){
				$cronreport_alltmpip[]=$row['device_ip'];
			}
		}
		$where .= (!empty($cronreport_username) ? ' AND m.username="'.$cronreport_username.'" ' : (!empty($cronreport_ugroupid) ? ' AND m.uid IN("'.implode('","', $cronreport_alltmpusername).'")' : '')).(!empty($cronreport_server) ? ' AND a.addr="'.$cronreport_server.'" ' : (!empty($cronreport_sgroupid) ? ' AND a.addr IN("'.implode('","', $cronreport_alltmpip).'")' : ''));

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')";
		}

		
		$sql = "SELECT a.*,m.realname, a.addr device_ip, MIN(start) mstart, MAX(start) mend,SUM(bb.ct) ct,bb.cmd,ug.groupname FROM ".$this->sessions_set->get_table_name()." a LEFT JOIN (SELECT COUNT(*) ct,sid,cmd FROM ".$this->commands_set->get_table_name()." WHERE dangerlevel > 0 GROUP BY sid,cmd) bb ON bb.sid=a.sid LEFT JOIN member m ON a.luser=m.username LEFT JOIN servergroup ug ON ug.id=m.groupid WHERE $where AND ct > 0  GROUP BY addr,user,luser,cmd ORDER BY $orderby1 $orderby2 ";	
					
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			//$reports = $this->sessions_set->base_select($sql);
			$str = "日期:\t".$start."\t 到 \t".$end."\n";
			$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("系统用户")."\t".language("服务器IP")."\t".language("违规命令")." \t".language("命令次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
			$id=1;
			$i=0;
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
			}else{
				$f = @fopen('tmp/DangerCmdReport.xls', "wa+");
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;
				foreach ($reports AS $report){		
					$str .= ($id++)."\t".$report['user']."\t".$report['realname']."\t".$report['groupname']."\t".$report['luser']."\t".$report['device_ip']."\t".$report['cmd']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
					$str .= "\n";
				}
				if($_GET['derive_forcron']){
					echo mb_convert_encoding($str, "GBK", "UTF-8");
				}else{
					@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
				}
			}
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
				return ;
			}else{
				fclose($f);
				go_url('tmp/DangerCmdReport.xls?'.time());
			}
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AuditReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==4){
			$reports = $this->sessions_set->base_select($sql);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'),  iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','违规命令'), iconv('UTF-8','GBK','命令次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
			$w = array(20, 20, 20, 20, 20, 20, 20, 20, 20, 20);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, $report['user'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['luser']), iconv('UTF-8','GBK',$report['device_ip']), iconv('UTF-8','GBK',$report['cmd']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->Output();
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('dangercmdreport_for_export.tpl');
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
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('dangercmdreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=auditreports.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();
		$sqlt = "SELECT COUNT(*) ct FROM (SELECT a.*,a.addr device_ip, MIN(start) mstart, MAX(start) mend,SUM(bb.ct) ct,bb.cmd FROM ".$this->sessions_set->get_table_name()." a LEFT JOIN (SELECT COUNT(*) ct,sid,cmd FROM ".$this->commands_set->get_table_name()." WHERE dangerlevel > 0 GROUP BY sid,cmd) bb ON bb.sid=a.sid LEFT JOIN member m ON a.luser=m.username LEFT JOIN servergroup ug ON ug.id=m.groupid  WHERE $where AND ct > 0 GROUP BY addr,user,luser,cmd) t ";		
		$row_num = $this->sessions_set->base_select($sqlt);	
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$reports = $this->sessions_set->base_select($sql);
		$usergroup = $this->usergroup_set->select_all('level=0 and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');		
		$this->assign('usergroup', $usergroup);
		$this->assign('allgroup', $usergroup);
		
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
		$this->assign('session_num', $row_num);
		$this->assign('reports', $reports);
		$this->assign('number', $number);
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
loading_end();
		$this->display('dangercmdreport.tpl');
	}	

	function dangercmdlistreport(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$usergroup = get_request('usergroup', 0, 1);
		if(empty($start)&&empty($end)){
			$start = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$end = date('Y-m-d');
		}
		if(empty($orderby1)){
			$orderby1 = 'at';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($start){
			$where .= " AND at >='".$start." 00:00:00'";
		}
		if($end){
			$where .= " AND at <='".$end." 23:59:59'";
		}
		if($usergroup){
			$where .=" AND ug.`id`='$usergroup'";
		}
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')";
				
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE  groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND bb.luser IN ('".implode("','", $alltmpuser)."')";
				}
			if($_SESSION['ADMIN_MUSERGROUP']){
					$where .= " AND 0";
				}
		}
		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')";
		}
		
		$sql = "SELECT a.*,bb.type,bb.luser,bb.user,bb.addr device_ip,m.realname,ug.groupname FROM ".$this->commands_set->get_table_name()." a LEFT JOIN ".$this->sessions_set->get_table_name()." bb  ON bb.sid=a.sid LEFT JOIN member m ON bb.luser=m.username LEFT JOIN servergroup ug ON ug.id=m.groupid WHERE $where AND dangerlevel > 0 ORDER BY $orderby1 $orderby2 ";	
					
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			$reports = $this->sessions_set->base_select($sql);
			$str = "日期:\t".$start."\t 到 \t".$end."\n";
			$str .=  language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("服务器IP")."\t".language("登录协议")."\t".language("系统用户")." \t".language("违规命令")." \t".language("违规级别")." \t".language("操作时间")."\n";
			$id=1;
			$i=0;
			$f = @fopen('tmp/AppLoginReport.xls', "wa+");
			@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;
				foreach ($reports AS $report){		
					
					$str .= ($id++)."\t".$report['luser']."\t".$report['realname']."\t".$report['groupname']."\t".$report['device_ip']."\t".$report['type']."\t".$report['user']."\t".$report['cmd']."\t".($report['dangerlevel']==1 ? '命令阻断' : ($report['dangerlevel']==2 ? '断开连接' : '命令告警' ))."\t".$report['at'];
					$str .= "\n";
				}
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}
			fclose($f);
			go_url('tmp/AppLoginReport.xls?'.time());
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=DangerCmdListReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==4){
			$reports = $this->sessions_set->base_select($sql);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','登录协议'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','违规命令'), iconv('UTF-8','GBK','违规级别'), iconv('UTF-8','GBK','操作时间'));
			$w = array(20, 20, 20, 20, 20, 20, 20, 20, 20, 20);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, $report['luser'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['device_ip']), iconv('UTF-8','GBK',$report['type']), iconv('UTF-8','GBK',$report['user']), iconv('UTF-8','GBK',$report['cmd']), iconv('UTF-8','GBK',($report['dangerlevel']==1 ? '命令阻断' : ($report['dangerlevel']==2 ? '断开连接' : '命令告警' ))), iconv('UTF-8','GBK',$report['at'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('dangercmdlistreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=DangerCmdListReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('dangercmdlistreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=DangerCmdListReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();
		$sqlt = "SELECT COUNT(*) ct FROM ".$this->commands_set->get_table_name()." a left join ".$this->sessions_set->get_table_name()." b ON a.sid=b.sid LEFT JOIN member m ON b.luser=m.username LEFT JOIN servergroup ug ON ug.id=m.groupid WHERE a.sid is not null and $where AND dangerlevel > 0 ";		
		$row_num = $this->sessions_set->base_select($sqlt);	
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');

		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$reports = $this->sessions_set->base_select($sql);
		$usergroup = $this->usergroup_set->select_all('level=0 and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
		$this->assign('usergroup', $usergroup);
		$this->assign('allgroup', $usergroup);
		
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
		$this->assign('session_num', $row_num);
		$this->assign('reports', $reports);
		$this->assign('number', $number);
loading_end();
		
		$this->display('dangercmdlistreport.tpl');
	}	
	
	function commandreport(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$usergroup = get_request('usergroup', 0, 1);
		if(empty($start)&&empty($end)){
			$start = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$end = date('Y-m-d');
		}
		if(empty($orderby1)){
			$orderby1 = 'ct';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($start){
			$where .= " AND start >='".$start." 00:00:00'";
		}
		if($end){
			$where .= " AND start <='".$end." 23:59:59'";
		}
		if($usergroup){
			$where .=" AND ug.`id`='$usergroup'";
		}
		$cronreport_ugroupid = $_GET['cornreport_param']['ugroupid'];
		$cronreport_sgroupid = $_GET['cornreport_param']['sgroupid'];
		$cronreport_username = $_GET['cornreport_param']['username'];
		$cronreport_server = $_GET['cornreport_param']['server'];

		if(empty($cronreport_ugroupid)){
			if($cronreport_ldapid2_u){
				$cronreport_ugroupid = $cronreport_ldapid2_u;
			}else if($cronreport_ldapid1_u){
				$cronreport_ugroupid = $cronreport_ldapid1_u;
			}
		}
		if(empty($cronreport_sgroupid)){
			if($ldapid2){
				$cronreport_sgroupid = $cronreport_ldapid2;
			}else if($cronreport_ldapid1){
				$cronreport_sgroupid = $cronreport_ldapid1;
			}
		}
		
		$cronreport_alltmpusername = array(0);
		$cronreport_alltmpip = array(0);
		if(empty($cronreport_username)){
			$allusers = mysql_query("SELECT uid,username FROM member WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allusers)
			while($row = mysql_fetch_array($allusers)){
				$cronreport_alltmpusername[]=$row['uid'];
			}
		}
		if(empty($cronreport_server)){
			$allips = mysql_query("SELECT device_ip FROM servers WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allips)
			while($row = mysql_fetch_array($allips)){
				$cronreport_alltmpip[]=$row['device_ip'];
			}
		}

		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
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
		$where .= (!empty($cronreport_username) ? ' AND m.username="'.$cronreport_username.'" ' : (!empty($cronreport_ugroupid) ? ' AND m.uid IN("'.implode('","', $cronreport_alltmpusername).'")' : '')).(!empty($cronreport_server) ? ' AND a.addr="'.$cronreport_server.'" ' : (!empty($cronreport_sgroupid) ? ' AND a.addr IN("'.implode('","', $cronreport_alltmpip).'")' : ''));

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')";
		}
		
		$sql = "SELECT a.*,a.addr device_ip, MIN(start) mstart, MAX(start) mend,sum(a.total_cmd) ct,m.realname,ug.groupname FROM ".$this->sessions_set->get_table_name()." a LEFT JOIN member m ON a.luser=m.username LEFT JOIN servergroup ug ON m.groupid=ug.id WHERE $where  GROUP BY addr,user,luser ORDER BY $orderby1 $orderby2 ";	
		
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			//$reports = $this->sessions_set->base_select($sql);
			$str = "日期:\t".$start."\t 到 \t".$end."\n";
			$str .= language("序号")."\t".language("堡垒机用户")."\t".language("别名")."\t".language("运维组")."\t".language("系统用户")."\t".language("登录主机")." \t".language("命令次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
			$id=1;
			$i=0;
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
			}else{
				$f = @fopen('tmp/CommandReport.xls', "wa+");
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;
				foreach ($reports AS $report){		
					$str .= ($id++)."\t".$report['user']."\t".$report['luser']."\t".$report['realname']."\t".$report['groupname']."\t".$report['device_ip']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
					$str .= "\n";
				}
				if($_GET['derive_forcron']){
					echo mb_convert_encoding($str, "GBK", "UTF-8");
				}else{
					@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
				}
			}
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
				return ;
			}else{
				fclose($f);
			}
			go_url('tmp/CommandReport.xls?'.time());
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=CommandReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();

		
		}else if($derive==4){
			$reports = $this->sessions_set->base_select($sql);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','堡垒机用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','登录主机'), iconv('UTF-8','GBK','命令次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
			$w = array(20, 22, 22, 22, 22, 22, 22, 22, 22);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, $report['user'], iconv('UTF-8','GBK',$report['luser']), iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['device_ip']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->Output();
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('commandreport_for_export.tpl');
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
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('commandreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=auditreports.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();
		$sqlt = "SELECT COUNT(*) ct FROM (SELECT a.* FROM ".$this->sessions_set->get_table_name()." a LEFT JOIN member m ON a.luser=m.username LEFT JOIN servergroup ug ON m.groupid=ug.id WHERE $where  GROUP BY addr,user,luser ) t ";		
		$row_num = $this->sessions_set->base_select($sqlt);	
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$reports = $this->sessions_set->base_select($sql);
		$usergroup = $this->usergroup_set->select_all('level=0  and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
		$this->assign('usergroup', $usergroup);
		$this->assign('allgroup', $usergroup);
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
		$this->assign('reports', $reports);
		$this->assign('session_num', $row_num);
		$this->assign('number', $number);
loading_end();
		
		$this->display('commandreport.tpl');
	}

	function appreport(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$usergroup = get_request('usergroup', 0, 1);
		if(empty($start)&&empty($end)){
			$start = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$end = date('Y-m-d');
		}
		if(empty($orderby1)){
			$orderby1 = 'ct';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($start){
			$where .= " AND start >='".$start." 00:00:00'";
		}
		if($end){
			$where .= " AND start <='".$end." 23:59:59'";
		}
		if($usergroup){
			$where .=" AND ug.`id`='$usergroup'";
		}

		$cronreport_ugroupid = $_GET['cornreport_param']['ugroupid'];
		$cronreport_sgroupid = $_GET['cornreport_param']['sgroupid'];
		$cronreport_username = $_GET['cornreport_param']['username'];
		$cronreport_server = $_GET['cornreport_param']['server'];
		if(empty($cronreport_ugroupid)){
			if($cronreport_ldapid2_u){
				$cronreport_ugroupid = $cronreport_ldapid2_u;
			}else if($cronreport_ldapid1_u){
				$cronreport_ugroupid = $cronreport_ldapid1_u;
			}
		}
		if(empty($cronreport_sgroupid)){
			if($ldapid2){
				$cronreport_sgroupid = $cronreport_ldapid2;
			}else if($cronreport_ldapid1){
				$cronreport_sgroupid = $cronreport_ldapid1;
			}
		}
		
		$cronreport_alltmpusername = array(0);
		$cronreport_alltmpip = array(0);
		if(empty($cronreport_username)){
			$allusers = mysql_query("SELECT uid,username FROM member WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allusers)
			while($row = mysql_fetch_array($allusers)){
				$cronreport_alltmpusername[]=$row['uid'];
			}
		}
		if(empty($cronreport_server)){
			$allips = mysql_query("SELECT device_ip FROM servers WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allips)
			while($row = mysql_fetch_array($allips)){
				$cronreport_alltmpip[]=$row['device_ip'];
			}
		}
		$where .= (!empty($cronreport_username) ? ' AND b.username="'.$cronreport_username.'" ' : (!empty($cronreport_ugroupid) ? ' AND b.uid IN("'.implode('","', $cronreport_alltmpusername).'")' : '')).(!empty($cronreport_server) ? ' AND a.serverip="'.$cronreport_server.'" ' : (!empty($cronreport_sgroupid) ? ' AND a.serverip IN("'.implode('","', $cronreport_alltmpip).'")' : ''));

		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				$where .= " AND LEFT(serverip,IF(LOCATE(':',serverip)>0,LOCATE(':',serverip)-1,LENGTH(serverip))) IN ('".implode("','", $alltmpip)."')";
				
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND luser IN ('".implode("','", $alltmpuser)."')";
				}
			if($_SESSION['ADMIN_MUSERGROUP']==0){
					$where .= " AND 0 ";
				}
		}

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')";
		}

		$sql = "SELECT COUNT(*) ct FROM (SELECT a.* FROM ".$this->appcomm_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." b ON a.memberid=b.uid LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON b.groupid=ug.id  WHERE $where  GROUP BY serverip,appname,memberid) t ";		
		$row_num = $this->appcomm_set->base_select($sql);	
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql = "SELECT a.*,addr device_ip,count(*) ct, MIN(start) mstart, MAX(start) mend,b.username user,b.realname,ug.groupname FROM ".$this->appcomm_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." b ON a.memberid=b.uid LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON b.groupid=ug.id WHERE $where GROUP BY serverip,appname,memberid ORDER BY $orderby1 $orderby2 ";	
		$reports = $this->appcomm_set->base_select($sql);			
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			//$reports = $this->appcomm_set->base_select($sql);			
			$str = "日期:\t".$start."\t 到 \t".$end."\n";
			$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("系统用户")."\t".language("应用名称")." \t".language("命令次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
			$id=1;
			$i=0;
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
			}else{
				$f = @fopen('tmp/AppReport.xls', "wa+");
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;
				foreach ($reports AS $report){		
					$str .= ($id++)."\t".$report['user']."\t".$report['realname']."\t".$report['groupname']."\t".$report['luser']."\t".$report['appname']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
					$str .= "\n";
				}
				if($_GET['derive_forcron']){
					echo mb_convert_encoding($str, "GBK", "UTF-8");
				}else{
					@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
				}
			}
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
				return ;
			}else{
				fclose($f);
				go_url('tmp/AppReport.xls?'.time());
			}
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AuditReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==4){
			$reports = $this->appcomm_set->base_select($sql);	
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','应用名称'), iconv('UTF-8','GBK','命令次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
			$w = array(20, 22, 22, 22, 22, 22, 22, 22, 22);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, $report['user'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['luser']), iconv('UTF-8','GBK',$report['appname']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->Output();
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->appcomm_set->base_select($sql);			
			ob_start();
			$this->assign('reports', $reports);
			$this->display('appreport_for_export.tpl');
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
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('appreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=auditreports.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$reports = $this->appcomm_set->base_select($sql);		
		$usergroup = $this->usergroup_set->select_all('level=0  and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
		$this->assign('usergroup', $usergroup);
		$this->assign('allgroup', $usergroup);
		
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
		$this->assign('reports', $reports);
		$this->assign('session_num', $row_num);
		$this->assign('number', $number);
		
		$this->display('appreport.tpl');
	}

	function sftpreport(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$usergroup = get_request('usergroup', 0, 1);
		if(empty($start)&&empty($end)){
			$start = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$end = date('Y-m-d');
		}
		if(empty($orderby1)){
			$orderby1 = 'ct';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($start){
			$where .= " AND start >='".$start." 00:00:00'";
		}
		if($end){
			$where .= " AND start <='".$end." 23:59:59'";
		}
		if($usergroup){
			$where .=" AND ug.`id`='$usergroup'";
		}
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				$wheret .= " AND LEFT(a.svraddr,IF(LOCATE(':',a.svraddr)>0,LOCATE(':',a.svraddr)-1,LENGTH(a.svraddr))) IN ('".implode("','", $alltmpip)."')";
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$wheret .= " AND luser IN ('".implode("','", $alltmpuser)."')";
				}
			if($_SESSION['ADMIN_MUSERGROUP']==0){
				$wheret .= " AND 0";
			}
		}

		$cronreport_ugroupid = $_GET['cornreport_param']['ugroupid'];
		$cronreport_sgroupid = $_GET['cornreport_param']['sgroupid'];
		$cronreport_username = $_GET['cornreport_param']['username'];
		$cronreport_server = $_GET['cornreport_param']['server'];

		if(empty($cronreport_ugroupid)){
			if($cronreport_ldapid2_u){
				$cronreport_ugroupid = $cronreport_ldapid2_u;
			}else if($cronreport_ldapid1_u){
				$cronreport_ugroupid = $cronreport_ldapid1_u;
			}
		}
		if(empty($cronreport_sgroupid)){
			if($ldapid2){
				$cronreport_sgroupid = $cronreport_ldapid2;
			}else if($cronreport_ldapid1){
				$cronreport_sgroupid = $cronreport_ldapid1;
			}
		}
		
		$cronreport_alltmpusername = array(0);
		$cronreport_alltmpip = array(0);
		if(empty($cronreport_username)){
			$allusers = mysql_query("SELECT uid,username FROM member WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allusers)
			while($row = mysql_fetch_array($allusers)){
				$cronreport_alltmpusername[]=$row['uid'];
			}
		}
		if(empty($cronreport_server)){
			$allips = mysql_query("SELECT device_ip FROM servers WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allips)
			while($row = mysql_fetch_array($allips)){
				$cronreport_alltmpip[]=$row['device_ip'];
			}
		}
		$where .= (!empty($cronreport_username) ? ' AND m.username="'.$cronreport_username.'" ' : (!empty($cronreport_ugroupid) ? ' AND m.uid IN("'.implode('","', $cronreport_alltmpusername).'")' : ''));
		$wheret .= (!empty($cronreport_server) ? ' AND a.svraddr="'.$cronreport_server.'" ' : (!empty($cronreport_sgroupid) ? ' AND a.svraddr IN("'.implode('","', $cronreport_alltmpip).'")' : ''));

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
			$wheret .= " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $cronreport_alltmpip)."')";
		}

		
		$sql = "SELECT *,MIN(start) mstart, MAX(start) mend,SUM(putct) putct,SUM(getct) getct,SUM(ct) ct,m.realname,ug.groupname FROM (SELECT a.svraddr device_ip,a.sftp_user,a.radius_user,a.start,a.end, IF(b.ct,b.ct,0) putct,IF(c.ct,c.ct,0) getct,IF(bb.ct,bb.ct,0) ct FROM ".$this->sftpsession_set->get_table_name()." a LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->sftpcmd_set->get_table_name()." WHERE LEFT(comm,3)='put' GROUP BY sid) b ON b.sid=a.sid LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->sftpcmd_set->get_table_name()." WHERE LEFT(comm,3)='get' GROUP BY sid) c ON c.sid=a.sid LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->sftpcmd_set->get_table_name()." WHERE 1 GROUP BY sid) bb ON bb.sid=a.sid WHERE 1 $wheret GROUP BY a.sid, radius_user,sftp_user ) t LEFT JOIN member m ON t.radius_user=m.username LEFT JOIN servergroup ug ON ug.id=m.groupid WHERE $where GROUP BY radius_user,sftp_user ORDER BY $orderby1 $orderby2";	
		$reports = $this->appcomm_set->base_select($sql);			
		
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			//$reports = $this->appcomm_set->base_select($sql);			
			$str = "日期:\t".$start."\t 到 \t".$end."\n";
			$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("系统用户")."\t".language("上载次数")."\t".language("下载次数")." \t".language("命令次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
			$id=1;
			$i=0;
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
			}else{
				$f = @fopen('tmp/SftpReport.xls', "wa+");
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;
				foreach ($reports AS $report){		
					$str .= ($id++)."\t".$report['radius_user']."\t".$report['realname']."\t".$report['groupname']."\t".$report['sftp_user']."\t".$report['putct']."\t".$report['getct']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
					$str .= "\n";
				}
				if($_GET['derive_forcron']){
					echo mb_convert_encoding($str, "GBK", "UTF-8");
				}else{
					@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
				}
			}
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
				return ;
			}else{
				fclose($f);
				go_url('tmp/SftpReport.xls?'.time());
			}
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AuditReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==4){
			$reports = $this->appcomm_set->base_select($sql);	
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','上载次数'), iconv('UTF-8','GBK','下载次数'), iconv('UTF-8','GBK','命令次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
			$w = array(12, 20, 20, 20, 20, 20, 20, 20, 20, 20);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, $report['radius_user'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['sftp_user']), iconv('UTF-8','GBK',$report['putct']), iconv('UTF-8','GBK',$report['getct']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->Output();
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->appcomm_set->base_select($sql);			
			ob_start();
			$this->assign('reports', $reports);
			$this->display('sftpreport_for_export.tpl');
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
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('sftpreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=auditreports.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();
		$sqlt = "SELECT COUNT(*) ct FROM (SELECT * FROM ".$this->sftpsession_set->get_table_name()." a WHERE 1 AND $where $wheret  GROUP BY radius_user,sftp_user) t ";		
		$row_num = $this->sftpsession_set->base_select($sqlt);	
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql .= "  LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$reports = $this->appcomm_set->base_select($sql);			
		$usergroup = $this->usergroup_set->select_all('level=0 and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
		$this->assign('usergroup', $usergroup);
		$this->assign('allgroup', $usergroup);
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
		$this->assign('session_num', $row_num);
		$this->assign('reports', $reports);
		$this->assign('number', $number);
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
loading_end();
		$this->display('sftpreport.tpl');
	}

	function ftpreport(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$usergroup = get_request('usergroup', 0, 1);
		if(empty($start)&&empty($end)){
			$start = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$end = date('Y-m-d');
		}
		if(empty($orderby1)){
			$orderby1 = 'ct';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($start){
			$where .= " AND start >='".$start." 00:00:00'";
		}
		if($end){
			$where .= " AND start <='".$end." 23:59:59'";
		}
		if($usergroup){
			$where .=" AND ug.`id`='$usergroup'";
		}
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
				for($i=0; $i<count($allips); $i++){
					$alltmpip[]=$allips[$i]['device_ip'];
				}
				$wheret .= " AND LEFT(a.svraddr,IF(LOCATE(':',a.svraddr)>0,LOCATE(':',a.svraddr)-1,LENGTH(a.svraddr))) IN ('".implode("','", $alltmpip)."')";
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$wheret .= " AND luser IN ('".implode("','", $alltmpuser)."')";
				}
			if($_SESSION['ADMIN_MUSERGROUP']==0){
				$wheret .= " AND 0";
			}
		}

		$cronreport_ugroupid = $_GET['cornreport_param']['ugroupid'];
		$cronreport_sgroupid = $_GET['cornreport_param']['sgroupid'];
		$cronreport_username = $_GET['cornreport_param']['username'];
		$cronreport_server = $_GET['cornreport_param']['server'];

		if(empty($cronreport_ugroupid)){
			if($cronreport_ldapid2_u){
				$cronreport_ugroupid = $cronreport_ldapid2_u;
			}else if($cronreport_ldapid1_u){
				$cronreport_ugroupid = $cronreport_ldapid1_u;
			}
		}
		if(empty($cronreport_sgroupid)){
			if($ldapid2){
				$cronreport_sgroupid = $cronreport_ldapid2;
			}else if($cronreport_ldapid1){
				$cronreport_sgroupid = $cronreport_ldapid1;
			}
		}
		
		$cronreport_alltmpusername = array(0);
		$cronreport_alltmpip = array(0);
		if(empty($cronreport_username)){
			$allusers = mysql_query("SELECT uid,username FROM member WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allusers)
			while($row = mysql_fetch_array($allusers)){
				$cronreport_alltmpusername[]=$row['uid'];
			}
		}
		if(empty($cronreport_server)){
			$allips = mysql_query("SELECT device_ip FROM servers WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allips)
			while($row = mysql_fetch_array($allips)){
				$cronreport_alltmpip[]=$row['device_ip'];
			}
		}
		$where .= (!empty($cronreport_username) ? ' AND m.username="'.$cronreport_username.'" ' : (!empty($cronreport_ugroupid) ? ' AND m.uid IN("'.implode('","', $cronreport_alltmpusername).'")' : ''));
		$wheret .= (!empty($cronreport_server) ? ' AND a.svraddr="'.$cronreport_server.'" ' : (!empty($cronreport_sgroupid) ? ' AND a.svraddr IN("'.implode('","', $cronreport_alltmpip).'")' : ''));

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
			$wheret .= " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $cronreport_alltmpip)."')";
		}
		
		$sql = "SELECT *,MIN(start) mstart, MAX(start) mend,SUM(putct) putct,SUM(getct) getct,SUM(ct) ct,m.realname,ug.groupname FROM (SELECT a.svraddr device_ip,a.ftp_user,a.radius_user,a.start,a.end, IF(b.ct,b.ct,0) putct,IF(c.ct,c.ct,0) getct,IF(bb.ct,bb.ct,0) ct FROM ".$this->ftpsession_set->get_table_name()." a LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->ftpcmd_set->get_table_name()." WHERE LEFT(comm,3)='put' GROUP BY sid) b ON b.sid=a.sid LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->ftpcmd_set->get_table_name()." WHERE LEFT(comm,3)='get' GROUP BY sid) c ON c.sid=a.sid LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->ftpcmd_set->get_table_name()." WHERE 1 GROUP BY sid) bb ON bb.sid=a.sid  WHERE 1 $wheret GROUP BY a.sid, radius_user,ftp_user) t LEFT JOIN member m ON t.radius_user=m.username LEFT JOIN servergroup ug ON ug.id=m.groupid WHERE $where GROUP BY radius_user,ftp_user ORDER BY $orderby1 $orderby2 ";	
		
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			//$reports = $this->appcomm_set->base_select($sql);			
			$str = "日期:\t".$start."\t 到 \t".$end."\n";
			$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("系统用户")."\t".language("上载次数")."\t".language("下载次数")." \t".language("命令次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
			$id=1;
			$i=0;
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
			}else{
				$f = @fopen('tmp/AppLoginReport.xls', "wa+");
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;
				foreach ($reports AS $report){		
					$str .= ($id++)."\t".$report['radius_user']."\t".$report['realname']."\t".$report['groupname']."\t".$report['ftp_user']."\t".$report['putct']."\t".$report['getct']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
					$str .= "\n";
				}
				if($_GET['derive_forcron']){
					echo mb_convert_encoding($str, "GBK", "UTF-8");
				}else{
					@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
				}
			}
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
				return ;
			}else{
				fclose($f);
				go_url('tmp/AppLoginReport.xls?'.time());
			}
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AuditReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==4){
			$reports = $this->appcomm_set->base_select($sql);	
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','上载次数'), iconv('UTF-8','GBK','下载次数'), iconv('UTF-8','GBK','命令次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
			$w = array(12, 20, 20, 20, 20, 20, 20, 20, 20, 20);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, $report['radius_user'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['ftp_user']), iconv('UTF-8','GBK',$report['putct']), iconv('UTF-8','GBK',$report['getct']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->Output();
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->appcomm_set->base_select($sql);			
			ob_start();
			$this->assign('reports', $reports);
			$this->display('ftpreport_for_export.tpl');
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
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('ftpreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=auditreports.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();
		$sqlt = "SELECT COUNT(*) ct FROM (SELECT a.* FROM ".$this->ftpsession_set->get_table_name()." a LEFT JOIN member m ON a.radius_user=m.username LEFT JOIN servergroup ug ON ug.id=m.groupid WHERE $where $wheret GROUP BY radius_user,ftp_user) t ";		
		$row_num = $this->ftpsession_set->base_select($sqlt);	
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');

		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$reports = $this->appcomm_set->base_select($sql);
		$usergroup = $this->usergroup_set->select_all('level=0 and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
		$this->assign('usergroup', $usergroup);
		$this->assign('allgroup', $usergroup);
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
		$this->assign('session_num', $row_num);
		$this->assign('reports', $reports);
		$this->assign('number', $number);
loading_end();
		
		$this->display('ftpreport.tpl');
	}
	
	function reportgraph() {
		$f_rangeStart = get_request('f_rangeStart', 0, 1);
		$f_rangeEnd = get_request('f_rangeEnd', 0, 1);
		$derive = get_request('derive', 0, 1);
		if(empty($f_rangeStart)&&empty($f_rangeEnd)){
			$f_rangeStart = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$f_rangeEnd = date('Y-m-d');
		}
		$f_rangeEnd = empty($f_rangeEnd) ? date('Y-m-d') : $f_rangeEnd;
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
				}
		}

		$sqltop10user = "select m.username,m.realname,(IFNULL(s.sct,0)+IFNULL(a.act,0)+IFNULL(t.tct,0)+IFNULL(r.rct,0)+IFNULL(f.fct,0)+IFNULL(sf.sfct,0)) as num  from member m 
					left join (select count(*) sct,luser from sessions where start >= '$f_rangeStart 00:00:00' AND start <= '$f_rangeEnd 23:59:59' AND type='ssh' ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ?  ($_CONFIG['DEPART_ADMIN'] ? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : " AND luser IN('".implode("','", $alltmpuser)."')") : '')." group by luser) s on m.username=s.luser 
					left join (select count(*) tct,luser from sessions where start >= '$f_rangeStart 00:00:00' AND start <= '$f_rangeEnd 23:59:59' AND type='telnet' ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : " AND luser IN('".implode("','", $alltmpuser)."')") : '')." group by luser) t on m.username=t.luser 
					left join (select count(*) rct,luser from rdpsessions where start >= '$f_rangeStart 00:00:00' AND start <= '$f_rangeEnd 23:59:59' AND (LOGIN_TEMPLATE=8 or LOGIN_TEMPLATE=22) ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : " AND luser IN('".implode("','", $alltmpuser)."')") : '')." group by luser) r on m.username=r.luser
					left join (select count(*) act,luser from rdpsessions where start >= '$f_rangeStart 00:00:00' AND start <= '$f_rangeEnd 23:59:59' AND (LOGIN_TEMPLATE=26) ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : " AND luser IN('".implode("','", $alltmpuser)."')") : '')." group by luser) a on m.username=a.luser 
					left join (select count(*) fct,radius_user from ftpsessions where start >= '$f_rangeStart 00:00:00' AND start <= '$f_rangeEnd 23:59:59' ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $alltmpip)."')" : " AND radius_user IN('".implode("','", $alltmpuser)."')") : '')." group by radius_user) f on m.username=f.radius_user
					left join (select count(*) sfct,radius_user from sftpsessions where start >= '$f_rangeStart 00:00:00' AND start <= '$f_rangeEnd 23:59:59' ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_CONFIG['DEPART_ADMIN'] ? " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $alltmpip)."')" : " AND radius_user IN('".implode("','", $alltmpuser)."')") : '')." group by radius_user) sf on m.username=sf.radius_user ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' WHERE 0' : " WHERE m.groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).")") : '')." ORDER BY num DESC LIMIT 10";

		$sqltop10protocol = "select count(*) num,'ssh' as protocol from sessions s left join member m on s.luser=m.username where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' AND type='ssh' ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? " AND m.groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).") AND ".($_CONFIG['DEPART_ADMIN'] ? "LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : "luser IN('".implode("','", $alltmpuser)."')") : '')." UNION select count(*) tct,'telnet' from sessions s left join member m on s.luser=m.username where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' AND type='telnet' ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : " AND m.groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).")")." AND ".($_CONFIG['DEPART_ADMIN'] ? "LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : "luser IN('".implode("','", $alltmpuser)."')") : '')." UNION select count(*) rct,'rdp' from rdpsessions s left join member m on s.luser=m.username where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' AND (LOGIN_TEMPLATE=8 or LOGIN_TEMPLATE=22) ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : " AND m.groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).")")." AND ".($_CONFIG['DEPART_ADMIN'] ? "LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : "luser IN('".implode("','", $alltmpuser)."')") : '')." UNION select count(*) act,'app' from rdpsessions s left join member m on s.luser=m.username where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' AND (LOGIN_TEMPLATE=26) ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : " AND m.groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).")")." AND ".($_CONFIG['DEPART_ADMIN'] ? "LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : "luser IN('".implode("','", $alltmpuser)."')") : '')." UNION select count(*) fct,'ftp' from ftpsessions s left join member m on s.radius_user=m.username where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : " AND m.groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).")")." AND ".($_CONFIG['DEPART_ADMIN'] ? "LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $alltmpip)."')" : "radius_user IN('".implode("','", $alltmpuser)."')") : '')." UNION select count(*) sfct,'sftp' from sftpsessions s left join member m on s.radius_user=m.username where start >= '$f_rangeStart 00:00:00' AND end <= '$f_rangeEnd 23:59:59' ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : " AND m.groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).")")." AND ".($_CONFIG['DEPART_ADMIN'] ? "LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $alltmpip)."')" : "radius_user IN('".implode("','", $alltmpuser)."')") : '')."";
	
		$sqltop10srcip = "SELECT count(*) num,l.sourceip FROM ".$this->loginacct_set->get_table_name()." l left join member m on l.audituser=m.username  WHERE time >= '$f_rangeStart 00:00:00' AND time <= '$f_rangeEnd 23:59:59' ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : " AND m.groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).")")."  AND " .($_CONFIG['DEPART_ADMIN'] ? "LEFT(serverip,IF(LOCATE(':',serverip)>0,LOCATE(':',serverip)-1,LENGTH(serverip))) IN ('".implode("','", $alltmpip)."')" : "audituser IN('".implode("','", $alltmpuser)."')") : '')." GROUP BY l.sourceip ORDER BY num desc LIMIT 10";

		$sqltop10dstip = "SELECT count(*) num,l.serverip FROM ".$this->loginacct_set->get_table_name()." l left join member m on l.audituser=m.username WHERE time >= '$f_rangeStart 00:00:00' AND time <= '$f_rangeEnd 23:59:59' ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : " AND m.groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).")")." AND " .($_CONFIG['DEPART_ADMIN'] ? "LEFT(serverip,IF(LOCATE(':',serverip)>0,LOCATE(':',serverip)-1,LENGTH(serverip))) IN ('".implode("','", $alltmpip)."')" : "audituser IN('".implode("','", $alltmpuser)."')") : '')." GROUP BY l.serverip ORDER BY num desc LIMIT 10";
		
		
		$datetime = explode(" ", $f_rangeEnd);
		$endymd = explode("-", $datetime[0]);
		
		$f_rangeStart = date('Y-m-d', mktime(0,0,0,$endymd[1],$endymd[2]-10,$endymd[0]));
		$sqllast10user = "SELECT count(*) num,audituser,m.realname FROM ".$this->loginacct_set->get_table_name()." l LEFT JOIN member m ON l.audituser=m.username WHERE time >= '$f_rangeStart 00:00:00' AND time <= '$f_rangeEnd 23:59:59' ".(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : " AND m.groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).")")." AND " .($_CONFIG['DEPART_ADMIN'] ? "LEFT(serverip,IF(LOCATE(':',serverip)>0,LOCATE(':',serverip)-1,LENGTH(serverip))) IN ('".implode("','", $alltmpip)."')" : "audituser IN('".implode("','", $alltmpuser)."')") : '')." GROUP BY audituser ORDER BY num desc LIMIT 10";
		

		

		if($derive==2){	
			
			$top10user = $this->commands_set->base_select($sqltop10user);
			for($i=0; $i<count($top10user); $i++){
				$top10user[$i]['username']=$top10user[$i]['username'].'('.$top10user[$i]['realname'].')';
			}
			$top10protocol = $this->commands_set->base_select($sqltop10protocol);
			$top10dstip = $this->loginacct_set->base_select($sqltop10dstip);
			$top10srcip = $this->loginacct_set->base_select($sqltop10srcip);$last10user = $this->loginacct_set->base_select($sqllast10user);
			for($i=0; $i<count($last10user); $i++){
				$last10user[$i]['audituser']=$last10user[$i]['audituser'].'('.$last10user[$i]['realname'].')';
			}
			if(is_array($last10user))
			$last10user = array_reverse($last10user);

			ob_start();
			$this->display('reportgraph_for_export.tpl');
			$str = ob_get_clean();
			
			if($_GET['derive_forcron']){
				echo mb_convert_encoding($str, "GBK", "UTF-8");
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=ReportGraph.html"); 
			echo $str;
			exit();
		}else if($derive==3){//word
			$top10user = $this->commands_set->base_select($sqltop10user);
			for($i=0; $i<count($top10user); $i++){
				$top10user[$i]['username']=$top10user[$i]['username'].'('.$top10user[$i]['realname'].')';
			}
			$top10protocol = $this->commands_set->base_select($sqltop10protocol);
			$top10dstip = $this->loginacct_set->base_select($sqltop10dstip);
			$top10srcip = $this->loginacct_set->base_select($sqltop10srcip);$last10user = $this->loginacct_set->base_select($sqllast10user);
			for($i=0; $i<count($last10user); $i++){
				$last10user[$i]['audituser']=$last10user[$i]['audituser'].'('.$last10user[$i]['realname'].')';
			}
			if(is_array($last10user))
			$last10user = array_reverse($last10user);

			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('reportgraph_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=ReportGraph.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}

loading_start();
		$top10user = $this->commands_set->base_select($sqltop10user);
		for($i=0; $i<count($top10user); $i++){
			$top10user[$i]['username']=subUTF8($top10user[$i]['username'].'('.$top10user[$i]['realname'].')', 14);
		}
		$top10protocol = $this->commands_set->base_select($sqltop10protocol);
		$top10dstip = $this->loginacct_set->base_select($sqltop10dstip);
		$top10srcip = $this->loginacct_set->base_select($sqltop10srcip);$last10user = $this->loginacct_set->base_select($sqllast10user);
		for($i=0; $i<count($last10user); $i++){
			$last10user[$i]['audituser']=subUTF8($last10user[$i]['audituser'].'('.$last10user[$i]['realname'].')', 14);
		}
		if(is_array($last10user))
		$last10user = array_reverse($last10user);

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		$this->assign('curr_url', $curr_url);
		$this->assign('top10user', json_encode($top10user));
		$this->assign('top10protocol', json_encode($top10protocol));
		$this->assign('top10srcip', json_encode($top10srcip));
		$this->assign('top10dstip', json_encode($top10dstip));
		$this->assign('last10user', json_encode($last10user));
		$this->assign('f_rangeStart', $f_rangeStart);
		$this->assign('f_rangeEnd', $f_rangeEnd);
loading_end();
		$this->display('reportgraph.tpl');
	}

	function loginacct($where = NULL) {
		global $_CONFIG;
		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = "1=1";
		$start = get_request('start');

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$id1 = get_request('id1');
		$id2 = get_request('id2');
		$serverip = get_request('serverip', 0, 1);
		$from = get_request('from', 0, 1);
		$systemuser = get_request('systemuser', 0, 1);
		$audituser = get_request('audituser', 0, 1);
		$protocol = get_request('protocol', 0, 1);
		$status = get_request('authenticationstatus', 0, 1);
		$time_start = get_request('f_rangeStart', 0, 1);
		$time_end = get_request('f_rangeEnd', 0, 1);
		$usergroup = get_request('usergroup', 0, 1);
		if(empty($time_start)&&empty($time_end)){
			$time_start = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$time_end = date('Y-m-d');
		}
		if(empty($orderby1)){
			$orderby1 = 'time';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		if($id1){
			$where .= " AND sid>=$id1";
		}
		if($id2){
			$where .= " AND sid<=$id2";
		}
		if($time_start){
			$where .= " AND `time` >='".$time_start." 00:00:00'";
		}
		if($time_end){
			$where .= " AND `time` <='".$time_end." 23:59:59'";
		}
		if($from) {
			if(is_ip($from)) {
				$where .= " AND loginacct.`sourceip` = '$from'";
			}
			else {
				$where .= " AND loginacct.`sourceip` LIKE '$from%'";
			}
		}
		if($protocol){
			$where .=" AND `portocol`='$protocol'";
		}

		if($usergroup){
			$where .=" AND ug.`id`='$usergroup'";
		}

		if($serverip) {
			if(is_ip($serverip)) {
				$where .= " AND serverip = '$serverip'";
			}
			else {
				$where .= " AND serverip LIKE '$serverip%'";
			}
		}

		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				$where .= " AND LEFT(serverip,IF(LOCATE(':',serverip)>0,LOCATE(':',serverip)-1,LENGTH(serverip))) IN ('".implode("','", $alltmpip)."')";
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND audituser IN ('".implode("','", $alltmpuser)."')";
				}
		}
		
		if($systemuser) {
			$where .= " AND (systemuser LIKE '%$systemuser%')";
		}
		
		if($audituser) {
			$where .= " AND (audituser LIKE '%$audituser%')";
		}
		if($status!=""){
			$where .= " AND (authenticationstatus='$status')";
		}
		if($_SESSION['ADMIN_LEVEL']==0){
			$where .= " AND (audituser = '".$_SESSION['ADMIN_USERNAME']."')";
		}
		$get_user_flist = $this->get_user_flist();
		if($_SESSION['ADMIN_LEVEL'] != 1 and !empty($get_user_flist)) {
			$where .= " AND host IN (" . implode(",", $get_user_flist) . ")";
		}

		$cronreport_ugroupid = $_GET['cornreport_param']['ugroupid'];
		$cronreport_sgroupid = $_GET['cornreport_param']['sgroupid'];
		$cronreport_username = $_GET['cornreport_param']['username'];
		$cronreport_server = $_GET['cornreport_param']['server'];

		if(empty($cronreport_ugroupid)){
			if($cronreport_ldapid2_u){
				$cronreport_ugroupid = $cronreport_ldapid2_u;
			}else if($cronreport_ldapid1_u){
				$cronreport_ugroupid = $cronreport_ldapid1_u;
			}
		}
		if(empty($cronreport_sgroupid)){
			if($ldapid2){
				$cronreport_sgroupid = $cronreport_ldapid2;
			}else if($cronreport_ldapid1){
				$cronreport_sgroupid = $cronreport_ldapid1;
			}
		}
		$cronreport_alltmpusername = array(0);
		$cronreport_alltmpip = array(0);
		if(empty($cronreport_username)){
			$allusers = mysql_query("SELECT uid,username FROM member WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allusers)
			while($row = mysql_fetch_array($allusers)){
				$cronreport_alltmpusername[]=$row['uid'];
			}
		}
		if(empty($cronreport_server)){
			$allips = mysql_query("SELECT device_ip FROM servers WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allips)
			while($row = mysql_fetch_array($allips)){
				$cronreport_alltmpip[]=$row['device_ip'];
			}
		}
		$where .= (!empty($cronreport_username) ? ' AND m.username="'.$cronreport_username.'" ' : (!empty($cronreport_ugroupid) ? ' AND m.uid IN("'.implode('","', $cronreport_alltmpusername).'")' : '')).(!empty($cronreport_server) ? ' AND serverip="'.$cronreport_server.'" ' : (!empty($cronreport_sgroupid) ? ' AND serverip IN("'.implode('","', $cronreport_alltmpip).'")' : ''));

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND LEFT(serverip,IF(LOCATE(':',serverip)>0,LOCATE(':',serverip)-1,LENGTH(serverip))) IN ('".implode("','", $cronreport_alltmpip)."')";
		}

		
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		$this->assign('f_rangeStart', $time_start);
		$this->assign('f_rangeEnd', $time_end);
		if($delete) {
			if($_SESSION['ADMIN_LEVEL'] == 1) {
				$this->delete_loginlog($where);
			}
			else {
				die(language('没有权限'));
			}
		}
		
		else if($derive) {
			if($derive==1){
				$result = $this->loginacct_set->base_select("SELECT loginacct.*,m.realname,ug.groupname FROM ".$this->loginacct_set->get_table_name()." LEFT JOIN ".$this->member_set->get_table_name()." m ON loginacct.audituser=m.username LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON ug.id=m.groupid WHERE $where LIMIT $start, 10000");
				$str = "日期:\t".$time_start."\t 到 \t".$time_end."\n";
				$str .= language("序号")."SID\t";
				$str .= language("来源地址")."\t";
				$str .= language("审计系统")."\t";
				$str .= language("目标地址")."\t";
				$str .= language("登录协议")."\t";
				$str .= language("时间")."\t";
				$str .= language("运维账号")."\t";
				$str .= language("别名")."\t";
				$str .= language("运维组")."\t";
				$str .= language("系统帐号")."\t";
				$str .= language("状态")."\t";
				$str .= language("出错原因")."\t\n";
				$row = 1;
				if(!empty($result))
				foreach($result as $info) {
					$str .= $info['sid']."\t";
					$str .= $info['sourceip']."\t";
					$str .= $info['auditip']."\t";
					$str .= $info['serverip']."\t";
					$str .= $info['portocol']."\t";
					$str .= $info['time']."\t";
					$str .= $info['audituser']."\t";
					$str .= $info['realname']."\t";
					$str .= $info['groupname']."\t";
					$str .= $info['systemuser']."\t";
					$str .= ($info['authenticationstatus'] ? '成功' : '失败')."\t";
					$str .= $info['failreason']."\t";	
					$str .= "\n";		
					
					$row++;
				}
				if($_GET['derive_forcron']){
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					return ;
				}
				Header('Cache-Control: private, must-revalidate, max-age=0');
				Header("Content-type: application/octet-stream"); 
				Header("Content-Disposition: attachment; filename=loginacct.xls"); 
				echo mb_convert_encoding($str, "GBK", "UTF-8");
				exit();		
			}else if($derive==4){
				$result = $this->loginacct_set->base_select("SELECT loginacct.*,m.realname,ug.groupname FROM ".$this->loginacct_set->get_table_name()." LEFT JOIN ".$this->member_set->get_table_name()." m ON loginacct.audituser=m.username LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON ug.id=m.groupid WHERE $where LIMIT $start, 10000");
				$pdf=new PDF_Chinese('P','mm','A4');
				$pdf->AddGBFont(); 
				$pdf->Open();
				$pdf->SetFont('GB','',12); 
				$pdf->AddPage();			
				$pdf->SetFillColor(224,235,255);
				$pdf->SetTextColor(0);
				$pdf->SetFont('');
				// Column headings
				$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','来源地址'), iconv('UTF-8','GBK','审计系统'), iconv('UTF-8','GBK','主机地址'), iconv('UTF-8','GBK','登录协议'), iconv('UTF-8','GBK','时间'),iconv('UTF-8','GBK','运维账号'),iconv('UTF-8','GBK','别名'),iconv('UTF-8','GBK','运维组'),iconv('UTF-8','GBK','系统用户'),iconv('UTF-8','GBK','状态'),iconv('UTF-8','GBK','出错原因'));
				$w = array(20, 36, 36, 36, 36, 36);
				// Data loading
				$i=0; $id=0; 
				$pdf->SetWidths($w);
				$pdf->Row($header, $fill);
				$fill = false;
				foreach ($result AS $report){	
					$pdf->Row(array(++$id, $report['sourceip'], iconv('UTF-8','GBK',$report['auditip']), iconv('UTF-8','GBK',$report['serverip']), iconv('UTF-8','GBK',$report['portocol']), iconv('UTF-8','GBK',$report['time']), iconv('UTF-8','GBK',$report['audituser']), iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['systemuser']), iconv('UTF-8','GBK',$report['authenticationstatus'] ? '成功' : '失败')), $fill);
					$fill = !$fill;

				}
				//$pdf->FancyTable($header,$data,$w);
				if($_GET['derive_forcron']){
					echo $pdf->Output();
					return ;
				}
				$pdf->Output();
				exit;
			}else if($derive==2){
				$alllog = $this->loginacct_set->base_select("SELECT loginacct.*,m.realname,ug.groupname FROM ".$this->loginacct_set->get_table_name()." LEFT JOIN ".$this->member_set->get_table_name()." m ON loginacct.audituser=m.username LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON ug.id=m.groupid WHERE $where LIMIT $start, 10000");
				ob_start();
				$this->assign('alllog', $alllog);
				$this->assign('title', language('登录日志'));
				$this->display('loginacct_export_tohtml.tpl');
				$str = ob_get_clean();
				if($_GET['derive_forcron']){
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					return ;
				}
				Header('Cache-Control: private, must-revalidate, max-age=0');
				Header("Content-type: application/octet-stream"); 
				Header("Content-Disposition: attachment; filename=auditreports.html"); 
				echo $str;
				exit();
				return;
			}else if($derive==3){//word
				$alllog = $this->sessions_set->base_select($sql);
				ob_start();
				$this->assign('alllog', $alllog);
				$this->display('loginacct_export_tohtml.tpl');
				$str = ob_get_clean();
				if($_GET['derive_forcron']){
					echo $str;
					return ;
				}
				Header('Cache-Control: private, must-revalidate, max-age=0');
				header("Content-type:application/vnd.ms-doc;");
				header("Content-Disposition: attachment;filename=auditreports.doc");
				echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
						xmlns:w=urn:schemas-microsoft-com:office:word 
						xmlns= target=_blank>";
				echo $str;
				echo "</html>"; 
				exit();
			}
		}
		else {
loading_start();	
			//$row_num = $this->loginacct_set->select_count($where);
			//$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			if($page_num==1||empty($page_num)){
				$row_num=10000000;
			}elseif($_SESSION['app_priority_search_num']){
				$row_num = $_SESSION['app_priority_search_num'];
			}
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$alllog = $this->loginacct_set->base_select("SELECT SQL_CALC_FOUND_ROWS loginacct.*,m.realname,ug.groupname FROM ".$this->loginacct_set->get_table_name()." LEFT JOIN ".$this->member_set->get_table_name()." m ON loginacct.audituser=m.username LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON ug.id=m.groupid WHERE $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition,  $newpager->intItemsPerPage");
			//$alllog=$this->loginacct_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2 );
			$_rows = $this->server_set->base_select("SELECT FOUND_ROWS() row_num");
			$_SESSION['app_priority_search_num']=$row_num = $_rows[0]['row_num'];
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			if($row_num>10000){				
				$num = ceil($row_num/10000);
				$str = "";
				$strhtml = "";
				for($i=0; $i<$num; $i++){
					$str .= "<a href='".$curr_url."&derive=1&start=".($i*10000+1)."' target='hide'>".($i*10000+1)."-".(($i+1)*10000 < $row_num ? ($i+1)*10000 : $row_num)."</a>  ";
					$strhtml .= "<a href='".$curr_url."&derive=2&start=".($i*10000+1)."' target='hide'>".($i*10000+1)."-".(($i+1)*10000 < $row_num ? ($i+1)*10000 : $row_num)."</a>  ";
					$strdoc .= "<a href='".$curr_url."&derive=3&start=".($i*10000+1)."' target='hide'>".($i*10000+1)."-".(($i+1)*10000 < $row_num ? ($i+1)*10000 : $row_num)."</a>  ";
				}
			}
			$alltem = $this->tem_set->select_all(" device_type = '' AND login_method IN('ssh','RDP','telnet','ftp','ssh1','vnc','x11','rlogin','apppub')", 'login_method', 'ASC');
			$alldevtype = $this->tem_set->select_all('login_method=""');
			$this->assign("alltem", $alltem);
			$this->assign("alldevtype", $alldevtype);
			$this->assign("str", $str);
			$this->assign("strhtml", $strhtml);
			$this->assign("strdoc", $strdoc);
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('log_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('alllog', $alllog);
			$usergroup = $this->usergroup_set->select_all('level=0 and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');		$this->assign('usergroup', $usergroup);
			$this->assign('allgroup', $usergroup);
loading_end();		
			
			$this->display("loginacct.tpl");
		}
	}

	
	function loginfailed($where = NULL) {
		global $_CONFIG;

		$page_num = get_request('page');
		$derive = get_request('derive');
		$delete = get_request('delete');
		$where = "1=1";
		$start = get_request('start');

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$serverip = get_request('serverip', 0, 1);
		$from = get_request('from', 0, 1);
		$audituser = get_request('audituser', 0, 1);
		$protocol = get_request('protocol', 0, 1);
		$ct = get_request('ct', 0, 1);
		$time_start = get_request('f_rangeStart', 0, 1);
		$time_end = get_request('f_rangeEnd', 0, 1);
		if(empty($time_start)&&empty($time_end)){
			$time_start = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$time_end = date('Y-m-d');
		}
		if(empty($orderby1)){
			$orderby1 = 'ct';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		if($id1){
			$where .= " AND sid>=$id1";
		}
		if($id2){
			$where .= " AND sid<=$id2";
		}
		if($time_start){
			$where .= " AND `time` >='".$time_start." 00:00:00'";
		}
		if($time_end){
			$where .= " AND `time` <='".$time_end." 23:59:59'";
		}
		if($from) {
			if(is_ip($from)) {
				$where .= " AND `sourceip` = '$from'";
			}
			else {
				$where .= " AND `sourceip` LIKE '$from%'";
			}
		}
		if($protocol){
			$where .=" AND `portocol`='$protocol'";
		}

		if($serverip) {
			if(is_ip($serverip)) {
				$where .= " AND serverip = '$serverip'";
			}
			else {
				$where .= " AND serverip LIKE '$serverip%'";
			}
		}

		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				$where .= " AND LEFT(serverip,IF(LOCATE(':',serverip)>0,LOCATE(':',serverip)-1,LENGTH(serverip))) IN ('".implode("','", $alltmpip)."')";
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND audituser IN ('".implode("','", $alltmpuser)."')";
				}
		}
		
		if($systemuser) {
			$where .= " AND (systemuser LIKE '%$systemuser%')";
		}
		
		if($audituser) {
			$where .= " AND (audituser LIKE '%$audituser%')";
		}
		if($status!=""){
			$where .= " AND (authenticationstatus='$status')";
		}
		if($_SESSION['ADMIN_LEVEL']==0){
			$where .= " AND (audituser = '".$_SESSION['ADMIN_USERNAME']."')";
		}
		$get_user_flist = $this->get_user_flist();
		if($_SESSION['ADMIN_LEVEL'] != 1 and !empty($get_user_flist)) {
			$where .= " AND host IN (" . implode(",", $get_user_flist) . ")";
		}

		$cronreport_ugroupid = $_GET['cornreport_param']['ugroupid'];
		$cronreport_sgroupid = $_GET['cornreport_param']['sgroupid'];
		$cronreport_username = $_GET['cornreport_param']['username'];
		$cronreport_server = $_GET['cornreport_param']['server'];

		if(empty($cronreport_ugroupid)){
			if($cronreport_ldapid2_u){
				$cronreport_ugroupid = $cronreport_ldapid2_u;
			}else if($cronreport_ldapid1_u){
				$cronreport_ugroupid = $cronreport_ldapid1_u;
			}
		}
		if(empty($cronreport_sgroupid)){
			if($ldapid2){
				$cronreport_sgroupid = $cronreport_ldapid2;
			}else if($cronreport_ldapid1){
				$cronreport_sgroupid = $cronreport_ldapid1;
			}
		}
		$cronreport_alltmpusername = array(0);
		$cronreport_alltmpip = array(0);
		if(empty($cronreport_username)){
			$allusers = mysql_query("SELECT uid,username FROM member WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allusers)
			while($row = mysql_fetch_array($allusers)){
				$cronreport_alltmpusername[]=$row['username'];
			}
		}
		if(empty($cronreport_server)){
			$allips = mysql_query("SELECT device_ip FROM servers WHERE groupid=".$cronreport_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$cronreport_ugroupid."))");
			if($allips)
			while($row = mysql_fetch_array($allips)){
				$cronreport_alltmpip[]=$row['device_ip'];
			}
		}
		$where .= (!empty($cronreport_username) ? ' AND audituser="'.$cronreport_username.'" ' : (!empty($cronreport_ugroupid) ? ' AND audituser IN("'.implode('","', $cronreport_alltmpusername).'")' : '')).(!empty($cronreport_server) ? ' AND serverip="'.$cronreport_server.'" ' : (!empty($cronreport_sgroupid) ? ' AND serverip IN("'.implode('","', $cronreport_alltmpip).'")' : ''));

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND LEFT(serverip,IF(LOCATE(':',serverip)>0,LOCATE(':',serverip)-1,LENGTH(serverip))) IN ('".implode("','", $cronreport_alltmpip)."')";
		}

		
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		
		if($delete) {
			if($_SESSION['ADMIN_LEVEL'] == 1) {
				$this->delete_loginlog($where);
			}
			else {
				die(language('没有权限'));
			}
		}
		
		else if($derive) {			
			if($derive==1){
				$sql = "SELECT count(*) ct,serverip,sourceip,audituser,portocol FROM ".$this->loginacct_set->get_table_name()." WHERE $where GROUP BY serverip,sourceip,audituser,portocol ORDER BY serverip asc";
				//$result=$this->loginacct_set->base_select("SELECT count(*) ct,serverip,sourceip,audituser,portocol FROM ".$this->loginacct_set->get_table_name()." WHERE $where  GROUP BY serverip,sourceip,audituser,portocol ORDER BY serverip asc LIMIT $start, 10000");
				//$handle = @fopen(ROOT . '/tmp/loginacct.xls', 'w');
				
				$str = "日期:\t".$time_start."\t到\t".$time_end."\n";
				$str .= language("序号")."SID\t";
				$str .= language("来源地址")."\t";
				$str .= language("主机地址")."\t";
				$str .= language("登录协议")."\t";
				$str .= language("账号")."\t";
				$str .= language("次数")."\t\n";
				$i=0;
				$row=0;
				if($_GET['derive_forcron']){
					echo mb_convert_encoding($str, "GBK", "UTF-8");
				}else{
					$f = @fopen('tmp/loginacct.xls', "wa+");
					@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
				}
				while(1){
					$str='';
					$result = $this->loginacct_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
					if(empty($result)) break;

					foreach($result as $info) {
						$str .= $row++."\t";
						$str .= $info['sourceip']."\t";
						$str .= $info['serverip']."\t";
						$str .= $info['portocol']."\t";
						$str .= $info['audituser']."\t";
						$str .= $info['ct']."\t";	
						$str .= "\n";		
					}
					if($_GET['derive_forcron']){
						echo mb_convert_encoding($str, "GBK", "UTF-8");
					}else{
						@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
					}
				}
				if($_GET['derive_forcron']){
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					return ;
				}else{
					fclose($f);
					go_url('tmp/loginacct.xls?'.time());
				}
				/*
				Header('Cache-Control: private, must-revalidate, max-age=0');
				Header("Content-type: application/octet-stream"); 
				Header("Content-Disposition: attachment; filename=loginacct.xls"); 
				$str= mb_convert_encoding($str, "GBK", "UTF-8");
				echo $str;
				*/
				exit();
			}else if($derive==4){
				$result=$this->loginacct_set->base_select("SELECT count(*) ct,serverip,sourceip,audituser,portocol FROM ".$this->loginacct_set->get_table_name()." WHERE $where  GROUP BY serverip,sourceip,audituser,portocol ORDER BY serverip asc LIMIT $start, 10000");
				$pdf=new PDF_Chinese('P','mm','A4');
				$pdf->AddGBFont(); 
				$pdf->Open();
				$pdf->SetFont('GB','',12); 
				$pdf->AddPage();			
				$pdf->SetFillColor(224,235,255);
				$pdf->SetTextColor(0);
				$pdf->SetFont('');
				// Column headings
				$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','来源地址'), iconv('UTF-8','GBK','主机地址'), iconv('UTF-8','GBK','登录协议'), iconv('UTF-8','GBK','账号'), iconv('UTF-8','GBK','次数'));
				$w = array(20, 36, 36, 36, 36, 36);
				// Data loading
				$i=0; $id=0; 
				$pdf->SetWidths($w);
				$pdf->Row($header, $fill);
				$fill = false;
				foreach ($result AS $report){	
					$pdf->Row(array(++$id, $report['sourceip'], iconv('UTF-8','GBK',$report['serverip']), iconv('UTF-8','GBK',$report['portocol']), iconv('UTF-8','GBK',$report['audituser']), iconv('UTF-8','GBK',$report['ct'])), $fill);
					$fill = !$fill;

				}
				//$pdf->FancyTable($header,$data,$w);
				if($_GET['derive_forcron']){
					echo $pdf->Output();
					return ;
				}
				$pdf->Output();
				exit;
		}else if($derive==2){
				$alllog=$this->loginacct_set->base_select("SELECT count(*) ct,serverip,sourceip,audituser,portocol FROM ".$this->loginacct_set->get_table_name()." WHERE $where  GROUP BY serverip,sourceip,audituser,portocol ORDER BY serverip asc LIMIT $start, 10000");
				ob_start();
				$this->assign('alllog', $alllog);
				$this->assign('title', language('登录日志'));
				$this->display('loginfailed_export_tohtml.tpl');
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
				return;
			}else if($derive==3){//word
				$alllog = $this->sessions_set->base_select("SELECT count(*) ct,serverip,sourceip,audituser,portocol FROM ".$this->loginacct_set->get_table_name()." WHERE $where  GROUP BY serverip,sourceip,audituser,portocol ORDER BY serverip asc LIMIT $start, 10000");
				ob_start();
				$this->assign('alllog', $alllog);
				$this->display('loginfailed_export_tohtml.tpl');
				$str = ob_get_clean();
				if($_GET['derive_forcron']){
					echo $str;
					return ;
				}
				Header('Cache-Control: private, must-revalidate, max-age=0');
				header("Content-type:application/vnd.ms-doc;");
				header("Content-Disposition: attachment;filename=AppAccountReport.doc");
				echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
						xmlns:w=urn:schemas-microsoft-com:office:word 
						xmlns= target=_blank>";
				echo $str;
				echo "</html>"; 
				exit();
			}
		}
		else {
loading_start();
			$row_num = $this->loginacct_set->base_select("SELECT count(*) AS row_num FROM (SELECT count(*) FROM ".$this->loginacct_set->get_table_name()." WHERE $where GROUP BY serverip,sourceip,audituser,portocol) t");
			$row_num = $row_num[0]['row_num'];
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$alllog=$this->loginacct_set->base_select("SELECT count(*) ct,serverip,sourceip,audituser,portocol FROM ".$this->loginacct_set->get_table_name()." WHERE $where  GROUP BY serverip,sourceip,audituser,portocol ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
			if($row_num>10000){				
				$num = ceil($row_num/10000);
				$str = "";
				$strhtml = "";
				for($i=0; $i<$num; $i++){
					$str .= "<a href='".$curr_url."&derive=1&start=".($i*10000+1)."' target='_blank'>".($i*10000+1)."-".(($i+1)*10000 < $row_num ? ($i+1)*10000 : $row_num)."</a>  ";
					$strhtml .= "<a href='".$curr_url."&derive=2&start=".($i*10000+1)."' target='_blank'>".($i*10000+1)."-".(($i+1)*10000 < $row_num ? ($i+1)*10000 : $row_num)."</a>  ";
					$strdoc .= "<a href='".$curr_url."&derive=3&start=".($i*10000+1)."' target='_blank'>".($i*10000+1)."-".(($i+1)*10000 < $row_num ? ($i+1)*10000 : $row_num)."</a>  ";
				}
			}
			$alltem = $this->tem_set->select_all(" device_type = '' AND login_method IN('ssh','RDP','telnet','ftp','ssh1','vnc','x11','rlogin','apppub')", 'login_method', 'ASC');
			$alldevtype = $this->tem_set->select_all('login_method=""');
			$this->assign("alltem", $alltem);
			$this->assign("alldevtype", $alldevtype);
			$this->assign("str", $str);
			$this->assign("strhtml", $strhtml);
			$this->assign("strdoc", $strdoc);
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('log_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('alllog', $alllog);
			$this->assign('f_rangeStart', $start);
			$this->assign('f_rangeEnd', $end);
			$usergroup = $this->usergroup_set->select_all('level=0 and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');		$this->assign('usergroup', $usergroup);
			$this->assign('allgroup', $usergroup);
loading_end();
			$this->display("loginfailed.tpl");
		}
	}


	function derive_loginfailed($start, $where) {		
		
	
	}
	
	function derive_loginfailed_tohtml($start, $where){
		
	}
	
	function configreport(){
		$back = get_request('back');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$page_num = get_request('page');
		$derive = get_request('derive');
		$view = get_request('view');
		$delete = get_request('delete');
		$where = "1=1";
		$start = get_request('start');
		$subject = get_request('subject', 0, 1);
		$template = get_request('template', 0, 1);
		$f_rangeStart = get_request('f_rangeStart', 0, 1);
		$f_rangeEnd = get_request('f_rangeEnd', 0, 1);

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		
		if(empty($orderby1)){
			$orderby1 = 'createtime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		if($time_start){
			$where .= " AND `time` >='".$time_start."'";
		}
		if($time_end){
			$where .= " AND `time` <='".$time_end."'";
		}
		if($from) {
			
				$where .= " AND subject LIKE '$from%'";
			
		}
		if($template){
			$where .=" AND template='$template'";
		}

		if($subject){
			$where .=" AND subject like '%$subject%'";
		}
		
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];		
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
		if($derive||$view) {
			$id = get_request('id');
			$report = $this->configreport_set->select_by_id($id);
			switch($report['cycle']){
				case 'thisday':
					$_GET['f_rangeStart'] = date('Y-m-d', mktime(0,0,0,date('m'),date('d'),date('Y')));
					break;
				case 'thisweek':
					$_GET['f_rangeStart'] = date('Y-m-d', mktime(0,0,0,date('m'),date('d')-date('w')+1,date('Y')));
					break;
				case 'thismonth':
					$_GET['f_rangeStart'] = date('Y-m-d', mktime(0,0,0,date('m'),1,date('Y')));
					break;
			}
			$pos = strpos($report['template'], '_');
			if($pos===false){
				$prev=$report['template'];
			}else{
				$prev = substr($report['template'], 0, $pos);
				if($pos+1<=strlen($report['template']))
					$back = substr($report['template'], $pos+1);
			}
			if($view){
				unset($derive);
			}
			
			switch($prev){
				case 'reportaudit':
					$_GET['number']=$back;
					$this->$prev();
					break;
				default:
					$this->$prev();
					break;
					
			}
			exit;
		} else {
			//echo $where;
			$row_num = $this->configreport_set->select_count($where);
			$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
			$alllog=$this->configreport_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2 );
			for($i=0; $i<count($alllog); $i++){
				for($j=0; $j<count($this->templates); $j++){
					if($alllog[$i]['template']==$this->templates[$j]['name']){
						$alllog[$i]['templatename']=$this->templates[$j]['title'];
					}
				}
				switch($alllog[$i]['cycle']){
					case 'thisday';
						$alllog[$i]['cyclename']='当天';
					break;
					case 'thisweek';
						$alllog[$i]['cyclename']='本周';
					break;
					case 'thismonth';
						$alllog[$i]['cyclename']='当月';
					break;
				}
				
			}
			$this->assign("templates", $this->templates);
			$this->assign('page_list', $newpager->showSerialList());
			$this->assign('log_num', $row_num);
			$this->assign('curr_page', $newpager->intCurrentPageNumber);
			$this->assign('total_page', $newpager->intTotalPageCount);
			$this->assign('items_per_page', $newpager->intItemsPerPage);
			$this->assign('curr_url', $curr_url);
			$this->assign('alllog', $alllog);
			$this->assign('f_rangeStart', $start);
			$this->assign('f_rangeEnd', $end);
			$this->display("configreport.tpl");
		}
	}

	function configreport_edit(){
		$id = get_request("id");
		$configreport = $this->configreport_set->select_by_id($id);
		
		$this->assign("id", $id);
		$this->assign("templates", $this->templates);
		$this->assign("configreport", $configreport);
		$this->display("configreport_edit.tpl");
	}
	
	function configreport_save(){
		$id = get_request("id");
		$template = get_request("template", 1, 1);
		$subject = get_request("subject", 1, 1);
		$cycle = get_request("cycle", 1, 1);
		$newconfigreport = new configreport();
		$newconfigreport->set_data("template", $template);
		$newconfigreport->set_data("subject", $subject);
		$newconfigreport->set_data("cycle", $cycle);
		$newconfigreport->set_data("createtime", date('Y-m-d'));
		if(empty($subject)){
			alert_and_back('标题不能为空');
			exit;
		}
		if($id){
			$newconfigreport->set_data("id", $id);
			$this->configreport_set->edit($newconfigreport);
		}else{
			$this->configreport_set->add($newconfigreport);
		}
		alert_and_back('操作成功','admin.php?controller=admin_reports&action=configreport');
	}

	function configreport_delete(){
		$this->configreport_set->delete($_POST['chk_member']);
		alert_and_back('操作成功','admin.php?controller=admin_reports&action=configreport');
	}

	function cronreports(){
		$back = get_request('back');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$page_num = get_request('page');
		$derive = get_request('derive');
		$view = get_request('view');
		$delete = get_request('delete');
		$where = "1=1";
		$start = get_request('start');
		$subject = get_request('subject', 0, 1);
		$template = get_request('template', 0, 1);
		$f_rangeStart = get_request('f_rangeStart', 0, 1);
		$f_rangeEnd = get_request('f_rangeEnd', 0, 1);

		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		
		if(empty($orderby1)){
			$orderby1 = 'applytime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		
		
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];		
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
		$row_num = $this->cronreport_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alllog=$this->cronreport_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2 );
		$this->assign("alllog", $alllog);
		$this->display("cronreport.tpl");
	}

	function cronreport_del(){
		$id = get_request('id');
		$this->cronreport_set->delete($id);
		alert_and_back('操作成功');
		exit;
	}

	function cronreport_edit(){
		global $_CONFIG;		
		$id = get_request('id');
		$page_num = get_request('page');
		
		$ha = $this->config_set->base_select("SELECT * FROM cronreports WHERE id=$id LIMIT 1");
		$defaultp = $ha[0];

		$users = $this->member_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101 ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'username', 'ASC');
		$servers = $this->server_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '')." AND (groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS'])."))" : ''),'device_ip', 'ASC');
		$sgroups = $this->sgroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : ' AND id IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).') ') : ''),'groupname', 'ASC');
		
		$this->assign("logined_user_level", 1);
		$datetype = array('day', 'week', 'month');
		foreach($datetype AS $v){
			$precl=$v;
			$ldapidname = $v.'_ldapid';
			$groupidname = $v.'_groupid';
			$$groupidname=$defaultp[$v.'ugroupid'];
			$groupfunc='change_usergroup(this.value,\''.$v.'\');';
			$groupfuncf='change_usergroup('.$$groupidname.',\''.$v.'\');';
			//$this->assign("ldapid1", 0);
			$precl=$v.'s';
			$ldapidname = $v.'_sldapid';
			$groupidname = $v.'_sgroupid';
			$$groupidname=$defaultp[$v.'sgroupid'];
			$groupfunc='change_servergroup(this.value,\''.$v.'\');';
			$groupfuncf='change_servergroup('.$$groupidname.',\''.$v.'\');';
			//$this->assign("ldapid1", 0);
		}
		require('./include/select_sgroup_ajax.inc.php');

		$this->assign('alluser', $users);
		$this->assign('allserver', $servers);
		$this->assign('sgroups', $sgroups);
		$this->assign("_config", $_CONFIG);

		
		$defaultp['template']=$ha[0]['template'];
		$ha_day = explode(',', $ha[0]['day']);
		for($i=0; $i<count($ha_day); $i++){
			$defaultp['day_'.$ha_day[$i]]=1;
		}
		$ha_week = explode(',', $ha[0]['week']);
		for($i=0; $i<count($ha_week); $i++){
			$defaultp['week_'.$ha_week[$i]]=1;
		}
		$ha_month = explode(',', $ha[0]['month']);			
		for($i=0; $i<count($ha_month); $i++){
			$defaultp['month_'.$ha_month[$i]]=1;
		}
		$this->assign('defaultp', $defaultp);
		$ha['dayusers'] = explode(',',$ha[0]['dayusers']);
		$ha['weekusers'] = explode(',', $ha[0]['weekusers']);
		$ha['monthusers'] = explode(',', $ha[0]['monthusers']);
		$users = $this->member_set->select_all('1', 'username', 'asc');
		for($i=0; $i<count($users); $i++){
			$_user = array('uid'=>$users[$i]['uid'], 'username'=>$users[$i]['username'], 'realname'=>$users[$i]['realname']);
			if(in_array($users[$i]['uid'], $ha['dayusers'])){
				$_user['dcheck'] = 'checked'; ;
			}
			$dayusers[] = $_user;
			if(in_array($users[$i]['uid'], $ha['weekusers'])){
				$_user['wcheck'] = 'checked'; ;
			}
			$weekusers[] = $_user;
			if(in_array($users[$i]['uid'], $ha['monthusers'])){
				$_user['mcheck'] = 'checked'; ;
			}
			$monthusers[] = $_user;
			$_user = null;
		}//var_dump($dayusers);
		$this->assign("dayusers", $dayusers);
		$this->assign("weekusers", $weekusers);
		$this->assign("monthusers", $monthusers);
		$this->display("cronreport_edit.tpl");
	}

	function cronreport_save(){
		$id = get_request('id');
		$ac = get_request('ac', 1, 1);		
		/*$day = get_request('day',1,1);	
		$week = get_request('week',1,1);
		$month = get_request('month',1,1);
		$dayusers = get_request('dayusers',1,1);
		$weekusers = get_request('weekusers',1,1);
		$monthusers = get_request('monthusers',1,1);*/
		
		if($ac){			
			$template = get_request('template',1,1);	
			$c = new cronreport();
			$datetype = array('day', 'week', 'month');//var_dump($_POST);
			$c->set_data('template', $template);
			foreach($datetype AS $v){
				$$v = get_request($v,1,1);
				${$v.'users'} = get_request($v.'users',1,1);
				${$v.'_ugroupid'} = $_POST[$v.'_groupid'];
				${$v.'_sgroupid'} = $_POST[$v.'_sgroupid'];
				${$v.'_username'} = get_request($v.'_username', 1, 1);
				${$v.'_server'} = get_request($v.'_server', 1, 1);
							
				if($$v)
				$$v = implode(',', $$v);				
				$c->set_data($v, $$v);
				if(${$v.'users'})
				${$v.'users'} = implode(',', ${$v.'users'});			
				$c->set_data($v.'users', ${$v.'users'});	

				if(!empty(${$v.'_username'})) ${$v.'_ugroupid'} = 0;
				if(!empty(${$v.'_server'})) ${$v.'_sgroupid'} = 0;

				$c->set_data($v.'ugroupid', ${$v.'_ugroupid'});
				$c->set_data($v.'sgroupid', ${$v.'_sgroupid'});
				$c->set_data($v.'username', ${$v.'_username'});
				$c->set_data($v.'server', ${$v.'_server'});
			}
			if($id) {
				$c->set_data('id', $id);
				$this->cronreport_set->edit($c);
			}
			else{
				$this->cronreport_set->add($c);
			}
			//$sql = ($id ? 'UPDATE' : 'INSERT INTO ')." cronreports SET template='$template',day='$day', week='$week', month='$month',dayusers='$dayusers', weekusers='$weekusers', monthusers='$monthusers'";
			//$this->config_set->query($sql);
			alert_and_back('修改成功','admin.php?controller=admin_reports&action=cronreports');
			exit;
		}
	}

	function docronreports(){

		global $_CONFIG;
		$filename_a = array("commandreport"=>'命令总计报表',"sftpreport"=>'SFTP命令报表',"ftpreport"=>'FTP命令报表',"appreport"=>'应用报表',"logintims"=>'登录统计',"dangercmdreport"=>'违规报表',"logintims"=>'登录统计');

		$ha = $this->config_set->base_select("SELECT * FROM cronreports");	
		for($h=0; $h<count($ha); $h++){
			if($ha[$h]['template']=='pdf'){
				$_GET['derive']=4;$ext='pdf';//pdf
			}elseif($ha[$h]['template']=='excel'){
				$_GET['derive']=1;$ext='xls';//excel
			}else{
				$_GET['derive']=2;$ext='html';//html
			}
			$_GET['derive_forcron']=1;
			//$_GET['datetype'] = 'day';
			
			if($ha[$h]['day']&&$_GET['datetype']=='day'){			
				$ha_day = explode(',', $ha[$h]['day']);
				$_GET['f_rangeStart'] = date('Y-m-d', mktime(0,0,0,date('m'),date('d')-1,date('Y')));
				$_GET['f_rangeEnd'] = date('Y-m-d', mktime(23,59,59,date('m'),date('d')-1,date('Y')));				
				$_GET['cornreport_param']['username'] = $ha[$h]['dayusername'];
				$_GET['cornreport_param']['server'] = $ha[$h]['dayserver'];
				$_GET['cornreport_param']['ugroupid'] = $ha[$h]['dayugroupid'];
				$_GET['cornreport_param']['sgroupid'] = $ha[$h]['daysgroupid'];
				for($i=0; $i<count($ha_day); $i++){
					$pos = strpos($ha_day[$i], '_');
					if($pos===false){
						$prev=$ha_day[$i];
					}else{
						$prev = substr($ha_day[$i], 0, $pos);
						if($pos+1<=strlen($ha_day[$i]))
							$back = substr($ha_day[$i], $pos+1);
					}
					//echo "week_".$ha_week[$i].'<br >';
					ob_start();
					switch($prev){
						case 'reportaudit':
							$_GET['number']=$back;
							$this->$prev();
							break;
						default:						
							$this->$prev();
							break;
							
					}
					$contents = ob_get_clean();
					file_put_contents("tmp/day_".$ha_day[$i].".".$ext, $contents);
					
					$savfile = $_CONFIG['REPORT_FILE_PATH']."day_".$ha_day[$i]."_".$_GET['f_rangeStart']."_".$_GET['f_rangeEnd'].".".$ext;
			
					copy("tmp/day_".$ha_day[$i].".".$ext, $savfile);				
					$crf = new crontab_report_file();				
					$crf->set_data('filepath', $savfile);				
					$crf->set_data('title', $filename_a[$ha_day[$i]]);				
					$crf->set_data('start', $_GET['f_rangeStart']);				
					$crf->set_data('end', $_GET['f_rangeEnd']);				
					$this->crontab_report_file_set->add($crf);
					$dayfile[]="tmp/day_".$ha_day[$i].".".$ext;
				}
			}
			if($ha[$h]['week']&&$_GET['datetype']=='week'){			
				$ha_week = explode(',', $ha[$h]['week']);
				$_GET['f_rangeStart'] = date('Y-m-d', mktime(0,0,0,date('m'),date('d')-date('w')-7+1,date('Y')));
				$_GET['f_rangeEnd'] = date('Y-m-d', mktime(23,59,59,date('m'),date('d')-date('w'),date('Y')));
				$_GET['cornreport_param']['username'] = $ha[$h]['weekusername'];
				$_GET['cornreport_param']['server'] = $ha[$h]['weekserver'];
				$_GET['cornreport_param']['ugroupid'] = $ha[$h]['weekugroupid'];
				$_GET['cornreport_param']['sgroupid'] = $ha[$h]['weeksgroupid'];

				for($i=0; $i<count($ha_week); $i++){
					$pos = strpos($ha_week[$i], '_');
					if($pos===false){
						$prev=$ha_week[$i];
					}else{
						$prev = substr($ha_week[$i], 0, $pos);
						if($pos+1<=strlen($ha_week[$i]))
							$back = substr($ha_week[$i], $pos+1);
					}
					//echo "week_".$ha_week[$i].'<br >';
					ob_start();
					switch($prev){
						case 'reportaudit':
							$_GET['number']=$back;
							$this->$prev();
							break;
						default:						
							$this->$prev();
							break;
							
					}
					$contents = ob_get_clean();
					file_put_contents("tmp/week_".$ha_week[$i].".".$ext, $contents);
				
					$savfile = $_CONFIG['REPORT_FILE_PATH']."week_".$ha_week[$i]."_".$_GET['f_rangeStart']."_".$_GET['f_rangeEnd'].".".$ext;
		
					copy("tmp/week_".$ha_week[$i].".".$ext, $savfile);
				
					$crf = new crontab_report_file();
				
					$crf->set_data('filepath', $savfile);
				
					$crf->set_data('title', $filename_a[$ha_week[$i]]);
				
					$crf->set_data('start', $_GET['f_rangeStart']);
				
					$crf->set_data('end', $_GET['f_rangeEnd']);
				
					$this->crontab_report_file_set->add($crf);
					$weekfile[]="tmp/week_".$ha_week[$i].".".$ext;
				}
			}
			if($ha[$h]['month']&&$_GET['datetype']=='month'){			
				$ha_month = explode(',', $ha[$h]['month']);
				$_GET['f_rangeStart'] = date('Y-m-d', mktime(0,0,0,date('m')-1,1,date('Y')));
				$_GET['f_rangeEnd'] = date('Y-m-d', mktime(23,59,59,date('m'),0,date('Y')));
				$_GET['cornreport_param']['username'] = $ha[$h]['monthusername'];
				$_GET['cornreport_param']['server'] = $ha[$h]['monthserver'];
				$_GET['cornreport_param']['ugroupid'] = $ha[$h]['monthugroupid'];
				$_GET['cornreport_param']['sgroupid'] = $ha[$h]['monthsgroupid'];
				for($i=0; $i<count($ha_month); $i++){
					$pos = strpos($ha_month[$i], '_');
					if($pos===false){
						$prev=$ha_month[$i];
					}else{
						$prev = substr($ha_month[$i], 0, $pos);
						if($pos+1<=strlen($ha_month[$i]))
							$back = substr($ha_month[$i], $pos+1);
					}
					//echo "month_".$ha_month[$i].'<br >';
					ob_start();
					switch($prev){
						case 'reportaudit':
							$_GET['number']=$back;
							$this->$prev();
							break;
						default:						
							$this->$prev();
							break;
							
					}
					$contents = ob_get_clean();
					file_put_contents("tmp/month_".$ha_month[$i].".".$ext, $contents);
				
					$savfile = $_CONFIG['REPORT_FILE_PATH']."month_".$ha_month[$i]."_".$_GET['f_rangeStart']."_".$_GET['f_rangeEnd'].".".$ext;
				
					copy("tmp/month_".$ha_month[$i].".".$ext, $savfile);
				
					$crf = new crontab_report_file();
				
					$crf->set_data('filepath', $savfile);
				
					$crf->set_data('title', $filename_a[$ha_month[$i]]);
				
					$crf->set_data('start', $_GET['f_rangeStart']);
				
					$crf->set_data('end', $_GET['f_rangeEnd']);
				
					$this->crontab_report_file_set->add($crf);
					$monthfile[]="tmp/month_".$ha_month[$i].".".$ext;
				}		
			}

			if($dayfile||$weekfile||$monthfile){
				require_once ROOT. './include/emailattachfile.php';
				$config = $this->config_set->base_select("SELECT * FROM alarm LIMIT 1");
			
				//$admin = $this->member_set->select_all("username='admin'");

				if($dayfile&&!empty($ha[$h]['dayusers'])){

					$e = new CSMTP($config[0]['MailServer'],"25",$config[0]['account'],$config[0]['password']);
	
					$e -> linkSMTP(); 
					$dayusers = $this->member_set->select_all("uid in(".$ha[$h]['dayusers'].")");
					for($j=0; $j<count($dayusers); $j++){
						if(!empty($dayusers[$j]['email']))
							$dayuseremail[]=$dayusers[$j]['email'];
					}
					$e -> buildMail($dayuseremail ,"报表" ,"报表附件中,请查收阅览","text/html"); 
					for($i=0; $i<count($dayfile); $i++){//echo $dayfile[$i];
						$tmpfilename = substr($dayfile[$i],strpos($dayfile[$i],"_")+1);
						$tmpfilename = substr($tmpfilename, 0, strpos($tmpfilename, "."));
						$tmpfilename = $filename_a[$tmpfilename].".".$ext;
						$e -> attachFile($dayfile[$i],'日报-'.$tmpfilename); 
					}			
					$e -> sendMail(); 
					$e -> quitSMTP();
				}

				if($weekfile&&!empty($ha[$h]['weekusers'])){
					$e = new CSMTP($config[0]['MailServer'],"25",$config[0]['account'],$config[0]['password']);
					$e -> linkSMTP(); 
					$weekusers = $this->member_set->select_all("uid in(".$ha[$h]['weekusers'].")");
					for($j=0; $j<count($weekusers); $j++){
						if(!empty($weekusers[$j]['email']))
							$weekuseremail[]=$weekusers[$j]['email'];
					}
					$e -> buildMail($weekuseremail ,"报表" ,"报表附件中,请查收阅览","text/html"); 
					for($i=0; $i<count($weekfile); $i++){//echo $weekfile[$i];
						$tmpfilename = substr($weekfile[$i],strpos($weekfile[$i],"_")+1);
						$tmpfilename = substr($tmpfilename, 0, strpos($tmpfilename, "."));
						$tmpfilename = $filename_a[$tmpfilename].".".$ext;
						$e -> attachFile($weekfile[$i],'周报-'.$tmpfilename); 
					}
					$e -> sendMail(); 
					$e -> quitSMTP();
				}


				if($monthfile&&!empty($ha[$h]['monthusers'])){

					$e = new CSMTP($config[0]['MailServer'],"25",$config[0]['account'],$config[0]['password']);
					$e -> linkSMTP();
					$monthusers = $this->member_set->select_all("uid in(".$ha[$h]['monthusers'].")");
					for($j=0; $j<count($monthusers); $j++){
						if(!empty($monthusers[$j]['email']))
							$monthuseremail[]=$monthusers[$j]['email'];
					}
					$e -> buildMail($monthuseremail ,"报表" ,"报表附件中,请查收阅览","text/html"); 
					for($i=0; $i<count($monthfile); $i++){
						$tmpfilename = substr($monthfile[$i],strpos($monthfile[$i],"_")+1);
						$tmpfilename = substr($tmpfilename, 0, strpos($tmpfilename, "."));
						$tmpfilename = $filename_a[$tmpfilename].".".$ext;
						$e -> attachFile($monthfile[$i],'月报-'.$tmpfilename); 
					}
					$e -> sendMail(); 
					$e -> quitSMTP();
				}
			}
		}
		//alert_and_back('操作成功');
	}


	function systemaccount(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$device_type = get_request('device_type', 0, 1);
		$login_method = get_request('login_method', 0, 1);
		$ip = get_request('ip', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'INET_ATON(a.device_ip)';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($device_type){
			$where .= " AND a.device_type ='".$device_type."'";
		}
		if($login_method){
			$where .= " AND a.login_method ='".$login_method."'";
		}
		if($ip){
			$where .= " AND a.device_ip like '%".$ip."%'";
		}
		
		if($_SESSION['ADMIN_LEVEL'] == 3|| $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
				for($i=0; $i<count($allips); $i++){
					$alltmpip[]=$allips[$i]['device_ip'];
				}
				if($alltmpip)
				$where .= " AND s.device_ip IN ('".implode("','", $alltmpip)."')";
			}
		}
		$alltem = $this->tem_set->select_all(" device_type = '' AND login_method IN('ssh','RDP','telnet','ftp','ssh1','vnc','x11','rlogin','apppub')", 'login_method', 'ASC');
		$alldevtype = $this->tem_set->select_all('login_method=""');
		$this->assign("alltem", $alltem);
		$this->assign("alldevtype", $alldevtype);
		
		$sql = "SELECT SQL_CALC_FOUND_ROWS a.*,b.login_method login_method_name,c.device_type device_type_name FROM ".$this->devpass_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." s ON a.device_ip=s.device_ip LEFT JOIN ".$this->tem_set->get_table_name()." b ON a.login_method=b.id LEFT JOIN ".$this->tem_set->get_table_name()." c ON a.device_type=c.id Where $where ORDER BY $orderby1 $orderby2 ,a.luser ASC";		
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			//$reports = $this->sessions_set->base_select($sql);
			$str = "日期:\t".$time_start."\t到\t".$time_end."\n";
			$str .= language("序号")."\t".language("服务器IP")."\t".language("主机名")."\t".language("系统")." \t".language("协议")." \t".language("系统用户")."\n";
			$id=1;
			$i=0;
			$f = @fopen('tmp/SystemAccountReport.xls', "wa+");
			@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;
				foreach ($reports AS $report){		
					$str .= ($id++)."\t".$report['device_ip']."\t".$report['hostname']."\t".$report['device_type_name']."\t".$report['login_method_name']."\t".$report['username'];
					$str .= "\n";
				}
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}
			fclose($f);
			go_url('tmp/SystemAccountReport.xls?'.time());
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemAccountReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==2){
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('systemaccount_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemAccountReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('systemaccount_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=SystemAccountReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}else if($derive==4){//pdf
			$reports = $this->sessions_set->base_select($sql);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','主机名'), iconv('UTF-8','GBK','系统'), iconv('UTF-8','GBK','协议'), iconv('UTF-8','GBK','系统用户'));
			$w = array(20, 36, 36, 36, 36, 36);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				//$data[$i++] = array($id++, $report['device_ip'], iconv('UTF-8','GBK',$report['hostname']), iconv('UTF-8','GBK',$report['device_type_name']), iconv('UTF-8','GBK',$report['login_method_name']), iconv('UTF-8','GBK',$report['username']));
				$pdf->Row(array(++$id, $report['device_ip'], iconv('UTF-8','GBK',$report['hostname']), iconv('UTF-8','GBK',$report['device_type_name']), iconv('UTF-8','GBK',$report['login_method_name']), iconv('UTF-8','GBK',$report['username'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}
loading_start();
		/*$sqlt = "SELECT COUNT(*) ct FROM ".$this->devpass_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." s ON a.device_ip=s.device_ip Where $where";		
		$row_num = $this->sessions_set->base_select($sqlt);	
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');*/
		if($page_num==1||empty($page_num)){
			$row_num=10000000;
		}elseif($_SESSION['app_priority_search_num']){
			$row_num = $_SESSION['app_priority_search_num'];
		}
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');

		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$reports = $this->sessions_set->base_select($sql);
		$_rows = $this->server_set->base_select("SELECT FOUND_ROWS() row_num");
		$_SESSION['app_priority_search_num']=$row_num = $_rows[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
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
		$this->assign('device_type', $device_type);
		$this->assign('login_method', $login_method);
		$this->assign('ip', $ip);
		$this->assign('reports', $reports);
		$this->assign('session_num', $row_num);
		$this->assign('number', $number);
loading_end();
		$this->display('systemaccount.tpl');
	}

	function appaccount(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($start)&&empty($end)){
			$start = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$end = date('Y-m-d');
		}
		if(empty($orderby1)){
			$orderby1 = 'a.device_ip';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		
		if($_SESSION['ADMIN_LEVEL'] == 3|| $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
				for($i=0; $i<count($allips); $i++){
					$alltmpip[]=$allips[$i]['device_ip'];
				}
				if($alltmpip)
				$where .= " AND s.device_ip IN ('".implode("','", $alltmpip)."')";
			}
		}

		
		$sql = "SELECT SQL_CALC_FOUND_ROWS b.*,IF(LENGTH(a.username)=0,'空用户',a.username) username FROM ".$this->appdevice_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." s ON a.device_ip=s.device_ip LEFT JOIN ".$this->apppub_set->get_table_name()." b ON a.apppubid=b.id WHERE b.id IS NOT NULL AND $where ORDER BY $orderby1 $orderby2 ,username ASC";		
		
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			//$reports = $this->sessions_set->base_select($sql);
			$str = "日期:\t".$time_start."\t到\t".$time_end."\n";
			$str .= language("序号")."\t".language("服务器IP")."\t".language("应用名称")."\t".language("应用路径")." \t".language("用户名")." \t".language("URL")."\n";
			$id=1;
			$i=0;
			$f = @fopen('tmp/AppAccountReport.xls', "wa+");
			@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;
				foreach ($reports AS $report){		
					$str .= ($id++)."\t".$report['appserverip']."\t".$report['name']."\t".$report['path']."\t".$report['username']."\t".$report['url'];
					$str .= "\n";
				}
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}
			fclose($f);
			go_url('tmp/AppAccountReport.xls?'.time());
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AppAccountReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==4){//pdf
			$reports = $this->sessions_set->base_select($sql);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','应用名称'), iconv('UTF-8','GBK','应用路径'), iconv('UTF-8','GBK','用户名'), iconv('UTF-8','GBK','URL'));
			$w = array(20, 36, 36, 36, 36, 36);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				//$data[$i++] = array($id++, $report['device_ip'], iconv('UTF-8','GBK',$report['hostname']), iconv('UTF-8','GBK',$report['device_type_name']), iconv('UTF-8','GBK',$report['login_method_name']), iconv('UTF-8','GBK',$report['username']));
				$pdf->Row(array(++$id, $report['appserverip'], iconv('UTF-8','GBK',$report['name']), iconv('UTF-8','GBK',$report['path']), iconv('UTF-8','GBK',$report['username']), iconv('UTF-8','GBK',$report['url'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('appaccount_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AppAccountReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('appaccount_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=AppAccountReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();
		/*$sqlt = "SELECT COUNT(*) ct FROM ".$this->appdevice_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." s ON a.device_ip=s.device_ip WHERE $where";
		$row_num = $this->sessions_set->base_select($sqlt);	
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');*/
		if($page_num==1||empty($page_num)){
			$row_num=10000000;
		}elseif($_SESSION['app_priority_search_num']){
			$row_num = $_SESSION['app_priority_search_num'];
		}
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$reports = $this->sessions_set->base_select($sql);
		$_rows = $this->server_set->base_select("SELECT FOUND_ROWS() row_num");
		$_SESSION['app_priority_search_num']=$row_num = $_rows[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
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
		$this->assign('session_num', $row_num);
		$this->assign('reports', $reports);
		$this->assign('number', $number);
loading_end();
		$this->display('appaccount.tpl');
	}

	function systempriority_search() {
		$member = $this->member_set->select_all('1'.($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' :' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''), 'username', 'asc');
		$lm = $this->tem_set->select_all('device_type=""', 'login_method', 'asc');
	
		$forbiddengps = $this->forbiddengps_set->select_all('1', 'gname', 'asc');
		$weektime = $this->weektime_set->select_all('1', 'policyname', 'asc');
		$sourceip = $this->sourceip_set->select_all('1', 'groupname', 'asc');
		
		$this->assign('member', $member);
		$this->assign('forbiddengps', $forbiddengps);
		$this->assign('weektime', $weektime);
		$this->assign('sourceip', $sourceip);
		$this->assign('usergroup', $usergroup);
		$this->assign('lm', $lm);
		$this->assign("allgroup", $allgroup);
		$this->display('systempriority_search.tpl');

	}

	function systempriority(){
		global $_CONFIG;
		$back = get_request('back');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$page_num = get_request('page');
		$derive = get_request('derive');
		$ip = get_request('ip',1,1) ? get_request('ip',1,1) : get_request('ip',0,1);
		$s_user = get_request('s_user',1,1) ? get_request('s_user',1,1) : get_request('s_user',0,1);
		$user = get_request('user',1,1) ? get_request('user',1,1) : get_request('user',0,1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$type='luser';
		if(empty($orderby1)){
			$orderby1 = 'device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$where = "1";
		if($ip){
			$where .= " AND devices.device_ip like '%$ip%'";
		}
		if($s_user){
			$where .= " AND devices.username like '%$s_user%'";
		}
		if($user){
			$where .= " AND member.username = '$user'";
		}
		if($_SESSION['ADMIN_LEVEL'] == 3|| $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				if($_CONFIG['DEPART_ADMIN']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
					if($alltmpip)
					$where .= " AND devices.device_ip IN ('".implode("','", $alltmpip)."')";
				}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND member.username IN ('".implode("','", $alltmpuser)."')";
				}
			}
		}

		$sql  = "select SQL_CALC_FOUND_ROWS tt.*,sg.groupname,s.hostname,lt.login_method from (select distinct 1 orderby,0 resourceid, member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceipv6,luser.devicesid,devices.device_ip,devices.username,devices.login_method lmethod,devices.device_type,luser.forbidden_commands_groups,luser.weektime,luser.sourceip,luser.autosu,luser.syslogalert,luser.mailalert,luser.loginlock from luser left join member on luser.memberid=member.uid left join devices on luser.devicesid=devices.id where member.uid and luser.devicesid AND $where";		
		$sql .= " union select distinct 2 orderby, a.resourceid, member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceipv6,t.devicesid,devices.device_ip,devices.username,devices.login_method lmethod,devices.device_type,a.forbidden_commands_groups,a.weektime,a.sourceip,a.autosu,a.syslogalert,a.mailalert,a.loginlock from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid>0 ) t on a.resourceid=t.id left join member on a.memberid=member.uid left join devices on t.devicesid=devices.id where t.id and member.uid and t.devicesid AND $where";
		$sql .= " union select distinct 2 orderby, a.resourceid, member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceipv6,devices.id devicesid,devices.device_ip,devices.username,devices.login_method lmethod,devices.device_type,a.forbidden_commands_groups,a.weektime,a.sourceip,a.autosu,a.syslogalert,a.mailalert,a.loginlock from luser_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join member on a.memberid=member.uid left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where";
		$sql .= " union select distinct 3 orderby, 0, member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceipv6,lgroup.devicesid,devices.device_ip,devices.username,devices.login_method lmethod,devices.device_type,lgroup.forbidden_commands_groups,lgroup.weektime,lgroup.sourceip,lgroup.autosu,lgroup.syslogalert,lgroup.mailalert,lgroup.loginlock from lgroup left join member on lgroup.groupid=member.groupid left join devices on lgroup.devicesid=devices.id where member.uid and lgroup.devicesid AND $where";
		$sql .= " union select distinct 4 orderby, a.resourceid, member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceipv6,t.devicesid,devices.device_ip,devices.username,devices.login_method lmethod,devices.device_type,a.forbidden_commands_groups,a.weektime,a.sourceip,a.autosu,a.syslogalert,a.mailalert,a.loginlock from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid>0 ) t on a.resourceid=t.id left join member on a.groupid=member.groupid left join devices on t.devicesid=devices.id where t.id and member.uid and t.devicesid AND $where ";
		$sql .= " union select distinct 4 orderby, a.resourceid, member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,member.sourceipv6,devices.id devicesid,devices.device_ip,devices.username,devices.login_method lmethod,devices.device_type,a.forbidden_commands_groups,a.weektime,a.sourceip,a.autosu,a.syslogalert,a.mailalert,a.loginlock from lgroup_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join member on a.groupid=member.groupid left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and devices.id AND $where ";
		$sql .= ") tt left join login_template lt on tt.lmethod=lt.id left join servers s on tt.device_ip=s.device_ip left join servergroup sg on sg.id=tt.groupid group by tt.uid,tt.devicesid";
		if($derive==1){
			//$reports = $this->server_set->base_select($sql);
			$str = language("序号")."\t".(($type == 'luser') ? '运维账号'."\t".'别名'."\t运维组" : '运维组')."\t".language("设备IP")."\t".language("系统用户")." \t".language("黑名单")." \t".language("来源IPv4")." \t".language("来源IPv6")." \t".language("自动为超级用户")." \t".language("SYSLOG告警")." \t".language("Mail告警")." \t".language("账号锁定")."\t".(($type == 'luser') ? '上次登录'." \t" : '').language("协议")."\n";
			$id=1;
			$i=0;
			$f = @fopen('tmp/SystemPriorityReport.xls', "wa+");
			@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." ORDER BY $orderby1 $orderby2, device_ip ASC, username ASC, webuser ASC LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;				
				//$reports=$this->systempriority_data($reports);
				foreach ($reports AS $report){
					$str .= ($id++)."\t".(($type == 'luser') ? $report['webuser']."\t".$report['webrealname']."\t".$report['usergroup'] :$report['gname'])."\t".$report['device_ip'].'('.$report['hostname'].')'."\t".$report['username']."\t".$report['forbidden_commands_groups']."\t".$report['sourceip']."\t".$report['sourceipv6']."\t".($report['autosu'] ? '是' : '否')."\t".($report['syslogalert'] ? '是' : '否')."\t".($report['mailalert'] ? '是' : '否')."\t".($report['loginlock'] ? '是' : '否')."\t".(($type == 'luser') ? $report['lastdate']." \t" : '').$report['login_method'];
					$str .= "\n";
				}
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}
			fclose($f);
			go_url('tmp/SystemPriorityReport.xls?'.time());
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemPriorityReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==4){
			$reports = $this->sessions_set->base_select($sql);
			$reports=$this->systempriority_data($reports);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维账号'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','设备IP'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','黑名单'), iconv('UTF-8','GBK','来源IPv4'), iconv('UTF-8','GBK','来源IPv6'), iconv('UTF-8','GBK','自动为超级用户'), iconv('UTF-8','GBK','SYSLOG告警'), iconv('UTF-8','GBK','Mail告警'), iconv('UTF-8','GBK','账号锁定'), iconv('UTF-8','GBK','上次登录'), iconv('UTF-8','GBK','协议'));
			$w = array(10, 14, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 14);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, iconv('UTF-8','GBK',$report['webuser']), iconv('UTF-8','GBK',$report['webrealname']), iconv('UTF-8','GBK',$report['device_ip'].'('.$report['hostname'].')'), iconv('UTF-8','GBK',$report['username']), iconv('UTF-8','GBK',$report['forbidden_commands_groups']), iconv('UTF-8','GBK',$report['sourceip']), iconv('UTF-8','GBK',$report['sourceipv6']), iconv('UTF-8','GBK',($report['autosu'] ? '是' : '否')), iconv('UTF-8','GBK',($report['syslogalert'] ? '是' : '否')), iconv('UTF-8','GBK',($report['mailalert'] ? '是' : '否')), iconv('UTF-8','GBK',($report['loginlock'] ? '是' : '否')), iconv('UTF-8','GBK',$report['lastdate']), iconv('UTF-8','GBK',$report['login_method'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->sessions_set->base_select($sql);
			$reports=$this->systempriority_data($reports);
			ob_start();
			$this->assign('alldev', $reports);
			$this->assign('type', $type);
			$this->assign('ip', $ip);
			$this->assign('s_user', $s_user);
			$this->assign('user', $user);
			$this->assign('group', $group);
			$this->display('systempriority_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemPriorityReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			$reports=$this->systempriority_data($reports);
			ob_start();$this->assign('alldev', $reports);
			$this->assign('type', $type);
			$this->assign('ip', $ip);
			$this->assign('s_user', $s_user);
			$this->assign('user', $user);
			$this->assign('group', $group);
			$this->display('systempriority_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=SystemPriorityReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();
		if($page_num==1||empty($page_num)){
			$row_num=10000000;
		}elseif($_SESSION['dev_priority_search_num']){
			$row_num = $_SESSION['dev_priority_search_num'];
		}
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql .= " ORDER BY $orderby1 $orderby2, device_ip ASC, username ASC, webuser ASC LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$alldev = $this->server_set->base_select($sql);
		$_rows = $this->server_set->base_select("SELECT FOUND_ROWS() row_num");
		$_SESSION['dev_priority_search_num']=$row_num = $_rows[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev=$this->systempriority_data($alldev);
		
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
		//echo '<pre>';print_r($alldev);echo '</pre>';
		$this->assign('curr_url', $curr_url);
		$this->assign('title', language('服务器列表'));
		$this->assign('alldev', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('type', $type);
		$this->assign('ip', $ip);
		$this->assign('s_user', $s_user);
		$this->assign('user', $user);
		$this->assign('group', $group);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
loading_end();
		$this->display('systempriority.tpl');
	}

	function systempriority_data($alldev){
		$num = count($alldev);
		$lm = $this->tem_set->select_all();
		for($i=0; $i<$num; $i++){
			foreach($lm as $tem) {
				if($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}elseif($alldev[$i]['device_type'] == $tem['id']) {
					$alldev[$i]['device_type'] = $tem['device_type'];
				}
			}
			if($alldev[$i]['groupid']){
				$usergroup = $this->usergroup_set->select_by_id($alldev[$i]['groupid']);
				$alldev[$i]['usergroup'] = $usergroup['groupname'];
			}
			$rowsql = "select 1 orderby,a.memberid,0 groupid,a.devicesid,0 resourceid,a.forbidden_commands_groups,a.sourceip,a.weektime from luser a where memberid=".$alldev[$i]['uid']." AND devicesid=".$alldev[$i]['devicesid'];
			$rowsql .= " UNION select 2 orderby,a.memberid,0,0,a.resourceid,a.forbidden_commands_groups,a.sourceip,a.weektime from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=".$alldev[$i]['devicesid'].") t on a.resourceid=t.id left join member on a.memberid=member.uid where t.id and member.uid=".$alldev[$i]['uid']." and t.devicesid";
			$rowsql .= " UNION select 2 orderby,a.memberid,0,0,a.resourceid,a.forbidden_commands_groups,a.sourceip,a.weektime from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.memberid=".$alldev[$i]['uid']." AND devices.id=".$alldev[$i]['devicesid'];
			$rowsql .= " UNION select 3 orderby,0,a.groupid,a.devicesid,0,a.forbidden_commands_groups,a.sourceip,a.weektime from lgroup a where groupid=".$alldev[$i]['groupid']." AND devicesid=".$alldev[$i]['devicesid'];
			$rowsql .= " UNION select 4 orderby,0,a.groupid,0,a.resourceid,a.forbidden_commands_groups,a.sourceip,a.weektime from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=".$alldev[$i]['devicesid'].") t on a.resourceid=t.id left join member on a.groupid=member.groupid where t.id and member.uid=".$alldev[$i]['uid']." and t.devicesid";
			$rowsql .= " UNION select 4 orderby,0,a.groupid,0,a.resourceid,a.forbidden_commands_groups,a.sourceip,a.weektime from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.groupid=".$alldev[$i]['groupid']." AND devices.id=".$alldev[$i]['devicesid'];
			$rowsql .= " order by orderby asc limit 1";
			$row = $this->luser_set->base_select($rowsql);
			/*
			if($row = $this->luser_set->select_all(" memberid=".$alldev[$i]['uid']." AND devicesid=".$alldev[$i]['devicesid'])){
			}else if($row = $this->luser_set->base_select("select a.* from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=".$alldev[$i]['devicesid'].") t on a.resourceid=t.id left join member on a.memberid=member.uid where t.id and member.uid=".$alldev[$i]['uid']." and t.devicesid")){
			}else if($row = $this->luser_set->base_select("select a.* from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.memberid=".$alldev[$i]['uid']." AND devices.id=".$alldev[$i]['devicesid']."")){
			}else if($row = $this->lgroup_set->select_all(" groupid=".$alldev[$i]['groupid']." AND devicesid=".$alldev[$i]['devicesid'])){
			}else if($row = $this->luser_set->base_select("select a.* from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=".$alldev[$i]['devicesid'].") t on a.resourceid=t.id left join member on a.groupid=member.groupid where t.id and member.uid=".$alldev[$i]['uid']." and t.devicesid")){
			}else if($row = $this->luser_set->base_select("select a.* from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.groupid=".$alldev[$i]['groupid']." AND devices.id=".$alldev[$i]['devicesid']."")){
			}*/
			$row[0]['sourceip'] = $alldev[$i]['sourceip'];
			
			$alldev[$i] = array_merge($alldev[$i], $row[0]);
			//var_dump($alldev[$i]);echo '<br>';echo '<br>';
		}
		return $alldev;
	}

	function apppriority_search() {
		if ($_SESSION['ADMIN_LEVEL'] != 1) {
            $devs = $_SESSION['DEVS'];
            $this->assign('alldev', $this->dev_set->select_all());
        } else {
            $this->assign('alldev', $this->dev_set->select_all());
        }
		$member = $this->member_set->select_all('1'.($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' :' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''), 'username', 'asc');
		$lm = $this->tem_set->select_all('device_type=""', 'login_method', 'asc');
		$appservers = $this->appserver_set->select_all('1'/*.($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND appserverip IN(SELECT device_ip FROM servers WHERE 1 '. ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '').' AND groupid='.$_SESSION['ADMIN_MSERVERGROUP'].' or groupid IN(SELECT id FROM '.$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$_SESSION['ADMIN_MSERVERGROUP'].')))' : '').""*/, 'name', 'asc');
		$this->assign('member', $member);
		$this->assign('usergroup', $usergroup);
		$this->assign('lm', $lm);
		$this->assign('appservers', $appservers);
		$this->display('apppriority_search.tpl');
	}

	function apppriority(){
		global $_CONFIG;
		$back = get_request('back');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$page_num = get_request('page');
		$derive = get_request('derive');
		$device_ip = get_request('device_ip',1,1) ? get_request('device_ip',1,1) : get_request('device_ip',0,1);
		$appserverip = get_request('appserverip',1,1) ? get_request('appserverip',1,1) : get_request('appserverip',0,1);
		$s_user = get_request('s_user',1,1) ? get_request('s_user',1,1) : get_request('s_user',0,1);
		$user = get_request('user',1,1) ? get_request('user',1,1) : get_request('user',0,1);		
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'appserverip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		if(empty($type)){
			$type='luser';
		}
		
		$where = "1";
		if($appserverip != '') {
			$where .= " AND apppub.appserverip LIKE '%$appserverip%'";
		}
		if($s_user != '') {
			$where .= " AND appdevices.username= '$s_user'";
		}
		if($user != '') {				
			$member = $this->member_set->select_all(" username='".$user."'");
			$member = $member[0];
			if(empty($member)){
				alert_and_back('该用户不存在 ','admin.php?controller=admin_pro&action=app_priority_search');
				exit;
			}
			$where .= " AND member.uid=".$member['uid'];
		}

		if($_SESSION['ADMIN_LEVEL'] == 3|| $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				if($_CONFIG['DEPART_ADMIN']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
					if($alltmpip)
					$where .= " AND appdevices.device_ip IN ('".implode("','", $alltmpip)."') ";
				}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND member.username IN ('".implode("','", $alltmpuser)."')";
				}
			}
		}

		$sql  = "select SQL_CALC_FOUND_ROWS distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,appmember.appdeviceid,apppub.appserverip,apppub.name appname,appdevices.username,appdevices.change_password,appdevices.enable,appdevices.device_ip from appmember left join member on appmember.memberid=member.uid left join appdevices on appmember.appdeviceid=appdevices.id left join apppub on appdevices.apppubid=apppub.id where member.uid and appmember.appdeviceid AND $where";		
		$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,t.appdevicesid,apppub.appserverip,apppub.name appname,appdevices.username,appdevices.change_password,appdevices.enable,appdevices.device_ip from luser_appresourcegrp a left join (select a.id,b.appdevicesid from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid>0 ) t on a.appresourceid=t.id left join member on a.memberid=member.uid left join appdevices on t.appdevicesid=appdevices.id left join apppub on appdevices.apppubid=apppub.id where t.id and member.uid and t.appdevicesid AND $where";
		$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,appdevices.id appdeviceid,apppub.appserverip,apppub.name appname,appdevices.username,appdevices.change_password,appdevices.enable,appdevices.device_ip from luser_appresourcegrp a left join (select a.id,b.groupid,b.username from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid  left join member on a.memberid=member.uid left join appdevices on s.device_ip=appdevices.device_ip left join apppub on appdevices.apppubid=apppub.id where t.id and appdevices.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) AND $where";
		$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,appgroup.appdeviceid,apppub.appserverip,apppub.name appname,appdevices.username,appdevices.change_password,appdevices.enable,appdevices.device_ip from appgroup left join member on appgroup.groupid=member.groupid left join appdevices on appgroup.appdeviceid=appdevices.id left join apppub on appdevices.apppubid=apppub.id where member.uid and appgroup.appdeviceid AND $where";
		$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,t.appdevicesid,apppub.appserverip,apppub.name appname,appdevices.username,appdevices.change_password,appdevices.enable,appdevices.device_ip from lgroup_appresourcegrp a left join (select a.id,b.appdevicesid from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid>0 ) t on a.appresourceid=t.id left join member on a.groupid=member.groupid left join appdevices on t.appdevicesid=appdevices.id left join apppub on appdevices.apppubid=apppub.id where t.id and member.uid and t.appdevicesid AND $where";
		$sql .= " union select distinct member.uid,member.username webuser,member.realname webrealname,member.groupid,member.lastdate,appdevices.id appdeviceid,apppub.appserverip,apppub.name appname,appdevices.username,appdevices.change_password,appdevices.enable,appdevices.device_ip from lgroup_appresourcegrp a left join (select a.id,b.groupid,b.username from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid  left join member on a.groupid=member.groupid left join appdevices on s.device_ip=appdevices.device_ip left join apppub on appdevices.apppubid=apppub.id where t.id and appdevices.id and member.uid and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) AND $where";

		

		if($derive==1){
			//$reports = $this->server_set->base_select($sql);
			$str = language("序号")."\t".(($type == 'luser') ? '运维账号'."\t".'别名' : '运维组')."\t".(($type == 'luser') ? '运维组'."\t" : '').language("设备IP")."\t".language("应用发布IP")." \t".language("应用名称")." \t".language("应用用户名")." \t".language("自动修改密码")." \t".language("激活")."\n";
			$id=1;
			$i=0;
			$f = @fopen('tmp/AppPriorityReport.xls', "wa+");
			@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." ORDER BY $orderby1 $orderby2, appserverip ASC, username ASC, webuser ASC  LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;				
				$reports=$this->apppriority_data($reports);
				foreach ($reports AS $report){		
					$str .= ($id++)."\t".(($type == 'luser') ? $report['webuser']."\t".$report['webrealname'] :$report['gname'])."\t".(($type == 'luser') ? $report['usergroup']."\t" :'').$report['device_ip']."\t".$report['appserverip']."\t".$report['appname']."\t".$report['username']."\t".($report['change_password'] ? '是' : '否')."\t".($report['enable'] ? '是' : '否');
					$str .= "\n";
				}
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}
			fclose($f);
			go_url('tmp/AppPriorityReport.xls?'.time());
				/*
				Header('Cache-Control: private, must-revalidate, max-age=0');
				Header("Content-type: application/octet-stream"); 
				Header("Content-Disposition: attachment; filename=AppPriorityReport.xls"); 
				echo mb_convert_encoding($str, "GBK", "UTF-8");
				*/
			exit();
		}else if($derive==4){
			$reports = $this->server_set->base_select($sql);
			$reports=$this->apppriority_data($reports);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维账号'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','设备IP'), iconv('UTF-8','GBK','应用发布IP'), iconv('UTF-8','GBK','应用名称'), iconv('UTF-8','GBK','应用用户名'), iconv('UTF-8','GBK','自动修改密码'), iconv('UTF-8','GBK','激活'));
			$w = array(12, 22, 22, 19, 22, 22, 22, 22, 22, 12);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				//$data[$i++] = array($id++, $report['device_ip'], iconv('UTF-8','GBK',$report['hostname']), iconv('UTF-8','GBK',$report['device_type_name']), iconv('UTF-8','GBK',$report['login_method_name']), iconv('UTF-8','GBK',$report['username']));
				$pdf->Row(array(++$id, $report['webuser'], iconv('UTF-8','GBK',$report['webrealname']), iconv('UTF-8','GBK',$report['usergroup']), iconv('UTF-8','GBK',$report['device_ip']), iconv('UTF-8','GBK',$report['appserverip']), iconv('UTF-8','GBK',$report['appname']), iconv('UTF-8','GBK',$report['username']), iconv('UTF-8','GBK',($report['change_password'] ? '是' : '否')), iconv('UTF-8','GBK',($report['enable'] ? '是' : '否'))), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->sessions_set->base_select($sql);
			$reports=$this->apppriority_data($reports);
			ob_start();
			$this->assign('alldev', $reports);
			$this->assign('type', $type);
			$this->assign('ip', $ip);
			$this->assign('s_user', $s_user);
			$this->assign('user', $user);
			$this->assign('group', $group);
			$this->display('apppriority_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemPriorityReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			$reports=$this->apppriority_data($reports);
			ob_start();
			$this->assign('alldev', $reports);
			$this->assign('type', $type);
			$this->assign('ip', $ip);
			$this->assign('s_user', $s_user);
			$this->assign('user', $user);
			$this->assign('group', $group);
			$this->display('apppriority_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=SystemPriorityReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();
		if($page_num==1||empty($page_num)){
			$row_num=10000000;
		}elseif($_SESSION['app_priority_search_num']){
			$row_num = $_SESSION['app_priority_search_num'];
		}
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql .= " ORDER BY $orderby1 $orderby2, appserverip ASC, username ASC, webuser ASC LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$alldev = $this->server_set->base_select($sql);
		$_rows = $this->server_set->base_select("SELECT FOUND_ROWS() row_num");
		$_SESSION['app_priority_search_num']=$row_num = $_rows[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev=$this->apppriority_data($alldev);

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		//echo '<pre>';print_r($alldev);echo '</pre>';
		$this->assign('curr_url', $curr_url);
		$this->assign('title', language('服务器列表'));
		$this->assign('alldev', $alldev);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('type', $type);
		$this->assign('ip', $ip);
		$this->assign('s_user', $s_user);
		$this->assign('user', $user);
		$this->assign('group', $group);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
loading_end();
		$this->display('apppriority.tpl');

	}

	function apppriority_data($alldev){
		$num = count($alldev);
		for($i=0; $i<$num; $i++){
			if($alldev[$i]['groupid']){
				$usergroup = $this->usergroup_set->select_by_id($alldev[$i]['groupid']);
				$alldev[$i]['usergroup'] = $usergroup['GroupName'];
			}
			if($row = $this->appmember_set->select_all(" memberid=".$alldev[$i]['uid']." AND appdeviceid=".$alldev[$i]['appdeviceid'])){
				$alldev[$i]['orderby']=1;
			}else if($row = $this->appmember_set->base_select("select a.* from luser_appresourcegrp a left join (select a.id,b.appdevicesid from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 AND b.appdevicesid=".$alldev[$i]['appdeviceid'].") t on a.appresourceid=t.id left join member on a.memberid=member.uid where t.id and member.uid=".$alldev[$i]['uid']." and t.appdevicesid")){				
				$alldev[$i]['orderby']=2;
			}else if($row = $this->luser_set->base_select("select a.* from ".$this->luser_appresourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->appresgroup_set->get_table_name()." a left join ".$this->appresgroup_set->get_table_name()." b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid left join appdevices on appdevices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) and a.memberid=".$alldev[$i]['uid']." AND appdevices.id=".$alldev[$i]['appdeviceid']."")){
				$alldev[$i]['orderby'] = 2;
			}else if($row = $this->appgroup_set->select_all(" groupid=".$alldev[$i]['groupid']." AND appdeviceid=".$alldev[$i]['appdeviceid'])){
				$alldev[$i]['orderby']=3;
			}else if($row = $this->appmember_set->base_select("select a.* from lgroup_appresourcegrp a left join (select a.id,b.appdevicesid from appresourcegroup a left join appresourcegroup b on a.appgroupname=b.appgroupname where a.appdevicesid=0 AND b.appdevicesid=".$alldev[$i]['appdeviceid'].") t on a.appresourceid=t.id left join member on a.groupid=member.groupid where t.id and member.uid=".$alldev[$i]['uid']." and t.appdevicesid")){
				$alldev[$i]['orderby']=4;
			}else if($row = $this->luser_set->base_select("select a.* from ".$this->lgroup_appresourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->appresgroup_set->get_table_name()." a left join ".$this->appresgroup_set->get_table_name()." b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid left join appdevices on appdevices.device_ip=s.device_ip where t.id and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) and a.groupid=".$alldev[$i]['groupid']." AND appdevices.id=".$alldev[$i]['appdeviceid']."")){
				$alldev[$i]['orderby'] = 4;
			}
			if(is_array($row[0]))
			$alldev[$i] = array_merge($alldev[$i], $row[0]);
			//var_dump($alldev[$i]);echo '<br>';echo '<br>';
		}
		return $alldev;
	}

	function admin_log() {
		$page_num = get_request('page');
		$luser = get_request('luser', 1, 1);
		$operation = get_request('operation', 1, 1);
		$administrator = get_request('administrator', 1, 1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$derive = get_request('derive', 0, 1);
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$administrator = get_request('administrator', 0, 1);
		$luser = get_request('luser', 0, 1);
		$resource_user = get_request('resource_user', 0, 1);
		$resource = get_request('resource', 0, 1);
		$actions = get_request('actions', 0, 1);
		if(empty($start)&&empty($end)){
			$start = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$end = date('Y-m-d');
		}
		$where = '1=1';
		if($start){
			$where .= " AND optime >='".$start." 00:00:00'";
		}
		if($end){
			$where .= " AND optime <='".$end." 23:59:59'";
		}
		
		if(empty($orderby1)){
			$orderby1 = 'optime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		if($luser){
			$where .= " AND luser like '%$luser%'" ;
		}
		if($operation){
			$where .= " AND action='$operation'" ;
		}
		if($administrator){
			$where .= " AND administrator like '%$administrator%'" ;
		}
		if($resource_user){
			$where .= " AND resource_user like '%$resource_user%'" ;
		}
		if($usergroup){
			$where .= " AND c.id='$usergroup'" ;
		}
		if($resource){
			$where .= " AND resource like '%$resource%'" ;
		}
		if($actions){
			switch($actions){
				case 'add':
					$actionstr = '增加';
				break;
				case 'edit':
					$actionstr = '编辑';
				break;
				case 'del':
					$actionstr = '删除';
				break;
			}
			$where .= " AND `action` like '%$actionstr%'" ;
		}
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			$where .= ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0 ' : " AND luser IN( SELECT username FROM ".$this->member_set->get_table_name()." WHERE groupid =".$_SESSION['ADMIN_MUSERGROUP'].") ");
		}
		
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			//$reports=$this->admin_log_set->select_all($where, $orderby1, $orderby2);
			$sql = "SELECT a.*,b.realname,c.groupname FROM ".$this->admin_log_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." b ON a.luser=b.username LEFT JOIN ".$this->usergroup_set->get_table_name()." c ON b.groupid=c.id  WHERE $where ORDER BY $orderby1 $orderby2";
			//$reports = $this->admin_log_set->base_select("SELECT a.*,b.realname,c.groupname FROM ".$this->admin_log_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." b ON a.luser=b.username LEFT JOIN ".$this->usergroup_set->get_table_name()." c ON b.groupid=c.id  WHERE $where ORDER BY $orderby1 $orderby2");
			$str = "日期:\t".$start."\t到\t".$end."\n";
			$str .= language("序号")."\t".language("管理员")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("操作")." \t".language("资源")." \t".language("资源用户")." \t".language("操作时间")."\n";
			$id=1;
			$i=0;
			$f = @fopen('tmp/AdminLogReport.xls', "wa+");
			@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;
				foreach ($reports AS $report){		
					$str .= ($id++)."\t".$report['administrator']."\t".(!empty($report['luser']) ? $report['luser']."\t" : "\t").$report['realname']."\t".$report['groupname']."\t".$report['action']."\t".$report['resource']."\t".$report['resource_user']."\t".$report['optime'];
					$str .= "\n";
				}
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}
			fclose($f);
			go_url('tmp/AdminLogReport.xls?'.time());
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AdminLogReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==4){
			
			$reports = $this->admin_log_set->base_select("SELECT a.*,b.realname,c.groupname FROM ".$this->admin_log_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." b ON a.luser=b.username LEFT JOIN ".$this->usergroup_set->get_table_name()." c ON b.groupid=c.id  WHERE $where ORDER BY $orderby1 $orderby2");
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','管理员'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','操作'), iconv('UTF-8','GBK','资源'), iconv('UTF-8','GBK','资源用户'), iconv('UTF-8','GBK','操作时间'));
			$w = array(20, 22, 22, 22, 22, 22, 22, 22, 22);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, $report['administrator'], iconv('UTF-8','GBK',$report['luser']), iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['action']), iconv('UTF-8','GBK',$report['resource']), iconv('UTF-8','GBK',$report['resource_user']), iconv('UTF-8','GBK',$report['optime'])), $fill);
				$fill = !$fill;
			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			//$reports=$this->admin_log_set->select_all($where, $orderby1, $orderby2);
			$reports = $this->admin_log_set->base_select("SELECT a.*,b.realname,c.groupname FROM ".$this->admin_log_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." b ON a.luser=b.username LEFT JOIN ".$this->usergroup_set->get_table_name()." c ON b.groupid=c.id WHERE $where ORDER BY $orderby1 $orderby2");
			ob_start();
			$this->assign('alldev', $reports);
			$this->assign('type', $type);
			$this->assign('ip', $ip);
			$this->assign('s_user', $s_user);
			$this->assign('user', $user);
			$this->assign('group', $group);
			$this->display('adminlog_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AdminLogReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){//word
			$reports = $this->admin_log_set->base_select("SELECT a.*,b.realname,c.groupname FROM ".$this->admin_log_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." b ON a.luser=b.username LEFT JOIN ".$this->usergroup_set->get_table_name()." c ON b.groupid=c.id WHERE $where ORDER BY $orderby1 $orderby2");
			ob_start();
			$this->assign('alldev', $reports);
			$this->assign('type', $type);
			$this->assign('ip', $ip);
			$this->assign('s_user', $s_user);
			$this->assign('user', $user);
			$this->assign('group', $group);
			$this->display('adminlog_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=AdminLogReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();
		/*$row_num = $this->admin_log_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		*/
		if($page_num==1||empty($page_num)){
			$row_num=10000000;
		}elseif($_SESSION['app_priority_search_num']){
			$row_num = $_SESSION['app_priority_search_num'];
		}
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$allmember = $this->admin_log_set->base_select("SELECT SQL_CALC_FOUND_ROWS a.*,b.realname,c.groupname FROM ".$this->admin_log_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." b ON a.luser=b.username LEFT JOIN ".$this->usergroup_set->get_table_name()." c ON b.groupid=c.id WHERE $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		//$allmember = $this->admin_log_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$where, $orderby1, $orderby2);
		$_rows = $this->server_set->base_select("SELECT FOUND_ROWS() row_num");
		$_SESSION['app_priority_search_num']=$row_num = $_rows[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');		$this->assign('usergroup', $usergroup);

		$this->assign('usergroup', $usergroup);

		//echo '<pre>';print_r($alldev);echo '</pre>';
		$this->assign('curr_url', $curr_url);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		

		$this->assign('allmember', $allmember);
loading_end();
		$this->display('adminlog_report.tpl');
	}

	function devloginreport(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$usergroup = get_request('usergroup', 0, 1);
		if(empty($start)&&empty($end)){
			$start = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$end = date('Y-m-d');
		}
		if(empty($orderby1)){
			$orderby1 = 'ct';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($start){
			$where .= " AND start >='".$start." 00:00:00'";
		}
		if($end){
			$where .= " AND start <='".$end." 23:59:59'";
		}


		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
				}
		}

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
		}		
		
		$sql = "SELECT a.luser,m.realname,m.groupid,a.type,a.user,if(locate(':',addr)=0, addr,left(addr, locate(':',addr)-1)) device_ip, MIN(start) mstart, MAX(start) mend,IFNULL(COUNT(*),0) ct FROM ".$this->sessions_set->get_table_name()." a LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->commands_set->get_table_name()."  GROUP BY sid) bb ON bb.sid=a.sid LEFT JOIN ".$this->member_set->get_table_name()." m ON a.luser=m.username WHERE $where ".($cronreport_alltmpip[0] ? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')" : "").(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? " AND ".($_CONFIG['DEPART_ADMIN'] ? "LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : "luser IN('".implode("','", $alltmpuser)."')") : '')." GROUP BY if(locate(':',addr)=0, addr,left(addr, locate(':',addr)-1)),user,luser,type";
		$sql .= " UNION SELECT a1.luser,m.realname,m.groupid,a1.type,a1.user,if(locate(':',addr)=0, addr,left(addr, locate(':',addr)-1)) device_ip, MIN(start) mstart, MAX(start) mend,IFNULL(COUNT(*),0) ct FROM ".$this->rdp_set->get_table_name()." a1 LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->rdpinput_set->get_table_name()."  GROUP BY sid) bb1 ON bb1.sid=a1.sid LEFT JOIN ".$this->member_set->get_table_name()." m ON a1.luser=m.username WHERE $where ".($cronreport_alltmpip[0] ? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')" : "").(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : '')." GROUP BY if(locate(':',addr)<0, addr,left(addr, locate(':',addr)-1)),user,luser,type";
		$sql .= " UNION SELECT a2.radius_user luser,m.realname,m.groupid,'sftp' type,a2.sftp_user user,if(locate(':',svraddr)=0, svraddr,left(svraddr, locate(':',svraddr)-1)) device_ip, MIN(start) mstart, MAX(start) mend,IFNULL(COUNT(*),0) ct FROM ".$this->sftpsession_set->get_table_name()." a2 LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->sftpcmd_set->get_table_name()."  GROUP BY sid) bb2 ON bb2.sid=a2.sid LEFT JOIN ".$this->member_set->get_table_name()." m ON a2.radius_user=m.username WHERE $where ".($cronreport_alltmpip[0] ? " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $cronreport_alltmpip)."')" : "").(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? " AND ".($_CONFIG['DEPART_ADMIN'] ? "LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $alltmpip)."')" : "radius_user IN('".implode("','", $alltmpuser)."')") : '')." GROUP BY if(locate(':',svraddr)=0, svraddr,left(svraddr, locate(':',svraddr)-1)),sftp_user,radius_user";
		$sql .= " UNION SELECT a3.radius_user luser,m.realname,m.groupid,'ftp' type,a3.ftp_user user,if(locate(':',svraddr)=0, svraddr,left(svraddr, locate(':',svraddr)-1)) device_ip, MIN(start) mstart, MAX(start) mend,IFNULL(COUNT(*),0) ct FROM ".$this->ftpsession_set->get_table_name()." a3 LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->ftpcmd_set->get_table_name()."  GROUP BY sid) bb3 ON bb3.sid=a3.sid LEFT JOIN ".$this->member_set->get_table_name()." m ON a3.radius_user=m.username WHERE $where ".($cronreport_alltmpip[0] ? " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $cronreport_alltmpip)."')" : "").(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? " AND ".($_CONFIG['DEPART_ADMIN'] ? "LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $alltmpip)."')" : "radius_user IN('".implode("','", $alltmpuser)."')") : '')." GROUP BY if(locate(':',svraddr)=0, svraddr,left(svraddr, locate(':',svraddr)-1)),ftp_user,radius_user ";
		
		$sql = "SELECT *,s.hostname,ug.groupname FROM ($sql) t LEFT JOIN ".$this->server_set->get_table_name()." s ON t.device_ip=s.device_ip LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON t.groupid=ug.id WHERE ".($usergroup ? " ug.id=$usergroup " : '1')."  ORDER BY $orderby1 $orderby2 ";
		
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			//$reports = $this->sessions_set->base_select($sql);
			$str = "日期:\t".$start."\t到\t".$end."\n";
			$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("服务器IP")."\t".language("主机名")." \t".language("协议")."\t".language("系统用户")." \t".language("登录次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
			$id=1;
			$i=0;
			$f = @fopen('tmp/DevLoginReport.xls', "wa+");
			@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;
				foreach ($reports AS $report){		
					$str .= ($id++)."\t".$report['luser']."\t".$report['realname']."\t".$report['groupname']."\t".$report['device_ip']."\t".$report['hostname']."\t".$report['type']."\t".$report['user']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
					$str .= "\n";
				}
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}
			fclose($f);
			go_url('tmp/DevLoginReport.xls?'.time());
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=DevLoginReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==4){
			$reports = $this->sessions_set->base_select($sql);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','主机名'), iconv('UTF-8','GBK','协议'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','登录次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
			$w = array(12, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, $report['luser'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['device_ip']), iconv('UTF-8','GBK',$report['hostname']), iconv('UTF-8','GBK',$report['type']), iconv('UTF-8','GBK',$report['user']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('devloginreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=DevLoginReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('devloginreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=DevLoginReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();
		$sqlt = "SELECT COUNT(*) ct FROM (SELECT a.luser,m.realname,m.groupid,a.type,a.user,if(locate(':',addr)=0, addr,left(addr, locate(':',addr)-1)) device_ip, MIN(start) mstart, MAX(start) mend,IFNULL(COUNT(*),0) ct FROM ".$this->sessions_set->get_table_name()." a LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->commands_set->get_table_name()."  GROUP BY sid) bb ON bb.sid=a.sid LEFT JOIN ".$this->member_set->get_table_name()." m ON a.luser=m.username WHERE $where ".($cronreport_alltmpip[0] ? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')" : "").(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? " AND ".($_CONFIG['DEPART_ADMIN'] ? "LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : "luser IN('".implode("','", $alltmpuser)."')") : '')." GROUP BY if(locate(':',addr)=0, addr,left(addr, locate(':',addr)-1)),user,luser,type";
		$sqlt .= " UNION SELECT a1.luser,m.realname,m.groupid,a1.type,a1.user,if(locate(':',addr)=0, addr,left(addr, locate(':',addr)-1)) device_ip, MIN(start) mstart, MAX(start) mend,IFNULL(COUNT(*),0) ct FROM ".$this->rdp_set->get_table_name()." a1 LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->rdpinput_set->get_table_name()."  GROUP BY sid) bb1 ON bb1.sid=a1.sid LEFT JOIN ".$this->member_set->get_table_name()." m ON a1.luser=m.username WHERE $where ".($cronreport_alltmpip[0] ? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')" : "").(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')" : '')." GROUP BY if(locate(':',addr)<0, addr,left(addr, locate(':',addr)-1)),user,luser,type";
		$sqlt .= " UNION SELECT a2.radius_user luser,m.realname,m.groupid,'sftp' type,a2.sftp_user user,if(locate(':',svraddr)=0, svraddr,left(svraddr, locate(':',svraddr)-1)) device_ip, MIN(start) mstart, MAX(start) mend,IFNULL(COUNT(*),0) ct FROM ".$this->sftpsession_set->get_table_name()." a2 LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->sftpcmd_set->get_table_name()."  GROUP BY sid) bb2 ON bb2.sid=a2.sid LEFT JOIN ".$this->member_set->get_table_name()." m ON a2.radius_user=m.username WHERE $where ".($cronreport_alltmpip[0] ? " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $cronreport_alltmpip)."')" : "").(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? " AND ".($_CONFIG['DEPART_ADMIN'] ? "LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $alltmpip)."')" : "radius_user IN('".implode("','", $alltmpuser)."')") : '')." GROUP BY if(locate(':',svraddr)=0, svraddr,left(svraddr, locate(':',svraddr)-1)),sftp_user,radius_user";
		$sqlt .= " UNION SELECT a3.radius_user luser,m.realname,m.groupid,'ftp' type,a3.ftp_user user,if(locate(':',svraddr)=0, svraddr,left(svraddr, locate(':',svraddr)-1)) device_ip, MIN(start) mstart, MAX(start) mend,IFNULL(COUNT(*),0) ct FROM ".$this->ftpsession_set->get_table_name()." a3 LEFT JOIN (SELECT COUNT(*) ct,sid FROM ".$this->ftpcmd_set->get_table_name()."  GROUP BY sid) bb3 ON bb3.sid=a3.sid LEFT JOIN ".$this->member_set->get_table_name()." m ON a3.radius_user=m.username WHERE $where ".($cronreport_alltmpip[0] ? " AND LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $cronreport_alltmpip)."')" : "").(( $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) ? " AND ".($_CONFIG['DEPART_ADMIN'] ? "LEFT(svraddr,IF(LOCATE(':',svraddr)>0,LOCATE(':',svraddr)-1,LENGTH(svraddr))) IN ('".implode("','", $alltmpip)."')" : "radius_user IN('".implode("','", $alltmpuser)."')") : '')." GROUP BY if(locate(':',svraddr)=0, svraddr,left(svraddr, locate(':',svraddr)-1)),ftp_user,radius_user ) t ";		
		$row_num = $this->sessions_set->base_select($sqlt);	
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');

		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$reports = $this->sessions_set->base_select($sql);
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
		$this->assign('reports', $reports);
		$this->assign('number', $number);
		$this->assign('session_num', $row_num);
		$usergroup = $this->usergroup_set->select_all('level=0  and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');		$this->assign('usergroup', $usergroup);

		$this->assign('allgroup', $usergroup);
loading_end();
		
		$this->display('devloginreport.tpl');
	}

	function apploginreport(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$usergroup = get_request('usergroup', 0, 1);
		if(empty($start)&&empty($end)){
			$start = date('Y-m-d', mktime(0,0,0,date('m')-1,date('d'),date('Y')));
			$end = date('Y-m-d');
		}
		if(empty($orderby1)){
			$orderby1 = 'ct';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($start){
			$where .= " AND start >='".$start." 00:00:00'";
		}
		if($end){
			$where .= " AND start <='".$end." 23:59:59'";
		}
		if($usergroup){
			$where .=" AND ug.`id`='$usergroup'";
		}
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')";
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND b.username IN ('".implode("','", $alltmpuser)."')";
				}
		}

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $cronreport_alltmpip)."')";
		}

		
		$sql = "SELECT a.*,addr device_ip,count(*) ct, MIN(start) mstart, MAX(start) mend,b.username user,b.realname,ug.groupname,c.url FROM ".$this->appcomm_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." b ON a.memberid=b.uid LEFT JOIN ".$this->apppub_set->get_table_name()." c ON a.serverip=c.appserverip and a.appname=c.name LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON b.groupid=ug.id WHERE $where GROUP BY serverip,appname,memberid ORDER BY $orderby1 $orderby2 ";	
				
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			//$reports = $this->appcomm_set->base_select($sql);			
			$str = "日期:\t".$start."\t到\t".$end."\n";
			$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("服务器IP")."\t".language("应用名称")." \t".language("程序路径")." \t".language("URL")." \t".language("登录次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
			$id=1;
			$i=0;
			$f = @fopen('tmp/AppLoginReport.xls', "wa+");
			@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;
				foreach ($reports AS $report){		
					$str .= ($id++)."\t".$report['user']."\t".$report['realname']."\t".$report['groupname']."\t".$report['serverip']."\t".$report['appname']."\t".$report['apppath']."\t".$report['url']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
					$str .= "\n";
				}
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}
			fclose($f);
			go_url('tmp/AppLoginReport.xls?'.time());
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AppLoginReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==4){
			$reports = $this->appcomm_set->base_select($sql);	
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','应用名称'), iconv('UTF-8','GBK','程序路径'), iconv('UTF-8','GBK','URL'), iconv('UTF-8','GBK','登录次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
			$w = array(12, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, $report['luser'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['serverip']), iconv('UTF-8','GBK',$report['appname']), iconv('UTF-8','GBK',$report['apppath']), iconv('UTF-8','GBK',$report['user']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->appcomm_set->base_select($sql);			
			ob_start();
			$this->assign('reports', $reports);
			$this->display('apploginreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AppLoginReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('apploginreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=AppLoginReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();
		$sqlt = "SELECT COUNT(*) ct FROM (SELECT a.* FROM ".$this->appcomm_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." b ON a.memberid=b.uid LEFT JOIN ".$this->apppub_set->get_table_name()." c ON a.serverip=c.appserverip and a.appname=c.name LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON b.groupid=ug.id WHERE $where  GROUP BY serverip,appname,memberid) t ";		
		$row_num = $this->appcomm_set->base_select($sqlt);	
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$reports = $this->appcomm_set->base_select($sql);			
		$usergroup = $this->usergroup_set->select_all('level=0  and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');		
		$this->assign('usergroup', $usergroup);
		$this->assign('allgroup', $usergroup);
		
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
		$this->assign('reports', $reports);
		$this->assign('session_num', $row_num);
		$this->assign('number', $number);
loading_end();
		
		$this->display('apploginreport.tpl');
	}

	function downloadcronreport()
    {
        global $_CONFIG;
		$derive = get_request('derive');
		$page_num = get_request('page');
		$template = get_request("template", 0, 1);	
		$subject = get_request("subject", 0, 1);	
		$f_rangeStart = get_request("f_rangeStart", 0, 1);	
		$f_rangeEnd = get_request("f_rangeEnd", 0, 1);	
		$orderby1 = get_request("orderby1", 0, 1);
		$orderby2 = get_request("orderby2", 0, 1);		
		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
        $where = "1=1";
		if($subject){
			$where .= " AND title like '%".$subject."%'";
		}
		if($f_rangeStart){
			$where .= " AND start >= '".$f_rangeStart."'";
		}
		if($f_rangeEnd){
			$where .= " AND start <= '".$f_rangeEnd."'";
		}
		if($derive==1){
			$id = get_request('id');
			$report = $this->crontab_report_file_set->select_by_id($id);
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=".iconv("UTF-8", "GBK", $report['title']).".".substr($report['filepath'],strrpos($report['filepath'],'.')+1)); 
			echo file_get_contents($report['filepath']);
			exit();
		}
loading_start();
        $row_num  = $this->crontab_report_file_set->select_count($where);
        $newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
        $this->assign('page_list', $newpager->showSerialList());
        $this->assign('log_num', $row_num);
        $this->assign('curr_page', $newpager->intCurrentPageNumber);
        $this->assign('total_page', $newpager->intTotalPageCount);
        $this->assign('items_per_page', $newpager->intItemsPerPage);
        $reports = $this->crontab_report_file_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
        $this->assign("name", $name);
        $this->assign('alllog', $reports);
		$this->assign("templates", $this->templates);
loading_end();
        $this->display('downloadcronreport.tpl');
    }

	function crontabreportsdelete(){
		$id = get_request('id');
		if(!empty($id)){
			$_POST['chk_member'][]=$id;
		}
		for($i=0; $i<count($_POST['chk_member']); $i++){
			$report = $this->crontab_report_file_set->select_by_id($_POST['chk_member'][$i]);
			@unlink($report['filepath']);
			$this->crontab_report_file_set->delete($_POST['chk_member'][$i]);
		}
		
		alert_and_back('操作成功');
	}

	function loginapproved() {
		$back = get_request('back');
		$derive = get_request('derive');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$page_num = get_request('page');
		$orderby1 = get_request("orderby1", 0, 1);
		$orderby2 = get_request("orderby2", 0, 1);
		$webuser = get_request("webuser", 0, 1);
		$ip = get_request("ip", 0, 1);
		$username = get_request("username", 0, 1);
		$start = get_request("start", 0, 1);
		$usergroup = get_request('usergroup', 0, 1);
		//$where = 'level < 10 AND level!=2';
		$where = 'approved = 2';
		if($webuser){
			$where .= " AND webuser like '%".$webuser."%'";
		}
		if($ip){
			$where .= " AND ip like '%".$ip."%'";
		}
		if($username){
			$where .= " AND username like '%".$username."%'";
		}
		if($start){
			$where .= " AND applytime>'".$start."'";
		}
		if($usergroup){
			$where .=" AND ug.`id`='$usergroup'";
		}

		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				$where .= " AND ".$this->login4approve_set->get_table_name().".ip IN ('".implode("','", $alltmpip)."')";
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND ".$this->login4approve_set->get_table_name().".webuser IN ('".implode("','", $alltmpuser)."')";
				}
		}
		

		if(empty($orderby1)){
			$orderby1 = 'logintime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		$alltem = $this->tem_set->select_all();
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		$sql = "SELECT count(0) ct FROM ".$this->login4approve_set->get_table_name()." LEFT JOIN ".$this->member_set->get_table_name()." m ON ".$this->login4approve_set->get_table_name().".webuser=m.username LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON m.groupid=ug.id WHERE $where ORDER BY logintime DESC";

		$row_num = $this->login4approve_set->base_select($sql);
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql = "SELECT ".$this->login4approve_set->get_table_name().".*,m.realname,ug.groupname FROM ".$this->login4approve_set->get_table_name()." LEFT JOIN ".$this->member_set->get_table_name()." m ON ".$this->login4approve_set->get_table_name().".webuser=m.username LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON m.groupid=ug.id WHERE $where ORDER BY $orderby1 $orderby2";
		if($derive==1){
			$allmember = $this->appcomm_set->base_select($sql);	
			for($i=0;$i<count($allmember);$i++) {
				foreach($alltem as $tem) {
					if($allmember[$i]['login_method'] == $tem['id']) {
						$allmember[$i]['login_method'] = $tem['login_method'];
					}
				}
			}
			$str = "日期:\t".$start."\t到\t".$end."\n";
			$str .= language("序号")."\t".language("用户名")."\t".language("别名")."\t".language("运维组")."\t".language("服务器IP")."\t".language("系统用户名")." \t".language("登录协议")." \t".language("申请时间")." \t".language("审批时间")." \t".language("申请人")." \t".language("登录时间")."\t\n";
			$id=1;
			foreach ($allmember AS $report){		
				$str .= ($id++)."\t".$report['webuser']."\t".$report['realname']."\t".$report['groupname']."\t".$report['ip']."\t".$report['username']."\t".$report['login_method']."\t".$report['applytime']."\t".$report['approvetime']."\t".$report['approveuser']."\t".$report['logintime'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AppLoginReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			exit();
		}else if($derive==4){
			$reports = $this->appcomm_set->base_select($sql);	
			for($i=0;$i<count($reports);$i++) {
				foreach($alltem as $tem) {
					if($reports[$i]['login_method'] == $tem['id']) {
						$reports[$i]['login_method'] = $tem['login_method'];
					}
				}
			}
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','用户名'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','系统用户名'), iconv('UTF-8','GBK','登录协议'), iconv('UTF-8','GBK','申请时间'), iconv('UTF-8','GBK','审批时间'), iconv('UTF-8','GBK','申请人'), iconv('UTF-8','GBK','登录时间'));
			$w = array(20, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, $report['webuser'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['ip']), iconv('UTF-8','GBK',$report['username']), iconv('UTF-8','GBK',$report['login_method']), iconv('UTF-8','GBK',$report['applytime']), iconv('UTF-8','GBK',$report['approvetime']), iconv('UTF-8','GBK',$report['approveuser']), iconv('UTF-8','GBK',$report['logintime'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$allmember = $this->appcomm_set->base_select($sql);		
			for($i=0;$i<count($allmember);$i++) {
				foreach($alltem as $tem) {
					if($allmember[$i]['login_method'] == $tem['id']) {
						$allmember[$i]['login_method'] = $tem['login_method'];
					}
				}
			}
			ob_start();
			$this->assign('reports', $allmember);
			$this->display('loginapproved_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AppLoginReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){
			$allmember = $this->appcomm_set->base_select($sql);		
			for($i=0;$i<count($allmember);$i++) {
				foreach($alltem as $tem) {
					if($allmember[$i]['login_method'] == $tem['id']) {
						$allmember[$i]['login_method'] = $tem['login_method'];
					}
				}
			}
			ob_start();
			$this->assign('reports', $allmember);
			$this->display('loginapproved_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=AppLoginReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}		
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$allmember = $this->login4approve_set->base_select($sql);
		$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');		$this->assign('usergroup', $usergroup);

		$this->assign('usergroup', $usergroup);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		
		for($i=0;$i<count($allmember);$i++) {
			foreach($alltem as $tem) {
				if($allmember[$i]['login_method'] == $tem['id']) {
					$allmember[$i]['login_method'] = $tem['login_method'];
				}
			}
		}

		$this->assign('approves', $allmember);
		$this->display('loginapproved.tpl');
	}

	function accountrecord() {
		$back = get_request('back');
		$derive = get_request('derive');
		if($back){
			if(is_array($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'])){
				$_GET = array_merge($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING'], $_GET);
				$_SERVER['QUERY_STRING'] = http_build_query($_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
			}
		}else{
			$_SESSION[$_GET['controller'].'_'.$_GET['action'].'_'.'QUERY_STRING'] = null;
		}
		$page_num = get_request('page');
		$orderby1 = get_request("orderby1", 0, 1);
		$orderby2 = get_request("orderby2", 0, 1);
		$webuser = get_request("webuser", 0, 1);
		$ip = get_request("ip", 0, 1);
		$username = get_request("username", 0, 1);
		$start = get_request("start", 0, 1);
		$usergroup = get_request('usergroup', 0, 1);
		//$where = 'level < 10 AND level!=2';
		$where = 'approved = 2';
		if($webuser){
			$where .= " AND webuser like '%".$webuser."%'";
		}
		if($ip){
			$where .= " AND ip like '%".$ip."%'";
		}
		if($username){
			$where .= " AND user like '%".$username."%'";
		}
		if($start){
			$where .= " AND date>'".$start."'";
		}
		if($usergroup){
			$where .=" AND ug.`id`='$usergroup'";
		}

		if(empty($orderby1)){
			$orderby1 = 'date';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

	

		$row_num = $this->account_record_set->select_count();
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		if($derive==1){
			$allmember = $this->account_record_set->select_all();	
			$str = "日期:\t".$start."\t到\t".$end."\n";
			$str .= language("序号")."\t".language("时间")."\t".language("服务器IP")."\t".language("从帐号")."\t".language("UID")."\t".language("GID")." \t".language("主目录")." \t".language("动作")."\t\n";
			$id=1;
			foreach ($allmember AS $report){		
				$str .= ($id++)."\t".$report['date']."\t".$report['ip']."\t".$report['user']."\t".$report['uid']."\t".$report['gid']."\t".$report['home']."\t".$report['action'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AppLoginReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			exit();
		}else if($derive==4){
			$reports = $this->account_record_set->select_all();	
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','时间'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','从帐号'), iconv('UTF-8','GBK','UID'), iconv('UTF-8','GBK','GID'), iconv('UTF-8','GBK','主目录'), iconv('UTF-8','GBK','动作'));
			$w = array(20, 25, 30, 25, 25, 25, 25, 25);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, $report['date'], iconv('UTF-8','GBK',$report['ip']), iconv('UTF-8','GBK',$report['user']), iconv('UTF-8','GBK',$report['uid']), iconv('UTF-8','GBK',$report['gid']), iconv('UTF-8','GBK',$report['home']), iconv('UTF-8','GBK',$report['action'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$allmember = $this->account_record_set->select_all();		
			ob_start();
			$this->assign('reports', $allmember);
			$this->display('account_record.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AppLoginReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){
			$allmember = $this->account_record_set->select_all();	
			ob_start();
			$this->assign('reports', $allmember);
			$this->display('account_record.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=AppLoginReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}		
		$allmember = $this->account_record_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,"1 = 1 ", $orderby1, $orderby2);
		$this->assign('usergroup', $usergroup);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		
		$this->assign('approves', $allmember);
		$this->display('accountrecord.tpl');
	}

	function cmdcachereport() {
		global $_CONFIG;
		$page_num = get_request('page');
		$derive = get_request('derive');
		$add = get_request('add', 1,1);
		$cmd = get_request('cmd', 1,1);
		$level = get_request('level', 1,1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$usergroup = get_request('usergroup', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'cmd';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		if($usergroup){
			$where .=" AND ug.`id`='$usergroup'";
		}

		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				$where .= " AND LEFT(a.addr,IF(LOCATE(':',a.addr)>0,LOCATE(':',a.addr)-1,LENGTH(a.addr))) IN ('".implode("','", $alltmpip)."')";
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND luser IN ('".implode("','", $alltmpuser)."')";
				}
		}
		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND LEFT(a.addr,IF(LOCATE(':',a.addr)>0,LOCATE(':',a.addr)-1,LENGTH(a.addr))) IN ('".implode("','", $cronreport_alltmpip)."')";
		}

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);
		
		//$allcommand =  $this->cmdcache_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,"1 = 1 ", $orderby1, $orderby2);
		$sql = "SELECT a.addr,a.luser,a.user,b.cmd ocmd, c.cmd,d.realname,COUNT(*) ct,ug.groupname,min(b.at) start,max(b.at) end FROM ".$this->sessions_set->get_table_name()." a LEFT JOIN ".$this->commands_set->get_table_name()." b ON a.sid=b.sid LEFT JOIN ".$this->cmdcache_set->get_table_name()." c ON lower(left(b.cmd, length(c.cmd)+1))=concat(lower(c.cmd), ' ') LEFT JOIN ".$this->member_set->get_table_name()." d ON a.luser=d.username LEFT JOIN ".$this->usergroup_set->get_table_name()." ug ON d.groupid=ug.id WHERE b.cid IS NOT NULL AND c.id IS NOT NULL $where GROUP BY a.addr,a.luser,a.user, c.cmd";
		
		if($derive==1){
			//$allmember = $this->appcomm_set->base_select($sql);	
			$str = "日期:\t".$start."\t到\t".$end."\n";
			$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("系统用户")."\t".language("设备IP")." \t".language("命令")."\t\n";
			$id=1;
			$i=0;
			$f = @fopen('tmp/CmdCacheReport.xls', "wa+");
			@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));

			while(1){
				$str='';
				$allmember = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($allmember)) break;
				foreach ($allmember AS $report){		
					$str .= ($id++)."\t".$report['luser']."\t".$report['realname']."\t".$report['groupname']."\t".$report['user']."\t".$report['addr']."\t".$report['ocmd']."\t";
					$str .= "\n";
				}
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}
			fclose($f);
			go_url('tmp/CmdCacheReport.xls?'.time());
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AppLoginReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==4){
			$reports = $this->appcomm_set->base_select($sql);	
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','设备IP'), iconv('UTF-8','GBK','命令'));
			$w = array(20, 36, 36, 36, 36, 36);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, $report['luser'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['user']), iconv('UTF-8','GBK',$report['addr']), iconv('UTF-8','GBK',$report['ocmd'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$allmember = $this->appcomm_set->base_select($sql);	
			ob_start();
			$this->assign('reports', $allmember);
			$this->display('cmdcache_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AppLoginReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){
			$allmember = $this->appcomm_set->base_select($sql);	
			ob_start();
			$this->assign('reports', $allmember);
			$this->display('cmdcache_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=AppLoginReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}		
loading_start();
		$row_num = $this->cmdcache_set->base_select("SELECT count(*) ct FROM ".$this->sessions_set->get_table_name()." a LEFT JOIN ".$this->commands_set->get_table_name()." b ON a.sid=b.sid LEFT JOIN ".$this->cmdcache_set->get_table_name()." c ON lower(left(b.cmd, length(c.cmd)+1))=concat(lower(c.cmd), ' ') WHERE b.cid IS NOT NULL AND c.id IS NOT NULL  $where");
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("gid", $gid);
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$allcommand =  $this->cmdcache_set->base_select($sql);
		$usergroup = $this->usergroup_set->select_all('level=0  and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');		
		$this->assign('usergroup', $usergroup);
		$this->assign('allgroup', $usergroup);

		$this->assign('usergroup', $usergroup);
		//$allcommand =  $this->cmdcache_set->base_select("SELECT cmd, COUNT(*) ct FROM ".$this->commands_set->get_table_name()." a LEFT JOIN ".$this->cmdcache_set->get_table_name()." b ON ".$newpager->intStartPosition, $newpager->intItemsPerPage,"1 = 1 ", $orderby1, $orderby2);

		$this->assign("allcommand",$allcommand);
		$this->assign("curr_url",$curr_url);
loading_end();
		$this->display("cmdcachereport.tpl");
	}

	function cmdcache() {
		$page_num = get_request('page');
		$derive = get_request('derive');
		$add = get_request('add', 1,1);
		$cmd = get_request('cmd', 1,1);
		$level = get_request('level', 1,1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'cmd';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

loading_start();
		$row_num = $this->cmdcache_set->select_count();
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("gid", $gid);
		
		$allcommand =  $this->cmdcache_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,"1 = 1 ", $orderby1, $orderby2);
		$this->assign("allcommand",$allcommand);
		$this->assign("curr_url",$curr_url);
loading_end();
		$this->display("cmdcache.tpl");
	}

	function cmdcache_edit(){
		$id = get_request('id');
		$cmdinfo = $this->cmdcache_set->select_by_id($id);
		$this->assign("cmdinfo", $cmdinfo);
		$this->display("cmdcache_edit.tpl");
	}

	function cmdcache_save(){
		$add = get_request('add', 1,1);
		$level = get_request('level', 1,1);
		$cmd = get_request('cmd', 1,1);		
		$id  =  get_request('id');
		if($add == 'new'){
			if($cmd==""){
				alert_and_back('命令不能为空');
				exit;
			}			
			if($cid){
				$cmdcache = new cmdcache();
				$cmdcache->set_data('cmd', $cmd);
				$cmdcache->set_data('id', $id);
				$this->cmdcache_set->edit($cmdcache);
			}else{
				for($i=0; $i<count($_POST['cmd']); $i++){
					if(empty($_POST['cmd'][$i])) continue;
					$cmdcache = new cmdcache();
					$cmdcache->set_data('cmd', $_POST['cmd'][$i]);
					$this->cmdcache_set->add($cmdcache);
				}
			}
			alert_and_back('操作成功','admin.php?controller=admin_reports&action=cmdcache');			
		}
	}

	function del_cmdcache() {
		$id = get_request('id');
		if(empty($id)){
			$id = $_POST['chk_gid'];
		}
		$this->cmdcache_set->delete($id);
		alert_and_back('操作成功','admin.php?controller=admin_reports&action=cmdcache');

	}

	function cmdcache_import(){
		$sql = "SELECT cid, lower(left(cmd, IF(locate(' ', cmd)>0, locate(' ',cmd), length(cmd)))) cmd,length(replace(cmd, ' ', '')) FROM ".$this->commands_set->get_table_name()." WHERE cmd IS NOT NULL GROUP BY cmd";
		$cmd = $this->cmdcache_set->base_select($sql);
		$cmdexists = array();
		for($i=0; $i<count($cmd); $i++){
			$cmd[$i]['cmd'] = trim($cmd[$i]['cmd']);
			if(empty($cmd[$i]['cmd']) || in_array($cmd[$i]['cmd'], $cmdexists)) continue;
			$cmdexists[] = $cmd[$i]['cmd'];
			$cmdcache = new cmdcache();
			$cmdcache->set_data('cmd', addslashes($cmd[$i]['cmd']));
			$this->cmdcache_set->add($cmdcache);
		}		
		alert_and_back('操作成功','admin.php?controller=admin_reports&action=cmdcache');
	}

	function cmdlistreport_users(){
		global $_CONFIG;
		$webuser = get_request('webuser',0,1);
		$ldapid1 = get_request('ldapid1',0,1);
		$ldapid2 = get_request('ldapid2',0,1);		
		$servergroup = get_request('servergroup',0,1);

		if($servergroup){
			$wheremember = ' AND groupid ='.$servergroup;
		}elseif($ldapid2){			
			$wheremember = ' AND groupid IN(select child FROM '.$this->sgroup_set->get_table_name().' WHERE id='.$ldapid2.')';
		}elseif($ldapid1){			
			$wheremember = ' AND groupid IN(select child FROM '.$this->sgroup_set->get_table_name().' WHERE id='.$ldapid1.')';
		}

		require_once('./include/select_sgroup_ajax.inc.php');

		$where = '1';
		if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
			if(empty($_SESSION['ADMIN_MUSERGROUP'])){
				alert_and_close('没有可管理的组');
				exit;
			}
			$where .= "  AND groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).") AND uid!=".$_SESSION['ADMIN_UID'];
		}
		$users = $this->member_set->select_all($where.$wheremember.(empty($webuser) ? '' : ' AND username like "%'.$webuser.'%"' ),'username', 'asc');
		if($_SESSION['CMDLISTREPORT']['users'])
		for($i=0; $i<count($users); $i++){
			if(in_array($users[$i]['username'], $_SESSION['CMDLISTREPORT']['users'])){
				$users[$i]['check']='checked';
			}
		}
		$this->assign("users", $users);
		$this->display("cmdlistreport_users.tpl");
	}
	function docmdlistreport_users(){
		$_SESSION['CMDLISTREPORT']['users'] = null;
		for($i=0; $i<count($_POST['Check']); $i++){
			if(!empty($_POST['Check'][$i]))
			$_SESSION['CMDLISTREPORT']['users'][]=$_POST['Check'][$i];
		}
		alert_and_close('已记录');
	}

	function cmdlistreport_ips(){
		global $_CONFIG;
		$webuser = get_request('webuser',0,1);
		$ldapid1 = get_request('ldapid1',0,1);
		$ldapid2 = get_request('ldapid2',0,1);		
		$servergroup = get_request('servergroup',0,1);

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$wheremember = " AND groupid IN ('".implode("','", $_tmpgid['child'])."')";
		}

		$where = '1';
		if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				alert_and_close('没有可管理的组');
				exit;
			}
			//$oldmem = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
			//$where .= " AND svraddr IN (SELECT device_ip FROM servers WHERE groupid = ".$oldmem['mservergroup']." )";
			//$where .= " AND device_ip IN (SELECT ip FROM dev WHERE did IN ($_SESSION[DEVS]))";
			$where .= ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0 ' : '')." AND (servers.groupid>0 AND groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).") ";


		}
		$ips = $this->server_set->select_all($where.$wheremember.(empty($webuser) ? '' : ' AND device_ip like "%'.$webuser.'%"' ),'inet_aton(device_ip)', 'asc');
		if($_SESSION['CMDLISTREPORT']['ips'])
		for($i=0; $i<count($ips); $i++){
			if(in_array($ips[$i]['device_ip'], $_SESSION['CMDLISTREPORT']['ips'])){
				$ips[$i]['check']='checked';
			}
		}
		$this->assign("ips", $ips);
		$this->display("cmdlistreport_ips.tpl");
	}
	function docmdlistreport_ips(){		
		$_SESSION['CMDLISTREPORT']['ips'] = null;
		for($i=0; $i<count($_POST['Check']); $i++){
			if(!empty($_POST['Check'][$i]))
				$_SESSION['CMDLISTREPORT']['ips'][]=$_POST['Check'][$i];
		}
		alert_and_close('已记录');		
	}
	function cmdlistreport_cmds(){
		$this->display("cmdlistreport_cmds.tpl");
	}
	function docmdlistreport_cmds(){
		$_SESSION['CMDLISTREPORT']['cmds'] = null;
		for($i=0; $i<count($_POST['commands']); $i++){
			if(!empty($_POST['commands'][$i]))
				$_SESSION['CMDLISTREPORT']['cmds'][]=$_POST['commands'][$i];
		}
		alert_and_close('已记录');
	}

	function cmdlistreport() {
		global $_CONFIG;
		$page_num = get_request('page');
		$derive = get_request('derive');
		$add = get_request('add', 1,1);
		$cmd = get_request('cmd', 1,1);
		$level = get_request('level', 1,1);
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		$username = get_request('username', 0, 1);
		$ip = get_request('ip', 0, 1);
		$start = get_request('start', 0, 1);
		$end = get_request('end', 0, 1);
		$where = '1';
		if(empty($orderby1)){
			$orderby1 = 'cid';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		if($username){
			$where .=" AND luser='$username'";
		}
		if($ip){
			$where .=" AND addr like '%$ip%'";
		}
		if(empty($start)&&empty($end)){
			$start = date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m'), date('d')-1, date('Y')));
			$end   = date('Y-m-d 23:59:59', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
		}
		if($start){
			$where .=" AND at > '$start'";
		}
		if($end){
			$where .=" AND at < '$end'";
		}

		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				$where .= " AND LEFT(b.addr,IF(LOCATE(':',b.addr)>0,LOCATE(':',b.addr)-1,LENGTH(b.addr))) IN ('".implode("','", $alltmpip)."')";
			}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND luser IN ('".implode("','", $alltmpuser)."')";
				}
		}
		$wheres = "";
		$wherec = "";

		if($_SESSION['CMDLISTREPORT']['users']){
			$wheres .= " AND luser IN('".implode("','", $_SESSION['CMDLISTREPORT']['users'])."') AND luser is not null ";
		}

		if($_SESSION['CMDLISTREPORT']['ips']){
			$addrwhere = '0';
			for($i=0; $i<count($_SESSION['CMDLISTREPORT']['ips']); $i++){
				$addrwhere .= " OR addr='".$_SESSION['CMDLISTREPORT']['ips'][$i]."'";
			}
			$wheres .= " AND (".$addrwhere.")";
		}

		if($_SESSION['CMDLISTREPORT']['cmds']){
			$wherec .= " AND cmd regexp '".implode("|", $_SESSION['CMDLISTREPORT']['cmds'])."'";
		}

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		parse_str($_SERVER['QUERY_STRING'], $_SESSION[$_GET['controller'].'_'.($_GET['action'] ? $_GET['action'] : 'index' ).'_'.'QUERY_STRING']);

		
		
		
		//$allcommand =  $this->cmdcache_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,"1 = 1 ", $orderby1, $orderby2);
		$sql = "SELECT b.addr,b.luser,a.*  FROM ".$this->commands_set->get_table_name()." a LEFT JOIN ".$this->sessions_set->get_table_name()." b ON a.sid=b.sid WHERE $where ".$wherec." ".$wheres." ORDER BY $orderby1 $orderby2 ";
		
		if($derive==1){
			//$allmember = $this->appcomm_set->base_select($sql.' limit 10000');	
			$str = "日期:\t".$start."\t到\t".$end."\n";
			$str .= language("序号")."\t".language("运维用户")."\t".language("设备IP")."\t".language("执行时间")."\t".language("命令")."\t".language("级别")."\t\n";
			$id=1;
			$i=0;
			@unlink('tmp/AppLoginReport.xls');
			$f = @fopen('tmp/AppLoginReport.xls', "wa+");
			@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));

			while(1){
				$str = "";
				$allmember = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");
				if(empty($allmember)) break;
				foreach ($allmember AS $report){
					
					switch($report['dangerlevel']){
						case 0:
							$slevel = '正常';
						break;
						case 1:
							$slevel = '危险';
						break;
						case 2:
							$slevel = '严重';
						break;
						case 3:
							$slevel = '警告';
						break;
						case 4:
							$slevel = '复核';
						break;
					}
					$str .= ($id++)."\t".$report['luser']."\t".$report['addr']."\t".$report['at']."\t".htmlspecialchars($report['cmd'])."\t".$slevel."\t";
					$str .= "\n";
					
				}
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}
			fclose($f);
			go_url('tmp/AppLoginReport.xls?'.time());
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AppLoginReport.xls"); 
			//echo mb_convert_encoding($str, "GBK", "UTF-8");
			echo mb_convert_encoding($str, "GBK", "UTF-8");			
			*/
			exit();
		}else if($derive==4){
			$reports = $this->appcomm_set->base_select($sql);	
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','设备IP'), iconv('UTF-8','GBK','执行时间'), iconv('UTF-8','GBK','命令'), iconv('UTF-8','GBK','级别'));
			$w = array(20, 36, 36, 36, 36, 36);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				switch($report['dangerlevel']){
					case 0:
						$slevel = '正常';
					break;
					case 1:
						$slevel = '危险';
					break;
					case 2:
						$slevel = '严重';
					break;
					case 3:
						$slevel = '警告';
					break;
					case 4:
						$slevel = '复核';
					break;
				}
				$pdf->Row(array(++$id, $report['luser'], iconv('UTF-8','GBK',$report['addr']), iconv('UTF-8','GBK',$report['at']), iconv('UTF-8','GBK',$report['cmd']), iconv('UTF-8','GBK',$slevel)), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$allmember = $this->appcomm_set->base_select($sql);	
			ob_start();
			$this->assign('reports', $allmember);
			$this->display('cmdlistreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=AppLoginReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){
			$allmember = $this->appcomm_set->base_select($sql);	
			ob_start();
			$this->assign('reports', $allmember);
			$this->display('cmdlistreport_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=AppLoginReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}		
loading_start();
		$row_num = $this->commands_set->base_select("SELECT count(*) ct  FROM ".$this->commands_set->get_table_name()." a LEFT JOIN ".$this->sessions_set->get_table_name()." b ON a.sid=b.sid WHERE $where ".$wherec." ".$wheres);
		$row_num = $row_num[0]['ct'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("gid", $gid);

		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		$allcommand =  $this->cmdcache_set->base_select($sql);
		$users = $this->member_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101 ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'username', 'ASC');
		$this->assign('users', $users);
		$servers = $this->server_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '')." AND groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")" : ''),'device_ip', 'ASC');
		$this->assign('servers', $servers);
		//$allcommand =  $this->cmdcache_set->base_select("SELECT cmd, COUNT(*) ct FROM ".$this->commands_set->get_table_name()." a LEFT JOIN ".$this->cmdcache_set->get_table_name()." b ON ".$newpager->intStartPosition, $newpager->intItemsPerPage,"1 = 1 ", $orderby1, $orderby2);

		$this->assign("allcommand",$allcommand);
		$this->assign("f_rangeStart",$start);
		$this->assign("f_rangeEnd",$end);
		$this->assign("curr_url",$curr_url);
loading_end();
		$this->display("cmdlistreport.tpl");
	}

	function report_search(){
		global $_CONFIG;
		$this->assign("years", array(date("Y"),date("Y")-1));
		
		$users = $this->member_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101 ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'username', 'ASC');
		$servers = $this->server_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '')." AND groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")" : ''),'device_ip', 'ASC');
		$sgroups = $this->sgroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : ' AND id IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).') ') : ''),'groupname', 'ASC');
		
		$ldapidname = 'ldapid';
		$groupidname = 'groupid';
		require('./include/select_sgroup_ajax.inc.php');
		$precl='s';
		$ldapidname = 'sldapid';
		$groupidname = 'sgroupid';
		require('./include/select_sgroup_ajax.inc.php');


		$this->assign('alluser', $users);
		$this->assign('allserver', $servers);
		$this->assign('sgroups', $sgroups);
		$this->assign("_config", $_CONFIG);
		$this->display('report_search.tpl');
	}

	function doreport_search(){
		$page_num = get_request('page');
		$derive = get_request('derive');
		$type = get_request('type', 0, 1);
		$dateinterval = get_request('dateinterval', 0, 1);
		$myear = get_request('myear', 0, 1);
		$mmonth = get_request('mmonth', 0, 1);
		$wyear = get_request('wyear', 0, 1);
		$wmonth = get_request('wmonth', 0, 1);
		$wweek = get_request('wweek', 0, 1);
		$dday = get_request('dday', 0, 1);
		$diy_id = get_request('diy_id');
		$username = get_request('username', 0, 1);
		$server = get_request('server', 0, 1);

		$ugroupid = $_GET['groupid'];
		$sgroupid = $_GET['sgroupid'];
		if(empty($username)){
			$alltmpusername[]=-1;
			$_tmpgid = $this->sgroup_set->select_by_id($ugroupid);
			if($_tmpgid)
			$allips = $this->sessions_set->base_select("SELECT uid,username FROM " . $this->member_set->get_table_name() . " WHERE groupid=".$ugroupid." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$alltmpusername[]=$allips[$i]['username'];
			}
		}
		if(empty($server)){
			$alltmpip[]=-1;
			$_tmpgid = $this->sgroup_set->select_by_id($sgroupid);
			if($_tmpgid)
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$ugroupid." or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$ugroupid.") or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$ugroupid."))");
			for($i=0; $i<count($allips); $i++){
				$alltmpip[]=$allips[$i]['device_ip'];
			}
		}

		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}
		$this->assign("curr_url",$curr_url);

		switch($dateinterval){
			case 'month':
				$start = date('Y-m-d 00:00:00', mktime(0, 0, 0, $mmonth, 1, $myear));
				$end   = date('Y-m-d 23:59:59', mktime(0, 0, 0, $mmonth+1, 0, $myear));
			break;
			case 'day':
				$start = $dday.' 00:00:00';
				$end   = $dday.' 23:59:59';
			break;
			case 'week':
				$w = date('w', mktime(0, 0, 1, $wmonth, 1, $wyear));
				$w = $w==0 ? 6 : $w-1;
				$start = date('Y-m-d 00:00:00', mktime(0, 0, 0, $wmonth, 7*($wweek-1)-$w+1, $wyear));
				$end   = date('Y-m-d 23:59:59', mktime(0, 0, 0, $wmonth, 7*($wweek)-$w, $wyear));
			break;
			case 'diy':
			break;
			default:
			break;
		}

		switch($type){
			case 'admin_log_statistic':
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$derive = get_request('derive', 0, 1);
				$administrator = get_request('administrator', 0, 1);
				$luser = get_request('luser', 0, 1);
				$resource_user = get_request('resource_user', 0, 1);
				$usergroup = get_request('usergroup', 0, 1);
				$where = ($dateinterval!='diy' ? " optime >= '$start' AND optime <= '$end'" : " createid='$diy_id'");
				$this->admin_log_statistic_set->set_table_name('admin_log_'.$dateinterval);
				if($start){
					$where .= " AND optime >='".$start." 00:00:00'";
				}
				if($end){
					$where .= " AND optime <='".$end." 23:59:59'";
				}
				$start = get_request('f_rangeStart', 0, 1);
				$end = get_request('f_rangeEnd', 0, 1);
				if(empty($orderby1)){
					$orderby1 = 'optime';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				$this->assign("orderby2", $orderby2);

				if($luser){
					$where .= " AND luser like '%$luser%'" ;
				}
				if($username){
					$where .= " AND luser like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND luser IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND resource like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND resource IN('".implode("','", $alltmpip)."')";
				}
				if($operation){
					$where .= " AND action='$operation'" ;
				}
				if($administrator){
					$where .= " AND administrator like '%$administrator%'" ;
				}
				if($resource_user){
					$where .= " AND resource_user like '%$resource_user%'" ;
				}
				if($usergroup){
					$where .= " AND c.id='$usergroup'" ;
				}
				if($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {
					$where .= " AND luser IN( SELECT username FROM ".$this->member_set->get_table_name()." WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).")) ";
				}

				$row_num = $this->admin_log_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->admin_log_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("reports", $allcommand);
				$this->display('adminlog_statistic.tpl');
			break;

			case 'login_statistic':
				$usergroup = get_request('usergroup', 0, 1);
				$f_rangeEnd = get_request('f_rangeEnd', 1, 1);
				$f_rangeStart = get_request('f_rangeStart', 1, 1);
				$where = $dateinterval!='diy' ? " start >= '$start' AND start <= '$end'" : " createid='$diy_id'";
				$f_rangeStart = get_request('f_rangeStart', 0, 1);
				$f_rangeEnd = get_request('f_rangeEnd', 0, 1);
				if($f_rangeStart){
					$where .= " AND start >= '$f_rangeStart'";
				}
				if($f_rangeEnd){
					$where .= " AND start >= '$f_rangeEnd'";
				}
				if($usergroup){
					$where .= " AND groupname = '$usergroup'";
				}
				if($username){
					$where .= " AND username like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND username IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND serverip like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND serverip IN('".implode("','", $alltmpip)."')";
				}

				$this->login_statistic_set->set_table_name('logintimes_'.$dateinterval);
				if($derive==1){
					//$result = $this->login_statistic_set->select_all($where, $orderby1, $orderby2);
					$result = $this->login_statistic_set->base_select("select * from (select username,realname,groupname,sum(sct) sct,sum(tct) tct,sum(rct) rct,sum(act) act,sum(vct) vct,sum(fct) fct,sum(sfct) sfct,sum(webct) webct,sum(xct) xct,sum(ct) ct from ".$this->login_statistic_set->get_table_name()." WHERE ".$where." GROUP BY username) t order by ct desc");
					//$handle = fopen(ROOT . 'tmp/loginreport.xls', 'w');

					$str = "日期:\t".$f_rangeStart."\t 到 \t".$f_rangeEnd."\n";
					$str .= language("序号")."\t".language("用户名")."\t".language("别名")."\t".language("运维组")."\t"."ssh\t"."telnet\t"."rdp\t"."应用\t"."VNC\t"."ftp\t"."sftp\t"."前台\t"."X11\t".language("合计")."\t\n";
					$row = 1;
					foreach($result as $info) {
						$col = 0;
						$str .= "$row\t";
						foreach($info as $key => $t) {
							if($key=='sid' || $key == 'start') continue;
							$str .= "$t\t";
							$col++;
						}
						$str .= "\n";
						$row++;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=loginreport.xls"); 
					$str= mb_convert_encoding($str, "GBK", "UTF-8");
					echo $str;
					exit();
				}else if($derive==4){
					$result = $this->login_statistic_set->base_select("select * from (select username,realname,groupname,sum(sct) sct,sum(tct) tct,sum(rct) rct,sum(act) act,sum(vct) vct,sum(fct) fct,sum(sfct) sfct,sum(webct) webct,sum(xct) xct,sum(ct) ct from ".$this->login_statistic_set->get_table_name()." WHERE ".$where." GROUP BY username) t order by ct desc");
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','用户名'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','ssh'), iconv('UTF-8','GBK','telnet'), iconv('UTF-8','GBK','rdp'), iconv('UTF-8','GBK','应用'), iconv('UTF-8','GBK','VNC'), iconv('UTF-8','GBK','ftp'), iconv('UTF-8','GBK','sftp'), iconv('UTF-8','GBK','前台'), iconv('UTF-8','GBK','X11'), iconv('UTF-8','GBK','合计'));
					$w = array(12, 15, 15, 15, 15, 15, 15, 15, 13, 13, 15, 15, 13, 13);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					foreach ($result AS $report){//var_dump($report);
						$pdf->Row(array(++$id, iconv('UTF-8','GBK',$report['username']), iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['sct']), iconv('UTF-8','GBK',$report['tct']), iconv('UTF-8','GBK',$report['rct']), iconv('UTF-8','GBK',$report['act']), iconv('UTF-8','GBK',$report['fct']), iconv('UTF-8','GBK',$report['sfct']), iconv('UTF-8','GBK',$report['webct']), iconv('UTF-8','GBK',$report['vct']), iconv('UTF-8','GBK',$report['xct']), iconv('UTF-8','GBK',$report['ct'])), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
				}elseif($derive==2){
					ob_start();
					$allsession = $this->login_statistic_set->base_select("select * from (select username,realname,groupname,sum(sct) sct,sum(tct) tct,sum(rct) rct,sum(act) act,sum(vct) vct,sum(fct) fct,sum(sfct) sfct,sum(webct) webct,sum(xct) xct,sum(ct) ct from ".$this->login_statistic_set->get_table_name()." WHERE ".$where." GROUP BY username) t order by ct desc");
					$this->assign('allsession', $allsession);
					$this->display("loginreports_list_for_export.tpl");
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
				}else if($derive==3){//word
					$allsession = $this->login_statistic_set->base_select("select * from (select username,realname,groupname,sum(sct) sct,sum(tct) tct,sum(rct) rct,sum(act) act,sum(vct) vct,sum(fct) fct,sum(sfct) sfct,sum(webct) webct,sum(xct) xct,sum(ct) ct from ".$this->login_statistic_set->get_table_name()." WHERE ".$where." GROUP BY username) t order by ct desc");
					ob_start();
					$this->assign('allsession', $allsession);
					$this->display('loginreports_list_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=auditreports.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}
				$row_num = $this->login_statistic_set->base_select("select count(*) num from (select * from ".$this->login_statistic_set->get_table_name()." WHERE ".$where." GROUP BY username) t");
				$row_num = $row_num[0]['num'];
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);		
				$allcommand = $this->login_statistic_set->base_select("select * from (select username,realname,groupname,sum(sct) sct,sum(tct) tct,sum(rct) rct,sum(act) act,sum(vct) vct,sum(fct) fct,sum(sfct) sfct,sum(webct) webct,sum(xct) xct,sum(ct) ct from ".$this->login_statistic_set->get_table_name()." WHERE ".$where." GROUP BY username) t order by ct desc");
				//$allcommand =  $this->login_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("allsession", $allcommand);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('loginreports_list_statistic.tpl');
			break;

			case 'loginacct_statistic':
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$serverip = get_request('serverip', 0, 1);
				$from = get_request('from', 0, 1);
				$systemuser = get_request('systemuser', 0, 1);
				$audituser = get_request('audituser', 0, 1);
				$protocol = get_request('protocol', 0, 1);
				$status = get_request('authenticationstatus', 0, 1);
				$time_start = get_request('f_rangeStart', 0, 1);
				$time_end = get_request('f_rangeEnd', 0, 1);
				$usergroup = get_request('usergroup', 0, 1);
				$where = $dateinterval!='diy' ? " time >= '$start' AND time <= '$end'" : " createid='$diy_id'";
				$this->loginacct_statistic_set->set_table_name('loginacct_'.$dateinterval);
				if(empty($orderby1)){
					$orderby1 = 'time';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				$this->assign("orderby2", $orderby2);
				if($time_start){
					$where .= " AND `time` >='".$time_start." 00:00:00'";
				}
				if($time_end){
					$where .= " AND `time` <='".$time_end." 23:59:59'";
				}
				if($from) {
					if(is_ip($from)) {
						$where .= " AND `sourceip` = '$from'";
					}
					else {
						$where .= " AND `sourceip` LIKE '$from%'";
					}
				}
				if($protocol){
					$where .=" AND `portocol`='$protocol'";
				}

				if($usergroup){
					$where .=" AND groupname='$usergroup'";
				}

				if($serverip) {
					if(is_ip($serverip)) {
						$where .= " AND serverip = '$serverip'";
					}
					else {
						$where .= " AND serverip LIKE '$serverip%'";
					}
				}
				if($username){
					$where .= " AND audituser like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND audituser IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND serverip like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND serverip IN('".implode("','", $alltmpip)."')";
				}

				if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
					if($_CONFIG['DEPART_ADMIN']){
						$alltmpip = array(0);
						$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allips); $i++){
							$alltmpip[]=$allips[$i]['device_ip'];
						}
						$where .= " AND serverip IN ('".implode("','", $alltmpip)."')";
					}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND audituser IN ('".implode("','", $alltmpuser)."')";
				}
				}
				
				if($systemuser) {
					$where .= " AND (systemuser LIKE '%$systemuser%')";
				}
				
				if($audituser) {
					$where .= " AND (audituser LIKE '%$audituser%')";
				}
				if($status!=""){
					$where .= " AND (authenticationstatus='$status')";
				}
				if($_SESSION['ADMIN_LEVEL']==0){
					$where .= " AND (audituser = '".$_SESSION['ADMIN_USERNAME']."')";
				}
				if($derive==1){
					$result = $this->loginacct_statistic_set->select_all($where, $orderby1, $orderby2);
					$str = "日期:\t".$time_start."\t 到 \t".$time_end."\n";
					$str .= language("序号")."SID\t";
					$str .= language("来源地址")."\t";
					$str .= language("审计系统")."\t";
					$str .= language("目标地址")."\t";
					$str .= language("登录协议")."\t";
					$str .= language("时间")."\t";
					$str .= language("运维账号")."\t";
					$str .= language("别名")."\t";
					$str .= language("运维组")."\t";
					$str .= language("系统帐号")."\t";
					$str .= language("状态")."\t";
					$str .= language("出错原因")."\t\n";
					$row = 1;
					if(!empty($result))
					foreach($result as $info) {
						$str .= $info['sid']."\t";
						$str .= $info['sourceip']."\t";
						$str .= $info['auditip']."\t";
						$str .= $info['serverip']."\t";
						$str .= $info['portocol']."\t";
						$str .= $info['time']."\t";
						$str .= $info['audituser']."\t";
						$str .= $info['realname']."\t";
						$str .= $info['groupname']."\t";
						$str .= $info['systemuser']."\t";
						$str .= ($info['authenticationstatus'] ? '成功' : '失败')."\t";
						$str .= $info['failreason']."\t";	
						$str .= "\n";		
						
						$row++;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=loginacct.xls"); 
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					exit();		
				}else if($derive==4){
					$result=$this->loginacct_statistic_set->select_all( $where, $orderby1, $orderby2);
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','来源地址'), iconv('UTF-8','GBK','审计系统'), iconv('UTF-8','GBK','主机地址'), iconv('UTF-8','GBK','登录协议'), iconv('UTF-8','GBK','时间'),iconv('UTF-8','GBK','运维账号'),iconv('UTF-8','GBK','别名'),iconv('UTF-8','GBK','运维组'),iconv('UTF-8','GBK','系统用户'),iconv('UTF-8','GBK','状态'),iconv('UTF-8','GBK','出错原因'));
					$w = array(20, 36, 36, 36, 36, 36);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					foreach ($result AS $report){	
						$pdf->Row(array(++$id, $report['sourceip'], iconv('UTF-8','GBK',$report['auditip']), iconv('UTF-8','GBK',$report['serverip']), iconv('UTF-8','GBK',$report['portocol']), iconv('UTF-8','GBK',$report['time']), iconv('UTF-8','GBK',$report['audituser']), iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['systemuser']), iconv('UTF-8','GBK',$report['authenticationstatus'] ? '成功' : '失败')), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
			}else if($derive==2){
					$alllog = $this->loginacct_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('alllog', $alllog);
					$this->assign('title', language('登录日志'));
					$this->display('loginacct_export_tohtml.tpl');
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
					return;
				}else if($derive==3){//word
					$alllog = $this->loginacct_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('alllog', $alllog);
					$this->display('loginacct_export_tohtml.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=auditreports.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}
				$row_num = $this->loginacct_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->loginacct_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("alllog", $allcommand);
				$alltem = $this->tem_set->select_all("device_type=''");
				$this->assign("alltem", $alltem);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('loginacct_statistic.tpl');
			break;

			case 'loginfailed_statistic':
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$serverip = get_request('serverip', 0, 1);
				$from = get_request('from', 0, 1);
				$audituser = get_request('audituser', 0, 1);
				$protocol = get_request('protocol', 0, 1);
				$ct = get_request('ct', 0, 1);
				$time_start = get_request('f_rangeStart', 0, 1);
				$time_end = get_request('f_rangeEnd', 0, 1);
				$where = $dateinterval!='diy' ? " time >= '$start' AND time <= '$end'" : " createid='$diy_id'";
				$this->loginfailed_statistic_set->set_table_name('loginfailed_'.$dateinterval);
				if(empty($orderby1)){
					$orderby1 = 'ct';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				$this->assign("orderby2", $orderby2);

				if($time_start){
					$where .= " AND `time` >='".$time_start." 00:00:00'";
				}
				if($time_end){
					$where .= " AND `time` <='".$time_end." 23:59:59'";
				}
				if($from) {
					if(is_ip($from)) {
						$where .= " AND `sourceip` = '$from'";
					}
					else {
						$where .= " AND `sourceip` LIKE '$from%'";
					}
				}
				if($protocol){
					$where .=" AND `portocol`='$protocol'";
				}

				if($serverip) {
					if(is_ip($serverip)) {
						$where .= " AND serverip = '$serverip'";
					}
					else {
						$where .= " AND serverip LIKE '$serverip%'";
					}
				}
				if($username){
					$where .= " AND audituser like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND audituser IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND serverip like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND serverip IN('".implode("','", $alltmpip)."')";
				}

				if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
					if($_CONFIG['DEPART_ADMIN']){
						$alltmpip = array(0);
						$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allips); $i++){
							$alltmpip[]=$allips[$i]['device_ip'];
						}
						$where .= " AND serverip IN ('".implode("','", $alltmpip)."')";
					}else{
						$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allusers); $i++){
							$alltmpuser[]=$allusers[$i]['username'];
						}
						if($alltmpuser)
						$where .= " AND audituser IN ('".implode("','", $alltmpuser)."')";
					}
				}
				
				if($systemuser) {
					$where .= " AND (systemuser LIKE '%$systemuser%')";
				}
				
				if($audituser) {
					$where .= " AND (audituser LIKE '%$audituser%')";
				}
				if($status!=""){
					$where .= " AND (authenticationstatus='$status')";
				}
				if($_SESSION['ADMIN_LEVEL']==0){
					$where .= " AND (audituser = '".$_SESSION['ADMIN_USERNAME']."')";
				}
				if($derive==1){
					$result=$this->loginfailed_statistic_set->select_all( $where, $orderby1, $orderby2);
					//$handle = @fopen(ROOT . '/tmp/loginacct.xls', 'w');
					
					$str = "日期:\t".$time_start."\t到\t".$time_end."\n";
					$str .= language("序号")."SID\t";
					$str .= language("来源地址")."\t";
					$str .= language("主机地址")."\t";
					$str .= language("登录协议")."\t";
					$str .= language("账号")."\t";
					$str .= language("次数")."\t\n";
					$row = 1;
					if(!empty($result))
					foreach($result as $info) {
						$str .= $info['sid']."\t";
						$str .= $info['sourceip']."\t";
						$str .= $info['serverip']."\t";
						$str .= $info['portocol']."\t";
						$str .= $info['audituser']."\t";
						$str .= $info['ct']."\t";	
						$str .= "\n";		
						
						$row++;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=loginacct.xls"); 
					$str= mb_convert_encoding($str, "GBK", "UTF-8");
					echo $str;
					exit();
				}else if($derive==4){
					$result=$this->loginfailed_statistic_set->select_all( $where, $orderby1, $orderby2);
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','来源地址'), iconv('UTF-8','GBK','主机地址'), iconv('UTF-8','GBK','登录协议'), iconv('UTF-8','GBK','账号'), iconv('UTF-8','GBK','次数'));
					$w = array(20, 36, 36, 36, 36, 36);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					foreach ($result AS $report){	
						$pdf->Row(array(++$id, $report['sourceip'], iconv('UTF-8','GBK',$report['serverip']), iconv('UTF-8','GBK',$report['portocol']), iconv('UTF-8','GBK',$report['audituser']), iconv('UTF-8','GBK',$report['ct'])), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
				}else if($derive==2){
					$alllog=$this->loginfailed_statistic_set->select_all( $where, $orderby1, $orderby2);
					ob_start();
					$this->assign('alllog', $alllog);
					$this->assign('title', language('登录日志'));
					$this->display('loginfailed_export_tohtml.tpl');
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
					return;
				}else if($derive==3){//word
					$alllog=$this->loginfailed_statistic_set->select_all( $where, $orderby1, $orderby2);
					ob_start();
					$this->assign('alllog', $alllog);
					$this->display('loginfailed_export_tohtml.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=AppAccountReport.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}
				$row_num = $this->loginfailed_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->loginfailed_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("alllog", $allcommand);
				$alltem = $this->tem_set->select_all("device_type=''");
				$this->assign("alltem", $alltem);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('loginfailed_statistic.tpl');
			break;

			case 'devlogin_statistic':
				$where = $dateinterval!='diy' ? " mstart >= '$start' AND mend <= '$end'" : " createid='$diy_id'";
				$this->devlogin_statistic_set->set_table_name('devlogin_'.$dateinterval);
				$number = get_request('number');
				$start = get_request('f_rangeStart', 0, 1);
				$end = get_request('f_rangeEnd', 0, 1);
				$derive = get_request('derive');
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$usergroup = get_request('usergroup', 0, 1);
				if(empty($orderby1)){
					$orderby1 = 'ct';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				$this->assign("orderby2", $orderby2);
				if($start){
					$where .= " AND mstart >='".$start." 00:00:00'";
				}
				if($end){
					$where .= " AND mend <='".$end." 23:59:59'";
				}
				if($usergroup){
					$where .= " AND groupname='$usergroup'";
				}
				if($username){
					$where .= " AND luser like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND luser IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND device_ip like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND device_ip IN('".implode("','", $alltmpip)."')";
				}

				if($derive==1){
					$reports = $this->devlogin_statistic_set->select_all($where, $orderby1, $orderby2);
					$str = "日期:\t".$start."\t到\t".$end."\n";
					$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("服务器IP")."\t".language("主机名")." \t".language("协议")."\t".language("系统用户")." \t".language("登录次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
					$id=1;
					if($reports)
					foreach ($reports AS $report){		
						$str .= ($id++)."\t".$report['luser']."\t".$report['realname']."\t".$report['groupname']."\t".$report['device_ip']."\t".$report['hostname']."\t".$report['type']."\t".$report['user']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
						$str .= "\n";
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=DevLoginReport.xls"); 
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					exit();
				}else if($derive==4){
					$reports = $this->devlogin_statistic_set->select_all($where, $orderby1, $orderby2);
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','主机名'), iconv('UTF-8','GBK','协议'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','登录次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
					$w = array(12, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					if($reports)
					foreach ($reports AS $report){	
						$pdf->Row(array(++$id, $report['luser'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['device_ip']), iconv('UTF-8','GBK',$report['hostname']), iconv('UTF-8','GBK',$report['user']), iconv('UTF-8','GBK',$report['type']), iconv('UTF-8','GBK',$report['user']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
				}else if($derive==2){
					$reports = $this->devlogin_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $reports);
					$this->display('devloginreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=DevLoginReport.html"); 
					echo $str;
					exit();
				}else if($derive==3){//word
					$reports = $this->devlogin_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $reports);
					$this->display('devloginreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=DevLoginReport.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}
				$row_num = $this->devlogin_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->devlogin_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("reports", $allcommand);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('devloginreport_statistic.tpl');
			break;

			case 'applogin_statistic':
				$where = $dateinterval!='diy' ? " mstart >= '$start' AND mend <= '$end'" : " createid='$diy_id'";
				$this->applogin_statistic_set->set_table_name('applogin_'.$dateinterval);
				$number = get_request('number');
				$start = get_request('f_rangeStart', 0, 1);
				$end = get_request('f_rangeEnd', 0, 1);
				$derive = get_request('derive');
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$usergroup = get_request('usergroup', 0, 1);
				if(empty($orderby1)){
					$orderby1 = 'ct';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				$this->assign("orderby2", $orderby2);
				
				if($start){
					$where .= " AND mstart >='".$start." 00:00:00'";
				}
				if($end){
					$where .= " AND mend <='".$end." 23:59:59'";
				}
				if($usergroup){
					$where .=" AND groupname='$usergroup'";
				}
				if($username){
					$where .= " AND user like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND user IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND serverip like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND serverip IN('".implode("','", $alltmpip)."')";
				}
				if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
					if($_CONFIG['DEPART_ADMIN']){
						$alltmpip = array(0);
						$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allips); $i++){
							$alltmpip[]=$allips[$i]['device_ip'];
						}
						$where .= " AND serverip IN ('".implode("','", $alltmpip)."')";
					}else{
						$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allusers); $i++){
							$alltmpuser[]=$allusers[$i]['username'];
						}
						if($alltmpuser)
						$where .= " AND user IN ('".implode("','", $alltmpuser)."')";
					}
				}
				if($derive==1){
					$reports = $this->applogin_statistic_set->select_all($where, $orderby1, $orderby2);		
					$str = "日期:\t".$start."\t到\t".$end."\n";
					$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("服务器IP")."\t".language("应用名称")." \t".language("程序路径")." \t".language("URL")." \t".language("登录次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
					$id=1;
					if($reports)
					foreach ($reports AS $report){		
						$str .= ($id++)."\t".$report['user']."\t".$report['realname']."\t".$report['groupname']."\t".$report['serverip']."\t".$report['appname']."\t".$report['apppath']."\t".$report['url']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
						$str .= "\n";
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=AppLoginReport.xls"); 
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					exit();
				}else if($derive==4){
					$reports = $this->applogin_statistic_set->select_all($where, $orderby1, $orderby2);		
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','应用名称'), iconv('UTF-8','GBK','程序路径'), iconv('UTF-8','GBK','URL'), iconv('UTF-8','GBK','登录次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
					$w = array(12, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					if($reports)
					foreach ($reports AS $report){	
						$pdf->Row(array(++$id, $report['luser'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['serverip']), iconv('UTF-8','GBK',$report['appname']), iconv('UTF-8','GBK',$report['apppath']), iconv('UTF-8','GBK',$report['user']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
				}else if($derive==2){
					$reports = $this->applogin_statistic_set->select_all($where, $orderby1, $orderby2);			
					ob_start();
					$this->assign('reports', $reports);
					$this->display('apploginreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=AppLoginReport.html"); 
					echo $str;
					exit();
				}else if($derive==3){//word
					$reports = $this->applogin_statistic_set->select_all($where, $orderby1, $orderby2);	
					ob_start();
					$this->assign('reports', $reports);
					$this->display('apploginreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=AppLoginReport.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}
				$row_num = $this->applogin_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand = $this->applogin_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("reports", $allcommand);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('apploginreport_statistic.tpl');
			break;

			case 'loginapproved_statistic':
				$where = $dateinterval!='diy' ? " logintime >= '$start' AND logintime <= '$end'" : " createid='$diy_id'";
				$this->loginapproved_statistic_set->set_table_name('loginapproved_'.$dateinterval);
				$orderby1 = get_request("orderby1", 0, 1);
				$orderby2 = get_request("orderby2", 0, 1);
				$webuser = get_request("webuser", 0, 1);
				$ip = get_request("ip", 0, 1);
				$username = get_request("username", 0, 1);
				$start = get_request("start", 0, 1);
				$usergroup = get_request('usergroup', 0, 1);
				//$where = 'level < 10 AND level!=2';
				
				if($username){
					$where .= " AND webuser like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND webuser IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND ip like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND ip IN('".implode("','", $alltmpip)."')";
				}

				if($webuser){
					$where .= " AND webuser like '%".$webuser."%'";
				}
				if($ip){
					$where .= " AND ip like '%".$ip."%'";
				}

				if($start){
					$where .= " AND logintime>'".$start."'";
				}
				if($usergroup){
					$where .=" AND groupname='$usergroup'";
				}

				if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
					if($_CONFIG['DEPART_ADMIN']){
						$alltmpip = array(0);
						$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allips); $i++){
							$alltmpip[]=$allips[$i]['device_ip'];
						}
						$where .= " AND ".$this->login4approve_set->get_table_name().".ip IN ('".implode("','", $alltmpip)."')";
					}else{
						$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allusers); $i++){
							$alltmpuser[]=$allusers[$i]['username'];
						}
						if($alltmpuser)
						$where .= " AND ".$this->login4approve_set->get_table_name().".webuser IN ('".implode("','", $alltmpuser)."')";
					}
				}				

				if(empty($orderby1)){
					$orderby1 = 'username';
				}
				if(strcasecmp($orderby2, 'asc') != 0 ) {
					$orderby2 = 'asc';
				}else{
					$orderby2 = 'desc';
				}
				$this->assign("orderby2", $orderby2);

				if($derive==1){
					$allmember = $this->loginapproved_statistic_set->select_all($where, $orderby1, $orderby2);
					for($i=0;$i<count($allmember);$i++) {
						foreach($alltem as $tem) {
							if($allmember[$i]['login_method'] == $tem['id']) {
								$allmember[$i]['login_method'] = $tem['login_method'];
							}
						}
					}
					$str = "日期:\t".$start."\t到\t".$end."\n";
					$str .= language("序号")."\t".language("用户名")."\t".language("别名")."\t".language("运维组")."\t".language("服务器IP")."\t".language("系统用户名")." \t".language("登录协议")." \t".language("申请时间")." \t".language("审批时间")." \t".language("申请人")." \t".language("登录时间")."\t\n";
					$id=1;
					foreach ($allmember AS $report){		
						$str .= ($id++)."\t".$report['webuser']."\t".$report['realname']."\t".$report['groupname']."\t".$report['ip']."\t".$report['username']."\t".$report['login_method']."\t".$report['applytime']."\t".$report['approvetime']."\t".$report['approveuser']."\t".$report['logintime'];
						$str .= "\n";
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=AppLoginReport.xls"); 
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					exit();
				}else if($derive==4){
					$reports = $this->loginapproved_statistic_set->select_all($where, $orderby1, $orderby2);
					for($i=0;$i<count($reports);$i++) {
						foreach($alltem as $tem) {
							if($reports[$i]['login_method'] == $tem['id']) {
								$reports[$i]['login_method'] = $tem['login_method'];
							}
						}
					}
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','用户名'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','系统用户名'), iconv('UTF-8','GBK','登录协议'), iconv('UTF-8','GBK','申请时间'), iconv('UTF-8','GBK','审批时间'), iconv('UTF-8','GBK','申请人'), iconv('UTF-8','GBK','登录时间'));
					$w = array(20, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					if($reports)
					foreach ($reports AS $report){	
						$pdf->Row(array(++$id, $report['webuser'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['ip']), iconv('UTF-8','GBK',$report['username']), iconv('UTF-8','GBK',$report['login_method']), iconv('UTF-8','GBK',$report['applytime']), iconv('UTF-8','GBK',$report['approvetime']), iconv('UTF-8','GBK',$report['approveuser']), iconv('UTF-8','GBK',$report['logintime'])), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
				}else if($derive==2){
					$allmember = $this->loginapproved_statistic_set->select_all($where, $orderby1, $orderby2);
					for($i=0;$i<count($allmember);$i++) {
						foreach($alltem as $tem) {
							if($allmember[$i]['login_method'] == $tem['id']) {
								$allmember[$i]['login_method'] = $tem['login_method'];
							}
						}
					}
					ob_start();
					$this->assign('reports', $allmember);
					$this->display('loginapproved_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=AppLoginReport.html"); 
					echo $str;
					exit();
				}else if($derive==3){
					$allmember = $this->loginapproved_statistic_set->select_all($where, $orderby1, $orderby2);
					for($i=0;$i<count($allmember);$i++) {
						foreach($alltem as $tem) {
							if($allmember[$i]['login_method'] == $tem['id']) {
								$allmember[$i]['login_method'] = $tem['login_method'];
							}
						}
					}
					ob_start();
					$this->assign('reports', $allmember);
					$this->display('loginapproved_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=AppLoginReport.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}		
				$row_num = $this->loginapproved_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->loginapproved_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("approves", $allcommand);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('loginapproved_statistic.tpl');
			break;

			case 'command_statistic':
				$where = $dateinterval!='diy' ? " mstart >= '$start' AND mend <= '$end'" : " createid='$diy_id'";
				$this->commandstatistic_set->set_table_name('commandstatistic_'.$dateinterval);
				$start = get_request('f_rangeStart', 0, 1);
				$end = get_request('f_rangeEnd', 0, 1);
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$usergroup = get_request('usergroup', 0, 1);
				if(empty($orderby1)){
					$orderby1 = 'ct';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				$this->assign("orderby2", $orderby2);
				
				if($start){
					$where .= " AND mstart >='".$start." 00:00:00'";
				}
				if($end){
					$where .= " AND mend <='".$end." 23:59:59'";
				}
				if($usergroup){
					$where .=" AND groupname='$usergroup'";
				}
				if($username){
					$where .= " AND luser like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND luser IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND addr like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND addr IN('".implode("','", $alltmpip)."')";
				}

				if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
					if($_CONFIG['DEPART_ADMIN']){
						$alltmpip = array(0);
						$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allips); $i++){
							$alltmpip[]=$allips[$i]['device_ip'];
						}
						$where .= " AND LEFT(addr,IF(LOCATE(':',addr)>0,LOCATE(':',addr)-1,LENGTH(addr))) IN ('".implode("','", $alltmpip)."')";
					}else{
						$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allusers); $i++){
							$alltmpuser[]=$allusers[$i]['username'];
						}
						if($alltmpuser)
						$where .= " AND luser IN ('".implode("','", $alltmpuser)."')";
					}
				}
				if($derive==1){
					$reports = $this->commandstatistic_set->select_all($where, $orderby1, $orderby2);
					$str = "日期:\t".$start."\t 到 \t".$end."\n";
					$str .= language("序号")."\t".language("堡垒机用户")."\t".language("别名")."\t".language("运维组")."\t".language("系统用户")."\t".language("登录主机")." \t".language("命令次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
					$id=1;
					if($reports)
					foreach ($reports AS $report){		
						$str .= ($id++)."\t".$report['luser']."\t".$report['realname']."\t".$report['groupname']."\t".$report['user']."\t".$report['device_ip']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
						$str .= "\n";
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=CommandReport.xls"); 
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					exit();
				
				}else if($derive==4){
					$reports = $this->commandstatistic_set->select_all($where, $orderby1, $orderby2);
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','堡垒机用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','登录主机'), iconv('UTF-8','GBK','命令次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
					$w = array(20, 22, 22, 22, 22, 22, 22, 22, 22);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					if($reports)
					foreach ($reports AS $report){	
						$pdf->Row(array(++$id, iconv('UTF-8','GBK',$report['luser']), iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), $report['user'], iconv('UTF-8','GBK',$report['device_ip']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
				}else if($derive==2){
					$reports = $this->commandstatistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $reports);
					$this->display('commandreport_for_export.tpl');
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
				}else if($derive==3){//word
					$reports = $this->commandstatistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $reports);
					$this->display('commandreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=auditreports.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}
				$row_num = $this->commandstatistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->commandstatistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("reports", $allcommand);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('commandstatistic.tpl');
			break;

			case 'cmdcache_statistic':
				$where = $dateinterval!='diy' ? " at >= '$start' AND at <= '$end'" : " createid='$diy_id'";
				$this->cmdcache_statistic_set->set_table_name('cmdcache_'.$dateinterval);
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$usergroup = get_request('usergroup', 0, 1);
				if(empty($orderby1)){
					$orderby1 = 'ocmd';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				$this->assign("orderby2", $orderby2);
				if($usergroup){
					$where .=" AND groupname='$usergroup'";
				}
				if($username){
					$where .= " AND luser like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND luser IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND addr like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND addr IN('".implode("','", $alltmpip)."')";
				}
				$row_num = $this->cmdcache_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->cmdcache_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("allcommand", $allcommand);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('cmdcachereport_statistic.tpl');
			break;

			case 'cmdlist_statistic':
				$where = $dateinterval!='diy' ? " at >= '$start' AND at <= '$end'" : " createid='$diy_id'";
				$this->cmdlist_statistic_set->set_table_name('cmdlist_'.$dateinterval);
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$ip = get_request('ip', 0, 1);
				$luser = get_request('luser', 0, 1);
				$start = get_request('f_rangeStart', 0, 1);
				$end = get_request('f_rangeEnd', 0, 1);
				if(empty($orderby1)){
					$orderby1 = 'cmd';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				if($ip){
					$where .= " AND addr like '%$ip%'";
				}
				if($luser){
					$where .= " AND luser='$luser'";
				}
				if($start){
					$where .= " AND at >= '$start'";
				}
				if($end){
					$where .= " AND at <= '$end'";
				}
				if($username){
					$where .= " AND luser like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND luser IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND addr like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND addr IN('".implode("','", $alltmpip)."')";
				}
				if($derive==1){
					$allmember = $this->cmdlist_statistic_set->select_all($where, $orderby1, $orderby2);
					$str = "日期:\t".$start."\t到\t".$end."\n";
					$str .= language("序号")."\t".language("运维用户")."\t".language("设备IP")."\t".language("执行时间")."\t".language("命令")."\t".language("级别")."\t\n";
					$id=1;
					foreach ($allmember AS $report){
						switch($report['dangerlevel']){
							case 0:
								$slevel = '正常';
							break;
							case 1:
								$slevel = '危险';
							break;
							case 2:
								$slevel = '严重';
							break;
							case 3:
								$slevel = '警告';
							break;
							case 4:
								$slevel = '复核';
							break;
						}
						$str .= ($id++)."\t".$report['luser']."\t".$report['addr']."\t".$report['at']."\t".$report['cmd']."\t".$slevel."\t";
						$str .= "\n";
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=AppLoginReport.xls"); 
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					exit();
				}else if($derive==4){
					$reports = $this->cmdlist_statistic_set->select_all($where, $orderby1, $orderby2);
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','设备IP'), iconv('UTF-8','GBK','执行时间'), iconv('UTF-8','GBK','命令'), iconv('UTF-8','GBK','级别'));
					$w = array(20, 36, 36, 36, 36, 36);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					if($reports)
					foreach ($reports AS $report){	
						switch($report['dangerlevel']){
							case 0:
								$slevel = '正常';
							break;
							case 1:
								$slevel = '危险';
							break;
							case 2:
								$slevel = '严重';
							break;
							case 3:
								$slevel = '警告';
							break;
							case 4:
								$slevel = '复核';
							break;
						}
						$pdf->Row(array(++$id, $report['luser'], iconv('UTF-8','GBK',$report['addr']), iconv('UTF-8','GBK',$report['at']), iconv('UTF-8','GBK',$report['cmd']), iconv('UTF-8','GBK',$slevel)), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
				}else if($derive==2){
					$allmember = $this->cmdlist_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $allmember);
					$this->display('cmdlistreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=AppLoginReport.html"); 
					echo $str;
					exit();
				}else if($derive==3){
					$allmember = $this->cmdlist_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $allmember);
					$this->display('cmdlistreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=AppLoginReport.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}		
				$row_num = $this->cmdlist_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->cmdlist_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("allcommand", $allcommand);
				$users = $this->member_set->select_all('1=1','username', 'ASC');
				$this->assign('users', $users);
				$servers = $this->server_set->select_all('1=1','device_ip', 'ASC');
				$this->assign('servers', $servers);
				$this->display('cmdlistreport_statistic.tpl');
			break;

			case 'app_statistic':
				$where = $dateinterval!='diy' ? " mstart >= '$start' AND mend <= '$end'" : " createid='$diy_id'";
				$this->app_statistic_set->set_table_name('appreport_'.$dateinterval);
				$number = get_request('number');
				$start = get_request('f_rangeStart', 0, 1);
				$end = get_request('f_rangeEnd', 0, 1);
				$derive = get_request('derive');
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$usergroup = get_request('usergroup', 0, 1);
				if(empty($orderby1)){
					$orderby1 = 'ct';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				$this->assign("orderby2", $orderby2);
				if($start){
					$where .= " AND mstart >='".$start." 00:00:00'";
				}
				if($end){
					$where .= " AND mend <='".$end." 23:59:59'";
				}
				if($usergroup){
					$where .=" AND groupname='$usergroup'";
				}
				if($username){
					$where .= " AND luser like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND luser IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND serverip like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND serverip IN('".implode("','", $alltmpip)."')";
				}

				if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
					if($_CONFIG['DEPART_ADMIN']){
						$alltmpip = array(0);
						$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allips); $i++){
							$alltmpip[]=$allips[$i]['device_ip'];
						}
						$where .= " AND LEFT(serverip,IF(LOCATE(':',serverip)>0,LOCATE(':',serverip)-1,LENGTH(serverip))) IN ('".implode("','", $alltmpip)."')";
					}else{
						$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allusers); $i++){
							$alltmpuser[]=$allusers[$i]['username'];
						}
						if($alltmpuser)
						$where .= " AND user IN ('".implode("','", $alltmpuser)."')";
					}
				}
				if($derive==1){
					$reports = $this->app_statistic_set->select_all($where, $orderby1, $orderby2);	
					$str = "日期:\t".$start."\t 到 \t".$end."\n";
					$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("系统用户")."\t".language("应用名称")." \t".language("命令次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
					$id=1;
					if($reports)
					foreach ($reports AS $report){		
						$str .= ($id++)."\t".$report['luser']."\t".$report['realname']."\t".$report['groupname']."\t".$report['user']."\t".$report['appname']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
						$str .= "\n";
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=AuditReport.xls"); 
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					exit();
				}else if($derive==4){
					$reports = $this->app_statistic_set->select_all($where, $orderby1, $orderby2);	
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','应用名称'), iconv('UTF-8','GBK','命令次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
					$w = array(20, 22, 22, 22, 22, 22, 22, 22, 22);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					if($reports)
					foreach ($reports AS $report){	
						$pdf->Row(array(++$id, $report['luser'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['user']), iconv('UTF-8','GBK',$report['appname']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
				}else if($derive==2){
					$reports = $this->app_statistic_set->select_all($where, $orderby1, $orderby2);			
					ob_start();
					$this->assign('reports', $reports);
					$this->display('appreport_for_export.tpl');
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
				}else if($derive==3){//word
					$reports = $this->app_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $reports);
					$this->display('appreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=auditreports.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}
				$row_num = $this->app_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->app_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("reports", $allcommand);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('appreport_statistic.tpl');
			break;

			case 'sftpcmd_statistic':
				$where = $dateinterval!='diy' ? " mstart >= '$start' AND mend <= '$end'" : " createid='$diy_id'";
				$this->sftpcmd_statistic_set->set_table_name('sftpreport_'.$dateinterval);
				$number = get_request('number');
				$start = get_request('f_rangeStart', 0, 1);
				$end = get_request('f_rangeEnd', 0, 1);
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$usergroup = get_request('usergroup', 0, 1);
				if(empty($orderby1)){
					$orderby1 = 'ct';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				$this->assign("orderby2", $orderby2);
				
				if($start){
					$where .= " AND mstart >='".$start." 00:00:00'";
				}
				if($end){
					$where .= " AND mend <='".$end." 23:59:59'";
				}
				if($usergroup){
					$where .=" AND groupname='$usergroup'";
				}
				if($username){
					$where .= " AND radius_user like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND radius_user IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND resource like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND resource IN('".implode("','", $alltmpip)."')";
				}
				if($derive==1){
					$reports = $this->sftpcmd_statistic_set->select_all($where, $orderby1, $orderby2);
					$str = "日期:\t".$start."\t 到 \t".$end."\n";
					$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("系统用户")."\t".language("上载次数")."\t".language("下载次数")." \t".language("命令次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
					$id=1;
					if($reports)
					foreach ($reports AS $report){		
						$str .= ($id++)."\t".$report['radius_user']."\t".$report['realname']."\t".$report['groupname']."\t".$report['sftp_user']."\t".$report['putct']."\t".$report['getct']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
						$str .= "\n";
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=AuditReport.xls"); 
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					exit();
				}else if($derive==4){
					$reports = $this->sftpcmd_statistic_set->select_all($where, $orderby1, $orderby2);
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','上载次数'), iconv('UTF-8','GBK','下载次数'), iconv('UTF-8','GBK','命令次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
					$w = array(12, 20, 20, 20, 20, 20, 20, 20, 20, 20);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					if($reports)
					foreach ($reports AS $report){	
						$pdf->Row(array(++$id, $report['radius_user'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['sftp_user']), iconv('UTF-8','GBK',$report['putct']), iconv('UTF-8','GBK',$report['getct']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
				}else if($derive==2){
					$reports = $this->sftpcmd_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $reports);
					$this->display('sftpreport_for_export.tpl');
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
				}else if($derive==3){//word
					$reports = $this->sftpcmd_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $reports);
					$this->display('sftpreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=auditreports.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}
				$row_num = $this->sftpcmd_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->sftpcmd_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("reports", $allcommand);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('sftpreport_statistic.tpl');
			break;

			case 'ftpcmd_statistic':
				$where = $dateinterval!='diy' ? " mstart >= '$start' AND mend <= '$end'" : " createid='$diy_id'";
				$this->ftpcmd_statistic_set->set_table_name('ftpreport_'.$dateinterval);
				$start = get_request('f_rangeStart', 0, 1);
				$end = get_request('f_rangeEnd', 0, 1);
				$derive = get_request('derive');
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$usergroup = get_request('usergroup', 0, 1);
				if(empty($orderby1)){
					$orderby1 = 'ct';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				$this->assign("orderby2", $orderby2);
				
				if($start){
					$where .= " AND mstart >='".$start." 00:00:00'";
				}
				if($end){
					$where .= " AND mend <='".$end." 23:59:59'";
				}
				if($usergroup){
					$where .=" AND groupname='$usergroup'";
				}
				if($username){
					$where .= " AND radius_user like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND radius_user IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND resource like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND resource IN('".implode("','", $alltmpip)."')";
				}

				if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
					if($_CONFIG['DEPART_ADMIN']){
						$alltmpip = array(0);
						$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allips); $i++){
							$alltmpip[]=$allips[$i]['device_ip'];
						}
						$wheret .= " AND LEFT(a.svraddr,IF(LOCATE(':',a.svraddr)>0,LOCATE(':',a.svraddr)-1,LENGTH(a.svraddr))) IN ('".implode("','", $alltmpip)."')";
					}else{
						$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allusers); $i++){
							$alltmpuser[]=$allusers[$i]['username'];
						}
						if($alltmpuser)
						$wheret .= " AND radius_user IN ('".implode("','", $alltmpuser)."')";
					}
				}
				if($derive==1){
					$reports = $this->ftpcmd_statistic_set->select_all($where, $orderby1, $orderby2);	
					$str = "日期:\t".$start."\t 到 \t".$end."\n";
					$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("系统用户")."\t".language("上载次数")."\t".language("下载次数")." \t".language("命令次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
					$id=1;
					if($reports)
					foreach ($reports AS $report){		
						$str .= ($id++)."\t".$report['radius_user']."\t".$report['realname']."\t".$report['groupname']."\t".$report['ftp_user']."\t".$report['putct']."\t".$report['getct']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
						$str .= "\n";
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=AuditReport.xls"); 
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					exit();
				}else if($derive==4){
					$reports = $this->ftpcmd_statistic_set->select_all($where, $orderby1, $orderby2);
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','上载次数'), iconv('UTF-8','GBK','下载次数'), iconv('UTF-8','GBK','命令次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
					$w = array(12, 20, 20, 20, 20, 20, 20, 20, 20, 20);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					if($reports)
					foreach ($reports AS $report){	
						$pdf->Row(array(++$id, $report['radius_user'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['ftp_user']), iconv('UTF-8','GBK',$report['putct']), iconv('UTF-8','GBK',$report['getct']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
				}else if($derive==2){
					$reports = $this->ftpcmd_statistic_set->select_all($where, $orderby1, $orderby2);		
					ob_start();
					$this->assign('reports', $reports);
					$this->display('ftpreport_for_export.tpl');
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
				}else if($derive==3){//word
					$reports = $this->ftpcmd_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $reports);
					$this->display('ftpreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=auditreports.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}
				$row_num = $this->ftpcmd_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->ftpcmd_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("reports", $allcommand);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('ftpreport_statistic.tpl');
			break;

			case 'dangercmd_statistic':
				$where = $dateinterval!='diy' ? " mstart >= '$start' AND mend <= '$end'" : " createid='$diy_id'";
				$this->dangercmd_statistic_set->set_table_name('dangercmdreport_'.$dateinterval);
				$start = get_request('f_rangeStart', 0, 1);
				$end = get_request('f_rangeEnd', 0, 1);
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$usergroup = get_request('usergroup', 0, 1);
				if(empty($orderby1)){
					$orderby1 = 'ct';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				$this->assign("orderby2", $orderby2);

				if($start){
					$where .= " AND mstart >='".$start." 00:00:00'";
				}
				if($end){
					$where .= " AND mend <='".$end." 23:59:59'";
				}
				if($usergroup){
					$where .=" AND groupname='$usergroup'";
				}
				if($username){
					$where .= " AND luser like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND luser IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND device_ip like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND device_ip IN('".implode("','", $alltmpip)."')";
				}

				if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
					if($_CONFIG['DEPART_ADMIN']){
						$alltmpip = array(0);
						$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allips); $i++){
							$alltmpip[]=$allips[$i]['device_ip'];
						}
						$where .= " AND device_ip IN ('".implode("','", $alltmpip)."')";
					}else{
						$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allusers); $i++){
							$alltmpuser[]=$allusers[$i]['username'];
						}
						if($alltmpuser)
						$where .= " AND user IN ('".implode("','", $alltmpuser)."')";
					}
				}
				if($derive==1){
					$reports = $this->dangercmd_statistic_set->select_all($where, $orderby1, $orderby2);
					$str = "日期:\t".$start."\t 到 \t".$end."\n";
					$str .= language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("系统用户")."\t".language("服务器IP")."\t".language("违规命令")." \t".language("命令次数")." \t".language("开始日期")." \t".language("结束日期")."\t\n";
					$id=1;
					if($reports)
					foreach ($reports AS $report){		
						$str .= ($id++)."\t".$report['user']."\t".$report['realname']."\t".$report['groupname']."\t".$report['luser']."\t".$report['device_ip']."\t".$report['cmd']."\t".$report['ct']."\t".$report['mstart']."\t".$report['mend'];
						$str .= "\n";
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=AuditReport.xls"); 
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					exit();
				}else if($derive==4){
					$reports = $this->dangercmd_statistic_set->select_all($where, $orderby1, $orderby2);
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'),  iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','违规命令'), iconv('UTF-8','GBK','命令次数'), iconv('UTF-8','GBK','开始日期'), iconv('UTF-8','GBK','结束日期'));
					$w = array(20, 20, 20, 20, 20, 20, 20, 20, 20, 20);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					if($reports)
					foreach ($reports AS $report){	
						$pdf->Row(array(++$id, $report['user'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['luser']), iconv('UTF-8','GBK',$report['device_ip']), iconv('UTF-8','GBK',$report['cmd']), iconv('UTF-8','GBK',$report['ct']), iconv('UTF-8','GBK',$report['mstart']), iconv('UTF-8','GBK',$report['mend'])), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
				}else if($derive==2){
					$reports = $this->dangercmd_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $reports);
					$this->display('dangercmdreport_for_export.tpl');
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
				}else if($derive==3){//word
					$reports = $this->dangercmd_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $reports);
					$this->display('dangercmdreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=auditreports.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}
				$row_num = $this->dangercmd_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->dangercmd_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("reports", $allcommand);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('dangercmdreport_statistic.tpl');
			break;

			case 'dangercmdlist_statistic':
				$where = $dateinterval!='diy' ? " at >= '$start' AND at <= '$end'" : " createid='$diy_id'";
				$this->dangercmdlist_statistic_set->set_table_name('dangercmdlistreport_'.$dateinterval);
				$start = get_request('f_rangeStart', 0, 1);
				$end = get_request('f_rangeEnd', 0, 1);
				$derive = get_request('derive');
				$orderby1 = get_request('orderby1', 0, 1);
				$orderby2 = get_request('orderby2', 0, 1);
				$usergroup = get_request('usergroup', 0, 1);
				if(empty($orderby1)){
					$orderby1 = 'at';
				}
				if(strcasecmp($orderby2, 'desc') != 0 ) {
					$orderby2 = 'desc';
				}else{
					$orderby2 = 'asc';
				}
				$this->assign("orderby2", $orderby2);
				
				if($start){
					$where .= " AND at >='".$start." 00:00:00'";
				}
				if($end){
					$where .= " AND at <='".$end." 23:59:59'";
				}
				if($usergroup){
					$where .=" AND groupname='$usergroup'";
				}
				if($username){
					$where .= " AND luser like '%$username%'" ;
				}elseif($ugroupid){
					$where .= " AND luser IN('".implode("','", $alltmpusername)."')";
				}
				if($server){
					$where .= " AND device_ip like '%$server%'" ;
				}elseif($ugroupid){
					$where .= " AND device_ip IN('".implode("','", $alltmpip)."')";
				}
				if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
					if($_CONFIG['DEPART_ADMIN']){
						$alltmpip = array(0);
						$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allips); $i++){
							$alltmpip[]=$allips[$i]['device_ip'];
						}
						$where .= " AND device_ip IN ('".implode("','", $alltmpip)."')";
					}else{
						$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
						for($i=0; $i<count($allusers); $i++){
							$alltmpuser[]=$allusers[$i]['username'];
						}
						if($alltmpuser)
						$where .= " AND luser IN ('".implode("','", $alltmpuser)."')";
					}
				}
				if($derive==1){
					$reports = $this->dangercmdlist_statistic_set->select_all($where, $orderby1, $orderby2);
					$str = "日期:\t".$start."\t 到 \t".$end."\n";
					$str .=  language("序号")."\t".language("运维用户")."\t".language("别名")."\t".language("运维组")."\t".language("服务器IP")."\t".language("登录协议")."\t".language("系统用户")." \t".language("违规命令")." \t".language("违规级别")." \t".language("操作时间")."\n";
					$id=1;
					if($reports)
					foreach ($reports AS $report){		
						
						$str .= ($id++)."\t".$report['luser']."\t".$report['realname']."\t".$report['groupname']."\t".$report['device_ip']."\t".$report['type']."\t".$report['user']."\t".$report['cmd']."\t".($report['dangerlevel']==1 ? '命令阻断' : ($report['dangerlevel']==2 ? '断开连接' : '命令告警' ))."\t".$report['at'];
						$str .= "\n";
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=DangerCmdListReport.xls"); 
					echo mb_convert_encoding($str, "GBK", "UTF-8");
					exit();
				}else if($derive==4){
					$reports = $this->dangercmdlist_statistic_set->select_all($where, $orderby1, $orderby2);
					$pdf=new PDF_Chinese('P','mm','A4');
					$pdf->AddGBFont(); 
					$pdf->Open();
					$pdf->SetFont('GB','',12); 
					$pdf->AddPage();			
					$pdf->SetFillColor(224,235,255);
					$pdf->SetTextColor(0);
					$pdf->SetFont('');
					// Column headings
					$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','运维用户'), iconv('UTF-8','GBK','别名'), iconv('UTF-8','GBK','运维组'), iconv('UTF-8','GBK','服务器IP'), iconv('UTF-8','GBK','登录协议'), iconv('UTF-8','GBK','系统用户'), iconv('UTF-8','GBK','违规命令'), iconv('UTF-8','GBK','违规级别'), iconv('UTF-8','GBK','操作时间'));
					$w = array(20, 20, 20, 20, 20, 20, 20, 20, 20, 20);
					// Data loading
					$i=0; $id=0; 
					$pdf->SetWidths($w);
					$pdf->Row($header, $fill);
					$fill = false;
					if($reports)
					foreach ($reports AS $report){	
						$pdf->Row(array(++$id, $report['luser'], iconv('UTF-8','GBK',$report['realname']), iconv('UTF-8','GBK',$report['groupname']), iconv('UTF-8','GBK',$report['device_ip']), iconv('UTF-8','GBK',$report['type']), iconv('UTF-8','GBK',$report['user']), iconv('UTF-8','GBK',$report['cmd']), iconv('UTF-8','GBK',($report['dangerlevel']==1 ? '命令阻断' : ($report['dangerlevel']==2 ? '断开连接' : '命令告警' ))), iconv('UTF-8','GBK',$report['at'])), $fill);
						$fill = !$fill;

					}
					//$pdf->FancyTable($header,$data,$w);
					if($_GET['derive_forcron']){
						echo $pdf->buffer;
						return ;
					}
					$pdf->Output();
					exit;
				}else if($derive==2){
					$reports = $this->dangercmdlist_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $reports);
					$this->display('dangercmdlistreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					Header("Content-type: application/octet-stream"); 
					Header("Content-Disposition: attachment; filename=DangerCmdListReport.html"); 
					echo $str;
					exit();
				}else if($derive==3){//word
					$reports = $this->dangercmdlist_statistic_set->select_all($where, $orderby1, $orderby2);
					ob_start();
					$this->assign('reports', $reports);
					$this->display('dangercmdlistreport_for_export.tpl');
					$str = ob_get_clean();
					if($_GET['derive_forcron']){
						echo $str;
						return ;
					}
					Header('Cache-Control: private, must-revalidate, max-age=0');
					header("Content-type:application/vnd.ms-doc;");
					header("Content-Disposition: attachment;filename=DangerCmdListReport.doc");
					echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
							xmlns:w=urn:schemas-microsoft-com:office:word 
							xmlns= target=_blank>";
					echo $str;
					echo "</html>"; 
					exit();
				}
				$row_num = $this->dangercmdlist_statistic_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('session_num', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);				
				$allcommand =  $this->dangercmdlist_statistic_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
				$this->assign("reports", $allcommand);
				$usergroup = $this->usergroup_set->select_all('level=0  '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
				$this->assign('usergroup', $usergroup);
				$this->display('dangercmdlistreport_statistic.tpl');
			break;
			
		}
	}

	function report_search_diy(){
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'b.username';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		$where = "1";
		$row_num = $this->report_diy_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('session_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);				
		$allcommand =  $this->report_diy_set->base_select("SELECT a.*,b.username,b.realname,c.groupname FROM ".$this->report_diy_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." b ON a.uid=b.uid LEFT JOIN ".$this->usergroup_set->get_table_name()." c ON b.groupid=c.id WHERE $where ORDER BY $orderby1 $orderby2 LIMIT ".$newpager->intStartPosition.",".$newpager->intItemsPerPage);
		$this->assign("reports", $allcommand);
		$this->display('report_search_diy.tpl');
	}

	function report_search_diy_edit(){
		global $_CONFIG;
		$users = $this->member_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101 ? ($_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'username', 'ASC');
		$servers = $this->server_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : '')." AND groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")" : ''),'device_ip', 'ASC');
		$sgroups = $this->sgroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101 ? ($_SESSION['ADMIN_MSERVERGROUP']==0 ? ' AND 0' : ' AND id IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).') ') : ''),'groupname', 'ASC');
		
		$ldapidname = 'ldapid';
		$groupidname = 'groupid';
		require('./include/select_sgroup_ajax.inc.php');
		$precl='s';
		$ldapidname = 'sldapid';
		$groupidname = 'sgroupid';
		require('./include/select_sgroup_ajax.inc.php');

		$this->assign('alluser', $users);
		$this->assign('allserver', $servers);
		$this->assign('sgroups', $sgroups);
		$this->assign("_config", $_CONFIG);
		$this->display('report_search_diy_edit.tpl');
	}

	function doreport_search_diy_edit(){
		$type = get_request('type', 0, 1);
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$create = get_request('f_rangeCreate', 0, 1);
		$username = get_request('username', 0, 1);
		$server = get_request('server', 0, 1);
		$ugroupid = $_GET['groupid'];
		$sgroupid = $_GET['sgroupid'];
		if(!empty($username)) $ugroupid = 0;
		if(!empty($server)) $sgroupid = 0;

		if(!is_dir(ROOT.'/at')){
			exec("sudo mkdir -m 0777 ".ROOT.'/at');
		}

		$diy = new report_diy();
		$diy->set_data('uid', $_SESSION['ADMIN_UID']);
		$diy->set_data('type', $type);
		$diy->set_data('start', $start);
		$diy->set_data('end', $end);
		$diy->set_data('username', $username);
		$diy->set_data('server', $server);
		$diy->set_data('ugroupid', $ugroupid);
		$diy->set_data('sgroupid', $sgroupid);
		$diy->set_data('applytime', date('Y-m-d H:i:s'));
		$this->report_diy_set->add($diy);

		$filename = ROOT.'/at/'.$_SESSION['ADMIN_UID'].'_'.time().'_at_'.$type;
		file_put_contents($filename, "php /root/cron_reports.php diy all ".$start." ".$end." ".mysql_insert_id());
		$_date = date_parse($create);
		$cmd = "sudo at -f ".$filename." ".$_date['hour'].":".$_date['minute']." ".$_date['year']."-".$_date['month']."-".$_date['day'];
		exec($cmd);
		alert_and_back('提交成功', 'admin.php?controller=admin_reports&action=report_search_diy');
	}

	function host_reports(){
		$duration = $_GET['duration'];
		$group = $_GET['group'];
		$content = ($_GET['content']!='disk' ? 'cms' : 'disk');
		switch($duration){
			case 'day':
				$ymd = $_GET['date'] ? $_GET['date'] : date('Y-m-d');
				$ymd_arr = explode('-', $ymd);

				$start_time = mktime(0,0,0, $ymd_arr[1], $ymd_arr[2], $ymd_arr[0]);
				$end_time = mktime(0,0,0, $ymd_arr[1], $ymd_arr[2], $ymd_arr[0])+24*60*60-300;		
				$data_table = ' (select * from ratedaylist WHERE UNIX_TIMESTAMP(time) >='.$start_time .' and UNIX_TIMESTAMP(time) <='.$end_time.' ) ld ON lh.id=ld.list_host_id LEFT JOIN ossim.host oh ON  lh.ip=oh.ip ';
				$ymdtitle = $ymd;
				break;
			case 'week':
				$year = $_GET['year'] ? $_GET['year'] : date('Y');
				$month = $_GET['month'] ? $_GET['month'] : date('m');		
				$week = $_GET['week'] ? $_GET['week'] : 1;
				$ymd_arr = array($year,$month,1);
				$ymdtitle = $ymd_arr[0].'年'.$ymd_arr[1].'月第'.$week.'周';
				$w = date('w', mktime(0,0,0, $ymd_arr[1], $ymd_arr[2], $ymd_arr[0]));		
				$start_time = mktime(0,0,0, $ymd_arr[1], $ymd_arr[2]-$w+7*($week-1)+1, $ymd_arr[0]);
				$end_time = mktime(23,59,59, $ymd_arr[1], $ymd_arr[2]-$w+7*($week-1)+1, $ymd_arr[0])+7*24*60*60;
				$data_table = '(select * from rateweeklist WHERE UNIX_TIMESTAMP(time) >='.$start_time .' and UNIX_TIMESTAMP(time) <='.$end_time.' )  ld ON lh.id=ld.list_host_id LEFT JOIN ossim.host oh ON lh.ip=oh.ip ';
				break;
			case 'month':	
				$year = $_GET['myear'] ? $_GET['myear'] : date('Y');
				$month = $_GET['mmonth'] ? $_GET['mmonth'] : date('m');
				$ymd_arr = array($year,$month,date('d'));
				$ymdtitle = $ymd_arr[0].'年'.$ymd_arr[1].'月';
				$start_time = mktime(0,0,0, $ymd_arr[1], 1, $ymd_arr[0]);
				$end_time = mktime(23,59,59, $ymd_arr[1], 1, $ymd_arr[0])+(date('t',mktime(23,59,59,$ymd_arr[1], 1, $ymd_arr[0]))*24*60*60)-7200;
				$data_table = '(select * from ratemonthlist WHERE UNIX_TIMESTAMP(time) >='.$start_time .' and UNIX_TIMESTAMP(time) <='.$end_time.' )  ld ON lh.id=ld.list_host_id LEFT JOIN ossim.host oh ON lh.ip=oh.ip ';
				break;
			default :
				$duration = 'day';
				$ymd = $_GET['date'] ? $_GET['date'] : date('Y-m-d');
				$ymd_e = $_GET['date_e'] ? $_GET['date_e'] : date('Y-m-d');
				$ymdtitle = $ymd.'-'.$ymd_e;
				$ymd_arr = explode('-', $ymd);
				$ymd_arr_e = explode('-', $ymd_e);
				$start_time = mktime(0,0,0, $ymd_arr[1], $ymd_arr[2], $ymd_arr[0]);
				$end_time = mktime(23,59,59, $ymd_arr_e[1], $ymd_arr_e[2], $ymd_arr_e[0]);		
				$data_table = '(select * from ratedaylist WHERE UNIX_TIMESTAMP(time) >='.$start_time .' and UNIX_TIMESTAMP(time) <='.$end_time.' )  ld ON lh.id=ld.list_host_id LEFT JOIN ossim.host oh ON lh.ip=oh.ip ';
		}
		//var_dump(date('Y-m-d H:i:s', $start_time));var_dump(date('Y-m-d H:i:s', $end_time));
		$where = ' datetime >=FROM_UNIXTIME('.$start_time.') AND datetime<=FROM_UNIXTIME('.$end_time.')';
		if ($group) {
			$alltmpip = array(0);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$group." or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$group.") or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$group."))");
			for($i=0; $i<count($allips); $i++){
				$alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND device_ip IN ('".implode("','", $alltmpip)."')";
		}
		include(ROOT."/include/pChart2.1.3/class/pData.class.php"); 
		include(ROOT."/include/pChart2.1.3/class/pDraw.class.php"); 
		include(ROOT."/include/pChart2.1.3/class/pImage.class.php"); 
		if($content=='cms'){
			$cpu = $this->snmp_status_set->base_select("SELECT count(0) ct,CAST(FLOOR(IF(avg_val=100,99,avg_val)/10) AS SIGNED) val FROM snmp_".$duration."_report_cpu WHERE $where  GROUP BY CAST(FLOOR(IF(avg_val=100,99,avg_val)/10) AS SIGNED) ORDER BY CAST(FLOOR(IF(avg_val=100,99,avg_val)/10) AS SIGNED) ASC");
			$memory = $this->snmp_status_set->base_select("SELECT count(0) ct,CAST(FLOOR(IF(avg_val=100,99,avg_val)/10) AS SIGNED) val FROM snmp_".$duration."_report_memory WHERE $where  GROUP BY CAST(FLOOR(IF(avg_val=100,99,avg_val)/10) AS SIGNED) ORDER BY CAST(FLOOR(IF(avg_val=100,99,avg_val)/10) AS SIGNED) ASC");
			$swap = $this->snmp_status_set->base_select("SELECT count(0) ct,CAST(FLOOR(IF(avg_val=100,99,avg_val)/10) AS SIGNED) val FROM snmp_".$duration."_report_swap WHERE $where  GROUP BY CAST(FLOOR(IF(avg_val=100,99,avg_val)/10) AS SIGNED) ORDER BY CAST(FLOOR(IF(avg_val=100,99,avg_val)/10) AS SIGNED) ASC");
			for($i=0; $i<count($cpu); $i++){
				$cpus[$cpu[$i]['val']] = $cpu[$i]['ct'];
			}
			for($i=0; $i<count($memory); $i++){
				$memories[$memory[$i]['val']] = $memory[$i]['ct'];
			}
			for($i=0; $i<count($swap); $i++){
				$swaps[$swap[$i]['val']] = $swap[$i]['ct'];
			}
			for($i=0; $i<10; $i++){
				if(empty($cpus[$i])){
					$cpus[$i]=0;
				}
				if(empty($memories[$i])){
					$memories[$i]=0;
				}
				if(empty($swaps[$i])){
					$swaps[$i]=0;
				}
			}

			$hosts = $this->snmp_status_set->base_select("SELECT cpu.device_ip, cast(cpu.avg_val AS decimal(10,2)) cpu_avg_val, cpu.high_val cpu_high_val, cpu.low_val cpu_low_val,cast(memory.avg_val AS decimal(10,2)) memory_avg_val, memory.high_val memory_high_val, memory.low_val memory_low_val,cast(swap.avg_val AS decimal(10,2)) swap_avg_val, swap.high_val swap_high_val, swap.low_val swap_low_val FROM (SELECT device_ip, AVG(avg_val) avg_val, MAX(high_val) high_val, MIN(low_val) low_val FROM snmp_".$duration."_report_cpu WHERE $where GROUP BY device_ip) cpu LEFT JOIN (SELECT device_ip, AVG(avg_val) avg_val, MAX(high_val) high_val, MIN(low_val) low_val FROM snmp_".$duration."_report_memory WHERE $where GROUP BY device_ip) memory ON cpu.device_ip=memory.device_ip LEFT JOIN  (SELECT device_ip, AVG(avg_val) avg_val, MAX(high_val) high_val, MIN(low_val) low_val FROM snmp_".$duration."_report_swap WHERE $where GROUP BY device_ip) swap ON cpu.device_ip=swap.device_ip WHERE memory.device_ip IS NOT NULL AND swap.device_ip IS NOT NULL");
			//echo '<pre>';var_dump($hosts);echo '</pre>';
			

			/* Create and populate the pData object */ 
			 $MyData = new pData();   
			 $MyData->addPoints($cpus,"CPU"); 
			 $MyData->addPoints($memories,"内存"); 
			 $MyData->addPoints($swaps,"交换分区");
			 $MyData->setAxisName(0,"Hits"); 
			 $MyData->addPoints(array("<10%","10%-20%","20%-30%","30%-40%","40%-50%","50%-60%","60%-70%","70%-80%","80%-90%",">90%"),"Months"); 
			 $MyData->setSerieDescription("Months","Month"); 
			 $MyData->setAbscissa("Months"); 
			 /* Create the pChart object */ 
			 $myPicture = new pImage(900,230,$MyData); 
			 /* Turn of Antialiasing */ 
			 $myPicture->Antialias = FALSE; 
			 /* Add a border to the picture */ 
			 $myPicture->drawGradientArea(0,0,900,230,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>241,"EndG"=>241,"EndB"=>241,"Alpha"=>100)); 
			 $myPicture->drawGradientArea(0,0,900,230,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>241,"EndG"=>241,"EndB"=>241,"Alpha"=>20)); 
			 //$myPicture->drawRectangle(0,0,899,229,array("R"=>0,"G"=>0,"B"=>0)); 
			 /* Set the default font */ 
			 $myPicture->setFontProperties(array("FontName"=>ROOT."/include/pChart2.1.3/fonts/msyh.ttf","FontSize"=>6)); 
			 /* Define the chart area */ 
			 $myPicture->setGraphArea(60,40,850,200); 
			 /* Draw the scale */ 
			 $scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE); 
			 $myPicture->drawScale($scaleSettings); 
			 /* Write the chart legend */ 
			 $myPicture->drawLegend(780,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
			 /* Turn on shadow computing */  
			 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
			 /* Draw the chart */ 
			 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
			 $settings = array("Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0); 
			 $myPicture->drawBarChart($settings); 

			/* Render the picture (choose the best way) */ 
				//var_dump(ROOT."/img/example.drawBarChart.floating.png");
			$myPicture->render(ROOT."/img/host_report.png"); 
			$this->assign("img", "host_report.png");
			$this->assign("reports", $hosts);
		}else{

			$disk = $this->snmp_status_set->base_select("SELECT count(0) ct,CAST(FLOOR(IF(avg_val=100,99,avg_val)/10) AS SIGNED) val FROM snmp_".$duration."_report_disk WHERE $where  GROUP BY CAST(FLOOR(IF(avg_val=100,99,avg_val)/10) AS SIGNED) ORDER BY CAST(FLOOR(IF(avg_val=100,99,avg_val)/10) AS SIGNED) ASC");

			for($i=0; $i<count($disk); $i++){
				$disks[$disk[$i]['val']] = $disk[$i]['ct'];
			}
			for($i=0; $i<10; $i++){
				if(empty($disks[$i])){
					$disks[$i]=0;
				}
			}

			/* Create and populate the pData object */ 
			 $MyData = new pData();   
			 $MyData->addPoints($disks,"硬盘"); 
			 $MyData->setAxisName(0,"Hits"); 
			 $MyData->addPoints(array("<10%","10%-20%","20%-30%","30%-40%","40%-50%","50%-60%","60%-70%","70%-80%","80%-90%",">90%"),"Months"); 
			 $MyData->setSerieDescription("Months","Month"); 
			 $MyData->setAbscissa("Months"); 
			 /* Create the pChart object */ 
			 $myPicture = new pImage(900,230,$MyData); 
			 /* Turn of Antialiasing */ 
			 $myPicture->Antialias = FALSE; 
			 /* Add a border to the picture */ 
			 $myPicture->drawGradientArea(0,0,900,230,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>241,"EndG"=>241,"EndB"=>241,"Alpha"=>100)); 
			 $myPicture->drawGradientArea(0,0,900,230,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>241,"EndG"=>241,"EndB"=>241,"Alpha"=>20)); 
			// $myPicture->drawRectangle(0,0,899,229,array("R"=>0,"G"=>0,"B"=>0)); 
			 /* Set the default font */ 
			 $myPicture->setFontProperties(array("FontName"=>ROOT."/include/pChart2.1.3/fonts/msyh.ttf","FontSize"=>6)); 
			 /* Define the chart area */ 
			 $myPicture->setGraphArea(60,40,850,200); 
			 /* Draw the scale */ 
			 $scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE); 
			 $myPicture->drawScale($scaleSettings); 
			 /* Write the chart legend */ 
			 $myPicture->drawLegend(780,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 
			 /* Turn on shadow computing */  
			 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
			 /* Draw the chart */ 
			 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
			 $settings = array("Surrounding"=>-30,"InnerSurrounding"=>30,"Interleave"=>0); 
			 $myPicture->drawBarChart($settings); 
			 $myPicture->render(ROOT."/img/host_disk_report.png"); 
//echo "SELECT device_ip,GROUP_CONCAT('&nbsp;&nbsp;',CONCAT(avg_val,'%(',disk,')')) avg_val,GROUP_CONCAT(CONCAT(high_val,'%(',disk,')')) high_val,GROUP_CONCAT(CONCAT(low_val,'%(',disk,')')) low_val FROM( SELECT device_ip,disk, AVG(avg_val) avg_val, MAX(high_val) high_val, MIN(low_val) low_val FROM snmp_".$duration."_report_disk WHERE $where GROUP BY device_ip,disk ) disk GROUP BY device_ip";
			 $disks = $this->snmp_status_set->base_select("SELECT device_ip,GROUP_CONCAT('&nbsp;&nbsp;',CONCAT(avg_val,'%(',disk,')')) avg_val,GROUP_CONCAT(CONCAT(high_val,'%(',disk,')')) high_val,GROUP_CONCAT(CONCAT(low_val,'%(',disk,')')) low_val FROM( SELECT device_ip,disk, AVG(avg_val) avg_val, MAX(high_val) high_val, MIN(low_val) low_val FROM snmp_".$duration."_report_disk WHERE $where GROUP BY device_ip,disk ) disk GROUP BY device_ip");

			 $this->assign("img", "host_disk_report.png");

			 $this->assign("reports", $disks);
		}
		$sgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
		$this->assign("pencents", array("<10%","10%-20%","20%-30%","30%-40%","40%-50%","50%-60%","60%-70%","70%-80%","80%-90%",">90%"));
		$this->assign("duration", $duration);
		$this->assign("sgroup", $sgroup);
		$this->assign("ymd", $ymd);
		$this->assign("mktime", time());
		$this->assign("content", $content);
		$this->display("host_reports.tpl");
	}

	function get_v($k){
		switch($k){
			case 'apache_cpu_load':
				return '每秒流量 KB/s';
				break;
			case 'apache_request_rate':
				return '系统占用';
				break;
			case 'apache_traffic_rate':
				return '请求速率';
				break;
			case 'apache_process_num':
				return '当前进行数';
				break;
			case 'apache_busy_process':
				return '正在处理请求';
				break;
			case 'mysql_questions_rate':
				return '打开文件数';
				break;
			case 'mysql_open_tables':
				return '打开表数';
				break;
			case 'mysql_open_files':
				return '连接数';
				break;
			case 'mysql_threads':
				return '查询速率';
				break;
			case 'tomcat_traffic_rate':
				return '每秒流量 KB/s';
				break;
			case 'tomcat_cpu_load':
				return 'CPU平均占用率 %';
				break;
			case 'tomcat_request_rate':
				return '每秒请求数量';
				break;
			case 'tomcat_memory_usage':
				return '当前jvm内存使用率';
				break;
			case 'tomcat_busy_thread':
				return '当前工作线程数';
				break;
			case 'nginx_request_rate':
				return 'nginx 请求率（点击率）';
				break;
			case 'nginx_connect_num':
				return 'nginx 连接数（并发数）';
				break;

		}
	}

	function app_reports(){
		$page_num = get_request('page');
		$duration = $_GET['duration'];
		$group = $_GET['group'];
		$content = (empty($_GET['content']) ? 'apache' : $_GET['content']);
		$duration = 'day';
		$ymd = $_GET['date'] ? $_GET['date'] : date('Y-m-d');
		$ymd_e = $_GET['date_e'] ? $_GET['date_e'] : date('Y-m-d');
		$ymdtitle = $ymd.'-'.$ymd_e;
		$ymd_arr = explode('-', $ymd);
		$ymd_arr_e = explode('-', $ymd_e);
		$start_time = mktime(0,0,0, $ymd_arr[1], $ymd_arr[2], $ymd_arr[0]);
		$end_time = mktime(23,59,59, $ymd_arr_e[1], $ymd_arr_e[2], $ymd_arr_e[0]);
		//var_dump(date('Y-m-d H:i:s', $start_time));var_dump(date('Y-m-d H:i:s', $end_time));
		$where = " app_name='".$content."' AND date >=FROM_UNIXTIME(".$start_time.") AND date<=FROM_UNIXTIME(".$end_time.")";
		if ($group) {
			$alltmpip = array(0);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$group." or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$group.") or groupid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid IN(SELECT id FROM ".$this->sgroup_set->get_table_name()." WHERE ldapid=".$group."))");
			for($i=0; $i<count($allips); $i++){
				$alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND device_ip IN ('".implode("','", $alltmpip)."')";
		}
		$row_num = $this->app_report_day_set->base_select("select count(*) num from ".$this->app_report_day_set->get_table_name()." where $where GROUP BY device_ip");
		$row_num = $row_num[0]['num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');

		$_result = $this->app_report_day_set->base_select("select device_ip,app_type,avg(`avg`) value from app_day_report where $where group by device_ip,app_type ");
		for($i=0; $i<count($_result); $i++){
			$result[$_result[$i]['app_type']][]=array('num'=>round($_result[$i]['value'],2), 'ip'=>$_result[$i]['device_ip']);
		}
		$_result = null;
		if($result)
		foreach($result AS $key => $v){
			$_result[]=array('k'=>$key, 'k_cn'=>$this->get_v($content.'_'.str_replace(' ', '_', $key)), 'v'=>json_encode($v));
		}
		$this->assign("graphdata", $_result);
		$this->assign("graphdata_ct", count($result));

		$hosts = $this->app_report_day_set->base_select("select device_ip,group_concat(app_type) app_type,group_concat(value) value from (select device_ip,app_type,avg(`avg`) value from app_day_report where $where group by device_ip,app_type) t group by device_ip LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		//echo '<pre>';var_dump($hosts);echo '</pre>';
		for($i=0; $i<count($hosts); $i++){
			$app_type = explode(',', $hosts[$i]['app_type']);
			$value = explode(',', $hosts[$i]['value']);
			for($j=0; $j<count($app_type); $j++){
				$hosts[$i][str_replace(' ', '_', $app_type[$j])] = floatval(round($value[$j],2));
			}
		}
			
		$this->assign("reports", $hosts);
		$sgroup = $this->sgroup_set->select_all('1', 'groupname', 'asc');
		$this->assign("pencents", array("<10%","10%-20%","20%-30%","30%-40%","40%-50%","50%-60%","60%-70%","70%-80%","80%-90%",">90%"));
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('session_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("duration", $duration);
		$this->assign("sgroup", $sgroup);
		$this->assign("ymd", $ymd);
		$this->assign("ymd_e", $ymd_e);
		$this->assign("mktime", time());
		$this->assign("content", $content);
		$this->display("app_reports.tpl");
	}

	function network_reports_policy(){
		$policy = $this->snmp_report_interface_policy_set->select_all('snmp_interface_id=0', 'policyname', 'asc');
		$this->assign("policy", $policy);
		$this->display("network_reports_policy.tpl");
	}

	function network_reports_policy_edit(){
		$policyid = get_request('id', 0, 1);
		$device_ip = get_request('device_ip', 0, 1);
		if($device_ip){
			$where = " AND device_ip='$device_ip'";
		}
		$networks = $this->server_set->base_select("SELECT device_ip,hostname FROM ".$this->server_set->get_table_name()." a LEFT JOIN ".$this->tem_set->get_table_name()." b ON a.device_type=b.id WHERE b.snmp_system=1 ORDER BY device_ip ASC");
		
		$policyinfo = $this->snmp_report_interface_policy_set->select_all("id='$policyid'");
		
		$interfaces = $this->snmp_interface_set->select_all("1 AND cur_status='UP' $where ", 'port_describe', 'asc');
		$sinterfaces = $this->snmp_interface_set->select_all("id IN(SELECT snmp_interface_id FROM ".$this->snmp_report_interface_policy_set->get_table_name()." WHERE policyname='".$policyinfo[0]['policyname']."')", 'port_describe', 'asc');
		for($j=0; $j<count($networks); $j++){
			for($i=0; $i<count($interfaces); $i++){
				if($interfaces[$i]['device_ip']==$networks[$j]['device_ip']){
					$interfaces[$i]['hostname'] = $networks[$j]['hostname'];
				}
			}
			for($i=0; $i<count($sinterfaces); $i++){
				if($sinterfaces[$i]['device_ip']==$networks[$j]['device_ip']){
					$sinterfaces[$i]['hostname'] = $networks[$j]['hostname'];
				}
			}
		}
		
		$this->assign("policy", $policy);
		$this->assign("networks", $networks);
		$this->assign("device_ip", $device_ip);
		$this->assign("interfaces", $interfaces);
		$this->assign("sinterfaces", $sinterfaces);
		$this->assign("policyinfo", $policyinfo[0]);
		$this->display("network_reports_policy_edit.tpl");
	}

	function network_reports_policy_delete(){
		$policyid = get_request('id', 0, 1);
		$this->snmp_report_interface_policy_set->delete($policyid);
		alert_and_back("操作成功",'admin.php?controller=admin_reports&action=network_reports_policy');
	}

	function network_reports_policy_save() {
		$oldpolicyname = get_request('oldpolicyname', 1, 1);
		$policyname = get_request('policyname', 1, 1);
		$policyid = get_request("policyid",1,0);
		$selected = get_request('secend', 1, 1);
		$device_ip = get_request('device_ip', 1, 1);
		$where = "1=1";
		if($device_ip){
			$where .= " AND snmp_interface_id IN(SELECT id FROM ".$this->snmp_interface_set->get_table_name()."  WHERE device_ip='$device_ip')";
		}
		if($policyname==""){
			alert_and_back("组名不能为空");
			exit;
		}elseif($this->snmp_report_interface_policy_set->select_count("policyname='$policyname' and id!=$policyid and snmp_interface_id=0") >0){
			alert_and_back("组名已经存在");
			exit;
		}elseif(empty($policyid)){
			$resourcegroup = new snmp_report_interface_policy();
			$resourcegroup->set_data('policyname',$policyname);
			$resourcegroup->set_data('snmp_interface_id',0);
			$this->snmp_report_interface_policy_set->add($resourcegroup);
			unset($resourcegroup);
		}
		if($policyid){
			$this->snmp_report_interface_policy_set->delete_all("policyname='$oldpolicyname' and snmp_interface_id!=0 and $where");
			$resourcegroup = new snmp_report_interface_policy();
			$resourcegroup->set_data('id',$policyid);
			$resourcegroup->set_data('policyname',$policyname);
			$this->snmp_report_interface_policy_set->edit($resourcegroup);
			unset($resourcegroup);
		}
		for($i=0; $i<count($selected); $i++){
			$resourcegroup = new snmp_report_interface_policy();
			$resourcegroup->set_data('policyname',$policyname);
			$resourcegroup->set_data('snmp_interface_id',$selected[$i]);
			$this->snmp_report_interface_policy_set->add($resourcegroup);
			unset($resourcegroup);
		}

		alert_and_back("操作成功",'admin.php?controller=admin_reports&action=network_reports_policy');
	}


	function network_reports(){
		$duration = $_GET['duration'] ? $_GET['duration'] : 'day';
		$content = (empty($_GET['content']) ? 'cms' : 'disk');
		$page_num = get_request('page');
		switch($duration){
			case 'day':
				$ymd = $_GET['date'] ? $_GET['date'] : date('Y-m-d');
				$ymd_arr = explode('-', $ymd);

				$start_time = mktime(0,0,0, $ymd_arr[1], $ymd_arr[2], $ymd_arr[0]);
				$end_time = mktime(0,0,0, $ymd_arr[1], $ymd_arr[2], $ymd_arr[0])+24*60*60-300;		
				$data_table = ' (select * from ratedaylist WHERE UNIX_TIMESTAMP(time) >='.$start_time .' and UNIX_TIMESTAMP(time) <='.$end_time.' ) ld ON lh.id=ld.list_host_id LEFT JOIN ossim.host oh ON  lh.ip=oh.ip ';
				$ymdtitle = $ymd;
				break;
			case 'week':
				$year = $_GET['year'] ? $_GET['year'] : date('Y');
				$month = $_GET['month'] ? $_GET['month'] : date('m');		
				$week = $_GET['week'] ? $_GET['week'] : 1;
				$ymd_arr = array($year,$month,1);
				$ymdtitle = $ymd_arr[0].'年'.$ymd_arr[1].'月第'.$week.'周';
				$w = date('w', mktime(0,0,0, $ymd_arr[1], $ymd_arr[2], $ymd_arr[0]));		
				$start_time = mktime(0,0,0, $ymd_arr[1], $ymd_arr[2]-$w+7*($week-1)+1, $ymd_arr[0]);
				$end_time = mktime(23,59,59, $ymd_arr[1], $ymd_arr[2]-$w+7*($week-1)+1, $ymd_arr[0])+7*24*60*60;
				$data_table = '(select * from rateweeklist WHERE UNIX_TIMESTAMP(time) >='.$start_time .' and UNIX_TIMESTAMP(time) <='.$end_time.' )  ld ON lh.id=ld.list_host_id LEFT JOIN ossim.host oh ON lh.ip=oh.ip ';
				break;
			case 'month':	
				$year = $_GET['myear'] ? $_GET['myear'] : date('Y');
				$month = $_GET['mmonth'] ? $_GET['mmonth'] : date('m');
				$ymd_arr = array($year,$month,date('d'));
				$ymdtitle = $ymd_arr[0].'年'.$ymd_arr[1].'月';
				$start_time = mktime(0,0,0, $ymd_arr[1], 1, $ymd_arr[0]);
				$end_time = mktime(23,59,59, $ymd_arr[1], 1, $ymd_arr[0])+(date('t',mktime(23,59,59,$ymd_arr[1], 1, $ymd_arr[0]))*24*60*60)-7200;
				$data_table = '(select * from ratemonthlist WHERE UNIX_TIMESTAMP(time) >='.$start_time .' and UNIX_TIMESTAMP(time) <='.$end_time.' )  ld ON lh.id=ld.list_host_id LEFT JOIN ossim.host oh ON lh.ip=oh.ip ';
				break;
			default :
				$ymdtitle = $ymd;
				$start_time = mktime(0,0,0, $ymd_arr[1], $ymd_arr[2], $ymd_arr[0]);
				$end_time = mktime(23,59,59, $ymd_arr[1], $ymd_arr[2], $ymd_arr[0])+24*60*60-300;		
				$data_table = '(select * from ratedaylist WHERE UNIX_TIMESTAMP(time) >='.$start_time .' and UNIX_TIMESTAMP(time) <='.$end_time.' )  ld ON lh.id=ld.list_host_id LEFT JOIN ossim.host oh ON lh.ip=oh.ip ';
		}
		//var_dump(date('Y-m-d H:i:s', $start_time));var_dump(date('Y-m-d H:i:s', $end_time));
		$where = ' datetime >=FROM_UNIXTIME('.$start_time.') AND datetime<=FROM_UNIXTIME('.$end_time.')';
		$rows = $this->snmp_status_set->base_select("SELECT count(0) ct FROM snmp_report_interface_".$duration." GROUP BY device_ip,port_describe");
		$total_page = $rows[0]['ct'];
		$newpager = new my_pager($total_page, $page_num, 20, 'page');

		$ips = $this->snmp_status_set->base_select("SELECT a.device_ip,a.port_describe,b.hostname,AVG(traffic_in) avg_ti,MAX(traffic_in) max_ti,MIN(traffic_in) min_ti,AVG(traffic_out) avg_to,MAX(traffic_out) max_to,MIN(traffic_out) min_to,AVG(packet_in) avg_pi,MAX(packet_in) max_pi,MIN(packet_in) min_pi,AVG(packet_out) avg_po,MAX(packet_out) max_po,MIN(packet_out) min_po,AVG(err_packet_in) avg_epi,MAX(err_packet_in) max_epi,MIN(err_packet_in) min_epi,AVG(err_packet_out) avg_epo,MAX(err_packet_out) max_epo,MIN(err_packet_out) min_epo FROM snmp_report_interface_".$duration." a LEFT JOIN ".$this->server_set->get_table_name()." b ON a.device_ip=b.device_ip WHERE $where GROUP BY device_ip,port_describe ORDER BY device_ip ASC  LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");

		$policy = $this->snmp_report_interface_policy_set->select_all('snmp_interface_id=0', 'policyname', 'asc');
		$this->assign("policy", $policy);
		$this->assign("duration", $duration);
		$this->assign("sgroup", $sgroup);
		$this->assign("ymd", $ymd);
		$this->assign("reports", $ips);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display("network_reports.tpl");
	}

	function workflow_approve(){
		global $_CONFIG;
		$page_num = get_request('page');
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'sid';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$where = '1';
		if($_SESSION['ADMIN_LEVEL'] == 3|| $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				if($_CONFIG['DEPART_ADMIN']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
					if($alltmpip)
					$where .= " AND devices.device_ip IN ('".implode("','", $alltmpip)."')";
				}else{
					$allusers = $this->sessions_set->base_select("SELECT username FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allusers); $i++){
						$alltmpuser[]=$allusers[$i]['username'];
					}
					if($alltmpuser)
					$where .= " AND m.username IN ('".implode("','", $alltmpuser)."')";
				}
			}

		}

		$sql = "SELECT workflow.*,m.username muname,wflog.members,wflog.apply_status,devices.device_ip,devices.username,login_template.login_method,workflow_contant.name FROM workflow LEFT JOIN (SELECT wid,GROUP_CONCAT(member order by sid ASC) members, GROUP_CONCAT(apply_status order by sid ASC) apply_status FROM workflow_log GROUP BY wid) wflog ON workflow.sid=wflog.wid LEFT JOIN devices ON workflow.devicesid=devices.id LEFT JOIN login_template ON devices.login_method=login_template.id LEFT JOIN workflow_contant ON workflow.contant=workflow_contant.sid LEFT JOIN member m ON workflow.memberid=m.uid WHERE $where";
		$sql .= " UNION SELECT workflow.*,m.username muname,wflog.members,wflog.apply_status,devices.device_ip,devices.username,login_template.login_method,workflow_contant.name FROM workflow LEFT JOIN (SELECT wid,GROUP_CONCAT(member order by sid ASC) members, GROUP_CONCAT(apply_status order by sid ASC) apply_status FROM workflow_log GROUP BY wid) wflog ON workflow.sid=wflog.wid LEFT JOIN devices ON workflow.devicesid=devices.id LEFT JOIN login_template ON devices.login_method=login_template.id LEFT JOIN workflow_contant ON workflow.contant=workflow_contant.sid LEFT JOIN member m ON workflow.memberid=m.uid WHERE $where";
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			//$reports = $this->sessions_set->base_select($sql);
			$str = "日期:\t".$start."\t到\t".$end."\n";
			$str .= language("序号")."\t".language("申请人")."\t".language("申请时间")."\t".language("设备IP")."\t".language("用户名")."\t".language("登录方式")." \t".language("操作内容")."\t".language("描述")." \t".language("流程状态")."\t\n";
			$id=1;
			$i=0;
			$f = @fopen('tmp/WorkFlowApprove.xls', "wa+");
			@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));

			while(1){
				$str='';
				$reports = $this->appcomm_set->base_select($sql." LIMIT ".(($i++)*10000).",10000");	
				if(empty($reports)) break;
				foreach ($reports AS $report){		
					if (!$report['status'] ){
						$report['status']='未审批';
					}elseif ($report['status'] == 1){
						$report['status']='关单';
					}elseif ($report['status'] == 2){
						$report['status']='驳回';
					}elseif ($report['status'] == 3){
						$report['status']='审批中';
					}elseif ($report['status'] == 4){
						$report['status']='审批完成';
					}
					$str .= ($id++)."\t".$report['muname']."\t".$report['dateline']."\t".$report['device_ip']."\t".$report['username']."\t".$report['login_method']."\t".$report['name']."\t".$report['desc']."\t".$report['status'];
					$str .= "\n";
				}
				@fwrite($f, mb_convert_encoding($str, "GBK", "UTF-8"));
			}
			fclose($f);
			go_url('tmp/WorkFlowApprove.xls?'.time());
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=DevLoginReport.xls"); 
			echo mb_convert_encoding($str, "GBK", "UTF-8");
			*/
			exit();
		}else if($derive==4){
			$reports = $this->sessions_set->base_select($sql);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GBK','序号'), iconv('UTF-8','GBK','申请人'), iconv('UTF-8','GBK','申请时间'), iconv('UTF-8','GBK','设备IP'), iconv('UTF-8','GBK','用户名'), iconv('UTF-8','GBK','登录方式'), iconv('UTF-8','GBK','操作内容'), iconv('UTF-8','GBK','描述'), iconv('UTF-8','GBK','流程状态'));
			$w = array(12, 18, 18, 18, 18, 18, 18, 18, 18, 18, 18);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				if (!$report['status'] ){
					$report['status']='未审批';
				}elseif ($report['status'] == 1){
					$report['status']='关单';
				}elseif ($report['status'] == 2){
					$report['status']='驳回';
				}elseif ($report['status'] == 3){
					$report['status']='审批中';
				}elseif ($report['status'] == 4){
					$report['status']='审批完成';
				}
				$pdf->Row(array(++$id, $report['muname'], iconv('UTF-8','GBK',$report['dateline']), iconv('UTF-8','GBK',$report['device_ip']), iconv('UTF-8','GBK',$report['username']), iconv('UTF-8','GBK',$report['login_method']), iconv('UTF-8','GBK',$report['name']), iconv('UTF-8','GBK',$report['desc']), iconv('UTF-8','GBK',$report['status'])), $fill);
				$fill = !$fill;

			}
			//$pdf->FancyTable($header,$data,$w);
			if($_GET['derive_forcron']){
				echo $pdf->buffer;
				return ;
			}
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('s', $reports);
			$this->display('workflow_approve_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=DevLoginReport.html"); 
			echo $str;
			exit();
		}else if($derive==3){//word
			$reports = $this->sessions_set->base_select($sql);
			ob_start();
			$this->assign('s', $reports);
			$this->display('workflow_approve_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=DevLoginReport.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}
loading_start();

		$row_num = $this->workflow_set->base_select("SELECT COUNT(*) AS row_num FROM ($sql) t");
		$row_num = $row_num[0]['row_num'];
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql .= " ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage ";
		$s = $this->workflow_set->base_select($sql);
		for($i=0; $i<count($s); $i++){
			
			$wfuser_arr = explode(',', $s[$i]['members']);
			$wflog = "";
			$found = 0;
			for($j=0; $j<count($wfuser_arr); $j++){
				if($wfuser_arr[$j]==$_SESSION['ADMIN_UID']){
					$found = 1;
					break;
				}
				$wflog .= "1,";
			}
			if(empty($found)) continue;			
			if(substr($s[$i]['apply_status'], 0, strlen($wflog)+3)==$wflog.'1,0'){
				$s[$i]['apply_status_reject'] = 1;
			}
			$wstatus = $this->workflow_log_set->select_all("wid=".$s[$i]['sid']." AND member=".$_SESSION['ADMIN_UID']);
			if($wstatus[0]['apply_status']){
				$s[$i]['approved'] = $wstatus[0]['apply_status'];
				continue;
			}

			$wflog = substr($wflog, 0, strlen($wflog)-1)."";//var_dump($found);var_dump($j==0);
			if($found&&$j==0 || substr($s[$i]['apply_status'], 0, strlen($wflog))==$wflog){
				$s[$i]['apply_status_priority'] = 1;
			}

		}
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		
		}

		//echo '<pre>';var_dump($s);echo '</pre>';
		$members = $this->member_set->select_all('1', 'username', 'asc');
		$this->assign('title', language('来源IP列表'));
		$this->assign('s', $s);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('members', $members);
		$this->assign('curr_url', $curr_url);
loading_end();		
		$this->display('workflow_approve_report.tpl');
	}

	function dns_report() {
		$orderby1= $this->getInput('orderby1');
		$orderby2= $this->getInput('orderby2');
		$listType = $this->getInput('listType');
		$f_rangeStart = $this->getInput('f_rangeStart');
		
		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(empty($orderby2)){
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		if($listType){
			$setName = 'dns_'.$listType.'_report_set';
		}
		else{
			$setName = 'dns_day_report_set';
		}
		$query = ' 1=1';
		if($f_rangeStart){
			$query = " date='$f_rangeStart'";
			if($listType=='week'){
				$query = " TIMESTAMPDIFF(DAY,date,'$f_rangeStart')<7 ";
			}			
			if($listType=='month'){
				$query = " MONTH('$f_rangeStart')= MONTH(date)";
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
 
		$this->display('dns_report.tpl');
	}
	
	function maillog(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$msg = get_request('msg', 0, 1);
		$email = get_request('email', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		
		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($msg){
			$where .= " AND msg like '%".$msg."%'";
		}
		if($email){
			$where .= " AND email like '%".$email."%'";
		}
		
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			$reports = $this->mail_sender_set->select_all($where);
			$str .= language("序号")."\t".language("邮件地址")."\t".language("主题")."\t".language("内容")." \t".language("附件")." \t".language("发送邮件进程")." \t".language("发送结果")." \t".language("失败原因")."\t\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['mailto']."\t".$report['subject']."\t".$report['msg']."\t".$report['file_path']."\t".$report['program']."\t".($report['status']==1 ? '成功' : '失败')."\t".$report['err_string'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemAlert.xls"); 
			echo iconv("UTF-8", "GB2312", $str);
			exit();
		
		}else if($derive==4){
			$reports = $this->mail_sender_set->select_all($where);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GB2312','序号'), iconv('UTF-8','GB2312','邮件地址'), iconv('UTF-8','GB2312','主题'), iconv('UTF-8','GB2312','内容'),  iconv('UTF-8','GB2312','附件'),  iconv('UTF-8','GB2312','发送邮件进程'),  iconv('UTF-8','GB2312','发送结果'),  iconv('UTF-8','GB2312','失败原因'));
			$w = array(20, 90, 14, 36, 20, 20);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, iconv('UTF-8','GB2312', $report['mailto']), iconv('UTF-8','GB2312',$report['subject']), iconv('UTF-8','GB2312',$report['msg']), iconv('UTF-8','GB2312',$report['file_path']), iconv('UTF-8','GB2312',$report['program']), iconv('UTF-8','GB2312',($report['mail_status']==1 ? '成功' : '失败')), iconv('UTF-8','GB2312',$report['err_string']) ), $fill);
				$fill = !$fill;
			}
			//$pdf->FancyTable($header,$data,$w);
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->mail_sender_set->select_all($where);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('maillog_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemAlert.html"); 
			echo $str;
			exit();
		}else if($derive==3){
			$reports = $this->mail_sender_set->select_all($where);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('maillog_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=SystemAlert.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}		
		$row_num = $this->mail_sender_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$reports = $this->mail_sender_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);

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
		$this->assign('reports', $reports);
		$this->assign('session_num', $row_num);
		$this->assign('number', $number);
		
		$this->display('maillog.tpl');
	}
	
	function maillog_del(){
		$id = get_request('id');
		$this->mail_sender_set->delete($id);
		alert_and_back('操作成功');
	}
	
	function aduserlog(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$ldap = get_request('ldap', 0, 1);
		$username = get_request('username', 0, 1);
		$start = get_request('start', 0, 1);
		$end = get_request('end', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		
		if(empty($orderby1)){
			$orderby1 = 'id';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($ldap){
			$where .= " AND ldap like '%".$ldap."%'";
		}
		if($username){
			$where .= " AND username like '%".$username."%'";
		}
		if($start){
			$where .= " AND time >= '".$start."'";
		}
		if($end){
			$where .= " AND time <= '".$end."'";
		}
		
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			$reports = $this->mail_sender_set->select_all($where);
			$str .= language("序号")."\t".language("时间")."\t".language("策略ID")."\t".language("策略名称")."\t".language("服务器IP")." \t".language("同步用户名")." \t".language("原目录")." \t".language("新目录")." \t".language("动作")."\t\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['time']."\t".$report['configid']."\t".$report['configname']."\t".$report['ip']."\t".$report['username']."\t".$report['ad']."\t".$report['ldap']."\t".$report['action'];
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemAlert.xls"); 
			echo iconv("UTF-8", "GB2312", $str);
			exit();
		
		}else if($derive==4){
			$reports = $this->aduser_log_set->select_all($where);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GB2312','序号'), iconv('UTF-8','GB2312','时间'), iconv('UTF-8','GB2312','主题'), iconv('UTF-8','GB2312','策略ID'),  iconv('UTF-8','GB2312','策略名称'),  iconv('UTF-8','GB2312','服务器IP'),  iconv('UTF-8','GB2312','用户名'),  iconv('UTF-8','GB2312','原目录'),  iconv('UTF-8','GB2312','新目录'),  iconv('UTF-8','GB2312','动作'));
			$w = array(20, 90, 14, 36, 20, 20);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, iconv('UTF-8','GB2312', $report['time']), iconv('UTF-8','GB2312',$report['configid']), iconv('UTF-8','GB2312',$report['configname']), iconv('UTF-8','GB2312',$report['ip']), iconv('UTF-8','GB2312',$report['username']), iconv('UTF-8','GB2312',$report['ad']), iconv('UTF-8','GB2312',$report['ldap']) , iconv('UTF-8','GB2312',$report['action'])), $fill);
				$fill = !$fill;
			}
			//$pdf->FancyTable($header,$data,$w);
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->aduser_log_set->select_all($where);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('aduserlog_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemAlert.html"); 
			echo $str;
			exit();
		}else if($derive==3){
			$reports = $this->aduser_log_set->select_all($where);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('aduserlog_for_export.tpl');
			$str = ob_get_clean();
			if($_GET['derive_forcron']){
				echo $str;
				return ;
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			header("Content-type:application/vnd.ms-doc;");
			header("Content-Disposition: attachment;filename=SystemAlert.doc");
			echo "<html xmlns:o=urn:schemas-microsoft-com:office:office 
					xmlns:w=urn:schemas-microsoft-com:office:word 
					xmlns= target=_blank>";
			echo $str;
			echo "</html>"; 
			exit();
		}		
		$row_num = $this->aduser_log_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$reports = $this->aduser_log_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);

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
		$this->assign('reports', $reports);
		$this->assign('session_num', $row_num);
		$this->assign('number', $number);
		
		$this->display('aduserlog.tpl');
	}
	
	function aduserlog_del(){
		$id = get_request('id');
		$this->mail_sender_set->delete($id);
		alert_and_back('操作成功');
	}

}


?>
