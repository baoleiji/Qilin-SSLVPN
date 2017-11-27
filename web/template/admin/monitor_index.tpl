<HTML><HEAD><TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=UTF-8">

<LINK rel=stylesheet type=text/css href="{{$template_root}}/all_purpose_style.css">
<script type="text/javascript" src="{{$template_root}}/cssjs/resourcePieChart.js"></script> 
<script src="{{$template_root}}/cssjs/MTree.js"></script>


<script	type="text/javascript">
<!--生成资源树的代码 -->
	var tree1 = new MTree("{{$template_root}}/images/treeImages");  //新建一个树的实
	tree1.setTreeName("tree1");  //为树命名，此处的参数应该与树的实例的名字一
	tree1.setAutoReload();//是否动态生
	

	tree1.addNode(new MTreeNode("Host_group","0",null,null,"","<span id='Host_group' class=ly title='主机'><img src='{{$template_root}}/images/ico-zhuji.gif'>主机</span>","","","","","",""));
	{{section name=h loop=$hosts}}
		tree1.addNode(new MTreeNode("{{$hosts[h].device_type}}","Host_group",null,null,"","<span id='WindowHost_snmp_resource' class=ly title='{{$hosts[h].device_type}}({{$hosts[h].ct}})'>{{$hosts[h].device_type}}({{$hosts[h].ct}})</span>","","","","","",""));
		{{section name=hh loop=$hosts[h].hosts}}
		tree1.addNode(new MTreeNode("{{$hosts[h].hosts[hh].ip}}","{{$hosts[h].device_type}}",null,null,"","<span id='{{$hosts[h].hosts[hh].ip}}' style=cursor:hand;  class=ly oncontextmenu=self.event.returnValue=false; title='ISA01'><nobr><img src='{{$template_root}}/images/{{if $hosts[h].hosts[hh].status eq 1}}Green.gif{{elseif $hosts[h].hosts[hh].status eq 2}}GreenYellow.gif{{else}}GreenRed.gif{{/if}}' onclick=gotoStateSearch('{{$hosts[h].hosts[hh].ip}}'); width=13/><a onclick=\"window.open ('admin.php?controller=admin_detail&ip={{$hosts[h].hosts[hh].ip}}', 'newwindow', 'height=' + screen.height + ',width=' + screen.width+'top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;\" href=\"#\" target=\"_blank\" >{{$hosts[h].hosts[hh].ip}}</a></nobr></span>","","","","","",""));
		{{/section}}
	{{/section}}

	var tree2 = new MTree("{{$template_root}}/images/treeImages");  //新建一个树的实
	tree2.setTreeName("tree2");  //为树命名，此处的参数应该与树的实例的名字
	tree2.setAutoReload();//是否动态生
	

	tree2.addNode(new MTreeNode("NetworkDevices_group","0",null,null,"","<span id='NetworkDevices_group' class=ly title='网络设备'><img src='{{$template_root}}/images/icon_trackback.gif'>网络设备</span>","","","","","",""));

	{{section name=n loop=$networks}}
		tree2.addNode(new MTreeNode("{{$networks[n].device_type}}","NetworkDevices_group",null,null,"","<span id='Switch_adv_resource' class=ly title='{{$networks[n].device_type}}({{$networks[n].ct}})'>{{$networks[n].device_type}}({{$networks[n].ct}})</span>","","","","","",""));
		{{section name=nn loop=$networks[n].hosts}}
		tree2.addNode(new MTreeNode("{{$networks[n].hosts[nn].ip}}","{{$networks[n].device_type}}",null,null,"","<span id='{{$networks[n].hosts[nn].ip}}' style=cursor:hand;  class=ly oncontextmenu=self.event.returnValue=false; title='ISA01'><nobr><img src='{{$template_root}}/images/{{if $networks[n].hosts[nn].status eq 1}}Green.gif{{elseif $networks[h].hosts[nn].status eq 2}}GreenYellow.gif{{else}}GreenRed.gif{{/if}}' onclick=gotoStateSearch('{{$networks[n].hosts[nn].ip}}'); width=13/><a onclick=\"window.open ('admin.php?controller=admin_detail&ip={{$networks[n].hosts[nn].ip}}&action=ciscoindex', 'newwindow', 'height=' + screen.height + ',width=' + screen.width+'top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;\" href=\"#\" target=\"_blank\" >{{$networks[n].hosts[nn].ip}}</a></nobr></span>","","","","","",""));
		{{/section}}
	{{/section}}

	
		
			var tree3 = new MTree("{{$template_root}}/images/treeImages");  //新建一个树的实
	tree3.setTreeName("tree3");  //为树命名，此处的参数应该与树的实例的名字
	tree3.setAutoReload();//是否动态生
	

	tree3.addNode(new MTreeNode("J2EEAppServer_group","0",null,null,"","<span id='J2EEAppServer_group' class=ly title='应用列表'><img src='{{$template_root}}/images/J2EE.gif'>应用列表</span>","","","","","",""));

	{{section name=k loop=$apps}}
		tree3.addNode(new MTreeNode("{{$apps[k].app_name}}","J2EEAppServer_group",null,null,"","<span id='Tomcat_base_resource' class=ly title='{{$apps[k].app_name}}({{$apps[k].ct}})'>{{$apps[k].app_name}}({{$apps[k].ct}})</span>","","","","","",""));
		{{section name=kk loop=$apps[k].hosts}}
		tree3.addNode(new MTreeNode("{{$apps[k].hosts[kk].ip}}","{{$apps[k].app_name}}",null,null,"","<span id='{{$apps[k].hosts[kk].ip}}' style=cursor:hand;  class=ly oncontextmenu=self.event.returnValue=false; title='ISA01'><nobr><img src='{{$template_root}}/images/{{if $apps[k].hosts[kk].status eq 1}}Green.gif{{elseif $apps[k].hosts[kk].status eq 2}}GreenYellow.gif{{else}}GreenRed.gif{{/if}}' onclick=gotoStateSearch('{{$apps[k].hosts[kk].ip}}'); width=13/><a onclick=\"window.open ('admin.php?controller=admin_detail&ip={{$apps[k].hosts[kk].ip}}', 'newwindow', 'height=' + screen.height + ',width=' + screen.width+'top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');return false;\" href=\"#\" target=\"_blank\" >{{$apps[k].hosts[kk].ip}}</a></nobr></span>","","","","","",""));
		{{/section}}
	{{/section}}

</script>
</head>
<BODY>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <TR>
    <TD class=hui_bj vAlign=middle>
    <DIV class=menu>
      <UL>
       <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=index">状态监控</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
		<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=system_monitor">系统监控</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
		<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=network_monitor">网络监控</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	</UL></DIV>
    </TD>
  </TR></table>
<TABLE border=0 cellSpacing=10 cellPadding=0 width="98%" bgColor=#ffffff  align=center>
  <TR>
    <TD valign="top"><TABLE style="BORDER-BOTTOM: #7cb9f2 1px solid; BORDER-LEFT: #7cb9f2 1px solid; BORDER-TOP: #7cb9f2 1px solid; BORDER-RIGHT: #7cb9f2 1px solid"  border=0 cellSpacing=0 cellPadding=0 width="100%">
      <TR>
        <Td class=list_bg borderColor=white><A  href="#"><strong>主机</strong></A></Td>
      </TR>
      <TR>
        <TD><TABLE width="100%" border=0 cellPadding=0 cellSpacing=0>
          <TBODY>
            <TR>
              <TD align=center vAlign=top bgColor=#ffffff><TABLE cellSpacing=0 cellPadding=0 width="98%" border=0>
                  <TBODY>
                    <TR>
                      <TD align=middle><img style="cursor:hand;" onclick="showImg('cpu利用率',event,'6');return false;" src="include/pChart2.1.3/graphgenerate2.php?data[]={{$hosts_status.0}}&data[]={{$nomonitorhosts}}&data[]={{$hosts_status.1}}&data[]={{$hosts_status.2}}&info[]={{$word_down}}&info[]={{$word_nomonitor}}&info[]={{$word_normal}}&info[]={{$word_overthold}}&graphtype=pie">
	
                      </TD>
                    </TR>
                   
                  </TBODY>
                </TABLE>
                  <TABLE cellSpacing=0 cellPadding=0 width="98%" border=0>
                    <TBODY>
                      <tr>
                        <td colspan="2"><table cellSpacing=0 width="100%" border=0>
                            <tr>
                              <td class=table-bottom-border width="5%">&nbsp;</td>
                              <td class=table-bottom-border width="15%"><NOBR><strong>状态</strong></NOBR></td>
                              <td class=table-bottom-border width="15%"><NOBR><strong>数量</strong></NOBR></td>
                              <td class=table-bottom-border width="30%">&nbsp;</td>
                              <td class=table-bottom-border width="15%"><NOBR><strong>状态</strong></NOBR></td>
                              <td class=table-bottom-border width="15%"><NOBR><strong>数量</strong></NOBR></td>
                              <td class=table-bottom-border >&nbsp;</td>
                            </tr>
                           <tr>
                              <td class=table-bottom-border >&nbsp;</td>
                              <td class=table-bottom-border><IMG width=13 align=absMiddle  style='cursor: hand' onClick="openResourceTypeListPage('0100101')" title="toolstip|ZH|可用性：可用&#10;|性&nbsp;&nbsp;&nbsp;&nbsp;能：正常" height=13 src="{{$template_root}}/images/Green.gif"></td>
                              <td class=table-bottom-border><SPAN style='cursor: hand' onClick="openResourceTypeListPage('0100101')"> {{$hosts_status.1}} </SPAN> </td>
                              <td class=table-bottom-border >&nbsp;</td>
                              <td class=table-bottom-border><IMG width=13 align=absMiddle  style='cursor: hand' onClick="openResourceTypeListPage('1010001')" title="toolstip|ZH|可用性：不可用&#10;|性&nbsp;&nbsp;&nbsp;&nbsp;能：-&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;" height=13 src="{{$template_root}}/images/Red.gif"></td>
                              <td class=table-bottom-border><SPAN style='cursor: hand' onClick="openResourceTypeListPage('1010001')"> {{$hosts_status.0}} </SPAN> </td>
                              <td class=table-bottom-border >&nbsp;</td>
                            </tr>
                            <tr>
                              <td class=table-bottom-border >&nbsp;</td>
                              <td class=table-bottom-border><IMG width=13 align=absMiddle  style='cursor: hand' onClick="openResourceTypeListPage('0101001')" title="toolstip|ZH|可用性：可用&#10;|性&nbsp;&nbsp;&nbsp;&nbsp;能：警告" height=13 src="{{$template_root}}/images/GreenYellow.gif"></td>
                              <td class=table-bottom-border><SPAN style='cursor: hand' onClick="openResourceTypeListPage('0101001')"> {{$hosts_status.2}} </SPAN> </td>
                              <td class=table-bottom-border >&nbsp;</td>
                              <td class=table-bottom-border><IMG width=13 align=absMiddle  style='cursor: hand' onClick="openResourceTypeListPage('0110001')" title="toolstip|ZH|可用性：可用&#10;|性&nbsp;&nbsp;&nbsp;&nbsp;能：严重" height=13 src="{{$template_root}}/images/Gray.gif"></td>
                              <td class=table-bottom-border><SPAN style='cursor: hand' onClick="openResourceTypeListPage('0110001')"> {{$nomonitorhosts}} </SPAN> </td>
                              <td class=table-bottom-border >&nbsp;</td>
                            </tr>
                          </table>
                        <td>          
                      </tr>
                      <tr height="22" valign="bottom" colspan="2">
                        <td align="center" class=table-bottom-border><NOBR><strong>合计</strong></NOBR> <SPAN style='cursor: hand' onClick="openResourceTypeListPage('all_stateid')"><nobr>&nbsp;{{$hosts_status.0+$nomonitorhosts+$hosts_status.1+$hosts_status.2}}&nbsp;</nobr></SPAN> </td>
                      </tr>
                    </TBODY>
                  </TABLE>
                <TABLE height=5 cellSpacing=0 cellPadding=0 width="98%"	border=0>
                    <TBODY>
                      <TR>
                        <TD></TD>
                      </TR>
                    </TBODY>
                  </TABLE>
                <TABLE cellSpacing=0 cellPadding=0 width="98%" border=0>
                    <TBODY>
                      <TR>
                        <TD vAlign=top height=219><TABLE
																style="BORDER-RIGHT: #79a0e1 1px solid; BORDER-TOP: #79a0e1 1px solid; BORDER-LEFT: #79a0e1 1px solid; BORDER-BOTTOM: #79a0e1 1px solid"
																cellSpacing=0 cellPadding=0 width="100%" border=0>
                            <TBODY>
                              <TR>
                                <TD vAlign=top rowSpan=3><TABLE height=5 cellSpacing=0 cellPadding=0
																			width="100%" border=0>
                                    <TBODY>
                                      <TR>
                                        <TD></TD>
                                      </TR>
                                    </TBODY>
                                  </TABLE>
                                    <!-- *****************************************************  -->
                                    <div id="leftdiv" style="height:290px;width:99%;overflow:auto; text-align:left;">
                                      <TABLE cellSpacing=0 cellPadding=0 width="95%"
																			border=0>
                                        <TBODY>
                                          <TR>
                                            <TD vAlign=center align=left width="202px"><script language="javascript">
																							//将对象结构转为html，写到网页中
																							var treehtml1=tree1.getTreeHtml();																							
																							document.write(treehtml1);
																							document.close();
																						</script>
                                            </TD>
                                          </TR>
                                        </TBODY>
                                      </TABLE>
                                    </div>
                                  <!-- ***************************************************** -->
                                                </TBODY>
                        </TABLE></TD>
                      </TR>
                    </TBODY>
                </TABLE></TD>
            </TR>
          </TBODY>
        </TABLE></TD>
      </TR>
    </TABLE></TD>
    <TD vAlign=top><TABLE style="BORDER-BOTTOM: #7cb9f2 1px solid; BORDER-LEFT: #7cb9f2 1px solid; BORDER-TOP: #7cb9f2 1px solid; BORDER-RIGHT: #7cb9f2 1px solid"  border=0 cellSpacing=0 cellPadding=0 width="100%">
      <TR>
        <TH class=list_bg borderColor=white><A  href="#"><strong>网络设备</strong></A></TH>
      </TR>
      <TR>
        <TD><TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
          <TBODY>
            <TR>
              <TD align=center vAlign=top bgColor=#ffffff><TABLE cellSpacing=0 cellPadding=0 width="98%" border=0>
                  <TBODY>
                    <TR>
                      <TD align=middle><img style="cursor:hand;" onclick="showImg('cpu利用率',event,'6');return false;" src="include/pChart2.1.3/graphgenerate2.php?data[]={{$networks_status.0}}&data[]={{$nomonitornetworks}}&data[]={{$networks_status.1}}&data[]={{$networks_status.2}}&info[]={{$word_down}}&info[]={{$word_nomonitor}}&info[]={{$word_normal}}&info[]={{$word_overthold}}&graphtype=pie">
																					   </TD>
                    </TR>
                    
                  </TBODY>
                </TABLE>
                  <TABLE cellSpacing=0 cellPadding=0 width="98%" border=0>
                    <TBODY>
                      <tr>
                        <td colspan="2"><table cellSpacing=0 cellPadding=0 width="100%" border=0>
                            <tr>
                              <td class=table-bottom-border width="5%">&nbsp;</td>
                              <td class=table-bottom-border width="15%"><NOBR><strong>状态</strong></NOBR></td>
                              <td class=table-bottom-border width="15%"><NOBR><strong>数量</strong></NOBR></td>
                              <td class=table-bottom-border width="30%">&nbsp;</td>
                              <td class=table-bottom-border width="15%"><NOBR><strong>状态</strong></NOBR></td>
                              <td class=table-bottom-border width="15%"><NOBR><strong>数量</strong></NOBR></td>
                              <td class=table-bottom-border >&nbsp;</td>
                            </tr>
                            <tr>
                              <td class=table-bottom-border >&nbsp;</td>
                              <td class=table-bottom-border><IMG width=13 align=absMiddle  style='cursor: hand' onClick="openResourceTypeListPage('0100101')" title="toolstip|ZH|可用性：可用&#10;|性&nbsp;&nbsp;&nbsp;&nbsp;能：正常" height=13 src="{{$template_root}}/images/Green.gif"></td>
                              <td class=table-bottom-border><SPAN style='cursor: hand' onClick="openResourceTypeListPage('0100101')"> {{$networks_status.1}} </SPAN> </td>
                              <td class=table-bottom-border >&nbsp;</td>
                              <td class=table-bottom-border><IMG width=13 align=absMiddle  style='cursor: hand' onClick="openResourceTypeListPage('1010001')" title="toolstip|ZH|可用性：不可用&#10;|性&nbsp;&nbsp;&nbsp;&nbsp;能：-&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;" height=13 src="{{$template_root}}/images/Red.gif"></td>
                              <td class=table-bottom-border><SPAN style='cursor: hand' onClick="openResourceTypeListPage('1010001')"> {{$networks_status.0}} </SPAN> </td>
                              <td class=table-bottom-border >&nbsp;</td>
                            </tr>
                            <tr>
                              <td class=table-bottom-border >&nbsp;</td>
                              <td class=table-bottom-border><IMG width=13 align=absMiddle  style='cursor: hand' onClick="openResourceTypeListPage('0101001')" title="toolstip|ZH|可用性：可用&#10;|性&nbsp;&nbsp;&nbsp;&nbsp;能：警告" height=13 src="{{$template_root}}/images/GreenYellow.gif"></td>
                              <td class=table-bottom-border><SPAN style='cursor: hand' onClick="openResourceTypeListPage('0101001')"> {{$networks_status.2}} </SPAN> </td>
                              <td class=table-bottom-border >&nbsp;</td>
                              <td class=table-bottom-border><IMG width=13 align=absMiddle  style='cursor: hand' onClick="openResourceTypeListPage('0110001')" title="toolstip|ZH|可用性：可用&#10;|性&nbsp;&nbsp;&nbsp;&nbsp;能：严重" height=13 src="{{$template_root}}/images/Gray.gif"></td>
                              <td class=table-bottom-border><SPAN style='cursor: hand' onClick="openResourceTypeListPage('0110001')"> {{$nomonitornetworks}} </SPAN> </td>
                              <td class=table-bottom-border >&nbsp;</td>
                            </tr>
                          
                          </table>
                        <td>                      </tr>
                      <tr height="22" valign="bottom" colspan="2">
                        <td align="center" class=table-bottom-border><NOBR><strong>合计</strong></NOBR> <SPAN style='cursor: hand' onClick="openResourceTypeListPage('all_stateid')"><nobr>&nbsp;{{$networks_status.0+$networks_status.1+$networks_status.2+$nomonitornetworks}}&nbsp;</nobr></SPAN> </td>
                      </tr>
                    </TBODY>
                  </TABLE>
                  <TABLE height=5 cellSpacing=0 cellPadding=0 width="98%"	border=0>
                    <TBODY>
                      <TR>
                        <TD></TD>
                      </TR>
                    </TBODY>
                  </TABLE>
                <TABLE cellSpacing=0 cellPadding=0 width="98%" border=0>
                    <TBODY>
                      <TR>
                        <TD vAlign=top height=219><TABLE
																style="BORDER-RIGHT: #79a0e1 1px solid; BORDER-TOP: #79a0e1 1px solid; BORDER-LEFT: #79a0e1 1px solid; BORDER-BOTTOM: #79a0e1 1px solid"
																cellSpacing=0 cellPadding=0 width="100%" border=0>
                            <TBODY>
                              <TR>
                                <TD vAlign=top rowSpan=3><TABLE height=5 cellSpacing=0 cellPadding=0
																			width="100%" border=0>
                                    <TBODY>
                                      <TR>
                                        <TD></TD>
                                      </TR>
                                    </TBODY>
                                  </TABLE>
                                    <!-- *****************************************************  -->
                                    <div id="leftdiv3" style="height:290px;width:99%;overflow:auto; text-align:left;">
                                      <TABLE cellSpacing=0 cellPadding=0 width="95%"
																			border=0>
                                        <TBODY>
                                          <TR>
                                            <TD vAlign=center align=left width="202px"><script language="javascript">
																							//将对象结构转为html，写到网页中
																							var treehtml2=tree2.getTreeHtml();																							
																							document.write(treehtml2);
																							document.close();
																						</script>                                            </TD>
                                          </TR>
                                        </TBODY>
                                      </TABLE>
                                    </div>
                                  <!-- ***************************************************** -->
                                                </TBODY>
                        </TABLE></TD>
                      </TR>
                    </TBODY>
                </TABLE></TD>
              </TR>
          </TBODY>
        </TABLE></TD>
      </TR>
    </TABLE></TD>
    <TD vAlign=top><TABLE style="BORDER-BOTTOM: #7cb9f2 1px solid; BORDER-LEFT: #7cb9f2 1px solid; BORDER-TOP: #7cb9f2 1px solid; BORDER-RIGHT: #7cb9f2 1px solid"  border=0 cellSpacing=0 cellPadding=0 width="100%">
      <TR>
        <TH class=list_bg borderColor=white><A  href="#"><strong>应用</strong></A></TH>
      </TR>
      <TR>
        <TD><TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
          <TBODY>
            <TR>
              <TD align=center vAlign=top bgColor=#ffffff><TABLE cellSpacing=0 cellPadding=0 width="98%" border=0>
                  <TBODY>
                    <TR>
                      <TD align=middle>
					  <img style="cursor:hand;" onclick="showImg('cpu利用率',event,'6');return false;" src="include/pChart2.1.3/graphgenerate2.php?data[]={{$apps_status.0}}&data[]={{$nomonitorapp}}&data[]={{$apps_status.1}}&data[]={{$apps_status.2}}&info[]={{$word_down}}&info[]={{$word_nomonitor}}&info[]={{$word_normal}}&info[]={{$word_overthold}}&graphtype=pie&datatype=app"> </TD>
                    </TR>
                   
                  </TBODY>
                </TABLE>
                  <TABLE cellSpacing=0 cellPadding=0 width="98%" border=0>
                    <TBODY>
                      <tr>
                        <td colspan="2"><table cellSpacing=0 cellPadding=0 width="100%" border=0>
                            <tr>
                              <td class=table-bottom-border width="5%">&nbsp;</td>
                              <td class=table-bottom-border width="15%"><NOBR><strong>状态</strong></NOBR></td>
                              <td class=table-bottom-border width="15%"><NOBR><strong>数量</strong></NOBR></td>
                              <td class=table-bottom-border width="30%">&nbsp;</td>
                              <td class=table-bottom-border width="15%"><NOBR><strong>状态</strong></NOBR></td>
                              <td class=table-bottom-border width="15%"><NOBR><strong>数量</strong></NOBR></td>
                              <td class=table-bottom-border >&nbsp;</td>
                            </tr>
                           <tr>
                              <td class=table-bottom-border >&nbsp;</td>
                              <td class=table-bottom-border><IMG width=13 align=absMiddle  style='cursor: hand' onClick="openResourceTypeListPage('0100101')" title="toolstip|ZH|可用性：可用&#10;|性&nbsp;&nbsp;&nbsp;&nbsp;能：正常" height=13 src="{{$template_root}}/images/Green.gif"></td>
                              <td class=table-bottom-border><SPAN style='cursor: hand' onClick="openResourceTypeListPage('0100101')"> {{$apps_status.1}} </SPAN> </td>
                              <td class=table-bottom-border >&nbsp;</td>
                              <td class=table-bottom-border><IMG width=13 align=absMiddle  style='cursor: hand' onClick="openResourceTypeListPage('1010001')" title="toolstip|ZH|可用性：不可用&#10;|性&nbsp;&nbsp;&nbsp;&nbsp;能：-&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;" height=13 src="{{$template_root}}/images/Red.gif"></td>
                              <td class=table-bottom-border><SPAN style='cursor: hand' onClick="openResourceTypeListPage('1010001')"> {{$apps_status.0}} </SPAN> </td>
                              <td class=table-bottom-border >&nbsp;</td>
                            </tr>
                            <tr>
                              <td class=table-bottom-border >&nbsp;</td>
                              <td class=table-bottom-border><IMG width=13 align=absMiddle  style='cursor: hand' onClick="openResourceTypeListPage('0101001')" title="toolstip|ZH|可用性：可用&#10;|性&nbsp;&nbsp;&nbsp;&nbsp;能：警告" height=13 src="{{$template_root}}/images/GreenYellow.gif"></td>
                              <td class=table-bottom-border><SPAN style='cursor: hand' onClick="openResourceTypeListPage('0101001')"> {{$apps_status.2}} </SPAN> </td>
                              <td class=table-bottom-border >&nbsp;</td>
                              <td class=table-bottom-border>&nbsp;</td>
                              <td class=table-bottom-border><SPAN style='cursor: hand' onClick="openResourceTypeListPage('0110001')">  </SPAN> </td>
                              <td class=table-bottom-border >&nbsp;</td>
                            </tr>
                          </table>
                        <td>                      </tr>
                      <tr height="22" valign="bottom" colspan="2">
                        <td align="center" class=table-bottom-border><NOBR><strong>合计</strong></NOBR> <SPAN style='cursor: hand' onClick="openResourceTypeListPage('all_stateid')"><nobr>&nbsp;{{$apps_status.0+$apps_status.1+$apps_status.2}}&nbsp;</nobr></SPAN> </td>
                      </tr>
                    </TBODY>
                  </TABLE>
                <TABLE height=5 cellSpacing=0 cellPadding=0 width="98%"	border=0>
                    <TBODY>
                      <TR>
                        <TD></TD>
                      </TR>
                    </TBODY>
                  </TABLE>
                <TABLE cellSpacing=0 cellPadding=0 width="98%" border=0>
                    <TBODY>
                      <TR>
                        <TD vAlign=top height=219><TABLE
																style="BORDER-RIGHT: #79a0e1 1px solid; BORDER-TOP: #79a0e1 1px solid; BORDER-LEFT: #79a0e1 1px solid; BORDER-BOTTOM: #79a0e1 1px solid"
																cellSpacing=0 cellPadding=0 width="100%" border=0>
                            <TBODY>
                              <TR>
                                <TD vAlign=top rowSpan=3><TABLE height=5 cellSpacing=0 cellPadding=0
																			width="100%" border=0>
                                    <TBODY>
                                      <TR>
                                        <TD></TD>
                                      </TR>
                                    </TBODY>
                                  </TABLE>
                                    <!-- *****************************************************  -->
                                    <div id="leftdiv2" style="height:290px;width:99%;overflow:auto; text-align:left;">
                                      <TABLE cellSpacing=0 cellPadding=0 width="95%"
																			border=0>
                                        <TBODY>
                                          <TR>
                                            <TD vAlign=center align=left width="202px"><script language="javascript">
																							//将对象结构转为html，写到网页中
																							var treehtml3=tree3.getTreeHtml();																							
																							document.write(treehtml3);
																							document.close();
																						</script>                                            </TD>
                                          </TR>
                                        </TBODY>
                                      </TABLE>
                                    </div>
                                  <!-- ***************************************************** -->
                                                </TBODY>
                        </TABLE></TD>
                      </TR>
                    </TBODY>
                </TABLE></TD>
              </TR>
          </TBODY>
        </TABLE></TD>
      </TR>
    </TABLE></TD>
  </TR>
</TABLE>
</HTML>
