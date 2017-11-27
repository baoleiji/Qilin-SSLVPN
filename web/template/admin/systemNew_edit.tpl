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
		<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_systemNew">规则列表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	</ul><span class="back_img"><A href="admin.php?controller=admin_systemNew&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="25" border="0"></A></span>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
    	<FORM method=post name=edit 
            action=admin.php?controller=admin_systemNew&action=save&sid={{$sid}}>
  <input type='hidden' name='sid' value="{{$sid}}">
	<table width=100%  class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
  					<TD align="right" class=main_list_td1>设备：</TD>
                    <TD align="left" class=main_list_td1>
                  
                   		<select name="facility" style="width:250px;"	>
                   		<option  value=''  >所有</option>		
                   		 	{{section name=t loop=$facilitys}}                		 	                 		 	
								<option value="{{$facilitys[t].name}}"  {{if $facilitys[t].name == $systemNew.facility}}selected{{/if}}>{{$facilitys[t].name}}</option>		
							{{/section}}
						</select>
                      </TD>
	  	
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                  <TD align="right" class=main_list_td1>级别：</TD>
                    <TD align="left" class=main_list_td1>
						<select name="level" style="width:250px;">
							<option value='' >所有</option>	
							<option value="DEBUG" {{if $systemNew.level == "DEBUG"}}selected{{/if}}>DEBUG</option>
							<option value="INFO" {{if $systemNew.level == "INFO"}}selected{{/if}}>INFO</option>
							<option value="NOTICE" {{if $systemNew.level == "NOTICE"}}selected{{/if}}>NOTICE</option>
							<option value="WARNING" {{if $systemNew.level == "WARNING"}}selected{{/if}}>WARNING</option>
							<option value="ERROR" {{if $systemNew.level == "ERROR"}}selected{{/if}}>ERROR</option>
							<option value="CRITICAL" {{if $systemNew.level == "CRITICAL"}}selected{{/if}}>CRITICAL</option>
							<option value="ALTERT" {{if $systemNew.level == "ALTERT"}}selected{{/if}}>ALTERT</option>
							<option value="EMERG" {{if $systemNew.level == "EMERG"}}selected{{/if}}>EMERG</option>
						</select>
					</TD>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                   <TD align="right" class=main_list_td1>等级：</TD>
                    <TD align="left" class=main_list_td1>
						<select name="priority" style="width:250px;">
							<option value="严重" {{if $systemNew.priority == "严重"}}selected{{/if}}>严重</option>
							<option value="重要" {{if $systemNew.priority == "重要"}}selected{{/if}}>重要</option>
							<option value="警告" {{if $systemNew.priority == "警告"}}selected{{/if}}>警告</option>
							<option value="一般" {{if $systemNew.priority == "一般"}}selected{{/if}}>一般</option>
							<option value="信息" {{if $systemNew.priority == "信息"}}selected{{/if}}>信息</option>
						</select>
					</TD>
	</tr>

	
		{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>内容：</TD>
                    <TD align="left" class=main_list_td1>
                    <INPUT  style="width:250px;" size=12 type=text name=msg  value="{{$systemNew.msg}}"> 
                    </TD>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>说明：</TD>
                    <TD align="left" class=main_list_td1>
                    <INPUT  style="width:250px;" size=12 type=text name=instruction  value="{{$systemNew.instruction}}"> 
                    </TD>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>动作：</TD>
                    <TD align="left" class=main_list_td1>
                   		 <select name="process" style="width:250px;">
                   		 	<option value="0" {{if $allsystemNew[t].process == "0"}}selected{{/if}}>保留</option>
							<option value="1" {{if $systemNew.process == "1"}}selected{{/if}}>过滤</option>
							<option value="2" {{if $systemNew.process == "2"}}selected{{/if}}>告警</option>						
						</select>
                      </TD>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                   <TD align="right" class=main_list_td1>实时：</TD>
                    <TD align="left" class=main_list_td1>
                   		  <select name="realtime" style="width:250px;">
							<option value="1" {{if $systemNew.realtime == "1"}}selected{{/if}}>实时打开</option>
							<option value="0" {{if $systemNew.realtime == "0"}}selected{{/if}}>实时关闭</option>							
						</select>
                      </TD>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>主机ip：</TD>
                    <TD align="left" class=main_list_td1>
                   		<input style="width:250px;" type="text" name="host"   value="{{$systemNew.host}}"/>
                      </TD>
	</tr>
	
	
	 {{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>程序：</TD>
                    <TD align="left" class=main_list_td1>
						<input  style="width:250px;" type="text" name="program"   value="{{$systemNew.program}}"/>
                      </TD>
     </tr>

		
     	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>描述：</TD>
                    <TD align="left" class=main_list_td1>
                   		<textarea style="width:250px;height:120px;"	 name="desc"  >{{$systemNew.desc}}</textarea>
                   		
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



