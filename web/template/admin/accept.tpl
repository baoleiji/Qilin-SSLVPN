<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<TITLE>登录提示</TITLE> 
<META http-equiv="Content-Type" content="text/html; charset=utf-8"><LINK href="{{$template_root}}/all_purpose_style.css" 
rel="stylesheet" type="text/css"> 
<STYLE type="text/css">
td{
	font-size: 14px;
}
#red_text {
	font-size: 16px;
	color: #0078ff;
	font-weight:bold;
}

#tinybox{position:absolute; display:none; padding:10px; background:#ffffff url(image/preload.gif) no-repeat 50% 50%; border:10px solid #e3e3e3; z-index:2000;}
#tinymask{position:absolute; display:none; top:0; left:0; height:100%; width:100%; background:#000000; z-index:1500;}
#tinycontent{background:#ffffff; font-size:1.1em;}
</STYLE>
 
<SCRIPT src="{{$template_root}}/cssjs/jquery-1.10.2.min.js" type="text/javascript"></SCRIPT>

<BODY style="background-color:#f1f1f1;">
<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>
<DIV style="margin: 0px auto; width: 634px; ">
<TABLE width="670" align="center" border="0" cellspacing="0" cellpadding="0">
  <FORM name="f1" action="admin.php?controller=admin_index&amp;action=doaccept" 
  method="post" >
  <TBODY>
  <TR>
    <TD align="center" valign="top"><img src="{{$template_root}}/images/dlts.jpg" width="670" height="43"></TD>
  </TR>
  <TR>
    <TD height="395" align="center" valign="top" background="{{$template_root}}/images/mobile_bottom.jpg">
      <br>
      <TABLE width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
        <TBODY>
        <TR>
          <TD height="160" align="center" valign="bottom">
            <TABLE width="100%" border="0" cellspacing="1" cellpadding="5">
              <TBODY>
              <TR>
                <TD>
                  <TABLE width="100%" border="0" cellspacing="0" 
cellpadding="0">
                    <TBODY>
                    <TR>
                      <TD colspan="2" height="45" align="left">{{$accept|nl2br}}</TD></TR>
					  <tr><td colspan="2" align="left"><b>我已经阅读并且同意上述要求 </b><input type="checkbox" onclick="makesuer(this.checked)" /> 

			
</TBODY>

</TABLE></TD></TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD height="95" align="center"><INPUT name="button" class="phonebtn2" id="button" onMouseOut="this.className='phonebtn1'" onMouseMove="this.className='phonebtn1cur'" type="submit" disabled value="同 意">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT name="button" onclick="window.location='admin.php?controller=admin_index&action=logout'" class="phonebtn1" id="button1" onMouseOut="this.className='phonebtn1'" onMouseMove="this.className='phonebtn1cur'" type="button" value="不同意">                    </TD></TR></TBODY></TABLE></TD></TR></TBODY></FORM></TABLE>
</DIV>
<script>
function makesuer(c){
	if(c) {
		document.getElementById('button').disabled=false;
		document.getElementById('button').className='phonebtn1';
	}
	else {
		document.getElementById('button').disabled=true;
		document.getElementById('button').className='phonebtn2';
	}
}
</SCRIPT>
 <IFRAME name="hide" height="0" src="about:blank" frameborder="0" scrolling="no"></IFRAME> </BODY></HTML>
