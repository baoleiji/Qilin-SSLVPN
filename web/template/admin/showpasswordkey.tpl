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
 <FORM name="f1" onSubmit="return check()" enctype="multipart/form-data" action="admin.php?controller=admin_pro&action=showpasswordkey&id={{$id}}" method="post">

              <TABLE width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" valign="top"  class="BBtable">
                <TBODY>
				 {{if $p}}
                  <TR bgcolor="#f7f7f7">
                    <TD colspan="2" class="list_bg">{{$p.key_str}}</TD>
                  </TR>
				 {{else}}
				 <TR bgcolor="#f7f7f7">
                    <TD colspan="2" class="list_bg">请分别输入password和audit用户密码</TD>
                  </TR>
                  <TR id="autosutr" bgcolor="#f7f7f7">
                    <TD width="50%" align="right">password用户密码</TD>
                    <TD><INPUT type=password name=password value="">                      </TD>
                  </TR>
                  <TR id="autosutr">
                    <TD width="50%" align="right">audit用户密码</TD>
                    <TD><INPUT type=password name=audit value="">      </TD>
                  </TR>
                  <TR>
                    <TD colspan="2" align="center"><INPUT class="an_02" name="submit" type="submit" value="提交">&nbsp;&nbsp;&nbsp;&nbsp;<INPUT class="an_02" name="submit" type="button" onclick="window.close();" value="取消"></TD>
                  </TR>
				  {{/if}}
                </TBODY>
              </TABLE>
</FORM>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



