<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
</head>
<script>
function searchit(){
document.route.submit();
return true;
}
var AllMember = new Array();
i=0;
{{section name=kk loop=$members}}
AllMember[{{$smarty.section.kk.index}}] = new Array();
AllMember[{{$smarty.section.kk.index}}]['username']='{{$members[kk].username}}';
AllMember[{{$smarty.section.kk.index}}]['realname']='{{$members[kk].realname}}';
AllMember[{{$smarty.section.kk.index}}]['uid']='{{$members[kk].uid}}';
{{/section}}
function filter(v,i,d){
	var obj = document.getElementById('uid_'+i);
	obj.options.length=0;
	for(var j=0; j<AllMember.length; j++){
		if(AllMember[j].username.indexOf(v)>=0){
			if(AllMember[j].username==d){
				obj.options[obj.options.length]=new Option(AllMember[j].username,AllMember[j].username,true,true);
			}else{
				obj.options[obj.options.length]=new Option(AllMember[j].username,AllMember[j].username);
			}
		}
	}
}
function updateuserkey(keyid, uid){
	$.post( "admin.php?controller=admin_member&action=keybinduser_save&fromajax=1&keyid="+keyid, { member: uid})
	  .done(function( data ) {
		alert(data );
	  });
}

function loadurl(url){
	if(url=="") return ;
	$.get(url, {Action:"get",Name:"lulu","1":Math.round(new Date().getTime()/1000)}, function (data, textStatus){
		this; // 在这里this指向的是Ajax请求的选项配置信息，请参考下图
		//alert(data);
		if(data.substring(0,10)=='freesvr://'){
			launcher(data);
		}else if(data.substring(0,15)=='window.loadurl(' || data.substring(0,11)=='if(confirm('){
			eval(data);
		}else{
			showImg('',data);
		}
	});
}
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

function showImg(wTitle, c)
{
	closeWindow();
	//var pos = mousePosition(ev);
	var wWidth=200;
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
	mesW.innerHTML='<div id="light" class="white_content" style="height:240px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#eeeeee" align="right" height="25"><a href="javascript:void(0)" onclick="closeWindow()">关闭</a></td></tr></table>'+c+"</div>";
	//styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";//鼠标点击位置
	//styleStr="left:"+(bWidth-wWidth)/2+"px;top:"+(bHeight-wHeight)/2+"px;position:absolute;width:"+wWidth+"px;";//屏幕中间
	mesW.style.cssText=styleStr;
	document.body.appendChild(mesW);
	//window.parent.document.getElementById("frame_content").height=pos.y+1000;
	//window.parent.parent.document.getElementById("main").height=bHeight+1000;	
	
	document.getElementById('fade').style.display='block'
	return false;
}
</script>
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

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
		<form name='route' action='admin.php?controller=admin_member&action=keys_index' method='post'>
			<td colspan="3" class="main_content">&nbsp;动态令牌 序列号：<input type="text" class="wbk" size="20" name="keyid" value="" />&nbsp;&nbsp; 用户名：<input type="text" class="wbk" size="20" name="username" value="" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" height="35" align="middle" onClick="return searchit();" border="0" value=" 确定 " class="bnnew2"/>&nbsp;&nbsp;</td>
			
			<input type="hidden" name="ac" value="new" />
		</form>
		</tr>
  <tr>
	<td class="">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="BBtable">
                <TBODY>		
		<tr >
			<th class="list_bg" align="center" width="20%"><a href="admin.php?controller=admin_member&action=keys_index&orderby1=keyid&orderby2={{$orderby2}}" ><strong>动态令牌 序列号</strong></a></td>
			<th class="list_bg" width="15%" align="center"><a href="admin.php?controller=admin_member&action=keys_index&orderby1=username&orderby2={{$orderby2}}" ><b>绑定用户</b></a></td>
			<th class="list_bg" width="15%" align="center"><a href="admin.php?controller=admin_member&action=keys_index&orderby1=type&orderby2={{$orderby2}}" ><b>类型</b></a></td>
			<th class="list_bg" width="30%">说明</TD>
			<th class="list_bg" align="center"><b>操作</b></td>
		</tr>		
		{{section name=t loop=$allkeys}}
		<tr {{if $smarty.section.t.index % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
			<td >{{$allkeys[t].keyid}}</td>
			<td >
			{{$allkeys[t].username}}</td>
			<td>{{if !$allkeys[t].type }}硬件{{else}}手机{{/if}}令牌</td>
			<td align="center"><a href='#' onclick='loadurl("admin.php?controller=admin_member&action=showdesc&id={{$allkeys[t].id}}");return false;' target="hide"><img src='{{$template_root}}/images/1-1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'>{{$allkeys[t].desc|truncate_cn:15:"...":""}}</a></td>
			
			<td >
			
			<img src="{{$template_root}}/images/edit_ico.gif" width="16" height="16" align="absmiddle"><a href="admin.php?controller=admin_member&action=keybinduser&keyid={{$allkeys[t].id}}">修改</a> 
			 | <img src="{{$template_root}}/images/delete_ico.gif" width="16" height="16" hspace="5" border="0" align="absmiddle"><a href="#" onClick="if(!confirm('您确定要删除key？')) {return false;} else { location.href='admin.php?controller=admin_member&action=keys_delete&id={{$allkeys[t].id}}';}">删除</a>
			
			</td>
		</tr>
		{{/section}}
		
		{{*<tr>
		<form name='route' action='admin.php?controller=admin_member&action=keys_index' method='post'>
			<td width="10%" class=""> 增加</td>
			<td class="" width="30%">keyid：<input type="text" class="wbk" size="30" name="keyid" value="" /></td>
			<td class="" ><input type="submit" name="submit" value="提交" /></td>
			
			<input type="hidden" name="ac" value="new" />
		</form>
		</tr>*}}
		
                <tr>
				<td colspan="1"><input type="button"  value="导入动态令牌" onclick="javascript:document.location='admin.php?controller=admin_member&action=importusbkey';" class="an_06">
		</td>
	           <td  colspan="3" align="right">
		   			共{{$total}}个记录  {{$page_list}}  页次：{{$curr_page}}/{{$total_page}}页  {{$items_per_page}}个记录/页  转到第<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_member&action=keys_index&page='+this.value;">页
		   </td>
		</tr>
		
		</TBODY>
              </TABLE>	</td>
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



