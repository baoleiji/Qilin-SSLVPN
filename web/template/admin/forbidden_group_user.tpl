<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

</head>
<script>
	function my_confirm(str){
		if(!confirm("确认要" + str + "？"))
		{
			window.event.returnValue = false;
		}
	}
	function chk_form(){
		for(var i = 0; i < document.member_list.elements.length;i++){
			var e = document.member_list.elements[i];
			if(e.name == 'id[]' && e.checked == true)
				return true;
		}
		alert("您没有{{$language.select}}任何{{$language.User}}！");
		return false;
	}
</script>
<body>



	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$title}}</td>
  </tr>

  <tr>
	<td class="main_content" align="center" width="100%">

	<table id="f1table"  border=0 width=100% cellpadding=1 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	
	

	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_forbidden&action=protect_edit&uid={{$id}}&f_gid={{$f_gid}}&weektime={{$weektime}}">
		<tr>
		<td width="33%" align=right>
		{{$language.InputthedeviceIP}}
		</td>
		<td width="67%">
			<input name="ip" type="text"><input type=submit class=btn1 value="{{$language.Input}}">
	  </td>
	</tr>

	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.select}}{{$language.DeviceGroup}}
		</td>
		<td width="67%">&nbsp;</td>
		
</tr>
		{{section name=g loop=$alldevgroup}}
		<tr>
		<td align=right>
			<input type="radio" name="controller" value="{{$alldevgroup[g].id}}" onClick="location.href='admin.php?controller=admin_forbidden&action=protect_dev&g_id={{$alldevgroup[g].id}}&uid={{$id}}&f_gid={{$f_gid}}&weektime={{$weektime}}'">
		</td>
		<td>
			{{$alldevgroup[g].groupname}}
		</td>
		</tr>
		{{/section}}
		</table>
	  </td>
	</tr>
	</table>
<br>

</form>
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


