<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{$site_title}}</title>
<link href="{{$template_root}}/cssjs/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script >

function showNodeCount0(check){
	var els = document.getElementsByTagName('div');
	for(var i=0; i<els.length; i++){
		if($(els[i]).attr("class")=='dTreeNode'&&$(els[i]).attr("count")==0){
			$(els[i]).css("display",check ? "" : "none");
		}
	}
}

function showLongTitle(check){return ;
	var els = document.getElementsByTagName('a');
	for(var i=0; i<els.length; i++){
		if($(els[i]).attr("class")=='node'){
			if(check){
				$(els[i])[0].innerText = $(els[i]).attr("shorttitle");
			}else{
				$(els[i])[0].innerText = $(els[i]).attr("longtitle");
			}
		}
	}
}
</script>
<body>
<table width="213" height="500" border="0" cellpadding="0" cellspacing="0"  class="zuo_bj" >
      <tr>
        <td height="42" colspan="2" align="center" valign="middle" class="hui_bj"><img src="{{$template_root}}/images/yw_53.jpg" width="16" height="13" align="absmiddle" /> {{$Year}}年{{$Month}}月{{$Day}}日 星期{{$Week}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td width="209" height="606" align="center" valign="top">
			<table width="189" height="117" border="0" cellpadding="0" cellspacing="0" class="sy">
				<tr>
				  <td height="29" colspan="2" align="left">&nbsp;&nbsp;&nbsp;<img src="{{$template_root}}/images/yw_47.jpg" width="22" height="22" align="absmiddle" />&nbsp;<strong class="bd">管理首页</strong></td>
				</tr>
				<tr>
				  <td width="87" align="center" valign="middle"><img src="{{$template_root}}/images/yw_43.jpg" width="67" height="62" /></td>
				  <td width="98" align="left" valign="middle">{{$username}}<br />({{$user.realname|truncate_cn:"10":"..."}})<br />
					{{if $admin_level == 0}}普通用户{{elseif $admin_level == 1}}管理员{{elseif $admin_level == 3}}部门管理员{{elseif $admin_level == 4}}配置管理员{{elseif $admin_level == 10}}密码管理员{{elseif $admin_level == 21}}部门审计员{{elseif $admin_level == 101}}部门密码员{{elseif $admin_level == 11}}RADIUS用户{{/if}}</td>
				</tr>
			</table>
            <br />
            <table width="178"  border="0" cellpadding="0" cellspacing="0" id="audit_menu">

			{{if $admin_level == 1 || $admin_level == 3 || $admin_level == 4 }}
              <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('resource');" class="anniu"><img src="{{$template_root}}/images/1_3.png" width="18" height="15" style="vertical-align:middle"/> 资源管理</td>
              </tr>
			  <tr >
                <td align="left" valign="top" id="resource" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
					{{if $admin_level!=10}}
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/group.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_member" target="main" id="membermenu" onclick="return jumpto(this)">用户管理</a></td>
                    </tr>  
<tr id="_tree"><td>     
<div style=" width:180px; overflow-x:auto;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr id="mtree" style="display:none">
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01">
<link href="{{$template_root}}/cssjs/dtree.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<div class="dtree" id="mddevtree" >
	<script type="text/javascript">
		mddev = new dTree('mddev','mddevtree');
		mddev.icon['folder'] = 'template/admin/cssjs/img/pcgroup.gif';
		mddev.icon['folderOpen'] = 'template/admin/cssjs/img/pcgroup.gif';
		mddev.icon['node'] = 'template/admin/cssjs/img/pc.gif';
		mddev.config['menu']=1;
		var i=0;
		mddev.add(0,-1,'',1,'目录','admin.php?controller=admin_member&all=1','','main',null,null,null);
		{{section name=ag loop=$allsgroup}}
			mddev.add({{$allsgroup[ag].id}},{{if $_config.LDAP eq 0}}0{{else}}{{$allsgroup[ag].ldapid}}{{/if}},'{{$allsgroup[ag].id}}',{{$allsgroup[ag].mcount}},'{{$allsgroup[ag].groupname}}({{$allsgroup[ag].mcount}})','admin.php?controller=admin_member&ldapid={{$allsgroup[ag].id}}','{{$allsgroup[ag].groupname}}({{$allsgroup[ag].mcount}})','main','template/admin/cssjs/img/servergroup.png','template/admin/cssjs/img/servergroup.png',null);
		{{/section}}
		mddev.show();
		mddev.s(0);
	</script>
</div>

					  </td>
                    </tr> 
</table>
</div>
</td></tr>

<tr id="_tree"><td>     
<div style=" width:180px; overflow-x:auto;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr id="devtree" style="display:none">
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01">
<div class="dtree" id="ddevtree">
	<script type="text/javascript">
		ddev = new dTree('ddev','ddevtree');
		ddev.icon['folder'] = 'template/admin/cssjs/img/pcgroup.gif';
		ddev.icon['folderOpen'] = 'template/admin/cssjs/img/pcgroup.gif';
		ddev.icon['node'] = 'template/admin/cssjs/img/pc.gif';
		ddev.config['menu']=2;
		var i=0;
		ddev.add(0,-1,'',1,'设备组','admin.php?controller=admin_pro&action=dev_index&all=1','','main',null,null,null,1,'设备组','设备组');
		//ddev.add(10000,0,'所有主机','admin.php?controller=admin_pro&action=dev_index','','main');
		{{section name=ag loop=$allsgroup}}
			ddev.add({{$allsgroup[ag].id}},{{if $_config.LDAP eq 0}}0{{else}}{{$allsgroup[ag].ldapid}}{{/if}},'{{$allsgroup[ag].id}}',{{$allsgroup[ag].count}},'{{$allsgroup[ag].groupname}}({{$allsgroup[ag].count}})','admin.php?controller=admin_pro&action=dev_index&gid={{$allsgroup[ag].id}}','{{$allsgroup[ag].groupname}}({{$allsgroup[ag].count}})','main','template/admin/cssjs/img/servergroup.png','template/admin/cssjs/img/servergroup.png',null);
		{{/section}}
		ddev.show();	
		ddev.s(0);
	</script>
</div>

					  </td>
                    </tr> 
</table>
</div>
</td></tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/hammer_screwdriver.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_pro&action=dev_group" target="main" onclick="return jumpto(this)">目录管理</a></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/key.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_member&action=keys_index" target="main" onclick="return jumpto(this)">动态令牌</a></td>
                    </tr>
					
					 {{/if}}
                </table></td>
              </tr>
			  {{/if}}


			{{if $admin_level == 1}}
              <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('configure');" class="anniu"><img src="{{$template_root}}/images/1_4.png" width="18" height="21" style="vertical-align:middle"/> 系统管理</td>
              </tr>
			   <tr >
                <td align="left" valign="top" id="configure" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/cog.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_config&action=config_ftp" target="main" id="configure1" onclick="return jumpto(this)">系统配置</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/chart_line.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_config&action=login_times" target="main" onclick="return jumpto(this)">密码策略</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/cog.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_config&action=certs" target="main" onclick="return jumpto(this)">证书配置</a></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/chart_line.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_config&action=syslog_mail_alarm" target="main" onclick="return jumpto(this)">告警配置</a></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/chart_line.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_config&action=status_warning" target="main" onclick="return jumpto(this)">告警参数</a></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/chart_line.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_eth&action=ifcfgeth" target="main" onclick="return jumpto(this)">{{$language.Network}}</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/application_double.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_eth&action=serverstatus" target="main" id="serverstatus" onclick="return jumpto(this)">服务状态</a></td>
                    </tr>
                </table></td>
              </tr>
			  {{/if}}
			{{if $admin_level == 1}}
              <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('vpn');" class="anniu"><img src="{{$template_root}}/images/1_5.png" width="18" height="19" style="vertical-align:middle"/> VPN</td>
              </tr>
			   <tr >
                <td align="left" valign="top" id="vpn" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
                	{{if $_config['vpnconfig']}}
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/tab_dot8.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_eth&action=vpnconfig" target="main" onclick="return jumpto(this)">VPN配置</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/tab_dot9.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_eth&action=vpn_list" target="main" onclick="return jumpto(this)">VPN策略</a></td>
                    </tr>
                    {{/if}}
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/tab_dot10.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_eth&action=route_list" target="main" onclick="return jumpto(this)">{{$language.VpnRouter}}</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/ico9.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_vpnlog&action=online" target="main" onclick="return jumpto(this)">在线用户</a></td>
                    </tr>
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/doc_table.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_vpnlog" target="main" onclick="return jumpto(this)">VPN LOG</a></td>
                    </tr>
                </table></td>
              </tr>
			
			{{/if}}
              <tr>
                <td align="left" valign="middle" onclick="javascript:show_box('other');" class="anniu"><img src="{{$template_root}}/images/1_6.png" width="18" height="19" style="vertical-align:middle"/> 其它</td>
              </tr>

			   <tr>
                <td align="left" valign="top"  id="other" style="display:none" ><table width="100%"  border="0" cellpadding="0" cellspacing="2">
					
					<tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/ico9.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_member&action=edit_self" target="main" id="OwnInformation" onclick="return jumpto(this)">{{$language.OwnInformation}}</a></td>
                    </tr>
                    <tr>
                      <td height="25" align="left" bgcolor="52A1D4" class="zcd01"><img src="{{$template_root}}/images/down.gif" width="18" height="21"  align="absmiddle"/> <a href="admin.php?controller=admin_index&action=tool_list" target="main" onclick="return jumpto(this)">工具下载</a></td>
                    </tr>
                </table></td>
              </tr>
          </table>
		  </td>
       
      </tr>
    </table>
	
	<script>
	var openid="";
	var cururl = "";
	function show_box(box_id){
		{{if $smarty.session.ADMIN_LEVEL eq 1}}
		document.getElementById('_tree').style.display='none';
		document.getElementById('devtree').style.display='none';
		document.getElementById('mtree').style.display='none';
		{{/if}}
		if(openid!=""&&openid!=box_id)
		document.getElementById(openid).style.display = "none";
		openid=box_id
		if(document.getElementById(box_id).style.display != "block"){
			document.getElementById(box_id).style.display = "block";
		} else {
			document.getElementById(box_id).style.display = "none";
		}
	}

	var selectedItem = '';
	function jumpto(obj){
		if((obj.id=='membermenu' || obj.id=='devmenu')&&selectedItem==obj){
			if(document.getElementById(cururl).style.display=='none'){
				document.getElementById(cururl).style.display='';
			}else{
				document.getElementById(cururl).style.display='none';
			}
			return false;
		}	
		{{if $smarty.session.ADMIN_LEVEL eq 1}}
		document.getElementById('_tree').style.display='none';
		document.getElementById('mtree').style.display='none';
		document.getElementById('devtree').style.display='none';
		{{/if}}
		if(selectedItem)
		selectedItem.parentNode.className='zcd01';
		obj.parentNode.className = "zcd";
		selectedItem = obj;
		return true;
	}

{{if $smarty.get.actions eq 'dev_group'}}
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_pro&action=dev_group&ldapid={{$smarty.get.ldapid}}&back={{$smarty.get.back}}'+'&'+Math.round(new Date().getTime()/1000);
{{elseif $smarty.get.actions eq 'dev_server'}}
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_pro&action=dev_index&gid={{$smarty.get.gid}}&back={{$smarty.get.back}}'+'&'+Math.round(new Date().getTime()/1000);
{{elseif $smarty.get.actions eq 'member'}}
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_member&ldapid={{$smarty.get.ldapid}}&gid={{$smarty.get.gid}}&back={{$smarty.get.back}}'+'&'+Math.round(new Date().getTime()/1000);
{{elseif $smarty.get.actions eq 'radiusmember'}}
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_member&action=radiususer&ldapid={{$smarty.get.ldapid}}&gid={{$smarty.get.gid}}&back={{$smarty.get.back}}'+'&'+Math.round(new Date().getTime()/1000);
{{elseif $smarty.get.actions eq 'usergroup'}}
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_member&action=usergroup&ldapid={{$smarty.get.ldapid}}&back={{$smarty.get.back}}'+'&'+Math.round(new Date().getTime()/1000);
{{elseif $smarty.get.actions eq 'config_ftp'}}
show_box('configure');
jumpto(document.getElementById('configure1'));
document.getElementById('configure1').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_config&action=config_ftp'+'&'+Math.round(new Date().getTime()/1000);
{{elseif $smarty.get.actions eq 'ldap'}}
show_box('configure');
jumpto(document.getElementById('configure1'));
document.getElementById('configure1').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_config&action=config_ssh'+'&'+Math.round(new Date().getTime()/1000);

{{elseif  $amdin_level ==10 or $amdin_level ==101}}
show_box('password');
jumpto(document.getElementById('passlist'));
document.getElementById('passlist').parentNode.className='zcd';
window.parent.document.getElementById('main').src=document.getElementById('passlist').href;
{{elseif $admin_level == 0}}
show_box('other');
//jumpto(document.getElementById('devlist2'));
//document.getElementById('devlist2').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_index&action=main';
//ddev.s(0);

{{elseif $admin_level == 11}}
show_box('other');
jumpto(document.getElementById('OwnInformation'));
document.getElementById('OwnInformation').parentNode.className='zcd';
window.parent.document.getElementById('main').src=document.getElementById('OwnInformation').href;
{{elseif $admin_level == 3 or $amdin_level ==1}}
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_status&action=latest';
{{elseif $admin_level==4}}
show_box('resource');
jumpto(document.getElementById('membermenu'));
document.getElementById('membermenu').parentNode.className='zcd';
window.parent.document.getElementById('main').src=document.getElementById('membermenu').href;
{{elseif $amdin_level ==2 or $amdin_level ==21}}
show_box('audit');
jumpto(document.getElementById('sshaudit'));
document.getElementById('sshaudit').parentNode.className='zcd';
window.parent.document.getElementById('main').src=document.getElementById('sshaudit').href;
{{elseif $amdin_level ==1 }}
show_box('configure');
jumpto(document.getElementById('serverstatus'));
document.getElementById('serverstatus').parentNode.className='zcd';
window.parent.document.getElementById('main').src='admin.php?controller=admin_status&action=latest';
{{/if}} 
{{if $login_tip == 1}}
window.open ('admin.php?controller=admin_index&action=login_tip', 'newwindow', 'height=330, width=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');
{{/if}}


</script>

</body>
</html>
