<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>路由列表</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
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
{{if $_config.LDAP}}
<script>
{{*
var servergroup = new Array();
var usergroup = new Array();
var i=0;
{{section name=a loop=$allsgroup}}
servergroup[i++]={id:{{$allsgroup[a].id}},name:'{{$allsgroup[a].groupname}}',ldapid:{{$allsgroup[a].ldapid}},level:{{$allsgroup[a].level}}};
{{/section}}
i=0;
{{section name=b loop=$usergroup}}
usergroup[i++]={id:{{$usergroup[b].id}},name:'{{$usergroup[b].groupname}}',ldapid:{{$usergroup[b].ldapid}},level:0};
{{/section}}
*}}
</script>
{{/if}}
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
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
</ul><span class="back_img"><A href="admin.php?controller=admin_member&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
</head>

<body>
		
 <tr>
	<td class="" colspan = "7"><form name='route' action='admin.php?controller=admin_member&action=batchadd_save' method='post'><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="main_content">

                <TBODY>
				 <TR>
                    <TD >
					{{if !$smarty.session.RADIUSUSERLIST}}
			
		{{include file="select_sgroup_ajax.tpl" }}  
			  {{/if}}
					</TD>
                  </TR>
				  </table></td></tr>
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
		<tr bgcolor="#F3F8FC">
			<th class="list_bg"  width="3%" align="center" bgcolor="#E0EDF8"><b>序列</b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>用户名</b></th>
			{{if !$smarty.session.RADIUSUSERLIST}}
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>真实姓名</b></th>
			{{/if}}
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>密码</b></th>
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>确认密码</b></th>
			{{if !$smarty.session.RADIUSUSERLIST}}
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>工作单位</b></th>
			{{/if}}
			<th class="list_bg"  width="10%" align="center" bgcolor="#E0EDF8"><b>用户权限</b></th>
			{{if $smarty.session.RADIUSUSERLIST}}
			<th class="list_bg"  width="30%" align="center" bgcolor="#E0EDF8"><b>{{if !$smarty.session.RADIUSUSERLIST}}运维组{{else}}级别权限{{/if}}</b></th>
			{{/if}}
		</tr>		
		{{section name=t loop=20}}
		
		<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td width="3%" class="td_line">{{$smarty.section.t.index+1}}</td>
			<td width="10%" class="td_line"><input type="text" class="wbk" name="username[]" value="" /></td>
			{{if !$smarty.session.RADIUSUSERLIST}}
			<td width="10%" class="td_line"><input type="text" class="wbk" name="realname[]" value="" /></td>
			{{/if}}
			<td width="10%" class="td_line"><input type="password" class="wbk" name="password[]" value="" /></td>
			<td width="10%" class="td_line"><input type="password" class="wbk" name="confirm_password[]" value="" /></td>
			{{if !$smarty.session.RADIUSUSERLIST}}
			<td width="10%" class="td_line"><input type="text" class="wbk" name="workcompany[]" value="" /></td>
			{{/if}}
			<td width="10%" class="td_line"><select  class="wbk"  name="level[]" onchange="change_level(this,{{$smarty.section.t.index+1}});">
			{{if !$smarty.session.RADIUSUSERLIST}}
							<option value="0">{{$language.common}}{{$language.User}}</option>
			{{/if}}
							<option value="11" >RADIUS{{$language.User}}</option>
						</select></td>
						{{if $smarty.session.RADIUSUSERLIST}}
			<td width="10%" class="td_line">
			
Cisco授权级别：<select  class="wbk"  name="priv[]">
                {{section name=k loop=16}}
				 <option value="{{$smarty.section.k.index}}" {{if $smarty.section.k.index == $priv}}selected{{/if}}>{{$smarty.section.k.index}}</option>
				{{/section}}
                  </SELECT>&nbsp;
华为授权级别：<select  class="wbk"  name="huaweipriv[]">
                {{section name=h loop=4}}
				<option value="{{$smarty.section.h.index}}" {{if $smarty.section.h.index == $huaweipriv}}selected{{/if}}>{{$smarty.section.h.index}}</option>
				{{/section}}
                  </SELECT>&nbsp;
登录协议：<input type="checkbox" name="radiusssh_{{$smarty.section.t.index}}" {{if !$member.uid or $radiusssh}}checked{{/if}} value="1" />SSH&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="radiustelnet_{{$smarty.section.t.index}}"  {{if !$member.uid or $radiustelnet}}checked{{/if}} value="1" />TELNET
			  
			  </td>
		{{/if}}
		</tr>
		
		{{/section}}
		 <tr>
			<td colspan="9" align="center" ><input type='submit'  name="batch" value='确定' class="an_02"></td>
		  </tr>

		</table></form>
	</td>
  </tr>

		
</table>

<script language="javascript">
{{if $_config.LDAP}}
{{$changelevelstr}}
{{/if}}
function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}
function change_level(obj, num){
	if(obj.value==11){
		var group = document.getElementById('groupid_'+num);
		var o_value = null;
		for(var i=0; i<group.options.length; i++){
			o_value = group.options[i].text.toLowerCase();
			if(o_value.indexOf("radius")>=0){
				group.options[i].selected = true;
				break;
			}
		}
	}
}
</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



