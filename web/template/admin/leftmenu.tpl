<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>left</title>
<LINK href="{{$template_root}}/cssjs/liye.css" type=text/css rel=stylesheet>
<SCRIPT src="{{$template_root}}/cssjs/MTree.js" type=text/javascript></SCRIPT>


</head>

<body> <!-- oncontextmenu="return false" -->

          <table width="{{if $smarty.get.from eq 'parameters'}}120{{else}}235{{/if}}"  height="554" border="0" cellspacing="0" cellpadding="0" style="background-color:#F1F1F1">
            <tr>
                <td height="100%" align="left" valign="top" width="{{if $smarty.get.from eq 'parameters'}}120{{else}}235{{/if}}">
			      <!-- 边框的头-->

				<div id="bangzi" style='border:#B1B5B9 1px solid; text-align:left; position:relative; left:0; top:0; width:{{if $smarty.get.from eq 'parameters'}}120{{else}}235{{/if}}px; height:554px; z-index:1; overflow: auto;'>
                  <table id="clgl" width="85%" border="0" cellspacing="0" cellpadding="0">
                  	<tr>
                  		<td colspan="2"><img src='{{$template_root}}/images/spacer.gif' height='8'></td>
                  	</tr>
                  	<tr>
						<td><img src='{{$template_root}}/images/spacer.gif' width='8'></td>
                  		
                  		<td width='232'>
							<!-- Tree -->
							<script type="text/javascript">
								var tree6 = new MTree("{{$template_root}}/images/treeImages");
									tree6.setTreeName("tree6");
								{{if $smarty.get.from eq 'paramters'}}

								 
							 tree6.addNode(new MTreeNode("a1","0","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<strong>{{$server.device_ip}}</strong>","<img id=stateimg src='{{$template_root}}/images/{{if $server.status eq 1}}Green.gif{{elseif $server.status eq 2}}GreenYellow.gif{{else}}GreenRed.gif{{/if}}' width='13' height='13'  style='cursor: hand' alt='点击浏览状态信息' onclick=openStatePage('a1')>&nbsp;","","","","",""));						
											
							tree6.addNode(new MTreeNode("b1","a1","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_b1'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_thold&action=status_thold&ip={{$ip}}&from=hostview','rightmain');>系统阈值</span>","<img src='{{$template_root}}/images/icon_cgxx.gif' width='16' height='16'>","","","","",""));

							tree6.addNode(new MTreeNode("b2","a1","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_b1'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_thold&action=interface_thold&ip={{$ip}}&from=hostview','rightmain');>网络阈值</span>","<img src='{{$template_root}}/images/ico-021.gif' width='16' height='16'>","","","","",""));

							tree6.addNode(new MTreeNode("b3","a1","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_b1'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_thold&action=app_thold&ip={{$ip}}&from=hostview','rightmain');>应用阈值</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));
										
										//tree6.setAutoReload(); //是否动态生成
								{{else}}
											
											tree6.addNode(new MTreeNode("a1","0","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<strong>{{$server.device_ip}}</strong>","<img id=stateimg src='{{$template_root}}/images/{{if $server.status eq 1}}Green.gif{{elseif $server.status eq 2}}GreenYellow.gif{{else}}GreenRed.gif{{/if}}' width='13' height='13'  style='cursor: hand' alt='点击浏览状态信息' onclick=openStatePage('a1')>&nbsp;","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("b1","a1","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_b1'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostview&ip={{$ip}}','rightmain');>常规信息</span>","<img src='{{$template_root}}/images/icon_cgxx.gif' width='16' height='16'>","","","","",""));
											
											tree6.addNode(new MTreeNode("b3","a1","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_b3'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' >事件管理</span>","<img src='{{$template_root}}/images/ico-021.gif' width='16' height='16'>","","","","",""));

											tree6.addNode(new MTreeNode("b31","b3","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_b3'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_login&action=winlinlogin&os={{$os}}&ip={{$ip}}','rightmain');>登录日志</span>","<img src='{{$template_root}}/images/ico-021.gif' width='16' height='16'>","","","","",""));	
											
											tree6.addNode(new MTreeNode("b32","b3","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_b3'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_authpriv&action=winlinauthpriv&os={{$os}}&ip={{$ip}}','rightmain');>权限日志</span>","<img src='{{$template_root}}/images/ico-021.gif' width='16' height='16'>","","","","",""));	

											tree6.addNode(new MTreeNode("b33","b3","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_b3'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_eventlogs&action=eventlogbyip&os={{$os}}&ip={{$ip}}','rightmain');>告警日志</span>","<img src='{{$template_root}}/images/ico-021.gif' width='16' height='16'>","","","","",""));	
											tree6.addNode(new MTreeNode("b34","b3","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_b3'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_thold&action=snmp_status_warning_log&ip={{$ip}}&from=hostview','rightmain');>系统告警</span>","<img src='{{$template_root}}/images/ico-021.gif' width='16' height='16'>","","","","",""));	
											tree6.addNode(new MTreeNode("b35","b3","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_b3'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_thold&action=snmp_interface_log&ip={{$ip}}&from=hostview','rightmain');>流量告警</span>","<img src='{{$template_root}}/images/ico-021.gif' width='16' height='16'>","","","","",""));	
											tree6.addNode(new MTreeNode("b36","b3","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_b3'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_thold&action=app_warning_log&ip={{$ip}}&from=hostview','rightmain');>应用告警</span>","<img src='{{$template_root}}/images/ico-021.gif' width='16' height='16'>","","","","",""));	
								
											
											tree6.addNode(new MTreeNode("b4","b13","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_nodehidden_availabilitymetrica1'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostview&ip={{$ip}}','rightmain');>可用性指标</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));							
											
											tree6.addNode(new MTreeNode("b5","b4","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_nodehidden_performancemetrica1'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostview&ip={{$ip}}','rightmain');>性能指标</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));

											tree6.addNode(new MTreeNode("b42","b13","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_nodehidden_availabilitymetrica1'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostview&ip={{$ip}}','rightmain');>本地检测指标</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));

											tree6.addNode(new MTreeNode("b421","b42","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_nodehidden_performancemetrica1'; style='border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' ,'rightmain');>本地端口</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));

											{{section name=p loop=$localport}}
											tree6.addNode(new MTreeNode("b421{{$smarty.section.p.index}}","b421","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_a1_b8'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=localport&id={{$localport[p].seq}}&ip={{$ip}}','rightmain');>PORT {{$localport[p].port}}</span>","<img src='{{$template_root}}/images/{{if $localport[p].port_status le '0' }}RhombusRed.gif{{else}}RhombusGreen.gif{{/if}}' width='16' height='16' id='imgb8a1'>","","","","",""));
											{{/section}}



											tree6.addNode(new MTreeNode("b422","b42","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_nodehidden_performancemetrica1'; style=' border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' ,'rightmain');>本地进程</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));

											{{section name=pr loop=$localprocess}}
											tree6.addNode(new MTreeNode("b422{{$smarty.section.pr.index}}","b422","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_a1_b8'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=localprocess&id={{$localprocess[pr].seq}}&ip={{$ip}}','rightmain');>{{$localprocess[pr].process}}</span>","<img src='{{$template_root}}/images/{{if $localprocess[pr].process_status eq '0'}}RhombusRed.gif{{else}}RhombusGreen.gif{{/if}}' width='16' height='16' id='imgb8a1'>","","","","",""));
											{{/section}}
								
											
											tree6.addNode(new MTreeNode("b6","b9","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_a1_b6'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=cpu&ip={{$ip}}','rightmain');>CPU平均利用率</span>","<img src='{{$template_root}}/images/{{if $cpu.value eq NULL or $cpu.value <0 }}RhombusRed.gif{{elseif $cpu.value < $cpu.lowvalue or $cpu.value > $cpu.highvalue}}RhombusYellow.gif{{else}}RhombusGreen.gif{{/if}}' width='16' height='16' id='imgb6a1'>","","","","",""));
{{if $cpuio}}
											tree6.addNode(new MTreeNode("b66","b9","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_a1_b6'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=cpu_io&ip={{$ip}}','rightmain');>CPU IO平均利用率</span>","<img src='{{$template_root}}/images/{{if $cpuio.value eq NULL or $cpuio.value <0 }}RhombusRed.gif{{elseif $cpuio.value < $cpuio.lowvalue or $cpuio.value > $cpuio.highvalue}}RhombusYellow.gif{{else}}RhombusGreen.gif{{/if}}' width='16' height='16' id='imgb6a1'>","","","","",""));
{{/if}}											
								
											
											tree6.addNode(new MTreeNode("b7","b10","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_a1_b7'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=memory&ip={{$ip}}','rightmain');>内存利用率</span>","<img src='{{$template_root}}/images/{{if $memory.value eq NULL or $memory.value <0 }}RhombusRed.gif{{elseif $memory.value < $memory.lowvalue or $memory.value > $memory.highvalue}}RhombusYellow.gif{{else}}RhombusGreen.gif{{/if}}' width='16' height='16' id='imgb7a1'>","","","","",""));
											
								
											
											//tree6.addNode(new MTreeNode("b8","b11","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_a1_b8'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostping&ip={{$ip}}','rightmain');>ping 时延</span>","<img src='{{$template_root}}/images/RhombusGreen.gif' width='16' height='16' id='imgb8a1'>","","","","",""));
											
											{{section name=d loop=$snmpstatus}}
											tree6.addNode(new MTreeNode("b8{{$smarty.section.d.index}}","b12","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_a1_b8'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=disk&id={{$snmpstatus[d].seq}}&ip={{$ip}}','rightmain');>{{$snmpstatus[d].disk}}</span>","<img src='{{$template_root}}/images/{{if $snmpstatus[d].value eq NULL or $snmpstatus[d].value <0 }}RhombusRed.gif{{elseif $snmpstatus[d].value < $snmpstatus[d].lowvalue or $snmpstatus[d].value > $snmpstatus[d].highvalue}}RhombusYellow.gif{{else}}RhombusGreen.gif{{/if}}' width='16' height='16' id='imgb8a1'>","","","","",""));
											{{/section}}

											{{section name=t loop=$tcpport}}
											tree6.addNode(new MTreeNode("b11{{$smarty.section.t.index}}","b11","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_a1_b8'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=tcpport&id={{$tcpport[t].seq}}&ip={{$ip}}','rightmain');>TCP {{$tcpport[t].tcpport}}</span>","<img src='{{$template_root}}/images/{{if $tcpport[t].value eq NULL or $tcpport[t].value <0 }}RhombusRed.gif{{elseif $tcpport[t].value < $tcpport[t].lowvalue or $tcpport[t].value > $tcpport[t].highvalue}}RhombusYellow.gif{{else}}RhombusGreen.gif{{/if}}' width='16' height='16' id='imgb8a1'>","","","","",""));
											{{/section}}
								
											
											tree6.addNode(new MTreeNode("b9","b5","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_a1_WindowHostCPUGroup'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=cpu&ip={{$ip}}','rightmain');>CPU类</span>","","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("b10","b5","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_a1_WindowHostMemGroup'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=memory&ip={{$ip}}','rightmain');>内存类</span>","","","","","",""));

											tree6.addNode(new MTreeNode("b12","b5","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_a1_WindowHostDiskGroup'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=disk&ip={{$ip}}','rightmain');>存贮类</span>","","","","","",""));
											
											
											
											tree6.addNode(new MTreeNode("b11","b5","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_a1_ConnectConfigurationGrp'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=tcpport&ip={{$ip}}','rightmain');>端口扫描类</span>","","","","","",""));							
									
											tree6.addNode(new MTreeNode("b13","a1","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span class='ly'>指标列表</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));

											tree6.addNode(new MTreeNode("b14","a1","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span class='ly'>应用监控</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));

											{{section name=ap loop=$apps}}
											tree6.addNode(new MTreeNode("{{$apps[ap].app_name}}","b14","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_nodehidden_availabilitymetrica1'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' >{{$apps[ap].app_name}}</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));	
											{{/section}}

											{{section name=app loop=$appdetail}}
											tree6.addNode(new MTreeNode("b141{{$smarty.section.app.index}}","{{$appdetail[app].app_name}}","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_nodehidden_availabilitymetrica1'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=appbytype&id={{$appdetail[app].seq}}&ip={{$ip}}','rightmain');>{{if $appdetail[app].app_name eq 'apache'}}{{if $appdetail[app].app_type eq 'cpu load'}}系统占用{{elseif $appdetail[app].app_type eq 'request rate'}}请求速率{{elseif $appdetail[app].app_type eq 'traffic rate'}}每秒流量 KB/s{{elseif $appdetail[app].app_type eq 'process num'}}当前进行数{{elseif $appdetail[app].app_type eq 'busy process'}}正在处理请求{{else}}未定义{{/if}}{{elseif $appdetail[app].app_name eq 'mysql'}}{{if $appdetail[app].app_type eq 'questions rate'}}查询速率{{elseif $appdetail[app].app_type eq 'open tables'}}打开表数{{elseif $appdetail[app].app_type eq 'open files'}}打开文件数{{elseif $appdetail[app].app_type eq 'threads'}}连接数{{else}}未定义{{/if}}{{elseif $appdetail[app].app_name eq 'tomcat'}}{{if $appdetail[app].app_type eq 'traffic rate'}}每秒流量 KB/s{{elseif $appdetail[app].app_type eq 'cpu load'}}CPU平均占用率 %{{elseif $appdetail[app].app_type eq 'request rate'}}每秒请求数量{{elseif $appdetail[app].app_type eq 'memory usage'}}当前jvm内存使用率{{elseif $appdetail[app].app_type eq 'busy thread'}}当前工作线程数{{else}}未定义{{/if}}{{elseif $appdetail[app].app_name eq 'nginx'}}{{if $appdetail[app].app_type eq 'request rate'}}nginx 请求率（点击率）{{elseif $appdetail[app].app_type eq 'connect num'}}nginx 连接数（并发数）{{elseif $appdetail[app].app_type eq 'server accept'}}处理连接数{{elseif $appdetail[app].app_type eq 'server handled'}}创建连接数{{elseif $appdetail[app].app_type eq 'reading num'}}读取客户端header信息数{{elseif $appdetail[app].app_type eq 'writing num'}}返回给客户端header信息数{{elseif $appdetail[app].app_type eq 'waiting num'}}nginx 等待连接数{{elseif $appdetail[app].app_type eq 'connect num'}}等待驻留连接{{else}}未定义{{/if}}{{/if}}</span>","<img src='{{$template_root}}/images/{{if $appdetail[app].value eq NULL or $appdetail[app].value <0 }}RhombusRed.gif{{elseif $appdetail[app].value < $appdetail[app].lowvalue or $appdetail[app].value > $appdetail[app].highvalue}}RhombusYellow.gif{{else}}RhombusGreen.gif{{/if}}' width='16' height='16' id='imgb8a1'>","","","","",""));	
											{{/section}}

											{{section name=appdns loop=$appdnsdetail}}
											tree6.addNode(new MTreeNode("b142{{$smarty.section.appdns.index}}","dns","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_nodehidden_availabilitymetrica1'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=appbytype&type=dns&id={{$appdnsdetail[appdns].id}}&ip={{$ip}}','rightmain');>{{if $appdnsdetail[appdns].type eq 1}}授权域可用性{{elseif $appdnsdetail[appdns].type eq 2}}非授权域可用性{{else}}未定义{{/if}}</span>","<img src='{{$template_root}}/images/{{if $appdnsdetail[appdns].delayvalue eq NULL or $appdnsdetail[appdns].delayvalue <0 }}RhombusRed.gif{{elseif $appdnsdetail[appdns].delayvalue < $appdnsdetail[appdns].lowvalue or $appdnsdetail[appdns].delayvalue > $appdnsdetail[appdns].highvalue}}RhombusYellow.gif{{else}}RhombusGreen.gif{{/if}}' width='16' height='16' id='imgb8a1'>","","","","",""));	
											{{/section}}
							
											
							 {{/if}}


											
														
								
		
								// 将对象结构转为html，写到网页中
								
										document.write("<div id='myspan'>");
										test=tree6.getTreeHtml();
										
										document.write(test);						
										document.write("</div>");
										//tree6.clickDemo('WindowHostName');

								tree6.expandAll();


							</script>
                  		</td>
                  	</tr>
                  
                  

				  </table>			    
                 </div>
                </td>
            </tr>
          </table>
<!-- 边框的结尾-->

</body>

</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
</body>
</html>
