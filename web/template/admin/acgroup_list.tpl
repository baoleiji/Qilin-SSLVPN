<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>自动登陆网段列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">网段管理——详细信息</td>
  </tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
			<tr>
				<th class="list_bg"  width="10%">组名</th>

				{{*
				<th class="list_bg"  width="10%">地址</th>
				<th class="list_bg"  width="10%">子网掩码</th>
				*}}

				{{if $admin_level == 1}}<th class="list_bg"  width="20%">操作</th>{{/if}}
			</tr>
			{{section name=t loop=$alluser}}
			{{if $groupname == $alluser[t].groupname || $admin_level == 1}} 
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			
				<td><a href="admin.php?controller=admin_ccontrol&action=net_detail&groupname={{$alluser[t].groupname}}">{{$alluser[t].groupname}}</a></td>
				{{*
					<td>{{$alluser[t].ip}}</td>
					<td>{{$alluser[t].netmask}}</td>
				*}}
				{{if $admin_level == 1}}<td><a href="admin.php?controller=admin_ccontrol&action=net_edit&type=new&groupname={{$alluser[t].groupname}}">增加</a> | <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_ccontrol&action=net_del&id={{$alluser[t].id}}&type=group'; }" >删除</a> {{* |<img src="{{$template_root}}/images/ckico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_ccontrol&action=net_edit&type=old&id={{$alluser[t].id}}">修改</a>*}}</td>{{/if}}
			</tr>
			{{/if}}
			{{/section}}
			<tr>
				<td colspan="4" align="left">
					共{{$row_num}}条  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}条日志/页  转到第<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_ccontrol&action=net_index&page='+this.value;">页
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



