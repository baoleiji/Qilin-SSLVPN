<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
{{if $smarty.session.ADMIN_LEVEL eq 0 || $smarty.session.ADMIN_LEVEL eq 10}}
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
{{if $smarty.session.ADMIN_LEVEL eq 10}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{else}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">设备列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class={{if $smarty.get.logintype ne 'ssh' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'ssh' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=ssh">SSH设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'ssh' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'telnet' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'telnet' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=telnet">TELNET设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'telnet' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'rdp' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'rdp' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=rdp">RDP设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'rdp' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'vnc' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'vnc' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=vnc&gid={{$gid}}">VNC设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'vnc' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'ftp' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'ftp' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=ftp">FTP设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'ftp' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'x11' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'x11' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=x11">X11设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'x11' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'apppub' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'apppub' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=apppub">应用发布设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'apppub' }}3{{/if}}.jpg" align="absmiddle"/></li>
{{/if}}

</ul>
</div></td></tr>
{{/if}}

	

  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                <TBODY>
				   {{*<TR>
<form name="f1" method=post action="admin.php?controller=admin_pro&action=dev_group_save">
服务器组名称称<input type = text name="groupname">
<input type="submit"  value="增加服务器组" class="an_02">
</form>
                  </TR>*}}
                  <TR>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=userdev_group&orderby1=GroupName&orderby2={{$orderby2}}" >服务器组名称</a></TD>
					 <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=userdev_group&orderby1=GroupName&orderby2=sct" >服务器台数</a></TD>
					  <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=userdev_group&orderby1=GroupName&orderby2=description" >描述</a></TD>
                  </TR>

            </tr>
			{{section name=t loop=$alldev}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
 <td> <a href='admin.php?controller=admin_index&action=main&gid={{$alldev[t].id}}'>{{$alldev[t].groupname}}</a></td>
  <td>{{$alldev[t].sct}}</td>
   <td>{{$alldev[t].description}}</td>
					
			</tr>
			{{/section}}
	          
                <tr>
	           <td  colspan="5" align="right">
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


