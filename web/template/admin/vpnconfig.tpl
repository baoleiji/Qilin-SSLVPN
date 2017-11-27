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
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_eth&action=vpnconfig_save">
	<tr><th colspan="3" class="list_bg"></th></tr>
	{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td>开放端口:</td>
		<td align=left>
		<input type="text" class="wbk" name="port" value="{{$vpnconfig.port}}" />
		</td>
		
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td>IP地址池:</td>
		<td align=left>
		<input type="text" class="wbk" name="server1" value="{{$vpnconfig.server1}}" />&nbsp;&nbsp;<input type="text" class="wbk" name="server2" value="{{$vpnconfig.server2}}" />
		</td>
		
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td>最大连接:</td>
		<td align=left>
		<input type="text" class="wbk" name="max_clients" value="{{$vpnconfig.max_clients}}" />
		</td>
		
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td>连接检测:</td>
		<td align=left>
		<input type="text" class="wbk" name="keepalive1" value="{{$vpnconfig.keepalive1}}" />&nbsp;&nbsp;<input type="text" class="wbk" name="keepalive2" value="{{$vpnconfig.keepalive2}}" />
		</td>
		
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td>
		地址		
		</td>
		<td width="67%">
		<input type=text name="addr" size=35 value="{{$addr}}" >
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td>
		Key		
		</td>
		<td width="67%">
		<input type=text name="key" size=35 value="{{$key}}" >
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td>启用压缩:</td>
		<td align=left>
		<select name="comp_lzo" id="comp_lzo">
		<option value="yes" {{if $vpnconfig.comp_lzo eq 1}}selected{{/if}}>是</option>
		<option value="no" {{if $vpnconfig.comp_lzo eq 0}}selected{{/if}}>否</option>
		</select>
		</td>
		
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td>终端互访:</td>
		<td align=left>
		<select name="client_to_client" id="client_to_client">
		<option value="yes" {{if $vpnconfig.client_to_client eq 1}}selected{{/if}}>是</option>
		<option value="no" {{if $vpnconfig.client_to_client eq 0}}selected{{/if}}>否</option>
		</select>
		</td>
		
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td  align="center" colspan=2><input type="submit"  value="{{$language.Save}}" class="an_02"></td>
		</tr>

	</table>
	<input type="hidden" name="oldport" value="{{$vpnconfig.port}}">
	<input type="hidden" name="oldserver1" value="{{$vpnconfig.server1}}">
	<input type="hidden" name="oldserver2" value="{{$vpnconfig.server2}}">
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
   if(document.getElementById("encrypt").options[document.getElementById("encrypt").options.selectedIndex].value!='{{$udf.encrypt}}'){
		if(confirm("所有的密码将被转换,请注意要先备份!")==false){
			return false;
		}
   }
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


