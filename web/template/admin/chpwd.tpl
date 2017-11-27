<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>路由列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">设备管理——密码修改</td>
  </tr>
  <tr>
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
		<tr bgcolor="#F3F8FC">
			<th class="list_bg"  width="3%" align="center" bgcolor="#E0EDF8"><b><a href="admin.php?controller=admin_index&action=chpwd&orderby1=id&orderby2={{$orderby2}}" >ID</a></b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b><a href="admin.php?controller=admin_index&action=chpwd&orderby1=hostname&orderby2={{$orderby2}}" >主机名</a></b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b><a href="admin.php?controller=admin_index&action=chpwd&orderby1=device_ip&orderby2={{$orderby2}}" >服务器IP</a></b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b><a href="admin.php?controller=admin_index&action=chpwd&orderby1=login_method&orderby2={{$orderby2}}" >服务</a></b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b><a href="admin.php?controller=admin_index&action=chpwd&orderby1=username&orderby2={{$orderby2}}" >账号</a></b></th>
			<th class="list_bg"  width="15%" align="center" bgcolor="#E0EDF8"><b><a href="admin.php?controller=admin_index&action=chpwd&orderby1=last_update_time&orderby2={{$orderby2}}" >改密时间</a></b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>原密码</b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>新密码</b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>确定</b></th>
		</tr>		
		<form name='route' action='admin.php?controller=admin_index&action=chpwd_save' method='post'>
		{{section name=t loop=$alldev}}
		
		<tr>
			<td width="3%" class="td_line">{{$alldev[t].id}}</td>
			<td width="10%" class="td_line">{{$alldev[t].hostname}}</td>
			<td width="10%" class="td_line">{{$alldev[t].device_ip}}:{{$alldev[t].port}}</td>
			<td width="10%" class="td_line">{{$alldev[t].login_method}}</td>
			<td width="10%" class="td_line">{{$alldev[t].username}}</td>
			<td width="10%" class="td_line">{{$alldev[t].last_update_time}}</td>
			<td class="td_line"><input type="text" class="wbk" name="old_password[]" value="" /></td>
			<td class="td_line" ><input type="text" class="wbk" name="new_password[]" value="" /></td>
			<td class="td_line"  width="10%" align="center"><input type='submit' name="modify" onclick="document.route.action='admin.php?controller=admin_index&action=chpwd_save&selected_id={{$smarty.section.t.index}}&single=1';return true;" value='修改' class="an_02"></td>
		</tr>
		<input type="hidden" name="id[]" value="{{$alldev[t].id}}" />
		
		{{/section}}
		 <tr>
			<td colspan="9" align="right" ><input type='submit'  name="modify" onclick="document.route.action='admin.php?controller=admin_index&action=chpwd_save'; return true;" value='编辑' class="an_02"></td>
		  </tr>
		   <tr>
	           <td  colspan="9">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_index&page='+this.value;">页
		   </td>
		</tr>
		</form>

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



