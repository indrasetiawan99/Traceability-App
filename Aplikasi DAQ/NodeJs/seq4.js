const mysql = require("mysql");
const QRCode = require("qrcode");
const bwipjs = require("bwip-js");
const fs = require("fs");

var con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "traceability_qrcode",
});

con.connect(function (err) {
  if (err) throw err;
  console.log("Connected!");
});

// Import dependencies
const SerialPort = require("serialport");
const Readline = require("@serialport/parser-readline");

var connectScanner = function () {
  // Defining the serial port
  const port = new SerialPort("COM5", {
    baudRate: 9600,
    dataBits: 8,
    parity: "none",
    stopBits: 1,
  });

  //Readline
  const parser = port.pipe(new Readline({ delimiter: "\r" }));

  parser.on("data", function (data) {
    // var data = '210500043_30-001-110 SC_API_10_M079_200521_07.23.54';  //for trial
    console.log("");
    console.log("Data is: ", data);

    // require variable
    var seq4_status = "OK";
    var status = "complete";
    var qrcode = data;

    // datetime variable
    var d = new Date();
    var months = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    var year = String(d.getFullYear()).substring(2, 4);
    var month = ("0" + (d.getMonth() + 1)).slice(-2);
    var datetime =
      ("0" + d.getDate()).slice(-2) +
      " " +
      months[d.getMonth()].substring(0, 3) +
      " " +
      d.getFullYear() +
      "-" +
      ("0" + d.getHours()).slice(-2) +
      ":" +
      ("0" + d.getMinutes()).slice(-2) +
      ":" +
      ("0" + d.getSeconds()).slice(-2);
    var datetime2 =
      ("0" + d.getDate()).slice(-2) +
      ("0" + (d.getMonth() + 1)).slice(-2) +
      d.getFullYear() +
      ("0" + d.getHours()).slice(-2) +
      ("0" + d.getMinutes()).slice(-2) +
      ("0" + d.getSeconds()).slice(-2);
    var datetime3 =
      ("0" + d.getDate()).slice(-2) +
      ("0" + (d.getMonth() + 1)).slice(-2) +
      String(d.getFullYear()).substring(2, 4) +
      "_" +
      ("0" + d.getHours()).slice(-2) +
      "." +
      ("0" + d.getMinutes()).slice(-2) +
      "." +
      ("0" + d.getSeconds()).slice(-2);
    var date =
      d.getFullYear() +
      ("0" + (d.getMonth() + 1)).slice(-2) +
      ("0" + d.getDate()).slice(-2);
    var date2 =
      d.getFullYear() +
      "-" +
      ("0" + (d.getMonth() + 1)).slice(-2) +
      "-" +
      ("0" + d.getDate()).slice(-2);
    var time =
      ("0" + d.getHours()).slice(-2) +
      ":" +
      ("0" + d.getMinutes()).slice(-2) +
      ":" +
      ("0" + d.getSeconds()).slice(-2);

    sql = "SELECT * FROM scanner_mode";
    con.query(sql, function (err, result) {
      if (err) throw err;
      if (result[0].mode == "Normal") {
        mode_normal();
      } else if (result[0].mode == "Manual_Print_Datapart") {
        mode_manual_print_datapart();
      } else if (result[0].mode == "Step1_Repair_Qrcode") {
        mode_step1_repair_qrcode();
      } else if (result[0].mode == "Step2_Repair_Qrcode") {
        mode_step2_repair_qrcode();
      }
    });

    function mode_step1_repair_qrcode() {
      sql = "SELECT * FROM part_production WHERE datapart = '" + data + "'";
      con.query(sql, function (err, result) {
        if (err) throw err;
        var arr_qrcode = [];

        if (result.length > 0) {
          console.log("");
          console.log("Step 1 Repair Qr-code Begin!");
          console.log("Input Datapart...");
          for (var i = 0; i < result.length; i++) {
            arr_qrcode.push(result[i].qrcode);
          }
          console.log(
            "Datapart ini memiliki " + arr_qrcode.length + " buah QR-code"
          );
          step1(result[0].datapart, arr_qrcode);
        } else {
          console.log("This is not a product!");
          console.log("");
        }
      });

      function step1(datapart, arr_qrcode) {
        sql = "DELETE FROM repair_qrcode";
        con.query(sql, function (err) {
          if (err) throw err;
        });

        for (var i = 0; i < arr_qrcode.length; i++) {
          sql =
            "INSERT INTO repair_qrcode(datapart, qrcode) VALUES ('" +
            datapart +
            "', '" +
            arr_qrcode[i] +
            "')";
          con.query(sql, function (err) {
            if (err) throw err;
          });
        }
        console.log(
          "Datapart dan Qr-code sudah di input ke tabel repair_qrcode"
        );
        console.log("Step 1 Repair Qr-code Complete");
        console.log("");
      }
    }

    function mode_step2_repair_qrcode() {
      sql = "SELECT * FROM repair_qrcode WHERE qrcode = '" + data + "'";
      con.query(sql, function (err, result) {
        if (err) throw err;

        if (result.length > 0) {
          console.log("");
          console.log("Step 2 Repair Qr-code Begin!");
          console.log("Input Qr-code...");
          sql =
            "UPDATE repair_qrcode SET cek_qrcode = '" +
            data +
            "' WHERE qrcode = '" +
            data +
            "'";
          con.query(sql, function (err) {
            if (err) throw err;

            console.log("Data Qr-code sudah di input ke tabel repair_qrcode");
            console.log("Step 2 Repair Qr-code Complete");
            console.log("");
          });
        } else {
          console.log("This is not a product!");
          console.log("");
        }
      });
    }

    function mode_manual_print_datapart() {
      sql = "SELECT * FROM part_production WHERE qrcode = '" + qrcode + "'";
      con.query(sql, function (err, result) {
        if (err) throw err;

        if (result.length > 0) {
          console.log("");
          console.log("Manual Print Datapart Begin!");
          step1(result[0].datapart);
        } else {
          console.log("This is not a product!");
          console.log("");
        }
      });

      function step1(datapart) {
        sql = "SELECT * FROM datapart WHERE code = '" + datapart + "'";
        con.query(sql, function (err, result) {
          if (err) throw err;

          if (result.length > 0) {
            step2(
              result[0].code,
              result[0].uniq_number,
              result[0].packaging,
              result[0].op_name,
              result[0].nik,
              result[0].part_name,
              result[0].pn_api,
              result[0].pn_cust,
              date,
              time,
              datetime,
              datetime2,
              result[0].job_no,
              result[0].sku_maris,
              result[0].address
            );
          }
        });
      }

      function step2(
        code,
        uniqNum,
        packaging,
        full_name,
        nik,
        part_name,
        pn_api,
        pn_cust,
        date,
        time,
        datetime,
        datetime2,
        job_no,
        sku_maris,
        address
      ) {
        QRCode.toFile(
          "C:/xampp/htdocs/project/upload/qrcode/item-" + code + ".png",
          code,
          {
            width: 123,
            margin: 1,
            scale: 10,
          },
          function (err) {
            if (err) throw err;
            console.log("Generate QRcode is done!");
          }
        );

        bwipjs.toBuffer(
          {
            bcid: "code128", // Barcode type
            text: code, // Text to encode
            scale: 10, // 3x scaling factor
            height: 10, // Bar height, in millimeters
            textxalign: "center", // Always good to set this
          },
          function (err, dataImage) {
            if (err) {
              console.log(err);
            } else {
              fs.writeFile(
                "C:/xampp/htdocs/project/upload/barcode/item-" + code + ".jpg",
                dataImage,
                function (err) {}
              );
              console.log("Generate Barcode is done!");
              console.log("Manual Print Datapart Complete");
              console.log("");
            }
          }
        );

        sql =
          "INSERT INTO temp_datapart(code, uniq_number, op_name, nik, part_name, pn_api, pn_cust, job_no, address, sku_maris, packaging, date, time, date_time, date_time2) VALUES ('" +
          code +
          "','" +
          uniqNum +
          "','" +
          full_name +
          "', '" +
          nik +
          "', '" +
          part_name +
          "', '" +
          pn_api +
          "', '" +
          pn_cust +
          "', '" +
          job_no +
          "', '" +
          address +
          "', '" +
          sku_maris +
          "', '" +
          packaging +
          "', '" +
          date +
          "', '" +
          time +
          "', '" +
          datetime +
          "', '" +
          datetime2 +
          "')";
        con.query(sql, function (err) {
          if (err) throw err;
        });
      }
    }

    function mode_normal() {
      sql = "SELECT * FROM part_production WHERE qrcode = '" + qrcode + "'";
      con.query(sql, function (err, result) {
        if (err) throw err;
        if (result.length > 0) {
          if (result[0].position == "Right") {
            step_RH();
          } else if (result[0].position == "Left") {
            step_LH();
          }
        } else {
          console.log("This is not a product!");
          console.log("");
        }
      });
    }

    function step_RH() {
      sql =
        "SELECT * FROM temp_production WHERE seq_status = 'Active' AND position = 'Right' ORDER BY id ASC LIMIT 1";
      con.query(sql, function (err, result) {
        if (err) throw err;
        console.log("");
        console.log("Step RH begin!");
        step1(result[0].nik, result[0].part_name, result[0].packaging);
      });

      function step1(nik, part_name, packaging) {
        sql = "SELECT * FROM master_user WHERE nik = '" + nik + "'";
        con.query(sql, function (err, result) {
          if (err) throw err;
          var full_name = result[0].full_name;

          sql = "DELETE FROM temp_datapart";
          con.query(sql, function (err, result) {
            if (err) throw err;
          });

          console.log("Step 1 Complete!");

          step2(full_name, part_name, nik, packaging);
        });
      }

      function step2(full_name, part_name, nik, packaging) {
        sql =
          "SELECT * FROM part_production WHERE seq1_status = 'OK' AND seq2_status = 'OK' AND seq3_status= 'OK' AND seq4_status IS NULL AND part_name = '" +
          part_name +
          "' AND op_name = '" +
          full_name +
          "' AND position = 'Right' AND qrcode = '" +
          data +
          "' AND hasil_scanning IS NULL AND status IS NULL ORDER BY id ASC LIMIT 1";
        con.query(sql, function (err, result) {
          if (err) throw err;
          console.log("Load Sequence 4 = " + result.length);

          console.log("Step 2 Complete!");
          step3(result.length, full_name, part_name, nik, packaging);
        });
      }

      function step3(loadSeq4, full_name, part_name, nik, packaging) {
        if (loadSeq4 > 0) {
          sql =
            "UPDATE part_production SET seq4_status = '" +
            seq4_status +
            "', hasil_scanning = '" +
            data +
            "', status = 'waiting' WHERE seq1_status = 'OK' AND seq2_status = 'OK' AND seq3_status= 'OK' AND seq4_status IS NULL AND part_name = '" +
            part_name +
            "' AND op_name = '" +
            full_name +
            "' AND position = 'Right' AND qrcode = '" +
            data +
            "' AND hasil_scanning IS NULL AND status IS NULL ORDER BY id ASC LIMIT 1";
          con.query(sql, function (err, result) {
            if (err) throw err;

            sql = "UPDATE temp_counting_seq4 SET counting_R = counting_R + 1";
            con.query(sql, function (err, result) {
              if (err) throw err;
              console.log("Step 3 Complete!");
              step4(packaging, nik, part_name);
            });
          });
        } else {
          console.log("Data ini sudah diinput atau tidak terdaftar");
          console.log("");
        }
      }

      function step4(packaging, nik, part_name) {
        sql = "SELECT * FROM master_user WHERE nik = '" + nik + "'";
        con.query(sql, function (err, result) {
          if (err) throw err;

          var full_name = result[0].full_name;
          sql =
            "SELECT * FROM master_product WHERE part_name = '" +
            part_name +
            "'";
          con.query(sql, function (err, result) {
            if (err) throw err;
            console.log("Step 4 Complete!");
            step5(
              packaging,
              full_name,
              nik,
              part_name,
              result[0].pn_api,
              result[0].pn_cust,
              packaging,
              date,
              time,
              datetime,
              datetime2,
              result[0].job_no,
              result[0].sku_maris,
              result[0].address
            );
          });
        });
      }

      function step5(
        packaging,
        full_name,
        nik,
        part_name,
        pn_api,
        pn_cust,
        packaging,
        date,
        time,
        datetime,
        datetime2,
        job_no,
        sku_maris,
        address
      ) {
        sql = "SELECT * FROM temp_counting_seq4";
        con.query(sql, function (err, result) {
          if (err) throw err;
          console.log("Counting R saat ini = " + result[0].counting_R);

          if (result[0].counting_R == packaging) {
            sql = "SELECT * FROM uniq_code";
            con.query(sql, function (err, result) {
              if (err) throw err;

              var date_uniqcode = new Date(result[0].date);
              var date_now = new Date(date2);
              var year_month_last =
                date_uniqcode.getFullYear() +
                "-" +
                ("0" + (date_uniqcode.getMonth() + 1)).slice(-2);
              var year_month_now =
                date_now.getFullYear() +
                "-" +
                ("0" + (date_now.getMonth() + 1)).slice(-2);

              if (year_month_last < year_month_now || result[0].cycle < 1) {
                console.log(
                  "Uniqcode date lessthan date now or cycle lessthan one"
                );
                sql =
                  "UPDATE uniq_code SET cycle = 1, date = '" + date_now + "'";
                con.query(sql, function (err) {
                  if (err) throw err;
                });
              }

              sql = "SELECT * FROM uniq_code";
              con.query(sql, function (err, result) {
                if (err) throw err;
                var cycle = result[0].cycle;

                sql = "UPDATE uniq_code SET cycle = cycle + 1";
                con.query(sql, function (err) {
                  if (err) throw err;
                });

                var id = ("000" + cycle).slice(-4);
                var uniqNum = year + month + id;
                var code =
                  uniqNum +
                  "_" +
                  pn_cust +
                  "_" +
                  "API" +
                  "_" +
                  packaging +
                  "_" +
                  sku_maris +
                  "_" +
                  nik +
                  "_" +
                  datetime3;

                QRCode.toFile(
                  "C:/xampp/htdocs/project/upload/qrcode/item-" + code + ".png",
                  code,
                  {
                    width: 123,
                    margin: 1,
                    scale: 10,
                  },
                  function (err) {
                    if (err) throw err;
                    console.log("Generate QRcode is done!");
                  }
                );

                bwipjs.toBuffer(
                  {
                    bcid: "code128", // Barcode type
                    text: code, // Text to encode
                    scale: 10, // 3x scaling factor
                    height: 10, // Bar height, in millimeters
                    textxalign: "center", // Always good to set this
                  },
                  function (err, dataImage) {
                    if (err) {
                      console.log(err);
                    } else {
                      fs.writeFile(
                        "C:/xampp/htdocs/project/upload/barcode/item-" +
                          code +
                          ".jpg",
                        dataImage,
                        function (err) {}
                      );
                      console.log("Generate Barcode is done!");
                      console.log("Step 5 Complete!");
                      console.log("");
                    }
                  }
                );

                sql =
                  "INSERT INTO datapart(code, uniq_number, op_name, nik, part_name, pn_api, pn_cust, job_no, address, sku_maris, packaging, date, time, date_time, date_time2) VALUES ('" +
                  code +
                  "','" +
                  uniqNum +
                  "','" +
                  full_name +
                  "', '" +
                  nik +
                  "', '" +
                  part_name +
                  "', '" +
                  pn_api +
                  "', '" +
                  pn_cust +
                  "', '" +
                  job_no +
                  "', '" +
                  address +
                  "', '" +
                  sku_maris +
                  "', '" +
                  packaging +
                  "', '" +
                  date +
                  "', '" +
                  time +
                  "', '" +
                  datetime +
                  "', '" +
                  datetime2 +
                  "')";
                con.query(sql, function (err) {
                  if (err) throw err;
                });

                sql =
                  "INSERT INTO temp_datapart(code, uniq_number, op_name, nik, part_name, pn_api, pn_cust, job_no, address, sku_maris, packaging, date, time, date_time, date_time2) VALUES ('" +
                  code +
                  "','" +
                  uniqNum +
                  "','" +
                  full_name +
                  "', '" +
                  nik +
                  "', '" +
                  part_name +
                  "', '" +
                  pn_api +
                  "', '" +
                  pn_cust +
                  "', '" +
                  job_no +
                  "', '" +
                  address +
                  "', '" +
                  sku_maris +
                  "', '" +
                  packaging +
                  "', '" +
                  date +
                  "', '" +
                  time +
                  "', '" +
                  datetime +
                  "', '" +
                  datetime2 +
                  "')";
                con.query(sql, function (err) {
                  if (err) throw err;
                });

                for (i = 0; i < packaging; i++) {
                  sql =
                    "UPDATE part_production SET datapart = '" +
                    code +
                    "', status = '" +
                    status +
                    "' WHERE datapart IS NULL AND position = 'Right' AND status = 'waiting' ORDER BY id ASC LIMIT 1";
                  con.query(sql, function (err) {
                    if (err) throw err;
                  });
                }

                sql = "UPDATE temp_counting_seq4 SET counting_R = 0";
                con.query(sql, function (err) {
                  if (err) throw err;
                });
              });
            });
          }
        });
      }
    }

    function step_LH() {
      sql =
        "SELECT * FROM temp_production WHERE seq_status = 'Active' AND position = 'Left' ORDER BY id ASC LIMIT 1";
      con.query(sql, function (err, result) {
        if (err) throw err;
        console.log("");
        console.log("Step LH begin!");
        step1(result[0].nik, result[0].part_name, result[0].packaging);
      });

      function step1(nik, part_name, packaging) {
        sql = "SELECT * FROM master_user WHERE nik = '" + nik + "'";
        con.query(sql, function (err, result) {
          if (err) throw err;
          var full_name = result[0].full_name;

          sql = "DELETE FROM temp_datapart";
          con.query(sql, function (err, result) {
            if (err) throw err;
          });

          console.log("Step 1 Complete!");

          step2(full_name, part_name, nik, packaging);
        });
      }

      function step2(full_name, part_name, nik, packaging) {
        sql =
          "SELECT * FROM part_production WHERE seq1_status = 'OK' AND seq2_status = 'OK' AND seq3_status= 'OK' AND seq4_status IS NULL AND part_name = '" +
          part_name +
          "' AND op_name = '" +
          full_name +
          "' AND position = 'Left' AND qrcode = '" +
          data +
          "' AND hasil_scanning IS NULL AND status IS NULL ORDER BY id ASC LIMIT 1";
        con.query(sql, function (err, result) {
          if (err) throw err;
          console.log("Load Sequence 4 = " + result.length);

          console.log("Step 2 Complete!");
          step3(result.length, full_name, part_name, nik, packaging);
        });
      }

      function step3(loadSeq4, full_name, part_name, nik, packaging) {
        if (loadSeq4 > 0) {
          sql =
            "UPDATE part_production SET seq4_status = '" +
            seq4_status +
            "', hasil_scanning = '" +
            data +
            "', status = 'waiting' WHERE seq1_status = 'OK' AND seq2_status = 'OK' AND seq3_status= 'OK' AND seq4_status IS NULL AND part_name = '" +
            part_name +
            "' AND op_name = '" +
            full_name +
            "' AND position = 'Left' AND qrcode = '" +
            data +
            "' AND hasil_scanning IS NULL AND status IS NULL ORDER BY id ASC LIMIT 1";
          con.query(sql, function (err, result) {
            if (err) throw err;

            sql = "UPDATE temp_counting_seq4 SET counting_L = counting_L + 1";
            con.query(sql, function (err, result) {
              if (err) throw err;
              console.log("Step 3 Complete!");
              step4(packaging, nik, part_name);
            });
          });
        } else {
          console.log("Data ini sudah diinput atau tidak terdaftar");
          console.log("");
        }
      }

      function step4(packaging, nik, part_name) {
        sql = "SELECT * FROM master_user WHERE nik = '" + nik + "'";
        con.query(sql, function (err, result) {
          if (err) throw err;

          var full_name = result[0].full_name;
          sql =
            "SELECT * FROM master_product WHERE part_name = '" +
            part_name +
            "'";
          con.query(sql, function (err, result) {
            if (err) throw err;
            console.log("Step 4 Complete!");
            step5(
              packaging,
              full_name,
              nik,
              part_name,
              result[0].pn_api,
              result[0].pn_cust,
              packaging,
              date,
              time,
              datetime,
              datetime2,
              result[0].job_no,
              result[0].sku_maris,
              result[0].address
            );
          });
        });
      }

      function step5(
        packaging,
        full_name,
        nik,
        part_name,
        pn_api,
        pn_cust,
        packaging,
        date,
        time,
        datetime,
        datetime2,
        job_no,
        sku_maris,
        address
      ) {
        sql = "SELECT * FROM temp_counting_seq4";
        con.query(sql, function (err, result) {
          if (err) throw err;
          console.log("Counting L saat ini = " + result[0].counting_L);

          if (result[0].counting_L == packaging) {
            sql = "SELECT * FROM uniq_code";
            con.query(sql, function (err, result) {
              if (err) throw err;

              var date_uniqcode = new Date(result[0].date);
              var date_now = new Date(date2);
              var year_month_last =
                date_uniqcode.getFullYear() +
                "-" +
                ("0" + (date_uniqcode.getMonth() + 1)).slice(-2);
              var year_month_now =
                date_now.getFullYear() +
                "-" +
                ("0" + (date_now.getMonth() + 1)).slice(-2);

              if (year_month_last < year_month_now || result[0].cycle < 1) {
                console.log(
                  "Uniqcode date lessthan date now or cycle lessthan one"
                );
                sql =
                  "UPDATE uniq_code SET cycle = 1, date = '" + date_now + "'";
                con.query(sql, function (err) {
                  if (err) throw err;
                });
              }

              sql = "SELECT * FROM uniq_code";
              con.query(sql, function (err, result) {
                if (err) throw err;
                var cycle = result[0].cycle;

                sql = "UPDATE uniq_code SET cycle = cycle + 1";
                con.query(sql, function (err) {
                  if (err) throw err;
                });

                var id = ("000" + cycle).slice(-4);
                var uniqNum = year + month + id;
                var code =
                  uniqNum +
                  "_" +
                  pn_cust +
                  "_" +
                  "API" +
                  "_" +
                  packaging +
                  "_" +
                  sku_maris +
                  "_" +
                  nik +
                  "_" +
                  datetime3;

                QRCode.toFile(
                  "C:/xampp/htdocs/project/upload/qrcode/item-" + code + ".png",
                  code,
                  {
                    width: 123,
                    margin: 1,
                    scale: 10,
                  },
                  function (err) {
                    if (err) throw err;
                    console.log("Generate QRcode is done!");
                  }
                );

                bwipjs.toBuffer(
                  {
                    bcid: "code128", // Barcode type
                    text: code, // Text to encode
                    scale: 10, // 3x scaling factor
                    height: 10, // Bar height, in millimeters
                    textxalign: "center", // Always good to set this
                  },
                  function (err, dataImage) {
                    if (err) {
                      console.log(err);
                    } else {
                      fs.writeFile(
                        "C:/xampp/htdocs/project/upload/barcode/item-" +
                          code +
                          ".jpg",
                        dataImage,
                        function (err) {}
                      );
                      console.log("Generate Barcode is done!");
                      console.log("Step 5 Complete!");
                      console.log("");
                    }
                  }
                );

                sql =
                  "INSERT INTO datapart(code, uniq_number, op_name, nik, part_name, pn_api, pn_cust, job_no, address, sku_maris, packaging, date, time, date_time, date_time2) VALUES ('" +
                  code +
                  "','" +
                  uniqNum +
                  "','" +
                  full_name +
                  "', '" +
                  nik +
                  "', '" +
                  part_name +
                  "', '" +
                  pn_api +
                  "', '" +
                  pn_cust +
                  "', '" +
                  job_no +
                  "', '" +
                  address +
                  "', '" +
                  sku_maris +
                  "', '" +
                  packaging +
                  "', '" +
                  date +
                  "', '" +
                  time +
                  "', '" +
                  datetime +
                  "', '" +
                  datetime2 +
                  "')";
                con.query(sql, function (err) {
                  if (err) throw err;
                });

                sql =
                  "INSERT INTO temp_datapart(code, uniq_number, op_name, nik, part_name, pn_api, pn_cust, job_no, address, sku_maris, packaging, date, time, date_time, date_time2) VALUES ('" +
                  code +
                  "','" +
                  uniqNum +
                  "','" +
                  full_name +
                  "', '" +
                  nik +
                  "', '" +
                  part_name +
                  "', '" +
                  pn_api +
                  "', '" +
                  pn_cust +
                  "', '" +
                  job_no +
                  "', '" +
                  address +
                  "', '" +
                  sku_maris +
                  "', '" +
                  packaging +
                  "', '" +
                  date +
                  "', '" +
                  time +
                  "', '" +
                  datetime +
                  "', '" +
                  datetime2 +
                  "')";
                con.query(sql, function (err) {
                  if (err) throw err;
                });

                for (i = 0; i < packaging; i++) {
                  sql =
                    "UPDATE part_production SET datapart = '" +
                    code +
                    "', status = '" +
                    status +
                    "' WHERE datapart IS NULL AND position = 'Left' AND status = 'waiting' ORDER BY id ASC LIMIT 1";
                  con.query(sql, function (err) {
                    if (err) throw err;
                  });
                }

                sql = "UPDATE temp_counting_seq4 SET counting_L = 0";
                con.query(sql, function (err) {
                  if (err) throw err;
                });
              });
            });
          }
        });
      }
    }
  });

  port.on("close", function () {
    console.log("SCANNER PORT CLOSED");
    reconnectScanner();
  });

  port.on("error", function (err) {
    console.error("error", err);
    reconnectScanner();
  });
};

connectScanner();

// check for connection errors or drops and reconnect
var reconnectScanner = function () {
  console.log("INITIATING RECONNECT");
  setTimeout(function () {
    console.log("RECONNECTING TO SCANNER");
    connectScanner();
  }, 2000);
};
