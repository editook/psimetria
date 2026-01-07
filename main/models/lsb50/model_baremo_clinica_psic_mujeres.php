<?php
class ModelBaremoClinicaPsiMujeres
{
    //BAREMO DE POBLACION CLINICA PSICOPATOLOGICA MUJERES	
    function getMin(){
        $mins = [];
        $eventEmitterValue = 97;
        $currentRangeStart = 0.00;
        $rangeStep = 0.01; // Incremento decimal "" => 0
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
            $value = number_format((float)$currentValue, 2);
            $mins["$value"] = $eventEmitterValue;
        }
        return $mins;
    }

    function getMag(){
        $mags = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => 5,"0.11" => 10,"0.21" => 15,"0.31" => 20,"0.46" => 25,"0.61" => 30,
            "0.66" => 35,"0.71" => 40,"0.81" => 45,"0.91" => 50,"1.11" => 55,"1.21" => 60,
            "1.36" => 65,"1.46" => 70,"1.71" => 75, "1.88" => 80,"1.96" => 85,"2.31" => 90,
            "2.81" => 95, "3.01" => 96, "3.21" => 97, "3.31" => 98, "3.46" => 99
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
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitterValue;
        }
        return $mags;
    }

    function getPr(){
        $prs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal
        $eventEmitterRanges = [
            "0.00" =>2 , "0.13" => 3,"0.28" => 4,"0.35" => 5,"0.42" => 10,"0.56" => 15,"0.65" => 20,"0.85" => 25,"1.06" => 30,"1.13" => 35,"1.28" => 40,"1.35" => 45,"1.49" => 50,"1.65" => 55,"1.70" => 60,"1.85" => 65,"1.92" => 70,"2.20" => 75,"2.28" => 80,"2.49" => 85,"2.63" => 90, "3.17" => 95, "3.49" => 96,"3.56" => 97,"3.85" => 98,"3.92" => 99
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
            $value = number_format((float)$currentValue, 2);
            $prs["$value"] = $eventEmitterValue;
        }
        return $prs;
    }

    function getHp(){
        $hps = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 5, "0.28" => 10,"0.56" => 15,"0.70" => 20,"0.82" => 25,"0.85" => 30,"1.33" => 35,"1.13" => 45,"1.42" => 55,"1.56" => 60,"1.70" => 65,"1.85" => 70,"1.99" => 75,"2.28"=>80,"2.56" => 85,"2.85" => 90,"3.28" => 95,"3.56" => 96,"3.70" => 97,"3.85" => 98,"3.90" => 99
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
            $value = number_format((float)$currentValue, 2);
            $hps["$value"] = $eventEmitterValue;
        }
        return $hps;
    }

    function getOb(){
        $obs = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 2,"0.13" => 3,"0.28" => 5,"0.42" => 10,"0.56" => 15,"0.70" => 20,"0.85" => 25,"0.99" => 30,"1.13" => 35,"1.16" => 40,"1.28" => 45,"1.56" => 50,"1.70" => 55,"1.85" => 60,"1.99" => 65,"2.28" => 70,"2.32" => 75,"2.56" => 80,"2.70" => 85,"2.99" => 90,"3.28" => 95,"3.56" => 96,"3.70" => 97,"3.85" => 99
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
            $value = number_format((float)$currentValue, 2);
            $obs["$value"] = $eventEmitterValue;
        }
        return $obs;
    }

    function getAn(){
        $ans = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 1,"0.10" => 3,"0.21" => 5,"0.32" => 10,"0.43" => 15,"0.55" => 20,"0.66" => 25,"0.77" => 30,"0.88" => 35,"0.99" => 40,"1.10" =>45,"1.21" => 50,"1.32" => 55,"1.43" => 60,"1.66" => 65,"1.88" => 70,"1.99" => 75,"2.21" => 80,"2.66" => 85,"2.99" => 90,"3.55" => 95,"3.74" => 96,"3.77" => 97,"3.80" => 99
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
            $value = number_format((float)$currentValue, 2);
            $ans["$value"] = $eventEmitterValue;
        }
        return $ans;
    }

    function getHs(){
        $hss = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 15,"0.16" => 20,"0.32" => 25,"0.49" => 35,"0.66" => 45,"0.82" => 50,"0.99" => 55,"1.16" => 60,"1.32" => 65,"1.66" => 70,"1.82" => 75,"2.16" => 80,"2.32" => 85,"2.49" => 90,"3.16" => 95,"3.66" => 96,"3.74" => 97,"3.82" => 99,
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
            $value = number_format((float)$currentValue, 2);
            $hss["$value"] = $eventEmitterValue;
        }
        return $hss;
    }

    function getSm(){
        $sms = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 2,"0.12" => 4,"0.24" => 5,"0.37" => 10,"0.62" => 15,"0.82" => 20,"0.99" => 25,"1.12" => 35,"1.37" => 40,"1.49" => 45,"1.62" => 50,"1.74" =>55,"1.87" => 60,"2.12" => 65,"2.24" => 70,"2.49" => 75,"2.62" => 80,"2.74" => 85,"3.29" => 90,"3.37" => 95,"3.49" => 97,"3.62" => 98,"3.77" => 99
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
            $value = number_format((float)$currentValue, 2);
            $sms["$value"] = $eventEmitterValue;
        }
        return $sms;
    }

    function getDe(){
        $des = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 1,"0.25" => 2,"0.29" => 3,"0.39" => 5,"0.59" => 10,"1.79" => 15,"1.89" => 20,"1.19" => 25,"1.39" => 30,"1.59" => 35,"1.69" => 40,"1.89" => 45,"1.99" => 50,"2.09" => 55,"2.29" => 60,"2.39" => 65,"2.49" => 70,"2.69" => 75,"2.79" => 80,"2.89" => 85,"3.29" => 90,"3.59" => 95,"3.69" => 96,"3.79" => 98,"3.89" => 99
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
            $value = number_format((float)$currentValue, 2);
            $des["$value"] = $eventEmitterValue;
        }
        return $des;
    }

    function getSu(){
        $sus = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
        "0.00" => 5,"0.32" => 15,"0.66" => 20,"0.99" => 25,"1.32" => 30,"1.66" => 35,"1.99" => 45,"2.32" => 50,"2.66" => 55,"2.99" => 65,"3.32" => 75,"3.66" => 80,"3.70" => 99
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
            $value = number_format((float)$currentValue, 2);
            $sus["$value"] = $eventEmitterValue;
        }
        return $sus;
    }

    function getSua(){
        $suas = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 1,"0.13" => 3,"0.27" => 4,"0.32" => 5,"0.56" => 10,"1.99" => 15,"1.13" => 20,"1.42" => 25,"1.56" => 30,"1.66" => 35,"1.70" => 40, "1.85" => 45,"1.99" => 50, "2.28" => 55,"2.42" => 60, "2.56" => 65,"2.85" => 70,"2.99" => 75,"3.13" => 80,"3.28" => 85,"3.42" => 90,"3.70" => 95,"3.85" => 97,"3.90" => 99
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
            $value = number_format((float)$currentValue, 2);
            $suas["$value"] = $eventEmitterValue;
        }
        return $suas;
    }

    function getIrpSi(){
        $irpsis = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
        "0.00" => 4,"0.07" => 5,"0.24" => 10,"0.41" => 15,"0.49" => 20,"0.57" => 25,"0.74" => 30,"0.91" => 35,"0.99" => 40,"1.16" => 45,"1.24" => 50,"1.32" => 55,"1.41" => 60,"1.57" => 65,"1.66" => 70,"1.82" => 75,"1.99" => 80,"2.24" => 85,"2.57" => 90,"3.24" => 95,"3.49" => 97,"3.66" => 99
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
            $value = number_format((float)$currentValue, 2);
            $irpsis["$value"] = $eventEmitterValue;
        }
        return $irpsis;
    }

    function getGlobal(){
        $globals = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
        "0.00" => 1,"0.24" => 2,"0.29" => 3,"0.40" => 4,"0.47" => 5,"0.53" => 10,"0.67" => 15,"0.87" => 20,"1.08" => 25,"1.19" => 30,"1.29" => 35,"1.38" => 40,"1.45" => 45,"1.53" => 50,"1.72" => 55,"1.81" => 60,"1.93" => 65,"2.02" => 70,"2.14" => 75,"2.26" => 80,"2.44" => 85,"2.70" => 90,"2.95" => 95,"3.20" => 96,"3.35" => 97,"3.45" => 98,"3.75" => 99
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
            $value = number_format((float)$currentValue, 2);
            $globals["$value"] = $eventEmitterValue;
        }
        return $globals;
    }

    function getNum(){
        $nums = [];
        $eventEmitterValue = 99;
        $currentRangeStart =50; 
        $rangeStep = 1; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
        "0" => 1,"8" => 2,"11" => 3,"12" => 5,"13" => 10,"19" => 15,"21" => 20,"23" => 25,"25" => 30,"26" => 35,"28" => 40,"31" => 50,"33" => 55,"34" => 60,"36" => 65,"38" => 70,"39" => 75,"40" => 80,"41" => 85,"44" => 90,"46" => 95,"47" => 96,"48" => 98,"49" => 99
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
            $value = number_format((float)$currentValue, 2);
            $nums["$value"] = $eventEmitterValue;
        }
        return $nums;
    }

    function getInt(){

        $ints = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4; 
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
        "0.00" => 1,"1.20" => 2,"1.26" => 3,"1.33" => 4,"1.37" => 5,"1.53" => 10,"1.75" => 15,"1.86" => 20,"1.96" => 25,"2.10" => 30,"2.19" => 35,"2.27" => 40,"2.37" => 45,"2.45" => 50,"2.58" => 55,"2.68" => 60,"2.75" => 65,"2.79" => 70,"2.91" => 75,"3.05" => 80,"3.19" => 85,"3.27" => 90,"3.46" => 95,"3.58" => 96,"3.65" => 97,"3.67" => 98,"3.79" => 99
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
            $value = number_format((float)$currentValue, 2);
            $ints["$value"] = $eventEmitterValue;
        }
        return $ints;
    }
}