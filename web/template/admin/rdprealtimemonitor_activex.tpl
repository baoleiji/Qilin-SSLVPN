<html>
<head>
<title>{{$ip}}</title>
<style type="text/css" media="screen">
p { color:"#000000"; font-family: "宋体, Verdana, Arial, Helvetica"; font-size:"75%"}
h1 { font-size: 100%; font-family: 宋体, verdana, arial, helvetica; font-weight: bold;
		margin-top: 0em;}
p.indent { margin-left: 3em; margin-top: .5em; line-height: 1.25em; margin-bottom: .2em; margin-right: 1em;}
.button {
	FONT-FAMILY: 宋体, Verdana, Helvetica, Arial, San-Serif;
	font-weight:normal;
	font-size:75%;
	color:#000000;
	background-color:#ffffff;
	border-color:#6699ff;
	margin-top:6pt;
	margin-left: .5em;

}
.topspace {margin-top: .08em; }
</style>
</head>

<body bgcolor="#ffffff">
<script language="vbscript">
<!--
const L_FullScreenWarn1_Text = "当前的安全设置不允许自动切换到全屏模式。"
const L_FullScreenWarn2_Text = "您可以用 Ctrl-Alt-Pause 将远程桌面会话切换到全屏模式"
const L_FullScreenTitle_Text = "远程桌面 Web 连接"
const L_ErrMsg_Text         = "连接到远程计算机时的错误: "
const L_PlatformCheck_ErrorMessage = "远程桌面 Web 连接 ActiveX 控件只能在 32 位版本的 Internet Explorer 中运行。"

' error messages
const L_RemoteDesktopCaption_ErrorMessage =  "远程桌面连接"
const L_DisconnectedCaption_ErrorMessage =  "远程桌面连接已被中断"
const L_ErrConnectCallFailed_ErrorMessage =  "客户端连接到远程计算机时出现错误。请检查系统内存，然后重新连接。"
const L_DisconnectRemoteByServer_ErrorMessage = "远程计算机已结束连接。"
const L_LowMemory_ErrorMessage = "本地计算机内存不足。请关闭一些程序，然后再连接到远程计算机。"
const L_SecurityErr_ErrorMessage = "由于安全错误，客户端无法连接到远程计算机。请确认您已登录到网络，然后重新连接。"
const L_BadServerName_ErrorMessage = "找不到指定的远程计算机。请确认您键入的计算机名和 IP 地址是否正确，然后重新连接。"
const L_ConnectFailedProtocol_ErrorMessage = "由于一个协议错误，客户端无法连接到远程计算机。请重新廉洁到远程计算机。如果客户端依旧无法连接，请跟网络管理员联系。"
const L_CannotLoopBackConnect_ErrorMessage = "客户端无法连接，您无法从同一台计算机的控制台会话连接到控制台。"
const L_NetworkErr_ErrorMessage = "由于网络错误，连接被结束。请重新连接到远程计算机。"
const L_InternalErr_ErrorMessage = "出现了一个内部错误。"
const L_NotResponding_ErrorMessage = "客户端无法连接到远程计算机。远程连接没有启用，或者计算机太忙，无法接受新连接。也有可能网络问题阻碍了连接。请重新连接。如果问题继续出现，请跟系统管理员联系。"
const L_VersionMismatch_ErrorMessage = "客户端和服务器版本不相符。请升级客户端软件，然后重新连接。"
const L_EncryptionError_ErrorMessage = "由于数据加密的错误，这个会话将结束。请重新连接到远程计算机。"
const L_ProtocolErr_ErrorMessage = "由于协议错误，这个会话将被中断。请重新连接到远程计算机。"
const L_IllegalServerName_ErrorMessage = "指定的计算机名含有无效字符。请确认计算机名，重试一次。"
const L_ConnectionTimeout_ErrorMessage = "远程连接已超时。请重新连接到远程计算机。"
const L_DisconnectIdleTimeout_ErrorMessage = "由于达到了空闲超时限度，远程会话被结束。这个限度是服务器管理员或网络策略设置的。"
const L_DisconnectLogonTimeout_ErrorMessage ="由于达到了总登录时间限度，远程会话被结束。这个限度是服务器管理员或网络策略设置的。"
const L_ProtocolErrWITHCODE_ErrorMessage  = "由于内部协议错误，客户端已中断连接: "
const L_LicensingTimeout_ErrorMessage = "客户端试图连接时，出现了一个授权错误(授权超时)。请重新跟远程计算机连接。"
const L_LicensingNegotFailed_ErrorMessage = "由于授权协议中的一个错误，远程计算机中断了会话。请重新跟远程计算机连接；或者跟服务器管理员联系。"
const L_DisconnectRemoteByServerTool_ErrorMessage = "跟远程计算机的远程会话被一个管理工具结束。可能是您的管理员中断了您的连接。"
const L_LogoffRemoteByServer_ErrorMessage = "由于会话在远程计算机上被注销，远程会话被中断。您的系统管理员或另一个用户结束了您的连接。"
const L_DisconnectByOtherConnection_ErrorMessage = "由于另一个用户连接到了会话，远程会话被中断。"
const L_ConnectionBroken_ErrorMessage  = "跟远程计算机的连接被打断。请重新连接到远程计算机。"
const L_ServerOutOfMemory_ErrorMessage = "由于远程计算机内存不足，连接被中断。"
const L_LicenseInternal_ErrorMessage = "由于远程计算机的授权协议中有一个内部错误，远程会话被中断。"
const L_NoLicenseServer_ErrorMessage = "由于没有终端服务器许可证服务器可以提供许可证，远程会话被中断。请跟服务器管理员联系。"
const L_NoLicense_ErrorMessage = "由于这台计算机没有终端服务器客户端访问许可证，远程会话被中断。请跟服务器管理员联系。"
const L_LicenseBadClientMsg_ErrorMessage = "由于远程计算机从这台计算机收到一个无效的授权消息，远程会话被中断。"
const L_LicenseHwidDoesntMatch_ErrorMessage = "由于这台计算机上储存的终端服务器客户端访问许可证已被修改，远程会话被中断。"
const L_BadClientLicense_ErrorMessage = "由于这台计算机上储存的终端服务器客户端访问许可证的格式无效，远程会话被中断。"
const L_LicenseCantFinishProtocol_ErrorMessage = "由于授权协议中有网络问题，远程会话被中断。请重新跟远程计算机连接。"
const L_LicenseClientEndedProtocol_ErrorMessage = "由于客户端过早地结束了授权协议，远程会话被中断。"
const L_LicenseBadClientEncryption_ErrorMessage = "由于授权消息的加密不正确，远程会话被中断。"
const L_CantUpgradeLicense_ErrorMessage = "由于无法升级或重续本地计算机的客户端访问许可证，远程会话被中断。请跟服务器管理员联系。"
const L_LicenseNoRemoteConnections_ErrorMessage = "由于远程计算机没有授权接受远程连接，远程会话被中断。请跟服务器管理员联系。"
const L_DecompressionFailed_ErrorMessage = "由于客户端的解压缩操作失败，远程会话被中断。请重新连接到远程计算机。"
const L_ServerDeniedConnection_ErrorMessage ="客户端无法建立跟远程计算机的连接。导致这个错误的可能的原因是: 1) 远程计算机上的远程连接可能没有启用。2) 已超出远程计算机上的连接最大数。3) 建立连接时出现了一个网络错误。"
const L_ControlLoadFailed_ErrorMessage= "远程桌面 Web 连接 ActiveX 控制无法安装。在没有一个安装后运行正常的控制版本的情况下，无法进行连接。请与服务器的管理员联系。"
const L_InvalidServerName_ErrorMessage = "指定了一个无效服务器。"

sub window_onload()
   if not LCase(Navigator.CpuClass) = "x86" then
      msgbox L_PlatformCheck_ErrorMessage
   end if
   if not autoConnect() then
       'Document.all.editServer.Focus
   end if
end sub

function autoConnect()
	Dim sServer
	Dim iFS, iAutoConnect


	sServer = getQS ("Server")
	iAutoConnect = getQS ("AutoConnect")
	iFS = getQS ("FS")

	if NOT IsNumeric ( iFS ) then
		iFS = 0
	else
		iFS = CInt ( iFS )
	end if

	if iAutoConnect <> 1 then
		autoConnect = false
		exit function
	else
		if iFS < 0 or iFS >= Document.all.comboResolution.options.length then
			iFS = 0
		end if

		if IsNull ( sServer ) or sServer = "" then
			sServer = window.location.hostname
		end if

		Document.all.comboResolution.selectedIndex	= iFS
		Document.all.Server.value = sServer

		btnConnect ()

		autoConnect = true
	end if

end function

function getQS ( sKey )
	Dim iKeyPos, iDelimPos, iEndPos
	Dim sURL, sRetVal
	iKeyPos = iDelimPos = iEndPos = 0
	sURL = window.location.href

	if sKey = "" Or Len(sKey) < 1 then
		getQS = ""
		exit function
	end if

	iKeyPos = InStr ( 1, sURL, sKey )

	if iKeyPos = 0 then
		sRetVal = ""
		exit function
	end if

	iDelimPos = InStr ( iKeyPos, sURL, "=" )
	iEndPos = InStr ( iDelimPos, sURL, "&" )

	if iEndPos = 0 then
		sRetVal = Mid ( sURL, iDelimPos + 1 )
	else
		sRetVal = Mid ( sURL, iDelimPos + 1, iEndPos - iDelimPos - 1 )
	end if

	getQS = sRetVal
end function

sub checkClick
      if Document.all.Check1.Checked then
         Document.all.tableLogonInfo.style.display = ""
         Document.all.editUserName.Disabled = false
         Document.all.editDomain.Disabled = false
      else
         Document.all.tableLogonInfo.style.display = "none"
         Document.all.editUserName.Disabled = true
         Document.all.editDomain.Disabled = true
      end if
end sub

sub OnControlLoadError
    msgbox L_ControlLoadFailed_ErrorMessage,0,L_RemoteDesktopCaption_ErrorMessage
end sub

sub OnControlLoad
   set Control = Document.getElementById("MsRdpClient")
   if Not Control is Nothing then
      if Control.readyState = 4 then
         Document.all.connectButton.disabled = FALSE
      end if
   end if
end sub


sub BtnConnect
   Dim serverName
   'server
   if not Document.all.Server.value = "" then
      serverName = Document.all.Server.value
   else
      serverName = Document.location.hostname
   end if
   
   serverName = trim(serverName)
   
   On Error Resume Next
   MsRdpClient.server = "{{$proxy_addr}}"
   If Err then 
      msgbox L_InvalidServerName_ErrorMessage,0,L_RemoteDesktopCaption_ErrorMessage
      Err.Clear
      exit sub
   end if
   On Error Goto 0
   
   'serverName name text
   Document.all.srvNameField.innerHtml = "{{$proxy_addr}}"
   
   'Username/Domain
   if Document.all.CheckBoxAutoLogon.checked then
      MsRdpClient.UserName = "{{$username}}"
	  MsRdpClient.AdvancedSettings.RDPPort = "{{$port}}"
	  MsRdpClient.AdvancedSettings.ClearTextPassword = "nopassword"
   end if

   'Resolution
   MsRdpClient.FullScreen = FALSE
   select case document.all.comboResolution.value
  case "3"
      MsRdpClient.FullScreen = TRUE
      resWidth  = screen.width
      resHeight = screen.height
   case "1"
      resWidth  = "800"
      resHeight = "600"
   case "2"
      resWidth  = "1024"
      resHeight = "768"
   end select
   MsRdpClient.DesktopWidth = "{{$resWidth}}"
   MsRdpClient.DesktopHeight = "{{$resHeight}}"
   
   
   MsRdpClient.Width = "{{$resWidth}}"
   MsRdpClient.Height = "{{$resHeight}}"
   
   'Device redirection options
   MsRdpClient.AdvancedSettings2.RedirectDrives     = TRUE
   MsRdpClient.AdvancedSettings2.RedirectPrinters   = TRUE
   MsRdpClient.AdvancedSettings2.RedirectPorts      = FALSE
   MsRdpClient.AdvancedSettings2.RedirectSmartCards = FALSE
   MsRdpClient.AdvancedSettings2.RedirectClipboard = True
   if Left(MsRdpClient.Version,1) >= 6 then 
   MsRdpClient.AdvancedSettings6.RedirectClipboard = TRUE
   end if
   
   'FullScreen title
   MsRdpClient.FullScreenTitle = L_FullScreenTitle_Text & "(" & serverName & ")"
   
   'Display connect region
   Document.all.loginArea.style.display = "none"
   Document.all.connectArea.style.display = "block"
   
   'Connect
   MsRdpClient.Connect
end sub

-->

</script>

<!--   
-->

<!-- =========================LOGIN AREA   ==========================
-->
<div id=loginArea>
<font size="4">





<table border="0" width="640" cellspacing="0" cellpadding=0 style="margin-top: -1em;display: none">
<!-- Graphic bar row  -->
<tr>
<td width="50%"></td>
<td colspan=3 align="left" valign="middle">
<img src="bluebarh.gif" alt="blue bar graphic" width="325" height="8"></td>
</tr> 
<!-- Row 1 -->
    <tr>
<!-- Column 1 spans 4 rows -->
    <td valign="top" width="50% "rowspan=4>
          <p class=indent><ID id=remotecomputername>键入要使用的远程计算机的名称，选择连接的屏幕大小，然后单击<b>连接</b>。</ID></p>
          <p class=indent><ID id=helpfultip1>连接页打开时，您可以将其添加到收藏夹，简化跟同一台计算机的连接。</ID></p>
    </td>
<!-- Column 2 spans 4 rows-->
	<td rowspan=4 valign="top" align="left">
    <img src="bluebarv.gif" alt="blue bar graphic" border=0 width="8" height="330">
	</td>
	
<!-- Column 3 -->		
    <td id="ServerNameKeyWidth" style="width:45%;" valign="middle">     
         <label id=ServerNameKey accessKey="S" for="editServer">
         <br><p align="right">&nbsp;<ID id=ServerName>服务器(<u>S</u>):</ID></label></p>
         </td>
		  
<!-- Column 4 -->		  
	<td id="ServerKeyWidth" width="40%" valign="bottom">
	<br>&nbsp;&nbsp;<input type="text" class="wbk" name="Server" size="41" id="editServer" value="{{$localhost}}">
	
	</td>
	</tr>
<!-- Row 2 -->
<tr>
<!-- Column 3 -->
<td valign="middle">
<p align="right"><label id=sizeKey accessKey="Z" for="comboRes" class="sizespace"><ID id=size>大小(<u>Z</u>):</ID></p></td>
<!-- Column 4 -->
<td valign="bottom">&nbsp;&nbsp;<select  class="wbk"  size="1" name="comboResolution" id=comboRes class="topspace">
             <option value="3" {{if $screen eq 3}}selected{{/if}}><ID id=option1>全屏显示</ID></option>
              <option value="1" {{if $screen eq 1}}selected{{/if}}><ID id=option3>800 x 600</ID></option>
              <option value="2" {{if $screen eq 2}}selected{{/if}}><ID id=option4>1024 x 768</ID></option>
            </select> </label>
</td>
</tr>
<!-- Row 3 -->
<tr>
<!-- Column 3 -->
<td></td>
<!-- Column 4 -->
<td align="bottom">			
	 <p class=topspace>&nbsp;<input type="checkbox" checked name="CheckBoxAutoLogon" ID=Check1 value="OFF" onclick = "checkClick"><label for="Check1" ID=SendLogonKey accesskey="l"><ID id=logoninfo>发送这个连接的登录信息(<u>L</u>)&nbsp;</ID></label><br>
	  
<span ID="tableLogonInfo" style="display: inline">

            <p align="right" class=topspace>
			<br> 
			<ID id=usernamelabel>用户名(<u>U</u>)&nbsp;:</ID>
                <label id=UserNameKey accessKey="U" for="editUserName"><input type="text" class="wbk" name="UserName" id=editUserName size="25" value="{{$username}}"></label><br>
			<ID id=usernamelabel>密码(<u>P</u>)&nbsp;:</ID>
                <label id=UserNameKey accessKey="P" for="editPassWord"><input type="text" class="wbk" name="PassWord" id=editPassWord size="25" value="{{$password}}"></label><br>
			<ID id=domainlabel>域(<u>D</u>):</ID>
          <label id=editDomainKey accessKey="D" for="editDomain">
          <input type="text" class="wbk" name="Domain" id=editDomain size="25"></label></p></span>	
          <input type="submit" id=connectbutton value="连接" disabled="TRUE" name="ButtonLogin" OnClick=BtnConnect class="button">
</td>
</tr>
<!-- Row 4 -->
<tr>
<!-- Column 3 -->
<td  height="215">&nbsp;</td>
<!-- Column 4 -->
<td>&nbsp;</td>
</tr>

 
     
</table>
</div>
<!-- ================================= LOGIN FORM =================
-->

<!-- ================================= CONNECT ====================
-->
<div id=connectArea style="display: none">
<center>
        <table>
        <tr>
        <OBJECT language="vbscript" ID="MsRdpClient"
        onerror="OnControlLoadError"
        onreadystatechange="OnControlLoad"
        CLASSID="CLSID:7584c670-2274-4efb-b00b-d6aaba6d3850"
        CODEBASE="msrdp.cab#version=5,2,3790,0"
        WIDTH=<% resWidth = Request.QueryString("rW")
            if  resWidth < 200 or resWidth > 1600 then
               resWidth = 800
            end if
            Response.Write resWidth %>
        HEIGHT=<% resHeight = Request.QueryString("rH")
            if  resHeight < 200 or resHeight > 1200 then
               resHeight = 600
            end if
            Response.Write resHeight %>>
        </OBJECT>
        </tr>
        <tr>
        <br>
        <font size="1" color="#000000" id="srvfontname" face="宋体, Verdana, Arial, Helvetica">
        <div id=connectDisplay style="display:none">
        <ID id=loggedinsrv>已连接 </ID><i><span id="srvNameField"></span></i></font><br></div>
        </tr>
        
<script language="VBScript">
<!--
sub ReturnToConnectPage()
   'Window.Navigate("Default.htm")
	self.close()
end sub

sub MsRdpClient_OnConnected()
   Document.All.connectDisplay.style.display = "block"
end sub

sub MsRdpClient_OnDisconnected(disconnectCode)
   extendedDiscReason = MsRdpClient.ExtendedDisconnectReason
   majorDiscReason = disconnectCode And &hFF

   if (disconnectCode = &hB08 or majorDiscReason = 2 or majorDiscReason = 1) and not (extendedDiscReason = 5) then
      'Switch back to login area
      ReturnToConnectPage
      exit sub
   end if
   
   errMsgText = L_DisconnectRemoteByServer_ErrorMessage
   if not extendedDiscReason = 0 then
      'Use the extended disconnect code
      select case extendedDiscReason
      case 0   errMsgText  = ""
      case 1   errMsgText  = L_DisconnectRemoteByServerTool_ErrorMessage
      case 2   errMsgText  = L_LogoffRemoteByServer_ErrorMessage
      case 3   errMsgText  = L_DisconnectIdleTimeout_ErrorMessage
      case 4   errMsgText  = L_DisconnectLogonTimeout_ErrorMessage
      case 5   errMsgText  = L_DisconnectByOtherConnection_ErrorMessage
      case 6   errMsgText  = L_ServerOutOfMemory_ErrorMessage
      case 7   errMsgText  = L_ServerDeniedConnection_ErrorMessage
      case 256 errMsgText  = L_LicenseInternal_ErrorMessage
      case 257 errMsgText  = L_NoLicenseServer_ErrorMessage
      case 258 errMsgText  = L_NoLicense_ErrorMessage
      case 259 errMsgText  = L_LicenseBadClientMsg_ErrorMessage
      case 260 errMsgText  = L_LicenseHwidDoesntMatch_ErrorMessage
      case 261 errMsgText  = L_BadClientLicense_ErrorMessage
      case 262 errMsgText  = L_LicenseCantFinishProtocol_ErrorMessage
      case 263 errMsgText  = L_LicenseClientEndedProtocol_ErrorMessage
      case 264 errMsgText  = L_LicenseBadClientEncryption_ErrorMessage
      case 265 errMsgText  = L_CantUpgradeLicense_ErrorMessage
      case 266 errMsgText  = L_LicenseNoRemoteConnections_ErrorMessage
      case else errMsgText = L_ErrMsg_Text
      end select
      if extendedDiscReason > 4096 then
         errMsgText = L_ProtocolErrWITHCODE_ErrorMessage  & errMsgText
      end if
   else
      ' no extended error information, use the disconnect code
      select case disconnectCode
      case 0   errMsgText  = L_ErrMsg_Text
      case 1   errMsgText  = L_ErrMsg_Text
      case 2   errMsgText  = L_ErrMsg_Text
      case 260 errMsgText  = L_BadServerName_ErrorMessage
      case 262 errMsgText  = L_LowMemory_ErrorMessage
      case 264 errMsgText  = L_ConnectionTimeout_ErrorMessage
      case 516 errMsgText  = L_NotResponding_ErrorMessage
      case 518 errMsgText  = L_LowMemory_ErrorMessage
      case 520 errMsgText  = L_BadServerName_ErrorMessage
      case 772 errMsgText  = L_NetworkErr_ErrorMessage
      case 774 errMsgText  = L_LowMemory_ErrorMessage
      case 776 errMsgText  = L_BadServerName_ErrorMessage
      case 1028 errMsgText = L_NetworkErr_ErrorMessage
      case 1030 errMsgText = L_SecurityErr_ErrorMessage
      case 1032 errMsgText = L_IllegalServerName_ErrorMessage
      case 1286 errMsgText = L_EncryptionError_ErrorMessage
      case 1288 errMsgText = L_BadServerName_ErrorMessage
      case 1540 errMsgText = L_BadServerName_ErrorMessage
      case 1542 errMsgText = L_SecurityErr_ErrorMessage
      case 1544 errMsgText = L_LowMemory_ErrorMessage
      case 1796 errMsgText = L_NotResponding_ErrorMessage
      case 1798 errMsgText = L_SecurityErr_ErrorMessage
      case 1800 errMsgText = L_CannotLoopBackConnect_ErrorMessage
      case 2052 errMsgText = L_BadServerName_ErrorMessage
      case 2056 errMsgText = L_LicensingNegotFailed_ErrorMessage
      case 2310 errMsgText = L_SecurityErr_ErrorMessage
      case 2566 errMsgText = L_SecurityErr_ErrorMessage
      case 2822 errMsgText = L_EncryptionError_ErrorMessage
      case 3078 errMsgText = L_EncryptionError_ErrorMessage
      case 3080 errMsgText = L_DecompressionFailed_ErrorMessage
      case 3334 errMsgText = L_ProtocolErr_ErrorMessage
      case 10500 errMsgText = L_ProtocolErr_ErrorMessage
      case else errMsgText = L_InternalErr_ErrorMessage
      end select
   end if
   
   msgbox errMsgText,0,L_DisconnectedCaption_ErrorMessage
   ReturnToConnectPage
   
end sub
-->
        </script>
</table>
</center>
</div>
<script language="vbscript">
btnConnect ()
</script>

</body>
</html>

