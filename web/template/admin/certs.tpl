<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>主页面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
</head>

<body>



<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
		<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=certificate_save">
<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="" onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'');"><td>是否开启证书认证:</td>
		<td align=left>
		<select name="Certificate" id="Certificate" >
		<option value="0" {{if $Certificate eq 0}}selected{{/if}}>否</option>
		<option value="2" {{if $Certificate eq 2}}selected{{/if}}>是</option>
		</select>
		 </td>
		<td><input type="submit" onclick="return certificate();" class="an_02" value="保存修改"></td>
		
	</tr>
	</form>
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=loadbalance">
	
<tr>
				<th class="list_bg"  width="20%">IP／域名</th>
				<th class="list_bg"  width="20%"><a href="admin.php?controller=admin_config&action=loadbalance&orderby1=ip&orderby2={{$orderby2}}" >类型</a></th>
				<th class="list_bg"  width="15%">操作</th>
			</tr>
			
			{{section name=t loop=$ip}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td>{{$ip[t]}}</td>
				<td>IP地址</td>
				<td>
				<img src="{{$template_root}}/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_config&action=certs_edit&ip={{$ip[t]|urlencode}}">编辑</a>
				 | <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_config&action=certs_del&ip={{$ip[t]|urlencode}}">删除</a>
				</td>
			</tr>
			{{/section}}

			{{section name=m loop=$dns}}
			<tr {{if $smarty.section.m.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td>{{$dns[m]}}</td>
				<td>主机名</td>
				<td>
				<img src="{{$template_root}}/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_config&action=certs_edit&dns={{$dns[m]|urlencode}}">编辑</a>
				 | <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_config&action=certs_del&dns={{$dns[m]|urlencode}}">删除</a>
				</td>
			</tr>
			{{/section}}
			
			<tr>
				<td colspan="2" align="center">
					<input type="button" onclick="window.location='admin.php?controller=admin_config&action=certs_edit'"  name="add" value="添&nbsp;&nbsp;加" class="an_02">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="document.getElementById('hide').src='admin.php?controller=admin_config&action=keyedit'"  name="add" value="服务器证书签名" class="an_06">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="if(confirm('{{if $Certificate}}证书重置会复位删除所有用户证书，必须关闭证书认证后才能继续{{else}}证书重置会复位删除所有用户证书，并且重新生成根证书{{/if}}')) document.getElementById('hide').src='admin.php?controller=admin_config&action=certsreset';"  name="add" value="证书重置" class="an_02">
						
				</td><input type="hidden" name="ac" value="delete" />
			</form>
			<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_config&action=loadbalance">

				<td colspan="2" align="right">
					共{{$command_num}}执行命令  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_config&action=loadbalance&page='+this.value;">页
				
				</td>
				</form>
			
			</tr>
			
			

		</table>
	</td>
  </tr>
</table>

<iframe name="hide" id="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>



