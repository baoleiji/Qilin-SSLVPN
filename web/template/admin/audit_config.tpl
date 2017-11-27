<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>来源地址配置</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="22"><img src="{{$template_root}}/images/main_left.gif" width="22" height="31"></td>
		<td background="{{$template_root}}/images/main_bg1.gif" class="main_title">来源地址</td>
		
		
		<td width="2"><img src="{{$template_root}}/images/main_right.gif" width="2" height="31"></td>
	  </tr>
	</table></td>
	</tr>
	<tr>
	<td class="main_content">说明：更改来源地址, 要删除条目请留空 </td>
	</tr>
	</table>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">程序配置——更改配置</td>
  </tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
<tr>
						<th class="list_bg"  bgcolor="d9ecfa" >开源地址</th>
					</tr>
					<form name="news_add" method="post" action="admin.php?controller=admin_config&action=audit_save">
					{{section name=t loop=$config}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><input name="start[]" type="text" value="{{$config[t]}}" /></td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="2" align="center">
							<input name="submit" type="submit"   value="保存配置" />
						</td>
					</tr>
					</form>
					<form name="news_add" method="post" action="admin.php?controller=admin_config&action=audit_add">
					<tr>
						<th class="list_bg" >来源地址</th>
					</tr>
					<tr>
						<td><input name="new_ip" type="text" value=""></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<input name="submit" type="submit"  value="新增来源地址" />
						</td>
					</tr>
					</form>
		</table>
	</td>
  </tr>
</table>

</body>
</html>



