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
 
		var arr = {{$last10flow}};
		getLine('last10flow','date','flow',arr);
		
		var arr = {{$last10usage}};
		getLine('last10usage','date','usage',arr);
		
		var arr = {{$last10conn}};
		getLine('last10conn','date','conn',arr);
	});
	
 

function getLine(divid,cname,title,arr){
	if(arr==null)
		arr = new Array();
	var categories = new Array();

     for(var i=0; i<arr.length;i++){
     		var name = arr[i][cname]; 
     		categories[i] = name;
	  }
	  
	  var series = getSeries(title,arr);
	
	chart = new Highcharts.Chart({
					chart: {
						renderTo: divid,
						defaultSeriesType: 'line',
						marginRight: 100,
						marginBottom: 80
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
							text: ''
						},
						plotLines: [{
							value: 0,
							width: 1,
							color: '#808080'
						}]
					},
					tooltip: {
						formatter: function() {
				                return '<b>'+ this.series.name +'</b> '+ ': '+ this.y  ;

						}
					},
					legend: { 
					         //   enabled: false  //设置图例不可见 
					         	layout: 'vertical',
				                align: 'right',
				                verticalAlign: 'top',
				                x: -20,
				                y: 10,
				                borderWidth: 0
					         
					        },
					series: series
				});	
	}
	
	function getSeries(title,arr){
		var result = new Array();
		if(title=='conn'){
			var ssh = getDataByName('ssh',arr);
			var telnet = getDataByName('telnet',arr);
			var graph = getDataByName('graph',arr);
			var ftp = getDataByName('ftp',arr);
			var db = getDataByName('db',arr);
			result.push(ssh);
			result.push(telnet);
			result.push(graph);
			result.push(ftp);
			result.push(db);
 	
		}else if(title=='usage'){
			var cpu = getDataByName('cpu',arr);
			var memory = getDataByName('memory',arr);
			var swap = getDataByName('swap',arr);
			var disk = getDataByName('disk',arr);
			result.push(cpu);
			result.push(memory);
			result.push(swap);
			result.push(disk);
		
		}else if(title=='flow'){
			var net_eth0_in = getDataByName('net_eth0_in',arr);
			var net_eth0_out = getDataByName('net_eth0_out',arr);
			var net_eth1_in = getDataByName('net_eth1_in',arr);
			var net_eth1_out = getDataByName('net_eth1_out',arr);
			result.push(net_eth0_in);
			result.push(net_eth0_out);
			result.push(net_eth1_in);
			result.push(net_eth1_out);
		}
		
		return result;
	}
	
	function getDataByName(name,arr){
		var tmpArr = new Array();
		for(var i=0;i<arr.length;i++){		
				tmpArr[i] = parseInt(arr[i][name])
		}
		var obj = new Object();
		obj.name = name;
		obj.data = tmpArr;
		return obj;
	}

</script>
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
 
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
	<ul>{{*
{{if $smarty.session.ADMIN_LEVEL e 1 or $smarty.session.ADMIN_LEVEL eq 2}}	
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=day_count">天报</a><img src="{{$template_root}}/images/aqn33.jpg" align="absmiddle"/></li>
{{/if}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=week_count">周报</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=month_count">月报</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}*}}
{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 2}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=reportgraph">图形</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
{{/if}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_log">同步日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=system_alert">系统告警</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=maillog">系统邮件</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=aduserlog">账号同步</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=aduserlog">账号同步</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
	</div>
</td>
 
 
 <tr>
<td   width=100%>


	<table width=100%   cellspacing="0">
	
	<tr  style="PADDING-TOP:0px;">
					<td colspan=3 align="center" >
								<table width="100%" style="height:300px;" class="BBtable">
									<tr>
										<td  style="text-align:left"  class="list_bg">近10天并发连接</td>
									</tr>
									<tr>
										<td style="height:90%;" >
										 <div id="last10conn" style="width: 100%; height:80%; margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
		
	</tr>
	
	<tr >
					<td colspan=3 align="center"  style="PADDING-TOP:5px;">
								<table width="100%" style="height:300px;" class="BBtable">
									<tr>
										<td  style="text-align:left"  class="list_bg">近10天系统利用率</td>
									</tr>
									<tr>
										<td style="height:90%;" >
										 <div id="last10usage" style="width: 100%; height:80%; margin: 1 auto"></div>
										</td>
									</tr>
								</table>
					</td>
		
	</tr>
	
	<tr >
					<td colspan=3 align="center"  style="PADDING-TOP:5px;">
								<table width="100%" style="height:300px;" class="BBtable">
									<tr>
										<td  style="text-align:left"  class="list_bg">近10天流量</td>
									</tr>
									<tr>
										<td style="height:90%;" >
										 <div id="last10flow" style="width: 100%; height:80%; margin: 1 auto"></div>
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



