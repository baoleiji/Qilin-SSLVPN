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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold">系统阈值列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=snmp_interface_policy">接口阈值列表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=status_thold">主机配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=interface_thold">网络配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=app_thold">应用配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=dns_thold">DNS配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="javascript:history.back();"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="25" border="0"></A></span>
</div></td></tr>
<tr><td>
    <form method="post" name="newform" action="admin.php?controller=admin_thold&action=snmp_interface_policy_save&id={{$thold.id}}">
    <table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
      <input type="hidden" name="ac" value="update">
{{assign var="trnumber" value=0}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    名称</td>
    <td class="left">
      <input type="text" value="{{$thold.name}}" size="25" name="name" id="name" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    是否邮件告警:</td>
    <td class="left">
      <input type="checkbox" value="1" {{if $thold.mail_alarm}}checked{{/if}} name="mail_alarm" id="mail_alarm" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    是否短信告警:</td>
    <td class="left">
      <input type="checkbox" value="1" {{if $thold.sms_alarm}}checked{{/if}} name="sms_alarm" id="sms_alarm" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    流量RRD是否记录:</td>
    <td class="left">
      <input type="checkbox" value="1" {{if $thold.trfficrrd}}checked{{/if}} name="trfficrrd" id="trfficrrd" >
    </td>
  </tr>

 {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    包RRD是否记录:</td>
    <td class="left">
      <input type="checkbox" value="1" {{if $thold.packetrrd}}checked{{/if}} name="packetrrd" id="packetrrd" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    错包RRD是否记录:</td>
    <td class="left">
      <input type="checkbox" value="1" {{if $thold.errorrrd}}checked{{/if}} name="errorrrd" id="errorrrd" >
    </td>
  </tr>
  
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    入流量:</td>
    <td class="left">
      下限:<input type="text" value="{{$thold.trfficinlow}}" size="25" name="trfficinlow" id="trfficinlow" >&nbsp;&nbsp;上限:<input type="text" value="{{$thold.trfficinhigh}}" size="25" name="trfficinhigh" id="trfficinhigh" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    出流量:</td>
    <td class="left">
      下限:<input type="text" value="{{$thold.trfficoutlow}}" size="25" name="trfficoutlow" id="trfficoutlow" >&nbsp;&nbsp;上限:<input type="text" value="{{$thold.trfficouthigh}}" size="25" name="trfficouthigh" id="trfficouthigh" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    入包:</td>
    <td class="left">
      下限:<input type="text" value="{{$thold.packetinlow}}" size="25" name="packetinlow" id="packetinlow" >&nbsp;&nbsp;上限:<input type="text" value="{{$thold.packetinhigh}}" size="25" name="packetinhigh" id="packetinhigh" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    出包:</td>
    <td class="left">
      下限:<input type="text" value="{{$thold.packetoutlow}}" size="25" name="packetoutlow" id="packetoutlow" >&nbsp;&nbsp;上限:<input type="text" value="{{$thold.packetouthigh}}" size="25" name="packetouthigh" id="packetouthigh" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    入错包:</td>
    <td class="left">
      下限:<input type="text" value="{{$thold.errorinlow}}" size="25" name="errorinlow" id="errorinlow" >&nbsp;&nbsp;上限:<input type="text" value="{{$thold.errorinhigh}}" size="25" name="errorinhigh" id="errorinhigh" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    出错包:</td>
    <td class="left">
      下限:<input type="text" value="{{$thold.erroroutlow}}" size="25" name="erroroutlow" id="erroroutlow" >&nbsp;&nbsp;上限:<input type="text" value="{{$thold.errorouthigh}}" size="25" name="errorouthigh" id="errorouthigh" >
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