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
{{if !$step }}
<FORM name="f1" onSubmit="return check()" enctype="multipart/form-data" action="admin.php?controller=admin_config&action=adusers" method="post">

              <TABLE width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" valign="top"  class="BBtable">
                <TBODY>
				<tr bgcolor="f7f7f7"><td align="right">AD 服务器:</td>		
	<td>
		<input type="text" class="wbk" name="address" value="{{$adconfig.address}}" />	
		</td>	
	<td align="right">
		 AD域 :</td>		
	<td>
		<input type="text" class="wbk" name="domain" value="{{$adconfig.domain}}" />	
		</td>		
	</tr>

	<tr bgcolor="f7f7f7"><td align="right">AD 服务器账号:</td>		
	<td>
		<input type="text" class="wbk" name="adusername" value="{{$adconfig.adusername}}" />	
		</td>
<td align="right"> AD 服务器密码:</td>		
	<td>
		<input type="password" class="wbk" name="adpassword" value="{{$adconfig.adpassword}}" />	</td>		
	<td align="right">
		 </td>		
	<td>	</td>
	</tr>
                  <TR>
                    <TD colspan="4" align="center"><INPUT class="an_02" type="submit" value="提交"></TD>
                  </TR>
                </TBODY>
              </TABLE>
</FORM>

{{else}}
 <FORM name="f1" onSubmit="return check()" enctype="multipart/form-data" action="admin.php?controller=admin_config&action=adusers_save" method="post">

              <TABLE width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" valign="top"  class="BBtable">
                <TBODY>
				<TR id="autosutr" {{if $smarty.section.i.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="20%" align="center">用户名 选择				
					</TD>
                  </TR>
				
                  <TR id="autosutr" {{if $smarty.section.i.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD>
					<table><tr >
		{{section name=i loop=$members}}
		{{if !$members[i].checked}}
		<td width="150"><input type='checkbox' name='username[]' value='{{$members[i].username}}' >{{$members[i].username}}</td>{{if ($smarty.section.i.index +1) % 5 == 0}}</tr><tr>
		
				 {{/if}} {{/if}} 
				{{/section}}
		</tr></table>
					</TD>
                  </TR>
                  <TR>
                    <TD colspan="2" align="center">密码<input type='password' name='password' class="input_shorttext" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT class="an_02" type="submit" value="保存修改"></TD>
                  </TR>
                </TBODY>
              </TABLE>
</FORM>
{{/if}}
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



