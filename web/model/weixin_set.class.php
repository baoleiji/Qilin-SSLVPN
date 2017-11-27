<?php
if(!defined('CAN_RUN')) {
	exit('Access Denied');
}

class weixin_set extends base_set {
	protected $table_name = 'weixin';
	protected $id_name = 'uid';

}