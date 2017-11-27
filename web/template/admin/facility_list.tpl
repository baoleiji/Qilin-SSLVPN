<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>主页面</title>
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
		alert("您没有选择任何设备！");
		return false;
	}
</script>
</head>

<body>

	


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="22"><img src="{{$template_root}}/images/main_left.gif" width="22" height="31"></td>
			  <td background="{{$template_root}}/images/main_bg1.gif" class="main_title">设备管理——设备列表</td>
			  
			  
			  <td width="2"><img src="{{$template_root}}/images/main_right.gif" width="2" height="31"></td>
			</tr>
		  </table></td>
	  </tr>
	  <tr>
		<td class="main_content">
			<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
	<form name="facility_list" action="admin.php?controller=admin_facility&action=delete_all" method="post">
				<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
						<th class="list_bg"  width="3%">选择</th>
						<th class="list_bg"  width="8%">设备名</th>
						<th class="list_bg"  width="8%">设备类型</th>
						<th class="list_bg"  width="12%">增加时间</th>
						<th class="list_bg"  width="12%">最后更新时间</th>
						<th class="list_bg"  width="12%">最后改变时间</th>
						<th class="list_bg"  width="18%">操作链接</th>
					</tr>
					{{section name=t loop=$allfacility}}
					<tr {{if $allfacility[t].alert == true}}bgcolor="red"{{elseif $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><input type="checkbox" name="chk_facility[]" value="{{$allfacility[t].fid}}"></td>
						<td>{{$allfacility[t].name}}</td>
						<td>{{$allfacility[t].type}}</td>
						<td>{{$allfacility[t].addtime}}</td>
						<td>{{$allfacility[t].updatetime}}</td>
						<td>{{$allfacility[t].lastchangetime}}</td>
						<td align="center">{{if $admin_level == 1}}<a href="admin.php?controller=admin_facility&action=edit&blank1=1&blank2=1&fid={{$allfacility[t].fid}}">修改</a> | <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_facility&action=delete&fid={{$allfacility[t].fid}}">删除</a> | {{/if}}<img src="{{$template_root}}/images/ckico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_facility&action=detail&fid={{$allfacility[t].fid}}">详细信息</a>{{if $admin_level == 1}} | <a href="admin.php?controller=admin_facility&action=update&fid={{$allfacility[t].fid}}">更新</a>{{/if}}</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="8" align="left">
							<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_facility[]')e.checked=this.form.select_all.checked;}" value="checkbox">选择本页显示的所有设备&nbsp;&nbsp;{{if $admin_level == 1}}<input type="submit"  value="批量删除所选设备" onclick="my_confirm('批量删除所选设备');if(chk_form()) document.facility_list.action='admin.php?controller=admin_facility&action=delete_all'; else return false;" class="an_02">{{/if}}
						</td>
					</tr>
				
			</form>
					<tr>
						<td colspan="8" align="left">
							共{{$total}}个设备  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个设备/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_facility&page='+this.value;">页
						</td>
					</tr>
				</table>
			</table>
		</td>
	  </tr>
	</table>

</body>
</html>



