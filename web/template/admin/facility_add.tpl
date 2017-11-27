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
			  <td background="{{$template_root}}/images/main_bg1.gif" class="main_title">{{$language.SessionAudit}}——{{$language.SessionsList}}</td>
			  
			  
			  <td width="2"><img src="{{$template_root}}/images/main_right.gif" width="2" height="31"></td>
			</tr>
		  </table></td>
	  </tr>
	  <tr>
		<td class="main_content">
			<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
<form method="post" name="add_user" action="admin.php?controller=admin_facility&action=save&type=add" onsubmit="javascript: return check_add_user();">
				<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
						<td>{{$language.device}}名：</td>
						<td><input type="text" class="wbk" name="name" class="input_shorttext"></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td>{{$language.device}}描述：</td>
						<td><textarea name="describe" cols="40" rows="5"></textarea></td>
					</tr>
					<tr>
						<td>{{$language.device}}{{$language.IPAddress}}：</td>
						<td><input type="text" class="wbk" name="ip" class="input_shorttext"></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td>{{$language.device}}{{$language.manage}}{{$language.port}}：</td>
						<td><input type="text" class="wbk" name="port" class="input_shorttext"></td>
					</tr>
					<tr>
						<td>SNMP{{$language.Authority}}域：</td>
						<td><input type="text" class="wbk" name="community" class="input_shorttext"></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td>{{$language.Yes}}{{$language.No}}使用模板：</td>
						<td>
						<select  class="wbk"  name="use_templet">
							<option value="0">{{$language.No}}</option>
							<option value="1">{{$language.Yes}}</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>{{$language.device}}{{$language.LoginMethod}}</td>
						<td>
						<select  class="wbk"  name="type">
							<option value="1">snmp</option>
							<option value="2">rsync</option>
						</select>
						</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td>{{$language.Username}}：</td>
						<td><input type="text" class="wbk" name="username" class="input_shorttext"></td>
					</tr>
					<tr>
						<td>{{$language.Password}}：</td>
						<td><input type="password" name="password" class="input_shorttext"></td>
					</tr>



					<tr bgcolor="f7f7f7">
						<td colspan="2" align="center"><input type="submit"   value="{{$language.Addanewdevice}}" class="an_02"></td>
					</tr>
				</table>
			</form>
			</table>
		</td>
	  </tr>
	</table>

</body>
</html>


