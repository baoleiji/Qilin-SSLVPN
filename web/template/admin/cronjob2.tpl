<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>主页面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
var group = new Array();
{{section name=g loop=$allgroup}}
group[{{$smarty.section.g.index}}] = new Array();
group[{{$smarty.section.g.index}}]['name']='{{$allgroup[g].groupname}}'
group[{{$smarty.section.g.index}}]['id']='{{$allgroup[g].id}}'
{{/section}}
var server = new Array();
{{section name=s loop=$server}}
server[{{$smarty.section.s.index}}] = new Array();
server[{{$smarty.section.s.index}}]['device_ip']='{{$server[s].device_ip}}'
server[{{$smarty.section.s.index}}]['group']='{{$server[s].groupid}}'
{{/section}}
var devices = new Array();
j=0;
{{section name=d loop=$devices}}
{{if $devices[d].username}}
devices[j] = new Array();
devices[j]['username']='{{$devices[d].username}}'
devices[j]['device_ip']='{{$devices[d].device_ip}}'
j++;
{{/if}}
{{/section}}
function changesg(selected_group){
	for(var j=0; j<group.length; j++){
		if(selected_group==group[j]['name']){
			selected_group=group[j]['id'];
			break;
		}
	}
	var iid=document.getElementById("server");
	iid.options.length=0;
	iid.options[iid.options.length] = new Option('所有设备','99999999');
	for(var i=0; i<server.length; i++){
		if(selected_group==server[i]['group']){
			iid.options[iid.options.length] = new Option(server[i]['device_ip'],server[i]['device_ip']);
		}else if(selected_group==1000){
			iid.options[iid.options.length] = new Option(server[i]['device_ip'],server[i]['device_ip']);
		}
	}
}

function changes(selected_server){
	var iid=document.getElementById("device");
	iid.options.length=0;
	iid.options[iid.options.length] = new Option('所有用户','99999999');
	for(var i=0; i<devices.length; i++){
		if(selected_server==devices[i]['device_ip']){
			iid.options[iid.options.length] = new Option(devices[i]['username'],devices[i]['username']);
		}
	}
}
</script>
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
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
{{if $smarty.session.ADMIN_LEVEL eq 1}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_eth&action=serverstatus">服务状态</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_status&action=latest">系统状态</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup">配置备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting">数据同步</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=upgrade">软件升级</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=cronjob">定时任务</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=changelogo">图标上传</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=notice">系统通知</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{else}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{if $smarty.session.ADMIN_LEVEL eq 10}}
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
{{if $smarty.session.ADMIN_LEVEL ne 10 and $smarty.session.ADMIN_LEVEL ne 101}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">设备目录</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}{{/if}}
</ul>
</div></td></tr>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_backup&action=cronjob">
	<tr><td>审计文件备份:</td>
		<td align=left>
		<input type="checkbox" class="wbk" name="chpwdservice" value="1" {{if $chpwdservice}}checked{{/if}} />
		</td>		
	</tr>
	<tr bgcolor="f7f7f7"><td>审计文件备份调度:</td>
		<td align=left>
		分钟:<select name="minute" >
		<option value="*" {{if $minute eq '*'}}selected{{/if}}>*</option>
		{{section name=m loop=60}}
		<option value="{{$smarty.section.m.index}}" {{if $minute ne '*' and $minute eq $smarty.section.m.index}}selected{{/if}}>{{$smarty.section.m.index}}</option>
		{{/section}}
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		小时:<select name="hour" >
		<option value="*" {{if $hour eq '*'}}selected{{/if}}>*</option>
		{{section name=h loop=24}}
		<option value="{{$smarty.section.h.index}}" {{if $hour ne '*' and $hour eq $smarty.section.h.index}}selected{{/if}}>{{$smarty.section.h.index}}</option>
		{{/section}}
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		天:<select name="day" >
		<option value="*" {{if $day eq '*'}}selected{{/if}}>*</option>
		{{section name=d loop=31}}
		<option value="{{$smarty.section.d.index+1}}" {{if $day ne '*' and $day eq $smarty.section.d.index+1}}selected{{/if}}>{{$smarty.section.d.index+1}}</option>
		{{/section}}
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		周:<select name="week" >
		<option value="*" {{if $week eq '*'}}selected{{/if}}>*</option>
		<option value="0" {{if $week eq '0'}}selected{{/if}}>日</option>
		<option value="1" {{if $week eq '1'}}selected{{/if}}>一</option>
		<option value="2" {{if $week eq '2'}}selected{{/if}}>二</option>
		<option value="3" {{if $week eq '3'}}selected{{/if}}>三</option>
		<option value="4" {{if $week eq '4'}}selected{{/if}}>四</option>
		<option value="5" {{if $week eq '5'}}selected{{/if}}>五</option>
		<option value="6" {{if $week eq '6'}}selected{{/if}}>六</option>
		</select>
		</td>		
	</tr>
	<tr><td>主从服务器备份:</td>
		<td align=left>
		<input type="checkbox" class="wbk" name="accountservice" value="1" {{if $accountservice}}checked{{/if}} />
		</td>		
	</tr>
	<tr bgcolor="f7f7f7"><td>主从服务器备份调度:</td>
		<td align=left>
		分钟:<select name="uminute" >
		<option value="*" {{if $uminute eq '*'}}selected{{/if}}>*</option>
		{{section name=um loop=60}}
		<option value="{{$smarty.section.um.index}}" {{if $uminute ne '*' and $uminute eq $smarty.section.um.index}}selected{{/if}}>{{$smarty.section.um.index}}</option>
		{{/section}}
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		小时:<select name="uhour" >
		<option value="*" {{if $uhour eq '*'}}selected{{/if}}>*</option>
		{{section name=uh loop=24}}
		<option value="{{$smarty.section.uh.index}}" {{if $uhour ne '*' and $uhour eq $smarty.section.uh.index}}selected{{/if}}>{{$smarty.section.uh.index}}</option>
		{{/section}}
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		天:<select name="uday" >
		<option value="*" {{if $uday eq '*'}}selected{{/if}}>*</option>
		{{section name=ud loop=31}}
		<option value="{{$smarty.section.ud.index+1}}" {{if $uday ne '*' and $uday eq $smarty.section.ud.index+1}}selected{{/if}}>{{$smarty.section.ud.index+1}}</option>
		{{/section}}
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		周:<select name="uweek" >
		<option value="*" {{if $uweek eq '*'}}selected{{/if}}>*</option>
		<option value="0" {{if $uweek eq '0'}}selected{{/if}}>日</option>
		<option value="1" {{if $uweek eq '1'}}selected{{/if}}>一</option>
		<option value="2" {{if $uweek eq '2'}}selected{{/if}}>二</option>
		<option value="3" {{if $uweek eq '3'}}selected{{/if}}>三</option>
		<option value="4" {{if $uweek eq '4'}}selected{{/if}}>四</option>
		<option value="5" {{if $uweek eq '5'}}selected{{/if}}>五</option>
		<option value="6" {{if $uweek eq '6'}}selected{{/if}}>六</option>
		</select>
		</td>		
	</tr>
	<tr><td>自动删除服务:</td>
		<td align=left>
		<input type="checkbox" class="wbk" name="uploadservice" value="1" {{if $uploadservice}}checked{{/if}} />
		</td>		
	</tr>
	<tr bgcolor="f7f7f7"><td>自动删除服务调度:</td>
		<td align=left>
		分钟:<select name="pminute" >
		<option value="*" {{if $pminute eq '*'}}selected{{/if}}>*</option>
		{{section name=pm loop=60}}
		<option value="{{$smarty.section.pm.index}}" {{if $pminute ne '*' and $pminute eq $smarty.section.pm.index}}selected{{/if}}>{{$smarty.section.pm.index}}</option>
		{{/section}}
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		小时:<select name="phour" >
		<option value="*" {{if $phour eq '*'}}selected{{/if}}>*</option>
		{{section name=ph loop=24}}
		<option value="{{$smarty.section.ph.index}}" {{if $phour ne '*' and $phour eq $smarty.section.ph.index}}selected{{/if}}>{{$smarty.section.ph.index}}</option>
		{{/section}}
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		天:<select name="pday" >
		<option value="*" {{if pday eq '*'}}selected{{/if}}>*</option>
		{{section name=pd loop=31}}
		<option value="{{$smarty.section.pd.index+1}}" {{if $pday ne '*' and $pday eq $smarty.section.pd.index+1}}selected{{/if}}>{{$smarty.section.pd.index+1}}</option>
		{{/section}}
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		周:<select name="pweek" >
		<option value="*" {{if $pweek eq '*'}}selected{{/if}}>*</option>
		<option value="0" {{if $pweek eq '0'}}selected{{/if}}>日</option>
		<option value="1" {{if $pweek eq '1'}}selected{{/if}}>一</option>
		<option value="2" {{if $pweek eq '2'}}selected{{/if}}>二</option>
		<option value="3" {{if $pweek eq '3'}}selected{{/if}}>三</option>
		<option value="4" {{if $pweek eq '4'}}selected{{/if}}>四</option>
		<option value="5" {{if $pweek eq '5'}}selected{{/if}}>五</option>
		<option value="6" {{if $pweek eq '6'}}selected{{/if}}>六</option>
		</select>
		</td>		
	</tr>
	<tr>
			<td></td><td align="left"><input type="submit"  value="保存修改" class="an_02"></td>
		</tr>

	</table>
	<input type="hidden" name="ac" value="doit" />
</form>

		</table>
	</td>
  </tr>
</table>
  <script type="text/javascript">
var cal = Calendar.setup({
    onSelect: function(cal) { cal.hide() },
    showTime: true
});
cal.manageFields("f_rangeStart_trigger", "f_rangeStart", "%Y-%m-%d %H:%M:%S");


</script>

<script language="javascript">
<!--
function check()
{
/*
   if(!checkIP(f1.ip.value) && f1.netmask.value != '32' ) {
	alert('地址为主机名时，掩码应为32');
	return false;
   }   
   if(checkIP(f1.ip.value) && !checknum(f1.netmask.value)) {
	alert('请录入正确掩码');
	return false;
   }
*/
   return true;

}//end check
// -->

function checkIP(ip)
{
	var ips = ip.split('.');
	if(ips.length==4 && ips[0]>=0 && ips[0]<256 && ips[1]>=0 && ips[1]<256 && ips[2]>=0 && ips[2]<256 && ips[3]>=0 && ips[3]<256)
		return ture;
	else
		return false;
}

function checknum(num)
{

	if( isDigit(num) && num > 0 && num < 65535)
		return ture;
	else
		return false;

}

function isDigit(s)
{
var patrn=/^[0-9]{1,20}$/;
if (!patrn.exec(s)) return false;
return true;
}
changesg(document.getElementById('group').options[document.getElementById('group').options.selectedIndex].value);
</script>
</body>
</html>



