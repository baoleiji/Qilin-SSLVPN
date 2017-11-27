<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_facility extends c_base {
	//List ripple
	function index() {
		$page_num = get_request('page');
		$where = '1=1';
		
		if(!is_admin()) {
			$flist = $_SESSION['ADMIN_FLIST'];
			if($flist) {
				$where = "fid in ('" . implode("','", $flist) . "')";
			}
			else {
				$where = "1=2";
			}

		}
		$row_num = $this->facility_set->select_count($where);
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$allfacility = $this->facility_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage, $where);
		for($i = 0; $i < count($allfacility); $i++) {
			if($this->changes_set->select_count("fid = '{$allfacility[$i]['fid']}' AND TIME_TO_SEC(TIMEDIFF(NOW(), changetime)) < 3600 * 24 * 7") != 0) { 
				$allfacility[$i]['alert'] = true;
			}
			else {
				$allfacility[$i]['alert'] = false;
			}
		}
		$this->assign('allfacility', $allfacility);
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('total', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		$this->display('facility_list.tpl');
	}
	// add ripple
	function add() {
		$this->display('facility_add.tpl');
	}
	// edit ripple
	function edit($fid = null) {
		if($fid == null) {
			$fid = get_request('fid');
		}
		$facility = $this->facility_set->select_by_id($fid);
		$ftype = $facility['type'];

		$config_list = $this->getconfig($fid);
		//print_r($config_list);
		$this->assign('tid', type2id($ftype));
		$this->assign('config_list', $config_list);
		$this->assign('config_type', $this->config_type);
		$this->assign('facility', $facility);
		$this->assign('action', 'edit');
		$this->display('facility_edit.tpl');
	}
	// ripple
	function config_add($config_type, $path, $fid) {
		if(trim($config_type) == '') {
			alert_and_back('配置名不能为空', 'admin.php?controller=admin_facility&action=edit&fid=' . $fid);
			die();
		}
		
		if($config_type == 'Linux配置文件'|| $config_type == 'Tripwire文件') {
			if(trim($path) == '') {
				alert_and_back('文件路径不能为空!', 'admin.php?controller=admin_facility&action=edit&fid=' . $fid);
				die();
			}
		}
		if ($this->config_set->select_count("fid = $fid and name = '$config_type' and attributes = '$path'") == 0 ) {
			$newconfig = new config();
			$newconfig->set_data('fid' , $fid);
			foreach($this->config_type as $basic) {
				if($basic['name'] == $config_type){
					$newconfig->set_data('interface' , $basic['class']);
				}
			}
			if($config_type == 'Linux配置文件' ||$config_type == 'Tripwire文件')
				$newconfig->set_data('attributes' , $path);
			$newconfig->set_data('updatetime', date("Y-m-d H:i:s"));
			$newconfig->set_data('addtime', date("Y-m-d H:i:s"));
			$newconfig->set_data('name' , $config_type);
			$this->config_set->add($newconfig);
			//$cid = mysql_insert_id();
			
		}
		else {
			alert_and_back('已有相同的配置', 'admin.php?controller=admin_facility&action=edit&fid=' . $fid);
			die();
		}	
	}
	// ripple
	function setbase($_cid){
		$tconfig = $this->config_set->select_by_id($_cid);
		if($tconfig['name'] != 'Tripwire文件') {
			$tfacility = $this->facility_set->select_by_id($tconfig['fid']);
			if($tfacility['port'] == '') {
				$tfacility['port'] = '22';
			}

			$result = $this->do_config[$tconfig['interface']]->get($tfacility,$tconfig);
			if($result[0] == 0 ) {
				$newconfig = new config();
				$newconfig->set_data('cid', $_cid);
				$newconfig->set_data('default', mysql_real_escape_string(file_get_contents('/tmp/audit.tmp')));
				$this->config_set->edit($newconfig);
			}
			else{
				$this->assign('title', "更新设备配置发生错误");
				$this->assign('content', nl2br($result[1]));
				$this->display('error.tpl');
				die();
			}
			return $result[0];
		}
		else {
			return 0;		
		}

	}

	//ripple
	function save() {
		$type = get_request('type', 0, 1);
		$newfacility = new facility();
		if($type == 'edit') {
			$fid = get_request('fid');
			$newfacility->set_data('fid', $fid);
			$oldfacility = $this->facility_set->select_by_id($fid);
			
			$ftype = $oldfacility['type'];
			$config_type = get_request('config_type', 1, 1);
			$path = get_request('path', 1, 1);
			$chk_delete = get_request('chk_delete', 1, 1);
			if(count($chk_delete)>0)
				$this->delete_config($chk_delete);
			//var_dump($chk_delete);
			if(trim($config_type) != '')
				$this->config_add($config_type, $path ,$fid);

		}
		else {
			$tid = get_request('type', 1);
			$newfacility->set_data('type', get_request('type', 1));
			$newfacility->set_data('addtime', date("Y-m-d H:i:s"));
		}

		$newfacility->set_data('username', get_request('username', 1, 1));
		$newfacility->set_data('password', get_request('password', 1, 1));
		$newfacility->set_data('name', get_request('name', 1, 1));
		$newfacility->set_data('describe', get_request('describe', 1, 1));
		$newfacility->set_data('ip', get_request('ip', 1, 1));
		$newfacility->set_data('port', get_request('port', 1, 1));
		$newfacility->set_data('community', get_request('community', 1, 1));
		$newfacility->set_data('updatetime', date("Y-m-d H:i:s"));


		if($newfacility->get_errnum() == 0) {
			if($type == 'add') {
				$this->facility_set->add($newfacility);
				$fid = mysql_insert_id();
				$usetemplet = get_request('use_templet', 1, 1);
				if($usetemplet == 1) {
					$templets = $this->config_set->select_all("fid = -$tid");
					if(count($templets)>0) {
						foreach($templets as $templet) {
							$newconfig = new config();
							$newconfig->set_data('fid' , $fid);
							$newconfig->set_data('interface' , $templet['interface']);
							if($templet['name'] == 'Linux配置文件'||$templet['name'] == 'Tripwire文件')
								$newconfig->set_data('attributes' , $templet['attributes']);
							$newconfig->set_data('updatetime', date("Y-m-d H:i:s"));

							$newconfig->set_data('addtime', date("Y-m-d H:i:s"));
							$newconfig->set_data('name' , $templet['name']);
							$this->config_set->add($newconfig);
						}					
					}
				}
				alert_and_back('成功添加设备,下面开始详细配置', 'admin.php?controller=admin_facility&action=edit&fid=' . $fid);
			}
			else {
				$this->facility_set->edit($newfacility);
				$configs = $this->config_set->select_all("fid = $fid");
				if(count($configs) > 0) {
					foreach($configs as $config) {
						$this->setbase($config['cid']);
					}
				}
				alert_and_back('成功编辑设备!', 'admin.php?controller=admin_facility');
			}
		}
		else {
			alert_and_back($newfacility->get_firsterr(), NULL, 1);
			exit();
		}
	}
	//ripple
	function getconfig($_fid){
		if($this->config_set->select_count("fid = $_fid") == 0 )
			return NULL;
		else {
			$tresult = $this->config_set->select_all("fid = $_fid");
			$tconfig_list = array();
			foreach($tresult as $_config) {
				if($_config['name'] == 'Linux配置文件'||$_config['name'] == 'Tripwire文件'){
					$tconfig_list[] = array(
									'cid'	=> $_config['cid'],
									'name' => $_config['name'],
									'path' => $_config['attributes'],
									);
				}
				else {
					$tconfig_list[] = array(
								'cid' => $_config['cid'],
								'name' => $_config['name'],
							);
				}
			}
			return $tconfig_list;
			
		}
		
	}


	function detail() {
		$fid = get_request('fid');
		if(!is_admin()) {
			if(array_search($fid, $_SESSION['ADMIN_FLIST']) === false) {
				alert_and_back('你没有管理这个设备的权限!');
				die();
			}
		}
		$facility = $this->facility_set->select_by_id($fid);
		if(!$facility) {
			alert_and_back('设备不存在!');
		}
		$config_list = array();
		$changes = $this->changes_set->select_all("fid = $fid",' changetime ');//get all the changes;
		$data = array();
		if(count($changes) > 0) {
			$data['date'] = date("Y-m-d",strtotime($changes[0]['changetime']));
			$data['list'] = array();
			$config = $this->config_set->select_by_id($changes[0]['conid']);
			if($config['name']=='Linux配置文件' || $config['name']== 'Tripwire文件')
				$tconfig['config'] = $config['name'].':'.$config['attributes'];
			else
				$tconfig['config'] = $config['name'];
			$tconfig['id'] = $changes[0]['chid'];
			array_push($data['list'], $tconfig);
			//get first change's date
			for($i=1; $i<count($changes); $i++) {
				if(date("Y-m-d",strtotime($changes[$i]['changetime'])) != date("Y-m-d",strtotime($changes[$i-1]['changetime']))) {
					//if next change's date is different from previous one's, save data and build a new one.
					$data['num'] = count($data['list']);
					array_push($config_list, $data);
					$data['date'] = date("Y-m-d",strtotime($changes[$i]['changetime']));
					$data['list'] = array();
				}
				$config = $this->config_set->select_by_id($changes[$i]['conid']);
				if($config['name'] == 'Linux配置文件' || $config['name'] == 'Tripwire文件')
					$tconfig['config'] = $config['name'].':'.$config['attributes'];
				else
					$tconfig['config'] = $config['name'];
				$tconfig['id'] = $changes[$i]['chid'];
				array_push($data['list'], $tconfig);
			}
		$data['num'] = count($data['list']);
		array_push($config_list, $data);			
		}
		$this->assign('fid', $fid);
		$this->assign('config', $config_list);
		$this->display('facility_detail.tpl');
	}

	function contrast() {
		$chid = get_request('chid');
		$change = $this->changes_set->select_by_id($chid);
		$facility = $this->facility_set->select_by_id($change['fid']);
		$config = $this->config_set->select_by_id($change['conid']);

		$this->assign('config_date', $change['changetime']);
		if($config['name'] == 'Linux配置文件'|| $config['name'] == 'Tripwire文件' ) {
			$this->assign('config_name', $config['attributes']);
		}
		else {
			$this->assign('config_name', $config['name']);
		}
		$this->assign('config_type',$config['name']);
		
		$this->assign('fid', $change['fid']);
		$this->assign('chid', $chid);
		$this->assign('result', nl2br(htmlspecialchars($this->do_config[$config['interface']]->compare($config['default'], $change['diffs']))));
		if($config['interface'] == 'linux_config') {
			$this->assign('mtime',$change['mtime']);
		}
		$this->assign('config_name',$config['attributes']);
		$this->display('facility_contrast.tpl');
	}

	function update($facility = null) {
		if($facility == null) {
			$fid = get_request('fid');
			if(!is_admin()) {
				if(array_search($fid, $_SESSION['ADMIN_FLIST']) === false) {
					alert_and_back('你没有管理这个设备的权限!');
					die();
				}
			}
			$facility = $this->facility_set->select_by_id($fid);
		}
		else {
			$fid = $facility['fid'];
			$benchmark = true;
		}
		
		if($facility['port'] == '') {
			$facility['port'] = '22';
		}
		$newfacility = new facility();
		$newfacility->set_data('fid', $fid);
		$newfacility->set_data('updatetime', date("Y-m-d H:i:s"));

		$tresult = $this->config_set->select_all(" fid = $fid ");
		if(count($tresult) == 0) {
			alert_and_back("此设备没有添加任何监控的配置!", "admin.php?controller=admin_facility&action=edit&fid=$fid");
			die();
		}
		$diffcounts == 0;
		foreach($tresult as $_config)	{
			if(file_exists('/tmp/audit.tmp')) {
				unlink('/tmp/audit.tmp');
			}
			$now = $this->do_config[$_config['interface']]->get($facility,$_config);
			if($now[0] == 0) {
				$diff = $this->do_config[$_config['interface']]->compare($_config['default'],file_get_contents('/tmp/audit.tmp'));
			}
			else if($now[0] == 2) {
				$diff = "该文件被删除";
			}
			else {
				//echo file_get_contents('/tmp/audit.tmp');
				$this->assign('title', "更新设备配置发生错误");
				$this->assign('content', nl2br($now[1]));
				$this->display('error.tpl');
				die();
			}

			if($diff != '') {
				$diffcounts++;
				$newchanges = new changes();
				$newchanges->set_data('conid',$_config['cid']);
				$newchanges->set_data('fid',$fid);
				if($now[0] == 2) {
					$newchanges->set_data('diffs', '$Linux Config Deleted$');
				}
				else {
					$newchanges->set_data('diffs',mysql_real_escape_string(file_get_contents('/tmp/audit.tmp')));
				}
				$newchanges->set_data('changetime', date("Y-m-d H:i:s"));
				if($now[0] != 2) {
					$stats = stat('/tmp/audit.tmp');
					$newchanges->set_data('mtime', date("Y-m-d H:i:s",$stats['mtime']));
				}
				else {
					$newchanges->set_data('mtime', date("Y-m-d H:i:s", 0));
				}
				$oldchanges = $this->changes_set->select_all("conid = ".$_config['cid'] ." and DATE_FORMAT( changetime, '%Y-%m-%d' ) = '".date("Y-m-d")."'");
				if(count($oldchanges)>0) {
					foreach($oldchanges as $oldchange) {
						$this->changes_set->delete($oldchange['chid']);
					}
				}
				$this->changes_set->add($newchanges);
			}
			
			if(file_exists('/tmp/audit.tmp')) {
				unlink('/tmp/audit.tmp');
			}
			
		}

		if($diffcounts == 0) {
			$this->facility_set->edit($newfacility);
			alert_and_back('更新成功,没有发现配置被更改!');
		}
		else {
			$newfacility->set_data('lastchangetime', date("Y-m-d H:i:s"));
			$this->facility_set->edit($newfacility);
			alert_and_back("更新成功,发现 $diffcounts 个配置被更改!", "admin.php?controller=admin_facility&action=detail&fid=$fid");
		}
			
	}

	function cover() {
		$chid = get_request('chid');
		$change = $this->changes_set->select_by_id($chid);
		$tconfig = $this->config_set->select_by_id($change['conid']);
		$fid = $change['fid'];
		$newconfig = new config();
		$newconfig->set_data('cid' , $tconfig["cid"]);
		$newconfig->set_data('fid' , $tconfig["fid"]);
		$newconfig->set_data('interface' , $tconfig["interface"]);
		$newconfig->set_data('name' , $tconfig["name"]);
		$newconfig->set_data('attributes' , $tconfig["attributes"]);
		$newconfig->set_data('addtime' , $tconfig["addtime"]);
		$newconfig->set_data('default', mysql_real_escape_string($change['diffs']));
		$newconfig->set_data('updatetime' , date("Y-m-d H:i:s"));
		$this->config_set->edit($newconfig);
		alert_and_back('成功更新基准文件!', "admin.php?controller=admin_facility&action=detail&fid=$fid");
	}

	function templet_list() {
		$this->display('facility_templet_list.tpl');
	}
	
	function templet_edit($tid = null) {
		if($tid == null) {
			$tid = get_request('tid'); 
		}

		if($tid >= 1 && $tid <= 2) {
			$templet = $this->config_set->select_all("fid = -$tid");
			$this->assign('tid', $tid);
			$this->assign('templet', $templet);
			$this->assign('config_type', $this->config_type);
			$this->display('facility_templet_edit.tpl');
		}
	}

	function templet_add() {
		$config_type = get_request('config_type', 1, 1);
		$path = get_request('path', 1, 1);
		$tid = get_request('tid');

		if(trim($config_type) == '') {
			alert_and_back('配置名不能为空', 'admin.php?controller=admin_facility&action=templet_edit&tid=' . $tid);
			die();
		}
		if($tid >= 1 && $tid <= 2) {
			if($config_type == 'Linux配置文件' || $config_type == 'Tripwire文件') {
				if(trim($path) == '') {
					alert_and_back('文件路径不能为空!', 'admin.php?controller=admin_facility&action=templet_edit&tid=' . $tid);
					die();
				}
				$config = array(
							'name' => $config_type,
							'path' => $path,
						);
			}
			else {
				$config = array(
							'name' => $config_type,
						);
			}			
			
			if ($this->config_set->select_count("fid = -$tid and name = '$config_type' and attributes = '$path'") == 0 ) {
				$newconfig = new config();
				$newconfig->set_data('fid' , -$tid);
				foreach($this->config_type as $basic) {
					if($basic['name'] == $config_type){
						$newconfig->set_data('interface' , $basic['class']);
					}
				}
				if($config_type == 'Linux配置文件'||$config_type == 'Tripwire文件')
					$newconfig->set_data('attributes' , $path);
				$newconfig->set_data('updatetime', date("Y-m-d H:i:s"));
				$newconfig->set_data('addtime', date("Y-m-d H:i:s"));
				$newconfig->set_data('name' , $config_type);
				$this->config_set->add($newconfig);
				alert_and_back('添加成功!', 'admin.php?controller=admin_facility&action=templet_edit&tid=' . $tid);
			
			}
			else {
				alert_and_back('配置已存在!', 'admin.php?controller=admin_facility&action=templet_edit&tid=' . $tid);
				die();
			}	
		}
	}

	function templet_del() {
		$chk_delete = get_request('chk_delete', 1, 1);
		$tid = get_request('tid');
		if(count($chk_delete)>0)
			$this->config_set->delete($chk_delete);
		$this->templet_edit($tid);
	}

	function delete($fid = -1) {
		$fromUser = 0;
		if($fid == -1) {
			$fromUser = 1;
			$fid = get_request('fid');
		}
		$this->facility_set->delete($fid);
		$oldconfig = $this->config_set->select_all("fid = $fid");
		if(count($oldconfig)>0) {
			foreach($oldconfig as $_config) {
				$this->delete_config($_config['cid']);
			}
		}
		if($fromUser == 1) {
			alert_and_back('成功删除设备!');
		}
	}
	// ripple
	function delete_config($cid) {
		$this->config_set->delete($cid);
		//$oldchanges = $this->changes_set->select_all("conid = $cid");
		$this->changes_set->delete($cid, 'conid');
			
	}
	
	
	function delete_all() {
		$fid = get_request('chk_facility', 1, 1);
		foreach($fid as $_fid) {
			$this->delete($_fid);
		}
		alert_and_back('成功删除所选设备!');
	}

	function del_dir() {
		$chk_delete = get_request('chk_delete', 1, 1);
		$fid = get_request('fid');
		if($chk_delete == null) {
			alert_and_back('没有选中日期!');
		}
		else {
			foreach($chk_delete as $date) {
				$changes = $this->changes_set->select_all(" DATE_FORMAT( changetime, '%Y-%m-%d' ) = '$date' AND fid = '$fid'");
				foreach($changes as $change)
					$this->changes_set->delete($change['chid']);
			}
			alert_and_back('已删除选中日期的记录!', "admin.php?controller=admin_facility&action=detail&fid=$fid");
		}
	}
}
?>
