<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">记账</td>
		            <td width="2"><img src="{{$template_root}}/images/main_right.gif" width="2" height="31"></td>
        </tr>
      </table></td>
  </tr>{{if $type == 0}}
              <tr>
              <td align="left" class="main_content">
	                           <form name="f1" method="post" action="admin.php?controller=admin_index&action=del_account" onsubmit="return check()">
                    <table table border=0 width=100%  cellspacing=0 bgcolor="#FFFFFF" valign=top >
					<tr>
					<td width="26%" align="right"> </td>
					<td width="20%">&nbsp;&nbsp;
					  <input type=text name="date"  size=20>	</td>
					<td width="7%">
					<input type=submit  value="{{$language.Delete}}此{{$language.day}}期之前的记账" onClick="if(my_confirm('{{$language.Delete}}')) {this.submit;}" class="an_02">
					</td>
					<td width="41%">{{$language.day}}期格式为四位年-月-{{$language.day}}:(2008-02-03)</td>
					</tr>
					</table>
					</form>
				</td>
				</tr>
				{{/if}}
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                <TBODY>
			<tr>
				<td bgColor=#e0edf8>{{$language.Username}}</th>
				<td bgColor=#e0edf8>{{$language.Logintime}}</th>
				<td bgColor=#e0edf8>登出{{$language.Time}}</th>
				<td bgColor=#e0edf8>NAS {{$language.IPAddress}}</th>
				<td bgColor=#e0edf8>在线{{$language.Time}}</th>
				<td bgColor=#e0edf8>客户端{{$language.IPAddress}}</th>
			</tr>

            </tr>
			{{section name=acct loop=$allaccount}}	
									<tr bgcolor="#F3F8FC" >
					<td><a href="accounting.php?name={{$allaccount[acct].UserName}}">{{$allaccount[acct].UserName}}</a></td>
					<td>{{$allaccount[acct].AcctStartTime}}</td>
					<td>{{$allaccount[acct].AcctStopTime}}</td>
					<td>{{$allaccount[acct].NASIPAddress}}</td>
					<td>{{$allaccount[acct].AcctSessionTime}}</td>
					<td>{{$allaccount[acct].FramedIPAddress}}</td>
				</tr>
			{{/section}}	

                <tr>
	           <td  colspan="5" align="right">
		   			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_index&action=account&page='+this.value;">{{$language.page}}
		   </td>
		</tr>
		</TBODY>
              </TABLE>	</td>
  </tr>
</table>

<script language="javascript">

function check_date(riqi)
{
  is_date=/^(\d{4})\-(\d{2})\-(\d{2})$/;  
  return is_date.test(riqi);
} 
function check(){
if(check_date(f1.date.value)==false){alert("{{$language.Input}}的{{$language.day}}期格式不正确,正确格式为四位年-月-{{$language.day}}");return false;}

return true;
}

function my_confirm(str){
	if(!confirm("确认要" + str + "？"))
	{
		window.event.returnValue = false;
	}
}


</script>
</body>
</html>


