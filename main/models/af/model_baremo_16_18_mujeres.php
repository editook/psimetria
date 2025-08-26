<?php
class ModelBaremo1618Mujeres
{
    //BAREMO ADULTOS MUJERES
    function getAcad(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal "" => 0,
    
        $eventEmitterRanges = [
            "0.00" => 1,
            "2.21" => 3,
            "2.86" => 5,
            "3.24" => 7,
            "3.50" => 10,
            "4.00" => 15,
            "4.35" => 20,
            "4.68" => 25,
            "5.02" => 30,
            "5.18" => 35,
            "5.41" => 40,
            "5.59" => 45,
            "5.93" => 50,
            "6.11" => 55,
            "6.35" => 60,
            "6.51" => 65,
            "6.68" => 70,
            "6.85" => 75,
            "7.06" => 80,
            "7.34" => 85,
            "7.76" => 90,
            "8.10" => 93,
            "8.37" => 95,
            "8.65" => 97,
            "8.81" => 99
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
            "3.03" => 3,
            "4.01" => 5,
            "4.47" => 7,
            "4.70" => 10,
            "5.08" => 15,
            "5.63" => 20,
            "5.97" => 25,
            "6.33" => 30,
            "6.58" => 35,
            "6.83" => 40,
            "7.00" => 45,
            "7.23" => 50,
            "7.33" => 55,
            "7.50" => 60,
            "7.67" => 65,
            "7.83" => 70,
            "8.01" => 75,
            "8.20" => 80,
            "8.42" => 85,
            "8.67" => 90,
            "8.93" => 93,
            "9.15" => 95,
            "9.30" => 97,
            "9.58" => 99
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
            "0.58" => 3,
            "1.47" => 5,
            "1.86" => 7,
            "2.11" => 10,
            "2.42" => 15,
            "2.84" => 20,
            "3.17" => 25,
            "3.45" => 30,
            "3.69" => 35,
            "4.00" => 40,
            "4.20" => 50,
            "4.56" => 55,
            "4.83" => 60,
            "5.00" => 65,
            "5.32" => 70,
            "5.58" => 75,
            "5.83" => 80,
            "6.08" => 85,
            "6.58" => 90,
            "7.15" => 93,
            "7.61" => 95,
            "7.92" => 97,
            "8.34" => 99
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

    function getFami(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 1,
            "1.87" => 3,
            "3.70" => 5,
            "4.74" => 7,
            "4.93" => 10,
            "5.58" => 15,
            "6.24" => 20,
            "6.85" => 25,
            "7.35" => 30,
            "7.67" => 35,
            "7.88" => 40,
            "8.08" => 45,
            "8.30" => 50,
            "8.48" => 55,
            "8.63" => 60,
            "8.78" => 70,
            "9.10" => 80,
            "9.34" => 90,
            "9.68" => 95,
            "9.83" => 99
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
            "1.08" => 3,
            "1.70" => 5,
            "1.88" => 7,
            "2.20" => 10,
            "2.64" => 15,
            "3.17" => 20,
            "3.45" => 25,
            "3.67" => 30,
            "4.00" => 40,
            "4.33" => 45,
            "4.52" => 50,
            "4.72" => 55,
            "4.99" => 60,
            "5.17" => 65,
            "5.48" => 70,
            "5.75" => 75,
            "6.00" => 80,
            "6.33" => 85,
            "6.67" => 90,
            "7.08" => 93,
            "7.37" => 95,
            "7.62" => 97,
            "7.92" => 99
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