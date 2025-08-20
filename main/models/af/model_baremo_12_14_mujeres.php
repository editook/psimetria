<?php
class ModelBaremo1214Mujeres
{
    //BAREMO ADULTOS MUJERES
    function getAcad(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal
        $eventEmitterRanges = [
            "0.00" => 1,"0.58" => 3,"1.32" => 5,"1.84" => 7,"2.36" => 10,"2.83" => 15,"3.50" => 20,"4.18" => 25,"4.77" => 30,"5.08" => 35,"5.35" => 40,"5.76" => 45,"6.01" => 50,"6.33" => 55,"6.67" => 60,"6.98" => 65,"7.25" => 70,"7.50" => 75,"7.79" => 80,"8.08" => 85,"8.38" => 90,"8.70" => 95,"8.97" => 97,"9.31" => 99
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
           "0.00" => 1,"2.75" => 3,"3.70" => 5,"4.50" => 7,"4.92" => 10,"5.33" => 15,"5.75" => 20,"6.07" => 25,"6.32" => 30,"6.51" => 35,"6.73" => 40,"6.97" => 45,"7.15" => 50,"7.38" => 55,"7.61" => 60,"7.80" => 65,"7.98" => 70,"8.16" => 75,"8.33" => 80,"8.60" => 85,"8.87" => 90,"9.13" => 93,"9.35" => 95,"9.52" => 97,"9.70" => 99
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
           "0.00" => 1,"0.24" => 3,"0.99" => 5,"1.57" => 7, "1.75" => 10,"2.08" => 15,"2.66" => 20,"3.06" => 25,"3.37" => 30,"3.55" => 35,"3.92" => 40,"4.15" => 45,"4.42" => 50,"4.67" => 55,"4.89" => 60,"5.19" => 65,"5.43" => 70,"5.72" => 75,"6.09" => 80,"6.45" => 85,"6.86" => 90,"7.34" => 93,"7.67" => 95,"8.12" => 97,"8.44" => 99
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
            "0.00" => 1,"2.65" => 3,"4.29" => 5,"5.00" => 7,"5.37" => 10,"5.81" => 15,"6.41" => 20,"6.75" => 25,"7.15" => 30,"7.50" => 35,"7.73" => 40,"7.95" => 45,"8.15" => 50,"8.32" => 55,"8.53" => 60,"8.77" => 65,"8.93" => 70,"9.11" => 75,"9.30" => 80,"9.50" => 85,"9.60" => 90,"9.75" => 95
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
            "0.00" => 1,"0.98" => 3,"1.55" => 5,"1.90" => 7,"2.16" => 10,"2.43" => 15,"2.87" => 20,"3.35" => 25,"3.68" => 30,"4.00" => 35,"4.33" => 40,"4.58" => 45,"4.91" => 50,"5.30" => 55,"5.50" => 60,"5.75" => 65,"6.00" => 70,"6.28" => 75,"6.57" => 80,"6.92" => 85,"7.19" => 90,"7.70" => 93,"8.00" => 95,"8.28" => 97,"8.58" => 99
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