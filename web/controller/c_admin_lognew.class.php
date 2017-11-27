<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}
class c_admin_lognew extends c_base {

	function index(){
		$_SESSION["sess_user_id"]=1;
		$module = get_request('module', 0, 1);
		$tabname=get_request('tabname', 0, 1);
		switch($module){
			case 'search':
				$tab = array(
					array(
						'tabname'=> 'today',
						'title'=> '今日'
					),
					array(
						'tabname'=> 'searchall',
						'title'=> '搜索'
					)
				);
				switch($tabname){
					case 'today':
						$tabname= 'today';
						$url = 'log/admin.php?c=admin_search&a=search&table=logs&excludeHost=1&excludeFacility=1&excludePriority=1&limit=20&orderby=seq&order=DESC&collapse=1&type=today';
						break;
					default :
						$tabname= 'searchall';
						$url = 'log/admin.php?c=admin_search';						
						break;
				}
				$this->assign("tabname", $tabname);
				break;
			case 'alert':
				$tab = array(
					array(
						'tabname'=> 'alert',
						'title'=> '告警'
					)
				);
				switch($tabname){
					default :				
						$url = 'log/admin.php?c=admin_alert';
						$tabname= 'alert';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			case 'filter':
				$tab = array(
					array(
						'tabname'=> 'filter',
						'title'=> '过滤'
					)
				);
				switch($tabname){
					default :				
						$url = 'log/admin.php?c=admin_filter';
						$tabname= 'filter';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			case 'manage':
				$tab = array(
					array(
						'tabname'=> 'manage',
						'title'=> '管理'
					),
					array(
						'tabname'=> 'manageNew',
						'title'=> '管理new'
					)
				);
				switch($tabname){
					case 'manageNew':
						$tabname= 'manageNew';
						$url = 'log/admin.php?c=admin_systemNew';
						break;
					default :				
						$url = 'log/admin.php?c=admin_system';
						$tabname= 'manage';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
		
			default:
				$url = 'log/admin.php?c=admin_search&tabname=today';
				$search='graph';
				break;
		}
		$this->assign("url", $url);
		$this->assign("tab", $tab);
		$this->assign("module", $module);
		$this->assign("action", "index");
		$this->display("log.tpl");
	}

}
?>
