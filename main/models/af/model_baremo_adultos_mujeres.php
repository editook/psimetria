<?php
class ModelBaremoAdultosMujeres
{
    //BAREMO ADULTOS MUJERES
    function getAcad(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =9.90;
        $rangeStep = 0.01; // Incremento decimal
        $eventEmitterRanges = [
            "0.00" => 1,"3.63" => 3,"4.56" => 5,"5.00" => 7,"5.47" => 10,"5.83" => 15,"6.50" => 20,"6.89" => 25,"7.42" => 30,"7.68" => 40,"8.00" => 50,"8.32" => 60,"8.72" => 70,"9.08" => 80,"9.43" => 90,"9.75" => 99
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
           "0.00" => 1,"2.88" => 3,"4.17" => 5,"4.51" => 7,"4.67" => 10,"5.00" => 15,"5.50" => 20,"5.83" => 25,"6.15" => 30,"6.42" => 35,"6.63" => 40,"6.82" => 45,"7.00" => 50,"7.33" => 55,"7.63" => 60,"7.82" => 65,"8.06" => 70,"8.27" => 80,"8.65" => 85,"8.92" =>90,"9.16" => 93,"9.58" => 95,"9.75" => 99
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
            "0.00" => 1,"1.25" => 3,"1.70" => 5,"2.31" => 7,"2.97" => 10,"3.41" => 15,"3.93" => 20,"4.23" => 25,"4.53" => 30,"4.83" => 40,"5.28" => 50,"5.83" => 55,"6.29" => 60,"6.62" => 70,"6.98" => 80,"7.69" => 90,"8.27" => 95,"8.75" => 97,"9.02" => 99
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
            "0.00" => 1,"3.72" => 3,"4.67" => 5,"5.38" => 7,"5.81" => 10,"6.16" => 15,"6.65" => 20,"7.12" => 25,"7.43" => 30,"7.67" => 35,"7.99" => 40,"8.17" => 50,"8.50" => 60,"8.80" => 65,"8.94" => 70,"9.10" => 75,"9.29" => 80,"9.45" => 85,"9.60" => 90,"9.75" => 95
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
            "0.00" => 1,"0.94" => 3,"1.56" => 5,"1.94" => 7,"2.31" => 10,"2.55" => 20,"3.37" => 25,"3.78" => 30,"4.01" => 40,"4.33" => 50,"4.87" => 60,"5.17" => 70,"5.52" => 80,"5.92" => 85,"6.17" => 90,"6.61" => 93,"6.87" => 95,"7.54" => 97,"7.83" => 99
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