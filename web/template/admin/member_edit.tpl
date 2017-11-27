<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<SCRIPT language=javascript src="./template/admin/calendar.js"></SCRIPT>
<script language="javascript">
	function check_add_user(){
		return(true);
	}
	
</script>
</head>

<body>



<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$language.Edit}}{{$language.User}}信息</td>
  </tr>
  <tr>
	<td class="main_content">
		
			<form method="post" name="add_user" action="admin.php?controller=admin_member&action=save&uid={{$member.uid}}&type=edit" onsubmit="javascript: return check_add_user();">
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
						<td>{{$language.Name}}：</td>
						<td><input type="text" class="wbk" name="realname" class="input_shorttext" value="{{$member.realname}}"></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td>{{$language.Mailbox}}：</td>
						<td><input type="text" class="wbk" name="email" class="input_shorttext" value="{{$member.email}}"></td>
					</tr>

					<tr>
						<td>{{$language.Level}}：</td>
						<td>
						<select  class="wbk"  name="level">
						<option value="0" {{if $member.level == 0}}selected{{/if}}>{{$language.common}}{{$language.User}}</option>
						<option value="1" {{if $member.level == 1}}selected{{/if}}>{{$language.Administrator}}</option>
						</select>
						</td>
					</tr>

					{{if $admin_level == 1}}
					<tr>
						<td width="33%" align=left>
						{{$language.User}}可访问的网段{{$language.group}}		
						</td>
						<td width="67%">
							<select  class="wbk"  name="acgroup">
								<option value="0">n/a</option>
								{{section name=t loop=$acgroup}}
								<option value="{{$acgroup[t].groupname}}" {{if $bindedacgroup == $acgroup[t].groupname}}selected{{/if}}>{{$acgroup[t].groupname}}</option>
								{{/section}}
							</select>
						</td>

					</tr>
					{{/if}}
					{{if $member.level == 0}}
					<tr bgcolor="f7f7f7">
						<td>{{$language.ManageDevice}}:</td>
						<td>
						<select  class="wbk"  name="flist[]" size="8" multiple>
						{{section name=i loop=$flist}}
							<option value="{{$flist[i].fid}}" {{if $flist[i].fid|isin:$member.flist == true}}selected{{/if}}>{{$flist[i].name}}</option>

						{{/section}}
						</select>
						</td>
					</tr>
					{{/if}}


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


