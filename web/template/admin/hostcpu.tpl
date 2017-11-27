<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>指标信息</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
.div_scrollbar2 {
	width:99%;   height:260px;   z-index:1;   overflow:   auto;SCROLLBAR-FACE-COLOR: #ffffff; SCROLLBAR-HIGHLIGHT-COLOR: #f3f3f3; SCROLLBAR-SHADOW-COLOR: COLOR:#000000 ; SCROLLBAR-3DLIGHT-COLOR: #ffffff; SCROLLBAR-ARROW-COLOR: #006c90;  SCROLLBAR-DARKSHADOW-COLOR: #ffffff;BORDER: #d1dbe1 1px solid;  
}
</STYLE>
<LINK rel=stylesheet type=text/css 
href="{{$template_root}}/cssjs/liye.css">
<META name=GENERATOR content="MSHTML 8.00.6001.23501">
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<body>
<div style='text-align:left; position:relative; left:0; top:0; width:100%; height:100%; overflow: auto;'>
			<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width='5'>
						<img src='{{$template_root}}/images/spacer.gif' width='5'>
					</td>
				  <td>
						
						<TABLE cellSpacing=0 cellPadding=0 width=675 border=0>	<TBODY>		<TR>			<TD vAlign=top align=middle width="68%">			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>				<TBODY>					<TR>						<TD width=19><IMG height=23 src="{{$template_root}}/images/01a.gif"							width=19></TD>						<TD vAlign=center align=middle width=90 bgColor=#ffffff><STRONG							class=lanzi_x><nobr>指标信息</nobr></STRONG></TD><TD  background={{$template_root}}/images/02a.gif>&nbsp;</TD>						<TD width=23><IMG height=23 src="{{$template_root}}/images/03a.gif"							width=23></TD></TR>				</TBODY>			</TABLE>	<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0><TBODY>	<TR>	<TD width=16  background={{$template_root}}/images/04a.gif>&nbsp;</TD><TD vAlign=top>
						
						<table width='95%' border='0' cellspacing='0' cellpadding='3'><tr><td width='30%' height='22' align='left' class='table-bottom-border'><strong>指标描述：</strong></td><td title='主机的CPU利用率的平均值' width='70%' align='left' class='table-bottom-border'>主机的{{$typename}}{{if $type ne 'tcpport'}}利用率的平均值{{else}}端口响应时间{{/if}}</td></tr><tr><td width='30%' height='22' align='left' class='table-bottom-border'><strong>确认状态：</strong></td><td width='70%' align='left' class='table-bottom-border'>   <img src='{{$template_root}}/images/{{if $localport[p].port_status le '0' }}RhombusRed.gif{{else}}RhombusGreen.gif{{/if}}' width='14' height='14' border='0' align='absmiddle'></td></tr>
						{{if $type ne 'tcpport'}}
						<tr><td width='30%' height='22' align='left' class='table-bottom-border'><strong>   <img src='{{$template_root}}/images/RhombusRed.gif' width='14' height='14' border='0' align='absmiddle'>阈值上限：</strong></td><td title='{{$status.highvalue}}%' width='70%' align='left' class='table-bottom-border'> 
						{{section name=p loop=$status}}
						{{if $status[p].type eq 'disk'}}
						({{$status[p].disk}})
						{{/if}}
						{{$status[p].highvalue}}%&nbsp;&nbsp;
						{{/section}}
						</td></tr>						
						<tr><td width='30%' height='22' align='left' class='table-bottom-border'><strong>   <img src='{{$template_root}}/images/RhombusYellow.gif' width='14' height='14' border='0' align='absmiddle'>阈值下限：</strong></td><td title='{{$status.lowvalue}}%' width='70%' align='left' class='table-bottom-border'>
						{{section name=p loop=$status}}
						{{if $status[p].type eq 'disk'}}
						({{$status[p].disk}})
						{{/if}}
						{{$status[p].lowvalue}}%&nbsp;&nbsp;
						{{/section}}</td></tr>
						<tr><td width='30%' height='22' align='left' class='table-bottom-border'><strong>当前值：</strong></td><td title='{{$status.value}}%' width='70%' align='left' class='table-bottom-border'>
						{{section name=p loop=$status}}
						{{if $status[p].type eq 'disk'}}
						({{$status[p].disk}})
						{{/if}}
						{{if $status[p].value lt 0}}无法获取{{else}}{{$status[p].value}}%{{/if}}&nbsp;&nbsp;
						{{/section}}</td></tr>
						{{else}}
						<tr><td width='30%' height='22' align='left' class='table-bottom-border'><strong>   <img src='{{$template_root}}/images/{{if $status.value eq NULL or $status.value <0 }}RhombusRed.gif{{elseif $status.value < $status.lowvalue or $status.value < $status.highvalue}}RhombusYellow.gif{{else}}RhombusGreen.gif{{/if}}' width='14' height='14' border='0' align='absmiddle'>阈值：</strong></td><td title='{{$status.highvalue}}%' width='70%' align='left' class='table-bottom-border'>
						{{$status.0.highvalue}} ms&nbsp;&nbsp;</td></tr>
						<tr><td width='30%' height='22' align='left' class='table-bottom-border'><strong>当前值：</strong></td><td title='{{$status.value}}%' width='70%' align='left' class='table-bottom-border'>
						{{if $status.0.value lt 0}}无法获取{{else}}{{$status.0.value}}%{{/if}} ms&nbsp;&nbsp;</td></tr>
						{{/if}}
						<tr><td width='30%' height='22' align='left' class='table-bottom-border'><strong>最近采集时间：</strong></td><td title='{{$status.datetime}}' width='70%' align='left' class='table-bottom-border'>{{$status.0.datetime}}</td></tr></table>
						<!-- 间隔空行 -->
						<table width="98%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="10"></td>
							</tr>
						</table>
						<!-- 间隔空行 -->
												</TD>						<TD width=14 background={{$template_root}}/images/05a.gif>&nbsp;</TD>					</TR>				</TBODY>			</TABLE>			<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>				<TBODY>					<TR>						<TD vAlign=top width=32><IMG height=17							src="{{$template_root}}/images/06a.gif" width=32></TD>						<TD width=98% background={{$template_root}}/images/07a.gif>&nbsp;</TD>						<TD vAlign=top width=30><IMG height=17							src="{{$template_root}}/images/08a.gif" width=30></TD>					</TR>				</TBODY>			</TABLE>			</TD>		</TR>	</TBODY></TABLE>
						
						<table width="675" height="40" border="0" cellspacing="0" cellpadding="0">
                          <tr valign="middle" align="right">
                            <td width="50%"></td>
                            <td align="right"><img id="1d" src='{{$template_root}}/images/1d.gif' onClick="reloadimg(this.id);" style="cursor:hand;" alt="最近1天" title="最近1天">&nbsp; <img id="7d" src='{{$template_root}}/images/7d.gif' onClick="reloadimg('week');" style="cursor:hand;" alt="最近7天" title="最近7天">&nbsp; <img id="30d" src='{{$template_root}}/images/30d.gif' onClick="reloadimg('month');" style="cursor:hand;" alt="最近30天" title="最近30天">&nbsp; <img id="365d" src='{{$template_root}}/images/365d.gif' onClick="reloadimg('year');" style="cursor:hand;" alt="最近365天" title="最近365天">&nbsp;&nbsp; <img id="f_rangeStart_trigger" name="f_rangeStart_trigger" src='{{$template_root}}/images/period.gif' style="cursor:hand;" alt="自定义时间段" title="自定义时间段"><input type="hidden"  name="f_rangeStart" size="13" id="f_rangeStart" value="" class="wbk"/>&nbsp;<img src='{{$template_root}}/images/excel.png' style="cursor:hand;" onclick="excel();" alt="导出csv" title="导出csv"> </td>
                          </tr>
                        </table>
						<div class="div_scrollbar2" style="">
						<table width="675" border="0" cellspacing="0" cellpadding="0">
  {{section name=p loop=$status}}
  <tr>
    <td align="center"><!-- 显示图片 -->
        <div id="cutDiv">
          <div id='cutDis' style='position:absolute; overflow:none; left:0px; top:0px; width:0px; height:0px; visibility:visible; background:magenta; filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity:0.5; opacity:0.5; z-index:5' ></div>
          <IMG src="admin.php?controller=admin_monitor&action=status_image&type={{$status[p].type}}&id={{$status[p].seq}}&{{$mktime}}" imgid="{{$status[p].seq}}" name="zoomGraphImage" width="500" height="200" ondragstart="return false" ondrag="return false" ondragend="return false"> </div></td>
  </tr>
  {{/section}}<tr><td align="right">{{if $type eq 'tcpport'}}<input type="button" onclick="window.location='admin.php?controller=admin_detail&action=tcp_port_value_delete&ip={{$status[0].ip}}&id={{$status[0].seq}}'" value="删除"/>{{/if}}</td></tr>
                        </table>
						</div>
						</td>
				</tr>
				
			</table>
		</div>

<script type="text/javascript">
function reloadimg(duration){
	var img = document.getElementsByName("zoomGraphImage");
	for(var i=0; i<img.length; i++){
		var id=img[i].attributes['imgid'].nodeValue;
		img[i].src="admin.php?controller=admin_monitor&action=status_image&duration="+duration+"&type={{$status.0.type}}&id="+id+"&{{$mktime}}";
	}
	
}
function excel(){
	var img = document.getElementsByName("zoomGraphImage");
	window.open(img[0].src+"&rrdexport=1&"+parseInt(10000*Math.random()));
}
var cal = Calendar.setup({
    onSelect: function(cal) { 
				cal.hide();
				var img = document.getElementsByName("zoomGraphImage");
				for(var i=0; i<img.length; i++){
					var id=img[i].attributes['imgid'].nodeValue;
					img[i].src="admin.php?controller=admin_monitor&action=status_image&date="+cal.selection.sel[0]+"&type={{$status.0.type}}&id="+id+"&{{$mktime}}";
				}
			 },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");

</script>

</body>
</html>
