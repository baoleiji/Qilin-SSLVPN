<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0072)https://103.30.149.78/test/admin.php -->
<HTML><HEAD><TITLE>登录短信认证</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type><LINK 
rel=stylesheet type=text/css href="{{$template_root}}/all_purpose_style.css">
<style type="text/css">
body{ background-color:#d7f2fd;}
td{
	font-size: 14px;
}
#red_text {
	font-size: 16px;
	color: #0078ff;
	font-weight:bold;
}
</style>
<SCRIPT type=text/javascript src="{{$template_root}}/jscss/jquery-1.10.2.min.js"></SCRIPT>

<META name=GENERATOR content="MSHTML 9.00.8112.16526"></HEAD>
<BODY>
<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>
<DIV style="MARGIN: 0px auto; WIDTH: 634px">
<TABLE border=0 cellSpacing=0 cellPadding=0 width=609 align=center>
<form name="f1" method=post  action="admin.php?controller=admin_index&action=chklogin&uid={{$userinfo.uid}}">
  <TBODY>
  <TR>
    <TD align=center><IMG border=0 src="./template/admin/images/phone_top.jpg" width=609 
      height=58></TD></TR>
  <TR>
    <TD height=311 vAlign=top background=./template/admin/images/phone_bottom.jpg align=center>
    <TABLE width="90%" border=0 align="center" cellPadding=0 cellSpacing=0>
        <TBODY>
        <TR>
          <TD height=160 vAlign=bottom align=center>
            <TABLE border=0 cellSpacing=1 cellPadding=5 width="100%"  >
              <TBODY>
              <TR>
                <TD>
                  <TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
                    <TBODY>
                      <TR>
                        <TD width="40%" height=45  align=right>用户名：</TD>
                        <TD id=red_text>{{$userinfo.username}}</TD>
                        </TR>
                      <TR>
                        <TD height=45 align=right>手机号：</TD>
                        <TD id=red_text>{{$userinfo.mobilenum}}</TD></TR>
                      <TR>
                        <TD height=45 align=right>输入短信密码：</TD>
                        <TD><input type=text name="smspassword" id="smspassword" style="WIDTH: 85px; height:30px; line-height:30px;"  value="" >
                          &nbsp;&nbsp;
                <input onClick="sendsms(120);" id="ElapsedTimeBu" type="button" value="获取短信密码"  class="phonebtn3"/></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD height=95 align=center><input type="submit" name="button" id="button" value="提 交" class="phonebtn1" onmousemove="this.className='phonebtn1cur'" onmouseout="this.className='phonebtn1'" />
  <input type="button" name="button2" id="button2" value="重 置"  class="phonebtn2" onmousemove="this.className='phonebtn2cur'" onmouseout="this.className='phonebtn2'"  />
          
</TD></TR></TBODY></TABLE></TD></TR></FORM></TBODY></TABLE></DIV>


<script language="javascript">
function sendsms(seconds){
	window.open ('admin.php?controller=admin_index&action=get_sms&uid={{$userinfo.uid}}', 'hide', 'height=130, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');
	document.getElementById('ElapsedTimeBu').disabled = true;
	document.getElementById('ElapsedTimeBu').value='还剩'+seconds+'秒';
	ElapsedTime(seconds)
	
}
function ElapsedTime(seconds){
	if(seconds==1){
		document.getElementById('ElapsedTimeBu').disabled = false;
		document.getElementById('ElapsedTimeBu').value='获取短信密码';
		return ;
	}
	document.getElementById('ElapsedTimeBu').value='还剩'+(seconds-1)+'秒';
    setTimeout("ElapsedTime("+(seconds-1)+")", 1000);
}

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>

