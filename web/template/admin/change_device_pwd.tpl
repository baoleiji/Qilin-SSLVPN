<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	function check_add_user(){
		return(true);
	}
</script>
</head>

<body>

	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="22"><img src="{{$template_root}}/images/main_left.gif" width="22" height="31"></td>
			  <td background="{{$template_root}}/images/main_bg1.gif" class="main_title">更改device密码</td>
			  
			  
			  <td width="2"><img src="{{$template_root}}/images/main_right.gif" width="2" height="31"></td>
			</tr>
		  </table></td>
	  </tr>
	  <tr>
		<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
			<form method="post" name="add_user" action="admin.php?controller=admin_pro&action=change_device_pwd&sid={{$id}}">
				<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%">
				{{if $msg}}
					<tr bgcolor="red">
						<td>提示：</td>
						<td>{{$msg}}</td>
					</tr>
				{{/if}}
					<tr>
						<td>原密码：</td>
						<td><input type="password" name="oldpwd" class="input_shorttext"></td>
					</tr>
					<tr>
						<td>{{$language.Password}}：</td>
						<td><input type="password" name="newpwd" class="input_shorttext"></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td>{{$language.Commitpassword}}：</td>
						<td><input type="password" name="newpwdc" class="input_shorttext"></td>
					</tr>

					<tr>
						<td colspan="2" align="center"><input  type="submit" value="{{$language.Commit}}" class="an_02"></td>
					</tr>
				</table>
				<input type="hidden" name="ac" value="change">
			</form>
			</table>
		</td>
	  </tr>
	</table>
</body>
</html>


