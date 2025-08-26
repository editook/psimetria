<?php
class ModelBaremoAdultosVarones
{
    function getAcad(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal
        
        $eventEmitterRanges = [
            "0.00" => 1,
            "3.54" => 3,
            "4.33" => 5,
            "5.00" => 10,
            "5.49" => 15,
            "6.03" => 20,
            "6.33" => 25,
            "6.78" => 30,
            "7.17" => 40,
            "7.55" => 50,
            "7.95" => 60,
            "8.18" => 70,
            "8.66" => 80,
            "8.99" => 85,
            "9.21" => 90,
            "9.49" => 95,
            "9.77" => 99
        ];

        //echo '<br>';
        for ($i = 0; $i <= 991; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
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
        $rangeStep = 0.01; // Incremento decimal
        $eventEmitterRanges = [
            "0.00" => 1,
            "2.88" => 3,
            "4.17" => 5,
            "4.51" => 7,
            "4.67" => 10,
            "5.00" => 15,
            "5.50" => 20,
            "5.83" => 25,
            "6.15" => 30,
            "6.42" => 35,
            "6.63" => 40,
            "6.82" => 45,
            "7.00" => 50,
            "7.33" => 55,
            "7.63" => 60,
            "7.82" => 65,
            "8.06" => 70,
            "8.27" => 80,
            "8.65" => 85,
            "8.92" => 90,
            "9.16" => 93,
            "9.58" => 95,
            "9.75" => 99
        ];

        for ($i = 0; $i <= 991; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
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
        $rangeStep = 0.01; // Incremento decimal
        
        $eventEmitterRanges = [
            "0.00" => 1,
            "2.27" => 3,
            "3.00" => 5,
            "3.67" => 10,
            "4.34" => 15,
            "4.64" => 20,
            "5.00" => 25,
            "5.33" => 30,
            "5.70" => 35,
            "5.98" => 40,
            "6.33" => 50,
            "6.67" => 55,
            "6.89" => 60,
            "7.17" => 70,
            "7.67" => 80,
            "8.04" => 85,
            "8.45" => 90,
            "8.84" => 95,
            "9.17" => 97,
            "9.58" => 99
        ];

        for ($i = 0; $i <= 991; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
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
        $eventEmitterValue = 95;
        $currentRangeStart =9.90; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 1,
            "3.72" => 3,
            "4.67" => 5,
            "5.38" => 7,
            "5.81" => 10,
            "6.16" => 15,
            "6.65" => 20,
            "7.12" => 25,
            "7.43" => 30,
            "7.66" => 30,
            "7.99" => 40,
            "8.17" => 50,
            "8.49" => 50,
            "8.79" => 60,
            "8.94" => 70,
            "9.10" => 75,
            "9.29" => 80,
            "9.45" => 85,
            "9.60" => 90,
            "9.75" => 95
        ];

        
        for ($i = 0; $i <= 991; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
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
            "0.75" => 5,
            "1.87" => 7,
            "2.21" => 10,
            "2.67" => 15,
            "3.27" => 20,
            "3.67" => 25,
            "4.17" => 30,
            "4.50" => 40,
            "5.07" => 50,
            "5.60" => 55,
            "5.98" => 60,
            "6.44" => 70,
            "7.00" => 75,
            "7.42" => 80,
            "7.70" => 85,
            "8.08" => 90,
            "8.37" => 95,
            "8.72" => 99
        ];

        for ($i = 0; $i <= 991; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $prs["$value"] = $eventEmitterValue;
        }
        return $prs;
    }

}