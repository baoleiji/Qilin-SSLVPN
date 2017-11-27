<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>自动发现</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/Calendarandtime.js"></script>
</head>

<body>
 <FORM name="f1" onSubmit="return check()" enctype="multipart/form-data" action="admin.php?controller=admin_pro&action=autofind" method="post">

              <TABLE width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" valign="top"  class="BBtable">
                <TBODY>
                  <TR bgcolor="#f7f7f7">
                    <TD class="" width="50%" align="right">输入网段</TD>
                    <TD class="" align="left"><input type="text" name="ip" id="ip" value="" >例如：192.168.0.0/16</TD>
                  </TR>
                  <TR>
                    <TD colspan="2" align="center"><INPUT class="an_02" onclick="return checkip();" type="submit" value="提交"></TD>
                  </TR>
                </TBODY>
              </TABLE>
</FORM>
<script>
function checkip(){
	var a = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\/\d{1,2}$/.test(document.getElementById('ip').value);
	return a; 
}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



