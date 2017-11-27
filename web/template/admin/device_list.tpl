<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>监控设备列表</title>
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
				<th class="list_bg"  width="10%">连接类型</th>
				<th class="list_bg"  width="10%">设备类型</th>
				<th class="list_bg"  width="10%">设备IP</th>
				<th class="list_bg"  width="8%">端口</th>
				<th class="list_bg"  width="10%">用户名</th>
				<th class="list_bg"  width="30%">操作</th>
			</tr>
			{{section name=t loop=$alldevice}}
			<tr {{if $alldevice[t].diff == 1}}bgcolor="red"{{/if}} {{if $alldevice[t].diff == 2}}bgcolor="yellow"{{/if}}>
				<td>{{$alldevice[t].conn_type}}</td>
				<td>{{$alldevice[t].dev_type}}</ td>
				<td>{{$alldevice[t].ip}}</ td>
				<td>{{$alldevice[t].port}}</ td>
				<td>{{$alldevice[t].user_username}}</ td>
				<td>{{if $alldevice[t].dev_type == 'linux'}}<a href="admin.php?controller=admin_compare&action=file_list&tid={{$alldevice[t].id}}&ttype=sub">修改监控文件</a> | {{/if}}<a href="admin.php?controller=admin_compare&action=cover&id={{$alldevice[t].id}}">更新基准</a> | <a href="admin.php?controller=admin_compare&action=compare&id={{$alldevice[t].id}}" target="_blank">查看监控结果</a> | <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="#" onClick="if(!confirm('您确定要删除设备？')) {return false;} else { location.href='admin.php?controller=admin_compare&action=device_del&id={{$alldevice[t].id}}'; }" >删除</a> | <img src="{{$template_root}}/images/ckico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_compare&action=device_add&type=old&id={{$alldevice[t].id}}">修改</a></td>
			</tr>
			{{/section}}
			<tr>
				<td colspan="7" align="left">
					共{{$command_num}}执行命令  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}条日志/页  转到第<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_session&action=dangerlist&page='+this.value;">页
				</td>
			</tr>
		</table>
	</td>
  </tr>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



