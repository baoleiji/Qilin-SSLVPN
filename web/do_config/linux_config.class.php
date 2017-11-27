<?php
class linux_config {
	function get($facility, $config) {
		$out = '';
		$result = array();
		if(file_exists('/tmp/audit.tmp')) {
			unlink('/tmp/audit.tmp');
		}
		$ret = rsync($facility['ip'], $facility['port'], $facility['username'], $facility['password'], $config['attributes'], '/tmp/audit.tmp', $out);
	
		$out = iconv("gbk", "utf-8", $out);
		$result[1] = $out;
		if(file_exists('/tmp/audit.tmp')) {
			$result[0] = 0;
		}
		else {
			if(strstr($out, "failed: No such file or directory")) {
				$result[0] = 2;			
			}
			else {
				$result[0] = 1;
			}
		}
		return $result;
	}

	function compare($old, $new) {
		//print($new);
		if(!preg_match('/Integrity check complete/i',$new)) {
			if($new == '$Linux Config Deleted$') {
				return "该配置文件已被删除";
			}
			else{
				return diff($old, $new);
			}
		}
		else {
			$blocks = explode("Rule Name:",$new);
			$added = array();
			$modified = array();
			$removed = array();
			$added[0] = 0;
			$added[1] = array();
			$modified[0] = 0;
			$modified[1] = array();
			$removed[0] = 0;
			$removed[1] = array();

			for($i=1;$i<count($blocks);$i++) {
				$sblocks = explode("\n\n",$blocks[$i]);
				foreach($sblocks as $sblock) {
					if(preg_match('/^Added:/i',$sblock)) {			
						$files = explode("\n",$sblock);
						$added[0] += count($files) - 1;
						for($j=1;$j<count($files);$j++) {
							$added[1][] = $files[$j];	
						}
					}
					elseif(preg_match('/^Modified:/i',$sblock)) {
						
						$files = explode("\n",$sblock);
						$modified[0] += count($files) - 1;
						for($j=1;$j<count($files);$j++) {
							$modified[1][] = $files[$j];	
						}
					}
					elseif(preg_match('/^Removed:/i',$sblock)) {			
						$files = explode("\n",$sblock);
						$removed[0] += count($files) - 1;
						for($j=1;$j<count($files);$j++) {
							$removed[1][] = $files[$j];	
						}
					}
				}
			}

			if($added[0]+$modified[0]+$removed[0] ==0) {
				return '';
			}
			else {
				$outstring = '';				
				$outstring .= "新添加的文件个数为".$added[0]."个\n"; 
				if($added[0]!=0) { 
					foreach($added[1] as $file)
						$outstring .= $file."\n";		
				}
				$outstring .= "新修改的文件个数为".$modified[0]."个\n"; 
				if($modified[0]!=0) { 
					foreach($modified[1] as $file)
						$outstring .= $file."\n";		
				}
				$outstring .= "新删除的文件个数为".$removed[0]."个\n"; 
				if($removed[0]!=0) { 
					foreach($removed[1] as $file)
						$outstring .= $file."\n";		
				}
				return $outstring;
			}
		}
	}
}

