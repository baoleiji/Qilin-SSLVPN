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
    <td  class="hui_bj">crontab{{$language.Log}}——{{$language.Log}}{{$language.Search}}</td>
  </tr>
  <tr>
	<td class="main_content">
<form method="get" name="session_search" action="admin.php">
				<input name="controller" value="admin_log" type="hidden">
				<input name="action" value="list_crontab" type="hidden">
				<table bordercolor="white" cellspacing="0" cellpadding="0" border="0" width="98%"  class="BBtable">
					<tr>
						<td class="td_line" width="30%">{{$language.Result}}：</td>
						<td class="td_line" width="70%">
						<select  class="wbk"  name="orderby1">
							<option value='id'>{{$language.default}}</option>
							<option value='time'>{{$language.Time}}</option>
							<option value='host'>{{$language.Ipaddress}}</option>
							<option value='cmd'>{{$language.Command}}</option>
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
						<td class="td_line" width="70%">{{$language.Slave}}&nbsp;&nbsp;<input name="id1" type="text" class="wbk">&nbsp;&nbsp;到&nbsp;&nbsp;<input name="id2" type="text" class="wbk"></td>
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
						<td class="td_line" width="30%">{{$language.Time}}：</td>
						<td class="td_line" width="70%">{{$language.Slave}}&nbsp;&nbsp;<input name="time1" type="text" class="wbk">&nbsp;&nbsp;到&nbsp;&nbsp;<input name="time2" type="text" class="wbk">&nbsp;{{$language.Example}}:2007-10-10 13:59:59</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">包含{{$language.Command}}：</td>
						<td class="td_line" width="70%"><input type="text" class="wbk" name="cmd"></td>
					</tr>
					<tr>
						<td class="td_line" colspan="2" align="center"><input name="submit" type="submit"  value="{{$language.Search}}" class="an_02"></td>
					</tr>
				</table>
			</form>
	</td>
  </tr>
</table>



