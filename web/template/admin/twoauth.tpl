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
            <td align="center"><form name="f1" method=post enctype="multipart/form-data" action="admin.php?controller=admin_pro&action=dotwoauth">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	 <TR bgcolor="">
                  <TD colspan="1" align=right>登录审批 </TD>
                  <td></td>
                </TR>
     <TR bgcolor="f7f7f7">
                  <TD width="50%" align=right>审批用户: </TD>
                  <TD>
					<select  class="wbk"  name=username>
                     {{section name=k loop=$users}}
						<option value="{{$users[k].username}}" >{{$users[k].username}}</option>
					 {{/section}}
					</select>                  
				  </TD>
                </TR>
                <TR>
                  <TD width="50%" align=right>密码: </TD>
                  <TD><input type="password" name="password" value="" />               
				  </TD>
                </TR>            
	<tr><td></td><td><input type=submit  value="登录" class="an_02"></td></tr></table>
	<input type="hidden" name="url" value="{{$url}}" />
	<input type="hidden" name="id" value="{{$devicesid}}" />
</form>
	</td>
  </tr>
</table>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



