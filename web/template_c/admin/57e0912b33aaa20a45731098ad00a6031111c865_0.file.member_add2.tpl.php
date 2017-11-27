<?php /* Smarty version 3.1.27, created on 2017-08-24 22:57:35
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/member_add2.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1676784064599ee95fcde822_50884427%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '57e0912b33aaa20a45731098ad00a6031111c865' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/member_add2.tpl',
      1 => 1503586624,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1676784064599ee95fcde822_50884427',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'allusbkey' => 0,
    '_config' => 0,
    'allsgroup' => 0,
    'ldaps' => 0,
    'ads' => 0,
    'radiususer' => 0,
    'member' => 0,
    'trnumber' => 0,
    'pwdshould' => 0,
    'priv' => 0,
    'otpenable' => 0,
    'shenmapriv' => 0,
    'huaweipriv' => 0,
    'radiusssh' => 0,
    'radiustelnet' => 0,
    'pwdconfig_password_ban_word' => 0,
    'pwdconfig_pwdstrong1' => 0,
    'pwdconfig_pwdstrong2' => 0,
    'pwdconfig_pwdstrong3' => 0,
    'pwdconfig_pwdstrong4' => 0,
    'pwdconfig_login_pwd_length' => 0,
    'vpnenable' => 0,
    'changelevelstr' => 0,
    'mchangelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_599ee95fe8cd15_18562232',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_599ee95fe8cd15_18562232')) {
function content_599ee95fe8cd15_18562232 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1676784064599ee95fcde822_50884427';
?>
<html >
<head>
<title><?php echo $_smarty_tpl->tpl_vars['language']->value['Master'];
echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 src="./template/admin/cssjs/jscal2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/cn.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/global.functions.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/_ajaxdtree.js"><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery.csv-0.71.min.js"><?php echo '</script'; ?>
>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />

<?php echo '<script'; ?>
 language="javascript">
	function check_add_user(){
		return(true);
	}

var AllUsbKey = new Array();
var i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['name'] = 'kk';
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allusbkey']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total']);
?>
AllUsbKey[i++]={keyid:'<?php echo $_smarty_tpl->tpl_vars['allusbkey']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['keyid'];?>
', type:<?php echo $_smarty_tpl->tpl_vars['allusbkey']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['type'];?>
};
<?php endfor; endif; ?>
function filter(){
	var filterStr = document.getElementById('filtertext').value;
	var usbkeyid = document.getElementById('usbkeyid');
	usbkeyid.options.length=1;
	for(var i=0; i<AllUsbKey.length;i++){
		if(filterStr.length==0 || AllUsbKey[i].keyid.indexOf(filterStr) >= 0){
			//if(usbkeytype==AllUsbKey[i].type){
				usbkeyid.options[usbkeyid.options.length++] = new Option(AllUsbKey[i].keyid,AllUsbKey[i].keyid);
			//}
		}
	}
}

function changeusbkeytype(t, v){
	var usbkeyid = document.getElementById('usbkeyid');
	usbkeyid.options[usbkeyid.options.length] = new Option('未绑定','');
	usbkeyid.options.length=1;
	for(var i=0; i<AllUsbKey.length;i++){
		//if(t==AllUsbKey[i].type){
			if(AllUsbKey[i].keyid==v){
				usbkeyid.options[usbkeyid.options.length++] = new Option(AllUsbKey[i].keyid,AllUsbKey[i].keyid, true, true);
			}else{
				usbkeyid.options[usbkeyid.options.length++] = new Option(AllUsbKey[i].keyid,AllUsbKey[i].keyid);
			}
		//}
	}
}
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 language=javascript>  
//CharMode函数
//测试某个字符<?php echo $_smarty_tpl->tpl_vars['language']->value['Yes'];?>
属于哪一类.  
function CharMode(iN){  
	if (iN>=48 && iN <=57) //数字  
		return 1;  
	if (iN>=65 && iN <=90) //大写字母  
		return 2;  
	if (iN>=97 && iN <=122) //小写  
		return 4;  
	else  
		return 8; //特殊字符  
}  
//bitTotal函数  
//计算出当前<?php echo $_smarty_tpl->tpl_vars['language']->value['Password'];?>
当<?php echo $_smarty_tpl->tpl_vars['language']->value['normal'];?>
一<?php echo $_smarty_tpl->tpl_vars['language']->value['all'];?>
有多少种模式  
function bitTotal(num){  
	modes=0;  
	for (i=0;i<4;i++){  
		if (num & 1) modes++;  
		num>>>=1;  
	}  
	return modes;  
}  
//checkStrong函数  
//返回<?php echo $_smarty_tpl->tpl_vars['language']->value['Password'];?>
的<?php echo $_smarty_tpl->tpl_vars['language']->value['strong'];?>
度级别  
function checkStrong(sPW){  
	if (sPW.length<=8)  
	return 0; //<?php echo $_smarty_tpl->tpl_vars['language']->value['Password'];?>
太短  
	Modes=0;  
	for (i=0;i<sPW.length;i++){  
	//测试每<?php echo $_smarty_tpl->tpl_vars['language']->value['one'];?>
字符的类别并统计一<?php echo $_smarty_tpl->tpl_vars['language']->value['all'];?>
有多少种模式.  
		Modes|=CharMode(sPW.charCodeAt(i));  
	}  
	return bitTotal(Modes);  
}  
//pwStrength函数  
//当<?php echo $_smarty_tpl->tpl_vars['language']->value['User'];?>
放开键盘<?php echo $_smarty_tpl->tpl_vars['language']->value['or'];
echo $_smarty_tpl->tpl_vars['language']->value['Password'];
echo $_smarty_tpl->tpl_vars['language']->value['Input'];?>
框失去焦点时,根据不同的级别<?php echo $_smarty_tpl->tpl_vars['language']->value['displayed'];?>
不同的颜色  
function pwStrength(pwd){  
	O_color="#eeeeee";  
	L_color="#FF0000";  
	M_color="#FF9900";  
	H_color="#33CC00";  
if (pwd==null||pwd==''){  
	Lcolor=Mcolor=Hcolor=O_color;  
}else{  
	S_level=checkStrong(pwd);  
switch(S_level) {  
	case 0:  
	Lcolor=Mcolor=Hcolor=O_color;  
	case 1:  
	Lcolor=L_color;  
	Mcolor=Hcolor=O_color;  
	break;  
	case 2:  
	Lcolor=Mcolor=M_color;  
	Hcolor=O_color;  
	break;  
	default:  
	Lcolor=Mcolor=Hcolor=H_color;  
}  
}
document.getElementById("strength_L").style.background=Lcolor;  
document.getElementById("strength_M").style.background=Mcolor;  
document.getElementById("strength_H").style.background=Hcolor;  
return;  
}  

<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['a'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['a']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['name'] = 'a';
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allsgroup']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total']);
?>
servergroup[i++]={id:<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['id'];?>
,name:'<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['groupname'];?>
',ldapid:<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['ldapid'];?>
,level:<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['level'];?>
};
<?php endfor; endif; ?>

<?php }?>

function changefirstauth(c,a){
	var s = document.getElementById('firstauth');
	if(!c)
	for(var i=0; i<s.options.length; i++){
		var at = (s.options[i].value.indexOf('_') > 0 ? s.options[i].value.substring(0, s.options[i].value.indexOf('_')) : s.options[i].value);
		if(at==a){
			s.options.remove(i);
			i--;
		}
	}
	else{
		switch(a){
			case 'ldapauth':
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['l'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['l']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['name'] = 'l';
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ldaps']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total']);
?>
				s.options[s.options.length]=new Option('LDAP <?php echo $_smarty_tpl->tpl_vars['ldaps']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['domain'];?>
', 'ldapauth_<?php echo $_smarty_tpl->tpl_vars['ldaps']->value[$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['address'];?>
');
				<?php endfor; endif; ?>
				break;
			case 'adauth':
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['a'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['a']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['name'] = 'a';
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['ads']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total']);
?>
				s.options[s.options.length]=new Option('AD <?php echo $_smarty_tpl->tpl_vars['ads']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['domain'];?>
', 'adauth_<?php echo $_smarty_tpl->tpl_vars['ads']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['address'];?>
');
				<?php endfor; endif; ?>
				break;
			case 'localauth':
				s.options[s.options.length]=new Option('本地登录', 'localauth');
				break;
			case 'radiusauth':
				s.options[s.options.length]=new Option('RADIUS', 'radiusauth');
				break;
			case 'fingersecauth':
				s.options[s.options.length]=new Option('指纹认证', 'fingersecauth');
				break;
			case 'localfingersecauth':
				s.options[s.options.length]=new Option('本地+指纹认证', 'localfingersecauth');
				break;
		}
	}
}
<?php echo '</script'; ?>
>  
<style>
A {
	COLOR: #000000; TEXT-DECORATION: none
}
#navbar {WIDTH: 98%; 
	
}
#header {
	LINE-HEIGHT: normal; WIDTH: 98%;  FONT-SIZE:12px; 
}
#header UL {
	 LIST-STYLE-TYPE: none; MARGIN: 0px 0px 0px 0px; height:27px;
}
#header LI {
	PADDING-BOTTOM: 0px; PADDING-LEFT: 0px; WIDTH: 109px; PADDING-RIGHT: 0px;  FLOAT: left;  color:#FFFFFF;   background-image:url(<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_bg2.jpg);height:32px; padding-top:5px;
}

#header A {
	PADDING-BOTTOM: 0px; PADDING-LEFT: 15px; PADDING-RIGHT: 15px; DISPLAY: block; PADDING-TOP: 5px;
}
#header .current {
	  BACKGROUND: #ffffff;   background-image:url(<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/tab_bg1.jpg);
}
#header .current A {
	PADDING-BOTTOM: 0px; font-weight:bold; color:#FFFFFF;
}
.content {
	MARGIN-TOP: 0px;
}
.content .contentMain {
	TEXT-ALIGN: left
}
</style>
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f1f1f1"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    
</ul><span class="back_img"><A href="admin.php?controller=admin_member&action=<?php if ($_smarty_tpl->tpl_vars['radiususer']->value) {
echo $_smarty_tpl->tpl_vars['radiususer']->value;
} elseif ($_GET['fromgroup']) {?>groupuser&gid=<?php echo $_GET['fromgroup'];
} else { ?>index<?php }?>&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="25" border="0"></A></span>
</div></td></tr>
	 </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f1f1f1"><tr><TD align="left" >	<FORM onSubmit="javascript: return check_add_user();" method=post 
      name=add_user 
      action=admin.php?controller=admin_member&action=save&uid=<?php echo $_smarty_tpl->tpl_vars['member']->value['uid'];?>
>
      <input type="password" style="display:none"/> 
      <?php if ($_SESSION['RADIUSUSERLIST']) {?>
<table bordercolor="white" cellspacing="0" cellpadding="1" border="0" width="100%"  class="BBtable" >
<tr><th colspan="3" class="list_bg"></th></tr>
				<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable(0, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
						<td width="33%" align=right><font color="red">*</font><?php echo $_smarty_tpl->tpl_vars['language']->value['Username'];?>
：</td>
						<TD align="left" ><input type="text" name="username" class="wbk input_shorttext" <?php if ($_smarty_tpl->tpl_vars['member']->value['uid']) {?>readonly<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['member']->value['username'];?>
"></td>
					</tr>
				<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
						<td width="33%" align=right><font color="red">*</font><?php echo $_smarty_tpl->tpl_vars['language']->value['Password'];?>
：</td>
						<TD align="left" >
						<span style="float:left; padding-top:10px;"><input type="password" id="password1" name="password1" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['member']->value['password'], ENT_QUOTES, 'UTF-8', true);?>
" class="input_shorttext" onKeyUp=pwStrength(this.value) 
onBlur=pwStrength(this.value) > <?php echo $_smarty_tpl->tpl_vars['pwdshould']->value;?>
 <input onClick="setrandompwd();" id="autosetpwd" type="checkbox" name="autosetpwd" value="1" />随机密码</span>
 <SPAN class="passwordcss">
                  <TABLE  border=0 cellSpacing=0  cellPadding=0 >
                    <TBODY>
                      <TR align=center bgColor=#F1F1F1>
                        <TD id=strength_L width="33%">弱</TD>
                        <TD id=strength_M width="33%">中</TD>
                        <TD id=strength_H  width="33%">强</TD>
                      </TR>
                    </TBODY>
                  </TABLE>
                </SPAN></td>
					</tr>
					<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
						<td width="33%" align=right><font color="red">*</font><?php echo $_smarty_tpl->tpl_vars['language']->value['Commitpassword'];?>
：</td>
						<TD align="left" ><input type="password"  id="password2" name="password2" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['member']->value['password'], ENT_QUOTES, 'UTF-8', true);?>
" class="input_shorttext"></td>
						</tr>
					
					
					<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr id="loginleveltr" <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
               
                  <TD  width="33%" align=right>Cisco授权级别： </TD>
                  <TD align="left" ><select  class="wbk"  name=priv>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['k'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=16) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total']);
?>
				<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['k']['index'];?>
" <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['k']['index'] == $_smarty_tpl->tpl_vars['priv']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['k']['index'];?>
</option>
			<?php endfor; endif; ?>
                  </SELECT>  
                  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;动态口令卡：含有字符<input type="text" class="wbk" size="10" id="filtertext" <?php if (!$_smarty_tpl->tpl_vars['otpenable']->value) {?>disabled<?php }?> onChange="filter();" />
                  <select  class="wbk"  name=usbkey id="usbkeyid"  <?php if (!$_smarty_tpl->tpl_vars['otpenable']->value) {?>disabled<?php }?>>
                      <OPTION value=""><?php echo $_smarty_tpl->tpl_vars['language']->value['nobind'];?>
</OPTION>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['k'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allusbkey']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total']);
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['allusbkey']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['keyid'];?>
" <?php if ($_smarty_tpl->tpl_vars['allusbkey']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['keyid'] == $_smarty_tpl->tpl_vars['member']->value['usbkey']) {?>selected<?php }?> <?php if ($_smarty_tpl->tpl_vars['allusbkey']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['bind']) {?>style="color:red"<?php }?>><?php echo $_smarty_tpl->tpl_vars['allusbkey']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['keyid'];?>
</option>
						<?php endfor; endif; ?>
                  </SELECT>&nbsp;&nbsp;
                 <select name="usbkeystatus" id="usbkeystatus">
                 <option value="11" <?php if (!$_smarty_tpl->tpl_vars['member']->value['uid'] || $_smarty_tpl->tpl_vars['member']->value['usbkeystatus'] == 11) {?>selected<?php }?>>手机未扫描</option>
                 <option value="0" <?php if ($_smarty_tpl->tpl_vars['member']->value['uid'] && $_smarty_tpl->tpl_vars['member']->value['usbkeystatus'] == 0) {?>selected<?php }?>>手机已扫描</option>
                 </select>            
				  </TD>
                </TR>
				<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr id="loginleveltr" <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
               
                  <TD  width="33%" align=right>神码交换机级别： </TD>
                  <TD align="left" ><input type="checkbox" name="shenmapriv" <?php if (!$_smarty_tpl->tpl_vars['member']->value || $_smarty_tpl->tpl_vars['shenmapriv']->value) {?>checked<?php }?> value=6>                  
				  </TD>
                </TR>
				<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr id="loginleveltr" <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
               
                  <TD  width="33%" align=right>华为授权级别： </TD>
                  <TD align="left" ><select  class="wbk"  name=huaweipriv>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['h'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['h']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['name'] = 'h';
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['loop'] = is_array($_loop=16) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['h']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['h']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['h']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['h']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['h']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['h']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['h']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['h']['total']);
?>
				<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['h']['index'];?>
" <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['h']['index'] == $_smarty_tpl->tpl_vars['huaweipriv']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['h']['index'];?>
</option>
			<?php endfor; endif; ?>
                  </SELECT>                  
				  </TD>
                </TR>
				<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr id="loginleveltr" <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
               
                  <TD  width="33%" align=right>登录协议： </TD>
                  <TD align="left" ><input type="checkbox" name="radiusssh" <?php if (!$_smarty_tpl->tpl_vars['member']->value['uid'] || $_smarty_tpl->tpl_vars['radiusssh']->value) {?>checked<?php }?> value="1" />SSH&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="radiustelnet"  <?php if (!$_smarty_tpl->tpl_vars['member']->value['uid'] || $_smarty_tpl->tpl_vars['radiustelnet']->value) {?>checked<?php }?> value="1" />TELNET
				  </TD>
                </TR>
				<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="33%" align=right>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['effectatdate'];?>
：		</td>
       <TD align="left" >
       <INPUT value="<?php echo $_smarty_tpl->tpl_vars['member']->value['start_time'];?>
" id="start_time" name="start_time" >&nbsp;&nbsp;
<input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk"></TD>
	</tr>
					<?php $_smarty_tpl->tpl_vars["trnumber"] = new Smarty_Variable($_smarty_tpl->tpl_vars['trnumber']->value+1, null, 0);?>
					<tr <?php if ($_smarty_tpl->tpl_vars['trnumber']->value%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
		<td width="33%" align=right>
		<?php echo $_smarty_tpl->tpl_vars['language']->value['Expiretime'];?>
：		</td>
       <TD align="left" >
       
       <INPUT value="<?php if ($_smarty_tpl->tpl_vars['member']->value['end_time'] != '2037-01-01 00:00:00') {
echo $_smarty_tpl->tpl_vars['member']->value['end_time'];
}?>" id="limit_time" name="limit_time" onFocus="setday(this)">&nbsp;&nbsp;<input type="button"  id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk"> 
  <?php echo '<script'; ?>
 type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true,
	popupDirection:'up'
});
cal.manageFields("f_rangeStart_trigger", "start_time", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "limit_time", "%Y-%m-%d %H:%M:%S");


<?php echo '</script'; ?>
>
                      <?php echo $_smarty_tpl->tpl_vars['language']->value['AlwaysValid'];?>
<INPUT value="1" <?php if ($_smarty_tpl->tpl_vars['member']->value['end_time'] == '2037-01-01 00:00:00' || !$_smarty_tpl->tpl_vars['member']->value['end_time']) {?> checked <?php }?> onclick="document.getElementById('limit_time').value=''" type=checkbox name="nolimit">  </TD>
	</tr>
		<tr><TD align="left" >&nbsp;</td><td align="left"><input type=submit  value="保存修改" class="an_02"></td></tr></table>
		<?php } else { ?>
  <DIV style="WIDTH:98%" id=navbar>
    <DIV  class=content>
        <TABLE width="98%" border="0" align="center" cellpadding="5" 
      cellspacing="0" class="BBtable">
	  <TR>
      <TD height="27" colspan="4" class="tb_t_bg">基本信息</TD>
    </TR>
          <TR bgcolor="#f7f7f7">
            <TD width="14%" align="right"><font color="red">*</font>用户名：</TD>
            <TD width="36%" align="left" ><input type="text" name="username" class="wbk input_shorttext" <?php if ($_smarty_tpl->tpl_vars['member']->value['uid']) {?>readonly<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['member']->value['username'];?>
"></TD>
            <TD width="14%" align="right"><font color="red">*</font>真实姓名：</TD>
            <TD align="left" ><input type="text"  name="realname" class="wbk input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['member']->value['realname'];?>
"></TD>
          </TR>
          <TR>
            <TD width="14%" align="right"><font color="red">*</font>密码：</TD>
            <TD width="36%" align="left" ><SPAN style=" padding-top:5px;float: left; width:250px;">
            
	 <input type="password" id="password1" name="password1" value="" class="input_shorttext" onKeyUp=pwStrength(this.value) 
onBlur=pwStrength(this.value) > <?php echo $_smarty_tpl->tpl_vars['pwdshould']->value;?>
 <input onClick="setrandompwd();" id="autosetpwd" type="checkbox" name="autosetpwd" value="1" />
              随机密码</SPAN>
              <SPAN class="passwordcss">
                  <TABLE  border=0 cellSpacing=0  cellPadding=0 style="width:50px;">
                    <TBODY>
                      <TR align=center bgColor=#F1F1F1>
                        <TD id=strength_L width="33%">弱</TD>
                        <TD id=strength_M width="33%">中</TD>
                        <TD id=strength_H  width="33%">强</TD>
                      </TR>
                    </TBODY>
                  </TABLE>
                </SPAN></TD>
            <TD align="right"><font color="red">*</font>确认密码：</TD>
            <TD align="left" ><input type="password"  id="password2" name="password2" value="" class="input_shorttext">&nbsp;&nbsp;&nbsp;强制修改密码<input type="checkbox" name="forceeditpassword" value="on" <?php if ($_smarty_tpl->tpl_vars['member']->value['forceeditpassword']) {?>checked<?php }?>></TD>
          </TR>
          <TR bgcolor="#f7f7f7">
            <TD align="right">电子邮件：</TD>
            <TD align="left" ><input type="text" name="email" class="wbk input_shorttext"value="<?php echo $_smarty_tpl->tpl_vars['member']->value['email'];?>
"></TD>
            <TD align="right">手机号码：</TD>
            <TD align="left" ><input type="text" name="mobilenum" class="input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['member']->value['mobilenum'];?>
"></TD>
          </TR>
          <INPUT name="priv2" type="hidden" 
        value="0">
          <TR>
            <TD align="right">工作单位：</TD>
            <TD align="left" ><input type="text" name="workcompany" class="input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['member']->value['workcompany'];?>
"> </TD>
            <TD align="right">工作部门：</TD>
            <TD align="left" ><INPUT name="workdepartment" class="input_shorttext" type="text" 
            value="<?php echo $_smarty_tpl->tpl_vars['member']->value['workdepartment'];?>
">            </TD>
          </TR>
          <TR bgcolor="#f7f7f7">
            <TD align="right"><font color="red">*</font>运维组： </TD>
            <TD >
			<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
   </TD>
            <TD align="right">证书CN：</TD>
      <TD align="left" ><input type="text" name="cacn" class="input_shorttext" value="<?php echo $_smarty_tpl->tpl_vars['member']->value['cacn'];?>
" style="width:280px"></TD>
          </TR>
           <TR bgcolor="">
      <TD align="right">生效时间： </TD>
      <TD align="left" ><INPUT value="<?php echo $_smarty_tpl->tpl_vars['member']->value['start_time'];?>
" id="start_time" name="start_time" >&nbsp;&nbsp;
<input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">
      </TD>
      <TD align="right">过期时间：</TD>
      <TD align="left" ><INPUT value="<?php if ($_smarty_tpl->tpl_vars['member']->value['end_time'] != '2037-01-01 00:00:00') {
echo $_smarty_tpl->tpl_vars['member']->value['end_time'];
}?>" id="limit_time" name="limit_time" onFocus="setday(this)">&nbsp;&nbsp;<input type="button"  id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk"> 
  <?php echo '<script'; ?>
 type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true,
	popupDirection:'up'
});
var cal2 = Calendar.setup({
    onSelect: function(cal2) { cal2.hide() },
    showTime: true,
	popupDirection:'up'
});
cal.manageFields("f_rangeStart_trigger", "start_time", "%Y-%m-%d %H:%M:%S");
cal2.manageFields("f_rangeEnd_trigger", "limit_time", "%Y-%m-%d %H:%M:%S");


<?php echo '</script'; ?>
>
                      <?php echo $_smarty_tpl->tpl_vars['language']->value['AlwaysValid'];?>
<INPUT value="1" <?php if ($_smarty_tpl->tpl_vars['member']->value['end_time'] == '2037-01-01 00:00:00' || !$_smarty_tpl->tpl_vars['member']->value['end_time']) {?> checked <?php }?> onclick="document.getElementById('limit_time').value=''" type=checkbox name="nolimit"> 
      </TD>
    </TR>
	<TR bgcolor="#f7f7f7">
      <TD align="right">启用：</TD>
      <TD align="left" ><input type="checkbox" name="enable" value="on" <?php if ($_smarty_tpl->tpl_vars['member']->value['enable'] || !$_smarty_tpl->tpl_vars['member']->value['uid']) {?>checked<?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;</TD>
     <TD align="right">VPN ：</TD>
      <TD align="left" ><select  class="wbk"  name=vpn >                     
							<option value="0" <?php if ($_smarty_tpl->tpl_vars['member']->value['vpn'] == 0) {?>selected<?php }?>>不允许</option>
							<option value="1" <?php if ($_smarty_tpl->tpl_vars['member']->value['vpn'] == 1 || !$_smarty_tpl->tpl_vars['member']->value['uid']) {?>selected<?php }?>>允许</option>
						</SELECT>&nbsp;&nbsp;&nbsp;
						VPN IP<input type="text" name="vpnip" value="<?php echo $_smarty_tpl->tpl_vars['member']->value['vpnip'];?>
" />
      </TD>
    </TR>
	
    <TR>
      <TD height="27" colspan="4" class="tb_t_bg">权限信息</TD>
    </TR>
    <TR bgcolor="#f7f7f7">
      <TD align="right">用户权限：</TD>
      <TD colspan="3"><ul style="LIST-STYLE-TYPE: none;"><li style=" float:left;width:100">
						<select  class="wbk"  name="level" onchange='changelevel(this.value);' <?php if (0 && $_smarty_tpl->tpl_vars['member']->value['uid']) {?>disabled<?php }?>>
							<option value="11" <?php if ($_smarty_tpl->tpl_vars['member']->value['level'] == 11) {?>selected<?php }?>>认证<?php echo $_smarty_tpl->tpl_vars['language']->value['User'];?>
</option>
							<option value="1" <?php if ($_smarty_tpl->tpl_vars['member']->value['level'] == 1) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['language']->value['Administrator'];?>
</option>
						</select></li></ul>&nbsp;&nbsp;
    
	管理路径：
	<?php $_smarty_tpl->tpl_vars['checkbox'] = new Smarty_Variable(1, null, 0);?>
	<?php $_smarty_tpl->tpl_vars['multipleselect'] = new Smarty_Variable(1, null, 0);?>
	<?php $_smarty_tpl->tpl_vars['select_group_id'] = new Smarty_Variable('mgroupid', null, 0);?>
	<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

	</TD>
    </TR>
	<TR>
     
    </TR>
	
    <TR>
      
      <TD align="right" >动态口令卡： </TD>
      <TD align="left" colspan="3">含有字符<input type="text" class="wbk" size="10" id="filtertext" <?php if (!$_smarty_tpl->tpl_vars['otpenable']->value) {?>disabled<?php }?> onChange="filter();" />
                  <select  class="wbk"  name=usbkey id="usbkeyid"  <?php if (!$_smarty_tpl->tpl_vars['otpenable']->value) {?>disabled<?php }?>>
                      <OPTION value=""><?php echo $_smarty_tpl->tpl_vars['language']->value['nobind'];?>
</OPTION>
                     	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['k'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allusbkey']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total']);
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['allusbkey']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['keyid'];?>
" <?php if ($_smarty_tpl->tpl_vars['allusbkey']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['keyid'] == $_smarty_tpl->tpl_vars['member']->value['usbkey']) {?>selected<?php }?> <?php if ($_smarty_tpl->tpl_vars['allusbkey']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['bind']) {?>style="color:red"<?php }?>><?php echo $_smarty_tpl->tpl_vars['allusbkey']->value[$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['keyid'];?>
</option>
						<?php endfor; endif; ?>
                  </SELECT>&nbsp;&nbsp;
                 <select name="usbkeystatus" id="usbkeystatus">
                 <option value="11" <?php if (!$_smarty_tpl->tpl_vars['member']->value['uid'] || $_smarty_tpl->tpl_vars['member']->value['usbkeystatus'] == 11) {?>selected<?php }?>>手机未扫描</option>
                 <option value="0" <?php if ($_smarty_tpl->tpl_vars['member']->value['uid'] && $_smarty_tpl->tpl_vars['member']->value['usbkeystatus'] == 0) {?>selected<?php }?>>手机已扫描</option>
                 </select>
                  </TD>
    </TR>
        </TABLE>
        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="60" align="center"> <?php if ($_smarty_tpl->tpl_vars['member']->value['uid']) {?><input type="button" onclick="document.getElementById('hide').src='admin.php?controller=admin_member&action=createca&uid=<?php echo $_smarty_tpl->tpl_vars['member']->value['uid'];?>
'" value="生成证书" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<?php }?><input type="submit"  value="保存修改" class="an_02"></td>
          </tr>
        </table>
    </DIV>
  </DIV>


<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
  <?php }?>
  <?php echo '<script'; ?>
>
function changelevel(iid){
	if(iid!=0){
		if(iid==3||iid==21||iid==101){
			<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
			document.getElementById('mgroupiddpop').disabled = false;
			<?php }?>
			document.getElementById('passwd_user_pri').disabled = false;
			document.getElementById('audit_user_pri').disabled = true;
			document.getElementById('common_user_pri').disabled = false;
		}else if(iid==1||iid==2){			
			document.getElementById('passwd_user_pri').disabled = false;
			document.getElementById('audit_user_pri').disabled = true;
			document.getElementById('common_user_pri').disabled = false;
		}else if(iid==10){
			document.getElementById('passwd_user_pri').disabled = true;
			document.getElementById('audit_user_pri').disabled = true;
			document.getElementById('common_user_pri').disabled = true;		
		}else if(iid==4){			
			document.getElementById('passwd_user_pri').disabled = false;
			document.getElementById('audit_user_pri').disabled = false;
			document.getElementById('common_user_pri').disabled = false;
		}
		document.getElementById('allowchange').disabled = true;
		document.getElementById('common_user_pri').disabled = false;
	}else{
		<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
			document.getElementById('mgroupiddpop').disabled = true;
		<?php }?>
		document.getElementById('allowchange').disabled = false;
		document.getElementById('passwd_user_pri').disabled = true;
		document.getElementById('audit_user_pri').disabled = true;
		document.getElementById('common_user_pri').disabled = true;		
	}
}

function GetRandomNum(Min,Max)
{   
var Range = Max - Min;   
var Rand = Math.random();   
return(Min + Math.round(Rand * Range));   
}   
var num = GetRandomNum(1,10);  

var numbers = ['0','1','2','3','4','5','6','7','8','9'];
var schars = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
var bchars = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
var sschars = ['~','!','@','#','$','%','^','&','*','(',')','<','>','?',':','"','{','}','\'',';','/','.',','];
var chars = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9','~','!','@','#','$','%','^','&','*','(',')','<','>','?',':','"','{','}','\'',';','/','.',','];

function generateMixed() {
	 var banword = '<?php echo $_smarty_tpl->tpl_vars['pwdconfig_password_ban_word']->value;?>
';
     var res = "";
	 for (var i=0; i<<?php echo $_smarty_tpl->tpl_vars['pwdconfig_pwdstrong1']->value;?>
; )
	 {
		var id = Math.ceil(Math.random()*(numbers.length-1));
		if(banword.indexOf(numbers[id])<0){
			res += numbers[id]
			i++;
		}
		
	 }
	 for (var i=0; i<<?php echo $_smarty_tpl->tpl_vars['pwdconfig_pwdstrong2']->value;?>
;  )
	 {
		var id = Math.ceil(Math.random()*(schars.length-1));
		if(banword.indexOf(schars[id])<0){
			res += schars[id]
			i++;
		}
		
	 }
	 for (var i=0; i<<?php echo $_smarty_tpl->tpl_vars['pwdconfig_pwdstrong3']->value;?>
; )
	 {
		var id = Math.ceil(Math.random()*(bchars.length-1));
		if(banword.indexOf(bchars[id])<0){
			res += bchars[id]
			i++;
		}
		
	 }
	 for (var i=0; i<<?php echo $_smarty_tpl->tpl_vars['pwdconfig_pwdstrong4']->value;?>
;  )
	 {
		var id = Math.ceil(Math.random()*(sschars.length-1));
		if(banword.indexOf(sschars[id])<0){
			res += sschars[id]
			i++;
		}
		
	 }
     for(var i = res.length; i <<?php echo $_smarty_tpl->tpl_vars['pwdconfig_login_pwd_length']->value;?>
 ; ) {
		var id = Math.ceil(Math.random()*(chars.length-1));
		if(banword.indexOf(chars[id])<0){
			res += chars[id];
			i++;
		}
     }
     return res;
}

function setrandompwd(){
	if(document.getElementById('autosetpwd').checked){
		var pwd = generateMixed();
		document.getElementById('password1').value=pwd;
		document.getElementById('password2').value=pwd;
	}else{
		document.getElementById('password1').value='';
		document.getElementById('password2').value='';
	}
}

function checkvpn(checked){
	if(document.getElementById('vpn').checked){
		document.getElementById('vpnip').disabled=true;
	}else{
		<?php if ($_smarty_tpl->tpl_vars['vpnenable']->value) {?>
		document.getElementById('vpnip').disabled = false;
		<?php }?>
	}
}

//checkvpn(<?php if ($_smarty_tpl->tpl_vars['member']->value['vpn']) {?>true<?php } else { ?>false<?php }?>)

<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
<?php echo $_smarty_tpl->tpl_vars['changelevelstr']->value;?>

<?php echo $_smarty_tpl->tpl_vars['mchangelevelstr']->value;?>

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['member']->value['level'] != '') {?>
changelevel(<?php echo $_smarty_tpl->tpl_vars['member']->value['level'];?>
);
<?php } else { ?>
changelevel(0);
<?php }?>

<?php echo '</script'; ?>
>
</FORM><?php }
}
?>