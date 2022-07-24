$(document).ready(function() {
    $("#registrasi-user").submit(function(e) {
        var npk = $('#npk').val();
        var form_data = {
            'npk': $('#npk').val(),
            'full-name': $('#full-name').val(),
            'short-name': $('#short-name').val(),
            'user-group': $('#user-group').val(),
            'op-skill': $('#op-skill').val(),
            'user-name': $('#user-name').val(),
            'password': $('#password').val(),
            'rfid-tag': $('#rfid-tag').val()
        };

        $.ajax({
            type: "POST",
            url: "http://10.14.134.44/admin/database/registrasi_db.php",
            data: "cek-user="+npk,
            success: function (data) {
                if(data.err_user == 'Yes'){
                    Swal.fire({
                        title: "Error!",
                        text: "User sudah terdaftar",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                } else if(data.err_user == 'No') {
                    $.ajax({
                        type: "POST",
                        url: "http://10.14.134.44/admin/database/registrasi_db.php",
                        data: form_data,
                        success: function (data) {
                            Swal.fire({
                                title: "success!",
                                text: "Registrasi berhasil",
                                icon: "success",
                                confirmButtonText: "OK",
                            }).then(() => {
                                location.replace(
                                  "http://10.14.134.44/admin/main/registrasi.php"
                                );
                            });
                        },
                    });
                }
            },
        });

        // Menonaktifkan fungsi submit form dengan php
        e.preventDefault();
    });
});