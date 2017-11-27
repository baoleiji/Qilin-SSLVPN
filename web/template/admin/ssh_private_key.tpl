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
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    {{if $smarty.session.ADMIN_LEVEL ne 10}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">设备目录</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=resource_group">系统用户组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=ssh_private_key">SSH私钥上传</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=ssh_public_key">SSH公钥上传</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	
</ul>
</div></td></tr>
	
  
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                <TBODY>
				  
                  <TR>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=ssh_private_key&orderby1=device_ip&orderby2={{$orderby2}}" >IP</a></th>
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=ssh_private_key&orderby1=hostname&orderby2={{$orderby2}}" >主机名</a></th>
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=ssh_private_key&orderby1=username&orderby2={{$orderby2}}" >用户名</a></th>
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=ssh_private_key&orderby1=login_method&orderby2={{$orderby2}}" >协议</a></th>
					<th class="list_bg" ><a href="admin.php?controller=admin_pro&action=ssh_private_key&orderby1=description&orderby2={{$orderby2}}" >当前私钥</a></th>
					<th class="list_bg" >操作</th>
                  </TR>

            </tr>
			{{section name=t loop=$sshdevices}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td> <a href='admin.php?controller=admin_pro&action=ssh_private_key&device_ip={{$sshdevices[t].device_ip}}'>{{$sshdevices[t].device_ip}}</a></td>
				<td> <a href='admin.php?controller=admin_pro&action=ssh_private_key&hostname={{$sshdevices[t].hostname}}'>{{$sshdevices[t].hostname}}</a></td>
				<td> <a href='admin.php?controller=admin_pro&action=ssh_private_key&username={{$sshdevices[t].username}}'>{{$sshdevices[t].username}}</a></td>	
				<td> <a href='admin.php?controller=admin_pro&action=ssh_private_key&login_method={{$sshdevices[t].login_method}}'>{{if $sshdevices[t].login_method eq 3}}SSH{{else}}SFTP{{/if}}</a></td>	
				<td> {{$sshdevices[t].private_key_file}}</td>
				<td> <a href='admin.php?controller=admin_pro&action=ssh_private_key&gid={{$sshdevices[t].id}}'><input type="button" value="选择私钥" onclick="window.open ('admin.php?controller=admin_pro&action=ssh_private_key_upload&lid={{$sshdevices[t].id}}', 'newwindow', 'height=130, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" ></td>
			</tr>
			{{/section}}
			<tr>
	           <td  colspan="1" align="left">
				
		   </td>
               
	           <td  colspan="5" align="right">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=ssh_private_key&page='+this.value;">页
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


