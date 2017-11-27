<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
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
<script>
function searchit(){
	document.f1.action = "admin.php?controller=admin_backup&action=backup_log";
	document.f1.action += "&ip="+document.f1.ip.value;
	document.f1.action += "&hostname="+encodeURIComponent(document.f1.hostname.value);
	return true;
}
</script>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>{{*
{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2}}	
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=day_count">天报</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=week_count">周报</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=month_count">月报</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}*}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_log">同步日志</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=system_alert">系统告警</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=backup_session">双机同步</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=maillog">系统邮件</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=aduserlog">账号同步</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>

  <tr>
	<td class="" colspan = "7"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

                <TBODY>
				 <TR>
                    <TD >
					<form name ='f1' action='admin.php?controller=admin_backup&action=backup_log' method=post>
					IP<input type="text" class="wbk" name="ip">
					主机名<input type="text" class="wbk" name="hostname">
					&nbsp;&nbsp;<input  type="submit" value="高级搜索" onclick="return searchit();" class="bnnew2">
					</form>
					</TD>
                  </TR>
				  </table></td></tr>
                  <TR><td>
				  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
				  <tr>
				  <th class="list_bg" >&nbsp;</th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_backup&action=backup_log&orderby1=ip&orderby2={{$orderby2}}">同步地址</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_backup&action=backup_log&orderby1=starttime&orderby2={{$orderby2}}">启动时间</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_backup&action=backup_log&orderby1=endtime&orderby2={{$orderby2}}">结束时间</a></th>	
                    <th class="list_bg" ><a href = "admin.php?controller=admin_backup&action=backup_log&orderby1=dblog&orderby2={{$orderby2}}">数据同步</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_backup&action=backup_log&orderby1=filelog&orderby2={{$orderby2}}">文件同步</a></th>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			<form name="member_list" action="admin.php?controller=admin_backup&action=backup_log_del" method="post">
			{{section name=t loop=$alldev}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td><input type="checkbox" name="chk_member[]" value="{{$alldev[t].id}}"></td>
				<td>{{$alldev[t].ip}}</td>
				<td>{{$alldev[t].starttime}}</td>
				<td>{{$alldev[t].endtime}}</td>
				<td>{{if $alldev[t].dblog eq 1}}成功{{elseif $alldev[t].dblog eq 2}}失败{{else}}未配置{{/if}}</td>
				<td>{{if $alldev[t].filelog eq 1}}成功{{elseif $alldev[t].filelog eq 2}}失败{{else}}未配置{{/if}}</td>
				<td>				<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_backup&action=backup_log_del&id={{$alldev[t].id}}';}">删除</a>
				</td> 
			</tr>
			{{/section}}
			
                <tr>
	           <td  colspan="3" align="left">
				<input name="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除" onClick="my_confirm('确定删除所选?');if(chk_form()) document.member_list.action='admin.php?controller=admin_backup&action=backup_log_del'; else return false;" class="an_02">
		   </td>

		    <td  colspan="4" align="right">
		   			&nbsp&nbsp;&nbsp;共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_backup&action=backup_setting&page='+this.value;">页&nbsp;&nbsp;&nbsp;{{if $smarty.session.ADMIN_LEVEL eq 3}}  导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>{{/if}}
		   </td>
                </tr>
            </form>
		</TBODY>
              </TABLE>
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



