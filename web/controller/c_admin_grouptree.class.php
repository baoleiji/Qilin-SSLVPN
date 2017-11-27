<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_grouptree extends c_base {
	function gettree(){
		
	}
	
	function getchild(){
		$groupid = get_request("groupid");
		$where = "ldapid=".$groupid;
		if($_SESSION['ADMIN_LEVEL']==3||$_SESSION['ADMIN_LEVEL']==21||$_SESSION['ADMIN_LEVEL']==101){
			$sgroup = $this->sgroup_set->base_select("select *,groupid id from servergroup_cache where $where and memberid=".$_SESSION['ADMIN_UID']);
		}else 
			$sgroup = $this->sgroup_set->select_all($where);
		echo json_encode(array('datas'=>$sgroup));
	}
	
	function get_devgroup(){
		$id = get_request('groupid');
		$level = get_request('level');
		$groupindex = get_request('groupindex',0,1);
		if(empty($id)) return ;
		if($_SESSION['ADMIN_LEVEL']==1){
			$subgroup = $this->sgroup_set->select_all("ldapid=".$id.(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101) ? " AND id IN(".implode(',', array_merge($_SESSION['ADMIN_MUSERGROUP_IDS'],$_SESSION['ADMIN_MSERVERGROUP_PARENT_IDS'])).")" : "" ).($_SESSION['dev_group_index']['_groupid'] ? ' and id IN('.implode(',', $_SESSION['dev_group_index']['_groupid']).')' : ''), "groupname", "ASC");

		}
		elseif(($_SESSION['ADMIN_LEVEL']==3|| $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101)){
			$count = 0;
			$mcount = 0;
			$subgroup = $this->sgroup_set->base_select("select *,groupid id from servergroup_cache where ldapid=".$id." and memberid=".$_SESSION['ADMIN_UID']);
		}
		if($_SESSION['ADMIN_MSERVERGROUP']==$id){//
			//$mcount-=1;
		}
		if($subgroup)
		for($j=0; $j<count($subgroup); $j++){
			if($_SESSION['ADMIN_MSERVERGROUP']==$subgroup[$j]['id']){
				//$subgroup[$j]['mcount']-=1;
			}
			switch($subgroup[$j]['attribute']){
				case '1':
					$attribute = '用户';
					break;
				case '2':
					$attribute = '主机';
					break;
				default:
					$attribute = '全部';
	
			}
			$subgroup[$j]['childrenct']=(strpos($subgroup[$j]['child'],',')!==false ? 1 : 0);
			$groupstr .= '<TBODY name="ldap'.'_'.$groupindex.'"  id="ldap'.'_'.$groupindex."_".$j.'" style="DISPLAY: none">
							<tr '.($j%2==0 ? 'bgcolor="f7f7f7"' : '' ).'>
							<td class=td25 width="20">&nbsp;</TD>
							<td onClick="toggle_group(\'ldap'.'_'.$groupindex."_".$j.'\', \'a_ldap'.'_'.$groupindex."_".$j.'\','.$subgroup[$j]['id'].','.($level+1).')">'.str_repeat('&nbsp;&nbsp;',$level).($subgroup[$j]['childrenct']>0 ? '<span class="td25"><A id=a_ldap'.'_'.$groupindex."_".$j.' href="javascript:;">[+]</A></span>' : '').'<a href="admin.php?controller=admin_pro&action=dev_index&gid='.$subgroup[$j]['id'].'">&nbsp;'.$subgroup[$j]['groupname'].'</a></td>
							<td class=td25 width="20"><a href="admin.php?controller=admin_pro&action=dev_index&gid='.$subgroup[$j]['id'].'">&nbsp;'.$subgroup[$j]['id'].'</a></TD>
							<td>'.$attribute.'</td>
							<td><a href="admin.php?controller=admin_pro&action=dev_index&gid='.$subgroup[$j]['id'].'&from=dir">'.$subgroup[$j]['count'].'</a></td>
							<td><a href="admin.php?controller=admin_member&gid='.$subgroup[$j]['id'].'&from=dir">'.$subgroup[$j]['mcount'].'</a></td>
							<td>'.$subgroup[$j]['description'].'</td>
							<td>'.(($_SESSION['ADMIN_LEVEL'] == 1 or $_SESSION['ADMIN_LEVEL'] == 3 or $_SESSION['ADMIN_LEVEL'] == 21 or $_SESSION['ADMIN_LEVEL'] == 101) ? '
							<img src="'.substr($this->smarty->template_dir[0],strlen(ROOT)).'/images/edit_ico.gif" width=16 height="16" hspace="5" border="0" align="absmiddle"><a href="admin.php?controller=admin_pro&action=devgroup_edit&id='.$subgroup[$j]['id'].'" >编辑</a> |
							<img src="'.substr($this->smarty->template_dir[0],strlen(ROOT)).'/images/delete_ico.gif" width=16 height="16" hspace="5" border="0" align="absmiddle"><a href="#" onClick="if(!confirm(\'您确定要删除？\')) {return false;} else { location.href=\'admin.php?controller=admin_pro&action=dev_group_del&id='.$subgroup[$j]['id'].'\';}">删除</a>
							' : '').'</td></tr>';
			$groupstr .= $_subchild['groupstr'];
		}
		else $groupstr .= '<TBODY name="ldap'.'_'.$groupindex.'"  id="ldap'.'_'.$groupindex."_0".'" style="DISPLAY: none">';
		echo $groupstr .= "</TBODY>";
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
