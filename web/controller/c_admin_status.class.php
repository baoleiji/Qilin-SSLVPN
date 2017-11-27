<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}


class c_admin_status extends c_base {
	function index() {
		$this->reportgraph();
	}
	
	function latest(){
		global $pwdconfig, $_CONFIG;
		global $_CONFIG;
		$filename = $_CONFIG['HACF'];
		$lines = @file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtolower($lines[$ii]), "virtual_ipaddress"))
				{
					$network['virtual_ipaddress'] = trim($lines[$ii+1]);
				}
			}
		}
		
		$cmd = "sudo ps -ef | grep keepalived | grep -v grep";
		exec($cmd, $out);
		if(strstr(strtolower($out[0]), "keepalived"))
		{
			$cmd = "ip add show | grep ".$network['virtual_ipaddress'];
			exec($cmd, $out1);
			if(empty($out1)){
				$ha='从';
			}else{
				$ha='主';
			}
		}else{
			$ha = '未配置';
		}

		$latest = $this->status_day_count_set->base_select("SELECT  *  FROM `local_status` ORDER BY datetime desc ");
		for($i=0; $i<count($latest); $i++){
			switch($latest[$i]['type']){
				case 'ssh并发数':
					$s['ssh_conn'] = $latest[$i]['value'];
					$s['ssh_conn_a'] = "<a href=\"#\" onclick=\"return showImg('".'ssh并发数'."',event,".$latest[$i]['seq'].");return false;\" >".$latest[$i]['value']."</a>";
					$s['ssh_conn_rrdfile'] = $latest[$i]['value'];
					$s['ssh_conn_lowvalue'] = $latest[$i]['lowvalue'];
					$s['ssh_conn_highvalue'] = $latest[$i]['highvalue'];
					break;
				case 'telnet并发数':
					$s['telnet_conn'] = $latest[$i]['value'];
					$s['telnet_conn_a'] = "<a href=\"#\" onclick=\"return showImg('".'telnet并发数'."',event,".$latest[$i]['seq'].");return false;\" >".$latest[$i]['value']."</a>";
					$s['telnet_conn_rrdfile'] = $latest[$i]['value'];
					$s['telnet_conn_lowvalue'] = $latest[$i]['lowvalue'];
					$s['telnet_conn_highvalue'] = $latest[$i]['highvalue'];
					break;
				case '图形会话并发数':
					$s['graph_conn'] = $latest[$i]['value'];
					$s['graph_conn_a'] = "<a href=\"#\" onclick=\"return showImg('".'图形会话并发数'."',event,".$latest[$i]['seq'].");return false;\" >".$latest[$i]['value']."</a>";
					$s['graph_conn_rrdfile'] = $latest[$i]['value'];
					$s['graph_conn_lowvalue'] = $latest[$i]['lowvalue'];
					$s['graph_conn_highvalue'] = $latest[$i]['highvalue'];
					break;
				case 'ftp连接数':
					$s['ftp_conn'] = $latest[$i]['value'];
					$s['ftp_conn_a'] = "<a href=\"#\" onclick=\"return showImg('".'ftp连接数'."',event,".$latest[$i]['seq'].");return false;\" >".$latest[$i]['value']."</a>";
					$s['ftp_conn_rrdfile'] = $latest[$i]['value'];
					$s['ftp_conn_lowvalue'] = $latest[$i]['lowvalue'];
					$s['ftp_conn_highvalue'] = $latest[$i]['highvalue'];
					break;
				case '数据库并发数':
					$s['db_conn'] = $latest[$i]['value'];
					$s['db_conn_a'] = "<a href=\"#\" onclick=\"return showImg('".'数据库并发数'."',event,".$latest[$i]['seq'].");return false;\" >".$latest[$i]['value']."</a>";
					$s['db_conn_rrdfile'] = $latest[$i]['value'];
					$s['db_conn_lowvalue'] = $latest[$i]['lowvalue'];
					$s['db_conn_highvalue'] = $latest[$i]['highvalue'];
					break;
				case 'mysql连接数':
					$s['mysql_conn'] = $latest[$i]['value'];
					$s['mysql_conn_a'] = "<a href=\"#\" onclick=\"return showImg('".'mysql连接数'."',event,".$latest[$i]['seq'].");return false;\" >".$latest[$i]['value']."</a>";
					$s['mysql_conn_rrdfile'] = $latest[$i]['value'];
					$s['mysql_conn_lowvalue'] = $latest[$i]['lowvalue'];
					$s['mysql_conn_highvalue'] = $latest[$i]['highvalue'];
					break;
				case 'http连接数':
					$s['http_conn'] = $latest[$i]['value'];
					$s['http_conn_a'] = "<a href=\"#\" onclick=\"return showImg('".'http连接数'."',event,".$latest[$i]['seq'].");return false;\" >".$latest[$i]['value']."</a>";
					$s['http_conn_rrdfile'] = $latest[$i]['value'];
					$s['http_conn_lowvalue'] = $latest[$i]['lowvalue'];
					$s['http_conn_highvalue'] = $latest[$i]['highvalue'];
					break;
				case 'tcp连接数':
					$s['tcp_conn'] = $latest[$i]['value'];
					$s['tcp_conn_a'] = "<a href=\"#\" onclick=\"return showImg('".'tcp连接数'."',event,".$latest[$i]['seq'].");return false;\" >".$latest[$i]['value']."</a>";
					$s['tcp_conn_rrdfile'] = $latest[$i]['value'];
					$s['tcp_conn_lowvalue'] = $latest[$i]['lowvalue'];
					$s['tcp_conn_highvalue'] = $latest[$i]['highvalue'];
					break;
				default:
					$s[$latest[$i]['type']] = $latest[$i]['value'];
					$s[$latest[$i]['type'].'_a'] = "<a href=\"#\" onclick=\"return showImg('".$latest[$i]['type']."',event,".$latest[$i]['seq'].");return false;\" >".$latest[$i]['value'];
					$s[$latest[$i]['type'].'_rrdfile'] = $latest[$i]['value'];
					$s[$latest[$i]['type'].'_seq'] = $latest[$i]['seq'];
					$s[$latest[$i]['type'].'_lowvalue'] = $latest[$i]['lowvalue'];
					$s[$latest[$i]['type'].'_highvalue'] = $latest[$i]['highvalue'];
					break;
			}
		}
 	//	print_r($latest);
		$buf = rfts( '/proc/uptime', 1 );
		$ar_buf = preg_split( '/ /', $buf );
		$result = trim( $ar_buf[0] );
		$uptime= uptime($result);
		$online_users = get_online_users('', $pwdconfig['logintimeout']*60);
		$serverct = $this->server_set->select_count();
		$memberct = $this->member_set->select_count();
		$devpassct = $this->devpass_set->select_count();
		$s['serverct']=$serverct;
		$s['memberct']=$memberct;
		$s['devpassct']=$devpassct;
		for( $i = 0, $max = sizeof( $online_users ); $i < $max; $i++ ) {
			switch($online_users[$i]['level']){
				case 0:
					$level = '普通用户';
				break;
				case 1:
					$level = '管理员';
				break;
				case 2:
					$level = '审计管理员';
				break;
				case 3:
					$level = '组管理员';
				break;
				case 4:
					$level = '配置管理员';
				break;
				case 10:
					$level = '密码管理员';
				break;

			}
			$online_users[$i]['levelstr'] = $level;
		}
        
        
		exec("sudo /opt/freesvr/audit/sbin/license-print", $output, $return);
        
		$arr = preg_split ("/\s{1,}/",$output[0]);
   
		$cpu['used']=$s['cpu'];
		$cpu['unused']=100-$s['cpu'];
		$memory['used']=$s['memory'];
		$memory['unused']=100-$s['memory'];
		$disk['used']=$s['disk'];
		$disk['unused']=100-$s['disk'];
		$swap['used']=$s['swap'];
		$swap['unused']=100-$s['swap'];
		$infostr = 'info[]='.urlencode('已使用').'&info[]='.urlencode('未使用');

		$this->assign("licenses", $arr);
		
		exec("/opt/freesvr/audit/bin/licid", $sn, $return);
        $sn=$sn[0];
		$this->assign("sn", $sn);
		$this->assign("host_ip", $_SERVER['HTTP_HOST']);
		$this->assign('uptime', $uptime);
		$this->assign('onlineusers', $online_users);
		$this->assign('latest', array($s));
		$this->assign('cpu', $cpu);
		$this->assign('memory', $memory);
		$this->assign('disk', $disk);
		$this->assign('swap', $swap);
		$this->assign('info', $infostr);
		$this->assign("version", $_CONFIG['Version']);
		$this->assign('ha', $ha);
		

		$file = $_CONFIG['CONFIGFILE']['OPENVPGLOG'];
		$lines = file($file);
		for($i=0; $i<count($lines); $i++){
			if(strpos(strtolower($lines[$i]), "common name")===0){
				$start = 1;
				continue;
			}
			if(strpos(strtolower($lines[$i]), strtolower("ROUTING TABLE"))!==false){
				$start = 0;
				continue;
			}
			if($start){
				$tmp=explode(',', $lines[$i]);
				$t = $tmp[2];
				$tmp[2]=$tmp[4];
				$tmp[4]=$t;
				$allsessions[]=$tmp;
			}
		}
		$this->assign("vpnonline", count($allsessions));
		$this->display('status_latest.tpl');
	}
	
	
	function day_count(){
		$page_num = get_request('page');
 
		$f_rangeEnd = get_request('f_rangeEnd', 1, 1);
		$f_rangeStart = get_request('f_rangeStart', 1, 1);
		if(!$f_rangeStart){
			$f_rangeStart = get_request('f_rangeStart', 0, 1);
		}
		if(!$f_rangeEnd){
			$f_rangeEnd = get_request('f_rangeEnd', 0, 1);
		}
 
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		
		$where ="  1=1 ";
		
		if($f_rangeStart){
			$where .= " and date >= '$f_rangeStart 00:00:00'";
		}
		if(f_rangeEnd){
			$where .= " and date <= '$f_rangeEnd 23:59:59'";
		}
		
		$row_num = $this->status_day_count_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql = "select  * from status_day_count ";
		if($f_rangeStart){
			$sql = $sql.'where'.$where;
		}
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		
		$all = $this->status_day_count_set->base_select($sql);
		$this->assign('all', $all);
		
		$this->assign('num', $row_num);
		$this->assign('f_rangeStart', $f_rangeStart);
		$this->assign('f_rangeEnd', $f_rangeEnd);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$this->display("status_day_count.tpl");
	}
	
	function week_count(){
		$page_num = get_request('page');
 		$f_rangeEnd = get_request('f_rangeEnd', 1, 1);
		$f_rangeStart = get_request('f_rangeStart', 1, 1);
		if(!$f_rangeStart){
			$f_rangeStart = get_request('f_rangeStart', 0, 1);
		}
		if(!$f_rangeEnd){
			$f_rangeEnd = get_request('f_rangeEnd', 0, 1);
		}
 
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		
		$where ="  1=1 ";
		
		if($f_rangeStart){
			$where .= " and date_start  >= '$f_rangeStart 00:00:00'";
		}
		if($f_rangeEnd){
			$where .= " and date_end <= '$f_rangeEnd 23:59:59'";
		}
		
		$row_num = $this->status_week_count_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql = "select  * from status_week_count ";
		if($f_rangeStart){
			$sql = $sql.'where'.$where;
		}
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		
		$all = $this->status_week_count_set->base_select($sql);
		$this->assign('all', $all);
		
		$this->assign('num', $row_num);
		$this->assign('f_rangeStart', $f_rangeStart);
		$this->assign('f_rangeEnd', $f_rangeEnd);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$this->display("status_week_count.tpl");
	}
	
	function month_count(){
		$page_num = get_request('page');
 		$f_rangeEnd = get_request('f_rangeEnd', 1, 1);
		$f_rangeStart = get_request('f_rangeStart', 1, 1);
		if(!$f_rangeStart){
			$f_rangeStart = get_request('f_rangeStart', 0, 1);
		}
		if(!$f_rangeEnd){
			$f_rangeEnd = get_request('f_rangeEnd', 0, 1);
		}
 
		$curr_url = $_SERVER['PHP_SELF'] . "?";
		if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
			$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
		}
		else {
			$curr_url .= $_SERVER['QUERY_STRING'];
		}
		
		$where ="  1=1 ";
		
		if($f_rangeStart){
			$where .= " and date_start  >= '$f_rangeStart 00:00:00'";
		}
		if(f_rangeEnd){
			$where .= " and date_end <= '$f_rangeEnd 23:59:59'";
		}
		
		$row_num = $this->status_month_count_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$sql = "select  * from status_month_count ";
		if($f_rangeStart){
			$sql = $sql.'where'.$where;
		}
		$sql .= " LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage";
		
		$all = $this->status_week_count_set->base_select($sql);
		$this->assign('all', $all);
		
		$this->assign('num', $row_num);
		$this->assign('f_rangeStart', $f_rangeStart);
		$this->assign('f_rangeEnd', $f_rangeEnd);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign('curr_url', $curr_url);
		$this->display("status_month_count.tpl");
	}
	
	function reportgraph() {
 
		
 		$last10conn = $this->status_day_count_set->base_select("SELECT sum(ssh_conn) ssh,sum(telnet_conn) telnet,sum(graph_conn) graph,sum(ftp_conn) ftp,sum(db_conn) db,date FROM `status_day_count`  GROUP BY date ORDER BY date desc LIMIT 10");
		if(is_array($last10conn))
		$last10conn = array_reverse($last10conn);
		
		$last10usage = $this->status_day_count_set->base_select("SELECT sum(cpu) cpu,sum(memory) memory,sum(swap) swap,sum(disk) disk,date FROM `status_day_count`  GROUP BY date ORDER BY date desc LIMIT 10");
		if(is_array($last10usage))
		$last10usage = array_reverse($last10usage);
		
		$last10flow = $this->status_day_count_set->base_select("SELECT IFNULL(sum(net_eth0_in),0) net_eth0_in, IFNULL(sum(net_eth0_out),0) net_eth0_out,IFNULL(sum(net_eth1_in),0) net_eth1_in,IFNULL(sum(net_eth1_out),0) net_eth1_out,date FROM `status_day_count`  GROUP BY date ORDER BY date desc LIMIT 10");
		if(is_array($last10flow))
		$last10flow = array_reverse($last10flow);
 
		$this->assign('last10flow', json_encode($last10flow));
		$this->assign('last10usage', json_encode($last10usage));
		$this->assign('last10conn', json_encode($last10conn));

		$this->display('statusgraph.tpl');
	}

	function system_alert(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		
		if(empty($orderby1)){
			$orderby1 = 'datetime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($start){
			$where .= " AND datetime >='".$start." 00:00:00'";
		}
		if($end){
			$where .= " AND datetime <='".$end." 23:59:59'";
		}
		
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			$reports = $this->status_abnormal_set->select_all($where);
			$str = (empty($start)&&empty($end) ? "" : "日期:\t".$start."\t 到 \t".$end."\n");
			$str .= language("序号")."\t".language("内容")."\t".language("当前值")."\t".language("时间")." \t".language("发送邮件")." \t".language("发送短信")."\t\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['context']."\t".$report['value']."\t".$report['datetime']."\t".($report['mail_status']==1 ? '成功' : '失败')."\t".($report['mail_status']==1 ? '成功' : '失败');
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemAlert.xls"); 
			echo iconv("UTF-8", "GB2312", $str);
			exit();
		
		}else if($derive==4){
			$reports = $this->status_abnormal_set->select_all($where);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GB2312','序号'), iconv('UTF-8','GB2312','内容'), iconv('UTF-8','GB2312','超值'), iconv('UTF-8','GB2312','时间'),  iconv('UTF-8','GB2312','发送邮件'),  iconv('UTF-8','GB2312','发送短信'));
			$w = array(20, 90, 14, 36, 20, 20);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, iconv('UTF-8','GB2312', $report['context']), iconv('UTF-8','GB2312',$report['value']), iconv('UTF-8','GB2312',$report['datetime']), iconv('UTF-8','GB2312',($report['mail_status']==1 ? '成功' : '失败')), iconv('UTF-8','GB2312',($report['mail_status']==1 ? '成功' : '失败'))), $fill);
				$fill = !$fill;
			}
			//$pdf->FancyTable($header,$data,$w);
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->status_abnormal_set->select_all($where);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('system_alert_for_export.tpl');
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
			$reports = $this->status_abnormal_set->select_all($where);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('system_alert_for_export.tpl');
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
		$row_num = $this->status_abnormal_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$reports = $this->status_abnormal_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);

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
		
		$this->display('system_alert.tpl');
	}

	function backup_session(){
		global $_CONFIG;
		$page_num = get_request('page');
		$number = get_request('number');
		$start = get_request('f_rangeStart', 0, 1);
		$end = get_request('f_rangeEnd', 0, 1);
		$derive = get_request('derive');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		
		if(empty($orderby1)){
			$orderby1 = 'datetime';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);
		
		$where = '1=1';
		if($start){
			$where .= " AND datetime >='".$start." 00:00:00'";
		}
		if($end){
			$where .= " AND datetime <='".$end." 23:59:59'";
		}
		
		$this->assign('f_rangeStart', $start);
		$this->assign('f_rangeEnd', $end);
		if($derive==1){
			$reports = $this->backupsession_set->select_all($where);
			$str = (empty($start)&&empty($end) ? "" : "日期:\t".$start."\t 到 \t".$end."\n");
			$str .= language("序号")."\t".language("内容")."\t".language("当前值")."\t".language("时间")." \t".language("发送邮件")." \t".language("发送短信")."\t\n";
			$id=1;
			if($reports)
			foreach ($reports AS $report){		
				$str .= ($id++)."\t".$report['context']."\t".$report['value']."\t".$report['datetime']."\t".($report['mail_status']==1 ? '成功' : '失败')."\t".($report['mail_status']==1 ? '成功' : '失败');
				$str .= "\n";
			}
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=SystemAlert.xls"); 
			echo iconv("UTF-8", "GB2312", $str);
			exit();
		
		}else if($derive==4){
			$reports = $this->backupsession_set->select_all($where);
			$pdf=new PDF_Chinese('P','mm','A4');
			$pdf->AddGBFont(); 
			$pdf->Open();
			$pdf->SetFont('GB','',12); 
			$pdf->AddPage();			
			$pdf->SetFillColor(224,235,255);
			$pdf->SetTextColor(0);
			$pdf->SetFont('');
			// Column headings
			$header = array(iconv('UTF-8','GB2312','序号'), iconv('UTF-8','GB2312','内容'), iconv('UTF-8','GB2312','超值'), iconv('UTF-8','GB2312','时间'),  iconv('UTF-8','GB2312','发送邮件'),  iconv('UTF-8','GB2312','发送短信'));
			$w = array(20, 90, 14, 36, 20, 20);
			// Data loading
			$i=0; $id=0; 
			$pdf->SetWidths($w);
			$pdf->Row($header, $fill);
			$fill = false;
			if($reports)
			foreach ($reports AS $report){	
				$pdf->Row(array(++$id, iconv('UTF-8','GB2312', $report['context']), iconv('UTF-8','GB2312',$report['value']), iconv('UTF-8','GB2312',$report['datetime']), iconv('UTF-8','GB2312',($report['mail_status']==1 ? '成功' : '失败')), iconv('UTF-8','GB2312',($report['mail_status']==1 ? '成功' : '失败'))), $fill);
				$fill = !$fill;
			}
			//$pdf->FancyTable($header,$data,$w);
			$pdf->Output();
			exit;
		}else if($derive==2){
			$reports = $this->backupsession_set->select_all($where);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('system_alert_for_export.tpl');
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
			$reports = $this->backupsession_set->select_all($where);
			ob_start();
			$this->assign('reports', $reports);
			$this->display('system_alert_for_export.tpl');
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
		$row_num = $this->backupsession_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$reports = $this->backupsession_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);

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
		
		$this->display('backup_session.tpl');
	}
}
?>
