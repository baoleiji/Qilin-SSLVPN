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
<style type="text/css">
a {
    color: #003499;
    text-decoration: none;
} 
a:hover {
    color: #000000;
    text-decoration: underline;
}
</style>
<body>

	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="">
			<form method="post" name="add_user" action="admin.php?controller=admin_member&action=save_self" enctype="multipart/form-data">
			 <input type="password" style="display:none"/> 	<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
<tr><th colspan="3" class="list_bg"></th></tr>
				{{if $msg}}
					<tr bgcolor="red">
						<td>提示：</td>
						<td>{{$msg}}</td>
					</tr>
				{{/if}}
					<tr bgcolor="f7f7f7">
						<td align="right" width="33%">原密码：</td>
						<td><input type="password" name="oripassword" class="input_shorttext"> {{$pwdshould}}</td>
					</tr>
					<tr>
						<td align="right" width="33%">{{$language.Password}}：</td>
						<td><input type="password" name="password1" class="input_shorttext"></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td align="right" width="33%">{{$language.Commitpassword}}：</td>
						<td><input type="password" name="password2" class="input_shorttext"></td>
					</tr>
					<tr>
						<td align="right" width="33%">{{$language.Mailbox}}：</td>
						<td><input type="text" name="email" class="input_shorttext" value="{{$member.email}}"></td>
					</tr>
					<tr>
						<td align="right" width="33%">密码有效期：</td>
						<td>{{$pwdremain}}</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td align="right" width="33%">登录提示：</td>
						<td><input type="checkbox" name="login_tip" value="1" {{if $member.login_tip}}checked{{/if}}></td>
					</tr>
					
                </TR>
				
				<tr bgcolor="f7f7f7">
						<td align="right" width="33%">客户端IP</td>
						<td>{{$member.websourceip}}
						</td>
					</tr>
					<tr >
						<td  align="center" colspan=2><input  type="submit" value="{{$language.Commit}}" class="an_02"></td>
					</tr>
				</table>
			</form>
			
		</td>
	  </tr>
	</table>
</body>
</html>


