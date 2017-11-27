<?php /* Smarty version 3.1.27, created on 2017-05-07 08:29:10
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/dev_group_index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:144893174590e6a56f26986_21393460%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '60e053cd66663b853bbfd7ee5d662793e8a92e24' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/dev_group_index.tpl',
      1 => 1483242955,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '144893174590e6a56f26986_21393460',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'groupname' => 0,
    'orderby2' => 0,
    'ldapid' => 0,
    '_config' => 0,
    'alldev' => 0,
    'gid' => 0,
    'total' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_590e6a570bd311_85791047',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_590e6a570bd311_85791047')) {
function content_590e6a570bd311_85791047 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '144893174590e6a56f26986_21393460';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>
<?php echo '<script'; ?>
>
function searchit(){
	document.f1.action = "admin.php?controller=admin_pro&action=dev_group";
	document.f1.action += "&groupname="+document.f1.groupname.value;
	return true;
}
var selected = new Array();
function toggle_group(oid, obj, gid,level, isChild) {
	obj = document.getElementById(obj);
	if(selected[gid]!=null||selected[gid]!=undefined) {
		toggle_group_callback(oid, obj, isChild);
		return;
	}
	var url ="admin.php?controller=admin_grouptree&action=get_devgroup&groupid="+escape(gid)+"&groupindex="+oid.substring(5)+"&level="+level;
	$.get(url, {"1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		selected[gid]=1;
		$(obj.parentNode.parentNode.parentNode.parentNode).after(data);
		toggle_group_callback(oid, obj, isChild);
	});
}

function toggle_group_callback(oid, obj, isChild) {
	obj = obj ? obj : document.getElementById('a_'+oid);
	if(!conf) {
		var conf = {'show':'[-]','hide':'[+]'};
	}
	
	var obody = document.getElementById(oid+'_0');
	var ids = oid.split('_');
	if(obody.style.display == 'none') {		
		if(isChild){
			obody.style.display = '';
		}else{
			var tbodys = document.getElementsByTagName('tbody');
			for(var i=0; i<tbodys.length; i++){
				if(tbodys[i].attributes.length>1&&tbodys[i].attributes.name!=undefined){
					if(tbodys[i].attributes.name.nodeValue==oid){
						tbodys[i].style.display = '';
					}
				}
			}
		}		
		obj.innerHTML = conf.show;
	} else {
		if(isChild){
			obody.style.display = 'none';
		}else{
			var tbodys = document.getElementsByTagName('tbody');
			for(var i=0; i<tbodys.length; i++){
				if(tbodys[i].attributes.length>1){
					if(tbodys[i].attributes.name!=undefined&&tbodys[i].attributes.name.nodeValue==oid){
						tbodys[i].style.display = 'none';
						if(tbodys[i].attributes.aid!=undefined&&document.getElementById(tbodys[i].attributes.aid.nodeValue)!=undefined)
						document.getElementById(tbodys[i].attributes.aid.nodeValue).innerHTML = conf.hide;
					}else if(tbodys[i].id.length>oid.length&&tbodys[i].id.substring(0, oid.length)==oid){
						if(tbodys[i].attributes.aid!=undefined&&document.getElementById(tbodys[i].attributes.aid.nodeValue)!=undefined)
						document.getElementById(tbodys[i].attributes.aid.nodeValue).innerHTML = conf.hide;
						tbodys[i].style.display = 'none';
						var as = document.getElementsByTagName("a");
						for(var j=0; j<as.length; j++){
							if(as[j].id.substring(0, 2)=='a_')
							if(as[j].id.substring(0, oid.length+2)=='a_'+oid){
								as[j].innerHTML = conf.hide;
							}
						}
					}
				}
			}
		}
		obj.innerHTML = conf.hide;
	}
	window.parent.reinitIframe();
}
<?php echo '</script'; ?>
>
<body>

<style type="text/css">
a {
    color: #003499;
    text-decoration: none;
} 
a:hover {
    color: #000000;
    text-decoration: underline;
}
</style>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	
   <tr>
	<td class="" colspan = "4"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

                <TBODY>
				 <TR>
                    <TD >
					<form name ='f1' action='admin.php?controller=admin_pro&action=dev_index' method=post>
					组名: <input type="text" class="wbk" name="groupname" value="<?php echo $_smarty_tpl->tpl_vars['groupname']->value;?>
">
					&nbsp;&nbsp;<input  type="submit" value="高级搜索" onclick="return searchit();" class="bnnew2">
					</form>
					</TD>
                  </TR>
				  </table></td></tr>
  <tr>
	<td class="">	
	<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                  <TR>
					<th class="list_bg" width="3%"></TD>
                    <th class="list_bg" width="35%" ><a href="admin.php?controller=admin_pro&action=dev_group&orderby1=groupname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&ldapid=<?php echo $_smarty_tpl->tpl_vars['ldapid']->value;?>
" >资源组名称</a></TD>					
					<th class="list_bg" width="3%">ID</TD>
					<th class="list_bg" width="8%" ><a href = "admin.php?controller=admin_pro&action=dev_group&orderby1=attribute&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&ldapid=<?php echo $_smarty_tpl->tpl_vars['ldapid']->value;?>
">属性</a></th>
					<th class="list_bg" width="5%" ><a href="admin.php?controller=admin_pro&action=dev_group&orderby1=count&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&ldapid=<?php echo $_smarty_tpl->tpl_vars['ldapid']->value;?>
" >服务器数</a></TD>
					<th class="list_bg" width="5%" ><a href="admin.php?controller=admin_pro&action=dev_group&orderby1=mcount&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&ldapid=<?php echo $_smarty_tpl->tpl_vars['ldapid']->value;?>
" >用户数</a></TD>
					<th class="list_bg" width="20%" ><a href="admin.php?controller=admin_pro&action=dev_group&orderby1=description&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&ldapid=<?php echo $_smarty_tpl->tpl_vars['ldapid']->value;?>
" >描述</a></TD>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
			
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alldev']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['t']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['t']['total']);
?>
			<tbody >
			<tr  <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
				<TD  onClick="toggle_group('ldap_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['t']['index'];?>
', 'a_ldap_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['t']['index'];?>
',<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
,1)" class=td25 width="30" align="center"><?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['childrenct'] > 0) {?><span class="td25"><A id=a_ldap_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['t']['index'];?>
 href="javascript:;">[+]</A></span><?php }?></TD>
				<td><a href="admin.php?controller=admin_pro&action=dev_index&gid=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['groupname'];?>
</a></td>
				<td><a href="admin.php?controller=admin_pro&action=dev_index&gid=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
</a></td>
				<td><?php if (!$_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['attribute']) {?>全部<?php } elseif ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['attribute'] == 1) {?>用户<?php } else { ?>主机<?php }?></td>
				<td><a href='admin.php?controller=admin_pro&action=dev_index&gid=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&from=dir'><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['count'];?>
</a></td>
				<td><a href='admin.php?controller=admin_member&ldapid=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&from=dir'><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['mcount'];?>
</a></td>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['description'];?>
</td>
				<td>
				<?php if ($_SESSION['ADMIN_LEVEL'] == 1 || $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {?>
				<img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_pro&action=devgroup_edit&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
" >编辑</a> | 
				<img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=dev_group_del&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
';}">删除</a>
				<?php }?>
				</td> 
			</tr><?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['childrenct'] > 0) {?>
				<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['groupstr'];?>

				<?php }?></tbody>
			<?php endfor; endif; ?>
			<?php } else { ?>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['nt'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['nt']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['name'] = 'nt';
$_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alldev']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['nt']['total']);
?>
					<tr  <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
						<td class=td25 width="20">&nbsp;</TD>
						<td width="20%"><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['groupname'];?>
</a></td>
						<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
						<td width="20%"> <a href='admin.php?controller=admin_pro&action=dev_group&level=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['level'];?>
'><?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['level'] == 1) {?>一级目录<?php } elseif ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['level'] == 2) {?>二级目录<?php } else { ?>资源组<?php }?></a></td>
						<?php }?>
						<td><?php if (!$_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['attribute']) {?>全部<?php } elseif ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['attribute'] == 1) {?>用户<?php } else { ?>主机<?php }?></td>
						<td width="5%"><a href='admin.php?controller=admin_pro&action=dev_index&gid=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['id'];?>
&from=dir'><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['count'];?>
</a></td>
						<td width="5%"><a href='admin.php?controller=admin_member&gid=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['id'];?>
&from=dir'><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['mcount'];?>
</a></td>
						<td width="20%"><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['description'];?>
</td>
						<td>
						<?php if ($_SESSION['ADMIN_LEVEL'] == 1 || $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {?>
						<img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_pro&action=devgroup_edit&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['id'];?>
" >编辑</a> | 
						<img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=dev_group_del&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['id'];?>
';}">删除</a> <?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['level'] > 0 && $_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>| 
						<img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/file.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_pro&action=dev_group&ldapid=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['nt']['index']]['id'];?>
" >查看子目录</a><?php }?>
						<?php }?>
						</td> 
					</tr>
					<?php endfor; endif; ?>
			<?php }?>
			
			<tr>
	           <td  colspan="3" align="left">
				<?php if ($_SESSION['ADMIN_LEVEL'] == 1 || $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 21 || $_SESSION['ADMIN_LEVEL'] == 101) {?>
				<input size="30" type="button"  value="添加新节点"  onClick="location.href='admin.php?controller=admin_pro&action=devgroup_edit&ldapid=<?php echo $_smarty_tpl->tpl_vars['ldapid']->value;?>
'" class="an_06">&nbsp;&nbsp;<input type="button"  value="批量添加" onClick="location.href='admin.php?controller=admin_pro&action=groupbatchadd&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
'" class="an_06">
				<?php }?>
		   </td>
               
	           <td  colspan="5" align="right">
		   			共<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
个记录  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;?>
个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_group&page='+this.value;">页
		   </td>
		</tr>
              </TABLE>	</td>
  </tr>
</table>

<?php echo '<script'; ?>
 language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}
window.parent.menu.document.getElementById('_tree').style.display='none';
window.parent.menu.document.getElementById('devtree').style.display='none';
window.parent.menu.document.getElementById('mtree').style.display='none';
window.parent.menu.cururl='ldaptree';
<?php echo '</script'; ?>
>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


<?php }
}
?>