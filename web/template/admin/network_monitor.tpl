
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd"><HTML 
xmlns="http://www.w3.org/1999/xhtml"><HEAD><META content="IE=10.000" 
http-equiv="X-UA-Compatible">
 <TITLE>OSSIM框架</TITLE> 
<META http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<META http-equiv="Pragma" content="no-cache"> <LINK href="template/admin/all_purpose_style.css" 
rel="stylesheet" type="text/css"> 
<STYLE>HTML {
	MARGIN: 0px; HEIGHT: 100%; FONT-SIZE: 12px
}
BODY {
	MARGIN: 0px; HEIGHT: 100%; FONT-SIZE: 12px
}
.mesWindow {
	BORDER-BOTTOM: #666 1px solid; BORDER-LEFT: #666 1px solid; BACKGROUND: #fff; BORDER-TOP: #666 1px solid; BORDER-RIGHT: #666 1px solid
}
.mesWindowTop {
	BORDER-BOTTOM: #eee 1px solid; TEXT-ALIGN: left; PADDING-BOTTOM: 3px; PADDING-LEFT: 3px; PADDING-RIGHT: 3px; MARGIN-LEFT: 4px; FONT-SIZE: 12px; FONT-WEIGHT: bold; PADDING-TOP: 3px
}
.mesWindowContent {
	MARGIN: 4px; FONT-SIZE: 12px
}
.mesWindow .close {
	BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; WIDTH: 28px; BACKGROUND: #fff; HEIGHT: 15px; BORDER-TOP: medium none; CURSOR: pointer; BORDER-RIGHT: medium none; TEXT-DECORATION: underline
}
.div_s_title {
	width:100%; }
.div_scrollbar {
	width:100%;   height:152px;   z-index:1;   overflow:auto;SCROLLBAR-FACE-COLOR: #ffffff; SCROLLBAR-HIGHLIGHT-COLOR: #f3f3f3; SCROLLBAR-SHADOW-COLOR: COLOR:#000000 ; SCROLLBAR-3DLIGHT-COLOR: #ffffff; SCROLLBAR-ARROW-COLOR: #006c90;  SCROLLBAR-DARKSHADOW-COLOR: #ffffff;  
}
</STYLE>
 
<SCRIPT type="text/javascript">


var interfacesct = new Array();
var interfacesid = new Array();
</SCRIPT>
 
<META name="GENERATOR" content="MSHTML 10.00.9200.16635"></HEAD> 
<BODY>
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
        <TR>
          <TD class="hui_bj" valign="middle">
          <DIV class=menu>
      <UL>
		<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=index">状态监控</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
		<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=system_monitor">系统监控</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
		<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=network_monitor">网络监控</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
        </UL></DIV>
        
       </TD></TR>
     <TR>
    <TD>
      <TABLE width="100%" align="center"  border="0" cellspacing="0" cellpadding="8">
        <TR id="network_port1_tr">
          <TD class="main_title_td">
            <TABLE width="99%" height="200" border="0" cellspacing="0" 
            cellpadding="3" class="BBtable">
              
              <tr>
            <td align="center"><a href="#" id="traffic_a" ><img width="480" height="220" id="traffic_graph" src="template/admin/images/nopic.jpg"></a></td>
        
            <td align="center"><a href="#" id="package_a" ><img width="480" height="220" id="package_graph" src="template/admin/images/nopic.jpg"></a></td>
          </tr>
		  </TABLE>
              
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="div_s_title" >
                      <TABLE width="99%" border="0" cellpadding="0" cellspacing="0" class="BBtable" >
                        <TR>
                          <TD width="2%" bgcolor="#b9dbfb"></TD>
                          <TD align="center" bgcolor="#b9dbfb">主机IP</TD>
                          <TD width="13%" align="center" bgcolor="#b9dbfb">主机名</TD>
                          <TD width="13%" align="center" bgcolor="#b9dbfb">运行时间</TD>
                          <TD width="13%" align="center" bgcolor="#b9dbfb">接口数</TD>
                          <TD width="13%" align="center" bgcolor="#b9dbfb">启用接口</TD>
                          <TD width="13%" align="center" bgcolor="#b9dbfb">禁用接口</TD>
                        </TR>
                      </TABLE>
                    </div>
                      <DIV  class="div_scrollbar" >
                        <TABLE width="100%" border="0" cellpadding="0"    cellspacing="0" class="BBtable" id="port1_network" >
                         {{section name=n loop=$network}}
		  <TR onclick="change_network({{$smarty.section.n.index}})">
			<TD width="2%" class="main_list_td1"><img id="_id_{{$smarty.section.n.index}}" src="template/admin/images/lv_dot.gif" width="13" height="13"></TD>
			<TD class="main_list_td1">{{$network[n].device_ip}}</TD>
			<TD width="13%" class="main_list_td1">{{$network[n].hostname}}</TD>
			<TD width="13%" class="main_list_td1">{{$network[n].snmptime_diff}}</TD>
			<TD width="13%" class="main_list_td1">{{$network[n].ct}}</TD>
			<TD width="13%" class="main_list_td1">{{$network[n].runct}}</TD>
			<TD width="13%" class="main_list_td1">{{$network[n].cutct}}</TD>
		  </TR>
		  
		 {{/section}}
                        </TABLE>
                      </DIV>
                      <div class="div_s_title" >
                        <TABLE width="100%" border="0" cellpadding="0"  cellspacing="0" class="BBtable"  valign="top">
                          <TR>
			  <td width="2%" bgcolor="#b9dbfb" class="main_list_title1">&nbsp;</td>
			  <TD width="20%" bgcolor="#b9dbfb" class="main_list_title1"><a id="t_a_port_describe" href="admin.php?controller=admin_monitor&action=network_monitor&orderby1=port_describe&orderby2={{$orderby2}}">网络接口</a></TD>
			  <TD width="13%" bgcolor="#b9dbfb" class="main_list_title1"><a id="t_a_cur_status" href="admin.php?controller=admin_monitor&action=network_monitor&orderby1=cur_status&orderby2={{$orderby2}}">当前状态</a></TD>
			  <TD width="13%" bgcolor="#b9dbfb" class="main_list_title1"><a id="t_a_connectdevice" href="admin.php?controller=admin_monitor&action=network_monitor&orderby1=connectdevice&orderby2={{$orderby2}}">对端设备</a></TD>
			  <TD width="13%" bgcolor="#b9dbfb" class="main_list_title1"><a id="t_a_connectdeviceport" href="admin.php?controller=admin_monitor&action=network_monitor&orderby1=connectdeviceport&orderby2={{$orderby2}}">对端接口</a></TD>
			  <TD width="13%" bgcolor="#b9dbfb" class="main_list_title1">流量(<a id="t_a_traffic_in" href="admin.php?controller=admin_monitor&action=network_monitor&orderby1=traffic_in&orderby2={{$orderby2}}">入</a>/<a  id="t_a_traffic_out" href="admin.php?controller=admin_monitor&action=network_monitor&orderby1=traffic_out&orderby2={{$orderby2}}">出</a>)</TD>
			  <TD width="13%" bgcolor="#b9dbfb" class="main_list_title1">包速率(<a  id="t_a_packet_in" href="admin.php?controller=admin_monitor&action=network_monitor&orderby1=packet_in&orderby2={{$orderby2}}">入</a>/<a  id="t_a_packet_out" href="admin.php?controller=admin_monitor&action=network_monitor&orderby1=packet_out&orderby2={{$orderby2}}">出</a>)</TD>
			  <TD width="13%" bgcolor="#b9dbfb" class="main_list_title1">错包(<a  id="t_a_err_packet_in" href="admin.php?controller=admin_monitor&action=network_monitor&orderby1=err_packet_in&orderby2={{$orderby2}}">入</a>/<a  id="t_a_err_packet_out" href="admin.php?controller=admin_monitor&action=network_monitor&orderby1=err_packet_out&orderby2={{$orderby2}}">出</a>)</TD>
			</TR>
                        </TABLE>
                      </div>
                     {{section name=nn loop=$network}}
		<script >
		interfacesid[{{$smarty.section.nn.index}}] = new Array();
		</script>
	
		
		<div id="_{{$smarty.section.nn.index}}" class="div_scrollbar" style="display:none">	 
		<TABLE align=center cellpadding="0" cellspacing="1"  valign="top"  class="BBtable" width="100%" >
			{{section name=i loop=$network[nn].interfaces}}
			<script >
			interfacesid[{{$smarty.section.nn.index}}][{{$smarty.section.i.index}}]={{$network[nn].interfaces[i].id}};
			</script>
			<TR onclick="change_network_interface({{$smarty.section.nn.index}},{{$smarty.section.i.index}},{{$smarty.section.nn.total}});">
			  <TD  width="2%" class="main_list_td1"><img id="_id_{{$smarty.section.nn.index}}_{{$smarty.section.i.index}}" src="template/admin/images/lv_dot.gif" width="13" height="13"></TD>
			  <TD width="20%" class="main_list_td1" title="{{$network[nn].interfaces[i].port_describe}}">{{$network[nn].interfaces[i].port_describe|truncate:30}}</TD>
			  <TD  width="13%" class="main_list_td1">{{$network[nn].interfaces[i].cur_status}}</TD>
			  <TD  width="13%" class="main_list_td1">{{$network[nn].interfaces[i].connectdevice}}</TD>
			  <TD  width="13%" class="main_list_td1">{{$network[nn].interfaces[i].connectdeviceport}}</TD>
			  <TD  width="13%" class="main_list_td1">{{$network[nn].interfaces[i].traffic_in}}/{{$network[nn].interfaces[i].traffic_out}}</TD>
			  <TD  width="13%" class="main_list_td1">{{$network[nn].interfaces[i].packet_in}}/{{$network[nn].interfaces[i].packet_out}}</TD>
			  <TD  width="13%" class="main_list_td1">{{$network[nn].interfaces[i].err_packet_in}}/{{$network[nn].interfaces[i].err_packet_out}}</TD>
			</TR>
			{{/section}}
			
			<!-- pagination -->
		  </TBODY>
		</TABLE>
	</div>
		<script >
		interfacesct[{{$smarty.section.nn.index}}]={{$smarty.section.i.total}};
		</script>
		{{/section}}
	</td></tr>
                </table>
              <div class="div_s_title" ></div>
          </TD></TR></TABLE></TR></TBODY></TABLE>
<SCRIPT>
var total = {{$smarty.section.n.total}};
function change_network(index){
	if(document.getElementById('_id_'+index)!=undefined)
	document.getElementById('_id_'+index).src='template/admin/images/lv_dot.gif';
	if(document.getElementById('_'+index)!=undefined)
	document.getElementById('_'+index).style.display='';
	document.getElementById('t_a_port_describe').href=document.getElementById('t_a_port_describe').href+'&index='+index;
	document.getElementById('t_a_cur_status').href=document.getElementById('t_a_cur_status').href+'&index='+index;
	document.getElementById('t_a_connectdevice').href=document.getElementById('t_a_connectdevice').href+'&index='+index;
	document.getElementById('t_a_connectdeviceport').href=document.getElementById('t_a_connectdeviceport').href+'&index='+index;
	document.getElementById('t_a_traffic_in').href=document.getElementById('t_a_traffic_in').href+'&index='+index;
	document.getElementById('t_a_traffic_out').href=document.getElementById('t_a_traffic_out').href+'&index='+index;
	document.getElementById('t_a_packet_in').href=document.getElementById('t_a_packet_in').href+'&index='+index;
	document.getElementById('t_a_packet_out').href=document.getElementById('t_a_packet_out').href+'&index='+index;
	document.getElementById('t_a_err_packet_in').href=document.getElementById('t_a_err_packet_in').href+'&index='+index;
	document.getElementById('t_a_err_packet_out').href=document.getElementById('t_a_err_packet_out').href+'&index='+index;
	for(var j=0; j<total; j++){
		 if(j==index) continue;
		document.getElementById('_id_'+j).src='template/admin/images/hui_dot.gif';
		document.getElementById('_'+j).style.display='none';
	}
	change_network_interface(index, 0);
}

function change_network_interface(ni,index){
	  if(interfacesid.length>0 && interfacesid[ni].length > 0){
	  document.getElementById('traffic_graph').src="admin.php?controller=admin_monitor&action=interface_image&type=traffic&id="+interfacesid[ni][index]+"&"+parseInt(10000*Math.random());
	 document.getElementById('package_graph').src="admin.php?controller=admin_monitor&action=interface_image&type=packet&id="+interfacesid[ni][index]+"&"+parseInt(10000*Math.random());
	}
	 for(var j=0; j<interfacesct[ni]; j++){
		document.getElementById('_id_'+ni+'_'+j).src='template/admin/images/hui_dot.gif';
	 }
	 if(document.getElementById('_id_'+ni+'_'+index)!=undefined)
	 document.getElementById('_id_'+ni+'_'+index).src='template/admin/images/lv_dot.gif';
}

change_network({{$index}});
 </SCRIPT>
 </BODY></HTML>
