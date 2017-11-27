<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>会话列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function searchit(){
	document.search.action = "admin.php?controller=admin_vpnlog";
	document.search.action += "&fromip="+document.search.fromip.value;
	document.search.action += "&toip="+document.search.toip.value;
	document.search.action += "&user="+document.search.user.value;
	document.search.action += "&f_rangeStart="+document.search.f_rangeStart.value;
	document.search.action += "&f_rangeEnd="+document.search.f_rangeEnd.value;
	document.search.submit();
	//alert(document.search.action);
	//return false;
	return true;
}
</script>
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="{{$template_root}}/cssjs/border-radius.css" />
<script src="{{$template_root}}/cssjs/jscal2.js"></script>
<script src="{{$template_root}}/cssjs/cn.js"></script>
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
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5" > 
  <tr>
         <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
  <tr>
    <td></td>
    <td><form action="admin.php?controller=admin_vpnlog&action=online" method="post" name="search" >
来源地址：<input type="text" class="wbk" name="fromip"  size="13" />
目标地址：<input type="text" class="wbk" name="toip"  size="13" />
用户名：<input type="text" class="wbk" name="user" size="13" />
开始日期：<input type="text" class="wbk"  name="f_rangeStart" size="13" id="f_rangeStart" value="" />
 <input type="button" onClick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">
&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>
</form> </td>
  </tr>
</table>  
    </td>
  </tr>
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "f_rangeEnd", "%Y-%m-%d %H:%M:%S");


</script>
  
 <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
  
					<tr>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%"><a href="admin.php?controller=admin_vpnlog&action=online&orderby1=user&orderby2={{$orderby2}}" >用户</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="5%"><a href="admin.php?controller=admin_vpnlog&action=online&orderby1=src_ip&orderby2={{$orderby2}}" >源ip</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%"><a href="admin.php?controller=admin_vpnlog&action=online&orderby1=in_time&orderby2={{$orderby2}}" >连接时间</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%"><a href="admin.php?controller=admin_vpnlog&action=online&orderby1=out_time&orderby2={{$orderby2}}" >发送字节</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%"><a href="admin.php?controller=admin_vpnlog&action=online&orderby1=out_time&orderby2={{$orderby2}}" >接收字节</a></th>
						<th class="list_bg"  bgcolor="d9ecfa" width="10%"><a href="#" >操作</a></th>
						
					</tr>
					{{section name=t loop=$allsession}}
					<tr {{if $allsession[t].dangerous > 1}}bgcolor="red"{{elseif $allsession[t].dangerous > 0}}bgcolor="yellow" {{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><a href="admin.php?controller=admin_vpnlog&action=online&user={{$allsession[t].user}}">{{$allsession[t].0}}</a></td>
						<td><a href="admin.php?controller=admin_vpnlog&action=online&fromip={{$allsession[t].src_ip}}">{{$allsession[t].1}}</a></td>
						<td><a href="admin.php?controller=admin_vpnlog&action=online&toip={{$allsession[t].time}}">{{$allsession[t].2}}</a></td>
						<td><a href="admin.php?controller=admin_vpnlog&action=online&toip={{$allsession[t].sends}}">{{$allsession[t].3}}</a></td>
						<td><a href="admin.php?controller=admin_vpnlog&action=online&toip={{$allsession[t].receives}}">{{$allsession[t].4}}</a></td>
						<td><a href="admin.php?controller=admin_vpnlog&action=cut&username={{$allsession[t].0}}">断开</a></td>
						</tr>
						

					{{/section}}
					<tr>
						<td colspan="6" align="right">
							共{{$session_num}}条会话  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;">页 <!--当前数据表: {{$now_table_name}}--> <a href="{{$curr_url}}&derive=1" target="hide">导出当前结果为Excel</a> {{if $admin_level == 1}}<a href="{{$curr_url}}&delete=1">删除当前结果</a>{{/if}}
						<!--
						<select  class="wbk"  name="table_name">
						{{section name=t loop=$table_list}}
						<option value="{{$table_list[t]}}" {{if $table_list[t] == $now_table_name}}selected{{/if}}>{{$table_list[t]}}</option>
						{{/section}}
						</select>
						-->
						</td>
					</tr>
	  </table>
	</td>
  </tr>
</table>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>



