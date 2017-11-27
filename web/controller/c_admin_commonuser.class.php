<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_commonuser extends c_base {
	
	function directory(){
		global $_CONFIG;
		$where0 = '1=1';
		if($_CONFIG['priority_cache'] || $user['searchcache']){
			$sql = "SELECT groupid id,groupname,ct count,ldapid FROM ".$this->devices_group_cache_set->get_table_name()." sg WHERE memberid=".$_SESSION['ADMIN_UID']." ORDER BY convert(sg.groupname using gbk) ASC";
			$sgroups = $this->sgroup_set->base_select($sql);
			
		}else{
			$servers = $this->server_set->select_all('1=1'.(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) ? ' and device_ip IN(SELECT device_ip FROM servers WHERE groupid='.$_SESSION['ADMIN_MSERVERGROUP']." or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).") )" : ''), 'device_ip', 'ASC');
			$devpass = $this->devpass_set->select_all('1=1'.(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) ? ' and device_ip IN(SELECT device_ip FROM servers WHERE groupid='.$_SESSION['ADMIN_MSERVERGROUP']." or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).") )" : ''), 'device_ip', 'ASC');
			$resources = $this->resgroup_set->select_all("devicesid=0", 'groupname', 'ASC');

			$useracls = $this->restrictpolicy_set->select_all('memberid='.$_SESSION['ADMIN_UID'].($_SESSION['ADMIN_GROUP'] ? " or usergroupid=".$_SESSION['ADMIN_GROUP']." or memberid=99999999 or usergroupid=99999999" : ""));
			$userdevices = array(0);
			$userresource = array(0);
			for($i=0; $i<count($useracls); $i++){
				if($useracls[$i]['devicesid']){
					$userdevices[]=$useracls[$i]['devicesid'];
				}elseif($useracls[$i]['resourceid']){
					$userresource[]=$useracls[$i]['resourceid'];
				}
			}

			$_sourceip_fit_client = $this->restrictacl_set->base_select("SELECT b.* from ".$this->restrictpolicy_set->get_table_name()." a LEFT JOIN ".$this->restrictacl_set->get_table_name()." b ON a.aclid=b.id WHERE ".'memberid='.$_SESSION['ADMIN_UID'].($_SESSION['ADMIN_GROUP'] ? " or usergroupid=".$_SESSION['ADMIN_GROUP']." or memberid=99999999 or usergroupid=99999999" : ""));
			$sourceip_fit_client = 0;
			for($i=0; $i<count($_sourceip_fit_client); $i++){
				if(!empty($_sourceip_fit_client[$i]['ip'])&&netMatch($_SERVER['REMOTE_ADDR'], $_sourceip_fit_client[$i]['ip'])){
					$sourceip_fit_client = 1;
					break;
				}
			}

			$nosourceip_fit_client = 0;
			if(!$sourceip_fit_client)
			for($i=0; $i<count($_sourceip_fit_client); $i++){
				if(empty($_sourceip_fit_client[$i]['ip'])){
					$nosourceip_fit_client = 1;
					break;
				}
			}
			
			if(1||$sourceip_fit_client||$nosourceip_fit_client)
			$allacls = $this->restrictpolicy_set->base_select(" SELECT a.*,b.year,b.aclname,b.month,b.day,b.week,b.time,b.ip FROM ".$this->restrictpolicy_set->get_table_name()." a LEFT JOIN ".$this->restrictacl_set->get_table_name()." b ON a.aclid=b.id WHERE IF(IF(LENGTH(year)>0, 1, 0)=0, 1,".date('Y')."=`year`) AND IF(IF(LENGTH(month)>0, 1, 0)=0, 1,if(locate(',".date('n').",',concat(',',month,',')),1,0)) AND IF(IF(LENGTH(day)>0, 1, 0)=0, 1,if(locate(',".date('j').",',concat(',',day,',')),1,0)) AND IF(IF(LENGTH(week)>0, 1, 0)=0, 1,if(locate(',".date('N').",',concat(',',week,',')),1,0)) AND IF(IF(LENGTH(time)>0, 1, 0)=0, 1,if(unix_timestamp(concat('1970-01-01 ',left(time,locate('-',time)-1)))<=unix_timestamp('1970-01-01 ".date('H:i')."') and unix_timestamp('1970-01-01 ".date('H:i')."') <= unix_timestamp(concat('1970-01-01 ',if(right(time,length(time)-locate('-',time))='24:00','23:59',right(time,length(time)-locate('-',time))))),1,0)) AND ".($nosourceip_fit_client ? "ip=''" : 1));

			$devices_arr = array(0);
			$resources_arr = array(0);
			for($i=0; $i<count($allacls); $i++){
				if(!(($sourceip_fit_client&&!empty($allacls[$i]['ip'])&&netMatch($_SERVER['REMOTE_ADDR'], $allacls[$i]['ip']))||(/*$nosourceip_fit_client&&*/empty($allacls[$i]['ip'])))){
					continue;
				}
				$ip_mask = explode("/", $allacls[$i]['ip']);
				$mask = $ip_mask[1];
				if($mask){
					$maskbits = is_numeric($mask) ? $mask : strpos(decbin(ip2long($mask)),"0"); 
				}
				$useraccess = $allacls[$i]['memberid']&&($allacls[$i]['memberid']==$_SESSION['ADMIN_UID'] || $allacls[$i]['memberid']==99999999);
				$groupaccess = $allacls[$i]['usergroupid']&&($allacls[$i]['usergroupid']==$_SESSION['ADMIN_GROUP'] || $allacls[$i]['usergroupid']==99999999);
				$ipaccess = 1;//!empty($allacls[$i]['ip']) ? (ip2long($ip_mask[0])>>(32-$maskbits))==(ip2long($_SERVER['REMOTE_ADDR'])>>(32-$maskbits)) : 1;

				if(($useraccess || $groupaccess)&&$ipaccess){
					if($allacls[$i]['devicesid']){
						if($allacls[$i]['devicesid']!='99999999'){
							$devices_arr[]=$allacls[$i]['devicesid'];
						}else{
							for($ii=0; $ii<count($devpass); $ii++){
								$devices_arr[]=$devpass[$ii]['id'];
							}
						}

					}elseif($allacls[$i]['resourceid']){
						if($allacls[$i]['resourceid']!='99999999'){
							$resources_arr[]=$allacls[$i]['resourceid'];
						}else{
							for($ii=0; $ii<count($resources); $ii++){
								$resources_arr[]=$resources[$ii]['id'];
							}
						}
					}
				}
			}
			unset($allacls);
			if(1||$sourceip_fit_client||$nosourceip_fit_client){
				$force_fit = true;
			}
			$devices_arr = array_diff($userdevices, $devices_arr);
			$resources_arr = array_diff($userresource,$resources_arr);
			
			$sql = "SELECT ".$_SESSION['ADMIN_UID'].",devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'].($force_fit&&!empty($devices_arr)  ? " AND devicesid NOT IN(".implode(',',$devices_arr).") " : " AND 1 ");
			$sql .= " UNION SELECT ".$_SESSION['ADMIN_UID'].",devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'].($force_fit&&!empty($devices_arr) ? " AND devicesid NOT IN(".implode(',',$devices_arr).")  " : " AND 1 ");
			$sql .= " UNION  SELECT ".$_SESSION['ADMIN_UID'].",devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE devicesid>0 and groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1').")";
			$sql .= " union select distinct ".$_SESSION['ADMIN_UID'].",devices.id devicesid from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.memberid=".$_SESSION['ADMIN_UID']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1')."";
			$sql .= " UNION SELECT  ".$_SESSION['ADMIN_UID'].",devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE devicesid>0 and groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1').")";
			$sql .= " union select distinct ".$_SESSION['ADMIN_UID'].",devices.id devicesid from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.groupid=".$_SESSION['ADMIN_GROUP']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1')."";
			$alldevid = $this->member_set->base_select($sql);
			$alldevsid = array();
			for($i=0; $i<count($alldevid); $i++){
				$alldevsid[]=$alldevid[$i]['devicesid'];
			}
			if(empty($alldevsid)){
				$alldevsid[]=0;
			}
			if(!empty($alldevsid)){
				$sql = "SELECT sg.groupname,sg.id,IFNULL(t.sct,0) count FROM ".$this->sgroup_set->get_table_name()." sg LEFT JOIN (SELECT s.groupid,count(*) sct FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ($sql) dd ON d.id=dd.devicesid LEFT JOIN ".$this->server_set->get_table_name()." s ON d.device_ip=s.device_ip WHERE dd.devicesid IS NOT NULL and (d.login_method=3 or d.login_method=5) and d.login_method!=26 group by s.groupid ) t ON sg.id=t.groupid Where $where0 AND t.sct > 0 ORDER BY ldapid asc,convert(sg.groupname using gbk) ASC";
				$sgroups = $this->sgroup_set->base_select($sql);
			}
		}
		$result['result']=1;
		$result['msg']=$matches[1];
		$result['data']=$sgroups;
		echo json_encode($result);
	}
	
	function devices(){
		global $_CONFIG;
		$gid = get_request('gid');
		$page_num = get_request('page');
		$ip = get_request('ip',1,1);
		$where = " (devices.login_method=3 or devices.login_method=5) ";
		if($ip){
			$where .= " AND devices.device_ip like '%".$ip."%' ";
		}
		if($_CONFIG['priority_cache'] || $member['searchcache']){
			if($gid){
				$where .= " AND (groupid='$gid')";
			}
			$total = $this->server_set->base_select("SELECT count(0) ct FROM `devices_cache` devices WHERE $where AND memberid=".$_SESSION['ADMIN_UID']." AND devices.devicesid  IS NOT NULL $groupby ");
			$total = $total[0]['ct'];
			$newpager = new my_pager($total, $page_num, 20, 'page');
			$alldev = $this->server_set->base_select("SELECT devices.device_ip,devices.devicesid id,devices.username,devices.login_method FROM `devices_cache` devices WHERE $where AND memberid=".$_SESSION['ADMIN_UID']." $groupby ORDER BY devices.$orderby1 $orderby2  LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		
		}else{
			$users = $this->member_set->select_all('1=1'.(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) ? ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : ''), 'username', 'ASC');
			$groups = $this->usergroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101  ? $_SESSION['ADMIN_MUSERGROUP']==0 ? ' AND 0' : (' AND id  IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ') : ''),'GroupName', 'ASC');		$this->assign('usergroup', $usergroup);

			$servers = $this->server_set->select_all('1=1'.(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) ? ' and device_ip IN(SELECT device_ip FROM servers WHERE groupid='.$_SESSION['ADMIN_MSERVERGROUP']." or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).") )" : ''), 'device_ip', 'ASC');
			$devpass = $this->devpass_set->select_all('1=1'.(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) ? ' and device_ip IN(SELECT device_ip FROM servers WHERE groupid='.$_SESSION['ADMIN_MSERVERGROUP']." or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).") )" : ''), 'device_ip', 'ASC');
			$resources = $this->resgroup_set->select_all("devicesid=0", 'groupname', 'ASC');
		
			$useracls = $this->restrictpolicy_set->select_all('memberid='.$_SESSION['ADMIN_UID'].($_SESSION['ADMIN_GROUP'] ? " or usergroupid=".$_SESSION['ADMIN_GROUP']." or memberid=99999999 or usergroupid=99999999" : ""));
			$userdevices = array(0);
			$userresource = array(0);
			for($i=0; $i<count($useracls); $i++){
				if($useracls[$i]['devicesid']){
					$userdevices[]=$useracls[$i]['devicesid'];
				}elseif($useracls[$i]['resourceid']){
					$userresource[]=$useracls[$i]['resourceid'];
				}
			}
		
			$_sourceip_fit_client = $this->restrictacl_set->base_select("SELECT b.* from ".$this->restrictpolicy_set->get_table_name()." a LEFT JOIN ".$this->restrictacl_set->get_table_name()." b ON a.aclid=b.id WHERE ".'memberid='.$_SESSION['ADMIN_UID'].($_SESSION['ADMIN_GROUP'] ? " or usergroupid=".$_SESSION['ADMIN_GROUP']." or memberid=99999999 or usergroupid=99999999" : ""));
			$sourceip_fit_client = 0;
			for($i=0; $i<count($_sourceip_fit_client); $i++){
				if(!empty($_sourceip_fit_client[$i]['ip'])&&netMatch($_SERVER['REMOTE_ADDR'], $_sourceip_fit_client[$i]['ip'])){
					$sourceip_fit_client = 1;
					break;
				}
			}
		
			$nosourceip_fit_client = 0;
			if(!$sourceip_fit_client)
				for($i=0; $i<count($_sourceip_fit_client); $i++){
					if(empty($_sourceip_fit_client[$i]['ip'])){
						$nosourceip_fit_client = 1;
						break;
					}
			}
			if(1||$sourceip_fit_client||$nosourceip_fit_client)
				$allacls = $this->restrictpolicy_set->base_select(" SELECT a.*,b.year,b.aclname,b.month,b.day,b.week,b.time,b.ip FROM ".$this->restrictpolicy_set->get_table_name()." a LEFT JOIN ".$this->restrictacl_set->get_table_name()." b ON a.aclid=b.id WHERE IF(IF(LENGTH(year)>0, 1, 0)=0, 1,".date('Y')."=`year`) AND IF(IF(LENGTH(month)>0, 1, 0)=0, 1,if(locate(',".date('n').",',concat(',',month,',')),1,0)) AND IF(IF(LENGTH(day)>0, 1, 0)=0, 1,if(locate(',".date('j').",',concat(',',day,',')),1,0)) AND IF(IF(LENGTH(week)>0, 1, 0)=0, 1,if(locate(',".date('N').",',concat(',',week,',')),1,0)) AND IF(IF(LENGTH(time)>0, 1, 0)=0, 1,if(unix_timestamp(concat('1970-01-01 ',left(time,locate('-',time)-1)))<=unix_timestamp('1970-01-01 ".date('H:i')."') and unix_timestamp('1970-01-01 ".date('H:i')."') <= unix_timestamp(concat('1970-01-01 ',if(right(time,length(time)-locate('-',time))='24:00','23:59',right(time,length(time)-locate('-',time))))),1,0)) AND ".($nosourceip_fit_client ? "ip=''" : 1));
		
				$devices_arr = array(0);
				$resources_arr = array(0);
				for($i=0; $i<count($allacls); $i++){
					if(!(($sourceip_fit_client&&!empty($allacls[$i]['ip'])&&netMatch($_SERVER['REMOTE_ADDR'], $allacls[$i]['ip']))||(/*$nosourceip_fit_client&&*/empty($allacls[$i]['ip'])))){
						continue;
					}
					$ip_mask = explode("/", $allacls[$i]['ip']);
					$mask = $ip_mask[1];
					if($mask){
						$maskbits = is_numeric($mask) ? $mask : strpos(decbin(ip2long($mask)),"0");
					}
					$useraccess = $allacls[$i]['memberid']&&($allacls[$i]['memberid']==$_SESSION['ADMIN_UID'] || $allacls[$i]['memberid']==99999999);
					$groupaccess = $allacls[$i]['usergroupid']&&($allacls[$i]['usergroupid']==$_SESSION['ADMIN_GROUP'] || $allacls[$i]['usergroupid']==99999999);
					$ipaccess = 1;//!empty($allacls[$i]['ip']) ? (ip2long($ip_mask[0])>>(32-$maskbits))==(ip2long($_SERVER['REMOTE_ADDR'])>>(32-$maskbits)) : 1;
		
					if(($useraccess || $groupaccess)&&$ipaccess){
						if($allacls[$i]['devicesid']){
							if($allacls[$i]['devicesid']!='99999999'){
								$devices_arr[]=$allacls[$i]['devicesid'];
							}else{
								for($ii=0; $ii<count($devpass); $ii++){
									$devices_arr[]=$devpass[$ii]['id'];
								}
							}
		
						}elseif($allacls[$i]['resourceid']){
							if($allacls[$i]['resourceid']!='99999999'){
								$resources_arr[]=$allacls[$i]['resourceid'];
							}else{
								for($ii=0; $ii<count($resources); $ii++){
									$resources_arr[]=$resources[$ii]['id'];
								}
							}
						}
					}
				}
				unset($allacls);
				if(1||$sourceip_fit_client||$nosourceip_fit_client){
					$force_fit = true;
				}
				$devices_arr = array_diff($userdevices, $devices_arr);
				$resources_arr = array_diff($userresource,$resources_arr);
		
				$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'].($force_fit&&!empty($devices_arr)  ? " AND devicesid NOT IN(".implode(',',$devices_arr).") " : " AND 1 ");
				$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'].($force_fit&&!empty($devices_arr) ? " AND devicesid NOT IN(".implode(',',$devices_arr).")  " : " AND 1 ");
				$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1').")";
				$sql .= " union select distinct devices.id devicesid from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.memberid=".$_SESSION['ADMIN_UID']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1')."";
				$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1').")";
				$sql .= " union select distinct devices.id devicesid from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.groupid=".$_SESSION['ADMIN_GROUP']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1')."";
				$alldevid = $this->member_set->base_select($sql);
				$alldevsid = array();
				for($i=0; $i<count($alldevid); $i++){
					$alldevsid[]=$alldevid[$i]['devicesid'];
				}
				if(empty($alldevsid)){
					$alldevsid[]=0;
				}

				if($gid){
					$where .= " AND servers.groupid='$gid'";
				}
					
				if($resgroup){
					$where .= ' AND devices.id IN(SELECT devicesid FROM resourcegroup WHERE devicesid!=0 AND groupname="'.$resgroup.'" )';
				}
					
				$where2 = $where ." AND devices.id IN(".implode(',', $alldevsid).")";
				$total = $this->server_set->base_select("SELECT count(0) ct FROM `devices` LEFT JOIN ($sql) d ON devices.id=d.devicesid LEFT JOIN servers ON devices.device_ip=servers.device_ip AND devices.hostname=servers.hostname WHERE $where AND d.devicesid IS NOT NULL $groupby ");
				$total = $total[0]['ct'];
				$newpager = new my_pager($total, $page_num, 20, 'page');
				$alldev = $this->server_set->base_select("SELECT devices.device_ip,devices.id,devices.username,lm.login_method FROM `devices` LEFT JOIN ($sql) d ON devices.id=d.devicesid LEFT JOIN login_template lm ON devices.login_method=lm.id LEFT JOIN servers ON devices.device_ip=servers.device_ip AND devices.hostname=servers.hostname WHERE $where AND d.devicesid IS NOT NULL $groupby ORDER BY devices.device_ip  LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
		}
		$result['result']=1;
		$result['msg']=$matches[1];
		$result['data']=$alldev;
		echo json_encode($result);
	}
}
?>
