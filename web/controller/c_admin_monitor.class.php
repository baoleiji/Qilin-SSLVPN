<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}
class c_admin_monitor extends c_base {
	function index(){
		global $_CONFIG;
		$hosts_status[0]=0;
		$hosts_status[1]=0;
		$hosts_status[2]=0;
		$networks_status[0]=0;
		$networks_status[1]=0;
		$networks_status[2]=0;
		$apps_status[0]=0;
		$apps_status[1]=0;
		$apps_status[2]=0;
		if ($_SESSION['ADMIN_LEVEL'] == 0) {
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
			$sql .= " UNION SELECT devicesid FROM " . $this->resgroup_set->get_table_name() . " WHERE groupname IN (SELECT b.groupname FROM " . $this->lgroup_resourcegrp_set->get_table_name() . " a LEFT JOIN " . $this->resgroup_set->get_table_name() . " b ON a.resourceid=b.id ";
			//if($_SESSION['ADMIN_LEVEL']==0)
				{
				$sql .= "WHERE a.groupid=" . $_SESSION['ADMIN_GROUP'];
			}
			$sql .= ")";
			$alldevid = $this->member_set->base_select($sql);
			for ($i = 0; $i < count($alldevid); $i++) {
				$alldevsid[] = $alldevid[$i]['devicesid'];
			}
			if (empty($alldevsid)) {
				$alldevsid[] = 0;
			}
            $where = " AND b.device_ip IN (SELECT device_ip FROM " . $this->devpass_set->get_table_name() . " WHERE id IN (" . implode(",", $alldevsid) . "))";
        }

		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			if($_CONFIG['DEPART_ADMIN']){
				$alltmpip = array(0);
				if($_SESSION['ADMIN_MSERVERGROUP']){
					$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
					for($i=0; $i<count($allips); $i++){
						$alltmpip[]=$allips[$i]['device_ip'];
					}
				}
				$where .= " AND LEFT(a.device_ip,IF(LOCATE(':',a.device_ip)>0,LOCATE(':',a.device_ip)-1,LENGTH(a.device_ip))) IN ('".implode("','", $alltmpip)."')";
			}
		}


		$sql = "SELECT count(0) ct, GROUP_CONCAT(CONCAT(a.device_ip,'_',b.`status`) ORDER BY INET_ATON(b.device_ip) ASC) d,c.device_type,b.device_type device_type_id FROM (select distinct device_ip FROM ".$this->snmp_status_set->get_table_name()." ) a LEFT  JOIN ".$this->server_set->get_table_name()." b ON a.device_ip=b.device_ip LEFT JOIN ".$this->tem_set->get_table_name()." c ON b.device_type=c.id  WHERE b.monitor!=0 AND c.snmp_system=0 $where GROUP BY c.device_type ORDER BY ct DESC, c.device_type ASC";
		$hosts = $this->snmp_status_set->base_select($sql);
		for($i=0; $i<count($hosts); $i++){
			$htmp = explode(',', $hosts[$i]['d']);//var_dump($htmp);var_dump(count($htmp));exit;
			for($j=0; $j<count($htmp); $j++){
				$tmp = explode('_', $htmp[$j]);
				$hosts[$i]['hosts'][]=array('ip'=>$tmp[0], 'status'=>$tmp[1]);
				$hosts_status[$tmp[1]]++;
			}
		}//echo '<pre>';var_dump($hosts);echo '</pre>';

		$sql = "SELECT count(0) ct, GROUP_CONCAT(CONCAT(a.device_ip,'_',b.`status`) ORDER BY INET_ATON(b.device_ip) ASC) d,c.device_type FROM (select distinct device_ip FROM ".$this->snmp_interface_set->get_table_name().") a LEFT  JOIN ".$this->server_set->get_table_name()." b ON a.device_ip=b.device_ip LEFT JOIN ".$this->tem_set->get_table_name()." c ON b.device_type=c.id  WHERE b.monitor!=0 AND c.snmp_system=1 $where GROUP BY c.device_type  ORDER BY ct DESC, c.device_type ASC";
		$networks = $this->snmp_status_set->base_select($sql);
		for($i=0; $i<count($networks); $i++){
			$htmp = explode(',', $networks[$i]['d']);
			for($j=0; $j<count($htmp); $j++){
				$tmp = explode('_', $htmp[$j]);
				$networks[$i]['hosts'][]=array('ip'=>$tmp[0], 'status'=>$tmp[1]);
				$networks_status[$tmp[1]]++;
			}
		}

		$sql = "SELECT count(0) ct, GROUP_CONCAT(CONCAT(a.device_ip,'_',b.`status`) ORDER BY INET_ATON(b.device_ip) ASC) d,c.device_type,a.app_name FROM (select distinct device_ip,app_name FROM ".$this->snmp_app_set->get_table_name().") a LEFT  JOIN ".$this->server_set->get_table_name()." b ON a.device_ip=b.device_ip LEFT JOIN ".$this->tem_set->get_table_name()." c ON b.device_type=c.id  WHERE b.monitor!=0 $where GROUP BY a.app_name  ORDER BY a.app_name ASC,ct DESC ";
		$apps = $this->snmp_status_set->base_select($sql);
		for($i=0; $i<count($apps); $i++){
			$htmp = explode(',', $apps[$i]['d']);
			for($j=0; $j<count($htmp); $j++){
				$tmp = explode('_', $htmp[$j]);
				$apps[$i]['hosts'][]=array('ip'=>$tmp[0], 'status'=>$tmp[1]);
				$apps_status[$tmp[1]]++;
			}
		}
		//var_dump($hosts);
		$nomonitorhosts = $this->server_set->base_select("select COUNT(0) ct from ".$this->server_set->get_table_name()." b LEFT JOIN ".$this->tem_set->get_table_name()." a ON b.device_type=a.id WHERE a.snmp_system=0 $where");
		$nomonitorhosts = $nomonitorhosts[0]['ct'];
		$nomonitornetworks = $this->server_set->base_select("select COUNT(0) ct from ".$this->server_set->get_table_name()." b LEFT JOIN ".$this->tem_set->get_table_name()." a ON b.device_type=a.id WHERE a.snmp_system=1 $where");
		$nomonitornetworks = $nomonitornetworks[0]['ct'];
		$this->assign("nomonitorhosts", $nomonitorhosts-$hosts_status[0]-$hosts_status[1]-$hosts_status[2]);
		$this->assign("nomonitornetworks", $nomonitornetworks-$networks_status[0]-$networks_status[1]-$networks_status[2]);
		$this->assign("hosts", $hosts);
		$this->assign("networks", $networks);
		$this->assign("apps", $apps);
		$this->assign("hosts_status", $hosts_status);
		$this->assign("networks_status", $networks_status);
		$this->assign("word_normal", urlencode('正常'));
		$this->assign("word_overthold", urlencode('超标'));
		$this->assign("word_nomonitor", urlencode('未监控'));
		$this->assign("word_down", urlencode('不可用'));
		$this->assign("apps_status", $apps_status);
		$this->display("monitor_index.tpl");
	}

	function system_monitor(){
		global $_CONFIG;
		$page_num = get_request('page');
		$ip = get_request('ip', 0, 1);
		$groupid = get_request('groupid');
		$orderkey=$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1=1";
		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND b.device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND b.device_ip LIKE '%$ip%'";
		}
		if($groupid){
			$where .= " AND b.groupid='$groupid'";
		}
		if($orderby1=='cpu'||$orderby1=='swap'||$orderby1=='disk'||$orderby1=='memory'){
			$orderby1 = 'value';
		}
		if(empty($orderby1)){
			$orderby1 = 'a.device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		if ($_SESSION['ADMIN_LEVEL'] == 0) {
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
			$sql .= " UNION SELECT devicesid FROM " . $this->resgroup_set->get_table_name() . " WHERE groupname IN (SELECT b.groupname FROM " . $this->lgroup_resourcegrp_set->get_table_name() . " a LEFT JOIN " . $this->resgroup_set->get_table_name() . " b ON a.resourceid=b.id ";
			//if($_SESSION['ADMIN_LEVEL']==0)
				{
				$sql .= "WHERE a.groupid=" . $_SESSION['ADMIN_GROUP'];
			}
			$sql .= ")";
			$alldevid = $this->member_set->base_select($sql);
			for ($i = 0; $i < count($alldevid); $i++) {
				$alldevsid[] = $alldevid[$i]['devicesid'];
			}
			if (empty($alldevsid)) {
				$alldevsid[] = 0;
			}
            $where .= " AND b.device_ip IN (SELECT device_ip FROM " . $this->devpass_set->get_table_name() . " WHERE id IN (" . implode(",", $alldevsid) . "))";
        }

		require_once('./include/select_sgroup_ajax.inc.php');
		if($g_id){
			$cronreport_alltmpip[]=1;
			$_tmpgid = $this->sgroup_set->select_by_id($g_id);
			$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid=".$g_id." or groupid IN(".$_tmpgid['child'].")");
			for($i=0; $i<count($allips); $i++){
				$cronreport_alltmpip[]=$allips[$i]['device_ip'];
			}
			$where .= " AND LEFT(b.device_ip,IF(LOCATE(':',b.device_ip)>0,LOCATE(':',b.device_ip)-1,LENGTH(b.device_ip))) IN ('".implode("','", $cronreport_alltmpip)."')";
		}

		$row_num = $this->snmp_status_set->base_select('SELECT count(0) AS count FROM '.$this->snmp_status_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." b ON a.device_ip=b.device_ip LEFT JOIN ".$this->tem_set->get_table_name()." c ON b.device_type=c.id WHERE ".$where." AND c.snmp_system=0 ".' GROUP BY a.device_ip');
		$row_num = count($row_num);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$device_ip = $this->snmp_status_set->base_select("SELECT a.device_ip FROM ".$this->snmp_status_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." b ON a.device_ip=b.device_ip LEFT JOIN ".$this->tem_set->get_table_name()." c ON b.device_type=c.id WHERE ".$where." AND c.snmp_system=0 GROUP BY a.device_ip ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		for($i=0; $i<count($device_ip); $i++){
			$dip[]=$device_ip[$i]['device_ip'];
		}
		if(empty($dip)){
			$dip[]='0';
		}
		if(in_array($orderkey,array('cpu', 'memory', 'swap', 'disk'))){
			$orderbyadd = " IF(type='$orderkey', 0, 1) ASC,";
		}

		$hosts = $this->snmp_status_set->base_select("SELECT a.*,GROUP_CONCAT(a.disk) AS disk,GROUP_CONCAT(IFNULL(a.value,-100)) disk_value,GROUP_CONCAT(a.lowvalue) disk_lowvalue,GROUP_CONCAT(a.highvalue) disk_highvalue,GROUP_CONCAT(a.seq) disk_seq,b.groupid,b.hostname,b.device_type,b.monitor FROM ".$this->snmp_status_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." b ON a.device_ip=b.device_ip LEFT JOIN ".$this->tem_set->get_table_name()." c ON b.device_type=c.id WHERE a.device_ip IN('".implode("','", $dip)."') AND c.snmp_system=0 GROUP BY a.device_ip,type  ORDER BY $orderbyadd $orderby1 $orderby2 ");
		$group = $this->sgroup_set->select_all('1', 'groupname', 'asc');
		$device_type = $this->tem_set->select_all();
		for($i=0; $i<count($device_type); $i++){
			$dtype[$device_type[$i]['id']]=$device_type[$i]['device_type'];
		}
		$ips = array();
		for($i=0; $i<count($hosts); $i++){
			if($hosts[$i]['type']!='disk'){
						
				if($hosts[$i]['value']=='-100'||$hosts[$i]['value']==null){
					$hosts[$i]['value']="<img src=\"template/admin/images/percentagebar.gif\" height=\"10\" width=\"".(100*0.4)."\" align=\"middle\" />&nbsp;&nbsp;<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >Error".'</a>';
				}elseif($hosts[$i]['value']<$hosts[$i]['lowvalue'] or $hosts[$i]['value']>$hosts[$i]['highvalue']){
					$hosts[$i]['value']="<img src=\"template/admin/images/percentagebar4.gif\" height=\"10\" width=\"".($hosts[$i]['value']*0.4)."\" align=\"middle\" /><img src=\"template/admin/images/percentagebar2.gif\" height=\"10\" width=\"".(100*0.4-$hosts[$i]['value']*0.4)."\" align=\"middle\" />&nbsp;&nbsp;<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".round($hosts[$i]['value'],2).'%</a>';
				}else{
					$hosts[$i]['value']="<img src=\"template/admin/images/percentagebar3.gif\" height=\"10\" width=\"".($hosts[$i]['value']*0.4)."\" align=\"middle\" /><img src=\"template/admin/images/percentagebar2.gif\" height=\"10\" width=\"".(100*0.4-$hosts[$i]['value']*0.4)."\" align=\"middle\" />&nbsp;&nbsp;<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".round($hosts[$i]['value'],2).'%</a>';
				}
				
				
			}else{
				$disks = explode(',', $hosts[$i]['disk']);
				$disk_value = explode(',', $hosts[$i]['disk_value']);
				$disk_lowvalue = explode(',', $hosts[$i]['disk_lowvalue']);
				$disk_highvalue = explode(',', $hosts[$i]['disk_highvalue']);
				$disk_seq = explode(',', $hosts[$i]['disk_seq']);
				for($d=0; $d<count($disks); $d++){
					if($disk_value[$d]==null){
						$interrupthost++;
						$stophost++;
						break;
					}
					if($disk_value[$d]<$disk_lowvalue[$d] or $disk_value[$d]>$disk_highvalue[$d]){
						${'tholddiskhost'}++;
						break;
					}
				}
				$diskinfo='';
				for($d=0; $d<count($disks); $d++){
					if($disk_value[$d]=='-100'||$disk_value[$d]==null){
						$diskinfo .="&nbsp;&nbsp;<img src=\"template/admin/images/percentagebar.gif\" height=\"10\" width=\"".(100*0.4)."\" align=\"middle\" />&nbsp;&nbsp;<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$disk_seq[$d].");return false;\" >Error</a>(".$disks[$d].")";
					}elseif($disk_value[$d]<$disk_lowvalue[$d] or $disk_value[$d]>$disk_highvalue[$d]){
						$diskinfo .="&nbsp;&nbsp;<img src=\"template/admin/images/percentagebar4.gif\" height=\"10\" width=\"".($disk_value[$d]*0.4)."\" align=\"middle\" /><img src=\"template/admin/images/percentagebar2.gif\" height=\"10\" width=\"".(100*0.4-$disk_value[$d]*0.4)."\" align=\"middle\" />&nbsp;&nbsp;<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$disk_seq[$d].");return false;\" >".round($disk_value[$d],2)."%</a>(".$disks[$d].")";
					}else{
						$diskinfo .="&nbsp;&nbsp;<img src=\"template/admin/images/percentagebar3.gif\" height=\"10\" width=\"".($disk_value[$d]*0.4)."\" align=\"middle\" /><img src=\"template/admin/images/percentagebar2.gif\" height=\"10\" width=\"".(100*0.4-$disk_value[$d]*0.4)."\" align=\"middle\" />&nbsp;&nbsp;<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$disk_seq[$d].");return false;\" >".round($disk_value[$d],2)."%</a>(".$disks[$d].")";
					}
					//$diskinfo .= ' '.$disks[$d].'('."<a href=\"#\" onclick=\"showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".$disk_value[$d].'%</a>)';
				}
				//echo $diskinfo;
			}

						
			$foundh = false;
			for($k=0; $k<count($ips); $k++){
				if($ips[$k]['device_ip']==$hosts[$i]['device_ip']){
					if($hosts[$i]['type']!='disk'){
						$ips[$k][$hosts[$i]['type'].'value']=$hosts[$i]['value'];
						
					}else{
						$ips[$k][$hosts[$i]['type'].'value']=$diskinfo;
					}
					$foundh = true;
				}
			}
			if(!$foundh){
				if($hosts[$i]['type']!='disk'){
					//echo '<pre>';var_dump($hosts[$i]);echo '</pre>';
					$ips[count($ips)]=array('device_ip'=>$hosts[$i]['device_ip'], $hosts[$i]['type'].'value'=>$hosts[$i]['value'],'device_type'=>$dtype[$hosts[$i]['device_type']],'hostname'=>$hosts[$i]['hostname'],'monitor'=>$hosts[$i]['monitor']);
					//var_dump($hosts[$i]);echo '<pre>';var_dump($group[$j]['ips']);echo '</pre>';
				}else{
					$ips[count($ips)]=array('device_ip'=>$hosts[$i]['device_ip'], $hosts[$i]['type'].'value'=>$diskinfo,'device_type'=>$dtype[$hosts[$i]['device_type']],'hostname'=>$hosts[$i]['hostname'],'monitor'=>$hosts[$i]['monitor']);
				}
				$group[$j]['hostnum']++;
			}
			
		}
		$usergroup = $this->usergroup_set->select_all('level=0 and attribute!=1 '.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');
		$this->assign('usergroup', $usergroup);
		$this->assign('allgroup', $usergroup);
		
		$this->assign("group", $group);
		$this->assign("hosts", $ips);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display("system_monitor.tpl");
	}

	function apache_monitor(){
		$page_num = get_request('page');
		$ip = get_request('ip', 0, 1);
		$groupid = get_request('groupid');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "app_name='apache'";
		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND app_status.device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND app_status.device_ip LIKE '%$ip%'";
		}
		
		if($orderby1=='cpuvalue'||$orderby1=='swapvalue'||$orderby1=='diskvalue'||$orderby1=='memoryvalue'){
			$orderby1 = 'value';
		}
		if(empty($orderby1)){
			$orderby1 = 'app_status.device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$total_page = $this->snmp_app_status_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$hosts = $this->snmp_app_status_set->base_select("SELECT app_status.*,b.hostname FROM ".$this->snmp_app_status_set->get_table_name()." LEFT  JOIN ".$this->server_set->get_table_name()." b ON app_status.device_ip=b.device_ip Where $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		for($i=0; $i<count($hosts); $i++){
			//$hosts[$i]['value'] = round($hosts[$i]['value'],0);
			if($hosts[$i]['value']=='-100'||$hosts[$i]['value']==null){				
				$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >Error".'</a>';
			}elseif($hosts[$i]['value']<$hosts[$i]['lowvalue'] or $hosts[$i]['value']>$hosts[$i]['highvalue']){
				if ($hosts[$i]['app_type'] == 'cpu') $hosts[$i]['value']=($hosts[$i]['value']*100).'%';
				elseif ($hosts[$i]['app_type'] == 'request rate') $hosts[$i]['value'].=' 次/秒';
				elseif ($hosts[$i]['app_type'] == 'traffic rate') $hosts[$i]['value']=strifSize($hosts[$i]['value']).' /秒';
				$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".round($hosts[$i]['value'],2).'</a>';
			}else{
				if ($hosts[$i]['app_type'] == 'cpu') $hosts[$i]['value']=($hosts[$i]['value']*100).'%';
				elseif ($hosts[$i]['app_type'] == 'request rate') $hosts[$i]['value'].=' 次/秒';
				elseif ($hosts[$i]['app_type'] == 'traffic rate') $hosts[$i]['value']=strifSize($hosts[$i]['value']).' /秒';
				$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".round($hosts[$i]['value'],2).'</a>';
			}
		}
		$this->assign("group", $group);
		$this->assign("hosts", $hosts);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display("apache_monitor.tpl");
	}

	function apache_monitor_edit(){
		$id = get_request('id');
		$status = $this->snmp_app_status_set->select_by_id($id);
		$this->assign("status", $status);
		$this->display("apache_monitor_edit.tpl");
	}
	function apache_monitor_save(){
		$id = get_request('id');
		$mail_alarm = get_request('mail_alarm',1,0);
		$sms_alarm = get_request('sms_alarm',1,0);
		$highvalue = get_request('highvalue',1,1);
		$lowvalue = get_request('lowvalue',1,1);
		$app = new snmp_app_status();
		$app->set_data('seq', $id);
		$app->set_data('mail_alarm', $mail_alarm);
		$app->set_data('sms_alarm', $sms_alarm);
		$app->set_data('highvalue', $highvalue);
		$app->set_data('lowvalue', $lowvalue);
		$status = $this->snmp_app_status_set->edit($app);
		alert_and_back('操作成功','admin.php?controller=admin_monitor&action=apache_monitor');
	}

	function mysql_monitor(){
		$page_num = get_request('page');
		$ip = get_request('ip', 0, 1);
		$groupid = get_request('groupid');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "app_name='mysql'";
		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND app_status.device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND app_status.device_ip LIKE '%$ip%'";
		}
		
		if($orderby1=='cpuvalue'||$orderby1=='swapvalue'||$orderby1=='diskvalue'||$orderby1=='memoryvalue'){
			$orderby1 = 'value';
		}
		if(empty($orderby1)){
			$orderby1 = 'app_status.device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$total_page = $this->snmp_app_status_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$hosts = $this->snmp_app_status_set->base_select("SELECT app_status.*,b.hostname FROM ".$this->snmp_app_status_set->get_table_name()." LEFT  JOIN ".$this->server_set->get_table_name()." b ON app_status.device_ip=b.device_ip Where $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		for($i=0; $i<count($hosts); $i++){
			$hosts[$i]['value'] = round($hosts[$i]['value'],2);
			if($hosts[$i]['value']!=0 && ($hosts[$i]['value']=='-100'||$hosts[$i]['value']==null)){
				$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >Error".'</a>';
			}elseif($hosts[$i]['value']<$hosts[$i]['lowvalue'] or $hosts[$i]['value']>$hosts[$i]['highvalue']){
				if ($hosts[$i]['app_type'] == 'questions rate') $hosts[$i]['value'].=' 次/秒';
				elseif ($hosts[$i]['app_type'] == 'open tables') $hosts[$i]['value'].=' 个';
				elseif ($hosts[$i]['app_type'] == 'opens') $hosts[$i]['value'].=' 个';
				elseif ($hosts[$i]['app_type'] == 'threads') $hosts[$i]['value'].=' 个';
				$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".$hosts[$i]['value'].'</a>';
			}else{
				if ($hosts[$i]['app_type'] == 'questions rate') $hosts[$i]['value'].=' 次/秒';
				elseif ($hosts[$i]['app_type'] == 'open tables') $hosts[$i]['value'].=' 个';
				elseif ($hosts[$i]['app_type'] == 'opens') $hosts[$i]['value'].=' 个';
				elseif ($hosts[$i]['app_type'] == 'threads') $hosts[$i]['value'].=' 个';
				$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".$hosts[$i]['value'].'</a>';
			}
		}
		
		$this->assign("group", $group);
		$this->assign("hosts", $hosts);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display("mysql_monitor.tpl");
	}

	function mysql_monitor_edit(){
		$id = get_request('id');
		$status = $this->snmp_app_status_set->select_by_id($id);
		$this->assign("status", $status);
		$this->display("mysql_monitor_edit.tpl");
	}
	function mysql_monitor_save(){
		$id = get_request('id');
		$mail_alarm = get_request('mail_alarm',1,0);
		$sms_alarm = get_request('sms_alarm',1,0);
		$highvalue = get_request('highvalue',1,1);
		$lowvalue = get_request('lowvalue',1,1);
		$app = new snmp_app_status();
		$app->set_data('seq', $id);
		$app->set_data('mail_alarm', $mail_alarm);
		$app->set_data('sms_alarm', $sms_alarm);
		$app->set_data('highvalue', $highvalue);
		$app->set_data('lowvalue', $lowvalue);
		$status = $this->snmp_app_status_set->edit($app);
		alert_and_back('操作成功','admin.php?controller=admin_monitor&action=mysql_monitor');
	}
	
function tomcat_monitor(){		
		$page_num = get_request('page');
		$ip = get_request('ip', 0, 1);
		$groupid = get_request('groupid');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "app_name='tomcat'";
		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND app_status.device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND app_status.device_ip LIKE '%$ip%'";
		}
		
		if($orderby1=='cpuvalue'||$orderby1=='swapvalue'||$orderby1=='diskvalue'||$orderby1=='memoryvalue'){
			$orderby1 = 'value';
		}
		if(empty($orderby1)){
			$orderby1 = 'app_status.device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$total_page = $this->snmp_app_status_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$hosts = $this->snmp_app_status_set->base_select("SELECT app_status.*,b.hostname FROM ".$this->snmp_app_status_set->get_table_name()." LEFT  JOIN ".$this->server_set->get_table_name()." b ON app_status.device_ip=b.device_ip Where $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		for($i=0; $i<count($hosts); $i++){
			$hosts[$i]['value'] = round($hosts[$i]['value'],2);
			if($hosts[$i]['value']!=0 && ($hosts[$i]['value']=='-100'||$hosts[$i]['value']==null)){
				$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >Error".'</a>';
			}elseif($hosts[$i]['value']<$hosts[$i]['lowvalue'] or $hosts[$i]['value']>$hosts[$i]['highvalue']){
				if ($hosts[$i]['app_type'] == 'traffic rate') $hosts[$i]['value'].=' KB/s';
				elseif ($hosts[$i]['app_type'] == 'cpu load') $hosts[$i]['value'].=' %';
				elseif ($hosts[$i]['app_type'] == 'request rate') $hosts[$i]['value'].=' 个';
				elseif ($hosts[$i]['app_type'] == 'memory usage') $hosts[$i]['value'].=' %';
				elseif ($hosts[$i]['app_type'] == 'busy thread') $hosts[$i]['value'].=' 个';
				$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".$hosts[$i]['value'].'</a>';
			}else{
				if ($hosts[$i]['app_type'] == 'traffic rate') $hosts[$i]['value'].=' KB/s';
				elseif ($hosts[$i]['app_type'] == 'cpu load') $hosts[$i]['value'].=' %';
				elseif ($hosts[$i]['app_type'] == 'request rate') $hosts[$i]['value'].=' 个';
				elseif ($hosts[$i]['app_type'] == 'memory usage') $hosts[$i]['value'].=' %';
				elseif ($hosts[$i]['app_type'] == 'busy thread') $hosts[$i]['value'].=' 个';
				$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".$hosts[$i]['value'].'</a>';
			}
		}
		
		$this->assign("group", $group);
		$this->assign("hosts", $hosts);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display("tomcat_monitor.tpl");
	}

	function tomcat_monitor_edit(){
		$id = get_request('id');
		$status = $this->snmp_app_status_set->select_by_id($id);
		$this->assign("status", $status);
		$this->display("tomcat_monitor_edit.tpl");
	}
	function tomcat_monitor_save(){
		$id = get_request('id');
		$mail_alarm = get_request('mail_alarm',1,0);
		$sms_alarm = get_request('sms_alarm',1,0);
		$highvalue = get_request('highvalue',1,1);
		$lowvalue = get_request('lowvalue',1,1);
		$app = new snmp_app_status();
		$app->set_data('seq', $id);
		$app->set_data('mail_alarm', $mail_alarm);
		$app->set_data('sms_alarm', $sms_alarm);
		$app->set_data('highvalue', $highvalue);
		$app->set_data('lowvalue', $lowvalue);
		$status = $this->snmp_app_status_set->edit($app);
		alert_and_back('操作成功','admin.php?controller=admin_monitor&action=tomcat_monitor');
	}
	
	function nginx_monitor(){
		$page_num = get_request('page');
		$ip = get_request('ip', 0, 1);
		$groupid = get_request('groupid');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "app_name='nginx'";
		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND app_status.device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND app_status.device_ip LIKE '%$ip%'";
		}
		
		if($orderby1=='cpuvalue'||$orderby1=='swapvalue'||$orderby1=='diskvalue'||$orderby1=='memoryvalue'){
			$orderby1 = 'value';
		}
		if(empty($orderby1)){
			$orderby1 = 'app_status.device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$total_page = $this->snmp_app_status_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$hosts = $this->snmp_app_status_set->base_select("SELECT app_status.*,b.hostname FROM ".$this->snmp_app_status_set->get_table_name()." LEFT  JOIN ".$this->server_set->get_table_name()." b ON app_status.device_ip=b.device_ip Where $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		for($i=0; $i<count($hosts); $i++){
			$hosts[$i]['value'] = round($hosts[$i]['value'],2);
			if($hosts[$i]['value']!=0 && ($hosts[$i]['value']=='-100'||$hosts[$i]['value']==null)){
				$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >Error".'</a>';
			}elseif($hosts[$i]['value']<$hosts[$i]['lowvalue'] or $hosts[$i]['value']>$hosts[$i]['highvalue']){
				if ($hosts[$i]['app_type'] == 'request rate') $hosts[$i]['value'].=' 次/秒';
				elseif ($hosts[$i]['app_type'] == 'connect num') $hosts[$i]['value'].=' 个';
				$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".$hosts[$i]['value'].'</a>';
			}else{
				if ($hosts[$i]['app_type'] == 'request rate') $hosts[$i]['value'].=' 次/秒';
				elseif ($hosts[$i]['app_type'] == 'connect num') $hosts[$i]['value'].=' 个';
				$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".$hosts[$i]['value'].'</a>';
			}
		}
		
		$this->assign("group", $group);
		$this->assign("hosts", $hosts);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display("nginx_monitor.tpl");
	}

	function nginx_monitor_edit(){
		$id = get_request('id');
		$status = $this->snmp_app_status_set->select_by_id($id);
		$this->assign("status", $status);
		$this->display("nginx_monitor_edit.tpl");
	}
	function nginx_monitor_save(){
		$id = get_request('id');
		$mail_alarm = get_request('mail_alarm',1,0);
		$sms_alarm = get_request('sms_alarm',1,0);
		$highvalue = get_request('highvalue',1,1);
		$lowvalue = get_request('lowvalue',1,1);
		$app = new snmp_app_status();
		$app->set_data('seq', $id);
		$app->set_data('mail_alarm', $mail_alarm);
		$app->set_data('sms_alarm', $sms_alarm);
		$app->set_data('highvalue', $highvalue);
		$app->set_data('lowvalue', $lowvalue);
		$status = $this->snmp_app_status_set->edit($app);
		alert_and_back('操作成功','admin.php?controller=admin_monitor&action=nginx_monitor');
	}

	function network_monitor(){
		$page_num = get_request('page');		
		$index = get_request('index');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$ip = get_request('ip', 0, 1);
		$where = "1=1";
		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND device_ip LIKE '%$ip%'";
		}
		if(empty($orderby1)){
			$orderby1 = 'port_describe';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		if ($_SESSION['ADMIN_LEVEL'] == 0) {
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
			$sql .= " UNION SELECT devicesid FROM " . $this->resgroup_set->get_table_name() . " WHERE groupname IN (SELECT b.groupname FROM " . $this->lgroup_resourcegrp_set->get_table_name() . " a LEFT JOIN " . $this->resgroup_set->get_table_name() . " b ON a.resourceid=b.id ";
			//if($_SESSION['ADMIN_LEVEL']==0)
				{
				$sql .= "WHERE a.groupid=" . $_SESSION['ADMIN_GROUP'];
			}
			$sql .= ")";
			$alldevid = $this->member_set->base_select($sql);
			for ($i = 0; $i < count($alldevid); $i++) {
				$alldevsid[] = $alldevid[$i]['devicesid'];
			}
			if (empty($alldevsid)) {
				$alldevsid[] = 0;
			}
            $where .= " AND b.device_ip IN (SELECT device_ip FROM " . $this->devpass_set->get_table_name() . " WHERE id IN (" . implode(",", $alldevsid) . "))";
        }
		$snmpips = $this->snmp_interface_set->base_select( "SELECT a.*,b.hostname,b.snmptime FROM ".$this->snmp_interface_set->get_table_name()." a LEFT JOIN ".$this->server_set->get_table_name()." b ON a.device_ip=b.device_ip LEFT JOIN ".$this->tem_set->get_table_name()." c ON b.device_type=c.id WHERE ".$where.' AND c.snmp_system=1 ORDER BY device_ip asc, '."  $orderby1 $orderby2");
		$network = array();
		for($i=0; $i<count($snmpips); $i++){			
			$foundh = false;
			$snmpips[$i]['traffic_in']=strifSize($snmpips[$i]['traffic_in']);
			$snmpips[$i]['traffic_out']=strifSize($snmpips[$i]['traffic_out']);
			$snmpips[$i]['packet_in']=strifSize($snmpips[$i]['packet_in']);
			$snmpips[$i]['packet_out']=strifSize($snmpips[$i]['packet_out']);
			$snmpips[$i]['err_packet_in']=strifSize($snmpips[$i]['err_packet_in']);
			$snmpips[$i]['err_packet_out']=strifSize($snmpips[$i]['err_packet_out']);
			for($k=0; $k<count($network); $k++){
				if($network[$k]['device_ip']==$snmpips[$i]['device_ip']){
					$network[$k]['interfaces'][] = $snmpips[$i];
					$network[$k]['ct']++;
					if($snmpips[$i]['enable']){						
						$network[$k]['runct']++;
					}else{
						$network[$k]['cutct']++;
					}
					$foundh = true;
				}
			}
			if(!$foundh){
				$micro = $snmpips[$i]['snmptime']%1000;
				$seconds = ($snmpips[$i]['snmptime']-$micro)/1000;
				$time = time();
				$start = new DateTime(date('Y-m-d H:i:s', $time-$seconds));
				$end = new DateTime(date('Y-m-d H:i:s', $time));
				$diff = $end->diff($start);
				$snmpips[$i]['snmptime_diff'] =  $diff->format('%d').'天'.' '.$diff->format('%h').':'.$diff->format('%i').':'.$diff->format('%s');

				$network[] = array(
								'device_ip' => $snmpips[$i]['device_ip'],
								'snmptime_diff' => $snmpips[$i]['snmptime_diff'],
								'hostname' => $snmpips[$i]['hostname'],
								'snmptime_diff' => $snmpips[$i]['snmptime_diff'],
								'ct' =>1,
								'runct' => ($snmpips[$i]['enable'] ? 1 : 0),
								'cutct' => ($snmpips[$i]['enable'] ? 0 : 1),
								'interfaces' => array($snmpips[$i])
							);
			}
		}
		
		$this->assign("network", $network);
		$this->assign("index", $index);
		$this->display("network_monitor.tpl");
	}
	


	function status_image(){
		$id = get_request('id');
		$rrdexport = get_request('rrdexport');
		$type = get_request('type', 0, 1);
		$duration = get_request('duration', 0, 1);
		$date = get_request('date', 0, 1);
		$date = $date ? substr($date,0,4).'-'.substr($date, 4, 2).'-'.substr($date,6,2) : null;
		switch($duration){
			case '14day':
				$start = mktime(date('H'), date('i'), 0, date('m'), date('d')-14, date('Y'));
				$end = mktime(date('H'), date('i')-date('i')%5, 0, date('m'), date('d'), date('Y'));
				$timespan = date('Y-m-d H:i').' 最近二周';
				break;
			case 'week':
				$start = mktime(date('H'), date('i'), 0, date('m'), date('d')-7, date('Y'));
				$end = mktime(date('H'), date('i')-date('i')%5, 0, date('m'), date('d'), date('Y'));
				$timespan = date('Y-m-d H:i').' 最近一周';
				break;
			case 'month':
				$start = mktime(date('H'), date('i'), 0, date('m')-1, date('d'), date('Y'));
				$end = mktime(date('H'), date('i')-date('i')%5, 0, date('m'), date('d'), date('Y'));
				$timespan = date('Y-m-d H:i').' 最近一个月';
				break;
			case 'year':
				$start = mktime(date('H'), date('i'), 0, date('m'), date('d'), date('Y')-1);
				$end = mktime(date('H'), date('i')-date('i')%5, 0, date('m'), date('d'), date('Y'));
				$timespan = date('Y-m-d H:i').' 最近一年';
				break;
			default:
				$start = -86400;
				$end = -300;
				$timespan = date('Y-m-d H:i').' 24小时';
			break;
		}

		$d = " ";$f = "%8.2lf %s";
		if($type=='localstatus'){
			$info = $this->snmp_check_port_set->base_select("SElECT * FROM local_status WHERE seq='$id' LIMIT 1");
			$info = $info[0];
			$info['type']=$info['type_name'];
			if(in_array($info['type'], array('cpu','memory','disk','swap'))){
				$d = "%";$f = "%1.1lf %%";
			}
		}elseif($type=='tcpport'){
			$info = $this->tcp_port_value_set->select_by_id($id);
			$info['type']='TCP '.$info['tcpport'];
		}elseif($type=='localport'){
			$info = $this->snmp_check_port_set->select_by_id($id);
			$info['type']='本地端口 '.$info['port'];
		}elseif($type=='localprocess'){
			$info = $this->snmp_check_process_set->select_by_id($id);
			$info['type']='本地进程 '.$info['process'];
		}elseif($type=='app'){
			$info = $this->snmp_app_status_set->select_by_id($id);
			switch($info['app_name']){
				case 'apache':
					if ($info['app_type'] == 'cpu load') {
						$info['app_type']='系统占用';$d = "%";$f = "%1.1lf %%";
						$rr = "sudo /opt/rrdtool-1.4.5/bin/rrdtool graph -  --imgformat=PNG --start=".$start." --end=".$end." --title='".$info['device_ip'].' '.$info['type'].' '.(empty($info['disk']) ? '' : $info['disk'].' ').' '.(empty($partition) ? '' : $partition.' ').$timespan."' --base=1024 --height=120 --width=500 --alt-autoscale-max --lower-limit=0  -c BACK#FFFFFF -c SHADEA#FFFFFF -c SHADEB#FFFFFF --watermark=''   --vertical-label='".$d."' --slope-mode --font TITLE:10: --font AXIS:8: --font LEGEND:8: --font UNIT:8: DEF:a=\"".$info['rrdfile']."\":val:AVERAGE CDEF:cdefa=a,8,* AREA:a#00FF00FF:\"".$info['type']."\"  GPRINT:cdefa:LAST:\"当前\: ".$f."\"  GPRINT:cdefa:AVERAGE:\"平均\: ".$f."\"  GPRINT:cdefa:MAX:\"最大\: ".$f."\"  ";
						header('Content-Type: image/png');
						echo system($rr, $out);
						exit;				
					}
				    elseif ($info['app_type'] == 'request rate') {$info['app_type']='请求速率';$d = " ";$f = "%8.2lf %s";}
				    elseif ($info['app_type'] == 'traffic rate') {$info['app_type']='流量';$d = " ";$f = "%8.2lf %s";}
				    elseif ($info['app_type'] == 'process num') {$info['app_type']='当前进行数';$d = " ";$f = "%8.2lf %s";}
				    elseif ($info['app_type'] == 'busy process') {$info['app_type']='正在处理请求';$d = " ";$f = "%8.2lf %s";}
				    else $info['app_type']='未定义';
					break;
				case 'mysql':
					if ($info['app_type'] == 'questions rate') {$info['app_type']='查询速率';$d = " ";$f = "%8.2lf %s";}
				    elseif ($info['app_type'] == 'open tables') {$info['app_type']='打开表数';$d = " ";$f = "%8.2lf %s";}
				    elseif ($info['app_type'] == 'open files') {$info['app_type']='打开文件数';$d = " ";$f = "%8.2lf %s";}
					elseif ($info['app_type'] == 'threads') {$info['app_type']='mysql进程连接数';$d = " ";$f = "%8.2lf %s";}
				    else $info['app_type']='未定义';
					break;
				case 'tomcat':
					if ($info['app_type'] == 'traffic rate') {$info['app_type']='每秒流量 KB/s';$d = " ";$f = "%8.2lf %s";}
				    elseif ($info['app_type'] == 'cpu load') {$info['app_type']='CPU平均占用率 %';$d = " ";$f = "%8.2lf %s";}
				    elseif ($info['app_type'] == 'request rate') {$info['app_type']='每秒请求数量';$d = " ";$f = "%8.2lf %s";}
					elseif ($info['app_type'] == 'memory usage') {$info['app_type']='当前jvm内存使用率';$d = " ";$f = "%8.2lf %s";}
					elseif ($info['app_type'] == 'busy thread') {$info['app_type']='当前工作线程数';$d = " ";$f = "%8.2lf %s";}
				    else $info['app_type']='未定义';
					break;
				case 'nginx':
					if ($info['app_type'] == 'request rate') {$info['app_type']='nginx 请求率（点击率）';$d = " ";$f = "%8.2lf %s";}
				    elseif ($info['app_type'] == 'connect num') {$info['app_type']='nginx 连接数（并发数）';$d = " ";$f = "%8.2lf %s";}
					elseif ($info['app_type'] == 'server accept') {$info['app_type']='处理连接数';$d = " ";$f = "%8.2lf %s";}
					elseif ($info['app_type'] == 'server handled') {$info['app_type']='创建连接数';$d = " ";$f = "%8.2lf %s";}
					elseif ($info['app_type'] == 'reading num') {$info['app_type']='读取客户端header信息数';$d = " ";$f = "%8.2lf %s";}
					elseif ($info['app_type'] == 'writing num') {$info['app_type']='返回给客户端header信息数';$d = " ";$f = "%8.2lf %s";}
					elseif ($info['app_type'] == 'waiting num') {$info['app_type']='nginx 等待连接数';$d = " ";$f = "%8.2lf %s";}
					elseif ($info['app_type'] == 'connect num') {$info['app_type']='等待驻留连接';$d = " ";$f = "%8.2lf %s";}

				    else $info['app_type']='未定义';
					break;
				default:

					break;
			}
			$info['type']=$info['app_name'].' '.$info['app_type'];
		}elseif($type=='oracle_tablespace'){
			$info = $this->oracle_tablespace_set->select_by_id($id);
			$info['device_ip'] = $info['oracle_ip'];
			$info['type']='表空间';
			$d = " ";
			$f = "%8.2lf %s";
		}elseif($type=='oracle_disk'){
			$info = $this->oracle_disk_set->select_by_id($id);
			$info['device_ip'] = $info['oracle_ip'];
			$info['type']='磁盘';
			$d = " ";
			$f = "%8.2lf %s";
		}elseif($type=='oracle_diskgroup'){
			$info = $this->oracle_diskgroup_set->select_by_id($id);
			$info['device_ip'] = $info['oracle_ip'];
			$info['type']='磁盘组';
			$d = " ";
			$f = "%8.2lf %s";
		}elseif($type=='dns'){
			$info = $this->dns_monitor_set->select_by_id($id);
			$info['type']=($info['type']==1 ? '授权域' : '非授权域');
			$d = " ";
			$f = "%8.2lf %s";
		}else{
			$info = $this->snmp_status_set->select_by_id($id);
			switch($info['type']){
				case 'memory':
					$info['type']='内存';
					break;
				case 'cpu':
					$info['type']='CPU';
					break;
				case 'disk':
					$info['type']='存储';
					break;
				case 'swap':
					$info['type']='交换空间';
					break;
			}
			$d = "%";
			$f = "%1.1lf %%";
		}
		
		if($date){
			$info['rrdfile'] = str_replace("/opt/freesvr/nm", "/opt/freesvr/nm/backup/".$date, $info['rrdfile']);
			if(!file_exists($info['rrdfile'])){
				header('Content-Type: image/png');
				echo file_get_contents('template/admin/images/nopic.jpg');
				exit;
			}else{			
				$ymd = explode('-', $date);
				$start = mktime(0, 0, 0, $ymd[1], $ymd[2], $ymd[0]);
				$end = mktime(23, 59, 59, $ymd[1], $ymd[2], $ymd[0]);
				$timespan = $date.' 24小时';
			}
		}
		if($rrdexport){
			$s = $this->server_set->select_all("device_ip='".$info['device_ip']."'");
			$this->rrd_export($start, $end, $info['device_ip'], $s[0]['hostname'], $info['type'].' '.(empty($info['disk']) ? '' : $info['disk'].' '), $info['rrdfile']);
			exit;
		}
		$rr = "sudo /opt/rrdtool-1.4.5/bin/rrdtool graph -  --imgformat=PNG --start=".$start." --end=".$end." --title='".$info['device_ip'].' '.$info['type'].' '.(empty($info['disk']) ? '' : $info['disk'].' ').' '.(empty($partition) ? '' : $partition.' ').$timespan."' --base=1024 --height=120 --width=500 --alt-autoscale-max --lower-limit=0  -c BACK#FFFFFF -c SHADEA#FFFFFF -c SHADEB#FFFFFF --watermark=''   --vertical-label='".$d."' --slope-mode --font TITLE:10: --font AXIS:8: --font LEGEND:8: --font UNIT:8: DEF:a=\"".$info['rrdfile']."\":val:AVERAGE  AREA:a#00FF00FF:\"".$info['type']."\"  GPRINT:a:LAST:\"当前\: ".$f."\"  GPRINT:a:AVERAGE:\"平均\: ".$f."\"  GPRINT:a:MAX:\"最大\: ".$f."\"  ";
		header('Content-Type: image/png');
		echo system($rr, $out);
		exit;
	}

	function rrd_export($start, $end, $device_ip, $hostname, $type, $rrdfile){
		$rr = "sudo /opt/rrdtool-1.4.5/bin/rrdtool fetch --start=".$start." --end=".$end." ".$rrdfile." AVERAGE";
		exec($rr, $o);
		$str = language("时间").",".language("IP").",".language("主机名").",".language("类型").",".language("数值")."\r\n";
		for($i=2; $i<count($o)-1; $i++){
			$v = explode(':', $o[$i]);
			$v[0]=trim($v[0]);
			$v[1]=trim($v[1]);
			$str .= date('Y-m-d H:i:s', $v[0]).",".$device_ip.",".$hostname.",".$type.",".($v[1]=='nan' ? 'null' : number_format($v[1],0,'.',''))."\r\n";
		}
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=rrd.csv"); 
		echo iconv("UTF-8", "GBK", $str);
		exit();
	}


	function interface_image(){
		$id = get_request('id');
		$type = get_request('type', 0, 1);
		$duration = get_request('duration', 0, 1);
		$date = get_request('date', 0, 1);
		$date = $date ? substr($date,0,4).'-'.substr($date, 4, 2).'-'.substr($date,6,2) : null;
		$info = $this->snmp_interface_set->select_by_id($id);
		switch($type){
			case 'traffic':
				$info['typetext']='流量';
				$info['typetextin']='入流量';
				$info['typetextout']='出流量';
				$dsin = 'traffic_in';
				$dsout = 'traffic_out';
				$rrdfile = $info['traffic_rrdfile'];
				break;
			case 'packet':
				$info['typetext']='包速率';
				$info['typetextin']='入包';
				$info['typetextout']='出包';
				$dsin = 'packet_in';
				$dsout = 'packet_out';
				$rrdfile = $info['packet_rrdfile'];
				break;
			case 'err_packet':
				$info['typetext']='错包';
				$info['typetextin']='入错包';
				$info['typetextout']='出错包';
				$dsin = 'err_packet_in';
				$dsout = 'err_packet_out';
				$rrdfile = $info['err_packet_rrdfile'];
				break;
		}
		switch($duration){
			case '14day':
				$start = mktime(date('H'), date('i'), 0, date('m'), date('d')-14, date('Y'));
				$end = mktime(date('H'), date('i')-date('i')%5, 0, date('m'), date('d'), date('Y'));
				$timespan = date('Y-m-d H:i').' 最近二周';
				break;
			case 'week':
				$start = mktime(date('H'), date('i'), 0, date('m'), date('d')-7, date('Y'));
				$end = mktime(date('H'), date('i')-date('i')%5, 0, date('m'), date('d'), date('Y'));
				$timespan = date('Y-m-d H:i').' 最近一周';
				break;
			case 'month':
				$start = mktime(date('H'), date('i'), 0, date('m')-1, date('d'), date('Y'));
				$end = mktime(date('H'), date('i')-date('i')%5, 0, date('m'), date('d'), date('Y'));
				$timespan = date('Y-m-d H\:i').' 最近一个月';
				break;
			case 'year':
				$start = mktime(date('H'), date('i'), 0, date('m'), date('d'), date('Y')-1);
				$end = mktime(date('H'), date('i')-date('i')%5, 0, date('m'), date('d'), date('Y'));
				$timespan = date('Y-m-d H:i').' 最近一年';
				break;
			default:
				$start = -86400;
				$end = -300;
				$timespan = date('Y-m-d H:i').' 24小时';
			break;
		}
		$timespan = str_replace(":", "\:", $timespan);
		if($date){
			$rrdfile = str_replace("/opt/freesvr/nm", "/opt/freesvr/nm/backup/".$date, $rrdfile);
			if(!file_exists($info['rrdfile'])){
				header('Content-Type: image/png');
				echo file_get_contents('template/admin/images/nopic.jpg');
				exit;
			}else{			
				$ymd = explode('-', $date);
				$start = mktime(0, 0, 0, $ymd[1], $ymd[2], $ymd[0]);
				$end = mktime(23, 59, 59, $ymd[1], $ymd[2], $ymd[0]);
				$timespan = $date.' 24小时';
			}
		}
		// $rr = "sudo /opt/rrdtool-1.4.5/bin/rrdtool graph -  --imgformat=PNG --start=-86400 --end=-300 --title='".$info['device_ip'].' '.$info['port_describe'].' '.$info['typetext'].' '.date('Y-m-d H:i').' 24小时'."' --rigid --base=1024 --height=120 --width=500 --alt-autoscale-max --lower-limit=0  -c BACK#FFFFFF -c SHADEA#FFFFFF -c SHADEB#FFFFFF --watermark=''   --vertical-label='' --slope-mode --font TITLE:10: --font AXIS:8: --font LEGEND:8: --font UNIT:8: DEF:a=\"".$rrdfile."\":".$dsin.":AVERAGE DEF:b=\"".$rrdfile."\":".$dsout.":AVERAGE  AREA:a#00FF00FF:\"".$info['typetextin']."\"  GPRINT:a:LAST:\"当前\: %8.2lf %s\" GPRINT:a:AVERAGE:\"平均\: %8.2lf %s\"  GPRINT:a:MAX:\"最大\: %8.2lf %s\t\n\"  LINE1:b#002A97FF:\"".$info['typetextout']."\" GPRINT:b:LAST:\"当前\:%8.2lf %s\"  GPRINT:b:AVERAGE:\"平均\:%8.2lf %s\"  GPRINT:b:MAX:\"最大\:%8.2lf %s\"  ";
		putenv("RRD_DEFAULT_FONT=/usr/share/fonts/msyh.ttf");
		$rr = '/opt/rrdtool-1.4.5/bin/rrdtool graph - --imgformat=PNG --start='.$start.' --end='.$end.' --title=\''.$info['device_ip'].' '.$info['port_describe'].' '.$info['typetext'].' '.'\' --rigid --base=1000 --height=120 --width=500 --alt-autoscale-max --lower-limit=0 COMMENT:"'.$timespan.'\c" COMMENT:"  \n"  -c BACK#FFFFFF -c SHADEA#FFFFFF -c SHADEB#FFFFFF --watermark=\'\' --vertical-label=\'\' --slope-mode --font TITLE:10: --font AXIS:8: --font LEGEND:8: --font UNIT:8: DEF:a="'.$rrdfile.'":'.$dsin.':AVERAGE DEF:b="'.$rrdfile.'":'.$dsout.':AVERAGE CDEF:cdefa=a,8,* CDEF:cdefe=b,8,* CDEF:cdefi=a,UN,INF,UNKN,IF AREA:cdefa#00FF00FF:"'.$info['typetextin'].'" GPRINT:cdefa:LAST:"当前\:%8.2lf %s" GPRINT:cdefa:AVERAGE:"平均\:%8.2lf %s" GPRINT:cdefa:MAX:"最大\:%8.2lf %s\t\n" LINE1:cdefe#0000FFFF:"'.$info['typetextout'].'" GPRINT:cdefe:LAST:"当前\:%8.2lf %s" GPRINT:cdefe:AVERAGE:"平均\:%8.2lf %s" GPRINT:cdefe:MAX:"最大\:%8.2lf %s\t\n" AREA:cdefi#8F9286FF:"" ';

		header('Content-Type: image/png');
		echo system($rr, $out);
		exit;
	}

	function monitor_status(){
		$gid = get_request('gid');
		$hms = date('H时m分s秒');
		$where = " snmp_system=0";
		if($gid){
			$where .= " AND groupid='$gid'";
		}
		$servers = $nomonitorhosts = $this->server_set->base_select("select a.*,b.device_type devtypename from ".$this->server_set->get_table_name()." a LEFT JOIN ".$this->tem_set->get_table_name()." b ON a.device_type=b.id WHERE a.monitor!=0 AND $where");
		$group = $this->sgroup_set->select_all("1", "groupname", "asc");
		$this->assign("group", $group);
		$this->assign("servers", $servers);
		$this->assign("hms", $hms);
		$this->display("monitor_status.tpl");
	}

	function oracle_tablespace_monitor(){
		$page_num = get_request('page');
		$ip = get_request('ip', 0, 1);
		$groupid = get_request('groupid');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1";
		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND oracle_tablespace.oracle_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND oracle_tablespace.oracle_ip LIKE '%$ip%'";
		}
		
		if(empty($orderby1)){
			$orderby1 = 'oracle_tablespace.oracle_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$total_page = $this->oracle_tablespace_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$hosts = $this->oracle_tablespace_set->base_select("SELECT oracle_tablespace.*,b.hostname FROM oracle_tablespace LEFT JOIN ".$this->server_set->get_table_name()." b ON oracle_tablespace.oracle_ip=b.device_ip Where $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		for($i=0; $i<count($hosts); $i++){
			$hosts[$i]['free_size']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['id'].");return false;\" >".round($hosts[$i]['free_size'],2).'</a>';
		}
		
		$this->assign("group", $group);
		$this->assign("hosts", $hosts);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display("oracle_tablespace_monitor.tpl");
	}

	function oracle_tablespace_monitor_edit(){
		$id = get_request('id');
		$status = $this->oracle_tablespace_set->select_by_id($id);
		$this->assign("status", $status);
		$this->display("oracle_tablespace_monitor_edit.tpl");
	}
	function oracle_tablespace_monitor_save(){
		$id = get_request('id');
		$mail_alarm = get_request('mail_alarm',1,0);
		$sms_alarm = get_request('sms_alarm',1,0);
		$highvalue = get_request('highvalue',1,1);
		$lowvalue = get_request('lowvalue',1,1);
		$send_interval = get_request('send_interval',1,1);
		$app = new oracle_tablespace();
		$app->set_data('id', $id);
		$app->set_data('mail_alarm', $mail_alarm);
		$app->set_data('sms_alarm', $sms_alarm);
		$app->set_data('highvalue', $highvalue);
		$app->set_data('lowvalue', $lowvalue);
		$app->set_data('send_interval', $send_interval);
		$status = $this->oracle_tablespace_set->edit($app);
		alert_and_back('操作成功','admin.php?controller=admin_monitor&action=oracle_tablespace_monitor');
	}

	function oracle_disk_monitor(){
		$page_num = get_request('page');
		$ip = get_request('ip', 0, 1);
		$groupid = get_request('groupid');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1";
		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND oracle_disk.oracle_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND oracle_disk.oracle_ip LIKE '%$ip%'";
		}
		
		if(empty($orderby1)){
			$orderby1 = 'oracle_disk.oracle_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$total_page = $this->oracle_disk_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$hosts = $this->oracle_disk_set->base_select("SELECT oracle_disk.*,b.hostname FROM oracle_disk LEFT JOIN ".$this->server_set->get_table_name()." b ON oracle_disk.oracle_ip=b.device_ip Where $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		for($i=0; $i<count($hosts); $i++){
			$hosts[$i]['free_size']=round($hosts[$i]['free_size'],2);
			//$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".$hosts[$i]['value'].'</a>';
		}
		
		$this->assign("group", $group);
		$this->assign("hosts", $hosts);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display("oracle_disk_monitor.tpl");
	}

	function oracle_disk_monitor_edit(){
		$id = get_request('id');
		$status = $this->oracle_disk_set->select_by_id($id);
		$this->assign("status", $status);
		$this->display("oracle_disk_monitor_edit.tpl");
	}
	function oracle_disk_monitor_save(){
		$id = get_request('id');
		$mail_alarm = get_request('mail_alarm',1,0);
		$sms_alarm = get_request('sms_alarm',1,0);
		$highvalue = get_request('highvalue',1,1);
		$lowvalue = get_request('lowvalue',1,1);
		$send_interval = get_request('send_interval',1,1);
		$app = new oracle_disk();
		$app->set_data('id', $id);
		$app->set_data('mail_alarm', $mail_alarm);
		$app->set_data('sms_alarm', $sms_alarm);
		$app->set_data('highvalue', $highvalue);
		$app->set_data('lowvalue', $lowvalue);
		$app->set_data('send_interval', $send_interval);
		$status = $this->oracle_disk_set->edit($app);
		alert_and_back('操作成功','admin.php?controller=admin_monitor&action=oracle_disk_monitor');
	}

	function oracle_diskgroup_monitor(){
		$page_num = get_request('page');
		$ip = get_request('ip', 0, 1);
		$groupid = get_request('groupid');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1";
		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND oracle_diskgroup.oracle_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND oracle_diskgroup.oracle_ip LIKE '%$ip%'";
		}
		
		if(empty($orderby1)){
			$orderby1 = 'oracle_diskgroup.oracle_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$total_page = $this->oracle_disk_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$hosts = $this->oracle_disk_set->base_select("SELECT oracle_diskgroup.*,b.hostname FROM oracle_diskgroup LEFT JOIN ".$this->server_set->get_table_name()." b ON oracle_diskgroup.oracle_ip=b.device_ip Where $where ORDER BY $orderby1 $orderby2 LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		for($i=0; $i<count($hosts); $i++){
			$hosts[$i]['free_size']=round($hosts[$i]['free_size'],2);
			//$hosts[$i]['value']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['seq'].");return false;\" >".$hosts[$i]['value'].'</a>';
		}
		
		$this->assign("group", $group);
		$this->assign("hosts", $hosts);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display("oracle_diskgroup_monitor.tpl");
	}

	function oracle_diskgroup_monitor_edit(){
		$id = get_request('id');
		$status = $this->oracle_diskgroup_set->select_by_id($id);
		$this->assign("status", $status);
		$this->display("oracle_diskgroup_monitor_edit.tpl");
	}
	function oracle_diskgroup_monitor_save(){
		$id = get_request('id');
		$mail_alarm = get_request('mail_alarm',1,0);
		$sms_alarm = get_request('sms_alarm',1,0);
		$highvalue = get_request('highvalue',1,1);
		$lowvalue = get_request('lowvalue',1,1);
		$send_interval = get_request('send_interval',1,1);
		$app = new oracle_diskgroup();
		$app->set_data('id', $id);
		$app->set_data('mail_alarm', $mail_alarm);
		$app->set_data('sms_alarm', $sms_alarm);
		$app->set_data('highvalue', $highvalue);
		$app->set_data('lowvalue', $lowvalue);
		$app->set_data('send_interval', $send_interval);
		$status = $this->oracle_diskgroup_set->edit($app);
		alert_and_back('操作成功','admin.php?controller=admin_monitor&action=oracle_diskgroup_monitor');
	}

	function weixin_monitor(){
		$page_num = get_request('page');
		$f_rangeStart = get_request('f_rangeStart', 0, 1);
		$f_rangeEnd = get_request('f_rangeEnd', 0, 1);
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1";
		if($f_rangeEnd){
			$where .= " AND date >= '".$f_rangeStart."'";
		}
		if($f_rangeEnd){
			$where .= " AND date <= '".$f_rangeEnd."'";
		}
		
		if(empty($orderby1)){
			$orderby1 = 'uid';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$total_page = $this->weixin_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$hosts = $this->weixin_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		
		$this->assign("group", $group);
		$this->assign("hosts", $hosts);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display("weixin_monitor.tpl");
	}

	function dns_monitor(){
		$page_num = get_request('page');
		$ip = get_request('ip', 0, 1);
		$groupid = get_request('groupid');
		$orderby1 = get_request('orderby1',0,1);
		$orderby2 = get_request('orderby2',0,1);
		$where = "1";
		if($ip == '') {
			$ip = get_request('ip',0,1);
			if($ip != '') {
				$where .= " AND device_ip LIKE '%$ip%'";
			}
		}
		else {
				$where .= " AND device_ip LIKE '%$ip%'";
		}
		
		if(empty($orderby1)){
			$orderby1 = 'device_ip';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);
		$total_page = $this->dns_monitor_set->select_count( $where);
		$newpager = new my_pager($total_page, $page_num, 20, 'page');
		$hosts = $this->dns_monitor_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		for($i=0; $i<count($hosts); $i++){
			$hosts[$i]['delayvalue']="<a href=\"#\" onclick=\"return showImg('".$hosts[$i]['device_ip'].' '.$hosts[$i]['type']."',event,".$hosts[$i]['id'].");return false;\" >".round($hosts[$i]['delayvalue'],2).'</a>';
		}
		
		$this->assign("group", $group);
		$this->assign("hosts", $hosts);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display("dns_monitor.tpl");
	}

	function dns_monitor_edit(){
		$id = get_request('id');
		$status = $this->dns_monitor_set->select_by_id($id);
		$this->assign("status", $status);
		$this->display("dns_monitor_edit.tpl");
	}
	function dns_monitor_save(){
		$id = get_request('id');
		$mail_alarm = get_request('mail_alarm',1,0);
		$sms_alarm = get_request('sms_alarm',1,0);
		$highvalue = get_request('highvalue',1,1);
		$lowvalue = get_request('lowvalue',1,1);
		$send_interval = get_request('send_interval',1,1);
		$app = new dns_monitor();
		$app->set_data('id', $id);
		$app->set_data('mail_alarm', $mail_alarm);
		$app->set_data('sms_alarm', $sms_alarm);
		$app->set_data('highvalue', $highvalue);
		$app->set_data('lowvalue', $lowvalue);
		$app->set_data('send_interval', $send_interval);
		$status = $this->dns_monitor_set->edit($app);
		alert_and_back('操作成功','admin.php?controller=admin_monitor&action=dns_monitor');
	}
}
?>
