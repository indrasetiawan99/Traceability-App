<?php
require('../assets/vendor/autoload.php');

$valQRcode = 'D01N_BS441RH' . '_' . '0030' . '_' . '01032021073102';
$qrCode = new Endroid\QrCode\QrCode($valQRcode);
$qrCode->setSize(90);
$qrCode->setMargin(0);
$qrCode->writeFile('../upload/qrcode/item-' . $valQRcode . '.png');
