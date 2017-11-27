<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>路由列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" /><script src="./template/admin/cssjs/global.functions.js"></script>
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
<script type="text/javascript">
{{if $_config.LDAP}}
var foundparent = false;
var servergroup = new Array();
var i=0;
{{section name=a loop=$allsgroup}}
servergroup[i++]={id:{{$allsgroup[a].id}},name:'{{$allsgroup[a].groupname}}',ldapid:{{$allsgroup[a].ldapid}},level:{{$allsgroup[a].level}}};
{{/section}}

{{/if}}
</script>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
{{if $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 101}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{if $smarty.session.ADMIN_LEVEL eq 10}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
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
</ul><span class="back_img"><A href="admin.php?controller=admin_pro&action=dev_index&gid={{$gid}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
</head>

<body>

		<form name='route' action='admin.php?controller=admin_pro&action=dobatchdevsave' method='post'>
 <tr>
	<td class="" colspan = "7">
	<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">
	<TBODY>
	 <TR>
		<TD >
		
		{{include file="select_sgroup.tpl" }}           
		</TD>
	  </TR>
	  </table>
	  </td>
 </tr>

  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
		<tr bgcolor="#F3F8FC">
			<th class="list_bg"  width="3%" align="center" bgcolor="#E0EDF8"><b>序列</b></th>
			<th class="list_bg"  width="18%" align="center" bgcolor="#E0EDF8"><b>服务器地址</b></th>
			<th class="list_bg"  width="18%" align="center" bgcolor="#E0EDF8"><b>主机名</b></th>
			<th class="list_bg"  width="5%" align="center" bgcolor="#E0EDF8"><b>系统类型</b></th>
		</tr>		
		{{section name=t loop=$devs}}
		
		<tr>
			<td class="td_line">{{$smarty.section.t.index+1}}</td>
			<td class="td_line">{{$devs[t].device_ip}}</td>
			<td class="td_line"><input type="text" class="wbk" name="hostname[]" size="30" value="{{$devs[t].hostname}}" /></td>
			<td class="td_line">
				<select  class="wbk"  name="type_id[]">
				{{section name=g loop=$alltype}}
					<OPTION VALUE="{{$alltype[g].id}}" {{if $alltype[g].id == $devs[t].device_type}}selected{{/if}}>{{$alltype[g].device_type}}</option>
				{{/section}}
				</select>
			</td>
		</tr>
		<input type="hidden" class="wbk" name="sid[]" size="30" value="{{$devs[t].id}}" />
		{{/section}}
		 <tr>
			<td colspan="9" align="center" ><input type='submit'  name="batch" value='确定' class="an_02"></td>
		  </tr>

		</table>
	</td>
  </tr>

		</form>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}
{{if $_config.LDAP}}
	{{$changelevelstr}}
	{{/if}}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



