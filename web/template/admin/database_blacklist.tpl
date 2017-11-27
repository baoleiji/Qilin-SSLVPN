<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>数据库黑名单</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=default_policy">默认策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sourceip">来源IP组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=weektime">周组策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list">命令权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=autochange_pwd">自动改密</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=cmdgroup_list">命令组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ipacl">授权策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow_contant">申请描述</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.LICENSE_KEY_NETMANAGER and $smarty.session.CACTI_CONFIG_ON}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=documentlist">文档上传</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>
	
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
		<tr bgcolor="#F3F8FC">
			<th class="list_bg"  width="30%" align="center" bgcolor="#E0EDF8"><b><a href="admin.php?controller=admin_eth&action=database_blacklist&orderby1=device_ip&orderby2={{$orderby2}}" >地址</a></b></th>
			<th class="list_bg"  width="30%" align="center" bgcolor="#E0EDF8"><b><a href="admin.php?controller=admin_eth&action=database_blacklist&orderby1=netmask&orderby2={{$orderby2}}" >掩码</a></b></th>
			<th class="list_bg"  width="30%" align="center" bgcolor="#E0EDF8"><b>{{$language.Operate}}</b></th>
		</tr>		
		{{section name=t loop=$routes}}
		<form name='route' action='admin.php?controller=admin_eth&action=database_blacklist' method='post'>
		<tr>
			<td width="10%" class="td_line">{{$routes[t].device_ip}}</td>
			<td width="10%" class="td_line">{{$routes[t].netmask}}</td>
			<td class="td_line"  width="30%" align="left"><img src="{{$template_root}}/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_eth&action=dbbalcklist_edit&id={{$routes[t].id}}" >编辑</a>&nbsp;|&nbsp;<img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_eth&action=database_blacklist&delete={{$routes[t].id}}&id={{$routes[t].id}}" >删除</a></td>
		</tr>
		<input type="hidden" name="id" value="{{$routes[t].id}}" />
		</form>
		{{/section}}
		<tr>
						<td colspan="3" align="right">
							{{$language.all}}{{$total}}个  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}个{{$language.User}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_eth&page='+this.value;">{{$language.page}}
						</td>
					</tr>
		<tr>           
			<td colspan="3"> <input  onclick="window.location='admin.php?controller=admin_eth&action=dbbalcklist_edit'" type="button" value="{{$language.Add}}" class="an_02"></td>
			
		</tr>
		
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

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


