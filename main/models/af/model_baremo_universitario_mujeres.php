<?php
class ModelBaremoUniversitarioMujeres
{
    function getAcad(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 1,
            "2.89" => 3,
            "3.77" => 5,
            "4.00" => 7,
            "4.29" => 10,
            "4.67" => 15,
            "5.00" => 20,
            "5.33" => 25,
            "5.52" => 30,
            "5.75" => 35,
            "6.00" => 40,
            "6.25" => 45,
            "6.49" => 50,
            "6.67" => 55,
            "6.83" => 60,
            "7.00" => 65,
            "7.17" => 70,
            "7.33" => 75,
            "7.49" => 80,
            "7.67" => 85,
            "8.00" => 90,
            "8.33" => 93,
            "8.50" => 95,
            "8.70" => 97,
            "8.99" => 99
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

    function getSoc(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        
        $eventEmitterRanges = [
            "0.00" => 1,
            "2.45" => 3,
            "3.67" => 5,
            "4.10" => 7,
            "4.40" => 10,
            "4.85" => 15,
            "5.25" => 20,
            "5.83" => 30,
            "6.08" => 35,
            "6.33" => 40,
            "6.58" => 45,
            "6.83" => 50,
            "7.08" => 55,
            "7.33" => 60,
            "7.50" => 65,
            "7.67" => 70,
            "7.85" => 75,
            "8.07" => 80,
            "8.27" => 85,
            "8.50" => 90,
            "8.78" => 93,
            "9.00" => 95,
            "9.17" => 97,
            "9.44" => 99
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
            "1.25" => 3,
            "1.77" => 5,
            "2.02" => 7,
            "2.30" => 10,
            "2.53" => 15,
            "2.92" => 20,
            "3.33" => 25,
            "3.59" => 30,
            "3.85" => 35,
            "4.17" => 40,
            "4.42" => 45,
            "4.65" => 50,
            "4.92" => 55,
            "5.17" => 60,
            "5.46" => 65,
            "5.68" => 70,
            "5.93" => 75,
            "6.17" => 80,
            "6.58" => 85,
            "6.83" => 90,
            "7.24" => 93,
            "7.65" => 95,
            "7.83" => 97,
            "8.22" => 99
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
            "2.04" => 3,
            "3.47" => 5,
            "4.54" => 7,
            "4.88" => 10,
            "5.43" => 15,
            "6.32" => 20,
            "6.83" => 25,
            "7.19" => 30,
            "7.50" => 35,
            "7.75" => 40,
            "8.04" => 45,
            "8.23" => 50,
            "8.40" => 55,
            "8.57" => 60,
            "8.75" => 70,
            "9.04" => 80,
            "9.37" => 90,
            "9.62" => 99
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
            "1.21" => 3,
            "1.81" => 5,
            "2.05" => 7,
            "2.26" => 10,
            "2.53" => 15,
            "3.17" => 20,
            "3.50" => 25,
            "3.75" => 30,
            "4.00" => 35,
            "4.20" => 40,
            "4.50" => 45,
            "4.67" => 50,
            "4.83" => 55,
            "5.10" => 60,
            "5.33" => 65,
            "5.50" => 70,
            "5.75" => 75,
            "5.92" => 80,
            "6.17" => 85,
            "6.50" => 90,
            "6.83" => 93,
            "7.23" => 95,
            "7.50" => 97,
            "7.82" => 99
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