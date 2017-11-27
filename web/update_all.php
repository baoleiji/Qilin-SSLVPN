<?php

require_once('./include/common.inc.php');
require_once(ROOT . './include/global.func.php');
require_once(ROOT . './controller/c_base.class.php');
require_once(ROOT . './controller/c_admin_crontab.class.php');

session_cache_limiter("no-cache");
session_start();
//Smarty初始化
$smarty = new Smarty(); 
$smarty->template_dir = ROOT . "./template/admin";
$smarty->compile_dir = ROOT . "./template_c/admin";
$smarty->cache_dir = './template_cache/admin';
$smarty->left_delimiter = "{{"; 
$smarty->right_delimiter = "}}";
$smarty->caching = 0;
$smarty->assign('template_root', './template/admin');
//创建控制器
$c = new c_admin_crontab();

$c->init($smarty, $_CONFIG);
//执行控制器的方法
$c->update_all();

?>
