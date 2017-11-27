<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0110)https://10.11.0.1/dep/admin.php -->
<!DOCTYPE html PUBLIC "-//w3c//dtd html 4.0 transitional//en" ""><HTML><HEAD><META 
content="IE=5.0000" http-equiv="X-UA-Compatible">
 <TITLE>修改</TITLE> 
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<META name="GENERATOR" content="MSHTML 11.00.9600.17801"> 
<META name="author" content="nuttycoder"> 
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script language="javascript">
	function check_add_user(){
		return(true);
	}

var AllMember = new Array();
var i=0;
{{section name=kk loop=$allradiusmem}}
AllMember[{{$smarty.section.kk.index}}] = Array();
AllMember[{{$smarty.section.kk.index}}]['username']='{{$allradiusmem[kk].username}}';
AllMember[{{$smarty.section.kk.index}}]['uid']='{{$allradiusmem[kk].uid}}';
{{/section}}

function filter(){
	var filterStr = document.getElementById('username').value;
	var usbkeyid = document.getElementById('memberselect');
	usbkeyid.options.length=1;
	for(var i=0; i<AllMember.length;i++){
		if(filterStr.length==0 || AllMember[i]['username'].indexOf(filterStr) >= 0){
			usbkeyid.options[usbkeyid.options.length++] = new Option(AllMember[i]['username'],AllMember[i]['uid']);
		}
	}
}
function change_for_user_auth(){
	{{if $radiususer}}
	 document.getElementById('fort_user_auth').checked=true;
	 {{/if}}
	var change_user_auth = document.getElementById('fort_user_auth').checked;
	if(change_user_auth){
		document.getElementById('username').readOnly  = true;
		document.getElementById('password_confirm').readOnly  = true;
		document.getElementById('password').readOnly  = true;
		{{if empty($id)}}document.getElementById('memberselect').style.display='';{{/if}}		
	}else{
		document.getElementById('username').readOnly  = false;
		document.getElementById('password_confirm').readOnly  = false;
		document.getElementById('password').readOnly  = false;
		document.getElementById('memberselect').style.display='none';
	}
}

function usernameselect(){
	document.getElementById('username').value = (document.getElementById('memberselect').options.selectedIndex==0 ? document.getElementById('username').value : document.getElementById('memberselect').options[document.getElementById('memberselect').options.selectedIndex].text);
}

function temptyuser(check){
	if(check){
		document.getElementById('username').value='';
		//document.getElementById('password').value='';
		//document.getElementById('password_confirm').value='';
		document.getElementById('automp').checked=false;
		document.getElementById('automp2').checked=false;
		document.getElementById('publickey_auth').checked=false;
		document.getElementById('autotr').style.display='none';
		document.getElementById('publickey_authtr').style.display='none';
		document.getElementById('automutr').style.display='none';
	}else{
		document.getElementById('autotr').style.display='';
		document.getElementById('publickey_authtr').style.display='';
		document.getElementById('automutr').style.display='';
	}
}

function searchit(){
	var url = "admin.php?controller=admin_reports&action=cmdlistreport_ips";
	url += "&webuser="+document.f1.webuser.value;
	{{if $_config.LDAP}}
	{{if $_config.TREEMODE}}
	var obj1=document.getElementById('groupid1');	
	gid=obj1.value;
	{{else}}
	for(var i=1; true; i++){
		var obj=document.getElementById('groupid'+i);
		if(obj!=null&&obj.options.selectedIndex>-1){
			gid=obj.options[obj.options.selectedIndex].value;
			continue;
		}
		break;
	}
	{{/if}}
	url += "&servergroup="+gid;
	{{/if}}
	window.location.href= url;
	return false;
}

{{if $_config.LDAP}}
var foundparent = false;
var servergroup = new Array();
var i=0;
{{section name=a loop=$allsgroup}}
servergroup[i++]={id:{{$allsgroup[a].id}},name:'{{$allsgroup[a].groupname}}',ldapid:{{$allsgroup[a].ldapid}},level:{{$allsgroup[a].level}}};
{{/section}}

function changelevel(v, d){
	document.getElementById('ldapid2').options.length=0;
	{{if $logined_user_level eq 1}}
	document.getElementById('ldapid2').options[document.getElementById('ldapid2').options.length]=new Option('无', 0);
	{{/if}}
	var found = 0;
	for(var i=0; i<servergroup.length; i++){
		if(servergroup[i].ldapid==v&& servergroup[i].level==2){
			if(d==servergroup[i].id){
				found = 1;
				document.getElementById('ldapid2').options[document.getElementById('ldapid2').options.length]=new Option(servergroup[i].name, servergroup[i].id, true, true);
			}else{				
				document.getElementById('ldapid2').options[document.getElementById('ldapid2').options.length]=new Option(servergroup[i].name, servergroup[i].id);
			}
		}
	}
	
	document.getElementById('servergroup').options.length=0;
	{{if $logined_user_level }}
	document.getElementById('servergroup').options[document.getElementById('servergroup').options.length]=new Option('无', 0);
	{{/if}}
	var found = 0;
	var class2_i = 0;
	var class2 = new Array();
	for(var i=0; i<servergroup.length; i++){
		if(servergroup[i].ldapid==v&& servergroup[i].level==0){
			if(d==servergroup[i].id){
				found = 1;
				document.getElementById('servergroup').options[document.getElementById('servergroup').options.length]=new Option(servergroup[i].name, servergroup[i].id, true, true);
			}else{				
				document.getElementById('servergroup').options[document.getElementById('servergroup').options.length]=new Option(servergroup[i].name, servergroup[i].id);
			}
		}
		if(servergroup[i].ldapid==v && servergroup[i].level==2){
			class2[class2_i++]=i;
		}
	}/*
	for(var j=0; j<class2.length; j++){
		for(var i=0; i<servergroup.length; i++){
			if(servergroup[i].ldapid==servergroup[class2[j]].id&& servergroup[i].level==0){
				if(d==servergroup[i].id){
					found = 1;
					document.getElementById('servergroup').options[document.getElementById('servergroup').options.length]=new Option(servergroup[i].name, servergroup[i].id, true, true);
				}else{				
					document.getElementById('servergroup').options[document.getElementById('servergroup').options.length]=new Option(servergroup[i].name, servergroup[i].id);
				}
			}
		}
	}*/
	//changelevel2(found,0);
}

function changelevel2(v, d){
	document.getElementById('servergroup').options.length=0;
	{{if $logined_user_level }}
	document.getElementById('servergroup').options[document.getElementById('servergroup').options.length]=new Option('无', 0);
	{{/if}}
	if(v!=0){
		for(var i=0; i<servergroup.length; i++){
			if(servergroup[i].ldapid==v&& servergroup[i].level==0){
				if(d==servergroup[i].id){
					found = 1;
					document.getElementById('servergroup').options[document.getElementById('servergroup').options.length]=new Option(servergroup[i].name, servergroup[i].id, true, true);
				}else{				
					document.getElementById('servergroup').options[document.getElementById('servergroup').options.length]=new Option(servergroup[i].name, servergroup[i].id);
				}
			}
		}
	}else{
		changelevel(document.getElementById('ldapid1').options[document.getElementById('ldapid1').options.selectedIndex].value, d);
	}
}
{{/if}}
</script>
 
<STYLE type="text/css">
a {
    color: #003499;
    text-decoration: none;
} 
a:hover {
    color: #000000;
    text-decoration: underline;
}
</STYLE>
 
<SCRIPT language="javascript" src="js/selectdate.js"></SCRIPT>
</HEAD>  
<BODY>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <TD height="33" class="main_content" colspan="3"><FORM name="f1" action="admin.php?controller=admin_reports&amp;action=cmdlistreport_ips" 
            method="post">
        资源组：{{if $_config.LDAP}}
		<select style="width:150px;" class="wbk"  name="ldapid1" id="ldapid1" onchange="changelevel(this.value,0)">
		{{if $smarty.session.ADMIN_LEVEL ne 3 and $smarty.session.ADMIN_LEVEL ne 21 and $smarty.session.ADMIN_LEVEL ne 101}}
		<OPTION VALUE="0">无</option>
		{{/if}}
		{{section name=g loop=$allsgroup}}
			{{if $allsgroup[g].level eq 1 }}
			<OPTION VALUE="{{$allsgroup[g].id}}" {{if $allsgroup[g].id == $ldapid1}}selected{{/if}}>{{$allsgroup[g].groupname}}</option>
			{{/if}}
		{{/section}}
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		<select style="width:150px;"  class="wbk"  name="ldapid2" id="ldapid2" onchange="changelevel2(this.value,0)">
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		{{/if}}		<select  style="width:150px;" class="wbk"  name="g_id" id="servergroup">
				<option value="0" >无</option>
		{{section name=g loop=$allgroup}}
		{{if $allgroup[g].level eq 0}}
		{{if !$_config.LDAP or ($_config.LDAP and $allgroup[g].ldapid eq 0)}}
			<OPTION VALUE="{{$allgroup[g].id}}" {{if $allgroup[g].id == $g_id}}selected{{/if}}>{{$allgroup[g].groupname}}</option>
		{{/if}}
		{{/if}}
		{{/section}}
		</select>
        IP过滤
        <INPUT name="webuser" class="wbk" type="text" style="width: 60px;">
        &nbsp;&nbsp;
        <INPUT class="bnnew2" onClick="return searchit();" type="button" value=" 提 交 ">
      </FORM></TD>
  </tr>
      <TBODY>
      <FORM name="f2" onSubmit="javascript:saveAccount=false;" action="admin.php?controller=admin_reports&amp;action=docmdlistreport_ips" 
        enctype="multipart/form-data" method="post">
  <tr>
    <TD height="33" colspan="3"><TABLE width="100%" align="center" class="BBtable" bgcolor="#ffffff" 
      border="0" cellspacing="0" cellpadding="5">
      <TR>
        <TD width="10%" align="right">主机名</TD>
        <TD><TABLE width="100%">
            <TBODY>
              {{section name=u loop=$ips}}
                <TD width="180"><INPUT name="Check[]" type="checkbox" {{$ips[u].check}} value="{{$ips[u].device_ip}}">{{$ips[u].device_ip}}({{$ips[u].hostname}})</TD>
			  {{if ($smarty.section.u.index+1)%5 eq 0}}
			  </tr><tr>
			  {{/if}}
			  {{/section}}
            </TBODY>
        </TABLE></TD>
      </TR>
    </TABLE></TD>
  </tr>
  <tr>
    <TD height="33" colspan="3" align="center"><INPUT class="an_02" type="submit" value="确 定"></TD>
  </tr>
      </FORM>
</table>
<SCRIPT type="text/javascript">
var saveAccount = false;
function saveTitle(e){
	if(saveAccount){
		//alert("绑定信息需要点击'保存修改'才能存盘");
		return  e.returnValue='绑定信息需要点击 保存修改 才能存盘,你真的要不保存离开吗？';
		
	}
	return true;
}
function setSave(){
	saveAccount=true;
}

</SCRIPT>
<script type="text/javascript">
{{if $_config.LDAP}}
{{if $ldapid1 or $ldapid2 or $g_id}}
changelevel({{if $ldapid1}}{{$ldapid1}}{{else}}0{{/if}}, {{if $ldapid2}}{{$ldapid2}}{{else}}0{{/if}});
changelevel2({{if $ldapid2}}{{$ldapid2}}{{else}}0{{/if}}, {{$g_id}});
{{/if}}
{{/if}}
</SCRIPT>
</BODY></HTML>
