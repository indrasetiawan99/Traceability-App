$( document ).ready(function() {
    
    var one_cycle = true;
    var t_before;
    var action = true;
    var dataURL = "";
    var accumulation = 0;
    var shift = '';

    // Counting Target
    setInterval(function () {

        var dt_now = new Date();
        var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        
        var date_setup_shift_min = new Date(dt_now);
        date_setup_shift_min.setHours(00,00,00);
        var date_setup_shift_max = new Date(dt_now);
        date_setup_shift_max.setHours(05,59,59);

        if(dt_now >= date_setup_shift_min && dt_now <= date_setup_shift_max){
            var shift1_from = new Date();
            shift1_from.setHours(06, 00, 00);
            shift1_from.setDate(dt_now.getDate() - 1);
            var shift1_to = new Date();
            shift1_to.setHours(17, 59, 59);
            shift1_to.setDate(dt_now.getDate() - 1);

            var shift3_from = new Date();
            shift3_from.setHours(18, 00, 00);
            shift3_from.setDate(dt_now.getDate() - 1);
            var shift3_to = new Date();
            shift3_to.setHours(05, 59, 59);
        }else{
            var shift1_from = new Date();
            shift1_from.setHours(06, 00, 00);
            var shift1_to = new Date();
            shift1_to.setHours(17, 59, 59);

            var shift3_from = new Date();
            shift3_from.setHours(18, 00, 00);
            var shift3_to = new Date();
            shift3_to.setHours(05, 59, 59);
            shift3_to.setDate(dt_now.getDate() + 1);
        }

        // Untuk otomatis finish setup production di dalam satu shift
        if(dt_now >= shift1_from && dt_now <= shift1_to){
            shift_end = shift1_to;
            dataURL = "action=ReadS1&day="+days[dt_now.getDay()];
            shift = 'shift1';
        } else if(dt_now >= shift3_from || dt_now <= shift3_to){
            shift_end = shift3_to;
            dataURL = "action=ReadS3&day="+days[dt_now.getDay()];
            shift = 'shift3';
        }

        $.ajax({
            type : "POST",
            url : "http://10.14.134.44/project/database/web/qualityDowntime2.php",
            data : dataURL,
            success : function(data) {
                var counter = Number(data.counter);
                var t_prod = Number(data.t_prod) * 1000;
                var created_at = data.created_at;
                var dt_created = new Date(created_at);
                var gt_created = dt_created.getTime();
                var start = data.start;
                var dt_start = new Date(start);
                var gt_start = dt_start.getTime();
                var target = Number(data.target);

                var year_start = Number(start.substring(0, 4));
                var month_start = Number(start.substring(5, 7));
                var date_start = Number(start.substring(8, 10));
                var hour_start = Number(start.substring(11, 13));
                var min_start = Number(start.substring(14, 16));
                var sec_start = Number(start.substring(17, 19));
                
                var finish = data.finish;
                var dt_finish = new Date(finish);
                var gt_finish = dt_finish.getTime();
                
                var br1_f = data.break1_from;
                var br1_t = data.break1_to;
                var br2_f = data.break2_from;
                var br2_t = data.break2_to;
                var br3_f = data.break3_from;
                var br3_t = data.break3_to;
                
                var br1_from = new Date();
                br1_from.setHours(Number(br1_f.substring(0, 2)), Number(br1_f.substring(3, 5)), Number(br1_f.substring(6, 8)));
                var br1_to = new Date();
                br1_to.setHours(Number(br1_t.substring(0, 2)), Number(br1_t.substring(3, 5)), Number(br1_t.substring(6, 8)));
                var br2_from = new Date();
                br2_from.setHours(Number(br2_f.substring(0, 2)), Number(br2_f.substring(3, 5)), Number(br2_f.substring(6, 8)));
                var br2_to = new Date();
                br2_to.setHours(Number(br2_t.substring(0, 2)), Number(br2_t.substring(3, 5)), Number(br2_t.substring(6, 8)));
                var br3_from = new Date();
                br3_from.setHours(Number(br3_f.substring(0, 2)), Number(br3_f.substring(3, 5)), Number(br3_f.substring(6, 8)));
                var br3_to = new Date();
                br3_to.setHours(Number(br3_t.substring(0, 2)), Number(br3_t.substring(3, 5)), Number(br3_t.substring(6, 8)));
                
                var gt_br1_from = br1_from.getTime();
                var gt_br1_to = br1_to.getTime();
                var gt_br2_from = br2_from.getTime();
                var gt_br2_to = br2_to.getTime();
                var gt_br3_from = br3_from.getTime();
                var gt_br3_to = br3_to.getTime();

                var br_OT = new Date()
                br_OT.setHours(19, 00, 00);
                var br_OT_from = new Date();
                br_OT_from.setHours(22, 00, 00);
                var br_OT_to = new Date()
                br_OT_to.setHours(22, 10, 00);

                var t_after = new Date().getTime();

                if(shift == 'shift3'){
            
                    if(dt_now >= date_setup_shift_min && dt_now <= date_setup_shift_max){
                        br1_from.setDate(dt_now.getDate() - 1);
                        br1_to.setDate(dt_now.getDate() - 1);
                        br_OT_from.setDate(dt_now.getDate() - 1);
                        br_OT_to.setDate(dt_now.getDate() - 1);
                        br2_from.setDate(dt_now.getDate());
                        br2_to.setDate(dt_now.getDate());
                        br3_from.setDate(dt_now.getDate());
                        br3_to.setDate(dt_now.getDate());
                        br_OT.setDate(dt_now.getDate() - 1);
                    }else{
                        br1_from.setDate(dt_now.getDate());
                        br1_to.setDate(dt_now.getDate());
                        br_OT_from.setDate(dt_now.getDate());
                        br_OT_to.setDate(dt_now.getDate());
                        br2_from.setDate(dt_now.getDate() + 1);
                        br2_to.setDate(dt_now.getDate() + 1);
                        br3_from.setDate(dt_now.getDate() + 1);
                        br3_to.setDate(dt_now.getDate() + 1);
                        br_OT.setDate(dt_now.getDate());
                    }

                    if(dt_now >= br_OT){
                        if(dt_start <= br_OT){
                            shift = 'shift3_2';
                        }
                    }
                }
                
                if(dt_created > dt_start){
                    if(shift == 'shift1'){
                        if(dt_created >= br3_to){
                            accumulation = Math.round(((gt_created - gt_start) - 4200000)/ t_prod);
                        } else if(dt_created >= br3_from){
                            accumulation = Math.round((((gt_created - gt_start) - (gt_created - gt_br3_from)) - 3600000)/ t_prod);
                        } else if(dt_created >= br2_to){
                            accumulation = Math.round(((gt_created - gt_start) - 3600000)/ t_prod);
                        } else if(dt_created >= br2_from){
                            accumulation = Math.round((((gt_created - gt_start) - (gt_created - gt_br2_from)) - 600000)/ t_prod);
                        } else if(dt_created >= br1_to){
                            accumulation = Math.round(((gt_created - gt_start) - 600000)/ t_prod);
                        } else if(dt_created >= br1_from){
                            accumulation = Math.round(((gt_created - gt_start) - (gt_created - gt_br1_from))/ t_prod);
                        } else if(dt_created < br1_from){
                            accumulation = Math.round((gt_created - gt_start) / t_prod);
                        }
                    } else if(shift == 'shift3'){
                        if(dt_created >= br3_to){
                            accumulation = Math.round(((gt_created - gt_start) - 6600000)/ t_prod);
                        } else if(dt_created >= br3_from){
                            accumulation = Math.round((((gt_created - gt_start) - (gt_created - gt_br3_from)) - 5400000)/ t_prod);
                        } else if(dt_created >= br2_to){
                            accumulation = Math.round(((gt_created - gt_start) - 5400000)/ t_prod);
                        } else if(dt_created >= br2_from){
                            accumulation = Math.round((((gt_created - gt_start) - (gt_created - gt_br2_from)) - 3000000)/ t_prod);
                        } else if(dt_created >= br1_to){
                            accumulation = Math.round(((gt_created - gt_start) - 3000000)/ t_prod);
                        } else if(dt_created >= br1_from){
                            accumulation = Math.round(((gt_created - gt_start) - (gt_created - gt_br1_from))/ t_prod);
                        } else if(dt_created < br1_from){
                            accumulation = Math.round((gt_created - gt_start) / t_prod);
                        }
                    } else if(shift == 'shift3_2'){
                        if(dt_created >= br3_to){
                            accumulation = Math.round(((gt_created - gt_start) - 7200000)/ t_prod);
                        } else if(dt_created >= br3_from){
                            accumulation = Math.round((((gt_created - gt_start) - (gt_created - gt_br3_from)) - 6000000)/ t_prod);
                        } else if(dt_created >= br2_to){
                            accumulation = Math.round(((gt_created - gt_start) - 6000000)/ t_prod);
                        } else if(dt_created >= br2_from){
                            accumulation = Math.round((((gt_created - gt_start) - (gt_created - gt_br2_from)) - 3600000)/ t_prod);
                        } else if(dt_created >= br_OT_to){ 
                            accumulation = Math.round(((gt_created - gt_start) - 3600000)/ t_prod);
                        } else if(dt_created >= br_OT_from){
                            accumulation = Math.round((((gt_created - gt_start) - (gt_created - br_OT_from)) - 3000000)/ t_prod);
                        } else if(dt_created >= br1_to){
                            accumulation = Math.round(((gt_created - gt_start) - 3000000)/ t_prod);
                        } else if(dt_created >= br1_from){
                            accumulation = Math.round(((gt_created - gt_start) - (gt_created - gt_br1_from))/ t_prod);
                        } else if(dt_created < br1_from){
                            accumulation = Math.round((gt_created - gt_start) / t_prod);
                        }
                    }
                    
                    if(accumulation > counter){
                        counter += accumulation;
                    }
                }

                // Break time
                if(shift != 'shift3_2'){
                    if ((dt_now >= br1_from && dt_now <= br1_to) || (dt_now >= br2_from && dt_now <= br2_to) || (dt_now >= br3_from && dt_now <= br3_to)) {
                        action = false;
                    } else {
                        action = true;
                    }
                }else if(shift == 'shift3_2'){
                    if ((dt_now >= br1_from && dt_now <= br1_to) || (dt_now >= br2_from && dt_now <= br2_to) || (dt_now >= br3_from && dt_now <= br3_to) || (dt_now >= br_OT_from && dt_now <= br_OT_to)) {
                        action = false;
                    } else {
                        action = true;
                    }
                }
                

                // Production time
                if (dt_now >= dt_start && dt_now <= dt_finish) {
                    if(one_cycle){
                        var n1 = counter * Number(data.t_prod);
                        var n2 = n1 / 3600;
                        var n3 = n1 % 3600;
                        var hour = Math.floor(n2);
                        var n4 = n3 / 60;
                        var minutes = Math.floor(n4);
                        var second = n3 % 60;

                        // Assign value time
                        hour_start += hour;
                        min_start += minutes;
                        sec_start += second;
                        if(sec_start > 59){
                            var carry_second = Math.floor(sec_start / 60);
                            sec_start -= 60;
                            min_start += carry_second;
                            if(min_start > 59){
                                var carry_minute = Math.floor(min_start / 60);
                                min_start -= 60;
                                hour_start += carry_minute;
                                if(hour_start > 23){
                                    var carry_hour = Math.floor(hour_start / 24);
                                    hour_start -= 24;
                                    date_start += carry_hour;
                                    if(month[dt_now.getMonth()] == 'January' || month[dt_now.getMonth()] == 'March' || month[dt_now.getMonth()] == 'May' || month[dt_now.getMonth()] == 'July' || month[dt_now.getMonth()] == 'August' || month[dt_now.getMonth()] == 'October' || month[dt_now.getMonth()] == 'December'){
                                        if(date_start > 31){
                                            date_start -= 31;
                                            month_start += 1;
                                        }
                                    }
                                    if(month[dt_now.getMonth()] == 'February'){
                                        var kabisat = year_start % 4;
                                        if(kabisat == 0){
                                            if(date_start > 29){
                                                date_start -= 29;
                                                month_start += 1;
                                            }
                                        }else{
                                            if(date_start > 28){
                                                date_start -= 28;
                                                month_start += 1;
                                            }
                                        }
                                    }
                                    if(month[dt_now.getMonth()] == 'April' || month[dt_now.getMonth()] == 'June' || month[dt_now.getMonth()] == 'September' || month[dt_now.getMonth()] == 'November'){
                                        if(date_start > 30){
                                            date_start -= 30;
                                            month_start += 1;
                                        }
                                    }
                                    if(month_start > 12){
                                        month_start -= 12;
                                        year_start += 1;
                                    }
                                }
                            }

                        }
                        var dt_start_now = new Date(year_start + '-' + month_start + '-' + date_start + ' ' + String(hour_start) + ':' + String(min_start) + ':' + String(sec_start));
                        // console.log(year_start + '-' + month_start + '-' + date_start + ' ' + String(hour_start) + ':' + String(min_start) + ':' + String(sec_start));

                        t_before = dt_start_now.getTime();
                        one_cycle = false;
                    }
                    if (action) {
                        if (t_after - t_before >= t_prod) {
                            t_before = t_after;
                            counter += 1;

                            // Update cum_target
                            if(counter <= target){
                                $.ajax({
                                    type: "POST",
                                    url: "http://10.14.134.44/project/database/web/qualityDowntime2.php",
                                    data: "action=Update_Quality&cum_target="+counter,
                                    success: function (data) {},
                                });
                            }
                        }
                    }
                }
            }
                
        });
    }, 1000); // update about every second

    // Update Quality
    setInterval(function () {
        $.ajax({
            type: "POST",
            url: "http://10.14.134.44/project/database/web/update_quality2.php",
            data: "action=Update",
            success: function (data) {},
        });
    }, 1000); // update about every second
});




