<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.File}}比较结果</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>



	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$language.User}}{{$language.File}}比较——{{$language.Detail}}</td>
  </tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
			{{if $msg == '0' }}<font size='5pt' color='green'>{{$language.device}}{{$language.Configure}}正常</font>{{elseif $msg == '2' }}<font size='5pt' color='red'>获取{{$language.device}}{{$language.Configure}}{{$language.Failed}}</font>{{else}}<font size='4pt' color='red'>{{$msg}}</font>{{/if}}
		</table>
	</td>
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


