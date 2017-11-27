<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery.csv-0.71.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/ldapajaxdtree.js"></script>
</head>
<style>
.dtree {width: auto;overflow: scroll;height:400px;}
</style>
<script type="text/javascript">
function checkgroupl(c, g){
	var elements = document.getElementsByTagName('input');
	var all = arguments[2] ? arguments[2] : 0;
	for(var i=0; i<elements.length; i++){
		if(elements[i].type=='checkbox'&&(all || elements[i].id.indexOf('u_'+g+'_')>=0)){
			elements[i].checked = c;
		}
	}

	return false;
}
</script>
<body>
{{if !$step }}
<FORM name="f1" onSubmit="return check()" enctype="multipart/form-data" action="admin.php?controller=admin_config&action=ldapusers" method="post">

              <TABLE width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" valign="top"  class="BBtable">
                <TBODY>
				<tr bgcolor="f7f7f7"><td align="right">LDAP 服务器:</td>		
	<td >
		<input type="text" class="wbk" name="address" value="{{$adconfig.address}}:{{$adconfig.port}}" />	
		</td>		
	</tr>

	<tr bgcolor="f7f7f7"><td align="right">管理员DN:</td>		
	<td >
		<input type="text" class="wbk" size="60" name="adusername" value="{{$adconfig.adusername}}" />	
		</td>
	</tr>
	<tr>
<td align="right">管理员密码:</td>		
	<td >
		<input type="password" class="wbk" name="adpassword" value="{{$adconfig.adpassword}}" />	</td>
	</tr>
<tr>
<td align="right">用户名对应属性：</td>		
	<td >
		<select name="usernamemap" >
		<option value="">默认</option>
		<option value="uid">UID</option>
		<option value="sn">SN</option>
		<option value="cn">CN</option>
		<option value="mail">MAIL "@"之前</option>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;真实对应属性：<select name="realnamemap" >
		<option value="">默认</option>
		<option value="uid">UID</option>
		<option value="sn">SN</option>
		<option value="cn">CN</option>
		</select>
		</td>
	</tr>
<tr bgcolor="f7f7f7"><td align="right">OU:</td>		
	<td>
		<input type="text"  size="60" class="wbk" size="50" name="ou" value="{{$adconfig.ou}}" />	搜索目录的DN
		</td>
	</tr>
                  <TR>
                    <TD colspan="4" align="center"><INPUT class="an_02" type="submit" value="提交"></TD>
                  </TR>
                </TBODY>
              </TABLE>
</FORM>

{{elseif $step eq 1}}
 <FORM name="f1" onSubmit="return check()" enctype="multipart/form-data" action="admin.php?controller=admin_config&action=ldapusers_save" method="post">

              <TABLE width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" valign="top"  class="BBtable">
                <TBODY>
				<TR id="autosutr" {{if $smarty.section.i.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD width="20%" align="center">用户名 选择				
					</TD>
                  </TR>
				
                  <TR id="autosutr" {{if $smarty.section.i.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD>
					<table><tr >
		{{section name=i loop=$members}}
		{{if !$members[i].checked}}
		<td width="150"><input type='checkbox' name='username[]' value='{{$members[i].username}}' >{{$members[i].username}}</td>{{if ($smarty.section.i.index +1) % 5 == 0}}</tr><tr>
		
				 {{/if}} {{/if}} 
				{{/section}}
		</tr></table>

	<div class="dtree" id="dtree1">
	<script type="text/javascript">

		ddev = new ldapTree('ddev',"dtree1",'users');
		ddev.icon['folder'] = 'template/admin/cssjs/img/group.gif';
		ddev.icon['folderOpen'] = 'template/admin/cssjs/img/groupopen.png';
		ddev.icon['node'] = 'template/admin/cssjs/img/user.gif';
		var i=0;
		ddev.add(0,-1,'<input type="checkbox" onclick="checkgroupl(this.checked,0,1);">{{$dn}}{{if $groupnumber}}   ({{$groupnumber}}){{/if}}','#','');
		//ddev.add(10000,0,'所有主机','admin.php?controller=admin_pro&action=dev_index','','main');
		{{section name=ac loop=$cns}}
			ddev.add({{$smarty.section.ac.index+1}},0,'<input type="checkbox" id="{{$smarty.section.ac.index+1}}" name="cn[]" value="" onclick="checkgroupl(this.checked,{{$smarty.section.ac.index+1}});">{{$cns[ac]}}','javascript:ddev.getChildren({{$smarty.section.ac.index+1}}, \'\', \'\', \'{{$cns[ac]}}\', \'{{$dn}}\');','{{$cns[ac]}}',null,ddev.icon.folder);
		{{/section}}
		{{section name=ao loop=$ous}}
			{{if $ous[ao].count > 0}}
			ddev.add({{$smarty.section.ac.index+1}}{{$smarty.section.ao.index+1}},0,'<input type="checkbox" id="{{$smarty.section.ac.index+1}}{{$smarty.section.ao.index+1}}" name="group[]" value="" onclick="checkgroupl(this.checked,{{$smarty.section.ac.index+1}}{{$smarty.section.ao.index+1}});">{{$ous[ao].name}}({{$ous[ao].count}})','javascript:ddev.getChildren({{$smarty.section.ac.index+1}}{{$smarty.section.ao.index+1}}, \'\', \'{{$ous[ao].name}}\', \'\', \'{{$dn}}\');','{{$ous[ao].name}}',null,ddev.icon.folder);
			{{/if}}
		{{/section}}
		{{section name=ag loop=$groups}}
			{{if $groups[ag].count > 0}}
			ddev.add({{$smarty.section.ac.index+1}}{{$smarty.section.ao.index+1}}{{$smarty.section.ag.index+1}},0,'<input type="checkbox" id="{{$smarty.section.ao.index+1}}{{$smarty.section.ag.index+1}}" name="group[]" value="" onclick="ddev.o({{$smarty.section.ao.index+1}}{{$smarty.section.ag.index+1}});checkgroupl(this.checked,{{$smarty.section.ac.index+1}}{{$smarty.section.ao.index+1}}{{$smarty.section.ag.index+1}});">{{$groups[ag].groupname}}({{$groups[ag].count}})','javascript:ddev.getChildren({{$smarty.section.ac.index+1}}{{$smarty.section.ao.index+1}}{{$smarty.section.ag.index+1}}, \'{{$groups[ag].groupname}}\', \'\',\'\', \'{{$dn}}\');','{{$groups[ag].groupname}}',null,ddev.icon.folder);
			{{/if}}
		{{/section}}
		{{section name=nu loop=$nogroupusers}}
			ddev.add({{$smarty.section.ac.index+1}}{{$smarty.section.ao.index+1}}{{$smarty.section.ag.index+1}}{{$smarty.section.nu.index}},0,'<input type="checkbox" name="username[]" value="{{$nogroupusers[nu].username}}{{if $nogroupusers[nu].ingroup }}|{{$nogroupusers[nu].dn}}{{/if}}" {{if $nogroupusers[nu].exists}}{{/if}}>{{if $nogroupusers[nu].exists}}<font style="color:red">{{$nogroupusers[nu].username}}{{else}}{{$nogroupusers[nu].username}}{{/if}}','#','{{$nogroupusers[nu]}}.username');
		{{/section}}
		ddev.show();	
		ddev.s(0);
	</script>
</div>
					</TD>
                  </TR>

<script src="./template/admin/cssjs/global.functions.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
{{assign var='popsize' value=100}}
{{assign var='direction' value='up'}}
                  <TR>
                    <TD colspan="2" align="left">导入后密码<input type='password' name='password' class="input_shorttext" style="width:100px;"/>&nbsp;
					
					{{include file="select_sgroup_ajax.tpl" }}&nbsp;&nbsp;<input type="checkbox" name="radiusauth" class="" value="1" {{if $member.radiusauth}}checked{{/if}}>RADIUS证&nbsp;&nbsp;<input type="checkbox" name="ldapauth" class="" value="1" checked>LDAP认证&nbsp;&nbsp;&nbsp;<INPUT class="an_02" type="submit" value="保存修改"></TD>
                  </TR>
                </TBODY>
              </TABLE>
</FORM>

{{/if}}
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



