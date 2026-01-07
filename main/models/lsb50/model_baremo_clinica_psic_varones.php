<?php
class ModelBaremoClinicaPsiVarones
{
    //BAREMO DE POBLACION CLINICA PSICOPATOLOGICA VARONES	
    function getMin(){
        $mins = [];
        $eventEmitterValue = 98;
        $currentRangeStart = 0.00;
        $rangeStep = 0.01; // Incremento decimal
        
        $eventEmitterRanges = [
            "0.12" => 95, "0.23" => 85, "0.36" => 80, "0.46" => 65, 
            "0.61" => 60, "0.71" => 50, "0.86" => 40, "0.96" => 30, 
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
            $value = number_format((float)$currentValue, 2);
            $mins["$value"] = $eventEmitterValue;
        }
        return $mins;
    }

    function getMag(){
        $mags = [];
        $eventEmitterValue = 99;
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal "" => 0,

        $eventEmitterRanges = [
           "0.00" => 10,"0.10" => 20,"0.24" => 30,"0.30" => 35,"0.45" => 45,"0.60" => 50,"0.70" => 55,"0.80" => 60,"0.90" => 65,"1.10" => 70,"1.20" => 75,"1.40" => 80,"1.70" => 85,"1.87" => 90,"2.20" => 95,"2.40" => 96, "2.70" => 97,"2.99" => 98,"3.40" => 99
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
        $rangeStep = 0.01; // Incremento decimal "" => 0,
        $eventEmitterRanges = [
            "0.00" => 2,"0.06" => 3,"0.13" => 10,"0.28" => 15,"0.35" => 20,"0.42" => 25,"0.56" => 30,"0.70" => 35,"0.85" => 40,"0.92" => 45,"1.06" => 50,"1.20" =>55,"1.35" => 60,"1.46" => 65,"1.75" => 70,"2.06" => 75,"2.28" => 80,"2.56" => 85,"2.70" => 90,"3.06" => 95,"3.20" => 96,"3.42" => 97, "3.49" => 98,"3.70" => 99
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
            "0.00" => 10,"0.13" => 15,"0.28" => 20,"0.42" => 30,"0.56" => 35,"0.70" => 40,"0.85" => 50,"0.99" => 55,"1.28" => 60,"1.42" => 65,"1.70" => 70,"1.99" => 75,"2.13" => 80,"2.42" => 85,"2.85" => 90,"3.13" => 95,"3.42" => 97,"3.56" => 98,"3.70" => 99
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
            "0.00" => 3,"0.13" => 10,"0.28" => 20,"0.42" => 25,"0.56" => 30,"0.70" => 35,"0.99" => 40,"1.13" => 45,"1.29" => 55,"1.42" => 60,"1.70" => 65,"1.85" => 70,"2.13" => 75,"2.42" => 80,"2.70" => 85,"2.85" => 90,"3.28" => 95,"3.42" => 98,"3.49" => 99,
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
            "0.00" => 1,"0.10" => 5,"0.21" => 20,"0.32" => 25,"0.43" => 30,"0.55" => 35,"0.66" => 40,"0.77" => 45,"0.99" => 50,"1.10" => 55,"1.21" => 60,"1.32" => 65,"1.43" => 70,"1.66" => 75,"1.77" => 80,"2.21" => 85,"2.43" => 90,"2.66" => 95,"2.88" => 96,"3.43" => 97,"3.55" => 98,"3.60" => 99
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
            "0.00" => 20,"0.16" => 25,"0.32" => 30,"0.49" => 40,"0.66" => 50,"0.82" => 55,"0.99" => 60,"1.16" => 65,"1.32" => 70,"1.66" => 75,"1.82" => 80,"2.16" => 85,"2.32" => 90,"2.49" => 95,"2.82" => 96,"2.99" => 97,"3.05" => 98,"3.16" => 99,
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
            "0.00" => 5,"0.12" => 15,"0.24" => 20,"0.37" => 25,"0.49" => 30,"0.62" => 35,"0.74" => 40,"0.87" => 45,"0.99" => 50,"1.12" => 55,"1.24" => 60,"1.37" => 65,"1.49" => 70,"1.62" => 75,"1.74" => 80,"1.87" => 85,"2.24" => 90,"2.49" => 95,"2.90" => 97,"2.99" => 99
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
            "0.00" => 2,"0.09" => 5,"0.19" => 10,"0.29" => 15,"0.39" => 20,"0.59" => 25,"0.69" => 30,"0.89" => 35,"1.09" => 40,"1.39" => 45,"1.49" => 50,"1.69" => 55,"1.79" => 60,"1.99" => 65,"2.09" => 70,"2.29" => 75,"2.39" => 80,"2.69" => 85,"2.79" => 90,"2.99" => 95,"3.29" => 97,"3.39" => 98,"3.49" =>99
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
        "0.00" => 10,"0.32" => 20,"0.66" => 25,"0.99" => 35,"1.32" => 50,"1.66" => 55,"1.99" => 60,"2.32" => 65,"2.66" => 75,"2.99" => 85,"3.32" => 90,"3.66" => 95,"3.70" => 99
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
            "0.00" => 3,"0.13" => 5,"0.28" => 10,"0.42" => 15,"0.56" => 20,"0.70" => 25,"0.99" => 30,"1.13" => 35,"1.28" => 45,"1.42" => 50,"1.70" => 55,"1.85" => 60,"1.99" => 65,"2.13" => 70,"2.28" => 75,"2.42" => 80,"2.70" => 85,"2.85" => 90,"3.13" => 95,"3.28" => 96,"3.42" => 98,"3.70" => 99
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
        "0.00" => 5,"0.07" => 20,"0.16" => 25,"0.32" => 30,"0.49" => 35,"0.66" => 40,"0.74" => 45,"0.82" => 50,"0.91" => 55,"1.07" => 60,"1.16" => 65,"1.24" => 70,"1.49" => 75,"1.82" => 80,"2.16" => 85,"2.41" => 90,"2.66" => 95,"2.91" => 96,"2.99" => 97,"3.16" => 99
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
        "0.00" => 1,"0.15" => 2,"0.20" => 3,"0.24" => 5,"0.39" => 10,"0.42" => 15,"0.46" => 20,"0.53" => 25,"0.63" => 30,"0.80" => 35,"0.98" => 40,"1.05" => 45,"1.15" => 50,"1.27" => 55,"1.30" => 60,"1.40" => 65,"1.61" => 70,"1.77" => 75,"1.93" => 80,"2.11" => 85,"2.37" => 90,"2.45" => 95,"2.80" => 97,"3.02" => 98,"3.15" => 99
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
        "0" => 1,"4" => 2,"6" => 3,"8" => 4,"9" => 5,"10" => 10,"13" => 15,"15" => 20,"18" => 25,"20" => 30,"21" => 35,"23" => 40,"25" => 45,"27" => 50,"29" => 55,"30" => 60,"31" => 65,"34" => 70,"36" => 75,"38" => 80,"39" => 85,"42" => 90,"45" => 95,"47" => 96,"48" => 98,"49" => 99
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
        "0.00" => 1,"1.02" => 2,"1.10" => 3,"1.13" => 4,"1.15" => 5,"1.20" => 10,"1.43" => 15,"1.50" => 20,"1.64" => 25,"1.70" => 30,"1.78" => 35,"1.91" => 40,"1.97" => 45,"2.06" => 50,"2.16" => 55,"2.30" => 60,"2.35" => 65,"2.45" => 70,"2.58" => 75,"2.68" => 80,"2.74" => 85,"2.90" => 90,"3.13" => 95,"3.29" => 96,"3.32" => 97,"3.45" => 98,"3.77" => 99,
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