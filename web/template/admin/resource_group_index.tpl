<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" /></head>
<script>
function searchit(){
	var gid=0;
	{{if $_config.LDAP}}	
	{{if $_config.TREEMODE}}
	var obj1=document.getElementById('groupiddh');	
	gid=obj1.value;
	{{else}}
	for(var i=1; true; i++){		
		var obj=document.getElementById('groupid'+i);
		gid=obj.options[obj.options.selectedIndex].value;		
		if(obj!=null&&obj.options.selectedIndex>-1){
			gid=obj.options[obj.options.selectedIndex].value;
			continue;
		}
		break;
	}
	{{/if}}
	{{/if}}
	document.f1.action = "admin.php?controller=admin_pro&action=resource_group";
	document.f1.action += "&username="+document.f1.username.value;
	document.f1.action += "&group="+gid;
	document.f1.submit();
	return false;
}
</script>

<script type="text/javascript">
{{if $_config.LDAP}}
var servergroup = new Array();
{{/if}}
</script>
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
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=resource_group">系统用户组</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_app&action=app_group">应用用户组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_priority_search">系统权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=app_priority_search">应用权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
	<tr>
	<td class="" colspan = "4"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

                <TBODY>
				 <TR>
                    <TD >
					<form name ='f1' action='admin.php?controller=admin_pro&action=resource_group' method=post>
					&nbsp;&nbsp;用户<select name="username"  style="width:150px">
					<option value="">请选择</option>
					{{section name=u loop=$users}}
					<option value="{{$users[u].uid}}" {{if $username eq $users[u].uid}}selected{{/if}}>{{$users[u].username}}</option>
					{{/section}}
					</select>&nbsp;&nbsp;
					{{assign var=select_group_id value='agroupid'}}
					{{assign var=group_tip value='用户组'}}
					{{include file="select_sgroup_ajax.tpl" }}<input  type="submit" value=" 搜索 " onclick="return searchit();" class="bnnew2">
					</form>
					</TD>
                  </TR>
				  </table></td></tr>
  <tr>
	<td class="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
                <TBODY>

                  <TR>
                    <th class="list_bg" width="30%" ><a href="admin.php?controller=admin_pro&action=resource_group&orderby1=groupname&orderby2={{$orderby2}}" >组名</a></TD>
					 <th class="list_bg" width="50%"><a href="admin.php?controller=admin_pro&action=resource_group&orderby1=desc&orderby2={{$orderby2}}" >描述</a></TD>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			{{section name=t loop=$alldev}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
 <td> {{$alldev[t].groupname}}</td>
  <td> {{$alldev[t].desc}}</td>
				<td>
				{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 4}}<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=resource_group_edit&id={{$alldev[t].id}}'>编辑</a>
				 | <img src='{{$template_root}}/images/bind.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=resourcegroup_bind&id={{$alldev[t].id}}'>授权</a>{{/if}}
				 | <img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=resource_group_del&gname={{$alldev[t].groupname|urlencode}}';}">删除</a>
				
				</td> 
			</tr>
			{{/section}}
			<tr>
	           <td  colspan="1" align="left">
				
				<input size="30" type="button"  value="添加新组" onClick="location.href='admin.php?controller=admin_pro&action=resource_group_edit'" class="an_02">&nbsp;&nbsp;&nbsp;
				<input size="30" type="button"  value="导出" onClick="document.getElementById('hide').src='admin.php?controller=admin_pro&action=export_resourcegroup'" class="an_02">&nbsp;&nbsp;&nbsp;
				<input size="30" type="button"  value="导入" onClick="location.href='admin.php?controller=admin_pro&action=resource_group_import'" class="an_02">
		   </td>
		    <td  colspan="6" align="right"><input size="30" type="button"  value="权限导出" onClick="document.getElementById('hide').src='admin.php?controller=admin_pro&action=export_resourcegroup_priorty'" class="an_02">&nbsp;&nbsp;&nbsp;
				<input size="30" type="button"  value="权限导入" onClick="location.href='admin.php?controller=admin_pro&action=resource_group_import_priorty'" class="an_02">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_group_index&page='+this.value;">页
		   </td>
                <tr>
	          
		</tr>
		</TBODY>
              </TABLE>	</td>
  </tr>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}
window.parent.menu.document.getElementById('devtree').style.display='none';
window.parent.menu.document.getElementById('_tree').style.display='none';
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
</body>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


