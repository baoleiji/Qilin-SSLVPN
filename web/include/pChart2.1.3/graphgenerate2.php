<?php    
 /* CAT:Pie charts */ 
define("ROOT", dirname(__FILE__)."/../../");
 /* pChart library inclusions */ 
 include(ROOT."./include/pChart2.1.3/class/pData.class.php"); 
 include(ROOT."./include/pChart2.1.3/class/pDraw.class.php"); 
 include(ROOT."./include/pChart2.1.3/class/pPie.class.php"); 
 include(ROOT."./include/pChart2.1.3/class/pImage.class.php"); 

 /* Create and populate the pData object */ 
 $MyData = new pData();    
 $MyData->addPoints($_GET[data],"ScoreA");   
 $MyData->setSerieDescription("ScoreA","Application A"); 

 /* Define the absissa serie */ 
 $MyData->addPoints($_GET[info],"Labels"); 
 $MyData->setAbscissa("Labels"); 

 $MyData->loadPalette(ROOT."./include/pChart2.1.3/palettes/monitorpie.color", TRUE);

 /* Create the pChart object */ 
 $myPicture = new pImage(320,160,$MyData); 

 /* Draw a solid background */ 
 $Settings = array("R"=>255, "G"=>255, "B"=>255, "Dash"=>0, "DashR"=>255, "DashG"=>255, "DashB"=>255); 
 $myPicture->drawFilledRectangle(0,0,300,160,$Settings); 

 /* Overlay with a gradient */ 
 $Settings = array("StartR"=>255, "StartG"=>255, "StartB"=>255, "EndR"=>255, "EndG"=>255, "EndB"=>255, "Alpha"=>255); 
 $myPicture->drawGradientArea(0,0,300,160,DIRECTION_VERTICAL,$Settings); 
// $myPicture->drawGradientArea(0,0,300,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100)); 

 /* Add a border to the picture */ 
 //$myPicture->drawRectangle(0,0,299,259,array("R"=>0,"G"=>0,"B"=>0)); 

 /* Write the picture title */  
// $myPicture->setFontProperties(array("FontName"=>ROOT. "./include/pChart/Fonts/simsun.ttc","FontSize"=>6)); 
// $myPicture->drawText(10,13,"pPie - Draw 2D pie charts",array("R"=>255,"G"=>255,"B"=>255)); 

 /* Set the default font properties */  
 $myPicture->setFontProperties(array("FontName"=>ROOT. "./include/pChart/Fonts/simsun.ttc","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80)); 

 /* Create the pPie object */  
 $PieChart = new pPie($myPicture,$MyData); 

 

 /* Draw an AA pie chart */  
 $PieChart->draw3DPie(160,60,array("Radius"=>70,"Border"=>TRUE)); 

 /* Write the legend box */  
 $myPicture->setShadow(FALSE); 
 $PieChart->drawPieLegend(60,130,array("Alpha"=>20, "Mode"=>LEGEND_HORIZONTAL)); 

 /* Render the picture (choose the best way) */ 
// $myPicture->autoOutput("pictures/example.draw3DPie.labels.png"); 
 $myPicture->stroke();

?> 