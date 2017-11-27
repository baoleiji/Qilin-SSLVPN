<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>会话列表</title>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
{{if $from ne 'status'}}
<tr><td valign="middle" class="hui_bj"><div class="menu">
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
	{{if $smarty.get.type eq 'run'}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=run">巡检帐号</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{else}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autotemplate">巡检管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=detail_config">巡检检测</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autorun_result">检测结果</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
</ul>
</div></td></tr>
{{/if}}
  <tr><td><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_autorun&action=autobackup_delete&type={{$smarty.get.type}}"><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
		
			<tr>
			{{if $from ne 'status'}}
				<th class="list_bg"  width="3%">选</th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type={{$smarty.get.type}}&ip={{$ip}}&orderby1=name&orderby2={{$orderby2}}" >名称</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type={{$smarty.get.type}}&ip={{$ip}}&orderby1=device_ip&orderby2={{$orderby2}}" >说明</a></th>
				<th class="list_bg"  width="5%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type={{$smarty.get.type}}&ip={{$ip}}&orderby1=upload&orderby2={{$orderby2}}" >间隔</a></th>
				<th class="list_bg"  width="">操作</th>
			{{else}}
				<td class="list_bg1"  width="3%">选</td>
				<td class="list_bg1"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type={{$smarty.get.type}}&ip={{$ip}}&orderby1=name&orderby2={{$orderby2}}" >名称</a></td>
				<td class="list_bg1"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type={{$smarty.get.type}}&ip={{$ip}}&orderby1=device_ip&orderby2={{$orderby2}}" >服务器IP</a></td>
				<td class="list_bg1"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type={{$smarty.get.type}}&ip={{$ip}}&orderby1=hostname&orderby2={{$orderby2}}" >服务器名称</a></td>
				<td class="list_bg1"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type={{$smarty.get.type}}&ip={{$ip}}&orderby1=username&orderby2={{$orderby2}}" >{{$word}}账号</a></td>
				<td class="list_bg1"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type={{$smarty.get.type}}&ip={{$ip}}&orderby1=desc&orderby2={{$orderby2}}" >{{$word}}内容</a></td>
				<td class="list_bg1"  width="5%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type={{$smarty.get.type}}&ip={{$ip}}&orderby1=su&orderby2={{$orderby2}}" >SUDO</a></td>
				<td class="list_bg1"  width="5%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type={{$smarty.get.type}}&ip={{$ip}}&orderby1=period&orderby2={{$orderby2}}" >周期</a></td>
				<td class="list_bg1"  width="10%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type={{$smarty.get.type}}&ip={{$ip}}&orderby1=lastruntime&orderby2={{$orderby2}}" >上次{{$word}}时间</a></td>
				<td class="list_bg1"  width="5%"><a href="admin.php?controller=admin_autorun&action=autobackup_list&type={{$smarty.get.type}}&ip={{$ip}}&orderby1=upload&orderby2={{$orderby2}}" >状态</a></td>
				<td class="list_bg1"  width="">操作</td>
			{{/if}}
			</tr>
			{{section name=t loop=$alldev}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td><input type="checkbox" name="chk_member[]" value="{{$alldev[t].id}}"></td>
				<td width="20%">{{$alldev[t].name}}</td>
				<td width="20%">{{$alldev[t].desc}}</td>
				<td width="20%">{{if $smarty.get.type eq 'run'}}{{$alldev[t].period}}{{else}}{{$alldev[t].interval}}{{/if}}</td>
				<td style="TEXT-ALIGN: left;"><img src='./template/admin/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_autorun&action=autobackup_save_backup&id={{$alldev[t].id}}&devicesid={{$alldev[t].deviceid}}&type={{$type}}&ip={{$ip}}&from={{$from}}'>修改</a>
				</td>
			</tr>
			{{/section}}
			
			<tr>
				<td  colspan="3" align="left">	<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value=" 删除 " onclick="my_confirm('{{$language.DeleteUsers}}');if(chk_form()) document.f1.action='admin.php?controller=admin_autorun&action=autobackup_delete&from={{$from}}'; else return false;" class="an_02">
				&nbsp;&nbsp;
				<input type="button" onclick="javascript:window.location='admin.php?controller=admin_autorun&action=autobackup_save_backup&type={{$type}}&ip={{$ip}}&from={{$from}}'"  value=" 增加 "  class="an_02">
				
				</td>
			
				<td colspan="10" align="right">
					共{{$command_num}}执行命令  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_session&action=dangerlist&page='+this.value;">页
				</td>
			</tr>
			</table>
			</form>
			<table  width="100%" >
			<tr><td  colspan="10" width="100%" align="center">
	<table id="f1table"  style="display:none"  border=0 width=100% cellpadding=1 cellspacing=1 bgcolor="#FFFFFF" class="BBtable" valign=top>

	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_autorun&action=autobackup_edit&type={{$type}}">
		<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.InputthedeviceIP}}
		</td>
		<td width="67%">
			<input name="ip" type="text" class="wbk"><input type=submit class=btn1 value="{{$language.Input}}">
	  </td>
	</tr>

	<tr>
		<td width="33%" align=right>
		{{$language.select}}{{$language.DeviceGroup}}
		</td>
		<td width="67%">&nbsp;</td>
		
</tr>
		{{section name=g loop=$alldevgroup}}
		<tr {{if $smarty.section.g.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td align=right>
			<input type="radio" name="controller" value="{{$alldevgroup[g].id}}" onClick="location.href='admin.php?controller=admin_autorun&action=autobackup_dev&g_id={{$alldevgroup[g].id}}&type={{$type}}'">
		</td>
		<td>
			{{$alldevgroup[g].groupname}}
		</td>
		</tr>
		{{/section}}
		</table>
	  </td>
	</tr>
	
<br>

</form>
</table>
<script type="text/javascript">
window.parent.menu.document.getElementById('devtree').style.display='none';
window.parent.menu.document.getElementById('ldaptree').style.display='none';
</script>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



