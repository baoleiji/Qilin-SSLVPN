<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>路由列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
 <SCRIPT language=javascript src="{{$template_root}}/images/selectdate.js"></SCRIPT>
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

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
{{if $smarty.session.ADMIN_LEVEL eq 10}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{else}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $from eq 'dir'}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{else}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{/if}}
	{{if $from eq 'dir'}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{else}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
{{/if}}
</ul><span class="back_img"><A href="javascript:history.back();"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
		<tr bgcolor="#F3F8FC">
			<th class="list_bg"  width="5%" align="center" bgcolor="#E0EDF8"><b>序列</b></th>
			<th class="list_bg"  width="9%" align="center" bgcolor="#E0EDF8"><b>用户名</b></th>
			<th class="list_bg"  width="9%" align="center" bgcolor="#E0EDF8"><b>密码</b></th>
			<th class="list_bg"  width="9%" align="center" bgcolor="#E0EDF8"><b>确认密码</b></th>
			<th class="list_bg"  width="9%" align="center" bgcolor="#E0EDF8"><b>登录方式</b></th>
			<th class="list_bg"  width="5%" align="center" bgcolor="#E0EDF8"><b>端口</b></th>
			<th class="list_bg"  align="center" bgcolor="#E0EDF8"><b>过期时间</b></th>
		</tr>		
		<form name='route' action='admin.php?controller=admin_pro&action=pass_batchsave&id={{$id}}&ip={{$ip}}&serverid={{$serverid}}&gid={{$gid}}' method='post'>
		{{section name=t loop=20}}
		
		<tr>
			<td width="3%" class="td_line">{{$smarty.section.t.index+1}}</td>
			<td width="10%" class="td_line"><input type="text" class="wbk" name="username[]" value="" /></td>
			<td width="10%" class="td_line"><input type="password" name="password[]" value="" /></td>
			<td width="10%" class="td_line"><input type="password" name="confirm_password[]" value="" /></td>
			<td width="10%" class="td_line"><select  class="wbk"  name="l_id[]" onchange="changeport({{$smarty.section.t.index+1}})">
		{{section name=g loop=$allmethod}}
			<OPTION id ="{{$allmethod[g].login_method}}{{$smarty.section.t.index+1}}" VALUE="{{$allmethod[g].id}}" {{if $allmethod[g].id == $l_id}}selected{{/if}}>{{if $allmethod[g].login_method eq 'apppub'}}应用发布{{else}}{{$allmethod[g].login_method}}{{/if}}</option>
		{{/section}}
		</select></td>
		<td><input type=text name="port[]" id="port{{$smarty.section.t.index+1}}" size=4 value="{{if $port}}{{$port}}{{else}}{{$sshport}}{{/if}}" ></td>
		<td><INPUT value="{{$limit_time}}" id="limit_time{{$smarty.section.t.index+1}}" name="limit_time[]"><IMG onClick="getDatePicker('limit_time{{$smarty.section.t.index+1}}', event)" src="{{$template_root}}/images/time.gif"> {{$language.clicktoselectdate}}{{$language.or}}{{$language.select}} {{$language.AlwaysValid}}<INPUT {{if $nolimit == 1}} checked {{/if}} type=checkbox name="nolimit[]">  </td>
		</tr>
		
		{{/section}}
		 <tr>
			<td colspan="9" align="center" ><input type='submit'  name="batch" value='确定'  class="an_02"></td>
		  </tr>
		</form>

		</table>
	</td>
  </tr>

</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}
var siteUrl = "{{$template_root}}/images/date";
function changeport(number) {
	var port = document.getElementById('port'+number);
	if(document.getElementById("ssh"+number).selected==true)  {	
		port.value = {{$sshport}};
	}
	if(document.getElementById("telnet"+number).selected==true)  {
		port.value = {{$telnetport}};
	}
	if(document.getElementById("ftp"+number).selected==true)  {
		port.value = {{$ftpport}};
	}
	if(document.getElementById("RDP"+number).selected==true)  {
		port.value = {{$rdpport}};
	}
	if(document.getElementById("vnc"+number).selected==true)  {
		port.value = 5901;
	}
	if(document.getElementById("rlogin"+number).selected==true)  {
		port.value = {{$rdpport}};
	}
	if(document.getElementById("ssh1"+number).selected==true)  {
		port.value = {{$sshport}};
	}
	if(document.getElementById("apppub"+number).selected==true)  {
		port.value = {{$rdpport}};
	}
	
}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



