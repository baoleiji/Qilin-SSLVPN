

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<LINK href="{{$template_root}}/cssjs/liye.css" type=text/css rel=stylesheet>
<SCRIPT src="{{$template_root}}/cssjs/MTree.js" type=text/javascript></SCRIPT>

</head>

<body> <!-- oncontextmenu="return false" -->
          <table width="235"  height="554" border="0" cellspacing="0" cellpadding="0" style="background-color:#F1F1F1">
            <tr>
                <td height="100%" align="left" valign="top" width="235">
			      <!-- 边框的头-->

				<div id="bangzi" style='border-top:#B1B5B9 1px solid; border-bottom:#B1B5B9 1px solid; border-left:#B1B5B9 1px solid; border-right:#B1B5B9 1px solid; text-align:left; position:relative; left:0; top:0; width:235px; height:554px; z-index:1; overflow: auto;'>
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
										//tree6.setAutoReload(); //是否动态生成
								
											
											tree6.addNode(new MTreeNode("aa","0","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<strong>I-I-I-I</strong>","<img id=stateimg src='{{$template_root}}/images/{{if $server.status eq 1}}Green.gif{{elseif $server.status eq 2}}GreenYellow.gif{{else}}GreenRed.gif{{/if}}' width='13' height='13'  style='cursor: hand' alt='点击浏览状态信息' onclick=openStatePage('aa')>&nbsp;","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("aanode_generalinfo","aa","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_aanode_generalinfo'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=ciscoview&ip={{$ip}}','rightmain');>常规信息</span>","<img src='{{$template_root}}/images/icon_cgxx.gif' width='16' height='16'>","","","","",""));
									
											tree6.addNode(new MTreeNode("aanode_eventmanage","aa","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_aanode_eventmanage'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=eventlogs&ip={{$ip}}','rightmain');>事件管理</span>","<img src='{{$template_root}}/images/ico-021.gif' width='16' height='16'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("aaperformancemetric","aametriclist","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_nodehidden_performancemetricaa'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('admin.php?controller=admin_detail&action=ciscoview&ip={{$ip}}','iframe2','focusNode_nodehidden_performancemetricaa','aa');>性能指标</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("SwitchAvgCPURate_adv","SwitchCPUGroupaa","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_aa_SwitchAvgCPURate_adv'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=cpu&ip={{$ip}}','rightmain');>CPU平均利用率</span>","<img src='{{$template_root}}/images/{{if $cpu.value eq NULL or $cpu.value <0 }}RhombusRed.gif{{elseif $cpu.value < $cpu.lowvalue or $cpu.value > $cpu.highvalue}}RhombusYellow.gif{{else}}RhombusGreen.gif{{/if}}' width='16' height='16' id='imgSwitchAvgCPURate_advaa'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("SwitchAvgMemUtilization_adv","SwitchMemGroupaa","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_aa_SwitchAvgMemUtilization_adv'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=window.open('admin.php?controller=admin_detail&action=hostbytype&type=memory&ip={{$ip}}','rightmain');>内存利用率</span>","<img src='{{$template_root}}/images/{{if $memory.value eq NULL or $memory.value <0 }}RhombusRed.gif{{elseif $memory.value < $memory.lowvalue or $memory.value > $memory.highvalue}}RhombusYellow.gif{{else}}RhombusGreen.gif{{/if}}' width='16' height='16' id='imgSwitchAvgMemUtilization_advaa'>","","","","",""));
											
								
											
										
											tree6.addNode(new MTreeNode("SwitchCPUGroupaa","aaperformancemetric","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_aa_SwitchCPUGroup'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/performanceMetric.jsp?metricgroupid=SwitchCPUGroup&instanceId=aa','iframe2','focusNode_aa_SwitchCPUGroup','aa');>CPU类</span>","","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("SwitchMemGroupaa","aaperformancemetric","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_aa_SwitchMemGroup'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/performanceMetric.jsp?metricgroupid=SwitchMemGroup&instanceId=aa','iframe2','focusNode_aa_SwitchMemGroup','aa');>内存类</span>","","","","","",""));
											
								
										
								
											
											tree6.addNode(new MTreeNode("aametriclist","aa","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span class='ly'>指标列表</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("aamonitorcomponent","aa","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span class='ly'>组件列表</span>","<img src='{{$template_root}}/images/jkzj.gif' width='16' height='16'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("aaSwitchCPU_adv","aamonitorcomponent","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_aaSwitchCPU_adv'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/childResourceIndex.jsp?instanceId=aa&resourceId=SwitchCPU_adv','iframe2','focusNode_aaSwitchCPU_adv','aa');>CPU</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("aaSwitchNetworkInterface_adv","aamonitorcomponent","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_aaSwitchNetworkInterface_adv'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/childResourceIndex.jsp?instanceId=aa&resourceId=SwitchNetworkInterface_adv','iframe2','focusNode_aaSwitchNetworkInterface_adv','aa');>网络接口</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));
											
								
		
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
