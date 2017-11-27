<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	function check_add_user(){
		return(true);
	}
</script>
</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$title}}</td>
  </tr>
  <tr>
    <td class="main_content" align="center">
	 		{{$content}}
			<br/ ><br />
			<a href="#" onclick="javascript:history.go(-1)"><img src="{{$template_root}}/images/back.png" width="50" border=0 width="60" /></a>
	 </td>
  </tr>
</table>


</body>
</html>


