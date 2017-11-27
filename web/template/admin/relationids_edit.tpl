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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_relation">规则列表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_relation&action=relationids">报警设备</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 
	</ul>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
    	<FORM method=post name=edit 
            action=admin.php?controller=admin_relation&action=save&t=relationids>

      <input type='hidden' name='seq' value="{{$result.seq}}">
      
	<table width=100%  class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>报警设备：</TD>
                    <TD align="left" class=main_list_td1>
                   	 <select name="idsip" STYLE="width: 133px">
                   		
                   		 	{{section name=t loop=$host}}                		 	                 		 	
								<option value="{{$host[t].hname}}"  {{if $host[t].hname == $result.idsip}}selected{{/if}}>{{$host[t].hname}}</option>		
							{{/section}}
						</select>
					</TD>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>System：</TD>
                    <TD align="left" class=main_list_td1>
 						<select name="system" STYLE="width: 133px">
                   		
                   		 	{{section name=t loop=$system}}                		 	                 		 	
								<option value="{{$system[t].system}}"  {{if $system[t].system == $result.system}}selected{{/if}}>{{$system[t].system}}</option>		
							{{/section}}
						</select>                     
					 </TD>
	</tr>


		
     	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>描述：</TD>
                    <TD align="left" class=main_list_td1>
                   		<textarea style="width:200px;height:120px;"	 name="desc"  >{{$result.desc}}</textarea>
                   		
                      </TD>
	</tr>


	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
         <TD  align="center" colSpan=2 >
         <INPUT class=an_02 value=保存修改  type=submit name=submit>
         </TD>

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



