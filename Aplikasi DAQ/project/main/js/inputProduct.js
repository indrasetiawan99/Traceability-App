$( document ).ready(function() {
    $("#submit-input-product").click(function(){
        var idOperator = document.getElementById('id-operator').value.substring(0,4);
        var cavity = document.getElementById('cavity').value;
        var partRH = document.getElementById("right-part").value;
        var partLH = document.getElementById("left-part").value;
        
        $.ajax({
            type : "POST",
            url : "http://10.14.134.44/project/database/web/inputProduct.php",
            data : "id-operator="+idOperator+"&cavity="+cavity+"&right-part="+partRH+"&left-part="+partLH,
            success : function(data) {
                if(idOperator != ""){
                    if(cavity !=""){
                        if(cavity == "1-Right"){
                            if(partRH != ""){
                                if(data.errUser == 'yes'){
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'User ini belum terdaftar',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }else if(data.errSkill == 'yes'){
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Operator skill tidak mencukupi',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }else if(data.errProd1 == 'yes'){
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Setup produksi sebelumnya belum selesai',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }else if(data.errProd2 == 'yes'){
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Part ini belum saat nya di input, ikuti planning dari supervisor',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }else{
                                    location.replace("http://10.14.134.44/project/main/operator.php");
                                }
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Part RH belum di pilih',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }else if(cavity == "1-Left"){
                            if(partLH != ""){
                                if(data.errUser == 'yes'){
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'User ini belum terdaftar',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }else if(data.errSkill == 'yes'){
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Operator skill tidak mencukupi',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }else if(data.errProd1 == 'yes'){
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Setup produksi sebelumnya belum selesai',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }else if(data.errProd2 == 'yes'){
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Part ini belum saat nya di input, ikuti planning dari supervisor',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }else{
                                    location.replace("http://10.14.134.44/project/main/operator.php");
                                }
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Part LH belum di pilih',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }else if(cavity == "2"){
                            if(partLH != "" && partRH != ""){
                                if(data.errUser == 'yes'){
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'User ini belum terdaftar',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }else if(data.errSkill == 'yes'){
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Operator skill tidak mencukupi',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }else if(data.errProd1 == 'yes'){
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Setup produksi sebelumnya belum selesai',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }else if(data.errProd2 == 'yes'){
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Part ini belum saat nya di input, ikuti planning dari supervisor',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }else{
                                    location.replace("http://10.14.134.44/project/main/operator.php");
                                }
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Part LH atau Part RH belum di pilih',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    }else{
                        Swal.fire({
                            title: 'Error!',
                            text: 'Cavity belum di pilih',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }else{
                    Swal.fire({
                        title: 'Error!',
                        text: 'Data operator belum di isi',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
});



