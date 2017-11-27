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
			<th class="list_bg"  width="5%" align="center" bgcolor="#E0EDF8"><b>选择</b></th>
			<th class="list_bg"  width="25%" align="center" bgcolor="#E0EDF8"><b>来源地址段</b></th>
			<th class="list_bg"  width="25%" align="center" bgcolor="#E0EDF8"><b>目标地址段</b></th>
			<th class="list_bg"  width="25%" align="center" bgcolor="#E0EDF8"><b>映射IP</b></th>
			<th class="list_bg"  width="" align="center" bgcolor="#E0EDF8"><b>操作</b></th>
		</tr>		
		<form name="ip_list" action="admin.php?controller=admin_eth&action=vpn_delete" method="post">
		{{section name=t loop=$routes}}
		<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td width="10%"><input type="checkbox" name="chk_gid[]" value="{{$routes[t].p_addr}}"></td>
			<td >{{$routes[t].s_addr}}</td>
			<td >{{$routes[t].d_addr}}</td>
			<td >{{$routes[t].p_addr}}</td>
			<td  align="left"><img src="{{$template_root}}/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_eth&action=vpn_edit&p_addr={{$routes[t].p_addr}}">编辑</a>
				| <img src="{{$template_root}}/images/cross.png" width="16" height="16" hspace="5" border="0" align="absmiddle"><a href="admin.php?controller=admin_eth&action=vpn_delete&p_addr={{$routes[t].p_addr|urlencode}}">删除</a></td>
		</tr>
		{{/section}}
                <tr>           
      <td colspan="5" ><input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_gid[]')e.checked=this.form.select_all.checked;}" value="checkbox">选中本页显示的所有项目&nbsp;&nbsp;<input type="submit"  value="删除选中" onclick="my_confirm('删除所选IP');if(chk_form()) document.ip_list.action='admin.php?controller=admin_eth&action=vpn_delete'; else return false;" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;<input  type="button" onclick="window.location='admin.php?controller=admin_eth&action=vpn_edit'" value=" 增加 " class="an_02"></td>
     
		</tr>
		</form>
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



