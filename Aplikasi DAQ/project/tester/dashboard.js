$( document ).ready(function() {
    var cumTarget = document.getElementById("cum_target");
    var downtime = document.getElementById("downtime");
    var machine = document.getElementById("machine_status");
    var partname = document.getElementById("partname");
    var target = document.getElementById("target");
    var status = document.getElementById("status");
    var datetime = document.getElementById("datetime");
    var cum_actual = document.getElementById("cum_actual");
    var rejection = document.getElementById("rejection");
    var efficiency = document.getElementById("efficiency");

    var cumTarget2 = document.getElementById("cum_target2");
    var downtime2 = document.getElementById("downtime2");
    var machine2 = document.getElementById("machine_status2");
    var partname2 = document.getElementById("partname2");
    var target2 = document.getElementById("target2");
    var status2 = document.getElementById("status2");
    var datetime2 = document.getElementById("datetime2");
    var cum_actual2 = document.getElementById("cum_actual2");
    var rejection2 = document.getElementById("rejection2");
    var efficiency2 = document.getElementById("efficiency2");
    
    cumTarget.innerHTML = 0;
    downtime.innerHTML = 0;
    machine.innerHTML = 0;
    partname.innerHTML = "-";
    target.innerHTML = 0;
    status.innerHTML = '-';
    datetime.innerHTML = '-';
    cum_actual.innerHTML = 0;
    rejection.innerHTML = 0;
    efficiency.innerHTML = 0 + '%';

    cumTarget2.innerHTML = 0;
    partname2.innerHTML = "-";
    target2.innerHTML = 0;
    status2.innerHTML = '-';
    datetime2.innerHTML = '-';
    cum_actual2.innerHTML = 0;
    rejection2.innerHTML = 0;
    efficiency2.innerHTML = 0 + '%';
    
    setInterval(function () {

        $.ajax({
            type : "POST",
            url : "http://10.14.134.44/project/database/web/recapitulation.php",
            data : "",
            success : function(data) {
                cum_actual.innerHTML = data.part_OK;
                rejection.innerHTML = data.part_NG;
                efficiency.innerHTML = data.efficiency + '%';
                cumTarget.innerHTML = data.counter;
                downtime.innerHTML = data.result_downtime;
                partname.innerHTML = data.partname;
                target.innerHTML = data.target;
                status.innerHTML = data.status;
                datetime.innerHTML = data.datetime;

                cum_actual2.innerHTML = data.part_OK2;
                rejection2.innerHTML = data.part_NG2;
                efficiency2.innerHTML = data.efficiency2 + '%';
                cumTarget2.innerHTML = data.counter2;
                partname2.innerHTML = data.partname2;
                target2.innerHTML = data.target2;
                status2.innerHTML = data.status2;
                datetime2.innerHTML = data.datetime2;

                $.ajax({
                    type: "POST",
                    url: "http://10.14.134.44/project/database/web/qualityDowntime.php",
                    data: "action=Read_Machine",
                    success: function (data) {
                        machine.innerHTML = data.machineStatus;
                    },
                });
            }
                
        });
    }, 1000); // update about every second
});




