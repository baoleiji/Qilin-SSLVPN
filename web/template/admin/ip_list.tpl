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
		for(var i = 0; i < document.ip_list.elements.length;i++){
			var e = document.ip_list.elements[i];
			if(e.name == 'chk_ip[]' && e.checked == true)
				return true;
		}
		alert("您没有选择任何IP！");
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
			  <td background="{{$template_root}}/images/main_bg1.gif" class="main_title">IP管理——IP列表</td>
			  
			  
			  <td width="2"><img src="{{$template_root}}/images/main_right.gif" width="2" height="31"></td>
			</tr>
		  </table></td>
	  </tr>
	  <tr>
		<td class="main_content">
			<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
	<form name="ip_list" action="admin.php?controller=admin_config&action=delete_all_ip" method="post">
				<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
						<th class="list_bg"  width="3%">选择</th>
						<th class="list_bg"  width="55%">IP</th>
						<th class="list_bg"  width="10%" >操作链接</th>
					</tr>
					{{section name=t loop=$ip}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><input type="checkbox" name="chk_ip[]" value="{{$ip[t].id}}"></td>
						<td align="center">{{$ip[t].ip}}</td>
						<td align="center"><img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_config&action=delete_ip&id={{$ip[t].id}}">删除</a></td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="4" align="right">
							<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_ip[]')e.checked=this.form.select_all.checked;}" value="checkbox">选中本页显示的所有项目&nbsp;&nbsp;<input type="submit"  value="批量删除所选IP" onclick="my_confirm('删除所选IP');if(chk_form()) document.ip_list.action='admin.php?controller=admin_config&action=delete_all_ip'; else return false;" class="an_02">
						</td>
					</tr>
					{{if $ipcount != 10}}
					<tr>
						<th class="list_bg"  width="15%" colspan="4">增加新IP</th>
					</tr>									<tr>
						<td align="center" colspan= "4">
							
						请录入新IP:&nbsp;&nbsp;<input type="text" class="wbk" name="newip" >
						</td>
					</tr>
					<tr>
						
					<td colspan="4" align="center">
							
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="add" value="增加新IP" onclick="document.ip_list.action='admin.php?controller=admin_config&action=add_ip'"  >
						</td>					
					</tr>
				{{/if}}
				</form>
				</table>
			</table>
		</td>
	  </tr>
	</table>

</body>
</html>



