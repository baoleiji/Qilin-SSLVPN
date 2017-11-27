<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>路由列表</title>
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

  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
		<tr bgcolor="#F3F8FC">
			<th class="list_bg"  width="30%" align="center" bgcolor="#E0EDF8"><b>IP</b></th>
			<th class="list_bg"  width="30%" align="center" bgcolor="#E0EDF8"><b>掩码</b></th>
			<th class="list_bg"  width="30%" align="center" bgcolor="#E0EDF8"><b>操作</b></th>
		</tr>		
		{{section name=t loop=$routes}}
		<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td width="10%">{{$routes[t].ip}}</td>
			<td width="30%">{{$routes[t].netmask}}</td>
			<td width="30%" align="left"><img src="{{$template_root}}/images/cross.png" width="16" height="16" hspace="5" border="0" align="absmiddle"><a href="admin.php?controller=admin_eth&action=route_delete&id={{$routes[t].id}}">删除</a></td>
		</tr>
		{{/section}}
                <tr>           
      <td  ><input  type="button" onclick="window.location='admin.php?controller=admin_eth&action=route_edit'" value=" 增加 " class="an_02"></td>
     <td>
   
	</td>
	<td align="left">
			
		 
		   </td>
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



