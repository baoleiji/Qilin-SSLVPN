<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/Calendarandtime.js"></script>
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	{{if $smarty.session.ADMIN_LEVEL ne 3 and $smarty.session.ADMIN_LEVEL ne 21 and $smarty.session.ADMIN_LEVEL ne 101}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=default_policy">默认策略</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{/if}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sourceip">来源IP组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=weektime">周组策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list">命令权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL ne 3 and $smarty.session.ADMIN_LEVEL ne 21 and $smarty.session.ADMIN_LEVEL ne 101}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=autochange_pwd">自动改密</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=cmdgroup_list">命令组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>	
	{{/if}}
	{{if $smarty.session.ADMIN_LEVEL ne 3 and $smarty.session.ADMIN_LEVEL ne 21 and $smarty.session.ADMIN_LEVEL ne 101}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ipacl">授权策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow_contant">申请描述</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.LICENSE_KEY_NETMANAGER and $smarty.session.CACTI_CONFIG_ON}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=documentlist">文档上传</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}

</ul>
</div></td></tr>

  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="5"  class="BBtable">

		<form name="f1" method=post action="admin.php?controller=admin_config&action=default_policy&id={{$defaultp.id}}">
          <tr><th colspan="3" class="list_bg"></th></tr>
{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD width="33%" align=right>自动登录为超级用户 </TD>
                  <TD width="67%"><INPUT id="autosu" {{if $defaultp.autosu == 1}} checked {{/if}} type=checkbox name=autosu value="on">                  </TD>
                </TR>
                {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD width="33%" align=right>是否登录时进行syslog告警 </TD>
                  <TD width="67%"><INPUT id="syslogalert" {{if $defaultp.syslogalert == 1}} checked {{/if}} type=checkbox name=syslogalert value="on">                  </TD>
                </TR>
                {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD width="33%" align=right>是否登录时发送邮件进行告警</TD>
                  <TD width="67%"><INPUT id="mailalert" {{if $defaultp.mailalert == 1}} checked {{/if}} type=checkbox name=mailalert value="on">                  </TD>
                </TR>
             {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD width="33%" align=right>账号是否被锁定 </TD>
                  <TD width="67%"><INPUT id="loginlock" {{if $defaultp.loginlock == 1}} checked {{/if}} type=checkbox name=loginlock value="on">                  </TD>
                </TR>
     {{assign var="trnumber" value=$trnumber+1}}
		<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                  <TD width="33%" align=right>周组策略 </TD>
                  <TD><select  class="wbk"  name=weektime>
                      <OPTION value="">无</OPTION>
                     	{{section name=k loop=$weektime}}
				<option value="{{$weektime[k].policyname}}" {{if $weektime[k].policyname == $defaultp.weektime}}selected{{/if}}>{{$weektime[k].policyname}}</option>
			{{/section}}
                  </SELECT>                  
				  </TD>
                </TR>
                <TR>
                  <TD width="33%" align=right>来源IP组 </TD>
                  <TD><select  class="wbk"  name=sourceip>
                      <OPTION value="">无</OPTION>
                     	{{section name=t loop=$sourceip}}
				<option value="{{$sourceip[t].groupname}}" {{if $sourceip[t].groupname == $defaultp.sourceip}}selected{{/if}}>{{$sourceip[t].groupname}}</option>
			{{/section}}
                  </SELECT>                  
				  </TD>
                </TR>
               {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                  <TD width="33%" align=right>命令权限 </TD>
                  <TD><select  class="wbk"  name=forbidden_commands_groups>
                      <OPTION value="">无</OPTION>
                     	{{section name=f loop=$allforbiddengroup}}
				<option value="{{$allforbiddengroup[f].gname}}" {{if $allforbiddengroup[f].gname == $defaultp.forbidden_commands_groups}}selected{{/if}}>{{$allforbiddengroup[f].gname}}({{if $allforbiddengroup[f].black_or_white}}允许{{else}}禁止{{/if}})</option>
			{{/section}}
                  </SELECT>                  
				  </TD>
                </TR>
                {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td align=right>网络硬盘：</td>
						<td><input type="text" class="wbk" name="netdisksize" class="input_shorttext" value="{{$defaultp.netdisksize}}">MB</td>
					</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                  <TD  align=right>默认控件 </TD>
                  <TD><select  class="wbk"  name=default_control>
                     <OPTION value="0" {{if $defaultp.default_control eq 0}}selected{{/if}}>自动检测</OPTION>
                     <OPTION value="1" {{if $defaultp.default_control eq 1}}selected{{/if}}>applet</OPTION>
                     <OPTION value="2" {{if $defaultp.default_control eq 2}}selected{{/if}}>activeX</OPTION>
                  </SELECT>                  
				  </TD>
                </TR>
               {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD width="33%" align=right>自动登录: </TD>
                  <TD width="67%"><INPUT id="entrust_password" {{if $defaultp.entrust_password == 1}} checked {{/if}} type=checkbox name=entrust_password value="on">                  </TD>
                </TR>    
                </div></td></tr>
				{{*
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD width="33%" align=right>RDP磁盘映射: </TD>
                  <TD width="67%"><INPUT id="rdpdiskauth_up" {{if $defaultp.rdpdiskauth_up == 1}} checked {{/if}} type=checkbox name=rdpdiskauth_up value="on">                  </TD>
                </TR>    
                </div></td></tr>
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD width="33%" align=right>剪切板上行: </TD>
                  <TD width="67%"><INPUT id="rdpclipauth_up" {{if $defaultp.rdpclipauth_up == 1}} checked {{/if}} type=checkbox name=rdpclipauth_up value="on">                  </TD>
                </TR>    
                </div></td></tr>
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD width="33%" align=right>剪切板下行: </TD>
                  <TD width="67%"><INPUT id="rdpclipauth_down" {{if $defaultp.rdpclipauth_down == 1}} checked {{/if}} type=checkbox name=rdpclipauth_down value="on">                  </TD>
                </TR>    
				*}}
                </div></td></tr>
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD width="33%" align=right>IPv6优先: </TD>
                  <TD width="67%"><INPUT id="ipv6enable" {{if $defaultp.ipv6enable == 1}} checked {{/if}} type=checkbox name=ipv6enable value="on">                  </TD>
                </TR>    
                </div></td></tr>
				  <TR >
<tr>
<td align="center" colspan=2>
<input type="hidden" name="ac" value="{{if $defaultp}}edit{{else}}new{{/if}}" />
<input type=submit  value="保存修改" class="an_02">

</td></tr>
</form>
	</table>


</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



