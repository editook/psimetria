<?php
class ModelBaremoPobGralMujeres
{
    //BAREMO DE POBLACION GENERAL VARONES	
    function getMin(){
        $mins = [];
        $eventEmitterValue = 98;
        $currentRangeStart = 0.00;
        $rangeStep = 0.01; // Incremento decimal
        $eventEmitterRanges = [
            "0.11" => 95, "0.21" => 90, "0.31" => 85, "0.41" => 80, 
            "0.61" => 75, "0.71" => 65, "0.81" => 55, "0.91" => 50, 
            "1.11" => 45, "1.21" => 40, "1.31" => 35, "1.36" => 30, 
            "1.61" => 25, "1.71" => 20, "1.81" => 15, "2.10" => 10, 
            "2.41" => 5, "2.61" => 3, "2.71" => 2, "2.81" => 1
        ];
        // Generar los datos
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart + ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                if ($currentValue >= round($rangeStart,2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            $mins["$currentValue"] = $eventEmitterValue;
        }
        return $mins;
    }

    function getMag(){
        $mags = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => 5,"0.10" => 10,"0.20" => 15,"0.30" => 20,"0.45" => 25,"0.60" => 30,
            "0.65" => 35,"0.70" => 40,"0.80" => 45,"0.90" => 50,"1.10" => 55,"1.20" => 60,
            "1.35" => 65,"1.45" => 70,"1.70" => 75, "1.87" => 80,"1.95" => 85,"2.30" => 90,
            "2.80" => 95, "3.00" => 96, "3.20" => 97, "3.30" => 98, "3.45" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $mags["$currentValue"] = $eventEmitterValue;
        }
        return $mags;
    }

    function getPr(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal
        $eventEmitterRanges = [
            "0.00" => 10,"0.06" => 20,"0.13" => 25,"0.21" => 35,"0.28" => 40,"0.35" => 50,"0.42" => 55,"0.49" => 60,"0.56" => 65,"0.63" => 70,"0.70" => 75,"0.85" => 80,"0.90" => 85,"1.06" => 90,"1.21" => 95,"1.45" => 96,"1.65" => 97,"1.85" => 98,"1.99" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $prs["$currentValue"] = $eventEmitterValue;
        }
        return $prs;
    }

    function getHp(){
        $hps = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 25,"0.13" => 40,"0.28" => 50,"0.42" => 65,"0.56" => 75,"0.70" => 80,"0.85" => 85,"0.99" => 90,"1.28" => 95,"1.56" => 96,"1.70" => 97,"1.85" => 98,"2.13" => 99,
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $hps["$currentValue"] = $eventEmitterValue;
        }
        return $hps;
    }

    function getOb(){
        $obs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 20,"0.13" => 30,"0.28" => 45,"0.42" => 60,"0.56" => 65,"0.70" => 70,"0.85" => 75,"0.99" => 80,"1.13" => 85,"1.28" => 90,"1.56" => 95,"1.70" => 96,"1.85" => 97,"2.13" => 98,"2.28" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $obs["$currentValue"] = $eventEmitterValue;
        }
        return $obs;
    }

    function getAn(){
        $ans = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 20,"0.10" => 40,"0.21" => 55,"0.32" => 70,"0.43" => 75,"0.55" => 80,"0.66" => 85,"0.88" => 90,"1.10" => 95,"1.21" => 96,"1.32" => 97,"1.42" => 98,"1.77" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $ans["$currentValue"] = $eventEmitterValue;
        }
        return $ans;
    }

    function getHs(){
        $hss = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 30,"0.16" => 45,"0.32" => 55,"0.49" => 70,"0.66" => 75,"0.82" => 85,"1.16" => 90,"1.49" => 95,"1.82" => 96,"1.99" => 97,"2.16" => 98,"2.49" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $hss["$currentValue"] = $eventEmitterValue;
        }
        return $hss;
    }

    function getSm(){
        $sms = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
           "0.00" => 30,"0.16" => 45,"0.49" => 50,"0.62" => 60,"0.74" => 65,"0.87" => 70,"0.99" => 75,"1.12" => 80,"1.24" => 85,"1.49" => 90,"1.87" => 95,"1.99" => 96,"2.12" => 97,"2.24" => 98,"2.49" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $sms["$currentValue"] = $eventEmitterValue;
        }
        return $sms;
    }

    function getDe(){
        $des = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 10,"0.09" => 15,"0.19" => 20,"0.29" => 30,"0.39" => 35,"0.49" => 45,"0.59" => 50,"0.69" => 55,"0.79" => 60,"0.89" => 65,"0.99" => 70,"1.09" => 75,"1.19" => 80,"1.29" => 85,"1.49" => 90,"1.79" => 95,"1.99" => 96,"2.19" => 97,"2.39" => 98,"2.49" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $des["$currentValue"] = $eventEmitterValue;
        }
        return $des;
    }

    function getSu(){
        $sus = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 20,"0.32" => 35,"0.66" => 50,"0.99" => 60,"1.32" => 70,"1.66" => 75,"1.99" => 85,"2.66" => 90,"2.99" => 97,"3.32" => 98,"3.66" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $sus["$currentValue"] = $eventEmitterValue;
        }
        return $sus;
    }

    function getSua(){
        $suas = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 10,"0.13" => 15,"0.28" => 25,"0.42" => 35,"0.56" => 50,"0.70" => 55,"0.85" => 65,"0.99" => 70,"1.13" => 75,"1.28" => 80,"1.42" => 85,"1.56" => 90,"1.85" => 95,"2.13" => 96,"2.28" => 98,"2.42" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $suas["$currentValue"] = $eventEmitterValue;
        }
        return $suas;
    }

    function getIrpSi(){
        $irpsis = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 30,"0.07" => 45,"0.16" => 60,"0.24" => 70,"0.30" => 75,"0.41" => 80,"0.49" => 85,"0.66" => 90,"0.82" => 95,"1.07" => 96,"1.16" => 97,"1.41" => 98,"1.57" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $irpsis["$currentValue"] = $eventEmitterValue;
        }
        return $irpsis;
    }

    function getGlobal(){
        $globals = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 1,"0.01" => 3,"0.03" => 4,"0.05" => 5,"0.10" => 10,"0.15" => 15,"0.18" => 20,"0.25" => 25,"0.31" => 30,"0.35" => 35,"0.41" => 40,"0.45" => 45,"0.49" => 50,"0.55" => 55,"0.60" => 60,"0.65" => 65,"0.69" => 70,"0.73" => 75,"0.82" => 80,"0.96" => 85,"1.06" => 90,"1.30" => 95,"1.53" => 96,"1.57" => 97,"1.74" => 98,"1.84" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $globals["$currentValue"] = $eventEmitterValue;
        }
        return $globals;
    }

    function getNum(){
        $nums = [];
        $eventEmitterValue = 99;
        $currentRangeStart =50; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
           "0" => 3,"1" => 5,"3" => 10,"4" => 15,"6" => 20, "8" => 25,"9" => 30,"11" => 35,"12" => 40,"13" => 45,"14" => 50,"16" => 55,"17" => 60,"18" => 65,"19" => 70,"20" => 75,"22" => 80,"24" => 85,"26" => 90,"31" => 35,"33" => 96,"35" => 97,"36" => 98,"37" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $nums["$currentValue"] = $eventEmitterValue;
        }
        return $nums;
    }

    function getInt(){

        $ints = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 5,"1.06" => 10,"1.16" => 15,"1.24" => 20,"1.34" => 25,"1.43" => 30,"1.50" => 35,"1.56" => 40,"1.63" => 45,"1.69" => 50,"1.77" => 55,"1.83" => 60,"1.91" => 65,"1.99" => 70,"2.10" => 75,"2.17" => 80,"2.31" => 85,"2.44" => 90,"2.63" => 95,"2.74" => 96,"2.80" => 97,"2.89" => 98,"2.99" => 99
        ];
        for ($i = 0; $i <= 400; $i++) {
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitterValue = $newValue;
                }
            }
            // Asignar el valor al array de datos
            $ints["$currentValue"] = $eventEmitterValue;
        }
        return $ints;
    }
}