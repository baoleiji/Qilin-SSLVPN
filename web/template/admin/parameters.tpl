<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>详细信息</TITLE>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK rel=stylesheet type=text/css 
href="{{$template_root}}/cssjs/liye.css">
<META name=GENERATOR content="MSHTML 8.00.6001.23501">
<SCRIPT type=text/javascript>

function allreload(){
	window.location.reload();
}

function allclose(){
	window.close();
}



</SCRIPT>
</HEAD>
<BODY>
<DIV align=center>
<TABLE border=0 cellSpacing=0 cellPadding=0 width=1000>
  <TBODY>
  <TR>
    <TD height=32 width=22><IMG 
      src="{{$template_root}}/images/top_left2.gif" width=22 
height=35></TD>
    <TD vAlign=top background={{$template_root}}/images/top_mid2.gif 
    width=868 align=left>
      <TABLE border=0 cellSpacing=0 cellPadding=0 width="80%">
        <TBODY>
        <TR>
        <TD height=28 
          align=left vAlign=bottom class=ly><strong>详细信息</strong></TD>
        </TR>
        </TBODY></TABLE></TD>
    <TD vAlign=top background={{$template_root}}/images/top_mid2.gif 
    width=97 align=left>
      <TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
        <TBODY>
        <TR>
          <TD height=31 vAlign=bottom align=right><IMG style="CURSOR: hand" 
            onclick=allreload() border=0 alt=刷新 
            src="{{$template_root}}/images/sx.gif" width=21 height=35></TD>
        <TD height=31 vAlign=bottom width=21 align=right><IMG 
            style="CURSOR: hand" onclick=allclose() border=0 alt=关闭 
            src="{{$template_root}}/images/close.gif" width=21 
          height=35></TD></TR></TBODY></TABLE></TD>
    <TD vAlign=top width=13 align=left><IMG 
      src="{{$template_root}}/images/top_right52.gif" width=13 
    height=35></TD></TR></TBODY></TABLE>
<table width="1000" border="0" cellpadding="0" cellspacing="0">
  <tr>
<td background="{{$template_root}}/images/mid_left2.gif" 
    width="14">&nbsp;</td>
    <td><table border="0" cellspacing="0" cellpadding="0" width="99%">
      <tr>
        <td valign="bottom" align="middle"><table border="0" cellspacing="0" cellpadding="0" width="100%" 
              height="32">
            <tbody>
              <tr>
               <td id="ciscotab" width="104" align="center" background="{{$template_root}}/images/bq.gif"  class="diline"><strong>
						<a href="admin.php?controller=admin_detail&ip={{$ip}}&os=host" style="cursor:hand;" class="ly" title="系统状态" onClick="changeInstanceId('ciscotab','ciscotab')">系统状态</a>
						</strong></td>
				  <td id="interfaceViewTab" width="104" align="center" background="{{$template_root}}/images/bq.gif"  class="diline"><strong>
							<a href="admin.php?controller=admin_detail&action=cisco_interface&ip={{$ip}}&os=host" style="cursor:hand;" class="ly" title="接口一览">接口一览</a>
							</strong></td>
				  <td id="interfaceViewTab" width="104" align="center" background="{{$template_root}}/images/bq.gif" ><strong>
							<a  style="cursor:hand;" class="ly" title="参数配置">参数配置</a>
							</strong></td>
				<td id="interfaceViewTab" width="104" align="center" background="{{$template_root}}/images/bq.gif"  class="diline"><strong>
							<a href="admin.php?controller=admin_detail&action=status_backup&ip={{$ip}}&from=status" style="cursor:hand;" class="ly" title="备份管理">备份管理</a>
							</strong></td>
				<td id="interfaceViewTab" width="104" align="center" background="{{$template_root}}/images/bq.gif"  class="diline"><strong>
							<a href="admin.php?controller=admin_detail&action=status_autorun&ip={{$ip}}&from=status" style="cursor:hand;" class="ly" title="自动脚步" >自动脚步</a>
							</strong></td>
                <td class="diline" align="middle"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="right">&nbsp;  </td>
                  </tr>
                </table></td>
              </tr>
            </tbody>
        </table></td>
      </tr>

      <tr>
        <TD class=full-lan vAlign=top align=middle>
        <table id="detailInfo" border="0" cellspacing="0" cellpadding="0" 
            width="100%">
            <tbody>
              <tr>
                <td width="120" valign="top"><iframe  src="admin.php?controller=admin_detail&action=hostleftmenu&ip={{$ip}}&from=paramters" name="iframe2" width="120" marginwidth="0"  height="586" marginheight="0"  scrolling="No"  frameborder="0" ></iframe></td>
                <td valign="top"><iframe src="admin.php?controller=admin_thold&action=status_thold&ip={{$ip}}&from=hostview" name="rightmain" width="100%"  marginwidth="0" height="586"  marginheight="0"  frameborder="0" ></iframe></td>
              </tr>
            </tbody>
          </table>

          </td>
      </tr>
    </table></td>
  <td background="{{$template_root}}/images/mid_right2.gif" 
    width="14">&nbsp;</td>
  </tr>
</table>
<TABLE border=0 cellSpacing=0 cellPadding=0 width=1000>
  <TBODY>
  <TR>
    <TD vAlign=top width=34><IMG 
      src="{{$template_root}}/images/bottom_left2.gif" width=34 
    height=20></TD>
    <TD background={{$template_root}}/images/bottom_mid2.gif 
    width=936>&nbsp;</TD>
    <TD vAlign=top width=30><IMG 
      src="{{$template_root}}/images/bottom_right2.gif" width=30 
      height=20></TD></TR></TBODY></TABLE></DIV>

</BODY></HTML>
