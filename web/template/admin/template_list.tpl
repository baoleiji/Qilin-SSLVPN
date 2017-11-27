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
    <td  class="hui_bj">命令管理——详细信息</td>
  </tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
			<tr>
				<th class="list_bg"  width="55%">模板名称</th>
				<th class="list_bg"  width="10%">操作</th>
			</tr>
			{{section name=t loop=$template}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td>{{$template[t].name}}</td>
				<td><img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_compare&action=template_del&id={{$template[t].id}}">删除</a> | <img src="{{$template_root}}/images/ico2.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_compare&action=file_list&tid={{$template[t].id}}&ttype=temp">查看详细信息</a></td>
			</tr>
			{{/section}}
			<tr>
				<td colspan="4" align="left">
					共{{$command_num}}执行命令  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}条日志/页  转到第<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_session&action=dangerlist&page='+this.value;">页
				</td>
			</tr>
			<tr valign="baseline">
				<td align="right"><b>创建新模板</b></td>
				<td colspan="3">
						<form action="admin.php?controller=admin_compare&action=template_add" name="f" method="post">
						模板名 <input type="text" name="name" size="50">
						  从模板复制  <select  class="wbk"  name="tempid">
							<option value="0">不复制</option>
							{{section name=t loop=$template}}
								<option value="{{$template[t].id}}" >{{$template[t].name}}</option>
							{{/section}}
							</select>
						<input type="submit"  value="创建">
						</form>
				</td>
			</tr>
		</table>
	</td>
  </tr>
</table>


</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



