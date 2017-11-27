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
    <td  class="hui_bj">{{$language.Edit}}{{$language.System}}{{$language.User}}{{$language.Password}}</td>
  </tr>
  <tr>
	<td class="main_content">
		
			<form method="post" name="add_user" action="admin.php?controller=admin_passwd&action=save&uid={{$member.uid}}&type=edit" onsubmit="javascript: return check_add_user();">
				<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
						<td>{{$language.Password}}：</td>
						<td><input type="password" name="password1" class="input_shorttext"></td>
					</tr>
					<tr bgcolor="f7f7f7"> 
						<td>{{$language.Commitpassword}}：</td>
						<td><input type="password" name="password2" class="input_shorttext"></td>
					</tr>

					<tr>
						<td colspan="2" align="center"><input type="submit"   value="{{$language.Commit}}" class="an_02"></td>
					</tr>
				</table>
			</form>
		</table>
	</td>
  </tr>
</table>

</body>
</html>


