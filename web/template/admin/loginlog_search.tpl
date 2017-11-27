<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.LogList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$language.Loginlog}}——{{$language.Log}}{{$language.Search}}</td>
  </tr>
  <tr>
	<td class="main_content">
<form method="get" name="session_search" action="admin.php">
				<input name="controller" value="admin_reports" type="hidden">
				<input name="action" value="loginacct" type="hidden">
				<table bordercolor="white" cellspacing="0" cellpadding="0" border="0" width="98%"  class="BBtable">
					<tr>
						<td class="td_line" width="30%">{{$language.Result}}：</td>
						<td class="td_line" width="70%">
						<select  class="wbk"  name="orderby1">
							<option value='sid'>{{$language.default}}</option>
							<option value='sourceip'>{{$language.SourceAddress}}</option>
							<option value='serverip'>{{$language.Ipaddress}}</option>
							<option value='systemuser'>系统账号</option>
						</select>
						{{$language.Sort}}
						<select  class="wbk"  name="orderby2">
							<option value='asc'>{{$language.ascendingorder}}</option>
							<option value='desc'>{{$language.decreasingorder}}</option>
						</select>
						</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">ID：</td>
						<td class="td_line" width="70%">{{$language.from}}&nbsp;&nbsp;<input name="id1" type="text" class="wbk">&nbsp;&nbsp;{{$language.to}}&nbsp;&nbsp;<input name="id2" type="text" class="wbk"></td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">{{$language.SourceAddress}}：</td>
						<td class="td_line" width="70%">
							<input name="from" id="from" type="text" class="wbk" /><br />
							<select  class="wbk"  name="fromlist" size="6" style="width:130px" onchange="javascript:document.getElementById('from').value=this.options[this.selectedIndex].text">
								{{section name=t loop=$alldev}}
								<option name="{{$alldev[t].ip}}">{{$alldev[t].ip}}</option>
								{{/section}}
							</select>
						</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">{{$language.Ipaddress}}：</td>
						<td class="td_line" width="70%">
							<input name="host" id="host" type="text" class="wbk" /><br />
							<select  class="wbk"  name="fromlist" size="6" style="width:130px" onchange="javascript:document.getElementById('host').value=this.options[this.selectedIndex].text">
								{{section name=t loop=$alldev}}
								<option name="{{$alldev[t].device_ip}}">{{$alldev[t].device_ip}}</option>
								{{/section}}
							</select>
						</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">登录协议：</td>
						<td class="td_line" width="70%">
						<select  class="wbk"  name="portocol" >
						<option value="">全部</option>
						{{section name=p loop=$allmethod}}
						<option value="{{$allmethod[p].login_method}}" >{{$allmethod[p].login_method}}</option>
						{{/section}}
						</select>
						</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">运维账号：</td>
<td class="td_line" width="70%"><input name="audituser" type="text" class="wbk">	</td>				</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">系统账号：</td>
						<td class="td_line" width="70%"><input type="text" class="wbk" name="systemuser"></td>
					</tr>	
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">状态：</td>
						<td class="td_line" width="70%"><input type="text" class="wbk" name="status"></td>
					</tr>					
					<tr>
						<td class="td_line" colspan="2" align="center"><input name="submit" type="submit"  value="{{$language.Search}}" class="an_02"></td>
					</tr>
				</table>
			</form>
	</td>
  </tr>
</table>



