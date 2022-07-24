$(document).ready(function () {
  setInterval(function () {
    $.ajax({
      type: "POST",
      url: "http://10.14.134.44/project/database/web/badge_remaining_part.php",
      data: "badge-remaining-part=Read",
      success: function (data) {
        document.getElementById("badge-remaining-part").innerHTML = data.badge_remaining_part;
      },
    });
  }, 1000); // update about every second
});
