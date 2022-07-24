$(document).ready(function () {

    $("#btn-src-qrcode").on("click", function () {
        var qrcode = document.getElementById("src-qrcode").value;
        var tr_datapart = document.getElementById("tr-qr-datapart-code");
        var seq_num = document.getElementById("tr-qr-seq-num");
        var datetime = document.getElementById("tr-qr-datetime");
        var npk = document.getElementById("tr-qr-npk");
        var name = document.getElementById("tr-qr-name");
        var op_skill = document.getElementById("tr-qr-skill");
        var part_name = document.getElementById("tr-qr-partname");
        var sku = document.getElementById("tr-qr-sku");
        var cust = document.getElementById("tr-qr-customer");
        var pn_api = document.getElementById("tr-qr-pn-api");
        var pn_cust = document.getElementById("tr-qr-pn-cust");
        var pack = document.getElementById("tr-qr-pack");
        var address = document.getElementById("tr-qr-address");
        var job_num = document.getElementById("tr-qr-job-num");
        var time_prod = document.getElementById("tr-qr-time-prod");
        var status = document.getElementById("tr-qr-status");
        var desc = document.getElementById("tr-qr-desc");

        $.ajax({
            type: "POST",
            url: "http://10.14.134.44/admin/database/quick_trace.php",
            data: "action=search-qrcode&qrcode="+qrcode,
            success: function (data) {
                tr_datapart.value = data.tr_datapart;
                seq_num.value = data.seq_num;
                datetime.value = data.datetime;
                npk.value = data.npk;
                name.value = data.name;
                op_skill.value = data.op_skill;
                part_name.value = data.part_name;
                sku.value = data.sku;
                cust.value = data.cust;
                pn_api.value = data.pn_api;
                pn_cust.value = data.pn_cust;
                pack.value = data.pack;
                address.value = data.address;
                job_num.value = data.job_num;
                time_prod.value = data.time_prod;
                status.value = data.status;
                desc.value = data.desc;
            }
          });
    });
    
    var table = $('#tr_quick').DataTable();
    $("#btn-src-datapart").on("click", function () {
        table.clear().draw();
        var datapart_code = document.getElementById("src-datapart").value;

        $.ajax({
            type: "POST",
            url: "http://10.14.134.44/admin/database/quick_trace.php",
            data: "action=search-datapart-code&datapart-code="+datapart_code,
            success: function (data) {
                for(var i = 0; i < data.length; i++){
                    table.row.add( [ 
                        i + 1,
                        data[i]
                    ] ).draw( false );
                }
            },
        });
    });

});