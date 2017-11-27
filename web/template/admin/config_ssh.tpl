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
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=config_ssh">认证配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=config_ftp">系统参数</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=login_times">密码策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=ha">高可用性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=syslog_mail_alarm">告警配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=status_warning">告警参数</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=loadbalance">负载均衡</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>




  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=ssh_save">
<tr><th colspan="6" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td colspan="6" width="30%"  align=center>
		认证模式：
		<select  class="wbk"  name="radiusauth" >
		<option value="yes" {{if $sshconfig.radiusauth eq 'yes'}}selected{{/if}}>开启</option>
		<option value="no"  {{if $sshconfig.radiusauth eq 'no'}}selected{{/if}}>关闭</option>
		</select>
		</td>
		
	</tr>
	<tr><td align="right" width="12%">Radius主:</td>		
	<td width="10%">
		<input type="text" class="wbk" name="address" value="{{$sshconfig.address}}" />	
		</td>		
	<td align="right" width="12%">Radius主端口:</td>		
	<td width="5%">
		<input type="text" class="wbk" name="port" size=10 value="{{$sshconfig.port}}" />	</td>		
	<td align="right" width="12%">
		Radius主key:</td>		
	<td>
		<input type="text" class="wbk" name="secret" size=15 value="{{$sshconfig.secret}}" />	
		</td>		
	</tr>
	
	<tr bgcolor="f7f7f7"><td align="right">Radius从:</td>		
	<td>
		<input type="text" class="wbk" name="slaveaddress" value="{{$sshconfig.slaveaddress}}" />	
		</td>
<td align="right">Radius从端口:</td>		
	<td>
		<input type="text" class="wbk" name="slaveport" size=10 value="{{$sshconfig.slaveport}}" />	</td>		
	<td align="right">
		Radius从key:</td>		
	<td>
		<input type="text" class="wbk" name="slavesecret" size=15 value="{{$sshconfig.slavesecret}}" />	
		</td>
		
	</tr>
{{section name=l loop=$ldaps}}
<tr><td align="right">LDAP服务器:</td>		
	<td>
		<input type="text" class="wbk" id="ldapip_{{$smarty.section.l.index}}" name="ldapip[]" value="{{$ldaps[l].address}}" />	
		</td>
<td align="right">LDAP服务器端口:</td>		
	<td>
		<input type="text" class="wbk" name="ldapport[]" size=10 value="{{$ldaps[l].port}}" />	</td>		
	<td align="right">
		LDAP服务器DC:</td>		
	<td>
		<input type="text" class="wbk" name="ldapdomain[]" size=15 value="{{$ldaps[l].domain}}" />	&nbsp;&nbsp;透明登录:<input type="checkbox" value="1" name="transpant[]" {{if $ldaps[l].transpant}}checked{{/if}} />&nbsp;&nbsp;<input type="button" onclick="document.getElementById('ldapip_{{$smarty.section.l.index}}').value='';document.f1.submit();"  value="删除" class="an_02">&nbsp;&nbsp;<input type="button" onclick="window.open ('admin.php?controller=admin_config&action=ldapusers&id={{$smarty.section.l.index}}', 'newwindow', 'height=500, width=600, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');"  value="导入账号" class="an_02">&nbsp;&nbsp;<input type="button" onclick="window.open ('admin.php?controller=admin_config&action=ldapimportconfig&adserverindex={{$smarty.section.a.index}}', 'newwindow', 'height=500, width=600, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');"  value="导入策略" class="an_02">
		</td>
		
	</tr>
{{/section}}
{{section name=a loop=$ads}}
	<tr bgcolor="f7f7f7"><td align="right">AD 服务器:</td>		
	<td>
		<input type="text" class="wbk" id="adip_{{$smarty.section.a.index}}" name="adip[]" value="{{$ads[a].address}}" />	
		</td>
<td align="right"> AD 服务器端口:</td>		
	<td>
		<input type="text" class="wbk" name="adport[]" size=10 value="{{$ads[a].port}}" />	</td>		
	<td align="right">
		 AD域 :</td>		
	<td>
		<input type="text" class="wbk" name="addomain[]" size=15 value="{{$ads[a].domain}}" />	&nbsp;&nbsp;<input type="button" onclick="document.getElementById('adip_{{$smarty.section.a.index}}').value='';document.f1.submit();"  value="删除" class="an_02">&nbsp;&nbsp;<input type="button" onclick="window.open ('admin.php?controller=admin_config&action=adusers&id={{$smarty.section.a.index}}', 'newwindow', 'height=500, width=600, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');"  value="导入账号" class="an_02">&nbsp;&nbsp;<input type="button" onclick="window.open ('admin.php?controller=admin_config&action=adimportconfig&adserverindex={{$smarty.section.a.index}}', 'newwindow', 'height=500, width=600, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');"  value="导入策略" class="an_02">
		</td>		
	</tr>
{{/section}}

	<tr>
			<td  align="center" colspan=6><input type="button" onclick="window.location='admin.php?controller=admin_config&action=addldapserver'"  value="添加条目" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit"  value="{{$language.Save}}" class="an_02"></td>
		</tr>

	</table>
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


