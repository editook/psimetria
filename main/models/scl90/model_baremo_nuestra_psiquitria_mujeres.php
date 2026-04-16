<?php
class ModelSCLBaremoPsiquiatriaMujeres
{
    function getSOM(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [34,5],
            "0.25"  => [37,10],
            "0.50" => [40,15],
            "0.67" => [42,20],
            "1.03" => [43,25],
            "1.25" => [45,30],
            "1.33"  => [46,35],
            "1.50" => [47,40],
            "1.58" => [49,45],
            "1.75" => [50,50],
            "1.83"    => [51,55],
            "2.00"  => [53,60],
            "2.10" => [54,65],
            "2.25" => [55,70],
            "2.42" => [57,75],
            "2.58"  => [58,80],
            "2.80" => [60,85],
            "2.95" => [63,90],
            "3.19" => [67,95],
            "3.59" => [70,97],
            "3.82"    => [75,99]
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
            "0.00"  => [34,5],
            "0.30"  => [37,10],
            "0.50" => [40,15],
            "0.66" => [42,20],
            "0.94" => [43,25],
            "1.12" => [45,30],
            "1.21"  => [46,35],
            "1.40"  => [47,40],
            "1.50"  => [49,45],
            "1.60"  => [50,50],
            "1.70"  => [51,55],
            "1.90"  => [53,60],
            "2.10"  => [54,65],
            "2.30"  => [55,70],
            "2.40" => [57,75],
            "2.58"  => [58,80],
            "2.80" => [60,85],
            "2.99" => [63,90],
            "3.33"  => [67,95],
            "3.70"  => [70,97],
            "3.80"    => [75,99]
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
            "0.00" => [34,5],
            "0.21" => [37,10],
            "0.44" => [42,20],
            "0.71" => [43,25],
            "0.89"    => [45,30],
            "1.00" => [46,35],
            "1.11"  => [47,40],
            "1.20" => [49,45],
            "1.22" => [50,50],
            "1.33" => [51,55],
            "1.44" => [53,60],
            "1.58" => [54,65],
            "1.89"    => [55,70],
            "2.00" => [57,75],
            "2.11" => [58,80],
            "2.22" => [60,85],
            "2.61" => [63,90],
            "3.03" => [67,95],
            "3.37" => [70,97],
            "3.85"    => [75,99]
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
            "0.54" => [37,10],
            "0.69" => [40,15],
            "0.92" => [42,20],
            "1.11" => [43,25],
            "1.38" => [45,30],
            "1.54" => [46,35],
            "1.69" => [47,40],
            "1.92"  => [49,45],
            "2.10" => [50,50],
            "2.23" => [51,55],
            "2.31" => [53,60],
            "2.38" => [54,65],
            "2.54" => [55,70],
            "2.61" => [57,75],
            "2.69" => [58,80],
            "2.97" => [60,85],
            "3.16" => [63,90],
            "3.47" => [67,95],
            "3.77" => [70,97],
            "3.85"    => [75,99]
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
            "0.00"  => [34,5],
            "0.30"  => [37,10],
            "0.40" => [40,15],
            "0.66"  => [42,20],
            "0.80"    => [43,25],
            "1.00"  => [45,30],
            "1.20"  => [46,35],
            "1.30"  => [47,40],
            "1.40"  => [49,45],
            "1.50"  => [50,50],
            "1.60"  => [51,55],
            "1.70"  => [53,60],
            "1.90"  => [54,65],
            "2.10"  => [55,70],
            "2.30"  => [57,75],
            "2.50"  => [58,80],
            "2.70" => [60,85],
            "3.94" => [63,90],
            "3.43"  => [67,95],
            "3.70"  => [70,97],
            "3.80"    => [75,99]
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
            "0.17" => [42,20],
            "0.33"  => [43,25],
            "0.50" => [45,30],
            "0.52" => [46,35],
            "0.67" => [49,45],
            "0.94"    => [50,50],
            "1.00" => [51,55],
            "1.17" => [53,60],
            "1.33" => [54,65],
            "1.51" => [55,70],
            "1.67"    => [57,75],
            "2.00" => [58,80],
            "2.33"  => [60,85],
            "2.50" => [63,90],
            "3.05" => [67,95],
            "3.68" => [70,97],
            "3.83"    => [75,99]
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
            "0.00" => [40,15],
            "0.14" => [43,25],
            "0.29" => [45,30],
            "0.43" => [46,35],
            "0.57" => [47,40],
            "0.69" => [49,45],
            "0.71" => [50,50],
            "0.86"    => [51,55],
            "1.00" => [53,60],
            "1.14" => [54,65],
            "1.15" => [55,70],
            "1.41" => [57,75],
            "1.71" => [58,80],
            "2.09" => [60,85],
            "2.71" => [63,90],
            "3.14" => [67,95],
            "3.42" => [70,97],
            "3.68"    => [75,99]
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
            "0.00" => [37,10],
            "0.17" => [40,15],
            "0.33"  => [42,20],
            "0.50" => [43,25],
            "0.67" => [46,35],
            "0.99"    => [47,40],
            "1.00" => [49,45],
            "1.17" => [51,55],
            "1.33"  => [53,60],
            "1.50" => [54,65],
            "1.67" => [55,70],
            "1.83" => [58,80],
            "2.17" => [60,85],
            "2.74" => [63,90],
            "3.33" => [67,95],
            "3.67" => [70,97],
            "3.81"    => [75,99]
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
            "0.00"  => [37,10],
            "0.10"  => [40,15],
            "0.20"  => [42,20],
            "0.30" => [43,25],
            "0.32" => [45,30],
            "0.41" => [46,35],
            "0.59"  => [47,40],
            "0.60"  => [49,45],
            "0.70"  => [50,50],
            "0.90"  => [53,60],
            "1.10"  => [54,65],
            "1.20"  => [55,70],
            "1.50"  => [57,75],
            "1.60"  => [58,80],
            "1.90" => [60,85],
            "2.14"  => [63,90],
            "2.50" => [67,95],
            "3.03"  => [70,97],
            "3.30"    => [75,99]
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
            "0.00"  => [34,5],
            "0.40" => [37,10],
            "0.55" => [40,15],
            "0.78" => [42,20],
            "0.97" => [43,25],
            "1.04" => [45,30],
            "1.13" => [46,35],
            "1.28"  => [47,40],
            "1.40"  => [49,45],
            "1.50"  => [50,50],
            "1.60" => [51,55],
            "1.71" => [53,60],
            "1.76" => [54,65],
            "1.91"    => [55,70],
            "2.00" => [57,75],
            "2.12" => [58,80],
            "2.35" => [60,85],
            "2.55" => [63,90],
            "2.91" => [67,95],
            "3.22" => [70,97],
            "3.59"    => [75,99]
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
            "0.00" => [34,5],
            "22.00" => [37,10],
            "27.00" => [42,15],
            "34.00" => [42,20],
            "38.00" => [43,25],
            "43.00" => [47,30],
            "46.00" => [47,35],
            "47.00" => [47,40],
            "52.00" => [49,45],
            "56.00" => [50,50],
            "58.00" => [51,55],
            "61.00" => [53,60],
            "65.00" => [54,65],
            "66.00" => [55,70],
            "68.00" => [57,75],
            "70.00" => [58,80],
            "73.00" => [60,85],
            "77.00" => [63,90],
            "79.00" => [67,95],
            "84.00" => [70,97],
            "88.00" => [75,99]
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
            "1.00" => [34,5],
            "1.54" => [37,10],
            "1.71" => [40,15],
            "1.81" => [42,20],
            "1.88" => [43,25],
            "2.02" => [45,30],
            "2.11" => [46,35],
            "2.19" => [47,40],
            "2.31"  => [49,45],
            "2.40" => [50,50],
            "2.49" => [51,55],
            "2.63" => [53,60],
            "2.76" => [54,65],
            "2.86" => [55,70],
            "3.01" => [57,75],
            "3.09" => [58,80],
            "3.19" => [60,85],
            "3.28" => [63,90],
            "3.38" => [67,95],
            "3.65" => [70,97],
            "3.73"    => [75,99]
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
