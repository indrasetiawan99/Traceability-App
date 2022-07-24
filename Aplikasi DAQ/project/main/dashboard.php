<?php
$baseURL = 'http://10.14.134.44/project/';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JQuery -->
    <script src="<?= $baseURL . 'assets/vendor_component/jquery/jquery-3.5.1.js' ?>" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= $baseURL . 'assets/vendor_component/bootstrap-4.6.0-dist/css/bootstrap.min.css' ?>" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Bootstrap JS -->
    <script src="<?= $baseURL . 'assets/vendor_component/bootstrap-4.6.0-dist/js/bootstrap.bundle.min.js' ?>"></script>

    <!-- JS Charting -->
    <script type="text/javascript" src="<?= $baseURL . 'assets/vendor_component/jscharting/js/jscharting.js' ?>"></script>
    <script type="text/javascript" src="<?= $baseURL . 'assets/vendor_component/jscharting/js/modules/types.js' ?>"></script>

    <!-- My CSS -->

    <title>Traceability QR-code</title>
</head>

<body>
    <!-- Content -->
    <div class="container">
        <div class="col">
            <div class="row">
                <div id="chartDiv" style="max-width: 450px;height: 200px;margin: 0px auto">
                </div>
            </div>
        </div>
    </div>

    <script>
        var chart = JSC.chart('chartDiv', {
            debug: true,
            type: 'gauge',
            animation_duration: 1000,
            legend_visible: false,
            xAxis: {
                spacingPercentage: 0.25
            },
            yAxis: {
                defaultTick: {
                    padding: -5,
                    label_style_fontSize: '14px'
                },
                line: {
                    width: 9,
                    color: 'smartPalette',
                    breaks_gap: 0.06
                },
                scale_range: [0, 100]
            },
            palette: {
                pointValue: '{%value/100}',
                colors: ['red', 'yellow', 'green']
            },
            defaultAnnotation: {
                position: 'inside bottom'
            },
            annotations: [{
                    id: 'anVal',
                    label: {
                        text: '0',
                        style: {
                            fontSize: 46
                        }
                    }
                },
                {
                    label: {
                        text: 'kW',
                        style: {
                            fontSize: 25,
                            color: '#696969'
                        }
                    }
                }
            ],
            defaultTooltip_enabled: false,
            defaultSeries: {
                angle: {
                    sweep: 180
                },
                shape: {
                    innerSize: '70%'
                }
            },
            series: [{
                type: 'column roundcaps',
                points: [{
                    id: '1',
                    x: 'speed',
                    y: 0
                }]
            }]
        });
        var INTERVAL_ID;

        playPause();

        function setGauge(max, y) {
            chart
                .series(0)
                .options({
                    points: [{
                        id: '1',
                        x: 'speed',
                        y: y
                    }]
                });
            chart
                .annotations('anVal')
                .options({
                    label_text: JSC.formatNumber(y, 'n1')
                }, {
                    animation: false
                });
        }

        function playPause(val) {
            if (val) {
                clearInterval(INTERVAL_ID);
            } else {
                update();
            }
        }

        function update() {
            INTERVAL_ID = setInterval(function() {
                $.ajax({
                    url: "http://10.14.134.44/project/database/web/jschart.php",
                    type: "GET",
                    success: function(data) {
                        setGauge(100, data.nilai * 100);
                        // setGauge(100, Math.random() * 100);
                    },
                });
            }, 1000);
        }
    </script>
    <!-- The Javascript -->
</body>

</html>