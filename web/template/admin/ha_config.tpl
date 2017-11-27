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
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=haconfig_save">
	<tr><th colspan="3" class="list_bg"></th></tr>
	{{assign var="trnumber" value=0}}
<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
	<td align="right">从服务器IP ：</td>
		<td align=left>
		<input type="text" class="wbk" name="slaveip" value="{{$ha.slaveip}}" readOnly />
		</td>
		
	</tr>

	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
	<td align="right">浮动 IP ：</td>
		<td align=left>
		<input type="text" class="wbk" name="virtual_ipaddress" value="{{$ha.virtual_ipaddress}}" />
		</td>
		
	</tr>
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td></td>	<td  align="left"><input type="submit" class=""  value="{{$language.Save}}"></td>
		</tr>

	</table>
	<input type="hidden" name="ac" value="{{if $ha}}edit{{else}}new{{/if}}" />
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

function changestatus(t){
	if(t=='master'){
		document.getElementById('masterip').disabled = 'disabled';
	}else{
		document.getElementById('masterip').disabled = '';
	}
	
}
</script>
</body>
</html>


