<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>会话列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<style type="text/css">
a {
    color: #003499;
    text-decoration: none;
} 
a:hover {
    color: #000000;
    text-decoration: underline;
}
</style>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_apppub">应用发布</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_http">Http/Https</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_mail">SMTP</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>


 
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
					<tr>
						<th class="list_bg"   width="10%">发送者</th>
						<th class="list_bg"   width="5%">接收方</th>
						<th class="list_bg"   width="10%">主题</th>
						<th class="list_bg"   width="10%">时间</th>
						<th class="list_bg" width="5%">源IP</th>
						<th class="list_bg" width="5%">目标IP</th>
						<th class="list_bg" width="5%">源MAC</th>
						<th class="list_bg" width="5%">目标MAC</th>
						<th class="list_bg"   width="10%">操作</th>
						
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $allsession[t].dangerous > 1}}bgcolor="red"{{elseif $allsession[t].dangerous > 0}}bgcolor="yellow" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					
						<td>{{$allsession[t].from}}</ td>
						<td>{{$allsession[t].to}}</ td>
						<td>{{$allsession[t].subject}}</td>
						<td>{{$allsession[t].start}}</td>
						<td>{{$allsession[t].s_addr}}</td>
						<td>{{$allsession[t].d_addr}}</td>
						<td>{{$allsession[t].SMAC}}</td>
						<td>{{$allsession[t].DMAC}}</td>
						<td> {{if $admin_level == 2}}<img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_mail&action=del_session&sid={{$allsession[t]['sid']}}">删除</a>{{/if}}</td>
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



