<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=default_policy">默认策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sourceip">来源IP组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=weektime">周组策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list">命令权限</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=autochange_pwd">自动改密</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=cmdgroup_list">命令组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ipacl">授权策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow_contant">申请描述</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.LICENSE_KEY_NETMANAGER and $smarty.session.CACTI_CONFIG_ON}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=documentlist">文档上传</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller=admin_forbidden&action=forbiddengps_cmd&gid={{$gid}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr> 
          <tr>

            <td align="center"><form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_forbidden&action=forbiddengps_cmd_save&cid={{$cmdinfo.cid}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
 <tr><th colspan="3" class="list_bg"></th></tr>
 {{if $cmdinfo.cid}}
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		命令:
		</td>
		<td width="67%">
		<input type = text name="cmd" id="cmd_0" value="{{$cmdinfo.cmd}}">&nbsp;&nbsp;<input type="checkbox"  name="regex_{{$smarty.section.c.index}}" {{if $regex}}checked{{/if}} onclick="changeRegex(this.checked,0)" value="on">正则
	  </td>
	</tr>
	{{if $ginfo.black_or_white eq 0}}
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		级别:
		</td>
		<td width="67%">				
			<select  class="wbk"  name="level" >
			<option value="1" {{if $cmdinfo.level eq '1'}}selected{{/if}}>{{$language.Disconnect}}</option>
			<option value="0" {{if $cmdinfo.level eq '0'}}selected{{/if}}>命令阻断</option>
			<option value="2" {{if $cmdinfo.level eq '2'}}selected{{/if}}>命令监控</option>
			<option value="3" {{if $cmdinfo.level eq '3'}}selected{{/if}}>命令授权</option>
			</select>
	  </td>
	</tr>	
	{{/if}}
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		授权:
		</td>
		<td width="67%">				
			<select  class="wbk"  name="toauthorize" >
			<option value="0" {{if $cmdinfo.toauthorize eq '0'}}selected{{/if}}>不授权</option>
			<option value="1" {{if $cmdinfo.toauthorize eq '1'}}selected{{/if}}>Admin授权</option>
			<option value="2" {{if $cmdinfo.toauthorize eq '2'}}selected{{/if}}>分组管理员授权</option>
			<option value="3" {{if $cmdinfo.toauthorize eq '3'}}selected{{/if}}>双人授权</option>
			</select>
	  </td>
	</tr>	
{{else}}

	{{assign var="trnumber" value=0}}
{{section name=c loop=10}}
<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		命令:
		<input type = text name="cmd_{{$smarty.section.c.index}}" id="cmd_{{$smarty.section.c.index}}" value="{{$cmdinfo.cmd}}">
	  </td>
	  <td width="67%"><input type="checkbox"  name="regex_{{$smarty.section.c.index}}" onclick="changeRegex(this.checked,{{$smarty.section.c.index}})" value="on">正则&nbsp;&nbsp;{{if $ginfo.black_or_white eq 0}}				
			<select  class="wbk"  name="level_{{$smarty.section.c.index}}" >
			<option value="1" {{if $cmdinfo.level eq '1'}}selected{{/if}}>{{$language.Disconnect}}</option>
			<option value="0" {{if $cmdinfo.level eq '0'}}selected{{/if}}>命令阻断</option>
			<option value="2" {{if $cmdinfo.level eq '2'}}selected{{/if}}>命令监控</option>
			<option value="3" {{if $cmdinfo.level eq '3'}}selected{{/if}}>命令授权</option>
			</select>
			{{/if}}
			<select  class="wbk"  name="toauthorize_{{$smarty.section.c.index}}" >
			<option value="0" {{if $cmdinfo.toauthorize eq '0'}}selected{{/if}}>不授权</option>
			<option value="1" {{if $cmdinfo.toauthorize eq '1'}}selected{{/if}}>Admin授权</option>
			<option value="2" {{if $cmdinfo.toauthorize eq '2'}}selected{{/if}}>分组管理员授权</option>
			<option value="3" {{if $cmdinfo.toauthorize eq '3'}}selected{{/if}}>双人授权</option>
			</select>
	  </td>
	</tr>	
{{/section}}
{{/if}}
	<tr>
		<td align="right"><input type="submit"  value=" 确定 " class="an_02"></td>
		<td></td>
	</tr>
	</table>
<br>
<input type="hidden" name="add" value="new" />
<input type="hidden" name="gid" value="{{$gid}}" />
</form>
	</td>
  </tr>
</table>

<script language="javascript">
function changeRegex(check,i){
    var cmdid = document.getElementById('cmd_'+i);
	var str = cmdid.value;
	if(check){
		while( str.indexOf( " " ) != -1 ) {
			 str=str.replace(" ","\\S*\\s+"); 
		}
		str+="\\S*";
	}else{
		while( str.indexOf( "\\S*\\s+" ) != -1 ) {
			 str=str.replace("\\S*\\s+"," "); 
		}
		if(str.substring(str.length-3)=="\\S*"){
			str = str.substring(0,str.length-3);
		}
	}
	cmdid.value = str;
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

document.getElementById("telnet").selected = true;


</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


