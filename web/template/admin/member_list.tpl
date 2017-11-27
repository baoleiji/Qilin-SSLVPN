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
<script>
	function searchit(){
		document.search.action = "admin.php?controller=admin_member{{if $smarty.session.RADIUSUSERLIST}}&action=radiususer{{/if}}";
		document.search.action += "&username="+document.search.username.value;
		document.search.submit();
		return true;
	}

	function uncheckAll(c){
		document.getElementById('select_all').checked = true;
		for(var i=0;i<document.member_list.elements.length;i++){
			var e=document.member_list.elements[i];
			if(e.name=='chk_member[]'&&!e.checked){
				document.getElementById('select_all').checked = false;
				break;
			}
		}
	}
	
function changeStyle(obj,c)
{
	if(c!='o'){
		obj.style.backgroundColor=c;
	}else{
		obj.style.backgroundColor="#FFCC80";
	}
}

function batchloginlock(){
	document.member_list.action = "admin.php?controller=admin_member&action=loginlock";
	document.member_list.submit();
	return true;
}

function adconfig(){
	window.location = "admin.php?controller=admin_member&action=adconfig";
}
</script>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<body>
	
 <TR>
<TD >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
<form name ='search' action='admin.php?controller=admin_member' method=post onsubmit="return searchit();">
  <tr>
    <td >
</td>
    <td >	
					用户名：<input type="text" name="username" size="13" class="wbk"/>&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>&nbsp;&nbsp;显示空目录<input type="checkbox" id="showemptydir" name="showemptydir" onclick="window.parent.menu.window.showNodeCount0(this.checked)"  />&nbsp;&nbsp;&nbsp;&nbsp;目录截取<input type="checkbox" name="showemptydir" onclick="window.parent.menu.window.showLongTitle(this.checked)" checked />

					</td>
  </tr>
</form>	
</table>
</TD>
                  </TR>
	  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	<form name="member_list" action="admin.php?controller=admin_member&action=delete_all" method="post">
					<tr>
						<th class="list_bg"  width="3%" >{{$language.select}}</th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_member&orderby1=username&orderby2={{$orderby2}}' >{{$language.Username}}</a></th>
						<th class="list_bg"  width="8%" ><a href='admin.php?controller=admin_member&orderby1=realname&orderby2={{$orderby2}}' >用户姓名</a></th>
						<th class="list_bg"  width="12%" ><a href='admin.php?controller=admin_member&orderby1=groupname&orderby2={{$orderby2}}' >运维组</a></th>
						<th class="list_bg"  width="10%" ><a href='admin.php?controller=admin_member&orderby1=workcompany&orderby2={{$orderby2}}' >工作单位</a></th>
						<th class="list_bg"  width="9%"><a href='admin.php?controller=admin_member&orderby1=usbkey&orderby2={{$orderby2}}' >令牌状态</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_member&orderby1=start_time&orderby2={{$orderby2}}' >生效时间</a></th>
						<th class="list_bg"  width="9%" ><a href='admin.php?controller=admin_member&orderby1=end_time&orderby2={{$orderby2}}' >{{$language.EndTime}}</a></th>
						{{if !$smarty.session.RADIUSUSERLIST}}
						<th class="list_bg"  width="6%" ><a href='admin.php?controller=admin_member&orderby1=level&orderby2={{$orderby2}}' >角色</a></th>
						{{/if}}
						<th class="list_bg"  width="24%" >{{$language.Operate}}{{$language.Link}}</th>
					</tr>
					{{section name=t loop=$allmember}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}} onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'{{if $smarty.section.t.index % 2 == 0}}f7f7f7{{/if}}');">
						<td>{{if ($smarty.session.ADMIN_LEVEL eq 4 and (!$allmember[t].level or $allmember[t].level == 3)) or ($smarty.session.ADMIN_LEVEL eq 1) or ($smarty.session.ADMIN_LEVEL eq 3) }}{{if ($allmember[t].level ne 1 and $allmember[t].level ne 10 and $allmember[t].level ne 2 and $allmember[t].level ne 3 and $allmember[t].level ne 101 and $allmember[t].level ne 21) or ($allmember[t].level eq 1 and $allmember[t].username ne 'admin')}}{{if !($allmember[t].username=='admin'&&$smarty.session.ADMIN_USERNAME ne 'admin')}}<input type="checkbox" name="chk_member[]" value="{{$allmember[t].uid}}" onclick="uncheckAll(this.checked);">{{/if}}{{/if}}{{/if}}</td>
						<td>{{if $allmember[t].onlinenumber > 0}}<a href='admin.php?controller=admin_member&action=online&username={{$allmember[t].username}}' ><img  border="0" src='{{$template_root}}/images/user_online.gif' title='在线' /></a>{{else}}<img border="0" src='{{$template_root}}/images/user_offline.gif'  title='离线' />{{/if}}{{$allmember[t].username}}</td>
						<td>{{if $allmember[t].realname}}{{$allmember[t].realname}}{{else}}未设置{{/if}}</td>
						<td>{{if $allmember[t].groupname eq 'null'}}无{{else}}{{$allmember[t].groupname}}{{/if}}</td>
						<td>{{$allmember[t].workcompany}}</td>
						<td>{{if $allmember[t].usbkey ne ''}}{{$allmember[t].usbkey}}{{elseif $allmember[t].usbkey_temp ne '' and $allmember[t].usbkeystatus eq 11}}未初始化{{elseif $allmember[t].usbkey_temp eq ''}}未绑定{{/if}}</td>
						<td>{{$allmember[t].start_time}}</td>
						<td>{{if $allmember[t].end_time eq '2037-01-01 00:00:00'}}{{$language.AlwaysValid}}{{else}}{{$allmember[t].end_time}}{{/if}}</td>
						{{if !$smarty.session.RADIUSUSERLIST}}
						<td><a href='admin.php?controller=admin_member&level={{$allmember[t].level}}' >{{if $allmember[t].level == 0}}认证{{$language.User}}{{elseif $allmember[t].level == 1}}{{$language.Administrator}}{{elseif $allmember[t].level == 3}}部门{{$language.Administrator}}{{elseif $allmember[t].level == 4}}配置{{$language.Administrator}}{{elseif $allmember[t].level == 10}}{{$language.Password}}{{$language.Administrator}}{{elseif $allmember[t].level == 21}}部门审计员{{elseif $allmember[t].level == 101}}部门密码员{{elseif $allmember[t].level == 11}}认证用户{{else}}{{$language.auditadministrator}}{{/if}}</a></td>
						{{/if}}
						<td>
						
						<!--<img src="{{$template_root}}/images/ckico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_dev&action=index&uid={{$allmember[t].uid}}">{{$language.Edit}}{{$language.device}}</a> |-->
						{{if ($smarty.session.ADMIN_LEVEL eq 4 and (!$allmember[t].level or $allmember[t].level == 3)) or ($smarty.session.ADMIN_LEVEL eq 1) or ($smarty.session.ADMIN_LEVEL eq 3)}}{{if !($allmember[t].username=='admin'&&$smarty.session.ADMIN_USERNAME ne 'admin')}}
						<img src="{{$template_root}}/images/{{if !$allmember[t].enable || $allmember[t].loginlock}}lock.png{{else}}lock_open.png{{/if}}" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=loginlock&uid={{$allmember[t].uid}}&enable={{if !(!$allmember[t].enable || $allmember[t].loginlock)}}1{{else}}0{{/if}}">{{if !$allmember[t].enable || $allmember[t].loginlock}}启用{{else}}禁用{{/if}}</a> |
						<img src="{{$template_root}}/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=edit&uid={{$allmember[t].uid}}">{{$language.Edit}}</a>  
						|&nbsp;<img src="{{$template_root}}/images/file.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_pro&action=resource_group_edit&uid={{$allmember[t].uid}}">权限</a>
						{{if $allmember[t].downpfx}} | 
						<img src="{{$template_root}}/images/pfx.jpg" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=downloadca&uid={{$allmember[t].uid}}">证书</a>  
						{{/if}}
						{{/if}}
						{{if $smarty.session.RADIUSUSERLIST}}<img src="{{$template_root}}/images/ico9.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_pro&action=viewradiusbind&uid={{$allmember[t].uid}}">查看</a>
						{{/if}}
						{{if $allmember[t].level != 10 and $allmember[t].level != 2 and $allmember[t].level != 1}}|&nbsp;<img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=delete&uid={{$allmember[t].uid}}" onclick="return confirm('确定删除？')">{{$language.Delete}}</a>{{/if}} 			
						{{/if}}
						</td>
					</tr>
					{{/section}}
					
					<tr>
						<td colspan="5" align="left">
							<input name="select_all" id="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=document.member_list.elements[i];if(e.name=='chk_member[]')e.checked=document.member_list.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="button"  value="{{$language.Add}}{{$language.User}}" onClick="javascript:document.location='admin.php?controller=admin_member&action=add&gid={{$smarty.get.gid}}&ldapid={{$smarty.get.ldapid}}';" class="an_02">&nbsp;&nbsp;<input type="submit"  value="删除用户" onClick="my_confirm('{{$language.DeleteUsers}}');if(chk_form()) document.member_list.action='admin.php?controller=admin_member&action=delete_all'; else return false;" class="an_02">&nbsp;&nbsp;<input type="submit"  value="批量编辑" onClick="javascript:document.member_list.action='admin.php?controller=admin_member&action=batchpriorityedit'" class="an_02">
							&nbsp;&nbsp;
						</form><form name="pageto" action="#" method="post">
						<td colspan="6" align="right">
						{{if !$smarty.session.RADIUSUSERLIST}}
						<input type="button"  value="导入" onClick="javascript: document.location='admin.php?controller=admin_member&action=memberimport';" class="an_02">
							&nbsp;&nbsp;<input type="button"  value="导出" onClick="javascript:document.location='{{$curr_url}}&derive=1';" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						{{/if}}
							{{$language.all}}{{$total}}个{{$language.User}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}个/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) {window.location='admin.php?controller=admin_member&page='+this.value;return false;}else this.value=this.value;">{{$language.page}}
							
						</td></form>
					</tr>
					
				
		  
					<tr>
						
					</tr>
				</table>
			
	  </table>
		</td>
	  </tr>
	</table>
	<iframe name="hide" height="0" frameborder="0" scrolling="no" id="hide"></iframe>
<script language="javascript">
window.parent.menu.window.showNodeCount0(false);
window.parent.menu.window.showLongTitle(true);
window.parent.menu.document.getElementById('_tree').style.display='';
window.parent.menu.document.getElementById('mtree').style.display='';
window.parent.menu.document.getElementById('devtree').style.display='none';
window.parent.menu.cururl='mtree';
</script>
</body>
</html>


