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
    <td  class="hui_bj">{{$language.SessionAudit}}</td>
  </tr>
  <tr>
    <td class="main_content">{{$language.Man}}：{{$language.Search}}{{$language.Session}},留空表示{{$language.no}}限制 </td>
  </tr>
</table>

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
						<table><tr >
						
							<td width="100">
							<input type="radio" name="controller" value="admin_sqlnet" onClick="location.href='admin.php?controller=admin_sqlnet&action=search'">Oracle{{$language.Session}}
							</td>
							<td width="100">
							<input type="radio" name="controller" value="admin_sybase" onClick="location.href='admin.php?controller=admin_sybase&action=search' ">Sybase{{$language.Session}}
							</td></tr><tr>
							<td width="100">
							<input type="radio" name="controller" value="admin_mysql" onClick="location.href='admin.php?controller=admin_mysql&action=search'">Mysql{{$language.Session}}
							</td><td width="100">
							<input type="radio" name="controller" value="admin_db2"   checked>DB2{{$language.Session}}
							</td></tr></table>
						</td>
					</tr>
					<tr>
						<td class="td_line" width="30%">{{$language.Result}}：</td>
						<td class="td_line" width="70%">
						<select  class="wbk"  name="orderby1">
							<option value='sid'>{{$language.default}}</option>
							<option value='s_addr'>{{$language.SourceAddress}}</option>
							<option value='d_addr'>{{$language.DestinationAddress}}</option>
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
						<td class="td_line" width="70%">{{$language.from}}&nbsp;&nbsp;<input name="sid1" type="text" class="wbk">&nbsp;&nbsp;{{$language.to}}&nbsp;&nbsp;<input name="sid2" type="text" class="wbk"></td>
					</tr>
					{{if $admin_level == 1}}
					<tr>
						<td class="td_line" width="30%">{{$language.Username}}：</td>
						<td class="td_line" width="70%"><input name="user" type="text" class="wbk"></td>
					</tr>
					{{/if}}
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">{{$language.SourceAddress}}：</td>
						<td class="td_line" width="70%">
							<input name="s_addr" type="text" class="wbk" /><br />
						</td>
					</tr>
					<tr>
						<td class="td_line" width="30%">{{$language.DestinationAddress}}：</td>
						<td class="td_line" width="70%">
							<input name="d_addr" type="text" class="wbk" />{{$language.PleaseinputcorrectAddress}}<br />
						</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">{{$language.StartTime}}：</td>
						<td class="td_line" width="70%">{{$language.from}}&nbsp;&nbsp;<input name="start1" type="text" class="wbk">&nbsp;&nbsp;{{$language.to}}&nbsp;&nbsp;<input name="start2" type="text" class="wbk">&nbsp;{{$language.Example}}:2007-10-10 13:59:59</td>
					</tr>
					<tr>
						<td class="td_line" width="30%">{{$language.EndTime}}：</td>
						<td class="td_line" width="70%">{{$language.from}}&nbsp;&nbsp;<input name="end1" type="text" class="wbk">&nbsp;&nbsp;{{$language.to}}&nbsp;&nbsp;<input name="end2" type="text" class="wbk">&nbsp;{{$language.Example}}:2007-10-10 13:59:59</td>
					</tr>
					<tr bgcolor="f7f7f7">
						<td class="td_line" width="30%">{{$language.Historycommands}}：</td>
						<td class="td_line" width="70%"><input type="text" class="wbk" name="command"></td>
					</tr>
					
					<tr>
						<td class="td_line" colspan="2" align="center"><input name="submit" type="submit"  value="{{$language.Search}}" onclick="setScroll();" class="an_02"></td>
					</tr>
				</table>
			</form>
	</td>
  </tr>
</table>


<script>
function setScroll(){
	window.parent.scrollTo(0,0);
}
</script>

