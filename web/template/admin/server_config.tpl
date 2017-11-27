<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>程序{{$language.Configure}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

</head>
<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">程序{{$language.Configure}}——更改{{$language.Configure}}</td>
  </tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="news_add" method="post" action="admin.php?controller=admin_config&action=server_save"onsubmit="return chk_form();">
				<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%">
					<tr>
						<td width="20%">{{$language.bind}}IP：</td>
						<td width="80%"><input name="bind" value="{{$config.bind}}"/></td>
						
					</tr>
					<tr bgcolor="f7f7f7">
						<td colspan="2">
						MySQL{{$language.Configure}}
						</td>
					</tr>
					<tr>
						<td>MySQL{{$language.Ipaddress}}：</td>
						<td><input name="mysql_host" value="{{$config.mysql_host}}"/></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td>MySQL{{$language.Username}}：</td>
						<td><input name="mysql_user" value="{{$config.mysql_user}}" /></td>
					</tr>
					<tr>
						<td>MySQL{{$language.Password}}：</td>
						<td><input name="mysql_pass" value="{{$config.mysql_pass}}"/></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td>MySQL数据库：</td>
						<td><input name="mysql_data" value="{{$config.mysql_data}}"/></td>
					</tr>
					<tr>
						<td>MySQL Sock：</td>
						<td><input name="mysql_sock" value="{{$config.mysql_sock}}"/></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td colspan="2" align="center"><input name="submit" type="submit"  value="保存{{$language.Configure}}" / class="an_02"></td>
					</tr>
				</table>
			</form>
		</table>
	</td>
  </tr>
</table>


</body>
</html>


