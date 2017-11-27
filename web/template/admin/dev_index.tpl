<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/global.functions.js"></script>
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
<script>
function searchit(){
	document.f1.action = "admin.php?controller=admin_pro&action=dev_index";
	document.f1.action += "&ip="+document.f1.ip.value;
	document.f1.action += "&hostname="+encodeURIComponent(document.f1.hostname.value);
	return true;
}

function changeStyle(obj,c)
{
	if(c!='o'){
		obj.style.backgroundColor=c;
	}else{
		obj.style.backgroundColor="#FFCC80";
	}
}
</script>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
	<td class="" colspan = "7"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

                <TBODY>
				 <TR>
                    <TD >
					<form name ='f1' action='admin.php?controller=admin_pro&action=dev_index' method=post>
					IP<input type="text" class="wbk" name="ip">
					主机名<input type="text" class="wbk" name="hostname">
					&nbsp;&nbsp;<input  type="submit" value=" 搜索 " onclick="return searchit();" class="bnnew2">&nbsp;&nbsp;显示空目录<input type="checkbox" id="showemptydir" name="showemptydir" onclick="window.parent.menu.window.showNodeCount0(this.checked)"  />&nbsp;&nbsp;&nbsp;&nbsp;目录截取<input type="checkbox" name="showemptydir" onclick="window.parent.menu.window.showLongTitle(this.checked)" checked />

					</form>
					</TD>
                  </TR>
				  </table></td></tr>
                  <TR><td>
				  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
				  <form name="member_list" action="admin.php?controller=admin_pro&action=dev_del" method="post">
				  <tr>
				  <th class="list_bg"  width="1%">选</th>
                    <th class="list_bg"  width="15%"><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=device_ip&orderby2={{$orderby2}}&gid={{$gid}}">服务器地址</a></th>
                    <th class="list_bg" width="20%"><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=hostname&orderby2={{$orderby2}}&gid={{$gid}}">主机名</a></th>
					
                    <th class="list_bg"  width="10%"><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=device_type&orderby2={{$orderby2}}&gid={{$gid}}">系统</a></th>
                    <th class="list_bg" width="20%"><a href = "admin.php?controller=admin_pro&action=dev_index&orderby1=groupid&orderby2={{$orderby2}}&gid={{$gid}}">设备组</a></th>
					{{if $smarty.session.CACTI_CONFIG_ON and $smarty.session.LICENSE_KEY_NETMANAGER}}
					<th class="list_bg" width="10%">状态</th>
					{{/if}}
					<th class="list_bg"  width="">操作</TD>
                  </TR>
            </tr>
			{{section name=t loop=$alldev}}
			<tr  {{if $alldev[t].ct > 0 or ($alldev[t].asset_warrantdate ne '0000-00-00 00:00:00' && $alldev[t].warrantdays<0) }}bgcolor="red" {{elseif  ($alldev[t].asset_warrantdate ne '0000-00-00 00:00:00' && $alldev[t].warrantdays<30)}}bgcolor="yellow"{{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}   onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'{{if $alldev[t].ct > 0 or ($alldev[t].asset_warrantdate ne '0000-00-00 00:00:00' && $alldev[t].warrantdays<0) }}red{{elseif  ($alldev[t].asset_warrantdate ne '0000-00-00 00:00:00' && $alldev[t].warrantdays<30)}}yellow{{elseif $smarty.section.t.index % 2 == 0}}f7f7f7{{/if}}');">
				<td><input type="checkbox" name="chk_member[]" value="{{$alldev[t].id}}"></td>
				<td>{{$alldev[t].device_ip}}</td>
				<td><span  title="{{$alldev[t].hostname}}" >{{$alldev[t].hostname}}</span></td>
				
				<td>{{$alldev[t].device_type}}</td>
				<td>{{$alldev[t].groupname}}</td>
				{{if $smarty.session.CACTI_CONFIG_ON and $smarty.session.LICENSE_KEY_NETMANAGER}}
				<td align=center><img src='{{$template_root}}/images/{{if !$alldev[t].monitor}}Gray.gif{{elseif $alldev[t].status eq 1}}Green.gif{{elseif $alldev[t].status eq 2}}GreenYellow.gif{{else}}Red.gif{{/if}}' style="cursor:hand;" onclick="window.open ('admin.php?controller=admin_detail&ip={{$alldev[t].device_ip}}{{if $alldev[t].device_type|lower eq 'cisco' }}&action=ciscoindex{{/if}}', 'newwindow', 'height=' + screen.height + ',width=' + screen.width+'top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" ></td>
				{{/if}}
				<td>
				
					{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 4}}<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=dev_edit&gid={{$gid}}&id={{$alldev[t].id}}'>修改</a>
					
					| <img src='{{$template_root}}/images/left_dot1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=devpass_index&ip={{$alldev[t].device_ip}}&serverid={{$alldev[t].id}}&gid={{$gid}}'>用户({{if $alldev[t].userct}}{{$alldev[t].userct}}{{else}}0{{/if}})</a>
										
					{{/if}}
					{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 21  or $smarty.session.ADMIN_LEVEL eq 101 or $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 4 }}
					
					| <img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=dev_del&id={{$alldev[t].id}}&gid={{$gid}}';}">删除</a>
					{{/if}}
					{{*if $gid}}
					| <img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=dev_delfromgroup&id={{$alldev[t].id}}&gid={{$gid}}';}">从当前组删除</a>
					{{/if*}}
				</td> 
			</tr>
			{{/section}}
			
                <tr>

	           <td  colspan="4" align="left">
			  <input name="select_all" id="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=document.member_list.elements[i];if(e.name=='chk_member[]')e.checked=document.member_list.select_all.checked;}" value="checkbox">&nbsp;&nbsp; {{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 21  or $smarty.session.ADMIN_LEVEL eq 4}}<input type="button"  value="批量添加" onClick="location.href='admin.php?controller=admin_pro&action=devbatchadd&gid={{$gid}}'" class="an_02">
			   &nbsp;&nbsp;<input type="submit"  value="批量删除" onClick="return my_confirm('删除所选');" class="an_02">
			   &nbsp;&nbsp;<input type="button"  value="导入" onClick="location.href='admin.php?controller=admin_pro&action=devimport&gid={{$gid}}'" class="an_02">		
				{{/if}}
				<input  type="button"  value="导出" onClick="export1()" class="an_02">			
		   </td>

		    <td  colspan="3" align="right">
		   			&nbsp&nbsp;&nbsp;共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_index&page='+this.value;">页&nbsp;&nbsp;&nbsp;
		   </td>
                </tr>
            </form>
		</TBODY>
              </TABLE>
	</td>
  </tr>
</table>

<script language="javascript">

window.parent.menu.window.showNodeCount0(false);
window.parent.menu.window.showLongTitle(true);

function export1(){
	var t = new Date().getTime();
	document.getElementById('hide').src='{{$curr_url}}&derive=3&'+t;
}
function my_confirm(str){
	if(!confirm(str + "？"))
	{
		return false;
	}
	return true;
}
window.parent.menu.document.getElementById('_tree').style.display='';
window.parent.menu.document.getElementById('devtree').style.display='';
window.parent.menu.document.getElementById('mtree').style.display='none';
window.parent.menu.cururl='devtree';
</script>
</body>
<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



