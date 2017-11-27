<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_compare extends c_base {
	function index() {
		$page_num = get_request('page');

		$row_num = $this->compare_set->select_count("1 = 1");
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$alldevice =  $this->compare_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage);


		$out = $alldevice;
		for($i=0;$i<count($out);$i++) {
			$out[$i]['user_username'] = $alldevice[$i]['user_username'];
			$out[$i]['user_pass'] = $alldevice[$i]['user_pass'];
			$out[$i]['enable_pass'] = $alldevice[$i]['enable_pass'];
		}


		$this->assign("alldevice",$out);

		$this->display("device_list.tpl");
	}

	function device_add() {
		$ntype = get_request('type',0,1);
		if($ntype == 'new') {
			$this->assign('title', '添加设备');			
		}
		else {
			$this->assign('title', '修改设备信息');
			$id = get_request('id');
			$oldequip =$this->compare_set->select_by_id($id);
			$this->assign('equipip', $oldequip['ip']);
			$this->assign('conn_type', $oldequip['conn_type']);
			$this->assign('dev_type', $oldequip['dev_type']);
			$this->assign('port',$oldequip['port']);
			$this->assign('username',$oldequip['user_username']);
			$this->assign('password',$oldequip['user_pass']);
			$this->assign('enable_pass',$oldequip['enable_pass']);
			$this->assign('allgroup',$allgroup);
			$this->assign('oldtemplate',$oldequip['template']);
			$this->assign('id', $id);
		}
		$this->assign('type',$ntype);
		$templates = $this->template_set->select_all();
		$this->assign("template",$templates);
		$this->display('device_edit.tpl');
	}

	function device_save() {
		$ntype = get_request('type',0,1);
		$ip = get_request('ip',1,1);
		$conn_type = get_request('conn_type',1,1);
		$dev_type = get_request('dev_type',1,1);
		$port = get_request('port',1,0);
		$username = get_request('username',1,1);
		$password = get_request('password',1,1);
		$enable_pass = get_request('enable_pass',1,1);
		$template = get_request('template',1,0);

		$device = new compare();
		$device->set_data('ip',$ip);
		$device->set_data('conn_type',$conn_type);
		$device->set_data('dev_type',$dev_type);
		$device->set_data('port',$port);
		$device->set_data('user_username',$username);
		$device->set_data('user_pass',$password);
		$device->set_data('enable_pass',$enable_pass);
		$device->set_data('template',$template);
		if ($ntype == 'new') {			
			$this->compare_set->add($device);
			alert_and_back('添加成功','admin.php?controller=admin_compare');
		}
		else 	{
			$id= get_request('id');
			$device->set_data('id',$id);
			$this->compare_set->edit($device);
			alert_and_back('编辑成功','admin.php?controller=admin_compare');

		}
	}

	function device_del() {
		$id = get_request('id');
		$this->compare_set->delete($id);
		$this->subfile_set->delete2("stid = $id");
		alert_and_back('删除成功','admin.php?controller=admin_compare');
	}
	
	function compare() {
		/*
		$ip = get_request('ip',0,1);
		exec('/opt/freesvr/audit/config_audit/./file_md5_check.pl '.escapeshellarg($ip),$output);
		//echo '/opt/freesvr/audit/config_audit/./file_md5_check.pl '.escapeshellarg($ip);
		//var_dump($output);
		$this->assign('msg',$output);
		$this->display('compare.tpl');
		//foreach($output as $tmp)
		//{
		//	print htmlspecialchars($tmp)."br";
		//}
		*/
		$id = get_request('id');
		$diff = $this->compare_set->select_by_id($id);
		switch($diff["diff"]) {
			case 0:
				$this->assign('msg',0);
				break;
			case 1:
				$this->assign('msg',nl2br($diff["detail"]));
				break;
			case 2:
				$this->assign('msg',2);
				break;
	
		}
		$this->display('compare.tpl');
	}


	function cover() {
		$id = get_request('id',0,1);
		$device = $this->compare_set->select_by_id($id);
		$ip = $device["ip"];
		$type = $device["dev_type"];
		$base = "/opt/freesvr/audit/config_audit/cache";
		$newdevice = new compare();
		$newdevice->set_data("id",$id);
		$newdevice->set_data("diff",0);
		switch($type) {
			case "linux" :
				if(is_dir("$base/$ip/config_audit/")) {
				//	$this->deltree("$base/$ip/baseline");
				//	rmdir("$base/$ip/baseline");
					exec("rm -fr $base/$ip/baseline");
					exec("mv $base/$ip/config_audit/ $base/$ip/baseline");
					$this->compare_set->edit($newdevice);
				}
				else {
					alert_and_back("最新配置不存在，更新失败","admin.php?controller=admin_compare");
				}
				break;
			case "huawei" :
				if(file_exists("$base/$ip/vrpcfg.txt")) {
					unlink("$base/$ip/baseline");
					exec("mv $base/$ip/vrpcfg.txt $base/$ip/baseline");
					$this->compare_set->edit($newdevice);
				}
				else {
					alert_and_back("最新配置不存在，更新失败","admin.php?controller=admin_compare");
				}
				break;
			case "cisco" :
				if(file_exists("$base/$ip/running-config")) {
					unlink("$base/$ip/baseline");
					exec("mv $base/$ip/running-config $base/$ip/baseline");
					$this->compare_set->edit($newdevice);
				}
				else {
					alert_and_back("最新配置不存在，更新失败","admin.php?controller=admin_compare");
				}
				break;
			default :
				alert_and_back("类型错误，更新失败","admin.php?controller=admin_compare");
		}
		alert_and_back("更新成功","admin.php?controller=admin_compare");

		
	}

function deltree($dir) {
  if ($handle = opendir("$dir")) {
   while (false !== ($item = readdir($handle))) {
     if ($item != "." && $item != "..") {
       if (is_dir("$dir/$item")) {
         deltree("$dir/$item");
       } else {
         unlink("$dir/$item");
         echo " removing $dir/$item<br>\n";
       }
     }
   }
   closedir($handle);
   rmdir($dir);
   echo "removing $dir<br>\n";
  }
}

/*
function deltree($dir){ 
	$d = dir($dir); 
	while($f = $d->read() ){ 
		if($f != "." && $f != ".."){ 
			if(is_dir($dir.$f)){ 
				deltree($dir.$f."/"); 
				rmdir($dir.$f); 
		} // if 
		if(is_file($dir.$f)) 
			unlink($dir.$f); 
		}// if 
	}// while 
	$d->close(); 
} 
*/


	function get_config() {
		$ip = get_request('ip',0,1);
		$type = get_request('type',0,1);
		$filename = '';
		switch ($type) {
		case 'linux':
			$filename='linux_audit_config_pull.pl';
			break;
		case 'cisco':
			$filename='cisco_audit_config_pull.pl';
			break;
		case 'huawei':
			$filename='huawei_audit_config_pull.pl';
			break;
		}
		exec("/opt/freesvr/audit/config_audit/./$filename ".$ip,$output);
		//alert_and_close('最新配置抓取成功');

	}


	function file_list() {
		$page_num = get_request('page');
		$tid = get_request('tid');
		$ttype = get_request("ttype",0,1);
		if($ttype == "temp")
			$row_num = $this->linuxfile_set->select_count("tid = $tid");
		else {
			$row_num = $this->subfile_set->select_count("stid = $tid");
		}
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		if($ttype == "temp") {
			$allfile =  $this->linuxfile_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,"tid = $tid");
		}
		else {
			$allfile =  $this->subfile_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage,"stid = $tid");
		}

		$this->assign('max_num',$allfile[count($allfile)-1]["fid"]);
		$this->assign("allfile",$allfile);
		$this->assign("tid",$tid);
		$this->assign("ttype",$ttype);
		$this->display('file_list.tpl');
	}

	function file_add() {
		$filename = get_request('filename',1,1);
		$tid = get_request('tid');
		$fid = get_request('fid');
		$ttype = get_request("ttype",0,1);

		if($ttype =="temp") {
			if ($this->linuxfile_set->select_count("fpath = '$filename' and tid = $tid") > 0 ) {
				alert_and_back('这个文件已被监控','admin.php?controller=admin_compare&action=file_list&ttype=temp&tid='.$tid);
			}
			else {
				$newfile = new linuxfile();
				$newfile->set_data('fpath',$filename);
				$newfile->set_data('tid',$tid);
				$newfile->set_data('fid',$fid);
				$this->linuxfile_set->add2($newfile);
				alert_and_back('添加成功','admin.php?controller=admin_compare&action=file_list&ttype=temp&tid='.$tid);
			}
		}
		else {
			if ($this->subfile_set->select_count("fpath = '$filename' and stid = $tid") > 0 ) {
				alert_and_back('这个文件已被监控','admin.php?controller=admin_compare&action=file_list&ttype=sub&tid='.$tid);
			}
			else {
				$newfile = new subfile();
				$newfile->set_data('fpath',$filename);
				$newfile->set_data('stid',$tid);
				$newfile->set_data('fid',$fid);
				$this->subfile_set->add2($newfile);
				alert_and_back('添加成功','admin.php?controller=admin_compare&action=file_list&ttype=sub&tid='.$tid);
			}
		}

	}

	function file_del() {
		$tid = get_request('tid');
		$fid = get_request('fid');
		$ttype = get_request("ttype",0,1);
		if($ttype =="temp") {
			$this->linuxfile_set->delete2("fid = $fid and tid = $tid");
		}
		else {
			$this->subfile_set->delete2("fid = $fid and stid = $tid");
		}
		alert_and_back('删除成功',"admin.php?controller=admin_compare&action=file_list&ttype=$ttype&tid=$tid");
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

	function template_list() {
		$page_num = get_request('page');
		$row_num = $this->template_set->select_count("1 = 1");
		$newpager = new my_pager($row_num, $page_num, $this->config['site']['items_per_page'], 'page');
		$this->assign('page_list', $newpager->showSerialList());
		$this->assign('command_num', $row_num);
		$this->assign('curr_page', $newpager->intCurrentPageNumber);
		$this->assign('total_page', $newpager->intTotalPageCount);
		$this->assign('items_per_page', $newpager->intItemsPerPage);
		
		$alltemplate =  $this->template_set->select_limit($newpager->intStartPosition, $newpager->intItemsPerPage);

		$this->assign("template",$alltemplate);

		$this->display('template_list.tpl');
	}

	function template_add() {
		$name = get_request('name',1,1);
		if ($this->template_set->select_count("name = '$name'") > 0 ) {
			alert_and_back('这个模板已存在','admin.php?controller=admin_compare&action=template_list');
		}
		else {
			$newtemplate = new template();
			$newtemplate->set_data('name',$name);
			$this->template_set->add($newtemplate);
			$tid = mysql_insert_id();

			
			$tempid = get_request('tempid',1,0);
			if($tempid != 0) {
				$files = $this->linuxfile_set->select_all("tid = $tempid");
				$fid = 1;
				foreach($files as $file) {
					$newfile = new linuxfile();
					$newfile->set_data('fpath',$file['fpath']);
					$newfile->set_data('tid',$tid);
					$newfile->set_data('fid',$fid);
					$this->linuxfile_set->add2($newfile);
					$fid++;
				}
			}
			alert_and_back('添加成功','admin.php?controller=admin_compare&action=template_list');
		}

	}

	function template_del() {
		$id = get_request('id');
		if ($this->compare_set->select_count("template = $id") > 0 ) {
			alert_and_back('还有设备使用这个模板','admin.php?controller=admin_compare&action=template_list');
		}
		else {
			$this->template_set->delete($id);
			$this->linuxfile_set->delete2("tid = $id");
			alert_and_back('删除成功','admin.php?controller=admin_compare&action=template_list');
		}

	}
}
?>
