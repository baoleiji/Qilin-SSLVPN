<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>

<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/border-radius.css" />
<script type="text/javascript">
var isIe=(document.all)?true:false;
function closeWindow()
{
	if(document.getElementById('back')!=null)
	{
		document.getElementById('back').parentNode.removeChild(document.getElementById('back'));
	}
	if(document.getElementById('mesWindow')!=null)
	{
		document.getElementById('mesWindow').parentNode.removeChild(document.getElementById('mesWindow'));
	}
	document.getElementById('fade').style.display='none';
}

function showImg(wTitle, c, width)
{
	closeWindow();
	//var pos = mousePosition(ev);
	var wWidth=400;
	var wHeight=240;
	var bWidth=parseInt(w=window.innerWidth|| document.documentElement.clientWidth|| document.body.clientWidth);

	var bHeight=parseInt(window.innerHeight|| document.documentElement.clientHeight|| document.body.clientHeight)+20;
	bHeight=700+20;
	var back=document.createElement("div");
	back.id="back";
	var styleStr="top:0px;left:0px;position:absolute;width:"+bWidth+"px;height:"+bHeight+"px;z-index:1002;";
	//styleStr+=(isIe)?"filter:alpha(opacity=0);":"opacity:0;";
	back.style.cssText=styleStr;
	document.body.appendChild(back);
	var mesW=document.createElement("div");
	mesW.id="mesWindow";
	mesW.className="mesWindow";
	mesW.innerHTML='<div id="light" class="white_content" style="height:240px;width:'+width+'px"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#eeeeee" align="right" height="25"><a href="javascript:void(0)" onclick="closeWindow()">关闭</a></td></tr></table>'+c+"</div>";
	//styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";//鼠标点击位置
	//styleStr="left:"+(bWidth-wWidth)/2+"px;top:"+(bHeight-wHeight)/2+"px;position:absolute;width:"+wWidth+"px;";//屏幕中间
	mesW.style.cssText=styleStr;
	document.body.appendChild(mesW);
	//window.parent.document.getElementById("frame_content").height=pos.y+1000;
	//window.parent.parent.document.getElementById("main").height=bHeight+1000;	
	
	document.getElementById('fade').style.display='block'
	return false;
}
function loadurl(url,width){
	$.get(url, {Action:"get",Name:"lulu","1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//alert(data);
		showImg('',data,width);
	});
}

var AllMembers = new Array();
var i=0;
{{section name=kk loop=$members}}
AllMembers[i++]={uid:{{$members[kk].uid}}, username:'{{$members[kk].username}}'};
{{/section}}
function filter(){
	var filterStr = document.getElementById('filtertext').value;
	var username = document.getElementById('username');
	username.options.length=1;
	for(var i=0; i<AllMembers.length;i++){
		if(filterStr.length==0 || AllMembers[i]['username'].indexOf(filterStr) >= 0){
			username.options[username.options.length++] = new Option(AllMembers[i]['username'],AllMembers[i]['uid']);
		}
	}
}

var cansub = true;
function check_userpriority(devicesid, uid){
	cansub = false;
	$.get('admin.php?controller=admin_workflow&action=check_userpriority&uid='+uid+'&devicesid='+devicesid, {Action:"get",Name:"lulu","1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//alert(data);
		if(data==1){
			cansub = true;
		}
	});
}

function cansubmit(){
	if(cansub==false&&confirm('该用户没有权限,是否要继续并为该用户添加权限？')){
		return true;
	}
	return cansub;
}
function changeStyle(obj,c)
{
	if(c!='o'){
		obj.style.backgroundColor=c;
	}else{
		obj.style.backgroundColor="#FFCC80";
	}
}
</script>
</head>

<body>
<div id="fade" class="black_overlay"></div> 
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
<td width="84%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
{{if $smarty.session.ADMIN_LEVEL eq 0}}
<li class={{if $smarty.get.logintype }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&gid={{$gid}}&all=1">设备列表</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne '_apppub' and $smarty.get.logintype ne 'apppub' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne '_apppub' and $smarty.get.logintype ne 'apppub'}}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=_apppub&gid={{$gid}}">应用列表</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne '_apppub' and $smarty.get.logintype ne 'apppub'}}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'ssh' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'ssh' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=ssh&gid={{$gid}}">SSH设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'ssh' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'telnet' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'telnet' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=telnet&gid={{$gid}}">TELNET设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'telnet' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'rdp' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'rdp' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=rdp&gid={{$gid}}">RDP设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'rdp' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'vnc' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'vnc' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=vnc&gid={{$gid}}">VNC设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'vnc' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'ftp' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'ftp' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=ftp&gid={{$gid}}">FTP设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'ftp' }}3{{/if}}.jpg" align="absmiddle"/></li>
<li class={{if $smarty.get.logintype ne 'x11' }}"me_b"{{else}}"me_a"{{/if}}><img src="{{$template_root}}/images/an1{{if $smarty.get.logintype ne 'x11' }}1{{/if}}.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main&logintype=x11">X11设备</a><img src="{{$template_root}}/images/an3{{if $smarty.get.logintype ne 'x11' }}3{{/if}}.jpg" align="absmiddle"/></li>

<li class=me_b><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_workflow&action=workflow">运维流程</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>

{{elseif $smarty.session.ADMIN_LEVEL eq 10 or $smarty.session.ADMIN_LEVEL eq 101}}
<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=main">密码查看</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
{{if $smarty.session.ADMIN_LEVEL eq 10}}
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordedit">修改密码</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>

<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=password_cron">定时任务</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_backup&action=backup_setting_forpassword">自动备份</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_index&action=passdown">密码文件下载</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_pro&action=passwordcheck">密码校验</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
{{/if}}
{{/if}}
</ul>
</div></td></tr>

	
 
  <tr>
	<td class="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
	<form name="ip_list" action="admin.php?controller=admin_workflow&action=workflow_delete" method="post">
                <TBODY>
                  <TR>
			
                    <th class="list_bg" width="5%"><a href="admin.php?controller=admin_workflow&action=workflow_approve&orderby1=groupname&orderby2={{$orderby2}}" >选</a></TD>
                    <th class="list_bg"  width="8%"><a href="admin.php?controller=admin_workflow&action=workflow_approve&orderby1=username&orderby2={{$orderby2}}" >申请人</a></TD>
                    <th class="list_bg"  width="13%"><a href="admin.php?controller=admin_workflow&action=workflow_approve&orderby1=dateline&orderby2={{$orderby2}}" >申请时间</a></TD>
                    <th class="list_bg"  width="6%"><a href="admin.php?controller=admin_workflow&action=workflow_approve&orderby1=device_ip&orderby2={{$orderby2}}" >设备IP</a></TD>
                    <th class="list_bg"  width="6%"><a href="admin.php?controller=admin_workflow&action=workflow_approve&orderby1=username&orderby2={{$orderby2}}" >用户名</a></TD>
                    <th class="list_bg"  width="8%"><a href="admin.php?controller=admin_workflow&action=workflow_approve&orderby1=login_method&orderby2={{$orderby2}}" >登录方式</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_workflow&action=workflow_approve&orderby1=name&orderby2={{$orderby2}}" >操作内容</a></TD>
					<th class="list_bg"  width="13%"><a href="admin.php?controller=admin_workflow&action=workflow_approve&orderby1=dateline&orderby2={{$orderby2}}" >申请时间</a></TD>
                    <th class="list_bg"  width="10%"><a href="admin.php?controller=admin_workflow&action=workflow_approve&orderby1=desc&orderby2={{$orderby2}}" >描述</a></TD>
                    <th class="list_bg"  width="6%"><a href="admin.php?controller=admin_workflow&action=workflow_approve&orderby1=status&orderby2={{$orderby2}}" >流程状态</a></TD>
					<th class="list_bg" >操作</TD>
                  </TR>

            </tr>
			{{section name=t loop=$s}}
			<tr  {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}} onmouseover="changeStyle(this,'o');" onmouseout="changeStyle(this,'{{if $smarty.section.t.index % 2 == 0}}f7f7f7{{/if}}');">
				<td width="5%">{{$smarty.section.t.index+1}}</td>
				<td> {{$s[t].muname}}</td>
				<td> {{$s[t].dateline}}</td>
				<td> {{$s[t].device_ip}}</td>
				<td> {{$s[t].username}}</td>
				<td> {{$s[t].login_method}}</td>
				<td> {{$s[t].name}}</td>
				<td> {{$s[t].deadline}}</td>
				<td>  <span title="{{$s[t].desc}}">{{$s[t].desc|truncate_cn:"20":"..."}}</span></td>
				<td> <a href='#' onclick='loadurl("admin.php?controller=admin_workflow&action=show_workflow_log&wid={{$s[t]['sid']}}", 600);return false;'>{{if !$s[t].status }}未审批{{elseif $s[t].status eq 1}}关单{{elseif $s[t].status eq 2}}驳回{{elseif $s[t].status eq 3}}审批中{{elseif $s[t].status eq 4}}审批完成{{/if}}</a></td>
				<td style="TEXT-ALIGN: left;">
				<img src="{{$template_root}}/images/list_ico1.gif" width="16" height="16" align="absmiddle">
				{{if $s[t].approved eq 1}}已同意 {{if $s[t].apply_status_reject eq 1}}<a href="#" onclick="loadurl('admin.php?controller=admin_workflow&action=approvedesc&wid={{$s[t]['sid']}}&status=2');">驳回批准</a>{{/if}}
				{{elseif $s[t].approved eq 2}}驳回
				{{elseif $s[t].apply_status_priority}}<a href="#" onclick="loadurl('admin.php?controller=admin_workflow&action=approvedesc&wid={{$s[t]['sid']}}&status=1');">批准</a>  <a href="#" onclick="loadurl('admin.php?controller=admin_workflow&action=approvedesc&wid={{$s[t]['sid']}}&status=2');">驳回</a>{{/if}}
				 
				</td> 
			</tr>
			{{/section}}
	          <tr>
	           <td  colspan="3" align="left">&nbsp;&nbsp;&nbsp;&nbsp; 
				  
		   		</td>
				<td  colspan="5" align="right">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_workflow&action=dev_group_index&page='+this.value;">页
		   </td>
		   		</tr>
	           
		</TBODY>
              </TABLE></form>	</td>
  </tr>
</table>

<script language="javascript">

function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}

</script>
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>


