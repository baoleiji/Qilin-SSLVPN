<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script src="./template/admin/cssjs/global.functions.js"></script>
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<script src="./template/admin/cssjs/global.functions.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
</head>

<body>
<script>



function change_option(number,index){
 for (var i = 0; i <= number; i++) {
      document.getElementById('current' + i).className = '';
      document.getElementById('content' + i).style.display = 'none';
 }
  document.getElementById('current' + index).className = 'current';
  document.getElementById('content' + index).style.display = 'block';
  if(index==1 || index==2 || index==3){
	document.getElementById('finalsubmit').style.display = 'block';
  }else{
	document.getElementById('finalsubmit').style.display = 'none';
  }
  return false;
}
</script>
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
</ul><span class="back_img"><A href="admin.php?controller={{if $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 101}}admin_index&action=main{{else}}{{if $smarty.get.appconfigedit}}admin_pro&action=dev_edit&id={{$id}}&gid={{$gid}}&apptable=1{{else}}admin_pro&action=dev_index&gid={{$gid}}{{/if}}{{/if}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>

   
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_pro&action=dev_save&id={{$id}}&appconfigedit={{$appconfigedit}}&appconfigid={{$appconfig1.seq}}&gid={{$gid}}">
		<input type="password" name="hiddenpassword" id="hiddenpassword" style="display:none"/>	 <DIV style="WIDTH:100%" id=navbar>
 {{if !$appconfigedit}}
				 <div id="content1" class="content">
				   <div class="contentMain">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<TR>
      <TD height="27" colspan="4" class="tb_t_bg">基本信息</TD>
    </TR>
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=right>
		主机名		
		</td>
		<td width="35%">
		<input type=text name="hostname" size=35 value="{{$hostname}}" >
	  </td>
	  <td width="15%" align=right>
			系统类型  </td>
		<td width="35%"><select  class="wbk"  name="type_id">
		{{section name=g loop=$alltype}}
			<OPTION VALUE="{{$alltype[g].id}}" {{if $alltype[g].id == $type_id}}selected{{/if}}>{{$alltype[g].device_type}}</option>
		{{/section}}
		</select>
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=right>
		IPv4地址
		</td>
		<td width="35%">
		<input type=text name="IP" size=35 value="{{$IP}}" {{if $id}}readonly{{/if}}>
	  </td>
	  <td width="15%" align=right>
			IPv6 </td>
		<td width="35%"><input type=text name="ipv6" size=35 value="{{$ipv6}}" >
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		
	  <td width="15%" align=right>
		设备组
		</td>
		<td width="35%" >
		{{include file="select_sgroup_ajax.tpl" }} 
			
		</td>
		 <td width="15%" align=right>
			使用状况 </td>
		<td width="35%"><input type=text name="asset_status" size=35 value="{{$asset_status}}" >
	  </td>
	</tr>

	</table> </div>
				 </div>
				 <div id="content2" class="content" >
				   <div class="contentMain">
				   <table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
				  
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=right>
		固定资产名称	
		</td>
		<td width="35%">
		<input type=text name="asset_name" size=35 value="{{$asset_name}}" >
	  </td>
	  <td width="15%" align=right>
		规格型号	
		</td>
		<td width="35%">
		<input type=text name="asset_specification" size=35 value="{{$asset_specification}}" >
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=right>
		部门名称	
		</td>
		<td width="35%">
		<input type=text name="asset_department" size=35 value="{{$asset_department}}" >
	  </td>
	  <td width="15%" align=right>
		存放地点	
		</td>
		<td width="35%">
		<input type=text name="asset_location" size=35 value="{{$asset_location}}" >
	  </td>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=right>
		支持厂商	
		</td>
		<td width="35%">
		<input type=text name="asset_company" size=35 value="{{$asset_company}}" >
	  </td>
	  <td width="15%" align=right>
		开始使用日期	
		</td>
		<td width="35%">
		<input type=text name="asset_start" id="asset_start" size=35 value="{{$asset_start}}" >&nbsp;&nbsp;<input type="button"  id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk"> 

	  </td>
	</tr>	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="15%" align=right>
		使用年限	
		</td>
		<td width="35%">
		<input type=text name="asset_usedtime" size=35 value="{{$asset_usedtime}}" >
	  </td>
	  <td width="15%" align=right>
		保修日期	
		</td>
		<td width="35%">
		<input type=text name="asset_warrantdate" id="asset_warrantdate" size=35 value="{{$asset_warrantdate}}" >&nbsp;&nbsp;<input type="button"  id="f_rangeEnd_trigger" name="f_rangeEnd_trigger" value="选择时间" class="wbk"> 
	  </td>
	</tr>
	
</table>
 </div>
</div>
{{if $caction}}
 <div id="content3" class="content" >
				   <div class="contentMain">
				
 </div>
				 </div>
{{/if}}
{{/if}}
{{if $caction}}
		{{if !$appconfigedit}}
		
</script>
{{/if}}{{/if}}

 {{if !$appconfigedit}}

	<tr id="finalsubmit"><td align="center">{{if $id and $monitor==1}}{{if !$appconfigedit}}<input type=button {{if !$id}}readonly{{/if}} onclick="admin.php?controller=admin_pro&action=server_detect&ip={{$IP}}"  value="硬件检测" class="an_02">{{/if}}{{/if}}&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit  value="保存修改" class="an_02" onclick="save();return true;"></td></tr></table>

</form>
{{/if}}
	</td>
  </tr>
</table>
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true,
	popupDirection: 'up'
});
cal.manageFields("f_rangeStart_trigger", "asset_start", "%Y-%m-%d %H:%M:%S");
cal.manageFields("f_rangeEnd_trigger", "asset_warrantdate", "%Y-%m-%d %H:%M:%S");


</script>
<script language="javascript">
function save(){
	if(document.getElementById('accounttable').style.display!='none'){
		document.f1.elements.action += "&accounttable=1";
	}
	if(document.getElementById('apptable').style.display!='none'){
		document.f1.elements.action += "&apptable=1";
	}
}
function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

function changeport() {
	if(document.getElementById("ssh").selected==true)  {
		f1.port.value = 22;
	}
	if(document.getElementById("telnet").selected==true)  {
		f1.port.value = 23;
	}
}

{{if $smarty.session.ADMIN_LEVEL eq 3 and $smarty.session.ADMIN_MSERVERGROUP}}
var ug = document.getElementById('servergroup');
for(var i=0; i<ug.options.length; i++){
	if(ug.options[i].value=={{$smarty.session.ADMIN_MSERVERGROUP}}){
		ug.selectedIndex=i;
		ug.onchange = function(){ug.selectedIndex=i;}
		break;
	}
}
{{/if}}

</script>
<script>

function opentable(id){
	if(document.getElementById(id).style.display=='none'){
		document.getElementById(id+"_img").src='template/admin/cssjs/img/nolines_minus.gif'
		document.getElementById(id).style.display=''
	}else{
		document.getElementById(id+"_img").src='template/admin/cssjs/img/nolines_plus.gif'
		document.getElementById(id).style.display='none'
	}
    window.parent.reinitIframe();
}
{{if $smarty.get.accounttable}}
opentable('accounttable');
{{/if}}
{{if $smarty.get.apptable}}
opentable('apptable');
{{/if}}


//change_option({{if $smarty.session.CACTI_CONFIG_ON}}4{{else}}2{{/if}},{{$tab}});
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



