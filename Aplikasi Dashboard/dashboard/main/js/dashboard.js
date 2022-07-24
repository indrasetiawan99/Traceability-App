$(document).ready(function () {
  // OEE Chart
  if (true) {
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
            background: "#e9ecef",
            startAngle: -135,
            endAngle: 135,
          },
          dataLabels: {
            name: {
              show: false,
            },
            value: {
              fontSize: "40px",
              fontWeight: "bold",
              // color: '#F2F4FF',
              show: true,
            },
          },
        },
      },
      fill: {
        colors: [
          function ({ value }) {
            if (value < 55) {
              return "#dc3545";
            } else if (value >= 55 && value < 80) {
              return "#ffc107";
            } else {
              return "#28a745";
            }
          },
        ],
      },
      stroke: {
        lineCap: "butt",
      },
      labels: ["Progress"],
    };

    var chart = new ApexCharts(document.querySelector("#oee-chart"), options1);
    chart.render();
    chart.updateSeries([1]);
  }

  // Progress Bar
  if (true) {
    // Progress Bar 1
    var val_bar_1 = 0;
    document.getElementById("lbl-availability").innerHTML = val_bar_1;
    document.getElementById("chart-availability").style.width = val_bar_1 + "%";
    if (val_bar_1 > 80) {
      document.getElementById("chart-availability").className =
        "progress-bar progress-bar-striped progress-bar-animated bg-success";
    } else if (val_bar_1 > 60) {
      document.getElementById("chart-availability").className =
        "progress-bar progress-bar-striped progress-bar-animated bg-warning";
    } else if (val_bar_1 < 60) {
      document.getElementById("chart-availability").className =
        "progress-bar progress-bar-striped progress-bar-animated bg-danger";
    }

    // Progress Bar 2
    var val_bar_2 = 0;
    document.getElementById("lbl-performance").innerHTML = val_bar_2;
    document.getElementById("chart-performance").style.width = val_bar_2 + "%";
    if (val_bar_2 > 80) {
      document.getElementById("chart-performance").className =
        "progress-bar progress-bar-striped progress-bar-animated bg-success";
    } else if (val_bar_2 > 60) {
      document.getElementById("chart-performance").className =
        "progress-bar progress-bar-striped progress-bar-animated bg-warning";
    } else if (val_bar_2 < 60) {
      document.getElementById("chart-performance").className =
        "progress-bar progress-bar-striped progress-bar-animated bg-danger";
    }

    // Progress Bar 3
    var val_bar_3 = 0;
    document.getElementById("lbl-quality").innerHTML = val_bar_3;
    document.getElementById("chart-quality").style.width = val_bar_3 + "%";
    if (val_bar_3 > 80) {
      document.getElementById("chart-quality").className =
        "progress-bar progress-bar-striped progress-bar-animated bg-success";
    } else if (val_bar_3 > 60) {
      document.getElementById("chart-quality").className =
        "progress-bar progress-bar-striped progress-bar-animated bg-warning";
    } else if (val_bar_3 < 60) {
      document.getElementById("chart-quality").className =
        "progress-bar progress-bar-striped progress-bar-animated bg-danger";
    }
  }

  // Olah Data
  if (true) {
    var part_name_LH = document.getElementById("part-name-LH");
    var target_LH = document.getElementById("target-LH");
    var cum_target_LH = document.getElementById("cum-target-LH");
    var part_OK_LH = document.getElementById("part-OK-LH");
    var part_NG_LH = document.getElementById("part-NG-LH");
    var part_name_RH = document.getElementById("part-name-RH");
    var target_RH = document.getElementById("target-RH");
    var cum_target_RH = document.getElementById("cum-target-RH");
    var part_OK_RH = document.getElementById("part-OK-RH");
    var part_NG_RH = document.getElementById("part-NG-RH");
    var operator_name_npk = document.getElementById("operator-name-npk");
    var planning_start = document.getElementById("planning-start");
    var planning_finish = document.getElementById("planning-finish");
    var cust_name = document.getElementById("cust-name");
    var machine_status = document.getElementById("machine-status");
    var total_line_stop = document.getElementById("total-line-stop");
    var shift_now = "";
    var colorr = '#dc3545';

    setInterval(function () {
      var dt_now = new Date();
      var shift1_from = new Date();
      shift1_from.setHours(06, 00, 00);
      var shift1_to = new Date();
      shift1_to.setHours(17, 59, 59);
      var shift3_from = new Date();
      shift3_from.setHours(18, 00, 00);
      var shift3_to = new Date();
      shift3_to.setHours(05, 59, 59);
      if (dt_now >= shift1_from && dt_now <= shift1_to) {
        shift_now = "Shift 1";
      } else if (dt_now >= shift3_from || dt_now <= shift3_to) {
        shift_now = "Shift 3";
      }

      $.ajax({
        type: "POST",
        url: "http://10.14.134.44/dashboard/database/dashboard_ajax.php",
        data: "read=Data1&shift=" + shift_now,
        success: function (data) {
          part_name_LH.innerHTML = data.part_name_LH;
          target_LH.innerHTML = data.target_LH;
          cum_target_LH.innerHTML = data.cum_target_LH;
          part_OK_LH.innerHTML = data.part_OK_LH;
          part_NG_LH.innerHTML = data.part_NG_LH;
          part_name_RH.innerHTML = data.part_name_RH;
          target_RH.innerHTML = data.target_RH;
          cum_target_RH.innerHTML = data.cum_target_RH;
          part_OK_RH.innerHTML = data.part_OK_RH;
          part_NG_RH.innerHTML = data.part_NG_RH;
          operator_name_npk.innerHTML = data.operator_name_npk;
          planning_start.innerHTML = data.planning_start;
          planning_finish.innerHTML = data.planning_finish;
          cust_name.innerHTML = data.cust_name;
          machine_status.innerHTML = data.machine_status;
          total_line_stop.innerHTML = data.total_line_stop + "'";

          // Progress Bar 1
          val_bar_1 = data.availability;
          document.getElementById("lbl-availability").innerHTML = val_bar_1;
          document.getElementById("chart-availability").style.width =
            val_bar_1 + "%";
          if (val_bar_1 > 80) {
            document.getElementById("chart-availability").className =
              "progress-bar progress-bar-striped progress-bar-animated bg-success";
          } else if (val_bar_1 > 60) {
            document.getElementById("chart-availability").className =
              "progress-bar progress-bar-striped progress-bar-animated bg-warning";
          } else if (val_bar_1 < 60) {
            document.getElementById("chart-availability").className =
              "progress-bar progress-bar-striped progress-bar-animated bg-danger";
          }

          // Progress Bar 2
          val_bar_2 = data.performance;
          document.getElementById("lbl-performance").innerHTML = val_bar_2;
          document.getElementById("chart-performance").style.width =
            val_bar_2 + "%";
          if (val_bar_2 > 80) {
            document.getElementById("chart-performance").className =
              "progress-bar progress-bar-striped progress-bar-animated bg-success";
          } else if (val_bar_2 > 60) {
            document.getElementById("chart-performance").className =
              "progress-bar progress-bar-striped progress-bar-animated bg-warning";
          } else if (val_bar_2 < 60) {
            document.getElementById("chart-performance").className =
              "progress-bar progress-bar-striped progress-bar-animated bg-danger";
          }

          // Progress Bar 3
          val_bar_3 = data.quality;
          document.getElementById("lbl-quality").innerHTML = val_bar_3;
          document.getElementById("chart-quality").style.width =
            val_bar_3 + "%";
          if (val_bar_3 > 80) {
            document.getElementById("chart-quality").className =
              "progress-bar progress-bar-striped progress-bar-animated bg-success";
          } else if (val_bar_3 > 60) {
            document.getElementById("chart-quality").className =
              "progress-bar progress-bar-striped progress-bar-animated bg-warning";
          } else if (val_bar_3 < 60) {
            document.getElementById("chart-quality").className =
              "progress-bar progress-bar-striped progress-bar-animated bg-danger";
          }

          chart.updateSeries([data.oee]);

          if(data.downtime == 'Yes'){
            if(colorr == '#dc3545'){
              colorr = '#93acb5';
            } else {
              // colorr = '#f2f4ff';
              colorr = '#dc3545';
            }
            document.getElementById("title-line-stop").style.color = colorr;
          } else {
            var colorrr = '#f2f4ff';
            document.getElementById("title-line-stop").style.color = colorrr;
          }
        },
      });
    }, 1000); // update about every second
  }

  // Pie Chart Line Stop
  if ($("#line-stop").length > 0) {
    var background_color = {
      Mold: "#7FFFD4",
      Mesin: "#F5F5DC",
      Box: "#FFE4C4",
      Kereta: "#8A2BE2",
      Komponen: "#A52A2A",
      "STD Kualitas": "#DEB887",
      Material: "#5F9EA0",
      Pemanasan: "#D2691E",
      Robot: "#6495ED",
      "Trial Robot": "#DC143C",
      "Kuras Barel": "#00008B",
      "Man Power": "#008B8B",
      SR: "#B8860B",
      Brifing: "#A9A9A9",
      "Setting Mesin": "#BDB76B",
      Dandory: "#CD5C5C",
      "Kuras Manifold": "#483D8B",
      "Cleaning Mold": "#2F4F4F",
      "Setting Awal": "#FFA07A",
      "Lain-lain": "#DAA520",
    };

    var ctx1 = document.getElementById("line-stop").getContext("2d");
    var data1 = {
      labels: [],
      datasets: [
        {
          data: [],
          backgroundColor: [],
          hoverBackgroundColor: [],
        },
      ],
    };

    var pieChart = new Chart(ctx1, {
      type: "pie",
      data: data1,
      options: {
        animation: {
          duration: 10,
        },
        responsive: true,
        legend: {
          labels: {
            fontFamily: "Nunito Sans",
            fontColor: "#F2F4FF",
          },
          position: "right",
        },
        tooltip: {
          backgroundColor: "rgba(33,33,33,1)",
          cornerRadius: 0,
          footerFontFamily: "'Nunito Sans'",
        },
        elements: {
          arc: {
            borderWidth: 1,
          },
        },
      },
    });

    var color = {};
    var length_data, key_data;
    setInterval(function () {
      var dt_now = new Date();
      var shift1_from = new Date();
      shift1_from.setHours(06, 00, 00);
      var shift1_to = new Date();
      shift1_to.setHours(17, 59, 59);
      var shift3_from = new Date();
      shift3_from.setHours(18, 00, 00);
      var shift3_to = new Date();
      shift3_to.setHours(05, 59, 59);
      if (dt_now >= shift1_from && dt_now <= shift1_to) {
        shift_now = "Shift 1";
      } else if (dt_now >= shift3_from || dt_now <= shift3_to) {
        shift_now = "Shift 3";
      }

      $.ajax({
        type: "POST",
        url: "http://10.14.134.44/dashboard/database/dashboard_ajax.php",
        data: "read=Data2&shift=" + shift_now,
        success: function (data) {
          length_data = Object.keys(data).length;
          key_data = Object.keys(data);

          for (var f = 0; f < length_data; f++) {
            color[key_data[f]] = background_color[key_data[f]];
          }

          // Makasimal 14 Karakter
          Update_Pie_Chart(
            pieChart,
            Object.keys(data),
            Object.values(color),
            Object.values(data),
            length_data
          );

          function Update_Pie_Chart(chart, label, color, data, cycle) {
            if (cycle > 0) {
              for (var f = 0; f < cycle; f++) {
                // chart.data.labels.splice(1, 1);
                chart.data.datasets.pop();
                chart.data.labels.pop();
              }

              chart.data.datasets.push({
                backgroundColor: color,
                data: data,
              });
              for (var f = 0; f < label.length; f++) {
                chart.data.labels.push(label[f]);
              }

              chart.update();
            } else {
              chart.data.datasets.pop();
              chart.update();
            }
          }
        },
      });
    }, 2000);
  }

  // Read Time Now
  if (true) {
    var days = [
      "Minggu",
      "Senin",
      "Selasa",
      "Rabu",
      "Kamis",
      "Jum'at",
      "Sabtu",
    ];
    var months = [
      "Januari",
      "Februari",
      "Maret",
      "April",
      "Mei",
      "Juni",
      "Juli",
      "Agustus",
      "September",
      "Oktober",
      "November",
      "Desember",
    ];
    var hours_now = document.getElementById("hours-now");
    var date_now = document.getElementById("date-now");
    var minutes_now = document.getElementById("minutes-now");
    var day_name = document.getElementById("day-name");

    setInterval(function () {
      var t = new Date();
      date_now.innerHTML =
        ("0" + t.getDate()).slice(-2) +
        " " +
        months[t.getMonth()] +
        " " +
        t.getFullYear();
      hours_now.innerHTML = ("0" + t.getHours()).slice(-2);
      minutes_now.innerHTML = ("0" + t.getMinutes()).slice(-2);
      day_name.innerHTML = days[t.getDay()];
    }, 1000); // update about every second
  }

});
