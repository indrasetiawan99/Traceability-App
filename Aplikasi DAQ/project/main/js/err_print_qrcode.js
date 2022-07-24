$(document).ready(function() {
    setInterval(function () {
        $.ajax({
            type: "POST",
            datatype: 'html',
            url: "http://10.14.134.44/project/database/web/err_print_qrcode.php",
            data: "err-print-qrcode=Read",
            success : function(msg) {
                $("tbody#err-qrcode-table").html(msg);
            }
        });    
    }, 1000); // update about every second
});