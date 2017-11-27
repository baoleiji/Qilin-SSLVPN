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
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=adimportconfig_save&id={{$adconfig.id}}">
<tr><th colspan="6" class="list_bg">选择已有配置:<select onchange="window.location='admin.php?controller=admin_config&action=adimportconfig&id='+this.value">
<option value="-1">请选择</option>
{{section name=c loop=$configs}}
<option value="{{$configs[c].id}}" {{if $configs[c].id eq $adconfig.id}}selected{{/if}}>{{$configs[c].title}}</option>
{{/section}}
</select></th></tr>
	
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td align="right">策略ID:</td>		
	<td>
		{{$adconfig.id}}
		</td>	
	</tr>
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td align="right">名称:</td>		
	<td>
		<input type="text" class="wbk" name="title" value="{{$adconfig.title}}" />	
		</td>	
	</tr>
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
	<td align="right">AD服务器:</td>		
	<td>
		<select name="ip">
		{{section name=as loop=$adservers}}
		<option value="{{$adservers[as].address}}" {{if $smarty.section.as.index eq $adserverindex or $adservers[as].address eq $adconfig.server}}selected{{/if}}>{{$adservers[as].address}}:{{$adservers[as].port}}</option>
		{{/section}}
		</select>
		</td>		
	</tr>
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td align="right">AD用户名:</td>		
	<td>
		<input type="text" class="wbk" name="adusername" value="{{$adconfig.adusername}}" />	
		</td>	
	</tr>
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td align="right">AD密码:</td>		
	<td>
		<input type="password" class="wbk" name="adpassword" value="{{$adconfig.adpassword}}" />&nbsp;&nbsp;&nbsp;<input type="password" class="wbk" name="readpassword" value="{{$adconfig.adpassword}}" />
		</td>	
	</tr>
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td align="right">导入用户密码:</td>		
	<td>
		<input type="password" class="wbk" name="aduserpwd" value="{{$adconfig.aduserpwd}}" />&nbsp;&nbsp;&nbsp;<input type="password" class="wbk" name="readuserpwd" value="{{$adconfig.aduserpwd}}" />
		</td>	
	</tr>
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
	<td align="right">服务器路径:</td>		
	<td>
		<textarea name="path" cols="50" rows="5" >{{$adconfig.path}}</textarea>
		</td>	
	</tr>
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
	<td colspan="2" align="center">过滤参数</td></tr>
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}><td align="right">用户:</td>		
	<td>
		<input type="text" size="80" class="wbk" name="filteruser" value="{{$adconfig.filteruser}}" />	
		</td>	
	</tr>
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
	<td align="right">用户组:</td>		
	<td>
		<input type="text" size="80" class="wbk" name="filterusergroup" value="{{$adconfig.filterusergroup}}" />	
		</td>	
	</tr>
	<tr>
		<td  align="center" colspan=2><input type="submit" name="submit"  value="同步" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit"  value="{{$language.Save}}" name="submit" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.location='admin.php?controller=admin_config&action=adimportconfig&id=-1'"  value="新建" class="an_02"></td>
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


