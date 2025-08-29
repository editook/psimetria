<?php
class ModelBaremoPobGralVarones
{
    //BAREMO DE POBLACION GENERAL VARONES
    function getMin(){
        $mins = [];
        $eventEmitterValue = 97;
        $currentRangeStart = 0.00;
        $rangeStep = 0.01; // Incremento decimal
        $eventEmitterRanges = [
            "0.12" => 95, "0.23" => 85, "0.36" => 80, "0.46" => 65, 
            "0.65" => 60, "0.71" => 50, "0.86" => 40, "0.96" => 30, 
            "1.11" => 25, "1.21" => 20, "1.45" => 15, "1.61" => 10, 
            "1.81" => 5, "2.06" => 4, "2.21" => 3, "2.41" => 2, 
            "2.56" => 1
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
            "0.00" => 10,"0.10" => 20,"0.24" => 30,"0.30" => 35,"0.45" => 35,"0.61" => 55,"0.80" => 60,"0.90" => 65,"1.10" => 70,"1.20" => 75,"1.40" => 80,"1.70" => 85,"1.97" => 90,"2.20" => 95,"2.40" => 96,"2.70" => 97,"2.99" => 98,"3.40" => 99
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
            "0.00" => 10,"0.05" => 15,"0.13" => 25,"0.20" => 35,"0.28" => 45,"0.35" => 50,"0.42" => 55,"0.49" => 60,"0.56" => 65,"0.63" => 70,"0.70" => 75,"0.78" => 80,"0.85" => 85,"0.99" => 90,"1.13" => 95,"1.35" => 96,"1.49" => 97,"1.56" => 98,"1.81" => 99
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
            "0.00" => 30,"0.13" => 45,"0.28" => 65,"0.42" => 70,"0.56" => 75,"0.70" => 80,"0.85" => 85,"0.99" => 90,"1.13" => 95,"1.28" => 96,"1.42" => 97,"1.56" => 98,"2.85" => 99
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
            "0.00" => 15,"0.13" => 25,"0.28" => 45,"0.42" => 55,"0.56" => 60,"0.70" => 70,"0.85" => 75,"0.99" => 80,"1.13" => 85,"1.28" => 90,"1.56" => 95,"1.70" => 96,"1.85" => 97,"1.99" => 98,"2.28" => 99
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
            "0.00" => 30,"0.10" => 50,"0.21" => 70,"0.32" => 80,"0.43" => 85,"0.55" => 90,"0.77" => 95,"0.86" => 96,"0.99" => 97,"1.21" => 98,"1.32" => 99
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
           "0.00" => 30,"0.16" => 45,"0.32" => 65,"0.49" => 70,"0.66" => 80,"0.82" => 85,"0.99" => 90,"1.32" => 95,"1.39" => 96,"1.49" => 97,"1.66" => 98,"1.99" => 99
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
            "0.00" => 20,"0.12" => 35,"0.24" => 50,"0.37" => 60,"0.49" => 70,"0.62" => 75,"0.75" => 80,"0.87" => 85,"0.90" => 90,"1.24" => 95,"1.62" => 96,"1.74" => 97,"1.99" => 98,"2.24" => 99
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
            "0.00" => 10,"0.10" => 20,"0.19" => 35,"0.29" => 45,"0.39" => 50,"0.49" => 60,"0.59" => 70,"0.69" => 75,"0.79" => 80,"0.89" => 85,"1.09" => 90,"1.49" => 95,"1.59" => 96,"1.69" => 97,"1.79" => 98,"1.99" => 99
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
            "0.00" => 30,"0.32" => 50,"0.60" => 65,"0.99" => 75,"1.32" => 85,"1.99" => 90,"2.32" => 95,"2.66" => 96,"2.99" => 98,"3.66" => 99
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
            "0.00" => 15,"0.13" => 30,"0.48" => 45,"0.42" => 60,"0.56" => 70,"0.70" => 75,"0.85" => 80,"0.99" => 85,"1.13" => 90,"1.56" => 95,"1.62" => 96,"1.70" => 97,"1.85" => 98,"2.28" => 99
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
            "0.00" => 35,"0.07" => 50,"0.16" => 70,"0.24" => 80,"0.32" => 85,"0.41" => 90,"0.66" => 95,"0.74" => 96,"0.82" => 97,"0.91" => 98,"1.16" => 99
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
            "0.00" => 1,"0.01" => 3,"0.03" => 4,"0.05" => 5,"0.09" => 10,"0.12" => 15,"0.17" => 17,"0.18" => 25,"0.21" => 30,"0.25" => 35,"0.30" => 40,"0.32" => 45,"0.36" => 50,"0.38" => 55,"0.43" => 60,"0.50" => 65,"0.52" => 70,"0.59" => 75,"0.63" => 80,"0.71" => 85,"0.85" => 90,"1.06" => 95,"1.19" => 96,"1.30" => 97,"1.38" => 98,"1.50" => 99
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
        $rangeStep = 1; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0" => 3,"1" => 5,"3" => 10,"4" => 15,"5" => 20,"6" => 25,"7" => 30,"8" => 35,"9" => 40,"10" => 45,"11" => 50,"12" => 55,"13" => 60,"14" => 65,"15" => 70,"18" => 75,"19" => 80,"22" => 85,"24" => 90,"28" => 95,"31" => 96,"33" => 97,"35" => 98,"36" => 99
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
            "0.00" => 10,"1.10" => 15,"1.12" => 20,"1.20" => 25,"1.25" => 30,"1.32" => 35,"1.37" => 40,"1.43" => 45,"1.49" => 50,"1.55" => 55,"1.61" => 60,"1.67" => 65,"1.77" => 70,"1.85" => 75,"1.99" => 80,"2.12" => 85,"2.20" => 90,"2.35" => 95,"2.49" => 96,"2.59" => 97,"2.70" => 98,"2.99" => 99
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