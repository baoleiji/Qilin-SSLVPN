<?php /* Smarty version 3.1.27, created on 2017-08-25 18:21:54
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/vpn/template/admin/devpass_index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1695087621599ffa42af3b16_21137754%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b9381d8d10b64b252e672f3b1d9f1075dabd842a' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/vpn/template/admin/devpass_index.tpl',
      1 => 1494943901,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1695087621599ffa42af3b16_21137754',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'language' => 0,
    'gid' => 0,
    'alldev' => 0,
    'ip' => 0,
    'serverid' => 0,
    'total' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
    'curr_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_599ffa42b93f37_96235375',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_599ffa42b93f37_96235375')) {
function content_599ffa42b93f37_96235375 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once '/opt/freesvr/web/htdocs/freesvr/audit/vpn/smarty/plugins/modifier.truncate_cn.php';

$_smarty_tpl->properties['nocache_hash'] = '1695087621599ffa42af3b16_21137754';
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
	function my_confirm(str){
		if(!confirm("确认要" + str + "？"))
		{
			window.event.returnValue = false;
		}
	}
	function chk_form(){
		for(var i = 0; i < document.member_list.elements.length;i++){
			var e = document.member_list.elements[i];
			if(e.name == 'chk_member[]' && e.checked == true)
				return true;
		}
		alert("您没有<?php echo $_smarty_tpl->tpl_vars['language']->value['select'];?>
任何<?php echo $_smarty_tpl->tpl_vars['language']->value['User'];?>
！");
		return false;
	}

	function batchloginlock(){
		document.member_list.action = "admin.php?controller=admin_pro&action=devbatchloginlock";
		document.member_list.submit();
		return true;
	}
	
	function loadurl(url){
		if(url=="") return ;
		$.get(url, {Action:"get",Name:"lulu","1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
			this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
			//alert(data);
			if(data.substring(0,10)=='freesvr://'){
				launcher(data);
			}else if(data.substring(0,15)=='window.loadurl(' || data.substring(0,11)=='if(confirm('){
				eval(data);
			}else{
				showImg('',data);
			}
		});
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
		var wWidth=200;
		var wHeight=240;
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
		mesW.innerHTML='<div id="light" class="white_content" style="height:240px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#eeeeee" align="right" height="25"><a href="javascript:void(0)" onclick="closeWindow()">关闭</a></td></tr></table>'+c+"</div>";
		//styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";//鼠标点击位置
		//styleStr="left:"+(bWidth-wWidth)/2+"px;top:"+(bHeight-wHeight)/2+"px;position:absolute;width:"+wWidth+"px;";//屏幕中间
		mesW.style.cssText=styleStr;
		document.body.appendChild(mesW);
		//window.parent.document.getElementById("frame_content").height=pos.y+1000;
		//window.parent.parent.document.getElementById("main").height=bHeight+1000;	
		
		document.getElementById('fade').style.display='block'
		return false;
	}
<?php echo '</script'; ?>
>
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
</head>

<body>
<div id="fade" class="black_overlay"></div> 

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
</ul><span class="back_img"><A href="admin.php?controller=admin_pro&action=dev_index&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
&back=1"><IMG src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                <TBODY>
		   		  <form name="member_list" action="admin.php?controller=admin_pro&action=devpass_index" method="post" >
		   
                  <TR>
                  <th class="list_bg"  width="3%"><?php echo $_smarty_tpl->tpl_vars['language']->value['select'];?>
</th>
                  <th class="list_bg"  width="1%">ID</th>
                    <th class="list_bg" width="10%"><?php echo $_smarty_tpl->tpl_vars['language']->value['HostName'];?>
</TD>
                    <th class="list_bg" width="10%">IP</TD>
                    <th class="list_bg" width="10%">系统</TD>
					<th class="list_bg" width="10%"><?php echo $_smarty_tpl->tpl_vars['language']->value['System'];
echo $_smarty_tpl->tpl_vars['language']->value['User'];?>
</TD>
                    <th class="list_bg" width="10%">账号信息</TD>
					<th class="list_bg" width="15%"><?php echo $_smarty_tpl->tpl_vars['language']->value['Operate'];?>
</TD>
                  </TR>

            </tr>
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
			<tr <?php if ($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['radiususer_is_in_member']) {?>bgcolor='red'<?php }?>>
			<td><input type="checkbox" name="chk_member[]" value="<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
"></td>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['hostname'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_type'];?>
</td>
				<td><?php if (!$_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username']) {?>空<?php echo $_smarty_tpl->tpl_vars['language']->value['User'];
} else {
echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'];
}
if ($_SESSION['ADMIN_LEVEL'] == 10) {?>(<a href='admin.php?controller=admin_pro&action=dev_checkpass&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
'>查看</a>)<?php }?></td>			
				<td align="center"><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=showdesc&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
");return false;' target="hide"><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1-1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['desc'],15,"...",'');?>
</a></td>
				<td>
				<?php if ($_SESSION['ADMIN_LEVEL'] == 1 || $_SESSION['ADMIN_LEVEL'] == 3 || $_SESSION['ADMIN_LEVEL'] == 4) {?>
				<img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=pass_edit&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&serverid=<?php echo $_smarty_tpl->tpl_vars['serverid']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['language']->value['Edit'];?>
</a>

				<img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('<?php echo $_smarty_tpl->tpl_vars['language']->value['Delete_sure_'];?>
？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=devpass_del&id=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
&ip=<?php echo $_smarty_tpl->tpl_vars['alldev']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['device_ip'];?>
&serverid=<?php echo $_smarty_tpl->tpl_vars['serverid']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
';}"><?php echo $_smarty_tpl->tpl_vars['language']->value['Delete'];?>
</a>
				<?php }?>
				</td> 
			</tr>
			<?php endfor; endif; ?>
			<tr>
	           <td  colspan="5" align="left"><input type="button"  value="添加" onClick="location.href='admin.php?controller=admin_pro&action=pass_edit&ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&serverid=<?php echo $_smarty_tpl->tpl_vars['serverid']->value;?>
&gid=<?php echo $_smarty_tpl->tpl_vars['gid']->value;?>
'"  class="an_06">
				&nbsp;&nbsp;<input type="submit"  value="删除" onclick="my_confirm('<?php echo $_smarty_tpl->tpl_vars['language']->value['DeleteUsers'];?>
');if(chk_form()) document.member_list.action='admin.php?controller=admin_pro&action=devpass_del&from=dev_priority_search'; else return false;" class="an_02">
		   </td>
              
	           <td  colspan="5" align="right">&nbsp;
		   			<?php echo $_smarty_tpl->tpl_vars['language']->value['all'];
echo $_smarty_tpl->tpl_vars['total']->value;
echo $_smarty_tpl->tpl_vars['language']->value['Recorder'];?>
  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  <?php echo $_smarty_tpl->tpl_vars['language']->value['Page'];?>
：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;
echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;
echo $_smarty_tpl->tpl_vars['language']->value['Recorder'];?>
/<?php echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
  <?php echo $_smarty_tpl->tpl_vars['language']->value['Goto'];?>
<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_index&serverid=<?php echo $_smarty_tpl->tpl_vars['serverid']->value;?>
&page='+this.value;"><?php echo $_smarty_tpl->tpl_vars['language']->value['page'];?>
&nbsp;&nbsp;&nbsp;<?php if ($_SESSION['ADMIN_LEVEL'] == 3) {?>  导出：<a href="<?php echo $_smarty_tpl->tpl_vars['curr_url']->value;?>
&derive=1" target="hide"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/excel.png" border=0></a><?php }?>
		   </td>
		</tr>
		</form>
		</TBODY>
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

<?php echo '</script'; ?>
>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



<?php }
}
?>