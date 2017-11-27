<?php 
set_time_limit(0);
class CSMTP{ 
	var $_emailaddr; 
	var $_mailhost; 
	var $_smtpport = 25; 
	var $_smtptimeout = 30; 
	var $_smtpgetanswertimeout = 10; 
	var $_smtpheaders = array(); 
	var $_smtpbody = ""; 
	var $_smtpboundary = ""; 
	var $_smtpattachfile; 
	var $_debug = 1; 
	var $_smtpfs=0;

	function __construct($host,$port,$email,$password){ //发邮件的邮箱地址和密码
	 
		$this ->_emailaddr = $email; 
		$temp = explode("@",$email); 
		$this ->_user = $email; 
		$this ->_password = $password; 
		$this->_host = $host;
		$this ->_smtphost = $host; 
		$this ->_smtpport = $port; 
	} 

	public function linkSMTP(){ //连接smtp服务器
		$this->_smtpfs = socket_create   (AF_INET,   SOCK_STREAM,   SOL_TCP);     //具体用法请参考手册   
		if($this->_smtpfs)   
		{   
			$this->result_str = "创建SOCKET:".socket_strerror(socket_last_error())."<br />";   
			echo($this->result_str);   
		}   
		else   
		{   
			exit("初始化失败，请检查您的网络连接和参数<br />");   
		}   
		echo 'Mail Server IP:';var_dump($this->_smtphost);
		echo 'Mail Server Port:';var_dump($this->_smtpport);
		$this->conn = socket_connect($this->_smtpfs,$this->_smtphost,$this->_smtpport);   
		if($this->conn)   
		{   
			$this->result_str = "创建SOCKET连接:".socket_strerror(socket_last_error())."<br />";   
			echo($this->result_str);   
		}   
		else   
		{   
			exit("初始化失败，请检查您的网络连接和参数"."<br />");   
		}   
		$this->result_str = "服务器应答：<font   color=#cc0000>".socket_read($this->_smtpfs, 1024)."</font>"."<br />";   
		echo($this->result_str); 
	 
		//$this ->_smtpfs = @fsockopen($this ->_smtphost,$this ->_smtpport, $errorn, $this ->_errorstr, $this ->_smtptimeout); 
		//if(!$this ->checkOK($this ->getAnswer($this ->_smtpfs),"220"))$this -> outbug("Can't link ".$this ->_smtphost); 
		$this ->sendCommand($this ->_smtpfs, "HELO ".$this ->_host."\r\n","250"); 
		$this ->sendCommand($this ->_smtpfs, "EHLO ".$this ->_host."\r\n","250"); 
		$this ->sendCommand($this ->_smtpfs, "AUTH LOGIN\r\n","334"); 
		$this ->sendCommand($this ->_smtpfs, $this ->encode($this ->_user)."\r\n","334"); 
		$this ->sendCommand($this ->_smtpfs, $this ->encode($this ->_password)."\r\n","235"); 
	} 

	public function quitSMTP(){ //离开服务器
	 
		$this ->sendCommand($this->_smtpfs, "QUIT\r\n","221"); 
		fclose($this->_smtpfs); 
	} 

	public function attachFile($filename,$zhfilename){ //加入附件，支持数组或单文件
		if(empty($zhfilename)) $zhfilename=$filename;

		//foreach(func_get_args() as $filename){ 
			if(!file_exists($filename)) 
			if(!file_exists(dirname($_SERVER['SCRIPT_FILENAME'])."/".$filename)) return; 

			$handle = fopen($filename,"rb"); 
			$str = fread($handle ,filesize($filename)); 
			fclose($handle); 
			//$temp_mime = include("mime.php"); 
			$temp_arr = explode("." ,basename($filename)); 
			$temp_key = array_slice($temp_arr, -1, 1); 
			$filemime = isset($temp_mime[$temp_key[0]])?$temp_mime[$temp_key[0]]:"text/html"; 
			$temp = "Content-Type: ".$filemime.";\r\n"; 
			$temp .= " name=\"".$this ->encode(($zhfilename),1)."\"\r\n"; 
			$temp .= "Content-Transfer-Encoding: base64\r\n"; 
			$temp .= "Content-Disposition: attachment;\r\n"; 
			$temp .= " filename=\"".$this ->encode(($zhfilename),1)."\"\r\n"; 
			$temp .= "\r\n"; 
			$temp .= $this ->cutFile($this ->encode($str)); 
			$this ->_smtpattachfile[] = $temp; 
		//} 
	} 

	public function sendMail(){ //发送邮件
		foreach($this ->_smtpmialto as $mailadd_val){ 
			$filestate = count($this ->_smtpattachfile)>0 ? 1 : 0; 
			$this ->sendCommand($this ->_smtpfs, "MAIL FROM:<".$this ->_emailaddr.">\r\n","250"); 
			$this ->sendCommand($this ->_smtpfs, "RCPT TO:<".$mailadd_val.">\r\n","250"); 
			foreach($this ->_smtpheaders as $val) 
				$temp .= $val; 
			$temp .= "--".$this ->_smtpboundary."\r\n"; 
			if($filestate==1){ 
				$new_smtpboundary = "--=".md5(microtime()); 
				$temp .= "Content-Type: multipart/alternative;\r\n"; 
				$temp .= " boundary=\"".$new_smtpboundary."\"\r\n"; 
				$temp .= "\r\n"; 
				$temp .= "--".$new_smtpboundary."\r\n"; 
			} 
			$temp .= "Content-Type: ".$this ->_smtpmialmime."\r\n"; 
			$temp .= "Content-Transfer-Encoding: base64\r\n"; 
			$temp .= "\r\n"; 
			$temp .= $this ->encode($this ->_smtpcontent)."\r\n"; 
			$temp .= "\r\n"; 
			if($filestate==1){ 
				$temp .= "--".$new_smtpboundary."--\r\n"; 
				$temp .= "\r\n"; 
				foreach($this ->_smtpattachfile as $val){ 
					$temp .= "--".$this ->_smtpboundary."\r\n"; 
					$temp .= $val; 
				} 
			} 
			$temp .= "--".$this ->_smtpboundary."--\r\n"; 
			$temp .= ".\r\n"; 
			$this ->sendCommand($this ->_smtpfs, "DATA\r\n","354"); 
			$this ->sendCommand($this ->_smtpfs, $temp,"250"); 
			unset($temp); 
		} 
	} 

	public function buildMail($to ,$subject,$content ,$mime ,$username=""){ //建立邮件，建立邮件文件头
	 
		if(is_array($to)){ 
			$this ->_smtpmialto = $to; 
		}else{ 
			$this ->_smtpmialto[] = $to; 
		} 
		$this ->_smtpmialfrom = $this ->_emailaddr; 
		$this ->_smtpboundary = "--=".md5(microtime()); 
		$this ->_smtpmialmime = $mime; 
		$headers["date"] = "Date: ".date("r")."\r\n"; 
		$headers["subject"] = "Subject: ".$this ->encode($subject ,1)."\r\n"; 
		$headers["message_id"] = "Message-Id: <".md5(uniqid(microtime())) ."@".$this ->_host.">\r\n"; 
		$username = $username==""?$this ->_user:$username; 
		$headers["from"] = "From: ".$this ->encode($username ,1)." <".$this ->_emailaddr.">\r\n"; 
		$temp = explode("@",$this ->_smtpmialto[0]); 
		$user = trim($temp[0]); 
		$headers["to"] = "To: ".$this ->encode($user,1)." <".$this ->_smtpmialto[0].">\r\n"; 
		$headers["content_type"] = "Content-Type: multipart/mixed "; 
		$headers["boundary"] = "; boundary=\"".$this ->_smtpboundary ."\"; charset=\"utf-8\"\r\n"; 
		$headers["content_transfer_encoding"] = "Content-Transfer-Encoding: base64\r\n"; 
		$headers["other"] = "X-Power-by: CayLeung\r\n"; 
		$headers["version"] = 'MIME-Version: 1.0' . "\r\n"; 
		$headers["end"] = "\r\n"; 
		$this ->_smtpheaders = $headers; 
		$this ->_smtpcontent = $content; 
	} 

	protected function getAnswer($socket){ //获取服务器返回信息
	 
		$starttime = time(); 
		$timeout = $this ->_smtpgetanswertimeout ; 
		$this ->checkLink($socket); 
		$results = $line = ""; 
		/*while(true){ 
			
			$line = fgets($this ->_smtpfs,4096); //var_dump($line);
			$results .= $line; 
			if(strpos($line,"\r\n")!==false){ 
			//	break; 
			} 
			if((time() - $starttime)>$timeout){ 
				$this -> _state = 0; 
				break; 
			} 
		} 
		$this -> _wait = 0; */
		$results = socket_read($socket,   1024);
		return $results; 
	} 

	protected function sendCommand($socket,$command,$okstr){ //发送命令
	 
		echo "C: ".htmlspecialchars($command)."<br/>"; 
		$this ->checkLink($this ->_smtpfs); 
		socket_write($socket, $command, strlen ($command));   
		//fwrite($socket,$command); 
		$r = $this ->getAnswer($socket)."<br/>"; 
		echo "S: ".$r; 
		return $r; 
	//echo $r= $this ->checkOK($r,$okstr)?"OK":"KO"; 
	} 


	protected function isMailAddr($addr){ //判断是否为邮箱地址
	 
		$r = preg_match("'\w[\w]+@[\w]+\.(com|cn|org)'iU",$addr)==0?false:true; 
		return $r; 
	} 

	protected function encode($str,$mode=0){ //进行base64编码
	 
		switch($mode){ 
			case 0: 
				return base64_encode($str); 
			case 1: 
				return "=?UTF8?B?".base64_encode($str)."?="; 
			default: 
				return $str; 
		} 
	} 

	protected function cutFile($str ,$len = 80){ //文件切割传输
	 
		$strlen = strlen($str); 
		$i = 0; 
		$temp = ""; 
		while($strlen>0){ 
			$temp .= substr($str,$i*$len,$len); 
			$temp .= "\r\n"; 
			$strlen -= $len; 
			$i++; 
		} 
		return $temp; 
	}
	 

	protected function checkOK($str,$okstr){ //判断服务器返回值是否成功
		//echo "S:".$str."<br />";
		return strtoupper(substr($str,0,strlen($okstr)))==$okstr; 
	} 

	protected function checkLink($socket){ //检查连接是否断开
	 
	if (!$socket) $this ->outbug($this ->_errorstr); 
	} 

	protected function outbug($str){ //显示错误信息
	 
		if(!$this ->_debug)return false; 
		echo "Catch a bug : ".$str; 
		exit; 
	} 
}
 

/*
 
//发送邮箱和密码 
$e = new CSMTP("mail3.ctsi.com.cn","25","zhaoshigang@ctsi.com.cn","**********");
//连接服务器 
$e -> linkSMTP(); 
$e -> buildMail("netmwd@163.com" ,"你好" ,"你好","text/html"); 
#添加附件 
#绝对路径或相对路径，支持多文件
$e -> attachFile("text.txt","jquery"); 
#发送文件 
$e -> sendMail(); 
#离开服务器 
$e -> quitSMTP();
 */

 
?>