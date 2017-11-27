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
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=configreport">报表配置</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	 <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=cronreports">报表自动生成配置</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	 <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_reports&action=downloadcronreport">下载报表</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul>
</div></td></tr>
	

  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="5"  class="BBtable">
		<form name="f1" method=post action="admin.php?controller=admin_reports&action=cronreports">
          <tr><th colspan="3" class="list_bg">&nbsp;</th></tr>
         <tr bgcolor="">
		<TD width="10%" align=right>报表模板 </TD><td colspan="2"><input type="radio" name='template' value="html" {{if $defaultp.template eq 'html'}}checked{{/if}}>HTML&nbsp;&nbsp;&nbsp;<input type="radio" name='template' value="excel" {{if $defaultp.template eq 'excel'}}checked{{/if}}>EXCEL&nbsp;&nbsp;&nbsp;<input type="radio" name='template' value="pdf" {{if $defaultp.template eq 'pdf'}}checked{{/if}}>PDF</td>
		</tr>
{{assign var="trnumber" value=0}}
		<tr bgcolor="f7f7f7">
		<TD width="10%" align=right rowspan="2">日发送的报表 </TD>
		<td width="10%" align=right  valign=top>报表类型</td>
                  <TD width="67%"><INPUT {{if $defaultp.day_commandreport == 1}} checked {{/if}} type=checkbox name=day[]  value="commandreport">命令总计
					&nbsp;&nbsp;<INPUT {{if $defaultp.day_appreport == 1}} checked {{/if}} type=checkbox name=day[] value="appreport">应用报表
					&nbsp;&nbsp;<INPUT {{if $defaultp.day_sftpreport == 1}} checked {{/if}} type=checkbox name=day[] value="sftpreport">SFTP命令报表
					&nbsp;&nbsp;<INPUT {{if $defaultp.day_ftpreport == 1}} checked {{/if}} type=checkbox name=day[] value="ftpreport">FTP命令报表
					<INPUT {{if $defaultp.day_dangercmdreport == 1}} checked {{/if}} type=checkbox name=day[] value="dangercmdreport">告警报表
					&nbsp;&nbsp;<INPUT {{if $defaultp.day_logintims == 1}} checked {{/if}} type=checkbox name=day[] value="logintims">登录统计
					{{*&nbsp;&nbsp;<INPUT {{if $defaultp.day_loginacct == 1}} checked {{/if}} type=checkbox name=day[] value="loginacct">授权明细
					&nbsp;&nbsp;<INPUT {{if $defaultp.day_loginfailed == 1}} checked {{/if}} type=checkbox name=day[] value="loginfailed">登录尝试*}}
					</TD>
                </TR>
	<tr bgcolor="f7f7f7">
	<td width="10%" align=right  valign=top>
		发送的用户
		</td>
		<td width="80%">
		<table><tr >
		{{section name=g loop=$dayusers}}
		<td width="180"><input type="checkbox" name='dayusers[]' value='{{$dayusers[g].uid}}'  {{$dayusers[g].dcheck}}>{{$dayusers[g].username}}({{if $dayusers[g].realname}}{{$dayusers[g].realname}}{{else}}未设置{{/if}})</td>{{if ($smarty.section.g.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/section}}
		</tr></table>
	  </td>
	  </tr>
	  <tr><td colspan="3"></td></tr>
					<tr >
		<TD width="10%" align=right rowspan="2">周发送的报表 </TD>
		<td width="10%" align=right  valign=top>报表类型</td>
                  <TD width="67%"><INPUT {{if $defaultp.week_commandreport == 1}} checked {{/if}} type=checkbox name=week[]  value="commandreport">命令总计
					&nbsp;&nbsp;<INPUT {{if $defaultp.week_appreport == 1}} checked {{/if}} type=checkbox name=week[] value="appreport">应用报表
					&nbsp;&nbsp;<INPUT {{if $defaultp.week_sftpreport == 1}} checked {{/if}} type=checkbox name=week[] value="sftpreport">SFTP命令报表
					&nbsp;&nbsp;<INPUT {{if $defaultp.week_ftpreport == 1}} checked {{/if}} type=checkbox name=week[] value="ftpreport">FTP命令报表
					<INPUT {{if $defaultp.week_dangercmdreport == 1}} checked {{/if}} type=checkbox name=week[] value="dangercmdreport">告警报表
					&nbsp;&nbsp;<INPUT {{if $defaultp.week_logintims == 1}} checked {{/if}} type=checkbox name=week[] value="logintims">登录统计
					{{*&nbsp;&nbsp;<INPUT {{if $defaultp.week_loginacct == 1}} checked {{/if}} type=checkbox name=week[] value="loginacct">授权明细
					&nbsp;&nbsp;<INPUT {{if $defaultp.week_loginfailed == 1}} checked {{/if}} type=checkbox name=week[] value="loginfailed">登录尝试*}}
					</TD>
                </TR>
				<tr>
	<td width="10%" align=right  valign=top>
		发送的用户
		</td>
		<td width="80%">
		<table><tr >
		{{section name=g loop=$weekusers}}
		<td width="180"><input type="checkbox" name='weekusers[]' value='{{$weekusers[g].uid}}'  {{$weekusers[g].wcheck}}>{{$weekusers[g].username}}({{if $weekusers[g].realname}}{{$weekusers[g].realname}}{{else}}未设置{{/if}})</td>{{if ($smarty.section.g.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/section}}
		</tr></table>
	  </td>
	  </tr>
	  <tr><td colspan="3"></td></tr>
                {{assign var="trnumber" value=$trnumber+1}}
	<tr  bgcolor="f7f7f7">
		<TD width="10%" align=right rowspan="2">月发送的报表 </TD>
		<td width="10%" align=right  valign=top>报表类型</td>
                  <TD width="67%"><INPUT {{if $defaultp.month_commandreport == 1}} checked {{/if}} type=checkbox name=month[]  value="commandreport">命令总计
					&nbsp;&nbsp;<INPUT {{if $defaultp.month_appreport == 1}} checked {{/if}} type=checkbox name=month[] value="appreport">应用报表
					&nbsp;&nbsp;<INPUT {{if $defaultp.month_sftpreport == 1}} checked {{/if}} type=checkbox name=month[] value="sftpreport">SFTP命令报表
					&nbsp;&nbsp;<INPUT {{if $defaultp.month_ftpreport == 1}} checked {{/if}} type=checkbox name=month[] value="ftpreport">FTP命令报表
					<INPUT {{if $defaultp.month_dangercmdreport == 1}} checked {{/if}} type=checkbox name=month[] value="dangercmdreport">告警报表
					&nbsp;&nbsp;<INPUT {{if $defaultp.month_logintims == 1}} checked {{/if}} type=checkbox name=month[] value="logintims">登录统计
					{{*&nbsp;&nbsp;<INPUT {{if $defaultp.month_loginacct == 1}} checked {{/if}} type=checkbox name=month[] value="loginacct">授权明细
					&nbsp;&nbsp;<INPUT {{if $defaultp.month_loginfailed == 1}} checked {{/if}} type=checkbox name=month[] value="loginfailed">登录尝试*}}
					</TD>
                </TR>
				<tr bgcolor="f7f7f7">
	<td width="10%" align=right  valign=top>
		发送的用户
		</td>
		<td width="80%">
		<table><tr >
		{{section name=g loop=$monthusers}}
		<td width="180"><input type="checkbox" name='monthusers[]' value='{{$monthusers[g].uid}}'  {{$monthusers[g].mcheck}}>{{$monthusers[g].username}}({{if $monthusers[g].realname}}{{$monthusers[g].realname}}{{else}}未设置{{/if}})</td>{{if ($smarty.section.g.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/section}}
		</tr></table>
	  </td>
	  </tr>
				  <TR >
<tr>
<td align="center" colspan=3>
<input type=button onclick="document.getElementById('hide').src='admin.php?controller=admin_reports&action=docronreports'"  value="生成报表" class="an_02">&nbsp;&nbsp;
<input type="hidden" name="ac" value="{{if $defaultp}}edit{{else}}new{{/if}}" />
<input type=submit  value="保存修改" class="an_02">

</td></tr>
</form>
	</table>


</body>
<iframe id="hide" name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



