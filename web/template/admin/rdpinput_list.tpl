<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>会话列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" /><script>

function changeStyle(obj,c)
{
	if(c!='o'){
		obj.style.backgroundColor=c;
	}else{
		obj.style.backgroundColor="#FFCC80";
	}
}
</script>
</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">会话管理——会话列表</td>
  </tr>
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">操作时间</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">内容</th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%">操作</th>
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $allsession[t].dangerous > 1}}bgcolor="red"{{elseif $allsession[t].dangerous > 0}}bgcolor="yellow" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}} onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'{{if $allsession[t].dangerous > 1}}red{{elseif $allsession[t].dangerous > 0}}yellow{{elseif $smarty.section.t.index % 2 == 0}}f7f7f7{{/if}}');">
						<td>{{$allsession[t].at}}</ td>
						<td>{{$allsession[t].cmd}}</td>
						<td>
						<img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_rdp&action=del_input&action=del_input&sid={{$allsession[t]['sid']}}&cid={{$allsession[t].cid}}">删除</a>
						</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="12" align="right">
							共{{$session_num}}条会话  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">页 <!--当前数据表: {{$now_table_name}}--> <a href="admin.php?controller=admin_rdp&action=del_input&action=del_input&sid={{$allsession[t]['sid']}}&derive=1" target="hide">导出当前结果为Excel</a> {{if $admin_level == 1}}<a href="admin.php?controller=admin_rdp&action=del_input&action=del_input&sid={{$allsession[t]['sid']}}&delete=1">删除当前结果</a>{{/if}}
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
<iframe id="hide" name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>



