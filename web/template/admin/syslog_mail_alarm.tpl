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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=syslog_mail_alarm">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7"><td align="right">{{$language.StartupMailAlert}}:</td>
		<td align=left>&nbsp;
		<input type="radio" name="Mail_Alarm" {{if $alarm.Mail_Alarm eq '1'}}checked{{/if}} value="1" />{{$language.Startup}} <input type="radio" name="Mail_Alarm" {{if $alarm.Mail_Alarm eq '0'}}checked{{/if}} value="0" />{{$language.Shutdown}}
		</td>
		
	</tr>
	<tr><td align="right">{{$language.MailServer}}:</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="Mailserver" value="{{$alarm.MailServer}}" />
		&nbsp;&nbsp;&nbsp;&nbsp;端口：<input type="text" class="wbk" name="mailport" value="{{$alarm.mailport}}" />
		&nbsp;&nbsp;&nbsp;&nbsp;SSL：<input type="checkbox" class="wbk" name="sslmail" value="1" {{if $alarm.sslmail}}checked{{/if}} />
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td align="right">{{$language.EmailAccount}}:</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="account" value="{{$alarm.account}}" />
		</td>
		
	</tr>
	<tr><td align="right">{{$language.AccountPassword}}:</td>
		<td align=left>&nbsp;
		<input type="password" name="password" value="{{$alarm.password}}" />
		</td>
		
	</tr>

	<tr bgcolor="f7f7f7"><td align="right">认证邮件告警:</td>
		<td align=left>&nbsp;
		<select  class="wbk"  name="mailalarm" >
		<option value="yes" {{if $alarm.mailalarm eq 'yes'}}selected{{/if}}>是</option>
		<option value="no" {{if $alarm.mailalarm eq 'no'}}selected{{/if}}>否</option>
		</select>&nbsp;打开认证告警邮件，如果告警邮件过多可能造成邮件堵塞，修改后请到系统管理中重启认证服务
		</td>
		
	</tr>
	
	<tr><td align="right">{{$language.StartupsyslogAlert}}:</td>
		<td align=left>&nbsp;
		<input type="radio" name="syslog_alarm" {{if $alarm.Syslog_Alarm eq '1'}}checked{{/if}} value="1" />{{$language.Startup}} <input type="radio" name="syslog_alarm" {{if $alarm.Syslog_Alarm eq '0'}}checked{{/if}} value="0" />{{$language.Shutdown}}
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td align="right">syslog{{$language.Server}}:</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="syslogserver" value="{{$alarm.syslogserver}}" />
		</td>
		
	</tr>
	<tr><td align="right">syslog{{$language.port}}:</td>
		<td align=left>&nbsp;
		<input type="text" class="wbk" name="syslogport" value="{{$alarm.syslogport}}" />
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td align="right">syslog{{$language.device}}:</td>
		<td align=left>&nbsp;
		<select  class="wbk"  name="syslog_facility" >
		<option value="local0" {{if $alarm.syslog_facility eq 'local0'}}selected{{/if}}>local0</option>
		<option value="local1" {{if $alarm.syslog_facility eq 'local1'}}selected{{/if}}>local1</option>
		<option value="local2" {{if $alarm.syslog_facility eq 'local2'}}selected{{/if}}>local2</option>
		<option value="local3" {{if $alarm.syslog_facility eq 'local3'}}selected{{/if}}>local3</option>
		<option value="local4" {{if $alarm.syslog_facility eq 'local4'}}selected{{/if}}>local4</option>
		<option value="local5" {{if $alarm.syslog_facility eq 'local5'}}selected{{/if}}>local5</option>
		<option value="local6" {{if $alarm.syslog_facility eq 'local6'}}selected{{/if}}>local6</option>
		<option value="local7" {{if $alarm.syslog_facility eq 'local7'}}selected{{/if}}>local7</option>
		</select>
		</td>
		
	</tr>
	<tr>
			<td colspan="2" align="center"><input type="submit"  value="{{$language.Save}}" class="an_02"></td>
		</tr>

	</table>
	<input type="hidden" name="ac" value="{{if $alarm.uid}}edit{{else}}new{{/if}}" />
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


