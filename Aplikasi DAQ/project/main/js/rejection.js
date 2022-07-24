$(document).ready(function () {
  const checkbox_R = document.getElementById("cb-ng-cat-R");
  document.getElementById("input-ng-cat-R").style.display = "none";
  document.getElementById("input-category-ng-R").value = "";
  checkbox_R.addEventListener("change", (event) => {
    if (event.currentTarget.checked) {
      document.getElementById("select-ng-cat-R").style.display = "none";
      document.getElementById("input-ng-cat-R").style.display = "block";
      document.getElementById("select-category-ng-R").value = "";
      document.getElementById("input-category-ng-R").value = "Lain-lain";
      $("#select-category-ng-R").multiselect("deselectAll", false);
    } else {
      document.getElementById("input-ng-cat-R").style.display = "none";
      document.getElementById("select-ng-cat-R").style.display = "block";
      document.getElementById("input-category-ng-R").value = "";
    }
  });

  const checkbox_L = document.getElementById("cb-ng-cat-L");
  document.getElementById("input-ng-cat-L").style.display = "none";
  document.getElementById("input-category-ng-L").value = "";
  checkbox_L.addEventListener("change", (event) => {
    if (event.currentTarget.checked) {
      document.getElementById("select-ng-cat-L").style.display = "none";
      document.getElementById("input-ng-cat-L").style.display = "block";
      document.getElementById("select-category-ng-L").value = "";
      document.getElementById("input-category-ng-L").value = "Lain-lain";
      $("#select-category-ng-L").multiselect("deselectAll", false);
    } else {
      document.getElementById("input-ng-cat-L").style.display = "none";
      document.getElementById("select-ng-cat-L").style.display = "block";
      document.getElementById("input-category-ng-L").value = "";
    }
  });

  var orderCount_R = 0;
  $("#select-category-ng-R").multiselect({
    maxHeight: 200,
    buttonWidth: "465px",
    includeSelectAllOption: true,
    enableFiltering: true,
    onChange: function (option, checked) {
      if (checked) {
        orderCount_R++;
        $(option).data("order", orderCount_R);
      } else {
        $(option).data("order", "");
      }
    },
    buttonText: function (options) {
      if (options.length === 0) {
        return "None selected";
      } else if (options.length > 5) {
        return options.length + " selected";
      } else {
        var selected = [];
        options.each(function () {
          selected.push([$(this).text(), $(this).data("order")]);
        });

        selected.sort(function (a, b) {
          return a[1] - b[1];
        });

        var text = "";
        for (var i = 0; i < selected.length; i++) {
          text += selected[i][0] + ", ";
        }

        return text.substr(0, text.length - 2);
      }
    },
  });

  var orderCount_L = 0;
  $("#select-category-ng-L").multiselect({
    maxHeight: 200,
    buttonWidth: "465px",
    includeSelectAllOption: true,
    enableFiltering: true,
    onChange: function (option, checked) {
      if (checked) {
        orderCount_L++;
        $(option).data("order", orderCount_L);
      } else {
        $(option).data("order", "");
      }
    },
    buttonText: function (options) {
      if (options.length === 0) {
        return "None selected";
      } else if (options.length > 5) {
        return options.length + " selected";
      } else {
        var selected = [];
        options.each(function () {
          selected.push([$(this).text(), $(this).data("order")]);
        });

        selected.sort(function (a, b) {
          return a[1] - b[1];
        });

        var text = "";
        for (var i = 0; i < selected.length; i++) {
          text += selected[i][0] + ", ";
        }

        return text.substr(0, text.length - 2);
      }
    },
  });

  $("#submit-part-ng-R").on("click", function () {
    var selected = [];
    $("#select-category-ng-R option:selected").each(function () {
      selected.push($(this).val());
    });
    var json_string_selected = JSON.stringify(selected);
    var partname = document.getElementById("part-ng-name-R").value;
    var input_category = document.getElementById("input-category-ng-R").value;
    var category;
    var mode = "";

    if (selected.length != 0) {
      category = json_string_selected;
      mode = "select";
    } else if (input_category != "") {
      category = input_category;
      mode = "input";
    } else {
      mode = "";
    }

    if (mode != "") {
      $.ajax({
        type: "POST",
        url: "http://10.14.134.44/project/database/web/rejection.php",
        data:
          "action=input-R&mode=" +
          mode +
          "&category=" +
          category +
          "&part-name=" +
          partname,
        success: function (data) {
          if (data.err_load == "No") {
            location.replace(
              "http://10.14.134.44/project/main/operator.php"
            );
          } else if (data.err_load == "Yes") {
            Swal.fire({
              title: "Error!",
              text: "Tidak ada loading part",
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        },
      });
    } else {
      Swal.fire({
        title: "Error!",
        text: "Isi kategori rejection",
        icon: "error",
        confirmButtonText: "OK",
      });
    }
  });

  $("#submit-part-ng-L").on("click", function () {
    var selected = [];
    $("#select-category-ng-L option:selected").each(function () {
      selected.push($(this).val());
    });
    var json_string_selected = JSON.stringify(selected);
    var partname = document.getElementById("part-ng-name-L").value;
    var input_category = document.getElementById("input-category-ng-L").value;
    var category;
    var mode = "";

    if (selected.length != 0) {
      category = json_string_selected;
      mode = "select";
    } else if (input_category != "") {
      category = input_category;
      mode = "input";
    } else {
      mode = "";
    }

    if (mode != "") {
      $.ajax({
        type: "POST",
        url: "http://10.14.134.44/project/database/web/rejection.php",
        data:
          "action=input-L&mode=" +
          mode +
          "&category=" +
          category +
          "&part-name=" +
          partname,
        success: function (data) {
          if (data.err_load == "No") {
            location.replace(
              "http://10.14.134.44/project/main/operator.php"
            );
          } else if (data.err_load == "Yes") {
            Swal.fire({
              title: "Error!",
              text: "Tidak ada loading part",
              icon: "error",
              confirmButtonText: "OK",
            });
          }
        },
      });
    } else {
      Swal.fire({
        title: "Error!",
        text: "Isi kategori rejection",
        icon: "error",
        confirmButtonText: "OK",
      });
    }
  });
});
