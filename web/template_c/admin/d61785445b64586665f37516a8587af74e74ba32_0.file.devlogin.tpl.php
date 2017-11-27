<?php /* Smarty version 3.1.27, created on 2016-12-27 10:48:06
         compiled from "/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/devlogin.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:7688064045861d6669f6b53_12656644%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd61785445b64586665f37516a8587af74e74ba32' => 
    array (
      0 => '/opt/freesvr/web/htdocs/freesvr/audit/dep10/template/admin/devlogin.tpl',
      1 => 1474793216,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7688064045861d6669f6b53_12656644',
  'variables' => 
  array (
    'logintool' => 0,
    'loginmethod' => 0,
    'ip' => 0,
    'port' => 0,
    'dusername' => 0,
    'username' => 0,
    'password' => 0,
    'dynamic_pwd' => 0,
    'entrust_password' => 0,
    'entrust_username' => 0,
    'sid' => 0,
    'proxy_addr' => 0,
    'member' => 0,
    'crttab' => 0,
    'webusername' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5861d666ae68b1_15210523',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5861d666ae68b1_15210523')) {
function content_5861d666ae68b1_15210523 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '7688064045861d6669f6b53_12656644';
if ($_smarty_tpl->tpl_vars['logintool']->value == 'putty') {?>freesvr://"&action=StartPutty&putty_path=c:\\freesvr\\ssh\\putty.exe&protocol=<?php echo $_smarty_tpl->tpl_vars['loginmethod']->value;?>
&host=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&port=<?php echo $_smarty_tpl->tpl_vars['port']->value;?>
&target_username=<?php echo $_smarty_tpl->tpl_vars['dusername']->value;?>
&target_ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
&password=<?php echo $_smarty_tpl->tpl_vars['password']->value;
echo $_smarty_tpl->tpl_vars['dynamic_pwd']->value;?>
&entrust_password=<?php echo $_smarty_tpl->tpl_vars['entrust_password']->value;
if ($_smarty_tpl->tpl_vars['loginmethod']->value == 'ssh' || $_smarty_tpl->tpl_vars['loginmethod']->value == 'ssh2') {?>&entrust_username=<?php echo $_smarty_tpl->tpl_vars['entrust_username']->value;
}?>&sid=<?php echo $_smarty_tpl->tpl_vars['sid']->value;?>
&vpnip=1.1.1.1&proxy_addr=<?php echo $_smarty_tpl->tpl_vars['proxy_addr']->value;?>
&debug=<?php echo $_SESSION['ADMIN_FREESVRDEBUG'];?>
&sshport=<?php echo $_smarty_tpl->tpl_vars['member']->value['sshport'];?>
&rdpport=<?php echo $_smarty_tpl->tpl_vars['member']->value['rdpport'];?>
&";
<?php } elseif ($_smarty_tpl->tpl_vars['logintool']->value == 'securecrt') {?>freesvr://"&action=StartSecureCRT&securecrt_path=c:\\freesvr\\ssh\\SecureCRT.lnk&protocol=<?php echo $_smarty_tpl->tpl_vars['loginmethod']->value;?>
&host=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&port=<?php echo $_smarty_tpl->tpl_vars['port']->value;?>
&target_username=<?php echo $_smarty_tpl->tpl_vars['dusername']->value;?>
&target_ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
&password=<?php echo $_smarty_tpl->tpl_vars['password']->value;
echo $_smarty_tpl->tpl_vars['dynamic_pwd']->value;?>
&entrust_password=<?php echo $_smarty_tpl->tpl_vars['entrust_password']->value;
if ($_smarty_tpl->tpl_vars['loginmethod']->value == 'ssh' || $_smarty_tpl->tpl_vars['loginmethod']->value == 'ssh2') {?>&entrust_username=<?php echo $_smarty_tpl->tpl_vars['entrust_username']->value;
}?>&sid=<?php echo $_smarty_tpl->tpl_vars['sid']->value;?>
&vpnip=1.1.1.1&proxy_addr=<?php echo $_smarty_tpl->tpl_vars['proxy_addr']->value;?>
&crttab=<?php echo $_smarty_tpl->tpl_vars['crttab']->value;?>
&debug=<?php echo $_SESSION['ADMIN_FREESVRDEBUG'];?>
&sshport=<?php echo $_smarty_tpl->tpl_vars['member']->value['sshport'];?>
&rdpport=<?php echo $_smarty_tpl->tpl_vars['member']->value['rdpport'];?>
&";
<?php } elseif ($_smarty_tpl->tpl_vars['logintool']->value == 'xshell') {?>freesvr://"&action=StartXshell&xshell_path=c:\\freesvr\\ssh\\SecureCRT.lnk&protocol=<?php echo $_smarty_tpl->tpl_vars['loginmethod']->value;?>
&host=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&port=<?php echo $_smarty_tpl->tpl_vars['port']->value;?>
&target_username=<?php echo $_smarty_tpl->tpl_vars['dusername']->value;?>
&target_ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
&password=<?php echo $_smarty_tpl->tpl_vars['password']->value;
echo $_smarty_tpl->tpl_vars['dynamic_pwd']->value;?>
&entrust_password=<?php echo $_smarty_tpl->tpl_vars['entrust_password']->value;
if ($_smarty_tpl->tpl_vars['loginmethod']->value == 'ssh' || $_smarty_tpl->tpl_vars['loginmethod']->value == 'ssh2') {?>&entrust_username=<?php echo $_smarty_tpl->tpl_vars['entrust_username']->value;
}?>&sid=<?php echo $_smarty_tpl->tpl_vars['sid']->value;?>
&vpnip=1.1.1.1&proxy_addr=<?php echo $_smarty_tpl->tpl_vars['proxy_addr']->value;?>
&crttab=<?php echo $_smarty_tpl->tpl_vars['crttab']->value;?>
&debug=<?php echo $_SESSION['ADMIN_FREESVRDEBUG'];?>
&sshport=<?php echo $_smarty_tpl->tpl_vars['member']->value['sshport'];?>
&rdpport=<?php echo $_smarty_tpl->tpl_vars['member']->value['rdpport'];?>
&";
<?php } elseif ($_smarty_tpl->tpl_vars['logintool']->value == 'xftp') {?>freesvr://"&action=StartXftp&xftp_path=c:\\freesvr\\ssh\\SecureCRT.lnk&protocol=<?php if ($_smarty_tpl->tpl_vars['loginmethod']->value != 'ftp') {?>sftp<?php } else { ?>ftp<?php }?>&host=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&port=<?php echo $_smarty_tpl->tpl_vars['port']->value;?>
&target_username=<?php echo $_smarty_tpl->tpl_vars['dusername']->value;?>
&target_ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
&password=<?php echo $_smarty_tpl->tpl_vars['password']->value;
echo $_smarty_tpl->tpl_vars['dynamic_pwd']->value;?>
&entrust_password=<?php echo $_smarty_tpl->tpl_vars['entrust_password']->value;
if ($_smarty_tpl->tpl_vars['loginmethod']->value == 'ssh' || $_smarty_tpl->tpl_vars['loginmethod']->value == 'ssh2') {?>&entrust_username=<?php echo $_smarty_tpl->tpl_vars['entrust_username']->value;
}?>&sid=<?php echo $_smarty_tpl->tpl_vars['sid']->value;?>
&vpnip=1.1.1.1&proxy_addr=<?php echo $_smarty_tpl->tpl_vars['proxy_addr']->value;?>
&crttab=<?php echo $_smarty_tpl->tpl_vars['crttab']->value;?>
&debug=<?php echo $_SESSION['ADMIN_FREESVRDEBUG'];?>
&sshport=<?php echo $_smarty_tpl->tpl_vars['member']->value['sshport'];?>
&rdpport=<?php echo $_smarty_tpl->tpl_vars['member']->value['rdpport'];?>
&";
<?php } elseif ($_smarty_tpl->tpl_vars['logintool']->value == 'flashxp') {?>freesvr://"&action=StartFlashXP&flash_path=c:\\freesvr\\sftp\\FlashXP.exe&protocol=<?php if ($_smarty_tpl->tpl_vars['loginmethod']->value == 'ssh') {?>sftp<?php } else {
echo $_smarty_tpl->tpl_vars['loginmethod']->value;
}?>&host=<?php echo $_smarty_tpl->tpl_vars['proxy_addr']->value;?>
&port=<?php echo $_smarty_tpl->tpl_vars['port']->value;?>
&target_username=<?php echo $_smarty_tpl->tpl_vars['dusername']->value;?>
&target_ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
&password=<?php echo $_smarty_tpl->tpl_vars['password']->value;
echo $_smarty_tpl->tpl_vars['dynamic_pwd']->value;?>
&entrust_password=<?php echo $_smarty_tpl->tpl_vars['entrust_password']->value;?>
&sid=<?php echo $_smarty_tpl->tpl_vars['sid']->value;?>
&vpnip=1.1.1.1&proxy_addr=<?php echo $_smarty_tpl->tpl_vars['proxy_addr']->value;?>
&debug=<?php echo $_SESSION['ADMIN_FREESVRDEBUG'];?>
&sshport=<?php echo $_smarty_tpl->tpl_vars['member']->value['sshport'];?>
&rdpport=<?php echo $_smarty_tpl->tpl_vars['member']->value['rdpport'];?>
&";
<?php } elseif ($_smarty_tpl->tpl_vars['logintool']->value == 'webssh') {?>webssh(0,'<?php echo $_smarty_tpl->tpl_vars['dusername']->value;?>
@<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
','http://<?php echo $_smarty_tpl->tpl_vars['proxy_addr']->value;?>
:9527/?title=<?php echo $_smarty_tpl->tpl_vars['dusername']->value;?>
@<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&host=<?php echo $_smarty_tpl->tpl_vars['proxy_addr']->value;?>
&port=22&username=<?php echo $_smarty_tpl->tpl_vars['webusername']->value;?>
&password=<?php echo $_smarty_tpl->tpl_vars['password']->value;
echo $_smarty_tpl->tpl_vars['dynamic_pwd']->value;?>
&sshport=<?php echo $_smarty_tpl->tpl_vars['member']->value['sshport'];?>
&rdpport=<?php echo $_smarty_tpl->tpl_vars['member']->value['rdpport'];?>
')
<?php } elseif ($_smarty_tpl->tpl_vars['logintool']->value == 'gateone') {?>webssh(1,'<?php echo $_smarty_tpl->tpl_vars['dusername']->value;?>
@<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
','admin.php?controller=admin_pro&action=gateone&title=<?php echo $_smarty_tpl->tpl_vars['dusername']->value;?>
@<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&host=<?php echo $_smarty_tpl->tpl_vars['proxy_addr']->value;?>
&port=22&username=<?php echo $_smarty_tpl->tpl_vars['webusername']->value;?>
&password=<?php echo $_smarty_tpl->tpl_vars['password']->value;
echo $_smarty_tpl->tpl_vars['dynamic_pwd']->value;?>
&sshport=<?php echo $_smarty_tpl->tpl_vars['member']->value['sshport'];?>
&rdpport=<?php echo $_smarty_tpl->tpl_vars['member']->value['rdpport'];?>
')
<?php } elseif ($_smarty_tpl->tpl_vars['loginmethod']->value == 'ftp' || $_smarty_tpl->tpl_vars['loginmethod']->value == 'sftp') {?>freesvr://"&action=StartWinscp&flash_path=c:\\freesvr\\sftp\\WinSCP.exe&protocol=<?php echo $_smarty_tpl->tpl_vars['loginmethod']->value;?>
&host=<?php echo $_smarty_tpl->tpl_vars['proxy_addr']->value;?>
&port=<?php echo $_smarty_tpl->tpl_vars['port']->value;?>
&target_username=<?php echo $_smarty_tpl->tpl_vars['dusername']->value;?>
&target_ip=<?php echo $_smarty_tpl->tpl_vars['ip']->value;?>
&username=<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
&password=<?php echo $_smarty_tpl->tpl_vars['password']->value;
echo $_smarty_tpl->tpl_vars['dynamic_pwd']->value;?>
&entrust_password=<?php echo $_smarty_tpl->tpl_vars['entrust_password']->value;
if ($_smarty_tpl->tpl_vars['loginmethod']->value == 'ssh' || $_smarty_tpl->tpl_vars['loginmethod']->value == 'ssh2') {?>&entrust_username=<?php echo $_smarty_tpl->tpl_vars['entrust_username']->value;
}?>&sid=<?php echo $_smarty_tpl->tpl_vars['sid']->value;?>
&vpnip=1.1.1.1&proxy_addr=<?php echo $_smarty_tpl->tpl_vars['proxy_addr']->value;?>
&debug=<?php echo $_SESSION['ADMIN_FREESVRDEBUG'];?>
&sshport=<?php echo $_smarty_tpl->tpl_vars['member']->value['sshport'];?>
&rdpport=<?php echo $_smarty_tpl->tpl_vars['member']->value['rdpport'];?>
&"
<?php }
}
}
?>