<?php
class ModelBaremo1012Mujeres
{
    //Baremos 10 a 12 años Mujeres
    function getAcad(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
           "0.00" => 1,"1.26" => 3,"2.67" => 5,"3.11" => 7, "3.48" => 10,"3.90" => 15,"4.67" => 20,"4.99" => 25,"5.33" => 30,"5.83" => 40,"6.26" => 45,"6.58" => 50,"6.92" => 55,"7.19" => 60,"7.50" => 70,"8.00" => 80,"8.50" => 85,"8.74" => 90,"9.00" => 95,"9.42" => 99
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

    function getSoc(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
           "0.00" => 1,"3.17" => 3,"4.16" => 5,"4.62" => 7,"4.83" => 10,"5.20" => 15,"5.67" =>20,"6.00" => 25,"6.25" => 30,"6.50" => 35,"6.75" => 40,"7.00" => 45,"7.22" => 50,"7.40" => 55,"7.58" => 60,"7.80" => 65,"7.98" => 70,"8.15" => 75,"8.33" => 80,"8.52" => 85,"8.78" => 90,"9.12" => 95,"9.52" => 97,"9.70" => 99
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
        $currentRangeStart =9.90;//"" => 0,
        $rangeStep = 0.01; // Incremento decimal
        $eventEmitterRanges = [
            "0.00" => 1,"0.33" => 3,"1.23" => 5,"1.53" => 10,"2.08" => 15,"2.52" => 20,"3.00" => 25,"3.37" => 30,"3.67" => 35,"4.03" => 40,"4.36" => 45,"4.60" => 50,"4.83" => 60,"5.35" => 65,"5.57" => 70,"5.80" => 75,"6.17" => 80,"6.50" => 85,"6.88" => 90,"7.32" => 93,"7.83" => 95,"8.06" => 97,"8.50" => 99
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
            "0.00" => 1,"3.33" => 3,"4.84" => 5,"5.50" => 7,"6.03" => 10,"6.48" => 15,"6.88" => 20,"7.28" => 25,"7.58" => 30,"7.80" => 35,"8.00" => 40,"8.23" => 50,"8.50" => 55,"8.65" => 60,"8.82" => 65,"8.97" => 70,"9.15" => 75,"9.30" => 80,"9.47" => 85,"9.62" => 90,"9.77" => 95
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
            "0.00" => 1,"1.44" => 3,"2.51" => 5,"2.71" => 7,"2.99" => 10,"3.45" => 15,"3.97" => 20,"4.36" => 26,"4.58" => 30,"5.03" => 35,"5.36" => 40,"5.65" => 45,"5.96" => 50,"6.25" => 60,"6.67" => 70,"7.15" => 75,"7.47" => 80,"7.73" => 85,"7.97" => 90,"8.34" => 93,"8.55" => 95,"8.83" => 97,"9.27" => 99,
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