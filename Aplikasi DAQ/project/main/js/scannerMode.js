$(document).ready(function () {
  setInterval(function () {
    var mode1 = document.getElementById("mode1");
    var mode2 = document.getElementById("mode2");
    var data;

    if (mode1.checked == true) {
      data = mode1.value;
    } else if (mode2.checked == true) {
      data = mode2.value;
    }

    $.ajax({
      type: "POST",
      url: "http://10.14.134.44/project/database/web/scannerMode.php",
      data: "Mode=" + data,
      success: function (data) {},
    });
  }, 1000); // update about every second
});
