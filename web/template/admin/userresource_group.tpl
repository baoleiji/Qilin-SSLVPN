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
	<td class="main_content" align="center">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_member&action=protect_group_resgrp_save&gid={{$gid}}">
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.groupname}}:
		</td>
		<td width="67%">
		{{$group.groupname}}
	  </td>
	</tr>
		
	<tr>

		<td width="33%" align=right>
		{{$language.bind}}{{$language.DeviceGroup}}
		</td>
		<td width="67%">
		<table><tr>
		{{section name=g loop=$alldevgroup}}
		<td width="150"><input type="checkbox" name='Check{{$smarty.section.g.index}}' value='{{$alldevgroup[g].id}}'  {{$alldevgroup[g].check}}><a onclick="window.open ('admin.php?controller=admin_pro&action=resourcegrp_selgroup&gid={{$gid}}&sid={{$alldevgroup[g].id}}&sessionlgroup={{$sessionlgroup}}', 'newwindow', 'height=330, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;" href="#" target="_blank" >{{$alldevgroup[g].groupname}}</a></td>{{if ($smarty.section.g.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/section}}
		</tr></table>
	  </td>
	</tr>
	</table>
<br>
<input type=submit  value="{{$language.Save}}" class="an_02">
<input type="hidden" name="sessionlgroup" value="{{$sessionlgroup}}" />

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


