<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>会话列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">会话管理——会话列表</td>
  </tr>
  <tr>
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
		
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">目的地址</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">登录用户名</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">开始时间</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">结束时间</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">详细信息</th>
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $allsession[t].dangerous > 5}}bgcolor="red"{{elseif $allsession[t].dangerous > 0}}bgcolor="yellow" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						
						<td><a href="admin.php?controller=admin_sqlnet_old&d_addr={{$allsession[t].d_addr}}">{{$allsession[t].d_addr}}</a></td>
						<td><a href="admin.php?controller=admin_sqlnet_old&user={{$allsession[t].user}}">{{$allsession[t].user}}</a></td>
						<td>{{$allsession[t].start}}</ td>
						<td>{{$allsession[t].end}}</td>
						<td><img src="{{$template_root}}/images/ckico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_sqlnet_old&action=view&sid={{$allsession[t]['sid']}}">查看</a>{{if $admin_level == 2}} | <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_sqlnet_old&action=del_session&sid={{$allsession[t]['sid']}}">删除</a>{{/if}}</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="12" align="right">
							共{{$session_num}}条会话  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">页 <!--当前数据表: {{$now_table_name}}--> <a href="{{$curr_url}}&derive=1" target="hide">导出当前结果为Excel</a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1">删除当前结果</a>{{/if}}
						<!--
						<select  class="wbk"  name="table_name">
						{{section name=t loop=$table_list}}
						<option value="{{$table_list[t]}}" {{if $table_list[t] == $now_table_name}}selected{{/if}}>{{$table_list[t]}}</option>
						{{/section}}
						</select>
						-->
						</td>
					</tr>
				</table>
	</td>
  </tr>
</table>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>


