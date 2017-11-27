<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>{{$title}}</title>
<meta name="generator" content="editplus">
<meta name="author" content="nuttycoder">
<link href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css" />
<script src="./template/admin/cssjs/jscal2.js"></script>
<script src="./template/admin/cssjs/cn.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<style>
.tip{width:50px;border:0px solid #ddd;padding:8px;background:#f1f1f1;color:#666;} 
</style>
<script language="JavaScript">
window.onload=function(){
obj=new Date();
d=obj.getFullYear()+'-';
d+=(obj.getMonth()+1)<10?'0'+(obj.getMonth()+1):obj.getMonth()+1;
d+='-'+obj.getDate()+' '+obj.getHours()+':'+obj.getMinutes()+':'+obj.getSeconds();
form.dt.value=d;
}


function getdocument(t){
	var rightmainsrc = document.getElementById('rightmain').contentWindow.window.location.href;
	var pos = rightmainsrc.indexOf('&type=');
	if(pos>=0){
		rightmainsrc = rightmainsrc.substring(pos+6);
		pos =  rightmainsrc.indexOf('&');
		rightmainsrc = rightmainsrc.substring(0, pos);
		window.open('admin.php?controller=admin_index&action=getdocument&ip={{$ip}}&type='+rightmainsrc+'&doctype='+t);
	}
}

 var tip={$:function(ele){ 
  if(typeof(ele)=="object") 
    return ele; 
  else if(typeof(ele)=="string"||typeof(ele)=="number") 
    return document.getElementById(ele.toString()); 
    return null; 
  }, 
  mousePos:function(e){ 
    var x,y; 
    var e = e||window.event; 
    return{x:e.clientX+document.body.scrollLeft+document.documentElement.scrollLeft, y:e.clientY+document.body.scrollTop+document.documentElement.scrollTop}; 
  }, 
  start:function(obj){ 
    var self = this; 
    var t = self.$("mjs:tip"); 
	var mouse = self.mousePos(obj.event);   
      t.style.left = mouse.x - 25 + 'px'; 
      t.style.top = mouse.y + 10 + 'px'; 
      //t.innerHTML = obj.getAttribute("tips"); 
	  if(t.style.display=='none')
      t.style.display = ''; 
	  else
      t.style.display = 'none'; 

	/*
    obj.onmousemove=function(e){ 
      var mouse = self.mousePos(e);   
      t.style.left = mouse.x + 10 + 'px'; 
      t.style.top = mouse.y + 10 + 'px'; 
      t.innerHTML = obj.getAttribute("tips"); 
      t.style.display = ''; 
    }; 
    obj.onmouseout=function(){ 
      t.style.display = 'none'; 
    }; */
  } 
 } 
</script>
</head>

<body>
<div id="mjs:tip" class="tip" style="position:absolute;left:0;top:0;display:none;"><a href="#" onclick="getdocument('pdf');return false;" ><img src="{{$template_root}}/images/pdf.png" border=0></a>&nbsp;&nbsp;<a href="#" onclick="getdocument('html');return false;" ><img src="{{$template_root}}/images/html.png" border=0></a></div> 

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
<td valign="middle" class="hui_bj" colspan="2">
	<div class="menu">
	<ul>
	<li class="me_a"><img src="{{$template_root}}/images/an1.jpg" align="absmiddle"/><a href="#">详细信息</a><img src="{{$template_root}}/images/an3.jpg" align="absmiddle"/></li>
	</ul><span class="back_img"><input type="button" value="文档查看" onclick="tip.start(this);" />&nbsp;</span>
	</div>
</td>
</tr>
 <tr>
<td   width=100%>
<FORM id=main_form onSubmit="return false;" method=get name=results action=admin.php>
     <INPUT id="controller " value=admin_search type=hidden name=c>
      <INPUT id=action value=search type=hidden   name=a> 	

<table border=0 width=100% cellpadding=5 cellspacing=1 bgcolor="#FFFFFF" valign=top>

<!--************-->
<tr>
<td width="100%"   align="center">
	<table  width=100% class="BBtable">
	{{assign var="trnumber" value=0}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
		 <TD align="right" class=main_list_td1 width="15%">主机：</TD>
         <TD align="left" class=main_list_td1>
     						 {{$detail.host}}
         </TD>
	  	
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>设备：</TD>
                    <TD align="left" class=main_list_td1>
						{{$detail.facility}}
					</TD>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                   <TD align="right" class=main_list_td1>级别：</TD>
                    <TD align="left" class=main_list_td1>
						{{$detail.priority}}
					</TD>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                    <TD align="right" class=main_list_td1>等级：</TD>
                    <TD align="left" class=main_list_td1>
                   		{{$detail.level}}
                      </TD>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                      <TD align="right" class=main_list_td1>时间：</TD>
                    <TD align="left" class=main_list_td1>
    						{{$detail.datetime}}
                      </TD>
	</tr>
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                     <TD align="right" class=main_list_td1>程序</TD>
                    <TD align="left" class=main_list_td1>
						{{$detail.program}}
                      </TD>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                       <TD align="right" class=main_list_td1>标识：</TD>
                    <TD align="left" class=main_list_td1>
                   		{{$detail.tag}}
                      </TD>
	</tr>
	
	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                     <TD align="right" class=main_list_td1>日志内容：</TD>
                    <TD align="left" class=main_list_td1>
                   		{{$detail.msg}}
                      </TD>
	</tr>

	{{assign var="trnumber" value=$trnumber+1}}
	<tr {{if $trnumber % 2 == 0}}bgcolor="f7f7f7"{{/if}}>
                     <TD align="right" class=main_list_td1>探针：</TD>
                    <TD align="left" class=main_list_td1>
                   		{{$detail.logserver}}
                      </TD>
	</tr>
	<tr>
	<td colspan='2' align="center"><input type=button  value="关闭" onclick="window.close();"  class="bnnew2" ></td>
	</tr>
	</table>
</td>
</tr>
</table>

  
      

</FORM>
</td>


</tr>
</table>

 <script type="text/javascript">



function my_confirm(str){
	if(!confirm(str + "？"))
	{
		window.event.returnValue = false;
	}
}



</script>
</body>

</html>



