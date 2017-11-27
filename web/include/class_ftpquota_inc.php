<?php


class FtpQuota
{
	var $fileTotalsize = 0;
	var $fileTotalNum  = 0;
	var $basePath;
	
	function FtpQuota($basePath)
	{
		if(is_file("$basePath/.ftpquota")){
			$line = file("$basePath/.ftpquota");
			list($this->fileTotalNum, $this->fileTotalsize) = explode(' ', $line[0], 2);
		}
		$this->basePath =  $basePath;
	}
	
	function plusFile($size)
	{
		$this->fileTotalsize += $size;
		$this->fileTotalNum ++;
	}
	
	function decFile($size)
	{
		$this->fileTotalsize -= $size;
		$this->fileTotalNum --;
		if($this->fileTotalsize<0) $this->fileTotalsize = 0;
		if($this->fileTotalNum<0)  $this->fileTotalNum =0;
	}
	
	function close()
	{
		$quotafile = fopen("$this->basePath/.ftpquota", w);
		fputs($quotafile, "$this->fileTotalNum $this->fileTotalsize");
		fclose($quotafile);
	}
}
?>