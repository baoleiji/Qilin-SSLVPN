<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

</head>

<body>



<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$language.device}}</td>
  </tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
		<form name="f1" method=post OnSubmit='return check();' action="admin.php?controller=admin_auto&action=user_save&id={{$id}}">


	<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		远程{{$language.Username}}		
		</td>
		<td width="67%">
		<input type=text name="remoteuser" size=10 value="{{$aluser.remoteuser}}" >
	  </td>
	</tr>
	<tr>
		<td width="33%" align=left>
		{{$language.Password}}		
		</td>
		<td width="67%">
		<input type=password name="password" size=10 value="{{$aluser.password}}" >
	  </td>
	 </tr>
	 <tr>
		<td width="33%" align=left>
		{{$language.Commitpassword}}		
		</td>
		<td width="67%">
		<input type=password name="password1" size=10 value="{{$aluser.password}}" >
	  </td>
	  </tr>
		<tr>
			<td colspan="2" align="center"><input type="submit"  value="{{$language.Save}}" class="an_02"></td>
		</tr>

	</table>
</form>

		</table>
	</td>
  </tr>
</table>


<script language="javascript">
<!--
function check()
{
   if(f1.password.value!=f1.password1.value) {
	alert('两次{{$language.Password}}不一致');
	return false;
   }

   return true;

}//end check
// -->

function checkIP(ip)
{
	var ips = ip.split('.');
	if(ips.length==4 && ips[0]>=0 && ips[0]<256 && ips[1]>=0 && ips[1]<256 && ips[2]>=0 && ips[2]<256 && ips[3]>=0 && ips[3]<256)
		return ture;
	else
		return false;
}

function checknum(num)
{

	if( isDigit(num) && num > 0 && num < 65535)
		return ture;
	else
		return false;

}

function isDigit(s)
{
var patrn=/^[0-9]{1,20}$/;
if (!patrn.exec(s)) return false;
return true;
}

</script>
</body>
</html>


