<?php
if (!empty($_GET['err-print-qrcode'])) {

    $valQRcode = $_GET['err-print-qrcode'];
    $part_name = $_GET['part-name'];

    include('../connection.php');

    $query = "SELECT * FROM master_product WHERE part_name = '$part_name'";
    $result = $mysqli->query($query);
    foreach ($result as $row) {
        $type = $row['type'];
        $pos_part_ = $row['position'];
    }
    $result->close();

    if ($pos_part_ == 'Right') {
        $pos_part = 'RH';
    } else if ($pos_part_ == 'Left') {
        $pos_part = 'LH';
    }

    if ($valQRcode != '') {
        $print_data = "
        <0x10>CT~~CD,~CC^~CT~
        ^XA~TA000~JSN^LT0^MNW^MTT^PON^PMN^LH0,0^JMA^PR5,5~SD15^JUS^LRN^CI0^XZ
        ^XA
        ^MMT
        ^PW400
        ^LL0080
        ^LS0
        ^FT150,102^BQN,2,3
        ^FH\^FDLA," . $valQRcode . "^FS
        ^FT151,110^A0N,19,19^FH\^FD" . $type . " / " . $pos_part . "^FS
        ^PQ1,0,1,Y^XZ        
        ";
        $fp = pfsockopen("192.168.1.203", 9100);
        fputs($fp, $print_data);
        fclose($fp);
    }

    $mysqli->close();
}

header('Location:../../main/handleErrorQrcode.php');
