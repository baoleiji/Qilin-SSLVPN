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
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=config_eth">eth0</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    {{section name=e loop=$num-1}}
	<li class={{if $number ne $smarty.section.e.index+1}}"me_b"{{else}}"me_a"{{/if}} ><img src="{{$template_root}}/images/an1{{if $number ne $smarty.section.e.index+1}}1{{/if}}.jpg"  align="absmiddle"><a href="admin.php?controller=admin_eth&action=config_ethx&number={{$smarty.section.e.index+1}}">eth{{$smarty.section.e.index+1}}</a><img src="{{$template_root}}/images/an3{{if $number ne $smarty.section.e.index+1}}3{{/if}}.jpg" align="absmiddle"/></li>
    {{/section}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=config_route">静态路由</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>


 
	<td class="">
		<table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_eth&action=ethx_save&number={{$number}}">
	<tr><th colspan="3" class="list_bg"></th></tr>
{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		ip地址		
		</td>
		<td width="67%">
		<input type=text name="ipaddr" size=35 value="{{$network.ipaddr}}" >
	  </td>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		掩码		
		</td>
		<td width="67%">
		<input type=text name="netmask" size=35 value="{{$network.netmask}}" >
	  </td>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		{{$language.Startup}}		
		</td>
		<td width="67%">
		<select  class="wbk"  name="onboot">
		<option value="yes" {{if $network.onboot eq 'yes'}}selected{{/if}} >{{$language.Yes}}</option>
		<option value="no" {{if $network.onboot eq 'no'}}selected{{/if}} >{{$language.No}}</option>
		</select>
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td  align="center" colspan=2><input type="submit"  value="{{$language.Save}}" class="an_02"></td>
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


