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
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />

<script language="JavaScript">
 
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
<td valign="middle" class="hui_bj" colspan="2">
	<div class="menu">
	<ul>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_search">综合日志</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eventlogs&action=applogs">应用日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_login">登录日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_authpriv">权限日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	</ul>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
<FORM id=main_form onSubmit="return false;" method=get name=results action=admin.php>
     <INPUT id="controller " value=admin_search type=hidden name=controller>
      <INPUT id=action value=search type=hidden   name=action> 	

<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>

<!--************-->
<tr>
<td width="100%"   align="center">
	<table  width=100% class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td   align=right>
		选择数据表:		
		</td>
		<td   colspan="3">
		 <select name="table" id="table">
				{{section loop=$table_list name=t}}
				<option value="{{$table_list[t]}}">{{$table_list[t]}}</option>
				{{/section}}
				<option value="alllogs">alllogs</option>
				</select>                 
				<span class="STYLE1">请选择数据表，其中logs为当前系统使用数据表，其它数据库为系统备份数据表 </span>
	  	</td>
	  	
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		         <TD  align=right>主机地址:</TD>
                <TD  align=left class=main_list_td1>&nbsp;&nbsp; 
			                包括<INPUT   value=0 type=radio name=excludeHost CHECKED> 
			    {{if $level == 1  }}
			                  除去 <INPUT value=1  type=radio name=excludeHost>
			   {{/if }}
			       &nbsp;<br>主机名包括 <INPUT  class="wbk" size=18 type=text name=host2>&nbsp;<br>
              
          	 	 <select name="host[]" style="WIDTH: 200px" multiple size=5>
					{{section name=t loop=$allhost}}
					<option>{{$allhost[t].device_ip}}</option>
					{{/section}}
					</select>
				&nbsp;<br>
				&nbsp;<br>
				</TD>
                <TD   align=right class=main_list_td1>日志设备:</TD>
                <TD   align=left class=main_list_td1>&nbsp;&nbsp; 包括
                    <INPUT  value=0 type=radio name=excludeFacility>去除
                  <INPUT value=1 CHECKED type=radio  name=excludeFacility>
                    <br>&nbsp;
				  <SELECT multiple size=5 style="WIDTH: 200px" name=facility[]>
				    <OPTION>auth</OPTION>
				    <OPTION>authpriv</OPTION>
				    <OPTION>cron</OPTION>
				    <OPTION>daemon</OPTION>
				    <OPTION>kern</OPTION>
				    <OPTION>local0</OPTION>
				    <OPTION>local3</OPTION>
				    <OPTION>local5</OPTION>
				    <OPTION>local6</OPTION>
				    <OPTION>local7</OPTION>
				    <OPTION>mail</OPTION>
				    <OPTION>syslog</OPTION>
				    <OPTION>user</OPTION>
				    <OPTION>uucp</OPTION>
				  </SELECT>                
  				</TD>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                <TD class=main_list_td1 align=right>日志级别:</TD>
                <TD class=main_list_td1 align=left>&nbsp;&nbsp; 包括<INPUT 
                  value=0 type=radio name=excludePriority>去除<INPUT value=1 
                  CHECKED type=radio 
                  name=excludePriority>
                  <br>
                  &nbsp;
                  <SELECT multiple size=5 style="WIDTH: 200px"
                  name=priority[]> 
                    <OPTION>debug<OPTION>info<OPTION>notice<OPTION>warning<OPTION>err<OPTION>crit<OPTION>alert<OPTION>emerg</OPTION></SELECT>
                  <br>
                 </TD>
                <TD align=right valign="top" class=main_list_td1>起始:<br>结束:</TD>
                <TD align=left valign="top" class=main_list_td1>&nbsp; 日期
                		<input type="text"  name="datetime" size="15" id="datetime"   class="wbk" /> 
				<input type="button"  id="datetime_trigger" name="datetime_trigger" value="选择时间" class="wbk">
					<br>
					&nbsp;&nbsp;日期
	<input type="text"  name="datetime2" size="15" id="datetime2"   class="wbk" /> 
				<input type="button"  id="datetime2_trigger" name="datetime2_trigger" value="选择时间" class="wbk">					<input id=page_id type=hidden name=pageId>
					<br>
 				</TD>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                         <TD class=main_list_td1 align=right>每页记录数:</TD>
                <TD class=main_list_td1 align=left>&nbsp;&nbsp; <SELECT 
                  name=limit> <OPTION selected>25</OPTION> <OPTION>50</OPTION> 
                    <OPTION>100</OPTION> <OPTION>200</OPTION> 
                    <OPTION>500</OPTION> <OPTION>1000</OPTION></SELECT> </TD>
                <TD align=right class=main_list_td1>排序字段:</TD>
                <TD align=left class=main_list_td1>&nbsp;&nbsp;
                    <SELECT name=orderby>
                      <OPTION selected>id</OPTION>
                      <OPTION>host</OPTION>
                      <OPTION>facility</OPTION>
                      <OPTION>priority</OPTION>
                      <OPTION>datetime</OPTION>
                    </SELECT>                
                  </TD>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                      <TD class=main_list_td1 align=right>升降序:</TD>
                <TD class=main_list_td1 align=left>&nbsp;&nbsp; <SELECT 
                  name=order> <OPTION>ASC</OPTION> <OPTION 
                    selected>DESC</OPTION></SELECT> </TD>
                <TD class=main_list_td1 align=left>&nbsp;</TD>
                <TD class=main_list_td1 align=left>&nbsp;</TD>
	</tr>


	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
          <TD class=main_list_td1 colSpan=4>进行日志信息内容搜索:<BR>
          去除 <INPUT  type=checkbox name=ExcludeMsg1>
         <INPUT size=75 type=text   name=msg1> 和<BR>
           去除 <INPUT type=checkbox name=ExcludeMsg2> 
         <INPUT size=75 type=text name=msg2> 和<BR>
           </TD>
	</tr>
	
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                <TD class=main_list_td1 colSpan=4>将同样的信息合并为一条输出: <INPUT 
                  value=1 CHECKED type=checkbox name=collapse>
                  </TD>
	</tr>


	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
	  <td colspan='4'  align="center">
		<INPUT id=hidden_search  type=hidden name=type> 
        <INPUT class=bnnew2 onClick="JavaScript: document.getElementById('action').value='search';submit();" value=搜索 type=button> 
		<INPUT class=bnnew2 onClick="JavaScript: document.getElementById('action').value='search';document.getElementById('hidden_search').value='today'; submit();" value=今天 type=button> 
		<INPUT class=bnnew2 onClick="JavaScript: document.getElementById('action').value='export'; submit();" value=导出 type=button> 
		<INPUT class=bnnew2 value=复位 type=reset>
	  </td>
	</tr>
	</table>
</td>
</tr>
</table>

  
      

</FORM>
</td>


</tr>
</table>

 <script type="text/javascript">


                  new Calendar({
                          inputField: "datetime",
                          dateFormat: "%Y-%m-%d %H:%M:%S",
                          trigger: "datetime_trigger",
                          bottomBar: false,
                          showTime: true,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());                             
                                  this.hide();
                          }
                  });
                  
                      new Calendar({
                          inputField: "datetime2",
                          dateFormat: "%Y-%m-%d %H:%M:%S",
                          trigger: "datetime2_trigger",
                          bottomBar: false,
                          showTime: true,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());                             
                                  this.hide();
                          }
                  });

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}


</script>
</body>

</html>



