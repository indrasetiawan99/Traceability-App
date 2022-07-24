<?php
/*
 * File Allows printing from web interface, simply connects to the Zebra Printer and then pumps data
 * into it which gets printed out.
 */
// $print_data = $_POST['zpl_data'];
$print_data = "
<0x10>CT~~CD,~CC^~CT~
^XA
~TA000
~JSN
^LT0
^MNW
^MTT
^PON
^PMN
^LH0,15
^JMA
^PR6,6
~SD15
^JUS
^LRN
^CI27
^PA0,1,1,0
^XZ
^XA
^MMT
^PW400
^LL160
^LS0
^FT30,156^BQN,2,5
^FH\^FDLA,123456789012123456789012123456789012123456789012^FS
^FT225,154^BQN,2,5
^FH\^FDLA,123456789012123456789012123456789012123456789012^FS
^PQ1,,,Y
^XZ
";

// Open a telnet connection to the printer, then push all the data into it.
try {
    $fp = pfsockopen("192.168.1.201", 9100);
    // fputs($fp, file_get_contents("C:/xampp/htdocs/project/upload/qrcode/qrcode.png"), filesize("C:/xampp/htdocs/project/upload/qrcode/qrcode.png"));
    fputs($fp, $print_data);
    fclose($fp);

    echo 'Successfully Printed';
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
