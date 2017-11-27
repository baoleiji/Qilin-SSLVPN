<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
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
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=serverstatus">服务状态</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=latest">系统状态</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
   <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup">配置备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting">数据同步</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=upgrade">软件升级</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=cronjob">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=changelogo">图标上传</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=notice">系统通知</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>


  
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_backup&action=backup_policy">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr><td align="right">备份间隔:</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="backuptime" value="{{$alarm.backuptime}}" />
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td align="right">备份后操作:</td>
		<td align=left>&nbsp;
		<select  class="wbk"  name="backup_delete" >
		<option value="0" {{if $alarm.backup_delete eq '0'}}selected{{/if}}>保留</option>
		<option value="1" {{if $alarm.backup_delete eq '1'}}selected{{/if}}>删除</option>
		</select>
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td align="right">协议:</td>
		<td align=left>&nbsp;
		<select  class="wbk"  name="backup_protocol" >
		<option value="ftp" {{if $alarm.backup_protocol eq 'ftp'}}selected{{/if}}>ftp</option>
		<option value="sftp" {{if $alarm.backup_protocol eq 'sftp'}}selected{{/if}}>sftp</option>
		</select>
		</td>
		
	</tr>
	<tr><td align="right">上传服务器IP:</td>
		<td align=left>&nbsp;
		<input type="text" name="backup_server" value="{{$alarm.backup_server}}" />
		</td>
		
	</tr>
	
	<tr bgcolor="f7f7f7"><td align="right">上传账号:</td>
		<td align=left>&nbsp;
		<input type="text" name="backup_username" value="{{$alarm.backup_username}}" />
		</td>
		
	</tr>
	<tr><td align="right">上传密码:</td>
		<td align=left>&nbsp;
		<input type="password" class="wbk" name="backup_password" value="{{$alarm.backup_password}}" />
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td align="right">上传目录:</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="backup_path" value="{{$alarm.backup_path}}" />
		</td>
		
	</tr>
	
	<tr bgcolor="f7f7f7">
			<td colspan="2" align="center"><input type="submit"  value="{{$language.Save}}" class="an_02"></td>
		</tr>

	</table>
	<input type="hidden" name="ac" value="{{if $alarm}}edit{{else}}new{{/if}}" />
</form>

		</table>
	</td>
  </tr>
</table>


<script language="javascript">
<!--
function check()
{
/*
   if(!checkIP(f1.ip.value) && f1.netmask.value != '32' ) {
	alert('地址为{{$language.HostName}}时，掩码应为32');
	return false;
   }   
   if(checkIP(f1.ip.value) && !checknum(f1.netmask.value)) {
	alert('请{{$language.Input}}正确掩码');
	return false;
   }
*/
   return true;

}//end check
// -->

function checkIP(ip)
{
	var ips = ip.split('.');
	if(ips.length==4 && ips[0]>=0 && ips[0]<256 && ips[1]>=0 && ips[1]<256 && ips[2]>=0 && ips[2]<256 && ips[3]>=0 && ips[3]<256)
		return ture;
	else
		return false;
}

function checknum(num)
{

	if( isDigit(num) && num > 0 && num < 65535)
		return ture;
	else
		return false;

}

function isDigit(s)
{
var patrn=/^[0-9]{1,20}$/;
if (!patrn.exec(s)) return false;
return true;
}

</script>
</body>
</html>


