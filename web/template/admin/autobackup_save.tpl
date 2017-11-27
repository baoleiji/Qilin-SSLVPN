<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
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
<script>

var foundparent = false;
var servergroup = new Array();
var usergroup = new Array();
var alluser = new Array();
var servers = new Array();
var devices = new Array();
var i=0;
{{section name=au loop=$alluser}}
alluser[i++]={uid:{{$alluser[au].uid}},username:'{{$alluser[au].username}}',realname:'{{$alluser[au].realname}}',groupid:{{$alluser[au].groupid}},level:{{$alluser[au].level}}};
{{/section}}
var i=0;
{{section name=as loop=$allserver}}
servers[i++]={hostname:'{{$allserver[as].hostname}}',device_ip:'{{$allserver[as].device_ip}}',groupid:{{$allserver[as].groupid}}};
{{/section}}
i=0;
{{section name=c loop=$alldevices}}
devices[i++]={id:{{$alldevices[c].id}},ip:'{{$alldevices[c].device_ip}}',username:'{{if !$alldevices[c].username}}空用户{{else}}{{$alldevices[c].username}}{{/if}}', login_method: '{{$alldevices[c].lmname}}'};
{{/section}}
function changesgroup(){
	var v = document.getElementById('groupid1').value;
	var d = '{{$serverip.device_ip}}';
	document.getElementById('serverip').options.length=0;	
	document.getElementById('serverip').options[document.getElementById('serverip').options.length]=new Option('无', 0);
	for(var i=0; i<servers.length; i++){
		if(servers[i].groupid==v){
			if(d==servers[i].device_ip){
				found = 1;
				document.getElementById('serverip').options[document.getElementById('serverip').options.length]=new Option(servers[i].device_ip, servers[i].device_ip, true, true);
			}else{				
				document.getElementById('serverip').options[document.getElementById('serverip').options.length]=new Option(servers[i].device_ip, servers[i].device_ip);
			}
		}
	}
}

function changeserver(v, d){
	document.getElementById('deviceid').options.length=0;	
	document.getElementById('deviceid').options[document.getElementById('deviceid').options.length]=new Option('无', 0);
	for(var i=0; i<devices.length; i++){
		if(devices[i].ip==v){
			if(d==devices[i].id){
				found = 1;
				document.getElementById('deviceid').options[document.getElementById('deviceid').options.length]=new Option(devices[i].username+'('+devices[i].login_method+')', devices[i].id, true, true);
			}else{				
				document.getElementById('deviceid').options[document.getElementById('deviceid').options.length]=new Option(devices[i].username+'('+devices[i].login_method+')', devices[i].id);
			}
		}
	}
}

function change_option(number,index){
 for (var i = 0; i < number; i++) {
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
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	{{if $from ne 'status'}}
 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
    {{if $smarty.get.type eq 'run'}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list&type=run">巡检帐号</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{else}}
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autobackup_list">备份管理</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	
	{{/if}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autotemplate">巡检管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=detail_config">巡检检测</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_autorun&action=autorun_result">检测结果</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="javascript:history.back();"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
{{/if}}
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>

    <td align="center">
	<form name="f1" method=post enctype="multipart/form-data"  action="admin.php?controller=admin_autorun&action=autobackup_dosave_backup&id={{$id}}&type={{$type}}&ip={{$ip}}&from={{$from}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	{{if $from ne 'status'}}
	<tr><th colspan="3" class="list_bg"></th></tr>
	{{else}}
	<tr><td colspan="3" class="list_bg1"></td></tr>
	{{/if}}
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称:
		</td>
		<td width="67%"><input type="text" class="wbk" name="name" value="{{$auto.name}}"></td>
	</tr>	
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		资源组:
		</td>
		<td width="67%">
		{{assign var=changegroup value='changesgroup();'}}
		{{include file="select_sgroup_ajax.tpl" }}
		</td>
	</tr>
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		服务器:
		</td>
		<td width="67%">
			<select  class="wbk"  name="serverip" id="serverip" onchange="changeserver(this.value,0);">
			</select>
		</td>
	</tr>	
	
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		用户:
		</td>
		<td width="67%">
			<select  class="wbk"  name="deviceid" id="deviceid">
			</select>
			</td>
	</tr>	
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		备份周期:
		</td>
		<td width="67%">				
			<input type="text" class="wbk" name="period" value="{{$auto.interval}}">天
	  </td>
	</tr>	
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		是否sudo:
		</td>
		<td width="67%">				
			<select  class="wbk"  name="su" >
			<option value="1" {{if $auto.su eq 1}}selected{{/if}}>是</option>
			<option value="0" {{if $auto.su eq 0}}selected{{/if}}>否</option>
			</select>
	  </td>
	</tr>	
	{{if $type eq 'run'}}
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		备份脚本:
		</td>
		<td width="67%">				
			<select  class="wbk"  name="localpath" >
			<option value="" >请选择</option>
			{{section name=t loop=$templates}}
			<option value="{{$templates[t].scriptpath}}" {{if $templates[t].scriptpath eq $auto.localpath}}selected{{/if}}>{{$templates[t].name}}</option>
			{{/section}}
			</select>
	  </td>
	</tr>	
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		上传服务器路径:
		</td>
		<td width="67%">				
			<input type="text" name="scriptpath" value="{{$auto.scriptpath}}" >
	  </td>
	</tr>	
	{{else}}
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		备份文件名:
		</td>
		<td width="67%">	
			<input type="text" name="scriptpath" value="{{$auto.scriptpath}}" >
	  </td>
	</tr>	
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		内存配置:
		</td>
		<td width="67%">	
			<input type="checkbox" name="running" value="on" {{if $auto.running}}checked{{/if}}>
	  </td>
	</tr>	
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		存盘配置:
		</td>
		<td width="67%">	
			<input type="checkbox" name="startup" value="on" {{if $auto.startup}}checked{{/if}}>
	  </td>
	</tr>	
	{{/if}}
	<tr {{if $trnumber++ % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		<td width="33%" align=right>
		巡检内容:
		</td>
		<td width="67%">				
			<textarea name="desc" rows="10" cols="50">{{$templates[t].desc}}</textarea>
	  </td>
	</tr>	
	<tr>
		<td></td>
		<td><input type="submit"  value="保存" class="an_02"></td>
	</tr>
	</table>
<br>
<input type="hidden" name="add" value="new" />
<input type="hidden" name="id" value="{{$id}}" />
</form>
	</td>
  </tr>
</table>

<script language="javascript">
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
changesgroup({{$sgroup.id}},'{{$serverip.device_ip}}')
changeserver('{{$serverip.device_ip}}','{{$devpass.id}}')
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


