<?php
// Excel begin of file header
function xlsBegin($handle) {
	fwrite($handle, pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0));
}
// Excel end of file footer
function xlsEnd($handle) {
	fwrite($handle, pack("ss", 0x0A, 0x00));
}
// Function to write a Number (double) into Row, Col
function xlsWriteNumber($handle, $Row, $Col, $Value) {
	fwrite($handle, pack("sssss", 0x203, 14, $Row, $Col, 0x0));
	fwrite($handle, pack("d", $Value));
}
// Function to write a label (text) into Row, Col
function xlsWriteStr($handle, $Row, $Col, $Value ) {
	$Value = "abcÄãºÃ";
	$L = strlen($Value);
	fwrite($handle, pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L));
	fwrite($handle, $Value);
}
?> 
