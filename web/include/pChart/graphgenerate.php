<?php
if(empty($_GET[data])){
	exit;
}
define("ROOT", dirname(__FILE__)."/../../");
require_once ROOT. './include/pChart/pData.class';
require_once ROOT. './include/pChart/pChart.class';
$_GET['info'][0] = iconv("GB2312", "UTF-8", $_GET['info'][0]);
$_GET['info'][1] = iconv("GB2312", "UTF-8", $_GET['info'][1]);
//var_dump($_GET['info']);
if($_GET['graphtype']=="pie"){
/*饼形图*/
$DataSet = new pData;
$DataSet->AddPoint($_GET[data],"Serie1");
$DataSet->AddPoint($_GET[info],"Serie2");
$DataSet->AddAllSeries();
$DataSet->SetAbsciseLabelSerie("Serie2");
 // Initialise the graph
$Test = new pChart(420,250);
$Test->drawFilledRoundedRectangle(7,7,413,243,5,240,240,240);
$Test->drawRoundedRectangle(5,5,415,245,5,230,230,230);
$Test->createColorGradientPalette(195,204,56,223,110,41,5);
 // Draw the pie chart
$Test->setFontProperties(ROOT. "./include/pChart/Fonts/simsun.ttc",8);
$Test->AntialiasQuality = 0;
$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),180,130,110,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
$Test->drawPieLegend(330,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

// Write the title
$Test->setFontProperties(ROOT. "./include/pChart/Fonts/simsun.ttc",10);
$Test->drawTitle(10,20,"饼形图",100,100,100);
$Test->Stroke();
}else{

/*柱形图*/

// Dataset definition 
 $DataSet = new pData;
 $DataSet->AddPoint($_GET[data],"Serie1");
  $DataSet->AddPoint($_GET[info],"Labels");
 $DataSet->AddAllSeries();

 $DataSet->RemoveSerie("Labels");
 $DataSet->SetAbsciseLabelSerie("Labels");
 $DataSet->SetSerieName("Login times","Serie1");


 // Initialise the graph
$Test = new pChart(700,230);
 $Test->setFontProperties("Fonts/tahoma.ttf",8);
 $Test->setGraphArea(50,30,585,200);
 $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);
 $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
 $Test->drawGraphArea(255,255,255,TRUE);
 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);
 $Test->drawGrid(4,TRUE,230,230,230,50);

 // Draw the 0 line
 $Test->setFontProperties("Fonts/tahoma.ttf",6);
 $Test->drawTreshold(0,143,55,72,TRUE,TRUE);

 // Draw the bar graph
 $Test->drawOverlayBarGraph($DataSet->GetData(),$DataSet->GetDataDescription());

 // Finish the graph
 $Test->setFontProperties("Fonts/tahoma.ttf",8);
 $Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);
 $Test->setFontProperties("Fonts/simsun.ttc",10);
 $Test->drawTitle(10,20,"柱形图",100,100,100);
 $Test->Stroke();
}
?>