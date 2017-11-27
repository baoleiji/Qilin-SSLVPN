<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$site_title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script>
function resto()
{
 if(document.getElementById('filesql').value=='' ){
   alert("{{$language.UploadFile}}");
   return false;
  }
  return true;
}
</script>
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
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=serverstatus">服务状态</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=latest">系统状态</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup">配置备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting">数据同步</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=upgrade">软件升级</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=cronjob">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=changelogo">图标上传</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=notice">系统通知</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>


  
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
		<tr>
				<th class="list_bg"  width="12%">服务名</th>
				<th class="list_bg" >上传</th>
			</tr>
			<form name="backup" enctype="multipart/form-data" action="admin.php?controller=admin_eth&action=upgradeServerStatusSave" method="post">	
			{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td>telnet</td>
			<td><input name="file" id="" type="file" />&nbsp;&nbsp;&nbsp;&nbsp;<input name="submit" type="submit" value="提交" class="an_02" /></td>
			</tr>
			<input type="hidden" name="stype" value="telnet" />
			</form>
			<form name="backup" enctype="multipart/form-data" action="admin.php?controller=admin_eth&action=upgradeServerStatusSave" method="post">	
			{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td>ssh</td>
			<td><input name="file" id="" type="file" />&nbsp;&nbsp;&nbsp;&nbsp;<input name="submit" type="submit" value="提交" class="an_02" /></td>
			</tr>
			<input type="hidden" name="stype" value="ssh" />
			</form>
			<form name="backup" enctype="multipart/form-data" action="admin.php?controller=admin_eth&action=upgradeServerStatusSave" method="post">	
			{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td>rdp</td>
			<td><input name="file" id="" type="file" />&nbsp;&nbsp;&nbsp;&nbsp;<input name="submit" type="submit" value="提交" class="an_02" /></td>
			</tr>
			<input type="hidden" name="stype" value="rdp" />
			</form>
			<form name="backup" enctype="multipart/form-data" action="admin.php?controller=admin_eth&action=upgradeServerStatusSave" method="post">	
			{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td>play</td>
			<td><input name="file" id="" type="file" />&nbsp;&nbsp;&nbsp;&nbsp;<input name="submit" type="submit" value="提交" class="an_02" /></td>
			</tr>
			<input type="hidden" name="stype" value="play" />
			</form>
			<form name="backup" enctype="multipart/form-data" action="admin.php?controller=admin_eth&action=upgradeServerStatusSave" method="post">	
			{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td>ftp</td>
			<td><input name="file" id="" type="file" />&nbsp;&nbsp;&nbsp;&nbsp;<input name="submit" type="submit" value="提交" class="an_02" /></td>
			</tr>
			<input type="hidden" name="stype" value="ftp" />
			</form>
			
		</table>
	</td>
  </tr>
</table>
</body>
</html>

