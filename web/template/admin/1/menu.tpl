<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$site_title}}</title>
<meta name="author" content="nuttycoder">
<STYLE>
BODY { background-image:url({{$template_root}}/images/left_bg.gif); FONT: 12px 宋体; 
}
A {
	COLOR: #002fc3; TEXT-DECORATION: none
}
A:hover {
	COLOR: #ff0000; TEXT-DECORATION: underline
}
DIV {
	BACKGROUND-COLOR: #ffffff; 
}
.logo{BACKGROUND-IMAGE: url({{$template_root}}/images/logo.gif); HEIGHT: 69px; width:170px; margin-left:4px; margin-top:5px;}
.div_box1 {
	MARGIN: 2px 5px 0px;width:170px; 
}
.div_box2 {
	 PADDING-RIGHT: 5px; BORDER-TOP: medium none; DISPLAY: none; PADDING-LEFT: 15px; PADDING-BOTTOM: 5px; LINE-HEIGHT: 150%; PADDING-TOP: 5px; 
}

.div_box2 li
{
 list-style:none; margin-left:-20px;  }
.div_box3 {
	PADDING-RIGHT: 6px; PADDING-LEFT: 20px; FONT-WEIGHT: bold;  COLOR: #ffffff; PADDING-TOP: 6px; HEIGHT: 24px; width:168px; cursor:hand;
}
.div_box3 a{COLOR: #ffffff;  cursor:hand;
}
</STYLE>
<script language="javascript">
	function show_box(box_id){
		if(document.getElementById(box_id).style.display != "block"){
			document.getElementById(box_id).style.display = "block";
		} else {
			document.getElementById(box_id).style.display = "none";
		}
	}
</script>
</head>

<body>

<DIV class="logo"></DIV>
	<div class="div_box1">
		<div class="div_box3" style="background-image:url('{{$template_root}}/images/left_menubg.gif');">
			<a href="admin.php?controller=admin_index&action=main" target="main">管理首页</a>&nbsp;|&nbsp;<a href="admin.php?controller=admin_index&action=logout" target="_top">退出</a>
		</div>
		<div class="div_box2" id="login_info" style="display:block;">
			{{$site_title}}后台管理<br />
			用户名:{{$username}}<br />
			权限:{{if $admin_level == 0}}普通用户{{elseif $admin_level == 1}}管理员{{/if}}
		</div>
	</div>
	<div class="div_box1">
		<div class="div_box3" style="background-image:url('{{$template_root}}/images/left_menubg.gif');" onclick="javascript:show_box('article_manage');">
			会话管理
		</div>
		<div class="div_box2" id="article_manage">
			<li><img src="{{$template_root}}/images/ico1.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_session" target="main">会话列表</a><br>
			<li><img src="{{$template_root}}/images/ico1.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_sqlnet" target="main">Oracle会话列表</a><br>
			<li><img src="{{$template_root}}/images/ico1.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_http" target="main">http/https会话列表</a><br>
			<li><img src="{{$template_root}}/images/ico1.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_ftp" target="main">FTP会话列表</a><br>

			{{if $admin_level == 1}}
			<li><img src="{{$template_root}}/images/ico1.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_session&action=running_list" target="main">正在运行的会话</a><br>
			<li><img src="{{$template_root}}/images/ico1.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_dev&action=update_all" target="main">更新设备列表</a><br>
			{{/if}}
			<li><img src="{{$template_root}}/images/ico2.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_session&action=search" target="main">高级搜索</a><br>

		</div>
	</div>
	{{if $admin_level == 1}}
	<div class="div_box1">
		<div class="div_box3" style="background-image:url('{{$template_root}}/images/left_menubg.gif');" onclick="javascript:show_box('info_manage');">
			程序配置
		</div>
		<div class="div_box2" id="info_manage">
		{{*	<li><img src="{{$template_root}}/images/ico3.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_config&action=server_edit" target="main">服务器端配置</a><br>
			<li><img src="{{$template_root}}/images/ico4.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_config&action=prompts_edit" target="main">Prompts配置</a><br>  *}}
			<li><img src="{{$template_root}}/images/ico4.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_config&action=ip_list" target="main">合法来源IP配置</a><br>
			<li><img src="{{$template_root}}/images/ico3.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_session&action=dangerlist" target="main">危险行为列表</a><br>

		</div>
	</div>
	{{/if}}
	{{if $admin_level == 1}}
	<div class="div_box1">
		<div class="div_box3" style="background-image:url('{{$template_root}}/images/left_menubg.gif');" onclick="javascript:show_box('log_manage');">
			日志查看
		</div>
		<div class="div_box2" id="log_manage">
			<li><img src="{{$template_root}}/images/ico3.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_log&action=list_login" target="main">登录日志</a>|<a href="admin.php?controller=admin_log&action=search_login" target="main">搜索</a><br>
			<li><img src="{{$template_root}}/images/ico3.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_log&action=list_crontab" target="main">crontab日志</a>|<a href="admin.php?controller=admin_log&action=search_crontab" target="main">搜索</a><br>
		</div>
	</div>
	{{/if}}

	{{if $admin_level == 1}}
	<div class="div_box1">
		<div class="div_box3" style="background-image:url('{{$template_root}}/images/left_menubg.gif');" onclick="javascript:show_box('vpn');">
			vpn配置
		</div>
		  <DIV class="div_box2" id="vpn" >
    <LI><IMG width="16" height="16" hspace="2"  vspace="2" align="absmiddle" src="{{$template_root}}/images/list_ico15.gif" ><A title="系统配置" href="admin.php?controller=admin_eth&action=config_sys" target="main">系统配置</A></LI></br>
    <LI><IMG width="16" height="16" hspace="2"  vspace="2" align="absmiddle"
src="{{$template_root}}/images/list_ico17.gif" ><A title=网络配置
href="admin.php?controller=admin_eth&action=config_net"
target="main">网络配置</A></LI></br>
    <LI><IMG width="16" height="16" hspace="2"  vspace="2" align="absmiddle"
src="{{$template_root}}/images/list_ico16.gif" ><A title=路由配置
href="admin.php?controller=admin_eth&action=route_list"
target="main">路由配置</A></LI></br>
    <LI><IMG width="16" height="16" hspace="2"  vspace="2" align="absmiddle"
src="{{$template_root}}/images/list_ico16.gif" ><A title=系统状态
href="admin.php?controller=admin_eth&action=status"
target="main">系统状态</A></LI></br>
   <LI><IMG width="16" height="16" hspace="2"  vspace="2" align="absmiddle"
src="{{$template_root}}/images/list_ico16.gif" ><A title=Radius配置
href="admin.php?controller=admin_eth&action=show_radius"
target="main">Radius配置</A></LI></br>
  </DIV>
	</div>
	{{/if}}

	{{*
	<div class="div_box1">
		<div class="div_box3" style="background-image:url('{{$template_root}}/images/left_menubg.gif');" onclick="javascript:show_box('facility_manage');">
			设备管理
		</div>
		<div  class="div_box2" id="facility_manage">
		{{if $admin_level == 1}}
		<li><img src="{{$template_root}}/images/ico5.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_facility&action=templet_list" target="main">模板管理</a><br>
		<li><img src="{{$template_root}}/images/ico6.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_facility&action=add" target="main">添加设备</a><br>
		{{/if}}
			<li><img src="{{$template_root}}/images/ico7.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_facility" target="main">设备列表</a>
		</div>
	</div>	
	*}}
	{{if $admin_level == 1}}
	<div class="div_box1">
		<div class="div_box3" style="background-image:url('{{$template_root}}/images/left_menubg.gif');" onclick="javascript:show_box('compare_manage');">
			配置监控
		</div>
		<div  class="div_box2" id="compare_manage">
		
		<li><img src="{{$template_root}}/images/ico7.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_compare" target="main">监控设备列表</a><br>
		<li><img src="{{$template_root}}/images/ico6.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_compare&action=device_add&type=new" target="main">添加监控设备</a><br>
		<li><img src="{{$template_root}}/images/ico6.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_compare&action=template_list" target="main">linux监控模板</a><br>
		
		</div>
	</div>
	{{/if}}

	
	<div class="div_box1">
		<div class="div_box3" style="background-image:url('{{$template_root}}/images/left_menubg.gif');" onclick="javascript:show_box('auto_log');">
			自动登录
		</div>
		<div  class="div_box2" id="auto_log">
		{{if $admin_level == 1}}
		<li><img src="{{$template_root}}/images/ico5.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_ccontrol&action=status" target="main">开启/关闭自动登陆功能</a><br>
		{{else}}
			<li><img src="{{$template_root}}/images/ico9.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_auto&action=aluser_edit" target="main">编辑默认自动登录账户</a>
			<li><img src="{{$template_root}}/images/ico9.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_auto&action=alnet_edit&ntype=new" target="main">添加自动登录网段</a>
			<li><img src="{{$template_root}}/images/ico9.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_auto&action=net_index" target="main">自动登录网段列表</a>

		{{/if}}
		</div>
	</div>
	<div class="div_box1">
		<div class="div_box3" style="background-image:url('{{$template_root}}/images/left_menubg.gif');" onclick="javascript:show_box('auto_login');">
			访问控制
		</div>
		<div  class="div_box2" id="auto_login">
		{{if $admin_level == 1}}
			{{*<li><img src="{{$template_root}}/images/ico5.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_ccontrol&action=status" target="main">开启/关闭自动登陆功能</a><br>*}}
			<li><img src="{{$template_root}}/images/ico8.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_ccontrol&action=net_edit&type=new" target="main">添加控制组</a><br>
		{{/if}}
		
		<li><img src="{{$template_root}}/images/ico9.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_ccontrol&action=net_index" target="main">控制组列表</a>
		</div>
	</div>

	{{if $admin_level == 1}}
	<div class="div_box1">
		<div class="div_box3" style="background-image:url('{{$template_root}}/images/left_menubg.gif');" onclick="javascript:show_box('user_manage');">
			用户管理
		</div>
		<div  class="div_box2" id="user_manage">
		<li><img src="{{$template_root}}/images/ico8.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_member&action=add" target="main">添加用户</a><br>
		<li><img src="{{$template_root}}/images/ico9.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_member" target="main">用户列表</a>
		</div>
	</div>
	{{/if}}
	
	{{if $admin_level == 1}}
	<div class="div_box1">
		<div class="div_box3" style="background-image:url('{{$template_root}}/images/left_menubg.gif');" onclick="javascript:show_box('systemuser_manage');">
			系统用户管理
		</div>
		<div  class="div_box2" id="systemuser_manage">
		<li><img src="{{$template_root}}/images/ico8.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_passwd&action=add" target="main">添加系统用户</a><br>
		<li><img src="{{$template_root}}/images/ico9.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_passwd" target="main">系统用户列表</a>
		</div>
	</div>
	{{/if}}

	<div class="div_box1">
		<div class="div_box3" style="background-image:url('{{$template_root}}/images/left_menubg.gif');" onclick="javascript:show_box('other_manage');">
			其它
		</div>
		<div class="div_box2" id="other_manage">
			{{if $admin_level == 1}}
			<li><img src="{{$template_root}}/images/ico10.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_backup" target="main">备份/恢复</a><br>
			<li><img src="{{$template_root}}/images/ico11.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_backup&action=refresh_dev" target="main">更新设备表</a><br>
			<li><img src="{{$template_root}}/images/ico11.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_eth&action=config_eth" target="main">更新设备地址</a><br>
			{{/if}}
			<li><img src="{{$template_root}}/images/ico12.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_member&action=edit_self" target="main">修改个人信息</a><br>
			<li><img src="{{$template_root}}/images/ico1.gif" width="16" height="16" hspace="2"  vspace="2" align="absmiddle"><a href="admin.php?controller=admin_index&action=license" target="main">license列表</a><br>
		</div>
	</div>

</body>
</html>
