<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<SCRIPT language=javascript src="{{$template_root}}/cssjs/calendar.js"></SCRIPT>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<script type="text/javascript">
function searchit(){
	document.f1.submit();	
	//alert(document.search.action);
	//return false;
	return true;
}
function searchit(){
	document.report.action = "admin.php?controller=admin_pro&action=logs_index";
	document.report.action += "&ip="+document.report.ip.value;
	document.report.action += "&start_time="+document.report.f_rangeStart.value;
	document.report.action += "&end_time="+document.report.f_rangeEnd.value;
	document.report.action += "&success="+document.report.success.value;
	document.report.submit();
	return false;
}
</script>
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 	 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=logs_index">改密明细</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=logs_statistic">改密统计</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
   <TR>
                    <TD colspan = "7" class="main_content">
					<form name ='report' action='admin.php?controller=admin_pro&action=logs_index' method=post>
					设备IP<input type="text" class="wbk" name="ip">
					开始日期：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value=""/>
					 <input type="button" onClick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">

					 结束日期：
					<input  type="text" class="wbk" name="f_rangeEnd" size="13" id="f_rangeEnd" value=""/>
					 <input type="button" onClick="changetype('timetype3')" id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk">
					成功：<select  class="wbk"  name="success" ><option value="">请选择</option><option value="Yes">是</option><option value="No">否</option></select>
					&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
					</form>
					  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d %H:%M:%S");


</script>
					</TD>
                  </TR>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
                <TBODY>
			<form name="member_list" action="admin.php?controller=admin_pro&action=logs_del" method="post">

                  <TR>
					<th class="list_bg" ></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=logs_index&orderby1=device_ip&orderby2={{$orderby2}}" >服务器地址</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=logs_index&orderby1=username&orderby2={{$orderby2}}" >用户名</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=logs_index&orderby1=update_success_flag&orderby2={{$orderby2}}" >上次修改结果</a></TD>
                    <th class="list_bg" ><a href="admin.php?controller=admin_pro&action=logs_index&orderby1=time&orderby2={{$orderby2}}" >时间</a></TD>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			{{section name=t loop=$alllog}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td>{{if $allmember[t].level != 10 &&  $allmember[t].level != 2 &&  $allmember[t].level != 1}}<input type="checkbox" name="chk_member[]" value="{{$alllog[t].id}}">{{/if}}</td>
				<td> {{$alllog[t].device_ip}}</td>
				<td>{{$alllog[t].username}}</td>
				<td>{{$alllog[t].update_success_flag}}</td>
				<td>{{$alllog[t].time}}</td>
				<td><img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('您确定要删除？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=logs_del&id={{$alllog[t].id}}';}">删除</a></td> 
			</tr>
			{{/section}}

                <tr>
				<td colspan="2" align="left">
							<input name="select_all" type="checkbox" onClick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">&nbsp;&nbsp;<input type="submit"  value="批量删除" onClick="my_confirm('批量删除');if(chk_form()) document.member_list.action='admin.php?controller=admin_pro&action=logs_del'; else return false;" class="an_02">
						</td>
	           <td  colspan="4" align="right">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) {window.location='admin.php?controller=admin_pro&action=logs_index&page='+this.value;return false;}">页   导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>
		   </td>
		</tr>
		</form>
		</TBODY>
              </TABLE>	</td>
  </tr>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



