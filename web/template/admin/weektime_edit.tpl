<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/Calendarandtime.js"></script>
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
</head>
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
<body>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
	{{if $smarty.session.ADMIN_LEVEL ne 3 and $smarty.session.ADMIN_LEVEL ne 21 and $smarty.session.ADMIN_LEVEL ne 101}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=default_policy">默认策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sourceip">来源IP组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=weektime">周组策略</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
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
</ul><span class="back_img"><A href="admin.php?controller=admin_member&action=weektime&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
          <form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_member&action=weektime_save&sid={{$wt['sid']}}">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.groupname}}	
		</td>
		<td width="67%">
		<input type=text name="policyname" size=35 value="{{$wt.policyname}}" >
	  </td>
	<tr>
		<td width="33%" align=right>
		{{$language.Monday}}
		</td>
		<td width="67%">
		<input type=text id="start1" name="start1" size=15 value="{{$wt.start_time1}}" onclick="setHM(this)">
		-
		<input type=text id="end1" name="end1" size=15 value="{{$wt.end_time1}}" onclick="setHM(this)">
		&nbsp;&nbsp;<input type="radio" onclick="banit(1,0)" name="ban" value="0">{{$language.Allowall}}<input type="radio" onclick="banit(1,1)" name="ban" value="1">{{$language.Banall}}

	  </td>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.Tuesday}}
		</td>
		<td width="67%">
		<input type=text id="start2" name="start2" size=15 value="{{$wt.start_time2}}" onclick="setHM(this)">
		-
		<input type=text id="end2" name="end2" size=15 value="{{$wt.end_time2}}" onclick="setHM(this)">
		&nbsp;&nbsp;<input type="radio" onclick="banit(2,0)" name="ban" value="0">{{$language.Allowall}}<input type="radio" onclick="banit(2,1)" name="ban" value="1">{{$language.Banall}}
	  </td>
	  <tr>
		<td width="33%" align=right>
		{{$language.Wednesday}}
		</td>
		<td width="67%">
		<input type=text id="start3" name="start3" size=15 value="{{$wt.start_time3}}" onclick="setHM(this)">
		-
		<input type=text id="end3" name="end3" size=15 value="{{$wt.end_time3}}" onclick="setHM(this)">
		&nbsp;&nbsp;<input type="radio" onclick="banit(3,0)" name="ban" value="0">{{$language.Allowall}}<input type="radio" onclick="banit(3,1)" name="ban" value="1">{{$language.Banall}}

	  </td>
	  <tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.Thursday}}
		</td>
		<td width="67%">
		<input type=text id="start4" name="start4" size=15 value="{{$wt.start_time4}}" onclick="setHM(this)">
		-
		<input type=text id="end4" name="end4" size=15 value="{{$wt.end_time4}}" onclick="setHM(this)">
		&nbsp;&nbsp;<input type="radio" onclick="banit(4,0)" name="ban" value="0">{{$language.Allowall}}<input type="radio" onclick="banit(4,1)" name="ban" value="1">{{$language.Banall}}

	  </td>
	  <tr>
		<td width="33%" align=right>
		{{$language.Friday}}
		</td>
		<td width="67%">
		<input type=text id="start5" name="start5" size=15 value="{{$wt.start_time5}}" onclick="setHM(this)">
		-
		<input type=text id="end5" name="end5" size=15 value="{{$wt.end_time5}}" onclick="setHM(this)">
		&nbsp;&nbsp;<input type="radio" onclick="banit(5,0)" name="ban" value="0">{{$language.Allowall}}<input type="radio" onclick="banit(5,1)" name="ban" value="1">{{$language.Banall}}

	  </td>
	  <tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		{{$language.Saturday}}
		</td>
		<td width="67%">
		<input type=text id="start6" name="start6" size=15 value="{{$wt.start_time6}}" onclick="setHM(this)">
		-
		<input type=text id="end6" name="end6" size=15 value="{{$wt.end_time6}}" onclick="setHM(this)">
		&nbsp;&nbsp;<input type="radio" onclick="banit(6,0)" name="ban" value="0">{{$language.Allowall}}<input type="radio" onclick="banit(6,1)" name="ban" value="1">{{$language.Banall}}

	  </td>
	  <tr>
		<td width="33%" align=right>
		{{$language.Sunday}}
		</td>
		<td width="67%">
		<input type=text id="start7" name="start7" size=15 value="{{$wt.start_time7}}" onclick="setHM(this)">
		-
		<input type=text id="end7" name="end7" size=15 value="{{$wt.end_time7}}" onclick="setHM(this)">
		&nbsp;&nbsp;<input type="radio" onclick="banit(7,0)" name="ban" value="0">{{$language.Allowall}}<input type="radio" onclick="banit(7,1)" name="ban" value="1">{{$language.Banall}}

	  </td>

	<tr bgcolor="f7f7f7"><td align="center" colspan=2><input type=submit  value="{{$language.Save}}" class="an_02"></td></tr>


	</form>
</table>
<script>
function banit(number, ban){
	document.getElementById('start'+number).value='00:00:00';
	if(ban){		
		document.getElementById('end'+number).value='00:00:00';
	}else{
		document.getElementById('end'+number).value='23:59:59';
	}
}
</script>
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_start1", "start1", "%H:%M");
cal.manageFields("f_start2", "start2", "%H:%M");
cal.manageFields("f_start3", "start3", "%H:%M");
cal.manageFields("f_start4", "start4", "%H:%M");
cal.manageFields("f_start5", "start5", "%H:%M");
cal.manageFields("f_start6", "start6", "%H:%M");
cal.manageFields("f_start7", "start7", "%H:%M");
cal.manageFields("f_end1", "end1", "%H:%M");
cal.manageFields("f_end2", "end2", "%H:%M");
cal.manageFields("f_end3", "end3", "%H:%M");
cal.manageFields("f_end4", "end4", "%H:%M");
cal.manageFields("f_end5", "end5", "%H:%M");
cal.manageFields("f_end6", "end6", "%H:%M");
cal.manageFields("f_end7", "end7", "%H:%M");
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


