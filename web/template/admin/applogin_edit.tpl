<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
	{{if $smarty.get.device_ip eq ''}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appserver_list">应用发布</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL ne 3}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appprogram_list">应用程序</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appicon_list">应用图标</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
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
</ul><span class="back_img"><A href="admin.php?controller={{if $fromapp eq 'search'}}admin_pro&action=app_priority_search{{else}}admin_config&action=apppub_list&ip={{$appserverip}}&device_ip={{$smarty.get.device_ip}}{{/if}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0" >
	
          <tr>
            <td align="center">
    <form name="f1" method=post action="admin.php?controller=admin_app&action=applogin_save&ip={{$appserverip}}&appdeviceid={{$appdeviceid}}&device_ip={{$smarty.get.device_ip}}">
	<table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="3" class="list_bg"></th></tr>
		
	{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>登录页面标题</td>
		<td width="67%"><input type="text" name="title" value="{{$p.title}}" /></td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>预登录标识</td>
		<td width="67%">
			标签类别:
			<select name="cTagname">
			<option value="button" {{if $p.cTagname eq 'button'}}selected{{/if}}>button</option>
			<option value="input" {{if $p.cTagname eq 'input'}}selected{{/if}}>input</option>
			<option value="select" {{if $p.cTagname eq 'select'}}selected{{/if}}>select</option>
			</select>
			
			标签识别:
			<select name="cTagAttributeType">
			<option value="1" {{if $p.cTagAttributeType eq 1}}selected{{/if}}>id</option>
			<option value="2" {{if $p.cTagAttributeType eq 2}}selected{{/if}}>name</option>
			<option value="3" {{if $p.cTagAttributeType eq 3}}selected{{/if}}>class</option>
			</select>		
			<input type="text" name="cTagAttributeValue" value="{{$p.cTagAttributeValue}}" />
		</td>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>用户标识</td>
		<td width="67%">
			标签类别:
			<select name="uTagname">
			<option value="button" {{if $p.uTagname eq 'button'}}selected{{/if}}>button</option>
			<option value="input" {{if $p.uTagname eq 'input'}}selected{{/if}}>input</option>
			<option value="select" {{if $p.uTagname eq 'select'}}selected{{/if}}>select</option>
			</select>
			
			标签识别:
			<select name="uTagAttributeType">
			<option value="1" {{if $p.uTagAttributeType eq 1}}selected{{/if}}>id</option>
			<option value="2" {{if $p.uTagAttributeType eq 2}}selected{{/if}}>name</option>
			<option value="3" {{if $p.uTagAttributeType eq 3}}selected{{/if}}>class</option>
			</select>		
			<input type="text" name="uTagAttributeValue" value="{{$p.uTagAttributeValue}}" />
		</td>
	</tr>
	
		{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>密码标识</td>
		<td width="67%">
			标签类别:
			<select name="pTagname">
			<option value="button" {{if $p.pTagname eq 'button'}}selected{{/if}}>button</option>
			<option value="input" {{if $p.pTagname eq 'input'}}selected{{/if}}>input</option>
			<option value="select" {{if $p.pTagname eq 'select'}}selected{{/if}}>select</option>
			</select>
			
			标签识别:
			<select name="pTagAttributeType">
			<option value="1" {{if $p.pTagAttributeType eq 1}}selected{{/if}}>id</option>
			<option value="2" {{if $p.pTagAttributeType eq 2}}selected{{/if}}>name</option>
			<option value="3" {{if $p.pTagAttributeType eq 3}}selected{{/if}}>class</option>
			</select>		
			<input type="text" name="pTagAttributeValue" value="{{$p.pTagAttributeValue}}" />
		</td>
	  </tr>
	 
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					<td></td><td><input type="hidden" name="ac" value="new" />
<input type="hidden" name="id" value="{{$p.uid}}" />
<input type=submit  value="保存修改" class="an_02"></td></tr>
	</table>
</form>
	</td>
  </tr>
</table>
</body>

<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>