<?php
class ModelSCLBaremoPoblacionGeneralVarones
{
    function getSOM(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [42, 20],
            "0.08" => [46, 35],
            "0.17" => [49, 45],
            "0.25" => [53, 60],
            "0.33" => [54, 65],
            "0.42"  => [55, 70],
            "0.50" => [57, 75],
            "0.58" => [58, 80],
            "0.62" => [60, 85],
            "0.67" => [63, 90],
            "0.92" => [67, 95],
            "1.33" => [70, 97],
            "1.53"    => [75, 99]
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
            "0.00" => [37, 10],
            "0.10" => [40, 15],
            "0.20" => [45, 30],
            "0.30" => [47, 40],
            "0.40" => [50, 50],
            "0.50" => [51, 55],
            "0.60" => [54, 65],
            "0.70" => [57, 75],
            "0.80" => [58, 80],
            "0.90"   => [60, 85],
            "1.00" => [63, 90],
            "1.10" => [67, 95],
            "1.40" => [70, 97],
            "1.50"   => [75, 99]
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
            //echo $value .'=>'.json_encode($eventEmitter).'<br>';
            $mags["$value"] = $eventEmitter;
        }
        $mags["0.00"] = [34,5];
        return $mags;
    }
    function getINT(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [42, 20],
            "0.11" => [46, 35],
            "0.22" => [49, 45],
            "0.33" => [51, 55],
            "0.44" => [54, 65],
            "0.56" => [57, 75],
            "0.67" => [58, 80],
            "0.78" => [63, 90],
            "0.89" => [67, 95],
            "1.22" => [70, 97],
            "1.44"    => [75, 99]
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
            "0.00" => [37, 10],
            "0.15"  => [42, 20],
            "0.20" => [43, 25],
            "0.23" => [45, 30],
            "0.31" => [46, 35],
            "0.38"  => [47, 40],
            "0.40" => [49, 45],
            "0.46" => [51, 55],
            "0.54" => [53, 60],
            "0.62" => [54, 65],
            "0.65" => [55, 70],
            "0.77" => [57, 75],
            "0.85" => [58, 80],
            "0.92" => [60, 85],
            "1.08" => [63, 90],
            "1.21" => [67, 95],
            "1.54" => [70, 97],
            "1.72"    => [75, 99]
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
            "0.00" => [40, 15],
            "0.10" => [45, 30],
            "0.20" => [49, 45],
            "0.30" => [51, 55],
            "0.40" => [54, 65],
            "0.50" => [57, 75],
            "0.60" => [58, 80],
            "0.70" => [60, 85],
            "0.80" => [63, 90],
            "0.90" => [67, 95],
            "1.20" => [70, 97],
            "1.34"   => [75, 99]
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
            "0.00" => [46, 35],
            "0.17" => [50, 50],
            "0.25" => [51, 55],
            "0.33"  => [54, 65],
            "0.50" => [55, 70],
            "0.52" => [57, 75],
            "0.67" => [58, 80],
            "0.83"    => [60, 85],
            "1.00" => [63, 90],
            "1.17"  => [67, 95],
            "1.50"    => [75, 99]
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
            "0.00" => [50, 50],
            "0.14" => [55, 70],
            "0.29" => [58, 80],
            "0.43" => [63, 90],
            "0.57" => [67, 95],
            "0.71" => [70, 97],
            "0.86"    => [75, 99]
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
            "0.00" => [45, 30],
            "0.17" => [47, 40],
            "0.33"  => [51, 55],
            "0.50" => [55, 70],
            "0.67" => [58, 80],
            "0.83"    => [60, 85],
            "1.00" => [63, 90],
            "1.17" => [67, 95],
            "1.33"  => [70, 97],
            "1.50"    => [75, 99]
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
            "0.00"  => [49, 45],
            "0.10"  => [53, 60],
            "0.20"  => [57, 75],
            "0.30"  => [58, 80],
            "0.40" => [60, 85],
            "0.51"  => [63, 90],
            "0.70" => [67, 95],
            "0.83"    => [70, 97],
            "1.00"    => [75, 99]
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
            "0.00" => [34, 5],
            "0.08" => [37, 10],
            "0.13" => [40, 15],
            "0.17" => [42, 20],
            "0.19" => [43, 25],
            "0.22" => [45, 30],
            "0.24" => [46, 35],
            "0.27"  => [47, 40],
            "0.30" => [49, 45],
            "0.34" => [50, 50],
            "0.38" => [51, 55],
            "0.41" => [53, 60],
            "0.44" => [54, 65],
            "0.48" => [55, 70],
            "0.54" => [57, 75],
            "0.59" => [58, 80],
            "0.63" => [60, 85],
            "0.73"  => [63, 90],
            "0.80" => [67, 95],
            "1.08" => [70, 97],
            "1.16"    => [75, 99]
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
        $currentRangeStart =190;
        $rangeStep = 1; // Incremento decimal

        $eventEmitterRanges = [
            "0.00"   => [34, 5],
            "5.00"   => [37, 10],
            "8.00"  => [40, 15],
            "10.00"  => [42, 20],
            "11.00"  => [43, 25],
            "13.00"  => [45, 30],
            "14.00"  => [46, 35],
            "16.00"  => [47, 40],
            "18.00"  => [49, 45],
            "19.00"  => [50, 50],
            "20.00"  => [51, 55],
            "22.00"  => [53, 60],
            "24.00"  => [54, 65],
            "26.00"  => [55, 70],
            "28.00"  => [57, 75],
            "31.00"  => [58, 80],
            "33.00"  => [60, 85],
            "41.00"  => [63, 90],
            "47.00"  => [67, 95],
            "53.00"  => [70, 97],
            "60.00" => [75, 99]
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
        }
        return $mags;
    }
    function getPSDI(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [34, 5],
            "1.03" => [37, 10],
            "1.13" => [40, 15],
            "1.18" => [42, 20],
            "1.23"  => [43, 25],
            "1.30" => [45, 30],
            "1.35" => [46, 35],
            "1.44" => [47, 40],
            "1.48" => [49, 45],
            "1.52" => [50, 50],
            "1.56" => [51, 55],
            "1.65" => [53, 60],
            "1.73" => [54, 65],
            "1.85"    => [55, 70],
            "2.00" => [57, 75],
            "2.03" => [58, 80],
            "2.15" => [60, 85],
            "2.22" => [63, 90],
            "2.28" => [67, 95],
            "2.49" => [70, 97],
            "2.65"    => [75, 99]
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
