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
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="#">详细信息</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	</ul>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
<FORM id=main_form onSubmit="return false;" method=get name=results action=admin.php>
     <INPUT id="controller " value=admin_search type=hidden name=c>
      <INPUT id=action value=search type=hidden   name=a> 	

	<table width=100%  class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		 <TD align="right" class=main_list_td1  >探针：</TD>
         <TD align="left" class=main_list_td1>
     						 {{$detail.logserver}}
         </TD>
	  	
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>主机：</TD>
                    <TD align="left" class=main_list_td1>
						{{$detail.host}}
					</TD>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                   <TD align="right" class=main_list_td1>来源：</TD>
                    <TD align="left" class=main_list_td1>
						{{$detail.srchost}}
					</TD>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>用户：</TD>
                    <TD align="left" class=main_list_td1>
                   		{{$detail.user}}
                      </TD>
	</tr>
	
		{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                <TD align="right" class=main_list_td1>协议：</TD>
                <TD align="left" class=main_list_td1>
                    	{{$detail.protocol}}
				</TD>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                      <TD align="right" class=main_list_td1>登录时间：</TD>
                    <TD align="left" class=main_list_td1>
    						{{$detail.starttime}}
                      </TD>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                     <TD align="right" class=main_list_td1>退出时间：</TD>
                    <TD align="left" class=main_list_td1>
						{{$detail.endtime}}
                      </TD>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                       <TD align="right" class=main_list_td1>成功：</TD>
                    <TD align="left" class=main_list_td1>
                   		{{if $detail.active == "1"}}成功
						{{elseif  $detail.active == "0"}}失败		
						{{else}}退出
						{{/if}}
                      </TD>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                     <TD align="right" class=main_list_td1>日志内容：</TD>
                    <TD align="left" class=main_list_td1>
                   		{{$detail.msg}}
                      </TD>
	</tr>

	<tr>
	<td colspan='2' align="center"><input type=submit  value="关闭" onclick="window.close();"  class="bnnew2" ></td>
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



