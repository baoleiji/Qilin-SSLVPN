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
<tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
	{{if $smarty.get.from ne 'hostview'}}
             <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold">系统阈值列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=snmp_interface_policy">接口阈值列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=status_thold">主机配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=interface_thold">网络配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=app_thold">应用配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=dns_thold">DNS配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>

</ul><span class="back_img"><A href="javascript:history.back();"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="25" border="0"></A></span>
</div></td></tr>{{/if}}
<tr><td>
    <form method="post" name="newform" action="admin.php?controller=admin_thold&action=app_thold_save&id={{$thold.seq}}&from={{$smarty.get.from}}">
   <table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable{{if $smarty.get.from eq 'hostview'}}1{{/if}}">
      <input type="hidden" name="ac" value="update">
{{assign var="trnumber" value=0}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td>IP</td>
    <td class="left">{{$thold.device_ip}}</td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    上次时间</td>
    <td class="left">
     {{$thold.datetime}}
    </td>
  </tr>
 {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    名称</td>
    <td class="left">
      <input type="text" value="{{$thold.app_name}}" size="25" name="app_name" id="app_name" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    类型</td>
    <td class="left">
      <input type="text" value="{{$thold.app_type}}" size="25" name="app_type" id="app_type" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    是否启用</td>
    <td class="left">
		<input type="radio" value="1" size="25" name="enable" id="enable" {{if $thold.enable}}checked{{/if}}>是 <input type="radio" value="0" size="25" name="enable" id="enable" {{if !$thold.enable}}checked{{/if}}>否
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    阈值</td>
    <td class="left">
     下限<input type="text" value="{{$thold.lowvalue}}" size="25" name="lowvalue" id="lowvalue" >---上限<input type="text" value="{{$thold.highvalue}}" size="25" name="highvalue" id="highvalue" >
    </td>
  </tr>
   

 {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 是否邮件告警</td>
    <td class="left"><input type="radio" value="1" size="25" name="mail_alarm" id="enable" {{if $thold.mail_alarm}}checked{{/if}}>是 <input type="radio" value="0" size="25" name="mail_alarm" id="enable" {{if !$thold.mail_alarm}}checked{{/if}}>否
    </td>
  </tr>

  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 是否短信告警</td>
    <td class="left"><input type="radio" value="1" size="25" name="sms_alarm" id="enable" {{if $thold.sms_alarm}}checked{{/if}}>是 <input type="radio" value="0" size="25" name="sms_alarm" id="enable" {{if !$thold.sms_alarm}}checked{{/if}}>否
    </td>
  </tr>
 {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    当前值</td>
    <td class="left">
      <input type="text" value="{{$thold.value}}" size="25" name="value" id="highvalue" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    RRD文件</td>
    <td class="left">
      <input type="text" value="{{$thold.rrdfile}}" size="25" name="rrdfile" id="highvalue" >
    </td>
  </tr>
 

  
{{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td colspan="2" align="center" style="border-bottom: none; padding: 10px;">
      <input type="button" value="确定" onClick="javascript:document.newform.submit();" class="btn" style="font-size:12px">
      <input type="reset" value="重置" class="btn" style="font-size:12px">
    </td>
  </tr>
</table></td></tr></table>
</form>
</body>
</html>