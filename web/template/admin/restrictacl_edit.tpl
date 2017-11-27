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
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=default_policy">默认策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sourceip">来源IP组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=weektime">周组策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=forbidden_groups_list">命令权限</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=autochange_pwd">自动改密</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_forbidden&action=cmdgroup_list">命令组</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_ipacl">授权策略</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow_contant">申请描述</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.LICENSE_KEY_NETMANAGER and $smarty.session.CACTI_CONFIG_ON}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=documentlist">文档上传</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller=admin_ipacl&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
          <form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_ipacl&action=save&sid={{$wt.id}}">
	<tr><th colspan="3" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		规则名:
		</td>
		<td width="67%">
		<input type=text id="aclname" name="aclname" value="{{$wt.aclname}}" >
	  </td>
	<tr>
		<td width="33%" align=right rowspan="5">
		访问日期区间:
		</td>
		<td width="67%">
		<input type=text id="year" name="year" size=15 value="{{$wt.year}}" >年,&nbsp;&nbsp;&nbsp;&nbsp;请输入大于1970的四位数字，可不填

	  </td>
	 </tr>
	<tr bgcolor="f7f7f7">
		
		<td width="67%">
		<input type=text id="month" name="month" size=15 value="{{$wt.month}}"  onkeyup="inputmonth(this.value)" onblur="inputmonth(this.value)">月,&nbsp;&nbsp;&nbsp;&nbsp;月份为1,2,3....12，多个用逗号分隔，可不填
	  </td></tr>
	  <tr>
	
		<td width="67%">
		<input type=text id="day" name="day" size=15 value="{{$wt.day}}"  onkeyup="inputday(this.value)" onblur="inputday(this.value)">日,&nbsp;&nbsp;&nbsp;&nbsp;日期为1,2,3....31，多个用逗号分隔，可不填
	  </td></tr>
	  <tr bgcolor="f7f7f7">
		
		<td width="67%">
		<input type=text id="week" name="week" size=15 value="{{$wt.week}}" onkeyup="inputweek(this.value)" onblur="inputweek(this.value)">星期,&nbsp;&nbsp;&nbsp;&nbsp;星期几,为1,2,3,4,5,6,7，多个用逗号分隔，可不填
	  </td></tr>
	  <tr>
		
		<td width="67%">
		<input type=text id="time" name="time" size=15 value="{{$wt.time}}" >时间,&nbsp;&nbsp;&nbsp;&nbsp;时间为时间段,如9:00-17:00，多个用逗号分隔，可不填
	  </td></tr>
	  <tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		会话时间:
		</td>
		<td width="67%">
		<input type=text id="lifetime" name="lifetime" size=15 value="{{$wt.lifetime}}" >分，范围为1-9999，可不填
	  </td></tr>
	  <tr>
		<td width="33%" align=right>
		来源网段:
		</td>
		<td width="67%">
		<input type=text id="ip" name="ip" size=18 value="{{$wt.ip}}" >例如:192.168.1.1/12
	  </td>

	<tr bgcolor="f7f7f7"><td align="center" colspan=2><input type=submit  value="{{$language.Save}}" class="an_02"></td></tr>


	</form>
</table>
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});

function inputweek(week){
	var c = week.split(",");
	for(var i=0; i<c.length; i++){
		c[i]=parseInt(c[i]);
		if(c[i]>7 || c[i]<1){
			alert('不能输入大于7小于1的数字');
			document.getElementById('week').focus();
		}
	}
}

function inputday(day){
	var c = day.split(",");
	for(var i=0; i<c.length; i++){
		c[i]=parseInt(c[i]);
		if(c[i]>31 || c[i]<1){
			alert('不能输入大于31小于1的数字');
			document.getElementById('day').focus();
		}
	}
}

function inputmonth(month){
	var c = month.split(",");
	for(var i=0; i<c.length; i++){
		c[i]=parseInt(c[i]);
		if(c[i]>12 || c[i]<1){
			alert('不能输入大于12小于1的数字');
			document.getElementById('month').focus();
		}
	}
}

function check(){
	if(document.getElementById('aclname').value==""){
		alert('策略名不能为空');
		return false;
	}
	return true;
}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


