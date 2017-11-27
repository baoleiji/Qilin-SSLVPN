<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/Calendarandtime.js"></script>
</head>
<script>

</script>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$title}}</td>
  </tr>
  <tr>
	<td class="main_content">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' enctype="multipart/form-data" action="admin.php?controller=admin_pro&action=ssh_private_key_upload&lid={{$lid}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<TR bgcolor="f7f7f7" id="autosutr">
		
				<TR>
                  <TD width="50%" align=right>上传SFTP/SSH key </TD>
                  <TD><input type="file" name="key" /></TD>
                </TR>
	<tr><td></td><td><input type=submit  value="保存修改" class="an_02"></td></tr></table>
	<input type="hidden" name="upload" value="1">
</form>
	</td>
  </tr>
</table>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



