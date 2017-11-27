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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>

</ul><span class="back_img"><A href="admin.php?controller=admin_backup&action=backup_setting&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_backup&action=backup_setting_forpassword_save&id={{$bs.seq}}">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr><td align="right">同步地址</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="ip" value="{{$bs.ip}}" />
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td align="right">同步端口:</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="port" value="{{$bs.port}}" />
		</td>
		
	</tr>
	<tr bgcolor=""><td align="right">系统用户:</td>
		<td align=left>&nbsp;
		<input type="text" name="user" value="{{$bs.user}}" />
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td align="right">系统用户密码:</td>
		<td align=left>&nbsp;
		<input type="password" class="wbk" name="passwd" value="{{$bs.passwd}}" />
		</td>
		
	</tr>
	<tr bgcolor=""><td align="right">确认系统用户密码:</td>
		<td align=left>&nbsp;
		<input type="password" class="wbk" name="passwdc" value="{{$bs.passwd}}" />
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td align="right">备份目录:</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="path" value="{{$bs.path}}" />
		</td>
		
	</tr>
	<tr bgcolor="">
			<td colspan="2" align="center"><input type="submit"  value="{{$language.Save}}" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="手动同步" class="an_02"></td>
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


