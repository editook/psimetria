<?php
class ModelSCLBaremoPsiquiatriaVarones
{
    function getSOM(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [37, 10],
            "0.17" => [40, 15],
            "0.38"  => [42, 20],
            "0.50" => [43, 25],
            "0.58" => [45, 30],
            "0.75" => [46, 35],
            "0.83" => [47, 40],
            "1.97"    => [49, 45],
            "1.00" => [50, 50],
            "1.17" => [51, 55],
            "1.27" => [53, 60],
            "1.42"  => [54, 65],
            "1.50" => [55, 70],
            "1.58" => [57, 75],
            "1.75" => [58, 80],
            "2.92" => [60, 85],
            "2.12" => [63, 90],
            "2.55" => [67, 95],
            "2.83"    => [70, 97],
            "3.00"    => [75, 99]
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
            "0.00" => [34, 5],
            "0.10" => [37, 10],
            "0.20" => [40, 15],
            "0.30" => [42, 20],
            "0.38" => [43, 25],
            "0.50" => [45, 30],
            "0.62" => [46, 35],
            "0.80" => [47, 40],
            "1.00" => [49, 45],
            "1.10" => [50, 50],
            "1.20" => [51, 55],
            "1.40" => [54, 65],
            "1.56" => [55, 70],
            "1.70" => [57, 75],
            "2.00" => [58, 80],
            "2.40" => [60, 85],
            "2.50" => [63, 90],
            "3.86" => [67, 95],
            "3.28" => [70, 97],
            "3.69" => [75, 99]
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
            "0.00" => [34, 5],
            "0.02" => [37, 10],
            "0.11" => [40, 15],
            "0.22" => [42, 20],
            "0.33" => [43, 25],
            "0.44" => [45, 30],
            "0.56" => [47, 40],
            "0.67" => [49, 45],
            "0.78" => [50, 50],
            "0.89" => [51, 55],
            "1.00" => [53, 60],
            "1.22" => [54, 65],
            "1.44" => [55, 70],
            "1.73" => [57, 75],
            "2.00" => [58, 80],
            "2.24" => [60, 85],
            "2.60" => [63, 90],
            "3.96" => [67, 95],
            "3.33" => [70, 97],
            "3.50" => [75, 99]
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
            "0.00" => [34, 5],
            "0.25" => [37, 10],
            "0.38" => [40, 15],
            "0.46"  => [42, 20],
            "0.60" => [43, 25],
            "0.69" => [45, 30],
            "0.78" => [46, 35],
            "1.03" => [47, 40],
            "1.23" => [49, 45],
            "1.38" => [50, 50],
            "1.54" => [51, 55],
            "1.69" => [53, 60],
            "1.77" => [54, 65],
            "1.89"    => [55, 70],
            "2.00" => [57, 75],
            "2.31" => [58, 80],
            "2.46" => [60, 85],
            "2.62" => [63, 90],
            "2.92" => [67, 95],
            "3.38" => [70, 97],
            "3.46"    => [75, 99]
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
            "0.00"  => [34, 5],
            "0.20" => [37, 10],
            "0.24"  => [40, 15],
            "0.30"  => [42, 20],
            "0.40"  => [43, 25],
            "0.50"  => [45, 30],
            "0.60"  => [46, 35],
            "0.80"  => [47, 40],
            "1.90" => [49, 45],
            "1.08"  => [50, 50],
            "1.20" => [51, 55],
            "1.32"  => [53, 60],
            "1.50"  => [54, 65],
            "1.60"  => [55, 70],
            "1.80"  => [57, 75],
            "1.90"  => [58, 80],
            "2.10"  => [60, 85],
            "2.30" => [63, 90],
            "3.82" => [67, 95],
            "3.46" => [70, 97],
            "3.65"    => [75, 99]
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
            "0.00" => [42, 20],
            "0.17" => [46, 35],
            "0.33"  => [47, 40],
            "0.50" => [49, 45],
            "0.63" => [50, 50],
            "0.67" => [51, 55],
            "0.83" => [53, 60],
            "1.07" => [54, 65],
            "1.33"  => [55, 70],
            "1.50" => [57, 75],
            "1.67" => [58, 80],
            "1.83" => [60, 85],
            "2.07" => [63, 90],
            "3.43" => [67, 95],
            "3.13" => [70, 97],
            "3.17"    => [75, 99]
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
            "0.00" => [43, 25],
            "0.14" => [46, 35],
            "0.29" => [47, 40],
            "0.43" => [51, 55],
            "0.71" => [54, 65],
            "0.86"    => [55, 70],
            "1.00" => [58, 80],
            "1.46"    => [60, 85],
            "2.00" => [63, 90],
            "2.43" => [67, 95],
            "2.86" => [70, 97],
            "3.49"    => [75, 99]
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

        $eventEmitterRanges = [//probar
            "0.00" => [37,10],
            "0.17"  => [42,20],
            "0.30" => [43,25],
            "0.33"  => [45,30],
            "0.50" => [47,40],
            "0.67" => [50,50],
            "0.83"    => [51,55],
            "1.00" => [53,60],
            "1.13"  => [54,65],
            "1.50"  => [55,70],
            "1.80"    => [57,75],
            "2.00" => [58,80],
            "2.17" => [60,85],
            "2.33" => [63,90],
            "2.67" => [67,95],
            "2.97" => [70,97],
            "3.25"    => [75,99]
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
            "0.00" => [37,10],
            "0.04"  => [40,15],
            "0.10"  => [43,25],
            "0.20"  => [46,35],
            "0.40"  => [47,40],
            "0.50" => [49,45],
            "0.58"  => [50,50],
            "0.70"  => [51,55],
            "0.80"    => [53,60],
            "1.00"  => [54,65],
            "1.20"  => [55,70],
            "1.40"  => [57,75],
            "1.60"  => [58,80],
            "1.90"    => [60,85],
            "2.00"  => [63,90],
            "2.40"    => [67,95],
            "3.00" => [70,97],
            "3.15"    => [75,99]
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
            "0.29" => [37,10],
            "0.37" => [40,15],
            "0.43" => [42,20],
            "0.48" => [43,25],
            "0.51" => [45,30],
            "0.61" => [46,35],
            "0.88" => [47,40],
            "0.97" => [49,45],
            "1.01" => [50,50],
            "1.14" => [51,55],
            "1.19" => [53,60],
            "1.31"  => [54,65],
            "1.40" => [55,70],
            "1.46" => [57,75],
            "1.73" => [58,80],
            "1.98" => [60,85],
            "2.18" => [63,90],
            "2.34" => [67,95],
            "2.92"  => [70,97],
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

    function getPST(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =90;
        $rangeStep = 1; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [34,5],
            "16.00" => [37,10],
            "19.00" => [40,15],
            "26.00" => [42,20],
            "27.00" => [43,25],
            "30.00" => [45,30],
            "37.00" => [46,35],
            "40.00" => [47,40],
            "42.00" => [49,45],
            "43.00" => [50,50],
            "46.00" => [51,55],
            "47.00" => [53,60],
            "51.00" => [54,65],
            "57.00" => [55,70],
            "59.00" => [57,75],
            "66.00" => [58,80],
            "71.00" => [60,85],
            "73.00" => [63,90],
            "77.00" => [67,95],
            "85.00" => [70,97],
            "86.00" => [75,99]
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
            "1.24" => [37,10],
            "1.35" => [40,15],
            "1.45" => [42,20],
            "1.51" => [43,25],
            "1.57" => [45,30],
            "1.71" => [46,35],
            "1.78" => [47,40],
            "1.92"    => [49,45],
            "2.00" => [50,50],
            "2.09" => [51,55],
            "2.19" => [53,60],
            "2.34" => [54,65],
            "2.44" => [55,70],
            "2.54" => [57,75],
            "2.63" => [58,80],
            "2.75" => [60,85],
            "2.93" => [63,90],
            "3.14" => [67,95],
            "3.45" => [70,97],
            "3.78"    => [75,99]
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