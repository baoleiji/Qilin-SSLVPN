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
	document.f1.action = "admin.php?controller=admin_assets";
	document.f1.action += "&number="+document.f1.number.value;
	document.f1.action += "&type="+document.f1.type.value;
	document.f1.action += "&specification="+document.f1.specification.value;
	document.f1.action += "&department="+document.f1.department.value;
	return true;
}
</script>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
{{if $smarty.session.ADMIN_LEVEL eq 10}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{else}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">设备目录</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=resource_group">系统用户组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autotemplate">巡检管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
</ul>
</div></td></tr>
	

  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

                <TBODY>
				 <TR><form name ='f1' action='admin.php?controller=admin_assets' method=post>
                    <TD colspan = "1"  class="">
					
					</td><td colspan="9" class="">
					卡片编号<input type="text" class="wbk" name="number">
					固定资产名称<input type="text" class="wbk" name="type">
					规格型号<input type="text" class="wbk" name="specification">
					部门名称<input type="text" class="wbk" name="department">
					&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
					</TD></form>
                  </TR></table></td></tr>
				  <tr><td>
				  <table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                  <TR>
				   <th class="list_bg" ><a href = "admin.php?controller=admin_assets&orderby1=device_ip&orderby2={{$orderby2}}">设备IP</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_assets&orderby1=number&orderby2={{$orderby2}}">卡片编号</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_assets&orderby1=type&orderby2={{$orderby2}}">固定资产名称</a></th>
					
                    <th class="list_bg" ><a href = "admin.php?controller=admin_assets&orderby1=specification&orderby2={{$orderby2}}">规格型号</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_assets&orderby1=department&orderby2={{$orderby2}}">部门名称</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_assets&orderby1=location&orderby2={{$orderby2}}">存放地点</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_assets&orderby1=start&orderby2={{$orderby2}}">开始使用日期</a></th>
					<th class="list_bg" ><a href = "admin.php?controller=admin_assets&orderby1=usedtime&orderby2={{$orderby2}}">使用年限</a></th>
					<th class="list_bg" ><a href = "admin.php?controller=admin_assets&orderby1=status&orderby2={{$orderby2}}">使用状况</a></th>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			{{section name=t loop=$alldev}}
			<tr {{if $alldev[t].ct > 0 }}bgcolor="red" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td>{{$alldev[t].device_ip}}</td>
				<td>{{$alldev[t].number}}</td>
				<td>{{$alldev[t].type}}</td>				
				<td>{{$alldev[t].specification}}</td>
				<td>{{$alldev[t].department}}</td>
				<td>{{$alldev[t].location}}</td>
				<td>{{$alldev[t].start}}</td>
				<td>{{$alldev[t].usedtime}}</td>
				<td>{{$alldev[t].status}}</td>
				<td>
				
					{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 3}}<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_assets&action=edit&id={{$alldev[t].id}}&serverip={{$alldev[t].device_ip}}'>修改</a>
					{{/if}}
					{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 10 }}
					
					| <img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_assets&action=del&id={{$alldev[t].id}}';}">删除</a>
					{{/if}}
				</td> 
			</tr>
			{{/section}}
			
                <tr>

		    <td  colspan="10" align="right">
		   			&nbsp&nbsp;&nbsp;共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_assets&page='+this.value;">页&nbsp;&nbsp;&nbsp;{{if $smarty.session.ADMIN_LEVEL eq 3}}  导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>{{/if}}
		   </td>
                </tr>
             
                <tr>
	          
		</tr>
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



