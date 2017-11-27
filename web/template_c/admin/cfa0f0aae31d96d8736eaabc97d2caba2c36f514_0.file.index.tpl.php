<?php /* Smarty version 3.1.27, created on 2016-12-04 12:03:52
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1264601556584395a81900b4_39540779%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cfa0f0aae31d96d8736eaabc97d2caba2c36f514' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/index.tpl',
      1 => 1474793216,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1264601556584395a81900b4_39540779',
  'variables' => 
  array (
    'site_title' => 0,
    'template_root' => 0,
    'user' => 0,
    'sessionlifetime' => 0,
    'dbaudit_on' => 0,
    'named_on' => 0,
    'config' => 0,
    'ismac' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_584395a8201d26_79607293',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_584395a8201d26_79607293')) {
function content_584395a8201d26_79607293 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1264601556584395a81900b4_39540779';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->tpl_vars['site_title']->value;?>
</title>
<link href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/all_purpose_style.css" rel="stylesheet" type="text/css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/layer/layer.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 language="javascript">

function webssh(title,url){
	var index = layer.open({
	  type: 2,
	  title:title,
	  content: url,
	  area: ['300px', '195px'],
	  maxmin: true,
	  success: function(layero, index){
				var body = layer.getChildFrame('body', index);
	  }
	});
	layer.full(index);
}

document.onmousedown=judgeMouseButton;
function judgeMouseButton(e){
	var e=window.event||e;//获取事件对象
	var value=e.button;
	if(value==2||value==3){
		_refresh = true;
	}else{
		_refresh = false;
	}
}
var _refresh = false;
document.onkeydown = function(e) {
	e = e || event || window.event;
	if(e.keyCode==116){
		_refresh = true;
	}
}
window.onbeforeunload=function(){
 // return "快住手！！别点下去！！";
};

var explorer = window.navigator.userAgent ;
if (/(msie\s|trident.*rv:)([\w.]+)/.exec(explorer.toLowerCase())!=null) {
		//alert("ie");
}


<?php if ($_smarty_tpl->tpl_vars['user']->value['webportal']) {?>
<!--
var maxtime = <?php echo $_smarty_tpl->tpl_vars['sessionlifetime']->value;?>
; //小时，分钟，秒，可以读取数据库时间函数
function CountDown(){
if(maxtime>=0){
hours = Math.floor(maxtime/60/60);
minutes = Math.floor(maxtime/60%60);
seconds = Math.floor(maxtime%60);
msg = "距离结束还有"+hours+"时"+minutes+"分"+seconds+"秒";
document.all["timer"].innerHTML=msg;
--maxtime;
}else{
	window.location='admin.php?controller=admin_index&action=login';
}
}
timer = setInterval("CountDown()",1000);
//-->
<?php }?>
function reinitIframe(){
	var iframe = document.getElementById("main");
	var version = 0;
	var minHeight = 600;
	var bHeight = 0;
	if(navigator.userAgent.indexOf("MSIE")>0){
		bHeight = iframe.contentWindow.document.body.scrollHeight;
	}else if(navigator.userAgent.indexOf("Firefox")>0){
		bHeight = iframe.contentWindow.document.body.scrollHeight;
	}else if(navigator.userAgent.indexOf("Chrome")>0){
		bHeight = iframe.contentDocument.body.scrollHeight;
	}else{
		bHeight = iframe.contentWindow.document.body.scrollHeight;
	}//alert(bHeight);	
	//var bHeight2 = iframe.contentWindow.document.body.scrollHeight;
	bHeight = Math.max(bHeight, minHeight)
	iframe.height =  bHeight+10;

}

var selectedCactiMenu = '';
function changeCactiMenu(obj, module){
	if(selectedCactiMenu)
		selectedCactiMenu.parentNode.className='td5';
		obj.parentNode.className = "td6";
		selectedCactiMenu = obj;
		if(module=='cacti'){
			show_box('monitor');
			jumpto(document.getElementById('systemmonitor'));
			document.getElementById('systemmonitor').parentNode.className='zcd';
			document.getElementById('main').src=document.getElementById('systemmonitor').href;

			document.getElementById('audit_menu').style.display='none'
			document.getElementById('log_menu').style.display='none'
			document.getElementById('cacti_menu').style.display='block'
		}else if(module=='audit'){
			show_box('audit');
			jumpto(document.getElementById('sshaudit'));
			document.getElementById('sshaudit').parentNode.className='zcd';
			document.getElementById('main').src=document.getElementById('sshaudit').href;

			document.getElementById('audit_menu').style.display='block'
			document.getElementById('cacti_menu').style.display='none'
			document.getElementById('log_menu').style.display='none'
		}else if(module=='log'){
			show_box('log');
			jumpto(document.getElementById('currentlog'));
			document.getElementById('currentlog').parentNode.className='zcd';
			document.getElementById('main').src=document.getElementById('currentlog').href;

			document.getElementById('audit_menu').style.display='none'
			document.getElementById('cacti_menu').style.display='none'
			document.getElementById('log_menu').style.display='block'
		}else{
			document.getElementById('audit_menu').style.display='none'
			document.getElementById('cacti_menu').style.display='block'
			document.getElementById('log_menu').style.display='none'
		}
	return true;
	
}
function setScroll(){
	window.scrollTo(0,0);
}
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 language="JavaScript">
function correctPNG() // correctly handle PNG transparency in Win IE 5.5 & 6.
{
    var arVersion = navigator.appVersion.split("MSIE")
    var version = parseFloat(arVersion[1])
    if ((version >= 5.5) && (document.body.filters))
    {
       for(var j=0; j<document.images.length; j++)
       {
          var img = document.images[j]
          var imgName = img.src.toUpperCase()
          if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
          {
             var imgID = (img.id) ? "id='" + img.id + "' " : ""
             var imgClass = (img.className) ? "class='" + img.className + "' " : ""
             var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
             var imgStyle = "display:inline-block;" + img.style.cssText
             if (img.align == "left") imgStyle = "float:left;" + imgStyle
             if (img.align == "right") imgStyle = "float:right;" + imgStyle
             if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
             var strNewHTML = "<span " + imgID + imgClass + imgTitle
             + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
             + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
             + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>"
             img.outerHTML = strNewHTML
             j = j-1
          }
       }
    }   
}
//window.attachEvent("onload", correctPNG);


<?php echo '</script'; ?>
>
<style type="text/css">
<!--
body {
	background-color: #F1F1F1;
}
-->
</style>

<style type="text/css"> 
*
#navigation, #navigation li ul { 
list-style-type:none; 
} 
#navigation {
} 
#navigation li { 
float:left; 
text-align:center; 
position:relative; 
} 
#navigation li a:link, #navigation li a:visited { 
display:block; 
text-decoration:none; 
color:#000; 
height:20px; 
line-height:20px; 
padding-left:10px; 
list-style-type:none; 
} 
#navigation li a:hover { 
color:#fff; 
} 
#navigation li ul li a:hover { 
color:#fff; 
left:0; 
width:80px;
background:#6b839c; 
} 
#navigation li ul { 
display:none; 
position:absolute; 
left:0; 
width:80px; 
background:#ADDEFE; 
} 
#navigation li ul li ul { 
display:none; 
position:absolute; 
top:0px; 
left:130px; 
margin-top:0; 
margin-left:1px; 
width:120px; 
} 
</style> 
<?php echo '<script'; ?>
 type="text/javascript"> 
function displaySubMenu(li) { 
var subMenu = li.getElementsByTagName("ul")[0]; 
subMenu.style.display = "block"; 
} 
function hideSubMenu(li) { 
var subMenu = li.getElementsByTagName("ul")[0]; 
subMenu.style.display = "none"; 
} 
<?php echo '</script'; ?>
> 
</head>

<body>
<table width="100%" height="486" border="0" cellpadding="0" cellspacing="0" bgcolor="#F1F1F1" >
  <tr>
    <td height="12" valign="top" background="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/yw_03.jpg"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="300" align="left" valign="top"><img src="logo/02.jpg" /></td>
        <td align="center" valign="top">
			
			<div class="cj" >
				<ul>
				<li><span class="td5"><a href="admin.php?controller=admin_index" onclick="return changeCactiMenu(this, 'audit')"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/home.png"/></a></span><span class="cj_zi">运维</span></li>
				<?php if ($_smarty_tpl->tpl_vars['dbaudit_on']->value) {?><li><span class="td5"><a href="dbaudit" ><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/db.png" /></a></span><span class="cj_zi">DB审计</span></li><?php }?>	
				<?php if ($_smarty_tpl->tpl_vars['named_on']->value) {?><li><span class="td5"><a href="../named/main.php?FROMAUDIT=1" ><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/home.png" /></a></span><span class="cj_zi">DNS</span></li><?php }?>	
				</ul>
			</div>
					</td>
					
<?php if ($_smarty_tpl->tpl_vars['user']->value['webportal']) {?><TD width="150" background="images/yw_03.jpg">
<div id="timer" style="color:#ffffff; text-align:left;"></div>      
      </TD><?php }?>
        <td width="200" align="right" valign="top"><table width="200" height="31" border="0" cellpadding="0" cellspacing="0" class="lj_hei">
          <tr>
            <td width="18" height="31" bgcolor="ADDEFE"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/yw_05.jpg" width="18" height="31" /></td>
            <td align="center" bgcolor="ADDEFE" ><ul id="navigation"> <li><a href="admin.php?controller=admin_index"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/yw_07.jpg" width="16" height="16" align="absmiddle" />主页</a></li><li><a href="admin.php?controller=admin_index&amp;action=logout"><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/yw_09.jpg" width="15" height="16" align="absmiddle" />退出</a></li><?php if ($_smarty_tpl->tpl_vars['user']->value['common_user_pri'] || $_smarty_tpl->tpl_vars['user']->value['passwd_user_pri'] || $_smarty_tpl->tpl_vars['user']->value['audit_user_pri']) {?>
<li onmouseover="displaySubMenu(this)" onmouseout="hideSubMenu(this)"> 
<a href="#" ><img src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/images/list_ico8.gif" width="15" height="16" align="absmiddle" />切换</a>
<ul style='width:70px;'> 
<?php if (!$_smarty_tpl->tpl_vars['config']->value['ADMINAUDIT']) {?>
<?php if ($_smarty_tpl->tpl_vars['user']->value['common_user_pri']) {?>
<li><a href="admin.php?controller=admin_index&action=changerole&level=0">运维用户</a></li>
<?php }?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['user']->value['passwd_user_pri']) {?>
<li><a href="admin.php?controller=admin_index&action=changerole&level=10">密码用户</a></li>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['user']->value['audit_user_pri']) {?>
<li><a href="admin.php?controller=admin_index&action=changerole&level=2">审计用户</a></li>
<?php }?>
<li><a href="admin.php?controller=admin_index&action=changerole&level=<?php echo $_smarty_tpl->tpl_vars['user']->value['level'];?>
"><?php if ($_smarty_tpl->tpl_vars['user']->value['level'] == 1) {
} elseif ($_smarty_tpl->tpl_vars['user']->value['level'] == 2) {?>运维<?php } elseif ($_smarty_tpl->tpl_vars['user']->value['level'] == 3) {?>部门<?php } elseif ($_smarty_tpl->tpl_vars['user']->value['level'] == 4) {?>配置<?php } elseif ($_smarty_tpl->tpl_vars['user']->value['level'] == 10) {?>密码<?php }?>管理员</a></li>
</ul> 
</li> 
<a href="admin.php?controller=admin_index&amp;action=changerole"> </a><?php }?></ul></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr><td width="230" align="left" valign="top" id="left" >
	   <iframe id="menu" name="menu" src="admin.php?controller=admin_index&amp;action=menu&actions=<?php echo $_GET['actions'];?>
&ldapid=<?php echo $_GET['ldapid'];?>
&back=<?php echo $_GET['back'];?>
" marginwidth="0"  framespacing="0" marginheight="0" height="700" frameborder="0" width="230" allowtransparency="true" scrolling="auto" ></iframe>
	</td>
	 
        
        <td width="" align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>
		<iframe id="main" name="main" marginwidth="0" onload="reinitIframe();setScroll();" framespacing="0" marginheight="0" frameborder="0" width="100%" allowtransparency="true" scrolling="no" ></iframe></td></tr>
        </table></td>
      </tr>
      
    </table></td>
  </tr>
</table>

<?php echo '<script'; ?>
>

<?php if ($_SESSION['notices']) {?>
window.open ('admin.php?controller=admin_index&action=notice_tip', 'newwindow', 'height=330, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');
<?php }?>
<?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['ismac']->value && 0) {?>
<iframe src="freesvr://'&action=Run&'" height=0 width=0 />
<?php }?>
</body>
</html>
<?php }
}
?>