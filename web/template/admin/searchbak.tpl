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
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_search">综合日志</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	</ul>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
<FORM id=main_form onSubmit="return false;" method=get name=results action=admin.php>
     <INPUT id="controller " value=admin_search type=hidden name=c>
      <INPUT id=action value=search type=hidden   name=a> 	

<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>
<tr>
<td width="49%">
	<table  class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		选择数据表:		
		</td>
		<td width="67%">
		 <select name="table" id="table">
				{{section loop=$table_list name=t}}
				<option value="{{$table_list[t]}}">{{$table_list[t]}}</option>
				{{/section}}
				<option value="alllogs">alllogs</option>
				</select>  
				<br>               
				<span class="STYLE1">请选择数据表，其中logs为当前系统使用数据表，其它数据库为系统备份数据表 </span>
	  	</td>
	  	
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		主机地址:	
		</td>
		<td width="67%">
				<input type="password" name="superpassword2" value="{{$superpassword}}"/>
	  </td>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td colspan='2'>
		**频率的说明：如果修改方式选择每周，这里填写周几（1—7）,如果是按月，填写几号（1—31）,如果是自定义，这里日几日更新一次（大于0的整数）
		</td>
	</tr>
	<tr>
	<td></td>
	<td><input type=submit  value="保存修改" class="an_02"></td>
	</tr>
	</table>
</td>
<!--**************-->
<td width="2%">
</td>
<td width="49%">
<table  class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		选择数据表:		
		</td>
		<td width="67%">
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
		<td width="33%" align=right>
		再输一次口令:	
		</td>
		<td width="67%">
				<input type="password" name="superpassword2" value="{{$superpassword}}"/>
	  </td>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td colspan='2'>
		**频率的说明：如果修改方式选择每周，这里填写周几（1—7）,如果是按月，填写几号（1—31）,如果是自定义，这里日几日更新一次（大于0的整数）
		</td>
	</tr>
	<tr>
	<td></td>
	<td><input type=submit  value="保存修改" class="an_02"></td>
	</tr>
	</table>
</td>
</tr>

<!--************-->
<tr>
<td  colspan="3" >&nbsp;</td>
</tr>
<!--************-->
<tr>
<td width="100%" colspan="3" align="center">
	<table  class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		选择数据表:		
		</td>
		<td width="67%">
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
		<td width="33%" align=right>
		再输一次口令:	
		</td>
		<td width="67%">
				<input type="password" name="superpassword2" value="{{$superpassword}}"/>
	  </td>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td colspan='2'>
		**频率的说明：如果修改方式选择每周，这里填写周几（1—7）,如果是按月，填写几号（1—31）,如果是自定义，这里日几日更新一次（大于0的整数）
		</td>
	</tr>
	<tr>
	<td></td>
	<td><input type=submit  value="保存修改" class="an_02"></td>
	</tr>
	</table>
</td>
</tr>
</table>

  
      

</form>
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



