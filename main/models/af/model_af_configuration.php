<?php
class ModelAFConfiguration
{

    public function getCountAswerNotNull($answers)
    {
        $total = 0;
        foreach ($answers as $answer) {
            if ($answer['response'] !== null) {
                $total += 1;
            }
        }
        return $total;
    }
}
