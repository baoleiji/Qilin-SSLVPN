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
		for(var i = 0; i < document.member_list.elements.length;i++){
			var e = document.member_list.elements[i];
			if(e.name == 'chk_member[]' && e.checked == true)
				return true;
		}
		alert("您没有选择任何用户！");
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
			  <td background="{{$template_root}}/images/main_bg1.gif" class="main_title">用户管理——用户列表</td>
			  
			  
			  <td width="2"><img src="{{$template_root}}/images/main_right.gif" width="2" height="31"></td>
			</tr>
		  </table></td>
	  </tr>
	  <tr>
		<td class="main_content">
			<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
	<form name="member_list" action="admin.php?controller=admin_passwd&action=delete_all" method="post">
				<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
						<th class="list_bg"  width="3%">选择</th>
						<th class="list_bg"  width="15%">用户名</th>
						<th class="list_bg"  width="10%" >操作链接</th>
					</tr>
					{{section name=t loop=$allmember}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><input type="checkbox" name="chk_member[]" value="{{$allmember[t].uid}}"></td>
						<td>{{$allmember[t].username}}</td>
						<td align="center"><img src="{{$template_root}}/images/ckico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_passwd&action=edit&uid={{$allmember[t].uid}}">修改密&nbsp;&nbsp;码</a> | <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_passwd&action=delete&uid={{$allmember[t].uid}}">删除</a></td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="8" align="left">
							<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">选择本页显示的所有用户&nbsp;&nbsp;<input type="submit"  value="批量删除所选用户" onclick="my_confirm('删除所选用户');if(chk_form()) document.member_list.action='admin.php?controller=admin_passwd&action=delete_all'; else return false;" class="an_02">
						</td>
					</tr>
				
			</form>
					<tr>
						<td colspan="8" align="left">
							共{{$total}}个用户  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个用户/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_passwd&page='+this.value;">页
						</td>
					</tr>
				</table>
			</table>
		</td>
	  </tr>
	</table>
	
</body>
</html>



