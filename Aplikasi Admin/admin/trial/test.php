<?php
$qrcode = '210500043_30-001-110 SC_API_10_M079_200521_07.23.54';
for ($i = 0; $i < 4; $i++) {
    $qrcode = substr($qrcode, strpos($qrcode, '_') + 1);
}
$qrcode = substr($qrcode, 0, strpos($qrcode, '_'));
echo $qrcode;
