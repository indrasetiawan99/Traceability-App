$(document).ready(function () {
  $("#submit-start-dnt-edit").click(function () {
    var desc = document.getElementById("desc-dnt-edit").value;
    var id = document.getElementById("id-start-dnt-edit").value;
    var nik = document.getElementById("user-start-dnt-edit").value.substring(0, 4);
    var confirm = document.getElementById("conf-start-dnt-edit").value.substring(0, 4);
    var select_category = document.getElementById("select-category-dnt-edit").value;
    var input_category = document.getElementById("input-category-dnt-edit").value;
    var category = "";

    if (select_category != "") {
      category = select_category;
    } else {
      category = input_category;
    }

    if (confirm != "") {
      if (category != "") {
        if (desc != "") {
          if (confirm == nik) {
            $.ajax({
              type: "POST",
              url: "http://10.14.134.44/project/database/web/downtime.php",
              data: "action=edit&type=start-downtime&id=" + id + "&category=" + category + "&desc=" + desc,
              success: function (data) {
                location.replace(
                  "http://10.14.134.44/project/main/operator.php"
                );
              },
            });
          } else {
            Swal.fire({
              title: 'Error!',
              text: 'Hanya boleh diubah oleh user yang menginput data',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          }
        } else {
          Swal.fire({
            title: 'Error!',
            text: 'Isi deskripsi downtime',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        }
      } else {
        Swal.fire({
          title: 'Error!',
          text: 'Isi kategori downtime',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    } else {
      Swal.fire({
        title: 'Error!',
        text: 'Isi data konfimasi user menggunakan kartu RFID',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });

  $("#submit-start-dnt").click(function () {
    var nik = document.getElementById("user-start-dnt").value.substring(0, 4);
    var select_category = document.getElementById("select-category-dnt").value;
    var input_category = document.getElementById("input-category-dnt").value;
    var desc = document.getElementById("desc-dnt").value;
    var category = "";

    if (select_category != "") {
      category = select_category;
    } else {
      category = input_category;
    }

    if (nik != "") {
      if (category != "") {
        if (desc != "") {
          $.ajax({
            type: "POST",
            url: "http://10.14.134.44/project/database/web/downtime.php",
            data:
              "action=input&type=start-downtime&nik=" +
              nik +
              "&category=" +
              category +
              "&desc=" +
              desc,
            success: function (data) {
              location.replace(
                "http://10.14.134.44/project/main/operator.php"
              );
            },
          });
        } else {
          Swal.fire({
            title: 'Error!',
            text: 'Isi deskripsi downtime',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        }
      } else {
        Swal.fire({
          title: 'Error!',
          text: 'Isi kategori downtime',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    } else {
      Swal.fire({
        title: 'Error!',
        text: 'Isi data user menggunakan kartu RFID',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });

  $("#submit-finish-dnt").click(function () {
    var id = document.getElementById("id-finish-dnt").value;
    var nik = document.getElementById("user-finish-dnt").value.substring(0, 4);

    if (nik != "") {
      $.ajax({
        type: "POST",
        url: "http://10.14.134.44/project/database/web/downtime.php",
        data: "action=input&type=finish-downtime&id=" + id + "&nik=" + nik,
        success: function (data) {
          if(data.err_user == 'Yes'){
            Swal.fire({
              title: 'Error!',
              text: 'Harus diisi oleh orang lain',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          }else if(data.err_user == 'No'){
            location.replace(
              "http://10.14.134.44/project/main/operator.php"
            );
          }
        },
      });
    } else {
      Swal.fire({
        title: 'Error!',
        text: 'Isi data user menggunakan kartu RFID',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });

  const checkbox1 = document.getElementById("cb-dnt-cat");
  document.getElementById("input-dnt-cat").style.display = "none";
  document.getElementById("input-category-dnt").value = "";
  checkbox1.addEventListener("change", (event) => {
    if (event.currentTarget.checked) {
      document.getElementById("select-dnt-cat").style.display = "none";
      document.getElementById("input-dnt-cat").style.display = "block";
      document.getElementById("input-category-dnt").value = "Lain-lain";
      document.getElementById("select-category-dnt").value = "";
    } else {
      document.getElementById("input-dnt-cat").style.display = "none";
      document.getElementById("select-dnt-cat").style.display = "block";
      document.getElementById("input-category-dnt").value = "";
    }
  });

  const checkbox2 = document.getElementById("cb-dnt-cat-edit");
  checkbox2.addEventListener("change", (event) => {
    if (event.currentTarget.checked) {
      document.getElementById("select-dnt-cat-edit").style.display = "none";
      document.getElementById("input-dnt-cat-edit").style.display = "block";
      document.getElementById("input-category-dnt-edit").value = "Lain-lain";
      document.getElementById("select-category-dnt-edit").value = "";
    } else {
      document.getElementById("input-dnt-cat-edit").style.display = "none";
      document.getElementById("select-dnt-cat-edit").style.display = "block";
      document.getElementById("input-category-dnt-edit").value = "";
    }
  });
});
