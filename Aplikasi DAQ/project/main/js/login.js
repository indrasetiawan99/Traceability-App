$(document).ready(function () {
  $("#btn-submit").click(function () {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    $.ajax({
      url:
        "http://10.14.134.44/project/database/web/login_db.php?username=" +
        username +
        "&password=" +
        password,
      type: "GET",
      success: function (data) {
        if (username == "") {
          Swal.fire({
            title: "Error!",
            text: "Username belum di isi",
            icon: "error",
            confirmButtonText: "OK",
          });
        } else if (password == "") {
          Swal.fire({
            title: "Error!",
            text: "Password belum di isi",
            icon: "error",
            confirmButtonText: "OK",
          });
        } else if (data.errUsername == "yes") {
          Swal.fire({
            title: "Error!",
            text: "User ini belum terdaftar",
            icon: "error",
            confirmButtonText: "OK",
          });
        } else if (data.errPassword == "yes") {
          Swal.fire({
            title: "Error!",
            text: "Password yang di input belum benar",
            icon: "error",
            confirmButtonText: "OK",
          });
        } else if (data.usergroup == "Operator") {
          location.replace(
            "http://10.14.134.44/project/main/operator.php"
          );
        } else if (data.usergroup != "Operator") {
          location.replace(
            "http://10.14.134.44/project/main/supervisor.php"
          );
        }
      },
    });
  });
});
