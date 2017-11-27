<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}
$groupidname = ($groupidname ? $groupidname : 'groupid' );
if(empty(${$groupidname})){
	if($_POST[$groupidname]) $g_id = ${$groupidname}=$_POST[$groupidname];
	elseif($_GET[$groupidname]) $g_id = ${$groupidname}=$_GET[$groupidname];
}
${$precl.'changelevelstr'}="";
${$precl.'changelevelstr'}.="document.getElementById('".$groupidname."dh').value='".${$groupidname}."';";
if($checkbox&&${$groupidname}){
	$_group = $this->sgroup_set->select_all("id IN(".${$groupidname}.")");
	$groupids_arr = explode(',', ${$groupidname});
	for($i=0; $i<count($_group); $i++){
		$_group_arr[]= $_group[$i]['groupname'];
	}
	${$precl.'changelevelstr'}.="document.getElementById('".$groupidname."dpop').value='".implode(',', $_group_arr)."';";
}else if(!empty(${$groupidname})){
	$_group = $this->sgroup_set->select_by_id(${$groupidname});
	//${$precl.'changelevelstr'}.="setSrcValue('".${$groupidname}['groupname']."','${$groupidname}','{$groupidname}','1', ".($checkbox ? 1 : 0).",'$departmanagersgroupids');";
	${$precl.'changelevelstr'}.="document.getElementById('".$groupidname."dpop').value='".$_group['groupname']."';";
}
$this->assign($precl."changelevelstr", ${$precl.'changelevelstr'});

if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
	$_psgroup_depart = $this->sgroup_set->select_all("id IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
	for($i=0; $i<count($_psgroup_depart); $i++){
		$departmanagersgroupids .= ','.$_psgroup_depart[$i]['child'];
	}
	$departmanagersgroupids .= ',';
	$this->assign('departmanagersgroupids', str_replace(",,", ",", $departmanagersgroupids));
}
$allsgroup = $this->sgroup_set->base_select("SELECT * FROM ".$this->sgroup_set->get_table_name()." WHERE 1".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? (empty($_SESSION['ADMIN_MSERVERGROUP_IDS']) ? ' AND 0' : ' AND (id IN('.implode(',',$_SESSION['ADMIN_MSERVERGROUP_IDS']).") or id IN(".(implode(',', $_SESSION['ADMIN_MSERVERGROUP_PARENT_IDS'])).")) ") : ''). " AND ldapid=0 ORDER BY convert(groupname using gbk) ASC");
$this->assign('allsgroup',$allsgroup);
$this->assign('_config',$_CONFIG);
?>
