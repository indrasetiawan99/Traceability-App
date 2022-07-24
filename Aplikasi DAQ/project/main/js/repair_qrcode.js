$(document).ready(function () {
  setInterval(function () {
    $.ajax({
      type: "POST",
      datatype: "html",
      url:
        "http://10.14.134.44/project/database/web/repair_qrcode_db.php",
      data: "action=Write",
      success: function (msg) {
        $("tbody#repair_qrcode").html(msg);
      },
    });

    $.ajax({
      type: "POST",
      url: "http://10.14.134.44/project/database/web/repair_qrcode_db.php",
      data: "action=Read",
      success: function (data) {
        document.getElementById("part-name-repair").value = data.part_name; 
      },
    });
  }, 1000); // update about every second
});
