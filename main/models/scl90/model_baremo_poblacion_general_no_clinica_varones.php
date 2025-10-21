
<?php
class ModelSCLBaremoPoblacionGeneralVarones
{
    function getSOM(){
        $mags = [];
        $eventEmitter = [75,99];
        $currentRangeStart =4;
        $rangeStep = 0.01; // Incremento decimal

        $eventEmitterRanges = [
            "0.00" => [42, 20],
            "0.08" => [46, 35],
            "0.17" => [49, 45],
            "0.25" => [53, 60],
            "0.33" => [54, 65],
            "0.42"  => [55, 70],
            "0.50" => [57, 75],
            "0.58" => [58, 80],
            "0.62" => [60, 85],
            "0.67" => [63, 90],
            "0.92" => [67, 95],
            "1.33" => [70, 97],
            "1.53"    => [75, 99]
        ];



        for ($i = 0; $i <= 400; $i++) {
            
            $currentValue = round($currentRangeStart - ($i * $rangeStep), 2);
            foreach ($eventEmitterRanges as $rangeStart => $newValue) {
                // Verificar si el valor actual está en el rango
                if ($currentValue > round($rangeStart, 2)) {
                    $eventEmitter = $newValue;
                }
            }
            $value = number_format((float)$currentValue, 2);
            $mags["$value"] = $eventEmitter;
        }
        return $mags;
    }
}
