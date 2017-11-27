<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$language.LogManager}}——{{$language.LogList}}</td>
  </tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
						<th class="list_bg"  bgcolor="d9ecfa" width="20%">{{$language.Ipaddress}}</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="15%">{{$language.ExcuteTime}}</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="60%">{{$language.Command}}行</th>
					</tr>
					{{section name=t loop=$alllog}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><a href="admin.php?controller=admin_log&action=list_crontab&host={{$alllog[t].host}}">{{$alllog[t].host}}</a></td>
						<td>{{$alllog[t].time}}</td>
						<td>{{$alllog[t].cmd}}</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="12" align="right">
							{{$language.all}}{{$log_num}}{{$language.item}}{{$language.Log}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">{{$language.page}} <a href="{{$curr_url}}&derive=1" target="hide">{{$language.ExcelExporttoExcel}}Excel</a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1">{{$language.Deleteresults}}</a>{{/if}}
						</td>
					</tr>
				</table>
	</td>
  </tr>
</table>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>


