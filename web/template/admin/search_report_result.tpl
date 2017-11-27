<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />

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
<td width="84%" align="left" valign="top">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F1F1F1">
<tr><td valign="middle" class="hui_bj" align="left">
<div class="menu">
<ul>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_search">综合日志</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eventlogs&action=applogs">应用日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_login">登录日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_authpriv">权限日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>

</ul><span class="back_img"><A href="admin.php?controller=admin_search&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="25" border="0"></A></span>
</div>
</td></tr>

  <tr>
    <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
  <tr>
    <td>
   共有日志{{$num_results}}条，分成{{$num_log_files}}个文件，每个文件最多包含{{$items_per_file}}条日志 
</td>
  </tr>
</table>	

	  </td>
  </tr>

  <tr><td>
  			<table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">

					<tr>
						<td   bgcolor="#FFFFFF">
							<ol id="file_list">
							</ol>
						</td>
					</tr>
				</table>
	</td>
  </tr>
</table></td>

<SCRIPT>
function display_list(num_files) {
			//Fuck, Bugs of IE again.

			var file_list;

			file_list = document.getElementById('file_list');
			for (i = 1; i <= num_files; i++) {
				li = document.createElement('li');
				a = document.createElement('a');
				a.className = 'special';
				a.href = location.search.replace("export", "do_export") + "&filenum=";
				a.href += i.toString();
				a.innerHTML = "log_" + i.toString() + ".xls";
				li.appendChild(a);
				file_list.appendChild(li);
			}
		}

		display_list({{$num_log_files}});
</SCRIPT>
</body>
</html>


