<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />

</head>
 <SCRIPT language=javascript src="{{$template_root}}/images/selectdate.js"></SCRIPT>
 <style>
 .operate {
	width: 60px; height: 20px; padding-top:5px; padding-bottom:5px;
}

.operate_common{
	position: absolute; top: 0px; left: 0px;  background-color: #FFFFFF; visibility: hidden; margin-bottom:8px; overflow: hidden; border: 1px solid #92B7E5; 
}
 </style>
<script>

var AllMember = new Array();
i=0;
{{section name=kk loop=$allmem}}
AllMember[{{$smarty.section.kk.index}}] = new Array();
AllMember[{{$smarty.section.kk.index}}]['username']='{{$allmem[kk].username}}';
AllMember[{{$smarty.section.kk.index}}]['realname']='{{$allmem[kk].realname}}';
AllMember[{{$smarty.section.kk.index}}]['uid']='{{$allmem[kk].uid}}';
AllMember[{{$smarty.section.kk.index}}]['groupid']='{{$allmem[kk].groupid}}';
AllMember[{{$smarty.section.kk.index}}]['check']='{{$allmem[kk].check}}';
{{/section}}

function checkAll(c){
	var targets = document.getElementsByTagName('input');
	for(var j=0; j<targets.length; j++){
		if(targets[j].name.substring(0,5)=='Check'){
			targets[j].checked=c;
		}
	}
}
function reload(p1,p2,check){
	window.location=window.location+'&'+(check ? p1 : p2);
}


var menuTimer = null;

function show_menu(obj1,obj2,state,location,keyid){ 
    var btn=document.getElementById(obj1);
    var obj=document.getElementById(obj2);
    var h=btn.offsetHeight;
    var w=btn.offsetWidth;
    var x=btn.offsetLeft;
    var y=btn.offsetTop;
    obj.innerHTML=keyid;
   /* obj.onmouseover =function(){
        show_menu(obj1,obj2,'show',location,keyid);
    }*/
    obj.onmouseout =function(){
        show_menu(obj1,obj2,'hide',location);
    }
    
    while(btn=btn.offsetParent){y+=btn.offsetTop;x+=btn.offsetLeft;}
    
    var hh=obj.offsetHeight;
    var ww=obj.offsetWidth;
    var xx=obj.offsetLeft;
    var yy=obj.offsetTop;
    var obj2state=state.toLowerCase();
    var obj2location=location.toLowerCase();
    
    var showx,showy;

    if(obj2location=="left" || obj2location=="top" || obj2location=="right" || obj2location=="bottom"){
        if(obj2location=="left"){showx=x-ww;showy=y;}
        if(obj2location=="top"){showx=x;showy=y-hh;}
        if(obj2location=="right"){showx=x+w;showy=y;}
        if(obj2location=="bottom"){showx=x;showy=y+h;}
    }else{ 
        showx=xx;showy=yy;
    }
    obj.style.left=showx+"px";
    obj.style.top=showy+"px";
    if(state =="hide"){
        menuTimer =setTimeout("_hide_menu('"+ obj2 +"')", 1);
    }else{
        clearTimeout(menuTimer);
        obj.style.visibility ="visible";
    }
}
function _hide_menu(id){
    document.getElementById(id).style.visibility ="hidden";
}

</script>
<body>

<div id="opdiv" class="operate operate_common">

</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="middle" class="hui_bj"><div class="menu">
<ul>
</ul><span class="back_img"><A href="admin.php?controller=admin_member&action=keys_index&back=1"><IMG src="{{$template_root}}/images/back1.png" 
      width="80" height="30" border="0"></A></span>
</div></td></tr>
  <tr>
	<td class="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><form name="f1" method=post action="admin.php?controller=admin_member&action=keybinduser_save&keyid={{$keyid}}">
	<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top  class="BBtable">
		
	  <tr bgcolor="f7f7f7"><td></td><td>key:{{$key.keyid}}</td></tr>
		<tr>
		<td width="15%" align=right>
		{{$language.bind}}{{$language.User}}
		<table border=0 width="100%" style="border:0px;">
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示已授权<input type="checkbox" name='showcheckeduser' {{if $smarty.get.binduser eq 1}}checked{{/if}} value=1 onclick="reload('binduser=1','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">只显示未授权<input type="checkbox" name='showuncheckeduser' {{if $smarty.get.binduser eq 2}}checked{{/if}} value=2 onclick="reload('binduser=2','binduser=0',this.checked);"></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;"><input type="button" name='batchselect' class="an_06" value="批量选择" onclick="window.open('admin.php?controller=admin_pro&action=xzuser', 'newwindow','height=650, width=700, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=yes,location=no, status=no');" ></td></tr>
	  <tr><td align="right" style="border-bottom:0px;border-top:0px;border-left:0px;border-right:0px;">全选<input type="checkbox" value=2 onclick="checkAll(this.checked);"></td></tr>
	  </table>
		</td>
		<td width="85%">
		<table><tr >
		{{section name=g loop=$allmem}}
		{{if !$smarty.get.binduser or ($smarty.get.binduser eq 2 and !$allmem[g].binded) or ($smarty.get.binduser eq 1 and $allmem[g].binded)}}
		<td width="180"><input type="checkbox" name='Check{{$smarty.section.g.index}}' value='{{$allmem[g].uid}}'  {{$allmem[g].check}}>{{if $allmem[g].binded}}<font color="red">{{/if}}{{$allmem[g].username}}({{if $allmem[g].realname}}{{$allmem[g].realname|truncate_cn:"10":"..."}}{{else}}未设置{{/if}}){{if $allmem[g].binded}}</font>{{/if}}</td>{{if ($smarty.section.g.index +1) % 5 == 0}}</tr><tr>{{/if}}
		{{/if}}
		{{/section}}
		</tr></table>
	  </td>
	  </tr>
	 
	<tr><td></td><td><input type=submit  value="{{$language.Save}}" class="an_02"></td></tr></table>
</form>
	</td>
  </tr>
</table>
 
</body>
<iframe name="hide" height="0" frameborder="0" scrolling="no"></iframe>
</html>



