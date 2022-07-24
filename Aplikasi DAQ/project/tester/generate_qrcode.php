<?php
require('../assets/vendor/autoload.php');

$valQRcode = '30-004-111' . '_' . 'API' . '_' . '10' . '_' . '0030' . '_' . '250321' . '_' . '07.24.00';
$qrCode = new Endroid\QrCode\QrCode($valQRcode);
$qrCode->setSize(65);
// $qrCode->setSize(96.75);
$qrCode->setMargin(0);
$qrCode->writeFile('../upload/qrcode/item-' . $valQRcode . '.png');
