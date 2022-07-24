$(document).ready(function () {
    setInterval(function () {
        var jig_plan = document.getElementById('jig-plan');
        var nut_plan = document.getElementById('nut-plan');
        var jig_actual = document.getElementById('jig-actual');
        var nut_actual = document.getElementById('nut-actual');

        $.ajax({
            type: "POST",
            url: "http://10.14.134.44/project/database/web/cek_jig_nut.php",
            data: "Action=Read",
            success: function (data) {
                jig_plan.innerHTML = data.jig_plan;
                nut_plan.innerHTML = data.nut_plan;
                jig_actual.innerHTML = data.jig_actual;
                nut_actual.innerHTML = data.nut_actual;

                if(data.jig_plan == data.jig_actual){
                    document.getElementById('jig-actual').className = 'font-weight-bold bg-success';
                }else{
                    document.getElementById('jig-actual').className = 'font-weight-bold bg-danger';
                }

                if(data.nut_plan == data.nut_actual){
                    document.getElementById('nut-actual').className = 'font-weight-bold bg-success';
                }else{
                    document.getElementById('nut-actual').className = 'font-weight-bold bg-danger';
                }
            },
        });
    }, 1000); // update about every second
});