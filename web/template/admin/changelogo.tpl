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

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=serverstatus">服务状态</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=latest">系统状态</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup">配置备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting">数据同步</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=upgrade">软件升级</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=cronjob">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=changelogo">图标上传</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=notice">系统通知</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
              <form action="admin.php?controller=admin_index&action=changelogo" method="post" enctype="multipart/form-data" >
			  <tr><th colspan="3" class="list_bg">logo替换</th></tr>
		<tr >
			<td width="10%" height="16" align="center" ><b>上传登录页面logo:</b></td>
			<td align="left" width="30%">
			<img src="logo/logo1.jpg" ><br /><br />
			<input type="file" name="login_logo" />
			</td>
		</tr>	
		<tr >
			<td width="10%" height="16" align="center" ><b>上传内页顶部logo:</b></td>
			<td align="left" width="30%">
			<img src="logo/02.jpg" ><br /><br />
			<input type="file" name="top_logo" />
			</td>
		</tr>	
		<tr >
			<td width="10%" height="16" align="center" ><b>安卓动态口令扫描码图片:</b></td>
			<td align="left" width="30%">
			<img src="logo/android.jpg" ><br /><br />
			<input type="file" name="android" />
			</td>
		</tr>	
		<tr >
			<td width="10%" height="16" align="center" ><b>苹果动态口令扫描码图片:</b></td>
			<td align="left" width="30%">
			<img src="logo/ios.jpg" ><br /><br />
			<input type="file" name="ios" />
			</td>
		</tr>	
		<tr >
			<td  align="center" colspan=2>
			<input type="submit" name="submit"  value="提交" class="an_02">
			</td>
		</tr>		
		
	</form>

        </table>
	</td>
  </tr> 
</table>
</body>
</html>


