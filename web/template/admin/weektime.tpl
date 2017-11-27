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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
{{if $smarty.session.ADMIN_LEVEL ne 3 and $smarty.session.ADMIN_LEVEL ne 21 and $smarty.session.ADMIN_LEVEL ne 101}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=default_policy">默认策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sourceip">来源IP组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=weektime">周组策略</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list">命令权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
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
</ul>
</div></td></tr>
	
 
  <tr>
	<td class="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
                <TBODY>
				   {{*<TR>
<form name="f1" method=post action="admin.php?controller=admin_pro&action=dev_group_save">
服务器组名称称<input type = text name="groupname">
<input type="submit" class="btn2" value="增加服务器组" class="an_02">
</form>
                  </TR>*}}
                  <TR>
                    <th class="list_bg" ><a href="admin.php?controller=admin_member&action=weektime&orderby1=policyname&orderby2={{$orderby2}}" >策略名</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_member&action=weektime&orderby1=start_time1&orderby2={{$orderby2}}" >星期一</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_member&action=weektime&orderby1=start_time2&orderby2={{$orderby2}}" >星期二</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_member&action=weektime&orderby1=start_time3&orderby2={{$orderby2}}" >星期三</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_member&action=weektime&orderby1=start_time4&orderby2={{$orderby2}}" >星期四</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_member&action=weektime&orderby1=start_time5&orderby2={{$orderby2}}" >星期五</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_member&action=weektime&orderby1=start_time6&orderby2={{$orderby2}}" >星期六</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_member&action=weektime&orderby1=start_time7&orderby2={{$orderby2}}" >星期日</a></TD>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			{{section name=t loop=$weektime}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td >{{$weektime[t].policyname}}</td>
				<td >{{$weektime[t].start_time1}}-{{$weektime[t].end_time1}}</td>
				<td >{{$weektime[t].start_time2}}-{{$weektime[t].end_time2}}</td>
				<td >{{$weektime[t].start_time3}}-{{$weektime[t].end_time3}}</td>
				<td >{{$weektime[t].start_time4}}-{{$weektime[t].end_time4}}</td>
				<td >{{$weektime[t].start_time5}}-{{$weektime[t].end_time5}}</td>
				<td >{{$weektime[t].start_time6}}-{{$weektime[t].end_time6}}</td>
				<td >{{$weektime[t].start_time7}}-{{$weektime[t].end_time7}}</td>		
				<td >
				<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="admin.php?controller=admin_member&action=weektime_edit&sid={{$weektime[t]['sid']}}" >修改</a>
				| <img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_member&action=delete_weektime&sid={{$weektime[t]['sid']}}';}">删除</a>
				</td> 
			</tr>
			{{/section}}
	           <tr>
						<td colspan="2" align="left">
							<input type="button"  value=" 增加 " onclick="javascript:document.location='admin.php?controller=admin_member&action=weektime_edit';" class="an_02">
						</td>
						<td  colspan="7" align="right">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_group_index&page='+this.value;">页
		   </td>
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

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


