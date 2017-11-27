<?php
$groupidname = ($groupidname ? $groupidname : 'groupid' );
$inputtype = ($inputtype ? $inputtype : 'text' );
$multipleselect = ($multipleselect ? $multipleselect : '0' );
$showcheck = ($showcheck ? $showcheck : '0' );
$i=0;
if($_GET[$groupidname]){
	$g_id=${$groupidname} = $_GET[$groupidname];
}
$this->assign("logined_user_level", 1);
$logined_user_level=1;
$departmanagersgroupids = "";
if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
	$_psgroup_depart = $this->sgroup_set->select_all("id IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
	for($i=0; $i<count($_psgroup_depart); $i++){
		$departmanagersgroupids .= ','.$_psgroup_depart[$i]['child'];
	}
	if(empty(${$groupidname}))
	${$groupidname}=$_SESSION['ADMIN_MSERVERGROUP'];
}
$groupids_arr = explode(',', ${$groupidname});
${'last'.$groupidname}=$sgroup = $this->sgroup_set->select_by_id($groupids_arr[0]);
$ori_g_id=$g_id;
if(!$multipleselect){
	$g_id=${$groupidname}=$groupids_arr[0];
}
$parent = array(-1);
if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
	$groupids_arr=explode(',', $_SESSION['ADMIN_MSERVERGROUP']);
}
for($i=0; $i<count($groupids_arr); $i++){
	$_psgroup = $this->sgroup_set->select_by_id($groupids_arr[$i]);
	while($_psgroup['ldapid']){
		$_psgroup = $this->sgroup_set->select_by_id($_psgroup['ldapid']);		
		$parent[]=$_psgroup['id'];
	}
}
$departmanagersgroupids .= ',';
if(!($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101)){
	$departmanagersgroupids='';
}
$i=1;
if($sgroup){
	while($sgroup['ldapid']){
		$_sgroup = $this->sgroup_set->select_by_id($sgroup['ldapid']);
		$_sgroup['childarr']=$sgroup;
		$sgroup=$_sgroup;
		$i++;
	}
}
//$logined_user_level=$i;
$i=1;
$this->assign("{$groupidname}1", $sgroup['id']);
while($sgroup['childarr']){
	${$precl.'changelevelstr'} .= "changelevels(".$sgroup['id'].",".$sgroup['childarr']['id']." , ".(++$i).", '$groupidname',".$logined_user_level.",'".str_replace("'", "\'", $groupfunc)."');".$groupfuncf."";
	$this->assign("$groupidname$i", $sgroup['id']);
	$sgroup=$sgroup['childarr'];
	$parent[]=$sgroup['id'];
}
if($_CONFIG['TREEMODE']){
	${$precl.'changelevelstr'}="";
	if($showcheck){
		$groupids_arr = explode(',', ${$groupidname});
		for($i=0; $i<count($groupids_arr); $i++){
			${$precl.'changelevelstr'}.="document.getElementById('".$groupidname."1_group_".$groupids_arr[$i]."').checked=true;";
		}
	}
	if(!empty(${'last'.$groupidname}['groupname']))
	${$precl.'changelevelstr'}.="setSrcValue('".${'last'.$groupidname}['groupname']."','${$groupidname}','{$groupidname}1','".($inputtype=='text' ? 1 : 0)."', $multipleselect,'$departmanagersgroupids');";
}
$this->assign($precl."changelevelstr", ${$precl.'changelevelstr'});
$allsgroup = $this->sgroup_set->base_select("SELECT * FROM ".$this->sgroup_set->get_table_name()." WHERE 1".($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101 ? (empty($_SESSION['ADMIN_MSERVERGROUP_IDS']) ? ' AND 0' : ' AND (id IN('.implode(',',$_SESSION['ADMIN_MSERVERGROUP_IDS']).") or id IN(".(implode(',', $parent)).")) ") : ''). " ORDER BY convert(groupname using gbk) ASC");
$this->assign('allsgroup',$allsgroup);
$this->assign('last'.$groupidname,${'last'.$groupidname});
$this->assign('_config',$_CONFIG);
$this->assign('inputtype',$inputtype);
if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
	$this->assign('departmanagersgroupids', $departmanagersgroupids);
}

?>
