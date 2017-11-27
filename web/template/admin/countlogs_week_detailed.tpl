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
			
   function searchit(orderby1,orderby2){

	document.search.action = "admin.php?controller=admin_countlogs&orderby1="+orderby1+"&orderby2="+orderby2;
	document.search.orderby1.value=orderby1;
	document.search.orderby2.value=orderby2;
	document.search.submit();

	return true;
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
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_countlogs">统计报表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_countlogin">登陆报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_countlogs&action=graph">图形报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_log&action=logs_warning">日志告警</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_log&action=applog_warning">应用告警</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>  

</ul>
</div>
</td></tr>

  <tr>
    <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
  <tr>
    <td>
        <FORM method=get name=f1   onSubmit="return false;"    action=admin.php>
         <INPUT id="controller " value=admin_countlogs type=hidden name=controller>
      <INPUT id=action value=index type=hidden   name=action> 
      
		<input type="radio" name="listType" value="month"   {{if $listType == "month"}}checked{{/if}} >每月&nbsp;
             <input type="radio" name="listType" value="week" {{if $listType == "week"}}checked{{/if}} >按周&nbsp;
             <input type="radio" name="listType"  value="day" {{if $listType == "day"||$listType == ""}}checked{{/if}} >按天&nbsp;
             <input class="wbk" type="text" name="f_rangeStart" id="f_rangeStart" {{if $f_rangeStart neq ""}}value={{$f_rangeStart}}{{/if}} />
 			<input class="wbk" type="button" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间">
             
             <select class="wbk" name="contentType">
              		<option value="detailed"  {{if $contentType == "detailed"}}selected{{/if}}>明细</option>	
              		<option value="level"  {{if $contentType == "level"}}selected{{/if}}>级别</option>	
              		<option value="server"  {{if $contentType == "server"}}selected{{/if}}>服务器</option>		
				</select>
				
				<input type="hidden" name="orderby1" id="orderby1"  value="" />
		        <input type="hidden" name="orderby2" id="orderby2"  value="" />
		  
               <INPUT  size="12" class="an_02"  onClick="JavaScript: document.getElementById('action').value='index';submit();" value=确定  type=button> 
	</FORM>
</td>
  </tr>
</table>	

	  </td>
  </tr>
  <tr><td>
  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	 <FORM method=post name=list     action=admin.php?controller=admin_countlogs&amp;a=delete_all&amp;t=countlogs_week_detailed>
				<tr>
			 	       <TH  class="list_bg">选</TH>
			          <TH  class="list_bg">ID</TH>
			          <TH  class="list_bg"><a href="#"  onClick="searchit('host','{{$orderby2}}');">主机名</a></TH>
			          <TH  class="list_bg"><a href="#"  onClick="searchit('date_start','{{$orderby2}}');">开始时间</a></TH>
			           <TH  class="list_bg"><a href="#"  onClick="searchit('date_end','{{$orderby2}}');">结束时间</a></TH>
			          <TH  class="list_bg"><a href="#"  onClick="searchit('DEBUG','{{$orderby2}}');">DEBUG</a></TH>
			          <TH  class="list_bg"><a href="#"  onClick="searchit('INFO','{{$orderby2}}');">INFO</a></TH>
			          <TH  class="list_bg"><a href="#"  onClick="searchit('NOTICE','{{$orderby2}}');">NOTICE</a></TH>
					  <TH  class="list_bg"><a href="#"  onClick="searchit('WARNING','{{$orderby2}}');">WARNING</a></TH>
					   <TH  class="list_bg"><a href="#"  onClick="searchit('ERR','{{$orderby2}}');">ERR</a></TH>
					    <TH  class="list_bg"><a href="#"  onClick="searchit('CRIT','{{$orderby2}}');">CRIT</a></TH>
					    
					    <TH  class="list_bg"><a href="#"  onClick="searchit('ALERT','{{$orderby2}}');">ALERT</a></TH>
					    <TH  class="list_bg"><a href="#"  onClick="searchit('EMERG','{{$orderby2}}');">EMERG</a></TH>
					    <TH  class="list_bg"><a href="#"  onClick="searchit('actionlog','{{$orderby2}}');">actionlog</a></TH>
					    <TH  class="list_bg"><a href="#"  onClick="searchit('alllog','{{$orderby2}}');">alllog</a></TH>
 					</tr>
					 {{section name=t loop=$all}}
  					 <TR class="list_tr_bg{{if $smarty.section.t.index % 2 ne 0}}1{{/if}}">
			    	       <TD><INPUT value={{$all[t].seq}} type=checkbox name=chk_member[]></TD>
				          <TD>{{$smarty.section.t.index+1}}</TD>
				          <TD>{{$all[t].host}}</TD>
				          <TD>{{$all[t].date_start}}</TD>
				           <TD>{{$all[t].date_end}}</TD>
				          <TD>{{$all[t].DEBUG}}</TD>
				            <TD>{{$all[t].INFO}}</TD>
				          <TD>{{$all[t].NOTICE}}</TD>
						  <TD>{{$all[t].WARNING}}</TD>
				          <TD>{{$all[t].ERR}}</TD>
				           <TD>{{$all[t].ALERT}}</TD>
				          <TD>{{$all[t].CRIT}}</TD>
		          
				         
				            <TD>{{$all[t].EMERG}}</TD>
				             <TD>{{$all[t].actionlog}}</TD>
				              <TD>{{$all[t].alllog}}</TD>
 					</tr>
					{{/section}}
		<TR>
          <TD colSpan=15 align=left>
          <INPUT  onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" 
            value=checkbox type=checkbox name=select_all>选本页显示的所有记录&nbsp;&nbsp;<INPUT class=an_06 onClick="my_confirm('删除所选记录');if(!chk_form())  return false;" value=批量删除所选记录 type=submit>      
             <input name="export" type="button" value="导出记录"  onclick=export1(); class="an_02" />       
            <input name="export" type="button" value="导出html"  onclick=export2();  class="an_02" />   
            </TD>
         </TR>
				</FORM>	
					<tr>
						<td height="45" colspan="15" align="right" bgcolor="#FFFFFF">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}条/每页 
							  转到第<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;" class="wbk">
							  页&nbsp;  
						</td>
					</tr>
				</table>
	</td>
  </tr>
</table></td>

<script type="text/javascript">
                  new Calendar({
                          inputField: "f_rangeStart",
                          dateFormat: "%Y-%m-%d",
                          trigger: "f_rangeStart_trigger",
                          bottomBar: false,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                 
                                  this.hide();
                          }
                  });
function export1(){
var f_rangeStart = document.getElementById("f_rangeStart").value;
location.href='admin.php?controller=admin_countlogs&action=export&table=log_countlogs_week_detailed&f_rangeStart='+f_rangeStart;

}

function export2(){
var f_rangeStart = document.getElementById("f_rangeStart").value;
location.href='admin.php?controller=admin_countlogs&action=derivetoHTML&table=log_countlogs_week_detailed&f_rangeStart='+f_rangeStart;
}
</script>
</body>
</html>


