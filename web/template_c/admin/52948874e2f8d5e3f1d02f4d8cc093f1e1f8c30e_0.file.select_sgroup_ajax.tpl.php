<?php /* Smarty version 3.1.27, created on 2017-05-07 08:26:28
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/template/admin/select_sgroup_ajax.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1162095256590e69b4540a44_53839158%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '52948874e2f8d5e3f1d02f4d8cc093f1e1f8c30e' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/template/admin/select_sgroup_ajax.tpl',
      1 => 1483239516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1162095256590e69b4540a44_53839158',
  'variables' => 
  array (
    'select_group_id' => 0,
    'group_tip' => 0,
    'inputtype' => 0,
    'popsize' => 0,
    'checkbox' => 0,
    'direction' => 0,
    'addgroup' => 0,
    'multipleselect' => 0,
    'departmanagersgroupids' => 0,
    'pre' => 0,
    'allgroups' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_590e69b45b7e20_03686547',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_590e69b45b7e20_03686547')) {
function content_590e69b45b7e20_03686547 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1162095256590e69b4540a44_53839158';
if (!$_smarty_tpl->tpl_vars['select_group_id']->value) {
$_smarty_tpl->tpl_vars['select_group_id'] = new Smarty_Variable('groupid', null, 0);
}?>
<?php if (!$_smarty_tpl->tpl_vars['group_tip']->value) {
$_smarty_tpl->tpl_vars['group_tip'] = new Smarty_Variable('资源组', null, 0);
}?>

<style>
.dtreecob {	font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;	font-size: 12px;	color: #666;	white-space: nowrap;	display:none;	border:1px solid #6699cc;		position: absolute; 	z-index: 9999;	background-color:white;	width:378px;}
.dBottom{background-color:#F0F0F0; margin-bottom:0px; text-align:right; height:23px;line-height:23px; }
.dBottom a{	margin-right:5px;color:black;text-decoration: none;	}
</style>
   <?php if (!$_smarty_tpl->tpl_vars['inputtype']->value || $_smarty_tpl->tpl_vars['inputtype']->value == 'text') {
echo $_smarty_tpl->tpl_vars['group_tip']->value;?>
：<?php }?><input type="hidden" id="<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
dh" name="<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
" value="0" />
 <input type="<?php if (!$_smarty_tpl->tpl_vars['inputtype']->value || $_smarty_tpl->tpl_vars['inputtype']->value == 'text') {?>text<?php } else { ?>button<?php }?>" class="wbk input_shorttext"  value="<?php if ($_smarty_tpl->tpl_vars['inputtype']->value && $_smarty_tpl->tpl_vars['inputtype']->value != 'text') {
echo $_smarty_tpl->tpl_vars['inputtype']->value;
}?>" style="width:<?php if ($_smarty_tpl->tpl_vars['popsize']->value) {
echo $_smarty_tpl->tpl_vars['popsize']->value;
} elseif ($_smarty_tpl->tpl_vars['checkbox']->value) {?>500<?php } else { ?>150<?php }?>px" id="<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
dpop" name=""  onClick='showTree(this,"<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d"<?php if ($_smarty_tpl->tpl_vars['direction']->value == "up") {?>,"up"<?php }?>)' readonly="readonly" />	

<div id="<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
dcombdtree" class="dtreecob">
		<p><a href="javascript: <?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d.openAll();">全部打开</a> | <a href="javascript: <?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d.closeAll();">全部折叠</a> | <a href="javascript:<?php if ($_smarty_tpl->tpl_vars['addgroup']->value) {?>checkS();<?php }?>hiddenDTree('<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d');">取消</a><?php if ($_smarty_tpl->tpl_vars['multipleselect']->value) {?> | <a href="javascript:<?php if ($_smarty_tpl->tpl_vars['checkbox']->value) {?>setSrcValue('','','<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d',<?php if ($_smarty_tpl->tpl_vars['addgroup']->value) {?>0<?php } else { ?>1<?php }?>,<?php if ($_smarty_tpl->tpl_vars['checkbox']->value) {?>1<?php } else { ?>0<?php }?>,'<?php echo $_smarty_tpl->tpl_vars['departmanagersgroupids']->value;?>
')<?php }?>;<?php if ($_smarty_tpl->tpl_vars['addgroup']->value) {?>selectgroup(0,'')<?php }?>;hiddenDTree('<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d');">保存</a><?php }?></p>
		<div class="dtree" id="<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
dtree" style="overflow: auto; width: 100%;">
		<?php echo '<script'; ?>
 type="text/javascript">
<!--
departmanagersgroupids = '<?php echo $_smarty_tpl->tpl_vars['departmanagersgroupids']->value;?>
';
		<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d = new dTree('<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d','<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
dtree');
		<?php if ($_smarty_tpl->tpl_vars['checkbox']->value) {?>
		<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d.config.checkbox=true;
		<?php }?>
		<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d.config.setop=<?php if ($_smarty_tpl->tpl_vars['addgroup']->value) {?>false<?php } else { ?>true<?php }?>;
		<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d.add(0,-1,0,1, '资源组','javascript:setSrcValue(\'\',0,\'<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
1\',<?php if ($_smarty_tpl->tpl_vars['inputtype']->value == "text") {?>1<?php } else { ?>0<?php }?>);hiddenDTree(\'<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
\');');
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
,'<?php if ($_smarty_tpl->tpl_vars['checkbox']->value) {?><input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d_group[]" id="group_<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['groupname'];?>
" gid="<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
" gname="<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['groupname'];?>
"  onclick="checkgroup(this.checked,<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d);"><?php }
echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['groupname'];?>
','javascript:setSrcValue(\'<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['groupname'];?>
\',<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['id'];?>
,\'<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d\',<?php if ($_smarty_tpl->tpl_vars['addgroup']->value) {?>0<?php } else { ?>1<?php }?>,<?php if ($_smarty_tpl->tpl_vars['checkbox']->value) {?>1<?php } else { ?>0<?php }?>,\'<?php echo $_smarty_tpl->tpl_vars['departmanagersgroupids']->value;?>
\');','<?php echo $_smarty_tpl->tpl_vars['allgroups']->value[$_smarty_tpl->getVariable('smarty')->value['section']['g']['index']]['groupname'];?>
',null,<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d.icon.folder);
		<?php endfor; endif; ?>
		<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d.show();
		//document.write(<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d);
// -->
<?php echo '</script'; ?>
></div>
		<div class="dBottom"><a href="javascript:hiddenDTree('<?php echo $_smarty_tpl->tpl_vars['select_group_id']->value;?>
d');">关闭</a></div>
		</div><?php }
}
?>