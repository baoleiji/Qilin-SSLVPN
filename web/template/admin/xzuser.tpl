<!DOCTYPE html PUBLIC "-//w3c//dtd html 4.0 transitional//en" ""><HTML><HEAD><META 
content="IE=5.0000" http-equiv="X-UA-Compatible">
 <TITLE></TITLE> 
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<META name="GENERATOR" content="MSHTML 11.00.9600.16428"> 
<META name="author" content="nuttycoder"> 
<LINK href="{{$template_root}}/all_purpose_style.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="{{$template_root}}/cssjs/jquery-1.10.2.min.js"></script>
<script src="./template/admin/cssjs/global.functions.js"></script>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<script type="text/javascript" src="{{$template_root}}/cssjs/_ajaxdtree.js"></script>
<style>
.dtreecob {
	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #666;
	border:1px solid #6699cc;	
	z-index: 9999;
	background-color:white;
	width:100%;
}
</style>
<script type="text/javascript">
var servergroup = new Array();
var i=0;
{{section name=a loop=$allsgroup}}
servergroup[i++]={id:{{$allsgroup[a].id}},name:'{{$allsgroup[a].groupname}}',ldapid:{{$allsgroup[a].ldapid}},level:{{$allsgroup[a].level}}};
{{/section}}
var AllMember = new Array();

{{section name=kk loop=$allmem}}
AllMember[{{$smarty.section.kk.index}}] = new Array();
AllMember[{{$smarty.section.kk.index}}]['username']='{{$allmem[kk].username}}';
AllMember[{{$smarty.section.kk.index}}]['realname']='{{$allmem[kk].realname}}';
AllMember[{{$smarty.section.kk.index}}]['uid']='{{$allmem[kk].uid}}';
AllMember[{{$smarty.section.kk.index}}]['groupid']='{{$allmem[kk].groupid}}';
AllMember[{{$smarty.section.kk.index}}]['check']='{{$allmem[kk].check}}';
{{/section}}

var selectedgroup = 0;
function selectgroup(groupid){
	selectedgroup = groupid;
	var useroptions = document.getElementById('useroptions');
	useroptions.options.length=0;
	for(var i=0; i<AllMember.length; i++){
		if(AllMember[i]['groupid']==groupid){
			useroptions.options[useroptions.options.length] = new Option(AllMember[i]['username']+'('+AllMember[i]['realname']+')', 'user_'+AllMember[i]['uid']);
			if(window.opener.document.getElementById('uid_'+AllMember[i]['uid'])!=null&&window.opener.document.getElementById('uid_'+AllMember[i]['uid'])!=undefined&&window.opener.document.getElementById('uid_'+AllMember[i]['uid']).checked){
				useroptions.options[useroptions.options.length-1].style.color="red";
			}
		}
	}
}
function movein(){
	var useroptions = document.getElementById('useroptions');
	var selected = document.getElementById('selected');
	for(var i=0; i<useroptions.options.length; i++){
		if(useroptions.options[i].selected){
			var found = false;
			for(var j=0; j<selected.options.length; j++){
				if(selected.options[j].value==useroptions.options[i].value) found = true;
			}
			if(!found){
				selected.options[selected.options.length] = new Option(useroptions.options[i]['text'], useroptions.options[i]['value']);
				useroptions.options.remove(i);
				i--;
			}
		}
	}
}
function moveout(){
	var useroptions = document.getElementById('useroptions');
	var selected = document.getElementById('selected');
	for(var i=0; i<selected.options.length; i++){
		if(selected.options[i].selected){			
			useroptions.options[useroptions.options.length] = new Option(selected.options[i]['text'], selected.options[i]['value']);
			selected.options.remove(i);
			i--;
		}
	}
}

function update(){
	var selected = document.getElementById('selected');
	var targets = window.opener.document.getElementsByTagName('input');
	for(var i=0; i<selected.options.length; i++){
		for(var j=0; j<targets.length; j++){
			if((targets[j].name.substring(0,5)=='Check'||targets[j].name.substring(0,6)=='member'||targets[j].name.substring(0,3)=='uid')&&targets[j].value==selected.options[i].value.substring(5)){
				targets[j].checked=true;
			}
		}
	}
	
}
function filter(){
	var username3 = document.getElementById('username3').value;
	var username2 = document.getElementById('username2').value;
	var useroptions = document.getElementById('useroptions');
	//createdtree(username2);
	useroptions.options.length=0;
	for(var i=0; i<AllMember.length; i++){
		if(/*window.opener.AllMember[i]['groupid']==selectedgroup &&*/ AllMember[i]['username']==username3){
			useroptions.options[useroptions.options.length] = new Option(AllMember[i]['username']+'('+AllMember[i]['realname']+')', 'user_'+AllMember[i]['uid']);
			if(window.opener.document.getElementById('uid_'+AllMember[i]['uid'])!=null&&window.opener.document.getElementById('uid_'+AllMember[i]['uid'])!=undefined&&window.opener.document.getElementById('uid_'+AllMember[i]['uid']).checked){
				useroptions.options[useroptions.options.length-1].style.color="red";
			}
		}
	}
}

function createdtree(filter){
	/*d = new dTree('d');
	d.add(0,-1,'资源组','javascript:selectgroup(0);');
	if(servergroup!=null)
	for(var i=0; i<servergroup.length; i++){
		if(filter.length==0 || (filter.length>0&&servergroup[i].name==filter))
		d.add(servergroup[i].id,servergroup[i].ldapid,servergroup[i].name,'javascript:selectgroup('+servergroup[i].id+');');
	}
	document.getElementById('dtree').innerHTML = d.toString();*/
}
</script>
 </HEAD> 
<BODY>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
  <TBODY>
  <TR>
    <TD>
      <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
        <TBODY>
        <TR>
          <TD align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <td width="75%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class=BBtable>
                  <tr>
                    <td>&nbsp;&nbsp;组查找
                      <INPUT name="username2" id="username2" type="text" style="width:80px;"> 
                        &nbsp;&nbsp;用户查找
                        <INPUT name="username3" id="username3" type="text" style="width:80px;">
                        &nbsp;
                        <INPUT class="an_02" type="submit" onclick="filter();" value="搜索"></td>
                  </tr>
                  <tr>
                    <td>
				{{if !$select_group_id}}{{assign var=select_group_id value='groupid'}}{{/if}}
                   <div  class="dtreecob"> 
                    <div class="dtree"  id="{{$select_group_id}}dtree" style="overflow:auto; width:100%;height:260px;">
		<script type="text/javascript">
<!--
departmanagersgroupids = '{{$departmanagersgroupids}}';
		{{$select_group_id}}d = new dTree('{{$select_group_id}}d','{{$select_group_id}}dtree');
		{{$select_group_id}}d.config.menu=2;
		{{$select_group_id}}d.add(0,-1,0,1, '资源组','javascript:selectgroup(0);');
		{{assign var=allgroups value=${{"`$pre`allsgroup"}}}}
		{{section name=g loop=$allgroups}}
			{{$select_group_id}}d.add({{$allgroups[g].id}},{{$allgroups[g].ldapid}},'',{{$allgroups[g].count}},'{{$allgroups[g].groupname}}','javascript:selectgroup({{$allgroups[g].id}});','{{$allgroups[g].groupname}}',null,{{$select_group_id}}d.icon.folder);
		{{/section}}
		{{$select_group_id}}d.show();
		//document.write({{$select_group_id}}d);
// -->
		</script>
				  </div>
				</div>
				</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>
  <select name="useroptions" size="80" multiple id="useroptions" ondblclick="movein();" style="height:200px; width:100%;">
  </select></td>
                  </tr>
                </table></td>
                <td align="center" bgcolor="#F7F7F7"><p>
                  <INPUT class="an_02" type="submit" value="增加" onclick="movein();">
                </p>
                  <p>&nbsp;</p>
                  <p>
                    <INPUT class="an_02" type="submit" value="删除" onclick="moveout();">
</p></td>
                <td width="25%" valign="top"><select multiple name="selected" size="80" id="selected" style="height:530px; width:100%;">
  </select></td>
              </tr>
              <tr>
                <td height="40" colspan="3" align="center" bgcolor="#f7f7f7">
				<input class="an_02" type="submit" value="提交" onclick="if(confirm('确定提交?')) {alert('请不要手动关闭窗口');update();window.close();}" > 
                   &nbsp;&nbsp;
                   <input class="an_02" type="submit" value="取消" onclick="window.close();"></td>
                </tr>
            </table>
            </TD></TR></TBODY></TABLE>
  </TR></TBODY></TABLE>
<DIV></DIV>
<script>
//createdtree('');
</script>
</BODY></HTML>
