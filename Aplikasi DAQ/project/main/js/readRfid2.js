$(document).ready(function () {
  setInterval(function () {
    $.ajax({
      type: "POST",
      url: "http://10.14.134.44/project/database/web/readRfid2.php",
      data: "action=read",
      success: function (data) {
        if (data.dataRfid != "") {
          document.getElementById("id-operator").value = data.dataRfid;
          document.getElementById("user-start-dnt").value = data.dataRfid;
          document.getElementById("conf-start-dnt-edit").value = data.dataRfid;
          document.getElementById("user-finish-dnt").value = data.dataRfid;

          $.ajax({
            type: "POST",
            url: "http://10.14.134.44/project/database/web/readRfid2.php",
            data: "action=delete",
            success: function (data) {},
          });
        }
      },
    });
  }, 500);
});
