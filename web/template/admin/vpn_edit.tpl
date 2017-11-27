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


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>

	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=vpn_list">VPN -策略</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_eth&action=vpn_list&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
    <form name="f1" method=post action="admin.php?controller=admin_eth&action=vpn_add">
		<tr><th colspan="3" class="list_bg"></th></tr>
	{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>来源地址</td>
		<td width="67%"><input type="text" name="s_addr" size="40" value="{{$p.s_addr}}" />例如:192.168.1.0/255.255.255.0</td>
	</tr>
	
		{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>目标地址</td>
		<td width="67%"><input type="text"  name="d_addr" size="40" value="{{$p.d_addr}}" />例如:172.16.1.0/255.255.255.0</td>
	  </tr>
	 {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>映射地址</td>
		<td width="67%"><input type="text"  name="p_addr" size="40" value="{{$p.p_addr}}" />例如:10.100.1.1</td>
	  </tr>
		 	 
	{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
					<td  align="center" colspan=2><input type="hidden" name="ac" value="{{if $p['sid']}}modify{{else}}new{{/if}}" />
<input type="hidden" name="id" value="{{$p['sid']}}" />
<input type=submit  value="保存修改" class="an_02">
	</td>
  </tr>
</form>
</table>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



