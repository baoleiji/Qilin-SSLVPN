<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function $(id) {
	return !id ? null : document.getElementById(id);
}

function toggle_group(oid, obj, isChild) {
	obj = obj ? obj : $('a_'+oid);
	if(!conf) {
		var conf = {'show':'[-]','hide':'[+]'};
	}
	if(isChild){
		var obody = $(oid);
	}else{
		var obody = $(oid+'0');
	}
	var ids = oid.split('_');
	if(obody.style.display == 'none') {		
		if(isChild){
			obody.style.display = '';
		}else{
			var tbodys = document.getElementsByTagName('tbody');
			for(var i=0; i<tbodys.length; i++){
				if(tbodys[i].attributes.length>1&&tbodys[i].attributes.name!=undefined){
					if(tbodys[i].attributes.name.nodeValue==oid){
						tbodys[i].style.display = '';
					}
				}
			}
		}		
		obj.innerHTML = conf.show;
	} else {
		if(isChild){
			obody.style.display = 'none';
		}else{
			var tbodys = document.getElementsByTagName('tbody');
			for(var i=0; i<tbodys.length; i++){
				if(tbodys[i].attributes.length>1){
					if(tbodys[i].attributes.name!=undefined&&tbodys[i].attributes.name.nodeValue==oid){
						tbodys[i].style.display = 'none';
						if(tbodys[i].attributes.aid!=undefined)
						$(tbodys[i].attributes.aid.nodeValue).innerHTML = conf.hide;
					}else if(tbodys[i].id.substring(0, oid.length) ==oid){
						tbodys[i].style.display = 'none';
					}
				}
			}
		}
		obj.innerHTML = conf.hide;
	}
	window.parent.reinitIframe();
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
     <li class="me_{{if $smarty.session.RADIUSUSERLIST}}b{{else}}a{{/if}}"><img src="{{$template_root}}/images/an1{{if $smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an3{{if $smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_{{if $smarty.session.RADIUSUSERLIST}}a{{else}}b{{/if}}"><img src="{{$template_root}}/images/an1{{if !$smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an3{{if !$smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>
	
  <tr>
	<td class="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                <TBODY>
				   {{*<TR>
<form name="f1" method=post action="admin.php?controller=admin_member&action=usergroup_save">
{{$language.ServerGroupName}}称<input type = text name="groupname">
<input type="submit"  value="{{$language.Add}}{{$language.ServerGroup}}" class="an_02">
</form>
                  </TR>*}}
                  <TR>

				  <th class="list_bg" width="1%"></TD>
                    <th class="list_bg" width="20%" ><a href="admin.php?controller=admin_member&action=usergroup&orderby1=groupname&orderby2={{$orderby2}}" >组名</a></TD>
					{{if $_config.LDAP}}
					<th class="list_bg" width="20%" ><a href = "admin.php?controller=admin_member&action=usergroup&orderby1=level&orderby2={{$orderby2}}">目录级别</a></th>
					{{/if}}
					<th class="list_bg" width="10%" ><a href="admin.php?controller=admin_member&action=dev_group&orderby1=count&orderby2={{$orderby2}}" >用户数数</a></TD>
					<th class="list_bg" width="20%" ><a href="admin.php?controller=admin_member&action=dev_group&orderby1=description&orderby2={{$orderby2}}" >描述</a></TD>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			{{if $_config.LDAP}}
			{{section name=t loop=$allgroup}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<TD  onClick="toggle_group('ldap_{{$smarty.section.t.index}}', $('a_ldap_{{$smarty.section.t.index}}'))" class=td25 width="30" align="center">{{if $allgroup[t].children_ct gt 0}}<span class="td25"><A id=a_ldap_{{$smarty.section.t.index}} href="javascript:;">[+]</A></span>{{/if}}</TD>
				<td> <a href='admin.php?controller=admin_member&action=index&gid={{$allgroup[t].id}}'>{{$allgroup[t].groupname}}</a></td>
				{{if $_config.LDAP}}
				<td> <a href='admin.php?controller=admin_member&action=usergroup&level={{$allgroup[t].level}}'>{{if $allgroup[t].level eq 1}}一级目录{{elseif $allgroup[t].level eq 2}}二级目录{{else}}运维组{{/if}}</a></td>
				{{/if}}
				<td>{{$allgroup[t].children_ct}}</td>
				<td>{{$allgroup[t].description}}</td>
				<td>
				{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 101}}
				<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_pro&action=devgroup_edit&id={{$allgroup[t].id}}" >编辑</a> | 
				<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=devgroup_edit&id={{$allgroup[t].id}}&from=usergroup';}">删除</a> 
				{{/if}}
				</td> 
			</tr>{{if $allgroup[t].children_ct gt 0}}
				{{section name=tt loop=$allgroup[t].children}}
				<TBODY name="ldap_{{$smarty.section.t.index}}" {{if $smarty.section.tt.index eq 0 }} id="ldap_{{$smarty.section.t.index}}0"{{/if}} aid="a_ldap_{{$smarty.section.t.index}}_{{$smarty.section.tt.index}}" style="DISPLAY: none">
				<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					<TD class=td25></TD>
					<td onClick="toggle_group('ldap_{{$smarty.section.t.index}}_{{$smarty.section.tt.index}}', $('a_ldap_{{$smarty.section.t.index}}_{{$smarty.section.tt.index}}'), true)"> {{if $allgroup[t].children_ct gt 0}}<span class="td25"><A id=a_ldap_{{$smarty.section.t.index}}_{{$smarty.section.tt.index}} href="javascript:;">[+]</A></span>{{/if}}<a href='admin.php?controller=admin_member&gid={{$allgroup[t].children[tt].id}}'>{{$allgroup[t].children[tt].groupname}}</a></td>
					{{if $_config.LDAP}}
					<td> <a href='admin.php?controller=admin_member&action=usergroup&level={{$allgroup[t].children[tt].level}}'>{{if $allgroup[t].children[tt].level eq 1}}一级目录{{elseif $allgroup[t].children[tt].level eq 2}}二级目录{{else}}运维组{{/if}}</a></td>
					{{/if}}
					<td>{{$allgroup[t].children[tt].children_ct}}</td>
					<td>{{$allgroup[t].children[tt].description}}</td>
					<td>
					{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 101}}
					<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_pro&action=devgroup_edit&id={{$allgroup[t].children[tt].id}}&from=usergroup" >编辑</a> | 
					<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=dev_group_del&id={{$allgroup[t].children[tt].id}}&from=usergroup';}">删除</a> 
					{{/if}}
					</td> 
				</tr>	
				</TBODY>
					<TBODY name="ldap_{{$smarty.section.t.index}}_{{$smarty.section.tt.index}}" id="ldap_{{$smarty.section.t.index}}_{{$smarty.section.tt.index}}" style="DISPLAY: none">
					{{section name=ttt loop=$allgroup[t].children[tt].children}}
					<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td class=td25 width="20">&nbsp;</TD>
						<td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;<a href='admin.php?controller=admin_member&action=index&gid={{$allgroup[t].children[tt].children[ttt].id}}'>{{$allgroup[t].children[tt].children[ttt].groupname}}</a></td>
						{{if $_config.LDAP}}
						<td width="20%"> <a href='admin.php?controller=admin_member&action=usergroup&level={{$allgroup[t].children[tt].children[ttt].level}}'>{{if $allgroup[t].children[tt].children[ttt].level eq 1}}一级目录{{elseif $allgroup[t].children[tt].children[ttt].level eq 2}}二级目录{{else}}运维组{{/if}}</a></td>
						{{/if}}
						<td width="5%">{{$allgroup[t].children[tt].children[ttt].userct}}</td>
						<td width="20%">{{$allgroup[t].children[tt].children[ttt].description}}</td>
						<td>
						{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 101}}
						<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_member&action=devgroup_edit&id={{$allgroup[t].children[tt].children[ttt].id}}&from=usergroup" >编辑</a> | 
						<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_member&action=delete_usergroup&id={{$allgroup[t].children[tt].children[ttt].id}}&from=usergroup';}">删除</a> 
						{{/if}}
						</td> 
					</tr>
					{{/section}}
					</TBODY>
				{{/section}}
				{{/if}}
			{{/section}}
			{{section name=nt loop=$noldapgroup}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td class=td25 width="20">&nbsp;</TD>
				<td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;<a href='admin.php?controller=admin_member&action=index&gid={{$noldapgroup[nt].id}}'>{{$noldapgroup[nt].groupname}}</a></td>
				{{if $_config.LDAP}}
				<td width="20%"> <a href='admin.php?controller=admin_member&action=usergroup&level={{$noldapgroup[nt].level}}'>{{if $noldapgroup[nt].level eq 1}}一级目录{{elseif $noldapgroup[t].children[tt].children[ttt].level eq 2}}二级目录{{else}}运维组{{/if}}</a></td>
				{{/if}}
				<td width="5%">{{$noldapgroup[nt].userct}}</td>
				<td width="20%">{{$noldapgroup[nt].description}}</td>
				<td>
				{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 101}}
				<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_member&action=usergroup_edit&id={{$noldapgroup[nt].id}}" >编辑</a> | 
				<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_member&action=delete_usergroup&id={{$noldapgroup[nt].id}}';}">删除</a>
				{{/if}}
				</td> 
			</tr>
			{{/section}}

			{{else}}
			{{section name=t loop=$allgroup}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td> </td>
				<td> {{$allgroup[t].groupname}}</td>
				<td> {{$allgroup[t].userct}}</td>
				<td> {{$allgroup[t].description}}</td>
				<td style="TEXT-ALIGN: left;"><img src='{{$template_root}}/images/ico9.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_member&action=groupuser&gid={{$allgroup[t].id}}" >{{$language.User}}</a>
				<!--| <img src='{{$template_root}}/images/list_ico18.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_member&action=protect_group&gid={{$allgroup[t].id}}&type=group" >{{$language.devicebind}}</a>
				| <img src='{{$template_root}}/images/ico3.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_member&action=protect_group_devgrp&gid={{$allgroup[t].id}}" >{{$language.Devicegroupbind}}</a>
				| <img src='{{$template_root}}/images/database.png' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_member&action=protect_group_resgrp&gid={{$allgroup[t].id}}" >资源组绑定</a>-->
				| <img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_member&action=usergroup_edit&id={{$allgroup[t].id}}" >编辑</a>
				| <img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('{{$language.Delete_sure_}}？')) {return false;} else { location.href='admin.php?controller=admin_member&action=delete_usergroup&id={{$allgroup[t].id}}';}">{{$language.Delete}}</a>
				</td> 
			</tr>
			{{/section}}
			{{/if}}
			<tr>
	           <td align="left">
		           <input type="button" onclick="document.location='admin.php?controller=admin_member&action=usergroup_edit&ldapid={{$smarty.get.ldapid}}'"  value="添加" class="an_02">
		   		</td>
		   	
				<td align="right" colspan="6">
		   			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_member&action=usergroup_index&page='+this.value;">{{$language.page}}
		   </td>
               	</tr>
		</TBODY>
              </TABLE>	</td>
  </tr>
</table>

<script language="javascript">
window.parent.menu.document.getElementById('_tree').style.display='';
window.parent.menu.document.getElementById('mtree').style.display='none';
if(window.parent.menu.document.getElementById('mldaptree')!=undefined)
window.parent.menu.document.getElementById('mldaptree').style.display='';
window.parent.menu.document.getElementById('devtree').style.display='none';
if(window.parent.menu.document.getElementById('ldaptree')!=undefined)
window.parent.menu.document.getElementById('ldaptree').style.display='none';
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>

