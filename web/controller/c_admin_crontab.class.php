<?php
class c_admin_crontab extends c_base {
	function update($facility) {
		$fid = $facility['fid'];
		$benchmark = true;
		
		if($facility['port'] == '') {
			$facility['port'] = '22';
		}
		$newfacility = new facility();
		$newfacility->set_data('fid', $fid);
		$newfacility->set_data('updatetime', date("Y-m-d H:i:s"));

		$tresult = $this->config_set->select_all(" fid = $fid ");
		if(count($tresult) == 0) {
			echo "此设备没有添加任何监控的配置\r\n";
			return 0;
		}
		$diffcounts == 0;
		foreach($tresult as $_config)	{
			if(file_exists('/tmp/audit.tmp')) {
				unlink('/tmp/audit.tmp');
			}
			$now = $this->do_config[$_config['interface']]->get($facility, $_config);
			if($now[0] == 0) {
				$diff = $this->do_config[$_config['interface']]->compare($_config['default'],file_get_contents('/tmp/audit.tmp'));
			}
			else {
				//echo file_get_contents('/tmp/audit.tmp');
				echo "更新设备配置发生错误\r\n";
				return -1;
			}

			if($diff != '') {
				$diffcounts++;
				$newchanges = new changes();
				$newchanges->set_data('conid',$_config['cid']);
				$newchanges->set_data('fid',$fid);
				$newchanges->set_data('diffs',mysql_real_escape_string(file_get_contents('/tmp/audit.tmp')));
				$newchanges->set_data('changetime', date("Y-m-d H:i:s"));
				$stats = stat('/tmp/audit.tmp');
				$newchanges->set_data('mtime', date("Y-m-d H:i:s",$stats['mtime']));
				$oldchanges = $this->changes_set->select_all("conid = ".$_config['cid'] ." and DATE_FORMAT( changetime, '%Y-%m-%d' ) = '".date("Y-m-d")."'");
				if(count($oldchanges)>0) {
					foreach($oldchanges as $oldchange) {
						$this->changes_set->delete($oldchange['chid']);
					}
				}
				$this->changes_set->add($newchanges);
			}
			
			if(file_exists('/tmp/audit.tmp')) {
				unlink('/tmp/audit.tmp');
			}
			
		}	
		if($diffcounts == 0) {
			$this->facility_set->edit($newfacility);
			echo "更新成功,没有发现配置被更改!\r\n";
		}
		else {
			$newfacility->set_data('lastchangetime', date("Y-m-d H:i:s"));
			$this->facility_set->edit($newfacility);
			echo "更新成功,发现 $diffcounts 个配置被更改!\r\n";
			return $diffcounts;
		}
		return 0;
			
	}

	function update_all() {
		$allfacility = $this->facility_set->select_all();
		$msg = '';
		foreach($allfacility as $facility) {
			if($facility['port'] == '') {
				$facility['port'] = '22';
			}
			$ret = $this->update($facility);
			if($ret != 0) {
				if($ret > 0) {
					$msg .= "设备{$facility['name']}({$facility['ip']}) 有 $ret 个配置被改变\n";
				}

			}
		}
		if($msg != '') {
			$admins = $this->member_set->select_all("level = '1'");
			$emails  = '';
			foreach($admins as $admin) {
				if($emails != '') {
					$emails .= ',' . $admin['email'];
				}
				else {
					$emails .= $admin['email'];
				}
			}

			if($emails != '') {
				mail($emails, iconv("utf-8", "gb2312", "[警告]设备配置改变"), iconv("utf-8", "gb2312", $msg));
#				mail("test@127.0.0.1", iconv("utf-8", "gb2312", "[警告]设备配置改变"), iconv("utf-8", "gb2312", $msg));
			}
		}
	}
}
?>
