$(document).ready(function () {
  setInterval(function () {
    var badge_downtime = document.getElementById("badge-downtime");

    $.ajax({
      type: "POST",
      url: "http://10.14.134.44/project/database/web/badge_downtime.php",
      data: "badge_downtime=Read",
      success: function (data) {
        badge_downtime.innerHTML = data.badge_downtime;

        $.ajax({
          type: "POST",
          datatype: "html",
          url:
            "http://10.14.134.44/project/database/web/badge_downtime.php",
          data: "badge_downtime=Write",
          success: function (msg) {
            $("tbody#downtime-table").html(msg);
          },
        });
      },
    });
  }, 1000); // update about every second
});
