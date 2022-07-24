$(document).ready(function () {
  setInterval(function () {
    $.ajax({
      type: "POST",
      url:"http://10.14.134.44/project/database/web/readRfid.php",
      data: "action=read",
      success: function (data) {
        if (data.username != "" && data.password != "") {
          document.getElementById("username").value = data.username;
          document.getElementById("password").value = data.password;

          $.ajax({
            type: "POST",
            url:"http://10.14.134.44/project/database/web/readRfid.php",
            data: "action=delete",
            success: function (data) {},
          });
        }
      },
    });
  }, 500);
});
