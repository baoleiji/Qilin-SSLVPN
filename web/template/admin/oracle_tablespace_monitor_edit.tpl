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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=apache_monitor">Apache</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=mysql_monitor">Mysql</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=tomcat_monitor">Tomcat</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=nginx_monitor">Nginx</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=oracle_tablespace_monitor">Oracle</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=weixin_monitor">微信监控</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=dns_monitor">DNS</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
 <tr>
	<td align="right"><a href="javascript:history.back();"><img src="{{$template_root}}/images/back.png" width="50" border=0 width="60" />
</a></td>
	</tr>
<tr><td>
    <form method="post" name="newform" action="admin.php?controller=admin_monitor&action=oracle_tablespace_monitor_save&id={{$status.id}}">
    <table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable">
      <input type="hidden" name="ac" value="update">
	
	{{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    邮件告警</td>
    <td class="left">
      <select name="mail_alarm" >
	  <option value=1 {{if $status.mail_alarm}}selected{{/if}}>打开</option>
	  <option value=0 {{if !$status.mail_alarm}}selected{{/if}}>关闭</option>
	  </select>
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    短信告警</td>
    <td class="left">
      <select name="sms_alarm" >
	  <option value=1 {{if $status.sms_alarm}}selected{{/if}}>打开</option>
	  <option value=0 {{if !$status.sms_alarm}}selected{{/if}}>关闭</option>
	  </select>
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right width="50%"> 
    上限:</td>
    <td class="left">
      <input type="text" value="{{$status.highvalue}}" size="25" name="highvalue" id="highvalue" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    下限:</td>
    <td class="left">
      <input type="text" value="{{$status.lowvalue}}" size="25" name="lowvalue" id="lowvalue" >
    </td>
  </tr>  
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td align=right> 
    发送间隔:</td>
    <td class="left">
      <input type="text" value="{{$status.send_interval}}" size="25" name="send_interval" id="send_interval" >
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