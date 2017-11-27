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
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=default_policy">默认策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sourceip">来源IP组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=weektime">周组策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list">命令权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=autochange_pwd">自动改密</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=cmdgroup_list">命令组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ipacl">授权策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow_contant">申请描述</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.LICENSE_KEY_NETMANAGER and $smarty.session.CACTI_CONFIG_ON}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=documentlist">文档上传</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>
	

  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="5"  class="BBtable">
          <form name="f1" method=post action="admin.php?controller=admin_config&action=autochange_pwd&id={{$defaultp.id}}">
	<tr><th colspan="3" class="list_bg"></th></tr>
{{assign var="trnumber" value=0}}
					
		<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                  <TD width="33%" align=right>最小长度 </TD>
                  <TD><input type="text" class="wbk" name="minlen" class="input_shorttext" value="{{$defaultp.minlen}}">
				  </TD>
                </TR>
				 {{assign var="trnumber" value=$trnumber+1}}
                <TR>
                  <TD width="33%" align=right>最少字母数 </TD>
                  <TD><input type="text" class="wbk" name="minalpha" class="input_shorttext" value="{{$defaultp.minalpha}}">                
				  </TD>
                </TR>
               {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                  <TD width="33%" align=right>最少其它字符数 </TD>
                  <TD><input type="text" class="wbk" name="minother" class="input_shorttext" value="{{$defaultp.minother}}">                
				  </TD>
                </TR>
                {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td align=right>与旧口令最少不同字符</td>
						<td><input type="text" class="wbk" name="mindiff" class="input_shorttext" value="{{$defaultp.mindiff}}"></td>
					</tr>
					{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                  <TD  align=right>密码最大重复字符数 </TD>
                  <TD><input type="text" class="wbk" name="maxrepeats" class="input_shorttext" value="{{$defaultp.maxrepeats}}">               
				  </TD>
                </TR>
               {{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD width="33%" align=right>记录旧密码时间 </TD>
                  <TD width="67%"><input type="text" class="wbk" name="histexpire" class="input_shorttext" value="{{$defaultp.histexpire}}">单位：天</TD>
                </TR>    
				{{assign var="trnumber" value=$trnumber+1}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<TD width="33%" align=right>记录旧密码次数 </TD>
                  <TD width="67%"><input type="text" class="wbk" name="histsize" class="input_shorttext" value="{{$defaultp.histsize}}">                  </TD>
                </TR>    
                </div></td></tr>
				  <TR >
<tr>
<td align="center" colspan=2>
<input type="hidden" name="ac" value="{{if $defaultp}}edit{{else}}new{{/if}}" />
<input type=submit  value="保存修改" class="an_02">

	</td>
  </tr></form>
</table>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



