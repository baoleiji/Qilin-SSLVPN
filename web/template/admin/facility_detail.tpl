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
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
			<form action="admin.php?controller=admin_facility&action=del_dir&fid={{$fid}}" method="post" name="detail">
			<tr>
				<th class="list_bg"  width="10%">{{$language.Delete}}</th>
				<th class="list_bg"  width="10%">检查{{$language.day}}期</th>
				<th class="list_bg"  width="15%">改变的{{$language.Configure}}数</th>
				<th class="list_bg"  width="75%">改变的{{$language.Configure}}{{$language.List}}</th>
			</tr>
			{{section name=t loop=$config}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td><input name="chk_delete[]" value="{{$config[t].date}}" type="checkbox" /></td>
				<td>{{$config[t].date}}</td>
				<td>{{$config[t].num}}</td>
				<td>
				{{section name=i loop=$config[t].list}}
				<a href="admin.php?controller=admin_facility&action=contrast&chid={{$config[t].list[i].id}}&date={{$config[t].date}}&fid={{$fid}}">{{$config[t].list[i].config}}</a><br/>
				{{/section}}
				</td>
			</tr>
			{{/section}}
			<tr>
				<td colspan="4" align="center">
				{{if $admin_level == 1}}<a href="#" onclick="javascript:document.detail.submit()">{{$language.Delete}}{{$language.select}}</a>&nbsp;{{/if}}
				<a href="admin.php?controller=admin_facility"><img src="{{$template_root}}/images/back.png" width="50" border=0 width="60" /></a>
				</td>
			</td>
			</form>
		</table>
	</td>
  </tr>
</table>

</body>
</html>


