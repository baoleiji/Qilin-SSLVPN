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
	<td class="main_content">

        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center">
	<table border=0 cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	{{section name=t loop=$apppub}}
	<TR bgcolor="f7f7f7">
	<TD width="50%" align=right>{{$apppub[t].name}} </TD>
                </TR>
	{{/section}}
     
          
	</table>

	</td>
  </tr>
</table>

</body>
</html>


