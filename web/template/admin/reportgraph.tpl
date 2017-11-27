<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/jquery-1.7.2.min.js"></script>
<script src="./template/admin/cssjs/highcharts.js"></script>
<script src="./template/admin/cssjs/exporting.js"></script>
<script language="JavaScript">

	var chart;
	$(document).ready(function() {
		var arr = {{$top10user}};
		getBar('top10user','username','堡垒机用户排行TOP10 ',arr);
		
		var arr = {{$top10protocol}};
		getPie('top10protocol','protocol','协议使用',arr);
		
		var arr = {{$top10srcip}};
		getBar('top10srcip','sourceip','登录来源IP',arr);
		
		var arr = {{$top10dstip}};
		getBar('top10dstip','serverip','登录目标IP',arr);
		
		var arr = {{$last10user}};
		getLine('last10user','audituser','10天堡垒机登录',arr);
	});
	
	 function	getBar(divid,cname,title,arr){

 //	alert(divid+"-"+cname+"-"+title);

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

	function getPie(divid,cname,title,arr){
	var data = new Array();
 	for(var i=0; i<arr.length;i++){
	        var o = new Object();
	        o.y = parseInt(arr[i].num);
	        o.name = arr[i][cname];
	        data[i] =  o;
	  }
	
		chart = new Highcharts.Chart({
					chart: {
						renderTo: divid,
						plotBackgroundColor: null,
						plotBorderWidth: null,
						marginRight: 30,
						marginLeft: 40,
						marginTop: 25,
						marginBottom: 120,
						plotShadow: false
					},
					title: {
						text: ''
					},
					exporting: { 
			            enabled: false  //设置导出按钮不可用 
			        }, 
					tooltip: {
						formatter: function() {
							return   this.point.name+":"+this.y;
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								formatter: function() {
								//	return  this.point.name+":<br>"+this.y;
									return  this.y;
								}
							},
							showInLegend: true
						}
					},
				    series: [{
						type: 'pie',
						name: 'Browser share',
						data: data
					}]
				});
	}

	function getLine(divid,cname,title,arr){
	var categories = new Array();
	var data = new Array();
     for(var i=0; i<arr.length;i++){
     		var name = arr[i][cname];
     		var tmp_arr = name.split(' ');
	        categories[i] = tmp_arr[0] ;
	        data[i] = parseInt(arr[i].num);
 
	  }
		chart = new Highcharts.Chart({
					chart: {
						renderTo: divid,
						defaultSeriesType: 'line',
						marginRight: 40,
						marginBottom: 100
					},
					title: {
						text: ''
					} ,
					exporting: { 
			            enabled: false  //设置导出按钮不可用 
			        }, 
					xAxis: {
					//	tickPixelInterval:550,
						categories: categories,
							labels:{  
							  rotation: -30,
							  y:60,
							  step:1
							}	
					},
					yAxis: {
						title: {
							rotation: 0,
							text: '数<br />量'
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					tooltip: {
						formatter: function() {
				                return  this.y ;
						}
					},
					legend: { 
					            enabled: false  //设置图例不可见 
					        },
					series: [{
						name: title,
						data: data
					}]
				});
	
	}

</script>
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
<script type="text/javascript">
function changetype(sid){
document.getElementById(sid).checked=true;
}
function searchit(){
	document.search.action = "admin.php?controller=admin_reports&action=reportgraph";
	document.search.action += "&f_rangeStart="+document.search.f_rangeStart.value;
	document.search.action += "&f_rangeEnd="+document.search.f_rangeEnd.value;
	//alert(document.search.action);
	//return false;
	return true;
}
</script>
</head>

<body>
<style type="text/css">
a {
    color: #003499;
    text-decoration: none;
} 
a:hover {
    color: #000000;
    text-decoration: underline;
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="middle" class="hui_bj" >
	<div class="menu">
	<ul>
{{if $smarty.get.from eq 'configreport'}}
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=configreport">报表配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cronreports">报表自动生成配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=downloadcronreport">下载报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{else}}
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=reportgraph" id="statisticreport" target="">图形输出</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 
{{/if}}
	</ul>{{if $smarty.get.from eq 'configreport'}}<span class="back_img"><A href="admin.php?controller=admin_reports&action=configreport"><IMG src="{{$template_root}}/images/back1.png" width="80" height="30" border="0"></A></span>{{/if}}
	</div>
</td>
</tr>
<tr>
    <td class="main_content">
<form action="{{$curr_url}}" method="post" name="search" >
{{$language.Starttime}}：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="{{$f_rangeStart}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="{{$language.Edittime}}"  class="wbk">


 {{$language.Endtime}}：
<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd"  value="{{$f_rangeEnd}}" />
 <input type="button" onclick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="{{$language.Edittime}}"  class="wbk">
 &nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
</form> 
	  </td>
  </tr>
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: false
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d");
</script>
 <tr>
<td   width=100%>


	<table width=100%   cellspacing="0">
		
	<tr >
					<td style="PADDING-RIGHT:5px;PADDING-TOP:0px;">
								<table width="100%" style="height:330px;"  class="BBtable">
									<tr>
										<th   style="text-align:left"   class="list_bg">堡垒机用户排行TOP10</th>
									</tr>
									<tr>
										<td style="height:100%;" >
										 <div id="top10user" style="width: 100%;height:80%;  margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
					<td style="PADDING-LEFT:5px;PADDING-TOP:0px;">
								<table width="100%" style="height:330px;" class="BBtable">
									<tr>
										<th   style="text-align:left"   class="list_bg">协议使用</th>
									</tr>
									<tr>
										<td style="height:100%;" >
										 <div id="top10protocol" style="width: 100%; height:80%; margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
					
	</tr>
	
	<tr >
					<td  width="33%"  style="PADDING-RIGHT:5px;PADDING-TOP:5px;">
							<table width="100%"  style="height:330px;" class="BBtable">
									<tr>
										<th  style="text-align:left;"  class="list_bg"> 登录来源IP</th>
									</tr>
									<tr>
										<td  style="height:100%;" > 
										 <div id="top10srcip" style="width: 100%;height:80%;  margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
					<td  width="33%" style="PADDING-LEFT:5px;PADDING-TOP:5px;">
								<table width="100%" style="height:330px;" class="BBtable">
									<tr>
										<th  style="text-align:left"  class="list_bg">登录目标IP</th>
									</tr>
									<tr>
										<td style="height:100%;" >
										 <div id="top10dstip" style="width: 100%;height:80%;  margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
	</tr>


	
	<tr >
					<td colspan=2 align="center" style="PADDING-TOP:5px;">
								<table width="100%" style="height:330px;" class="BBtable">
									<tr>
										<th  style="text-align:left"  class="list_bg">10天堡垒机登录</th>
									</tr>
									<tr>
										<td style="height:100%;" >
										 <div id="last10user" style="width: 100%; height:80%; margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
		
	</tr>

	</table>

</td>

</tr>
</table>
 <script type="text/javascript">



function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}



</script>
</body>

</html>



