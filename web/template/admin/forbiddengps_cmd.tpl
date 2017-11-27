<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Black}}{{$language.group}}{{$language.List}}</title>
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
<script>
	function searchit(){
		document.search.action = "admin.php?controller=admin_forbidden&action=forbiddengps_cmd&gid={{$gid}}";
		document.search.action += "&cmd="+document.search.cmd.value;
		document.search.submit();
		return true;
	}
	
</script>
<body>



	<table width="100%" border="0" cellspacing="0" cellpadding="0">

 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
{{if $smarty.session.ADMIN_LEVEL ne 3 and $smarty.session.ADMIN_LEVEL ne 21 and $smarty.session.ADMIN_LEVEL ne 101}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=default_policy">默认策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sourceip">来源IP组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=weektime">周组策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list">命令权限</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL ne 3 and $smarty.session.ADMIN_LEVEL ne 21 and $smarty.session.ADMIN_LEVEL ne 101}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=autochange_pwd">自动改密</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=cmdgroup_list">命令组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	{{if $smarty.session.ADMIN_LEVEL ne 3 and $smarty.session.ADMIN_LEVEL ne 21 and $smarty.session.ADMIN_LEVEL ne 101}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ipacl">授权策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow_contant">申请描述</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.LICENSE_KEY_NETMANAGER and $smarty.session.CACTI_CONFIG_ON}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=documentlist">文档上传</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller=admin_forbidden&action=forbidden_groups_list&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
<form name ='search' action='admin.php?controller=admin_member' method=post onsubmit="return searchit();">
  <tr>
    <td >	
					命令：<input type="text" name="cmd" size="13" class="wbk"/>&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>

					</td>
  </tr>
</form>	
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
	<form name="ip_list" action="admin.php?controller=admin_forbidden&action=del_forbiddengps_cmd&gid={{$gid}}" method="post">
			<tr>
				<th class="list_bg"  width="3%">选择</th>
				<th class="list_bg"  width="35%"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd&orderby1=cmd&gid={{$gid}}&orderby2={{$orderby2}}" >{{$language.Command}}</a></th>
				{{if !$ginfo.black_or_white}}
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd&orderby1=level&gid={{$gid}}&orderby2={{$orderby2}}" >级别</a></th>
				{{/if}}
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd&orderby1=toauthorize&gid={{$gid}}&orderby2={{$orderby2}}" >授权</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd&orderby1=gid&gid={{$gid}}&orderby2={{$orderby2}}" >{{$language.groupname}}</a></th>
				<th class="list_bg">{{$language.Operate}}</th>
			</tr>
			{{section name=t loop=$allcommand}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td><input type="checkbox" name="chk_gid[]" value="{{$allcommand[t].cid}}"></td>
				<td>{{$allcommand[t].cmd}}</td>
				{{if !$ginfo.black_or_white}}
				<td>{{if $allcommand[t].level eq 1}}断开连接{{elseif $allcommand[t].level eq 2}}命令监控{{elseif $allcommand[t].level eq 3}}命令授权{{else}}命令阻断{{/if}}</td>
				{{/if}}
				<td>{{if $allcommand[t].toauthorize eq 1}}Admin授权{{elseif $allcommand[t].toauthorize eq 2}}分组管理员授权{{elseif $allcommand[t].toauthorize eq 3}}双人授权{{else}}不授权{{/if}}</td>
				<td>{{$allcommand[t].gid}}</td>
				<td>
				<img src="{{$template_root}}/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd_edit&cid={{$allcommand[t].cid}}&gid={{$gid}}">编辑</a>
				| <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_forbidden&action=del_forbiddengps_cmd&cid={{$allcommand[t].cid}}&gid={{$gid}}">{{$language.Delete}}</a>				
				</td>
			</tr>
			{{/section}}
			
			
			<tr>
			<td align="left" colspan="3"><input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_gid[]')e.checked=this.form.select_all.checked;}" value="checkbox">全选&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="my_confirm('删除所选IP');if(chk_form()) document.ip_list.action='admin.php?controller=admin_config&action=delete_all_ip'; else return false;" class="an_02">&nbsp;&nbsp;
			<input type="button"  onclick="window.location='admin.php?controller=admin_forbidden&action=forbiddengps_cmd_edit&gid={{$gid}}'" name="submit"  value="{{$language.Add}}" class="an_02">&nbsp;&nbsp;<input type="button"  onclick="window.open ('admin.php?controller=admin_forbidden&action=from_cmdgroup&gid={{$gid}}', 'newwindow', 'height=330, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" name="submit"  value="从模版添加" class="an_06">
			&nbsp;&nbsp;<input type="button"  value="导出" onClick="location.href='admin.php?controller=admin_forbidden&action=forbiddengps_cmd_export&gid={{$gid}}'" class="an_02">&nbsp;&nbsp;<input type="button"  value="导入" onClick="location.href='admin.php?controller=admin_forbidden&action=forbiddengps_cmd_import&gid={{$gid}}'" class="an_02">
			<input type="hidden" name="add" value="new" >
			</td>
				<td colspan="{{if !$ginfo.black_or_white}}4{{else}}3{{/if}}" align="right">
					{{$language.all}}{{$command_num}}{{$language.Command}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_forbidden&action=dangerlist&page='+this.value;">{{$language.page}}
				</td>
			</tr>
			</form>
		</table>
	</td>
  </tr>
</table>


</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


