<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>OSSIM框架</TITLE>
<META content="text/html; charset=UTF-8" http-equiv=Content-Type>
<META content=no-cache http-equiv=Pragma>
<link href="template/admin/all_purpose_style.css" type="text/css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
<script type="text/javascript">
function changetype(sid){
document.getElementById(sid).checked=true;
}
function searchit(){
	document.report.action = "admin.php?controller=admin_monitor&action=weixin_monitor";
	document.report.action += "&f_rangeStart="+document.report.f_rangeStart.value;
	document.report.action += "&f_rangeEnd="+document.report.f_rangeEnd.value;
	document.report.submit();
	return false;
}
</script>
</HEAD>
<BODY style="float:center">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >

  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
       <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=apache_monitor">Apache</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=mysql_monitor">MySQL</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=tomcat_monitor">Tomcat</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=nginx_monitor">Nginx</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=oracle_tablespace_monitor">Oracle</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=weixin_monitor">微信监控</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_monitor&action=dns_monitor">DNS</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
<tr>
	<td align="left" colspan = "7"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

		<TBODY>
		 <TR>
			<TD >
			<form name ='report' action='admin.php?controller=admin_pro&action=dev_index' method=post  onkeyup="keyup(event.keyCode);"  onsubmit="return false;">
			{{$language.Starttime}}：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="{{$f_rangeStart|date_format:'%Y-%m-%d'}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="{{$language.Edittime}}"  class="wbk">


 {{$language.Endtime}}：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd"  value="{{$f_rangeEnd|date_format:'%Y-%m-%d'}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="{{$language.Edittime}}"  class="wbk">
 &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
			</form>
			</TD>
		  </TR>
		  </table></td></tr>
      <tr  >
        <td class="" width="100%">

		  <TABLE class=BBtable cellSpacing=0 cellPadding=0 width="100%"             align=center>
              <TBODY>
			
			  
              <TR>
                <TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=apache_monitor&orderby1=device_ip&orderby2={{$orderby2}}">时间</a></TD>
				<TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=apache_monitor&orderby1=hostname&orderby2={{$orderby2}}">注用户数</a></TD>
				<TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=apache_monitor&orderby1=datetime&orderby2={{$orderby2}}">新注册用户数</a></TD>
				<TD width="9%" class="list_bg"><a href = "admin.php?controller=admin_monitor&action=apache_monitor&orderby1=app_type&orderby2={{$orderby2}}">新绑定用户数</a></TD>
                <TD width="9%"  class="list_bg"><a href = "admin.php?controller=admin_monitor&action=apache_monitor&orderby1=value&orderby2={{$orderby2}}">订单总数</a></TD>
                <TD width="9%"  class="list_bg"><a href = "admin.php?controller=admin_monitor&action=apache_monitor&orderby1=mail_alarm&orderby2={{$orderby2}}">订单总金额</a></TD>
                <TD width="9%"  class="list_bg"><a href = "admin.php?controller=admin_monitor&action=apache_monitor&orderby1=sms_alarm&orderby2={{$orderby2}}">支付总金额</a></TD>
              </TR>
			{{section name=h loop=$hosts}}
		 <TR {{if $smarty.section.h.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD class="">{{$hosts[h].date}}</TD>
		<TD class="">{{$hosts[h].sumAttentnum}}</TD>
		<TD class="" style="text-align:left">{{$hosts[h].sumRegnum}}</TD>
		<TD class="" style="text-align:left">{{$hosts[h].sumBindnum}}</TD>
		<TD class="" style="text-align:left">{{$hosts[h].sumpaynum}}</TD>
		<TD class="" style="text-align:left">{{$hosts[h].summoneynum}}</TD>
		<TD class="" style="text-align:left">{{$hosts[h].sumpaymoneynum}}</TD>	
	  </TR>
	{{sectionelse}}
	   <TR>
                  <TD style="MARGIN-TOP: 10px" colspan="9">没有数据</TD>
                </TR>
	{{/section}}
	<tr>
	  <td  colspan="10" align="right">
		   			&nbsp&nbsp;&nbsp;共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_monitor&action=weixin_monitor&page='+this.value;">页&nbsp;&nbsp;&nbsp;{{if $smarty.session.ADMIN_LEVEL eq 3}}<a href="{{$curr_url}}&derive=1" target="hide">{{$language.ExportresulttoExcel}}</a>{{/if}}
		   </td>
		   </tr>
		</TBODY></TABLE>
  
    
		  </td>
      </tr>
	  <tr><td cellpadding="3" height="15" align="right"></td></tr>
    </table></td>
  </tr>
  <tr><td height="10"></td></tr>
</table>

 <script type="text/javascript">
                  new Calendar({
                          inputField: "f_rangeStart",
                          dateFormat: "%Y-%m-%d",
                          trigger: "f_rangeStart_trigger",
                          bottomBar: false,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                 
                                  this.hide();
                          }
                  });
                  new Calendar({
                      inputField: "f_rangeEnd",
                      dateFormat: "%Y-%m-%d",
                      trigger: "f_rangeEnd_trigger",
                      bottomBar: false,
                      onSelect: function() {
                              var date = Calendar.intToDate(this.selection.get());
                             
                              this.hide();
                      }
              });
                </script>

</BODY></HTML>

