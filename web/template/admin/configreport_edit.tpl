<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
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
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=configreport">报表配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cronreports">报表自动生成配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	 <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=downloadcronreport">下载报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_reports&action=configreport&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
<tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
		
          <tr>
            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_reports&action=configreport_save&id={{$id}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top  class="BBtable">
	<tr><th colspan="2" class="list_bg">&nbsp;</th></tr>
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		标题		
		</td>
		<td width="67%">
		<input type=text name="subject" size=35 value="{{$configreport.subject}}" >
	  </td>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		模板	
		</td>
		<td width="67%">
				<select  class="wbk"  name="template" id="template">
				{{section name=t loop=$templates}}
				<option value="{{$templates[t].name}}" {{if $configreport.template eq $templates[t].name}}selected{{/if}} >{{$templates[t].title}}</option>
				{{/section}}
				</select>
	  </td>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		周期	
		</td>
		<td width="67%">
			<select  class="wbk"  name="cycle" id="cycle">
				<option value="thisday" {{if 'thisday' eq $templates[t].cycle}}selected{{/if}}>当天</option>
				<option value="thisweek" {{if 'thisweek' eq $templates[t].cycle}}selected{{/if}}>本周</option>
				<option value="thismonth" {{if 'thismonth' eq $templates[t].cycle}}selected{{/if}}>本月</option>
			</select>
	  </td>
	</tr>
	
	<tr><td></td><td><input type=submit  value="保存修改" class="an_02"></td></tr></table>
<input type='hidden' name='id' value="{{$id}}">
</form>
	</td>
  </tr>
</table>

<script language="javascript">

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
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



