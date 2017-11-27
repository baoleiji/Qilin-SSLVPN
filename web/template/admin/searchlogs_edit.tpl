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
<script language="JavaScript">
window.onload=function(){
obj=new Date();
d=obj.getFullYear()+'-';
d+=(obj.getMonth()+1)<10?'0'+(obj.getMonth()+1):obj.getMonth()+1;
d+='-'+obj.getDate()+' '+obj.getHours()+':'+obj.getMinutes()+':'+obj.getSeconds();
form.dt.value=d;
}
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
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_searchlogs">搜索条件</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	</ul>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
<FORM id=main_form onSubmit="return false;" method=get name=results action=admin.php>
     <INPUT id="controller " value=admin_searchlogs type=hidden name=c>
      <INPUT id=action value=save type=hidden   name=a> 	

<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>

<!--************-->
<tr>
<td width="100%" colspan="3" align="center">
	<table  class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td   align=right>
		查询名称:		
		</td>
		<td   colspan="3">
		      <INPUT   type=text name=queryname> 
	  	</td>
	  	
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
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
                <TD width="40%" align=left class=main_list_td1>&nbsp;&nbsp; 
			                包括<INPUT   value=0 type=radio name=excludeHost> 
			                除去 <INPUT value=1 CHECKED type=radio name=excludeHost>
			       &nbsp;<br>主机名包括 <INPUT  class="wbk" size=18 type=text name=host2>&nbsp;<br>
              
          	 	 <select name="host[]" style="WIDTH: 200px" multiple size=5>
					{{section name=t loop=$allhost}}
					<option>{{$allhost[t].hname}}</option>
					{{/section}}
					</select>
				&nbsp;<br>
				&nbsp;<br>
				</TD>
                <TD width="10%" align=right class=main_list_td1>日志设备:</TD>
                <TD width="40%" align=left class=main_list_td1>&nbsp;&nbsp; 包括
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
                 	 <input maxlength=10 size=10 type=text name=date2>时间
					<input maxlength=10 size=10 type=text name=time2>
					<br>
					&nbsp;&nbsp;日期
					<input maxlength=10 size=10 type=text name=date>时间
					<input maxlength=10  size=10 type=text name=time>
					<input id=page_id type=hidden name=pageId>
					<br>
				<span class="STYLE1">日期格式为：YYYY-MM-DD 时间格式为：HH:MM:SS. 直接输入 Yesterday, today 和 now 也是可以使用的有效格式. </span><br>
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
                      <OPTION selected>seq</OPTION>
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
        <INPUT class=bnnew2 onClick="JavaScript: document.getElementById('action').value='save';submit();" value=确定 type=button> 
		<INPUT class=bnnew2 onClick="JavaScript: history.back(-1);" value=返回  type=button> 
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



function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}



</script>
</body>

</html>



