<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="layout_datapart_wip.css">
    <title>Layout Datapart WIP</title>
</head>

<body>
    <!-- <table class="font fs75 center">
        <tr>
            <td class="w150">
                <h1>SUB ASSY BASE STAY RHD RH 34232-S1600</h1>
                <h1>(WIP)</h1>
            </td>
        </tr>
    </table> -->
    <script>
        var part_name = 'SUB ASSY BASE STAY RHD RH 34232-S1600';

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
            <link rel="stylesheet" href="layout_datapart_wip.css">
            <title>Document</title>
        </head>

        <body>
            <table class="font fs75 center">
                <tr>
                    <td class="w150">
                        <h1>` + part_name + `</h1>
                        <h1>(WIP)</h1>
                    </td>
                </tr>
            </table>
        </body>

        </html>
        `

            printWindow.document.write(content);

            printWindow.document.close();

            await delay(300);
            // printWindow.print();
            await delay(300);

            setTimeout(function() {
                // printWindow.close();
            }, 1000);
        }
        print();
    </script>
</body>

</html>