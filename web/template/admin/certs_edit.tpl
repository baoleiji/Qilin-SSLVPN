<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
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
 <SCRIPT language=javascript src="{{$template_root}}/images/selectdate.js"></SCRIPT>
 <SCRIPT type=text/javascript>
var siteUrl = "{{$template_root}}/images/date";
</SCRIPT>
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0" >

<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
<form name="f1" method=post action="admin.php?controller=admin_config&action=certs_save">

          <tr><th colspan="3" class="list_bg"></th></tr>
	{{assign var="trnumber" value=0}}<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>类型</td>
		<td width="67%">
			<select name="type" style="width: 120px;">
			<option value="0" {{if $ip}}selected{{/if}}>IP 地址</option>
			<option value="1" {{if $dns}}selected{{/if}}>主机名</option>
			</select>
		</td>
	  </tr>
	
		{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>IP</td>
		<td width="67%"><input type="text" name="ip" value="{{$ip}}{{$dns}}" /></td>
	</tr>
		 	 
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					<td  align="center" colspan=2>
<input type="hidden" name="oldip" value="{{$ip}}" />
<input type="hidden" name="olddns" value="{{$dns}}" />
<input type=submit  value="保存修改" class="an_02">

	</td>
  </tr></form>
</table>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



