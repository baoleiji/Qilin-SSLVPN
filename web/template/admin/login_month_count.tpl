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
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_countlogin">登陆报表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 
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
     <INPUT id="controller " value=admin_countlogin type=hidden name=controller>
      <INPUT id=action value=index type=hidden   name=action> 	
	   <select name="type" onchange="window.location='admin.php?controller=admin_countlogin&action='+this.value">
			 <option value=''>天</option>
			 <option value='week' >周</option>
			 <option value='month' selected>月</option>
			 </select>
             <input class="wbk" type="text" name="f_rangeStart" id="f_rangeStart" {{if $f_rangeStart neq ""}}value={{$f_rangeStart}}{{/if}} />
 			<input class="wbk" type="button" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间">

		      <INPUT  size="12" class="bnnew2"  onClick="JavaScript: document.getElementById('action').value='month';submit();" value=查找  type=button> 
	</FORM>
</td>
  </tr>
</table>	

	  </td>
  </tr>
  <tr><td>
  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	 <FORM method=post name=list     action=admin.php?controller=admin_countlogin&amp;a=delete_all&amp;t=login_month_count>
					
				<tr>
			 	       <TH width="3%" class="list_bg">选</TH>
			          <TH width="3%" class="list_bg">ID</TH>
			          <TH width="15%" class="list_bg">起始日期</TH>
			           <TH width="15%" class="list_bg">结束日期</TH>
			          <TH width="8%" class="list_bg">主机</TH>
			          <TH width="8%" class="list_bg">用户</TH>
			          <TH width="8%" class="list_bg">来源地址</TH>
			          <TH width="8%" class="list_bg">协议</TH>
					  <TH width="8%" class="list_bg">状态</TH>
					   <TH width="5%" class="list_bg">数量</TH>

					</tr>
					 {{section name=t loop=$all}}
  					 <TR class="list_tr_bg{{if $smarty.section.t.index % 2 ne 0}}1{{/if}}">
	    			 <TD><INPUT value={{$all[t].seq}} type=checkbox name=chk_member[]></TD>
			          <TD>{{$smarty.section.t.index+1}}</TD>
			          <TD>{{$all[t].date_start}}</TD>
			           <TD>{{$all[t].date_end}}</TD>
			          <TD>{{$all[t].server}}</TD>
			          <TD>{{$all[t].user}}</TD>
			          <TD>{{$all[t].srcip}}</TD>
					  <TD>{{$all[t].protocol}}</TD>
			          <TD>{{$all[t].status}}</TD>
			           <TD>{{$all[t].count}}</TD>
			
					</tr>
					{{/section}}
		<TR>
          <TD colSpan=10 align=left>
          <INPUT  onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" 
            value=checkbox type=checkbox name=select_all>选本页显示的所有记录&nbsp;&nbsp;<INPUT class=an_06 onClick="my_confirm('删除所选记录');if(!chk_form())  return false;" value=批量删除所选记录 type=submit>      
          <input name="export" type="button" value="导出记录"  onclick="javascript:location.href='admin.php?controller=admin_countlogin&action=export&table=login_month_count'" class="an_02" /> 
          <input name="export" type="button" value="导出html"  onclick="javascript:location.href='admin.php?controller=admin_countlogin&action=derivetoHTML&table=login_month_count'" class="an_02" />   
           
            </TD>
         </TR>
				</FORM>	
					<tr>
						<td height="45" colspan="10" align="right" bgcolor="#FFFFFF">
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

</script>
</body>
</html>


