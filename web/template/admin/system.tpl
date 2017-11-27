<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<script language="JavaScript">
window.onload=function(){
obj=new Date();
d=obj.getFullYear()+'-';
d+=(obj.getMonth()+1)<10?'0'+(obj.getMonth()+1):obj.getMonth()+1;
d+='-'+obj.getDate()+' '+obj.getHours()+':'+obj.getMinutes()+':'+obj.getSeconds();
form.dt.value=d;
}

function handle_delete() {
	//Because of bugs of IE, I need to define these variables explicitly.

	var delete_form;
	var page_id;
	var confirm_result;
	var table;

	table = document.getElementById("table");
	delete_form = document.getElementById("delete_form");
	page_id = document.getElementById("page_id");
	confirm_result = confirm("您确认要删除数据表" + table.value + "吗？");
	if (confirm_result) {
		page_id.value = "delete";
		delete_form.submit();
	}
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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_slaveserver">探针管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_system">备份管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 
	</ul>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>

	<table width=100%  class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<form name="backup" action="admin.php?controller=admin_system&action=backup" METHOD=post>
  		 <td class="lighter" >
			      	<a class="myfont1">数据库备份，点击备份按钮对现有数据库进行备份:<a><br>
			        <a class="myfont1">备份将会清除目前数据表内容 </a>
					<input value="备份" class="myinput" type="submit">
		 </td>
		</form>
	</tr>
{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<form name="backup" action="admin.php?controller=admin_system&action=applog" METHOD=post>
  		 <td class="lighter" >
			      	<a class="myfont1">数据表applog备份，点击备份按钮对现有数据表applog进行备份:<a><br>
			        <a class="myfont1">备份将会清除目前applog数据表内容 </a>
					<input value="备份" class="myinput" type="submit">
		 </td>
		</form>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<form name="backup" action="admin.php?controller=admin_system&action=refresh_host" METHOD=post>
  	  		  <td class="lighter" width="85%">
				      <a class="myfont1">点击确认按钮更新新主机列表:<a><br>
				      <a class="myfont1">从选择的日志数据表中更新主机列表,可能需要数分钟:</a>
						<select name="logstable" id="logstable">
							<option value="log_logs">logs</option>
							{{section name=t loop=$r_alltable}}
							<option value="log_{{$r_alltable[t]}}">log_{{$r_alltable[t]}}</option>
							{{/section}}
						</select>
						<input value="更新" class="myinput" type="submit">
			     </td>
		</form>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<form id="truncate_form" method="post" action="admin.php?controller=admin_system&action=truncate_alllogs">
  		      <td class="lighter" width="85%">
						
							 <a class="myfont1">清空alllogs数据表:<a>
			            	<input value="清空" class="myinput" type="submit">
			</td>
			
				<input type="hidden" name="pageId" value="" id="page_id">
		</form>
	</tr>
{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<form id="truncate_form" method="post" action="admin.php?controller=admin_system&action=truncate_applogs">
  		      <td class="lighter" width="85%">
						
							 <a class="myfont1">清空applog数据表:<a>
			            	<input value="清空" class="myinput" type="submit">
			</td>
			
				<input type="hidden" name="pageId" value="" id="page_id">
		</form>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<form id="delete_form" method="post" action="admin.php?controller=admin_system&action=delete_table" onsubmit="return false;">
  					<td class="lighter" width="85%">

							 <a class="myfont1">删除数据表:<a>
							<select name="table" id="table">
							{{section name=t loop=$alltable}}
							<option value="{{$alltable[t]}}">{{$alltable[t]}}</option>
							{{/section}}
							</select>
			            	<input value="删除" class="myinput" type="button" onclick="JavaScript: handle_delete();">
					</td>
			
				<input type="hidden" name="pageId" value="" id="page_id">
		</form>
	</tr>

{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<form id="delete_form" method="post" action="admin.php?controller=admin_system&action=delete_table" onsubmit="return false;">
  					<td class="lighter" width="85%">

							 <a class="myfont1">删除applog数据表:<a>
							<select name="table" id="table">
							{{section name=t loop=$r_allapplogtable}}
							<option value="{{$r_allapplogtable[t]}}">{{$r_allapplogtable[t]}}</option>
							{{/section}}
							</select>
			            	<input value="删除" class="myinput" type="button" onclick="JavaScript: handle_delete();">
					</td>
			
				<input type="hidden" name="pageId" value="" id="page_id">
		</form>
	</tr>

{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<form id="delete_form" method="post" action="admin.php?controller=admin_system&action=audit_server2log_hosts">
  					<td class="lighter" width="85%">

							 <a class="myfont1">从堡垒机系统里更新主机列表:<a>
							<input value="更新" class="myinput" type="submit">
					</td>
			
		</form>
	</tr>

	</table>
</form>
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



