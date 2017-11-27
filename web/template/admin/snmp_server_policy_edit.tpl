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
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold">系统阈值列表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=snmp_interface_policy">接口阈值列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=status_thold">主机配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=interface_thold">网络配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=app_thold">应用配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=dns_thold">DNS配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="javascript:history.back();"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="25" border="0"></A></span>
</div></td></tr>
<tr><td>
    <form method="post" name="newform" action="admin.php?controller=admin_thold&action=snmp_server_policy_save&id={{$thold.id}}">
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
    CPU RRD是否记录:</td>
    <td class="left">
      <input type="checkbox" value="1" {{if $thold.cpurrd}}checked{{/if}} name="cpurrd" id="cpurrd" >
    </td>
  </tr>

  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    CPU-IO RRD是否记录:</td>
    <td class="left">
      <input type="checkbox" value="1" {{if $thold.cpuiorrd}}checked{{/if}} name="cpuiorrd" id="cpuiorrd" >
    </td>
  </tr>

 {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    内存RRD是否记录:</td>
    <td class="left">
      <input type="checkbox" value="1" {{if $thold.memoryrrd}}checked{{/if}} name="memoryrrd" id="memoryrrd" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    交换空间RRD是否记录:</td>
    <td class="left">
      <input type="checkbox" value="1" {{if $thold.swaprrd}}checked{{/if}} name="swaprrd" id="swaprrd" >
    </td>
  </tr>
  
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    存储RRD是否记录:</td>
    <td class="left">
      <input type="checkbox" value="1" {{if $thold.diskrrd}}checked{{/if}} name="diskrrd" id="diskrrd" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    CPU:</td>
    <td class="left">
      下限:<input type="text" value="{{$thold.cpulow}}" size="25" name="cpulow" id="cpulow" >%&nbsp;&nbsp;上限:<input type="text" value="{{$thold.cpuhigh}}" size="25" name="cpuhigh" id="cpuhigh" >%
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    CPU-IO:</td>
    <td class="left">
      下限:<input type="text" value="{{$thold.cpuiolow}}" size="25" name="cpuiolow" id="cpuiolow" >%&nbsp;&nbsp;上限:<input type="text" value="{{$thold.cpuiohigh}}" size="25" name="cpuiohigh" id="cpuiohigh" >%
    </td>
  </tr>
 {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    内存:</td>
    <td class="left">
      下限:<input type="text" value="{{$thold.memorylow}}" size="25" name="memorylow" id="memorylow" >%&nbsp;&nbsp;上限:<input type="text" value="{{$thold.memoryhigh}}" size="25" name="memoryhigh" id="memoryhigh" >%
    </td>
  </tr>
 {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    交换空间:</td>
    <td class="left">
      下限:<input type="text" value="{{$thold.swaplow}}" size="25" name="swaplow" id="swaplow" >%&nbsp;&nbsp;上限:<input type="text" value="{{$thold.swaphigh}}" size="25" name="swaphigh" id="swaphigh" >%
    </td>
  </tr>
 {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    存储:</td>
    <td class="left">
      下限:<input type="text" value="{{$thold.disklow}}" size="25" name="disklow" id="disklow" >&nbsp;&nbsp;上限:<input type="text" value="{{$thold.diskhigh}}" size="25" name="diskhigh" id="diskhigh" >
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