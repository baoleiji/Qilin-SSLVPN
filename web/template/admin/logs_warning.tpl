<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<SCRIPT>
	function my_confirm(str){
		if(!confirm("确认要" + str + "？"))
		{
			window.event.returnValue = false;
		}
	}
	function chk_form(){
		for(var i = 0; i < document.list.elements.length;i++){
			var e = document.list.elements[i];
			if(e.name == 'chk_member[]' && e.checked == true)
				return true;
		}
		alert("您没有选任何记录！");
		return false;
	}
</SCRIPT>
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
<td width="84%" align="left" valign="top">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F1F1F1">
<tr><td valign="middle" class="hui_bj" align="left">
<div class="menu">
<ul>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_countlogs">统计报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_countlogin">登陆报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_countlogs&action=graph">图形报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_log&action=logs_warning">日志告警</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_log&action=applog_warning">应用告警</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
</ul>
</div>
</td></tr>

  <tr><td>
  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	 <FORM method=post name=list     action=admin.php?controller=admin_host&amp;a=delete_all&amp;t=host>					
			<tr>		
                <TH width="10%" class=list_bg>主机</TH>    
                <TH width="15%" class=list_bg>时间</TH>
                 <TH  width="10%"  class=list_bg>级别</TH>
                  <TH  width="55%"  class=list_bg>日志内容</TH>
                  <TH width="7%" class="list_bg">操作</TH>
			</tr>
				 {{section name=r loop=$result_array}}
  			 <TR class="list_tr_bg{{if $smarty.section.t.index % 2 ne 0}}1{{/if}}">

                <TD class=main_list_td1>{{$result_array[r].host}}</TD>

				 <TD class=main_list_td1>{{$result_array[r].datetime}}</TD>
				 <TD class=main_list_td1>{{$result_array[r].priority}}</TD>
				  <TD class=main_list_td1>{{$result_array[r].msg}}</TD>
				  <TD>
				  	<input name="detail" type="button" value="详细"  onclick="javascript:window.open('admin.php?controller=admin_log&action=logs_warning_detail&seq={{$result_array[r].seq}}','newwin')" class="bnnew2"  />
				  </TD>
			</tr>
					{{/section}}

				</FORM>	
					<tr>
					<td>
				  	 <input name="export" type="button" value="导出记录"  onclick="javascript:location.href='admin.php?controller=admin_log&action=logs_warning&derive=1'" class="an_02" />      </td>
						<td height="45" colspan="5" align="right" bgcolor="#FFFFFF">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}条/每页 
							  转到第<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;" class="wbk">
							  页&nbsp;  
						</td>
					</tr>
				</table>
	</td>
  </tr>
</table></td>


</body>
</html>


