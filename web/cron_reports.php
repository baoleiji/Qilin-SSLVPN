<?php
set_time_limit(0);

if($argc < 2){
	echo 'param error';
	exit;
}
$dateinterval = $argv[1];
$type = $argv[2];
$start = $argv[3];
$end = $argv[4];
$diy_id = $argv[5];
//var_dump($argv);

$host = "localhost";
$username = "freesvr";
$pwd = "freesvr";
$dbname = "audit_sec";

mysql_connect($host, $username, $pwd) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());
mysql_query("set names utf8") or die(mysql_error());

switch($dateinterval){
	case 'month':		
		$start = (empty($argv[3]) ? date('Y-m-d') : $argv[3]);
		$ymd = explode('-', $start);
		$start = date('Y-m-d 00:00:00', mktime(0, 0, 0, $ymd[1]-1, 1, $ymd[0]));
		$end   = date('Y-m-d 23:59:59', mktime(0, 0, 0, $ymd[1], 0, $ymd[0]));
	break;
	case 'day':
		$start = empty($start) ? date('Y-m-d', mktime(0,0,1, date('m'), date('d')-1, date('Y'))) : $start;
		$end   = $start.' 23:59:59';
		$start = $start.' 00:00:00';
	break;
	case 'week':
		$start = (empty($argv[3]) ? date('Y-m-d') : $argv[3]);
		$ymd = explode('-', $start);
		$start = date('Y-m-d 00:00:00', mktime(0, 0, 0, $ymd[1], $ymd[2]-date('w')-7+1, $ymd[0]));
		$end   = date('Y-m-d 23:59:59', mktime(0, 0, 0, $ymd[1], $ymd[2]-date('w'), $ymd[0]));
	break;
	case 'diy':
		$start = empty($start) ? date('Y-m-d') : $start;
		$start = $argv[3];
		$start = $start.' 00:00:00';
		$end   = $end.' 23:59:59';
		$diyinfo = mysql_query("SELECT * FROM report_diy WHERE sid='".$diy_id."'");
		$diyinfo = mysql_fetch_array($diyinfo);
		//var_dump($diyinfo);
		$diy_ugroupid = $diyinfo['ugroupid'];
		$diy_sgroupid = $diyinfo['sgroupid'];
		$diy_username = $diyinfo['username'];
		$diy_server = $diyinfo['server'];

		if(empty($diy_ugroupid)){
			if($diy_ldapid2_u){
				$diy_ugroupid = $diy_ldapid2_u;
			}else if($diy_ldapid1_u){
				$diy_ugroupid = $diy_ldapid1_u;
			}
		}
		if(empty($diy_sgroupid)){
			if($ldapid2){
				$diy_sgroupid = $diy_ldapid2;
			}else if($diy_ldapid1){
				$diy_sgroupid = $diy_ldapid1;
			}
		}
		$diy_alltmpusername = array(-1);
		if(empty($diy_username)){
			$allusers = mysql_query("SELECT uid,username FROM member WHERE groupid=".$diy_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$diy_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$diy_ugroupid."))");
			while($row = mysql_fetch_array($allusers)){
				$diy_alltmpusername[]=$row['uid'];
			}
		}
		$diy_alltmpip = array(-1);
		if(empty($diy_server)){						
			$allips = mysql_query("SELECT device_ip FROM servers WHERE groupid=".$diy_ugroupid." or groupid IN(SELECT id FROM servergroup WHERE ldapid=".$diy_ugroupid.") or groupid IN(SELECT id FROM servergroup WHERE ldapid IN(SELECT id FROM servergroup WHERE ldapid=".$diy_ugroupid."))");
			while($row = mysql_fetch_array($allips)){
				$diy_alltmpip[]=$row['device_ip'];
			}
		}
	break;
	default:
	break;
}



//权限报表
echo ${'sql_admin_log_statistic_'.$dateinterval} = "INSERT INTO admin_log_".$dateinterval."(luser,action,resource,resource_user,optime,administrator,result,realname,groupname".($dateinterval=='diy' ? ',createid' : '').") SELECT a.luser,a.action,a.resource,a.resource_user,a.optime,a.administrator,a.result,b.realname,c.groupname".($dateinterval=='diy' ? ','.$diy_id : '')." FROM admin_log a LEFT JOIN member b ON a.luser=b.username LEFT JOIN servergroup c ON b.groupid=c.id WHERE 1=1 AND optime >='$start' AND optime <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND b.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND b.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND a.resource="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND a.resource IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." ORDER BY optime desc ";

echo ";\n\n";
echo ${'sql_accountrecord_statistic_'.$dateinterval} = "INSERT INTO account_record_".$dateinterval."(date,ip,user,uid,gid,home,shell,action".($dateinterval=='diy' ? ',createid' : '').") SELECT date,ip,user,uid,gid,home,shell,action".($dateinterval=='diy' ? ','.$diy_id : '')." FROM account_record WHERE 1=1 AND date >='$start' AND date <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND user="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND ip="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND ip IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." ORDER BY date desc ";

echo ";\n\n";
//登录报表
echo ${'sql_login_statistic_'.$dateinterval} = "INSERT INTO logintimes_".$dateinterval."(username,realname,groupname,sct,tct,rct,act,vct,fct,sfct,webct,xct,ct,start,serverip".($dateinterval=='diy' ? ',createid' : '').") select IFNULL(m.username,'') username,IFNULL(m.realname,'') realname,ug.groupname,IFNULL(s.sct,0) sct,IFNULL(t.tct,0) tct, IFNULL(r.rct,0) rct,IFNULL(a.act,0) act, IFNULL(f.fct,0) fct, IFNULL(sf.sfct,0) sfct, IFNULL(web.webct,0) webct,IFNULL(v.vct,0) vct,IFNULL(x.xct,0) xct,(IFNULL(s.sct,0)+IFNULL(a.act,0)+IFNULL(t.tct,0)+IFNULL(r.rct,0)+IFNULL(f.fct,0)+IFNULL(sf.sfct,0)+IFNULL(web.webct,0)+IFNULL(v.vct,0)+IFNULL(x.xct,0)) as ct,'$start' start,m.device_ip".($dateinterval=='diy' ? ','.$diy_id : '')."  from (select member.username,member.realname,member.groupid,servers.device_ip from member join servers WHERE 1 ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND member.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND member.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND servers.device_ip="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND servers.device_ip IN("'.implode('","', $diy_alltmpip).'")' : '')) : '').") m left join (select count(*) sct,luser,start,addr from sessions where start >= '$start' AND end <= '$end' AND type='ssh' AND 1 group by addr,luser) s on m.username=s.luser and m.device_ip=s.addr left join (select count(*) tct,luser,start,addr from sessions where start >= '$start' AND end <= '$end' AND type='telnet' AND 1 group by addr,luser) t on m.username=t.luser and m.device_ip=t.addr left join (select count(*) rct,luser,start,addr from rdpsessions where start >= '$start' AND end <= '$end' AND (LOGIN_TEMPLATE=8 ) AND 1 group by addr,luser) r on m.username=r.luser and m.device_ip=r.addr left join (select count(*) act,luser,start,addr from rdpsessions where start >= '$start' AND end <= '$end' AND (LOGIN_TEMPLATE=26) AND 1 group by addr,luser) a on m.username=a.luser and m.device_ip=a.addr left join (select count(*) vct,luser,start,addr from rdpsessions where start >= '$start' AND end <= '$end' AND (LOGIN_TEMPLATE=21) AND 1 group by addr,luser) v on m.username=v.luser and m.device_ip=v.addr left join (select count(*) xct,luser,start,addr from rdpsessions where start >= '$start' AND end <= '$end' AND (LOGIN_TEMPLATE=22) AND 1 group by addr,luser) x on m.username=x.luser and m.device_ip=x.addr left join (select count(*) fct,radius_user,start,svraddr from ftpsessions where start >= '$start' AND end <= '$end' AND 1 group by svraddr,radius_user) f on m.username=f.radius_user and m.device_ip=f.svraddr left join (select count(*) sfct,radius_user,start,svraddr from sftpsessions where start >= '$start' AND end <= '$end' AND 1 group by svraddr,radius_user) sf on m.username=sf.radius_user and m.device_ip=sf.svraddr left join (select count(*) webct,audituser,time,serverip from loginacct where time >= '$start' AND time <= '$end' and portocol='web' AND 1 group by serverip,audituser) web on m.username=web.audituser and m.device_ip=web.serverip LEFT JOIN servergroup ug ON m.groupid=ug.id WHERE 1 ORDER BY ct DESC  ";

echo ";\n\n";
echo ${'sql_loginacct_statistic_'.$dateinterval} = "INSERT INTO loginacct_".$dateinterval."(pid,time,sourceip,auditip,serverip,portocol,audituser,systemuser,authenticationstatus,failreason,realname,groupname".($dateinterval=='diy' ? ',createid' : '').") SELECT a.pid,a.time,a.sourceip,a.auditip,a.serverip,a.portocol,a.audituser,a.systemuser,a.authenticationstatus,a.failreason,m.realname,ug.groupname".($dateinterval=='diy' ? ','.$diy_id : '')." FROM loginacct a LEFT JOIN member m ON a.audituser=m.username LEFT JOIN servergroup ug ON ug.id=m.groupid WHERE 1=1 AND `time` >='$start' AND `time` <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND a.serverip="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND a.serverip IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." ORDER BY time desc  ";

echo ";\n\n";
echo ${'sql_loginfailed_statistic_'.$dateinterval} = "INSERT INTO loginfailed_".$dateinterval."(ct,serverip,sourceip,audituser,portocol,time".($dateinterval=='diy' ? ',createid' : '').") SELECT count(*) ct,serverip,a.sourceip,audituser,portocol,time".($dateinterval=='diy' ? ','.$diy_id : '')." FROM loginacct a left join member m on a.audituser=m.uid WHERE authenticationstatus=0 AND `time` >='$start' AND `time` <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND a.serverip="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND a.serverip IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." GROUP BY serverip,a.sourceip,audituser,portocol ORDER BY ct desc  ";

echo ";\n\n";
echo ${'sql_devlogin_statistic_'.$dateinterval} = "INSERT INTO devlogin_".$dateinterval."(luser,realname,groupname,device_ip,hostname,type,user,mstart,mend,ct".($dateinterval=='diy' ? ',createid' : '').") SELECT luser,realname,ug.groupname,t.device_ip,hostname,type,user,mstart,mend,ct".($dateinterval=='diy' ? ','.$diy_id : '')." FROM (SELECT a.luser,m.realname,m.groupid,a.type,a.user,if(locate(':',addr)=0, addr,left(addr, locate(':',addr)-1)) device_ip, MIN(start) mstart, MAX(start) mend,IFNULL(COUNT(*),0) ct FROM sessions a LEFT JOIN (SELECT COUNT(*) ct,sid FROM commands GROUP BY sid) bb ON bb.sid=a.sid LEFT JOIN member m ON a.luser=m.username WHERE 1=1 AND start >='$start' AND start <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND if(locate(":",addr)=0, addr,left(addr, locate(":",addr)-1))="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND if(locate(":",addr)=0, addr,left(addr, locate(":",addr)-1)) IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." GROUP BY if(locate(':',addr)<0, addr,left(addr, locate(':',addr)-1)),user,luser,type UNION SELECT a1.luser,m.realname,m.groupid,a1.type,a1.user,if(locate(':',addr)=0, addr,left(addr, locate(':',addr)-1)) device_ip, MIN(start) mstart, MAX(start) mend,IFNULL(COUNT(*),0) ct FROM rdpsessions a1 LEFT JOIN (SELECT COUNT(*) ct,sid FROM rdpinput GROUP BY sid) bb1 ON bb1.sid=a1.sid LEFT JOIN member m ON a1.luser=m.username WHERE 1=1 AND start >='$start' AND start <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND if(locate(":",addr)=0, addr,left(addr, locate(":",addr)-1))="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND if(locate(":",addr)=0, addr,left(addr, locate(":",addr)-1)) IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." GROUP BY if(locate(':',addr)<0, addr,left(addr, locate(':',addr)-1)),user,luser,type UNION SELECT a2.radius_user luser,m.realname,m.groupid,'sftp' type,a2.sftp_user user,if(locate(':',svraddr)=0, svraddr,left(svraddr, locate(':',svraddr)-1)) device_ip, MIN(start) mstart, MAX(start) mend,IFNULL(COUNT(*),0) ct FROM sftpsessions a2 LEFT JOIN (SELECT COUNT(*) ct,sid FROM sftpcomm GROUP BY sid) bb2 ON bb2.sid=a2.sid LEFT JOIN member m ON a2.radius_user=m.username WHERE 1=1 AND start >='$start' AND start <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND if(locate(":",svraddr)=0, svraddr,left(svraddr, locate(":",svraddr)-1))="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND if(locate(":",svraddr)=0, svraddr,left(svraddr, locate(":",svraddr)-1)) IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." GROUP BY if(locate(':',svraddr)<0, svraddr,left(svraddr, locate(':',svraddr)-1)),sftp_user,radius_user UNION SELECT a3.radius_user luser,m.realname,m.groupid,'ftp' type,a3.ftp_user user,if(locate(':',svraddr)=0, svraddr,left(svraddr, locate(':',svraddr)-1)) device_ip, MIN(start) mstart, MAX(start) mend,IFNULL(COUNT(*),0) ct FROM ftpsessions a3 LEFT JOIN (SELECT COUNT(*) ct,sid FROM ftpcomm GROUP BY sid) bb3 ON bb3.sid=a3.sid LEFT JOIN member m ON a3.radius_user=m.username WHERE 1=1 AND start >='$start' AND start <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND if(locate(":",svraddr)=0, svraddr,left(svraddr, locate(":",svraddr)-1))="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND if(locate(":",svraddr)=0, svraddr,left(svraddr, locate(":",svraddr)-1)) IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." GROUP BY if(locate(':',svraddr)<0, svraddr,left(svraddr, locate(':',svraddr)-1)),ftp_user,radius_user ) t LEFT JOIN servers s ON t.device_ip=s.device_ip LEFT JOIN servergroup ug ON t.groupid=ug.id WHERE 1 ORDER BY ct desc ";

echo ";\n\n";
echo ${'sql_applogin_statistic_'.$dateinterval} = "INSERT INTO applogin_".$dateinterval."(user,realname,groupname,serverip,appname,apppath,url,mstart,mend,ct".($dateinterval=='diy' ? ',createid' : '').") SELECT b.username user,b.realname,ug.groupname,serverip,a.appname,a.apppath,c.url, MIN(start) mstart, MAX(start) mend,count(*)".($dateinterval=='diy' ? ','.$diy_id : '')." FROM appcomm a LEFT JOIN member b ON a.memberid=b.uid LEFT JOIN apppub c ON a.serverip=c.appserverip and a.appname=c.name LEFT JOIN servergroup ug ON b.groupid=ug.id WHERE 1=1 AND start >='$start' AND start <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND b.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND b.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND serverip="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND serverip IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." GROUP BY serverip,appname,memberid ORDER BY count(*) desc ";

echo ";\n\n";
echo ${'sql_loginapproved_statistic_'.$dateinterval} = "INSERT INTO loginapproved_".$dateinterval."(webuser,realname,groupname,ip,username,login_method,applytime,approvetime,approveuser,logintime".($dateinterval=='diy' ? ',createid' : '').") SELECT m.username,m.realname,ug.groupname,login4approve.ip,login4approve.username,login4approve.login_method,login4approve.applytime,login4approve.approvetime,login4approve.approveuser,login4approve.logintime".($dateinterval=='diy' ? ','.$diy_id : '')." FROM login4approve LEFT JOIN member m ON login4approve.webuser=m.username LEFT JOIN servergroup ug ON m.groupid=ug.id WHERE approved = 2 AND logintime >='$start' AND logintime <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND login4approve.ip="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND login4approve.ip IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." ORDER BY logintime DESC ";

echo ";\n\n";
//操作报表
echo ${'sql_command_statistic_'.$dateinterval} = "INSERT INTO commandstatistic_".$dateinterval."(addr,luser,realname,groupname,user,mstart,mend,ct".($dateinterval=='diy' ? ',createid' : '').") SELECT a.addr, a.luser, m.realname,ug.groupname, a.user, MIN(start), MAX(start),SUM(bb.ct)".($dateinterval=='diy' ? ','.$diy_id : '')." FROM sessions a LEFT JOIN (SELECT COUNT(*) ct,sid FROM commands WHERE 1 GROUP BY sid) bb ON bb.sid=a.sid LEFT JOIN member m ON a.luser=m.username LEFT JOIN servergroup ug ON m.groupid=ug.id WHERE 1=1 AND start >='$start' AND start <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND addr="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND addr IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." GROUP BY addr,user,luser ORDER BY ct desc ";

echo ";\n\n";
echo ${'sql_cmdcache_statistic_'.$dateinterval} = "INSERT INTO cmdcache_".$dateinterval."(luser,realname,groupname,user,addr,ocmd,ct,at".($dateinterval=='diy' ? ',createid' : '').") SELECT a.luser,d.realname,ug.groupname,a.user,a.addr,b.cmd ocmd,COUNT(*) ct,b.at".($dateinterval=='diy' ? ','.$diy_id : '')." FROM (SELECt * FROM sessions WHERE start >='$start' AND start <='$end' ) a LEFT JOIN (SELECT * FROM commands WHERE at >='$start' AND at <='$end') b ON a.sid=b.sid LEFT JOIN cmdcache c ON lower(left(b.cmd, length(c.cmd)+1))=concat(lower(c.cmd), ' ') LEFT JOIN member d ON a.luser=d.username LEFT JOIN servergroup ug ON d.groupid=ug.id WHERE b.cid IS NOT NULL AND c.id IS NOT NULL ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND d.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND d.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND a.addr="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND a.addr IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." GROUP BY a.addr,a.luser,a.user, c.cmd  ";

echo ";\n\n";
echo ${'sql_cmdlist_statistic_'.$dateinterval} = "INSERT INTO cmdlist_".$dateinterval."(luser,realname,groupname,addr,cmd,at,dangerlevel".($dateinterval=='diy' ? ',createid' : '').") SELECT b.luser,m.realname,ug.groupname,b.addr,a.cmd,a.at,dangerlevel".($dateinterval=='diy' ? ','.$diy_id : '')."  FROM commands a LEFT JOIN sessions b ON a.sid=b.sid LEFT JOIN member m ON b.luser=m.username LEFT JOIN servergroup ug ON m.groupid=ug.id WHERE 1 AND at >='$start' AND at <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND b.addr="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND b.addr IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." ORDER BY at desc  ";

echo ";\n\n";
echo ${'sql_app_statistic_'.$dateinterval} = "INSERT INTO appreport_".$dateinterval."(luser,realname,groupname,user,serverip,appname,mstart,mend,ct".($dateinterval=='diy' ? ',createid' : '').") SELECT b.username ,b.realname,ug.groupname,r.user ,a.serverip,a.appname, MIN(a.start), MAX(a.start),count(*)".($dateinterval=='diy' ? ','.$diy_id : '')." FROM appcomm a LEFT JOIN rdpsessions r ON a.sid=r.sid LEFT JOIN member b ON a.memberid=b.uid LEFT JOIN servergroup ug ON b.groupid=ug.id WHERE 1=1 AND a.start >='$start' AND a.start <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND b.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND b.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND r.addr="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND r.addr IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." GROUP BY a.serverip,appname,memberid ORDER BY count(*) desc ";

echo ";\n\n";
echo ${'sql_sftpcmd_statistic_'.$dateinterval} = "INSERT INTO sftpreport_".$dateinterval."(radius_user,realname,groupname,sftp_user,putct,getct,ct,mstart,mend,serverip".($dateinterval=='diy' ? ',createid' : '').") SELECT radius_user,m.realname,ug.groupname,sftp_user,SUM(putct),SUM(getct),SUM(ct),MIN(start) mstart, MAX(start) mend,t.device_ip".($dateinterval=='diy' ? ','.$diy_id : '')." FROM (SELECT a.svraddr device_ip,a.sftp_user,a.radius_user,a.start,a.end, IF(b.ct,b.ct,0) putct,IF(c.ct,c.ct,0) getct,IF(bb.ct,bb.ct,0) ct FROM sftpsessions a LEFT JOIN (SELECT COUNT(*) ct,sid FROM sftpcomm WHERE LEFT(comm,3)='put' GROUP BY sid) b ON b.sid=a.sid LEFT JOIN (SELECT COUNT(*) ct,sid FROM sftpcomm WHERE LEFT(comm,3)='get' GROUP BY sid) c ON c.sid=a.sid LEFT JOIN (SELECT COUNT(*) ct,sid FROM sftpcomm WHERE 1 GROUP BY sid) bb ON bb.sid=a.sid WHERE 1 GROUP BY a.sid, radius_user,sftp_user) t LEFT JOIN member m ON t.radius_user=m.username LEFT JOIN servergroup ug ON ug.id=m.groupid WHERE 1=1 AND start >='$start' AND start <='$end'  ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND t.device_ip="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND t.device_ip IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." GROUP BY radius_user,sftp_user ORDER BY ct desc";

echo ";\n\n";
echo ${'sql_ftpcmd_statistic_'.$dateinterval} = "INSERT INTO ftpreport_".$dateinterval."(radius_user,realname,groupname,ftp_user,putct,getct,ct,mstart,mend,serverip".($dateinterval=='diy' ? ',createid' : '').") SELECT radius_user,m.realname,ug.groupname,ftp_user,SUM(putct),SUM(getct),SUM(ct),MIN(start) mstart, MAX(start) mend,t.device_ip ".($dateinterval=='diy' ? ','.$diy_id : '')." FROM (SELECT a.svraddr device_ip,a.ftp_user,a.radius_user,a.start,a.end, IF(b.ct,b.ct,0) putct,IF(c.ct,c.ct,0) getct,IF(bb.ct,bb.ct,0) ct FROM ftpsessions a LEFT JOIN (SELECT COUNT(*) ct,sid FROM ftpcomm WHERE LEFT(comm,3)='put' GROUP BY sid) b ON b.sid=a.sid LEFT JOIN (SELECT COUNT(*) ct,sid FROM ftpcomm WHERE LEFT(comm,3)='get' GROUP BY sid) c ON c.sid=a.sid LEFT JOIN (SELECT COUNT(*) ct,sid FROM ftpcomm WHERE 1 GROUP BY sid) bb ON bb.sid=a.sid WHERE 1 GROUP BY a.sid, radius_user,ftp_user) t LEFT JOIN member m ON t.radius_user=m.username LEFT JOIN servergroup ug ON ug.id=m.groupid WHERE 1=1 AND start >='$start' AND start <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND t.device_ip="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND t.device_ip IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." GROUP BY radius_user,ftp_user ORDER BY ct desc ";

echo ";\n\n";
//违规报表
echo ${'sql_dangercmd_statistic_'.$dateinterval} = "INSERT INTO dangercmdreport_".$dateinterval."(luser,realname,groupname,user,device_ip,cmd,ct,mstart,mend".($dateinterval=='diy' ? ',createid' : '').") SELECT a.luser,m.realname,ug.groupname,a.user,a.addr,bb.cmd,SUM(bb.ct), MIN(start), MAX(start)".($dateinterval=='diy' ? ','.$diy_id : '')." FROM sessions a LEFT JOIN (SELECT COUNT(*) ct,sid,cmd FROM commands WHERE dangerlevel > 0 GROUP BY sid,cmd) bb ON bb.sid=a.sid LEFT JOIN member m ON a.luser=m.username LEFT JOIN servergroup ug ON ug.id=m.groupid WHERE 1=1 AND a.start >='$start' AND a.start <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND a.addr="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND a.addr IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." AND ct > 0 GROUP BY addr,user,luser,cmd ORDER BY ct desc";

echo ";\n\n";
echo ${'sql_dangercmdlist_statistic_'.$dateinterval} = "INSERT INTO dangercmdlistreport_".$dateinterval."(luser,realname,groupname,user,device_ip,cmd,type,dangerlevel,at".($dateinterval=='diy' ? ',createid' : '').") SELECT bb.luser,m.realname,ug.groupname,bb.user,bb.addr,a.cmd,bb.type,dangerlevel,at".($dateinterval=='diy' ? ','.$diy_id : '')." FROM commands a LEFT JOIN sessions bb ON bb.sid=a.sid LEFT JOIN member m ON bb.luser=m.username LEFT JOIN servergroup ug ON ug.id=m.groupid WHERE 1=1 AND at >='$start' AND at <='$end' ".($dateinterval=='diy' ? (!empty($diy_username) ? ' AND m.username="'.$diy_username.'" ' : (!empty($diy_ugroupid) ? ' AND m.uid IN("'.implode('","', $diy_alltmpusername).'")' : '')) : '')." ".($dateinterval=='diy' ? (!empty($diy_server) ? ' AND bb.addr="'.$diy_server.'" ' : (!empty($diy_sgroupid) ? ' AND bb.addr IN("'.implode('","', $diy_alltmpip).'")' : '')) : '')." AND dangerlevel > 0 ORDER BY at desc";
echo ";\n\n";


switch($type){
	case 'all':		
		mysql_query(${'sql_admin_log_statistic_'.$dateinterval});
		echo "sql_admin_log_statistic_ updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_accountrecord_statistic_'.$dateinterval});
		echo "sql_accountrecord_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_login_statistic_'.$dateinterval});
		echo "sql_login_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_loginacct_statistic_'.$dateinterval});
		echo "sql_loginacct_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_loginfailed_statistic_'.$dateinterval});
		echo "sql_loginfailed_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_devlogin_statistic_'.$dateinterval});
		echo "sql_devlogin_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_applogin_statistic_'.$dateinterval});
		echo "sql_applogin_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_loginapproved_statistic_'.$dateinterval});
		echo "sql_loginapproved_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_command_statistic_'.$dateinterval});
		echo "sql_command_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_cmdcache_statistic_'.$dateinterval});
		echo "sql_cmdcache_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_cmdlist_statistic_'.$dateinterval});
		echo "sql_cmdlist_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_app_statistic_'.$dateinterval});
		echo "sql_app_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_sftpcmd_statistic_'.$dateinterval});
		echo "sql_sftpcmd_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_ftpcmd_statistic_'.$dateinterval});
		echo "sql_ftpcmd_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_dangercmd_statistic_'.$dateinterval});
		echo "sql_dangercmd_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		mysql_query(${'sql_dangercmdlist_statistic_'.$dateinterval});
		echo "sql_dangercmdlist_statistic_updated:".mysql_affected_rows().",errorno:".mysql_errno().",error:".mysql_error()."\n";
		if($diy_id)	mysql_query("UPDATE report_diy SET status=1,createtime=NOW() WHERE sid='$diy_id'");
	break;
	default:
		echo ${'sql_'.$type.'_'.$dateinterval};
		echo "\n";
		mysql_query(${'sql_'.$type.'_'.$dateinterval});
		echo "updated:".mysql_affected_rows()."\n";
		if($diy_id)	mysql_query("UPDATE report_diy SET status=1,createtime=NOW() WHERE sid='$diy_id'");
		break;
}

?>