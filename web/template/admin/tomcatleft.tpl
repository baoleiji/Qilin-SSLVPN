
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<LINK href="{{$template_root}}/cssjs/liye.css" type=text/css rel=stylesheet>
<SCRIPT src="{{$template_root}}/cssjs/MTree.js" type=text/javascript></SCRIPT>

</head>
<body>

          <table width="225"  height="554" border="0" cellspacing="0" cellpadding="0" style="background-color:#F1F1F1">
            <tr>
                <td height="100%" align="left" valign="top" width="225">
			      <!-- 边框的头-->

				<div id="bangzi" style='border-top:#B1B5B9 1px solid; border-bottom:#B1B5B9 1px solid; border-left:#B1B5B9 1px solid; border-right:#B1B5B9 1px solid; text-align:left; position:relative; left:0; top:0; width:225px; height:554px; z-index:1; overflow: auto;'>
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
								
											
											tree6.addNode(new MTreeNode("C804375CBAF287CE2D5BF3F80981A829A8DB1DF7","0","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<strong>10.1.1.171_80</strong>","<img id=stateimg src='{{$template_root}}/images/{{if $server.status eq 1}}Green.gif{{elseif $server.status eq 2}}GreenYellow.gif{{else}}GreenRed.gif{{/if}}' width='13' height='13'  style='cursor: hand' alt='点击浏览状态信息' onclick=openStatePage('C804375CBAF287CE2D5BF3F80981A829A8DB1DF7')>&nbsp;","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("C804375CBAF287CE2D5BF3F80981A829A8DB1DF7node_generalinfo","C804375CBAF287CE2D5BF3F80981A829A8DB1DF7","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7node_generalinfo'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/generalInfo.jsp?instanceId=C804375CBAF287CE2D5BF3F80981A829A8DB1DF7&rootResourceId=Tomcat_base','iframe2','focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7node_generalinfo','C804375CBAF287CE2D5BF3F80981A829A8DB1DF7');>常规信息</span>","<img src='{{$template_root}}/images/icon_cgxx.gif' width='16' height='16'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("C804375CBAF287CE2D5BF3F80981A829A8DB1DF7node_importantmentmetric","C804375CBAF287CE2D5BF3F80981A829A8DB1DF7","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7node_importantmentmetric'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/hostStateIndex.jsp?instanceId=C804375CBAF287CE2D5BF3F80981A829A8DB1DF7&rootResourceId=Tomcat_base','iframe2','focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7node_importantmentmetric','C804375CBAF287CE2D5BF3F80981A829A8DB1DF7');>问题指标和组件</span>","<img src='{{$template_root}}/images/tjzb.gif' width='16' height='16'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("C804375CBAF287CE2D5BF3F80981A829A8DB1DF7node_eventmanage","C804375CBAF287CE2D5BF3F80981A829A8DB1DF7","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7node_eventmanage'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/EventListIndex.jsp?instanceId=C804375CBAF287CE2D5BF3F80981A829A8DB1DF7&rootResourceId=Tomcat_base','iframe2','focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7node_eventmanage','C804375CBAF287CE2D5BF3F80981A829A8DB1DF7');>事件管理</span>","<img src='{{$template_root}}/images/ico-021.gif' width='16' height='16'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("C804375CBAF287CE2D5BF3F80981A829A8DB1DF7availabilitymetric","C804375CBAF287CE2D5BF3F80981A829A8DB1DF7metriclist","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_nodehidden_availabilitymetricC804375CBAF287CE2D5BF3F80981A829A8DB1DF7'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/availabilityMetric.jsp?instanceId=C804375CBAF287CE2D5BF3F80981A829A8DB1DF7','iframe2','focusNode_nodehidden_availabilitymetricC804375CBAF287CE2D5BF3F80981A829A8DB1DF7','C804375CBAF287CE2D5BF3F80981A829A8DB1DF7');>可用性指标</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("C804375CBAF287CE2D5BF3F80981A829A8DB1DF7performancemetric","C804375CBAF287CE2D5BF3F80981A829A8DB1DF7metriclist","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_nodehidden_performancemetricC804375CBAF287CE2D5BF3F80981A829A8DB1DF7'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/performanceMetric.jsp?instanceId=C804375CBAF287CE2D5BF3F80981A829A8DB1DF7','iframe2','focusNode_nodehidden_performancemetricC804375CBAF287CE2D5BF3F80981A829A8DB1DF7','C804375CBAF287CE2D5BF3F80981A829A8DB1DF7');>性能指标</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("TomcatSystemCPUUtilization_base","TomcatCPUGroupC804375CBAF287CE2D5BF3F80981A829A8DB1DF7","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7_TomcatSystemCPUUtilization_base'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/metricInfo.jsp?metricid=TomcatSystemCPUUtilization_base&instanceId=C804375CBAF287CE2D5BF3F80981A829A8DB1DF7','iframe2','focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7_TomcatSystemCPUUtilization_base','C804375CBAF287CE2D5BF3F80981A829A8DB1DF7');>系统CPU利用率</span>","<img src='{{$template_root}}/images/RhombusGray.gif' width='16' height='16' id='imgTomcatSystemCPUUtilization_baseC804375CBAF287CE2D5BF3F80981A829A8DB1DF7'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("TomcatCPUUtilization_base","TomcatCPUGroupC804375CBAF287CE2D5BF3F80981A829A8DB1DF7","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7_TomcatCPUUtilization_base'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/metricInfo.jsp?metricid=TomcatCPUUtilization_base&instanceId=C804375CBAF287CE2D5BF3F80981A829A8DB1DF7','iframe2','focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7_TomcatCPUUtilization_base','C804375CBAF287CE2D5BF3F80981A829A8DB1DF7');>Tomcat CPU利用率</span>","<img src='{{$template_root}}/images/RhombusGray.gif' width='16' height='16' id='imgTomcatCPUUtilization_baseC804375CBAF287CE2D5BF3F80981A829A8DB1DF7'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("TomcatSystemMemoryUtilization_base","TomcatMemoryGroupC804375CBAF287CE2D5BF3F80981A829A8DB1DF7","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7_TomcatSystemMemoryUtilization_base'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/metricInfo.jsp?metricid=TomcatSystemMemoryUtilization_base&instanceId=C804375CBAF287CE2D5BF3F80981A829A8DB1DF7','iframe2','focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7_TomcatSystemMemoryUtilization_base','C804375CBAF287CE2D5BF3F80981A829A8DB1DF7');>系统内存利用率</span>","<img src='{{$template_root}}/images/RhombusGray.gif' width='16' height='16' id='imgTomcatSystemMemoryUtilization_baseC804375CBAF287CE2D5BF3F80981A829A8DB1DF7'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("TomcatJVMMemoryUtilization_base","TomcatMemoryGroupC804375CBAF287CE2D5BF3F80981A829A8DB1DF7","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7_TomcatJVMMemoryUtilization_base'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/metricInfo.jsp?metricid=TomcatJVMMemoryUtilization_base&instanceId=C804375CBAF287CE2D5BF3F80981A829A8DB1DF7','iframe2','focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7_TomcatJVMMemoryUtilization_base','C804375CBAF287CE2D5BF3F80981A829A8DB1DF7');>JVM内存利用率</span>","<img src='{{$template_root}}/images/RhombusGray.gif' width='16' height='16' id='imgTomcatJVMMemoryUtilization_baseC804375CBAF287CE2D5BF3F80981A829A8DB1DF7'>","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("TomcatCPUGroupC804375CBAF287CE2D5BF3F80981A829A8DB1DF7","C804375CBAF287CE2D5BF3F80981A829A8DB1DF7performancemetric","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7_TomcatCPUGroup'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/performanceMetric.jsp?metricgroupid=TomcatCPUGroup&instanceId=C804375CBAF287CE2D5BF3F80981A829A8DB1DF7','iframe2','focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7_TomcatCPUGroup','C804375CBAF287CE2D5BF3F80981A829A8DB1DF7');>CPU</span>","","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("TomcatMemoryGroupC804375CBAF287CE2D5BF3F80981A829A8DB1DF7","C804375CBAF287CE2D5BF3F80981A829A8DB1DF7performancemetric","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span id='focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7_TomcatMemoryGroup'; style='cursor:hand; border: 0px solid ; overflow: hidden; text-overflow:ellipsis'  class='ly' onclick=parent.giveDisplay_block();hrefFrame('plugins/common/detail/performanceMetric.jsp?metricgroupid=TomcatMemoryGroup&instanceId=C804375CBAF287CE2D5BF3F80981A829A8DB1DF7','iframe2','focusNode_C804375CBAF287CE2D5BF3F80981A829A8DB1DF7_TomcatMemoryGroup','C804375CBAF287CE2D5BF3F80981A829A8DB1DF7');>内存</span>","","","","","",""));
											
								
											
											tree6.addNode(new MTreeNode("C804375CBAF287CE2D5BF3F80981A829A8DB1DF7metriclist","C804375CBAF287CE2D5BF3F80981A829A8DB1DF7","{{$template_root}}/images/tree{{$template_root}}/images/open.gif","{{$template_root}}/images/tree{{$template_root}}/images/close.gif","","<span class='ly'>指标列表</span>","<img src='{{$template_root}}/images/ico_zblb.gif' width='16' height='16'>","","","","",""));
											
								
		
								// 将对象结构转为html，写到网页中
								
										document.write("<div id='myspan'>");
										test=tree6.getTreeHtml();
										
										document.write(test);						
										document.write("</div>");
										//tree6.clickDemo('WindowHostName');

								
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
