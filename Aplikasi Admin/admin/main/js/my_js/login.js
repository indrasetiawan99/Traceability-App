$(document).ready(function () {
  $("#btn-submit").on("click", function() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

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
    } else {
      $.ajax({
        type: "POST",
        url: "http://10.14.134.44/admin/database/login_db.php",
        data: 'username='+username+'&password='+password,
        success: function (data) {
          if (data.err_username == "yes") {
            Swal.fire({
              title: "Error!",
              text: "User ini tidak terdaftar",
              icon: "error",
              confirmButtonText: "OK",
            });
          } else if (data.err_password == "yes") {
            Swal.fire({
              title: "Error!",
              text: "Salah password",
              icon: "error",
              confirmButtonText: "OK",
            });
          } else {
            location.replace(
              "http://10.14.134.44/admin/main/tr_quick_trace.php"
            );
          }
        },
      });
    }
  });
});
  