<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>主页面</title>
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
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=ifcfgeth">网络配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=config_route">静态路由</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=ping">PING</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
  <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=tracepath">TRACE</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>

 
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	
	<tr>
		<th class="list_bg" align=center>序号</th>
		<th class="list_bg" align=center>网段</th>
		<th class="list_bg" align=center>掩码</th>
		<th class="list_bg" align=center>网关</th>
		<th class="list_bg" align=center>操作</th>
	</tr>
	{{section name=r loop=$route}}
	<form action='admin.php?controller=admin_eth&action=route_save' method='post'>
	<tr {{if $smarty.section.r.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td align=center>{{$smarty.section.r.index+1}}</td>
		<td align=center><input name='section' value='{{$route[r].section}}'></td>
		<td align=center><input name='netmask' value='{{$route[r].netmask}}'></td>
		<td align=center><input name='gateway' value='{{$route[r].gateway}}'></td>
		<td align=center><input type="submit" name="delete" value='删除' class="an_02"></td>
		
	</tr>
	<input type="hidden" name="sectionold" value="{{$route[r].section}}">
	<input type="hidden" name="netmaskold" value="{{$route[r].netmask}}">
	<input type="hidden" name="gatewayold" value="{{$route[r].gateway}}">
	</form>
	{{/section}}
	<form action='admin.php?controller=admin_eth&action=route_add2' method='post'>
	<tr bgcolor="f7f7f7">
		<td align=center>增加</td>
		<td align=center><input name='section' value=''></td>
		<td align=center><input name='netmask' value=''></td>
		<td align=center><input name='gateway' value=''></td>
		<td align=center><input type='submit' value='增加' class="an_02"></td>
		
	</tr>
	</form>
	</table>


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
	alert('地址为主机名时，掩码应为32');
	return false;
   }   
   if(checkIP(f1.ip.value) && !checknum(f1.netmask.value)) {
	alert('请录入正确掩码');
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



