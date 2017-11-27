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
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_login">Windows登录</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_login&action=linux">Linux登录</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_login&action=search">搜索</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 

	</ul>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
<FORM  method=post name=list     action=admin.php?controller=admin_login&amp;a=search_result>

<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>

<!--************-->
<tr>
<td width="100%" colspan="3" align="center">
	<table  width="100%"  class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td   align=right>
		选择数据表:	&nbsp;	&nbsp;		
		</td>
		<td >
		 <SELECT name=table style="width:200px;">
                       <OPTION >windows_login</OPTION>
                      <OPTION>linux_login</OPTION>
 		</SELECT>    
	  	</td>
	  	
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		    	<td   align=right>
		探针:&nbsp;	&nbsp;	
		</td>
		<td >
		<input  type=text name=logserver style="width:200px;">
	  	</td>
	</tr>


	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		    	<td   align=right>
		主机ip:&nbsp;	&nbsp;	
		</td>
		<td >
		<input  type=text name=host style="width:200px;">
	  	</td>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		    	<td   align=right>
		来源ip:&nbsp;	&nbsp;	
		</td>
		<td >
		<input  type=text name=srchost style="width:200px;">
	  	</td>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		 <td   align=right>
		用户名:&nbsp;	&nbsp;	
		</td>
		<td >
		<input  type=text name=user style="width:200px;">
	  	</td>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		    	<td   align=right>
		登陆时间:&nbsp;	&nbsp;	
		</td>
		<td >
		<input  type=text name=starttime1 id=starttime1 style="width:200px;">
 		<input class="wbk" type="button" id="starttime1_trigger" name="starttime1_trigger" value="选择时间">
 		
	  	</td>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		    	<td   align=right>
		退出时间:&nbsp;	&nbsp;	
		</td>
		<td >
		<input  type=text name=endtime  id=endtime style="width:200px;">
 		<input class="wbk" type="button" id="endtime_trigger" name="endtime_trigger" value="选择时间">
           
	  	</td>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td   align=right>
		是否成功:	&nbsp;	&nbsp;		
		</td>
		<td >
		 <SELECT name=active style="width:200px;">
		 		<option value =''></option>
		 		<option value ="a">失败</option>
              	<option value ="b">成功</option>		  
			 	<option value="c">退出</option>
 		</SELECT>    
	  	</td>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
	  <td colspan='2'  align="center">
        <INPUT class=bnnew2   value=搜索  type=submit> 
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

      new Calendar({
              inputField: "endtime",
              dateFormat: "%Y-%m-%d %H:%M",
              showTime: true,
              trigger: "endtime_trigger",
              bottomBar: false,
              onSelect: function() {
                      var date = Calendar.intToDate(this.selection.get());
                     
                      this.hide();
              }
      });
      
       new Calendar({
              inputField: "starttime1",
			 	dateFormat: "%Y-%m-%d %H:%M",
              trigger: "starttime1_trigger",
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



