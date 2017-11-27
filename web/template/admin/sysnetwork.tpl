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
    <td  class="hui_bj">{{$language.SessionAudit}}——{{$language.Session}}{{$language.Search}}</td>
  </tr>
  <tr>
	<td class="main_content">
<form method="get" name="session_search" action="admin.php">
				<table bordercolor="white" cellspacing="0" cellpadding="0" border="0" width="98%"  class="BBtable">
					<!--
					<tr>
						<td class="td_line" width="30%">数据表：</td>
						<td class="td_line" width="70%">
						<select  class="wbk"  name="table_name">
						{{section name=t loop=$table_list}}
						<option value="{{$table_list[t]}}">{{$table_list[t]}}</option>
						{{/section}}
						</select>
						{{$language.Sort}}
						</td>
					</tr>
					-->
					<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
 <td> {{$language.Search}}{{$language.Session}}{{$language.Content}}</td>
						<td>
							telnet/ssh{{$language.Session}}<input type="radio" name="controller" value="admin_session" checked>
							rdp{{$language.Session}}<input type="radio" name="controller" value="admin_rdp" onClick="location.href='admin.php?controller=admin_rdp&action=search'">
							Oracle{{$language.Session}}<input type="radio" name="controller" value="admin_sqlnet" onClick="location.href='admin.php?controller=admin_sqlnet&action=search'">
							Http{{$language.Session}}<input type="radio" name="controller" value="admin_http" onClick="location.href='admin.php?controller=admin_http&action=search'">
							Ftp{{$language.Session}}<input type="radio" name="controller" value="admin_ftp" onClick="location.href='admin.php?controller=admin_ftp&action=search'">
						</td>
					</tr>
					<tr>
						<td class="td_line" width="30%">{{$language.Result}}：</td>
						<td class="td_line" width="70%">
						<select  class="wbk"  name="orderby1">
							<option value='sid'>{{$language.default}}</option>
							<option value='addr'>{{$language.DeviceAddress}}</option>
							<option value='type'>{{$language.Sessiontype}}</option>
							<option value='user'>{{$language.Username}}</option>
							<option value='start'>{{$language.Session}}{{$language.StartTime}}</option>
							<option value='end'>{{$language.Session}}{{$language.EndTime}}</option>
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
						<td class="td_line" width="70%">{{$language.Slave}}&nbsp;&nbsp;<input name="sid1" type="text" class="wbk">&nbsp;&nbsp;到&nbsp;&nbsp;<input name="sid2" type="text" class="wbk"></td>
					</tr>
					{{if $admin_level == 1}}
					<tr>
						<td class="td_line" width="30%">{{$language.Username}}：</td>
						<td class="td_line" width="70%"><input name="user" type="text" class="wbk"></td>
					</tr>
					{{/if}}
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">{{$language.DeviceAddress}}：</td>
						<td class="td_line" width="70%">
							<input name="addr" id="addr" type="text" class="wbk" /><br />
							<select  class="wbk"  name="fromlist" size="6" style="width:130px" onchange="javascript:document.getElementById('addr').value=this.options[this.selectedIndex].text">
								{{section name=t loop=$alldev}}
								<option name="{{$alldev[t].ip}}">{{$alldev[t].ip}}</option>
								{{/section}}
							</select>
						</td>
					</tr>
					<tr>
						<td class="td_line" width="30%">{{$language.Sessiontype}}：</td>
						<td class="td_line" width="70%">
						<select  class="wbk"  name="type">
							<option value='all'>{{$language.All}}</option>
							<option value='ssh'>ssh</option>
							<option value='telnet'>telnet</option>
						</select>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">{{$language.StartTime}}：</td>
						<td class="td_line" width="70%">{{$language.Slave}}&nbsp;&nbsp;<input name="start1" type="text" class="wbk">&nbsp;&nbsp;到&nbsp;&nbsp;<input name="start2" type="text" class="wbk">&nbsp;{{$language.Example}}:2007-10-10 13:59:59</td>
					</tr>
					<tr>
						<td class="td_line" width="30%">{{$language.EndTime}}：</td>
						<td class="td_line" width="70%">{{$language.Slave}}&nbsp;&nbsp;<input name="end1" type="text" class="wbk">&nbsp;&nbsp;到&nbsp;&nbsp;<input name="end2" type="text" class="wbk">&nbsp;{{$language.Example}}:2007-10-10 13:59:59</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">{{$language.Historycommands}}：</td>
						<td class="td_line" width="70%"><input type="text" class="wbk" name="command"></td>
					</tr>
					<tr>
						<td class="td_line" colspan="2" align="center"><input name="submit" type="submit"  value="{{$language.Search}}" class="an_02"></td>
					</tr>
				</table>
			</form>
	</td>
  </tr>
</table>



