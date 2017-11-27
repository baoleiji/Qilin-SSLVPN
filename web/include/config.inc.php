<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

//绔欑偣閰嶇疆
$_CONFIG = array();
$_CONFIG['site']['Language'] = "cn";
$_CONFIG['site']['SERVER_CONF'] = "conf/server.conf";
$_CONFIG['site']['items_per_page'] = 15;
$_CONFIG['site']['title'] = 'Audit';
$_CONFIG['site']['admin_email'] = '涔熶簯 <cfreely@hotmail>';
$_CONFIG['site']['probackup'] = '/home/hewu/release/pro-backup/';
$_CONFIG['site']['DATA_PATH'] = dirname(__FILE__).'/../';

$_CONFIG['backup']['authcode'] = 'abcdef';
//鎸囧畾tftp鏍圭洰褰?
$_CONFIG['TFTP_ROOT'] = '/tftpboot/';
//鎸囧畾澶栭儴璁块棶鏈満鐨則ftp浣跨敤鐨刬p
$_CONFIG['TFTP_SERVER_IP'] = '10.254.0.254';
$_CONFIG['DEVLOGIN_FORTIP'] = '127.0.0.1';
$_CONFIG['DEVLOGIN_FORTIP2'] = '222.35.62.134';
$_CONFIG['MONITORPORT'] = '22';
$_CONFIG['MONITORUSER'] = 'qq';
$_CONFIG['MONITORPASSWORD'] = 'marsec';
$_CONFIG['FTP_DOWNLOAD_PREFIX'] = '/opt/freesvr/audit/';
$_CONFIG['FTP_LOG_PATH_PREFIX'] = '/ftplog/backup/';
$_CONFIG['HTTP_LOG_PATH_PREFIX'] = '/httplog/backup/';
$_CONFIG['ORACLE_LOG_PATH_PREFIX'] = '/oraclelog/backup/';


$_CONFIG['CONFIGFILE']['SERVERCONF'] = '/opt/freesvr/vpn/etc/server.conf';
$_CONFIG['CONFIGFILE']['IFGETH_NUMBER'] = 2;
$_CONFIG['CONFIGFILE']['IFGETH0'] = '/etc/sysconfig/network-scripts/ifcfg-eth0';
$_CONFIG['CONFIGFILE']['IFGETH1'] = '/etc/sysconfig/network-scripts/ifcfg-ens3';
$_CONFIG['CONFIGFILE']['IFGETH2'] = '/etc/sysconfig/network-scripts/ifcfg-eth2';
$_CONFIG['CONFIGFILE']['IFGETH3'] = '/etc/sysconfig/network-scripts/ifcfg-eth3';
$_CONFIG['CONFIGFILE']['IFGETH4'] = '/etc/sysconfig/network-scripts/ifcfg-eth4';
$_CONFIG['CONFIGFILE']['IFGETH5'] = '/etc/sysconfig/network-scripts/ifcfg-eth5';
$_CONFIG['CONFIGFILE']['IFGETH6'] = '/etc/sysconfig/network-scripts/ifcfg-eth6';
$_CONFIG['CONFIGFILE']['IFGBR0'] = '/etc/sysconfig/network-scripts/ifcfg-br0';
$_CONFIG['CONFIGFILE']['IFGBR1'] = '/etc/sysconfig/network-scripts/ifcfg-br1';

$_CONFIG['CONFIGFILE']['NETWORK'] = '/etc/sysconfig/network';
$_CONFIG['CONFIGFILE']['OPENVPGLOG'] = '/opt/freesvr/vpn/etc/openvpn-status.log';
$_CONFIG['CONFIGFILE']['RCLOCAL'] = '/etc/rc.local';
$_CONFIG['CONFIGFILE']['SSH'] = '/opt/freesvr/audit/authd/etc/freesvr_authd_config';
$_CONFIG['CONFIGFILE']['SFTP'] = '/opt/freesvr/audit/sshgw-audit/etc/freesvr-ssh-proxy_config';
$_CONFIG['CONFIGFILE']['FTP'] = '/opt/freesvr/audit/ftp-audit/etc/freesvr-ftp-audit.conf';
$_CONFIG['CONFIGFILE']['TELNET'] = '/opt/freesvr/audit/etc/global.cfg';
$_CONFIG['CONFIGFILE']['RADCONF'] = '/opt/freesvr/vpn/etc/rad.conf';
$_CONFIG['CONFIGFILE']['RDP'] = '/etc/xrdp/global.cfg';
$_CONFIG['CONFIGFILE']['DNS'] = '/etc/resolv.conf';
$_CONFIG['CONFIGFILE']['VPNIP'] = '/opt/freesvr/vpn/etc/ccd/ipp.txt';
$_CONFIG['CONFIGFILE']['VPNCUT'] = '/opt/freesvr/audit/bin/kill_vpn.pl';
$_CONFIG['CONFIGFILE']['CNF'] = '/opt/freesvr/audit/etc/global.cfg';
$attributes = array();

$attributes[] = array(
					'name' => 'Crypt-Password',
					'op' => ':=',
					'default' => '',
				);

$attributes[] = array(
					'name' => 'Service-Type',
					'op' => ':=',	
					'default' => '',
				);

$attributes[] = array(
					'name' => 'cisco-avpair',
					'op' => '=',	
					'default' => 'shell:priv-lvl=',
				);
$attributes[] = array(
					'name' => 'Reply-Message',
					'op' => '=',
					'default' => '',
				);
$attributes[] = array(
					'name' => 'Huawei-Exec-Privilege',
					'op' => ':=',
					'default' => '',
				);
$_CONFIG['attributes'] = $attributes;
$config_type = array();

$config_type[] = array(
			'name' => 'Linux閰嶇疆鏂囦欢',
			'facility' => array(
				0 => 2,
			),
			'class' => 'linux_config',
			'type' => 'rsync',
			'path' => '',
		);
$config_type[] = array(
			'name' => 'Tripwire鏂囦欢',
			'facility' => array(
				0 => 2,
			),
			'class' => 'linux_config',
			'type' => 'rsync',
			'path' => '',
		);
$config_type[] = array(
			'name' => 'running-config',
			'facility' => array(
				0 => 1,
			),
			'class' => 'cisco_config',
			'type' => 'cisco_config',
			'file' => 'running-config',
		);
$config_type[] = array(
			'name' => 'startup-config',
			'facility' => array(
				0 => 1,
			),
			'class' => 'cisco_config',
			'type' => 'cisco_config',
			'file' => 'startup-config',
		);
$config_type[] = array(
			'name' => 'devlogin-config',
			'network_segment' => '10.0.0.0',
			'fortip' => '222.35.62.134'
		);

$_CONFIG['config_type'] = $config_type;
$_CONFIG['textname']='User-Password';
$_CONFIG['password'] = "\$1\$qY9g/6K4";

$_CONFIG['crypt']=0;
$_CONFIG['Web_AUTORUN']="c:\\freesvr\\desktop\\web_browser.exe";
$_CONFIG['Sysbase_AUTORUN']="c:\\zy\\database.exe";
$_CONFIG['Oracle_AUTORUN']="c:\\zy\\database.exe";
$_CONFIG['apppub_AUTORUN']="c:\\freesvr\\Desktopapp\\DesktopApp.exe";
$_CONFIG['REPORT_PATH'] = '/home/hewu/workbench/report/';
$_CONFIG['SEARCH_HTML_LOG'] = '/opt/freesvr/audit/gateway/log/bin/search_html_log.pl';
$_CONFIG['SEARCH_RDP_LOG'] = '/opt/freesvr/audit/gateway/log/bin/search_rdp_log.pl';
$_CONFIG['PASSWORD_USER_DOWNLOAD'] = '/opt/freesvr/audit/etc/desdevs.txt.gz';
$_CONFIG['EDITPASSWORD'] = '/home/hewu/workbench/pwd_changer/pwd-changer-1.1.0';
$_CONFIG['PASSWORD_USER_DOWN'] = '/opt/freesvr/audit/etc/changepassword/';
$_CONFIG['TIMEOUT_MINUTES'] = 30;
$_CONFIG['RDP_CUTOFF'] = '/etc/freesvr-monitor/bin/client';
$_CONFIG['RUNNING_CUTOFF'] = '/opt/freesvr/audit/gateway/log/bin/kill_pid.pl';
$_CONFIG['HACF'] = '/etc/keepalived/keepalived.conf';
$_CONFIG['HACFQIANGZHAN'] = '/opt/freesvr/audit/sbin/ha.sh';
$_CONFIG['HARESOURCES'] = '/etc/ha.d/haresources';
$_CONFIG['SSHPUBLICKEY'] = '/opt/freesvr/authorized_keys';
$_CONFIG['SSHPRIVATEKEYDIR'] = '/opt/freesvr/sshprivatekey';
$_CONFIG['NTPKEYS'] = '/etc/ntp/keys';
$_CONFIG['NTPNAGIOS'] = '/var/spool/cron/freesvr';
$_CONFIG['NTPNAGIOS2'] = '/etc/ntp.conf';
$_CONFIG['RDPSERVER1'] = '/etc/xrdp/global.cfg';
$_CONFIG['RDPSERVER2'] = '/etc/xrdp/global.cfg';
$_CONFIG['DATABASE_BLACKLIST'] = '/opt/freesvr/audit//etc/oracle_black_list.conf';
$_CONFIG['EDITPASSWORD2'] = '/opt/freesvr/audit/passwd/sbin/freesvr-passwd';
$_CONFIG['NETDISKPATH'] = '/opt/freesvr/audit/netdisk';
$_CONFIG['SOFTDOWNPATH'] = '/opt/freesvr/audit/softdown';
$_CONFIG['CAFILEPATH'] = '/opt/freesvr/web/CA/';
$_CONFIG['PASSEDITSSHPRIVATEKEY'] = '/opt/freesvr/audit/sshgw-audit/keys';//sshprivatekey表中的
$_CONFIG['PASSEDITSSHPULICKEY'] = '/opt/freesvr/audit/sshgw-audit/keys/pubkeys';//sshpublickey表中的
$_CONFIG['PASSEDITSSHPRIVATEKEY_NEW'] = '/opt/freesvr/audit/sshgw-audit/keys/pvt';//sshprivatekey表中的
$_CONFIG['PASSEDITSSHPULICKEY_NEW'] = '/opt/freesvr/audit/sshgw-audit/keys/pub';//sshpublickey表中的
$_CONFIG['LOGIN_DEBUG'] = 0;
$_CONFIG['DB_DEBUG'] = 0;
$_CONFIG['ACTIVEX_VERSION'] = '1,0,1,2';
$_CONFIG['PASSWORD_BAN_WORD'] = '&1"1\'1<1>\\';
$_CONFIG['PASSWORDUSER'] = 1;
$_CONFIG['OTHER_MEMBER_RADIUS'] = 0;
$_CONFIG['AUTOBACKUPDIR'] = '/opt/freesvr/audit/autorun/script';
$_CONFIG['AUTORUNDIR'] = '/opt/freesvr/audit/autorun';
$_CONFIG['AUTOTEMPLATEDIR'] = '/opt/freesvr/audit/autorun/script';
$_CONFIG['Version'] = '1.1';
$_CONFIG['CACTI_ON'] = '1';
$_CONFIG['LOG_ON'] = '1';
$_CONFIG['DBAUDIT_ON'] = '0';
$_CONFIG['db-audit'] = '0';
$_CONFIG['RANDOM_DB'] = '0';
$_CONFIG['APP_HOST'] = '127.0.0.1';
$_CONFIG['IE']="C:\\Program Files\\Internet Explorer\\iexplore.exe";
$_CONFIG['Radmin']="C:\\freesvr\\radmin\\Radmin.exe";
$_CONFIG['Xbrowser']="C:\\Program Files\\NetSarang\\Xmanager Enterprise 3\\Xbrowser.exe";
$_CONFIG['PLSQL']="C:\\Program Files\\PLSQL Developer\\plsqldev.exe";
$_CONFIG['PL_SQL']=20;
$_CONFIG['BACKUP_SCRIPT']="/home/lwm/backup_script/backup_script.pl";
$_CONFIG['FREESVR_UDF']="/opt/freesvr/audit/udf/etc/freesvr_udf.conf";
$_CONFIG['CREATE_LOG_USER'] = '0';
$_CONFIG['BAOLEIJI_IP']='118.186.17.101';
$_CONFIG['IPTABLES'] = '/etc/sysconfig/iptables';
$_CONFIG['SNMP'] = '/etc/snmp/snmpd.conf';
$_CONFIG['REPORT_FILE_PATH'] = '/opt/freesvr/audit/file/reports/';
$_CONFIG['AD_USERS']=array("Users","Administrator","Guest","SUPPORT_388945a0","ASPNET","HelpServicesGroup","TelnetClients","krbtgt","Domain Computers","Domain Controllers","Schema Admins","Enterprise Admins","Cert Publishers","Domain Admins","Domain Users","Domain Guests","Group Policy Creator Owners","RAS and IAS Servers","DnsAdmins","DnsUpdateProxy");
$_CONFIG['IFCFG-BR-DIR']='/etc/sysconfig/network-scripts';
$_CONFIG['XUNJIANBACKUP'] = '1';
$_CONFIG['DEPART_ADMIN'] = '1';//0 member 1 device
$_CONFIG['ADMINAUDIT'] = '0';
$_CONFIG['SYSTEMVERSION'] = '5';//network
$_CONFIG['SYSTEMVERSION_IPTABLES'] = '7';//iptables
$_CONFIG['SNMP'] = '/etc/snmp/snmpd.conf';
$_CONFIG['TREEMODE'] = '1';//为0资源组选择是下拉，为1是弹出dtree
$_CONFIG['IMPORTFILEPATH'] = '/opt/freesvr/audit/log/upload/';
$_CONFIG['RDPREPLAYIP'] = '';
$_CONFIG['interfacesn'] = '123456789';
$_CONFIG['interfacesn_on'] = 1;
$_CONFIG['LDAPCLIENT'] = '0';
$_CONFIG['RZ_URL'] = '222.35.42.196:5180';//回调地址

////sms config
$_CONFIG['SMS_ID'] = 1;//0 miaodiyun,1 
$_CONFIG['SMS'][0]['SMS_BASE_URL'] = "https://api.miaodiyun.com/20150822/";
$_CONFIG['SMS'][0]['SMS_ACCOUNT_SID'] = "572b53131afe46cea46b6f7593204bde";
$_CONFIG['SMS'][0]['SMS_AUTH_TOKEN']  = "90be290d5d6940ad8745b591ec86093a";
$_CONFIG['SMS'][0]['SMS_funAndOperate'] = "industrySMS/sendSMS";
$_CONFIG['SMS'][1]['WSDL']='http://www.fjsalt.com/webservice/SBasics.asmx?wsdl';
$_CONFIG['SMS'][1]['USERNAME']='魏永国';
$_CONFIG['SMS'][1]['PWD']='6666';
$_CONFIG['SMS'][2]['WSDL']='http://211.138.84.238:9090/axis/services/SmOutAccess?wsdl';
$_CONFIG['SMS'][2]['jkxlh']='70e0bb2cfdfa44799ff3a81be63cded8';
$_CONFIG['ACCEPT_FILE'] = '/opt/freesvr/audit/etc/accept.txt';
$_CONFIG['vpnconfig'] = '0';
?>
