<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>详细信息</title>
<LINK rel=stylesheet type=text/css href="{{$template_root}}/cssjs/liye.css">
<style>
.div_scrollbar2 {
	width:99%;   height:132px;   z-index:1;   overflow:   auto;SCROLLBAR-FACE-COLOR: #ffffff; SCROLLBAR-HIGHLIGHT-COLOR: #f3f3f3; SCROLLBAR-SHADOW-COLOR: COLOR:#000000 ; SCROLLBAR-3DLIGHT-COLOR: #ffffff; SCROLLBAR-ARROW-COLOR: #006c90;  SCROLLBAR-DARKSHADOW-COLOR: #ffffff;BORDER: #d1dbe1 1px solid;  
}
</STYLE>
</head>

<body>
<table id="interfaceViewTable" border="0"  cellspacing="0" cellpadding="0" width="100%">
  <tbody>
    <tr>
      <td valign="top" align="middle"><table border="0" cellspacing="0" cellpadding="0" align="left">
        <tbody>
          <tr>
            <td width="510"><table border="0" cellspacing="0" cellpadding="0" width="695">
              <tbody>
                <tr>
                  <td valign="top" width="68%" align="middle"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tbody>
                      <tr>
                        <td width="19"><img 
                        src="{{$template_root}}/images/01a.gif" width="19" 
                        height="23" /></td>
                        <td bgcolor="#ffffff" valign="center" width="90" 
                        align="middle"><strong 
                        class="lanzi_x"><NOBR>主机信息</NOBR></strong></td>
                        <td 
                      background="{{$template_root}}/images/02a.gif">&nbsp;</td>
                        <td width="23"><img 
                        src="{{$template_root}}/images/03a.gif" width="23" 
                        height="23" /></td>
                      </tr>
                    </tbody>
                  </table>
                          <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tbody>
                              <tr>
                                <td background="{{$template_root}}/images/04a.gif" 
                      width="16">&nbsp;</td>
                                <td valign="top"><table border="0" cellspacing="0" cellpadding="0" width="665">
                                    <tbody>
                                      <tr>
                                        <td class="table-bottom-border" height="24" width="19%" 
                            align="left"><strong>主机名：</strong></td>
                                        <td class="table-bottom-border" title="ISA01" height="24" 
                            width="24%" align="left">{{$serverinfo.hostname}}&nbsp;</td>
                                        <td class="table-bottom-border" height="24" width="24%" 
                            align="left"><strong>类型：</strong></td>
                                        <td class="table-bottom-border" 
                            title="主机-Windows OS(SNMP)" height="24" width="33%" 
                            align="left">{{$serverinfo.device_type}}</td>
                                      </tr>
                                      <tr>
                                        <td class="table-bottom-border" height="24" 
                              align="left"><strong>操作系统：</strong></td>
                                        <td class="table-bottom-border" 
                            title="Microsoft Windows 2000 Server" height="24" 
                            align="left">{{$serverinfo.device_type}}&nbsp;</td>
                                        <td class="table-bottom-border" height="24" 
                              align="left"><strong>使用的策略：</strong></td>
                                        <td class="table-bottom-border" 
                            title="default_Windows OS(SNMP)" height="24" 
                            align="left">{{if $serverinfo.monitor eq 1}}SNMP{{elseif $serverinfo.monitor eq 2}}登陆{{elseif $serverinfo.monitor eq 3}}被动{{/if}} </td>
                                      </tr>
                                      <tr>
                                        <td class="table-bottom-border" height="24" 
                              align="left"><strong>连续运行时间：</strong></td>
                                        <td class="table-bottom-border" title="30d4h33m49s" 
                            height="24" align="left">{{$serverinfo.snmptime_diff}}</td>
                                        <td class="table-bottom-border" align="left">&nbsp;</td>
                                        <td class="table-bottom-border" 
                          align="left">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td class="table-bottom-border" height="24" 
                              align="left"><strong>响应时间：</strong></td>
                                        <td class="table-bottom-border" align="left"><span 
                              id="pingReport"></span>
                                            <input class="bottom-border" onclick="ping();" value="Ping" type="button" name="Submit222" />
                                        </td>
                                        <td class="table-bottom-border" height="24" 
                              align="left"><strong>登录方式：</strong></td>
                                        <td class="table-bottom-border" height="24" 
                              align="left"><select id="loginmethod" name="loginmethod">
							  {{section name=t loop=$alldev}}
                                            <option selected="selected" 
                                value="{{$alldev[t].login_method}}_{{$alldev[t].id}}">{{$alldev[t].login_method}}({{if $alldev[t].username eq ''}}空用户{{else}}{{$alldev[t].username}}{{/if}})&nbsp;</option>
                              {{/section}}
                                          </select>
                                            <NOBR>
                                            <input class="bottom-border" onclick="login();" value="登录" type="button" name="telentButton" />
                                          </NOBR></td>
                                      </tr>
                                      <tr>
                                        <td class="table-bottom-border" height="24" 
                              align="left"><strong>主机说明：</strong></td>
                                        <td class="table-bottom-border" 
                            title="Hardware: x86 Family 6 Model 8 Stepping 6 AT/AT COMPATIBLE - Software: Windows 2000 Version 5.0 (Build 2195 Uniprocessor Free)" 
                            height="24" colspan="3" align="left">{{$serverinfo.snmpdesc}}&nbsp;</td>
                                      </tr>
                                    </tbody>
                                </table></td>
                                <td background="{{$template_root}}/images/05a.gif" 
                      width="14">&nbsp;</td>
                              </tr>
                            </tbody>
                          </table>
                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tbody>
                              <tr>
                                <td valign="top" width="32"><img 
                        src="{{$template_root}}/images/06a.gif" width="32" 
                        height="17" /></td>
                                <td background="{{$template_root}}/images/07a.gif" 
                      width="98%">&nbsp;</td>
                                <td valign="top" width="30"><img 
                        src="{{$template_root}}/images/08a.gif" width="30" 
                        height="17" /></td>
                              </tr>
                            </tbody>
                        </table></td>
                </tr>
              </tbody>
            </table></td>
           
          </tr>
          <tr>
            <td colspan="2"><table border="0" cellspacing="0" cellpadding="0" width="695">
              <tbody>
                <tr>
                  <td valign="top" width="68%" align="middle"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tbody>
                      <tr>
                        <td width="19"><img 
                        src="{{$template_root}}/images/01a.gif" width="19" 
                        height="23" /></td>
                        <td bgcolor="#ffffff" valign="center" width="90" 
                        align="middle"><strong 
                        class="lanzi_x"><NOBR>资源状态</NOBR></strong></td>
                        <td 
                      background="{{$template_root}}/images/02a.gif">&nbsp;</td>
                        <td width="23"><img 
                        src="{{$template_root}}/images/03a.gif" width="23" 
                        height="23" /></td>
                      </tr>
                    </tbody>
                  </table>
                          <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tbody>
                              <tr>
                                <td background="{{$template_root}}/images/04a.gif" 
                      width="16">&nbsp;</td>
                                <td valign="top"><table border="0" cellspacing="0" cellpadding="0" 
                          width="97%">
                                    <tbody>
                                      <tr>
                                        <td class="table-bottom-border" height="24" width="15%" 
                            align="left"><strong>总体状态：</strong></td>
                                        <td class="table-bottom-border" height="24" 
                              align="left"><img style="CURSOR: hand" 
                              id="statedetailimg" onclick="linkStateJSP();" 
                              alt="点击浏览状态信息" align="absmiddle" 
                              src="{{$template_root}}/images/{{if $serverinfo.status eq 1}}Green.gif{{elseif $serverinfo.status eq 2}}GreenYellow.gif{{else}}GreenRed.gif{{/if}}" /></td>
                                      </tr>
                                      <tr>
                                        <td class="table-bottom-border" height="24" valign="top" 
                            align="left"><strong>说明：</strong></td>
                                        <td class="table-bottom-border" height="24" 
                              align="left">{{$serverinfo.asset_desc}}&nbsp;</td>
                                      </tr>
                                    </tbody>
                                </table></td>
                                <td background="{{$template_root}}/images/05a.gif" 
                      width="14">&nbsp;</td>
                              </tr>
                            </tbody>
                          </table>
                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tbody>
                              <tr>
                                <td valign="top" width="32"><img 
                        src="{{$template_root}}/images/06a.gif" width="32" 
                        height="17" /></td>
                                <td background="{{$template_root}}/images/07a.gif" 
                      width="98%">&nbsp;</td>
                                <td valign="top" width="30"><img 
                        src="{{$template_root}}/images/08a.gif" width="30" 
                        height="17" /></td>
                              </tr>
                            </tbody>
                        </table></td>
                </tr>
              </tbody>
            </table>
                  <table border="0" cellspacing="0" cellpadding="0" width="695">
                    <tbody>
                      <tr>
                        <td valign="top" width="68%" align="middle"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tbody>
                              <tr>
                                <td width="19"><img 
                        src="{{$template_root}}/images/01a.gif" width="19" 
                        height="23" /></td>
                                <td bgcolor="#ffffff" valign="center" width="90" 
                        align="middle"><strong 
                        class="lanzi_x"><NOBR>维护信息</NOBR></strong></td>
                                <td 
                      background="{{$template_root}}/images/02a.gif">&nbsp;</td>
                                <td width="23"><img 
                        src="{{$template_root}}/images/03a.gif" width="23" 
                        height="23" /></td>
                              </tr>
                            </tbody>
                          </table>
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                              <tbody>
                                <tr>
                                  <td background="{{$template_root}}/images/04a.gif" 
                      width="16">&nbsp;</td>
                                  <td valign="top"><table border="0" cellspacing="0" cellpadding="0" 
                          width="97%">
                                      <tbody>
                                        <tr>
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
                                        </tr>
                                      </tbody>
                                  </table></td>
                                  <td background="{{$template_root}}/images/05a.gif" 
                      width="14">&nbsp;</td>
                                </tr>
                              </tbody>
                            </table>
                          <table border="0" cellspacing="0" cellpadding="0" width="100%">
                              <tbody>
                                <tr>
                                  <td valign="top" width="32"><img 
                        src="{{$template_root}}/images/06a.gif" width="32" 
                        height="17" /></td>
                                  <td background="{{$template_root}}/images/07a.gif" 
                      width="98%">&nbsp;</td>
                                  <td valign="top" width="30"><img 
                        src="{{$template_root}}/images/08a.gif" width="30" 
                        height="17" /></td>
                                </tr>
                              </tbody>
                          </table></td>
                      </tr>
                    </tbody>
                  </table>
              <table border="0" cellspacing="0" cellpadding="0" width="695">
                    <tbody>
                      <tr>
                        <td valign="top" width="68%" align="middle"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tbody>
                              <tr>
                                <td width="19"><img 
                        src="{{$template_root}}/images/01a.gif" width="19" 
                        height="23" /></td>
                                <td bgcolor="#ffffff" valign="center" width="90" 
                        align="middle"><strong 
                        class="lanzi_x"><NOBR>信息一览</NOBR></strong></td>
                                <td 
                      background="{{$template_root}}/images/02a.gif">&nbsp;</td>
                                <td width="23"><img 
                        src="{{$template_root}}/images/03a.gif" width="23" 
                        height="23" /></td>
                              </tr>
                            </tbody>
                          </table>
                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                              <tbody>
                                <tr>
                                  <td background="{{$template_root}}/images/04a.gif" 
                      width="16">&nbsp;</td>
                                  <td valign="top"><table border="0" cellspacing="0" cellpadding="0" width="660">
                                      <tbody>
                                        <tr>
                                          <td valign="bottom" align="middle"><table border="0" cellspacing="0" cellpadding="0" 
                              width="100%" height="32">
                                              <tbody>
                                                <tr>
                                                  <td id="cpuhead" class="diline" 
                                background="{{$template_root}}/images/bq-80.gif" 
                                width="80" align="middle"><a style="CURSOR: hand" 
                                class="ly" 
                                onclick="clickHead('cpuhead','#');detailgiveDisplay_block('cpudetail');try{parent.iframe3.changeState();}catch(e){};" 
                                target="iframeinfo">CPU</a></td>
                                                  <td id="memhead" class="diline" 
                                background="{{$template_root}}/images/bq-80.gif" 
                                width="80" align="middle"><a style="CURSOR: hand" 
                                class="ly" 
                                onclick="clickHead('memhead','#');detailgiveDisplay_block('memorydetail');try{parent.iframe3.changeState();}catch(e){};" 
                                target="iframeinfo">内存</a></td>
                                                  <td id="diskhead" class="diline" 
                                background="{{$template_root}}/images/bq-80.gif" 
                                width="80" align="middle"><a style="CURSOR: hand" 
                                class="ly" 
                                onclick="clickHead('diskhead','#');detailgiveDisplay_block('diskdetail');try{parent.iframe3.changeState();}catch(e){};" 
                                target="iframeinfo">硬盘</a></td>
                                                  <td class="diline" 
                                align="right">&nbsp;</td>
                                                </tr>
                                              </tbody>
                                          </table></td>
                                        </tr>
                                        <tr>
                                          <td class="full-lan" valign="top" align="middle"><table border="0" cellspacing="0" cellpadding="0" 
                              width="98%">
                                              <tbody>
                                                <tr>
                                                  <td height="10"></td>
                                                </tr>
                                              </tbody>
                                            </table>
                                              <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                <tbody>
                                                  <tr>
                                                    <td valign="top" align="middle">
													
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
                                                                      <table  cellspacing='0' cellpadding='0' width='450' height='20' border='0' style=' border-bottom: 1px solid black;border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;'>
                                                                        <tr>
                                                                          <!-- 百分比1-->
                                                                          <td width='{{$hoststatus.cpu.value}}%' height='2' style='background-image:url({{$template_root}}/images/green_rate.jpg); background-repeat : repeat ;{{if $hoststatus.cpu.value lt 1}}display:none;{{/if}}'><div align="left"><strong>&nbsp;</strong></div></td>
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

													<table cellspacing="1" cellpadding="2" width="99%" bgcolor="#8caade" border="0" id="diskdetail">
                                                        <tbody>
                                                          <tr align="middle" bgcolor="#ffffff">
                                                            <td width="20%" bgcolor="#d6e8ff"><strong><img height="16"	src="{{$template_root}}/images/cpu1.gif" width="20" align="absmiddle" />  存储 <br />
                                                                  <br />
                                                            </strong></td>
                                                            <td>
															<div class="div_scrollbar2" style="">
															<table width="98%" border="0" cellspacing="0" cellpadding="5">
															{{section name=d loop=$hoststatus.disk}}
                                                                <tr align="left">
                                                                  <td width="100%" height="53" align="left"><table cellspacing='0' cellpadding='0' border='0'>
                                                                      <tr>
                                                                        <td style='word-break:break-all' width='450'>{{$hoststatus.disk[d].disk}} {{$hoststatus.disk[d].value}}% </td>
                                                                      </tr>
                                                                    </table>
                                                                      <table  cellspacing='0' cellpadding='0' width='450' height='20' border='0' style=' border-bottom: 1px solid black;border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;'>
                                                                        <tr>
                                                                          <!-- 百分比1-->
                                                                          <td width='{{$hoststatus.disk[d].value}}%' height='2' style='background-image:url({{$template_root}}/images/green_rate.jpg); background-repeat : repeat ;{{if $hoststatus.disk[d].value lt 1}}display:none;{{/if}}'><div align="left"><strong>&nbsp;</strong></div></td>
                                                                          <td><div align='center'></div></td>
                                                                          <td>&nbsp;</td>
                                                                        </tr>
                                                                    </table></td>
                                                                </tr>
															 {{/section}}
                                                            </table>
															</div>
															</td>
                                                          </tr>
                                                        </tbody>
                                                    </table>

													
													
													
													</td>
                                                  </tr>
                                                </tbody>
                                            </table></td>
                                        </tr>
                                      </tbody>
                                    </table>
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
	var diskhead=document.getElementById('diskhead');
	diskhead.className='diline';
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
	document.getElementById('diskdetail').style.display="none";
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
	var app_act = 'activeX';
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
			weburl += '&selectedip='+lbip+'&app_act='+app_act;
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
                                  </td>
                                  <td background="{{$template_root}}/images/05a.gif" 
                      width="14">&nbsp;</td>
                                </tr>
                              </tbody>
                            </table>
                          <table border="0" cellspacing="0" cellpadding="0" width="100%">
                              <tbody>
                                <tr>
                                  <td valign="top" width="32"><img 
                        src="{{$template_root}}/images/06a.gif" width="32" 
                        height="17" /></td>
                                  <td background="{{$template_root}}/images/07a.gif" 
                      width="98%">&nbsp;</td>
                                  <td valign="top" width="30"><img 
                        src="{{$template_root}}/images/08a.gif" width="30" 
                        height="17" /></td>
                                </tr>
                              </tbody>
                          </table></td>
                      </tr>
                    </tbody>
                </table></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
<iframe id="hide" name="hide" height="0"  frameborder="0" scrolling="no"></iframe>
</body>
</html>
