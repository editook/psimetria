<?php
class ModelBaremo1012Varones
{
    //BAREMO ADULTOS MUJERES
    function getAcad(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal
        $eventEmitterRanges = [
            "0.00" => 1,"0.99" => 3,"2.17" => 7,"3.21" => 10,"3.50" => 15,"4.00" => 20,"4.53" => 25,"5.15" => 30,"5.45" => 40,"6.01" => 50,"6.48" => 60,"6.99" => 65,"7.35" => 70,"7.64" => 80,"8.17" => 85,"8.42" => 90,"8.80" => 93,"9.02" => 95,"9.25" => 99
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
           "0.00" => 1,"3.15" => 3,"4.15" => 5,"4.62" => 7,"4.83" => 10,"5.20" => 20,"6.00" => 25,"6.25" => 30,"6.50" => 35,"6.75" => 40,"7.00" => 45,"7.22" => 50,"7.40" => 55,"7.58" => 60,"7.80" => 65,"7.98" => 70,"8.15" => 75,"8.33" => 80,"8.52" => 85,"8.78" => 90,"9.12" => 95,"9.52" => 97,"9.70" => 99
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
            "0.00" => 1,"0.87" => 3,"1.39" => 5,"1.84" => 10,"2.50" => 15,"3.12" => 20,"3.56" => 25,"4.03" => 30,"4.25" => 35,"4.50" => 40,"4.83" => 45,"5.17" => 50,"5.44" => 60,"5.83" => 70,"6.49" => 75,"6.83" => 80,"7.21" => 85,"7.67" => 90,"8.13" => 95,"8.56" => 97,"9.02" => 99
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
            "0.00" => 1,"1.23" => 3,"2.70" => 5,"3.33" => 7,"3.83" => 10,"4.30" => 15,"4.81" => 20,"5.32" => 25,"5.66" => 30,"5.98" => 40,"6.38" => 50,"6.83" => 60,"7.33" => 65,"7.58" => 70,"7.83" => 75,"8.13" => 80,"8.45" => 85,"8.67" => 90,"9.03" => 95,"9.35" => 97,"9.56" => 99
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