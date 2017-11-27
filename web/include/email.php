<?php
set_time_limit(120);   
class   smtp_mail   
{   
var   $host;                     //主机   
var   $port;                     //端口   一般为25   
var   $user;                     //SMTP认证的帐号   
var   $pass;                     //认证密码   
var   $debug   =   false;       //是否显示和服务器会话信息？   
var   $conn;   
var   $result_str;             //结果   
var   $in;                     //客户机发送的命令   
var   $from;                     //源信箱   
var   $to;                     //目标信箱   
var   $subject;                   //主题   
var   $body;                     //内容   
function   smtp_mail($host,$port,$user,$pass,$debug=false)   
{   
$this->host       =   $host;   
$this->port       =   $port;   
$this->user       =   base64_encode($user);   
$this->pass       =   base64_encode($pass);   
$this->debug     =   $debug;   
$this->socket   =   @socket_create   (AF_INET,   SOCK_STREAM,   SOL_TCP);     //具体用法请参考手册   
if($this->socket)   
{   
$this->result_str     =     "创建SOCKET:".@socket_strerror(socket_last_error());   
$this->debug_show($this->result_str);   
}   
else   
{   
alert_and_back("邮箱设置,初始化失败，请检查您的网络连接和参数");  
exit;
}   
$this->conn   =   @socket_connect($this->socket,$this->host,$this->port);   
if($this->conn)   
{   
$this->result_str     =     "创建SOCKET连接:".@socket_strerror(socket_last_error());   
$this->debug_show($this->result_str);   
}   
else   
{   
alert_and_back("邮箱设置,初始化失败，请检查您的网络连接和参数");   
exit;
}   
$this->result_str   =   "服务器应答：<font   color=#cc0000>".@socket_read   ($this->socket,   1024)."</font>";   
$this->debug_show($this->result_str);   


}   
	function   debug_show($str)   
	{   
		if($this->debug)   
		{   
			echo   $str."<p>\r\n";   
		}   
	}   
	function   send($from,$to,$subject,$body)   
	{   
		if($from   ==   ""   ||   $to   ==   "")   
		{   
		exit("请输入信箱地址");   
		}   
		if($subject   ==   "")   $sebject   =   "无标题";   
		if($body         ==   "")   $body         =   "无内容";   
		$this->from           =     $from;   
		$this->to               =     $to;   
		$this->subject     =     $subject;   
		$this->body           =     $body;   

		$All                     =   "From:".$this->from."\n";   
		$All                     .=   "To:".$this->to."\n";   
		$All                     .=   "Subject:".$this->subject."\n";   
		$All                     .=   "\r\n";   
		$All					 .= "Content-Type: text/html\r\n"; 
		$All                     .=   "\r\n";  
		$All                     .=   $this->body;   
		$All                     .=   "\r\n";  
		$All                     .=   "\r\n";  
		/*   
			如过把$All的内容再加处理，就可以实现发送MIME邮件了   
			不过还需要加很多程序   
		*/   


		//以下是和服务器会话   
		$this->in               =     "EHLO HELO\r\n";   
		$this->docommand();   

		$this->in               =     "AUTH LOGIN\r\n";   
		$this->docommand();   

		$this->in               =     $this->user."\r\n";   
		$this->docommand();   

		$this->in               =     $this->pass."\r\n";   
		$this->docommand();   

		$this->in               =     "MAIL FROM:<".$this->from.">\r\n";   
		$this->docommand();   

		$this->in               =     "RCPT TO:<".$this->to.">\r\n";   
		$this->docommand();   

		$this->in               =     "DATA\r\n";   
		$this->docommand();   

		$this->in               =     $All."\r\n.\r\n";   
		$this->docommand();   

		$this->in               =     "QUIT\r\n";   
		$this->docommand();   

		//结束，关闭连接   



	}   

	function   docommand()   
	{   
		@socket_write   ($this->socket,   $this->in,   strlen   ($this->in));   
		$this->debug_show("客户机命令：".$this->in);   
		$this->result_str   =   "服务器应答：<font   color=#cc0000>".@socket_read   ($this->socket,   1024)."</font>";   
		$this->debug_show($this->result_str);   
	}   
}   
//这个是我做的测试，我用的是smtp.163.com，那你的信箱也必须是163.com的，要不人家不让你发！！   
//你用这个类的时候你修改成你自己的信箱就可以了   

//$smtp     =       new   smtp_mail("smtp.163.com","25","testnetmwd@163.com","*********",true);$smtp->send("testnetmwd@163.com","netmwd@qq.com","你好","你好"); 
?>