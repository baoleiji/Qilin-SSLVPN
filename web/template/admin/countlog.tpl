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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_realtime">实时日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_realtime&action=countlogs">实时统计</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_realtime&action=countlogs_minuter">5分钟统计</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_realtime&action=countlogs_hour">1小时统计</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 

</ul>
</div>
</td></tr>

  <tr>
    <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
  <tr>
    <td>
    <FORM method=post name=f1     action=admin.php?controller=admin_realtime&amp;a=countlogs>
		      主机:<INPUT name=host  size="12" class="wbk"> <INPUT  size="12" class="an_02" value=查找 type=submit> 
	</FORM>
</td>
  </tr>
</table>	

	  </td>
  </tr>
  <tr><td>
  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	 <FORM method=post name=list     action=admin.php?controller=admin_realtime&amp;a=delete_all&amp;t=countlogs>
					
				<tr>
					<TH width="3%" class="list_bg">选</TH>
			          <TH width="5%" class="list_bg">ID</TH>
			          <TH width="10%" class="list_bg">主机</TH>
			          <TH width="10%" class="list_bg">Debug </TH>
			          <TH width="6%" class="list_bg">Info </TH>
			          <TH width="6%" class="list_bg">notice </TH>
					  <TH width="6%" class="list_bg">warning </TH>
					  <TH width="6%" class="list_bg">err</TH>
					  <TH width="6%" class="list_bg">critical</TH>
					  <TH width="6%" class="list_bg">altert</TH>
					  <TH width="6%" class="list_bg">emerg</TH>
					  <TH width="24%" class="list_bg">总计</TH>
					</tr>
					 {{section name=t loop=$alllogs}}
  			 <TR class="list_tr_bg{{if $smarty.section.t.index % 2 ne 0}}1{{/if}}">
	    			 <TD><INPUT value={{$alllogs[t].seq}} type=checkbox name=chk_member[]></TD>
			          <TD>{{$smarty.section.t.index+1}}</TD>
			          <TD>{{$alllogs[t].host}}</TD>
			          <TD>{{$alllogs[t].DEBUG}}</TD>
			          <TD>{{$alllogs[t].INFO}}</TD>
					  <TD>{{$alllogs[t].NOTICE}}</TD>
			          <TD>{{$alllogs[t].WARNING}}</TD>
					  <TD>{{$alllogs[t].ERR}}</TD>
					  <TD>{{$alllogs[t].CRIT}}</TD>
					  <TD>{{$alllogs[t].ALERT}}</TD>
					  <TD>{{$alllogs[t].EMERG}}</TD>
					  <TD>{{$alllogs[t].alllog}}</TD>
					</tr>
					{{/section}}
		<TR>
          <TD colSpan=12 align=left>
          <INPUT  onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" 
            value=checkbox type=checkbox name=select_all>选本页显示的所有记录&nbsp;&nbsp;<INPUT class=an_06 onClick="my_confirm('删除所选记录');if(!chk_form())  return false;" value=批量删除所选记录 type=submit>      
            </TD>
         </TR>
				</FORM>	
					<tr>
						<td height="45" colspan="12" align="right" bgcolor="#FFFFFF">
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


