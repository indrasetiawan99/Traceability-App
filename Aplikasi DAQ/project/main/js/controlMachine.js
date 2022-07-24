$(document).ready(function () {
  $("#btn-on-off").click(function () {
    $.ajax({
      type: "GET",
      url:
        "http://10.14.134.44/project/database/web/controlMachine_db.php?action=Check",
      success: function (data) {
        if (data.errSkill == "yes") {
          Swal.fire({
            title: 'Error!',
            text: 'Operator Skill dibawah 75%',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        } else if (data.errSkill == "no") {
          if (data.usergroup == "Supervisor") {
            location.replace(
              "http://10.14.134.44/project/database/web/controlMachine_db.php?action=Yes&from=supervisor"
            );
          } else {
            location.replace(
              "http://10.14.134.44/project/database/web/controlMachine_db.php?action=Yes&from=operator"
            );
          }
        }
      },
    });
  });
});
