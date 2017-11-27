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
    <td  class="hui_bj">{{$language.SessionAudit}}——{{$language.Detail}}</td>
  </tr>
  <tr>
	<td align="right"><span class="back_img"><A href="admin.php?controller=admin_sqlnet&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span></td>
  </tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
			<tr>
				<th class="list_bg"  width="10%">{{$language.ExcuteTime}}</th>
				<th class="list_bg"  width="15%">{{$language.Command}}</th>				
				<th class="list_bg"   width="8%">命令字节数</th>
				<th class="list_bg"   width="8%">结果字节数</th>
				<th class="list_bg"   width="7%">响应时间</th>
				<th class="list_bg"   width="7%">返回代码</th>
				<th class="list_bg"  width="5%">{{$language.Operate}}</th>
			</tr>
			{{section name=t loop=$allcommand}}
			<tr {{if $allcommand[t].dangerlevel > 5}}bgcolor="red"{{elseif $allcommand[t].dangerlevel > 0}}bgcolor="yellow" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>

				<td>{{$allcommand[t].at}}</ td>
				<td>{{$allcommand[t].cmd}}</td>
				<td>{{$allcommand[t].cmd_bytes}}</td>
				<td>{{$allcommand[t].result_bytes}}</td>
				<td>{{$allcommand[t].return_time}}</td>
				<td>{{$allcommand[t].return_code}}</td>
{{*				<td><a href="admin.php?controller=admin_sqlnet&action=download&sid={{$allcommand[t]['sid']}}")>{{$language.Download}}</a></td>*}}
			</tr>
			{{/section}}
			<tr>
				<td colspan="12" align="right">
					{{$language.all}}{{$command_num}}{{$language.Command}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.item}}{{$language.Log}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_sqlnet&action=view&page='+this.value;">{{$language.page}}  
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


</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


