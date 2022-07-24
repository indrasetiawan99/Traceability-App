<?php
if ($_GET['action'] == 'Print') {
    include('../connection.php');

    $query1 = "SELECT * FROM repair_qrcode WHERE cek_qrcode IS NULL";
    $result1 = $mysqli->query($query1);
    $cek_for_print = mysqli_num_rows($result1);
    if ($cek_for_print > 0) {
        foreach ($result1 as $row1) {
            $valQRcode = $row1['qrcode'];

            $query2 = "SELECT * FROM part_production WHERE qrcode = '$valQRcode'";
            $result2 = $mysqli->query($query2);
            foreach ($result2 as $row2) {
                $part_name = $row2['part_name'];
            }
            $result2->close();

            $query3 = "SELECT * FROM master_product WHERE part_name = '$part_name'";
            $result3 = $mysqli->query($query3);
            foreach ($result3 as $row) {
                $type = $row['type'];
                $pos_part_ = $row['position'];
            }
            $result3->close();

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

                $query4 = "UPDATE repair_qrcode SET cek_qrcode = '$valQRcode' WHERE qrcode = '$valQRcode'";
                $mysqli->query($query4);
            }
        }
        $result1->close();
    }

    $mysqli->close();
    header('Location:../../main/repair_qrcode.php');
}
