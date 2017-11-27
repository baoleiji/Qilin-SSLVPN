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


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">资源管理——{{$language.ProgramUpgrade}}</td>
  </tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
		
			<form name="backup" enctype="multipart/form-data" action="admin.php?controller=admin_eth&action=upgradeServerSave" method="post">	
			<tr>
			<td>{{$language.upload}}{{$language.File}}</td>
			<td><input name="file" id="" type="file" />&nbsp;&nbsp;&nbsp;&nbsp;<input name="submit" type="submit" value="{{$language.Commit}}" /></td>
			</tr>
			
			</form>
			
			
		</table>
	</td>
  </tr>
</table>
</body>
</html>


