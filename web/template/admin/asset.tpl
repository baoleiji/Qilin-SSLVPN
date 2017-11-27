<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>主页面</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.19120">
<META name=author content=nuttycoder><LINK rel=stylesheet type=text/css 
href="{{$template_root}}/css/all_purpose_style.css">
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
		alert("您没有选任何用户！");
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
    <td class="daohang"><img src="{{$template_root}}/images/home_dot.gif" width="16" height="14"> &nbsp;当前位置:  首页 &gt;&gt; 用户管理 &gt;&gt; 用户列表</td>
  </tr>
  <tr>
    <td align="left">
    	<table width="100%" border="0" align="left" cellpadding="0" cellspacing="1"  class="main_menu">
		  <tr>
		    <td class="main_menu_td">用户列表</td>
		  </tr>
		  <tr>
		    <TD height="30px">
		    <FORM method=post name=f1 
		      action=admin.php?controller=admin_member>用户名:<INPUT name=username> <INPUT class=btn1 value=查找 type=submit> </FORM></TD>
		  </tr>
		</table>
    </td>
  </tr>
  
  <tr>
    <td align="left">
    	     <TABLE border=0 cellSpacing=1 borderColor=white cellPadding=5 width="100%">
         <FORM method=post name=list 
        action=admin.php?controller=admin_asset&amp;a=delete_all&amp;t=system_template>
        <TBODY></TBODY>
     </TABLE>
      <TABLE border=0 cellSpacing=1 borderColor=white cellPadding=5 width="100%">
        <TBODY>
        <TR>
          <TH width="3%" class="list_bg">选</TH>
          <TH width="5%" class="list_bg">ID</TH>
          <TH width="10%" class="list_bg">主机名</TH>
          <TH width="10%" class="list_bg">主机ip</TH>
          <TH width="10%" class="list_bg">操作系统</TH>
          <TH width="6%" class="list_bg">设备组</TH>
          <TH width="10%" class="list_bg">上架日期</TH>
		  <TH width="10%" class="list_bg">使用年限</TH>
		   <TH width="10%" class="list_bg">保修期</TH>
		    <TH width="10%" class="list_bg">序列号</TH>
		 </TR>
		  {{section name=t loop=$all}}
        <TR class="list_tr_bg{{if $smarty.section.t.index % 2 ne 0}}1{{/if}}">
         <TD><INPUT value={{$all[t].Hid}} type=checkbox name=chk_member[]></TD>
          <TD>{{$smarty.section.t.index+1}}</TD>
          <TD>{{$all[t].hostname}}</TD>
          <TD>{{$all[t].hname}}</TD>
          <TD>{{$all[t].system}}</TD>
          <TD>{{$all[t].group}}</TD>
		  <TD>{{$all[t].asset_start}}</TD>
          <TD>{{$all[t].asset_usetime}}</TD>
           <TD>{{$all[t].asset_warrantdate}}</TD>
          <TD>{{$all[t].asset_sn}}</TD>
		</TR>
			{{/section}}
      
        <TR>
          <TD colSpan=8 align=left><INPUT   onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" 
            value=checkbox type=checkbox name=select_all>
            选本页显示的所有用户&nbsp;&nbsp;<INPUT class=an_02 onClick="my_confirm('删除所选用户');if(chk_form()) document.member_list.action='admin.php?controller=admin_member&amp;action=delete_all'; else return false;" value=批量删除所选用户 type=submit> 
        </TD>
        </TR>
       <TR>
          <TD colSpan=8 align=left>{{$page_list}}  页：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}/页  到
							  <input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;" class="wbk">
							  页&nbsp; 
		 </TD>
		 </TR>
		 </TBODY>
		 </TABLE>
    </td>
  </tr>
</table>


</BODY></HTML>
