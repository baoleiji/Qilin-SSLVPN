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
		var arr = {{$week_detailed}};
		getBar('week_detailed','host','服务器日志统计',arr);
		
		var arr = {{$week_count_srcip}};
		getBar('week_count_srcip','srcip','登录来源地址统计',arr);
		
		var arr = {{$week_count_server}};
		getBar('week_count_server','server','登陆服务器',arr);
		
		var arr = {{$week_count_protocol}};
		getBar('week_count_protocol','protocol','目标协议',arr);
		
		var arr = {{$week_level}};
		getPie('week_level','level','级别(天)',arr);
		
		var arr = {{$hour_level}};
		getLine('hour_level','date_end','级别(时)',arr);
	});
	
	 function	getBar(divid,cname,title,arr){
	if(arr==null)
		arr = new Array();
	var y = 55;
	var rotation = -65;
	var bottom = 100;
	if(cname=='protocol'){
		y = 20;
		bottom = 40;
		rotation = 0;
	}
	var colors = Highcharts.getOptions().colors;
	var max = 0;
	if(arr.length>0)
		 max = parseInt(arr[0].num)+0.5;
		 
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
					text: '数量'
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
	if(arr==null)
		arr = new Array();
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
	if(arr==null)
		arr = new Array();
	var categories = new Array();
	var data = new Array();
     for(var i=0; i<arr.length;i++){
     		var name = arr[i][cname];
	        categories[i] = name;
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
							text: '数量'
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
<div style="overflow: auto;width:100%;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="middle" class="hui_bj" >
	<div class="menu">
	<ul>
		<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_countlogs">统计报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
		<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_countlogin">登陆报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
		<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_countlogs&action=graph">图形报表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
		<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_log&action=logs_warning">日志告警</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
		<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_log&action=applog_warning">应用告警</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>   
	</ul>
	</div>
</td>
</tr>
<tr>
    <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
  <tr>
    <td>
    <FORM method=get name=f1   onSubmit="return false;"    action=admin.php>
     <INPUT id="controller " value=admin_countlogin type=hidden name=c>
      <INPUT id=action value=index type=hidden   name=a> 	
            <select name="type" onchange="window.location='admin.php?controller=admin_countlogs&action='+this.value">
			 <option value='graph'>天</option>
			 <option value='weekgraph' selected >周</option>
			 <option value='monthgraph' >月</option>
			 </select>
	</FORM>
</td>
  </tr>
</table>	

	  </td>
  </tr>
 <tr>
<td   width=100%>


	<table width=99%   cellspacing="10">
		
	<tr >
					<td >
								<table width="100%" style="height:330px;"  class="BBtable">
									<tr>
										<td   style="text-align:left"   class="list_bg">登录来源地址统计</td>
									</tr>
									<tr>
										<td style="height:90%;" >
										 <div id="week_count_srcip" style="width: 100%;height:80%;  margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
					<td >
								<table width="100%" style="height:330px;" class="BBtable">
									<tr>
										<td   style="text-align:left"   class="list_bg">服务器登录统计</td>
									</tr>
									<tr>
										<td style="height:90%;" >
										 <div id="week_count_server" style="width: 100%; height:80%; margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
					<td >
								<table width="100%" style="height:330px;" class="BBtable">
									<tr>
										<td   style="text-align:left"   class="list_bg">登陆协议</td>
									</tr>
									<tr>
										<td style="height:90%;" >
										 <div id="week_count_protocol" style="width: 100%; height:80%; margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
	</tr>
	
	<tr >
					<td  width="33%" >
							<table width="100%"  style="height:330px;" class="BBtable">
									<tr>
										<td  style="text-align:left;"  class="list_bg"> 服务器日志统计</td>
									</tr>
									<tr>
										<td  style="height:90%;" > 
										 <div id="week_detailed" style="width: 100%;height:80%;  margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
					<td  width="33%">
								<table width="100%" style="height:330px;" class="BBtable">
									<tr>
										<td  style="text-align:left"  class="list_bg">级别</td>
									</tr>
									<tr>
										<td style="height:90%;" >
										 <div id="week_level" style="width: 100%;height:80%;  margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
					<td   width="33%">
								
					</td>
	</tr>


	
	<tr >
					<td colspan=3 align="center">
								<table width="100%" style="height:330px;" class="BBtable">
									<tr>
										<td  style="text-align:left"  class="list_bg">IP</td>
									</tr>
									<tr>
										<td style="height:90%;" >
										 <div id="hour_level" style="width: 100%; height:80%; margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
		
	</tr>

	</table>

</td>


</tr>
</table>
</div>
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



