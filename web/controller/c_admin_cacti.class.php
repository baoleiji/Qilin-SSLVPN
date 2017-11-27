<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}
class c_admin_cacti extends c_base {
	function tholdmanage() {
		$_SESSION["sess_user_id"]=1;
		$module = get_request('module', 0, 1);
		$tab = array(
			);
		switch($module){
			case 'tholdmanage':
				$url = 'cacti/thold.php';
				break;
			default:
				$url = 'cacti/thold.php';
				$module='tholdtemplate';
				break;
		}
		$this->assign("url", $url);
		$this->assign("tab", $tab);
		$this->assign("module", $module);
		$this->assign("action", "tholdmanage");
		$this->display("cacti.tpl");
	}


	function reports() {
		$_SESSION["sess_user_id"]=1;
		$module = get_request('module', 0, 1);
	
		switch($module){
			case 'host':
				$tab = array(
					array(
						'tabname'=> 'status',
						'title'=> '主机报表'
					)
				);
				switch($tabname){
					default :
						$tabname= 'status';						
						$url = 'cacti/rrd_reports.php';
						break;
				}				
				$this->assign("tabname", $tabname);				
				break;
			case 'network':
				$tab = array(
					array(
						'tabname'=> 'status',
						'title'=> '网络报表'
					)
				);
				switch($tabname){
					default :
						$tabname= 'status';						
						$url = 'cacti/rrdnetwork_reports.php';
						break;
				}				
				$this->assign("tabname", $tabname);	
				
				break;
			case 'app':
				$tab = array(
					array(
						'tabname'=> 'status',
						'title'=> '应用报表'
					)
				);
				switch($tabname){
					default :
						$tabname= 'status';						
						$url = 'cacti/rrdapp_reports.php';
						break;
				}				
				$this->assign("tabname", $tabname);	
				
				break;
			default:
				$url = 'cacti/rrd_reports.php';
				$module='host';
				break;
		}
		$this->assign("url", $url);
		$this->assign("tab", $tab);
		$this->assign("module", $module);
		$this->assign("action", "reports");
		$this->display("cacti.tpl");
	}

	function monitor(){
		$_SESSION["sess_user_id"]=1;
		$module = get_request('module', 0, 1);
		$tabname = get_request('tabname', 0, 1);
		if(empty($module)){
			$module = 'listsystem';
		}
		switch($module){
			case 'listsystem':
				$tab = array(
					array(
						'tabname'=> 'listsystem',
						'title'=> '系统监控'
					)
				);
				switch($tabname){
					default :
						$tabname= 'listsystem';
						$url = 'cacti/hostdata.php';				
						break;
				}
				$this->assign("tabname", $tabname);
				break;
			case 'listnetwork':
				$tab = array(
					array(
						'tabname'=> 'listnetwork',
						'title'=> '端口监控'
					),
					array(
						'tabname'=> 'listnetworktraf',
						'title'=> '流量监控'
					)
				);
				switch($tabname){
					case 'listnetworktraf':
						$tabname= 'listnetworktraf';
						$url = 'cacti/networktrafdata.php';
						break;
					default :
						$tabname= 'listnetwork';
						$url = 'cacti/networkdata.php';
						break;
				}				
				$this->assign("tabname", $tabname);
				break;
			case 'listapp':
				$tab = array(
					array(
						'tabname'=> 'listnetwork',
						'title'=> '应用监控'
					)
				);
				switch($tabname){
					default :
						$tabname= 'listnetwork';
						$url = 'cacti/appdata.php';
						break;
				}				
				$this->assign("tabname", $tabname);				
				break;
			case 'topology':
				$tab = array(
					array(
						'tabname'=> 'topology',
						'title'=> '拓扑图'
					)
				);
				switch($tabname){
					default :
						$tabname= 'topology';
						$url = 'cacti/plugins/weathermap/weathermap-cacti-plugin.php';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			case 'status':
				$tab = array(
					array(
						'tabname'=> 'status',
						'title'=> '状态监控'
					)
				);
				switch($tabname){
					default :
						$tabname= 'status';
						$url = 'cacti/plugins/monitor/monitor.php';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			case 'networkmanage':
				$tab = array(
					array(
						'tabname'=> 'networkmanage',
						'title'=> '设备管理'
					),
					array(
						'tabname'=> 'hostgroup',
						'title'=> '设备组管理'
					)
				);
				switch($tabname){
					case 'hostgroup':
						$tabname= 'hostgroup';						
						$url = 'cacti/host_group.php';
						break;
					default :
						$tabname= 'networkmanage';						
						$url = 'cacti/host.php';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			case 'thold':
				$tab = array(
					array(
						'tabname'=> 'thold',
						'title'=> '阈值管理'
					)
				);
				switch($tabname){
					default :
						$tabname= 'thold';						
						$url = 'cacti/thold.php';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			case 'tholdlog':
				$tab = array(
					array(
						'tabname'=> 'tholdlog',
						'title'=> '告警统计'
					)
				);
				switch($tabname){
					default :
						$tabname= 'tholdlog';						
						$url = 'cacti/tholdlog.php';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			case 'topologymanage':
				$tab = array(
					array(
						'tabname'=> 'topologymanage',
						'title'=> '拓扑图管理'
					)
				);
				switch($tabname){
					default :
						$url = 'cacti/plugins/weathermap/weathermap-cacti-plugin-mgmt.php';
						$tabname= 'topologymanage';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			case 'port':
				$tab = array(
					array(
						'tabname'=> 'port',
						'title'=> '端口监控'
					)
				);
				switch($tabname){
					default :
						$tabname= 'port';						
						$url = 'cacti/alarmtab.php';
						break;
				}				
				$this->assign("tabname", $tabname);
				break;
			case 'portstandard':
				$tab = array(
					array(
						'tabname'=> 'portstandard',
						'title'=> '端口基准'
					)
				);
				switch($tabname){
					default :
						$url = 'cacti/listsnmpstatus.php';
						$tabname= 'portstandard';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			default:
				$url = 'cacti/hostdata.php';
				$module='listsystem';
				break;
		}
		$this->assign("url", $url);
		$this->assign("tab", $tab);
		$this->assign("module", $module);
		$this->assign("action", "monitor");
		$this->display("cacti.tpl");
	}

	function template(){
		$_SESSION["sess_user_id"]=1;
		$module = get_request('module', 0, 1);
		$tabname=get_request('tabname', 0, 1);
		switch($module){
			case 'graph':
				$tab = array(
					array(
						'tabname'=> 'graph',
						'title'=> '图形模版'
					)
				);
				switch($tabname){
					default :
						$url = 'cacti/graph_templates.php';
						$tabname= 'graph';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			case 'host':
				$tab = array(
					array(
						'tabname'=> 'host',
						'title'=> '主机模版'
					)
				);
				switch($tabname){
					default :
						$url = 'cacti/host_templates.php';
						$tabname= 'host';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			case 'color':
				$tab = array(
					array(
						'tabname'=> 'color',
						'title'=> '颜色模版'
					)
				);
				switch($tabname){
					default :				
						$url = 'cacti/plugins/aggregate/color_templates.php';
						$tabname= 'color';
						break;
				}				
				$this->assign("tabname", $tabname);
				break;
			case 'manage':				
				$tab = array(
					array(
						'tabname'=> 'import',
						'title'=> '导入'
					),
					array(
						'tabname'=> 'export',
						'title'=> '导出'
					)
				);
				switch($tabname){
					case 'export':
						$tabname= 'export';
						$url = 'cacti/templates_export.php';
						break;
					default :
						$tabname= 'import';
						$url = 'cacti/templates_import.php';						
						break;
				}
				$this->assign("tabname", $tabname);
				break;
			case 'poller':				
				$tab = array(
					array(
						'tabname'=> 'dataquery',
						'title'=> '数据查询'
					),
					array(
						'tabname'=> 'datatemplate',
						'title'=> '数据模版'
					)
				);
				switch($tabname){
					case 'datatemplate':
						$tabname= 'datatemplate';
						$url = 'cacti/data_templates.php';
						break;
					default :
						$tabname= 'dataquery';
						$url = 'cacti/data_queries.php';						
						break;
				}
				$this->assign("tabname", $tabname);
				break;
		
			default:
				$url = 'cacti/graph_templates.php';
				$module='graph';
				break;
		}
		$this->assign("url", $url);
		$this->assign("tab", $tab);
		$this->assign("module", $module);
		$this->assign("action", "template");
		$this->display("cacti.tpl");
	}

	function settings(){
		$_SESSION["sess_user_id"]=1;
		$module = get_request('module', 0, 1);
		$tabname=get_request('tabname', 0, 1);
		switch($module){
			case 'general':
				$tab = array(
					array(
						'tabname'=> 'general',
						'title'=> '常规'
					),
					array(
						'tabname'=> 'path',
						'title'=> '路径'
					),
					array(
						'tabname'=> 'poller',
						'title'=> '采集器'
					),
					array(
						'tabname'=> 'export',
						'title'=> '导出图形'
					),
					array(
						'tabname'=> 'visual',
						'title'=> '效果'
					),
					array(
						'tabname'=> 'authentication',
						'title'=> '验证'
					),
					array(
						'tabname'=> 'misc',
						'title'=> '杂项'
					),
					array(
						'tabname'=> 'tholdsetting',
						'title'=> '告警设置'
					)
				);
				switch($tabname){
					case 'general':
						$tabname= 'general';
						$url = 'cacti/settings.php?tab=general';
						break;
					case 'path':
						$tabname= 'path';
						$url = 'cacti/settings.php?tab=path';
						break;
					case 'poller':
						$tabname= 'poller';
						$url = 'cacti/settings.php?tab=poller';
						break;
					case 'export':
						$tabname= 'export';
						$url = 'cacti/settings.php?tab=export';
						break;
					case 'visual':
						$tabname= 'visual';
						$url = 'cacti/settings.php?tab=visual';
						break;
					case 'authentication':
						$tabname= 'authentication';
						$url = 'cacti/settings.php?tab=authentication';
						break;
					case 'misc':
						$tabname= 'misc';
						$url = 'cacti/settings.php?tab=misc';
						break;
					case 'tholdsetting':
						$tabname= 'tholdsetting';
						$url = 'cacti/thold_setting.php';
						break;
					
					default :
						$tabname= 'general';
						$url = 'cacti/settings.php?tab=general';						
						break;
				}
				$this->assign("tabname", $tabname);
				break;
			case 'tool':
				$tab = array(
					array(
						'tabname'=> 'utilities',
						'title'=> 'CactiEZ系统工具'
					),
					array(
						'tabname'=> 'addlistrrd',
						'title'=> '重置RRD缓冲'
					),
					array(
						'tabname'=> 'addlistsnmp',
						'title'=> 'snmp端口初始化'
					)
				);
				switch($tabname){
					case 'utilities':
						$tabname= 'utilities';
						$url = 'cacti/utilities.php';
						break;
				
					case 'addlistrrd':
						$tabname= 'addlistrrd';
						$url = 'cacti/addlistrrd.php';
						break;
					case 'addlistsnmp':
						$tabname= 'addlistsnmp';
						$url = 'cacti/addlistsnmp.php';
						break;
					default :
						$tabname= 'utilities';
						$url = 'cacti/utilities.php';						
						break;
				}
				$this->assign("tabname", $tabname);
				break;
			default:
				$url = 'cacti/settings.php?tab=general';
				$module='general';
				break;
		}
		$this->assign("url", $url);
		$this->assign("tab", $tab);
		$this->assign("module", $module);
		$this->assign("action", "settings");
		$this->display("cacti.tpl");
	}

	function users(){
		$_SESSION["sess_user_id"]=1;
		$module = get_request('module', 0, 1);
		$tabname=get_request('tabname', 0, 1);
		switch($module){
			case 'users':
				$tab = array(
					array(
						'tabname'=> 'users',
						'title'=> '用户管理'
					)
				);
				switch($tabname){
					default :				
						$url = 'cacti/user_admin.php';
						$tabname= 'users';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			case 'password':
				$tab = array(
					array(
						'tabname'=> 'password',
						'title'=> '密码修改'
					)
				);
				switch($tabname){
					default :				
						$url = 'cacti/user_admin.php?action=user_edit&tab=user_realms_edit&id=1';
						$tabname= 'password';
						break;
				}				
				$this->assign("tabname", $tabname);
				
				break;
			default:
				$url = 'cacti/user_admin.php';
				$module='users';
				break;
		}
		$this->assign("url", $url);
		$this->assign("tab", $tab);
		$this->assign("module", $module);
		$this->assign("action", "template");
		$this->display("cacti.tpl");
	}

}
?>
