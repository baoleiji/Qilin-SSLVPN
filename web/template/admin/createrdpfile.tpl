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


<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>

    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=createrdpfile">列表导出</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
		
			<form name="backup" enctype="multipart/form-data" action="admin.php?controller=admin_index&action=createrdpfile&tool=mremote" method="post">	
			<tr>
			<td>mRemote</td>
			<td>堡垒机IP:<input name="baoleijiip" id="" value="{{$eth0}}" type="text" width=50 />&nbsp;&nbsp;&nbsp;&nbsp;端口:<input name="port" id="" value="3389" type="text" width=50 />&nbsp;&nbsp;&nbsp;&nbsp;域名连接:<input type="checkbox" name="m_bydomain" id="m_bydomain" {{if $m_bydomain}}checked{{/if}} value="1"  />&nbsp;&nbsp;&nbsp;&nbsp;<input name="submit" type="submit" class="an_02" value="列表下载" /></td>
			</tr>
			</form>

			<form name="backup" enctype="multipart/form-data" action="admin.php?controller=admin_index&action=createrdpfile&tool=rdcman" method="post">	
			<tr>
			<td>RDCMAN</td>
			<td>堡垒机IP:<input name="baoleijiip" id="" value="{{$eth0}}" type="text" width=50 />&nbsp;&nbsp;&nbsp;&nbsp;端口:<input name="port" id="" value="3389" type="text" width=50 />&nbsp;&nbsp;&nbsp;&nbsp;域名连接:<input type="checkbox" name="r_bydomain" id="r_bydomain" {{if $r_bydomain}}checked{{/if}} value="1"  />&nbsp;&nbsp;&nbsp;&nbsp;<input name="submit" type="submit" class="an_02" value="列表下载" /></td>
			</tr>
			</form>

			<form name="backup" enctype="multipart/form-data" action="admin.php?controller=admin_index&action=createrdpfile&tool=securecrt" method="post" target="hide">	
			<tr>
			<td>SecureCRT</td>
			<td>堡垒机IP:<input name="baoleijiip" id="" value="{{$eth0}}" type="text" width=50 />&nbsp;&nbsp;&nbsp;&nbsp;端口:<input name="port" id="" value="22" type="text" width=50 />&nbsp;&nbsp;&nbsp;&nbsp;默认:<select name="template" ><option value="">无</option><option value="6">SecureCRT6</option><option value="6">SecureCRT7</option></select>模版:<input name="crttemplate" id="" type="file" width=50 />&nbsp;&nbsp;<br />终端类型:<select name="term" ><option value="ANSI">ANSI</option><option value="Linux">Linux</option><option value="VT100">VT100</option><option value="Xterm">Xterm</option></select>字符集:<select name="charset" ><option value="Default">Default</option><option value="UTF-8">UTF-8</option></select>配色方案:<select name="colorscheme" ><option value="Monochrome">Monochrome</option><option value="Traditional">Traditional</option><option value="Windows">Windows</option></select>&nbsp;&nbsp;域名连接:<input type="checkbox" name="s_bydomain" id="s_bydomain" {{if $s_bydomain}}checked{{/if}} value="1"  />&nbsp;&nbsp;&nbsp;&nbsp;<input name="submit" type="submit"  class="an_02" value="列表下载" /></td>
			</tr>
			</form>
			<form name="backup" enctype="multipart/form-data" action="admin.php?controller=admin_index&action=createrdpfile&tool=xshell" method="post" target="hide">	
			<tr>
			<td>Xshell</td>
			<td>堡垒机IP:<input name="baoleijiip" id="" value="{{$eth0}}" type="text" width=50 />&nbsp;&nbsp;&nbsp;&nbsp;端口:<input name="port" id="" value="22" type="text" width=50 />&nbsp;&nbsp;&nbsp;&nbsp;默认:<select name="template" ><option value="">无</option><option value="3">XShell3</option><option value="4">XShell4</option></select>模版:<input name="xshelltemplate" id="" type="file" width=50 />&nbsp;&nbsp;&nbsp;&nbsp;域名连接:<input type="checkbox" name="x_bydomain" id="x_bydomain" {{if $x_bydomain}}checked{{/if}} value="1"  />&nbsp;&nbsp;&nbsp;&nbsp;<input name="submit" type="submit" class="an_02" value="列表下载" /></td>
			</tr>
			</form>
		</table>
	</td>
  </tr>
</table>
<iframe name="hide" height="0" frameborder="0" scrolling="no" id="hide"></iframe>
</body>
</html>


