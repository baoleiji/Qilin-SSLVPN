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
    <td  class="hui_bj">{{$language.CommandsManager}}——{{$language.Detail}}</td>
  </tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
			<tr>
				<th class="list_bg"  width="10%">RUSER</th>
				<th class="list_bg"  width="10%">PID</th>
				<th class="list_bg"  width="55%">CMD</th>
				<th class="list_bg"  width="10%">{{$language.Operate}}</th>
			</tr>
			{{section name=t loop=$allsession}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td>{{$allsession[t].ruser}}</td>
				<td>{{$allsession[t].pid}}</td>
				<td>{{$allsession[t].cmd}}</td>
				<td><img src="{{$template_root}}/images/ico2.gif" width="16" height="16" align="absmiddle"><a href="#" onClick ="window.open('admin.php?controller=admin_session&action=monitor&pid={{$allsession[t].pid}}','','menubar=no,toolbar=no,resizable=yes,height=700,width=700')">监控</a></td>
			</tr>
			{{/section}}
			<tr>
				<td colspan="4" align="left">
					{{$language.all}}{{$command_num}}{{$language.item}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_session&action=running_list&page='+this.value;">{{$language.page}}
				</td>
			</tr>
		</table>
	</td>
  </tr>
</table>


</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


