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
  <table width="700" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="top">
                          <table width="96%" border="1" align="center" cellpadding="0" cellspacing="0"  bordercolorlight="#D4D4D4" bordercolordark="#FFFFFF" bgcolor="#F9F9F9">
                            <tr>
                              <td align="center" bgcolor="#D6E8FF" valign="middle"><table height="22" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td rowspan="2" valign="middle" align="center"><nobr><strong>等级</strong></nobr></td>
                                    <td height="11" align="center" valign="bottom"><a href="#" onClick="showOrderBy('-1', 'asc');return false;"><img src="{{$template_root}}/images/st-paixus.gif" width="10" height="8" align="absmiddle" border="0"></a></td>
                                  </tr>
                                  <tr>
                                    <td height="11" align="center" valign="top"><a href="#" onClick="showOrderBy('-1', 'desc');return false;"><img src="{{$template_root}}/images/st-paixu.gif" width="10" height="6" align="absmiddle" border="0"></a></td>
                                  </tr>
                              </table></td>
                              <td  align="center" bgcolor="#D6E8FF"><nobr><strong>时间</strong></nobr></td>
                             
                          
                              <td  height="46" align="center" bgcolor="#D6E8FF" valign="middle"><table width="100" height="22" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td rowspan="2" valign="middle" align="center"><nobr><strong>program</strong></nobr></td>
                                    <td height="11" align="center" valign="bottom"><a href="#" onClick="showOrderBy('2', 'asc');return false;"><img src="{{$template_root}}/images/st-paixus.gif" width="10" height="8" align="absmiddle" border="0"></a></td>
                                  </tr>
                                  <tr>
                                    <td height="11" align="center" valign="top"><a href="#" onClick="showOrderBy('2', 'desc');return false;"><img src="{{$template_root}}/images/st-paixu.gif" width="10" height="6" align="absmiddle" border="0"></a></td>
                                  </tr>
                              </table></td>
                              <td  height="46" align="center" bgcolor="#D6E8FF" valign="middle"><table width="100" height="22" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td rowspan="2" valign="middle" align="center"><nobr><strong>信息</strong></nobr></td>
                                    <td height="11" align="center" valign="bottom"><a href="#" onClick="showOrderBy('3', 'asc');return false;"><img src="{{$template_root}}/images/st-paixus.gif" width="10" height="8" align="absmiddle" border="0"></a></td>
                                  </tr>
                                  <tr>
                                    <td height="11" align="center" valign="top"><a href="#" onClick="showOrderBy('3', 'desc');return false;"><img src="{{$template_root}}/images/st-paixu.gif" width="10" height="6" align="absmiddle" border="0"></a></td>
                                  </tr>
                              </table></td>
                             
                            </tr>
							{{section name=i loop=$eventlogs}}
                            <tr>
                              <td><span onMouseOver="showAllContent('{{$eventlogs[i].port_describe}}', 16);" onMouseOut="document.getElementById('msg_id').style.display='none';"><nobr><img style="cursor:hand" src='{{$template_root}}/images/Gray.gif' onClick="gotoStateSearch('472614B7732A12081FB6B5FCDE870DA688C0CDB8');" /><span style="width:120; overflow: hidden; text-overflow:ellipsis;"><nobr>{{$eventlogs[i].level}}</nobr></span></nobr></span></td>
                              <td><NOBR>{{$eventlogs[i].datetime}}</NOBR></td>
                             
                              <td width="98" height="30" align="center" id="01" style=""><nobr> <a style="text-decoration: none;" href="javascript:void(0);">{{$eventlogs[i].program}}</a> </nobr> </td>
                              <td width="98" height="30" align="center" id="02" style=""><nobr> <a style="text-decoration: none;" href="javascript:void(0);">{{$eventlogs[i].msg}}</a> </nobr> </td>
                            </tr>
							{{/section}}
                            
                          </table>
                      </td>
                    </tr>
                  </table>

</BODY></HTML>



