<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$site_title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script>
function resto()
{
 if(document.getElementById('filesql').value=='' ){
   alert("{{$language.UploadFile}}");
   return false;
  }
  return true;
}
</script>
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
var _system = ['cpu', 'cpu_io', 'memory', 'disk', 'swap'];
var _interface = ['interface'];

function changetype(v, d){
	var dtype = document.getElementById('_type');
	dtype.options.length = 0;
	dtype.options[dtype.options.length] = new Option('请选择', '');
    if(v=='system'){
		for(var i=0; i<_system.length; i++){
			if(d==_system[i]){
				dtype.options[dtype.options.length] = new Option(_system[i], _system[i], true, true);
			}else{
				dtype.options[dtype.options.length] = new Option(_system[i], _system[i]);
			}
		}
	}else if(v=='interface'){
		for(var i=0; i<_interface.length; i++){
			if(d==_system[i]){
				dtype.options[dtype.options.length] = new Option(_interface[i], _interface[i], true, true);
			}else{
				dtype.options[dtype.options.length] = new Option(_interface[i], _interface[i]);
			}
		}
	}else if(v=='log'){
		for(var i=0; i<_system.length; i++){
		}
	}
}
</script>
</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
	 <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>

	{{if $smarty.session.ADMIN_LEVEL ne 3 and $smarty.session.ADMIN_LEVEL ne 21 and $smarty.session.ADMIN_LEVEL ne 101}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=default_policy">默认策略</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
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
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=documentlist">文档上传</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
</ul><span class="back_img"><A href="admin.php?controller=admin_index&action=documentlist&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
		<form name="backup" enctype="multipart/form-data" action="admin.php?controller=admin_index&action=dodocumentupload&id={{$doc.id}}" method="post">
		<tr><th colspan="3" class="list_bg"></th></tr>
		<tr><td align="right">标题：</td><td><input name="title" id="title" type="text" value="{{$doc.title}}" /></td></tr>
		<tr><td align="right">设备：</td>
			<td>
			<select name="device_ip" >
			<option value="">所有</option>
			{{section name=s loop=$servers}}
			<option value="{{$servers[s].device_ip}}" {{if $doc.device_ip eq $servers[s].device_ip}}selected{{/if}} >{{$servers[s].device_ip}}</option>
			{{/section}}
			</select>
			</td>
		</tr>
		<tr><td align="right">设备类型：</td>
			<td>
			<select name="device_type" >
			<option value="">所有</option>
			{{section name=d loop=$dtype}}
			<option value="{{$dtype[d].id}}" {{if $doc.device_type eq $dtype[d].id}}selected{{/if}}>{{$dtype[d].device_type}}</option>
			{{/section}}
			</select>
			</td>
		</tr>
		<tr><td align="right">类型：</td>
			<td>
			<select name="type" id="type" onchange="changetype(this.value)">
			<option value="">请选择</option>
			<option value="system" {{if $_type eq 'system'}}selected{{/if}}>系统</option>
			<option value="interface" {{if $_type eq 'interface'}}selected{{/if}}>网络</option>
			<option value="log" {{if $_type eq 'log'}}selected{{/if}}>日志</option>
			</select>
			<select name="_type" id="_type" >
			</select>
			</td>
		</tr>
		<tr><td align="right">PDF文档：</td><td><input name="pdf" id="pdf" type="file" /></td></tr>
		<tr><td align="right">说明：</td><td><textarea name="desc" cols="30" rows="10" id="desc" >{{$doc.desc}}</textarea></td></tr>
		{{*<tr><td align="right">HTML文档：</td><td><input name="html" id="html" type="file" /></td></tr>*}}
		<tr><td  colspan="2" align="center"><input name="submit" type="submit" value="提交" / class="an_02"></td><td></td></tr>
		</form>
		</table>
	</td>
  </tr>
</table>
<script>
changetype('{{$_type}}', '{{$doc.type}}');
</script>
</body>
</html>


