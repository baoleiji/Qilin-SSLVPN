<?php

require_once('./include/common.inc.php');
require_once(ROOT . './include/global.func.php');
require_once(ROOT . './include/email.php');
require_once(ROOT . './controller/c_base.class.php');


$controller = 'c_webservice';

if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = 'index';
}

if(file_exists(ROOT ."./controller/$controller.class.php")) {
	require_once(ROOT ."./controller/$controller.class.php");
	
	$newcontroller = new $controller();
	
	if(method_exists($newcontroller, $action)) {
		if($newcontroller->validateKey($action)) {
			//Smarty初始化
			$smarty = new Smarty();
			$smarty->template_dir = ROOT . "./template/admin";
			$smarty->compile_dir = ROOT . "./template_c/admin";
			$smarty->cache_dir = './template_cache/admin';
			$smarty->left_delimiter = "{{";
			$smarty->right_delimiter = "}}";
			$smarty->caching = 0;
			$smarty->assign('template_root', './template/admin');
						
			$newcontroller->init($smarty, $_CONFIG);
			$result = $newcontroller->$action();
			
		} else {
			$result = array("ret" => "keyError");
		}
		
		echo $newcontroller->getOutput($result);
		//echo json_encode($result);
		
	} else {
		echo "无效的操作";
	}
	
} else {
	echo "无效的控制器";
}


