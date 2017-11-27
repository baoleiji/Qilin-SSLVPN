<?php
require('chinese.php');

$pdf=new PDF_Chinese();
 $pdf->AddGBFont(); 
 $pdf->Open();
 $pdf->AddPage();
 $pdf->SetFont('GB','',20); 
 $pdf->Write(10,'ÕâÀïÊÇ²âÊÔ×Ö·û');
 $pdf->Output();
?>
