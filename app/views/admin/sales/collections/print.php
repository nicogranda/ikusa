<?php
ob_start(); // inicia buffer de salida

require('../../app/libraries/fpdf/quote.php');


ob_end_flush(); // envикa PDF
exit;
