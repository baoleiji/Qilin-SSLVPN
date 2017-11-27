{{include file="include/header.tpl"}}
<table border="0" cellpadding="0" cellpadding="0" bordercolor="#FFFFFF">
<tr>
<td bgcolor="#EEEEEE" rowspan="2">
<form name="news_add" method="post" action="admin.php?controller=admin_config&action=save"onsubmit="return chk_form();">
<table width="90%" align="center">
					<tr>
						<td style="width:50%" align="right">MySQL服务器地址：</td>
						<td><input type="text" name="host" value="{{$xml->MySQL->Host}}"></td>
					</tr>
					<tr>
						<td align="right">MySQL用户名：</td>
						<td><input type="text" name="username" value="{{$xml->MySQL->Username}}"></td>
					</tr>
					<tr>
						<td align="right">MySQL密码：</td>
						<td><input type="text" name="password" value="{{$xml->MySQL->Password}}"></td>
					</tr>
					<tr>
						<td align="right">MySQL数据库：</td>
						<td><input type="text" name="database" value="{{$xml->MySQL->Database}}"></td>
					</tr>
					<tr>
						<td align="right">MySQL Sock：</td>
						<td><input type="text" name="sock" value="{{$xml->MySQL->Sock}}"></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<input name="submit" type="submit" value="保存配置" />
						</td>
					</tr>
</table>
</form>
</td></tr>
</table>
{{include file="include/footer.tpl"}}
