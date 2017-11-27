<?php /* Smarty version 3.1.27, created on 2016-12-21 21:45:42
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/scpsession_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1191708829585a8786ace6d4_90103309%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '16b9e90f809fac4b51c2c308f2b75480152c4350' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/scpsession_list.tpl',
      1 => 1479354364,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1191708829585a8786ace6d4_90103309',
  'variables' => 
  array (
    'language' => 0,
    'template_root' => 0,
    'backupdb_id' => 0,
    '_config' => 0,
    'orderby2' => 0,
    'allsession' => 0,
    'session_num' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
    'curr_url' => 0,
    'now_table_name' => 0,
    'table_list' => 0,
    'changelevelstr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_585a8786bbaf91_37818685',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_585a8786bbaf91_37818685')) {
function content_585a8786bbaf91_37818685 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1191708829585a8786ace6d4_90103309';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['language']->value['SessionsList'];?>
</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
 type="text/javascript">
function searchit(){
	var url = "admin.php?controller=admin_scp&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
";
	url += "&svraddr="+document.search.elements.ip.value;
	url += "&user="+document.search.elements.user.value;
	url += "&start1="+document.search.elements.f_rangeStart.value;
	url += "&start2="+document.search.elements.f_rangeEnd.value;
	<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
	<?php if ($_smarty_tpl->tpl_vars['_config']->value['TREEMODE']) {?>
	var obj1=document.getElementById('groupiddh');	
	gid=obj1.value;
	<?php } else { ?>
	for(var i=1; true; i++){
		var obj=document.getElementById('groupid'+i);
		if(obj!=null&&obj.options.selectedIndex>-1){
			gid=obj.options[obj.options.selectedIndex].value;
			continue;
		}
		break;
	}
	<?php }?>
	url += "&groupid="+gid;
	<?php }?>
	document.search.action = url;
	//alert(document.search.elements.action);
	//return false;
	return true;
}
var isIe=(document.all)?true:false;

function closeWindow()
{
	if(document.getElementById('back')!=null)
	{
		document.getElementById('back').parentNode.removeChild(document.getElementById('back'));
	}
	if(document.getElementById('mesWindow')!=null)
	{
		document.getElementById('mesWindow').parentNode.removeChild(document.getElementById('mesWindow'));
	}
	document.getElementById('fade').style.display='none';
}

function showImg(wTitle, c)
{
	closeWindow();
	//var pos = mousePosition(ev);
	var wWidth=240;
	var wHeight=300;
	var bWidth=parseInt(w=window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth);
	var bHeight=parseInt(window.innerHeight|| document.documentElement.clientHeight|| document.body.clientHeight)+20;
	bHeight=700+20;
	var back=document.createElement("div");
	back.id="back";
	var styleStr="top:0px;left:0px;position:absolute;width:"+bWidth+"px;height:"+bHeight+"px;z-index:1002;";
	//styleStr+=(isIe)?"filter:alpha(opacity=0);":"opacity:0;";
	back.style.cssText=styleStr;
	document.body.appendChild(back);
	var mesW=document.createElement("div");
	mesW.id="mesWindow";
	mesW.className="mesWindow";
	mesW.innerHTML='<div id="light" class="white_content" style="height:230px;width:32%"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#eeeeee" align="right" height="25"><a href="javascript:void(0)" onclick="closeWindow()">关闭</a></td></tr></table>'+c+"</div>";
	//styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";//鼠标点击位置
	//styleStr="left:"+(bWidth-wWidth)/2+"px;top:"+(bHeight-wHeight)/2+"px;position:absolute;width:"+wWidth+"px;";//屏幕中间
	mesW.style.cssText=styleStr;
	document.body.appendChild(mesW);
	//window.parent.document.getElementById("frame_content").height=pos.y+1000;
	//window.parent.parent.document.getElementById("main").height=bHeight+1000;	
	
	document.getElementById('fade').style.display='block'
	return false;
}

function loadurl(url){
	$.get(url, {Action:"get",Name:"lulu"}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//alert(data);
		showImg('',data);
	});
}
function changeStyle(obj,c)
{
	if(c!='o'){
		obj.style.backgroundColor=c;
	}else{
		obj.style.backgroundColor="#FFCC80";
	}
}
<?php echo '</script'; ?>
>

<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<?php echo '<script'; ?>
 src="./template/admin/cssjs/jscal2.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/cn.js"><?php echo '</script'; ?>
>
</head>

<body>
<div id="fade" class="black_overlay"></div> 
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#F1F1F1"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_session&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">Telnet/SSH</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_sftp&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">SFTP</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_a"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_scp&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">SCP</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an3.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ftp&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">FTP</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li> 
<?php if ($_SESSION['ADMIN_LEVEL'] != 0) {?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_as400&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">AS400</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li> 
<?php }?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_rdp&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">RDP</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_vnc&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">VNC</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li> 
<?php if ($_smarty_tpl->tpl_vars['backupdb_id']->value) {?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_apppub&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">应用发布</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li>
<?php }?>
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_x11&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">X11</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow_approve">流程审批</a><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/an33.jpg" align="absmiddle"/></li> 
</ul>
</div></td></tr>


 <tr>
    <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content"><form action="admin.php?controller=admin_sqlserver&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
" method="post" name="search" >
  <tr>
    <td></td>
    <td>
<?php echo $_smarty_tpl->getSubTemplate ("select_sgroup_ajax.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
          
&nbsp;目的地址：<input type="text" class="wbk" name="ip"  size="13" />
运维用户：<input type="text" class="wbk" name="user" size="13" />
&nbsp;    
开始日期：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="" />
 <input type="button" onClick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">

 结束日期：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd" value="" />
 <input type="button" onClick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk">
	  &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
 	</td>
  </tr></form>
</table>

				
  <?php echo '<script'; ?>
 type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d %H:%M:%S");

function filter1(){
	if(document.getElementById('filtercheck').checked){
		window.location=document.location+'&filter=1';
	}else{
		window.location=document.location+'&filter=0';
	}
}
<?php echo '</script'; ?>
>
					</td>
  </tr>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_scp&orderby1=cliaddr&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">来源地址</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_scp&orderby1=svraddr&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['DestinationAddress'];?>
</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_scp&orderby1=radius_user&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">运维</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_scp&orderby1=realname&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">真实姓名</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_scp&orderby1=sftp_user&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['LocalUser'];?>
</a></th>
						<th class="list_bg"   width="15%"><a href="admin.php?controller=admin_scp&orderby1=start&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['StartTime'];?>
</a></th>
						<th class="list_bg"   width="10%"><a href="admin.php?controller=admin_scp&orderby1=end&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
">操作命令</a></th>
						<th class="list_bg"   width="18%">下载</th>
					</tr>
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allsession']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
					<tr <?php if ($_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 5) {?>bgcolor="red"<?php } elseif ($_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 0) {?>bgcolor="yellow" <?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?> onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'<?php if ($_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 5) {?>red<?php } elseif ($_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['dangerous'] > 0) {?>yellow<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>f7f7f7<?php }?>');">

						<td><a href="admin.php?controller=admin_scp&cliaddr=<?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cliaddr'];?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cliaddr'];?>
</a></td>
					
						<td><a href="admin.php?controller=admin_scp&svraddr=<?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['svraddr'];?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['svraddr'];?>
</a></td>
						<td><a href="admin.php?controller=admin_scp&radius_user=<?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['radius_user'];?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['radius_user'];?>
</a></td>
						<td><a href="admin.php?controller=admin_scp&realname=<?php echo urlencode($_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['realname']);?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['realname'];?>
</a></td>
						<td><a href="admin.php?controller=admin_scp&sftp_user=<?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sftp_user'];?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sftp_user'];?>
</a></td>
						
						<td><?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['at'];?>
</ td>
						<td><?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['comm'];?>
</td>
						<td style="TEXT-ALIGN: left;"><?php if ($_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['filename']) {?><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/down.gif" width="16" height="16" align="absmiddle"> <a href="admin.php?controller=admin_scp&action=download&cid=<?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['cid'];?>
"  target="hide">下载</a><?php }?>
						<?php if ($_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['logincommit']) {?>&nbsp;&nbsp;<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1-1.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_session&commit=<?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['logincommit'];?>
&action=logincommit&type=sftp" target="hide" >说明</a><?php }?>
						<?php if (0) {?> <?php if (!$_smarty_tpl->tpl_vars['backupdb_id']->value) {?>| <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_scp&action=del_session&sid=<?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
&backupdb_id=<?php echo $_smarty_tpl->tpl_vars['backupdb_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['language']->value['Delete'];?>
</a><?php }
}?> <!-- | <a href=admin.php?controller=admin_scp&action=download&sid=<?php echo $_smarty_tpl->tpl_vars['allsession']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['sid'];?>
 target="_blank"><?php echo $_smarty_tpl->tpl_vars['language']->value['Log'];?>
</a>--></td>
					</tr>
					<?php endfor; endif; ?>
					<tr>
						<td colspan="12" align="right">
							<?php echo $_smarty_tpl->tpl_vars['language']->value['all'];
echo $_smarty_tpl->tpl_vars['session_num']->value;
echo $_smarty_tpl->tpl_vars['language']->value['Session'];?>
  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  <?php echo $_smarty_tpl->tpl_vars['language']->value['Page'];?>
：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;
echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;
echo $_smarty_tpl->tpl_vars['language']->value['item'];
echo $_smarty_tpl->tpl_vars['language']->value['Log'];?>
/<?php echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
  <?php echo $_smarty_tpl->tpl_vars['language']->value['Goto'];?>
<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
&page='+this.value;"><?php echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
 <!--当前数据表: <?php echo $_smarty_tpl->tpl_vars['now_table_name']->value;?>
--> 
						<!--
						<select  class="wbk"  name="table_name">
						<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['table_list']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
						<option value="<?php echo $_smarty_tpl->tpl_vars['table_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']];?>
" <?php if ($_smarty_tpl->tpl_vars['table_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']] == $_smarty_tpl->tpl_vars['now_table_name']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['table_list']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']];?>
</option>
						<?php endfor; endif; ?>
						</select>
						-->
						</td>
					</tr>
				</table>
	</td>
  </tr>
</table>
<?php echo '<script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['_config']->value['LDAP']) {?>
<?php echo $_smarty_tpl->tpl_vars['changelevelstr']->value;?>

<?php }?>
<?php echo '</script'; ?>
>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>


<?php }
}
?>