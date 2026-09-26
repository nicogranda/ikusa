<?php
ob_start(); // inicia buffer de salida

require(dirname(__DIR__, 6) . '/app/libraries/fpdf/quote.php');


ob_end_flush(); // envикa PDF
exit;
