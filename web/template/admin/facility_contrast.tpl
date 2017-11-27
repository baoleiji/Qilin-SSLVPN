<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script>
	function my_confirm(str){
		if(!confirm("确认要" + str + "？"))
		{
			window.event.returnValue = false;
		}
	}
	function chk_form(){
		for(var i = 0; i < document.facility_list.elements.length;i++){
			var e = document.facility_list.elements[i];
			if(e.name == 'chk_facility[]' && e.checked == true)
				return true;
		}
		alert("您没有{{$language.select}}任何{{$language.device}}！");
		return false;
	}
</script>
</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$language.device}}{{$language.manage}}——{{$language.device}}{{$language.Detail}}{{$language.Record}}</td>
  </tr>
  <tr>
	<td class=""><table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%" class="BBtable">
			<tr>
				<th class="list_bg"  width="20%">检查{{$language.day}}期</th>
				<th class="list_bg"  width="10%">{{$language.Configure}}名称</th>
				{{if $mtime !=''}}<th class="list_bg"  width="20%">{{$language.ChangeTime}}</th>{{/if}}
				<th class="list_bg"  width="80%">{{$language.Detail}}对比</th>
			</tr>
			<tr>
				<td>{{$config_date}}</td>
				<td>{{$config_name}}</td>
				{{if $mtime != ''}}<td><a href="admin.php?controller=admin_session&time={{$mtime}}&command={{$config_name}}">{{$mtime}}</a></td>{{/if}}
				<td>
				{{$result}}
				</td>
			</tr>
			<tr>
			<td colspan="4" align="center">
			{{if $admin_level == 1}}
			{{if $config_type != 'Tripwire{{$language.File}}'}}
			<a href="admin.php?controller=admin_facility&action=cover&fid={{$fid}}&chid={{$chid}}">{{$language.UpdateReference}}{{$language.File}}</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			{{/if}}
			{{/if}}
			<a href="admin.php?controller=admin_facility&action=detail&fid={{$fid}}&back=1"  ><img src="{{$template_root}}/images/back.png" width="50" border=0 width="60" /></a>
			</td>
			</tr>
		</table>
	</td>
  </tr>
</table>

	
</body>
</html>


