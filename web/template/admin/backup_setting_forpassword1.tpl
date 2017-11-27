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
	document.f1.action = "admin.php?controller=admin_backup&action=backup_setting";
	document.f1.action += "&ip="+document.f1.ip.value;
	document.f1.action += "&session_flag="+document.f1.session_flag.value;
	return true;
}
</script>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>

  <tr>
	<td class="" colspan = "7"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

                <TBODY>
				 <TR>
                    <TD >
					<form name ='f1' action='admin.php?controller=admin_backup&action=backup_setting' method=post>
					类型<select  class="wbk"  name="session_flag">
						<option value="" >请选择</option>
						<option value="0" {{if $session_flag eq '0'}}selected{{/if}}>审计日志</option>
						<option value="100" {{if $session_flag eq '100'}}selected{{/if}}>资产权限</option>
						<option value="1" {{if $session_flag eq '1'}}selected{{/if}}>主从数据</option>
						<option value="2" {{if $session_flag eq '2'}}selected{{/if}}>密码文件</option>
					</select>&nbsp;&nbsp;
					IP<input type="text" class="wbk" name="ip" value="{{$ip}}">
					&nbsp;&nbsp;<input  type="submit" value="高级搜索" onclick="return searchit();" class="bnnew2">
					</form>
					</TD>
                  </TR>
				  </table></td></tr>
                  <TR><td>
				  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
				  <tr>
				  <th class="list_bg" >&nbsp;</th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_backup&action=backup_setting_forpassword&orderby1=desc&orderby2={{$orderby2}}">描述</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_backup&action=backup_setting_forpassword&orderby1=session_flag&orderby2={{$orderby2}}">同步类型</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_backup&action=backup_setting_forpassword&orderby1=ip&orderby2={{$orderby2}}">同步地址</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_backup&action=backup_setting_forpassword&orderby1=port&orderby2={{$orderby2}}">同步端口</a></th>
                    <th class="list_bg" ><a href = "admin.php?controller=admin_backup&action=backup_setting_forpassword&orderby1=protocol&orderby2={{$orderby2}}">同步协议</a></th>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			<form name="member_list" action="admin.php?controller=admin_backup&action=backup_setting_forpassword_del" method="post">
			{{section name=t loop=$alldev}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td><input type="checkbox" name="chk_member[]" value="{{$alldev[t].seq}}"></td>
				<td>{{$alldev[t].desc}}</td>
				<td>{{if $alldev[t].session_flag eq '100'}}资产权限{{elseif $alldev[t].session_flag eq '1'}}主从数据{{elseif $alldev[t].session_flag eq '2'}}密码文件{{else}}审计日志{{/if}} </td>
				<td>{{$alldev[t].ip}}</td>
				<td><span  title="{{$alldev[t].port}}" >{{$alldev[t].port}}</span></td>
				<td>{{$alldev[t].protocol}}</td>
				<td>				
					<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_backup&action=backup_setting_forpassword_edit&id={{$alldev[t].seq}}'>修改</a>
					 | <img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_backup&action=backup_setting_forpassword_del&id={{$alldev[t].seq}}';}">删除</a>
				</td> 
			</tr>
			{{/section}}
			
                <tr>
	           <td  colspan="3" align="left">
				<input name="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="删除" onClick="my_confirm('确定删除所选?');if(chk_form()) document.member_list.action='admin.php?controller=admin_member&action=delete_all'; else return false;" class="an_02">&nbsp;&nbsp;<input type="button"  value="{{$language.Add}}" onClick="javascript:document.location='admin.php?controller=admin_backup&action=backup_setting_forpassword_edit';" class="an_02">&nbsp;&nbsp;
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



