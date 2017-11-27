<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>常规信息</title>


<LINK href="{{$template_root}}/cssjs/liye.css" type=text/css rel=stylesheet>
</head>

<body>
<div style='text-align:left; position:relative; left:0; top:0; width:100%; height:100%; overflow: auto;'>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width='5'>
			<img src='{{$template_root}}/images/spacer.gif' width='5'>
		</td>
		<td >
		<TABLE cellSpacing=0 cellPadding=0 align="left" border="0">
			<TBODY>
				<TR>
					<TD width="510">
					<TABLE cellSpacing=0 cellPadding=0 width=535 border=0>	<TBODY>		<TR>			<TD vAlign=top align=middle width="68%">			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>				<TBODY>					<TR>						<TD width=19><IMG height=23 src="{{$template_root}}/images/01a.gif"							width=19></TD>						<TD vAlign=center align=middle width=90 bgColor=#ffffff><STRONG							class=lanzi_x><nobr>网络设备信息</nobr></STRONG></TD><TD  background={{$template_root}}/images/02a.gif>&nbsp;</TD>						<TD width=23><IMG height=23 src="{{$template_root}}/images/03a.gif"							width=23></TD></TR>				</TBODY>			</TABLE>	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0><TBODY>	<TR>	<TD width=16  background={{$template_root}}/images/04a.gif>&nbsp;</TD><TD vAlign=top>
					<TABLE cellSpacing=0 cellPadding=0 width="505" border=0>
						<TBODY>
							<TR>
								<TD width="20%" class=table-bottom-border align=left height=24><STRONG>网络设备名：</STRONG></TD>
								<TD width="32%" class=table-bottom-border align=left height=24 title="I-I-I-I">{{$serverinfo.hostname}}</TD>
								<TD width="13%" class=table-bottom-border align=left height=24><STRONG>类型：</STRONG></TD>
								<TD width="35%" class=table-bottom-border align=left height=24 title="Cisco交换机">Cisco交换机</TD>
							</TR>
							
								<TR>
									<TD class=table-bottom-border align=left height=24><STRONG>使用的策略：</STRONG></TD>
									<TD class=table-bottom-border align=left height=24 title="default_Cisco交换机">default_Cisco交换机</TD>
									<TD class=table-bottom-border align=left height=24><nobr><STRONG>连续运行时间：</STRONG></nobr></TD>
									<TD class=table-bottom-border align=left colSpan=3 height=24 title="27d5h44m49s">{{$serverinfo.snmptime_diff}}</TD>
								</TR>
							
							<TR>
								<TD class=table-bottom-border align=left height=24><STRONG>响应时间：</STRONG></TD>
								<TD class=table-bottom-border align=left><span id=pingReport></span>
								
									<input class=bottom-border onClick="ping();" type=button value=Ping name=Submit222>
								
								</TD>
								<TD class=table-bottom-border align=left height=24><STRONG>登录方式：</STRONG></TD>
								<TD class=table-bottom-border align=left height=24>
								<select id="loginmethod" name="loginmethod">
							  {{section name=t loop=$alldev}}
                                            <option selected="selected" 
                                value="{{$alldev[t].login_method}}_{{$alldev[t].id}}">{{$alldev[t].login_method}}({{if $alldev[t].username eq ''}}空用户{{else}}{{$alldev[t].username}}{{/if}})&nbsp;</option>
                              {{/section}}
                                          </select>
                                            <NOBR>
                                            <input class="bottom-border" onclick="login();" value="登录" type="button" name="telentButton" />
								</TD>
							</TR>
						
							<TR>
								<TD class=table-bottom-border align=left height=24><STRONG>网络设备说明：</STRONG></TD>
								<TD class=table-bottom-border align=left colSpan=3 height=24 title="{{$serverinfo.snmpdesc}}">{{$serverinfo.snmpdesc}}</TD>
							</TR>
						</TBODY>
					</TABLE>
											</TD>						<TD width=14 background={{$template_root}}/images/05a.gif>&nbsp;</TD>					</TR>				</TBODY>			</TABLE>			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>				<TBODY>					<TR>						<TD vAlign=top width=32><IMG height=17							src="{{$template_root}}/images/06a.gif" width=32></TD>						<TD width=98% background={{$template_root}}/images/07a.gif>&nbsp;</TD>						<TD vAlign=top width=30><IMG height=17							src="{{$template_root}}/images/08a.gif" width=30></TD>					</TR>				</TBODY>			</TABLE>			</TD>		</TR>	</TBODY></TABLE></TD>
					<TD vAlign=top  width="160">
						<TABLE cellSpacing=0 cellPadding=0 width=100% border=0>	<TBODY>		<TR>			<TD vAlign=top align=middle width="68%">			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>				<TBODY>					<TR>						<TD width=19><IMG height=23 src="{{$template_root}}/images/01a.gif"							width=19></TD>						<TD vAlign=center align=middle width=90 bgColor=#ffffff><STRONG							class=lanzi_x><nobr>可用性统计</nobr></STRONG></TD><TD  background={{$template_root}}/images/02a.gif>&nbsp;</TD>						<TD width=23><IMG height=23 src="{{$template_root}}/images/03a.gif"							width=23></TD></TR>				</TBODY>			</TABLE>	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0><TBODY>	<TR>	<TD width=16  background={{$template_root}}/images/04a.gif>&nbsp;</TD><TD vAlign=top><table cellspacing="0" cellpadding="0" width="96%" border="0">
                          <tbody>
                            <tr>
                              <td class="table-bottom-border" align="left" width="30%" height="24"><nobr><strong>今天：</strong></nobr></td>
                              <td class="table-bottom-border" align="left" width="70%" height="24">100%</td>
                            </tr>
                            <tr>
                              <td class="table-bottom-border" align="left" height="24"><nobr><strong>昨天：</strong></nobr></td>
                              <td class="table-bottom-border" align="left" height="24">100%</td>
                            </tr>
                            <tr>
                              <td class="table-bottom-border" align="left" height="24"><nobr><strong>最近7天：</strong></nobr></td>
                              <td class="table-bottom-border" align="left" height="24">100%</td>
                            </tr>
                            <tr>
                              <td class="table-bottom-border" align="left" height="24"><nobr><strong>本月：</strong></nobr></td>
                              <td class="table-bottom-border" align="left" height="24">100%</td>
                            </tr>
                            <tr>
                              <td class="table-bottom-border" align="left" height="24"><nobr><strong>今年：</strong></nobr></td>
                              <td class="table-bottom-border" align="left" height="24">100%</td>
                            </tr>
                          </tbody>
                        </table></TD>						<TD width=14 background={{$template_root}}/images/05a.gif>&nbsp;</TD>					</TR>				</TBODY>			</TABLE>			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>				<TBODY>					<TR>						<TD vAlign=top width=32><IMG height=17							src="{{$template_root}}/images/06a.gif" width=32></TD>						<TD width=98% background={{$template_root}}/images/07a.gif>&nbsp;</TD>						<TD vAlign=top width=30><IMG height=17							src="{{$template_root}}/images/08a.gif" width=30></TD>					</TR>				</TBODY>			</TABLE>			</TD>		</TR>	</TBODY></TABLE>
					</TD>
				</TR>
				<tr>
				  <td colspan=2>
					
					<TABLE cellSpacing=0 cellPadding=0 width=695 border=0>	<TBODY>		<TR>			<TD vAlign=top align=middle width="68%">			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>				<TBODY>					<TR>						<TD width=19><IMG height=23 src="{{$template_root}}/images/01a.gif"							width=19></TD>						<TD vAlign=center align=middle width=90 bgColor=#ffffff><STRONG							class=lanzi_x><nobr>资源状态</nobr></STRONG></TD><TD  background={{$template_root}}/images/02a.gif>&nbsp;</TD>						<TD width=23><IMG height=23 src="{{$template_root}}/images/03a.gif"							width=23></TD></TR>				</TBODY>			</TABLE>	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0><TBODY>	<TR>	<TD width=16  background={{$template_root}}/images/04a.gif>&nbsp;</TD><TD vAlign=top>
							<TABLE cellSpacing=0 cellPadding=0 width="97%" border=0>		<TBODY>			<TR>				<TD width='15%' class=table-bottom-border align=left height=24><STRONG>总体状态：</STRONG></TD>				<TD class=table-bottom-border align=left height=24><IMG id='statedetailimg' 					 src="{{$template_root}}/images/{{if $serverinfo.status eq 1}}Green.gif{{elseif $serverinfo.status eq 2}}GreenYellow.gif{{else}}GreenRed.gif{{/if}}"  align=absMiddle style='cursor: hand' alt='点击浏览状态信息' onclick=linkStateJSP(); ></TD>			</TR>			<TR>				<TD VALIGN='top' class=table-bottom-border align=left height=24><STRONG>说明：</STRONG></TD>				<TD class=table-bottom-border align=left height=24>{{$serverinfo.asset_desc}}</TD>			</TR>		</TBODY>	</TABLE>		
											</TD>						<TD width=14 background={{$template_root}}/images/05a.gif>&nbsp;</TD>					</TR>				</TBODY>			</TABLE>			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>				<TBODY>					<TR>						<TD vAlign=top width=32><IMG height=17							src="{{$template_root}}/images/06a.gif" width=32></TD>						<TD width=98% background={{$template_root}}/images/07a.gif>&nbsp;</TD>						<TD vAlign=top width=30><IMG height=17							src="{{$template_root}}/images/08a.gif" width=30></TD>					</TR>				</TBODY>			</TABLE>			</TD>		</TR>	</TBODY></TABLE>
					
					
					<TABLE cellSpacing=0 cellPadding=0 width=695 border=0>	<TBODY>		<TR>			<TD vAlign=top align=middle width="68%">			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>				<TBODY>					<TR>						<TD width=19><IMG height=23 src="{{$template_root}}/images/01a.gif"							width=19></TD>						<TD vAlign=center align=middle width=90 bgColor=#ffffff><STRONG							class=lanzi_x><nobr>维护信息</nobr></STRONG></TD><TD  background={{$template_root}}/images/02a.gif>&nbsp;</TD>						<TD width=23><IMG height=23 src="{{$template_root}}/images/03a.gif"							width=23></TD></TR>				</TBODY>			</TABLE>	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0><TBODY>	<TR>	<TD width=16  background={{$template_root}}/images/04a.gif>&nbsp;</TD><TD vAlign=top>
					<TABLE cellSpacing=0 cellPadding=0 width="97%" border=0>	<TBODY>		 <tr>
                                          <td class="table-bottom-border" height="24" width="16%" 
                            align="left"><strong>所属部门：</strong></td>
                                          <td class="table-bottom-border" title="-" height="24" 
                            width="26%" align="left">{{$serverinfo.asset_department}}&nbsp;</td>
                                          <td class="table-bottom-border" height="24" width="20%" 
                            align="left"><strong>存放地点：</strong></td>
                                          <td class="table-bottom-border" title="-" height="24" 
                            width="38%" align="left">{{$serverinfo.asset_location}}&nbsp; </td>
                                        </tr>
                                        <tr>
                                          <td class="table-bottom-border" height="24" 
                              align="left"><strong>支持厂商：</strong></td>
                                          <td class="table-bottom-border" height="24" 
                              align="left">{{$serverinfo.asset_company}}&nbsp;</td>
                                          <td class="table-bottom-border" height="24" 
                              align="left"><strong>保修日期：</strong></td>
                                          <td class="table-bottom-border" title="-" height="24" 
                            align="left">{{$serverinfo.asset_warrantdate}}&nbsp;</td>
                                        </tr>
                                       <tr>
                                          <td class="table-bottom-border" height="24" 
                              align="left"><strong>上架时间：</strong></td>
                                          <td class="table-bottom-border" height="24" 
                              align="left"><a class="ly" title="-" 
                              href="mailto:-">{{$serverinfo.asset_start}}&nbsp;</a></td>
                                          <td class="table-bottom-border" height="24" 
                              align="left"><strong>使用年限：</strong></td>
                                          <td class="table-bottom-border" title="-" height="24" 
                            align="left">{{$serverinfo.asset_usedtime}}&nbsp;</td>
                                        </tr> </TBODY></TABLE>
											</TD>						<TD width=14 background={{$template_root}}/images/05a.gif>&nbsp;</TD>					</TR>				</TBODY>			</TABLE>			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>				<TBODY>					<TR>						<TD vAlign=top width=32><IMG height=17							src="{{$template_root}}/images/06a.gif" width=32></TD>						<TD width=98% background={{$template_root}}/images/07a.gif>&nbsp;</TD>						<TD vAlign=top width=30><IMG height=17							src="{{$template_root}}/images/08a.gif" width=30></TD>					</TR>				</TBODY>			</TABLE>			</TD>		</TR>	</TBODY></TABLE>
					
					
					
					
					<TABLE cellSpacing=0 cellPadding=0 width=695 border=0>	<TBODY>		<TR>			<TD vAlign=top align=middle width="68%">			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>				<TBODY>					<TR>						<TD width=19><IMG height=23 src="{{$template_root}}/images/01a.gif"							width=19></TD>						<TD vAlign=center align=middle width=90 bgColor=#ffffff><STRONG							class=lanzi_x><nobr>信息一览</nobr></STRONG></TD><TD  background={{$template_root}}/images/02a.gif>&nbsp;</TD>						<TD width=23><IMG height=23 src="{{$template_root}}/images/03a.gif"							width=23></TD></TR>				</TBODY>			</TABLE>	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0><TBODY>	<TR>	<TD width=16  background={{$template_root}}/images/04a.gif>&nbsp;</TD><TD vAlign=top>
						<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr>
	<td align='center' valign='bottom'>
	<table width='100%' height='32' border='0' cellpadding='0'
		cellspacing='0'>
		<tr>
	<td id='cpuhead' width='80' align='center' background='{{$template_root}}/images/bq-80.gif'>
		<a style='cursor:hand;' class='ly' target='iframeinfo' onClick="clickHead('cpuhead','cpuInfo.jsp?instanceId=649633404A1F04D7C3FB94A32F746459F3671681');detailgiveDisplay_block('cpudetail');try{parent.iframe3.changeState();}catch(e){};">CPU</a></td>	<td id='memhead' width='80' align='center' background='{{$template_root}}/images/bq-80.gif' class='diline'>
		<a style='cursor:hand;' class='ly' target='iframeinfo' onClick="clickHead('memhead','memInfo.jsp?instanceId=649633404A1F04D7C3FB94A32F746459F3671681');detailgiveDisplay_block('memorydetail');try{parent.iframe3.changeState();}catch(e){};">内存</a></td>			<td align='right' class='diline'>&nbsp;</td>
		</tr>
	</table>
	</td>
</tr>
<tr>
	<td align='center' valign='top' class='full-lan'>
	<table width='98%' border='0' cellspacing='0' cellpadding='0'>
		<tr>
			<td height='10'></td>
		</tr>
	</table>
	

												<table cellspacing="1" cellpadding="2" width="99%" bgcolor="#8caade" border="0" id="cpudetail">
                                                        <tbody>
                                                          <tr align="middle" bgcolor="#ffffff">
                                                            <td width="20%" bgcolor="#d6e8ff"><strong><img height="16"	src="{{$template_root}}/images/cpu1.gif" width="20" align="absmiddle" /> CPU <br />
                                                                  <br />
                                                            </strong></td>
                                                            <td><table width="98%" border="0" cellspacing="0" cellpadding="5">
                                                                <tr align="left">
                                                                  <td width="100%" height="53" align="left"><table cellspacing='0' cellpadding='0' border='0'>
                                                                      <tr>
                                                                        <td style='word-break:break-all' width='450'>{{$hoststatus.cpu.value}}% </td>
                                                                      </tr>
                                                                    </table>
                                                                      <table  cellspacing='0' cellpadding='0' width='450' height='20' border='0' style=' border-bottom: 1px solid black;border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;{{if $hoststatus.cpu.value lt 1}}display:none;{{/if}}'>
                                                                        <tr>
                                                                          <!-- 百分比1-->
                                                                          <td width='{{$hoststatus.cpu.value}}%' height='2' style='background-image:url({{$template_root}}/images/green_rate.jpg); background-repeat : repeat ;'><div align="left"><strong>&nbsp;</strong></div></td>
                                                                          <td><div align='center'></div></td>
                                                                          <td>&nbsp;</td>
                                                                        </tr>
                                                                    </table></td>
                                                                </tr>
                                                            </table></td>
                                                          </tr>
                                                        </tbody>
                                                    </table>

													<table cellspacing="1" cellpadding="2" width="99%" bgcolor="#8caade" border="0" id="memorydetail">
                                                        <tbody>
                                                          <tr align="middle" bgcolor="#ffffff">
                                                            <td width="20%" bgcolor="#d6e8ff"><strong><img height="16"	src="{{$template_root}}/images/cpu1.gif" width="20" align="absmiddle" /> 内存 <br />
                                                                  <br />
                                                            </strong></td>
                                                            <td><table width="98%" border="0" cellspacing="0" cellpadding="5">
                                                                <tr align="left">
                                                                  <td width="100%" height="53" align="left"><table cellspacing='0' cellpadding='0' border='0'>
                                                                      <tr>
                                                                        <td style='word-break:break-all' width='450'>{{$hoststatus.memory.value}}% </td>
                                                                      </tr>
                                                                    </table>
                                                                      <table  cellspacing='0' cellpadding='0' width='450' height='20' border='0' style=' border-bottom: 1px solid black;border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;'>
                                                                        <tr>
                                                                          <!-- 百分比1-->
                                                                          <td width='{{$hoststatus.memory.value}}%' height='2' style='background-image:url({{$template_root}}/images/green_rate.jpg); background-repeat : repeat ;{{if $hoststatus.memory.value lt 1}}display:none;{{/if}}'><div align="left"><strong>&nbsp;</strong></div></td>
                                                                          <td><div align='center'></div></td>
                                                                          <td>&nbsp;</td>
                                                                        </tr>
                                                                    </table></td>
                                                                </tr>
                                                            </table></td>
                                                          </tr>
                                                        </tbody>
                                                    </table>

	
	
	</td>
</tr>
</table>
											</TD>						<TD width=14 background={{$template_root}}/images/05a.gif>&nbsp;</TD>					</TR>				</TBODY>			</TABLE>			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>				<TBODY>					<TR>						<TD vAlign=top width=32><IMG height=17							src="{{$template_root}}/images/06a.gif" width=32></TD>						<TD width=98% background={{$template_root}}/images/07a.gif>&nbsp;</TD>						<TD vAlign=top width=30><IMG height=17							src="{{$template_root}}/images/08a.gif" width=30></TD>					</TR>				</TBODY>			</TABLE>			</TD>		</TR>	</TBODY></TABLE>
					
					</td>
				</tr>
			</TBODY>
		</TABLE>
		</td>
	</tr>
</table>
</div>
 <script type="text/javascript">
//var g_loading = new Loading("<span class='word-blue'>数据加载中，请稍候…</span>",180,250,"yes","yes");
var oldHrefObj = null;
function focusNodeFont(hrefElement){      
	var newHrefElement = document.getElementById(hrefElement);
    if(oldHrefObj){ 
            oldHrefObj.style.fontWeight='normal';   
    }
    if(newHrefElement){
            newHrefElement.style.fontWeight='bolder';     
            oldHrefObj = newHrefElement;
    }
    if(parent.clearNodeFont){
            parent.focusNodeFont();   
    } 
} 
function clickHead(headname,url){
	var cpuhead=document.getElementById('cpuhead');
	cpuhead.className='diline';
	var memhead=document.getElementById('memhead');
	memhead.className='diline';
	var currhead=document.getElementById(headname);
	currhead.className='';
	focusNodeFont(headname);
	//document.all.iframeinfo.src = url;	
}
function detailgiveDisplay_block(id){	
	giveDisplay_block(id);
}
function giveDisplay_block(id){	
	document.getElementById('cpudetail').style.display="none";
	document.getElementById('memorydetail').style.display="none";
	document.getElementById(id).style.display="";
}
clickHead('cpuhead');
focusNodeFont('cpuhead');
detailgiveDisplay_block('cpudetail');
try{
	parent.iframe3.changeState();
}catch(e){};

function login(){
	var loginmethod = document.getElementById('loginmethod').options[document.getElementById('loginmethod').options.selectedIndex].value;
	m_sid = loginmethod.split('_');
	iid = m_sid[1];
	var rdpclipauth = {{if $member.rdpclipauth and $windows_version!=5.2}}1{{else}}0{{/if}};
	var screen = '{{$member.rdp_screen}}';
	if(screen.length==0){
		screen = 1;
	}
	var rdpdiskauth = 1;
	var consoleauth = 1;
	var app_act = 'applet';
	var lbip = '{{$localip}}';
	var weburl = '';

	switch(m_sid[0]){
		case 'RDP':
			weburl= 'admin.php?controller=admin_detail&action=dev_login&id='+iid+'&screen='+screen+'&selectedip='+lbip+'&app_act='+app_act+'&rdparg=0&appdeviceid=0&rdpclipauth='+rdpclipauth+'&rdpdiskauth='+rdpdiskauth+'&consoleauth='+consoleauth;	
			{{if !$member.default_appcontrol}}
				weburl += '&rdptype=activex';
			{{/if}}
		break;
		case 'ssh1':
		case 'ssh':
		case 'telnet':
		case 'rlogin':
			weburl = 'admin.php?controller=admin_detail&action=dev_login&id='+iid+'&logintool=putty&type={{$type}}';
		break;
		case 'ftp':
		case 'sftp':
			weburl = 'admin.php?controller=admin_detail&action=dev_login&logintool=winscp&id='+iid;
			weburl += '&selectedip='+lbip+'&app_act='+app_act;
		break;
		case 'RDP2008':
		case 'vnc':
		case 'Web':
		case 'Sybase':
		case 'Oracle':
		case 'DB2':
			weburl= 'admin.php?controller=admin_detail&action=dev_login&id='+iid+'&screen='+screen+'&selectedip='+lbip+'&app_act='+app_act+'&rdparg=0&appdeviceid='+appdeviceid+'&rdpclipauth='+rdpclipauth+'&rdpdiskauth='+rdpdiskauth+'&consoleauth='+consoleauth;	
			{{if !$member.default_appcontrol}}
				weburl += '&rdptype=activex';
			{{/if}}
		break;
			
	}
	//hide.src=weburl;
	window.open(weburl);
}

function ping(){
 window.open("admin.php?controller=admin_detail&action=ping&ip={{$ip}}", "ping", "height=50, width=50, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no");
}
</script>
<iframe id="hide" name="hide" height="0"  frameborder="0" scrolling="no"></iframe>
</body>
</html>
