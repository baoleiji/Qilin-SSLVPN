<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
</head>
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
<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	
</ul><span class="back_img"><A href="admin.php?controller=admin_pro&action=systemtype&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
 
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
          <form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_pro&action=systemtype_save&id={{$wt.id}}">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		系统类型
		</td>
		<td width="67%">
		<input type=text name="device_type" size=35 value="{{$wt.device_type}}" >
	  </td>
	<tr bgcolor="">
		<td width="33%" align=right>
		超级用户切换命令
		</td>
		<td width="67%">
		<input type=text name="sucommand" size=35 value="{{$wt.sucommand}}" >
	  </td>
	 </tr>
	 <tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		主机/网络
		</td>
		<td width="67%">
		<select name="snmp_system" >
		<option value="0" {{if !$wt.snmp_system }}selected{{/if}}>主机</option>
		<option value="1" {{if $wt.snmp_system eq 1}}selected{{/if}}>网络</option>
		</select>
	  </td>
	 </tr>

	<tr bgcolor="f7f7f7"><td align="center" colspan=2><input type=submit  value="{{$language.Save}}" class="an_02"></td></tr>


	</form>
</table>
<script>
function banit(number, ban){
	document.getElementById('start'+number).value='00:00:00';
	if(ban){		
		document.getElementById('end'+number).value='00:00:00';
	}else{
		document.getElementById('end'+number).value='23:59:59';
	}
}
</script>
 
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


