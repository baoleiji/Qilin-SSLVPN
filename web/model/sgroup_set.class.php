<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class sgroup_set extends base_set {
	protected $table_name = 'servergroup';
	protected $id_name = 'id';
	var $allsgroup;

	function insert_user($gid) {
		$this->query("UPDATE $this->table_name SET count = (SELECT count(*) FROM servers WHERE groupid=$gid ) WHERE id = $gid");
	}

	function remove_user($gid) {
		$this->query("UPDATE $this->table_name SET count = (SELECT count(*) FROM servers WHERE groupid=$gid ) WHERE  id = $gid");
	}

	function countsgroups($gid, $pmcount, $pcount){
		$_child[]=$gid;
		$count = 0;
		$mcount = 0;//var_dump($this->allsgroup[$index]['groupname']);echo ':';
		$childs = $this->base_select("SELECT id,ldapid,count,mcount FROM servergroup where ldapid=".$gid);
		for($i=0; $i<count($childs); $i++){//var_dump($this->allsgroup[$i]['groupname']);
			$child = $this->countsgroups($childs[$i]['id'], $childs[$i]['mcount'], $childs[$i]['count']);//echo '<br>';
			$count +=$child['count'];
			$mcount+=$child['mcount'];
			$_child=array_merge($_child, $child['child']);
		}
		$pcount+=$count;
		$pmcount+=$mcount;//echo '------';
		//var_dump($this->allsgroup[$index]['id']);echo '<pre>';var_dump($this->allsgroup[$index]['child']);echo '</pre>';
		$this->query("UPDATE servergroup SET child='".implode(',',$_child)."',count=".$pcount.",mcount=".$pmcount." WHERE id=".$gid);
		return array('count'=>$pcount,'mcount'=>$pmcount,'child'=>$_child);
	}
	function updatechild(){
		$this->query("UPDATE servergroup a SET count=(select count(*) FROM servers b WHERE a.id=b.groupid)");
		$this->query("UPDATE servergroup a SET mcount=(select count(*) FROM member b WHERE a.id=b.groupid)");
		$this->query("UPDATE servergroup a SET child=id");
		$this->allsgroup=$this->base_select("SELECT id,ldapid,count,mcount FROM servergroup where ldapid=0");
		for($ii=0; $ii<count($this->allsgroup); $ii++){
			if($this->allsgroup[$ii]['ldapid']==0){
				$child = $this->countsgroups($this->allsgroup[$ii]['id'], $this->allsgroup[$ii]['mcount'],$this->allsgroup[$ii]['count']);
				$this->allsgroup[$ii]['child']=$child['child'];
				$this->allsgroup[$ii]['count']=$child['count'];
				$this->allsgroup[$ii]['mcount']=$child['mcount'];
			}
		}
		/*for($ii=0; $ii<count($this->allsgroup); $ii++){//var_dump($this->allsgroup[$ii]['child']);echo '</pre>';
			$this->query("UPDATE servergroup SET child='".(!empty($this->allsgroup[$ii]['child']) ? implode(',', $this->allsgroup[$ii]['child']) : '')."',count=".intval($this->allsgroup[$ii]['count']).",mcount=".intval($this->allsgroup[$ii]['mcount'])." WHERE id=".$this->allsgroup[$ii]['id']);
		}*/
	}
	
	function updates($gid, $oldgid, $num=1){
		if($gid){
			$_gp = array();
			$_g = $this->select_by_id($gid);
			$_gp[]=$_g['id'];
			while($_g['ldapid']){
				$_g = $this->select_by_id($_g['ldapid']);
				if($_g['id'])
				$_gp[]=$_g['id'];
			}
			$this->query("UPDATE servergroup set count=count+$num where id in(".implode(',', $_gp).")");
		}
		if($oldgid){
			$_gp=null;
			$_gp = array();
			$_g = $this->select_by_id($oldgid);
			$_gp[]=$_g['id'];
			while($_g['ldapid']){
				$_g = $this->select_by_id($_g['ldapid']);
				if($_g['id'])
				$_gp[]=$_g['id'];
			}
			$this->query("UPDATE servergroup set count=count-$num where id in(".implode(',', $_gp).")");
		}
	}
	
	function updatem($gid, $oldgid, $num=1){
		if($gid){
			$_gp = array();
			$_g = $this->select_by_id($gid);
			$_gp[]=$_g['id'];
			while($_g['ldapid']){
				$_g = $this->select_by_id($_g['ldapid']);
				if($_g['id'])
				$_gp[]=$_g['id'];
			}
			$this->query("UPDATE servergroup set mcount=mcount+$num where id in(".implode(',', $_gp).")");
		}
		
		$_gp=null;
		if($oldgid){
			$_gp = array();
			$_g = $this->select_by_id($oldgid);
			$_gp[]=$_g['id'];
			while($_g['ldapid']){
				$_g = $this->select_by_id($_g['ldapid']);
				if($_g['id'])
				$_gp[]=$_g['id'];
			}
			$this->query("UPDATE servergroup set mcount=mcount-$num where id in(".implode(',', $_gp).")");
		}
		
	}
	
	function update($gid,$old,$uid=0){
		$_g['ldapid'] = $gid;
		while($_g['ldapid']){
			$_g = $this->select_by_id($_g['ldapid']);
			$_gg = $this->select_all("ldapid=".$_g['id']);
			$_gp=$_g['id'].',';
			for($i=0; $i<count($_gg); $i++){
				if($_gg[$i]['child'])
				$_gp.=$_gg[$i]['child'].',';
			}
			$this->query("UPDATE servergroup set child='".substr($_gp,0,strlen($_gp)-1)."' where id=".$_g['id']);
		}
		if($old){
			$_g = $old;
			while($_g['ldapid']){
				$_g = $this->select_by_id($_g['ldapid']);
				$_gg = $this->select_all("ldapid=".$_g['id']);
				$_gp=$_g['id'].',';
				for($i=0; $i<count($_gg); $i++){
					if($_gg[$i]['child'])
					$_gp.=$_gg[$i]['child'].',';
				}
				$this->query("UPDATE servergroup set child='".substr($_gp,0,strlen($_gp)-1)."' where id=".$_g['id']);
			}
		}
	}
	
	function updateall(){
		$this->query("call upgroups(0)");
	}

}