<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class c_webservice extends c_base {
	private $code = "bd9bbc9862842fa8eb8fd67eb2e7ca0";
	private $key = null;
	
	function index() {
		print "a webservice for data exchange using code {$this->code}.";
	}
	
	function getKey() {
		if(is_null($this->key)) {
			$params = $_GET;
			
			unset($params['action']);
			unset($params['key']);
			unset($params['skipKey']);
			ksort($params, SORT_STRING | SORT_FLAG_CASE);
			
			//print_r($params);
			$str = "";
			foreach($params as $k => $v) {
				$str .= $k . $v;
			}
			
			$this->key = md5($str . $this->code);
		}
		
		return $this->key;
	}
	
	function validateKey($action) {
		if(isset($_GET["skipKey"]))
			return true;
		
		if($action == "index")
		    return true;
		
		//print md5($str . $this->code);
		if(isset($_GET["key"]) && $this->getKey() == $_GET["key"]) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function getOutput($result) {
		if(isset($_GET["skipKey"])) {
			$result['skipKey'] = 1;
		}
		
		$str = "ret" . $result["ret"];
			
		if(isset($result["val"])) {
			$str .= "val{"; // . str_replace('"', '', json_encode($result["val"], JSON_FORCE_OBJECT));
			if($result["val"]) {
				$i = 0;
				foreach($result["val"] as $k => $v) {
					if($i > 0)
						$str .= ",";

					$str .= $k . ":" . $v;
					
				    $i++;
				}
			}

			$str .= "}";
		}
			
		$result["key"] = md5($str . $this->code);
		//$result["key_calc"] = $str . $this->code;
		
		//$str = "ret" . $result['ret'];
		return json_encode($result, JSON_FORCE_OBJECT);
		
	}
	
	//获取全部用户真实姓名信息
	/**
	 * Name
	 * OrderType
	 * Start
	 * Size
	 * Key
	 */
	function GetUserList() {
		if(!isset($_GET['Name']) || !in_array($_GET['Name'], array('uid', 'username', 'realname', 'email'))) {
			return array('ret' => 'parameterError',
					     'message' => 'Name参数有效值：uid/username/realname/email'
					    );
		}
		
		if(!isset($_GET['OrderType']) || !in_array($_GET['OrderType'], array('Asc', 'Desc'))) {
			return array('ret' => 'parameterError',
					     'message' => 'OrderType参数有效值：Asc/Desc'
			);
		}
		
		if(!isset($_GET['Start']) || !is_numeric($_GET['Start'])) {
			return array('ret' => 'parameterError',
					     'message' => 'Start必须为数字'
			);
		}
		
		if(!isset($_GET['Size']) || !is_numeric($_GET['Size'])) {
			return array('ret' => 'parameterError',
					     'message' => 'Size必须为数字'
			);
		}
		
		$vals = array();
		$users = $this->member_set->select_limit($_GET['Start'],
						                         $_GET['Size'],
						                         '1=1',
						                         $_GET['Name'],
						                         $_GET['OrderType']);
		if($users) {
			foreach($users as $user) {
				$vals[$user['uid']] = $user['username'];
			}
		}
		
		return array('ret' => 'ok',
				     'val' => $vals);
		
	}
	
	//根据ID数组获取用户姓名列表
	function GetUserListByIDList() {
		if(!isset($_GET['IDList']) || !preg_match("/^\d+(,\d+)*$/", $_GET['IDList'])) {
			return array('ret' => 'parameterError',
					     'message' => 'IDList必须为逗号分割的数字列表'
			);
		}
		
		$vals = array();
		$users = $this->member_set->select_all("uid in (" . $_GET['IDList'] . ")");
		
		if($users) {
			foreach($users as $user) {
				$vals[$user['uid']] = $user['username'];
			}
		}
		
		return array('ret' => 'ok',
				     'val' => $vals);
	}
	
	//根据ID获取用户信息
	function GetUserInfoByID() {
		if(!isset($_GET['ID']) || !preg_match("/^\d+$/", $_GET['ID'])) {
			return array('ret' => 'parameterError',
					     'message' => 'ID必须为数字'
			);
		}
		
		$vals = $this->member_set->select_by_id($_GET['ID']);
		if($vals) unset($vals['password']);
		
		return array('ret' => 'ok',
				     'val' => $vals);
	}
	
	//获取全部用户组名称
	function GetUserGroup() {
		$vals = array();
		$items = $this->usergroup_set->select_all("1=1");
		
		if($items) {
			foreach($items as $item) {
				$vals[$item['id']] = $item['GroupName'];
			}
		}
		
		return array('ret' => 'ok',
				     'val' => $vals);
	}
	
	//根据ID数组获取用户组
	function GetUserGroupByIDList() {
		if(!isset($_GET['IDList']) || !preg_match("/^\d+(,\d+)*$/", $_GET['IDList'])) {
			return array('ret' => 'parameterError',
					     'message' => 'IDList必须为逗号分割的数字列表'
			);
		}
		
		$vals = array();
		$items = $this->usergroup_set->select_all("id in (" . $_GET['IDList'] . ")");
		
		if($items) {
			foreach($items as $item) {
				$vals[$item['id']] = $item['GroupName'];
			}
		}
		
		return array('ret' => 'ok',
				     'val' => $vals);
		
	}
	
	//根据用户组ID获取用户列表
	function GetUserListByGroupID() {
		if(!isset($_GET['ID']) || !preg_match("/^\d+$/", $_GET['ID'])) {
			return array('ret' => 'parameterError',
					     'message' => 'ID必须为数字'
			);
		}
		
		$vals = array();
		$users = $this->member_set->select_all("groupid = " . $_GET['ID']);
		
		if($users) {
			foreach($users as $user) {
				$vals[$user['uid']] = $user['username'];
			}
		}
		
		return array('ret' => 'ok',
				     'val' => $vals);
	}
	
	//根据ID获取资产信息
	function GetAssetByID() {
		if(!isset($_GET['ID']) || !preg_match("/^\d+$/", $_GET['ID'])) {
			return array('ret' => 'parameterError',
					'message' => 'ID必须为数字'
			);
		}
		
		$vals = $this->assets_set->select_by_id($_GET['ID']);
		//if($vals) unset($vals['password']);
		
		return array('ret' => 'ok',
				     'val' => $vals);
	}
	
	
	
}
