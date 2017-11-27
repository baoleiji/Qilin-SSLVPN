<?php /* Smarty version 3.1.27, created on 2017-08-25 08:35:09
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/vpn/template/admin/keys_list.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1610810228599f70bd99b857_91060853%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '64e1797445932581b414065b55cc2ab878c692e7' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/vpn/template/admin/keys_list.tpl',
      1 => 1483243459,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1610810228599f70bd99b857_91060853',
  'variables' => 
  array (
    'title' => 0,
    'template_root' => 0,
    'members' => 0,
    'orderby2' => 0,
    'allkeys' => 0,
    'total' => 0,
    'page_list' => 0,
    'curr_page' => 0,
    'total_page' => 0,
    'items_per_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_599f70bda13054_99205785',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_599f70bda13054_99205785')) {
function content_599f70bda13054_99205785 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate_cn')) require_once '/opt/freesvr/web/htdocs/freesvr/audit/vpn/smarty/plugins/modifier.truncate_cn.php';

$_smarty_tpl->properties['nocache_hash'] = '1610810228599f70bd99b857_91060853';
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
</head>
<?php echo '<script'; ?>
>
function searchit(){
document.route.submit();
return true;
}
var AllMember = new Array();
i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['name'] = 'kk';
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['members']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
] = new Array();
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['username']='<?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['username'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['realname']='<?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['realname'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['uid']='<?php echo $_smarty_tpl->tpl_vars['members']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['uid'];?>
';
<?php endfor; endif; ?>
function filter(v,i,d){
	var obj = document.getElementById('uid_'+i);
	obj.options.length=0;
	for(var j=0; j<AllMember.length; j++){
		if(AllMember[j].username.indexOf(v)>=0){
			if(AllMember[j].username==d){
				obj.options[obj.options.length]=new Option(AllMember[j].username,AllMember[j].username,true,true);
			}else{
				obj.options[obj.options.length]=new Option(AllMember[j].username,AllMember[j].username);
			}
		}
	}
}
function updateuserkey(keyid, uid){
	$.post( "admin.php?controller=admin_member&action=keybinduser_save&fromajax=1&keyid="+keyid, { member: uid})
	  .done(function( data ) {
		alert(data );
	  });
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

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
		<form name='route' action='admin.php?controller=admin_member&action=keys_index' method='post'>
			<td colspan="3" class="main_content">&nbsp;动态令牌 序列号：<input type="text" class="wbk" size="20" name="keyid" value="" />&nbsp;&nbsp; 用户名：<input type="text" class="wbk" size="20" name="username" value="" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>&nbsp;&nbsp;</td>
			
			<input type="hidden" name="ac" value="new" />
		</form>
		</tr>
  <tr>
	<td class="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
                <TBODY>		
		<tr >
			<th class="list_bg" align="center" width="20%"><a href="admin.php?controller=admin_member&action=keys_index&orderby1=keyid&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" ><strong>动态令牌 序列号</strong></a></td>
			<th class="list_bg" width="15%" align="center"><a href="admin.php?controller=admin_member&action=keys_index&orderby1=username&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" ><b>绑定用户</b></a></td>
			<th class="list_bg" width="15%" align="center"><a href="admin.php?controller=admin_member&action=keys_index&orderby1=type&orderby2=<?php echo $_smarty_tpl->tpl_vars['orderby2']->value;?>
" ><b>类型</b></a></td>
			<th class="list_bg" width="30%">说明</TD>
			<th class="list_bg" align="center"><b>操作</b></td>
		</tr>		
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['t'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['t']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['name'] = 't';
$_smarty_tpl->tpl_vars['smarty']->value['section']['t']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allkeys']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
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
		<tr <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['t']['index']%2 == 0) {?>bgcolor="f7f7f7"<?php }?>>
			<td ><?php echo $_smarty_tpl->tpl_vars['allkeys']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['keyid'];?>
</td>
			<td >
			<?php echo $_smarty_tpl->tpl_vars['allkeys']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['username'];?>
</td>
			<td><?php if (!$_smarty_tpl->tpl_vars['allkeys']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['type']) {?>硬件<?php } else { ?>手机<?php }?>令牌</td>
			<td align="center"><a href='#' onclick='loadurl("admin.php?controller=admin_member&action=showdesc&id=<?php echo $_smarty_tpl->tpl_vars['allkeys']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
");return false;' target="hide"><img src='<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/1-1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><?php echo smarty_modifier_truncate_cn($_smarty_tpl->tpl_vars['allkeys']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['desc'],15,"...",'');?>
</a></td>
			
			<td >
			
			<img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=keybinduser&keyid=<?php echo $_smarty_tpl->tpl_vars['allkeys']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
">修改</a> 
			 | <img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/delete_ico.gif" width="16" height="16" hspace="5" border="0" align="absmiddle"><a href="#" onClick="if(!confirm('您确定要删除key？')) {return false;} else { location.href='admin.php?controller=admin_member&action=keys_delete&id=<?php echo $_smarty_tpl->tpl_vars['allkeys']->value[$_smarty_tpl->getVariable('smarty')->value['section']['t']['index']]['id'];?>
';}">删除</a>
			
			</td>
		</tr>
		<?php endfor; endif; ?>
		
		
		
                <tr>
				<td colspan="1"><input type="button"  value="导入动态令牌" onclick="javascript:document.location='admin.php?controller=admin_member&action=importusbkey';" class="an_06">
		</td>
	           <td  colspan="3" align="right">
		   			共<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
个记录  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
  页次：<?php echo $_smarty_tpl->tpl_vars['curr_page']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_page']->value;?>
页  <?php echo $_smarty_tpl->tpl_vars['items_per_page']->value;?>
个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_member&action=keys_index&page='+this.value;">页
		   </td>
		</tr>
		
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