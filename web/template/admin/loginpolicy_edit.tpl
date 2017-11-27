<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/Calendarandtime.js"></script>
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
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
<script >
function changeuser(){
		if(document.getElementById('groups').style.display=='none'){
			document.getElementById('groups').style.display=''
			document.getElementById('users').style.display='none'
		}else{
			document.getElementById('users').style.display=''
			document.getElementById('groups').style.display='none'
		}
	}

	function changeserver(){
		if(document.getElementById('resources').style.display=='none'){
			document.getElementById('resources').style.display=''
			document.getElementById('servers').style.display='none'
		}else{
			document.getElementById('servers').style.display=''
			document.getElementById('resources').style.display='none'
		}
	}

	function newit(){
		if(document.getElementById('groups').style.display=='none'){
			document.getElementById('groups').disabled=true;
		}else{
			document.getElementById('users').disabled=true;
		}
		if(document.getElementById('resources').style.display=='none'){
			document.getElementById('resources').disabled=true;
		}else{
			document.getElementById('servers').disabled=true;
		}
	}
</script>
<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=resource_group">系统用户组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_app&action=app_group">应用用户组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_priority_search">系统权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=app_priority_search">应用权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_ipacl&action=loginpolicy&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
          <form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_ipacl&action=loginpolicy&id={{$p.id}}">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		<input type="button" value=" 用户/运维组 " onclick="changeuser();" />
		</td>
		<td width="67%">
		<select name="users" id="users" style="{{if !$p.memberid}}display:none{{/if}}">
					<option value="99999999" >所有</option>
					{{section name=u loop=$users}}
					<option value="{{$users[u].uid}}" {{if $p.memberid eq $users[u].uid}}selected{{/if}}>{{$users[u].username}}</option>
					{{/section}}
					</select>
					<select name="groups" id="groups" style="{{if !$p.usergroupid}}display:none{{/if}}">
					<option value="99999999" >所有</option>
					{{section name=g loop=$groups}}
					<option value="{{$groups[g].id}}" {{if $p.usergroupid eq $groups[g].id}}selected{{/if}}>{{$groups[g].groupname}}</option>
					{{/section}}
					</select>
	  </td>
	<tr>
		<td width="33%" align=right >
		<input type="button" value=" 设备/资源组 " onclick="changeserver();" />
		</td>
		<td width="67%">
		<select name="servers" id="servers" style="{{if !$p.serverid}}display:none{{/if}}">
					<option value="99999999" >所有</option>
					{{section name=s loop=$servers}}
					<option value="{{$servers[s].id}}" {{if $p.serverid eq $servers[s].id}}selected{{/if}}>{{$servers[s].device_ip}}</option>
					{{/section}}
					</select>
					<select name="resources" id="resources" style="{{if !$p.resourceid}}display:none{{/if}}">
					<option value="99999999" >所有</option>
					{{section name=sg loop=$resources}}
					<option value="{{$resources[sg].id}}" {{if $p.resourceid eq $resources[sg].id}}selected{{/if}}>{{$resources[sg].groupname}}</option>
					{{/section}}
					</select>
	  </td>
	 </tr>
	<tr bgcolor="f7f7f7">		
		<td width="33%" align=right >
		规则
	  </td>	
		<td width="67%">
		<select name="restrictacl" id="restrictacl" >
					<option value="" >所有</option>
					{{section name=a loop=$acl}}
					<option value="{{$acl[a].id}}" {{if $p.aclid eq $acl[a].id}}selected{{/if}}>{{$acl[a].aclname}}</option>
					{{/section}}
					</select>
	  </td></tr>
	

	<tr bgcolor="f7f7f7"><td align="center" colspan=2><input type=submit onClick="return newit();"  value="{{$language.Save}}" class="an_02"></td></tr>

<input type="hidden" name="ac" value="doinsert" />
	</form>
</table>
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});

function inputweek(week){
	var c = week.split(",");
	for(var i=0; i<c.length; i++){
		c[i]=parseInt(c[i]);
		if(c[i]>7 || c[i]<1){
			alert('不能输入大于7小于1的数字');
			document.getElementById('week').focus();
		}
	}
}

function inputday(day){
	var c = day.split(",");
	for(var i=0; i<c.length; i++){
		c[i]=parseInt(c[i]);
		if(c[i]>31 || c[i]<1){
			alert('不能输入大于31小于1的数字');
			document.getElementById('day').focus();
		}
	}
}

function inputmonth(month){
	var c = month.split(",");
	for(var i=0; i<c.length; i++){
		c[i]=parseInt(c[i]);
		if(c[i]>12 || c[i]<1){
			alert('不能输入大于12小于1的数字');
			document.getElementById('month').focus();
		}
	}
}

function check(){
	if(document.getElementById('aclname').value==""){
		alert('策略名不能为空');
		return false;
	}
	return true;
}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


