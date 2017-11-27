<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script>
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
		alert("您没有{{$language.select}}任何{{$language.User}}！");
		return false;
	}
</script>
</head>

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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
     <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>	
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>

	  <tr><td>
	<form name="member_list" action="admin.php?controller=admin_member&action=offline" method="post">
				<table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
						<th class="list_bg"  width="3%" class="list_bg">{{$language.select}}</th>
						<th class="list_bg"  width="9%" class="list_bg">用户名</th>
						<th class="list_bg"  width="9%" class="list_bg">用户等级</th>
						<th class="list_bg"  width="9%" class="list_bg">登录时间</th>
						<th class="list_bg"  width="9%" class="list_bg">最近活动时间</th>
						<th class="list_bg"  width="6%" class="list_bg">IP</th>
						<th class="list_bg"  width="24%" class="list_bg">{{$language.Operate}}{{$language.Link}}</th>
					</tr>
					{{section name=t loop=$online_users}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td>{{if $online_users[t].ssid ne $current_session_id}}<input type="checkbox" name="chk_member[]" value="{{$online_users[t].ssid}}">{{/if}}</td>
						<td>{{$online_users[t].username}}</td>
						<td>{{if $online_users[t].level eq 1}}管理员{{elseif $online_users[t].level eq 2}}审计员{{elseif $online_users[t].level eq 21}}部门审计员{{elseif $online_users[t].level eq 3}}部门管理员{{elseif $online_users[t].level eq 10}}密码管理员{{elseif $online_users[t].level eq 101}}部门密码管理员{{elseif $online_users[t].level eq 0}}运维用户{{/if}}</td>
						<td>{{$online_users[t].logindate}}</td>
						<td>{{$online_users[t].lastactime}}</td>
						<td>{{$online_users[t].ip}}</td>
						<td align="center">
						{{if $smarty.session.ADMIN_LEVEL eq 1}}
						{{if $online_users[t].ssid ne $current_session_id}}<img src="{{$template_root}}/images/disconnect.png" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=offline&ssid={{$online_users[t].ssid}}" >断开</a>{{/if}}{{/if}}
						</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="8" align="left">
							<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">{{$language.select}}{{$language.this}}{{$language.page}}{{$language.displayed}}的{{$language.All}}{{$language.User}}&nbsp;&nbsp;<input type="submit"  value=" 断开选定的用户" onclick="my_confirm('确定要断开用户?');if(chk_form()) document.member_list.action='admin.php?controller=admin_member&action=offline_all'; else return false;" class="an_06">
						</td>
					</tr>
			</form>
					
			
			</table>
		</td>
	  </tr>
	</table>
	
</body>
</html>


