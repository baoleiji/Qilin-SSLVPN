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
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_searchlogs">搜索条件</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>

</ul>
</div>
</td></tr>
 
  <tr><td>
  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	 <FORM method=post name=list     action=admin.php?controller=admin_realtime&amp;a=delete_all&amp;t=realtimelogs>
					
				<tr>
 
			          <TH  width="3%"   class="list_bg">ID</TH>
			         
			          <TH  width="10%"   class="list_bg">主机</TH>
			          <TH  width="8%"   class="list_bg">程序</TH>
			          <TH  width="8%"   class="list_bg">级别</TH>
			          <TH  width="10%"   class="list_bg">时间</TH>
					  <TH  width="40%"   class="list_bg">日志内容</TH>
						 <TH  width="8%"   class="list_bg">探针</TH>
					</tr>
					 {{section name=t loop=$all}}
  			 <TR class="list_tr_bg{{if $smarty.section.t.index % 2 ne 0}}1{{/if}}">
 			          <TD>{{$smarty.section.t.index+1}}</TD>
			         
			          <TD>{{$all[t].host}}</TD>
			          <TD>{{$all[t].program}}</TD>
			          <TD>{{$all[t].level}}</TD>
					  <TD>{{$all[t].datetime}}</TD>
			          <TD>{{$all[t].msg}}</TD>
			           <TD>{{$all[t].logserver}}</TD>
					</tr>
					{{/section}}
 
				</FORM>	
					<tr>
						<td height="45" colspan="8" align="right" bgcolor="#FFFFFF">
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


