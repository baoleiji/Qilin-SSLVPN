<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<script src="./template/admin/js/jquery-1.7.2.min.js"></script>
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
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_authpriv">Windows权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_authpriv&action=linux">Linux权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_authpriv&action=search">搜索</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 

	</ul>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
<FORM  method=post name=list     action=admin.php?controller=admin_authpriv&amp;a=search_result>

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
		 <SELECT name=table id=table  style="width:200px;">
                      
                      <OPTION  value ='linux_authpriv' >linux_authpriv</OPTION>
                       <OPTION  value ='windows_authpriv' >windows_authpriv</OPTION>
 		</SELECT>    
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
		操作事件:	&nbsp;	&nbsp;		
		</td>
		<td >
		 <SELECT name=event  id=event style="width:200px;">
		 		<option value =''></option>
		 		<option value ="用户添加">用户添加</option>
              	<option value ="用户组添加">用户组添加</option>		  
			 	<option value="用户删除">用户删除</option>
			 	
			 	<option value="用户组删除">用户组删除</option>
			 	<option value="用户修改密码">用户修改密码</option>
			 	<option value="用户锁定">用户锁定</option>
			 	<option value="用户解锁">用户解锁</option>
			 	<option value="修改用户权限">修改用户权限</option>
			 	<option value="添加用户到组">添加用户到组</option>
			 	<option value="从组中删除用户">从组中删除用户</option>
 
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

	$("#table").change(function(){
		var t = $("#table").val();
		if(t=='windows_authpriv'){
			$("#event").append("<option value='其它usermod操作'>其它usermod操作</option>");  
			 
		}else if(t=='linux_authpriv'){
		 
			$("#event option:last").remove();  
		} 
	
	 });
 
		 
</script>
</body>

</html>



