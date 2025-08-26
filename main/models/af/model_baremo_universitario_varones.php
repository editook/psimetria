<?php
class ModelBaremoUniversitarioVarones
{
    function getAcad(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 1,
            "2.56" => 3,
            "3.12" => 5,
            "3.45" => 7,
            "4.07" => 10,
            "4.31" => 15,
            "4.67" => 20,
            "5.00" => 25,
            "5.33" => 30,
            "5.53" => 35,
            "5.78" => 40,
            "6.00" => 50,
            "6.33" => 60,
            "6.67" => 70,
            "7.07" => 80,
            "7.41" => 90,
            "7.83" => 95,
            "8.26" => 97,
            "8.50" => 99
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
            "5.58" => 25,
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
            "2.59" => 3,
            "3.00" => 5,
            "3.33" => 10,
            "3.81" => 15,
            "4.17" => 20,
            "4.46" => 30,
            "4.94" => 35,
            "5.17" => 40,
            "5.39" => 50,
            "5.83" => 60,
            "6.33" => 70,
            "6.67" => 80,
            "7.00" => 85,
            "7.33" => 90,
            "7.72" => 93,
            "8.16" => 95,
            "8.66" => 99
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
            "3.60" => 3,
            "4.17" => 5,
            "4.62" => 10,
            "5.34" => 15,
            "6.00" => 20,
            "6.28" => 25,
            "6.55" => 30,
            "6.85" => 40,
            "7.17" => 45,
            "7.42" => 50,
            "7.67" => 60,
            "8.07" => 65,
            "8.32" => 70,
            "8.53" => 80,
            "8.90" => 90,
            "9.13" => 95,
            "9.52" => 99
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
            "1.43" => 3,
            "2.22" => 5,
            "2.75" => 7,
            "3.08" => 10,
            "3.38" => 20,
            "4.08" => 25,
            "4.50" => 30,
            "4.92" => 40,
            "5.33" => 50,
            "5.67" => 60,
            "6.00" => 70,
            "6.46" => 80,
            "6.95" => 85,
            "7.30" => 90,
            "7.60" => 95,
            "8.08" => 99
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