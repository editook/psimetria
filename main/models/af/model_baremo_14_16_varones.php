<?php
class ModelBaremo1416Varones
{
    function getAcad(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal "" => 0,
    
        $eventEmitterRanges = [
            "0.00" => 1,
            "0.89" => 3,
            "1.87" => 5,
            "2.59" => 7,
            "2.89" => 10,
            "3.34" => 15,
            "3.83" => 20,
            "4.33" => 25,
            "4.67" => 30,
            "4.97" => 35,
            "5.33" => 40,
            "5.58" => 45,
            "5.83" => 50,
            "6.08" => 55,
            "6.25" => 60,
            "6.50" => 65,
            "6.72" => 70,
            "7.00" => 75,
            "7.20" => 80,
            "7.47" => 85,
            "7.75" => 90,
            "8.17" => 93,
            "8.42" => 95,
            "8.58" => 97,
            "8.85" => 99
        ];
        for ($i = 0; $i <= 991; $i++) {
            $currentValue = (float)round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue >= (float)$rangeStart) {
                    $eventEmitterValue = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $prs["$value"] = $eventEmitterValue;
        }
        return $prs;
    
    }

    function getSoc(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal "" => 0,
    
        $eventEmitterRanges = [
            "0.00" => 1,
            "3.42" => 3,
            "4.18" => 5,
            "4.67" => 7,
            "5.00" => 10,
            "5.42" => 15,
            "5.84" => 20,
            "6.25" => 25,
            "6.57" => 30,
            "6.77" => 35,
            "7.00" => 40,
            "7.18" => 45,
            "7.40" => 50,
            "7.58" => 55,
            "7.75" => 60,
            "7.92" => 65,
            "8.08" => 70,
            "8.28" => 75,
            "8.47" => 80,
            "8.67" => 85,
            "8.90" => 90,
            "9.15" => 93,
            "9.35" => 95,
            "9.53" => 97,
            "9.65" => 99
        ];
        for ($i = 0; $i <= 991; $i++) {
            $currentValue = (float)round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > (float)$rangeStart) {
                    $eventEmitterValue = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $prs["$value"] = $eventEmitterValue;
        }
        return $prs;
    }

    function getEmo(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal "" => 0,
    
        $eventEmitterRanges = [
            "0.00" => 1,
            "1.96" => 3,
            "2.43" => 5,
            "2.76" => 7,
            "3.00" => 10,
            "3.34" => 15,
            "3.84" => 20,
            "4.34" => 25,
            "4.59" => 30,
            "4.84" => 35,
            "5.09" => 40,
            "5.34" => 45,
            "5.59" => 50,
            "5.84" => 55,
            "5.99" => 60,
            "6.18" => 65,
            "6.49" => 70,
            "6.69" => 75,
            "7.01" => 80,
            "7.33" => 85,
            "7.73" => 90,
            "8.10" => 93,
            "8.49" => 95,
            "8.67" => 97,
            "8.88" => 99
        ];

        for ($i = 0; $i <= 991; $i++) {
            $currentValue = (float)round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue >= (float)$rangeStart) {
                    $eventEmitterValue = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $prs["$value"] = $eventEmitterValue;
        }
        return $prs;
    }

    function getFami(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal "" => 0,
    
        $eventEmitterRanges = [
            "0.00" => 1,
            "2.43" => 3,
            "3.87" => 5,
            "4.51" => 7,
            "5.17" => 10,
            "5.76" => 15,
            "6.38" => 20,
            "6.78" => 25,
            "7.13" => 30,
            "7.48" => 35,
            "7.73" => 40,
            "7.94" => 45,
            "8.14" => 50,
            "8.33" => 55,
            "8.56" => 60,
            "8.73" => 65,
            "8.89" => 70,
            "9.08" => 75,
            "9.23" => 80,
            "9.38" => 85,
            "9.53" => 90,
            "9.69" => 95,
            "9.85" => 99
        ];
        for ($i = 0; $i <= 991; $i++) {
            $currentValue = (float)round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > (float)$rangeStart) {
                    $eventEmitterValue = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $prs["$value"] = $eventEmitterValue;
        }
        return $prs;
    }

    function getFis(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal "" => 0,
    
        $eventEmitterRanges = [
            "0.00" => 1,
            "1.53" => 3,
            "2.48" => 5,
            "3.19" => 7,
            "3.52" => 10,
            "4.02" => 15,
            "4.63" => 20,
            "5.02" => 25,
            "5.33" => 30,
            "5.57" => 35,
            "5.86" => 40,
            "6.14" => 45,
            "6.33" => 50,
            "6.52" => 55,
            "6.77" => 60,
            "6.99" => 65,
            "7.22" => 70,
            "7.45" => 75,
            "7.67" => 80,
            "7.87" => 85,
            "8.13" => 90,
            "8.52" => 93,
            "8.79" => 95,
            "9.07" => 97,
            "9.27" => 99,
        ];



        for ($i = 0; $i <= 991; $i++) {
            $currentValue = (float)round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > (float)$rangeStart) {
                    $eventEmitterValue = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $prs["$value"] = $eventEmitterValue;
        }
        return $prs;
    }

}