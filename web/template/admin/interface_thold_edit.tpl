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
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=interface_thold">网络配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=app_thold">应用配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_thold&action=dns_thold">DNS配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="javascript:history.back();"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="25" border="0"></A></span>
</div></td></tr>{{/if}}
<tr><td>
    <form method="post" name="newform" action="admin.php?controller=admin_thold&action=interface_thold_save&id={{$thold.id}}&from={{$smarty.get.from}}">
   <table border=0 width=100% cellpadding=5 cellspacing=0 bgcolor="#FFFFFF" valign=top class="BBtable{{if $smarty.get.from eq 'hostview'}}1{{/if}}">
      <input type="hidden" name="ac" value="update">
{{assign var="trnumber" value=0}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td>IP</td>
    <td class="left">{{$thold.device_ip}}</td>
  </tr>
  {{assign var="trnumber" value=0}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td>上次抓取日期</td>
    <td class="left">{{$thold.datetime}}</td>
  </tr>
  
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    端口号</td>
    <td class="left">
      <input type="text" value="{{$thold.port_index}}" size="25" name="port_index" id="port_index" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    接口名称</td>
    <td class="left">
      <input type="text" value="{{$thold.port_describe}}" size="25" name="port_describe" id="port_describe" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    接口类型</td>
    <td class="left">
      <input type="text" value="{{$thold.port_type}}" size="25" name="port_type" id="port_type" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    接口速度</td>
    <td class="left">
      <input type="text" value="{{$thold.port_speed}}" size="25" name="port_speed" id="port_speed" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    默认状态</td>
    <td class="left">
      <input type="text" value="{{$thold.normal_status}}" size="25" name="normal_status" id="normal_status" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    当前状态</td>
    <td class="left">
      <input type="text" value="{{$thold.cur_status}}" size="25" name="cur_status" id="cur_status" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    对端设备</td>
    <td class="left">
      <input type="text" value="{{$thold.connectdevice}}" size="25" name="connectdevice" id="connectdevice" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    对端设备接口</td>
    <td class="left">
      <input type="text" value="{{$thold.connectdeviceport}}" size="25" name="connectdeviceport" id="connectdeviceport" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    配线架接口</td>
    <td class="left">
      <input type="text" value="{{$thold.connectport}}" size="25" name="connectport" id="connectport" >
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
    入流量阈值</td>
    <td class="left">
     下限<input type="text" value="{{$thold.traffic_in_lowvalue}}" size="25" name="traffic_in_lowvalue" id="traffic_in_lowvalue" >---上限<input type="text" value="{{$thold.traffic_in_highvalue}}" size="25" name="traffic_in_highvalue" id="traffic_in_highvalue" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    出流量阈值</td>
    <td class="left">
     下限<input type="text" value="{{$thold.traffic_out_lowvalue}}" size="25" name="traffic_out_lowvalue" id="traffic_out_lowvalue" >---上限<input type="text" value="{{$thold.traffic_out_highvalue}}" size="25" name="traffic_out_highvalue" id="traffic_out_highvalue" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    入包阈值</td>
    <td class="left">
     下限<input type="text" value="{{$thold.packet_in_lowvalue}}" size="25" name="packet_in_lowvalue" id="packet_in_lowvalue" >---上限<input type="text" value="{{$thold.packet_in_highvalue}}" size="25" name="packet_in_highvalue" id="packet_in_highvalue" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    出包阈值</td>
    <td class="left">
     下限<input type="text" value="{{$thold.packet_out_lowvalue}}" size="25" name="packet_out_lowvalue" id="packet_out_lowvalue" >---上限<input type="text" value="{{$thold.packet_out_highvalue}}" size="25" name="packet_out_highvalue" id="packet_out_highvalue" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    入错包阈值</td>
    <td class="left">
     下限<input type="text" value="{{$thold.err_packet_in_lowvalue}}" size="25" name="err_packet_in_lowvalue" id="err_packet_in_lowvalue" >---上限<input type="text" value="{{$thold.err_packet_in_highvalue}}" size="25" name="err_packet_in_highvalue" id="err_packet_in_highvalue" >
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    出错包阈值</td>
    <td class="left">
     下限<input type="text" value="{{$thold.err_packet_out_lowvalue}}" size="25" name="err_packet_out_lowvalue" id="err_packet_out_lowvalue" >---上限<input type="text" value="{{$thold.err_packet_out_highvalue}}" size="25" name="err_packet_out_highvalue" id="err_packet_out_highvalue" >
    </td>
  </tr>
 {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 是否记录流量rrd</td>
    <td class="left"><input type="radio" value="1" size="25" name="traffic_RRD" id="traffic_RRD" {{if $thold.traffic_RRD}}checked{{/if}}>是 <input type="radio" value="0" size="25" name="traffic_RRD" id="traffic_RRD" {{if !$thold.traffic_RRD}}checked{{/if}}>否
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 是否记录包rrd</td>
    <td class="left"><input type="radio" value="1" size="25" name="packet_RRD" id="enable" {{if $thold.packet_RRD}}checked{{/if}}>是 <input type="radio" value="0" size="25" name="packet_RRD" id="packet_RRD" {{if !$thold.packet_RRD}}checked{{/if}}>否
    </td>
  </tr>
  {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 是否记录错包rrd</td>
    <td class="left"><input type="radio" value="1" size="25" name="err_packet_RRD" id="enable" {{if $thold.err_packet_RRD}}checked{{/if}}>是 <input type="radio" value="0" size="25" name="err_packet_RRD" id="err_packet_RRD" {{if !$thold.err_packet_RRD}}checked{{/if}}>否
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
    发送间隔</td>
    <td class="left">
      <input type="text" value="{{$thold.send_interval}}" size="25" name="send_interval" id="highvalue" >
    </td>
  </tr>

  
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    流量RRD文件</td>
    <td class="left">
      <input type="text" value="{{$thold.trafffic_rrdfile}}" size="25" name="trafffic_rrdfile" id="highvalue" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    包RRD文件</td>
    <td class="left">
      <input type="text" value="{{$thold.packet_rrdfile}}" size="25" name="packet_rrdfile" id="highvalue" >
    </td>
  </tr>
   {{assign var="trnumber" value=$trnumber+1}}
   <tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
    <td> 
    错包RRD文件</td>
    <td class="left">
      <input type="text" value="{{$thold.err_packet_rrdfile}}" size="25" name="err_packet_rrdfile" id="highvalue" >
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