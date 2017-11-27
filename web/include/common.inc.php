<?php
header('Content-Type: text/html; charset=UTF-8');
//header("Cache-Control: no-cache"); 

define ('CAN_RUN', true);
define('ROOT', substr(dirname(__FILE__), 0, -7));
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());


require_once ROOT. './include/config.inc.php';

/*//include cacti file
if($_CONFIG['CACTI_ON']){
	
	include_once(ROOT."/cacti/include/global.php");
	include_once(ROOT."/cacti/lib/utility.php");
	include_once(ROOT."/cacti/lib/data_query.php");
	include_once(ROOT."/cacti/lib/api_data_source.php");
	include_once(ROOT."/cacti/lib/api_graph.php");
	require_once(ROOT.'/cacti/lib/api_device.php');
	require_once(ROOT.'/cacti/lib/auth.php');
}
//cacti end*/

require_once ROOT. './include/fpdf/chinese.php';
require_once ROOT. './include/db_connect.inc.php';
require_once ROOT. './include/pager.class.php';
require_once ROOT. './smarty/Smarty.class.php';




define('DATA_PATH', $_CONFIG['site']['DATA_PATH']);

function __autoload($class_name) {
	if(file_exists(ROOT. './model/' . $class_name . '.class.php')) {
    	require_once ROOT. './model/' . $class_name . '.class.php';
	}
	else if(file_exists(ROOT. './do_config/' . $class_name . '.class.php')) {
    	require_once ROOT. './do_config/' . $class_name . '.class.php';
	}else if(file_exists(ROOT. './smarty/sysplugins/' . strtolower($class_name) . '.php')) {
    	require_once ROOT. './smarty/sysplugins/' . strtolower($class_name) . '.php';
	}else if(file_exists(ROOT. './smarty/plugins/' . strtolower($class_name) . '.php')) {
    	require_once ROOT. './smarty/plugins/' . strtolower($class_name) . '.php';
	}
}
?>
