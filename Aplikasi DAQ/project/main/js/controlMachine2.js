baseURL = 'http://10.14.134.44/project/';
setInterval(function () {
    var imgStatus = document.getElementById('img-status');

    $.ajax({
        type: "GET",
        url: baseURL+"database/web/controlMachine_db.php?action=Read",
        success : function(data) {
            if(data.machineStatus == 0){
                imgStatus.src = baseURL + 'assets/img/red-led.png';
            }else if(data.machineStatus == 1){
                imgStatus.src = baseURL + 'assets/img/green-led.png';
            }
        }
    });
}, 1000); // update about every second