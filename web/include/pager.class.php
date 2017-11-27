<?php
	/**
	 * 分页算法类
	 * written by sskaje
	 *
	 */
	class pager
	{
		/**
		 * 总共的项目数，一般为结果集的行数
		 *
		 * @var int
		 */
		public $intTotalItemCount;
		
		/**
		 * 分页总数
		 *
		 * @var int
		 */
		public $intTotalPageCount;
		
		/**
		 * 每页项目数
		 *
		 * @var int
		 */
		public $intItemsPerPage;
		
		/**
		 * 当前页码
		 *
		 * @var int
		 */
		public $intCurrentPageNumber;
		
		/**
		 * 查询起始位置
		 *
		 * @var int
		 */
		public $intStartPosition;
		
		/**
		 * 下一页的页码
		 *
		 * @var int
		 */
		public $intNextPageNumber;
		
		/**
		 * 上一页的页码
		 *
		 * @var int
		 */
		public $intPrevPageNumber;
		
		/**
		 * 页码序列处当前页左右两侧最多显示的页码数
		 *
		 * @var int
		 */
		public $intPageSerialCount = 3;
		
		/**
		 * 构造函数 参数为 项目总数，当前页，每页显示项目数量
		 *
		 * @param int $intTotalItemCount
		 * @param int $intCurrentPageNumber
		 * @param int $intItemsPerPage
		 */
		public $indexpagestr = '首页';
		public $lastpagestr = '末页';
		public $prevpagestr = '上一页';
		public $nextpagestr = '下一页';
		public $pagestr = '页';
		public $di = '第';
		
		function __construct($intTotalItemCount, $intCurrentPageNumber=1, $intItemsPerPage=10)
		{
			if(LANGUAGE=='en'){
				require ROOT.'/include/language_en.php';
				require ROOT.'/include/language_cn.php';
				foreach ($cn AS $key => $value){			
					if($value=="首页"){
						$this->indexpagestr=$en[$key];
					}elseif($value=="末页"){
						$this->lastpagestr=$en[$key];
					}elseif($value=="上一页"){
						$this->prevpagestr=$en[$key];
					}elseif($value=="下一页"){
						$this->nextpagestr=$en[$key];
					}elseif($value=="页"){
						$this->pagestr=$en[$key];
					}elseif($value=="第"){
						$this->di=$en[$key];
					}					
				}
			}
			if($intTotalItemCount == 0) {
				$this->intTotalItemCount    =   $intTotalItemCount;
				$this->intItemsPerPage      =   intval($intItemsPerPage)==0? 10: intval($intItemsPerPage);
				$this->intTotalPageCount    =   0;
				$this->intCurrentPageNumber =   0;
				$this->intStartPosition     =   0;
				$this->intNextPageNumber    =   0;
				$this->intPrevPageNumber    =   0;
					
			}
			else {
				$this->intTotalItemCount    =   $intTotalItemCount;
				$this->intItemsPerPage      =   intval($intItemsPerPage)==0? 10: intval($intItemsPerPage);
				$this->intTotalPageCount    =   $this->getTotalPageCount();
				$this->intCurrentPageNumber =   $this->getCurrentPageNumber(intval($intCurrentPageNumber));
				$this->intStartPosition     =   $this->getStartPosition();
				$this->intNextPageNumber    =   $this->getNextPageNumber($this->intCurrentPageNumber);
				$this->intPrevPageNumber    =   $this->getPrevPageNumber($this->intCurrentPageNumber);
			}
		}

		/**
		 * 返回当前页码，主要处理边界的问题
		 *
		 * @param int $pageNumber
		 * @return int
		 */
		protected function getCurrentPageNumber($intCurrentPageNumber)
		{
			if ($intCurrentPageNumber < 1)
				return 1;
			else if ($intCurrentPageNumber > $this->intTotalPageCount)
				return $this->intTotalPageCount;
			else
				return $intCurrentPageNumber;
		}
		
		/**
		 * 返回页码总数
		 *
		 * @return int
		 */
		protected function getTotalPageCount()
		{
			return (int) ceil($this->intTotalItemCount / $this->intItemsPerPage );
		}
		
		/**
		 * 返回查询启始项
		 *
		 * @return int
		 */
		protected function getStartPosition()
		{
			return ($this->intItemsPerPage) * ($this->intCurrentPageNumber - 1);
		}
		
		/**
		 * 得到下一页的页码
		 *
		 * @return int
		 */
		protected function getNextPageNumber($intCurrentPageNumber)
		{
			return ($intCurrentPageNumber == $this->intTotalPageCount)? $this->intTotalPageCount : $intCurrentPageNumber+1 ;
		}
		
		/**
		 * 返回上一页的页码
		 *
		 * @return int
		 */
		protected function getPrevPageNumber($intCurrentPageNumber)
		{
			return ($intCurrentPageNumber == 1)? 1 : $intCurrentPageNumber-1 ;
		}
		
		/**
		 * 设置页码序列的两边参数，默认为2
		 *
		 * @param unknown_type $intPageSerialCout
		 */
		public function setPageSerialCount($intPageSerialCout)
		{
			$this->intPageSerialCount = $intPageSerialCout;
		}
		
		/**
		 * 返回页码序列，与设置的$intPageSerialCount有关，当前页两侧除去最大和最小，最多显示有$intPageSerialCount个页码
		 * 返回的数组取为 PageStart=$_arrReturned[$i]['PageStart']&ItemsPerPage=$_arrReturned[$i]['ItemsPerPage'] 
		 * 其中首页和末页的页码数已加入数组
		 *
		 * @return array
		 */
		public function getPageNumberSerial()
		{
			$arrPageSerial = array();
			for($i=0; $i<$this->intPageSerialCount*2+1; $i++ )
			{
				$key = $this->intCurrentPageNumber - $this->intPageSerialCount + $i;
				if ($key > $this->intTotalPageCount || $key <1 )
				{
					continue;
				}
				else
				{ 
					$arrPageSerial[] = array('PageStart'=>$key, 'ItemsPerPage'=>$this->intItemsPerPage);
				}
			}
			return array_merge(
				array(array('PageStart'=>1,							'ItemsPerPage'=>$this->intItemsPerPage)),	//首页
				array(array('PageStart'=>$this->intPrevPageNumber,  'ItemsPerPage'=>$this->intItemsPerPage)),	//上一页
				$arrPageSerial,																					//页码序列
				array(array('PageStart'=>$this->intNextPageNumber,  'ItemsPerPage'=>$this->intItemsPerPage)),	//下一页
				array(array('PageStart'=>$this->intTotalPageCount,  'ItemsPerPage'=>$this->intItemsPerPage))	//末页
			);
		}
	}
	
	/**
	 * 继承于Pager类
	 *
	 */
	class my_pager extends pager 
	{
		/**
		 * PageStart 的GET变量名
		 *
		 * @var string
		 */
		public $varPageStart;
		
		
		/**
		 * 输出的页码表
		 *
		 * @var string
		 */
		public $strSerialList = '';
		
		/**
		 * 继承类的构造函数
		 * 构造函数 参数为 项目总数，当前页，每页显示项目数量，PageStart 的GET变量名，ItemsPerPage 的GET变量名
		 *
		 * @param int $intTotalItemCount
		 * @param int $intCurrentPageNumber
		 * @param int $intItemsPerPage
		 * @param string $varPageStart
		 */
		function __construct($intTotalItemCount, $intCurrentPageNumber=1, $intItemsPerPage=20, $varPageStart)
		{
			/*
			$this->intTotalItemCount    =   $intTotalItemCount;
			$this->intItemsPerPage      =   intval($intItemsPerPage)==0? 10: intval($intItemsPerPage);
			$this->intTotalPageCount    =   $this->getTotalPageCount();
			$this->intCurrentPageNumber =   $this->getCurrentPageNumber(intval($intCurrentPageNumber));
			$this->intStartPosition     =   $this->getStartPosition();
			$this->intNextPageNumber    =   $this->getNextPageNumber($this->intCurrentPageNumber);
			$this->intPrevPageNumber    =   $this->getPrevPageNumber($this->intCurrentPageNumber);
			*/
			parent::__construct($intTotalItemCount, $intCurrentPageNumber, $intItemsPerPage);
			$this->varPageStart         =   $varPageStart;
		}
		
		/**
		 * 输出页码序列
		 *
		 */
		function showSerialList($para = '')
		{	
			if($para == '') {
				if(strstr($_SERVER['QUERY_STRING'], "page=")) {
					$para = substr($_SERVER['QUERY_STRING'], 0 , strpos($_SERVER['QUERY_STRING'], "page="));
				}
				else {
					$para = $_SERVER['QUERY_STRING']. "&";
				}
			}
			$arrPageNumberSerial = $this->getPageNumberSerial();
			$this->strSerialList .= <<<STRING
<a href="{$_SERVER['PHP_SELF']}?$para{$this->varPageStart}={$arrPageNumberSerial[0]['PageStart']}" title="$this->indexpagestr">$this->indexpagestr</a>&nbsp;
<a href="{$_SERVER['PHP_SELF']}?$para{$this->varPageStart}={$arrPageNumberSerial[1]['PageStart']}" title="$this->prevpagestr">$this->prevpagestr</a>&nbsp;
STRING;
			for ($i=2;$i<count($arrPageNumberSerial)-2;$i++)
			{
				if ($arrPageNumberSerial[$i]['PageStart'] == $this->intCurrentPageNumber)
				{
					$this->strSerialList .= <<<STRING
<strong>{$arrPageNumberSerial[$i]['PageStart']}</strong> &nbsp;
STRING;
				}
				else 
				{
					$this->strSerialList .= <<<STRING
<a href="{$_SERVER['PHP_SELF']}?$para{$this->varPageStart}={$arrPageNumberSerial[$i]['PageStart']}"  title="{$this->di} {$arrPageNumberSerial[$i]['PageStart']} {$this->pagestr}">{$arrPageNumberSerial[$i]['PageStart']}</a>&nbsp;
STRING;
				}
			}
			$this->strSerialList .= '
<a href="'.$_SERVER['PHP_SELF'].'?'.$para.$this->varPageStart.'='.$arrPageNumberSerial[count($arrPageNumberSerial)-2]['PageStart'].'" title="'.$this->nextpagestr.'">'.$this->nextpagestr.'</a>&nbsp;
<a href="'.$_SERVER['PHP_SELF'].'?'.$para.$this->varPageStart.'='.$arrPageNumberSerial[count($arrPageNumberSerial)-1]['PageStart'].'" title="'.$this->lastpagestr.'">'.$this->lastpagestr.'</a>
';
			return $this->strSerialList;
		}
	}
?>
