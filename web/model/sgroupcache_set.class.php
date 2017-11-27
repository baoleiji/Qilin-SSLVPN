<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sgroupcache_set extends base_set {
	protected $table_name = 'servergroup_cache';
	protected $id_name = 'id';
	var $allsgroup;
	var $sgroup_set;

	function insert_user($gid) {
		$this->query("UPDATE $this->table_name SET count = (SELECT count(*) FROM servers WHERE groupid=$gid ) WHERE id = $gid");
	}

	function remove_user($gid) {
		$this->query("UPDATE $this->table_name SET count = (SELECT count(*) FROM servers WHERE groupid=$gid ) WHERE  id = $gid");
	}
	function updates($gid, $oldgid, $num=1){
		$this->sgroup_set=new sgroup_set();
		if($gid){
			$_gp = array();
			$_g = $this->sgroup_set->select_by_id($gid);
			$_gp[]=$_g['id'];
			while($_g['ldapid']){
				$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
				if($_g['id'])
				$_gp[]=$_g['id'];
			}
			$this->query("UPDATE servergroup_cache set count=count+$num where groupid in(".implode(',', $_gp).")");
		}
		if($oldgid){
			$_gp=null;
			$_gp = array();
			$_g = $this->sgroup_set->select_by_id($oldgid);
			$_gp[]=$_g['id'];
			while($_g['ldapid']){
				$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
				if($_g['id'])
				$_gp[]=$_g['id'];
			}
			$this->query("UPDATE servergroup_cache set count=count-$num where groupid in(".implode(',', $_gp).")");
		}
	}
	
	function updatem($gid, $oldgid, $num=1){
		$this->sgroup_set=new sgroup_set();
		if($gid){
			$_gp = array();
			$_g = $this->sgroup_set->select_by_id($gid);
			$_gp[]=$_g['id'];
			while($_g['ldapid']){
				$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
				if($_g['id'])
				$_gp[]=$_g['id'];
			}
			$this->query("UPDATE servergroup_cache set mcount=mcount+$num where groupid in(".implode(',', $_gp).")");
		}
	
		$_gp=null;
		if($oldgid){
			$_gp = array();
			$_g = $this->sgroup_set->select_by_id($oldgid);
			$_gp[]=$_g['id'];
			while($_g['ldapid']){
				$_g = $this->sgroup_set->select_by_id($_g['ldapid']);
				if($_g['id'])
				$_gp[]=$_g['id'];
			}
			$this->query("UPDATE servergroup_cache set mcount=mcount-$num where groupid in(".implode(',', $_gp).")");
		}
	
	}
	function update($gid,$old,$uid=0){
		$_g['ldapid'] = $gid;
		if(empty($uid)) return ;
		while($_g['ldapid']){
			$_g = $this->select_all("groupid=".$_g['ldapid']." and memberid=".$uid);
			$_g = $_g[0];
			$_gg = $this->select_all("ldapid=".$_g['groupid']." and memberid=".$uid);
			$_gp=$_g['groupid'].',';
			for($i=0; $i<count($_gg); $i++){
				if($_gg[$i]['child'])
				$_gp.=$_gg[$i]['child'].',';
			}
			$this->query("UPDATE servergroup_cache set child='".substr($_gp,0,strlen($_gp)-1)."' where id=".$_g['groupid']." and memberid=".$uid);
		}
		if($old){
			$_g = $old;
			while($_g['ldapid']){
				$_g = $this->select_all("groupid=".$_g['ldapid']." and memberid=".$uid);
				$_g = $_g[0];
				$_gg = $this->select_all("ldapid=".$_g['groupid']." and memberid=".$uid);
				$_gp=$_g['groupid'].',';
				for($i=0; $i<count($_gg); $i++){
					if($_gg[$i]['child'])
					$_gp.=$_gg[$i]['child'].',';
				}
				$this->query("UPDATE servergroup_cache set child='".substr($_gp,0,strlen($_gp)-1)."' where groupid=".$_g['groupid']." and memberid=".$uid);
			}
		}
	}

}