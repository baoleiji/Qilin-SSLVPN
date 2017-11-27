<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script>
	function my_confirm(str){
		if(!confirm("确认要" + str + "？"))
		{
			window.event.returnValue = false;
		}
	}
	function chk_form(){
		for(var i = 0; i < document.member_list.elements.length;i++){
			var e = document.member_list.elements[i];
			if(e.name == 'chk_member[]' && e.checked == true)
				return true;
		}
		alert("您没有{{$language.select}}任何{{$language.User}}！");
		return false;
	}

	function batchloginlock(){
		document.member_list.action = "admin.php?controller=admin_pro&action=devbatchloginlock";
		document.member_list.submit();
		return true;
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
</head>

<body>
<div id="fade" class="black_overlay"></div> 

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
</ul><span class="back_img"><A href="admin.php?controller=admin_pro&action=dev_index&gid={{$gid}}&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class=""><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="BBtable">
                <TBODY>{{*
			           <td  colspan="6">
		   			<form action="admin.php?controller=admin_pro&action=devpass_index" method="post" >
					{{$language.IPAddress}}<input type="text" class="wbk" name="ip"/>
					{{$language.Username}}<input type="text" class="wbk" name="name"/>
					<input type="submit" class="button" value="{{$language.Search}}">
					</form>
		   </td>*}}
		   		  <form name="member_list" action="admin.php?controller=admin_pro&action=devpass_index" method="post" >
		   
                  <TR>
                  <th class="list_bg"  width="3%">{{$language.select}}</th>
                  <th class="list_bg"  width="1%">ID</th>
                    <th class="list_bg" width="10%">{{$language.HostName}}</TD>
                    <th class="list_bg" width="10%">IP</TD>
                    <th class="list_bg" width="10%">系统</TD>
					<th class="list_bg" width="10%">{{$language.System}}{{$language.User}}</TD>
                    <th class="list_bg" width="10%">账号信息</TD>
					<th class="list_bg" width="15%">{{$language.Operate}}</TD>
                  </TR>

            </tr>
			{{section name=t loop=$alldev}}
			<tr {{if $alldev[t].radiususer_is_in_member}}bgcolor='red'{{/if}}>
			<td><input type="checkbox" name="chk_member[]" value="{{$alldev[t].id}}"></td>
				<td>{{$alldev[t].id}}</td>
				<td>{{$alldev[t].hostname}}</td>
				<td>{{$alldev[t].device_ip}}</td>
				<td>{{$alldev[t].device_type}}</td>
				<td>{{if !$alldev[t].username}}空{{$language.User}}{{else}}{{$alldev[t].username}}{{/if}}{{if $smarty.session.ADMIN_LEVEL eq 10}}(<a href='admin.php?controller=admin_pro&action=dev_checkpass&id={{$alldev[t].id}}'>查看</a>){{/if}}</td>			
				<td align="center"><a href='#' onclick='loadurl("admin.php?controller=admin_pro&action=showdesc&id={{$alldev[t].id}}");return false;' target="hide"><img src='{{$template_root}}/images/1-1.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'>{{$alldev[t].desc|truncate_cn:15:"...":""}}</a></td>
				<td>
				{{if $smarty.session.ADMIN_LEVEL eq 1 or $smarty.session.ADMIN_LEVEL eq 3 or $smarty.session.ADMIN_LEVEL eq 4}}
				<img src='{{$template_root}}/images/edit_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href='admin.php?controller=admin_pro&action=pass_edit&id={{$alldev[t].id}}&ip={{$ip}}&serverid={{$serverid}}&gid={{$gid}}'>{{$language.Edit}}</a>

				<img src='{{$template_root}}/images/delete_ico.gif' width=16 height='16' hspace='5' border='0' align='absmiddle'><a href="#" onClick="if(!confirm('{{$language.Delete_sure_}}？')) {return false;} else { location.href='admin.php?controller=admin_pro&action=devpass_del&id={{$alldev[t].id}}&ip={{$alldev[t].device_ip}}&serverid={{$serverid}}&gid={{$gid}}';}">{{$language.Delete}}</a>
				{{/if}}
				</td> 
			</tr>
			{{/section}}
			<tr>
	           <td  colspan="5" align="left"><input type="button"  value="添加" onClick="location.href='admin.php?controller=admin_pro&action=pass_edit&ip={{$ip}}&serverid={{$serverid}}&gid={{$gid}}'"  class="an_06">
				&nbsp;&nbsp;<input type="submit"  value="删除" onclick="my_confirm('{{$language.DeleteUsers}}');if(chk_form()) document.member_list.action='admin.php?controller=admin_pro&action=devpass_del&from=dev_priority_search'; else return false;" class="an_02">
		   </td>
              
	           <td  colspan="5" align="right">&nbsp;
		   			{{$language.all}}{{$total}}{{$language.Recorder}}  {{$page_list}}  {{$language.Page}}：{{$curr_page}}/{{$total_page}}{{$language.page}}  {{$items_per_page}}{{$language.Recorder}}/{{$language.page}}  {{$language.Goto}}<input name="pagenum" type="text" class="wbk" size="2" onKeyPress="if(event.keyCode==13) window.location='admin.php?controller=admin_pro&action=dev_index&serverid={{$serverid}}&page='+this.value;">{{$language.page}}&nbsp;&nbsp;&nbsp;{{if $smarty.session.ADMIN_LEVEL eq 3}}  导出：<a href="{{$curr_url}}&derive=1" target="hide"><img src="{{$template_root}}/images/excel.png" border=0></a>{{/if}}
		   </td>
		</tr>
		</form>
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



