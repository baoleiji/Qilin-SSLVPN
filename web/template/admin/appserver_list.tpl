<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>会话列表</title>
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
	var wHeight=120;
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
	mesW.innerHTML='<div id="light" class="white_content" style="height:120px;width:'+width+'px"><img src="{{$template_root}}/images/loading2.gif" /><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="right" height="25"><a href="javascript:void(0)" onclick="closeWindow()"><font color="gray">关闭</font></a></td></tr></table></div>';
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
	showImg('','',width);
	$.get(url, {Action:"get",Name:"lulu","1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		closeWindow()
		alert(data);
	});
}
function showImg2(wTitle, c)
{
	closeWindow();
	//var pos = mousePosition(ev);
	var wWidth=400;
	var wHeight=300;
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
	mesW.innerHTML='<div id="light" class="white_content" style="height:300px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#eeeeee" align="right" height="25"><a href="javascript:void(0)" onclick="closeWindow()">关闭</a></td></tr></table>'+c+"</div>";
	//styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";//鼠标点击位置
	//styleStr="left:"+(bWidth-wWidth)/2+"px;top:"+(bHeight-wHeight)/2+"px;position:absolute;width:"+wWidth+"px;";//屏幕中间
	mesW.style.cssText=styleStr;
	document.body.appendChild(mesW);
	//window.parent.document.getElementById("frame_content").height=pos.y+1000;
	//window.parent.parent.document.getElementById("main").height=bHeight+1000;	
	
	document.getElementById('fade').style.display='block'
	return false;
}

function loadurl2(url){
	if(url=="") return ;
	$.get(url, {Action:"get",Name:"lulu","1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//alert(data);
		showImg2('',data);
	});
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
   
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appserver_list">应用发布</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	{{if $smarty.session.ADMIN_LEVEL ne 3}}
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appprogram_list">应用程序</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	<li class="me_b"><img src="{{$template_root}}/images/an11.jpg" align="absmiddle"/><a href="admin.php?controller=admin_config&action=appicon_list">应用图标</a><img src="{{$template_root}}/images/an33.jpg" align="absmiddle"/></li>
	{{/if}}
</ul>
</div></td></tr>

	
  
  <tr><td><table bordercolor="white" cellspacing="0" cellpadding="5" border="0" width="100%" class="BBtable">
			<tr>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_config&action=appserver_list&orderby1=name&orderby2={{$orderby2}}" >应用发布服务器名称</a></th>
				<th class="list_bg"  width="10%"><a href="admin.php?controller=admin_config&action=appserver_list&orderby1=appserverip&orderby2={{$orderby2}}" >应用发布服务器IP</a></th>
				<th class="list_bg"  width="20%"><a href="admin.php?controller=admin_config&action=appserver_list&orderby1=description&orderby2={{$orderby2}}" >描述</a></th>
				<th class="list_bg"  width="30%">操作</th>
			</tr>
			{{section name=t loop=$apppub}}
			<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
				<td>{{$apppub[t].name}}</td>
				<td>{{$apppub[t].appserverip}}</ td>
				<td>{{$apppub[t].description}}</ td>
				<td style="TEXT-ALIGN: left;"><img src='./template/admin/images/ico-bianji.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=async_account&ip={{$apppub[t].appserverip}}",300)' target="hide">同步账号</a>&nbsp;&nbsp;&nbsp;&nbsp;
				| <img src='./template/admin/images/icon_trackback.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=async_config&ip={{$apppub[t].appserverip}}",300)' target="hide">同步配置</a>&nbsp;&nbsp;&nbsp;&nbsp;
				| <img src='./template/admin/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_config&action=appserver_edit&id={{$apppub[t].id}}'>修改</a>&nbsp;&nbsp;&nbsp;&nbsp;
				| <img src="{{$template_root}}/images/scico.gif" width="16" height="16" align="absmiddle"><a onclick="if(confirm('确定删除吗?')) return true;else return false;" href="admin.php?controller=admin_config&action=appserver_delete&id={{$apppub[t].id}}">删除</a>&nbsp;| <img src='./template/admin/images/app.png' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_config&action=apppub_list&ip={{$apppub[t].appserverip}}'>应用发布</a>&nbsp;| <img src='./template/admin/images/1-1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='#' onclick="loadurl2('admin.php?controller=admin_app&action=recopyhtml&appserverip={{$apppub[t].appserverip}}')">复制</a></td>
			</tr>
			{{/section}}
			<tr>
				
				<td align="left">
				{{if $smarty.session.ADMIN_LEVEL eq 1}}
					<input type="button" onclick="location.href='admin.php?controller=admin_config&action=appserver_edit'" value="增加" class="an_02">
				{{/if}}
				</td><td colspan="3" align="right">
					共{{$command_num}}执行命令  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}条日志/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_session&action=dangerlist&page='+this.value;">页
				</td>
			</tr>
		</table>
	</td>
  </tr>
</table>
<script type="text/javascript">
window.parent.menu.document.getElementById('devtree').style.display='none';
window.parent.menu.document.getElementById('ldaptree').style.display='none';
</script>

</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



