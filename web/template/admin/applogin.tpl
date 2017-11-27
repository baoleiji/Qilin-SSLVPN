<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>
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

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appserver_list">应用发布</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL ne 3}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appprogram_list">应用程序</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appicon_list">应用图标</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>
 
  <tr>
	<td class="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center">
				<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
				<tr><th colspan="1" class="list_bg">用户名</th><th colspan="1" class="list_bg">密码</th></tr>	
				  <tr>
				  <td width="50%" align=center>
					<select  class="wbk"  style="width:400;height:400;"  name="first" size="30" id="first" multiple="multiple" onclick="showit('u');">
					{{section name=ra loop=$usernames}}
					<option value="{{$usernames[ra].uid}}" title="{{$usernames[ra].username}}">{{$usernames[ra].username}}</option>
					{{/section}}
					</select>
					</td>
					 <td align="center">
					<select  class="wbk"   style="width:400;height:400;" size="30" id="secend" name="secend[]" multiple="multiple"  onclick="showit('p');">
					{{section name=r loop=$passwords}}
					<option value="{{$passwords[r].uid}}" title="{{$passwords[r].password}}" >{{$passwords[r].password}}</option>
					{{/section}}
					</select>
				  </td>
				</tr>
				<tr>
				<td align="center">
				<input type="hidden"  value="0" id="uid">
				<input type="text" name="username" id="username" />
				&nbsp;&nbsp;<input type="submit"  value="保存" onclick="fsave('u');" class="an_02">
				&nbsp;&nbsp;<input type="submit"  value="删除" onclick="fdel('u');" class="an_02">
				</td>
				<td align="center">
				<input type="text" name="password" id="password" />
				&nbsp;&nbsp;<input type="submit"  value="保存" onclick="fsave('p');" class="an_02">
				&nbsp;&nbsp;<input type="submit"  value="删除" onclick="fdel('p');" class="an_02">
				</td>
				</tr>
				</table>
			</td>
		</tr>
		
</table>

<script language="javascript">
var changed = false;
function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

</script>
<script type="text/javascript" >
	function fsave(up){
		if(up=='u'){
			window.location='admin.php?controller=admin_pro&action=applogin_save&username='+document.getElementById('username').value+'&uid='+document.getElementById('uid').value;
		}else{
			window.location='admin.php?controller=admin_pro&action=applogin_save&password='+document.getElementById('password').value+'&uid='+document.getElementById('uid').value;
		}
		return true;
	}

	function fdel(up){
		if(up=='u'){
			window.location='admin.php?controller=admin_pro&action=delapplogin&username='+document.getElementById('username').value+'&uid='+document.getElementById('uid').value;
		}else{
			window.location='admin.php?controller=admin_pro&action=delapplogin&password='+document.getElementById('password').value+'&uid='+document.getElementById('uid').value;
		}
		return true;
	}

	function showit(up){
		if(up=='u'){
			document.getElementById('username').value=document.getElementById('first').options[document.getElementById('first').options.selectedIndex].text;
			document.getElementById('uid').value=document.getElementById('first').options[document.getElementById('first').options.selectedIndex].value;
		}else{
			document.getElementById('password').value=document.getElementById('secend').options[document.getElementById('secend').options.selectedIndex].text;
			document.getElementById('uid').value=document.getElementById('secend').options[document.getElementById('secend').options.selectedIndex].value;
		}
		return true;
	}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


