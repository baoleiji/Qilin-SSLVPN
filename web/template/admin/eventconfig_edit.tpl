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
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eventlogs&action=eventconfig">报警规则</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_alert">告警配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>  

	</ul>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
  <FORM method=post name=edit action=admin.php?controller=admin_eventlogs&action=save&t=eventconfig&id={{$id}}>
  <input type='hidden' name='id' value="{{$id}}">
	<table width=100%  class="BBtable">

		{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>日志规则：</TD>
                    <TD align="left" class=main_list_td1>
                    <INPUT style="width:300px;" type=text name=eventmsg  value="{{$result.eventmsg}}"> 
                    </TD>
	</tr>

	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>事件名称：</TD>
                    <TD align="left" class=main_list_td1>
                   		<input style="width:300px;" type="text" name="event"   value="{{$result.event}}"/>
                      </TD>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>类型：</TD>
                    <TD align="left" class=main_list_td1>
                    	<select name="logsource" style="width:300px;">
							<option value="程序" {{if $result.logsource == "程序"}}selected{{/if}}>程序</option>
							<option value="网络" {{if $result.logsource == "网络"}}selected{{/if}}>网络</option>
							<option value="硬件" {{if $result.logsource == "硬件"}}selected{{/if}}>硬件</option>
							<option value="软件" {{if $result.logsource == "软件"}}selected{{/if}}>软件</option>
							<option value="系统" {{if $result.logsource == "系统"}}selected{{/if}}>系统</option>
							<option value="其它" {{if $result.logsource == "其它"}}selected{{/if}}>其它</option>
						</select>
                    </TD>
	</tr>
	
	 {{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>级别：</TD>
                    <TD align="left" class=main_list_td1>
						<select name="msg_level" style="width:300px;">
							<option value="5" {{if $result.msg_level == "5"}}selected{{/if}}>紧急</option>
							<option value="4" {{if $result.msg_level == "4"}}selected{{/if}}>非常严重</option>
							<option value="3" {{if $result.msg_level == "3"}}selected{{/if}}>严重</option>
							<option value="2" {{if $result.msg_level == "2"}}selected{{/if}}>警告</option>
							<option value="1" {{if $result.msg_level == "1"}}selected{{/if}}>信息</option>
						</select>
                      </TD>
     </tr>
     
     	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>描述：</TD>
                    <TD align="left" class=main_list_td1>
                   		<textarea style="width:300px;height:120px;"	 name="desc"  >{{$result.desc}}</textarea>
                   		
                      </TD>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
         <TD  align="center" colSpan=2 >
         <INPUT  class="bnnew2"  value=保存修改  type=submit name=submit>
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



