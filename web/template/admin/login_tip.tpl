<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/Calendarandtime.js"></script>
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$title}}</td>
  </tr>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_pro&action=resourcegrp_seluser_save">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<TR  bgcolor="f7f7f7" id="autosutr">
		<TD width="50%" align=right>上次登录IP </TD>
                  <TD>{{$member.ip}}  </TD>
                </TR>
                <TR id="autosutr">
		<TD width="50%" align=right>上次登录时间 </TD>
                  <TD >       {{$smarty.session.ADMIN_LASTDATE}}       </TD>
                </TR>
                <TR id="autosutr" bgcolor="f7f7f7">
		<TD width="50%" align=right>上次口令更改时间</TD>
                  <TD >    {{$member.lastdateChpwd}}          </TD>
                </TR>
                <TR id="autosutr">
		<TD width="50%" align=right>口令到期时间 </TD>
                  <TD >{{$member.nextdateChpwd}}</TD>
                </TR>
     <TR bgcolor="f7f7f7">
                  <TD width="50%" align=right>本次来源IP </TD>
                  <TD>  
				  {{$smarty.session.ADMIN_IP}}
				  </TD>
                </TR>
                <TR>
                  <TD width="50%" align=right>当前时间</TD>
                  <TD>               
				  {{$now}}
				  </TD>
                </TR>
               
</table>

</body>
</html>


