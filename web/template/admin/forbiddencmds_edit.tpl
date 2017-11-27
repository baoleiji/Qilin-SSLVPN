<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

</head>
 <SCRIPT language=javascript src="{{$template_root}}/images/selectdate.js"></SCRIPT>
 <SCRIPT type=text/javascript>
var siteUrl = "{{$template_root}}/images/date";
</SCRIPT>
<body>



	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$title}}</td>
  </tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
          <tr>
            <td align="center">
    <form name="f1" method=post action="admin.php?controller=admin_session&action=forbiddencms_edit">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
		<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.Command}}
		</td>
		<td width="67%">
		<input type=text name="cmd" size=35 value="" >
	  </td>
	</tr>
	<tr >
		<td width="33%" align=right>
		地址
		</td>
		<td width="67%">
		<select  class="wbk"  name="addr" >
		{{section name=a loop=$alladdr}}
		<option value='{{$alladdr[a]}}' >{{$alladdr[a]}}</option>
		{{/section}}
		</select>
	  </td>
	</tr>
	
		<tr>
		<td width="33%" align=right>
		{{$language.bind}}{{$language.User}}
		</td>
		<td width="67%">
		<select  class="wbk"  name="radius_user" >
		{{section name=g loop=$allmem}}
		<option value='{{$allmem[g].username}}' >{{$allmem[g].username}}</option>
		{{/section}}
		</select>
	  </td>
	  </tr>
	</table>
<br>
<input type="hidden" name="ac" value="new" />
<input type=submit  value="{{$language.Save}}" class="an_02">

</form>
	</td>
  </tr>
</table>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


