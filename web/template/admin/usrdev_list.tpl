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
		for(var i = 0; i < document.dev_list.elements.length;i++){
			var e = document.dev_list.elements[i];
			if(e.name == 'chk_member[]' && e.checked == true)
				return true;
		}
		alert("您没有{{$language.select}}任何{{$language.User}}！");
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
			  <td background="{{$template_root}}/images/main_bg1.gif" class="main_title">{{$language.User}}{{$language.manage}}——{{$language.User}}可{{$language.View}}{{$language.DevicesList}}</td>
			  
			  
			  <td width="2"><img src="{{$template_root}}/images/main_right.gif" width="2" height="31"></td>
			</tr>
		  </table></td>
	  </tr>
	  <tr>
		<td class="main_content">
			<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
	<form name="dev_list" action="admin.php?controller=admin_dev&action=modify_all&uid={{$uid}}" method="post">
				<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
					<tr>
						<th class="list_bg"  width="3%">{{$language.select}}</th>
						<th class="list_bg"  width="77%">ip</th>
					</tr>
					{{section name=t loop=$alldev}}
					<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
						<td><input type="checkbox" name="chk_member[]" value="{{$alldev[t].did}}" {{if $alldev[t].occupied ==1}}checked{{/if}}></td>
					
						<td>{{$alldev[t].ip}}</td>
					</tr>
					{{/section}}
					<tr>
						<td colspan="8" align="left">
							<input name="select_all" type="checkbox" onclick="javascript:for(var i=0;i<this.form.elements.length;i++){var e=this.form.elements[i];if(e.name=='chk_member[]')e.checked=this.form.select_all.checked;}" value="checkbox">{{$language.select}}{{$language.this}}{{$language.page}}{{$language.displayed}}的{{$language.All}}{{$language.device}}&nbsp;&nbsp;<input type="submit"  value="批量{{$language.Edit}}{{$language.device}}" onclick="document.dev_list.action='admin.php?controller=admin_dev&action=modify_all&uid={{$uid}}';" class="an_02">
						</td>
					</tr>
				
			</form>
				</table>
			</table>
		</td>
	  </tr>
	</table>
	
</body>
</html>


