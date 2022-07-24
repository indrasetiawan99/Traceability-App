$(document).ready(function () {
  setInterval(function () {
    $.ajax({
      url:
        "http://10.14.134.44/project/database/web/print.php?action=read",
      type: "GET",
      success: function (data) {
        if (data[0].status == "active") {
          var code = data[0].code;
          var partName = data[0].partName;
          var pnApi = data[0].pnApi;
          var pnCust = data[0].pnCust;
          var pack = data[0].pack;
          var dateTime = data[0].dateTime;
          var name_ = data[0].name;
          var name = name_.substring(0, 21);
          var shift = data[0].shift;
          var machine = "ASSY";
          var uniqNum = data[0].uniqNum;
          var job_no = data[0].job_no;
          var address = data[0].address;
          var pos_part = data[0].pos_part;
          var date = dateTime.substring(0, 11);

          console.log(code);

          function delay(delayInms) {
            return new Promise((resolve) => {
              setTimeout(() => {
                resolve(2);
              }, delayInms);
            });
          }

          async function print() {
            await delay(200);
            var printWindow = window.open("", "", "width=1, height=1");

            printWindow.document.open();

            content =
            `
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="layout_datapart.css">
                <title>Document</title>
            </head>

            <body>
                <table class="font fs75 center">
                    <tr>
                        <th class="col1" colspan="10">Data Part - PT. Autoplastik Indonesia</th>
                        <th class="col2" rowspan="9">Date Print : ` + dateTime + `</th>
                    </tr>
                    <tr>
                        <td class="col3">FG</td>
                        <td class="col4" colspan="7" style="vertical-align: middle;"><img src="../upload/barcode/item-` + code + `.jpg" height="40"></td>
                        <td class="col4b">` + pos_part + `</td>
                        <td class="col5" rowspan="4" style="vertical-align: middle;"><img src="../upload/qrcode/item-` + code + `.png"></td>
                    </tr>
                    <tr>
                        <td class="col6" colspan="4" style="font-weight: bold;">` + pnCust + `</td>
                        <td class="col7" colspan="5" style="font-weight: bold;">` + pnApi + `</td>
                    </tr>
                    <tr>
                        <td class="col8" colspan="9" style="font-weight: bold;">` + partName + `</td>
                    </tr>
                    <tr>
                        <td class="col9 left" colspan="2">PROSES</td>
                        <td class="col10" colspan="2">PRODUKSI</td>
                        <td class="col10b" colspan="2">QC</td>
                        <td class="col11">KET.</td>
                        <td class="col12" colspan="2">Address</td>
                    </tr>
                    <tr>
                        <td class="left" colspan="2">MESIN/LINE</td>
                        <td colspan="2">ASSY</td>
                        <td rowspan="4" colspan="2"></td>
                        <td rowspan="2" style="border-bottom: none; vertical-align: middle; text-align: center; font-size: 16px; font-weight: bold;">`+ job_no +`</td>
                        <td rowspan="2" colspan="2" style="border-bottom: none; vertical-align: middle; text-align: center; font-size: 16px; font-weight: bold;">`+ address +`</td>
                        <td class="col13" rowspan="4" style="text-align: center;"><span style="font-size: 25px; font-weight: bold;">`+ pack +`</span><br><br><span>PCS</span></td>
                    </tr>
                    <tr>
                        <td class="left" colspan="2">TGL PRODUKSI</td>
                        <td colspan="2">` + date + `</td>
                    </tr>
                    <tr>
                        <td class="left" colspan="2">SHIFT</td>
                        <td colspan="2">` + shift + `</td>
                        <td style="border-top: none; vertical-align: middle; text-align: left;">R</td>
                        <td colspan="2" style="border-top: none;"></td>
                    </tr>
                    <tr>
                        <td class="left" colspan="2">OPERATOR</td>
                        <td colspan="2">` + name + `</td>
                        <td class="left">` + uniqNum + `</td>
                        <td colspan="2"></td>
                    </tr>
                </table>
            </body>

            </html>
            `

            printWindow.document.write(content);

            printWindow.document.close();

            await delay(300);
            printWindow.print();
            await delay(300);
            $.ajax({
              url:
                "http://10.14.134.44/project/database/web/print.php?action=delete",
              type: "GET",
            });

            setTimeout(function () {
              printWindow.close();
            }, 1000);
          }
          print();
        }
      },
    });
  }, 2000);
});
