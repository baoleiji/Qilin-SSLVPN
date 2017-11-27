<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_ipacl extends c_base {
	function index() {
		$page_num = get_request('page');
		$orderby1 = get_request('orderby1', 0, 1);
		$orderby2 = get_request('orderby2', 0, 1);
		if(empty($orderby1)){
			$orderby1 = 'aclname';
		}
		if(strcasecmp($orderby2, 'asc') != 0 ) {
			$orderby2 = 'asc';
		}else{
			$orderby2 = 'desc';
		}
		$this->assign("orderby2", $orderby2);

		$where = '1=1';
		$row_num = $this->restrictacl_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$acl = $this->restrictacl_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where, $orderby1, $orderby2);
		$this->assign('title', language('授权策略列表'));
		$this->assign('acl', $acl);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('restrictacl.tpl');
	}

	function edit(){
		$id = get_request("id");
		$wt = $this->restrictacl_set->select_by_id($id);
		$this->assign("title", language('编辑授权规则'));
		$this->assign("wt", $wt);
		$this->display('restrictacl_edit.tpl');
	}
	
	function delete(){
		$id = get_request("id");
		if($this->restrictpolicy_set->select_count("aclid=".$id)>0){
			alert_and_back('策略已经绑定，请先删除绑定');
			return ;
		}
		$this->restrictacl_set->delete($id);
		alert_and_back('删除成功','admin.php?controller=admin_ipacl');
	}
	
	function save(){
		$id = get_request("sid");
		$aclname = get_request("aclname", 1, 1);
		$year = get_request("year", 1, 1);
		$month = get_request("month", 1, 1);
		$day = get_request("day", 1, 1);
		$week = get_request("week", 1, 1);
		$time = get_request("time", 1, 1);
		$lifetime = get_request("lifetime", 1, 1);
		$ip = get_request("ip", 1, 1);
		if(empty($aclname)){
			alert_and_back('输入策略名');
			exit;
		}
		$allgp = $this->restrictacl_set->select_all('aclname="'.$aclname.'" and id!='.$id);
		if(!empty($allgp)){
			alert_and_back('该策略名已经存在');
			exit;
		}
		if($ip){
			$_ip = explode('/', $ip);
			if(!(is_ip($_ip[0])&&ctype_digit($_ip[1]))){
				alert_and_back('输入的来源网段格式不正确');
				exit;
			}
		}
		
		$restrictacl = new restrictacl();
		$restrictacl->set_data('aclname', $aclname);
		$restrictacl->set_data('year', $year);
		$restrictacl->set_data('month', $month);
		$restrictacl->set_data('day', $day);
		$restrictacl->set_data('week', $week);
		$restrictacl->set_data('time', $time);
		$restrictacl->set_data('lifetime', $lifetime);
		$restrictacl->set_data('ip', $ip);
		if($id){
			$restrictacl->set_data("id", $id);
			$this->restrictacl_set->edit($restrictacl);
			alert_and_back('修改成功','admin.php?controller=admin_ipacl');
			exit;
		}
		
		$this->restrictacl_set->add($restrictacl);
		alert_and_back('编辑成功','admin.php?controller=admin_ipacl');
	}

	function loginpolicy(){
		$page_num = get_request('page');
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

		$memberid = get_request('users', 1, 0);
		$usergroupid = get_request('groups', 1, 0);
		$serverid = get_request('servers', 1, 0);
		$resourceid = get_request('resources', 1, 0);
		$aclid = get_request('restrictacl', 1, 0);
		$id = get_request('id');
		if($_POST['ac']=='doinsert'){
			if(empty($aclid)){
				alert_and_back('请选择规则');
				exit;
			}
			$restrictpolicy = new restrictpolicy();
			$restrictpolicy->set_data('memberid', $memberid);
			$restrictpolicy->set_data('usergroupid', $usergroupid);
			$restrictpolicy->set_data('serverid', $serverid);
			$restrictpolicy->set_data('resourceid', $resourceid);
			$restrictpolicy->set_data('aclid', $aclid);
			if($id){
				$restrictpolicy->set_data('id', $id);
				$this->restrictpolicy_set->edit($restrictpolicy);
			}else{
				$this->restrictpolicy_set->add($restrictpolicy);
			}
			alert_and_back('操作成功', 'admin.php?controller=admin_ipacl&action=loginpolicy');
		}

		$users = $this->member_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : ''), 'username', 'ASC');
		$groups = $this->usergroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND id IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : ''), 'groupname', 'ASC');
		$servers = $this->server_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' and device_ip IN(SELECT device_ip FROM servers WHERE groupid IN('.implode(",", $_SESSION['ADMIN_MSERVERGROUP_IDS']).'))' : '0'), 'device_ip', 'ASC');
		$resources = $this->resgroup_set->select_all("devicesid=0".($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' and user="'.$_SESSION['ADMIN_USERNAME'].'"' : ''), 'groupname', 'ASC');
		$acl = $this->restrictacl_set->select_all('1=1', 'aclname', 'ASC');
		$this->assign('users', $users);
		$this->assign('groups', $groups);
		$this->assign('servers', $servers);
		$this->assign('resources', $resources);
		$this->assign('acl', $acl);

		$where = '1=1';
		if ($_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21  || $_SESSION['ADMIN_LEVEL'] == 101) {
			$alltmpip = array(0);
			if(empty($_SESSION['ADMIN_MSERVERGROUP'])){
				$where .= " AND 1=0";
			}else{
				
				$allusers = $this->sessions_set->base_select("SELECT uid FROM " . $this->member_set->get_table_name() . " WHERE groupid IN(".$_SESSION['ADMIN_MSERVERGROUP'].") or groupid IN(".implode(',', $_SESSION['ADMIN_MSERVERGROUP_IDS']).")");
				for($i=0; $i<count($allusers); $i++){
					$alltmpuser[]=$allusers[$i]['uid'];
				}
				if($alltmpuser)
				$wherem = " OR memberid IN (".implode(",", $alltmpuser).")";
				$where .= " AND (usergroupid IN(".implode(",", $_SESSION['ADMIN_MSERVERGROUP_IDS']).") ".$wherem.")";

			}
        }
		$row_num = $this->restrictpolicy_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$respolicy = $this->restrictpolicy_set->base_select("SELECT f.*,b.username,c.groupname,d.device_ip,e.groupname resname,a.id rid,a.memberid,a.usergroupid,a.serverid,a.resourceid FROM ".$this->restrictpolicy_set->get_table_name()." a LEFT JOIN ".$this->member_set->get_table_name()." b ON a.memberid=b.uid LEFT JOIN ".$this->usergroup_set->get_table_name()." c ON a.usergroupid=c.id LEFT JOIN ".$this->server_set->get_table_name()." d ON a.serverid=d.id LEFT JOIN ".$this->resgroup_set->get_table_name()." e ON a.resourceid=e.id LEFT JOIN ".$this->restrictacl_set->get_table_name()." f ON a.aclid=f.id  WHERE $where ORDER BY $orderby1 $orderby2 LIMIT ".$newpager->intStartPosition.",".$newpager->intItemsPerPage);
		$this->assign('title', language('授权策略列表'));
		$this->assign('respolicy', $respolicy);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);

		$this->display('loginpolicy.tpl');
	}

	function loginpolicy_edit(){
		$id = get_request('id');
		$users = $this->member_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND groupid IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : ''), 'username', 'ASC');
		$groups = $this->usergroup_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' AND id IN('.implode(',', $_SESSION['ADMIN_MUSERGROUP_IDS']).') ' : ''), 'groupname', 'ASC');
		$servers = $this->server_set->select_all('1=1'.($_SESSION['ADMIN_LEVEL']==3 || $_SESSION['ADMIN_LEVEL']==21 || $_SESSION['ADMIN_LEVEL']==101 ? ' and device_ip IN(SELECT device_ip FROM servers WHERE groupid IN('.$_SESSION['ADMIN_MSERVERGROUP'].'))' : ''), 'device_ip', 'ASC');
		$resources = $this->resgroup_set->select_all("devicesid=0", 'groupname', 'ASC');
		$acl = $this->restrictacl_set->select_all('1=1', 'aclname', 'ASC');
		$p = $this->restrictpolicy_set->select_by_id($id);
		$this->assign('users', $users);
		$this->assign('groups', $groups);
		$this->assign('servers', $servers);
		$this->assign('resources', $resources);
		$this->assign('acl', $acl);
		$this->assign('p', $p);
		$this->display('loginpolicy_edit.tpl');
	}

	function delete_policy(){
		$id = get_request('id');
		if(empty($id)){
			$id = get_request('chk_member', 1, 1);
		}
		
		$this->restrictpolicy_set->delete($id);
		alert_and_back('成功删除');
	}
}
?>
