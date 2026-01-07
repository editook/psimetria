<?php
class ModelSCLBaremoPacientesDisfusion
{
    function getSOM(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [34,5],
            "0.08" => [37,10],
            "0.17" => [40,15],
            "0.25" => [42,20],
            "0.33" => [43,25],
            "0.42" => [45,30],
            "0.56" => [46,35],
            "0.67"  => [47,40],
            "0.80" => [49,45],
            "1.88"    => [50,50],
            "1.00" => [51,55],
            "1.12" => [53,60],
            "1.25" => [54,65],
            "1.33" => [55,70],
            "1.42" => [57,75],
            "1.52" => [58,80],
            "2.77" => [60,85],
            "2.08" => [63,90],
            "2.59" => [67,95],
            "3.25" => [70,97],
            "3.42"    => [75,99]
        ];


        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitter;
        }
        return $mags;
    }

    function getOBS(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00"  => [37,10],
            "0.10"  => [40,15],
            "0.30" => [42,20],
            "0.38"  => [43,25],
            "0.50"  => [45,30],
            "0.60"  => [46,35],
            "0.70"  => [47,40],
            "0.80"  => [50,50],
            "0.90"  => [51,55],
            "1.10"  => [53,60],
            "1.20"  => [54,65],
            "1.30" => [55,70],
            "1.43"  => [57,75],
            "1.60"  => [58,80],
            "1.70" => [60,85],
            "2.02"  => [63,90],
            "2.20" => [67,95],
            "2.72"  => [70,97],
            "3.10"    => [75,99]
        ];


        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitter;
        }
        return $mags;
    }
    function getINT(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [43,10],
            "0.11" => [43,20],
            "0.22" => [43,25],
            "0.33" => [45,30],
            "0.44" => [46,35],
            "0.56" => [47,40],
            "0.67" => [49,45],
            "0.78" => [50,50],
            "0.89"    => [51,55],
            "1.00" => [53,60],
            "1.04" => [54,65],
            "1.22" => [55,70],
            "1.37" => [57,75],
            "1.44" => [58,80],
            "1.56" => [60,85],
            "1.79" => [63,90],
            "2.11" => [67,95],
            "2.48" => [70,97],
            "3.35"    => [75,99]
        ];


        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitter;
        }
        return $mags;
    }
    function getDEP(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [34,5],
            "0.08" => [40,15],
            "0.23" => [42,20],
            "0.31" => [43,25],
            "0.52" => [45,30],
            "0.62" => [46,35],
            "0.69" => [47,40],
            "0.85" => [49,45],
            "0.92" => [50,50],
            "1.04" => [51,55],
            "1.15" => [53,60],
            "1.23" => [54,65],
            "1.38" => [55,70],
            "1.62" => [57,75],
            "1.85" => [58,80],
            "1.92" => [60,85],
            "2.09" => [63,90],
            "2.31" => [67,95],
            "2.62" => [70,97],
            "2.92"    => [75,99]
        ];


        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitter;
        }
        return $mags;
    }
    function getANS(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00"  => [43,10],
            "0.10"  => [43,15],
            "0.20" => [43,20],
            "0.28"  => [43,25],
            "0.40"  => [45,30],
            "0.50"  => [47,40],
            "0.60"  => [50,50],
            "0.70"  => [51,55],
            "0.90" => [53,60],
            "0.92"    => [34,60],
            "1.00"  => [40,65],
            "1.10" => [40,70],
            "1.23"  => [42,75],
            "1.30" => [42,80],
            "1.31"  => [43,80],
            "1.50" => [43,85],
            "1.52"  => [45,85],
            "1.60" => [45,90],
            "1.62" => [46,90],
            "1.69" => [47,90],
            "1.85" => [49,90],
            "1.91" => [49,95],
            "1.92" => [50,95],
            "2.04" => [51,95],
            "2.15" => [53,95],
            "2.23" => [54,95],
            "2.38"  => [55,95],
            "2.50" => [55,97],
            "2.62" => [57,97],
            "2.64" => [57,99],
            "2.85" => [58,99],
            "2.92" => [60,99],
            "3.09" => [63,99],
            "3.31" => [67,99],
            "3.62" => [70,99],
            "3.92"    => [75,99],
        ];



        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitter;
        }
        return $mags;
    }
    function getHOS(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [40,15],
            "0.14" => [42,20],
            "0.17" => [45,30],
            "0.33"  => [49,45],
            "0.50" => [51,55],
            "0.67" => [53,60],
            "0.83" => [54,65],
            "0.89"    => [55,70],
            "1.00" => [57,75],
            "1.17"  => [58,80],
            "1.50" => [60,85],
            "1.67" => [63,90],
            "2.33" => [67,95],
            "2.34" => [70,97],
            "2.68"    => [75,99],
        ];

        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitter;
        }
        return $mags;
    }
    function getFOB(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [47,40],
            "0.14" => [49,45],
            "0.29" => [53,60],
            "0.43" => [57,75],
            "0.71" => [58,80],
            "0.86"    => [60,85],
            "1.00"  => [63,90],
            "1.30" => [67,95],
            "2.57" => [70,97],
            "2.87"    => [75,99],
        ];

        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitter;
        }
        return $mags;
    }
    function getPAR(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [40,15],
            "0.17" => [45,30],
            "0.33" => [46,35],
            "0.44"  => [47,40],
            "0.50" => [49,45],
            "0.67" => [51,55],
            "0.83" => [54,65],
            "1.17" => [57,75],
            "1.33"  => [58,80],
            "1.50" => [60,85],
            "1.69"    => [63,90],
            "2.00" => [67,95],
            "2.34" => [70,97],
            "3.01"    => [75,99],
        ];

        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitter;
        }
        return $mags;
    }
    function getPSI(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00"  => [42,20],
            "0.10"  => [46,35],
            "0.20"  => [49,45],
            "0.30"  => [51,55],
            "0.40"  => [54,65],
            "0.50"  => [55,70],
            "0.70" => [57,75],
            "0.73" => [58,80],
            "0.92"    => [60,85],
            "1.00" => [63,90],
            "1.11" => [67,95],
            "1.91" => [70,97],
            "2.12"    => [75,99],
        ];

        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitter;
        }
        return $mags;
    }
    function getGSI(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [34,5],
            "0.11" => [37,10],
            "0.13" => [40,15],
            "0.25" => [42,20],
            "0.31" => [43,25],
            "0.48" => [45,30],
            "0.54" => [46,35],
            "0.67" => [47,40],
            "0.76" => [49,45],
            "0.79" => [50,50],
            "0.82" => [51,55],
            "0.89" => [53,60],
            "0.97" => [54,65],
            "1.03" => [55,70],
            "1.11" => [57,75],
            "1.34" => [58,80],
            "1.42" => [60,85],
            "1.56" => [63,90],
            "1.78" => [67,95],
            "2.19" => [70,97],
            "2.66"    => [75,99],
        ];

        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitter;
        }
        return $mags;
    }
    function getPST(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =90;
        $rangeStep = 1; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [37,10],
            "10.00" => [40,15],
            "14.00" => [42,20],
            "22.00" => [43,25],
            "28.00" => [45,30],
            "32.00" => [46,35],
            "35.00" => [47,40],
            "38.00" => [49,45],
            "40.00" => [50,50],
            "41.00" => [51,55],
            "44.00" => [53,60],
            "45.00" => [54,65],
            "49.00" => [55,70],
            "51.00" => [57,75],
            "55.00" => [58,80],
            "59.00" => [60,85],
            "63.00" => [63,90],
            "69.00" => [67,95],
            "73.00" => [70,97],
            "81.00" => [75,99]
        ];


        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = (int)$currentValue;
            $mags["$value"] = $eventEmitter;
            //echo $value.' '.json_encode($eventEmitter).'<br>';
        }
        return $mags;
    }
    function getPSDI(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [34,5],
            "1.00" => [37,10],
            "1.11" => [40,15],
            "1.24" => [42,20],
            "1.35" => [43,25],
            "1.40" => [45,30],
            "1.53" => [46,35],
            "1.61" => [47,40],
            "1.68" => [49,45],
            "1.74" => [50,50],
            "1.78" => [51,55],
            "1.86" => [53,60],
            "1.97" => [54,65],
            "2.02" => [55,70],
            "2.15" => [57,75],
            "2.33" => [58,80],
            "2.41" => [60,85],
            "2.59" => [63,90],
            "2.80" => [67,95],
            "3.05" => [70,97],
            "3.57" => [75,99]
        ];

        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitter;
        }
        return $mags;
    }
}
