 <html>
<head>
  <title> </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
 <link href="template/admin/all_purpose_style.css" type="text/css" rel="stylesheet">
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >

  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
             <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=snmp_alert">告警配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_configure&action=snmp_interface">接口设置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li></ul>
</ul><span class="back_img"><A href="javascript:history.back();"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="25" border="0"></A></span>
</div></td></tr>
<tr><td>
    <form method="post" name="newform" action="admin.php?controller=admin_configure&action=snmp_interface_save&id={{$interface.id}}">
    <table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
      <input type="hidden" name="ac" value="update">
{{assign var="trnumber" value=0}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    对端设备</td>
    <td class="left">
      <select name="connectdevice" >
	  {{section name=s loop=$servers}}
	  <option value="{{$servers[s].id}}" {{if $servers[s].id eq $interface.connectdevice}} selected{{/if}} >{{$servers[s].device_ip}}</option>
	  {{/section}}
	  </select>
    </td>
  </tr>
  
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    对端设备接口:</td>
    <td class="left">
      <input type="text" value="{{$interface.connectdeviceport}}" size="25" name="connectdeviceport" id="connectdeviceport" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    配线架接口:</td>
    <td class="left">
      <input type="text" value="{{$interface.connectport}}" size="25" name="connectport" id="connectport" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    描述:</td>
    <td class="left">
      <input type="text" value="{{$interface.connectdesc}}" size="25" name="connectdesc" id="connectdesc" >
    </td>
  </tr>

{{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td colspan="2" align="center" style="border-bottom: none; padding: 10px;">
      <input type="button" value="确定" onClick="javascript:document.newform.submit();" class="an_02" style="font-size:12px">
      <input type="reset" value="重置" class="an_02" style="font-size:12px">
    </td>
  </tr>
</table></td></tr></table>
</form>
</body>
</html>