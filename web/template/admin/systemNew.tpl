<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.SessionsList}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<SCRIPT>
	function my_confirm(str){
		if(!confirm("确认要" + str + "？"))
		{
			window.event.returnValue = false;
		}
	}
	function chk_form(){
		for(var i = 0; i < document.list.elements.length;i++){
			var e = document.list.elements[i];
			if(e.name == 'chk_member[]' && e.checked == true)
				return true;
		}
		alert("您没有选任何记录！");
		return false;
	}
</SCRIPT>
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
<td width="84%" align="left" valign="top">
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F1F1F1">
<tr><td valign="middle" class="hui_bj" align="left">
<div class="menu">
<ul>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_systemNew">系统日志</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_systemNew&action=applog_config">应用日志</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div>
</td></tr>

  <tr>
    <td >
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main_content">
  <tr>
    <td>
    <FORM method=get name=f1   onSubmit="return false;"    action=admin.php>
     <INPUT id="controller " value=admin_systemNew type=hidden name=c>
      <INPUT id=action value=index type=hidden   name=a> 	
		      设备名:<INPUT name=host  size="12" class="wbk"> 
		      <INPUT  size="12" class="bnnew2"  onClick="JavaScript: document.getElementById('action').value='index';submit();" value=查找  type=button> 
	</FORM>
</td>
  </tr>
</table>	

	  </td>
  </tr>
  <tr><td>
  <table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
	 <FORM method=post name=list     action=admin.php?controller=admin_systemNew&amp;a=delete_all&amp;t=syslog>
					
				<tr>
					<TH class="list_bg" width="3%" ></TH>
                   <TH class="list_bg"  width="5%"  >设备</TH>
	               <TH class="list_bg"  width="5%"   >级别</TH>
	               <TH class="list_bg"  width="6%"   >等级</TH>
	               <TH class="list_bg"  width="15%"   >内容</TH>
					<TH class="list_bg"  width="6%"   >动作</TH>
	                <TH class="list_bg"  width="10%"   >实时</TH>
	                 <TH class="list_bg"  width="15%"   >程序</TH>
	                <TH class="list_bg"  width="6%"  >修改</TH>
					</tr>
					  {{section name=t loop=$allsystemNew}}
             	 <TR bgColor=#f7f7f7>
              	<td><input type="checkbox" name="chk_member[]" value="{{$allsystemNew[t]['sid']}}"></td>  
                  <TD >
                  	{{if $allsystemNew[t].facility == ""}}所有
					{{else }} {{$allsystemNew[t].facility}}
					{{/if}}
                  </TD>                          
				 <TD >				 
				 	{{if $allsystemNew[t].level == ""}}所有
					{{else }} {{$allsystemNew[t].level}}
					{{/if}}
				 		
				</TD>
				<TD >
				{{$allsystemNew[t].priority}}

                </TD>
				
                <TD >{{$allsystemNew[t].msg}}</TD>             
  
                   <TD >
                   	{{if $allsystemNew[t].process == "1"}}过滤
					{{elseif  $allsystemNew[t].process == "2"}}告警
		
					{{else}}保留
					{{/if}}
					
                </TD>              
                 <TD >
					{{if $allsystemNew[t].realtime == "1"}}实时打开
					{{else}}实时关闭
					{{/if}}
                </TD>
                 <TD >{{ $allsystemNew[t].program  }} </TD>

                 <TD ><input name="edit" type="button" value="编辑"  onclick="javascript:location.href='admin.php?controller=admin_systemNew&action=systemNew_edit&sid={{$allsystemNew[t]['sid']}}'"  class="bnnew2" /></TD>
                           
			 </TR>

		{{/section}}
		<TR>
          <TD colSpan=10 align=left>
          <INPUT  onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" 
            value=checkbox type=checkbox name=select_all>选本页显示的所有记录&nbsp;&nbsp;<INPUT class=an_06 onClick="my_confirm('删除所选记录');if(!chk_form())  return false;" value=批量删除所选记录 type=submit>      
         <input type="button" onclick="window.location='admin.php?controller=admin_systemNew&action=systemNew_edit'"  value=" 添加 "  class="an_02">
         <input name="export" type="button" value="导入记录"  onclick="javascript:location.href='admin.php?controller=admin_systemNew&action=import'" class="an_02" />
         <input name="export" type="button" value="导出记录"  onclick="javascript:location.href='admin.php?controller=admin_systemNew&action=export'" class="an_02" />
          
          
          </TD>
         </TR>
				</FORM>	
					<tr>
						<td height="45" colspan="10" align="right" bgcolor="#FFFFFF">
							{{$language.all}}{{$session_num}}{{$language.Session}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}条/每页 
							  转到第<input name="pagenum" type="text" size="2" onKeyPress="if(event.keyCode==13) window.location='{{$curr_url}}&page='+this.value;" class="wbk">
							  页&nbsp;  
						</td>
					</tr>
				</table>
	</td>
  </tr>
</table></td>


</body>
</html>


