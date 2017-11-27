<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>路由{{$language.List}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>
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
<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>

	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=vpn_pool">VPN POOL</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
		<tr bgcolor="#F3F8FC">
			<th class="list_bg"  width="20%" align="center" bgcolor="#E0EDF8"><b>VPN pool</b></th>
			<th class="list_bg"  width="30%" align="center" bgcolor="#E0EDF8"><b>起始地址</b></th>
			<th class="list_bg"  width="30%" align="center" bgcolor="#E0EDF8"><b>终止地址</b></th>
			<th class="list_bg"  width="30%" align="center" bgcolor="#E0EDF8"><b>{{$language.Operate}}</b></th>
		</tr>		
		{{section name=t loop=$routes}}
		<form name='route' action='admin.php?controller=admin_eth&action=vpnpool_save' method='post'>
		<tr>
			<td width="10%" class="td_line">{{$routes[t].gname}}</td>
			<td class="td_line" width="30%">{{$routes[t].start}}</td>
			<td class="td_line" width="30%">{{$routes[t].end}}</td>
			<td class="td_line"  width="30%" align="center"><img src="{{$template_root}}/images/edit_ico.gif" width="16" height="16" hspace="5" border="0" align="absmiddle"><a href="admin.php?controller=admin_eth&action=vpnpool_edit&gname={{$routes[t].gname}}" >编辑</a>&nbsp;&nbsp;<img src="{{$template_root}}/images/cross.png" width="16" height="16" hspace="5" border="0" align="absmiddle"><a href="admin.php?controller=admin_eth&action=vpnpool_save&delete={{$routes[t].gname}}" >删除</a></td>
		</tr>
		<input type="hidden" name="gname" value="{{$routes[t].gname}}" />
		</form>
		{{/section}}
                <tr>           
      <td  ><input  onclick="window.location='admin.php?controller=admin_eth&action=vpnpool_edit'" type="button" value=" {{$language.Add}} " class="an_02"></td>
	<td  >  </td>
	<td  > </td>
		   <td></td>
		</tr>
		</table>
	</td>
  </tr>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


