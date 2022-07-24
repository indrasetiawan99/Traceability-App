$(document).ready(function () {

    // Initialize Component Shift 1 and 3
    if(true){
        // OEE Chart Shift 1
        if( true ){ 
            var options1 = {
                chart: {
                    height: 275,
                    type: "radialBar",
                },
                series: [60],
                colors: ["#20E647"],
                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 135,
                        track: {
                            background: '#e9ecef',
                            startAngle: -135,
                            endAngle: 135,
                        },
                        dataLabels: {
                                name: {
                                show: false,
                            },
                            value: {
                                fontSize: "40px",
                                fontWeight: 'bold',
                                show: true
                            }
                        }
                    }
                },
                fill: {
                    colors: [function({value}) {
                        if(value < 55) {
                            return '#dc3545'
                        } else if (value >= 55 && value < 80) {
                            return '#ffc107'
                        } else {
                            return '#28a745'
                        }
                    }]
                },
                stroke: {
                    lineCap: "butt"
                },
                labels: ["Progress"]
            };
                
                
            var chart = new ApexCharts(document.querySelector("#oee-s1"), options1);
            chart.render();
            chart.updateSeries([1]);
        }

        // Progress Bar Shift 1
        if( true ){ 
            // Progress Bar 1
            var val_bar_1_s1 = 1;
            document.getElementById('lbl-availability-s1').innerHTML = val_bar_1_s1;
            document.getElementById("chart-availability-s1").style.width = val_bar_1_s1 + "%";
            if(val_bar_1_s1 > 80){
                document.getElementById("chart-availability-s1").className = "progress-bar progress-bar-striped progress-bar-animated bg-success";  
            } else if(val_bar_1_s1 > 60){
                document.getElementById("chart-availability-s1").className = "progress-bar progress-bar-striped progress-bar-animated bg-warning";  
            } else if(val_bar_1_s1 < 60){
                document.getElementById("chart-availability-s1").className = "progress-bar progress-bar-striped progress-bar-animated bg-danger";  
            }
            
            // Progress Bar 2
            var val_bar_2_s1 = 1;
            document.getElementById('lbl-performance-s1').innerHTML = val_bar_2_s1;
            document.getElementById("chart-performance-s1").style.width = val_bar_2_s1 + "%";
            if(val_bar_2_s1 > 80){
                document.getElementById("chart-performance-s1").className = "progress-bar progress-bar-striped progress-bar-animated bg-success";  
            } else if(val_bar_2_s1 > 60){
                document.getElementById("chart-performance-s1").className = "progress-bar progress-bar-striped progress-bar-animated bg-warning";  
            } else if(val_bar_2_s1 < 60){
                document.getElementById("chart-performance-s1").className = "progress-bar progress-bar-striped progress-bar-animated bg-danger";  
            }

            // Progress Bar 3
            var val_bar_3_s1 = 1;
            document.getElementById('lbl-quality-s1').innerHTML = val_bar_3_s1;
            document.getElementById("chart-quality-s1").style.width = val_bar_3_s1 + "%";
            if(val_bar_3_s1 > 80){
                document.getElementById("chart-quality-s1").className = "progress-bar progress-bar-striped progress-bar-animated bg-success";  
            } else if(val_bar_3_s1 > 60){
                document.getElementById("chart-quality-s1").className = "progress-bar progress-bar-striped progress-bar-animated bg-warning";  
            } else if(val_bar_3_s1 < 60){
                document.getElementById("chart-quality-s1").className = "progress-bar progress-bar-striped progress-bar-animated bg-danger";  
            }
        }

        // Pie Chart Downtime Shift 1
        if( $('#downtime-s1').length > 0 ){
            var background_color = {
                'Mold' : "#7FFFD4", 
                'Mesin' : "#F5F5DC", 
                'Box' : "#FFE4C4", 
                'Kereta' : "#8A2BE2", 
                'Komponen' : "#A52A2A", 
                'STD Kualitas' : "#DEB887", 
                'Material' : "#5F9EA0", 
                'Pemanasan' : "#D2691E", 
                'Robot' : "#6495ED", 
                'Trial Robot' : "#DC143C", 
                'Kuras Barel' : "#00008B", 
                'Man Power' : "#008B8B", 
                'SR' : "#B8860B", 
                'Brifing' : "#A9A9A9",
                'Setting Mesin' : '#BDB76B',
                'Dandory' : '#CD5C5C',
                'Kuras Manifold' : '#483D8B',
                'Cleaning Mold' : '#2F4F4F',
                'Setting Awal' : '#FFA07A',
                'Lain-lain' : '#DAA520'
            };
            
            var ctx1 = document.getElementById("downtime-s1").getContext("2d");
            var data1 = {
            labels: [],
            datasets: [
                {
                data: [],
                backgroundColor: [],
                hoverBackgroundColor: []
                }]
            };
            
            var pieChart  = new Chart(ctx1,{
            type: 'pie',
            data: data1,
            options: {
                animation: {
                duration:	10
                },
                responsive: true,
                legend: {
                labels: {
                    fontFamily: "Nunito Sans",
                    fontColor: "#7792b1",
                },
                position: "right"
                },
                tooltip: {
                backgroundColor:'rgba(33,33,33,1)',
                cornerRadius:0,
                footerFontFamily:"'Nunito Sans'"
                },
                elements: {
                arc: {
                    borderWidth: 1
                }
                }
            }
            });
        }

        // Pie Chart NG Part Shift 1
        if( $('#ng-part-s1').length > 0 ){
            var background_color2 = {
                'Crack' : "#7FFFD4", 
                'Dimensi' : "#FFE4C4", 
                'Ejector Mark' : "#8A2BE2",
                'Short Shoot' : "#A52A2A",
                'Wide Line' : "#DEB887",
                'Kontaminasi' : "#5F9EA0",
                'Buble' : "#D2691E",
                'Flow Mark' : "#6495ED",
                'Bending' : "#DC143C",
                'Sink Mark' : "#00008B",
                'Burn Mark' : "#008B8B",
                'Scratch' : "#B8860B",
                'Silver' : "#A9A9A9",
                'Blackspot' : "#006400",
                'Gloss' : "#BDB76B",
                'Mutih' : "#556B2F",
                'Minyak' : "#9932CC",
                'Jetting' : "#8B0000",
                'Over Cut' : "#E9967A",
                'Burry' : "#483D8B",
                'Check Of' : "#2F4F4F",
                'Colour (Visual)' : "#00CED1",
                'Setting' : "#696969",
                'Lain-lain' : "#1E90FF"
            };
            
            var ctx2 = document.getElementById("ng-part-s1").getContext("2d");
            var data2 = {
            labels: [],
            datasets: [
                {
                data: [],
                backgroundColor: [],
                hoverBackgroundColor: []
                }]
            };
            
            var pieChart2  = new Chart(ctx2,{
            type: 'pie',
            data: data2,
            options: {
                animation: {
                duration:	10
                },
                responsive: true,
                legend: {
                labels: {
                    fontFamily: "Nunito Sans",
                    fontColor: "#7792b1",
                },
                position: "right"
                },
                tooltip: {
                backgroundColor:'rgba(33,33,33,1)',
                cornerRadius:0,
                footerFontFamily:"'Nunito Sans'"
                },
                elements: {
                arc: {
                    borderWidth: 1
                }
                }
            }
            });
        }

        // Hourly Achivement Shift 1
        if( $('#achivement-s1').length > 0 ){
            var labels = ["6 - 7", "7 - 8", "8 - 9", "9 - 10", "10 - 11", "11 - 12", "12 - 13", "13 - 14", "14 - 15", "15 - 16", "16 - 17", "17 - 18"];
            var label3_1 = "Part RH";
            var label3_2 = "Part LH";
            var background_color3_1 = "#689f38";
            var background_color3_2 = "#38649f";
            var border_color3_1 = "#689f38";
            var border_color3_2 = "#38649f";
            
            var ctx3 = document.getElementById("achivement-s1").getContext("2d");
            var data3 = {
                labels: labels,
                datasets: [
                    {
                        label: label3_1,
                        backgroundColor: background_color3_1,
                        borderColor: border_color3_1,
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                    },
                    {
                        label: label3_2,
                        backgroundColor: background_color3_2,
                        borderColor: border_color3_2,
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                    }
                ]
            };
            
            var hBar3 = new Chart(ctx3, {
                type:"bar",
                data:data3,
                options: {
                    tooltips: {
                        mode:"label"
                    },
                    scales: {
                        yAxes: [{
                            stacked: true,
                            gridLines: {
                                color: "rgba(135,135,135,0)",
                            },
                            ticks: {
                                fontFamily: "Nunito Sans",
                                fontColor:"#878787"
                            }
                        }],
                        xAxes: [{
                            stacked: true,
                            gridLines: {
                                color: "rgba(135,135,135,0)",
                            },
                            ticks: {
                                fontFamily: "Nunito Sans",
                                fontColor:"#878787"
                            }
                        }],
                        
                    },
                    elements:{
                        point: {
                            hitRadius:40
                        }
                    },
                    animation: {
                        duration:	10
                    },
                    responsive: true,
                    maintainAspectRatio:false,
                    legend: {
                        display: true,
                    },
                    
                    tooltip: {
                        backgroundColor:'rgba(33,33,33,1)',
                        cornerRadius:0,
                        footerFontFamily:"'Nunito Sans'"
                    }
                    
                }
            });
        };

        // OEE Chart Shift 3
        if( true ){ 
            var options2 = {
                chart: {
                    height: 275,
                    type: "radialBar",
                },
                series: [60],
                colors: ["#20E647"],
                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 135,
                        track: {
                            background: '#e9ecef',
                            startAngle: -135,
                            endAngle: 135,
                        },
                        dataLabels: {
                                name: {
                                show: false,
                            },
                            value: {
                                fontSize: "40px",
                                fontWeight: 'bold',
                                show: true
                            }
                        }
                    }
                },
                fill: {
                    colors: [function({value}) {
                        if(value < 55) {
                            return '#dc3545'
                        } else if (value >= 55 && value < 80) {
                            return '#ffc107'
                        } else {
                            return '#28a745'
                        }
                    }]
                },
                stroke: {
                    lineCap: "butt"
                },
                labels: ["Progress"]
            };
                
                
            var chart2 = new ApexCharts(document.querySelector("#oee-s3"), options2);
            chart2.render();
            chart2.updateSeries([1]);
        }

        // Progress Bar Shift 3
        if( true ){ 
            // Progress Bar 1
            var val_bar_1_s3 = 1;
            document.getElementById('lbl-availability-s3').innerHTML = val_bar_1_s3;
            document.getElementById("chart-availability-s3").style.width = val_bar_1_s3 + "%";
            if(val_bar_1_s3 > 80){
                document.getElementById("chart-availability-s3").className = "progress-bar progress-bar-striped progress-bar-animated bg-success";  
            } else if(val_bar_1_s3 > 60){
                document.getElementById("chart-availability-s3").className = "progress-bar progress-bar-striped progress-bar-animated bg-warning";  
            } else if(val_bar_1_s3 < 60){
                document.getElementById("chart-availability-s3").className = "progress-bar progress-bar-striped progress-bar-animated bg-danger";  
            }
            
            // Progress Bar 2
            var val_bar_2_s3 = 1;
            document.getElementById('lbl-performance-s3').innerHTML = val_bar_2_s3;
            document.getElementById("chart-performance-s3").style.width = val_bar_2_s3 + "%";
            if(val_bar_2_s3 > 80){
                document.getElementById("chart-performance-s3").className = "progress-bar progress-bar-striped progress-bar-animated bg-success";  
            } else if(val_bar_2_s3 > 60){
                document.getElementById("chart-performance-s3").className = "progress-bar progress-bar-striped progress-bar-animated bg-warning";  
            } else if(val_bar_2_s3 < 60){
                document.getElementById("chart-performance-s3").className = "progress-bar progress-bar-striped progress-bar-animated bg-danger";  
            }

            // Progress Bar 3
            var val_bar_3_s3 = 1;
            document.getElementById('lbl-quality-s3').innerHTML = val_bar_3_s3;
            document.getElementById("chart-quality-s3").style.width = val_bar_3_s3 + "%";
            if(val_bar_3_s3 > 80){
                document.getElementById("chart-quality-s3").className = "progress-bar progress-bar-striped progress-bar-animated bg-success";  
            } else if(val_bar_3_s3 > 60){
                document.getElementById("chart-quality-s3").className = "progress-bar progress-bar-striped progress-bar-animated bg-warning";  
            } else if(val_bar_3_s3 < 60){
                document.getElementById("chart-quality-s3").className = "progress-bar progress-bar-striped progress-bar-animated bg-danger";  
            }
        }

        // Pie Chart Downtime Shift 3
        if( $('#downtime-s3').length > 0 ){
            var ctx4 = document.getElementById("downtime-s3").getContext("2d");
            var data4 = {
            labels: [],
            datasets: [
                {
                data: [],
                backgroundColor: [],
                hoverBackgroundColor: []
                }]
            };
            
            var pieChart4  = new Chart(ctx4,{
            type: 'pie',
            data: data4,
            options: {
                animation: {
                duration:	10
                },
                responsive: true,
                legend: {
                labels: {
                    fontFamily: "Nunito Sans",
                    fontColor: "#7792b1",
                },
                position: "right"
                },
                tooltip: {
                backgroundColor:'rgba(33,33,33,1)',
                cornerRadius:0,
                footerFontFamily:"'Nunito Sans'"
                },
                elements: {
                arc: {
                    borderWidth: 1
                }
                }
            }
            });
        }

        // Pie Chart NG Part Shift 3
        if( $('#ng-part-s3').length > 0 ){
            var ctx5 = document.getElementById("ng-part-s3").getContext("2d");
            var data5 = {
            labels: [],
            datasets: [
                {
                data: [],
                backgroundColor: [],
                hoverBackgroundColor: []
                }]
            };
            
            var pieChart5 = new Chart(ctx5,{
            type: 'pie',
            data: data5,
            options: {
                animation: {
                duration:	10
                },
                responsive: true,
                legend: {
                labels: {
                    fontFamily: "Nunito Sans",
                    fontColor: "#7792b1",
                },
                position: "right"
                },
                tooltip: {
                backgroundColor:'rgba(33,33,33,1)',
                cornerRadius:0,
                footerFontFamily:"'Nunito Sans'"
                },
                elements: {
                arc: {
                    borderWidth: 1
                }
                }
            }
            });
        }

        // Hourly Achivement Shift 3
        if( $('#achivement-s3').length > 0 ){
            var ctx6 = document.getElementById("achivement-s3").getContext("2d");
            var data6 = {
                labels: labels,
                datasets: [
                    {
                        label: label3_1,
                        backgroundColor: background_color3_1,
                        borderColor: border_color3_1,
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                    },
                    {
                        label: label3_2,
                        backgroundColor: background_color3_2,
                        borderColor: border_color3_2,
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                    }
                ]
            };
            
            var hBar6 = new Chart(ctx6, {
                type:"bar",
                data:data6,
                options: {
                    tooltips: {
                        mode:"label"
                    },
                    scales: {
                        yAxes: [{
                            stacked: true,
                            gridLines: {
                                color: "rgba(135,135,135,0)",
                            },
                            ticks: {
                                fontFamily: "Nunito Sans",
                                fontColor:"#878787"
                            }
                        }],
                        xAxes: [{
                            stacked: true,
                            gridLines: {
                                color: "rgba(135,135,135,0)",
                            },
                            ticks: {
                                fontFamily: "Nunito Sans",
                                fontColor:"#878787"
                            }
                        }],
                        
                    },
                    elements:{
                        point: {
                            hitRadius:40
                        }
                    },
                    animation: {
                        duration:	10
                    },
                    responsive: true,
                    maintainAspectRatio:false,
                    legend: {
                        display: true,
                    },
                    
                    tooltip: {
                        backgroundColor:'rgba(33,33,33,1)',
                        cornerRadius:0,
                        footerFontFamily:"'Nunito Sans'"
                    }
                    
                }
            });
        };

        // Data Table Rejection Shift 1
        $('#rejection-shift1 tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" style="color: black;">' );
        } );
        
        var tbl_rejection_s1 = $('#rejection-shift1').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            initComplete: function () {
                // Apply the search
                this.api().columns().every( function () {
                    var that = this;
     
                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    } );
                } );
            }
        } );

        // Data Table Downtime Shift 1
        $('#downtime-shift1 tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" style="color: black;">' );
        } );
        
        var tbl_downtime_s1 = $('#downtime-shift1').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            initComplete: function () {
                // Apply the search
                this.api().columns().every( function () {
                    var that = this;
     
                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    } );
                } );
            }
        } );
        
        // Data Table Rejection Shift 3
        $('#rejection-shift3 tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" style="color: black;">' );
        } );
        
        var tbl_rejection_s3 = $('#rejection-shift3').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            initComplete: function () {
                // Apply the search
                this.api().columns().every( function () {
                    var that = this;
     
                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    } );
                } );
            }
        } );
        
        // Data Table Downtime Shift 3
        $('#downtime-shift3 tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" style="color: black;">' );
        } );
        
        var tbl_downtime_s3 = $('#downtime-shift3').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            initComplete: function () {
                // Apply the search
                this.api().columns().every( function () {
                    var that = this;
     
                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    } );
                } );
            }
        } );
    }

    // Olah Data
    $("#btn-daily-report").on("click", function () {
        var daily_report_date = document.getElementById("daily-report-date").value;

        // Data Angka Shift 1
        if (true) {
            var total_dnt_s1 = document.getElementById("total-dnt-s1");
            var total_ng_s1 = document.getElementById("total-ng-s1");
            var availability_s1 = 1;
            var performance_s1 = 1;
            var quality_s1 = 1;
            var oee_s1 = 1;
    
            $.ajax({
                type: "POST",
                url : "http://10.14.134.44/admin/database/index_ajax.php",
                data: "read=Data-angka-s1&daily-report-date="+daily_report_date,
                success: function (data) {
                    total_dnt_s1.innerHTML = data.total_dnt_s1 + "'";
                    total_ng_s1.innerHTML = data.part_NG_s1;
        
                    // Progress Bar 1
                    availability_s1 = data.availability_s1;
                    document.getElementById("lbl-availability-s1").innerHTML = availability_s1;
                    document.getElementById("chart-availability-s1").style.width = availability_s1 + "%";
                    if (availability_s1 > 80) {
                        document.getElementById("chart-availability-s1").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-success";
                    } else if (availability_s1 > 60) {
                        document.getElementById("chart-availability-s1").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-warning";
                    } else if (availability_s1 < 60) {
                        document.getElementById("chart-availability-s1").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-danger";
                    }
        
                    // Progress Bar 2
                    performance_s1 = data.performance_s1;
                    document.getElementById("lbl-performance-s1").innerHTML = performance_s1;
                    document.getElementById("chart-performance-s1").style.width = performance_s1 + "%";
                    if (performance_s1 > 80) {
                        document.getElementById("chart-performance-s1").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-success";
                    } else if (performance_s1 > 60) {
                        document.getElementById("chart-performance-s1").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-warning";
                    } else if (performance_s1 < 60) {
                        document.getElementById("chart-performance-s1").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-danger";
                    }
        
                    // Progress Bar 3
                    quality_s1 = data.quality_s1;
                    document.getElementById("lbl-quality-s1").innerHTML = quality_s1;
                    document.getElementById("chart-quality-s1").style.width = quality_s1 + "%";
                    if (quality_s1 > 80) {
                        document.getElementById("chart-quality-s1").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-success";
                    } else if (quality_s1 > 60) {
                        document.getElementById("chart-quality-s1").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-warning";
                    } else if (quality_s1 < 60) {
                        document.getElementById("chart-quality-s1").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-danger";
                    }
                    
                    oee_s1 = data.oee_s1;
                    chart.updateSeries([oee_s1]);
                },
            });
        }

        // Pie Chart Downtime Shift 1
        if(true){
            var color = {};
            var length_data, key_data;
    
            $.ajax({
                type : "POST",
                url : "http://10.14.134.44/admin/database/index_ajax.php",
                data : "read=Downtime-s1&daily-report-date="+daily_report_date,
                success : function(data) {
                    length_data = Object.keys(data).length;
                    key_data = Object.keys(data);
    
                    for(var f = 0;f < length_data;f++){
                        color[key_data[f]] = background_color[key_data[f]];
                    }
    
                    Update_Pie_Chart(pieChart, Object.keys(data), Object.values(color), Object.values(data),  length_data);
    
                    function Update_Pie_Chart(chart, label, color, data, cycle) {
                        if(cycle > 0){
                            for(var f = 0; f < cycle; f++){
                                chart.data.datasets.pop();
                                chart.data.labels.pop();
                            }
    
                            chart.data.datasets.push({
                                backgroundColor: color,
                                data: data
                            });
                            for(var f = 0; f < label.length; f++){
                                chart.data.labels.push(label[f]);
                            }
                            
                            chart.update();
                        }else{
                            chart.data.datasets.pop();
                            chart.update();
                        }
                        
                    }
                }
            });
        }

        // Pie Chart NG Part Shift 1
        if(true){
            var color2 = {};
            var length_data2, key_data2;
    
            $.ajax({
                type : "POST",
                url : "http://10.14.134.44/admin/database/index_ajax.php",
                data : "read=NG-part-s1&daily-report-date="+daily_report_date,
                success : function(data) {
                    length_data2 = Object.keys(data).length;
                    key_data2 = Object.keys(data);
    
                    for(var f = 0;f < length_data2;f++){
                        color2[key_data2[f]] = background_color2[key_data2[f]];
                    }
    
                    Update_Pie_Chart2(pieChart2, Object.keys(data), Object.values(color2), Object.values(data),  length_data2);
    
                    function Update_Pie_Chart2(chart, label, color, data, cycle) {
                        if(cycle > 0){
                            for(var f = 0; f < cycle; f++){
                                chart.data.datasets.pop();
                                chart.data.labels.pop();
                            }
    
                            chart.data.datasets.push({
                                backgroundColor: color,
                                data: data
                            });
                            for(var f = 0; f < label.length; f++){
                                chart.data.labels.push(label[f]);
                            }
                            
                            chart.update();
                        }else{
                            chart.data.datasets.pop();
                            chart.update();
                        }
                        
                    }
                }
            });
        }

        // Data Hourly Achivement Shift 1
        if(true){
            $.ajax({
                type : "POST",
                url : "http://10.14.134.44/admin/database/index_ajax.php",
                data : "read=Data-hourly-s1&daily-report-date="+daily_report_date,
                success : function(data) {
                    var update_datasets3_1 = [data.RH_qty[0], data.RH_qty[1], data.RH_qty[2], data.RH_qty[3], data.RH_qty[4], data.RH_qty[5], data.RH_qty[6], data.RH_qty[7], data.RH_qty[8], data.RH_qty[9], data.RH_qty[10], data.RH_qty[11]];
                    var update_datasets3_2 = [data.LH_qty[0], data.LH_qty[1], data.LH_qty[2], data.LH_qty[3], data.LH_qty[4], data.LH_qty[5], data.LH_qty[6], data.LH_qty[7], data.LH_qty[8], data.LH_qty[9], data.LH_qty[10], data.LH_qty[11]];
                    Update_Bar_Chart(hBar3, label3_1, label3_2, background_color3_1, background_color3_2, border_color3_1, border_color3_2, update_datasets3_1, update_datasets3_2);
                    
                    function Update_Bar_Chart(chart, label3_1, label3_2, background_color3_1, background_color3_2, border_color3_1, border_color3_2, update_datasets3_1, update_datasets3_2) {
                        chart.data.datasets.pop();
                        chart.data.datasets.pop();
                        chart.data.datasets.push(
                            {
                                label: label3_1,
                                backgroundColor: background_color3_1,
                                borderColor: border_color3_1,
                                data: update_datasets3_1
                            },
                            {
                                label: label3_2,
                                backgroundColor: background_color3_2,
                                borderColor: border_color3_2,
                                data: update_datasets3_2
                            }
                        );
                        chart.update();
                    }
                }
            });
        }

        // NG Part Description Shift 1
        if(true){
            $.ajax({
                type : "POST",
                url : "http://10.14.134.44/admin/database/index_ajax.php",
                data : "read=NG-desc-s1&daily-report-date="+daily_report_date,
                success : function(data) {
                    tbl_rejection_s1.clear().draw();
                    for(var i = 0; i < data[0].length; i++){
                        tbl_rejection_s1.row.add( [ 
                            i + 1,
                            data[0][i],
                            data[1][i],
                            data[2][i],
                            data[3][i]
                        ] ).draw( false );
                    }
                }
            });
        }

        // Downtime Description Shift 1
        if(true){
            $.ajax({
                type : "POST",
                url : "http://10.14.134.44/admin/database/index_ajax.php",
                data : "read=Dnt-desc-s1&daily-report-date="+daily_report_date,
                success : function(data) {
                    tbl_downtime_s1.clear().draw();
                    for(var i = 0; i < data[0].length; i++){
                        tbl_downtime_s1.row.add( [ 
                            i + 1,
                            data[0][i],
                            data[1][i],
                            data[2][i],
                            data[3][i],
                            data[4][i],
                            data[5][i],
                            data[6][i]
                        ] ).draw( false );
                    }
                }
            });
        }

        // Data Angka Shift 3
        if (true) {
            var total_dnt_s3 = document.getElementById("total-dnt-s3");
            var total_ng_s3 = document.getElementById("total-ng-s3");
            var availability_s3 = 1;
            var performance_s3 = 1;
            var quality_s3 = 1;
            var oee_s3 = 1;
    
            $.ajax({
                type: "POST",
                url : "http://10.14.134.44/admin/database/index_ajax.php",
                data: "read=Data-angka-s3&daily-report-date="+daily_report_date,
                success: function (data) {
                    total_dnt_s3.innerHTML = data.total_dnt_s3 + "'";
                    total_ng_s3.innerHTML = data.part_NG_s3;
        
                    // Progress Bar 1
                    availability_s3 = data.availability_s3;
                    document.getElementById("lbl-availability-s3").innerHTML = availability_s3;
                    document.getElementById("chart-availability-s3").style.width = availability_s3 + "%";
                    if (availability_s3 > 80) {
                        document.getElementById("chart-availability-s3").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-success";
                    } else if (availability_s3 > 60) {
                        document.getElementById("chart-availability-s3").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-warning";
                    } else if (availability_s3 < 60) {
                        document.getElementById("chart-availability-s3").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-danger";
                    }
        
                    // Progress Bar 2
                    performance_s3 = data.performance_s3;
                    document.getElementById("lbl-performance-s3").innerHTML = performance_s3;
                    document.getElementById("chart-performance-s3").style.width = performance_s3 + "%";
                    if (performance_s3 > 80) {
                        document.getElementById("chart-performance-s3").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-success";
                    } else if (performance_s3 > 60) {
                        document.getElementById("chart-performance-s3").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-warning";
                    } else if (performance_s3 < 60) {
                        document.getElementById("chart-performance-s3").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-danger";
                    }
        
                    // Progress Bar 3
                    quality_s3 = data.quality_s3;
                    document.getElementById("lbl-quality-s3").innerHTML = quality_s3;
                    document.getElementById("chart-quality-s3").style.width = quality_s3 + "%";
                    if (quality_s3 > 80) {
                        document.getElementById("chart-quality-s3").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-success";
                    } else if (quality_s3 > 60) {
                        document.getElementById("chart-quality-s3").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-warning";
                    } else if (quality_s3 < 60) {
                        document.getElementById("chart-quality-s3").className =
                        "progress-bar progress-bar-striped progress-bar-animated bg-danger";
                    }
                    
                    oee_s3 = data.oee_s3;
                    chart.updateSeries([oee_s3]);
                },
            });
        }

        // Pie Chart Downtime Shift 3
        if(true){
            var color = {};
            var length_data, key_data;
    
            $.ajax({
                type : "POST",
                url : "http://10.14.134.44/admin/database/index_ajax.php",
                data : "read=Downtime-s3&daily-report-date="+daily_report_date,
                success : function(data) {
                    length_data = Object.keys(data).length;
                    key_data = Object.keys(data);
    
                    for(var f = 0;f < length_data;f++){
                        color[key_data[f]] = background_color[key_data[f]];
                    }
    
                    Update_Pie_Chart3(pieChart4, Object.keys(data), Object.values(color), Object.values(data),  length_data);
    
                    function Update_Pie_Chart3(chart, label, color, data, cycle) {
                        if(cycle > 0){
                            for(var f = 0; f < cycle; f++){
                                chart.data.datasets.pop();
                                chart.data.labels.pop();
                            }
    
                            chart.data.datasets.push({
                                backgroundColor: color,
                                data: data
                            });
                            for(var f = 0; f < label.length; f++){
                                chart.data.labels.push(label[f]);
                            }
                            
                            chart.update();
                        }else{
                            chart.data.datasets.pop();
                            chart.update();
                        }
                        
                    }
                }
            });
        }

        // Pie Chart NG Part Shift 3
        if(true){
            var color2 = {};
            var length_data2, key_data2;
    
            $.ajax({
                type : "POST",
                url : "http://10.14.134.44/admin/database/index_ajax.php",
                data : "read=NG-part-s3&daily-report-date="+daily_report_date,
                success : function(data) {
                    length_data2 = Object.keys(data).length;
                    key_data2 = Object.keys(data);
    
                    for(var f = 0;f < length_data2;f++){
                        color2[key_data2[f]] = background_color2[key_data2[f]];
                    }
    
                    Update_Pie_Chart4(pieChart5, Object.keys(data), Object.values(color2), Object.values(data),  length_data2);
    
                    function Update_Pie_Chart4(chart, label, color, data, cycle) {
                        if(cycle > 0){
                            for(var f = 0; f < cycle; f++){
                                chart.data.datasets.pop();
                                chart.data.labels.pop();
                            }
    
                            chart.data.datasets.push({
                                backgroundColor: color,
                                data: data
                            });
                            for(var f = 0; f < label.length; f++){
                                chart.data.labels.push(label[f]);
                            }
                            
                            chart.update();
                        }else{
                            chart.data.datasets.pop();
                            chart.update();
                        }
                        
                    }
                }
            });
        }

        // Data Hourly Achivement Shift 3
        if(true){
            $.ajax({
                type : "POST",
                url : "http://10.14.134.44/admin/database/index_ajax.php",
                data : "read=Data-hourly-s3&daily-report-date="+daily_report_date,
                success : function(data) {
                    var update_datasets3_1 = [data.RH_qty[0], data.RH_qty[1], data.RH_qty[2], data.RH_qty[3], data.RH_qty[4], data.RH_qty[5], data.RH_qty[6], data.RH_qty[7], data.RH_qty[8], data.RH_qty[9], data.RH_qty[10], data.RH_qty[11]];
                    var update_datasets3_2 = [data.LH_qty[0], data.LH_qty[1], data.LH_qty[2], data.LH_qty[3], data.LH_qty[4], data.LH_qty[5], data.LH_qty[6], data.LH_qty[7], data.LH_qty[8], data.LH_qty[9], data.LH_qty[10], data.LH_qty[11]];
                    Update_Bar_Chart2(hBar6, label3_1, label3_2, background_color3_1, background_color3_2, border_color3_1, border_color3_2, update_datasets3_1, update_datasets3_2);
                    
                    function Update_Bar_Chart2(chart, label3_1, label3_2, background_color3_1, background_color3_2, border_color3_1, border_color3_2, update_datasets3_1, update_datasets3_2) {
                        chart.data.datasets.pop();
                        chart.data.datasets.pop();
                        chart.data.datasets.push(
                            {
                                label: label3_1,
                                backgroundColor: background_color3_1,
                                borderColor: border_color3_1,
                                data: update_datasets3_1
                            },
                            {
                                label: label3_2,
                                backgroundColor: background_color3_2,
                                borderColor: border_color3_2,
                                data: update_datasets3_2
                            }
                        );
                        chart.update();
                    }
                }
            });
        }

        // NG Part Description Shift 3
        if(true){
            $.ajax({
                type : "POST",
                url : "http://10.14.134.44/admin/database/index_ajax.php",
                data : "read=NG-desc-s3&daily-report-date="+daily_report_date,
                success : function(data) {
                    tbl_rejection_s3.clear().draw();
                    for(var i = 0; i < data[0].length; i++){
                        tbl_rejection_s3.row.add( [ 
                            i + 1,
                            data[0][i],
                            data[1][i],
                            data[2][i],
                            data[3][i]
                        ] ).draw( false );
                    }
                }
            });
        }

        // Downtime Description Shift 3
        if(true){
            $.ajax({
                type : "POST",
                url : "http://10.14.134.44/admin/database/index_ajax.php",
                data : "read=Dnt-desc-s3&daily-report-date="+daily_report_date,
                success : function(data) {
                    tbl_downtime_s3.clear().draw();
                    for(var i = 0; i < data[0].length; i++){
                        tbl_downtime_s3.row.add( [ 
                            i + 1,
                            data[0][i],
                            data[1][i],
                            data[2][i],
                            data[3][i],
                            data[4][i],
                            data[5][i],
                            data[6][i]
                        ] ).draw( false );
                    }
                }
            });
        }
    });
});