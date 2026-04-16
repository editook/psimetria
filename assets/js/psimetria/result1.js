const name_user = "<?php echo $register['id_client'] ?>";

const testname = "<?php echo $register['type_question_name'] ?>";
const filenamepdf = (name_user + "_" + testname).replace(/\s+/g, '');
var jsonpdf = [];
jsonpdf.push({
    type: 2,
    image: "contenido1"
});
jsonpdf.push({
    type: 2,
    image: "contenido2"
});
jsonpdf.push({
    type: 4,
    text: getvalue('jsonvalue1')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 7,
    text: getvalue('jsonvalue2')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue3')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 7,
    text: getvalue('jsonvalue4')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue5')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue5_1')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 7,
    text: getvalue('jsonvalue6')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue7')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue7_1')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue7_2')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue7_3')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 7,
    text: getvalue('jsonvalue8')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue9')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue9_1')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 7,
    text: getvalue('jsonvalue12')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue13')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue13_1')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue13_2')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue13_3')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue13_4')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 7,
    text: getvalue('jsonvalue14')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: getvalue('jsonvalue15')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 7,
    text: getvalue('jsonvalue16')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 8,
    text: getvalue('jsonvalue17')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 7,
    text: getvalue('jsonvalue18')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 8,
    text: getvalue('jsonvalue19')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 7,
    text: getvalue('jsonvalue20')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 8,
    text: getvalue('jsonvalue21')
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 5,
    text: ''
});
jsonpdf.push({
    type: 8,
    text: getvalue('jsonvalue21_1')
});

$(function() {
    'use strict';
    var colorLine = "black";
    var newCust = [
        [<?= $mins["$Pmin"] ?>, 10],
        [<?= $mags["$Pmag"] ?>, 0]
    ];

    var plot = $.plot($('#flotLine2'), [{
        data: newCust,
        label: 'Data',
        color: colorLine
    }], {
        series: {
            lines: {
                show: true,
                lineWidth: 2
            },
            shadowSize: 0
        },
        points: {
            show: true,
            radius: 3,
            fill: true,
            fillColor: colorLine,
            lineWidth: 2.5
        },
        legend: {
            noColumns: 1,
            position: 'ne',
            show: false
        },
        grid: {
            borderWidth: 1,
            borderColor: 'transparent',
            hoverable: true,
            show: true
        },
        yaxis: {
            min: -5,
            max: 15,
            color: 'transparent',
            ticks: [
                [0, ''],
                [15, '']
            ],
            tickColor: 'transparent',
            tickLength: 0,
            show: false,
            font: {
                size: 10,
                color: '#999'
            }
        },
        xaxis: {
            color: '#eee',
            min: 0,
            max: 99,
            tickColor: 'black',
            ticks: [
                [1, '1'],
                [3, '3'],
                [16, '16'],
                [50, '50'],
                [84, '84'],
                [96, '97'],
                [99, '99'],
            ],
            tickLength: 0,
            font: {
                size: 10,
                color: 'black'
            },
            position: 'top'
        }
    });

    var flotLineIndGeneral = [
        [<?= $globals["$Pind_global_sev"] ?>, 20],
        [<?= $nums["$Pnum_sintomas"] ?>, 10],
        [<?= $ints["$Pind_intesidad_sintomas"] ?>, 0]
    ];

    var plot = $.plot($('#flotLineIndGeneral'), [{
        data: flotLineIndGeneral,
        label: 'Data',
        color: colorLine
    }], {
        series: {
            lines: {
                show: true,
                lineWidth: 2
            },
            shadowSize: 0
        },
        points: {
            show: true,
            radius: 3,
            fill: true,
            fillColor: colorLine,
            lineWidth: 2.5
        },
        legend: {
            noColumns: 1,
            position: 'ne',
            show: false
        },
        grid: {
            borderWidth: 1,
            borderColor: 'transparent',
            hoverable: true,
            show: true
        },
        yaxis: {
            min: -5,
            max: 25,
            color: '#eee',
            tickColor: 'transparent',
            font: {
                size: 10,
                color: 'transparent'
            }
        },
        xaxis: {
            color: '#eee',
            min: 0,
            max: 99,
            tickColor: 'transparent',
            font: {
                size: 10,
                color: 'transparent'
            },
            position: 'top',
            show: false
        }
    });
    var flotLineEscalasClinicas = [
        [<?= $prs["$Ppsicoreactividad"] ?>, 80],
        [<?= $hps["$Phipersenc"] ?>, 70],
        [<?= $obs["$Pobs_comp"] ?>, 60],
        [<?= $ans["$Panciedad"] ?>, 50],
        [<?= $hss["$Phostilidad"] ?>, 40],
        [<?= $sms["$Psomatizacion"] ?>, 30],
        [<?= $des["$Pdepresion"] ?>, 20],
        [<?= $sus["$Palsuenio"] ?>, 10],
        [<?= $suas["$Palsuenio_ampl"] ?>, 0]
    ];

    var plot = $.plot($('#flotLineEscalasClinicas'), [{
        data: flotLineEscalasClinicas,
        label: 'Data',
        color: colorLine
    }], {
        series: {
            lines: {
                show: true,
                lineWidth: 2
            },
            shadowSize: 0
        },
        points: {
            show: true,
            radius: 3,
            fill: true,
            fillColor: colorLine,
            lineWidth: 2.5
        },
        legend: {
            noColumns: 1,
            position: 'ne',
            show: false
        },
        grid: {
            borderWidth: 1,
            borderColor: 'transparent',
            hoverable: true,
            show: true
        },
        yaxis: {
            min: -5,
            max: 85,
            color: '#737f9e',
            ticks: [
                [0, ''],
                [85, '']
            ],
            tickColor: 'rgba(171, 167, 167, 0)',
            font: {
                size: 10,
                color: '#999'
            },
            show: false
        },
        xaxis: {
            color: '#eee',
            min: 0,
            max: 99,
            tickColor: 'rgba(171, 167, 167, 0)',
            font: {
                size: 10,
                color: '#999'
            },
            position: 'top',
            show: false
        }
    });

    var flotLineIndRiesgoPat = [
        [<?= $irpsis["$Pirp"] ?>, 6]
    ];

    var plot = $.plot($('#flotLineIndRiesgoPat'), [{
        data: flotLineIndRiesgoPat,
        label: 'Data',
        color: colorLine
    }], {
        series: {
            lines: {
                show: true,
                lineWidth: 2
            },
            shadowSize: 0
        },
        points: {
            show: true,
            radius: 3,
            fill: true,
            fillColor: colorLine,
            lineWidth: 2.5
        },
        legend: {
            noColumns: 1,
            position: 'ne',
            show: false
        },
        grid: {
            borderWidth: 1,
            borderColor: 'transparent',
            hoverable: true,
            show: true,
            tickColor: 'rgba(171, 167, 167, 0)'
        },
        yaxis: {
            min: 0,
            max: 12,
            color: '#eee',
            ticks: [
                [0, ''],
                [12, '']
            ],
            tickColor: 'rgba(171, 167, 167,0.2)',
            font: {
                size: 10,
                color: '#999'
            }
        },
        xaxis: {
            color: '#eee',
            min: 0,
            max: 99,
            tickColor: 'black',
            ticks: [
                [1, '1'],
                [3, '3'],
                [16, '16'],
                [50, '50'],
                [84, '84'],
                [96, '97'],
                [99, '99'],
            ],
            tickLength: 0,
            font: {
                size: 10,
                color: 'black'
            },
            position: 'bottom'
        }
    });

    var plot = $.plot($('#flotLineEscalasClinicas'), [{
        data: flotLineEscalasClinicas,
        label: 'Data',
        color: colorLine
    }], {
        series: {
            lines: {
                show: true,
                lineWidth: 2
            },
            shadowSize: 0
        },
        points: {
            show: true,
            radius: 3,
            fill: true,
            fillColor: colorLine,
            lineWidth: 2.5
        },
        legend: {
            noColumns: 1,
            position: 'ne',
            show: false
        },
        grid: {
            borderWidth: 1,
            borderColor: 'transparent',
            hoverable: true,
            show: true
        },
        yaxis: {
            min: -5,
            max: 85,
            color: 'black',
            ticks: [
                [0, ''],
                [85, '']
            ],
            tickColor: 'black',
            font: {
                size: 10,
                color: 'black'
            },
            show: false
        },
        xaxis: {
            color: '#eee',
            min: 0,
            max: 99,
            tickColor: 'black',
            font: {
                size: 10,
                color: 'black'
            },
            position: 'top',
            show: false
        }
    });

    var colores = $.plot($('#colorss'), [{
        data: [],
        label: 'Data',
        color: colorLine
    }], {
        series: {
            lines: {
                show: true,
                lineWidth: 2
            },
            shadowSize: 0
        },
        points: {
            show: true,
            radius: 3,
            fill: true,
            fillColor: colorLine,
            lineWidth: 2.5
        },
        legend: {
            noColumns: 1,
            position: 'ne',
            show: false
        },
        grid: {
            borderWidth: 1,
            borderColor: 'transparent',
            hoverable: true,
            show: true,
            tickColor: 'rgba(171, 167, 167, 0)',
            markings: [{
                    xaxis: {
                        from: 0,
                        to: 3
                    },
                    color: '#c6d5ec'
                },
                {
                    xaxis: {
                        from: 3,
                        to: 16
                    },
                    color: '#95b4dd'
                },
                {
                    xaxis: {
                        from: 16,
                        to: 85
                    },
                    color: '#40ab96'
                },
                {
                    xaxis: {
                        from: 84,
                        to: 97
                    },
                    color: '#fee1bb'
                },
                {
                    xaxis: {
                        from: 97,
                        to: 99
                    },
                    color: '#fef0db'
                },
                { // Línea punteada en X = 50
                    xaxis: {
                        from: 50,
                        to: 50
                    },
                    color: '#000', // color de la línea
                    lineWidth: 0.5
                },
                { // Línea horizontal en y = 6
                    yaxis: {
                        from: 10.0,
                        to: 10.0
                    },
                    color: 'white',
                    lineWidth: 1
                },
                { // Línea horizontal en y = 6
                    yaxis: {
                        from: 7.4,
                        to: 7.4
                    },
                    color: 'white',
                    lineWidth: 1
                },
                { // Línea horizontal en y = 6
                    yaxis: {
                        from: 0.86,
                        to: 0.86
                    },
                    color: 'white',
                    lineWidth: 1
                }
            ]
        },
        yaxis: {
            min: 0,
            max: 12,
            color: '#eee',
            ticks: [
                [0, ''],
                [12, '']
            ],
            tickColor: 'transparent',
            font: {
                size: 10,
                color: 'transparent'
            },
            show: false
        },
        xaxis: {
            color: '#eee',
            min: 0,
            show: false,
            max: 99,
            tickColor: 'transparent',
            font: {
                size: 10,
                color: '#999'
            }
        }
    });

    var colores = $.plot($('#colorss2'), [{
        data: [],
        label: 'Data',
        color: colorLine
    }], {
        series: {
            lines: {
                show: true,
                lineWidth: 2
            },
            shadowSize: 0
        },
        points: {
            show: true,
            radius: 3,
            fill: true,
            fillColor: colorLine,
            lineWidth: 2.5
        },
        legend: {
            noColumns: 1,
            position: 'ne',
            show: false
        },
        grid: {
            borderWidth: 1,
            borderColor: 'transparent',
            hoverable: true,
            show: true,
            tickColor: 'rgba(171, 167, 167, 0)',
            markings: [{
                    xaxis: {
                        from: 84,
                        to: 94
                    },
                    color: 'rgba(13, 165, 140, 0.44)'
                },
                {
                    xaxis: {
                        from: 0,
                        to: 50
                    },
                    color: '#40ab96'
                }
            ]
        },
        yaxis: {
            min: 0,
            max: 12,
            color: '#eee',
            ticks: [
                [0, ''],
                [12, '']
            ],
            tickColor: 'transparent',
            font: {
                size: 10,
                color: 'transparent'
            },
            show: false
        },
        xaxis: {
            color: '#eee',
            min: 0,
            show: false,
            max: 99,
            tickColor: 'transparent',
            font: {
                size: 10,
                color: '#999'
            }
        }
    });

    function labelFormatter(label, series) {
        return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
    }
});
setTimeout(function() {
    document.getElementById('colorss').style.position = 'absolute';
}, 1000);
setTimeout(function() {
    document.getElementById('colorss2').style.position = 'absolute';
}, 1000);
document.getElementById('baremo_id').addEventListener('change', function() {
    document.getElementById('form_baremo').submit();
});