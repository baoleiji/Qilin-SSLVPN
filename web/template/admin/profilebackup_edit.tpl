<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$language.Master}}{{$language.page}}面</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="hui_bj">{{$language.Configure}}{{$language.File}}</td>
  </tr>
  <tr>
	<td class="main_content">
		<table bordercolor="white" cellspacing="1" cellpadding="5" border="0" width="100%"  class="BBtable">
		<form name="f1" method=post action="admin.php?controller=admin_pro&action=profilebackup_save">	
	{{*<tr bgcolor="f7f7f7">
		<td width="33%" align=left>
		{{$language.Server}}{{$language.LoginMethod}}		
		</td>
		<td width="67%">
		<select  class="wbk"  name="type_id" id="type_id" onchange="selecttype()">
		<option value="">{{$language.Pleaseselect}}{{$language.System}}{{$language.LoginMethod}}</option>
		{{section name=g loop=$alltype}}
			<OPTION VALUE="{{$alltype[g].id}}" {{if $alltype[g].id == $type_id}}selected{{/if}}>{{$alltype[g].device_type}}</option>
		{{/section}}
		</select>
	  </td>
	</tr>
	*}}
	{{if $device_type eq 'cisco' || $device_type eq 'huawei'  }}
	<tr bgcolor="#F3F8FC" id="selectconfig" style="display:none">
		<td width="33%" align=left>
		{{$language.Pleaseselect}}{{$language.Configure}}		
		</td>
		<td width="67%">
		<select  class="wbk"  name="configfile" id="configfile" >
		<option value="">{{$language.Pleaseselect}}</option>
		<option value="run">运行{{$language.Configure}}</option>
		<option value="start">存盘{{$language.Configure}}</option>
		
		</select>
	  </td>
	</tr>
	{{elseif $device_type eq 'linux' || $device_type eq 'hp-ux' || $device_type eq 'aix' || $device_type eq 'solaris'  }}
	<tr bgcolor="#F3F8FC" id="inputconfig" >
		<td width="33%" align=left>{{$language.PleaseInputconfigurefile}}</td>
		<td width="67%">
		<input type="text" class="wbk" id="configfile" name="configfile" value="" />
	  </td>
	</tr>
	{{else}}
	
	<script language='javascript'>alert('暂不支持');history.go(-1);</script>
	
	{{/if}}
	<tr>
			<td colspan="2" align="center">
				<input type="submit"  onclick="return checkconfigfile();" value="{{$language.Save}}">
			</td>
	</tr>

	</table>
	<input type="hidden" name="device_id" value="{{$device_id}}">
</form>
		</table>
	</td>
  </tr>
</table>


<script language="javascript">

function selecttype(){
	var devtype = new Array();
	var devid = document.getElementById('type_id').options[document.getElementById('type_id').options.selectedIndex].value;
	{{section name=gg loop=$alltype}}
	devtype[{{$alltype[gg].id}}] = '{{$alltype[gg].device_type}}';
	{{/section}}
		//alert(devtype[devid].toLocaleLowerCase());
	var devtypes = devtype[devid].toLocaleLowerCase();
	
	if(devtypes=='cisco' || devtypes=='huawei'){
		document.getElementById('selectconfig').style.display = 'inline';
		document.getElementById('inputconfig').style.display = 'none';
	}else if(devtypes=='linux' || devtypes=='hp-ux' || devtypes=='aix' || devtypes=='soalris'){
		document.getElementById('selectconfig').style.display = 'none';
		document.getElementById('inputconfig').style.display = 'inline';
	}else{
		alert('抱歉,暂不支持');
	}
}

function checkconfigfile(){
	if(document.getElementById('selectconfig').style.display=='inline'){
		var selectvalue = document.getElementById('configfile1').options[document.getElementById('configfile1').options.selectedIndex].value;
		if(selectvalue.length==0){
			alert("抱歉,{{$language.Pleaseselect}}{{$language.Configure}}项");
			return false;
		}
		document.getElementById('configfile').value = selectvalue;
	}else{
		var inputvalue = document.getElementById('configfile2').value;
		if(inputvalue.length==0){
			alert("抱歉,请请{{$language.Input}}{{$language.Configure}}{{$language.File}}");
			return false;
		}
		document.getElementById('configfile').value = inputvalue;
	}
	return true;
}

</script>
</body>
</html>


