<?php
class ModelConfiguration
{
    public function sumatoria($answers, $options, $result)
    {
        $total = 0;
        foreach ($answers as $answer) {
            foreach ($options as $option) {
                if ($answer['item_order'] == $option && $answer['response'] !== null) {
                    $total += ((int)$answer['response']) == $result ? 1 : 0;
                }
            }
        }
        return $total;
    }

    public function getValueResponseOfQuestion($answers, $item_order)
    {
        foreach ($answers as $answer) {
            if ($answer['item_order'] == $item_order && $answer['response'] !== null) {
                return $answer['response'];
            }
        }
        return (string)random_int(5647, 1483647 + $item_order); //valor aleatorio para que no exista null iguales
    }
    public function getByItemOrder($answers, $item_order)
    {

        foreach ($answers as $answer) {
            if ($answer['item_order'] == $item_order) {
                return $answer;
            }
        }
        return [];
    }
}
