<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$title}}</td>
  </tr>
  <tr>
	<td class="main_content" align='center'><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_pro&action=stra_save&ntype={{$ntype}}&id={{$id}}&d_id={{$d_id}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<tr bgcolor="f7f7f7">
			<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.IPAddress}}
		</td>
		<td width="67%">
		<input type=text name="IP" size=35 value="{{$IP}}" readonly>
	  </td>
	</tr>
	<tr>
		<td width="33%" align=right>
		{{$language.policyname}}	
		</td>
		<td width="67%">
		<input type=text name="straname" size=35 value="{{$straname}}" {{if $straname}}readonly{{/if}}>
	  </td>
	</tr>

		</tr>
		<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.Edittype}}	
		</td>
		<td width="67%">
		<input type='radio' name="stra_type" value='mon' {{if $method == 'mon'}}checked{{/if}}>
		{{$language.Month}}
		<input type='radio' name="stra_type" value='week' {{if $method == 'week'}}checked{{/if}}>
		{{$language.Week}}
		<input type='radio' name="stra_type" value='custom'{{if $method == 'custom'}}checked{{/if}}>
		{{$language.Custom}}
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.Frequency}}
		</td>
		<td width="67%">
		<input type=text name="freq" size=35 value="{{$freq}}" >**
		</td>
	</tr>	
	<tr bgcolor="f7f7f7">
		<td colspan='2'>
		**{{$language.Frequency}}的{{$language.Man}}：如果{{$language.Edittype}}{{$language.select}}{{$language.Week}}，这里填写周几（1—7）,如果{{$language.Yes}}{{$language.Month}}，填写几号（1—31）,如果{{$language.Yes}}{{$language.Custom}}，这里{{$language.day}}几{{$language.day}}更{{$language.new}}一次（大于0的整数）
		</td>
	</tr>
	<tr><td></td><td><input type=submit  value="{{$language.Save}}" class="an_02"></td></tr></table>

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



