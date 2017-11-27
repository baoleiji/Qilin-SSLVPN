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
   <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=ifcfgeth">网络配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=config_route">静态路由</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=ping">PING</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
  <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=tracepath">TRACE</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_eth&action=ifcfgeth&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>



  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_eth&action=br0_save&filename={{$filename}}">
<tr><th colspan="3" class="list_bg"></th></tr>
{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td width="33%" align=right>IPv4启动:</td>
		<td align=left width="67%">
		<select name="onboot" >
		<option value="yes" {{if $onboot eq 'yes'}}selected{{/if}}>启用</option>
		<option value="no" {{if $onboot eq 'no'}}selected{{/if}}>禁用</option>
		</select>
		</td>		
	</tr>
	
{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		ip地址		
		</td>
		<td width="67%">
		<input type=text name="ipaddr" size=35 value="{{$ipaddr}}" >
	  </td>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		掩码		
		</td>
		<td width="67%">
		<input type=text name="netmask" size=35 value="{{$netmask}}" >
	  </td>
	</tr>

	
{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td width="33%" align=right>IPv6启用:</td>
		<td align=left width="67%">
		<select name="ipv6init" >
		<option value="yes" {{if $ipv6init eq 'yes'}}selected{{/if}}>打开</option>
		<option value="no" {{if $ipv6init eq 'no'}}selected{{/if}}>关闭</option>
		</select>
		</td>		
	</tr>
{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td width="33%" align=right>IPv6地址:</td>
		<td align=left width="67%">
		<input type="text" class="wbk" name="ipv6addr" value="{{$ipv6addr}}" />	
		</td>
		
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td width="33%" align=right>IPv6网关:</td>
		<td align=left width="67%">
		<input type="text" class="wbk" name="ipv6gateway" value="{{$ipv6gateway}}" />	
		</td>		
	</tr>
{{if $name eq 'ETH0' or $name eq 'BR0'}}
{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td width="33%" align=right>DNS{{$language.Server}}一:</td>
		<td align=left width="67%">
		<input type="text" class="wbk" name="nameserver1" value="{{$sshconfig.nameserver1}}" />	
		</td>
		
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td width="33%" align=right>DNS{{$language.Server}}二:</td>
		<td align=left width="67%">
		<input type="text" class="wbk" name="nameserver2" value="{{$sshconfig.nameserver2}}" />	
		</td>		
	</tr>
{{/if}}	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td width="33%" align=right>绑定网卡:</td>
		<td align=left width="67%">
		{{section name=e loop=$eths}}
		<input type='checkbox' name='eths[]' value='{{$eths[e].file}}' {{if $eths[e].br0}}checked{{/if}} {{if $smarty.get.name ne $eths[e].name}}disabled{{/if}} />{{$eths[e].name}}&nbsp;&nbsp;&nbsp;&nbsp;
		{{/section}}
		</td>		
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td  align="center" colspan=2><input  type="submit" onclick="return reset();" value="重启网络" class="an_02">&nbsp;&nbsp;<input type="submit"  value="{{$language.Save}}" class="an_02"></td>
		</tr>

	</table>

</form>

		</table>
	</td>
  </tr>
</table>


<script language="javascript">
function reset(){
	if(confim('确定要重{{$language.new}}{{$language.Start}}吗?')){
		document.location='admin.php?controller=admin_eth&action=network_restart'
		return false;
	}
	return false;
}
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


