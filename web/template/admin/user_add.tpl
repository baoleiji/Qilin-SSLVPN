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
<td valign="middle" class="hui_bj" >
	<div class="menu">
	<ul>
		<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_user">用户配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	</ul>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
			<form action="admin.php?controller=admin_user&action=save&type=add" method="POST">
				<table  class="BBtable" width="100%">
					{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td colspan=2 align=center>
						<b>添加用户:</b>	
						</td>
					  	
					</tr>
				
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
							<td align="right" >新用户名:</td>
							<td><input type="text" size=12 maxlength=32 name="username"></td>
					</tr>
					
						{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
							<td align="right" >用户密码:</td>
							<td><input type="password" size=12 maxlength=32 name="password1"></td>
					</tr>
					
						{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td align="right" >确认密码:</td>
						<td><input type="password" size=12 maxlength=32 name="password2"></td>
					</tr>
					
						{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
							<td align="right" >E-Mail:</td>
							<td><input type="text" size=12 maxlength=255 name="email"></td>
					</tr>
				
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
							<td align="right" >权限:</td>
							<td>
								<select name="level">
									<option value="0">普通用户</option>
									<option value="1">管理员</option>
								</select>
							</td>
					</tr>
					
 
						{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td align="right" >绑定设备组:</td>
				<td>
					 {{section name=t loop=$allgroup}}
					 	<input value={{$allgroup[t].id}} type=checkbox name=group[] {{if $allgroup[t].tag==1}}checked{{/if}}/>
					 	{{$allgroup[t].groupname}}
					  {{/section }}

				</td>
	</tr>
	
				
     	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>描述：</TD>
                    <TD align="left" class=main_list_td1>
                   		<textarea style="width:200px;height:120px;"	 name="desc"  > </textarea>
                   		
                      </TD>
	</tr>
	
					<tr>
					<td colspan=2 align=center>
							<input type="submit" value="添加" class="bnnew2" >
							<input type="reset" value="复位"   class="bnnew2" >
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



