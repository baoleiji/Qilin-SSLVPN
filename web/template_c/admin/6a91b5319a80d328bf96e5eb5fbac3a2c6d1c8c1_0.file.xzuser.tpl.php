<?php /* Smarty version 3.1.27, created on 2017-01-03 00:05:21
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/xzuser.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:534059761586a7a41b971e9_00817342%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a91b5319a80d328bf96e5eb5fbac3a2c6d1c8c1' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/otp/template/admin/xzuser.tpl',
      1 => 1483239516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '534059761586a7a41b971e9_00817342',
  'variables' => 
  array (
    'template_root' => 0,
    'allsgroup' => 0,
    'allmem' => 0,
    'select_group_id' => 0,
    'departmanagersgroupids' => 0,
    'pre' => 0,
    'allgroups' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_586a7a41c5bd25_06893731',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_586a7a41c5bd25_06893731')) {
function content_586a7a41c5bd25_06893731 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '534059761586a7a41b971e9_00817342';
?>
<!DOCTYPE html PUBLIC "-//w3c//dtd html 4.0 transitional//en" ""><HTML><HEAD><META 
content="IE=5.0000" http-equiv="X-UA-Compatible">
 <TITLE></TITLE> 
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<META name="GENERATOR" content="MSHTML 11.00.9600.16428"> 
<META name="author" content="nuttycoder"> 
<LINK href="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/all_purpose_style.css" rel="stylesheet" type="text/css"> 
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="./template/admin/cssjs/global.functions.js"><?php echo '</script'; ?>
>
<link type="text/css" rel="stylesheet" href="./template/admin/cssjs/jscal2.css" />
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['template_root']->value;?>
/cssjs/_ajaxdtree.js"><?php echo '</script'; ?>
>
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
<?php echo '<script'; ?>
 type="text/javascript">
var servergroup = new Array();
var i=0;
<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['a'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['a']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['name'] = 'a';
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allsgroup']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['a']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['a']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['a']['total']);
?>
servergroup[i++]={id:<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['id'];?>
,name:'<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['groupname'];?>
',ldapid:<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['ldapid'];?>
,level:<?php echo $_smarty_tpl->tpl_vars['allsgroup']->value[$_smarty_tpl->getVariable('smarty')->value['section']['a']['index']]['level'];?>
};
<?php endfor; endif; ?>
var AllMember = new Array();

<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['name'] = 'kk';
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allmem']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['kk']['total']);
?>
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
] = new Array();
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['username']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['username'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['realname']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['realname'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['uid']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['uid'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['groupid']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['groupid'];?>
';
AllMember[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['kk']['index'];?>
]['check']='<?php echo $_smarty_tpl->tpl_vars['allmem']->value[$_smarty_tpl->getVariable('smarty')->value['section']['kk']['index']]['check'];?>
';
<?php endfor; endif; ?>

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
<?php echo '</script'; ?>
>
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
				<?php if (!$_smarty_tpl->tpl_vars['select_group_id']->value) {
$_smarty_tpl->tpl_vars['select_group_id'] = new Smarty_Variable('groupid', null, 0);
}?>
                   <div  class="dtreecob"> 
                    <div class="dtree"  id="<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
dtree" style="overflow:auto; width:100%;height:260px;">
		<?php echo '<script'; ?>
 type="text/javascript">
<!--
departmanagersgroupids = '<?php echo $_smarty_tpl->tpl_vars['departmanagersgroupids']->value;?>
';
		<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d = new dTree('<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d','<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
dtree');
		<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d.config.menu=2;
		<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d.add(0,-1,0,1, '资源组','javascript:selectgroup(0);');
		<?php $_smarty_tpl->tpl_vars['allgroups'] = new Smarty_Variable($_smarty_tpl->tpl_vars[''.(((string)$_smarty_tpl->tpl_vars['pre']->value)."allsgroup")]->value, null, 0);?>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['g'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['g']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['name'] = 'g';
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['allgroups']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['g']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['g']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['g']['total']);
?>
			<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d.add(<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['ldapid'];?>
,'',<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['count'];?>
,'<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['groupname'];?>
','javascript:selectgroup(<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
);','<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['groupname'];?>
',null,<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d.icon.folder);
		<?php endfor; endif; ?>
		<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d.show();
		//document.write(<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d);
// -->
		<?php echo '</script'; ?>
>
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
<?php echo '<script'; ?>
>
//createdtree('');
<?php echo '</script'; ?>
>
</BODY></HTML>
<?php }
}
?>