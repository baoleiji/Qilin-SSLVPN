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
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_host">资产列表</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_host&action=company">支持厂商</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_host&action=system">操作系统</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li> 
	</ul>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
    	<FORM method=post name=edit 
            action=admin.php?controller=admin_host&action=save&t=host>

      <input type='hidden' name='hid' value="{{$result.hid}}">
      
	<table width=100%  class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>IP地址：</TD>
                    <TD align="left" class=main_list_td1>
                   			<input   size=20 type="text" name="hname"   value="{{$result.hname}}"/>
                      </TD>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>主机名：</TD>
                    <TD align="left" class=main_list_td1>
                   			<input   size=20 type="text" name="hostname"   value="{{$result.hostname}}"/>
                      </TD>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>操作系统：</TD>
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
                    <TD align="right" class=main_list_td1>设备组：</TD>
                    <TD align="left" class=main_list_td1>
                   		<select name="group" STYLE="width: 133px">
                   			<option value=""  > </option>		
                   		 	{{section name=t loop=$group}}                		 	                 		 	
								<option value="{{$group[t].id}}"  {{if $group[t].id == $result.group}}selected{{/if}}>{{$group[t].groupname}}</option>		
							{{/section}}
						</select>
                      </TD>
	</tr>
	
		{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>支持厂商：</TD>
                    <TD align="left" class=main_list_td1>
                   		<select name="support_company" STYLE="width: 133px">                 		
                   		 	{{section name=t loop=$company}}                		 	                 		 	
								<option value="{{$company[t].company}}"  {{if $company[t].company == $result.company}}selected{{/if}}>{{$company[t].company}}</option>		
							{{/section}}
						</select>
                      </TD>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                 <TD align="right" class=main_list_td1>上架时间：</TD>
                    <TD align="left" class=main_list_td1>
                        <input  size=20 type="text" name="asset_start" id="asset_start"  {{if $result.asset_start}}value={{$result.asset_start}}{{/if}} />
 						<input type="button" id="asset_start_trigger" name="asset_start_trigger" value="选择时间">
                      
                      </TD>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>使用年限：</TD>
                    <TD align="left" class=main_list_td1>
                    <INPUT  size=20 type=text name=asset_usedtime  value="{{$result.asset_usedtime}}">
                     </TD>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>保修期：</TD>
                    <TD align="left" class=main_list_td1>
                   		
                      <input  size=20 type="text" name="asset_warrantdate" id="asset_warrantdate"  {{if $result.asset_warrantdate}}value={{$result.asset_warrantdate}}{{/if}}/>
 						<input type="button" id="asset_warrantdate_trigger" name="asset_warrantdate_trigger" value="选择时间">
                     
                      </TD>
	</tr>
		
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>序列号：</TD>
                    <TD align="left" class=main_list_td1>
                   		<input   size=20 type="text" name="asset_sn"   value="{{$result.asset_sn}}"/>
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


 new Calendar({
                          inputField: "asset_start",
                          dateFormat: "%Y-%m-%d",
                          trigger: "asset_start_trigger",
                          bottomBar: false,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                 
                                  this.hide();
                          }
                  });
                  
                  new Calendar({
                          inputField: "asset_warrantdate",
                          dateFormat: "%Y-%m-%d",
                          trigger: "asset_warrantdate_trigger",
                          bottomBar: false,
                          onSelect: function() {
                                  var date = Calendar.intToDate(this.selection.get());
                                 
                                  this.hide();
                          }
                  });

</script>
</body>

</html>



