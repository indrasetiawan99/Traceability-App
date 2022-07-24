$(document).ready(function () {
  $("#btn-edit").click(function () {
    var checkboxes = document.querySelectorAll("input[type=checkbox]:checked");
    document.getElementById("box1").style.display = "none";
    document.getElementById("box2").style.display = "none";
    document.getElementById("box3").style.display = "none";

    document.getElementById("edit-target1").required = false;
    document.getElementById("edit-start-date1").required = false;
    document.getElementById("edit-start-hour1").required = false;
    document.getElementById("edit-start-min1").required = false;
    document.getElementById("edit-finish-date1").required = false;
    document.getElementById("edit-finish-hour1").required = false;
    document.getElementById("edit-finish-min1").required = false;
    document.getElementById("edit-target2").required = false;
    document.getElementById("edit-start-date2").required = false;
    document.getElementById("edit-start-hour2").required = false;
    document.getElementById("edit-start-min2").required = false;
    document.getElementById("edit-finish-date2").required = false;
    document.getElementById("edit-finish-hour2").required = false;
    document.getElementById("edit-finish-min2").required = false;
    document.getElementById("edit-target3").required = false;
    document.getElementById("edit-start-date3").required = false;
    document.getElementById("edit-start-hour3").required = false;
    document.getElementById("edit-start-min3").required = false;
    document.getElementById("edit-finish-date3").required = false;
    document.getElementById("edit-finish-hour3").required = false;
    document.getElementById("edit-finish-min3").required = false;

    if (checkboxes.length == 1) {
      $dataAjax = "idPart1=" + checkboxes[0].value;
      $urlAjax =
        "http://10.14.134.44/project/database/web/editSetup.php?jumlahData=" +
        1;
    } else if (checkboxes.length == 2) {
      $dataAjax =
        "idPart1=" + checkboxes[0].value + "&idPart2=" + checkboxes[1].value;
      $urlAjax =
        "http://10.14.134.44/project/database/web/editSetup.php?jumlahData=" +
        2;
    } else if (checkboxes.length == 3) {
      $dataAjax =
        "idPart1=" +
        checkboxes[0].value +
        "&idPart2=" +
        checkboxes[1].value +
        "&idPart3=" +
        checkboxes[2].value;
      $urlAjax =
        "http://10.14.134.44/project/database/web/editSetup.php?jumlahData=" +
        3;
    } else {
      $dataAjax = "";
      $urlAjax = "http://10.14.134.44/project/database/web/editSetup.php";
    }

    $.ajax({
      type: "POST",
      url: $urlAjax,
      data: $dataAjax,
      success: function (data) {
        if (checkboxes.length >= 1) {
          document.getElementById("box1").style.display = "block";

          document.getElementById("edit-part-name1").value = data.partname1;
          document.getElementById("edit-target1").value = data.target1;
          document.getElementById("edit-start-date1").value = data.startDate1;
          document.getElementById("edit-start-hour1").value = data.startTime1.substring(0, 2);
          document.getElementById("edit-start-min1").value = data.startTime1.substring(3, 5);
          document.getElementById("edit-finish-date1").value = data.endDate1;
          document.getElementById("edit-finish-hour1").value = data.endTime1.substring(0, 2);
          document.getElementById("edit-finish-min1").value = data.endTime1.substring(3, 5);

          document.getElementById("edit-target1").required = true;
          document.getElementById("edit-start-date1").required = true;
          document.getElementById("edit-start-hour1").required = true;
          document.getElementById("edit-start-min1").required = true;
          document.getElementById("edit-finish-date1").required = true;
          document.getElementById("edit-finish-hour1").required = true;
          document.getElementById("edit-finish-min1").required = true;
        }
        if (checkboxes.length >= 2) {
          document.getElementById("box2").style.display = "block";

          document.getElementById("edit-part-name2").value = data.partname2;
          document.getElementById("edit-target2").value = data.target2;
          document.getElementById("edit-start-date2").value = data.startDate2;
          document.getElementById("edit-start-hour2").value = data.startTime2.substring(0, 2);
          document.getElementById("edit-start-min2").value = data.startTime2.substring(3, 5);
          document.getElementById("edit-finish-date2").value = data.endDate2;
          document.getElementById("edit-finish-hour2").value = data.endTime2.substring(0, 2);
          document.getElementById("edit-finish-min2").value = data.endTime2.substring(3, 5);

          document.getElementById("edit-target2").required = true;
          document.getElementById("edit-start-date2").required = true;
          document.getElementById("edit-start-hour2").required = true;
          document.getElementById("edit-start-min2").required = true;
          document.getElementById("edit-finish-date2").required = true;
          document.getElementById("edit-finish-hour2").required = true;
          document.getElementById("edit-finish-min2").required = true;
        }
        if (checkboxes.length >= 3) {
          document.getElementById("box3").style.display = "block";

          document.getElementById("edit-part-name3").value = data.partname3;
          document.getElementById("edit-target3").value = data.target3;
          document.getElementById("edit-start-date3").value = data.startDate3;
          document.getElementById("edit-start-hour3").value = data.startTime3.substring(0, 2);
          document.getElementById("edit-start-min3").value = data.startTime3.substring(3, 5);
          document.getElementById("edit-finish-date3").value = data.endDate3;
          document.getElementById("edit-finish-hour3").value = data.endTime3.substring(0, 2);
          document.getElementById("edit-finish-min3").value = data.endTime3.substring(3, 5);

          document.getElementById("edit-target3").required = true;
          document.getElementById("edit-start-date3").required = true;
          document.getElementById("edit-start-hour3").required = true;
          document.getElementById("edit-start-min3").required = true;
          document.getElementById("edit-finish-date3").required = true;
          document.getElementById("edit-finish-hour3").required = true;
          document.getElementById("edit-finish-min3").required = true;
        }
      },
    });
  });
});
