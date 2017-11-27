<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
</head>
<script>
function searchit(){
	document.route.action+='&user='+document.getElementById('user').value;
	document.route.action+='&type='+document.getElementById('type').options[document.getElementById('type').options.selectedIndex].value;
	document.route.submit();
	return false;
}
</script>
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

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>

	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_log&action=adminlog">系统操作</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_log&action=downuploaded">批量导入</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
  <tr>
		<form name='route' action='admin.php?controller=admin_log&action=downuploaded' method='post'>
			<td colspan="3" class="main_content">&nbsp;上传用户：<input type="text" class="wbk" size="20" name="user" id="user" value="" />&nbsp;&nbsp; 类型：
			<select name="type" id="type">
			<option value="">请选择</option>
			<option value="member">用户</option>
			<option value="apppub">应用发布</option>
			<option value="appprogram">应用程序</option>
			<option value="forbiddengps_cmd">命令权限</option>
			<option value="usbkey">动态令牌</option>
			<option value="devices">系统用户</option>
			<option value="resourcegroup">资源组</option>
			<option value="resourcegroup_priority">资源组权限</option>
			<option value="sshkey">公私钥</option>
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>&nbsp;&nbsp;</td>
			
			<input type="hidden" name="ac" value="new" />
		</form>
		</tr>
  <tr>
	<td class="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
                <TBODY>		
		<tr >
			<th class="list_bg" align="center" width="20%"><a href="admin.php?controller=admin_member&action=keys_index&orderby1=keyid&orderby2={{$orderby2}}" >类型</a></td>
			<th class="list_bg" width="40%" align="center"><a href="admin.php?controller=admin_member&action=keys_index&orderby1=username&orderby2={{$orderby2}}" >上传时间</a></td>
			<th class="list_bg" width="20%" align="center"><a href="admin.php?controller=admin_member&action=keys_index&orderby1=type&orderby2={{$orderby2}}" >上传用户</a></td>
			<th class="list_bg" align="center"><b>操作</b></td>
		</tr>		
		{{section name=t loop=$importlog}}
		<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td >{{if $importlog[t].type eq 'member'}}用户{{elseif $importlog[t].type eq 'apppub'}}应用发布{{elseif $importlog[t].type eq 'appprogram'}}应用程序{{elseif $importlog[t].type eq 'forbiddengps_cmd'}}命令权限{{elseif $importlog[t].type eq 'usbkey'}}动态令牌{{elseif $importlog[t].type eq 'devices'}}系统用户{{elseif $importlog[t].type eq 'resourcegroup'}}资源组{{elseif $importlog[t].type eq 'resourcegroup_priority'}}资源组权限{{elseif $importlog[t].type eq 'sshkey'}}公私钥{{/if}}</td>
			<td >{{$importlog[t].uptime}}</td>
			<td>{{$importlog[t].user}}</td>
			<td >			
			<img src="{{$template_root}}/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_log&action=downloadfile&id={{$importlog[t].id}}">下载</a> 
			 | <img src="{{$template_root}}/images/delete_ico.gif" width="16" height="16" hspace="5" border="0" align="absmiddle"><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_log&action=downuploaded&delete=1&id={{$importlog[t].id}}';}">删除</a>
			
			</td>
		</tr>
		{{/section}}
                <tr>
				<td colspan="1"></td>
	           <td  colspan="3" align="right">
		   			共{{$log_num}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_member&action=keys_index&page='+this.value;">页
		   </td>
		</tr>
		
		</TBODY>
              </TABLE>	</td>
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



