<?php
class ModelBaremo1618Varones
{
    //BAREMO ADULTOS MUJERES
    function getAcad(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 1,
            "1.51" => 3,
            "2.29" => 5,
            "2.67" => 7,
            "2.99" => 10,
            "3.29" => 15,
            "3.73" => 20,
            "4.14" => 30,
            "4.67" => 35,
            "4.92" => 40,
            "5.17" => 45,
            "5.53" => 50,
            "5.78" => 55,
            "6.05" => 60,
            "6.27" => 70,
            "6.82" => 75,
            "7.07" => 80,
            "7.33" => 85,
            "7.71" => 90,
            "8.04" => 95,
            "8.35" => 97,
            "8.90" => 99
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
            "1.92" => 3,
            "2.47" => 5,
            "3.01" => 7,
            "3.18" => 10,
            "3.68" => 15,
            "4.15" => 20,
            "4.49" => 25,
            "4.67" => 30,
            "4.98" => 35,
            "5.29" => 40,
            "5.49" => 45,
            "5.77" => 50,
            "6.00" => 60,
            "6.41" => 65,
            "6.67" => 70,
            "6.87" => 75,
            "7.13" => 80,
            "7.35" => 85,
            "7.67" => 90,
            "8.00" => 93,
            "8.42" => 95,
            "8.69" => 97,
            "8.96" => 99
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
            "2.85" => 3,
            "3.59" => 5,
            "4.48" => 7,
            "4.78" => 10,
            "5.18" => 15,
            "6.07" => 20,
            "6.50" => 25,
            "6.80" => 30,
            "7.00" => 35,
            "7.25" => 40,
            "7.58" => 50,
            "7.97" => 55,
            "8.13" => 60,
            "8.33" => 65,
            "8.52" => 70,
            "8.72" => 80,
            "8.98" => 85,
            "9.26" => 90,
            "9.44" => 95,
            "9.70" => 99
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
            "2.04" => 3,
            "2.85" => 5,
            "3.15" => 7,
            "3.42" => 10,
            "3.79" => 15,
            "4.17" => 20,
            "4.57" => 25,
            "4.90" => 30,
            "5.17" => 40,
            "5.69" => 45,
            "5.98" => 50,
            "6.17" => 55,
            "6.35" => 60,
            "6.58" => 65,
            "6.83" => 70,
            "7.13" => 75,
            "7.37" => 80,
            "7.58" => 85,
            "7.92" => 90,
            "8.16" => 95,
            "8.59" => 97,
            "8.93" => 99
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