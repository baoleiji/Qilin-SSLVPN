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
    <td  class="hui_bj">导入公钥私钥</td>
  </tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
            <tr>
              <td align="center">
              <form action="admin.php?controller=admin_pro&action=dosshpublickey" method="post" enctype="multipart/form-data" >
              <TABLE border=0 cellSpacing=1 cellPadding=5 
                                width="100%" bgColor=#ffffff valign="top">
                <TBODY>		
		<tr >
			<td width="10%" height="16" align="center" ><b>公钥</b></td>
			<td align="left" width="30%">
			<input type="file" name="publickey" />
			</td>
		</tr>	
		<tr >
			<td width="10%" height="16" align="center" ><b>私钥</b></td>
			<td align="left" width="30%">
			<input type="file" name="privatekey" />
			</td>
		</tr>	
		<tr >
			<td width="10%" height="16" align="center" ></td>
			<td align="left" width="30%">
			<input type="submit" name="submit" value="提交" />
			</td>
		</tr>		
		
		</TBODY>
              </TABLE>
              </form>
              </td>

        </table>
	</td>
  </tr>
</table>
</body>
</html>


