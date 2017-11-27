<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
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
    <td  class="hui_bj">{{$language.SessionAudit}}——{{$language.SessionsList}}</td>
  </tr>
  <tr>
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
			<form name="templet" action="admin.php?controller=admin_facility&action=templet_del&tid={{$tid}}" method="post">
			<tr>
				<th class="list_bg"  colspan="2" align="center"><strong>监控的{{$language.Configure}}{{$language.List}}</strong></td>
			</tr>
{{section name=i loop=$templet}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td><input type="checkbox" name="chk_delete[]" value="{{$templet[i].cid}}"></td>
				<td>
					{{$templet[i].name}}{{if $templet[i].name=='Linux{{$language.Configure}}{{$language.File}}'}}：{{$templet[i].attributes}}{{/if}}{{if $templet[i].name=='Tripwire{{$language.File}}'}}：{{$templet[i].attributes}}{{/if}}
				</td>
			</tr>
{{/section}}
			<tr align="center">
				<td colspan="2"><input name="submit" type="submit" value="{{$language.Delete}}{{$language.select}}"></td>
			</tr>
			</form>
			
			<tr>
				<th class="list_bg"  colspan="2" align="center"><strong>{{$language.new}}增要监控的{{$language.Configure}}</strong></td>
			</tr>

			<form name="templet_add" action="admin.php?controller=admin_facility&action=templet_add&tid={{$tid}}" method="post">
			<tr>
				<td colspan="2" align="center">
					<select  class="wbk"  name="config_type" id="config_type" onchange="if(document.getElementById('config_type').value != 'Linux{{$language.Configure}}{{$language.File}}' && document.getElementById('config_type').value != 'Tripwire{{$language.File}}') {document.getElementById('path').style.display='none';} else {document.getElementById('path').style.display='inline';}">
					{{section name=t loop=$config_type}}
					{{if $tid|isin:$config_type[t].facility}} 
					<option value="{{$config_type[t].name}}">{{$config_type[t].name}}</option>
					{{/if}}
					{{/section}}
					</select>
					<div id="path" style="display:inline">
						{{$language.Configure}}{{$language.File}}路径：<input name="path" value="" type="text" class="wbk" />
					</div>
					<script language="javascript">
						if(document.getElementById('config_type').value != 'Linux{{$language.Configure}}{{$language.File}}' && document.getElementById('config_type').value != 'Tripwire{{$language.File}}') {document.getElementById('path').style.display='none';}
					</script>
				</td>
			</tr>
			<tr align="center">
				<td colspan="2"><input name="submit" type="submit"  value="{{$language.new}}增" class="an_02"><input type="submit" name="Submit3" value="" class="an_03"/ class="an_02"></td>
			</tr>
			</form>
		</table>
	</td>
  </tr>
</table>

	
</body>
</html>


