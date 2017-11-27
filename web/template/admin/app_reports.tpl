<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>OSSIM框架</TITLE>
<META content="text/html; charset=UTF-8" http-equiv=Content-Type>
<META content=no-cache http-equiv=Pragma>
<link href="template/admin/all_purpose_style.css" type="text/css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="template/admin/cssjs/jscal2.css" />
<script src="template/admin/cssjs/jscal2.js"></script>
<script src="template/admin/cssjs/cn.js"></script>
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
</STYLE>
<script>
function keyup(keycode){
	if(keycode==13){
		searchit();
	}
}
function changetimetype(id){
	document.getElementById(id).checked = true;
}
</script>
<script type="text/javascript">
function reloadimg(duration){
	var img = document.getElementById("zoomGraphImage");
	img.src=img.src+"&duration="+duration+"&"+parseInt(10000*Math.random());
}
</script>
<script src="./template/admin/cssjs/jquery-1.7.2.min.js"></script>
<script src="./template/admin/cssjs/highcharts.js"></script>
<script src="./template/admin/cssjs/exporting.js"></script>
<script language="JavaScript">

	var chart;
	$(document).ready(function() {
	{{section name=d loop=$graphdata}}
	var arr = {{$graphdata[d].v}};
	getBar('g_{{$smarty.section.d.index}}','ip','{{$graphdata[d].k_cn}}',arr);
	{{/section}}
		
	});
	
	 function	getBar(divid,cname,title,arr){

	var y = 55;
	var rotation = -65;
	var bottom = 100;
	if(cname=='protocol'){
		y = 20;
		bottom = 40;
		rotation = 0;
	}
	var colors = Highcharts.getOptions().colors;
	var max = parseInt(arr[0].num)+0.5;
	var categories = new Array();
	var data = new Array();
     for(var i=0; i<arr.length;i++){
	        categories[i] = arr[i][cname];
	        var o = new Object();
	        o.y = arr[i].num;
	        o.color = colors[i];
	        data[i] =  o;
 
	  }
		chart = new Highcharts.Chart({
			chart: {
				renderTo: divid, 
				type: 'column',
				marginBottom: bottom,
				marginTop: 20
			},
			title: {
				text: ''
			},
			xAxis: {
				categories: categories,
				tickPixelInterval:1000,
			//	tickInterval:10,
				labels:{  
				  rotation: rotation,
				  y:y 	
				}					
			},
			yAxis: {
				title: {
					
					rotation: 0,
					text: '数<br />量'
				},
				max:max
			},
			plotOptions: {
				column: {
					cursor: 'pointer',
					pointPadding: 0.2,
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						color: colors[0],
						formatter: function() {
							return this.y ;
						}
					}					
				}
			},
			tooltip: {
				formatter: function() {
					var point = this.point,
					s = this.x +':<b>'+ this.y +'</b><br/>';
					return s;
				}
			},
			legend: { 
					            enabled: false  //设置图例不可见 
					        },
			series: [{
				name: title,
				data: data,
				color: 'white'
			}],
			exporting: {
				enabled: false
			}
		});
	}
</script>
</HEAD>
<BODY style="float:center">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >

  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0"  >
       <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=host_reports">主机报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=app_reports">应用报表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=dns_report">DNS报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
<tr>
	<td align="left" colspan = "7"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

		<TBODY>
		 <TR>
			<TD >
			<form name ='f1' action='admin.php?controller=admin_reports&action=app_reports' method='get' >
<input type="hidden" name="controller" value="admin_reports" />
<input type="hidden" name="action" value="app_reports" />
设备组:<select name='group'  style="width:150px">
<option value='' >全部设备</option>
{{section name=g loop=$sgroup}}
<option value='{{$sgroup[g].id}}' >{{$sgroup[g].groupname}}</option>
{{/section}}
</select>&nbsp;&nbsp;&nbsp;&nbsp;
内容:<select name='content' >
<option value='mysql' {{if $content eq 'mysql'}}selected{{/if}}>MySQL</option>
<option value='apache' {{if $content eq 'apache'}}selected{{/if}}>Apache</option>
<option value='tomcat' {{if $content eq 'tomcat'}}selected{{/if}}>Tomcat</option>
<option value='nginx' {{if $content eq 'nginx'}}selected{{/if}}>Nginx</option>
</select>
<input type="text" name="date" id="date" size="25" value="{{$ymd}}"/><input type="button" id="f_date" name="f_date" value="开始时间"> - <input type="text" name="date_e" id="date_e" size="25" value="{{$ymd_e}}"/><input type="button" id="f_date_e" name="f_date_e" value="结束时间"> 

<input type="submit" value="提交"  class="bnnew2"/>
<script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() }
});
cal.manageFields("f_date", "date", "%Y-%m-%d");
cal.manageFields("f_date_e", "date_e", "%Y-%m-%d");
</script>
			</form>
			</TD>
		  </TR>
		  </table></td></tr>		 
      <tr  >
        <td class="">
		<TR>
                  <TD style="MARGIN-TOP: 10px" colspan="9">
				  <table cellSpacing=0 cellPadding=0 width="100%" align=center><tr>
{{section name=d loop=$graphdata}}
{{if $smarty.section.d.index gt 0 and $smarty.section.d.index%2 eq 0}}
</tr><tr>
{{/if}}
<td width="50%"><table width="100%" style="height:230px;"  class="BBtable">
									<tr>
										<th   style="text-align:left"   class="list_bg">{{$graphdata[d].k_cn}}</th>
									</tr>
									<tr>
										<td style="height:100%;" >
										 <div id="g_{{$smarty.section.d.index}}" style="width: 100%;height:80%;  margin: 1 auto"></div>
										</td>
									</tr>
								</table></td>
{{/section}}
</tr></table>
</TD>
                </TR>
		  <TABLE class=BBtable cellSpacing=0 cellPadding=0 width="100%" align=center>		
              <TBODY>			
	{{if $content eq 'apache'}}		  
			<TR>
                <td width="10%" class="list_bg">主机</td>
				<TD class="list_bg" >每秒流量 KB/s</TD>
				<TD class="list_bg" >系统占用</TD>
				<TD class="list_bg" >请求速率</TD>
				<TD class="list_bg" >当前进行数</TD>
				<TD class="list_bg" >正在处理请求</TD>
			  </TR>
			{{section name=h loop=$reports}}
		 <TR {{if $smarty.section.h.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD class="">{{$reports[h].device_ip}}</TD>
		<TD class="">{{$reports[h].cpu_load}}</TD>
		<TD class="">{{$reports[h].request_rate}}</TD>
		<TD class="">{{$reports[h].traffic_rate}}</TD>
		<TD class="">{{$reports[h].process_num}}</TD>
		<TD class="">{{$reports[h].busy_process}}</TD>
	  </TR>
	 
	{{sectionelse}}
	   <TR>
                  <TD style="MARGIN-TOP: 10px" colspan="9">没有数据</TD>
                </TR>
	{{/section}}
	{{elseif $content eq 'mysql'}}
	<TR>
                <td width="10%" class="list_bg" >主机</td>
				<TD class="list_bg" >打开文件数</TD>
				<TD class="list_bg" >打开表数</TD>
				<TD class="list_bg" >连接数</TD>
				<TD class="list_bg" > 查询速率 </TD>
			  </TR>
			{{section name=h loop=$reports}}
		 <TR {{if $smarty.section.h.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD class="">{{$reports[h].device_ip}}</TD>
		<TD class="">{{$reports[h].questions_rate}}</TD>
		<TD class="">{{$reports[h].open_tables}}</TD>
		<TD class="">{{$reports[h].open_files}}</TD>
		<TD class="">{{$reports[h].threads}}</TD>
	  </TR>
	 
	{{sectionelse}}
	   <TR>
                  <TD style="MARGIN-TOP: 10px" colspan="9">没有数据</TD>
                </TR>
	{{/section}}
	{{elseif $content eq 'tomcat'}}
	<TR>
                <td width="10%" class="list_bg" >主机</td>
				<TD class="list_bg" >每秒流量 KB/s</TD>
				<TD class="list_bg" >CPU平均占用率 %</TD>
				<TD class="list_bg" >每秒请求数量</TD>
				<TD class="list_bg" > 当前jvm内存使用率 </TD>
				<TD class="list_bg" > 当前工作线程数 </TD>
			  </TR>
			{{section name=h loop=$reports}}
		 <TR {{if $smarty.section.h.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD class="">{{$reports[h].device_ip}}</TD>
		<TD class="">{{$reports[h].traffic_rate}}</TD>
		<TD class="">{{$reports[h].cpu_load}}</TD>
		<TD class="">{{$reports[h].request_rate}}</TD>
		<TD class="">{{$reports[h].memory_usage}}</TD>
		<TD class="">{{$reports[h].busy_thread}}</TD>
	  </TR>
	 
	{{sectionelse}}
	   <TR>
                  <TD style="MARGIN-TOP: 10px" colspan="9">没有数据</TD>
                </TR>
	{{/section}}
	{{elseif $content eq 'nginx'}}
	<TR>
                <td width="10%" class="list_bg" >主机</td>
				<TD class="list_bg" >nginx 请求率（点击率）</TD>
				<TD class="list_bg" >nginx 连接数（并发数）</TD>
			  </TR>
			{{section name=h loop=$reports}}
		 <TR {{if $smarty.section.h.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD class="">{{$reports[h].device_ip}}</TD>
		<TD class="">{{$reports[h].request_rate}}</TD>
		<TD class="">{{$reports[h].connect_num}}</TD>
	  </TR>
	 
	{{sectionelse}}
	   <TR>
                  <TD style="MARGIN-TOP: 10px" colspan="9">没有数据</TD>
                </TR>
	{{/section}}
	{{/if}}
	<tr>
	  <td  colspan="8" align="right">
		   			&nbsp&nbsp;&nbsp;共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_monitor&action=system_monitor&page='+this.value;">页&nbsp;&nbsp;&nbsp;{{if $smarty.session.ADMIN_LEVEL eq 3}}<a href="{{$curr_url}}&derive=1" target="hide">{{$language.ExportresulttoExcel}}</a>{{/if}}
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



</BODY></HTML>

