<?php
require('wordwrap.php');

$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$text=str_repeat('this is a word wrap test ',20);
$nb=$pdf->WordWrap($text,120);
$pdf->Write(5,"This paragraph has $nb lines:\n\n");
$pdf->Write(5,$text);
$pdf->Output();
?>
