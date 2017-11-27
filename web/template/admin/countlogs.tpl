<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>主页面</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.19120">
<META name=author content=nuttycoder><LINK rel=stylesheet type=text/css 
href="{{$template_root}}/css/all_purpose_style.css">
<LINK rel=stylesheet href="{{$template_root}}/css/jscal2.css">
<script src="{{$template_root}}/js/jscal2.js"></script>
<script src="{{$template_root}}/js/cn.js"></script>
<SCRIPT>
	function my_confirm(str){
		if(!confirm("确认要" + str + "？"))
		{
			window.event.returnValue = false;
		}
	}
	function chk_form(){
		for(var i = 0; i < document.member_list.elements.length;i++){
			var e = document.member_list.elements[i];
			if(e.name == 'chk_member[]' && e.checked == true)
				return true;
		}
		alert("您没有选任何记录！");
		return false;
	}
	

</SCRIPT>
</HEAD>
<BODY>
<table width="98%" border="0" align="left" cellpadding="1" cellspacing="0">
<tr>
    <td align="left">{{include file="tabs.tpl"}}</td>
  </tr>
  <tr>
    <td class="daohang"><img src="{{$template_root}}/images/home_dot.gif" width="16" height="14"> &nbsp;当前位置:  首页 &gt;&gt; 记录管理 &gt;&gt; 记录列表</td>
  </tr>
  <tr>
    <td align="left">
    	<table width="100%" border="0" align="left" cellpadding="0" cellspacing="1"  class="main_menu">
		  <tr>
		    <td class="main_menu_td">记录列表</td>
		  </tr>
		  <tr>
		    <TD height="30px">
		    <FORM method=post name=f1  action=admin.php?controller=admin_countlogs >
		   	<input type="radio" name="listType" value="month">每月&nbsp;
             <input type="radio" name="listType" value="week">按周&nbsp;
             <input type="radio" name="listType" checked value="day">按天&nbsp;
             <input type="text" name="f_rangeStart" id="f_rangeStart" />
 			<input type="button" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间">
             
             <select name="contentType">
              		<option value="detailed" >明细</option>	
              		<option value="level" >级别</option>	
              		<option value="server" >服务器</option>		
				</select>
             <INPUT class=an_02 value=确定 type=submit>
		      
		      
		    </FORM></TD>
		  </tr>
		</table>
    </td>
  </tr>
  
  <tr>
    <td align="left">
    	     <TABLE border=0 cellSpacing=1 borderColor=white cellPadding=5 width="100%">
        <FORM method=post name=member_list 
        action=admin.php?controller=admin_member&amp;action=delete_all>
        <TBODY></TBODY>
     </TABLE>
      <TABLE border=0 cellSpacing=1 borderColor=white cellPadding=5 width="100%">
        <TBODY>
        <TR>
          <TH width="3%" class="list_bg">选</TH>
          <TH width="3%" class="list_bg">ID</TH>
          <TH width="8%" class="list_bg">主机名</TH>
          <TH width="8%" class="list_bg">时间</TH>
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
		    <TH width="5%" class="list_bg">seq</TH>
		 </TR>
		  {{section name=t loop=$all}}
        <TR class="list_tr_bg{{if $smarty.section.t.index % 2 ne 0}}1{{/if}}">
         <TD><INPUT value={{$all[t].seq}} type=checkbox name=chk_member[]></TD>
          <TD>{{$smarty.section.t.index+1}}</TD>
          <TD>{{$all[t].host}}</TD>
          <TD>{{$all[t].date}}</TD>
          <TD>{{$all[t].DEBUG}}</TD>
          <TD>{{$all[t].NOTICE}}</TD>
		  <TD>{{$all[t].WARNING}}</TD>
          <TD>{{$all[t].ERR}}</TD>
           <TD>{{$all[t].ALERT}}</TD>
          <TD>{{$all[t].CRIT}}</TD>
          
           <TD>{{$all[t].ALERT}}</TD>
            <TD>{{$all[t].EMERG}}</TD>
             <TD>{{$all[t].actionlog}}</TD>
              <TD>{{$all[t].alllog}}</TD>
               <TD>{{$all[t].seq}}</TD>
		</TR>
			{{/section}}
      
        <TR>
          <TD colSpan=15 align=left><INPUT   onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" 
            value=checkbox type=checkbox name=select_all>
            选本页显示的所有记录&nbsp;&nbsp;<INPUT class=an_06 onClick="my_confirm('删除所选记录');if(chk_form()) document.member_list.action='admin.php?controller=admin_member&amp;action=delete_all'; else return false;" value=批量删除所选记录 type=submit> 
        </TD>
        </TR>
       <TR>
          <TD colSpan=15 align=left>{{$page_list}}  页：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}/页  到
							  <input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;" class="wbk">
							  页&nbsp; 
		 </TD>
		 </TR>
		 </TBODY>
		 </TABLE>
    </td>
  </tr>
</table>
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

</BODY></HTML>
