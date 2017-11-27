<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>
<script>
function searchit(){
	document.f1.action = "admin.php?controller=admin_pro&action=dev_group";
	document.f1.action += "&groupname="+document.f1.groupname.value;
	return true;
}
var selected = new Array();
function toggle_group(oid, obj, gid,level, isChild) {
	obj = document.getElementById(obj);
	if(selected[gid]!=null||selected[gid]!=undefined) {
		toggle_group_callback(oid, obj, isChild);
		return;
	}
	var url ="admin.php?controller=admin_grouptree&action=get_devgroup&groupid="+escape(gid)+"&groupindex="+oid.substring(5)+"&level="+level;
	$.get(url, {"1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		selected[gid]=1;
		$(obj.parentNode.parentNode.parentNode.parentNode).after(data);
		toggle_group_callback(oid, obj, isChild);
	});
}

function toggle_group_callback(oid, obj, isChild) {
	obj = obj ? obj : document.getElementById('a_'+oid);
	if(!conf) {
		var conf = {'show':'[-]','hide':'[+]'};
	}
	
	var obody = document.getElementById(oid+'_0');
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
						if(tbodys[i].attributes.aid!=undefined&&document.getElementById(tbodys[i].attributes.aid.nodeValue)!=undefined)
						document.getElementById(tbodys[i].attributes.aid.nodeValue).innerHTML = conf.hide;
					}else if(tbodys[i].id.length>oid.length&&tbodys[i].id.substring(0, oid.length)==oid){
						if(tbodys[i].attributes.aid!=undefined&&document.getElementById(tbodys[i].attributes.aid.nodeValue)!=undefined)
						document.getElementById(tbodys[i].attributes.aid.nodeValue).innerHTML = conf.hide;
						tbodys[i].style.display = 'none';
						var as = document.getElementsByTagName("a");
						for(var j=0; j<as.length; j++){
							if(as[j].id.substring(0, 2)=='a_')
							if(as[j].id.substring(0, oid.length+2)=='a_'+oid){
								as[j].innerHTML = conf.hide;
							}
						}
					}
				}
			}
		}
		obj.innerHTML = conf.hide;
	}
	window.parent.reinitIframe();
}
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	
   <tr>
	<td class="" colspan = "4"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

                <TBODY>
				 <TR>
                    <TD >
					<form name ='f1' action='admin.php?controller=admin_pro&action=dev_index' method=post>
					组名: <input type="text" class="wbk" name="groupname" value="{{$groupname}}">
					&nbsp;&nbsp;<input  type="submit" value="高级搜索" onclick="return searchit();" class="bnnew2">
					</form>
					</TD>
                  </TR>
				  </table></td></tr>
  <tr>
	<td class="">	
	<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                  <TR>
					<th class="list_bg" width="3%"></TD>
                    <th class="list_bg" width="35%" ><a href="admin.php?controller=admin_pro&action=dev_group&orderby1=groupname&orderby2={{$orderby2}}&ldapid={{$ldapid}}" >资源组名称</a></TD>					
					<th class="list_bg" width="3%">ID</TD>
					<th class="list_bg" width="8%" ><a href = "admin.php?controller=admin_pro&action=dev_group&orderby1=attribute&orderby2={{$orderby2}}&ldapid={{$ldapid}}">属性</a></th>
					<th class="list_bg" width="5%" ><a href="admin.php?controller=admin_pro&action=dev_group&orderby1=count&orderby2={{$orderby2}}&ldapid={{$ldapid}}" >服务器数</a></TD>
					<th class="list_bg" width="5%" ><a href="admin.php?controller=admin_pro&action=dev_group&orderby1=mcount&orderby2={{$orderby2}}&ldapid={{$ldapid}}" >用户数</a></TD>
					<th class="list_bg" width="20%" ><a href="admin.php?controller=admin_pro&action=dev_group&orderby1=description&orderby2={{$orderby2}}&ldapid={{$ldapid}}" >描述</a></TD>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			{{if $_config.LDAP}}
			
			{{section name=t loop=$alldev}}
			<tbody >
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<TD  onClick="toggle_group('ldap_{{$smarty.section.t.index}}', 'a_ldap_{{$smarty.section.t.index}}',{{$alldev[t].id}},1)" class=td25 width="30" align="center">{{if $alldev[t].childrenct gt 0}}<span class="td25"><A id=a_ldap_{{$smarty.section.t.index}} href="javascript:;">[+]</A></span>{{/if}}</TD>
				<td><a href="admin.php?controller=admin_pro&action=dev_index&gid={{$alldev[t].id}}">{{$alldev[t].groupname}}</a></td>
				<td><a href="admin.php?controller=admin_pro&action=dev_index&gid={{$alldev[t].id}}">{{$alldev[t].id}}</a></td>
				<td>{{if !$alldev[t].attribute }}全部{{elseif $alldev[t].attribute eq 1}}用户{{else}}主机{{/if}}</td>
				<td><a href='admin.php?controller=admin_pro&action=dev_index&gid={{$alldev[t].id}}&from=dir'>{{$alldev[t].count}}</a></td>
				<td><a href='admin.php?controller=admin_member&ldapid={{$alldev[t].id}}&from=dir'>{{$alldev[t].mcount}}</a></td>
				<td>{{$alldev[t].description}}</td>
				<td>
				{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 101}}
				<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_pro&action=devgroup_edit&id={{$alldev[t].id}}" >编辑</a> | 
				<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=dev_group_del&id={{$alldev[t].id}}';}">删除</a>
				{{/if}}
				</td> 
			</tr>{{if $alldev[t].childrenct gt 0}}
				{{$alldev[t].groupstr}}
				{{/if}}</tbody>
			{{/section}}
			{{else}}
			{{section name=nt loop=$alldev}}
					<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td class=td25 width="20">&nbsp;</TD>
						<td width="20%">{{$alldev[nt].groupname}}</a></td>
						{{if $_config.LDAP}}
						<td width="20%"> <a href='admin.php?controller=admin_pro&action=dev_group&level={{$alldev[nt].level}}'>{{if $alldev[nt].level eq 1}}一级目录{{elseif $alldev[nt].level eq 2}}二级目录{{else}}资源组{{/if}}</a></td>
						{{/if}}
						<td>{{if !$alldev[nt].attribute }}全部{{elseif $alldev[nt].attribute eq 1}}用户{{else}}主机{{/if}}</td>
						<td width="5%"><a href='admin.php?controller=admin_pro&action=dev_index&gid={{$alldev[nt].id}}&from=dir'>{{$alldev[nt].count}}</a></td>
						<td width="5%"><a href='admin.php?controller=admin_member&gid={{$alldev[nt].id}}&from=dir'>{{$alldev[nt].mcount}}</a></td>
						<td width="20%">{{$alldev[nt].description}}</td>
						<td>
						{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 101}}
						<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_pro&action=devgroup_edit&id={{$alldev[nt].id}}" >编辑</a> | 
						<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=dev_group_del&id={{$alldev[nt].id}}';}">删除</a> {{if $alldev[nt].level>0 and $_config.LDAP}}| 
						<img src='{{$template_root}}/images/file.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_pro&action=dev_group&ldapid={{$alldev[nt].id}}" >查看子目录</a>{{/if}}
						{{/if}}
						</td> 
					</tr>
					{{/section}}
			{{/if}}
			
			<tr>
	           <td  colspan="3" align="left">
				{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 21 or $smarty.session.ADMIN_LEVEL eq 101}}
				<input size="30" type="button"  value="添加新节点"  onClick="location.href='admin.php?controller=admin_pro&action=devgroup_edit&ldapid={{$ldapid}}'" class="an_06">&nbsp;&nbsp;<input type="button"  value="批量添加" onClick="location.href='admin.php?controller=admin_pro&action=groupbatchadd&gid={{$gid}}'" class="an_06">
				{{/if}}
		   </td>
               
	           <td  colspan="5" align="right">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_group&page='+this.value;">页
		   </td>
		</tr>
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
window.parent.menu.document.getElementById('_tree').style.display='none';
window.parent.menu.document.getElementById('devtree').style.display='none';
window.parent.menu.document.getElementById('mtree').style.display='none';
window.parent.menu.cururl='ldaptree';
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


