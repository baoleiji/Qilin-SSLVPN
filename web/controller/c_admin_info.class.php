<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}
class c_admin_info extends c_base {
	
	function index(){
		$module = get_request('module', 0, 1);
		$tabname=get_request('tabname', 0, 1);
		switch($module){
			case 'general':
				$tab = array(
					array(
						'tabname'=> 'general',
						'title'=> '系统信息'
					)
				);
				switch($tabname){
					case 'general':
						$tabname= 'general';
						$url = 'info/index.php';
						break;
				}
				$this->assign("tabname", $tabname);
				break;
			default:
				$tab = array(
					array(
						'tabname'=> 'general',
						'title'=> '系统信息'
					)
				);
				$url = 'info/index.php';
				$module='general';
				$tabname= 'general';
				$this->assign("tabname", $tabname);
				break;
		}
		$this->assign("url", $url);
		$this->assign("tab", $tab);
		$this->assign("module", $module);
		$this->assign("action", "index");
		$this->display("info.tpl");
	}
}
?>
