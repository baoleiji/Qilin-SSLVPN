<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_admin_interface extends c_base {
	function process_postdata(){
		$r = json_decode(urldecode($_POST['data']), true);
		if(!is_array($r)){
			$_result['result']=0;
			$_result['msg']='json格式解析错误';
			$_result['data']=array();
			echo json_encode($_result);
			return false;
		}
		return $r;
	}

	function groupAdd(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_POST = $data;
		$_GET['id']=$data['id'];
		require_once(ROOT ."./controller/c_admin_pro.class.php");	
		$newpro = new c_admin_pro();
		$sgroupset = new sgroup_set();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$id = $newpro->dev_group_save(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$sgroupset->select_all('id="'.$id.'"');
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function groupDel(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_POST = $data;
		
		require_once(ROOT ."./controller/c_admin_pro.class.php");	
		$newpro = new c_admin_pro();
		$sgroupset = new sgroup_set();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		for($i=0; $i<count($data['id']); $i++){
			$_GET['id']=$data['id'][$i];
			$newpro->dev_group_del();
		}
		
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
		}
		echo json_encode($_result);
	}

	function groupList(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_GET = $data;
		$_GET['derive']=0;
		$this->config['site']['items_per_page']=$_GET['items_per_page'];
		require_once(ROOT ."./controller/c_admin_pro.class.php");	
		$newpro = new c_admin_pro();
		$sgroupset = new sgroup_set();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$datas=$newpro->dev_group(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if($r==0){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$datas;
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function radiususerAdd(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_SESSION['RADIUSUSERLIST']=true;
		$_POST = $data;
		$_POST['password1']=$data['password'];
		$_POST['password2']=$data['password'];
		$_GET['uid']=$data['uid'];
		require_once(ROOT ."./controller/c_admin_member.class.php");	
		$newmember = new c_admin_member();
		$memberset = new member_set();
		$newmember->init($this->smarty, $this->config);
		ob_start();
		$id=$newmember->save(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$memberset->base_select('select *,NULL password from member where uid="'.$id.'"');
			var_dump($_result);
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		var_dump($_result);
		echo json_encode($_result);
	}

	function radiususerDel(){
		global $_CONFIG;		
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_SESSION['RADIUSUSERLIST']=true;
		$_POST['chk_member']=$data['uid'];
		require_once(ROOT ."./controller/c_admin_member.class.php");	
		$newmember = new c_admin_member();
		$memberset = new member_set();
		$newmember->init($this->smarty, $this->config);
		ob_start();
		$newmember->delete_all();
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=array();
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function radiususerList(){
		global $_CONFIG;		
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_SESSION['RADIUSUSERLIST']=true;
		$_GET=$data;
		$_GET['derive']=0;
		$this->config['site']['items_per_page']=$_GET['items_per_page'];

		require_once(ROOT ."./controller/c_admin_member.class.php");	
		$newmember = new c_admin_member();
		$newmember->init($this->smarty, $this->config);
		ob_start();
		$datas=$newmember->index(true,true );
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);

		if($r==0){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$datas;
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}

		echo json_encode($_result);
	}

	function userAdd(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_SESSION['RADIUSUSERLIST']=false;
		$_POST = $data;
		$_POST['password1']=$data['password'];
		$_POST['password2']=$data['password'];
		$_GET['uid']=$data['uid'];
		require_once(ROOT ."./controller/c_admin_member.class.php");	
		$newmember = new c_admin_member();
		$memberset = new member_set();
		$newmember->init($this->smarty, $this->config);
		ob_start();
		$id=$newmember->save(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$memberset->base_select('select *,NULL password from member where uid="'.$id.'"');
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function userDel(){
		global $_CONFIG;		
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_SESSION['RADIUSUSERLIST']=false;
		$_POST['chk_member']=$data['uid'];
		require_once(ROOT ."./controller/c_admin_member.class.php");	
		$newmember = new c_admin_member();
		$memberset = new member_set();
		$newmember->init($this->smarty, $this->config);
		ob_start();
		$newmember->delete_all();
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=array();
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function userList(){
		global $_CONFIG;		
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_SESSION['RADIUSUSERLIST']=false;
		$_GET=$data;
		$_GET['derive']=0;
		$this->config['site']['items_per_page']=$_GET['items_per_page'];
		require_once(ROOT ."./controller/c_admin_member.class.php");	
		$newmember = new c_admin_member();
		$memberset = new member_set();
		$newmember->init($this->smarty, $this->config);
		ob_start();
		$datas=$newmember->index(false,true );
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if($r==0){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$datas;
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function serverAdd(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_POST = $data;
		$_POST['IP']=$_POST['ip'];
		$_GET['id']=$data['id'];
		require_once(ROOT ."./controller/c_admin_pro.class.php");	
		$newpro = new c_admin_pro();
		$serverset = new server_set();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$newpro->dev_save(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$serverset->base_select('SELECT *,NULL superpassword FROM '.$serverset->get_table_name().' WHERE device_ip="'.$_POST['ip'].'"');
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function serverDel(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_POST = $data;
		$_POST['chk_member']=$data['id'];
		
		require_once(ROOT ."./controller/c_admin_pro.class.php");	
		$newpro = new c_admin_pro();
		$serverset = new server_set();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$newpro->dev_del();
		$result = ob_get_clean();
		echo $result;
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		var_dump($matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=array();
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function serverList(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_GET = $data;
		$_GET['derive']=0;
		$this->config['site']['items_per_page']=$_GET['items_per_page'];
		require_once(ROOT ."./controller/c_admin_pro.class.php");	
		$newpro = new c_admin_pro();
		$serverset = new server_set();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$datas = $newpro->dev_index(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if($r==0){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$datas;
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function deviceAdd(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_POST = $data;
		$_GET['ip']=$_POST['ip'];
		$_GET['id']=$data['id'];
		$server = $this->server_set->select_all("device_ip='".$_GET['ip']."'");
		$_GET['serverid']=$server[0]['id'];
		require_once(ROOT ."./controller/c_admin_pro.class.php");
		for($i=0; $i<count($_POST['users']); $i++){
			$_POST['Check'.$i]=$_POST['users'][$i];
		}
		for($i=0; $i<count($_POST['groups']); $i++){
			$_POST['Group'.$i]=$_POST['groups'][$i];
		}
		$newpro = new c_admin_pro();
		$deviceset = new devpass_set();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$id = $newpro->pass_save(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$deviceset->base_select('select *,NULL cur_password,NULL old_password,NULL new_password from '.$deviceset->get_table_name().' where id="'.$id.'"');
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function deviceDel(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_POST = $data;
		$_GET['id']=$data['id'];
		
		require_once(ROOT ."./controller/c_admin_pro.class.php");	
		$newpro = new c_admin_pro();
		$serverset = new server_set();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$newpro->pass_del();
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=array();
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function deviceList(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_GET = $data;
		$_GET['derive']=0;
		$this->config['site']['items_per_page']=$_GET['items_per_page'];
		require_once(ROOT ."./controller/c_admin_pro.class.php");	
		$newpro = new c_admin_pro();
		$serverset = new server_set();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$datas=$newpro->devpass_index(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if($r==0){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$datas;
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function resourceAdd(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_POST = $data;
		$_POST['gname'] = $data['groupname'];
		$_GET['id']=$data['id'];
		for($i=0; $i<count($_POST['users']); $i++){
			$_POST['Check'.$i]=$_POST['users'][$i];
		}
		for($i=0; $i<count($_POST['groups']); $i++){
			$_POST['Group'.$i]=$_POST['groups'][$i];
		}
		require_once(ROOT ."./controller/c_admin_pro.class.php");	
		$newpro = new c_admin_pro();
		$resgroupset = new resgroup_set();
		$newpro->init($this->smarty, $this->config);
		$_POST['secend'] = $_POST['devices'];
		for($i=0; $i<count($data['bindgroup']); $i++){
			$_POST['secend'][]='groupid_'.$data['bindgroup'][$i];
		}
		ob_start();
		$id = $newpro->resource_group_save(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$resgroupset->select_all('id="'.$id.'"');
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function resourceDel(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_POST = $data;
		
		require_once(ROOT ."./controller/c_admin_pro.class.php");	
		$newpro = new c_admin_pro();
		$resgroupset = new resgroup_set();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		for($i=0; $i<count($data['id']);$i++){
			$resgroup = $resgroupset->select_by_id($data['id'][$i]);
			$_GET['gname'] = $resgroup['groupname'];
			$newpro->resource_group_del();
		}
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=array();
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function resourceList(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_GET = $data;
		$_GET['derive']=0;
		$this->config['site']['items_per_page']=$_GET['items_per_page'];
		require_once(ROOT ."./controller/c_admin_pro.class.php");	
		$newpro = new c_admin_pro();
		$resgroupset = new resgroup_set();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$datas=$newpro->resource_group(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if($r==0){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$datas;
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}
	
	function keyList(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_GET = $data;
		$_POST['keyid']=$data['keyid'];
		$_POST['username']=$data['username'];
		$_GET['derive']=0;
		$this->config['site']['items_per_page']=$_GET['items_per_page'];
		require_once(ROOT ."./controller/c_admin_member.class.php");	
		$newmember = new c_admin_member();
		$newmember->init($this->smarty, $this->config);
		ob_start();
		$datas=$newmember->keys_index(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);

		if($r==0){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$datas;
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function keyBind(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$usbkeyset = new usbkey_set();
		$memberset = new member_set();
		$user = $memberset->select_by_id($data['uid']);
		$key = $usbkeyset->select_all($data['keyid']);
		if($data['bind']){
			if(empty($user)){
				$_result['result']=0;
				$_result['msg']='用户不存在';
				$_result['data']=array();
			}elseif(empty($key)){
				$_result['result']=0;
				$_result['msg']='KEY不存在';
				$_result['data']=array();
			}else{
				$memberset->query("UPDATE member set usbkey='".$key[0]['keyid']."',usbkeystatus=11 where uid=".$data['uid']);
				$_result['result']=0;
				$_result['msg']='操作成功';
				$_result['data']=array();
			}
		}else{
			if(empty($user)){
				$_result['result']=0;
				$_result['msg']='用户不存在';
				$_result['data']=array();
			}else{
				$memberset->query("UPDATE member set usbkey='',usbkeystatus=0 where uid=".$data['uid']);
				$_result['result']=1;
				$_result['msg']='操作成功';
				$_result['data']=array();
			}
		}
		echo json_encode($_result);
	}
	
	function getQrcode(){
		global $_CONFIG;
		$memberset = new member_set();
		$user = $memberset->select_by_id($_GET['uid']);
		header('Location:include/phpqrcode/qrcodeimage.php?data='.$user['usbkey'].'&level=H&size=7');
	}
	
	function ValidateKey(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$minfo = $this->member_set->select_by_id($data['uid']);
		if($minfo['usbkey']&&$minfo['usbkeystatus']==11){
			$old_radius = $this->radius_set->select_all("UserName = '".$minfo['username']."'");
			$new_radius = new radius();
			$new_radius->set_data("id",$old_radius[0]['id']);
			$new_radius->set_data("Value",crypt($this->member_set->udf_decrypt($minfo['password']),"\$1\$qY9g/6K4"));
			$this->radius_set->edit($new_radius);
			$_tmp = $this->member_set->base_select("select rad_getpasswd('".$minfo['username']."','".$this->member_set->udf_decrypt($minfo['password']).$data['qrcode']."','','127.0.0.1') AS p");
			if(crypt($this->member_set->udf_decrypt($minfo['password']).$data['qrcode'],"\$1\$qY9g/6K4")!=$_tmp[0]['p']){	
				$_result['result']=0;
				$_result['msg']='动态口令输入错误,系统时间为:'.date('Y年m月d日 H时i分');
				$_result['data']=array();
			}else{
				$newmember = new member();
				$newmember->set_data("usbkeystatus", 0);
				$newmember->set_data("smspassword", 0);
				$newmember->set_data("uid", $data['uid']);
				$this->member_set->edit($newmember);
				$_result['result']=1;
				$_result['msg']='操作成功';
				$_result['data']=array();
				
			}
		}else{
			$_result['result']=0;
			$_result['msg']='用户不需验证';
			$_result['data']=array();
		}
		echo json_encode($_result);
	}

	function forbiddenAdd(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_POST = $data;
		$_POST['add']='new';
		$_POST['gname']=$data['groupname'];
		$_GET['id']=$data['id'];
		require_once(ROOT ."./controller/c_admin_forbidden.class.php");	
		$newpro = new c_admin_forbidden();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$id = $newpro->forbiddengps_save(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$this->forbiddengps_set->select_all('id="'.$id.'"');
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}
	
	function forbiddenDel(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_POST = $data;
		$_GET['gid']=$data['gid'];
		
		require_once(ROOT ."./controller/c_admin_forbidden.class.php");	
		$newpro = new c_admin_forbidden();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$newpro->del_forbiddengps();
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=array();
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}
	
	function forbiddenList(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_GET = $data;
		$_GET['derive']=0;
		$this->config['site']['items_per_page']=$_GET['items_per_page'];
		require_once(ROOT ."./controller/c_admin_forbidden.class.php");	
		$newpro = new c_admin_forbidden();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$datas=$newpro->forbidden_groups_list(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if($r==0){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$datas;
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}
	
	function forbiddenCmdAdd(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_POST = $data;
		$_POST['add']='new';
		$_GET['cid']=$data['cid'];
		for($i=0; $i<count($data['cmd']); $i++){
			if(empty($data['cmd'][$i])) continue;
			$_POST['cmd_'.$i]=$data['cmd'][$i];
		}
		require_once(ROOT ."./controller/c_admin_forbidden.class.php");	
		$newpro = new c_admin_forbidden();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$id = $newpro->forbiddengps_cmd_save();
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$this->forbiddengpscommand_set->select_all('cid="'.$cid.'"');
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}
	
	function forbiddenCmdDel(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_POST = $data;
        for($i=0; $i<count($data['cid']); $i++){
            if(empty($data['cid'][$i])) continue;
            $_POST['chk_gid'][]=$data['cid'][$i];
        }
		require_once(ROOT ."./controller/c_admin_forbidden.class.php");	
		$newpro = new c_admin_forbidden();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$newpro->del_forbiddengps_cmd();
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(strpos($matches[1], '成功')!==false){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=array();
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}
	
	function forbiddenCmdList(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_GET = $data;
		$_GET['derive']=0;
		$this->config['site']['items_per_page']=$_GET['items_per_page'];
		require_once(ROOT ."./controller/c_admin_forbidden.class.php");	
		$newpro = new c_admin_forbidden();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$datas=$newpro->forbiddengps_cmd(true);
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if($r==0){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=$datas;
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}
	
	
	
	function sessionList(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_GET = $data;
		ob_start();
		switch($data['type']){
			case 'ssh':
				require_once(ROOT ."./controller/c_admin_session.class.php");	
				$newpro = new c_admin_session();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);

			break;
			case 'telnet':
				require_once(ROOT ."./controller/c_admin_session.class.php");	
				$newpro = new c_admin_session();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);
				
			break;
			case 'commands':
				require_once(ROOT ."./controller/c_admin_session.class.php");	
				$newpro = new c_admin_session();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->view(true);
			break;
			case 'scp':
				require_once(ROOT ."./controller/c_admin_scp.class.php");	
				$newpro = new c_admin_scp();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);
			break;
			case 'sftp':
				require_once(ROOT ."./controller/c_admin_sftp.class.php");	
				$newpro = new c_admin_sftp();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);
			break;
			case 'sftpcommands':
				require_once(ROOT ."./controller/c_admin_sftp.class.php");	
				$newpro = new c_admin_sftp();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->view(true);
			break;
			case 'ftp':
				require_once(ROOT ."./controller/c_admin_ftp.class.php");	
				$newpro = new c_admin_ftp();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);
			break;
			case 'ftpcommands':
				require_once(ROOT ."./controller/c_admin_ftp.class.php");	
				$newpro = new c_admin_ftp();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->view(true);
			break;
			case 'as400':
				require_once(ROOT ."./controller/c_admin_as400.class.php");	
				$newpro = new c_admin_as400();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);
			break;
			case 'rdp':
				require_once(ROOT ."./controller/c_admin_rdp.class.php");	
				$newpro = new c_admin_rdp();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);
			break;
			case 'vnc':
				require_once(ROOT ."./controller/c_admin_vnc.class.php");	
				$newpro = new c_admin_vnc();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);
			break;
			case 'x11':
				require_once(ROOT ."./controller/c_admin_x11.class.php");	
				$newpro = new c_admin_x11();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);
			break;
			case 'apppub':
				require_once(ROOT ."./controller/c_admin_apppub.class.php");	
				$newpro = new c_admin_apppub();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);
			break;
			case 'mysqlcommands':
				require_once(ROOT ."./controller/c_admin_apppub.class.php");	
				$newpro = new c_admin_apppub();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->sqlview(true);
			break;
			case 'rdpmouse':
				require_once(ROOT ."./controller/c_admin_rdp.class.php");	
				$newpro = new c_admin_rdp();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->rdpmouse(true);
			break;
			
		}
		
		ob_get_clean();
		$_result['result']=1;
		$_result['msg']='操作成功';
		$_result['data']=$datas;
		echo json_encode($_result);
	}
	
	function sessionOnline(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_GET = $data;
		ob_start();
		switch($data['type']){
			case 'ssh':
				require_once(ROOT ."./controller/c_admin_session.class.php");	
				$newpro = new c_admin_session();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->gateway_running_list(true);
			break;
			case 'telnet':
				require_once(ROOT ."./controller/c_admin_session.class.php");	
				$newpro = new c_admin_session();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->gateway_running_telnet(true);
			break;
			case 'rdp':
				require_once(ROOT ."./controller/c_admin_rdprun.class.php");	
				$newpro = new c_admin_rdprun();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);
			break;
			case 'vnc':
				require_once(ROOT ."./controller/c_admin_vncrun.class.php");	
				$newpro = new c_admin_vncrun();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);
			break;
			case 'apppub':
				require_once(ROOT ."./controller/c_admin_apppubrun.class.php");	
				$newpro = new c_admin_apppubrun();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->index(NULL,true);
			break;
		}
		
		ob_get_clean();
		$_result['result']=1;
		$_result['msg']='操作成功';
		$_result['data']=$datas;
		echo json_encode($_result);
	}
	
	function sessionCut(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_GET = $data;
		ob_start();
		switch($data['type']){
			case 'ssh':
				require_once(ROOT ."./controller/c_admin_session.class.php");	
				$newpro = new c_admin_session();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->cut_running();
			break;
			case 'telnet':
				require_once(ROOT ."./controller/c_admin_session.class.php");	
				$newpro = new c_admin_session();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->cut_running();
			break;
			case 'rdp':
				require_once(ROOT ."./controller/c_admin_rdprun.class.php");	
				$newpro = new c_admin_rdprun();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->cutoff();
			break;
			case 'vnc':
				require_once(ROOT ."./controller/c_admin_vncrun.class.php");	
				$newpro = new c_admin_vncrun();
				$newpro->init($this->smarty, $this->config);
				$datas=$newpro->cutoff();
			break;
			case 'apppub':
			break;
		}
		
		ob_get_clean();
		$_result['result']=1;
		$_result['msg']='操作成功';
		$_result['data']=$datas;
		echo json_encode($_result);
	}
	
	function devLogin(){
		global $_CONFIG;
		if(($data=$this->process_postdata())===false){
			return ;
		}
		$_GET = $data;
		
		require_once(ROOT ."./controller/c_admin_pro.class.php");	
		$newpro = new c_admin_pro();
		$newpro->init($this->smarty, $this->config);
		ob_start();
		$newpro->dev_login();
		$result = ob_get_clean();
		$r = preg_match("/<script language='javascript'>alert\(['\"](.*?)['\"]\);/", $result, $matches);
		if(!$r){
			$_result['result']=1;
			$_result['msg']='操作成功';
			$_result['data']=array('address'=>$result);
		}else{
			$_result['result']=0;
			$_result['msg']=$matches[1];
			$_result['data']=array();
		}
		echo json_encode($_result);
	}
	
}
?>
