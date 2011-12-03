<?php
require_once(__DIR__ . '/bootstrap.php');

$pdf = new Zend_Pdf();
$card = new Qsl_Card();
$pdf->pages[] = $card->build();

$pdf->save(__DIR__ . '/output.pdf');
