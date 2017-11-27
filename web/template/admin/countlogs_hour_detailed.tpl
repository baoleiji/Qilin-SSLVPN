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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_realtime&action=countlogs_minuter">5分钟统计</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_realtime&action=countlogs_hour">1小时统计</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 

</ul>
</div>
</td></tr>
  <tr>
    <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
  <tr>
    <td>
    <FORM method=post name=search     action="admin.php?controller=admin_realtime&action=countlogs_hour">	

             <select class="wbk" name="contentType">
              		<option value="detailed"  {{if $contentType == "detailed"}}selected{{/if}}>明细</option>	
              		<option value="level"  {{if $contentType == "level"}}selected{{/if}}>级别</option>	
              		<option value="server"  {{if $contentType == "server"}}selected{{/if}}>服务器</option>		
				</select>
				时间：<input type="text"  name="f_rangeStart" size="13" id="f_rangeStart"  {{if $f_rangeStart}}value="{{$curr_time}}"{{/if}} class="wbk" /> 
				<input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">

             <INPUT class="an_02" value=确定 type=submit>
	</FORM>
</td>
  </tr>
</table>


	  </td>
  </tr>

  <tr><td>
  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	 <FORM method=post name=list     action="admin.php?controller=admin_realtime&amp;action=delete_all&amp;t=countlogs_hour_detailed">
				<tr>
			 	       <TH width="3%" class="list_bg">选</TH>
			          <TH width="3%" class="list_bg">ID</TH>
			          <TH width="8%" class="list_bg">主机名</TH>
			          <TH width="15%" class="list_bg">时间</TH>
			          <TH width="8%" class="list_bg">DEBUG</TH>
			          <TH width="5%" class="list_bg">INFO</TH>
			          <TH width="5%" class="list_bg">NOTICE</TH>
					  <TH width="5%" class="list_bg">WARNING</TH>
					   <TH width="5%" class="list_bg">ERR</TH>
					    <TH width="5%" class="list_bg">CRIT</TH>
					    
					    <TH width="5%" class="list_bg">ALERT</TH>
					    <TH width="5%" class="list_bg">EMERG</TH>
					    <TH width="5%" class="list_bg">actionlog</TH>
					    <TH width="5%" class="list_bg">alllog</TH>
 					</tr>
					 {{section name=t loop=$all}}
  					 <TR class="list_tr_bg{{if $smarty.section.t.index % 2 ne 0}}1{{/if}}">
	    			 <TD><INPUT value={{$all[t].seq}} type=checkbox name=chk_member[]></TD>
			          <TD>{{$smarty.section.t.index+1}}</TD>
			          <TD>{{$all[t].host}}</TD>
			          <TD>{{$all[t].date}}</TD>
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
          <TD colSpan=14 align=left>
          <INPUT  onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" 
            value=checkbox type=checkbox name=select_all>选本页显示的所有记录&nbsp;&nbsp;<INPUT class=an_06 onClick="my_confirm('删除所选记录');if(!chk_form())  return false;" value=批量删除所选记录 type=submit>      
            </TD>
         </TR>
         
		</FORM>	
		<TR>
          <TD colSpan=14 align=left>
		    <FORM method=post name=f1     action=admin.php?controller=admin_realtime>	
				   <input type=hidden value={{ $f_rangeStart}}  name="f_rangeStart">
				    <input type=hidden value={{ $contentType}}  name="contentType">			
				    <INPUT name=curr_time type=hidden  value="{{$curr_time}}">				
		             <INPUT class="an_02" value=前1小时  type=button  onclick="this.form.action='{{$curr_url}}&curr_num='+{{$curr_num+1}};this.form.submit();">
		             <INPUT class="an_02" value=后1小时  type=button  onclick="this.form.action='{{$curr_url}}&curr_num='+{{$curr_num-1}};this.form.submit();" {{ if $curr_num==1}} disabled {{/if}}>
			</FORM>  
            
		 </TD>
         </TR>
		

				</table>
	</td>
  </tr>
</table></td>

<script type="text/javascript">
              new Calendar({
                          inputField: "f_rangeStart",
                          dateFormat: "%Y-%m-%d %H:00",
                          trigger: "f_rangeStart_trigger",
                          bottomBar: false,
                          showTime: true,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                 
                                  this.hide();
                          }
                  });

</script>
</body>
</html>


