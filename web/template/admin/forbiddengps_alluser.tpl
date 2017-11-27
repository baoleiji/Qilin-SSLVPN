<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Black}}{{$language.group}}{{$language.List}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>

<body>



	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$language.CommandsManager}}——{{$language.Detail}}</td>
  </tr>

  <tr>
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
			<tr>
				<td>{{$language.User}}{{$language.select}}:<br />
				{{section name=g loop=$allmem}}
		<input onclick="setmember({{$allmem[g].uid}});" type="radio" name='Check{{$smarty.section.g.index}}' value='{{$allmem[g].uid}}'  {{$allmem[g].check}}>{{$allmem[g].username}}{{if ($smarty.section.g.index +1) % 5 == 0}}<br/>{{/if}}
		{{/section}}
				</td>
			</tr>
			<tr>
				<td>{{$language.Time}}{{$language.List}}:<br />
				<select  class="wbk"  name=weektime id=weektime>
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=k loop=$weektime}}
				<option value="{{$weektime[k].policyname}}" {{if $weektime[k].policyname == $member.weektime}}selected{{/if}}>{{$weektime[k].policyname}}</option>
			{{/section}}
                  </SELECT>
				</td>
			</tr>
			<tr><td><input type="button" onclick="return goto()" value="{{$language.NextStep}}" /></td></tr>
			<input type="hidden" name="selectedmember" id="selectedmember" value="" />
		</table>
	</td>
  </tr>
</table>
<script>
function setmember(uid){
	document.getElementById('selectedmember').value=uid;
}
function goto(){
	var uid=document.getElementById('selectedmember').value;
	if(!/^[0-9]+$/.test(uid)){
		alert("{{$language.Pleaseselect}}{{$language.User}}");
		return false;
	}
	url = 'admin.php?controller=admin_forbidden&action=protect_group&uid='+uid+'&f_gid={{$gid}}&weektime='+document.getElementById('weektime').options[document.getElementById('weektime').selectedIndex].value;
	location.href=url
	return true;	
}
</script>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


