<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>主页面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	function check_add_user(){
		return(true);
	}
</script>
</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">会话管理——会话列表</td>
  </tr>
  <tr>
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
		<form method="post" name="add_user" action="admin.php?controller=admin_facility&action=save&type=edit&fid={{$facility.fid}}" >
		<tr>
			<th class="list_bg"  colspan="2" align="center"><strong>设备基本信息</strong></td>
		</tr>
		<tr>
			<td>设备名：</td>
			<td><input type="text" class="wbk" name="name" class="input_shorttext" value="{{$facility.name}}"></td>
		</tr>
		<tr bgcolor="f7f7f7">
			<td>设备描述：</td>
			<td><textarea name="describe" cols="40" rows="5">{{$facility.describe}}</textarea></td>
		</tr>
		<tr>
			<td>设备服务器地址：</td>
			<td><input type="text" class="wbk" name="ip" class="input_shorttext" value="{{$facility.ip}}"></td>
		</tr>
		<tr bgcolor="f7f7f7">
			<td>SSH 端口：</td>
			<td><input type="text" class="wbk" name="port" class="input_shorttext" value="{{$facility.port}}"></td>
		</tr>
		<tr>
			<td>SNMP通信字符串：</td>
			<td><input type="text" class="wbk" name="community" class="input_shorttext" value="{{$facility.community}}"></td>
		</tr>
		<tr bgcolor="f7f7f7">
			<td>设备类型</td>
			<td>
			{{$facility.type}}
			</td>
		</tr>
		<tr>
			<td>用户名：</td>
			<td><input type="text" class="wbk" name="username" class="input_shorttext" value="{{$facility.username}}"></td>
		</tr>
		<tr bgcolor="f7f7f7">
			<td>密&nbsp;&nbsp;码：</td>
			<td><input type="password" name="password" class="input_shorttext" value="{{$facility.password}}"></td>
		</tr>
		
		<tr>
			<th class="list_bg"  colspan="2" align="center"><strong>监控的配置列表(选择表示删除)</strong></td>
		</tr>
		{{section name=t loop=$config_list}}
		<tr>
			<td></td>
			<td><input type="checkbox" name="chk_delete[]" size="60" value="{{$config_list[t].cid}}">{{$config_list[t].name}}{{if $config_list[t].name == 'Linux配置文件'}}：{{$config_list[t].path}}{{/if}}{{if $config_list[t].name == 'Tripwire文件'}}：{{$config_list[t].path}}{{/if}}</td>
		</tr>
		{{/section}}
		<tr>
			<th class="list_bg"  colspan="2" align="center"><strong>新增要监控的配置</strong></td>
		</tr>

		<tr>
			<td colspan="2" align="center">
				<select  class="wbk"  name="config_type" id="config_type" onchange="if(document.getElementById('config_type').value != 'Linux配置文件' && document.getElementById('config_type').value != 'Tripwire文件') {document.getElementById('path').style.display='none';} else {document.getElementById('path').style.display='inline';}">
				<option value="">无</option>
				{{section name=t loop=$config_type}}
				{{if $tid|isin:$config_type[t].facility}} 
				<option value="{{$config_type[t].name}}">{{$config_type[t].name}}</option>
				{{/if}}
				{{/section}}
				</select>
				<div id="path" style="display:inline">
					配置文件路径：<input name="path" value="" type="text" class="wbk" />
				</div>
				<script language="javascript">
					if(document.getElementById('config_type').value != 'Linux配置文件' && document.getElementById('config_type').value != 'Tripwire文件') {document.getElementById('path').style.display='none';} 
				</script>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit"  value="修改设备" class="an_02"><input type="submit" name="Submit3" value="" class="an_03"/ class="an_02"></td>
		</tr>
		</form>

		</table>
	</td>
  </tr>
</table>

</body>
</html>



