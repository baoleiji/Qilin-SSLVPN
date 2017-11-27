<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/Calendarandtime.js"></script>
</head>

<body>
 <FORM name="f1" onSubmit="return check()" action="admin.php?controller=admin_pro&action=resourcegrp_selgroup_save" 
            method="post">

              <TABLE width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" valign="top"  class="BBtable">
                <TBODY>
				{{assign var="trnumber" value=0}}
					<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD colspan="2" class="list_bg">设置</TD>
                  </TR>
                  <TR id="autosutr"  {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">{{$language.automaticallyloginassuperadministrator}}</TD>
                    <TD><INPUT id="autosu" {{if $lgroup.autosu == 1}} checked {{/if}} type=checkbox name=autosu value="on">                      </TD>
                  </TR>
                  <TR id="autosutr" {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">{{$language.syslogAlertwhenloginin}}</TD>
                    <TD><INPUT id="syslogalert" {{if $lgroup.syslogalert == 1}} checked {{/if}} type=checkbox name=syslogalert value="on">                  </TD>
                  </TR>
                  <TR id="autosutr"  {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">{{$language.mailalertwhenloginin}}</TD>
                    <TD><INPUT id="mailalert" {{if $lgroup.mailalert == 1}} checked {{/if}} type=checkbox name=mailalert value="on">              </TD>
                  </TR>
                  <TR id="autosutr" {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">{{$language.accountlocked}} </TD>
                    <TD><INPUT id="loginlock" {{if $lgroup.loginlock == 1}} checked {{/if}} type=checkbox name=loginlock value="on">                    </TD>
                  </TR>
				  {{*
                  <TR id="autosutr"  {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">磁盘映射 </TD>
                    <TD><INPUT id="loginlock" {{if $lgroup.rdpdiskauth_up == 1}} checked {{/if}} type=checkbox name=rdpdiskauth_up value="on">                </TD>
                  </TR>
                  <TR id="autosutr"  {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">剪切板上行 </TD>
                    <TD><INPUT id="loginlock" {{if $lgroup.rdpclipauth_up == 1}} checked {{/if}} type=checkbox name=rdpclipauth_up value="on">           </TD>
                  </TR>
				    <TR id="autosutr"  {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">剪切板下行 </TD>
                    <TD><INPUT id="loginlock" {{if $lgroup.rdpclipauth_down == 1}} checked {{/if}} type=checkbox name=rdpclipauth_down value="on">           </TD>
                  </TR>
                 *}}
                  <TR {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">命令权限 </TD>
                    <TD><select  class="wbk"  name=forbidden_commands_groups>
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=f loop=$allforbiddengroup}}
				<option value="{{$allforbiddengroup[f].gname}}" {{if $allforbiddengroup[f].gname == $lgroup.forbidden_commands_groups}}selected{{/if}}>{{$allforbiddengroup[f].gname}}({{if $allforbiddengroup[f].black_or_white eq 1}}白名单{{elseif $allforbiddengroup[f].black_or_white eq 3}}授权命令{{else}}黑名单{{/if}})</option>
			{{/section}}
                  </SELECT>      </TD>
                  </TR>
				  <TR {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">登录规则 </TD>
                    <TD><select name="restrictacl" id="restrictacl" >
					<option value="" >所有</option>
					{{section name=a loop=$acl}}
					<option value="{{$acl[a].id}}" {{if $lgroup.restrictacl eq $acl[a].id}}selected{{/if}}>{{$acl[a].aclname}}</option>
					{{/section}}
					</select> </TD>
                  </TR>
				  <TR  {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">双人授权 </TD>
                    <TD><INPUT id="twoauth" {{if $lgroup.twoauth == 1}} checked {{/if}} type=checkbox onclick="checktwo(this.checked);" name=twoauth value="on">      </TD>
                  </TR>
				  <TR bgcolor="" id="wf_2" {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">登录短信告警</TD>
                    <TD><INPUT id="smsalert" {{if $lgroup.smsalert == 1}} checked {{/if}} type=checkbox name=smsalert value="on">           </TD>
                  </TR>
				  <TR bgcolor="" id="wf_2" {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">流程审批</TD>
                    <TD><INPUT id="workflow" onclick="sworkflow(this.checked);" {{if $lgroup.workflow == 1}} checked {{/if}} type=checkbox name=workflow value="on">           </TD>
                  </TR>
				  <TR  {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id=tr_wf_user1>
                    <TD width="50%" align="right">审批人一 </TD>
                    <TD><select  class="wbk"  name=wf_user1 id=wf_user1 >
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=w loop=$webusers}}
				<option value="{{$webusers[w].uid}}" {{if $webusers[w].uid == $lgroup.wf_user1}}selected{{/if}}>{{$webusers[w].username}}</option>
			{{/section}}
                  </SELECT>       </TD>
                  </TR>
				  <TR id=tr_wf_user2 {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">审批人二 </TD>
                    <TD><select  class="wbk"  name=wf_user2 id=wf_user2>
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=w loop=$webusers}}
				<option value="{{$webusers[w].uid}}" {{if $webusers[w].uid == $lgroup.wf_user2}}selected{{/if}}>{{$webusers[w].username}}</option>
			{{/section}}
                  </SELECT>       </TD>
                  </TR>
				  <TR  {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id=tr_wf_user3>
                    <TD width="50%" align="right">审批人三 </TD>
                    <TD><select  class="wbk"  name=wf_user3 id=wf_user3>
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=w loop=$webusers}}
				<option value="{{$webusers[w].uid}}" {{if $webusers[w].uid == $lgroup.wf_user3}}selected{{/if}}>{{$webusers[w].username}}</option>
			{{/section}}
                  </SELECT>       </TD>
                  </TR>
				  <TR id=tr_wf_user4 {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="50%" align="right">审批人四 </TD>
                    <TD><select  class="wbk"  name=wf_user4 id=wf_user4>
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=w loop=$webusers}}
				<option value="{{$webusers[w].uid}}" {{if $webusers[w].uid == $lgroup.wf_user4}}selected{{/if}}>{{$webusers[w].username}}</option>
			{{/section}}
                  </SELECT>       </TD>
                  </TR>
				  <TR  {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}} id=tr_wf_user5>
                    <TD width="50%" align="right">审批人五 </TD>
                    <TD><select  class="wbk"  name=wf_user5 id=wf_user5>
                      <OPTION value="">{{$language.no}}</OPTION>
                     	{{section name=w loop=$webusers}}
				<option value="{{$webusers[w].uid}}" {{if $webusers[w].uid == $lgroup.wf_user5}}selected{{/if}}>{{$webusers[w].username}}</option>
			{{/section}}
                  </SELECT>       </TD>
                  </TR>
                  <TR>
                    <TD colspan="2" align="center"><INPUT class="an_02" type="submit" value="保存修改"></TD>
                  </TR>
                </TBODY>
              </TABLE>
<input type="hidden" name="id" value="{{$lgroup.id}}" />
<input type="hidden" name="gid" value="{{$gid}}" />
<input type="hidden" name="sid" value="{{$sid}}" />
<input type="hidden" name="sessionlgroup" value="{{$sessionlgroup}}" />
</FORM>


<script>
function sworkflow(checked){
	if(checked){
		for(var i=1; i<=5; i++){
			document.getElementById('tr_wf_user'+i).style.display = '';
		}
	}else{
		for(var i=1; i<=5; i++){
			document.getElementById('tr_wf_user'+i).style.display = 'none';
		}
	}
}
var success = true;
function checkwfuser(user, b){
	success = true;
	checkwfuser1(user,b);
	return success;
}
function checkwfuser1(user, b){
	if(document.getElementById('wf_user'+user).options[document.getElementById('wf_user'+user).options.selectedIndex].value > 0){
		b = true;
		if(user-1>0){
			if(checkwfuser1(user-1, b)==false&&b){
				success = false;
				alert('请选择流程批准人'+(user-1));
				return false;
			}
		}
		return true;
	}
	if(user-1>0&&b==false){
		checkwfuser1(user-1, b);
	}
	return false;
}
function checktwo(c){
  if(c){
	document.getElementById('workflow').checked = true;
	sworkflow(true);
  }
}
sworkflow({{if !$luser.workflow}}false{{else}}true{{/if}});
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


