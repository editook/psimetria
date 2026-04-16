<?php
class ModelConfiguration {
    public function sumatoria($answers,$options,$result){
        $total = 0;
        foreach($answers as $answer){
            foreach($options as $option){
                if($answer['item_order'] == $option){
                    $total += ((int)$answer['response'])==$result?1:0;
                }
            }
        }
        return $total;
    }
    
    public function getQuestion($answers,$item_order){
        foreach($answers as $answer){
            if($answer['item_order'] == $item_order){
                return $answer['response'];
            }
        }
        return "";
    }
    public function getByItemOrder($answers,$item_order){

        foreach($answers as $answer){
            if($answer['item_order'] == $item_order){
                return $answer;
            }
        }
        return [];
    }
}
