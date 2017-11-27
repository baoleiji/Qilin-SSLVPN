<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
</head>
<style type="text/css">
a {
    color: #003499;
    text-decoration: none;
} 
a:hover {
    color: #000000;
    text-decoration: underline;
}
</style>
{{if $_config.LDAP }}
<script>
var foundparent = false;
var servergroup = new Array();
var i=0;
{{section name=a loop=$allsgroup}}
{{if $sgroup.id ne $allsgroup[a].id}}
servergroup[i++]={id:{{$allsgroup[a].id}},name:'{{$allsgroup[a].groupname}}',ldapid:{{$allsgroup[a].ldapid}},level:{{$allsgroup[a].level}}};
{{/if}}
{{/section}}

function changelevel(v, d){
	document.getElementById('ldapid2').options.length=0;
	{{if $logined_user_level eq 1}}
	document.getElementById('ldapid2').options[document.getElementById('ldapid2').options.length]=new Option('无', 0);
	{{/if}}
	var found = 0;	
	document.getElementById('ldapid1id').value=v;
	for(var i=0; i<servergroup.length; i++){
		if(servergroup[i].ldapid==v&&servergroup[i].level==2){
			if(d==servergroup[i].id){
				found = 1;				
				document.getElementById('ldapid2id').value=d;
				document.getElementById('ldapid2').options[document.getElementById('ldapid2').options.length]=new Option(servergroup[i].name, servergroup[i].id, true, true);
				//document.getElementById('ldapid2').options.selectedIndex = document.getElementById('ldapid2').options.length-1;
			}else{				
				document.getElementById('ldapid2').options[document.getElementById('ldapid2').options.length]=new Option(servergroup[i].name, servergroup[i].id);
			}
		}
	}
	document.getElementById('ldapid2id').value= document.getElementById('ldapid2').options.selectedIndex >= 0 ? document.getElementById('ldapid2').options[document.getElementById('ldapid2').options.selectedIndex].value : 0;
}

function changelevel2(v, d){
	document.getElementById('ldapid2id').value=v;
	return ;
	document.getElementById('level2').disabled =false;
	if(v!=0)
	document.getElementById('level2').disabled =true;
}
</script>
{{/if}}
<body>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
      <li class="me_{{if $smarty.session.RADIUSUSERLIST}}b{{else}}a{{/if}}"><img src="{{$template_root}}/images/an1{{if $smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member">用户管理</a><img src="{{$template_root}}/images/an3{{if $smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_index">设备管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=dev_group">目录管理</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=workdept">用户属性</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=systemtype">系统类型</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=sshkey">SSH公私钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_{{if $smarty.session.RADIUSUSERLIST}}a{{else}}b{{/if}}"><img src="{{$template_root}}/images/an1{{if !$smarty.session.RADIUSUSERLIST}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=radiususer">RADIUS用户</a><img src="{{$template_root}}/images/an3{{if !$smarty.session.RADIUSUSERLIST}}3{{/if}}.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordkey">密码密钥</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL eq 1}}
    <li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_member&action=online">在线用户</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul><span class="back_img"><A href="admin.php?controller=admin_member&action=usergroup&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>

            <td align="center">
<form name="f1" method=post OnSubmit='return check()' action="admin.php?controller=admin_member&action=usergroup_save&id={{$sgroup.id}}&ldapid={{$ldapid}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top class="BBtable">
	<tr><th colspan="2" class="list_bg"></th></tr>
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		组名
		</td>
		<td width="67%">
		<input type = text name="groupname" value="{{$sgroup.groupname}}">
	  </td>
	</tr>
	{{if $_config.LDAP }}
	<tr bgcolor="f7f7f7">
		<td width="33%" align=right>
		所属目录
		</td>
		<td width="67%">
		一级<select  class="wbk"  name="ldapid1_" id="ldapid1"  onchange="changelevel(this.value,0)">
				{{if $smarty.session.ADMIN_LEVEL ne 3 and $smarty.session.ADMIN_LEVEL ne 21 and $smarty.session.ADMIN_LEVEL ne 101}}
				<OPTION VALUE="0">无</option>
				{{/if}}
			{{section name=g loop=$allsgroup}}
			{{if $sgroup.id ne $allsgroup[g].id}}
			{{if $allsgroup[g].level eq 1 }}
			<OPTION VALUE="{{$allsgroup[g].id}}" {{if $allsgroup[g].id == $ldapid1}}selected{{/if}} >{{$allsgroup[g].groupname}}</option>
			{{/if}}
			{{/if}}
		{{/section}}
		</select>
		二级<select  class="wbk"  name="ldapid2_" id="ldapid2" onchange="changelevel2(this.value,0)">
		</select>
	  </td>
	</tr>
	{{/if}}
	<tr>
		<td width="33%" align=right valign="top">
		描述
		</td>
		<td width="67%">
		<textarea cols="30" rows="10"  name="description">{{$sgroup.description}}</textarea>
	  </td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit"  value=" 确    认 " class="an_06"></td>
	</tr>
	</table>
<br>
<input type="hidden" name="levelx" id="levelxid" value="{{$sgroup.level}}" />
<input type="hidden" name="ldapid1" id="ldapid1id" value="{{if $sgroup.level eq 2}}{{$sgroup.ldapid}}{{/if}}" />
<input type="hidden" name="ldapid2" id="ldapid2id" value="0" />
</form>
	</td>
  </tr>
</table>
{{if $_config.LDAP }}
<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}


function levelxx(v){
	document.getElementById('levelxid').value = v;
	document.getElementById('ldapid1').options.selectedIndex=0;
	document.getElementById('ldapid2').options.selectedIndex=0;
	if(v==1){
		document.getElementById('ldapid1').disabled = true;
		document.getElementById('ldapid2').disabled = true;
	}else if(v==2){
		document.getElementById('ldapid1').disabled = false;
		document.getElementById('ldapid2').disabled = true;
	}else{
		document.getElementById('ldapid1').disabled = false;
		document.getElementById('ldapid2').disabled = false;
	}
	document.getElementById('ldapid1id').value=document.getElementById('ldapid1').options[document.getElementById('ldapid1').options.selectedIndex].value;
	document.getElementById('ldapid2id').value=document.getElementById('ldapid2').options[document.getElementById('ldapid2').options.selectedIndex].value;
}

function check(){
	if(document.getElementById('levelxid').value==2&&document.getElementById('ldapid1id').value==0){
		alert('请选择一级目录');
		return false;
	}
	return true;
}
changelevel({{if $ldapid1}}{{$ldapid1}}{{else}}0{{/if}}, {{if $ldapid2}}{{$ldapid2}}{{else}}0{{/if}})
</script>
{{/if}}
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


