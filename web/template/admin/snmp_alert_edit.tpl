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
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=snmp_alert">告警配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_configure&action=snmp_interface">接口设置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>

</ul><span class="back_img"><A href="javascript:history.back();"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="25" border="0"></A></span>
</div></td></tr>
<tr><td>
    <form method="post" name="newform" action="admin.php?controller=admin_thold&action=snmp_alert_save&id={{$alert.seq}}">
    <table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
      <input type="hidden" name="ac" value="update">
{{assign var="trnumber" value=0}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    名称</td>
    <td class="left">
      <input type="text" value="{{$alert.name}}" size="25" name="name" id="name" >
    </td>
  </tr>
 {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 允许</td>
    <td class="left"><input type="radio" value="1" size="25" name="enable" id="enable" {{if $alert.enable}}checked{{/if}}>是 <input type="radio" value="0" size="25" name="enable" id="enable" {{if !$alert.enable}}checked{{/if}}>否
    </td>
  </tr>
{{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    设备组</td>
    <td class="left">
     <select name='groupid' >
					<option value="0">全部设备</option>
					{{section name='g' loop=$group}}
					<option value="{{$group[g].id}}" {{if $alert.groupid eq $group[g].id}}selected{{/if}}>{{$group[g].groupname}}</option>
					{{/section}}
					</select>
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 是否邮件告警</td>
    <td class="left">
       <input type="radio" value="1" size="25" name="mail_alarm" id="mail_alarm" {{if $alert.mail_alarm}}checked{{/if}}>是 <input type="radio" value="0" size="25" name="mail_alarm" id="mail_alarm" {{if !$alert.mail_alarm}}checked{{/if}}>否
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 是否短信告警</td>
    <td class="left">
       <input type="radio" value="1" size="25" name="sms_alarm" id="sms_alarm" {{if $alert.sms_alarm}}checked{{/if}}>是 <input type="radio" value="0" size="25" name="sms_alarm" id="sms_alarm" {{if !$alert.sms_alarm}}checked{{/if}}>否
    </td>
  </tr>
{{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    告警周期</td>
    <td class="left">
      <input type="text" value="{{$alert.period}}" size="25" name="period" id="period" >分钟
    </td>
  </tr>
 
{{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 告警项</td>
    <td class="left">
       <select name="alertitem">
	   <option value="system" {{if $alert.alarmitem eq 'system'}}selected{{/if}}>系统</option>
	   <option value="network" {{if $alert.alarmitem eq 'network'}}selected{{/if}}>网络</option>
	   <option value="app" {{if $alert.alarmitem eq 'app'}}selected{{/if}}>应用</option>
	   </select>
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right  valign=top>
		{{$language.bind}}{{$language.User}}
		</td>
		<td width="67%">
		<table><tr >
		{{section name=g loop=$allmem}}
		<td width="150"><input type="checkbox" name='memberid[]' value='{{$allmem[g].uid}}'  {{if $allmem[g].check}}checked{{/if}}>{{$allmem[g].username}}({{if $allmem[g].realname}}{{$allmem[g].realname}}{{else}}未设置{{/if}})</a></td>{{if ($smarty.section.g.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/section}}
		</tr></table>
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