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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_search">综合日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eventlogs&action=applogs">应用日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_login">登录日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_authpriv">权限日志</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul>
</div>
</td></tr>

  <tr>
    <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
  <tr>
    <td>
    <FORM method=get name=f1   onSubmit="return false;"    action=admin.php>
         <INPUT id="controller " value=admin_authpriv type=hidden name=controller>
      <INPUT id=action value=index type=hidden   name=action> 	
	  <select name="type" onchange="window.location='admin.php?controller=admin_authpriv&action='+this.value">
			 <option value=''>Windows</option>
			 <option value='linux'>Linux</option>
			 </select>
			 主机:<INPUT name=host  size="12" class="wbk">&nbsp;&nbsp;
		     操作:<INPUT name=event  size="12" class="wbk">&nbsp;&nbsp;
			 用户名:<INPUT name=user  size="12" class="wbk">&nbsp;&nbsp;
			 组名:<INPUT name=usergroup  size="12" class="wbk">&nbsp;&nbsp;
			 开始时间：<input type="text"  name="f_rangeStart" size="13" id="f_rangeStart"  class="wbk" /> 
				<input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">
		  截止时间：<input type="text"  name="f_rangeEnd" size="13" id="f_rangeEnd"  class="wbk" /> 
				<input type="button"  id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk">
		      <INPUT  size="12" class="bnnew2"  onClick="JavaScript: document.getElementById('action').value='index';submit();" value=查找  type=button> 
			  <script type="text/javascript">

                  new Calendar({
                          inputField: "f_rangeStart",
                          dateFormat: "%Y-%m-%d %H:%M",
                          trigger: "f_rangeStart_trigger",
                          bottomBar: false,
                          showTime: true,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                 
                                  this.hide();
                          }
                  });
				   new Calendar({
                          inputField: "f_rangeEnd",
                          dateFormat: "%Y-%m-%d %H:%M",
                          trigger: "f_rangeEnd_trigger",
                          bottomBar: false,
                          showTime: true,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                 
                                  this.hide();
                          }
                  });
				  </script>
	</FORM>
</td>
  </tr>
</table>	

	  </td>
  </tr>
  <tr><td>
  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	 <FORM method=post name=list     action=admin.php?controller=admin_authpriv&amp;a=delete_all&amp;t=windows_authpriv>
					
				<tr>
		        <TH width="2%" class="list_bg">选</TH>
		          <TH width="2%" class="list_bg">ID</TH>
 		          
		          <TH width="4%" class="list_bg">主机</TH>
		          <TH width="5%" class="list_bg">时间</TH>
				  <TH width="7%" class="list_bg">操作</TH>
		          <TH width="4%" class="list_bg">用户名</TH>
				
				  <TH width="5%" class="list_bg">组名</TH>
				   <TH width="37%" class="list_bg">日志信息</TH>		 
 					</tr>
					 {{section name=t loop=$all}}
   <TR class="list_tr_bg{{if $smarty.section.t.index % 2 ne 0}}1{{/if}}">
 					<TD><INPUT value={{$all[t].id}} type=checkbox name=chk_member[]></TD>
		          <TD>{{$smarty.section.t.index+1}}</TD>
 		        
		          <TD>{{$all[t].ip}}</TD>
		          <TD>{{$all[t].datetime}}</TD>
				  <TD>{{$all[t].event}}</TD>
				  <TD>{{$all[t].username}}</TD>
		        <TD>{{$all[t].groupname}}</TD>
 				  <TD>{{$all[t].loginfo}}</TD>
 				  <!--  
				  <TD>
				  	<input name="detail" type="button" value="详细"  onclick="javascript:window.open('admin.php?controller=admin_authpriv&action=detail&t=windows_authpriv&id={{$all[t].id}}','newwin')" class="bnnew2"  />
				  </TD>
				  -->
					</tr>
					{{/section}}
		<TR>
          <TD colSpan=8 align=left>
          <INPUT  onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" 
            value=checkbox type=checkbox name=select_all>选本页显示的所有记录&nbsp;&nbsp;<INPUT class=an_06 onClick="my_confirm('删除所选记录');if(!chk_form())  return false;" value=批量删除所选记录 type=submit>      
            </TD>
         </TR>
				</FORM>	
					<tr>
						<td height="45" colspan="8" align="right" bgcolor="#FFFFFF">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}条/每页 
							  转到第<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;" class="wbk">
							  页&nbsp;   <a href="{{$curr_url}}&derive=1" target="hide">{{$language.ExportresulttoExcel}}</a>
						</td>
					</tr>
				</table>
	</td>
  </tr>
</table></td>

<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>


