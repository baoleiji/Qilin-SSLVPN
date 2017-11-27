<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_index extends c_base {
	var $allsgroup;
	function index() {		
		global $_CONFIG,$pwdconfig;
		//$named = $this->member_set->base_select("select * from named.users where name='".$_SESSION['ADMIN_USERNAME']."'");
		if($named){
			$this->assign("named_on", 1);
		}
		$user=$this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$this->assign("cacti_on", $_SESSION['CACTI_CONFIG_ON']);		
		$this->assign("log_on", $_SESSION['LOG_CONFIG_ON']);		
		$this->assign("dbaudit_on", $_SESSION['DBAUDIT_ON']&&$_SESSION['DBAUDIT_CONFIG_ON']);
		$this->assign("pwdremain", $_CONFIG['PWD_REMAIN_DAYS']);
		$this->assign("username", $_SESSION["ADMIN_USERNAME"]);
		$this->assign("amdin_level", $_SESSION["ADMIN_LEVEL"]);
		$this->assign("user", $user);
		$this->assign("config", $_CONFIG);
		if($user['webportal']){
			$this->assign("sessionlifetime", $user['webportallogin']-time());
		}else{
			$this->assign("sessionlifetime", $pwdconfig['logintimeout']*60+$_SESSION['startonlinetime']-time());
		}
		$sql = "SELECT a.*,group_concat(distinct servergroup.groupname order by convert(servergroup.groupname using gbk) ASC) gname,group_concat(distinct member.username order by member.username asc) uname FROM ".$this->notice_set->get_table_name()." a LEFT JOIN servergroup ON LOCATE(concat(',',servergroup.id,','),a.groups)  LEFT JOIN member ON LOCATE(concat(',',member.uid,','),a.members) WHERE a.enable and a.expiretime > NOW() and (`all` or member.uid=".$_SESSION['ADMIN_UID'].($_SESSION['ADMIN_GROUP'] ? " or LOCATE(concat(',',".$_SESSION['ADMIN_GROUP'].",','), concat(',',servergroup.child,',')) " : "").") group by a.id ORDER BY a.id desc";
		$_SESSION['notices'] = $this->notice_set->base_select($sql);
		$agent = strtolower($_SERVER["HTTP_USER_AGENT"]);
		$mac = ((strpos($agent,'iphone')||strpos($agent,'ipad')||strpos($agent,'macintosh')||strpos($agent,'mac os')) ? 1 : 0);
		$this->assign("ismac", $mac);
		$this->display("index.tpl");
	}

	function countsgroups($gid, $index){
		$count = 0;
		$mcount = 0;//var_dump($this->allsgroup[$index]['groupname']);echo ':';
		for($i=0; $i<count($this->allsgroup); $i++){//var_dump($this->allsgroup[$i]['groupname']);
			if($gid==$this->allsgroup[$i]['ldapid']){
				$child = $this->countsgroups($this->allsgroup[$i]['id'], $i);//echo '<br>';
				//var_dump($this->allsgroup[$i]['groupname']);var_dump($child);
				$count +=$child['count'];
				$mcount+=$child['mcount'];
			}
		}
		if(!($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) || ($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101)&&in_array($this->allsgroup[$index]['id'], $_SESSION['ADMIN_MSERVERGROUP_IDS'])){
			$this->allsgroup[$index]['count']+=$count;
			$this->allsgroup[$index]['mcount']+=$mcount;//echo '------';
		}else{
			$this->allsgroup[$index]['count']=$count;
			$this->allsgroup[$index]['mcount']=$mcount;//echo '------';
		}
		return array('count'=>$this->allsgroup[$index]['count'],'mcount'=>$this->allsgroup[$index]['mcount']);
	}

	function menu() {
		global $_CONFIG;
		
		$this->assign("cacti_on", $_SESSION['CACTI_CONFIG_ON']);		
		$user=$this->member_set->select_by_id($_SESSION['ADMIN_UID']);//var_dump(date('w'));
		switch(date('w')){
			case 1:
				$this->assign('Week', '一');
				break;
			case 2:
				$this->assign('Week', '二');
				break;
			case 3:
				$this->assign('Week', '三');
				break;
			case 4:
				$this->assign('Week', '四');
				break;
			case 5:
				$this->assign('Week', '五');
				break;
			case 6:
				$this->assign('Week', '六');
				break;
			case 0:
				$this->assign('Week', '日');
				break;
		}
		if(empty($_SESSION['ADMIN_GROUP'])){
			$_SESSION['ADMIN_GROUP']=0;
		}
		if($_CONFIG['priority_cache'] || $user['searchcache']){
			$appservers = $this->appmember_set->base_select("select * from appdevice_appserver_cache where memberid=".$_SESSION['ADMIN_UID']);
			/*$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'];
			$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'];
			$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID']." )";
			$sql .= " union select distinct devices.id devicesid from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and  a.memberid=".$_SESSION['ADMIN_UID']." ";
			$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP']." )";	
			$sql .= " union select distinct devices.id devicesid from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) AND a.groupid=".$_SESSION['ADMIN_GROUP']." ";
			*/
		}else{
			$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'];
			$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'];
			$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID']." )";
			$sql .= " union select distinct devices.id devicesid from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and  a.memberid=".$_SESSION['ADMIN_UID']." ";
			$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP']." )";	
			$sql .= " union select distinct devices.id devicesid from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.groupid=".$_SESSION['ADMIN_GROUP']." ";

			$appservers = $this->appmember_set->base_select("SELECT d.device_ip appserverip,a.name hostname,s.groupid FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ($sql) dd ON d.id=dd.devicesid LEFT JOIN ".$this->server_set->get_table_name()." s ON d.device_ip=s.device_ip left join apppserver a ON s.device_ip=a.appserverip  WHERE dd.devicesid IS NOT NULL AND d.login_method=26  and a.id is not null  GROUP BY d.device_ip", 'hostname', 'asc');
		}
		
		if($_SESSION['ADMIN_LOGIN_TIP']){			
			$this->assign("login_tip", 1);
		}
		$_SESSION['ADMIN_LOGIN_TIP'] = false;
		$where = "1";
		if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
			//$where .= " AND ( id IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).") or id IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_PARENT_IDS']).") ) ";
		}
		

		if($_SESSION['ADMIN_LEVEL']==0){
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
				/*$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'];
				$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'];
				$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID'].")";
				$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP'].")";
			
				$alldevid = $this->member_set->base_select($sql);
				$alldevsid = array();
				for($i=0; $i<count($alldevid); $i++){
					$alldevsid[]=$alldevid[$i]['devicesid'];
				}
				if($alldevsid){
					//$where .= " AND id IN";
				}else{
					$where0 .= " AND 0" ;
				}*/
				if(!empty($alldevsid)){
					$sql = "SELECT sg.*,IFNULL(t.sct,0) count FROM ".$this->sgroup_set->get_table_name()." sg LEFT JOIN (SELECT s.groupid,count(*) sct FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ($sql) dd ON d.id=dd.devicesid LEFT JOIN ".$this->server_set->get_table_name()." s ON d.device_ip=s.device_ip WHERE dd.devicesid IS NOT NULL  and d.login_method!=26 group by s.groupid ) t ON sg.id=t.groupid Where $where0 AND t.sct > 0 ORDER BY ldapid asc,convert(sg.groupname using gbk) ASC";
					$sgroups = $this->sgroup_set->base_select($sql);
					$psgroups = array();
					$psgroupsid = array();
					for($i=0; $i<count($sgroups); $i++){
						$_sgroup = $sgroups[$i];
						while($_sgroup['ldapid']&&!in_array($_sgroup['ldapid'],$psgroupsid)){
							$_sgroup=$this->sgroup_set->select_by_id($_sgroup['ldapid']);
							$_sgroup['count']=0;
							$psgroupsid[]=$_sgroup['id'];
							$psgroups[]=$_sgroup;
						}
					}
					for($i=0; $i<count($psgroups); $i++){
						$found = 0;
						for($j=0; $j<count($sgroups); $j++){
							if($psgroups[$i]['id']==$sgroups[$j]['id']){
								$found = 1;
								break;
							}
						}
						if(empty($found)) $sgroups[]=$psgroups[$i];
					}
					if($_CONFIG['LDAP']){
						if($user['ldap']){
							$this->allsgroup=$sgroups;
							for($i=0; $i<count($sgroups); $i++){
								$groupid[]=$sgroups[$i]['id'];
								if($sgroups[$i]['ldapid']==0){
									$_child = $this->countsgroups($sgroups[$i]['id'], $i);
									$sgroups[$i]['count']+=$_child['count'];
									$sgroups[$i]['mcount']+=$_child['mcount'];
								}
							}
							$sgroups=$this->allsgroup;
							$this->allsgroup=null;
						}
					}
				}
			}
						
		}else{
			//$allsgroup = $this->sgroup_set->select_all($where, 'groupname', 'asc');
			if($_SESSION['ADMIN_LEVEL']==1){
				$sql = "SELECT sg.* FROM ".$this->sgroup_set->get_table_name()." sg  Where $where and ldapid=0  ORDER BY convert(sg.groupname using gbk) ASC";
			}elseif($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
				if(!$user['searchcache']){
					$this->sgroup_set->query("call updpgroups(".$_SESSION['ADMIN_UID'].")");
				}
				$sql = "SELECT sg.*,sg.groupid id FROM servergroup_cache sg  Where memberid=".$_SESSION['ADMIN_UID']." AND $where and ldapid=0  ORDER BY convert(sg.groupname using gbk) ASC";
			}else{
				//$sql = "SELECT sg.*,IFNULL(t.count,0) FROM ".$this->sgroup_set->get_table_name()." sg LEFT JOIN (SELECT s.groupid,count(*) count FROM ".$this->devpass_set->get_table_name()." d LEFT JOIN ($sql) dd ON d.id=dd.devicesid LEFT JOIN ".$this->server_set->get_table_name()." s ON d.device_ip=s.device_ip WHERE dd.devicesid IS NOT NULL  and d.login_method!=26 group by s.groupid ) t ON sg.id=t.groupid Where $where  ORDER BY sg.groupname ASC";
				$sql = "SELECT sg.* FROM ".$this->sgroup_set->get_table_name()." sg  Where $where and ldapid=0  ORDER BY convert(sg.groupname using gbk) ASC";
			}
			$allsgroup = $this->sgroup_set->base_select($sql);
			
			/*$this->allsgroup = $allsgroup;
			for($i=0; $i<count($allsgroup); $i++){
					//if($allsgroup[$i]['groupname']!='first') continue;
				$groupid[]=$allsgroup[$i]['id'];
				if($allsgroup[$i]['ldapid']==0){
					$_child = $this->countsgroups($allsgroup[$i]['id'], $i);
					if(!($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) || ($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101)&&in_array($allsgroup[$i]['id'], $_SESSION['ADMIN_MSERVERGROUP_IDS'])){
						$allsgroup[$i]['count']+=$_child['count'];
						$allsgroup[$i]['mcount']+=$_child['mcount'];
					}else{
						$allsgroup[$i]['count']=$_child['count'];
						$allsgroup[$i]['mcount']=$_child['mcount'];
					}
				}
			}
			$allsgroup = $this->allsgroup;
			$this->allsgroup=null;
			*/
			//if(!empty($groupid)){
				//$sgroup = $this->sgroup_set->select_all("id IN(".implode(',', $groupid).")");
			/*
			$allldaptmp = $this->sgroup_set->base_select("SELECT a.*,IFNULL(b.ct,0) count, IFNULL(c.ct,0) mcount FROM ".$this->sgroup_set->get_table_name()." a LEFT JOIN ( SELECT count(*) ct,ldapid FROM ".$this->sgroup_set->get_table_name()." WHERE level=0 GROUP BY ldapid ) b ON a.id=b.ldapid LEFT JOIN ( SELECT count(*) ct,ldapid FROM ".$this->usergroup_set->get_table_name()." GROUP BY ldapid ) c ON a.id=c.ldapid WHERE a.level>0 AND $where ORDER BY a.level ASC, convert(groupname using gbk) ASC");

			if($_CONFIG['LDAP']){
				for($i=0; $i<count($allldaptmp); $i++){
					if($allldaptmp[$i]['level']==1){
						$allldap[]=$allldaptmp[$i];
					}else{
						for($j=0; $j<count($allldap); $j++){
							if($allldap[$j]['id']==$allldaptmp[$i]['ldapid']){
								$allldap[$j]['count'] += $allldaptmp[$i]['count'];
								if($allldaptmp[$i]['level']==2)
								$allldap[$j]['mcount'] += $allldaptmp[$i]['mcount'];
								//$allldap[$j]['count'] += 1;
								$allldap[$j]['children'][] = $allldaptmp[$i];
								break;
							}
						}
					}
				}
				if(empty($allldap)){
					for($i=0; $i<count($allldaptmp); $i++){
						if($allldaptmp[$i]['level']==2){
							$allldap[]=$allldaptmp[$i];
						}
					}
				}
			}*/
		}
		
		if($_SESSION['ADMIN_LEVEL']==0){//var_dump($appservers);
			for($i=0; $i<count($appservers); $i++){
				if($_CONFIG['priority_cache'] || $user['searchcache']){
					$appsgroups=array();
					$psgroups = array();
					$psgroupsid = array();
					$sql = "select * from appdevice_cache where appserverip='".$appservers[$i]['appserverip']."' and memberid=".$_SESSION['ADMIN_UID'];
					$appmember=$this->server_set->base_select($sql);
					$appservers[$i]['appname']=$appmember;
					$appservers[$i]['count']=count($appmember);
					$sql = "select memberid,groupid id,groupname,ct count,ldapid,appserverip from appdevice_group_cache where appserverip='".$appservers[$i]['appserverip']."' and memberid=".$_SESSION['ADMIN_UID'];
					$appservers[$i]['appsgroups'] = $this->server_set->base_select($sql);
				}else{
					$appsgroups=array();
					$psgroups = array();
					$psgroupsid = array();
					$sql = "SELECT b.id appdeviceid, b.device_ip, c.appserverip,c.name,ap.icon,c.path,c.url,c.appprogramname FROM ".$this->appdevice_set->get_table_name()." b  LEFT JOIN ".$this->apppub_set->get_table_name()." c ON b.apppubid=c.id LEFT JOIN ".$this->appprogram_set->get_table_name()." ap ON c.appprogramname=ap.name ";
					
					$sql .= " WHERE c.appserverip='".$appservers[$i]['appserverip']."' AND (b.id IN(select appdeviceid FROM ".$this->appmember_set->get_table_name(). " WHERE memberid=".$_SESSION['ADMIN_UID'].") OR b.id IN(select appdevicesid FROM ".$this->appresgroup_set->get_table_name(). " WHERE appgroupname IN(select ag.appgroupname FROM ".$this->luser_appresourcegrp_set->get_table_name()." la LEFT JOIN ".$this->appresgroup_set->get_table_name()." ag ON la.appresourceid=ag.id   WHERE memberid=".$_SESSION['ADMIN_UID'].")) OR b.id IN(select distinct appdevices.id from ".$this->luser_appresourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->appresgroup_set->get_table_name()." a left join ".$this->appresgroup_set->get_table_name()." b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid left join appdevices on appdevices.device_ip=s.device_ip where t.id and appdevices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) and a.memberid=".$_SESSION['ADMIN_UID'].")";
					if($_SESSION['ADMIN_GROUP']){
						$sql .= " OR b.id IN(select appdeviceid FROM ".$this->appgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'].") OR b.id IN(select appdevicesid FROM ".$this->appresgroup_set->get_table_name(). " WHERE appgroupname IN(select ag.appgroupname FROM ".$this->lgroup_appresourcegrp_set->get_table_name()." la LEFT JOIN ".$this->appresgroup_set->get_table_name()." ag ON la.appresourceid=ag.id   WHERE la.groupid=".$_SESSION['ADMIN_GROUP'].")) OR b.id IN(select distinct appdevices.id from ".$this->lgroup_appresourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->appresgroup_set->get_table_name()." a left join ".$this->appresgroup_set->get_table_name()." b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid left join appdevices on appdevices.device_ip=s.device_ip where t.id and appdevices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) and a.groupid=".$_SESSION['ADMIN_GROUP'].")";
					}
					$sql .= ") ";
					//$sql .= " AND c.appserverip='".$appserverip."'";
					if($appname){
						$sql .= "  AND c.name like '%".$appname."%'";
					}
					//$sql .= " GROUP BY ap.name";
					$appmember=$this->server_set->base_select($sql);
					$appservers[$i]['appname']=$appmember;
					$appservers[$i]['count']=count($appmember);
					$appsgroupsid = array();//var_dump(count($appmember));
					for($j=0; $j<count($appmember); $j++){
						$tmpserver = $this->server_set->select_all("device_ip='".$appmember[$j]['device_ip']."'");
						if($tmpserver[0]['groupid']&&!in_array($tmpserver[0]['groupid'], $appsgroupsid)){
							$appsgroupsid[]=$tmpserver[0]['groupid'];
							$tmpgroup = $this->sgroup_set->select_by_id($tmpserver[0]['groupid']);
							$tmpgroup['count']=0;
							$appsgroups[]=$tmpgroup;
						}
						for($m=0; $m<count($appsgroups); $m++){//var_dump($appsgroups[$m]['id']);var_dump($tmpserver[0]['groupid']);
							if($appsgroups[$m]['id']==$tmpserver[0]['groupid']){
								$appsgroups[$m]['count']+=1;
								break;
							}
						}
					}
					
					for($ii=0; $ii<count($appsgroups); $ii++){
						$_sgroup = $appsgroups[$ii];
						while($_sgroup['ldapid']&&!in_array($_sgroup['ldapid'],$psgroupsid)){
							$_sgroup=$this->sgroup_set->select_by_id($_sgroup['ldapid']);
							$_sgroup['count']=0;
							$psgroupsid[]=$_sgroup['id'];
							$psgroups[]=$_sgroup;
						}
					}
					for($ii=0; $ii<count($psgroups); $ii++){
						$found = 0;
						for($jj=0; $jj<count($appsgroups); $jj++){
							if($psgroups[$ii]['id']==$appsgroups[$jj]['id']){
								$found = 1;
								break;
							}
						}
						if(empty($found)) $appsgroups[]=$psgroups[$ii];
					}
					if($_CONFIG['LDAP']){
						if($user['ldap']){
							$this->allsgroup=$appsgroups;
							for($ii=0; $ii<count($appsgroups); $ii++){
								$groupid[]=$appsgroups[$ii]['id'];
								if($appsgroups[$ii]['ldapid']==0){
									$_child = $this->countsgroups($appsgroups[$ii]['id'], $ii);
									$appsgroups[$ii]['count']+=$_child['count'];
								}
							}
							$appservers[$i]['appsgroups']=$this->allsgroup;
							$this->allsgroup=null;
						}
					}
				}
				$psgroups = null;
				$psgroupsid = null;
				$appsgroups=null;
			}//var_dump($appsgroups);
			
		}
		//echo '<pre>';var_dump($appservers);echo '</pre>';

		$this->assign("pwdremain", $_CONFIG['PWD_REMAIN_DAYS']);
		$this->assign("xunjianbackup", $_CONFIG['XUNJIANBACKUP']);
		$this->assign("username", $_SESSION["ADMIN_USERNAME"]);
		$this->assign("amdin_level", $_SESSION["ADMIN_LEVEL"]);
		$this->assign("amdin_logindate", $_SESSION["ADMIN_LASTDATE"]);
		$this->assign("amdin_ip", $_SESSION["ADMIN_IP"]);
		$this->assign("user", $user);
		$this->assign("appservers", $appservers);
		$this->assign("allsgroup", $allsgroup);
		$this->assign("allugroup", $allugroup);
		$this->assign("allldap", $allldap);
		$this->assign('Year', date('Y'));
		$this->assign('Month', date('m'));
		$this->assign('Day', date('d'));
		$this->assign("sgroups", $sgroups);
		$this->assign("appsgroups", $appsgroups);
		$this->assign("_config", $_CONFIG);
		exec("sudo /opt/freesvr/audit/sbin/license-print", $out, $return);
		$_o = explode(' ', $out[0]);
		$_p = explode('-', $_o[3]);
		$_SESSION['LICENSE_KEY_NETMANAGER']=$_p[1];
		$this->assign("netmanageenable", $_p[1]);
		$this->assign("logenable", $_p[2]);
		$this->assign("appenable", $_p[4]);
		$this->display("menu.tpl");
	}

	function main() {
			global $_CONFIG;
			$page_num = get_request('page');
			$gid = get_request('gid');
			$resgroup = get_request('resgroup', 0, 1);
			$logintype = get_request('logintype', 0, 1);
			$appserverip = get_request('appserverip', 0, 1);
			$sip = get_request('sip', 0, 1);
			$hostname = get_request('hostname', 0, 1);
			$member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
			$this->assign('member', $member);
			$lb = $this->loadbalance_set->select_all();
			$localhost = $this->get_eth0_ip();
			$localhost = $localhost['eth0'];
			$this->assign("localip",$localhost);
			$this->assign("lb",$lb);
			$this->assign("logindebug",$_CONFIG['LOGIN_DEBUG']);
			$orderby1 = get_request('orderby1', 0, 1);
			$orderby2 = get_request('orderby2', 0, 1);
			$all = get_request('all', 0, 1);
			$appname = get_request('appname', 0, 1);
			$appprogramname = get_request('appprogramname', 0, 1);
			$where = '1=1';

			if($logintype!='apppub'){
				if($all){
					$_SESSION['logintype'] = null;
				}
				if($logintype){
					$_SESSION['logintype'] = $logintype;
				}elseif($_SESSION['logintype']){
					$logintype = $_SESSION['logintype'];
				}
				$_GET['logintype'] = $logintype;
				if($logintype!='_apppub'){
					$where .= " AND devices.login_method!=26 ";
				}
			}
			if($appserverip){
				$where .= " AND devices.device_ip='".$appserverip."'";
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

			$curr_url = $_SERVER['PHP_SELF'] . "?";
			if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
				$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
			}
			else {
				$curr_url .= $_SERVER['QUERY_STRING'];
			}
			$this->assign('curr_url', $curr_url);
			$this->assign("rdpdiskauth_up", $_COOKIE['rdpdiskauth_up']);
			$this->assign("bydomain", $_COOKIE['bydomain']);

			if(	$_SESSION['ADMIN_LEVEL'] == 0) {
				if(($msiepos=strpos($_SERVER['HTTP_USER_AGENT'], "Windows NT"))>0){
					$this->assign("windows_version", floatval(substr($_SERVER['HTTP_USER_AGENT'], $msiepos+10, strpos($_SERVER['HTTP_USER_AGENT'], ";", $msiepos+1)-$msiepos-10)));
				}
				$alltem = $this->tem_set->select_all();
			
				if($logintype){
					$found = 0;
					foreach($alltem as $tems) {
						if(strtolower($tems['login_method'])==strtolower($logintype=='_apppub' ? 'apppub' : $logintype)) {
							$found = 1;
							if(strtolower($logintype)=='rdp'){
								$where .= " AND (devices.login_method=".$tems['id']." )";
							}elseif(strtolower($logintype)=='ssh'){
								$where .= " AND (devices.login_method=".$tems['id']." or devices.login_method=25)";
							}else{
								$where .= " AND devices.login_method=".$tems['id'];
							}
							
						}
					}
					if(!$found){
						$where .= " AND 0 ";
					}
				}
				if($sip){
					$where .= " AND devices.device_ip like '%$sip%'"; 
				}
				if($hostname){
						$where .= " AND devices.hostname like '%$hostname%'"; 
					
				}
				//$_SERVER['REMOTE_ADDR']='111.193.133.252';
				$_gidinfo = $this->sgroup_set->select_by_id($gid);
				if($_CONFIG['priority_cache'] || $member['searchcache']){
					if($gid){
						if($logintype!='_apppub'&&$logintype!='apppub'){
							$where .= " AND (groupid='$gid' or groupid IN(".$_gidinfo['child']."))";
						}
					}
					$total = $this->server_set->base_select("SELECT count(0) ct FROM `devices_cache` devices WHERE $where AND memberid=".$_SESSION['ADMIN_UID']." AND devices.devicesid IS NOT NULL $groupby ");
					$total = $total[0]['ct'];
					$newpager = new my_pager($total, $page_num, 20, 'page');
					$alldev = $this->server_set->base_select("SELECT devices.*,devices.devicesid id FROM `devices_cache` devices WHERE $where AND memberid=".$_SESSION['ADMIN_UID']." $groupby ORDER BY devices.$orderby1 $orderby2  LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");

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
					//$where .=" AND devices.id IN(".implode(',', $alldevsid).")";
					if($gid){
						if($logintype!='_apppub'&&$logintype!='apppub'){
							$_gidinfo = $this->sgroup_set->select_by_id($gid);
							if($_CONFIG['LDAP']){
								$where .= " AND (groupid='$gid' or groupid IN(".$_gidinfo['child']."))";
							}else{
								$where .= " AND servers.groupid='$gid'";
							}
						}else{
							$where .= " AND (groupid='$gid' or groupid IN(".$_gidinfo['child']."))";
						}
					}
					
					if($resgroup){
						$where .= ' AND devices.id IN(SELECT devicesid FROM resourcegroup WHERE devicesid!=0 AND groupname="'.$resgroup.'" )';
					}
					
					$where2 = $where ." AND devices.id IN(".implode(',', $alldevsid).")";
					$total = $this->server_set->base_select("SELECT count(0) ct FROM `devices` LEFT JOIN ($sql) d ON devices.id=d.devicesid LEFT JOIN servers ON devices.device_ip=servers.device_ip AND devices.hostname=servers.hostname WHERE $where AND d.devicesid IS NOT NULL $groupby ");
					$total = $total[0]['ct'];
					$newpager = new my_pager($total, $page_num, 20, 'page');
					$alldev = $this->server_set->base_select("SELECT devices.*,servers.status,servers.monitor FROM `devices` LEFT JOIN ($sql) d ON devices.id=d.devicesid LEFT JOIN servers ON devices.device_ip=servers.device_ip AND devices.hostname=servers.hostname WHERE $where AND d.devicesid IS NOT NULL $groupby ORDER BY devices.$orderby1 $orderby2  LIMIT $newpager->intStartPosition, $newpager->intItemsPerPage");
				}
				
				$row_num = count($alldev);
				for($i=0;$i<$row_num;$i++) {
					if($_CONFIG['priority_cache'] || $member['searchcache']){
						$_serverinfo = $this->server_set->select_all("device_ip='".$alldev[$i]['device_ip']."'");
						$alldev[$i]['status'] = $_serverinfo[0]['status'];
						$alldev[$i]['monitor'] = $_serverinfo[0]['monitor'];
					}
					if($row = $this->luser_set->select_all(" memberid=".$_SESSION['ADMIN_UID']." AND devicesid=".$alldev[$i]['id'])){
					}else if($row = $this->luser_set->base_select("select a.* from luser_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=".$alldev[$i]['id'].") t on a.resourceid=t.id left join member on a.memberid=member.uid where t.id and member.uid=".$_SESSION['ADMIN_UID']." and t.devicesid")){
					}else if($row = $this->lgroup_set->select_all(" groupid=".$_SESSION['ADMIN_GROUP']." AND devicesid=".$alldev[$i]['id'])){
					}else if($row = $this->luser_set->base_select("select a.* from lgroup_resourcegrp a left join (select a.id,b.devicesid from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 AND b.devicesid=".$alldev[$i]['id'].") t on a.resourceid=t.id left join member on a.groupid=member.groupid where t.id and member.groupid=".$_SESSION['ADMIN_GROUP']." and t.devicesid")){
					}
					$alldev[$i]['twopriority'] = 1;
					if($row[0]['workflow']){
						$alldev[$i]['workflow_status']=2;
						$wf_contant = $this->workflow_contant_set->select_all("sid=(SELECT contant FROM workflow WHERE sid=".$row[0]['workflow'].")");
						$alldev[$i]['twopriority'] = ($wf_contant[0]['name']=='登录授权' ? 0 : 1);
						$appro_history=$this->workflow_set->base_select("SELECT status FROM ".$this->workflow_set->get_table_name()." WHERE devicesid=".intval($alldev[$i]['id'])." AND memberid=".intval($_SESSION['ADMIN_UID'])." AND islogin=0 ORDER BY sid DESC LIMIT 1");
						if($appro_history&&$appro_history[0]['status']==4){
							$alldev[$i]['workflow_status']=$appro_history[0]['status'];
						}
					}//var_dump($alldev[$i]['workflow_status']);
					/*$twoauth = $this->member_set->select_all("uid IN(SELECT twoauth FROM ".$this->luser_resourcegrp_set->get_table_name()." WHERE memberid='".$_SESSION['ADMIN_UID']."' AND resourceid IN(SELECT b.id FROM ".$this->resgroup_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.groupname=b.groupname AND b.devicesid=0 WHERE a.devicesid='".$alldev[$i]['id']."') UNION SELECT twoauth FROM ".$this->lgroup_resourcegrp_set->get_table_name()." WHERE groupid='".$_SESSION['ADMIN_GROUP']."' AND resourceid IN(SELECT c.id FROM ".$this->resgroup_set->get_table_name()." c LEFT JOIN ".$this->resgroup_set->get_table_name()." d ON c.groupname=d.groupname AND d.devicesid=0 WHERE c.devicesid='".$alldev[$i]['id']."') )");
					if(!empty($twoauth)){
						$approve = $this->login4approve_set->select_all("username='".$alldev[$i]['username']."' AND ip='".$alldev[$i]['device_ip']."' AND webuser='".$_SESSION['ADMIN_USERNAME']."' AND login_method='".$alldev[$i]['login_method']."' AND approved<2");
						$approve = $approve[0];//var_dump($approve);
						if(!$approve['approved']){
							$alldev[$i]['puttyhong']=1;
						}
					}*/
					$alldev[$i]['connections'] = intval($this->rdp_set->select_count("addr='".$alldev[$i]['device_ip']."' AND user='".$alldev[$i]['username']."' AND (LOGIN_TEMPLATE=8 or LOGIN_TEMPLATE=22) AND rdp_runnig=1"));
					foreach($alltem as $tem) {
						if($alldev[$i]['login_method'] == $tem['id']) {
							$alldev[$i]['login_method'] = $tem['login_method'];
						}
						elseif($alldev[$i]['device_type'] == $tem['id']) {
							$alldev[$i]['device_type'] = $tem['device_type'];
						}
					}
					switch ($alldev[$i]['passwordtry']){
						case '0':
							$alldev[$i]['passwordtrys']=language('登录正常');
							break;
						case '1':
							$alldev[$i]['passwordtrys']=language('密码错误');
							break;
						case '2':
							$alldev[$i]['passwordtrys']=language('无法连接');
							break;
						default:
							$alldev[$i]['passwordtrys']=language('无法判断');
							break;
					}
				}
				if($logintype=='apppub' || $logintype=='_apppub'){
					
					$sqlunion = "";
					if($_CONFIG['priority_cache'] || $member['searchcache']){
						$sql = "select * from appdevice_cache where memberid=".$_SESSION['ADMIN_UID']." ";
						if($appserverip){
							$sql .= " AND appserverip='".$appserverip."'";
						}
						if($sip){
							$sql .= " AND device_ip like '%".$sip."%'";
						}
						if($gid){
							$_gidinfo = $this->sgroup_set->select_by_id($gid);
							if($_CONFIG['LDAP']){
								$sql .= "  AND (groupid='".intval($gid)."' or groupid IN(".$_gidinfo['child']."))";
							}else{
								$sql .= "  AND groupid='".intval($gid)."'";
							}
								
						}
						if($appname){
							$sql .= "  AND name like '%".$appname."%'";
						}
						if($appprogramname){
							$sql .= "  AND appprogramname like '%".$appprogramname."%'";
						}
						//$alldev[$i]['appmember']=$this->server_set->base_select($sql);
					}else{
						$sql = "SELECT devss.id devid,b.id appdeviceid, b.device_ip,b.desc,b.username,ss.hostname,c.appprogramname, c.appserverip,c.name,ap.icon,c.path,c.url FROM ".$this->appdevice_set->get_table_name()." b  LEFT JOIN ".$this->apppub_set->get_table_name()." c ON b.apppubid=c.id LEFT JOIN ".$this->appprogram_set->get_table_name()." ap ON c.appprogramname=ap.name ";
						//if($gid){
							$sql .= " LEFT JOIN ".$this->server_set->get_table_name()." ss ON b.device_ip=ss.device_ip ";
						//}
							$sql .= " LEFT JOIN ".$this->devpass_set->get_table_name()." devss ON c.appserverip=devss.device_ip and devss.login_method=26";
						$sql .= " WHERE (b.id IN(select appdeviceid FROM ".$this->appmember_set->get_table_name(). " WHERE memberid=".$_SESSION['ADMIN_UID'].") OR b.id IN(select appdevicesid FROM ".$this->appresgroup_set->get_table_name(). " WHERE appgroupname IN(select ag.appgroupname FROM ".$this->luser_appresourcegrp_set->get_table_name()." la LEFT JOIN ".$this->appresgroup_set->get_table_name()." ag ON la.appresourceid=ag.id   WHERE memberid=".$_SESSION['ADMIN_UID'].")) OR b.id IN(select distinct appdevices.id from ".$this->luser_appresourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->appresgroup_set->get_table_name()." a left join ".$this->appresgroup_set->get_table_name()." b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid left join appdevices on appdevices.device_ip=s.device_ip where t.id and appdevices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) and a.memberid=".$_SESSION['ADMIN_UID'].")";
						if($member['groupid']){
							$sql .= " OR b.id IN(select appdeviceid FROM ".$this->appgroup_set->get_table_name()." WHERE groupid=".$member['groupid'].") OR b.id IN(select appdevicesid FROM ".$this->appresgroup_set->get_table_name(). " WHERE appgroupname IN(select ag.appgroupname FROM ".$this->lgroup_appresourcegrp_set->get_table_name()." la LEFT JOIN ".$this->appresgroup_set->get_table_name()." ag ON la.appresourceid=ag.id   WHERE la.groupid=".$member['groupid'].")) OR b.id IN(select distinct appdevices.id from ".$this->lgroup_appresourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->appresgroup_set->get_table_name()." a left join ".$this->appresgroup_set->get_table_name()." b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid left join appdevices on appdevices.device_ip=s.device_ip where t.id and appdevices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) and a.groupid=".$member['groupid'].")";
						}
						$sql .= ") ";
						//$sql .= " AND c.appserverip='".$alldev[$i]['device_ip']."'";
							
						if($appserverip){
							$sql .= " AND c.appserverip='".$appserverip."'";
						}
						if($sip){
							$sql .= " AND b.device_ip like '%".$sip."%'";
						}
						if($gid){
							$_gidinfo = $this->sgroup_set->select_by_id($gid);
							if($_CONFIG['LDAP']){
								$sql .= "  AND (ss.groupid='".intval($gid)."' or groupid IN(".$_gidinfo['child']."))";
							}else{
								$sql .= "  AND ss.groupid='".intval($gid)."'";
							}
								
						}
						if($appname){
							$sql .= "  AND c.name like '%".$appname."%'";
						}
						if($appprogramname){
							$sql .= "  AND c.appprogramname like '%".$appprogramname."%'";
						}
						
						if($hostname){
							$sql .= "  AND ss.hostname like '%".$hostname."%'";
						}
						//$sql .= " GROUP BY c.name";
						//$alldev[$i]['appmember']=$this->server_set->base_select($sql);
					}
					
					$total = $this->server_set->base_select("SELECT count(0) ct FROM ($sql)t ");
					$total = $total[0]['ct']+count($alldev);
					$newpager = new my_pager($total, $page_num, 20, 'page');
					$start = $newpager->intStartPosition-count($alldev);
					$start = $start > 0 ? $start : 0;
					$limit = $newpager->intItemsPerPage;
					if($page_num<=1){
						$limit = $newpager->intItemsPerPage-count($alldev);
					}
					$appmembers = $this->server_set->base_select($sql." order by device_ip LIMIT $start, $limit");
				
				}
				
				$curr_url = $_SERVER['PHP_SELF'] . "?";
				if(strstr($_SERVER['QUERY_STRING'], "&page=")) {
					$curr_url .= substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "&page="));
				}
				else {
					$curr_url .= $_SERVER['QUERY_STRING'];
				}
				$this->assign('curr_url', $curr_url);
				//echo '<pre>';print_r($alldev);echo '</pre>';
				$this->assign("webusername", $_SESSION['ADMIN_USERNAME']);
				$this->assign('sip', $sip);
				$this->assign('hostname', $hostname);
				$this->assign('gid', $gid);
				$this->assign('title', language('服务器列表'));
				$this->assign('alldev', $alldev);
				$this->assign('logintype', $logintype);
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('total', $total);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);
				$this->assign('appserverip', $appserverip);
				$this->assign('appservers', $this->appserver_set->select_all("1", "appserverip", "asc"));
				$this->assign('appmember', $appmembers);
				$this->display("usrdev.tpl");
			}
			elseif($_SESSION['ADMIN_LEVEL'] == 10 or $_SESSION['ADMIN_LEVEL'] == 101) {
				if($sip){
					$where = " b.device_ip like '%$sip%'"; 
				}
				if($hostname){
					$where = " b.hostname like '%$hostname%'"; 
				}
				if($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101){
					$where .= ' and b.device_ip IN(SELECT device_ip FROM servers WHERE groupid='.$_SESSION['ADMIN_MSERVERGROUP']." or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")";
				}

				$row_num = $this->devpass_set->base_select("SELECT count(*) ct FROM ".$this->devpass_set->get_table_name()." devices LEFT JOIN ".$this->server_set->get_table_name()." b ON devices.device_ip=b.device_ip LEFT JOIN ".$this->sgroup_set->get_table_name()." c ON b.groupid=c.id WHERE $where");
				$row_num = $row_num[0]['ct'];
				//$row_num = $this->devpass_set->select_count($where);
				$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
				$alldev = $this->devpass_set->base_select("SELECT devices.*,c.groupname,b.id serverid FROM ".$this->devpass_set->get_table_name()." devices LEFT JOIN ".$this->server_set->get_table_name()." b ON devices.device_ip=b.device_ip LEFT JOIN ".$this->sgroup_set->get_table_name()." c ON b.groupid=c.id WHERE $where ORDER BY $orderby1 $orderby2 LIMIT  $newpager->intStartPosition, $newpager->intItemsPerPage");

				$alltem = $this->tem_set->select_all();
				$row_num = count($alldev);

				for($i=0;$i<$row_num;$i++) {
					foreach($alltem as $tem) {
						if($alldev[$i]['login_method'] == $tem['id']) {
							$alldev[$i]['login_method'] = $tem['login_method'];
						}
						elseif($alldev[$i]['device_type'] == $tem['id']) {
							$alldev[$i]['device_type'] = $tem['device_type'];
						}
					}
					
					switch ($alldev[$i]['passwordtry']){
						case '0':
							$alldev[$i]['passwordtrys']=language('登录正常');
							break;
						case '1':
							$alldev[$i]['passwordtrys']=language('密码错误');
							break;
						case '2':
							$alldev[$i]['passwordtrys']=language('无法连接');
							break;
						default:
							$alldev[$i]['passwordtrys']=language('无法判断');
							break;
					}
				}

				$this->assign('title', language('服务器列表'));
				$this->assign('alldev', $alldev);
				$this->assign('gid', $gid);
				$this->assign('page_list', $newpager->showSerialList());
				$this->assign('total', $row_num);
				$this->assign('curr_page', $newpager->intCurrentPageNumber);
				$this->assign('total_page', $newpager->intTotalPageCount);
				$this->assign('items_per_page', $newpager->intItemsPerPage);
				$this->display("usrdev.tpl");
			}
			else{
				$this->display("main.tpl");
			}
		
	}
	
	function cache_countsgroups($gid, $pcount){
		$count = 0;
		$childs = $this->server_set->base_select("SELECT groupid id,ldapid,ct FROM devices_group_cache where ldapid=".$gid." and memberid=".$_SESSION['ADMIN_UID']);
		for($i=0; $i<count($childs); $i++){//var_dump($this->allsgroup[$i]['groupname']);
			$child = $this->cache_countsgroups($childs[$i]['id'], $childs[$i]['ct']);//echo '<br>';
			$count +=$child['ct'];
		}
		if(!($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) || ($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101)&&in_array($gid, $_SESSION['ADMIN_MSERVERGROUP_IDS'])){
			$pcount+=$count;
		}else{
			$pcount=$count;
		}
		$this->server_set->query("UPDATE devices_group_cache SET ct=".$pcount." WHERE groupid=".$gid." and memberid=".$_SESSION['ADMIN_UID']);
		return array('ct'=>$pcount);
	}
	
	function appcache_countsgroups($gid,$appserverip, $pcount){
		$count = 0;
		$childs = $this->server_set->base_select("SELECT groupid id,ldapid,ct,appserverip FROM appdevice_group_cache where ldapid=".$gid." and appserverip='".$appserverip."' and memberid=".$_SESSION['ADMIN_UID']);
		for($i=0; $i<count($childs); $i++){//var_dump($this->allsgroup[$i]['groupname']);
			$child = $this->appcache_countsgroups($childs[$i]['id'], $childs[$i]['appserverip'], $childs[$i]['ct']);//echo '<br>';
			$count +=$child['ct'];
		}
		if(!($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) || ($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101)&&in_array($gid, $_SESSION['ADMIN_MSERVERGROUP_IDS'])){
			$pcount+=$count;
		}else{
			$pcount=$count;
		}
		$this->server_set->query("UPDATE appdevice_group_cache SET ct=".$pcount." WHERE groupid=".$gid." and  appserverip='".$appserverip."' and memberid=".$_SESSION['ADMIN_UID']);
		return array('ct'=>$pcount);
	}

	function do_devices_cache($r=0){
		if(empty($_SESSION['ADMIN_GROUP'])){
			$_SESSION['ADMIN_GROUP']=0;
		}
		if($_SESSION['ADMIN_LEVEL']==1){
			$this->server_set->query("call upgroups(".$_SESSION['ADMIN_UID'].")");
		}elseif($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
			$this->server_set->query("call updpgroups(".$_SESSION['ADMIN_UID'].")");
		}elseif ($_SESSION['ADMIN_LEVEL']==0){
			$this->server_set->query("DELETE FROM devices_cache WHERE memberid='".$_SESSION['ADMIN_UID']."'");
			$this->server_set->query("DELETE FROM devices_group_cache WHERE memberid='".$_SESSION['ADMIN_UID']."'");
			$this->server_set->query("DELETE FROM devices_id_cache WHERE memberid='".$_SESSION['ADMIN_UID']."'");
			$this->server_set->query("DELETE FROM appdevice_appserver_cache WHERE memberid='".$_SESSION['ADMIN_UID']."'");
			$this->server_set->query("DELETE FROM appdevice_cache WHERE memberid='".$_SESSION['ADMIN_UID']."'");
			$this->server_set->query("DELETE FROM appdevice_group_cache WHERE memberid='".$_SESSION['ADMIN_UID']."'");
	
			$servers = $this->server_set->select_all('1=1'.(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) ? ' and device_ip IN(SELECT device_ip FROM servers WHERE groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).") )" : ''), 'device_ip', 'ASC');
			$devpass = $this->devpass_set->select_all('1=1'.(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) ? ' and device_ip IN(SELECT device_ip FROM servers WHERE groupid IN('.implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).") )" : ''), 'device_ip', 'ASC');
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
			
			/*
			$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'].($force_fit&&!empty($devices_arr)  ? " AND devicesid NOT IN(".implode(',',$devices_arr).") " : " AND 1 ");
			$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'].($force_fit&&!empty($devices_arr) ? " AND devicesid NOT IN(".implode(',',$devices_arr).")  " : " AND 1 ");
			$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1').")";
			$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1').")";
			*/
			$sql = "SELECT ".$_SESSION['ADMIN_UID'].",devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'].($force_fit&&!empty($devices_arr)  ? " AND devicesid NOT IN(".implode(',',$devices_arr).") " : " AND 1 ");
			$sql .= " UNION SELECT ".$_SESSION['ADMIN_UID'].",devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'].($force_fit&&!empty($devices_arr) ? " AND devicesid NOT IN(".implode(',',$devices_arr).")  " : " AND 1 ");
			$sql .= " UNION  SELECT ".$_SESSION['ADMIN_UID'].",devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE devicesid>0 and groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1').")";
			$sql .= " union select distinct ".$_SESSION['ADMIN_UID'].",devices.id devicesid from ".$this->luser_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.memberid=".$_SESSION['ADMIN_UID']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1')."";
			$sql .= " UNION SELECT  ".$_SESSION['ADMIN_UID'].",devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE devicesid>0 and groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1').")";
			$sql .= " union select distinct ".$_SESSION['ADMIN_UID'].",devices.id devicesid from ".$this->lgroup_resourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->resgroup_set->get_table_name()." a left join ".$this->resgroup_set->get_table_name()." b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and devices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=devices.username) and a.groupid=".$_SESSION['ADMIN_GROUP']." AND ".($force_fit&&!empty($resources_arr)  ? "a.resourceid NOT IN(".implode(',', $resources_arr).")" : '1=1')."";
	
			$this->server_set->query("INSERT IGNORE INTO devices_id_cache(memberid, devicesid) $sql");
			$alldev = $this->server_set->query("INSERT IGNORE INTO devices_cache(  `memberid`, `devicesid` ,  `device_ip`,  `login_method`,  `hostname`,  `username`,  `old_password`,  `cur_password`,  `last_update_time` ,  `port`,  `device_type` ,  `enable` ,  `limit_time`,  `automodify`,  `luser` ,  `master_user` ,  `log_tab` ,  `passwordtry` ,  `changesure` ,  `lgroup` ,  `autosu` ,  `entrust_password`,  `change_password` ,  `entrust_username` ,  `publickey_auth`,  `radiususer` ,  `encoding`,  `sshprivatekey`,  `sshpublickey`,  `sftp` ,  `first_prompt`, `groupid`, `desc`) SELECT  ".$_SESSION['ADMIN_UID'].", devices.`id` ,devices.`device_ip`,devices.`login_method`,devices.`hostname`,devices.`username`,devices.`old_password`,devices.`cur_password`,devices.`last_update_time` ,devices.`port`,devices.`device_type` ,devices.`enable` ,devices.`limit_time`,devices.`automodify`,devices.`luser` ,devices.`master_user` ,devices.`log_tab` ,devices.`passwordtry` ,devices.`changesure` ,devices.`lgroup` ,devices.`autosu` ,devices.`entrust_password`,devices.`change_password` ,devices.`entrust_username` ,devices.`publickey_auth`,devices.`radiususer` ,devices.`encoding`,devices.`sshprivatekey`,devices.`sshpublickey`,devices.`sftp` ,devices.`first_prompt`,servers.`groupid`, devices.desc FROM `devices` LEFT JOIN (select devicesid from devices_id_cache where memberid=".$_SESSION['ADMIN_UID'].") d ON devices.id=d.devicesid LEFT JOIN servers ON devices.device_ip=servers.device_ip AND devices.hostname=servers.hostname WHERE d.devicesid IS NOT NULL $groupby ORDER BY devices.device_ip ASC");
			$this->server_set->query("INSERT IGNORE INTO devices_group_cache(memberid, groupid, groupname, ct, ldapid) SELECT ".$_SESSION['ADMIN_UID'].",sg.id, sg.groupname,t.sct,sg.ldapid FROM servergroup sg LEFT JOIN (SELECT s.groupid,count(*) sct FROM devices d LEFT JOIN (select devicesid from devices_id_cache  where memberid=".$_SESSION['ADMIN_UID'].") dd ON d.id=dd.devicesid LEFT JOIN servers s ON d.device_ip=s.device_ip WHERE dd.devicesid IS NOT NULL and d.login_method!=26 group by s.groupid ) t ON sg.id=t.groupid Where 1=1 AND t.sct > 0 ORDER BY sg.groupname ASC");
		
			while(1){
				$_rsid = array();
				$rs = $this->server_set->base_select("select id from servergroup where id in(select ldapid from devices_group_cache where ldapid>0 and memberid=".$_SESSION['ADMIN_UID'].") and id not in(select groupid from devices_group_cache where memberid=".$_SESSION['ADMIN_UID'].")");
				
				if(count($rs)==0) break;
				for($i=0; $i<count($rs); $i++){
					$_rsid[]=$rs[$i]['id'];
				}
				$this->server_set->query("INSERT IGNORE INTO devices_group_cache(memberid, groupid, groupname, ct, ldapid) SELECT ".$_SESSION['ADMIN_UID'].",sg.id, sg.groupname,0,sg.ldapid FROM servergroup sg where id IN(".implode(',', $_rsid).")");
			}
			
			$allsgroup=$this->server_set->base_select("SELECT groupid id,ldapid,ct FROM devices_group_cache where ldapid=0 and memberid=".$_SESSION['ADMIN_UID']);
			for($ii=0; $ii<count($allsgroup); $ii++){
				if($allsgroup[$ii]['ldapid']==0){
					$child = $this->cache_countsgroups($allsgroup[$ii]['id'], $allsgroup[$ii]['ct']);
					$allsgroup[$ii]['ct']=$child['ct'];
				}
			}
			unset($allsgroup);
			
			$sql = "INSERT IGNORE INTO appdevice_cache(memberid,appdeviceid, device_ip,groupid,appserverip,name,icon,path,url,appprogramname,devid,hostname,`desc`,username) SELECT ".$_SESSION['ADMIN_UID'].",b.id appdeviceid, b.device_ip,ss.groupid, c.appserverip,c.name,ap.icon,c.path,c.url,appprogramname,devss.id,ss.hostname,b.desc,b.username FROM ".$this->appdevice_set->get_table_name()." b  LEFT JOIN ".$this->apppub_set->get_table_name()." c ON b.apppubid=c.id LEFT JOIN ".$this->appprogram_set->get_table_name()." ap ON c.appprogramname=ap.name ";
			//if($gid){
				$sql .= " LEFT JOIN ".$this->server_set->get_table_name()." ss ON b.device_ip=ss.device_ip ";
			//}
				$sql .= " LEFT JOIN ".$this->devpass_set->get_table_name()." devss ON c.appserverip=devss.device_ip and devss.login_method=26";
					
			$sql .= " WHERE (b.id IN(select appdeviceid FROM ".$this->appmember_set->get_table_name(). " WHERE memberid=".$_SESSION['ADMIN_UID'].") OR b.id IN(select appdevicesid FROM ".$this->appresgroup_set->get_table_name(). " WHERE appgroupname IN(select ag.appgroupname FROM ".$this->luser_appresourcegrp_set->get_table_name()." la LEFT JOIN ".$this->appresgroup_set->get_table_name()." ag ON la.appresourceid=ag.id   WHERE memberid=".$_SESSION['ADMIN_UID'].")) OR b.id IN(select distinct appdevices.id from ".$this->luser_appresourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->appresgroup_set->get_table_name()." a left join ".$this->appresgroup_set->get_table_name()." b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid left join appdevices on appdevices.device_ip=s.device_ip where t.id and appdevices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) and a.memberid=".$_SESSION['ADMIN_UID'].")";
			if($_SESSION['ADMIN_GROUP']){
				$sql .= " OR b.id IN(select appdeviceid FROM ".$this->appgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'].") OR b.id IN(select appdevicesid FROM ".$this->appresgroup_set->get_table_name(). " WHERE appgroupname IN(select ag.appgroupname FROM ".$this->lgroup_appresourcegrp_set->get_table_name()." la LEFT JOIN ".$this->appresgroup_set->get_table_name()." ag ON la.appresourceid=ag.id   WHERE la.groupid=".$_SESSION['ADMIN_GROUP'].")) OR b.id IN(select distinct appdevices.id from ".$this->lgroup_appresourcegrp_set->get_table_name()." a left join (select a.id,b.groupid,b.username from ".$this->appresgroup_set->get_table_name()." a left join ".$this->appresgroup_set->get_table_name()." b on a.appgroupname=b.appgroupname where a.appdevicesid=0 and b.appdevicesid=-1 ) t on a.appresourceid=t.id left join servers s on s.groupid=t.groupid left join appdevices on appdevices.device_ip=s.device_ip where t.id and appdevices.id  and t.groupid and t.groupid=s.groupid AND IF(t.username='0', 1, t.username=appdevices.username) and a.groupid=".$_SESSION['ADMIN_GROUP'].")";
			}
			$sql .= ") ";
			$sql .= " AND c.appserverip IN(select appserverip FROM appdevice_appserver_cache  where memberid=".$_SESSION['ADMIN_UID'].")";
			$sql .= " GROUP BY c.appserverip,c.name";
			$this->server_set->query($sql);
			$this->server_set->query(" UPDATE appdevice_appserver_cache a SET `ct`=(select count(*) FROM appdevice_cache b WHERE a.appserverip=b.appserverip and memberid=".$_SESSION['ADMIN_UID'].") where memberid=".$_SESSION['ADMIN_UID']);
			$this->server_set->query("INSERT IGNORE INTO appdevice_group_cache(memberid, groupid, groupname, ct, ldapid, appserverip) SELECT ".$_SESSION['ADMIN_UID'].",sg.id, sg.groupname,count(*),sg.ldapid,t.appserverip FROM servergroup sg LEFT JOIN appdevice_cache t ON sg.id=t.groupid Where t.groupid is not null  and memberid=".$_SESSION['ADMIN_UID']." group by t.appserverip,sg.id ORDER BY sg.groupname ASC");
			while(1){
				$_rsid = array();
				$rs = $this->server_set->base_select("select id from servergroup where id in(select ldapid from appdevice_group_cache where ldapid>0 and memberid=".$_SESSION['ADMIN_UID'].") and id not in(select groupid from appdevice_group_cache where memberid=".$_SESSION['ADMIN_UID'].")");
					
				if(count($rs)==0) break;
				for($i=0; $i<count($rs); $i++){
					$_rsid[]=$rs[$i]['id'];
				}
				$this->server_set->query("INSERT IGNORE INTO appdevice_group_cache(memberid, groupid, groupname, ct, ldapid, appserverip) SELECT distinct ".$_SESSION['ADMIN_UID'].",sg.id, sg.groupname,0,sg.ldapid,b.appserverip FROM servergroup sg left join appdevice_group_cache b on sg.id=b.ldapid where sg.id IN(".implode(',', $_rsid).")");
			}
			
			$allsgroup=$this->server_set->base_select("SELECT groupid id,ldapid,ct,appserverip FROM appdevice_group_cache where ldapid=0 and memberid=".$_SESSION['ADMIN_UID']);
			for($ii=0; $ii<count($allsgroup); $ii++){
				if($allsgroup[$ii]['ldapid']==0){
					$child = $this->appcache_countsgroups($allsgroup[$ii]['id'], $allsgroup[$ii]['appserverip'], $allsgroup[$ii]['ct']);
					$allsgroup[$ii]['ct']=$child['ct'];
				}
			}
			unset($allsgroup);
		}
		$m = new member();
		$m->set_data('cachechange', 0);
		$m->set_data('uid', $_SESSION['ADMIN_UID']);
		$this->member_set->edit($m);
		if($r==0){
		alert_and_back('已经更新', 'admin.php?controller=admin_index', 0, 1);
		exit;
		}
	}
	
	function get_eth0_ip() {
		global $_CONFIG;
		$eth0 = explode(":", $_SERVER["HTTP_HOST"]);
		return array('eth0'=>$eth0[0]);
		$filename = $_CONFIG['CONFIGFILE']['IFGETH0'];
		
		$return=array();
		if(file_exists($filename))
		{
			$lines = file($filename);
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(strstr(strtoupper($lines[$ii]), "IPADDR"))
				{
					$tmp = explode("=", $lines[$ii]);
					$network['IPADDR']['value'] = $tmp[1];
					$network['IPADDR']['file'] = $filename;
				}
			}
		}
		else
		{
			//alert_and_back('配置文件不存在');
		}
	
		$return['eth0'] = trim($network['IPADDR']['value']);
		return $return;
	}

	function login_user_field(){
		global $_CONFIG;
		$cacn = get_request('cacn', 0, 1);
		if(!empty($cacn)&&$_CONFIG['Certificate']){
			$cacn = explode(';', $cacn);
			for($i=0; $i<count($cacn); $i++){
				if(!empty($cacn[$i])){
					$cacntmp = explode(' ', $cacn[$i]);
					$cacntmp = array_reverse($cacntmp);
					$_cacn[]=implode(' ', $cacntmp);
				}
			}
			$members = $this->member_set->select_all("cacn IN('".implode("','", $_cacn)."')", 'username' , 'asc');
			$this->assign("memberscount", count($members));
			$this->assign("members", $members);
			$this->assign("cacn", $members[0]['cacn']);
		}else{
			$this->assign("memberscount", 0);
		}
		$logintype = $this->setting_set->select_all("sname='logintype'");
		$logintype = unserialize($logintype[0]['svalue']);
		$this->assign("logintype", $logintype);
		$this->assign('authtype', $_COOKIE['authtype']);
		$this->display("login_username.tpl");
	}

	function login() {
		session_destroy();
		global $_CONFIG;
//设置此页面的过期时间(用格林威治时间表示)，只要是已经过去的日期即可。    
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");      
//设置此页面的最后更新日期(用格林威治时间表示)为当天，可以强制浏览器获取最新资料     
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");      
//告诉客户端浏览器不使用缓存，HTTP 1.1 协议     
header("Cache-Control: no-cache, must-revalidate");      
//告诉客户端浏览器不使用缓存，兼容HTTP 1.0 协议     
header("Pragma: no-cache"); 

$_SESSION['CHKSMSLOGIN_STEP']=null;
		$ref = get_request('ref', 0, 1);
		//$_SESSION['CHKSMSLOGIN_STEP'] = -1;
		if($_CONFIG['LOGIN_DEBUG']){
			echo '<pre>';var_dump($_SERVER);echo '</pre>';
		}
		if(strstr($ref,"login") || strstr($ref,"ref")){
			$ref='';
		}
		if($_CONFIG['Certificate']==2){
			$cacn = $_SERVER['SSL_CLIENT_S_DN_CN'];
			if(!empty($cacn)||$_CONFIG['Certificate']){
				$cacn = explode(';', $cacn);
				for($i=0; $i<count($cacn); $i++){
					if(!empty($cacn[$i])){
						$_cacn[]=$cacn[$i];
					}
				}
				if(empty($_cacn)){
					$_cacn = array(0);
				}
				$members = $this->member_set->select_all("cacn IN('".implode("','", $_cacn)."')", 'username' , 'asc');
				$this->assign("memberscount", count($members));
				$this->assign("members", $members);
				$this->assign("cacn", $members[0]['cacn']);
			}
		}		
		$loginconfig = $this->setting_set->select_all(" sname='loginconfig'");
		$loginconfig = unserialize($loginconfig[0]['svalue']);
		$this->assign("ldaps", $loginconfig['ldapconfig']);
		$this->assign("ads", $loginconfig['adconfig']);

		$logintype = $this->setting_set->select_all("sname='logintype'");
		$logintype = unserialize($logintype[0]['svalue']);
		$DpwdTime = $this->setting_set->select_all("sname='DpwdTime'");
		$dpwdtime = ($DpwdTime[0]['svalue']);
		$LoginAuthType = $this->setting_set->select_all("sname='LoginAuthType'");
		$LoginAuthType = ($LoginAuthType[0]['svalue']);
		$this->assign("Certificate", $_CONFIG['Certificate']);
		$this->assign('authtype', $_COOKIE['authtype']);
		$this->assign('ref', urlencode($ref));
		$this->assign('nametype', ($_COOKIE['nametype']=='realname' ? 'realname' : 'username'));
		$this->assign("logintype", $logintype);
		$this->assign("dpwdtime", $dpwdtime);
		$this->assign("loginauthtype", $LoginAuthType);
		$this->assign("datetime", date('Y年m月d日 H时i分'));
		$this->display("login.tpl");
	}

	function get_user_login_fristauth(){
		$username=get_request('username', 0, 1);
		$t=get_request('t', 0, 1);
		$where = 'username="'.$username.'"';
		if($t=='r') $where = 'realname="'.$username.'"';
		$m = $this->member_set->select_all($where);
		echo $m[0]['firstauth'];
	}

	function chklogin() {
		global $_CONFIG;
		if(!empty($_GET['username'])&&!empty($_GET['password'])&&!empty($_GET['frommc'])){
			$_POST['username']=$_GET['username'];
			$_POST['password']=$_GET['password'];
			$_POST['authtype']=$_GET['authtype'];
		}
		$username = get_request("username", 1, 1);
		$language = get_request("language", 1, 1);
		$password = htmlspecialchars_decode(get_request("password", 1, 1));
		$dpassword = get_request("dpassword", 1, 1);
		$nametype = get_request("nametype", 1, 1);
		$authtype = get_request("authtype", 1, 1);
		if($dpassword=='令牌用户输入'){
			$dpassword='';
		}
		if(is_array($username)){
			$username=$username[0];
		}
		if(is_array($password)){
			$password=$password[0];
		}
		if(is_array($nametype)){
			$nametype=$nametype[0];
		}
		if(is_string($nametype) || is_numeric($nametype))
		setcookie("nametype", $nametype, time()+3600*24*365*100, '/', '', 1);
		if(is_string($authtype) || is_numeric($authtype))
		setcookie("authtype", $authtype, time()+3600*24*365*100, '/', '', 1);
		if(is_string($username) || is_numeric($username))
		setcookie("username", $username, time()+3600*24*365*100, '/', '', 1);
		if(strpos($authtype, '_')!==false){
			$tmpauthtype = explode('_', $authtype);
			$authtype = $tmpauthtype[0];
			$authtype_server = $tmpauthtype[1];
		}
		$ref = get_request('ref', 0, 1);
		if($_SESSION['CHKSMSLOGIN_STEP']>0){
			$result[0] = $this->member_set->select_by_id(get_request('uid'));
			$username = $result[0]['username'];
			$password = $this->member_set->udf_decrypt($result[0]['password']);
			$authtype = 'localauth';
		}

		$where = "`username` = '$username' ";
		if($nametype=='realname'){
			$where = "`realname` = '$username' ";
		}else{
			if(!preg_match('/^[a-zA-Z._\-0-9@]+$/', $username)){
				alert_and_back('用户名输入不正确','admin.php?controller=admin_index&action=login');
				exit();
			}
		}
		
		
		$result = $this->member_set->select_all($where);
		if(!($result[0]['username']==$username||$result[0]['realname']==$username)){
			alert_and_back($_CONFIG['WEBLOGINWRONGTIP']);
			exit;
		}
		if(empty($username)&&$_SESSION['CHKSMSLOGIN_STEP']>0){
			$result[0] = $this->member_set->select_by_id(get_request('uid'));
		}
		if($language){
			define("LANGUAGE", $language);
		}elseif($_COOKIE['AUDIT_LANGUAGE']){
			define("LANGUAGE", $_COOKIE['AUDIT_LANGUAGE']);
		}else{
			define("LANGUAGE", 'cn');
		}
		$_SESSION['AUDIT_LANGUAGE'] = LANGUAGE;
		if(empty($authtype)){			
			if(strpos($result[0]['firstauth'],'_')!==false){
				$tmpauthtype = explode('_', $result[0]['firstauth']);
				$authtype = $tmpauthtype[0];
				$authtype_server = $tmpauthtype[1];
			}else{
				$authtype = $result[0]['firstauth'];
			}
			//var_dump($result);
		}
		
		if(empty($result)){
			alert_and_back($_CONFIG['WEBLOGINWRONGTIP']);
			exit;
		}elseif($result[0]['sourceip']&&!$this->check_ip($result[0])){
			$loginacct = new loginacct();	
			$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
			$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
			$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
			$loginacct->set_data('portocol', 'web');
			$loginacct->set_data('audituser', $result[0]['username']);	
			$loginacct->set_data('systemuser', ''); 
			$loginacct->set_data('time', date('y-m-d H:i:s')); 
			$loginacct->set_data('authenticationstatus', 0);
			$loginacct->set_data('failreason', "IP不在允许范围");
			$this->loginacct_set->add($loginacct);
			alert_and_back('IP不在允许范围','admin.php?controller=admin_index&action=login');
			exit;
		}elseif($result[0]['weektime']&&!$this->check_weektime($result[0])){
			$loginacct = new loginacct();	
			$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
			$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
			$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
			$loginacct->set_data('portocol', 'web');
			$loginacct->set_data('audituser', $result[0]['username']);	
			$loginacct->set_data('systemuser', ''); 
			$loginacct->set_data('time', date('y-m-d H:i:s')); 
			$loginacct->set_data('authenticationstatus', 0);
			$loginacct->set_data('failreason', "该时间段不允许登录");
			$this->loginacct_set->add($loginacct);
			alert_and_back('该时间段不允许登录','admin.php?controller=admin_index&action=login');
			exit;
		}/*elseif($result[0]['level']==11){
			$loginacct = new loginacct();	
			$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
			$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
			$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
			$loginacct->set_data('portocol', 'web');
			$loginacct->set_data('audituser', $result[0]['username']);	
			$loginacct->set_data('systemuser', ''); 
			$loginacct->set_data('time', date('y-m-d H:i:s')); 
			$loginacct->set_data('authenticationstatus', 0);
			$loginacct->set_data('failreason', "RADIUS用户不允许登录");
			$this->loginacct_set->add($loginacct);
			alert_and_back('该用户不允许登录');
			exit;
		}*/elseif(!$result[0]['enable']){
			$loginacct = new loginacct();	
			$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
			$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
			$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
			$loginacct->set_data('portocol', 'web');
			$loginacct->set_data('audituser', $result[0]['username']);	
			$loginacct->set_data('systemuser', ''); 
			$loginacct->set_data('time', date('y-m-d H:i:s')); 
			$loginacct->set_data('authenticationstatus', 0);
			$loginacct->set_data('failreason', "该用户已经锁定");
			$this->loginacct_set->add($loginacct);
			alert_and_back('该用户已经锁定','admin.php?controller=admin_index&action=login');
			exit;
		}elseif($result[0]['level']!=11&&empty($result[0][$authtype])&&!($authtype=='localauth'&&$_SESSION['LOGIN_RADIUS_TO_LOCAL'])){
			if($authtype=='localauth'){
				$authname= '本地认证';
			}elseif($authtype=='radiusauth'){
				$authname= 'RADIUS认证';
			}elseif($authtype=='ldapauth'){
				$authname= 'LDAP认证';
			}elseif($authtype=='adauth'){
				$authname= 'AD认证';
			}elseif($authtype=='fingersecauth'){
				$authname= '指纹认证';
			}elseif($authtype=='localfingersecauth'){
				$authname= '本地+指纹认证';
			}
			if($result[0]['localauth']){
				$authtypes .= '本地认证';
			}
			if($result[0]['radiusauth']){
				$authtypes .= 'RADIUS认证';
			}
			if($result[0]['ldapauth']){
				$authtypes .= 'LDAP认证';
			}
			if($result[0]['adauth']){
				$authtypes .= 'AD认证';
			}
			if($result[0]['fingersecauth']){
				$authtypes .= '指纹认证';
			}
			if($result[0]['localfingersecauth']){
				$authtypes .= '本地+指纹认证';
			}
			$loginacct = new loginacct();	
			$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
			$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
			$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
			$loginacct->set_data('portocol', 'web');
			$loginacct->set_data('audituser', $result[0]['username']);	
			$loginacct->set_data('systemuser', ''); 
			$loginacct->set_data('time', date('y-m-d H:i:s')); 
			$loginacct->set_data('authenticationstatus', 0);
			$loginacct->set_data('failreason', "该用户不支持:$authname");
			$this->loginacct_set->add($loginacct);
			alert_and_back("该用户不支持:$authname".'\n'."支持的登录方式:".$authtypes,'admin.php?controller=admin_index&action=login');
			exit;
		}
		if($result[0]['cacn']&&intval($_POST['memberscount'])==0&&$_CONFIG['Certificate']){
			//echo "<script>alert('".$result[0]['username'].'已经绑定的证书不匹配'."')</script>";
			$loginacct = new loginacct();	
			$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
			$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
			$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
			$loginacct->set_data('portocol', 'web');
			$loginacct->set_data('audituser', $result[0]['username']);	
			$loginacct->set_data('systemuser', ''); 
			$loginacct->set_data('time', date('y-m-d H:i:s')); 
			$loginacct->set_data('authenticationstatus', 0);
			$loginacct->set_data('failreason', '已经绑定的证书不匹配');
			$this->loginacct_set->add($loginacct);
			alert_and_back($result[0]['username'].'已经绑定的证书不匹配','admin.php?controller=admin_index&action=login');
			exit;
		}
		$_SESSION['authtype'] = $authtype;
		$username = $result[0]['username'];
		$user_start_time = date_parse($result[0]['start_time']);
		$user_end_time = date_parse($result[0]['end_time']);
		if(time() < mktime($user_start_time['hour'], $user_start_time['minute'], $user_start_time['second'], $user_start_time['month'], $user_start_time['day'], $user_start_time['year']) || time() > mktime($user_end_time['hour'], $user_end_time['minute'], $user_end_time['second'], $user_end_time['month'], $user_end_time['day'], $user_end_time['year']) ){
			$loginacct = new loginacct();	
			$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
			$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
			$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
			$loginacct->set_data('portocol', 'web');
			$loginacct->set_data('audituser', $result[0]['username']);	
			$loginacct->set_data('systemuser', ''); 
			$loginacct->set_data('time', date('y-m-d H:i:s')); 
			$loginacct->set_data('authenticationstatus', 0);
			$loginacct->set_data('failreason', '帐号不在有效期范围内,帐号的有效期为:\n开始:'.$result[0]['start_time'].'\n结束:'.$result[0]['end_time']);
			$this->loginacct_set->add($loginacct);
			alert_and_back('帐号不在有效期范围内,帐号的有效期为:\n开始:'.$result[0]['start_time'].'\n结束:'.$result[0]['end_time'],'admin.php?controller=admin_index&action=login');
			exit;
		}
		//$config = $this->setting_set->select_all(" sname='login_times' ");
		$config = $this->setting_set->select_all(" sname='password_policy'");
		$pwdconfig = unserialize($config[0]['svalue']);
		$login_times = $pwdconfig['login_times'];
	
		$lastdate = date_parse($result[0][lastdate]);
		$newmember = new member();
		$newmember->set_data("uid", $result[0]['uid']);

		$max_online = $pwdconfig['onlinecountmax'];
		$exist_account = get_online_users($username, $pwdconfig['logintimeout']*60);
		for($i=0; $i<count($exist_account); $i++){
			if($exist_account[$i]['ip']==$_SERVER['REMOTE_ADDR']&&session_id()!=$exist_account[$i]['ssid']){
				//alert_and_back('您已经在本机登录,请退出后再登录');
				//exit;
			}
		}
		if(count($exist_account)+1 > $max_online){
			$found_online = 1;
			for($i=0; $i<count($exist_account); $i++){
				if($exist_account[$i]['ssid']==$_COOKIE['audit_sec_sessionid']){
					$found_online=1;
				}
			}
			if(!empty($found_online)){
				$loginacct = new loginacct();	
				$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
				$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
				$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
				$loginacct->set_data('portocol', 'web');
				$loginacct->set_data('audituser', $result[0]['username']);	
				$loginacct->set_data('systemuser', ''); 
				$loginacct->set_data('time', date('y-m-d H:i:s')); 
				$loginacct->set_data('authenticationstatus', 0);
				$loginacct->set_data('failreason', '该用户的在线数已经达到了最大值');
				$this->loginacct_set->add($loginacct);
				alert_and_back('该用户的在线数已经达到了最大值','admin.php?controller=admin_index&action=login');		
				exit;
			}
		}
		//if($result[0]['loginlock'])
		{
			if($result[0]['logintimes'] >= $login_times){
				$lastdate_add_1_day = mktime($lastdate['hour'], $lastdate['minute']+$pwdconfig['login_times_last'], $lastdate['second'], $lastdate['month'], $lastdate['day'], $lastdate['year']);
				$maxlogintimes = 1;
				if($lastdate_add_1_day < time()){
					$newmember->set_data("loginlock", 0);
					$newmember->set_data("logintimes", 1);
					$this->member_set->edit($newmember);
					$result[0]['logintimes']=1;
					$result[0]['loginlock']=0;
				}else{					
					$newmember->set_data("loginlock", 1);
					$this->member_set->edit($newmember);
					$loginacct = new loginacct();	
					$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
					$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
					$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
					$loginacct->set_data('portocol', 'web');
					$loginacct->set_data('audituser', $result[0]['username']);	
					$loginacct->set_data('systemuser', ''); 
					$loginacct->set_data('time', date('y-m-d H:i:s')); 
					$loginacct->set_data('authenticationstatus', 0);
					$loginacct->set_data('failreason', '登录次数达到了最大次数');
					$this->loginacct_set->add($loginacct);
					alert_and_back(language("您登录次数达到了最大次数").":".$login_times.','.language('请'.$pwdconfig['login_times_last'].'分钟后再试'),'admin.php?controller=admin_index&action=login');
					exit;
				}
			}else{
				if($result[0]['logintimes']==0){
					$newmember->set_data("lastdate", date('Y-m-d H:i:s'));
				}
				$newmember->set_data("logintimes", $result[0]['logintimes'] + 1);
				$result[0]['logintimes']+=1;
			}
		}
		
		$default_control = '';
		switch($result[0]['default_control']){
			case 0:
				$default_control = (strpos($_SERVER['HTTP_USER_AGENT'],'MSIE')||(!strpos($_SERVER['HTTP_USER_AGENT'],'Firefox')&&!strpos($_SERVER['HTTP_USER_AGENT'],'Chrome')&&!strpos($_SERVER['HTTP_USER_AGENT'],'Safari')&&!strpos($_SERVER['HTTP_USER_AGENT'],'Opera')&&!strpos($_SERVER['HTTP_USER_AGENT'],'Opera'))) ? 'activeX' : 'applet';
				break;
			case 1:
				$default_control = 'applet';
				break;
			case 2:
				$default_control = 'activeX';
				break;
		}
		$_SESSION['ADMIN_DEFAULT_CONTROL'] = $default_control;

		if($result[0]['mservergroup'])
		$serverResult = $this->server_set->select_all(" groupid='".$result[0]['mservergroup']."'");
		if($serverResult){
			foreach ($serverResult AS $key => $value){
				$serverIds[] = $value['id'];
			}
		}
		if($serverIds)
		$serverString=implode(",", $serverIds);
		//$radiusconfig['radiusauth']='no';
		
		$can_login = true;
		if($result[0]['usbkey']&&intval($result[0]['usbkeystatus'])!=11&&$authtype!='radiusauth'){
			$_tmp = $this->member_set->base_select("select rad_getpasswd('".$result[0]['username']."','".$this->member_set->udf_decrypt($result[0]['password']).$dpassword."','','127.0.0.1') AS p");
			//var_dump($_tmp);var_dump($this->member_set->udf_decrypt($result[0]['password']).$dpassword);var_dump(crypt($password.$dpassword,"\$1\$qY9g/6K4"));exit;
			if($_tmp[0]['p']=='xxxxxx'){
				$can_login = false;
			}else{
				$can_login = (crypt($this->member_set->udf_decrypt($result[0]['password']).$dpassword,"\$1\$qY9g/6K4")==$_tmp[0]['p']);
			}
		}
		if(!$can_login){
			$loginacct = new loginacct();	
			$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
			$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
			$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
			$loginacct->set_data('portocol', 'web');
			$loginacct->set_data('audituser', $result[0]['username']);	
			$loginacct->set_data('systemuser', ''); 
			$loginacct->set_data('time', date('y-m-d H:i:s')); 
			$loginacct->set_data('authenticationstatus', 0);
			$loginacct->set_data('failreason', '动态口令输入错误');
			$this->loginacct_set->add($loginacct);
			alert_and_back('动态口令输入错误','admin.php?controller=admin_index&action=login');		
			exit;
		}
		if($authtype=='localauth'){
			if($_CONFIG['crypt']==1){
				$password = encrypt($password);
			}
			/*
			if($result[0]['usbkey']&&intval($result[0]['usbkeystatus'])!=11){
				$_tmp = $this->member_set->base_select("select rad_getpasswd('".$result[0]['username']."','".$password.$dpassword."','','127.0.0.1') AS p");
				//var_dump($_tmp);var_dump(crypt($password.$dpassword,"\$1\$qY9g/6K4"));exit;
				if($_tmp[0]['p']=='xxxxxx'){
					$can_login = false;
				}else{
					$can_login = (crypt($password.$dpassword,"\$1\$qY9g/6K4")==$_tmp[0]['p']);
				}
			}else{
				$can_login = $this->member_set->udf_decrypt($result[0][password])==$password;
			}*/
			
			$can_login = $this->member_set->udf_decrypt($result[0][password])==$password;
			if(intval($_SESSION['CHKSMSLOGIN_STEP'])<1&&!$can_login) 
			{
				$loginacct = new loginacct();	
				$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
				$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
				$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
				$loginacct->set_data('portocol', 'web');
				$loginacct->set_data('audituser', $result[0]['username']);
				$loginacct->set_data('systemuser', ''); 
				$loginacct->set_data('time', date('y-m-d H:i:s')); 
				$loginacct->set_data('authenticationstatus', 0);
				$loginacct->set_data('failreason', $_CONFIG['WEBLOGINWRONGTIP']);
				$this->loginacct_set->add($loginacct);
				if(/*$result[0]['level']!=1&&*/(1 || $result[0]['loginlock']))
				{

					$this->member_set->edit($newmember);
					if($login_times-$result[0]['logintimes'] > 0){
						alert_and_back(language($_CONFIG['WEBLOGINWRONGTIP'].',请重试').language('还有').($login_times-$result[0]['logintimes']).'次','admin.php?controller=admin_index&action=login');
					}else{						
						alert_and_back($_CONFIG['WEBLOGINWRONGTIP'].',已经超出系统限制,请'.$pwdconfig['login_times_last'].'分钟后重试','admin.php?controller=admin_index&action=login');
					}
					exit;
				}else{
					alert_and_back($_CONFIG['WEBLOGINWRONGTIP'].'','admin.php?controller=admin_index&action=login');
					exit;
				}				
			}
			else {
				
				/*
				之前的短信认证，增加组合认证接口后放到组合验证里
				if($result[0][auth]==2){
					if(intval($_SESSION['CHKSMSLOGIN_STEP'])<2){
						$_SESSION['CHKSMSLOGIN_STEP']=2;
						$this->assign("userinfo", $result[0]);
						$this->display("sendsms.tpl");
						exit;
					}else{//var_dump($result[0]['smspassword']);var_dump(get_request('smspassword',1,1));
						if($result[0]['smspassword']!=get_request('smspassword',1,1)){							
							$_SESSION['CHKSMSLOGIN_STEP']=1;
							alert_and_back('输入错误','admin.php?controller=admin_index&action=chklogin&uid='.$result[0]['uid']);
							exit;
						}
					}
					
				}*/
				$loginacct = new loginacct();	
				$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
				$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
				$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
				$loginacct->set_data('portocol', 'web');
				$loginacct->set_data('audituser', $result[0]['username']);
				$loginacct->set_data('systemuser', ''); 
				$loginacct->set_data('time', date('y-m-d H:i:s')); 
				$loginacct->set_data('authenticationstatus', 1);
				$this->loginacct_set->add($loginacct);
				$_SESSION['ADMIN_LOGINED'] = true;
				$_SESSION['ADMIN_USERNAME'] =  $username;
				$_SESSION['ADMIN_LEVEL'] = $result[0]['level'];
				$_SESSION['ADMIN_UID'] = $result[0]['uid'];
				$_SESSION['ADMIN_GROUP'] = (int)$result[0]['groupid'];
				$_SESSION['ADMIN_FLIST'] = unserialize($result[0]['flist']);
				$_SESSION['ADMIN_SEARCHCACHE'] = $result[0]['searchcache'];
				
				$_SESSION['DEVS'] = $serverString;
				$_SESSION['ADMIN_LASTDATE'] = $result[0]['lastdate'];
				$_SESSION['ADMIN_IP'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['ADMIN_MUSERGROUP'] = $result[0]['musergroup'];
				$_SESSION['ADMIN_MUSERGROUPTYPE'] = $result[0]['musergrouptype'];
				$_SESSION['ADMIN_MSERVERGROUP'] = $result[0]['mservergroup'];
				$_SESSION['ADMIN_LOGINDATE'] = date('Y-m-d H:i:s');
				$_SESSION['LOGIN_RADIUS_TO_LOCAL'] = 0;
				if($result[0]['login_tip']){
					$_SESSION['ADMIN_LOGIN_TIP'] = true;
				}
				if(empty($_SESSION['DEVS']))
					$_SESSION['DEVS']=0;
				setcookie("LANGUAGE", $language,time()+3600*24*365*100, '/', '', 1);
				setcookie("audit_sec_sessionid", session_id(), time()+3600*24*365*100, '/', '', 1);
				$newmember->set_data("lastdate", date('Y-m-d H:i:s'));
				$newmember->set_data("ip", $_SERVER['REMOTE_ADDR']);
				$newmember->set_data("logintimes", 0);
				$newmember->set_data('devs',",".$serverString.",");
				$cologinauth = (($result[0]['usbkey']&&$result[0]['usbkeystatus']==11) || $result[0]['authtype']&&($result[0]['radiusauth']||$result[0]['ldapauth']||$result[0]['adauth']||intval($result[0]['auth'])==2));
					if(!($cologinauth&&empty($_SESSION['USER_MULTI_LOGIN_VALIDATED']))){
					$newmember->set_data("webportallogin", (empty($result[0]['webportaltime']) ? mktime(23,59,59,date('n'),date('j'),date('Y')) : time()+$result[0]['webportaltime']*60));
					$newmember->set_data("websourceip", $_SERVER['REMOTE_ADDR']);
				}
				$this->member_set->edit($newmember);

				$filename = $_CONFIG['HACF'];
				$lines = @file($filename);
				if(!empty($lines))
				{
					
					for($ii=0; $ii<count($lines); $ii++)
					{
						if(strstr(strtolower(trim($lines[$ii])), "state "))
						{
							$tmp = preg_split("/[\s]+/", $lines[$ii]);//var_dump($tmp);
							if(strtolower(trim($tmp[2]))=="backup"){
								echo "<script>alert('登录的是从机')</script>";
								break;
							}
						}
					}
				}


				$_SESSION['startonlinetime']=time();//var_dump((time()-$result[0]['lastdateChpwd'])/(24*3600));var_dump($pwdconfig['pwdexpired']-$pwdconfig['pwdahead']);exit;
				if((((time()-$result[0]['lastdateChpwd'])/(24*3600)) > ($pwdconfig['pwdexpired']-$pwdconfig['pwdahead']) )){
					$membercpwd = urlencode("controller=admin_member&action=edit_self&msg=changepwd");
					go_url('admin.php?controller=admin_index&ref='.$membercpwd);
					exit;
				}
				if($result[0]['usbkey']&&$result[0]['usbkeystatus']==11&&$action!='menu'&&!($controller=='c_admin_index'&&($action=='index'))&&$action!='logout'&&$_SESSION['authtype']=='localauth'){
					$membercpwd = urlencode("controller=admin_index&action=qrcode");
					go_url('admin.php?controller=admin_index&ref='.$membercpwd);
					exit;
				}
				go_url('admin.php?controller=admin_index&ref='.urlencode($ref));
				exit;
			}	
		}else if($authtype=='radiusauth'){
			$filename = $_CONFIG['CONFIGFILE']['SSH'];
			$lines = @file($filename);
			if(!empty($lines)){
				for($ii=0; $ii<count($lines); $ii++)
				{
									
					if(strstr($lines[$ii], "MasterRadiusServerAddress"))
					{
						$tmp = preg_split("/[\s]+/", $lines[$ii]);
						$radiusconfig['address'] = trim($tmp[1]);
					}
					if(strstr($lines[$ii], "MasterRadiusServerPort"))
					{
						$tmp = preg_split("/[\s]+/", $lines[$ii]);
						$radiusconfig['port'] = trim($tmp[1]);
					}
					if(strstr($lines[$ii], "MasterRadiusServerSecret"))
					{
						$tmp = preg_split("/[\s]+/", $lines[$ii]);
						$radiusconfig['secret'] = trim($tmp[1]);
					}
					if(strstr($lines[$ii], "SlaveRadiusServerAddress"))
					{
						$tmp = preg_split("/[\s]+/", $lines[$ii]);
						$radiusconfig['slaveaddress'] = trim($tmp[1]);
					}
					if(strstr($lines[$ii], "SlaveRadiusServerPort"))
					{
						$tmp = preg_split("/[\s]+/", $lines[$ii]);
						$radiusconfig['slaveport'] = trim($tmp[1]);
					}
					if(strstr($lines[$ii], "SlaveRadiusServerSecret"))
					{
						$tmp = preg_split("/[\s]+/", $lines[$ii]);
						$radiusconfig['slavesecret'] = trim($tmp[1]);
					}
					if(strstr($lines[$ii], "RadiusAuth"))
					{
						$tmp = preg_split("/[\s]+/", $lines[$ii]);
						$radiusconfig['radiusauth'] = trim($tmp[1]);
					}
				}
			}else{
				alert_and_back('打开radius配置文件失败');
				exit;
			}
			if($_CONFIG['RDPAUTH_TO_LOCALAUTH']){
				echo "<script>alert('".$_CONFIG['RDPAUTH_TO_LOCALAUTH_TIPS']."');</script>";
				$auth_rs = ($this->member_set->udf_decrypt($result[0][password])==$password);
			}else{
				$auth_rs = $this->radius_chk($username, $password.$dpassword, $radiusconfig['address'], $radiusconfig['port'],$radiusconfig['secret']);
				//$auth_rs=1;

				if($auth_rs<-1){
					$auth_rs = $this->radius_chk($username, $password.$dpassword, $radiusconfig['slaveaddress'], $radiusconfig['slaveport'],$radiusconfig['slavesecret']);
				}
			}

			switch($auth_rs){
				case 1:
					$_SESSION['ADMIN_LOGINED'] = true;
					$_SESSION['ADMIN_USERNAME'] =  $username;
					$_SESSION['ADMIN_LEVEL'] = $result[0]['level'];					
					$_SESSION['ADMIN_UID'] = $result[0]['uid'];
					$_SESSION['ADMIN_GROUP'] = (int)$result[0]['groupid'];
					$_SESSION['ADMIN_FLIST'] = unserialize($result[0]['flist']);
					$_SESSION['ADMIN_SEARCHCACHE'] = $result[0]['searchcache'];
					$_SESSION['ADMIN_LASTDATE'] = $result[0]['lastdate'];
					$_SESSION['ADMIN_IP'] = $_SERVER['REMOTE_ADDR'];
					$_SESSION['ADMIN_MUSERGROUP'] = $result[0]['musergroup'];
					$_SESSION['ADMIN_MUSERGROUPTYPE'] = $result[0]['musergrouptype'];
					$_SESSION['ADMIN_MSERVERGROUP'] = $result[0]['mservergroup'];
					$_SESSION['ADMIN_LOGINDATE'] = date('Y-m-d H:i:s');
					if($result[0]['login_tip']){
						$_SESSION['ADMIN_LOGIN_TIP'] = true;
					}
					$_SESSION['DEVS'] = $serverString;
					if(empty($_SESSION['DEVS']))
						$_SESSION['DEVS']=0;
					setcookie("LANGUAGE", $language,time()+3600*24*365*100, '/', '', 1);
					setcookie("audit_sec_sessionid", session_id(), time()+3600*24*365*100, '/', '', 1);
					$newmember->set_data("lastdate", date('Y-m-d H:i:s'));
					$newmember->set_data("ip", $_SERVER['REMOTE_ADDR']);
					$newmember->set_data("logintimes", 0); 
					$newmember->set_data('devs',",".$serverString.",");
					$cologinauth = (($result[0]['usbkey']&&$result[0]['usbkeystatus']==11) || $result[0]['authtype']&&($result[0]['radiusauth']||$result[0]['ldapauth']||$result[0]['adauth']||intval($result[0]['auth'])==2));
					if(!($cologinauth&&empty($_SESSION['USER_MULTI_LOGIN_VALIDATED']))){
						$newmember->set_data("webportallogin", (empty($result[0]['webportaltime']) ? mktime(23,59,59,date('n'),date('j'),date('Y')) : time()+$result[0]['webportaltime']*60));
						$newmember->set_data("websourceip", $_SERVER['REMOTE_ADDR']);
					}

					$this->member_set->edit($newmember);

					
					$loginacct = new loginacct();	
					$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
					$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);		
					$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
					$loginacct->set_data('portocol', 'web');
					$loginacct->set_data('audituser', $result[0]['username']);
					$loginacct->set_data('systemuser', ''); 
					$loginacct->set_data('time', date('y-m-d H:i:s')); 
					$loginacct->set_data('authenticationstatus', 1);
					$this->loginacct_set->add($loginacct);
					
					$filename = $_CONFIG['HACF'];
					$lines = @file($filename);
					if(!empty($lines))
					{
						
						for($ii=0; $ii<count($lines); $ii++)
						{
							if(strstr(strtolower(trim($lines[$ii])), "state "))
							{
								$tmp = preg_split("/[\s]+/", $lines[$ii]);//var_dump($tmp);
								if(strtolower(trim($tmp[2]))=="backup"){
									echo "<script>alert('登录的是从机')</script>";
									break;
								}
							}
						}
					}

					$_SESSION['startonlinetime']=time();//var_dump((time()-$result[0]['lastdateChpwd'])/(24*3600));var_dump($pwdconfig['pwdexpired']-$pwdconfig['pwdahead']);exit;
					if((((time()-$result[0]['lastdateChpwd'])/(24*3600)) > ($pwdconfig['pwdexpired']-$pwdconfig['pwdahead']) )){
						$membercpwd = urlencode("controller=admin_member&action=edit_self&msg=changepwd");
						//go_url('admin.php?controller=admin_index&ref='.$membercpwd);
						//exit;
					}
					go_url('admin.php?controller=admin_index&ref='.urlencode($ref));
					exit;
					break;
				case -1:					
					if(/*$result[0]['level']!=1&&*/(1 || $result[0]['loginlock'])){
						$this->member_set->edit($newmember);
						if($login_times-$result[0]['logintimes'] > 0){
							$loginacct = new loginacct();	
							$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
							$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
							$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
							$loginacct->set_data('portocol', 'web');
							$loginacct->set_data('audituser', $result[0]['username']);	
							$loginacct->set_data('systemuser', ''); 
							$loginacct->set_data('time', date('y-m-d H:i:s')); 
							$loginacct->set_data('authenticationstatus', 0);
							$loginacct->set_data('failreason', $_CONFIG['WEBLOGINWRONGTIP']);
							$this->loginacct_set->add($loginacct);
							alert_and_back(language($_CONFIG['WEBLOGINWRONGTIP'].',请重试').language('还有').($login_times-$result[0]['logintimes']).'次');
							exit;
						}
						else {
							$loginacct = new loginacct();	
							$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
							$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
							$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
							$loginacct->set_data('portocol', 'web');
							$loginacct->set_data('audituser', $result[0]['username']);
							$loginacct->set_data('systemuser', ''); 
							$loginacct->set_data('time', date('y-m-d H:i:s')); 
							$loginacct->set_data('authenticationstatus', 0);
							$loginacct->set_data('failreason', $_CONFIG['WEBLOGINWRONGTIP'].',已经超出系统限制');
							$this->loginacct_set->add($loginacct);
							alert_and_back($_CONFIG['WEBLOGINWRONGTIP'].',已经超出系统限制,请'.$pwdconfig['login_times_last'].'分钟后重试');
							exit;
						}
					}else{
						$loginacct = new loginacct();	
						$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
						$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
						$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
						$loginacct->set_data('portocol', 'web');
						$loginacct->set_data('audituser', $result[0]['username']);
						$loginacct->set_data('systemuser', ''); 
						$loginacct->set_data('time', date('y-m-d H:i:s')); 
						$loginacct->set_data('authenticationstatus', 0);
						$this->loginacct_set->add($loginacct);
						alert_and_back($_CONFIG['WEBLOGINWRONGTIP']);
						exit;
					}
					break;
				default:
				{
					if(/*$result[0]['level']==0 || $_CONFIG['OTHER_MEMBER_RADIUS']==1*/1){
						$_SESSION['LOGIN_RADIUS_TO_LOCAL']=1;
							$loginacct = new loginacct();	
							$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
							$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
							$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
							$loginacct->set_data('portocol', 'web');
							$loginacct->set_data('audituser', $result[0]['username']);
							$loginacct->set_data('systemuser', ''); 
							$loginacct->set_data('time', date('y-m-d H:i:s')); 
							$loginacct->set_data('authenticationstatus', 0);
							$loginacct->set_data('failreason','系统错误,请稍候重试,或用本地方式登录,或联系管理员');
							$this->loginacct_set->add($loginacct);
						alert_and_back('系统错误,请稍候重试,或用本地方式登录,或联系管理员','admin.php?controller=admin_index&action=login');
						exit;
					}
				}
			}
			
		}elseif($authtype=='ldapauth'){
			$ldapconfig=$this->setting_set->select_all("sname='loginconfig'");
			$ldapconfig = unserialize($ldapconfig[0]['svalue']);
			$_ldapconfig = $ldapconfig['ldapconfig'];
			for($ii=0; $ii<count($_ldapconfig); $ii++){
				if($_ldapconfig[$ii]['address']==$authtype_server){
					$ldapconfig = $_ldapconfig[$ii];
					break;
				}
			}
			$auth_rs = $this->ldap_chk($_CONFIG['LDAPCLIENT']?$username:$result[0]['adou'], $password, $ldapconfig['address'], $ldapconfig['port'],$ldapconfig['domain']);
			//$auth_rs=1;

			switch($auth_rs){
				case 1:
					$_SESSION['ADMIN_LOGINED'] = true;
					$_SESSION['ADMIN_USERNAME'] =  $username;
					$_SESSION['ADMIN_LEVEL'] = $result[0]['level'];					
					$_SESSION['ADMIN_UID'] = $result[0]['uid'];
					$_SESSION['ADMIN_GROUP'] = (int)$result[0]['groupid'];
					$_SESSION['ADMIN_FLIST'] = unserialize($result[0]['flist']);
					$_SESSION['ADMIN_SEARCHCACHE'] = $result[0]['searchcache'];
					$_SESSION['ADMIN_LASTDATE'] = $result[0]['lastdate'];
					$_SESSION['ADMIN_IP'] = $_SERVER['REMOTE_ADDR'];
					$_SESSION['ADMIN_MUSERGROUP'] = $result[0]['musergroup'];
					$_SESSION['ADMIN_MUSERGROUPTYPE'] = $result[0]['musergrouptype'];
					$_SESSION['ADMIN_MSERVERGROUP'] = $result[0]['mservergroup'];
					$_SESSION['ADMIN_LOGINDATE'] = date('Y-m-d H:i:s');
					if($result[0]['login_tip']){
						$_SESSION['ADMIN_LOGIN_TIP'] = true;
					}
					$_SESSION['DEVS'] = $serverString;
					if(empty($_SESSION['DEVS']))
						$_SESSION['DEVS']=0;
					setcookie("LANGUAGE", $language,time()+3600*24*365*100, '/', '', 1);
					setcookie("audit_sec_sessionid", session_id(), time()+3600*24*365*100, '/', '', 1);
					$newmember->set_data("lastdate", date('Y-m-d H:i:s'));
					$newmember->set_data("ip", $_SERVER['REMOTE_ADDR']);
					$newmember->set_data("logintimes", 0); 
					$newmember->set_data('devs',",".$serverString.",");
					$cologinauth = (($result[0]['usbkey']&&$result[0]['usbkeystatus']==11) || $result[0]['authtype']&&($result[0]['radiusauth']||$result[0]['ldapauth']||$result[0]['adauth']||intval($result[0]['auth'])==2));
					if(!($cologinauth&&empty($_SESSION['USER_MULTI_LOGIN_VALIDATED']))){
						$newmember->set_data("webportallogin", (empty($result[0]['webportaltime']) ? mktime(23,59,59,date('n'),date('j'),date('Y')) : time()+$result[0]['webportaltime']*60));
						$newmember->set_data("websourceip", $_SERVER['REMOTE_ADDR']);
					}
					$this->member_set->edit($newmember);

					$loginacct = new loginacct();	
					$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
					$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
					$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
					$loginacct->set_data('portocol', 'web');
					$loginacct->set_data('audituser', $result[0]['username']);
					$loginacct->set_data('systemuser', ''); 
					$loginacct->set_data('time', date('y-m-d H:i:s')); 
					$loginacct->set_data('authenticationstatus', 1);
					$this->loginacct_set->add($loginacct);
					

					$_SESSION['startonlinetime']=time();//var_dump((time()-$result[0]['lastdateChpwd'])/(24*3600));var_dump($pwdconfig['pwdexpired']-$pwdconfig['pwdahead']);exit;
					if((((time()-$result[0]['lastdateChpwd'])/(24*3600)) > ($pwdconfig['pwdexpired']-$pwdconfig['pwdahead']) )){
						$membercpwd = urlencode("controller=admin_member&action=edit_self&msg=changepwd");
						//go_url('admin.php?controller=admin_index&ref='.$membercpwd);
						//exit;
					}
					go_url('admin.php?controller=admin_index&ref='.urlencode($ref));
					exit;
					break;
				case -1:					
					if(/*$result[0]['level']!=1&&*/(1 || $result[0]['loginlock'])){
						$this->member_set->edit($newmember);
						if($login_times-$result[0]['logintimes'] > 0){
							$loginacct = new loginacct();	
							$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
							$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
							$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
							$loginacct->set_data('portocol', 'web');
							$loginacct->set_data('audituser', $result[0]['username']);
							$loginacct->set_data('systemuser', ''); 
							$loginacct->set_data('time', date('y-m-d H:i:s')); 
							$loginacct->set_data('authenticationstatus', 0);
							$loginacct->set_data('failreason',$_CONFIG['WEBLOGINWRONGTIP']);
							$this->loginacct_set->add($loginacct);
							alert_and_back(language($_CONFIG['WEBLOGINWRONGTIP'].',请重试').language('还有').($login_times-$result[0]['logintimes']).'次','admin.php?controller=admin_index&action=login');
							exit;
						}
						else {
							$loginacct = new loginacct();	
							$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
							$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
							$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
							$loginacct->set_data('portocol', 'web');
							$loginacct->set_data('audituser', $result[0]['username']);
							$loginacct->set_data('systemuser', ''); 
							$loginacct->set_data('time', date('y-m-d H:i:s')); 
							$loginacct->set_data('authenticationstatus', 0);
							$loginacct->set_data('failreason',$_CONFIG['WEBLOGINWRONGTIP'].',已经超出系统限制');
							$this->loginacct_set->add($loginacct);
							alert_and_back($_CONFIG['WEBLOGINWRONGTIP'].',已经超出系统限制,请'.$pwdconfig['login_times_last'].'分钟后重试','admin.php?controller=admin_index&action=login');
							exit;
						}
					}else{
						$loginacct = new loginacct();	
						$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
						$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
						$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
						$loginacct->set_data('portocol', 'web');
						$loginacct->set_data('audituser', $result[0]['username']);
						$loginacct->set_data('systemuser', ''); 
						$loginacct->set_data('time', date('y-m-d H:i:s')); 
						$loginacct->set_data('authenticationstatus', 0);
						$this->loginacct_set->add($loginacct);
						alert_and_back($_CONFIG['WEBLOGINWRONGTIP'].'','admin.php?controller=admin_index&action=login');
						exit;
					}
					break;
				default:
				{
					if(/*$result[0]['level']==0 || $_CONFIG['OTHER_MEMBER_RADIUS']==1*/1){
						$loginacct = new loginacct();	
						$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
						$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
						$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
						$loginacct->set_data('portocol', 'web');
						$loginacct->set_data('audituser', $result[0]['username']);
						$loginacct->set_data('systemuser', ''); 
						$loginacct->set_data('time', date('y-m-d H:i:s')); 
						$loginacct->set_data('authenticationstatus', 0);
						$loginacct->set_data('failreason','系统错误,请稍候重试,或用本地方式登录,或联系管理员');
						$this->loginacct_set->add($loginacct);
						alert_and_back('系统错误,请稍候重试,或联系管理员','admin.php?controller=admin_index&action=login');
						exit;
					}
				}
			}
			
		}elseif($authtype=='adauth'){
			$adconfig=$this->setting_set->select_all("sname='loginconfig'");
			$adconfig = unserialize($adconfig[0]['svalue']);
			$_adconfig = $adconfig['adconfig'];
			for($ii=0; $ii<count($_adconfig); $ii++){
				if($_adconfig[$ii]['address']==$authtype_server){
					$adconfig = $_adconfig[$ii];
					break;
				}
			}
			$auth_rs = $this->ad_chk($username, $password, $adconfig['address'], $adconfig['port'],$adconfig['domain']);
			//$auth_rs=1;

			switch($auth_rs){
				case 1:
					$_SESSION['ADMIN_LOGINED'] = true;
					$_SESSION['ADMIN_USERNAME'] =  $username;
					$_SESSION['ADMIN_LEVEL'] = $result[0]['level'];					
					$_SESSION['ADMIN_UID'] = $result[0]['uid'];
					$_SESSION['ADMIN_GROUP'] = (int)$result[0]['groupid'];
					$_SESSION['ADMIN_FLIST'] = unserialize($result[0]['flist']);
					$_SESSION['ADMIN_SEARCHCACHE'] = $result[0]['searchcache'];
					$_SESSION['ADMIN_LASTDATE'] = $result[0]['lastdate'];
					$_SESSION['ADMIN_IP'] = $_SERVER['REMOTE_ADDR'];
					$_SESSION['ADMIN_MUSERGROUP'] = $result[0]['musergroup'];
					$_SESSION['ADMIN_MUSERGROUPTYPE'] = $result[0]['musergrouptype'];
					$_SESSION['ADMIN_MSERVERGROUP'] = $result[0]['mservergroup'];
					$_SESSION['ADMIN_LOGINDATE'] = date('Y-m-d H:i:s');
					if($result[0]['login_tip']){
						$_SESSION['ADMIN_LOGIN_TIP'] = true;
					}
					$_SESSION['DEVS'] = $serverString;
					if(empty($_SESSION['DEVS']))
						$_SESSION['DEVS']=0;
					setcookie("LANGUAGE", $language,time()+3600*24*365*100, '/', '', 1);
					setcookie("audit_sec_sessionid", session_id(), time()+3600*24*365*100, '/', '', 1);
					$newmember->set_data("lastdate", date('Y-m-d H:i:s'));
					$newmember->set_data("ip", $_SERVER['REMOTE_ADDR']);
					$newmember->set_data("logintimes", 0); 
					$newmember->set_data('devs',",".$serverString.",");
					$cologinauth = (($result[0]['usbkey']&&$result[0]['usbkeystatus']==11) || $result[0]['authtype']&&($result[0]['radiusauth']||$result[0]['ldapauth']||$result[0]['adauth']||intval($result[0]['auth'])==2));
					if(!($cologinauth&&empty($_SESSION['USER_MULTI_LOGIN_VALIDATED']))){
						$newmember->set_data("webportallogin", (empty($result[0]['webportaltime']) ? mktime(23,59,59,date('n'),date('j'),date('Y')) : time()+$result[0]['webportaltime']*60));
						$newmember->set_data("websourceip", $_SERVER['REMOTE_ADDR']);
					}
					$this->member_set->edit($newmember);

					$loginacct = new loginacct();	
					$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
					$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
					$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
					$loginacct->set_data('portocol', 'web');
					$loginacct->set_data('audituser', $result[0]['username']);
					$loginacct->set_data('systemuser', ''); 
					$loginacct->set_data('time', date('y-m-d H:i:s')); 
					$loginacct->set_data('authenticationstatus', 1);
					$this->loginacct_set->add($loginacct);
					

					$_SESSION['startonlinetime']=time();//var_dump((time()-$result[0]['lastdateChpwd'])/(24*3600));var_dump($pwdconfig['pwdexpired']-$pwdconfig['pwdahead']);exit;
					if((((time()-$result[0]['lastdateChpwd'])/(24*3600)) > ($pwdconfig['pwdexpired']-$pwdconfig['pwdahead']) )){
						$membercpwd = urlencode("controller=admin_member&action=edit_self&msg=changepwd");
						//go_url('admin.php?controller=admin_index&ref='.$membercpwd);
						//exit;
					}
					go_url('admin.php?controller=admin_index&ref='.urlencode($ref));
					exit;
					break;
				case -1:					
					if(/*$result[0]['level']!=1&&*/(1 || $result[0]['loginlock'])){
						$this->member_set->edit($newmember);
						if($login_times-$result[0]['logintimes'] > 0){
							$loginacct = new loginacct();	
							$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
							$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
							$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
							$loginacct->set_data('portocol', 'web');
							$loginacct->set_data('audituser', $result[0]['username']);
							$loginacct->set_data('systemuser', ''); 
							$loginacct->set_data('time', date('y-m-d H:i:s')); 
							$loginacct->set_data('authenticationstatus', 0);
							$loginacct->set_data('failreason',$_CONFIG['WEBLOGINWRONGTIP']);
							$this->loginacct_set->add($loginacct);
							alert_and_back(language($_CONFIG['WEBLOGINWRONGTIP'].',请重试').language('还有').($login_times-$result[0]['logintimes']).'次','admin.php?controller=admin_index&action=login');
							exit;
						}
						else {
							$loginacct = new loginacct();	
							$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
							$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
							$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
							$loginacct->set_data('portocol', 'web');
							$loginacct->set_data('audituser', $result[0]['username']);
							$loginacct->set_data('systemuser', ''); 
							$loginacct->set_data('time', date('y-m-d H:i:s')); 
							$loginacct->set_data('authenticationstatus', 0);
							$loginacct->set_data('failreason',$_CONFIG['WEBLOGINWRONGTIP'].',已经超出系统限制');
							$this->loginacct_set->add($loginacct);
							alert_and_back($_CONFIG['WEBLOGINWRONGTIP'].',已经超出系统限制,请'.$pwdconfig['login_times_last'].'分钟后重试','admin.php?controller=admin_index&action=login');
							exit;
						}
					}else{
						$loginacct = new loginacct();	
						$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
						$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
						$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
						$loginacct->set_data('portocol', 'web');
						$loginacct->set_data('audituser', $result[0]['username']);
						$loginacct->set_data('systemuser', ''); 
						$loginacct->set_data('time', date('y-m-d H:i:s')); 
						$loginacct->set_data('authenticationstatus', 0);
						$this->loginacct_set->add($loginacct);
						alert_and_back($_CONFIG['WEBLOGINWRONGTIP'].'','admin.php?controller=admin_index&action=login');
						exit;
					}
					break;
				default:
				{
					if(/*$result[0]['level']==0 || $_CONFIG['OTHER_MEMBER_RADIUS']==1*/1){
						$loginacct = new loginacct();	
						$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
						$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
						$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
						$loginacct->set_data('portocol', 'web');
						$loginacct->set_data('audituser', $result[0]['username']);
						$loginacct->set_data('systemuser', ''); 
						$loginacct->set_data('time', date('y-m-d H:i:s')); 
						$loginacct->set_data('authenticationstatus', 0);
						$loginacct->set_data('failreason','系统错误,请稍候重试,或联系管理员');
						$this->loginacct_set->add($loginacct);
						alert_and_back('系统错误,请稍候重试,或联系管理员','admin.php?controller=admin_index&action=login');
						exit;
					}
				}
			}
			
		}else if($authtype=='fingersecauth'){
			$fpdata = get_request('fpdata', 1, 1);//echo '1';var_dump($_POST);var_dump($fpdata);
			//$fpdata = 'AQEAAAACAhAAAADrQpKD1nQZ2ul0d0JSPs07BMwBAAAF1QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEhdaAg6AAAAAQ0AAAAAAAAAAABEM0JFNkRFQi03MkNFLTRBNEYtOUNFRi1DNTI0OUU2MjdCMTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAATYuMi45MjAwAAAAAAAAAAAEMTkyLjE2OC41OC4xAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAARjAtRkYtRjctRkQtQTctQ0ZnYW9mZW5nMQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYCAAAAAQEH5gAAAAEA9AEAASABAAeiCoiEEQBMACAND09AgAsLWlgACAXEYKAENs14wARXsnxgA0GkxAAAEMbYQA0Lx+hgEAiLXAECENZkYQkMY50BDArTxOEOBGDV4Q8E2SQCDQVpZOIIBeCgggYGAcd5YAQPEcRCSqL6gzXAwzk9SFGitkN3wMM0NEZYonM1mE7AwiknIAVmXKIFS3vAwiAdFQVvYlmhRodTwMIZFw8DcWihA0dUwMITpEMAESVWwMINpEQiQiVVwMIHpFZEMzV1wMMDo2NTRGbAwwKjVVRFZ8DEdqJkZUbAxXNxb23g';

			$auth_rs = $this->fingersec_chk($username, $fpdata);
			//$auth_rs=1;

			switch($auth_rs){
				case 1:
					$_SESSION['ADMIN_LOGINED'] = true;
					$_SESSION['ADMIN_USERNAME'] =  $username;
					$_SESSION['ADMIN_LEVEL'] = $result[0]['level'];					
					$_SESSION['ADMIN_UID'] = $result[0]['uid'];
					$_SESSION['ADMIN_GROUP'] = (int)$result[0]['groupid'];
					$_SESSION['ADMIN_FLIST'] = unserialize($result[0]['flist']);
					$_SESSION['ADMIN_LASTDATE'] = $result[0]['lastdate'];
					$_SESSION['ADMIN_IP'] = $_SERVER['REMOTE_ADDR'];
					$_SESSION['ADMIN_MUSERGROUP'] = $result[0]['musergroup'];
					$_SESSION['ADMIN_MUSERGROUPTYPE'] = $result[0]['musergrouptype'];
					$_SESSION['ADMIN_MSERVERGROUP'] = $result[0]['mservergroup'];
					$_SESSION['ADMIN_LOGINDATE'] = date('Y-m-d H:i:s');
					if($result[0]['login_tip']){
						$_SESSION['ADMIN_LOGIN_TIP'] = true;
					}
					$_SESSION['DEVS'] = $serverString;
					if(empty($_SESSION['DEVS']))
						$_SESSION['DEVS']=0;
					setcookie("LANGUAGE", $language,time()+3600*24*365*100, '/', '', 1);
					setcookie("audit_sec_sessionid", session_id(), time()+3600*24*365*100, '/', '', 1);
					$newmember->set_data("lastdate", date('Y-m-d H:i:s'));
					$newmember->set_data("ip", $_SERVER['REMOTE_ADDR']);
					$newmember->set_data("logintimes", 0); 
					$newmember->set_data('devs',",".$serverString.",");
					$this->member_set->edit($newmember);

					$adminlog = new admin_log();
					$adminlog->set_data('luser', $result[0]['username']);
					$adminlog->set_data('action', language('web登录成功'));
					$this->admin_log_set->add($adminlog);
					$loginacct = new loginacct();	
					$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
					$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
					$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
					$loginacct->set_data('portocol', 'web');
					$loginacct->set_data('audituser', $result[0]['username']);
					$loginacct->set_data('systemuser', ''); 
					$loginacct->set_data('time', date('y-m-d H:i:s')); 
					$loginacct->set_data('authenticationstatus', 1);
					$this->loginacct_set->add($loginacct);
					
					$_SESSION['startonlinetime']=mktime();//var_dump((mktime()-$result[0]['lastdateChpwd'])/(24*3600));var_dump($pwdconfig['pwdexpired']-$pwdconfig['pwdahead']);exit;
					if((((mktime()-$result[0]['lastdateChpwd'])/(24*3600)) > ($pwdconfig['pwdexpired']-$pwdconfig['pwdahead']) )){
						$membercpwd = urlencode("controller=admin_member&action=edit_self&msg=changepwd");
						//go_url('admin.php?controller=admin_index&ref='.$membercpwd);
						//exit;
					}
					go_url('admin.php?controller=admin_index&ref='.urlencode($ref));
					exit;
					break;
				case -1:					
					if(/*$result[0]['level']!=1&&*/(1 || $result[0]['loginlock'])){
						$this->member_set->edit($newmember);
						if($login_times-$result[0]['logintimes'] > 1){
							$loginacct = new loginacct();	
							$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
							$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
							$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
							$loginacct->set_data('portocol', 'web');
							$loginacct->set_data('audituser', $result[0]['username']);
							$loginacct->set_data('systemuser', ''); 
							$loginacct->set_data('time', date('y-m-d H:i:s')); 
							$loginacct->set_data('authenticationstatus', 0);
							$this->loginacct_set->add($loginacct);
							alert_and_back(language('验证失败,请重试').language('还有').($login_times-$result[0]['logintimes']-1).'次');
							exit;
						}
						else {
							$adminlog = new admin_log();
							$adminlog->set_data('luser', $result[0]['username']);
							$adminlog->set_data('action', language('密码超过最大值'));
							$this->admin_log_set->add($adminlog);
							$loginacct = new loginacct();	
							$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
							$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
							$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
							$loginacct->set_data('portocol', 'web');
							$loginacct->set_data('audituser', $result[0]['username']);
							$loginacct->set_data('systemuser', ''); 
							$loginacct->set_data('time', date('y-m-d H:i:s')); 
							$loginacct->set_data('authenticationstatus', 0);
							$this->loginacct_set->add($loginacct);
							alert_and_back('验证失败,已经超出系统限制,请'.$pwdconfig['login_times_last'].'分钟后重试');
							exit;
						}
					}else{
						$loginacct = new loginacct();	
						$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
						$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
						$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
						$loginacct->set_data('portocol', 'web');
						$loginacct->set_data('audituser', $result[0]['username']);
						$loginacct->set_data('systemuser', ''); 
						$loginacct->set_data('time', date('y-m-d H:i:s')); 
						$loginacct->set_data('authenticationstatus', 0);
						$this->loginacct_set->add($loginacct);
						alert_and_back('验证失败');
						exit;
					}
					break;
				default:
				{
					if(/*$result[0]['level']==0 || $_CONFIG['OTHER_MEMBER_RADIUS']==1*/1){
						alert_and_back('系统错误,请稍候重试,或联系管理员');
						exit;
					}
				}
			}	
		}else if($authtype=='localfingersecauth'){//echo '2';var_dump($this->member_set->udf_decrypt($result[0][password]));var_dump(get_request('password',1,1));var_dump($_POST);var_dump($fpdata);
			if($this->member_set->udf_decrypt($result[0][password])!=get_request('password',1,1)){
				alert_and_back('用户名密码错误');
				exit;
			}

			$fpdata = get_request('fpdata', 1, 1);
			//$fpdata = 'AQEAAAACAhAAAADrQpKD1nQZ2ul0d0JSPs07BMwBAAAF1QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEhdaAg6AAAAAQ0AAAAAAAAAAABEM0JFNkRFQi03MkNFLTRBNEYtOUNFRi1DNTI0OUU2MjdCMTAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAATYuMi45MjAwAAAAAAAAAAAEMTkyLjE2OC41OC4xAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAARjAtRkYtRjctRkQtQTctQ0ZnYW9mZW5nMQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYCAAAAAQEH5gAAAAEA9AEAASABAAeiCoiEEQBMACAND09AgAsLWlgACAXEYKAENs14wARXsnxgA0GkxAAAEMbYQA0Lx+hgEAiLXAECENZkYQkMY50BDArTxOEOBGDV4Q8E2SQCDQVpZOIIBeCgggYGAcd5YAQPEcRCSqL6gzXAwzk9SFGitkN3wMM0NEZYonM1mE7AwiknIAVmXKIFS3vAwiAdFQVvYlmhRodTwMIZFw8DcWihA0dUwMITpEMAESVWwMINpEQiQiVVwMIHpFZEMzV1wMMDo2NTRGbAwwKjVVRFZ8DEdqJkZUbAxXNxb23g';
			$auth_rs = $this->fingersec_chk($username, $fpdata);
			//$auth_rs=1;

			switch($auth_rs){
				case 1:
					$_SESSION['ADMIN_LOGINED'] = true;
					$_SESSION['ADMIN_USERNAME'] =  $username;
					$_SESSION['ADMIN_LEVEL'] = $result[0]['level'];					
					$_SESSION['ADMIN_UID'] = $result[0]['uid'];
					$_SESSION['ADMIN_GROUP'] = (int)$result[0]['groupid'];
					$_SESSION['ADMIN_FLIST'] = unserialize($result[0]['flist']);
					$_SESSION['ADMIN_LASTDATE'] = $result[0]['lastdate'];
					$_SESSION['ADMIN_IP'] = $_SERVER['REMOTE_ADDR'];
					$_SESSION['ADMIN_MUSERGROUP'] = $result[0]['musergroup'];
					$_SESSION['ADMIN_MUSERGROUPTYPE'] = $result[0]['musergrouptype'];
					$_SESSION['ADMIN_MSERVERGROUP'] = $result[0]['mservergroup'];
					$_SESSION['ADMIN_LOGINDATE'] = date('Y-m-d H:i:s');
					if($result[0]['login_tip']){
						$_SESSION['ADMIN_LOGIN_TIP'] = true;
					}
					$_SESSION['DEVS'] = $serverString;
					if(empty($_SESSION['DEVS']))
						$_SESSION['DEVS']=0;
					setcookie("LANGUAGE", $language,time()+3600*24*365*100, '/', '', 1);
					setcookie("audit_sec_sessionid", session_id(), time()+3600*24*365*100, '/', '', 1);
					$newmember->set_data("lastdate", date('Y-m-d H:i:s'));
					$newmember->set_data("ip", $_SERVER['REMOTE_ADDR']);
					$newmember->set_data("logintimes", 0); 
					$newmember->set_data('devs',",".$serverString.",");
					$this->member_set->edit($newmember);

					$adminlog = new admin_log();
					$adminlog->set_data('luser', $result[0]['username']);
					$adminlog->set_data('action', language('web登录成功'));
					$this->admin_log_set->add($adminlog);
					$loginacct = new loginacct();	
					$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
					$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
					$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
					$loginacct->set_data('portocol', 'web');
					$loginacct->set_data('audituser', $result[0]['username']);
					$loginacct->set_data('systemuser', ''); 
					$loginacct->set_data('time', date('y-m-d H:i:s')); 
					$loginacct->set_data('authenticationstatus', 1);
					$this->loginacct_set->add($loginacct);
					
					$_SESSION['startonlinetime']=mktime();//var_dump((mktime()-$result[0]['lastdateChpwd'])/(24*3600));var_dump($pwdconfig['pwdexpired']-$pwdconfig['pwdahead']);exit;
					if((((mktime()-$result[0]['lastdateChpwd'])/(24*3600)) > ($pwdconfig['pwdexpired']-$pwdconfig['pwdahead']) )){
						$membercpwd = urlencode("controller=admin_member&action=edit_self&msg=changepwd");
						//go_url('admin.php?controller=admin_index&ref='.$membercpwd);
						//exit;
					}
					go_url('admin.php?controller=admin_index&ref='.urlencode($ref));
					exit;
					break;
				case -1:					
					if(/*$result[0]['level']!=1&&*/(1 || $result[0]['loginlock'])){
						$this->member_set->edit($newmember);
						if($login_times-$result[0]['logintimes'] > 1){
							$loginacct = new loginacct();	
							$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
							$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
							$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
							$loginacct->set_data('portocol', 'web');
							$loginacct->set_data('audituser', $result[0]['username']);
							$loginacct->set_data('systemuser', ''); 
							$loginacct->set_data('time', date('y-m-d H:i:s')); 
							$loginacct->set_data('authenticationstatus', 0);
							$this->loginacct_set->add($loginacct);
							alert_and_back(language('验证失败,请重试').language('还有').($login_times-$result[0]['logintimes']-1).'次');
							exit;
						}
						else {
							$adminlog = new admin_log();
							$adminlog->set_data('luser', $result[0]['username']);
							$adminlog->set_data('action', language('密码超过最大值'));
							$this->admin_log_set->add($adminlog);
							$loginacct = new loginacct();	
							$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
							$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
							$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
							$loginacct->set_data('portocol', 'web');
							$loginacct->set_data('audituser', $result[0]['username']);
							$loginacct->set_data('systemuser', ''); 
							$loginacct->set_data('time', date('y-m-d H:i:s')); 
							$loginacct->set_data('authenticationstatus', 0);
							$this->loginacct_set->add($loginacct);
							alert_and_back('验证失败,已经超出系统限制,请'.$pwdconfig['login_times_last'].'分钟后重试');
							exit;
						}
					}else{
						$loginacct = new loginacct();	
						$loginacct->set_data('auditip', $_SERVER['HTTP_HOST']);			
						$loginacct->set_data('serverip', $_SERVER['HTTP_HOST']);
						$loginacct->set_data('sourceip', $_SERVER['REMOTE_ADDR']);
						$loginacct->set_data('portocol', 'web');
						$loginacct->set_data('audituser', $result[0]['username']);
						$loginacct->set_data('systemuser', ''); 
						$loginacct->set_data('time', date('y-m-d H:i:s')); 
						$loginacct->set_data('authenticationstatus', 0);
						$this->loginacct_set->add($loginacct);
						alert_and_back('验证失败');
						exit;
					}
					break;
				default:
				{
					if(/*$result[0]['level']==0 || $_CONFIG['OTHER_MEMBER_RADIUS']==1*/1){
						alert_and_back('系统错误,请稍候重试,或联系管理员');
						exit;
					}
				}
			}	
		}
	}

	
	function qrcode(){
		global $_CONFIG;
		$m =$this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$m['mobilenum']=substr($m['mobilenum'],0,3).'****'.substr($m['mobilenum'],7);
		$this->assign("userinfo", $m);
		if($_CONFIG['LOGIN_DEBUG']){
			$key = $this->usbkey_set->select_all("keyid='".$m['usbkey']."'");
			//echo '<pre>';var_dump($key);echo '</pre>';
		}

		$loginconfig = $this->setting_set->select_all(" sname='loginconfig'");
		$loginconfig = unserialize($loginconfig[0]['svalue']);
		$this->assign("ldaps", $loginconfig['ldapconfig']);
		$this->assign("ads", $loginconfig['adconfig']);
		$this->display("qrcode.tpl");
	}

	function doqrcode(){
		global $_CONFIG;
		$localpwd = get_request('localpwd',1,1);
		$radiuspwd = get_request('radiuspwd',1,1);
		$ldappwd = get_request('ldapwd',1,1);
		$adpwd = get_request('adpwd',1,1);
		$smspassword = get_request('smspassword',1,1);
		$minfo = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		if($minfo['usbkey']&&$minfo['usbkeystatus']==11){
			$old_radius = $this->radius_set->select_all("UserName = '".$minfo['username']."'");
			$new_radius = new radius();
			$new_radius->set_data("id",$old_radius[0]['id']);
			$new_radius->set_data("Value",crypt($this->member_set->udf_decrypt($minfo['password']),"\$1\$qY9g/6K4"));
			$this->radius_set->edit($new_radius);
			$_tmp = $this->member_set->base_select("select rad_getpasswd('".$_SESSION['ADMIN_USERNAME']."','".$this->member_set->udf_decrypt($minfo['password']).get_request('qrcode',1,1)."','','127.0.0.1') AS p");
			if(crypt($this->member_set->udf_decrypt($minfo['password']).get_request('qrcode',1,1),"\$1\$qY9g/6K4")!=$_tmp[0]['p']){						
				$_SESSION['CHKSMSLOGIN_STEP']=1;
				alert_and_back('动态口令输入错误\n系统时间为:'.date('Y年m月d日 H时i分'),'admin.php?controller=admin_index&action=chklogin&uid='.$minfo['uid']);
				exit;
			}else{
				
				$newmember = new member();
				$newmember->set_data("usbkeystatus", 0);
				$newmember->set_data("smspassword", 0);
				$newmember->set_data("uid", $_SESSION['ADMIN_UID']);
				$this->member_set->edit($newmember);
				
				session_destroy();
				alert_and_back('操作成功，请重新登录','admin.php?controller=admin_index&action=login',0,1);
				exit;
			}
		}
		$localauth = (!$minfo['authtype']||!$minfo['localauth']||$_SESSION['authtype']=='localauth');
		$radiusauth = (!$minfo['authtype']||!$minfo['radiusauth']||$_SESSION['authtype']=='radiusauth');
		$ldapauth = (!$minfo['authtype']||!$minfo['ldapauth']||$_SESSION['authtype']=='ldapauth');
		$adauth = (!$minfo['authtype']||!$minfo['adauth']||$_SESSION['authtype']=='adauth');
		$auth = !$minfo['authtype']||!$minfo['auth'];
		if($minfo['authtype']&&($minfo['localauth']||$minfo['radiusauth']||$minfo['ldapauth']||$minfo['adauth']||intval($minfo['auth'])==2)){
			if($minfo['localauth']&&$_SESSION['authtype']!='localauth'){
				$localauth = ($this->member_set->udf_decrypt($minfo['password'])==$localpwd);
			}
			if($minfo['radiusauth']&&$_SESSION['authtype']!='radiusauth'){
				$filename = $_CONFIG['CONFIGFILE']['SSH'];
				$lines = @file($filename);
				if(!empty($lines)){
					for($ii=0; $ii<count($lines); $ii++)
					{
										
						if(strstr($lines[$ii], "MasterRadiusServerAddress"))
						{
							$tmp = preg_split("/[\s]+/", $lines[$ii]);
							$radiusconfig['address'] = trim($tmp[1]);
						}
						if(strstr($lines[$ii], "MasterRadiusServerPort"))
						{
							$tmp = preg_split("/[\s]+/", $lines[$ii]);
							$radiusconfig['port'] = trim($tmp[1]);
						}
						if(strstr($lines[$ii], "MasterRadiusServerSecret"))
						{
							$tmp = preg_split("/[\s]+/", $lines[$ii]);
							$radiusconfig['secret'] = trim($tmp[1]);
						}
						if(strstr($lines[$ii], "SlaveRadiusServerAddress"))
						{
							$tmp = preg_split("/[\s]+/", $lines[$ii]);
							$radiusconfig['slaveaddress'] = trim($tmp[1]);
						}
						if(strstr($lines[$ii], "SlaveRadiusServerPort"))
						{
							$tmp = preg_split("/[\s]+/", $lines[$ii]);
							$radiusconfig['slaveport'] = trim($tmp[1]);
						}
						if(strstr($lines[$ii], "SlaveRadiusServerSecret"))
						{
							$tmp = preg_split("/[\s]+/", $lines[$ii]);
							$radiusconfig['slavesecret'] = trim($tmp[1]);
						}
						if(strstr($lines[$ii], "RadiusAuth"))
						{
							$tmp = preg_split("/[\s]+/", $lines[$ii]);
							$radiusconfig['radiusauth'] = trim($tmp[1]);
						}
					}
				}else{
					alert_and_back('打开radius配置文件失败');
					exit;
				}
				$radiusauth = $this->radius_chk($minfo['username'], $radiuspwd, $radiusconfig['address'], $radiusconfig['port'],$radiusconfig['secret']);
				//$auth_rs=1;

				if($radiusauth<-1){
					$radiusauth = $this->radius_chk($minfo['username'], $radiuspwd, $radiusconfig['slaveaddress'], $radiusconfig['slaveport'],$radiusconfig['slavesecret']);
				}
				if($radiusauth==-4||$radiusauth==-2){
					//echo "<script>alert('RADIUS无法访问，跳过登录');</script>";
					//$radiusauth=1;
				}

			}

			$ldapserver = get_request('ldapserver', 1, 1);
			if(strpos($ldapserver, '_')!==false){
				$tmpauthtype = explode('_', $ldapserver);
				$authtype_server = $tmpauthtype[1];
			}
			if($minfo['ldapauth']&&$_SESSION['authtype']!='ldapauth'){
				$ldapconfig=$this->setting_set->select_all("sname='loginconfig'");
				$ldapconfig = unserialize($ldapconfig[0]['svalue']);
				$_ldapconfig = $ldapconfig['ldapconfig'];
				for($ii=0; $ii<count($_ldapconfig); $ii++){
					if($_ldapconfig[$ii]['address']==$authtype_server){
						$ldapconfig = $_ldapconfig[$ii];
						break;
					}					
				}
				$ldapauth = $this->ldap_chk($_CONFIG['LDAPCLIENT']?$minfo['username']:$minfo['adou'], $ldappwd, $ldapconfig['address'], $ldapconfig['port'],$ldapconfig['domain']);
			}

			$adserver = get_request('adserver', 1, 1);
			if(strpos($adserver, '_')!==false){
				$tmpauthtype = explode('_', $adserver);
				$authtype_server = $tmpauthtype[1];
			}
			if($minfo['adauth']&&$_SESSION['authtype']!='adauth'){
				$adconfig=$this->setting_set->select_all("sname='loginconfig'");
				$adconfig = unserialize($adconfig[0]['svalue']);
				$_adconfig = $adconfig['adconfig'];
				for($ii=0; $ii<count($_adconfig); $ii++){
					if($_adconfig[$ii]['address']==$authtype_server){
						$adconfig = $_adconfig[$ii];
						break;
					}
				}
				$adauth = $this->ad_chk($minfo['username'], $adpwd, $adconfig['address'], $adconfig['port'],$adconfig['domain']);
			}

			if($minfo['auth']==2){
				$auth = ($minfo['smspassword']==$smspassword);
			}
			if($localauth!=1){
				$error[]='本地密码错误';
			}
			if($radiusauth!=1){
				$error[]='RADIUS密码错误';
			}
			if($ldapauth!=1){
				$error[]='LDAP密码错误';
			}
			if($adauth!=1){
				$error[]='AD密码错误';
			}
			if(!$auth){
				$error[]='短信密码错误';
			}
			if($error){
				alert_and_back('输入错误:\n'.implode('\n',$error).'\n','admin.php?controller=admin_index&action=chklogin&uid='.$minfo['uid']);
				exit;
			}
			//$auth_rs=1;
			
		}

		$m = new member();
		$m->set_data("webportallogin", (empty($minfo['webportaltime']) ? mktime(23,59,59,date('n'),date('j'),date('Y')) : time()+$minfo['webportaltime']*60));
		$m->set_data("websourceip", $_SERVER['REMOTE_ADDR']);
		$m->set_data("uid",$_SESSION['ADMIN_UID']);
		$this->member_set->edit($m);
		
		$_SESSION['USER_MULTI_LOGIN_VALIDATED']=true;
		//alert_and_back('登录成功','admin.php?controller=admin_index',0, 1);
		go_url('admin.php?controller=admin_index',1);
	}

	function accept(){
		global $_CONFIG;
		$this->assign('accept', file_get_contents($_CONFIG['ACCEPT_FILE']));
		$this->display("accept.tpl");
	}

	function doaccept(){
		global $_CONFIG;
		
		
		$_SESSION['USER_LOGIN_ACCEPT']=true;
		//alert_and_back('登录成功','admin.php?controller=admin_index',0, 1);
		go_url('admin.php?controller=admin_index',1);
	}

	function check_ip($member){
		$sources = $this->sourceip_set->select_all( 'groupname=\''.$member['sourceip'].'\' AND sourceip!=\'\'');
		$found = 0;
		$guest = $_SERVER['REMOTE_ADDR'];//var_dump($guest);
		for($i=0; $i<count($sources); $i++){//var_dump($sources[$i]['sourceip']);
			if(ipMatch($sources[$i]['sourceip'], $guest)){
				$found = 1;
				break;
			}
		}
		return $found;
	}
	function check_weektime($member){
		$sources = $this->weektime_set->select_all( 'policyname=\''.$member['weektime'].'\'');
		$w = (date('w')==0 ? '7' : date('w'));
		$found = true;
		if(date('H:i:s')<$sources[0]['start_time'.$w] || date('H:i:s')>$sources[0]['end_time'.$w]){
			$found = false;
		}
		return $found;
	}
	function radius_chk($username, $pwd, $server, $port, $key){
		global $_CONFIG;
		//var_dump($username. $pwd. $server. $port. $key);return -1;
		$password= $pwd;
		$radius = radius_auth_open(); 
		
	    if (! radius_add_server($radius,$server,(int)$port,$key,5,3)) 
	    { 
			return -4;
	        die('Radius Error: ' . radius_strerror($radius)); 
	    } 
	
	    if (! radius_create_request($radius,RADIUS_ACCESS_REQUEST)) 
	    { 
			return -4;
	        die('Radius Error: ' . radius_strerror($radius)); 
	    } 
	
	    radius_put_attr($radius,RADIUS_USER_NAME,$username); 
	    radius_put_attr($radius,RADIUS_USER_PASSWORD,$pwd); 
	    //@radius_put_attr($radius,RADIUS_NAS_IP_ADDRESS,'221.207.58.56', RADIUS_OPTION_TAGGED, 10); 
		$rs = radius_send_request($radius);
	    switch ($rs) 
	    { 
	        case RADIUS_ACCESS_ACCEPT: 
				$result = $this->member_set->select_all("username='".$username."'");
				if($result[0]['asyncoutpass']>=0 && $server!= '127.0.0.1' && substr($password,0,strlen($password)-$result[0]['asyncoutpass'])!=$this->member_set->udf_decrypt($result[0]['password'])){
					$password = substr($password,0,strlen($password)-$result[0]['asyncoutpass']);
						$new_radius = new radius();						
						$new_radius->set_data("UserName",$username);
						$new_radius->set_data("Attribute",'Crypt-Password');
						$new_radius->set_data("email",$result[0]['email']);					
						$new_radius->set_data("Value",crypt($password,"\$1\$qY9g/6K4"));					
						$radiususer = $this->radius_set->select_all("UserName = '" .$username . "'");
						$new_radius->set_data("id",$radiususer[0]['id']);
						$this->radius_set->edit($new_radius);						
						$newmember = new member();
						$newmember->set_data("password", $this->member_set->udf_encrypt($password)); 
						$newmember->set_data('uid', $result[0]['uid']);
						$this->member_set->edit($newmember);
				}
	            return 1;
	            break; 
	        case RADIUS_ACCESS_REJECT: 
	            return -1;
	            break; 
	        case RADIUS_ACCESS_CHALLENGE: 
	            return -2;
	            break; 
	        default: 
				//die('Radius Error: ' . radius_strerror($radius)); 
	        	return -4;
	            
	    } 
		radius_close($radius);
	}

		function ldap_chk($username, $pwd, $server, $port, $dc)
	{
		global $_CONFIG;
		//var_dump($username. $pwd. $server. $port. $dc);

		$ldapconn = @ldap_connect("$server", $port);	 
		@ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
		@ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
		if ($ldapconn) {

			// binding to ldap server
			$_domain = explode('.', $dc);
			$sdomain = '';
			for($i=0; $i<count($_domain); $i++){
				$sdomain .= "dc=".$_domain[$i].',';
			}
			$sdomain = substr($sdomain, 0, strlen($sdomain)-1);
			//首经贸代码 (shou jing mao)
			if($_CONFIG['LDAPCLIENT'])
				$ldapbind = @ldap_bind($ldapconn, 'cn='.$username.','.($username=='admin' ? '':'ou=syyh,dc=cuebusers,').$sdomain, $pwd);
			else 
				$ldapbind = @ldap_bind($ldapconn, $username, $pwd);
			// verify binding
			//exit;
			if ($ldapbind) {
				$_username = explode(',', $username);
				$_username = explode('=', $_username[0]);
				$_username = trim($_username[1]);
				$result = $this->member_set->select_all("username='".$_username."'");
				if($result){
					$pwd = substr($pwd,0,strlen($pwd)-$result[0]['asyncoutpass']);
					$new_radius = new radius();						
					$new_radius->set_data("UserName",$_username);
					$new_radius->set_data("Attribute",'Crypt-Password');
					$new_radius->set_data("email",$result[0]['email']);					
					$new_radius->set_data("Value",crypt($pwd,"\$1\$qY9g/6K4"));					
					$radiususer = $this->radius_set->select_all("UserName = '" .$_username . "'");
					$new_radius->set_data("id",$radiususer[0]['id']);
					$this->radius_set->edit($new_radius);						
					$newmember = new member();
					$newmember->set_data("password", $this->member_set->udf_encrypt($pwd)); 
					$newmember->set_data('uid', $result[0]['uid']);
					$this->member_set->edit($newmember);
				}
				return 1;
			}
			return -1;
		}
		return 0;
	}

	function ad_chk($username, $pwd, $server, $port, $domain)
	{
		global $_CONFIG;
		$password= $pwd;
		//var_dump($username. $pwd. $server. $port. $domain);
		//return -1;
		include (ROOT . "/include/adLDAP/adLDAP.php");
		try {
			$options['account_suffix'] = '@'.$domain;
			$options['domain_controllers'] = array($server);
			$_domain = explode('.', $domain);
			$sdomain = '';
			for($i=0; $i<count($_domain); $i++){
				$sdomain .= "dc=".$_domain[$i].',';
			}
			$sdomain = substr($sdomain, 0, strlen($sdomain)-1);
			$options['base_dn'] = $sdomain;

			$adldap = new adLDAP($options);
		}
		catch (adLDAPException $e) {
			return -1;
		}
		$result = $adldap->authenticate($username, $pwd);
		if(!$result){
			return -1;
		}
		$result = $this->member_set->select_all("username='".$username."'");
		if($result[0]['asyncoutpass']>=0 && substr($password,0,strlen($password)-$result[0]['asyncoutpass'])!=$this->member_set->udf_decrypt($result[0]['password'])){
				$password = substr($password,0,strlen($password)-$result[0]['asyncoutpass']);
				$new_radius = new radius();						
				$new_radius->set_data("UserName",$username);
				$new_radius->set_data("Attribute",'Crypt-Password');
				$new_radius->set_data("email",$result[0]['email']);					
				$new_radius->set_data("Value",crypt($password,"\$1\$qY9g/6K4"));					
				$radiususer = $this->radius_set->select_all("UserName = '" .$username . "'");
				$new_radius->set_data("id",$radiususer[0]['id']);
				$this->radius_set->edit($new_radius);						
				$newmember = new member();
				$newmember->set_data("password", $this->member_set->udf_encrypt($password)); 
				$newmember->set_data('uid', $result[0]['uid']);
				$this->member_set->edit($newmember);
		}
		//exit;
		return 1;
		/*
		$conn = ldap_connect($server);
		if($conn){
			//设置参数
			ldap_set_option ( $conn, LDAP_OPT_PROTOCOL_VERSION, 3 );
			ldap_set_option ( $conn, LDAP_OPT_REFERRALS, 0 ); // Binding to ldap server
			//echo $user.'/'.$pswd;
			$bd = ldap_bind($conn, $username.'@'.$domain, $pwd);
			if($bd){
				return 1;
			}else{
				return -1;
			}
		}*/
		return 0;

	}

	function fingersec_chk($userid, $fpdata)
	{
		global $_CONFIG;
		$param = array('arg0'=>'afism', 'arg1'=>'afism', 'arg2'=>$userid, 'arg3'=>$fpdata);
		//$client = new SoapClient('http://218.249.100.214:3680/taxAfiss/IService?wsdl');
//		var_dump($fpdata );
		$client = new SoapClient($_CONFIG['fingersecserver']);
//var_dump($_CONFIG['fingersecserver'] );
//var_dump($client );
		$i=$client->verify('afism','afism',$userid,$fpdata);
var_dump($i );exit;
		if($i->return=='0'){
			return 1;
		}
		return -1;
	}

	function encryp($code) {
		$chars = preg_split('//', $code, -1, PREG_SPLIT_NO_EMPTY);
		$i=10;
		$result = array();
		foreach($chars as $char) {
			
			$result[] = ord($char) ^ $i;
			$i++;
		}
		$string = '';
		foreach($result as $char) {
			$string.= chr($char);
		}
		return $string;
	}

	function logout() {
		global $_CONFIG;
		$m = new member();
		$m->set_data("webportallogin",0);
		$m->set_data("uid",$_SESSION['ADMIN_UID']);
		$this->member_set->edit($m);
		session_destroy();
		$_SESSION = array();
		if($_CONFIG['Certificate']==2){
			alert_and_close('请关闭IE浏览器');
		}else
		go_url('admin.php');

	}

	function license(){
		global $_CONFIG;
		exec("sudo /opt/freesvr/audit/sbin/license-print", $out, $return);
		if(empty($out[0]) || ($out[0]&&(trim($out[0])==-1 || date('Y-m-d')>substr($out[0], 0, strpos($out[0], ' '))))){
			echo('<script >alert("系统Licenses错误");</script>');
		}
		exec("sudo /opt/freesvr/audit/sbin/license-print", $output, $return);
		if($output[0]==-1){
			$output[0]='';
		}
		//$output = file("./controller/4.txt");
		//print_r($output);
		$targets = array();
		$i = 0;
		$j=0;
		//foreach($output as $line)
		$page_num = get_request('page');
		$page_num = empty($page_num) ? 1 : $page_num;
		$newpager = new my_pager(count($output), $page_num, 20, 'page');
		$num = ($page_num-1)*20+20 > count($output) ? count($output) : ($page_num-1)*20+20;
		for($i=($page_num-1)*20; $i<$num; $i++) 
		{
			$line = $output[$i];
			$arr = preg_split ("/\s{1,}/",$line);
			$targets[$i-($page_num-1)*20]["deadline"] = $arr[0];
			$targets[$i-($page_num-1)*20]["equipnum"] = $arr[1];
			$targets[$i-($page_num-1)*20]["company"] = $arr[2];
			$this->assign("licensekeytype",  1);
			if(strpos($arr[3],'-')===false){
				 $this->assign("licensekeytype",  0);
				$targets[$i-($page_num-1)*20]["key"] = $arr[3];
				$targets[$i-($page_num-1)*20]["ssh"] = 1;
				$targets[$i-($page_num-1)*20]["rdp"] = 1;
				$targets[$i-($page_num-1)*20]["apppub"] = 1;
			}else{
				$targets[$i-($page_num-1)*20]["key"] = substr($arr[3],strrpos($arr[3],'-')+1);
				$targets[$i-($page_num-1)*20]["ssh"] = $arr[4];
				$targets[$i-($page_num-1)*20]["rdp"] = $arr[5];
				$targets[$i-($page_num-1)*20]["apppub"] = $arr[6];
			}
			if(count($arr)<4){
				$targets[$i-($page_num-1)*20]["ssh"] = 1;
				$targets[$i-($page_num-1)*20]["rdp"] = 1;
				$targets[$i-($page_num-1)*20]["apppub"] = 1;
			}
			$_p = explode('-', $arr[3]);
			$targets[$i-($page_num-1)*20]["priority"] = $_p;
			//$i++;
		}
		$filename = $_CONFIG['CONFIGFILE']['SSH'];		
		$lines = file($filename);
		if(!empty($lines))
		{
			
			for($ii=0; $ii<count($lines); $ii++)
			{
								
				if(substr(trim($lines[$ii]),0,1)!='#'&&strstr($lines[$ii], "LicensesDevice"))
				{
					$tmp = preg_split("/[\s]+/", $lines[$ii]);//var_dump($tmp);
					$device = $tmp[1];
					break;
				}
			}
		}
		else
		{
			alert_and_back($filename.'配置文件不存在或没有权限');
			exit;
		}
		$cmd = "sudo ls -l /etc/sysconfig/network-scripts/ifcfg-*";
		exec($cmd, $out, $return);
		$j=0;
		for($i=0; $i<count($out); $i++){
			$out_ = preg_split("/\s+/", $out[$i]);
			$file=$out_[count($out_)-1];
			$filename=substr($out_[count($out_)-1], strrpos( $out_[count($out_)-1],'/')+1);
			if(strrpos( $out_[count($out_)-1],'/')===false){
				continue;
			}
			if(strpos($filename, '.backup')){
				$backupname[]=strtoupper(substr($filename,strpos($filename,'-')+1,strrpos($filename,'.')-strpos($filename,'-')-1));
				continue;
			}
			if(strpos($file,'lo')!==false){
				continue;
			}
			
			$files[$j]['name']=strtolower(substr($filename,strpos($filename,'-')+1));			
			$files[$j]['file']=$file;
			$files[$j]['filename']=$filename;
			$j++;
		}//var_dump($backupname);
		
		$this->assign("eths", $files);
		$this->assign("device", $device);

		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("license", $targets);
		$this->display("license.tpl");
	}
	
	function upload_license(){
		$ac = get_request('ac', 1, 1);
		if($ac=='upload'){
			if(is_uploaded_file($_FILES['key']['tmp_name'])){	
				if($_FILES['key']['name']!='licenses.key'){
					alert_and_back('请上传正确的文件','admin.php?controller=admin_index&action=license');
					exit;
				}
				if(move_uploaded_file($_FILES['key']['tmp_name'], "/opt/freesvr/audit/etc/licenses.key")){
					alert_and_back('上传成功','admin.php?controller=admin_index&action=license');
				}else{
					alert_and_back('移动文件失败','admin.php?controller=admin_index&action=license');
				}
				exit;
			}else{
				alert_and_back('请上传正确的文件','admin.php?controller=admin_index&action=license');
				exit;
			}
		}
		$this->display('upload_license.tpl');
	}

	function create_license(){
		global $_CONFIG;
		$device = get_request('ld', 0, 1);
//echo "/opt/freesvr/audit/sbin/collect -i $device";
		exec("sudo  /opt/freesvr/audit/sbin/manageprocess.pl freesvr-authd stop",$out0);
		exec("sudo  /opt/freesvr/audit/sbin/manageprocess.pl freesvr-authd start",$out00);
		exec("sudo  /opt/freesvr/audit/sbin/collect",$out);
		if($interface) return $out[0];
		echo '<div style="word-wrap:break-word; width:500px;border:solid 1px #ccc;">'.$out[0].'</div><br><input type=button value="复制到剪贴板" onclick="copyToClipboard(\''.$out[0].'\')"/>';
		return;
	}

	
	function test() {
		$this->member_set->change_pass();
	}

	function account() {
		$type = get_request('type');
		$page_num = get_request('page');
		$where = '1 = 1';
		if($type == 1) {
			$where = " AcctStopTime = '0000-00-00 00:00:00'";
			$this->assign('type',$type);
		}
		if($_SESSION[ADMIN_LEVEL]==0){
			$where .= " AND username='$_SESSION[ADMIN_USERNAME]'";
		}
		$row_num = $this->account_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$allaccount = $this->account_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where);

		$this->assign('title', language('记账信息'));
		//var_dump($allaccount);
		$this->assign('allaccount', $allaccount);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('admin_account.tpl');
	}

	function del_account() {
		$date = get_request('date', 1, 1);
		$this->account_set->delete_all("AcctStopTime < '$date 00:00:00 '");
		alert_and_back('删除成功');
	}

	function tool_list() {
		global $_CONFIG;
		$memberinfo = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		if($memberinfo['level']=='0' && $memberinfo['usbkeystatus']=='1'){
			$this->assign('usbkeyshow', 1);
		}
		$allTools = array();
		$Tool = array();
		$key = array();
		$i = 1;
		$d = @dir($_CONFIG['SOFTDOWNPATH']);
		if($d){
			while (false !== ($entry = $d->read())) {
				if($entry != '.' && $entry != '..') {
					$Tool['id'] = $i++;
					$Tool['path'] = urlencode($entry);
					$Tool['name'] = $entry;
					$key[] =$entry;
					$allTools[] = $Tool;
				}
			}
		}else{
			alert_and_back('读取目录失败 ,请检查文件权限','',1);
			exit;
		}
	 
		$d->close();
		array_multisort($key, SORT_ASC, $allTools);
		$this->assign("allTools",$allTools);
		$this->assign('title',language('工具列表'));
		$this->display('tools_list.tpl');
	}

	function tool_down(){
		global $_CONFIG;
		$name = get_request('name', 0, 1);
		if(substr(realpath($_CONFIG['SOFTDOWNPATH']."/".$name), 0, strlen($_CONFIG['SOFTDOWNPATH']))!=$_CONFIG['SOFTDOWNPATH']){
			alert_and_back('系统错误','',1);
			exit;
		}
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		header("Content-Disposition:filename=".iconv("UTF-8", "GB2312", $name));
		echo file_get_contents($_CONFIG['SOFTDOWNPATH']."/".$name);
		exit();
	}

	function upload_tool(){
		global $_CONFIG;
		$ac = get_request('ac', 1, 1);
		if($ac=='upload'){
			if(is_uploaded_file($_FILES['key']['tmp_name'])){	
				if(move_uploaded_file($_FILES['key']['tmp_name'], $_CONFIG['SOFTDOWNPATH']."/".$_FILES['key']['name'])){
					alert_and_back('上传成功','admin.php?controller=admin_index&action=tool_list');
				}else{
					alert_and_back('移动文件失败','admin.php?controller=admin_index&action=upload_tool');
				}
				exit;
			}else{
				alert_and_back('请上传正确的文件','admin.php?controller=admin_index&action=upload_tool');
				exit;
			}
		}
		$this->display('upload_soft.tpl');
	}

	function tool_delete(){
		global $_CONFIG;
		$name = get_request('name', 0, 1);
	//	unlink(ROOT."soft-down/".$name);
		@unlink($_CONFIG['SOFTDOWNPATH']."/".$name);
	
		alert_and_back('删除成功','admin.php?controller=admin_index&action=tool_list');
		exit;
	}
	
	function passdown(){
		global $_CONFIG;
		$page_num = get_request('page');
		
		exec('ls -lh --full-time -t '.$_CONFIG['PASSWORD_USER_DOWN'], $output);
		$row_num=count($output)-1;
		$j=0;
		$perpage = 20;
		for($i=1; $i<count($output); $i++){
			if($i < ($page_num-1)*$perpage+1) continue;
			if($j>$perpage-1) break;
			$filearr = preg_split("/[\s]+/", $output[$i]);
			$files[$j]['name'] = $filearr[8];
			$files[$j]['size'] = $filearr[4];
			$files[$j]['time'] = $filearr[5].' '.substr($filearr[6], 0, 8);
			$j++;
		}
		
		$newpager = new my_pager($row_num, $page_num, $perpage, 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->assign("title", language('密码文件下载'));
		$this->assign('files', $files);
		$this->display('passdown.tpl');
	}

	function deletepassfile(){
		global $_CONFIG;
		$file = get_request('filename',0,1);
		if(empty($file)){
			$files = $_POST['chk_member'];
		}else{
			$files[]=$file;
		}
		for($i=0; $i<count($files); $i++){
			exec('sudo rm -f '.$_CONFIG['PASSWORD_USER_DOWN'].$files[$i]);
		}
		alert_and_back("删除文件成功");
		exit;
	}
	
	function dopassdown(){
		global $_CONFIG;
		$filename = get_request('name', 0, 1);
		$file = $_CONFIG['PASSWORD_USER_DOWN']."/$filename";
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=$filename"); 
		$f=fopen($file,'rb'); 
			if($f!=false){
				$contents = "";
				do {
				    $data = fread($f, 8192);
				    if (strlen($data) == 0) {
				        break;
				    }
				    $contents .= $data;
				} while(true);
				fclose($f); 
				echo $contents;
		}else{
			alert_and_back("打开文件失败");
		}
		exit();
	}
	
	function download_usbkeyfile(){
		$username = $_SESSION['ADMIN_USERNAME'];
		$uid = $_SESSION['ADMIN_UID'];
		$member = $this->member_set->select_by_id($uid);
		if(empty($member['usbkeystatus'])){
			alert_and_close('该文件已经下载过');
			exit;
		}
		$filename = $username;
		$file = "/opt/freesvr/audit/usbkeys/$filename";
		Header('Cache-Control: private, must-revalidate, max-age=0');
		Header("Content-type: application/octet-stream"); 
		Header("Content-Disposition: attachment; filename=$filename"); 
		$f=fopen($file,'rb'); 
		if($f!=false){
			
			$newmember = new member();
			$newmember->set_data('uid', $uid);
			$newmember->set_data('usbkey', 0);
			$newmember->set_data('usbkeystatus', 0);
			$this->member_set->edit($newmember);
			
			$contents = "";
			do {
			    $data = fread($f, 8192);
			    if (strlen($data) == 0) {
			        break;
			    }
			    $contents .= $data;
			} while(true);
			fclose($f); 
			echo $contents;
			unlink($file);
		}else{
			alert_and_back("打开文件失败");
		}
		exit();
	}

	function appdevice_list(){
		global $_CONFIG;
		$page_num = get_request('page');
		$this->assign("logindebug",$_CONFIG['LOGIN_DEBUG']);
		$lb = $this->loadbalance_set->select_all();
		$localhost = $this->get_eth0_ip();
		$localhost = $localhost['eth0'];
		$this->assign("localip",$localhost);
		$where = "appserverip IN(SELECT appserverip FROM apppub WHERE id IN(SELECT appid FROM appmember WHERE memberid=".$_SESSION['ADMIN_UID'].") OR id IN(SELECT appid FROM appgroup WHERE groupid=".($_SESSION['ADMIN_GROUP']?$_SESSION['ADMIN_GROUP']:0)."))";

		$total = $this->appserver_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->appserver_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$where,'appserverip', 'ASC');
		
		$newpager = new my_pager($total, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);

		$this->assign('alldev', $alldev);
		$this->display('usrapppubdev.tpl');
	}

	function appdev_login(){
		global $_CONFIG;

		$rdptype = get_request('rdptype', 0, 1);
		$appid = get_request('id', 0, 1);
		$selectedip = get_request('selectedip', 0, 1);
		$app_act = get_request('app_act', 0, 1);
		$screen = get_request('screen', 0 ,1);
		$this->assign("activex_version", $_CONFIG['ACTIVEX_VERSION']);
		$str = genRandomString(8);
		$appserver = $this->appserver_set->select_by_id($appid);
		$this->assign("screen", $screen);
		$this->assign("port", 80);
		$this->assign("app_act",$app_act);
		$this->assign('ip',$appserver['appserverip']);
		$this->assign('localhost', $selectedip);
		$this->assign("id", $appid);
		$this->assign("autorun", $_CONFIG['apppub_AUTORUN']);
		$dynamic_pwd = $this->radkey_set->get_ran_radkey($_SESSION['ADMIN_USERNAME']);
		$this->assign("dynamic_pwd",$dynamic_pwd);
		if($type=='gateway' || $type=='fort' ){
			$this->assign("dynamic_pwd",'');
		}
		if($rdptype=='activex'){
			$this->assign('username',$_SESSION['ADMIN_USERNAME'].'--'.$appid.'--'.$str);
			$this->assign('password',$str.'--');
			$this->assign('sid',$appid.'--'.$str);
			$this->display('rdplogin_activex.tpl');
		}else{			
			$this->assign('username',$_SESSION['ADMIN_USERNAME'].'--'.$appid.'--'.$str);
			$this->assign('password',$str.'--');
			$this->assign('sid',$appid.'--'.$str);
			$this->display('WebSysbaseOraclelogin_mstsc.tpl');
		}
		
	}

	function apppub_list(){
		$page_num = get_request('page');

		$where = " id IN(SELECT appid FROM appmember WHERE memberid=".$_SESSION['ADMIN_UID'].") OR id IN(SELECT appid FROM appgroup WHERE groupid=".($_SESSION['ADMIN_GROUP']?$_SESSION['ADMIN_GROUP']:0).")";

		$total = $this->apppub_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->apppub_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$where,'appserverip', 'ASC');
		
		$newpager = new my_pager($total, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);

		$this->assign('apppub', $alldev);
		$this->display('viewapppub.tpl');
	}

	function login_tip(){
		$config = $this->setting_set->select_all(" sname='password_policy'");
		$pwdconfig = unserialize($config[0]['svalue']);
		$pwdexpired = $pwdconfig['pwdexpired'];
		$member = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		$member['nextdateChpwd'] = date('Y-m-d H:i:s', $member['lastdateChpwd']+$pwdexpired*24*60*60);
		$member['lastdateChpwd'] = date('Y-m-d H:i:s', $member['lastdateChpwd']);
		
		$this->assign("member", $member);
		$this->assign("now", date('Y-m-d H:i:s'));
		$this->display("login_tip.tpl");

	}

	function chpwd(){
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'device_ip';
		}
		if(strcasecmp($orderby2, 'desc') != 0 ) {
			$orderby2 = 'desc';
		}else{
			$orderby2 = 'asc';
		}
		$this->assign("orderby2", $orderby2);

		$sql = "SELECT devicesid FROM ".$this->luser_set->get_table_name()." WHERE memberid=".$_SESSION['ADMIN_UID'];
		$sql .= " UNION SELECT devicesid FROM ".$this->lgroup_set->get_table_name()." WHERE groupid=".$_SESSION['ADMIN_GROUP'];
		$sql .= " UNION  SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->luser_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE  a.memberid=".$_SESSION['ADMIN_UID'].")";
		$sql .= " UNION SELECT devicesid FROM ".$this->resgroup_set->get_table_name()." WHERE groupname IN (SELECT b.groupname FROM ".$this->lgroup_resourcegrp_set->get_table_name()." a LEFT JOIN ".$this->resgroup_set->get_table_name()." b ON a.resourceid=b.id WHERE a.groupid=".$_SESSION['ADMIN_GROUP'].")";
		$alldevid = $this->member_set->base_select($sql);
		$alltem = $this->tem_set->select_all();
		$alldevsid = array();
		for($i=0; $i<count($alldevid); $i++){
			$alldevsid[]=$alldevid[$i]['devicesid'];
		}
		if(empty($alldevsid)){
			$alldevsid[]=0;
		}
		$where = " id IN(".implode(",", $alldevsid).") AND entrust_password=1 AND radiususer=0 AND login_method!=26 AND publickey_auth=0";
		$total = $this->devpass_set->select_count($where);
		$newpager = new my_pager($total, $page_num, 20, 'page');
		$alldev = $this->devpass_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$where, $orderby1, $orderby2);

		$row_num = count($alldev);
		for($i=0;$i<$row_num;$i++) {
			foreach($alltem as $tem) {
				if($alldev[$i]['login_method'] == $tem['id']) {
					$alldev[$i]['login_method'] = $tem['login_method'];
				}
				elseif($alldev[$i]['device_type'] == $tem['id']) {
					$alldev[$i]['device_type'] = $tem['device_type'];
				}
			}
		}

		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);

		



		$this->assign('alldev', $alldev);
		$this->display('chpwd.tpl');
	}

	function chpwd_save(){
		global $_CONFIG;
		$selected_id = get_request('selected_id');
		$single = get_request('single');

		if($single){
			$id = $_POST['id'][$selected_id];
			$old_password = $_POST['old_password'][$selected_id];
			$new_password = $_POST['new_password'][$selected_id];
			if(empty($new_password)){
				alert_and_back("请输入新密码");
				exit;
			}
			if($row=$this->devpass_set->select_count("cur_password='".$this->devpass_set->udf_encrypt($old_password)."' AND id=$id")==0){
				alert_and_back("输入的原密码错误");
				exit;
			}
			$old_dev = $this->devpass_set->select_by_id($id);
			$newdevice = new devpass();
			$newdevice->set_data('id', $id);
			$newdevice->set_data("old_password", $old_dev['cur_password']);
			$newdevice->set_data("cur_password", $this->devpass_set->udf_encrypt($new_password));
			$newdevice->set_data("last_update_time", date('Y-m-d H:i:s'));
			$this->devpass_set->edit($newdevice);

			$adminlog = new admin_log();
			$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
			$adminlog->set_data('action', language('修改系统用户密码'));
			$adminlog->set_data('resource', $old_dev['device_ip']);
			$adminlog->set_data('resource_user', $old_dev['username']);
			$adminlog->set_data('type', 13);
			$this->admin_log_set->add($adminlog);

			alert_and_back("修改成功");
		}else{
			$msg = "";
			for($i=0; $i<count($_POST['id']); $i++){
				$id = $_POST['id'][$i];
				$old_password = $_POST['old_password'][$i];
				$new_password = $_POST['new_password'][$i];

				if($old_password || $new_password){

					$updatestatus =1;
					$smsg = "设备:".$_POST['id'][$i];
					if(empty($new_password)){
						$smsg .= ",无原始密码";
						$updatestatus = 0;
					}
					if($row=$this->devpass_set->select_count("cur_password='".$this->devpass_set->udf_encrypt($old_password)."' AND id=$id")==0){
						$smsg .= ",原始密码不正确";
						$updatestatus = 0;
					}					
					if($updatestatus == 1){
						$old_dev = $this->devpass_set->select_by_id($id);
						$newdevice = new devpass();
						$newdevice->set_data('id', $id);
						$newdevice->set_data("old_password", $old_dev['cur_password']);
						$newdevice->set_data("cur_password", $this->devpass_set->udf_encrypt($new_password));
						$newdevice->set_data("last_update_time", date('Y-m-d H:i:s'));
						$this->devpass_set->edit($newdevice);
						
						$adminlog = new admin_log();
						$adminlog->set_data('administrator', $_SESSION['ADMIN_USERNAME']);
						$adminlog->set_data('action', language('修改系统用户密码'));
						$adminlog->set_data('resource', $old_dev['device_ip']);
						$adminlog->set_data('resource_user', $old_dev['username']);
						$adminlog->set_data('type', 13);
						$this->admin_log_set->add($adminlog);

					}else{
						$msg .= $smsg.'\n';
					}
				}
			}
			if(!empty($msg)){
				//var_dump($msg);
				alert_and_back("部分没有更新:\\n".$msg);
				exit;
			}else{
				alert_and_back("修改成功");
				exit;
			}
		}
		
		//
	}

	function getpwd(){
		global $_CONFIG;
		$ac = get_request("ac", 1, 1);
		$username = get_request("username", 1, 1);
		$email = get_request("email", 1, 1);
		$_SESSION["POST"]=$_POST;
		if($ac=='get'){
			if(empty($username)||empty($email)){
				alert_and_back('请完整的填写信息');
				exit;
			}
			$user = $this->member_set->select_all("username = '" . $username . "' AND email='".$email."'");
			$user = $user[0];
			if(empty($user)){
				alert_and_back('你填写的信息有误');
				exit;
			}
			$password = genRandomPassword(8);
			if($_CONFIG['crypt']==1){
				$password = encrypt($password);
			}
			$newmember = new member();
			$newmember->set_data('uid', $user['uid']);
			$newmember->set_data('password', $this->member_set->udf_encrypt($password));
			$this->member_set->edit($newmember);

			$old_radius = $this->radius_set->select_all("UserName = '".$user['username']."'");
			$new_radius = new radius();
			$new_radius->set_data("id",$old_radius[0]['id']);
			$new_radius->set_data("Value",crypt($password,"\$1\$qY9g/6K4"));
			$newmember->set_data('lastdateChpwd', time());		
			$this->radius_set->edit($new_radius);
			
			$ha = $this->config_set->base_select("SELECT * FROM alarm LIMIT 1");
			$smtp = new smtp_mail($ha[0]['MailServer'],"25",$ha[0]['account'],$ha[0]['password'], false);
			$smtp->send($ha[0]['account'],$user['email'],$_CONFIG['site']['title']." 重置密码",($username).",你好:\n  您的新密码是:".$password);
			alert_and_back('密码修改成功,请查阅邮箱', 'admin.php?controller=admin_index&action=login');
		}
		$this->display("getpwd.tpl");
	}

	function get_sms(){
		global $_CONFIG;
		$uid = get_request('uid');
		$user = $this->member_set->select_by_id($uid);
		if($user['auth']!=2){
			alert_and_close('错误，请重新登录');
			exit;
		}
		$smspassword = mt_rand(100000, 999999);
		$newmem = new member();
		$newmem->set_data('uid', $uid);
		$newmem->set_data('smspassword', $smspassword);
		$newmem->set_data('smstime', date('Y-m-d H:i:s'));
		$this->member_set->edit($newmem);
		/*$url = 'http://192.168.4.71:8080/smsServer/service.action?branch_no=10&password=010&depart_no=10001&message_type=1&batch_no=4324&priority=1&sp_no=955589903&mobile_type=1&mobile_tel='.$user['mobilenum'].'&message='.urlencode(iconv("UTF-8", "GBK", '堡垒机登录短信验证码:')).$smspassword.'';
		$c = file_get_contents($url);
		if($c==0) 
		echo '发送成功';
		else
		echo '发送失败,请重试或联系管理员';
		*/
		if($_CONFIG['SMS_ID']==1){
			$param = array(
						"strUsername"=>$_CONFIG['SMS'][1]['USERNAME'], 
						"strUserPwd"=>$_CONFIG['SMS'][1]['PWD'], 
						"strMobiles"=>$user['mobilenum'], 
						"strTitle"=>"【运维审计平台】,您的堡垒机登录短信验证码是:".$smspassword, 		
			);
			
			$client = new SoapClient($_CONFIG['SMS'][1]['WSDL']);
			//$client = new SoapClient('http://180.169.69.40:5581/DTAS/api/Authentication?wsdl');
			var_dump($param);
			$i=$client->sendSM($param);var_dump($i);
			if(strtolower($i->sendSMResult)=='ok'){
				echo '<script>alert("发送成功");</script>';
			}else{
				echo '<script>alert("发送失败，请联系管理员");</script>';
			}
		}elseif($_CONFIG['SMS_ID']==2){
			$doc = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
			$doc .= "<ROOT>\n";
			$doc .= "<SendSm>\n";
			$doc .= "<phone>" . $user['mobilenum'] . "</phone>\n";
			$doc .= "<content>" . "【运维审计平台】,您的堡垒机登录短信验证码是:".$smspassword . "</content>\n";
			//$doc .= "<sendTime>".date('Y-m-d H:i:s', mktime(date('H'),date('i')+5,date('s'),date('m'),date('d'),date('Y')))."</sendTime>\n";
			$doc .= "<sendTime></sendTime>\n";
			$doc .= "</SendSm>\n";
			$doc .= "</ROOT>\n";
			$param = array(
						"jkxlh"=>$_CONFIG['SMS'][2]['jkxlh'], 
						"smXmlDoc"=>$doc
			);
			var_dump($param);
			var_dump(simplexml_load_string($doc));
			$client = new SoapClient($_CONFIG['SMS'][2]['WSDL']);
			//$client = new SoapClient('http://180.169.69.40:5581/DTAS/api/Authentication?wsdl');
			
			$i=$client->sendSm($_CONFIG['SMS'][2]['jkxlh'],$doc);
			$i = simplexml_load_string($i);
			//var_dump($i);
			if($i->HEAD->RESULT=='成功'&&intval($i->HEAD->ROW)>0){
				echo '<script>alert("发送成功");</script>';
			}else{
				echo '<script>alert("发送失败，请联系管理员");</script>';
			}
		}else{
			require_once 'include/sms.php';
			$body = createBasicAuthData();
			// 在基本认证参数的基础上添加短信内容和发送目标号码的参数
			$body['smsContent'] = "【运维审计平台】,您的堡垒机登录短信验证码是:".$smspassword;
			$body['to'] = $user['mobilenum'];
				
			// 提交请求
			$result = post($GLOBALS['funAndOperate'], $body);
			var_dump($result);
		}

	}

	function rdpfile_mremote($sgroup,$baoleijiip, $port, $psd){//echo '<pre>';var_dump($sgroup);echo '</pre>';
		$str = "<Node Name=\"".$sgroup['groupname']."\" Type=\"Container\" Expanded=\"False\" Descr=\"\" Icon=\"mRemoteNG\" Panel=\"常规\" Username=\"\" Domain=\"\" Password=\"\" Hostname=\"\" Protocol=\"RDP\" PuttySession=\"Default Settings\" Port=\"3389\" ConnectToConsole=\"False\" UseCredSsp=\"True\" RenderingEngine=\"IE\" ICAEncryptionStrength=\"EncrBasic\" RDPAuthenticationLevel=\"NoAuth\" LoadBalanceInfo=\"\" Colors=\"Colors16Bit\" Resolution=\"FitToWindow\" AutomaticResize=\"True\" DisplayWallpaper=\"False\" DisplayThemes=\"False\" EnableFontSmoothing=\"False\" EnableDesktopComposition=\"False\" CacheBitmaps=\"True\" RedirectDiskDrives=\"False\" RedirectPorts=\"False\" RedirectPrinters=\"False\" RedirectSmartCards=\"False\" RedirectSound=\"DoNotPlay\" RedirectKeys=\"False\" Connected=\"False\" PreExtApp=\"\" PostExtApp=\"\" MacAddress=\"\" UserField=\"\" ExtApp=\"\" VNCCompression=\"CompNone\" VNCEncoding=\"EncHextile\" VNCAuthMode=\"AuthVNC\" VNCProxyType=\"ProxyNone\" VNCProxyIP=\"\" VNCProxyPort=\"0\" VNCProxyUsername=\"\" VNCProxyPassword=\"\" VNCColors=\"ColNormal\" VNCSmartSizeMode=\"SmartSAspect\" VNCViewOnly=\"False\" RDGatewayUsageMethod=\"Never\" RDGatewayHostname=\"\" RDGatewayUseConnectionCredentials=\"Yes\" RDGatewayUsername=\"\" RDGatewayPassword=\"\" RDGatewayDomain=\"\" InheritCacheBitmaps=\"False\" InheritColors=\"False\" InheritDescription=\"False\" InheritDisplayThemes=\"False\" InheritDisplayWallpaper=\"False\" InheritEnableFontSmoothing=\"False\" InheritEnableDesktopComposition=\"False\" InheritDomain=\"False\" InheritIcon=\"False\" InheritPanel=\"False\" InheritPassword=\"False\" InheritPort=\"False\" InheritProtocol=\"False\" InheritPuttySession=\"False\" InheritRedirectDiskDrives=\"False\" InheritRedirectKeys=\"False\" InheritRedirectPorts=\"False\" InheritRedirectPrinters=\"False\" InheritRedirectSmartCards=\"False\" InheritRedirectSound=\"False\" InheritResolution=\"False\" InheritAutomaticResize=\"False\" InheritUseConsoleSession=\"False\" InheritUseCredSsp=\"False\" InheritRenderingEngine=\"False\" InheritUsername=\"False\" InheritICAEncryptionStrength=\"False\" InheritRDPAuthenticationLevel=\"False\" InheritLoadBalanceInfo=\"False\" InheritPreExtApp=\"False\" InheritPostExtApp=\"False\" InheritMacAddress=\"False\" InheritUserField=\"False\" InheritExtApp=\"False\" InheritVNCCompression=\"False\" InheritVNCEncoding=\"False\" InheritVNCAuthMode=\"False\" InheritVNCProxyType=\"False\" InheritVNCProxyIP=\"False\" InheritVNCProxyPort=\"False\" InheritVNCProxyUsername=\"False\" InheritVNCProxyPassword=\"False\" InheritVNCColors=\"False\" InheritVNCSmartSizeMode=\"False\" InheritVNCViewOnly=\"False\" InheritRDGatewayUsageMethod=\"False\" InheritRDGatewayHostname=\"False\" InheritRDGatewayUseConnectionCredentials=\"False\" InheritRDGatewayUsername=\"False\" InheritRDGatewayPassword=\"False\" InheritRDGatewayDomain=\"False\">\n";
		for($i=0; $i<count($this->allsgroup); $i++){//var_dump($this->allsgroup[$i]['groupname']);
			if($this->allsgroup[$i]['id']&&$sgroup['id']==$this->allsgroup[$i]['ldapid']){
				$str.= $this->rdpfile_mremote($this->allsgroup[$i],$baoleijiip, $port, $psd);//echo '<br>';
			}
		}
		for($n=0; $n<count($sgroup['servers']); $n++){
			$row1=$sgroup['servers'][$n];
			$str .=  '<Node Name="'.($m_bydomain ? $row1['hostname']:$row1['device_ip']).'" Type="Connection" Descr="" Icon="mRemote" Panel="General" Username="'.$row1['username'].'--'.$row1['id'].'" Domain="" Password="'.$psd.'" Hostname="'.$baoleijiip.'" Protocol="RDP" PuttySession="Default Settings" Port="'.$port.'" ConnectToConsole="False" RenderingEngine="IE" ICAEncryptionStrength="EncrBasic" RDPAuthenticationLevel="NoAuth" Colors="Colors16Bit" Resolution="FitToWindow" DisplayWallpaper="False" DisplayThemes="False" CacheBitmaps="True" RedirectDiskDrives="False" RedirectPorts="False" RedirectPrinters="False" RedirectSmartCards="False" RedirectSound="DoNotPlay" RedirectKeys="False" Connected="False" PreExtApp="" PostExtApp="" MacAddress="" UserField="" ExtApp="" VNCCompression="CompNone" VNCEncoding="EncHextile" VNCAuthMode="AuthVNC" VNCProxyType="ProxyNone" VNCProxyIP="" VNCProxyPort="0" VNCProxyUsername="" VNCProxyPassword="" VNCColors="ColNormal" VNCSmartSizeMode="SmartSAspect" VNCViewOnly="False" InheritCacheBitmaps="False" InheritColors="False" InheritDescription="False" InheritDisplayThemes="False" InheritDisplayWallpaper="False" InheritDomain="False" InheritIcon="False" InheritPanel="False" InheritPassword="False" InheritPort="False" InheritProtocol="False" InheritPuttySession="False" InheritRedirectDiskDrives="False" InheritRedirectKeys="False" InheritRedirectPorts="False" InheritRedirectPrinters="False" InheritRedirectSmartCards="False" InheritRedirectSound="False" InheritResolution="False" InheritUseConsoleSession="False" InheritRenderingEngine="False" InheritUsername="False" InheritICAEncryptionStrength="False" InheritRDPAuthenticationLevel="False" InheritPreExtApp="False" InheritPostExtApp="False" InheritMacAddress="False" InheritUserField="False" InheritExtApp="False" InheritVNCCompression="False" InheritVNCEncoding="False" InheritVNCAuthMode="False" InheritVNCProxyType="False" InheritVNCProxyIP="False" InheritVNCProxyPort="False" InheritVNCProxyUsername="False" InheritVNCProxyPassword="False" InheritVNCColors="False" InheritVNCSmartSizeMode="False" InheritVNCViewOnly="False" />'."\n";
		}
		$str .= "</Node>\n";
		return $str;
	}

	function createrdpfile(){
		global $_CONFIG;
		$tool = get_request("tool", 0, 1);
		$psd = get_request("psd", 1, 1);
		$port = get_request("port", 1, 0);
		$template = get_request("template", 1, 0);
		$m_bydomain = get_request("m_bydomain", 1, 0);
		$r_bydomain = get_request("r_bydomain", 1, 0);
		$s_bydomain = get_request("s_bydomain", 1, 0);
		$x_bydomain = get_request("x_bydomain", 1, 0);

		$baoleijiip = get_request("baoleijiip", 1, 1);
		$eth0 = $this->get_eth0_ip();
		$eth0 = $eth0['eth0'];
		
		$sql = "SELECT uid,username,groupid FROM member where uid=".$_SESSION['ADMIN_UID'];
		$rs = mysql_query($sql) or die(mysql_error());
		$sgroups = array();
		if($_GET['tool']=='mremote'){
			$str = '<?xml version="1.0" encoding="utf-8"?>'."\n";
			$str .= '<Connections Name="Connections" Export="False" Protected="V859XVQWq9JS5+BO6z6ZYPXJVuQVwCvgaKZLm65IFNXAHDLWTAOtHla5rcluX+YH" ConfVersion="2.1">'."\n";
			while($row=mysql_fetch_array($rs)){
				$sql1 = 'SELECT devicesid FROM luser WHERE memberid='.$row['uid'].' UNION SELECT devicesid FROM lgroup WHERE groupid='.$row['groupid'].' UNION SELECT devicesid FROM resourcegroup WHERE groupname IN (SELECT b.groupname FROM luser_resourcegrp a LEFT JOIN resourcegroup b ON a.resourceid=b.id WHERE a.memberid='.$row['uid'].') UNION SELECT devicesid FROM resourcegroup WHERE groupname IN (SELECT b.groupname FROM lgroup_resourcegrp a LEFT JOIN resourcegroup b ON a.resourceid=b.id WHERE a.groupid='.$row['groupid'].') union select distinct devices.id devicesid from luser_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and a.memberid='.$row['uid'].' and t.groupid and t.groupid=s.groupid AND IF(t.username=\'0\', 1, t.username=devices.username) union select distinct devices.id devicesid from lgroup_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and a.groupid='.$row['groupid'].' and t.groupid and t.groupid=s.groupid AND IF(t.username=\'0\', 1, t.username=devices.username) ';	
				$sql = "SELECT devices.id,devices.device_ip,devices.hostname,g.id groupid, g.groupname,g.level,g.ldapid FROM `devices`  LEFT JOIN (".$sql1.") d ON devices.id=d.devicesid LEFT JOIN servers ON devices.device_ip=servers.device_ip AND devices.hostname=servers.hostname LEFT JOIN `servergroup` g ON servers.groupid=g.id WHERE d.devicesid IS NOT NULL AND (devices.login_method=8 or devices.login_method=21) ORDER BY IF(g.level=0,3,g.level) ASC, g.groupname ASC, devices.device_ip ASC";
				$rs1 = mysql_query($sql) or die(mysql_error());
				
				while($row1=mysql_fetch_assoc($rs1)){
					$row1['username']=$row['username'];
					$found=0;
					for($i=0; $i<count($sgroups); $i++){
						if($sgroups[$i]['groupid']==$row1['groupid']){
							$found = 1;
							$sgroups[$i]['servers'][]=$row1;
							break;
						}
					}
					if(!$found){
						$ct = count($sgroups);
						$sgroups[$ct]['username']=$row['username'];
						$sgroups[$ct]['groupid']=$row1['groupid'];
						$sgroups[$ct]['id']=$row1['groupid'];
						$sgroups[$ct]['level']=$row1['level'];
						$sgroups[$ct]['ldapid']=$row1['ldapid'];
						$sgroups[$ct]['groupname']=(empty($row1['groupname']) ? '未分组' : $row1['groupname']);
						$sgroups[$ct]['servers'][]=$row1;
					}
				}
			}
			$psgroups = array();
			$psgroupsid = array();
			for($i=0; $i<count($sgroups); $i++){
				$_sgroup = $sgroups[$i];
				while($_sgroup['ldapid']&&!in_array($_sgroup['ldapid'],$psgroupsid)){
					$_sgroup=$this->sgroup_set->select_by_id($_sgroup['ldapid']);
					$_sgroup['groupid']=$_sgroup['id'];
					$_sgroup['count']=0;
					$psgroupsid[]=$_sgroup['id'];
					$psgroups[]=$_sgroup;
				}
			}
			for($i=0; $i<count($psgroups); $i++){
				$sgroups[]=$psgroups[$i];
			}
			$gps = array();
			$noldap = array();
			if($_CONFIG['LDAP']){
				$this->allsgroup=$sgroups;
				for($i=0; $i<count($this->allsgroup); $i++){
					if($this->allsgroup[$i]['ldapid']==0){
						$str.=$this->rdpfile_mremote($this->allsgroup[$i],$baoleijiip, $port, $psd);
					}
				}
				$sgroups=$this->allsgroup;
				$this->allsgroup=null;
			}
			//echo '<pre>';var_dump($sgroups);echo '</pre>';

			$str .= '</Connections>';
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=confCons.xml"); 
			echo $str;
			exit();
		}elseif($_GET['tool']=='rdcman'){
			$str = '<?xml version="1.0" encoding="utf-8"?>'."\n";
			$str .= '<version>1.42</version>'."\n";
			$str .= '<properties>'."\n";
			$str .= '<titleText>[C:\Users\cmas.ma\Desktop\x.rdg]</titleText>'."\n";
			$str .= '</properties>'."\n";
			$str .= '<group>'."\n";
			$str .= ' <properties>'."\n";
			$str .= '<name>Remote Desktops</name>'."\n";
			$str .= '<expanded>True</expanded>'."\n";
			$str .= '<inheritDisplay>True</inheritDisplay>'."\n";
			$str .= '<logonSettings inherit="FromParent" />'."\n";
			$str .= '<remoteDesktop inherit="FromParent" />'."\n";
			$str .= '<localResources inherit="FromParent" />'."\n";
			$str .= '</properties>'."\n";

			while($row=mysql_fetch_array($rs)){
				$sql1 = 'SELECT devicesid FROM luser WHERE memberid='.$row['uid'].' UNION SELECT devicesid FROM lgroup WHERE groupid='.$row['groupid'].' UNION SELECT devicesid FROM resourcegroup WHERE groupname IN (SELECT b.groupname FROM luser_resourcegrp a LEFT JOIN resourcegroup b ON a.resourceid=b.id WHERE a.memberid='.$row['uid'].') UNION SELECT devicesid FROM resourcegroup WHERE groupname IN (SELECT b.groupname FROM lgroup_resourcegrp a LEFT JOIN resourcegroup b ON a.resourceid=b.id WHERE a.groupid='.$row['groupid'].') union select distinct devices.id devicesid from luser_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and a.memberid='.$row['uid'].' and t.groupid and t.groupid=s.groupid AND IF(t.username=\'0\', 1, t.username=devices.username) union select distinct devices.id devicesid from lgroup_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and a.groupid='.$row['groupid'].' and t.groupid and t.groupid=s.groupid AND IF(t.username=\'0\', 1, t.username=devices.username)';	
				$sql = "SELECT devices.* FROM `devices` LEFT JOIN (".$sql1.") d ON devices.id=d.devicesid  WHERE d.devicesid IS NOT NULL   AND devices.login_method=8";
				$rs1 = mysql_query($sql) or die(mysql_error());
				while($row1=mysql_fetch_array($rs1)){
					$str .= '<server>'."\n";
					$str .= '<name>'.$baoleijiip.'</name>'."\n";
					$str .= '<displayName>'.($r_bydomain ? $row1['hostname']:$row1['device_ip']).'</displayName>'."\n";
					$str .= '<thumbnailScale>1</thumbnailScale>'."\n";
					$str .= '<logonSettings inherit="None">'."\n";
					$str .= '<userName>'.$row['username'].'--'.$row1['id'].'</userName>'."\n";
					$str .= '<password>'.$psd.'</password>'."\n";
					$str .= '<domain />'."\n";
					$str .= '<port>'.$port.'</port>'."\n";
					$str .= '<connectToConsole>False</connectToConsole>'."\n";
					$str .= '<startProgram />'."\n";
					$str .= '<workingDir />'."\n";
					$str .= '</logonSettings>'."\n";
					$str .= '<remoteDesktop inherit="FromParent" />'."\n";
					$str .= '<localResources inherit="FromParent" />'."\n";
					$str .= '</server>'."\n";
				}
			}   
			$str .= ' </group>'."\n";
			$str .= ' </RDCMan>'."\n";
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=rdcman.rdg"); 
			echo $str;
			exit();
		}elseif($_GET['tool']=='securecrt'){
			$term = get_request("term", 1, 1);
			$charset = get_request("charset", 1, 1);
			$colorscheme = get_request("colorscheme", 1, 1);
			if(!$template&&!is_uploaded_file($_FILES['crttemplate']['tmp_name'])){
				alert_and_back("请上传模版文件");
				exit;
			}
			
			$root = 'tmp/crtini/'.$_SESSION['ADMIN_USERNAME'];
			exec("rm -rf ".$root);
			if(!is_dir($root)){
				$cmd = "mkdir -p ".$root;
				exec($cmd);
			}
			if(!$template){
				$configfile = file($_FILES['crttemplate']['tmp_name']);
			}else{
				$configfile = file('include/securecrt'.$template.'.ini');
			}
			$alltem = $this->tem_set->select_all();
			while($row=mysql_fetch_array($rs)){
				$sql1 = 'SELECT devicesid FROM luser WHERE memberid='.$row['uid'].' UNION SELECT devicesid FROM lgroup WHERE groupid='.$row['groupid'].' UNION SELECT devicesid FROM resourcegroup WHERE groupname IN (SELECT b.groupname FROM luser_resourcegrp a LEFT JOIN resourcegroup b ON a.resourceid=b.id WHERE a.memberid='.$row['uid'].') UNION SELECT devicesid FROM resourcegroup WHERE groupname IN (SELECT b.groupname FROM lgroup_resourcegrp a LEFT JOIN resourcegroup b ON a.resourceid=b.id WHERE a.groupid='.$row['groupid'].') union select distinct devices.id devicesid from luser_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and a.memberid='.$row['uid'].' and t.groupid and t.groupid=s.groupid AND IF(t.username=\'0\', 1, t.username=devices.username) union select distinct devices.id devicesid from lgroup_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and a.groupid='.$row['groupid'].' and t.groupid and t.groupid=s.groupid AND IF(t.username=\'0\', 1, t.username=devices.username)';	
				$sql = "SELECT devices.*,g.groupname,g.id groupid FROM `devices` LEFT JOIN (".$sql1.") d ON devices.id=d.devicesid LEFT JOIN `servers` s ON devices.device_ip=s.device_ip LEFT JOIN `servergroup` g ON s.groupid=g.id WHERE d.devicesid IS NOT NULL AND (devices.login_method=3 or devices.login_method=5)";
				$rs1 = mysql_query($sql) or die(mysql_error());
				while($row1=mysql_fetch_array($rs1)){
					foreach($alltem as $tem) {
						if($row1['login_method'] == $tem['id']) {
							$row1['login_method'] = $tem['login_method'];
						}
					}
					$tmp_file = $configfile;
					for($i=0; $i<count($tmp_file); $i++){
						if(strstr(strtoupper($tmp_file[$i]), '"HOSTNAME"'))
						{
							$tmp = explode("=", $tmp_file[$i]);
							$tmp_file[$i] = $tmp[0].'='.$baoleijiip."\r\n";
						}
						if(strstr(strtoupper($tmp_file[$i]), '"USERNAME"'))
						{
							$tmp = explode("=", $tmp_file[$i]);
							$tmp_file[$i] = $tmp[0].'='.$row['username'].'--'.$row1['id']."\r\n";
						}
						if(strstr(strtoupper($tmp_file[$i]), '"[SSH2] PORT"'))
						{
							$tmp = explode("=", $tmp_file[$i]);
							$tmp_file[$i] = $tmp[0].'='.dechex($port)."\r\n";
						}
						if(strstr(strtoupper($tmp_file[$i]), strtoupper('"Emulation"')))
						{
							$tmp = explode("=", $tmp_file[$i]);
							$tmp_file[$i] = $tmp[0].'='.$term."\r\n";
						}
						if(strstr(strtoupper($tmp_file[$i]), strtoupper('"Color Scheme"')))
						{
							$tmp = explode("=", $tmp_file[$i]);
							$tmp_file[$i] = $tmp[0].'='.$colorscheme."\r\n";
						}
						if(strstr(strtoupper($tmp_file[$i]), strtoupper('"Output Transformer Name"')))
						{
							$tmp = explode("=", $tmp_file[$i]);
							$tmp_file[$i] = $tmp[0].'='.$charset."\r\n";
						}
					}
					$filename = ($s_bydomain ? $row1['hostname']:$row1['device_ip']).'_'.$row1['login_method'].$row1['port'].'_'.(empty($row1['username']) ? 'NULL' : $row1['username']).'.ini';
					$row1['groupname'] = str_replace(" ","-",$row1['groupname']);
					if($row1['groupid']){
						//$root1 = iconv("UTF-8", "GB2312", $row1['groupname']);
						$root1 = $row1['groupname'];
						$_sgroup = $this->sgroup_set->select_by_id($row1['groupid']);
						while($_sgroup['ldapid']){
							$_sgroup =$this->sgroup_set->select_by_id($_sgroup['ldapid']);
							$root1 = $_sgroup['groupname'].'/'.$root1;
						}
						$root1 = $root."/".$root1;
						//$root1 = iconv("UTF-8", "GB2312", $root1);
						dump(!is_dir($root1));
						if(!is_dir($root1)){
							exec('mkdir -p "'.$root1.'"');
						}
						$file = $root1.'/'.$filename;
					}else{
						$file = $root.'/'.$filename;
					}
					exec("touch ".$file);
					$this->Array2File($tmp_file, $file);
					$tmp_file = "";
				}
			}
			exec("rm -f $root/../".$_SESSION['ADMIN_USERNAME'].".zip");
			//exec("zip -q -r -D tmp/".$_SESSION['ADMIN_USERNAME'].".zip ".$root);
			$phpstr = "<?php\r\nsession_start();\r\nexec(\"zip -q -r -D \".\$_SESSION['ADMIN_USERNAME'].\".zip \".\$_SESSION['ADMIN_USERNAME']);\r\nHeader('Cache-Control: private, must-revalidate, max-age=0');\r\nHeader(\"Content-type: application/octet-stream\");\r\n Header(\"Content-Disposition: attachment; filename=\".\$_SESSION['ADMIN_USERNAME'].\".zip\");\r\necho file_get_contents(\$_SESSION['ADMIN_USERNAME'].\".zip\");\r\nexit();\r\n?>\r\n";

			$phpstr = "<?php\r\nsession_start();\r\nexec(\"zip -q -r -D \".\$_SESSION['ADMIN_USERNAME'].\".zip \".\$_SESSION['ADMIN_USERNAME']);\r\nHeader('Location: '.\$_SESSION['ADMIN_USERNAME'].'.zip');\r\nexit();\r\n?>\r\n";

			if(!file_exists("$root/../zipphp.php"))
				$this->Array2File(array($phpstr), "$root/../zipphp.php");
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=rdcman.rdg"); 
			echo $str;
			*/
			
			go_url("$root/../zipphp.php");
			exit();
		}elseif($_GET['tool']=='xshell'){
			if(!$template&&!is_uploaded_file($_FILES['xshelltemplate']['tmp_name'])){
				alert_and_back("请上传模版文件");
				exit;
			}
			
			$root = 'tmp/xshellini/'.$_SESSION['ADMIN_USERNAME'];
			exec("rm -rf ".$root);
			if(!is_dir($root)){
				$cmd = "mkdir -p ".$root;
				exec($cmd);
			}
			if(!$template){
				$configfile = file($_FILES['xshelltemplate']['tmp_name']);
			}else{
				$configfile = file('include/xshell'.$template.'.xsh');
			}
			$alltem = $this->tem_set->select_all();
			while($row=mysql_fetch_array($rs)){
				$sql1 = 'SELECT devicesid FROM luser WHERE memberid='.$row['uid'].' UNION SELECT devicesid FROM lgroup WHERE groupid='.$row['groupid'].' UNION SELECT devicesid FROM resourcegroup WHERE groupname IN (SELECT b.groupname FROM luser_resourcegrp a LEFT JOIN resourcegroup b ON a.resourceid=b.id WHERE a.memberid='.$row['uid'].') UNION SELECT devicesid FROM resourcegroup WHERE groupname IN (SELECT b.groupname FROM lgroup_resourcegrp a LEFT JOIN resourcegroup b ON a.resourceid=b.id WHERE a.groupid='.$row['groupid'].') union select distinct devices.id devicesid from luser_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and a.memberid='.$row['uid'].' and t.groupid and t.groupid=s.groupid AND IF(t.username=\'0\', 1, t.username=devices.username) union select distinct devices.id devicesid from lgroup_resourcegrp a left join (select a.id,b.groupid,b.username from resourcegroup a left join resourcegroup b on a.groupname=b.groupname where a.devicesid=0 and b.devicesid=-1 ) t on a.resourceid=t.id left join servers s on s.groupid=t.groupid left join devices on devices.device_ip=s.device_ip where t.id and a.groupid='.$row['groupid'].' and t.groupid and t.groupid=s.groupid AND IF(t.username=\'0\', 1, t.username=devices.username)';	
				$sql = "SELECT devices.*,g.groupname,g.id groupid FROM `devices` LEFT JOIN (".$sql1.") d ON devices.id=d.devicesid LEFT JOIN `servers` s ON devices.device_ip=s.device_ip LEFT JOIN `servergroup` g ON s.groupid=g.id WHERE d.devicesid IS NOT NULL AND (devices.login_method=3 or devices.login_method=5)";
				$rs1 = mysql_query($sql) or die(mysql_error());
				while($row1=mysql_fetch_array($rs1)){
					foreach($alltem as $tem) {
						if($row1['login_method'] == $tem['id']) {
							$row1['login_method'] = $tem['login_method'];
						}
					}
					$tmp_file = $configfile;
					for($i=0; $i<count($tmp_file); $i++){
						if(strstr(strtoupper($tmp_file[$i]), 'HOST'))
						{
							$tmp = explode("=", $tmp_file[$i]);
							$tmp_file[$i] = $tmp[0].'='.$baoleijiip."\r\n";
						}
						if(strstr(strtoupper($tmp_file[$i]), 'USERNAME'))
						{
							$tmp = explode("=", $tmp_file[$i]);
							$tmp_file[$i] = $tmp[0].'='.$_SESSION['ADMIN_USERNAME'].'--'.$row1['id']."\r\n";
						}
						if(strstr(strtoupper($tmp_file[$i]), 'PORT'))
						{
							$tmp = explode("=", $tmp_file[$i]);
							$tmp_file[$i] = $tmp[0].'='.$port."\r\n";
						}
					}
					$filename = ($x_bydomain ? $row1['hostname']:$row1['device_ip']).'_'.$row1['login_method'].$row1['port'].'_'.(empty($row1['username']) ? 'NULL' : $row1['username']).'.xsh';
					$row1['groupname'] = str_replace(" ","-",$row1['groupname']);
					if($row1['groupname']){
						$root1 = $row1['groupname'];
						$_sgroup = $this->sgroup_set->select_by_id($row1['groupid']);
						while($_sgroup['ldapid']){
							$_sgroup =$this->sgroup_set->select_by_id($_sgroup['ldapid']);
							$root1 = $_sgroup['groupname'].'/'.$root1;
						}
						$root1 = $root."/".$root1;
						$root1 = iconv("UTF-8", "GB2312", $root1);
						if(!is_dir($root1)){
							exec('mkdir -p "'.$root1.'"');
						}
						$file = $root1.'/'.$filename;

					}else{
						$file = $root.'/'.$filename;
					}
					exec("touch ".$file);
					$this->Array2File($tmp_file, $file);
					$tmp_file = "";
				}
			}
			exec("rm -f $root/../".$_SESSION['ADMIN_USERNAME'].".zip");
			//exec("zip -q -r -D tmp/".$_SESSION['ADMIN_USERNAME'].".zip ".$root);
			$phpstr = "<?php\r\nsession_start();\r\nexec(\"zip -q -r -D \".\$_SESSION['ADMIN_USERNAME'].\".zip \".\$_SESSION['ADMIN_USERNAME']);\r\nHeader('Cache-Control: private, must-revalidate, max-age=0');\r\nHeader(\"Content-type: application/octet-stream\");\r\n Header(\"Content-Disposition: attachment; filename=\".\$_SESSION['ADMIN_USERNAME'].\".zip\");\r\necho file_get_contents(\$_SESSION['ADMIN_USERNAME'].\".zip\");\r\nexit();\r\n?>\r\n";

			$phpstr = "<?php\r\nsession_start();\r\nexec(\"zip -q -r -D \".\$_SESSION['ADMIN_USERNAME'].\".zip \".\$_SESSION['ADMIN_USERNAME']);\r\nHeader('Location: '.\$_SESSION['ADMIN_USERNAME'].'.zip');\r\nexit();\r\n?>\r\n";
			if(!file_exists("$root/../zipphp.php"))
				$this->Array2File(array($phpstr), "$root/../zipphp.php");
			/*
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=rdcman.rdg"); 
			echo $str;
			*/
			
			go_url("$root/../zipphp.php");
			exit();
		}
		$this->assign("eth0", $eth0);
		$this->display("createrdpfile.tpl");
	}

	function changerole(){
		$user = $this->member_set->select_by_id($_SESSION['ADMIN_UID']);
		if($user['common_user_pri']||$user['passwd_user_pri']||$user['audit_user_pri']){
			$level = get_request('level', 0, 1);
			if($level==0&&$user['common_user_pri']){
				$_SESSION['ADMIN_LEVEL'] = '0';
				$_SESSION['ADMIN_CHROLE_LEVEL'] = '0';
				alert_and_back('切换角色','admin.php?controller=admin_index');
				exit;
			}if($level==2&&$user['audit_user_pri']){
				$_SESSION['ADMIN_LEVEL'] = '2';
				$_SESSION['ADMIN_CHROLE_LEVEL'] = '2';
				alert_and_back('切换角色','admin.php?controller=admin_index');
				exit;
			}if($level==10&&$user['passwd_user_pri']){
				$_SESSION['ADMIN_LEVEL'] = '10';
				$_SESSION['ADMIN_CHROLE_LEVEL'] = '10';
				alert_and_back('切换角色','admin.php?controller=admin_index');
				exit;
			}elseif($user['level']==$level){
				$_SESSION['ADMIN_LEVEL'] = $level;
				$_SESSION['ADMIN_CHROLE_LEVEL'] = $level;
				alert_and_back('切换角色','admin.php?controller=admin_index');
				exit;
			}			
		}
	}

	function changelogo(){
		if(is_uploaded_file($_FILES['login_logo']['tmp_name']) || is_uploaded_file($_FILES['top_logo']['tmp_name']) || is_uploaded_file($_FILES['android']['tmp_name']) || is_uploaded_file($_FILES['ios']['tmp_name'])){
			if(is_uploaded_file($_FILES['login_logo']['tmp_name'])){
				if(!move_uploaded_file($_FILES['login_logo']['tmp_name'], 'logo/logo1.jpg')){
					$err[]='上传登录页面logo失败\n';
				}
			}
			if(is_uploaded_file($_FILES['top_logo']['tmp_name'])){
				if(!move_uploaded_file($_FILES['top_logo']['tmp_name'], 'logo/02.jpg')){
					$err[]='上传内页logo失败\n';
				}
			}
			if(is_uploaded_file($_FILES['android']['tmp_name'])){
				if(!move_uploaded_file($_FILES['android']['tmp_name'], 'logo/android.jpg')){
					$err[]='上传安卓码扫描码失败\n';
				}
			}
			if(is_uploaded_file($_FILES['ios']['tmp_name'])){
				if(!move_uploaded_file($_FILES['ios']['tmp_name'], 'logo/ios.jpg')){
					$err[]='上传苹果扫描码失败\n';
				}
			}
			if(empty($err)){
				alert_and_back('操作成功', 'admin.php?controller=admin_index&'.time(), 0, 1);
				exit;
			}else{
				alert_and_back(implode(' ', $err));
				exit;
			}
		}
		$this->display("changelogo.tpl");
	}
	

	function documentlist(){
		global $_CONFIG;
		$page_num = get_request('page');
		$where = '1';
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			$alltmpip = array(0);
			if($_SESSION['ADMIN_MSERVERGROUP']){
				$allips = $this->sessions_set->base_select("SELECT device_ip FROM " . $this->server_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
				for($i=0; $i<count($allips); $i++){
					$alltmpip[]=$allips[$i]['device_ip'];
				}
			}
			$where .= " AND device_ip IN ('".implode("','", $alltmpip)."')";
		}
		$total = $this->document_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$alldev = $this->document_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,$where,'datetime', 'DESC');
		$device_type = $this->tem_set->select_all('login_method=""', 'device_type', 'asc');
		for($i=0; $i<count($alldev); $i++){
			for($j=0; $j<count($device_type); $j++){
				if($alldev[$i]['device_type']==$device_type[$j]['id']){
					$alldev[$i]['device_type']=$device_type[$j]['device_type'];
				}
			}
		}
		
		$newpager = new my_pager($total, $page_num, 20, 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $total);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);

		$this->assign('s', $alldev);
		$this->display('documentlist.tpl');
	}

	function documentupload(){
		$id = get_request('id');
		$servers = $this->server_set->select_all('1', 'device_ip', 'asc');
		$device_type = $this->tem_set->select_all('login_method=""', 'device_type', 'asc');
		$logrulename = $this->server_set->base_select("select * from log_rulename ORDER BY name ASC");
		$doc = $this->document_set->select_by_id($id);
		$this->assign("_type", 'system');
		if($doc['type']=='interface'){
			$this->assign("_type", 'interface');
		}
		$this->assign("doc", $doc);
		$this->assign("servers", $servers);
		$this->assign("dtype", $device_type);
		$this->assign("logrulename", $logrulename);
		$this->display('documentupload.tpl');
	}

	function dodocumentupload(){
		$id = get_request('id');
		$title = get_request('title', 1, 1);
		$device_ip = get_request('device_ip', 1, 1);
		$device_type = get_request('device_type', 1, 1);
		$_type = get_request('_type', 1, 1);
		$pdf = get_request('pdf', 1, 1);
		$oldpdf = get_request('oldpdf', 1, 1);
		$desc = get_request('desc', 1, 1);
		$html = get_request('html', 1, 1);
		$file = time();

		if(empty($title)){
			alert_and_back('请填写标题');
			exit;
		}

		if(empty($device_type)){
			alert_and_back('请选择设备类型');
			exit;
		}

		if(empty($_type)){
			alert_and_back('请选择类型');
			exit;
		}
		$document = new document();

		if($id);
		$oldd = $this->document_set->select_by_id($id);
		$document->set_data('pdf',  $oldd['pdf']);
		$document->set_data('html',  $oldd['html']);

		if(is_uploaded_file($_FILES['html']['tmp_name'])){
			if(!move_uploaded_file($_FILES['html']['tmp_name'], "/opt/freesvr/audit/doc/".$file.".html")){
				$error[] = '移动html文件失败';
			}else{					
				@unlink($oldd['html']);
				$document->set_data('html', "/opt/freesvr/audit/doc/".$file.".html");
			}
		}
		if(is_uploaded_file($_FILES['pdf']['tmp_name'])){	
			if(!move_uploaded_file($_FILES['pdf']['tmp_name'], "/opt/freesvr/audit/doc/".$file.".pdf")){
				$error[] = '移动pdf文件失败';
			}else{					
				@unlink($oldd['pdf']);
				$document->set_data('pdf',  "/opt/freesvr/audit/doc/".$file.".pdf");
			}
			
		}
		$document->set_data('device_ip', $device_ip);
		$document->set_data('device_type', $device_type);
		$document->set_data('type', $_type);
		$document->set_data('title', $title);
		$document->set_data('desc', $desc);

		if($id){
			$document->set_data('id', $id);
			$this->document_set->edit($document);
		}else{
			$this->document_set->add($document);
		}
		if($error){
			alert_and_back('操作失败'.implode(',',$error));
			exit;
		}
		alert_and_back('操作成功','admin.php?controller=admin_index&action=documentlist');
	}

	function documentdel(){
		$id = get_request('id');
		if(empty($id)){
			$this->document_set->delete($_POST['chk_gid']);
		}else{
			$oldd = $this->document_set->select_by_id($id);
			@unlink($oldd['pdf']);
			@unlink($oldd['html']);
			$this->document_set->delete($id);
		}
		alert_and_back('操作成功','admin.php?controller=admin_index&action=documentlist');
	}

	function getdocument(){
		/*echo ' <li><a target="_blank" href="#">李克</a></li>
                    <li><a target="_blank" href="#">有</a></li>
                    <li><a target="_blank" href="#">公</a></li>
                    <li><a target="_blank" href="#">个</a></li>
                    <li><a target="_blank" href="#">北京</a></li>
                    <li><a target="_blank" href="#">京东</a></li>
                    <li><a target="_blank" href="#">克</a></li>
                    <li><a target="_blank" href="#">为</a></li>
                    <li><a target="_blank" href="#">有</a></li>
                    <li><a target="_blank" href="#">像</a></li>';
		exit;*/

		$id = get_request('id');
		$ip = get_request('ip', 0, 1);
		$type = get_request('type', 0, 1);
		$doctype = get_request('doctype', 0, 1);
		if($id){
			$row = $this->document_set->select_by_id($id);
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=".$row[$doctype]); 
			echo file_get_contents($row[$doctype]);
			exit();
		}else{
			$row1 = $this->document_set->select_all("device_ip='".$ip."' and type='".$type."'");
			$row2 = $this->document_set->select_all("type='".$type."' AND id NOT IN(SELECT id FROM ".$this->document_set->get_table_name()." WHERE device_ip='".$ip."' and type='".$type."')");
			$row = array();
			if($row1)
			$row=array_merge($row, $row1);
			if($row2)
			$row=array_merge($row, $row2);
			$str = '';
			for($i=0; $i<count($row); $i++){
				$str .= "<li><a target='_blank' href='#' onclick='javascript:window.open(\"admin.php?controller=admin_index&action=getdocument&doctype=".$doctype."&id=".$row[$i]['id']."\")' >".$row[$i]['title']."</li>";
			}
			echo $str;
		}

		exit;
		if(count($row)==1){
			Header('Cache-Control: private, must-revalidate, max-age=0');
			Header("Content-type: application/octet-stream"); 
			Header("Content-Disposition: attachment; filename=".$row[0][$doctype]); 
			echo file_get_contents($row[0][$doctype]);
			exit();
		}elseif(count($row)>1){			
			$device_type = $this->tem_set->select_all('login_method=""', 'device_type', 'asc');
			for($i=0; $i<count($row); $i++){
				for($j=0; $j<count($device_type); $j++){
					if($row[$i]['device_type']==$device_type[$j]['id']){
						$row[$i]['device_type']=$device_type[$j]['device_type'];
					}
				}
			}
			$this->assign("s", $row);
			$this->display("documentviewlist.tpl");
			exit();
		}else{
			alert_and_close('不存在相关文档');
		}
	}

	function notice_tip(){
		//$sql = "SELECT a.*,group_concat(distinct servergroup.groupname order by convert(servergroup.groupname using gbk) ASC) gname,group_concat(distinct member.username order by member.username asc) uname FROM ".$this->notice_set->get_table_name()." a LEFT JOIN servergroup ON LOCATE(concat(',',servergroup.id,','),a.groups)  LEFT JOIN member ON LOCATE(concat(',',member.uid,','),a.members) WHERE `all` or member.uid=".$_SESSION['ADMIN_UID'].($_SESSION['ADMIN_GROUP'] ? " or LOCATE(concat(',',".$_SESSION['ADMIN_GROUP'].",','), concat(',',servergroup.child,',')) " : "")." group by a.id ORDER BY a.id desc";
		//$notices = $this->notice_set->base_select($sql);
		$this->display("notice_tip.tpl");
	}

	function jiekouyanz()
	{//var_dump($_POST);
		$can_login = false;
		$result = $this->member_set->select_all("username='".$_POST['username']."'");
		if(empty($result)){
			echo json_encode(array('result'=>2,'info'=>'user not exists'));
			return ;
		}
		if($_POST['logintype']=='local'){
			$can_login=$_POST['password']==$this->member_set->udf_decrypt($result[0]['password']);
		}else{
			$dpassword=$_POST['password'];
			//var_dump($result);
			if($result[0]['usbkey']&&intval($result[0]['usbkeystatus'])!=11){
				$_tmp = $this->member_set->base_select("select rad_getpasswd('".$result[0]['username']."','".$this->member_set->udf_decrypt($result[0]['password']).$dpassword."','','127.0.0.1') AS p");
				//var_dump($_tmp);var_dump($this->member_set->udf_decrypt($result[0]['password']).$dpassword);var_dump(crypt($password.$dpassword,"\$1\$qY9g/6K4"));exit;
				if($_tmp[0]['p']=='xxxxxx'){
					$can_login = false;
				}else{
					$can_login = (crypt($this->member_set->udf_decrypt($result[0]['password']).$dpassword,"\$1\$qY9g/6K4")==$_tmp[0]['p']);
				}
			}
		}
		if($can_login)
			echo json_encode(array('result'=>0,'info'=>'SUCCESS'));
		else
			echo json_encode(array('result'=>1,'info'=>'PASSWORD ERROR'));
		return ;
		
	}

	function String2File($sIn, $sFileOut) {
	  $rc = false;
	  do {
	   if (!($f = @fopen($sFileOut, "wa+"))) {
	     $rc = 1; 
	     alert_and_back('打开文件'.$sFileOut.'失败,请检查文件权限');
	     break;
	   }
	   if (!@fwrite($f, $sIn)) {
	     $rc = 2; 
	     alert_and_back('打开文件'.$sFileOut.'失败,请检查文件权限');
	     break;
	   }
	   $rc = true;
	  } while (0);
	  if ($f) {
	   fclose($f);
	  }
	  return ($rc);
	}

	function Array2File($aIn, $sFileOut) {
	  return ($this->String2File(implode("", $aIn), $sFileOut));
	}
}
?>
