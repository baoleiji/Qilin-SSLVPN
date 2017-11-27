   <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>{{$title}}</TITLE><LINK rel=stylesheet type=text/css 
href="{{$template_root}}/images/content.css">
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18372"></HEAD>
<BODY>
<CENTER><BR><BR>
  <table width="95%" border="0" cellpadding="1" cellspacing="1" bgcolor="3c84cc">
    <tr>
      <td class="td_bg"><TABLE border=0 cellSpacing=0 cellPadding=2 width="100%">
        <TBODY>
          <TR vAlign=top align=right>
            <TD class=td_title height=25 width="35%" align=left>{{$title}} </TD>
            </TR>
        </TBODY>
      </TABLE>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_pro&action=dev_save&ntype={{$ntype}}&id={{$id}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.IPAddress}}		
		</td>
		<td width="67%">
		<input type=text name="IP" size=35 value="{{$IP}}" >
	  </td>
	</tr>
		<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.port}}	
		</td>
		<td width="67%">
		<input type=text name="port" size=4 value="{{$port}}" >
	  </td>
	</tr>
		</tr>
		<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.Loginmode}}	
		</td>
		<td width="67%">
				<select  class="wbk"  name="t_id">
		{{section name=g loop=$alltem}}
			<OPTION VALUE="{{$alltem[g].id}}" {{if $alltem[g].id == $t_id}}selected{{/if}}>{{$alltem[g].device_type}}/{{$alltem[g].login_method}}</option>
		{{/section}}
		</select>
	  </td>
	</tr>
		<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.Username}}
		</td>
		<td width="67%">
		<input type=text name="username" size=35 value="{{$username}}" >
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		原始{{$language.Password}}
		</td>
		<td width="67%">
		<input type=text name="password" size=35 value="{{$password}}" >
	  </td>
	</tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		邮箱
		</td>
		<td width="67%">
		<input type=text name="email" size=35 value="{{$email}}" >
	  </td>
	</tr>
	</table>
<br>
<input type=submit class=button value="{{$language.Save}}">

</form>
<script language="javascript">
<!--
function check()
{
   if (!checkIP(f1.equipname.value))
   {
	alert("{{$language.device}}名应为合法的{{$language.IPAddress}}");
	f1.equipname.focus();
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

	if( isDigit(num) && num > 0 && num < 257)
		return ture;
	else
		return false;

}

function isDigit(s)
{
var patrn=/^[0-9]{1,20}$/;
if (!patrn.exec(s)) return false
return true
}

</script>

</td>
          </tr>
        </table></td>
    </tr>
  </table>
</body>

</html>



