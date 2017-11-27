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
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autotemplate">巡检管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=detail_config">巡检检测</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autorun_result">检测结果</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
</ul>
</div></td></tr>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">  
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
		<form name="f1" method=post action="admin.php?controller=admin_autorun&action=autobackup_delete&type={{$smarty.get.type}}">
			<tr>
				<th class="list_bg"  width="3%">选</th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_autorun&action=autotemplate&orderby1=name&orderby2={{$orderby2}}" >名称</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_autorun&action=autotemplate&orderby1=scriptpath&orderby2={{$orderby2}}" >模板位置</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_autorun&action=autotemplate&orderby1=desc&orderby2={{$orderby2}}" >模板描述</a></th>
				<th class="list_bg"  width="15%">操作</th>
			</tr>
			{{section name=t loop=$alldev}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td><input type="checkbox" name="chk_member[]" value="{{$alldev[t].id}}"></td>
				<td>{{$alldev[t].name}}</td>
				<td>{{$alldev[t].scriptpath}}</td>
				<td>{{$alldev[t].desc}}</ td>
				<td style="TEXT-ALIGN: left;"><img src='./template/admin/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_autorun&action=autotemplate_edit&id={{$alldev[t].id}}'>修改</a>| <img src='./template/admin/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_autorun&action=autobackup_save&type=run&id={{$alldev[t].id}}'>绑定</a>| <img src='./template/admin/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_autorun&action=viewtemplate&id={{$alldev[t].id}}' target="_blank">查看</a>| <img src='./template/admin/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_autorun&action=autotemplate_del&id={{$alldev[t].id}}'>删除</a></td>
			</tr>
			{{/section}}
			
			<tr>
				<td  colspan="3" align="left">	<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除" onclick="my_confirm('{{$language.DeleteUsers}}');if(chk_form()) document.f1.action='admin.php?controller=admin_autorun&action=autotemplate_del'; else return false;" class="an_02">
				&nbsp;&nbsp;
				<input type="button" onclick="window.location='admin.php?controller=admin_autorun&action=autotemplate_edit'"  value="增加"  class="an_02">
				
				</td>
			
				<td colspan="10" align="right">
					共{{$command_num}}执行命令  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_session&action=dangerlist&page='+this.value;">页
				</td>
			</tr>
			</form>
		
</form>
		</table>
	</td>
  </tr>
</table>
<script language="javascript">
window.parent.menu.document.getElementById('devtree').style.display='none';
window.parent.menu.document.getElementById('ldaptree').style.display='none';

function my_confirm(str){
 return confirm(str);
}
function chk_form(){
    return true;
}
</script>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



