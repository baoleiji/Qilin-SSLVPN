<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>主页面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function reloadimg(duration){
	var img = document.getElementById("zoomGraphImage");
	img.src=img.src+"&duration="+duration+"&"+parseInt(10000*Math.random());
}
</script>

<script>

var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var alluser = new Array();
var allserver = new Array();
var i=0;
{{section name=au loop=$alluser}}
alluser[i++]={uid:{{$alluser[au].uid}},username:'{{$alluser[au].username}}',realname:'{{$alluser[au].realname}}',groupid:{{$alluser[au].groupid}},level:{{$alluser[au].level}}};
{{/section}}
var i=0;
{{section name=as loop=$allserver}}
allserver[i++]={hostname:'{{$allserver[as].hostname}}',device_ip:'{{$allserver[as].device_ip}}',groupid:{{$allserver[as].groupid}}};
{{/section}}

</script>
<script type="text/javascript">


function GetRandomNum(Min,Max)
{   
var Range = Max - Min;   
var Rand = Math.random();   
return(Min + Math.round(Rand * Range));   
}   
var num = GetRandomNum(1,10);  

var numbers = ['0','1','2','3','4','5','6','7','8','9'];
var schars = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
var bchars = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
var sschars = ['~','!','@','#','$','%','^','&','*','(',')','<','>','?',':','"','{','}','\'',';','/','.',','];
var chars = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9','~','!','@','#','$','%','^','&','*','<','>','?',':','"','\'',';','.',','];

function generateMixed() {
	 var banword = '{{$pwdconfig_password_ban_word}}';
     var res = "";
	 for (var i=0; i<{{$pwdconfig_pwdstrong1}}; i++ )
	 {
		var id = Math.ceil(Math.random()*(numbers.length-1));
		res += numbers[id]
	 }
	 for (var i=0; i<{{$pwdconfig_pwdstrong2}}; i++ )
	 {
		var id = Math.ceil(Math.random()*(schars.length-1));
		res += schars[id]
	 }
	 for (var i=0; i<{{$pwdconfig_pwdstrong3}}; i++ )
	 {
		var id = Math.ceil(Math.random()*(bchars.length-1));
		res += bchars[id]
	 }
	 for (var i=0; i<{{$pwdconfig_pwdstrong4}}; i++ )
	 {
		var id = Math.ceil(Math.random()*(sschars.length-1));
		res += sschars[id]
	 }
     for(var i = 0; i <{{$pwdconfig_login_pwd_length}} ; ) {
		var id = Math.ceil(Math.random()*(chars.length-1));
		if(banword.indexOf(chars[id])<0){
			res += chars[id];
			i++;
		}
     }
     return res;
}

function setrandompwd(){
	if(document.getElementById('autosetpwd').checked){
		var pwd = generateMixed();
		document.getElementById('password').value=pwd;
	}else{
		document.getElementById('password').value='';
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
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
{{if $smarty.session.ADMIN_LEVEL eq 10}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
{{if $smarty.session.ADMIN_LEVEL ne 10 and $smarty.session.ADMIN_LEVEL ne 101}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">设备目录</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_pro&action=passwordedit">
	
	 
	<tr ><td>设备选择</td>
		<td align=left>
		{{include file="select_sgroup_ajax.tpl" }}          
		&nbsp;&nbsp;&nbsp;服务器IP:
		<input type="text"  name="server" size="13" value="" class="wbk"/> 
		{{*<select  class="wbk"  name='server' id='server'  onchange="changes(this.value);">
		<option value='' >所有服务器</option>
		</select>*}}
		&nbsp;&nbsp;&nbsp;
		用户:
		<input type="text"  name="device" size="13" value="" class="wbk"/> 
		{{*<select  class="wbk"  name='device' id='device'>用户选择:
		<option value='' >所有用户</option>
		</select>*}}
		</td>
		
	</tr>
	<tr bgcolor="f7f7f7"><td>密&nbsp;&nbsp;码修改:</td>
		<td align=left>
		<select  class="wbk"  name='pwdpolicy'>		
		<option value=1 >强制修改</option>
		<option value=0 >策略修改</option>
		</select>
		</td>
		
	</tr>
<tr><td>开始日期：</td>
		<td align=left>
		<input type="text"  name="f_rangeStart" size="13" id="f_rangeStart" value="立即执行" class="wbk"/> 
<input type="button" onClick="changetype('timetype3')" id="f_rangeStart_trigger" name="f_rangeStart_trigger" value="选择时间" class="wbk">
		</td>		
	</tr>
	<tr bgcolor="f7f7f7"><td>密&nbsp;&nbsp;码:</td>
		<td align=left>
		<input type="text" class="wbk" name="password" id="password" value="" />&nbsp;&nbsp;&nbsp;&nbsp;<input onClick="setrandompwd();" id="autosetpwd" type="checkbox" name="autosetpwd" value="1" />随机密码
		</td>		
	</tr>
	<tr >
			<td colspan="2" align="center"><input type="submit"  value="生成密码" class="an_02"></td>
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
</script>
<script>
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
</script>
</body>
</html>



