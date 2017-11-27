<?php
if(empty($_GET[data])){
	exit;
}
define("ROOT", dirname(__FILE__)."/../../");
require_once ROOT. './include/pChart/pData.class';
require_once ROOT. './include/pChart/pChart.class';
$_GET['info'][0]=urldecode($_GET['info'][0]);
$_GET['info'][1]=urldecode($_GET['info'][1]);
//$_GET['info'][0] = iconv("GB2312", "UTF-8", $_GET['info'][0]);
//$_GET['info'][1] = iconv("GB2312", "UTF-8", $_GET['info'][1]);
//var_dump($_GET['info']);

/*饼形图*/
$DataSet = new pData;
$DataSet->AddPoint($_GET[data],"Serie1");
$DataSet->AddPoint($_GET[info],"Serie2");
$DataSet->AddAllSeries();
$DataSet->SetAbsciseLabelSerie("Serie2");
 // Initialise the graph
$Test = new pChart(220,150);
$Test->drawFilledRoundedRectangle(7,7,196,243,5,255,255,255);
$Test->drawRoundedRectangle(5,5,196,245,5,255,255,255);
//$Test->createColorGradientPalette(255,0,0,255,255,255,1);
$Test->setColorPalette(0,233,147,146);
$Test->setColorPalette(1,143,215,141);
 // Draw the pie chart
$Test->setFontProperties(ROOT. "./include/pChart/Fonts/simsun.ttc",8);
$Test->AntialiasQuality = 0;
$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),100,65,50,PIE_PERCENTAGE_LABEL,FALSE,50,20,2);
$Test->drawPieLegend(130,5,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

$Test->Stroke();
?>