<?php
$rrd_cmd_path = '/opt/rrdtool-1.4.5/bin/rrdtool';
$rrds_path='/home/lwm/RRD/rrds';
$colors = array('#00FF00','#0000FF','#FF0000','#FF00FF','#00FFFF');

if(!is_dir('./rrdimg')){
	mkdir('./rrdimg');
}
//生成cpu
exec("awk '{if($1~/^cpu/) print $1;}' /proc/stat ",$cpus);//var_dump($cpus);
$cpu_record_type = array('total','idle','user','iowait','intr');

for($j=0; $j<5; $j++){

	if(!file_exists($rrds_path.'/cpu_'.$cpu_record_type[$j].'.rrd')) continue;

	$cmd = $rrd_cmd_path.' graph "rrdimg/cpu_'.$cpu_record_type[$j].'.png" -s -86400 -w 500 -h 100  -x MINUTE:30:HOUR:2:HOUR:2:0:%H:%M -Y -t "cpu_'.$cpu_record_type[$j].' io" ';  
	for($i=0; $i<count($cpus); $i++){
		$cmd .= ' DEF:'.$cpus[$i].'='.$rrds_path.'/cpu_'.$cpu_record_type[$j].'.rrd:'.$cpus[$i].':AVERAGE ';
		$cmd .= ' CDEF:'.$cpus[$i].'_sector='.$cpus[$i].',1,\/ ';
		$cmd .= ' LINE1:'.$cpus[$i].'_sector'.$colors[$i].':"'.$cpus[$i].'_sector"';
	}
	//echo $cmd.'<br />';
	$images[] = 'cpu_'.$cpu_record_type[$j].'.png';
	exec($cmd, $out);

}


//生成disk
$cmd='';
exec("awk '{if($3~/[sh]d[abcdefgh]$/ && $4 > 0 ) print $3;}' /proc/diskstats ",$disks);//var_dump($disks);
for($i=0; $i<count($disks); $i++){

	if(!file_exists($rrds_path.'/'.$disks[$i].'.rrd')) continue;

	$cmd = $rrd_cmd_path.' graph "rrdimg/'.$disks[$i].'.png" -s -86400 -w 500 -h 100  -x MINUTE:30:HOUR:2:HOUR:2:0:%H:%M -Y -t "'.$disks[$i].' io"    DEF:rio='.$rrds_path.'/'.$disks[$i].'.rrd:rio:AVERAGE DEF:wio='.$rrds_path.'/'.$disks[$i].'.rrd:wio:AVERAGE CDEF:rio_sector=rio,1,\/  CDEF:wio_sector=wio,1,\/  LINE1:rio_sector'.$colors[0].':"rio(sector)" LINE1:wio_sector'.$colors[2].':"wio(sector)"';
	//echo $cmd.'<br />';
	$images[] = $disks[$i].'.png';
	exec($cmd, $out);
}


//生成eth
$cmd='';
exec("awk -F':' '{if($1~/eth[0123456]$/ && $2 > 0 ) print $1;}' /proc/net/dev ",$eth);//var_dump($eth);
for($i=0; $i<count($eth); $i++){
	$eth[$i]=trim($eth[$i]);

	if(!file_exists($rrds_path.'/'.$eth[$i].'.rrd')) continue;

	$cmd = $rrd_cmd_path.' graph "rrdimg/'.$eth[$i].'.png" -s -86400 -w 500 -h 100 -x MINUTE:30:HOUR:2:HOUR:2:0:%H:%M -Y  -t "'.$eth[$i].' traffic" DEF:rx='.$rrds_path.'/'.$eth[$i].'.rrd:rx:AVERAGE  DEF:tx='.$rrds_path.'/'.$eth[$i].'.rrd:tx:AVERAGE CDEF:rx_mbps=rx,1,\/ CDEF:tx_mbps=tx,1,\/  LINE1:rx_mbps'.$colors[2].':"rx(mbps)"  LINE1:tx_mbps'.$colors[0].':"tx(mbps)"';
	$images[] = $eth[$i].'.png';
	//echo $cmd.'<br />';
	exec($cmd, $out);
}


//生成df -h
$cmd='';
exec("df -h",$dfs);//var_dump($dfs);
for($i=1; $i<count($dfs); $i++){
	$dfmount = preg_split("/[\s]+/", $dfs[$i]);//var_dump($dfs[$i]);
	
	if(!file_exists($rrds_path.'/'.str_replace('/','#',$dfmount[5]).'.rrd')) continue;

	$cmd = $rrd_cmd_path.' graph "rrdimg/'.str_replace('/','_',$dfmount[5]).'.png" -s -86400 -w 500 -h 100  -x MINUTE:30:HOUR:2:HOUR:2:0:%H:%M -Y -t "'.str_replace('#','/',$dfmount[5]).' io"  DEF:used='.$rrds_path.'/'.str_replace('/','#',$dfmount[5]).'.rrd:Used:AVERAGE DEF:avail='.$rrds_path.'/'.str_replace('/','#',$dfmount[5]).'.rrd:Avail:AVERAGE CDEF:used_sector=used,1,\/ CDEF:avail_sector=avail,1,\/  LINE1:used_sector#00FF00:"used_sector(M)" LINE1:avail_sector#0000FF:"avail_sector(M)"';
	$images[] = str_replace('/','_',$dfmount[5]).'.png';
	//echo $cmd.'<br />';
	exec($cmd, $out);
}


//生成 memory
$cmd='';
if(file_exists($rrds_path.'/memory.rrd')){
	$cmd = $rrd_cmd_path.' graph "rrdimg/memory.png" -s -86400 -w 500 -h 100 -x MINUTE:30:HOUR:2:HOUR:2:0:%H:%M -Y  -t "memory usage" DEF:TotalMemory='.$rrds_path.'/memory.rrd:TotalMemory:AVERAGE DEF:FreeMemory='.$rrds_path.'/memory.rrd:FreeMemory:AVERAGE DEF:TotalSwap='.$rrds_path.'/memory.rrd:TotalSwap:AVERAGE DEF:FreeSwap='.$rrds_path.'/memory.rrd:FreeSwap:AVERAGE CDEF:TotalMemoryM=TotalMemory,1024,\/ CDEF:FreeMemoryM=FreeMemory,1024,\/ CDEF:TotalSwapM=TotalSwap,1024,\/ CDEF:FreeSwapM=FreeSwap,1024,\/ LINE1:TotalMemoryM#00FF00:"TotalMemory(k)" LINE1:FreeMemoryM#0000FF:"FreeMemory(k)" LINE1:TotalSwapM#FF0000:"TotalSwap(k)" LINE1:FreeSwapM#FF00FF:"FreeSwap(k)"';
	//echo $cmd.'<br />';
	$images[] = 'memory.png';
	exec($cmd, $out);
}

for($i=0;$i<count($images); $i++){
	echo '<img src=rrdimg/'.$images[$i].' />'.'<br /><br /><br />';
}

?>