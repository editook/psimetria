<?php
class Answer_Model
{
  

    public function generateRandomKey() {
        $chars = '0123456789abcdef'; // Caracteres hexadecimales
        $key = sprintf(
            '%s-%s-%s-%s-%s',
            substr(str_shuffle(str_repeat($chars, 8)), 0, 8),  // 8 caracteres
            substr(str_shuffle(str_repeat($chars, 4)), 0, 4),  // 4 caracteres
            substr(str_shuffle(str_repeat($chars, 4)), 0, 4),  // 4 caracteres
            substr(str_shuffle(str_repeat($chars, 4)), 0, 4),  // 4 caracteres
            substr(str_shuffle(str_repeat($chars, 12)), 0, 12) // 12 caracteres
        );
        return $key;
    }

    public function sumatoria($answers,$options){
        $total = 0;
        foreach($answers as $answer){
            foreach($options as $option){
                if($answer['item_order'] == $option){
                    $total += (int)$answer['response'];
                }
            }
        }
        return $total;
    }

    public function sumatoriaMaci($answers,$array,$compare){
        $total = 0;
        foreach($array as $option => $value){
            foreach($answers as $answer){
                if($answer['item_order'] == $option){
                    $sum = 0;
                    if(intval($answer['response']) == $compare){
                        $sum = $value;
                    }
                    //echo $answer['item_order'].'='.$sum.'<br>';
                    $total += $sum;
                    break;
                }
            }
        }
        return $total;
    }

    public function getValueModel($answers,$value){
        
        foreach($answers as $asnwer){
            if($asnwer['item_order'] == $value){
                return (int)$asnwer['response'];
            }
        }
        return 0;
    }
    public function ocurrencias($answers,$indice){
        $total = 0;
        foreach($answers as $asnwer){
            if((int)$asnwer['response'] == $indice){
                $total += 1;
            }
        }
        return $total;
    }

    public function getById($id)
    {
        $query =
            "SELECT *
             FROM answer
             WHERE id = $id ";

        $con = new Connection();
        $result = $con->execute_query($query);

        if( mysqli_num_rows($result) > 0)
            return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
        else
            return null;
    }

    public function getMaciInputProblem($id_client){
        $query =
            "SELECT *
             FROM maci_input
             WHERE id_client = '$id_client' ";

        $con = new Connection();
        $result = $con->execute_query($query);

        if( mysqli_num_rows($result) > 0)
            return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
        else
            return null;
    }

    public function maciUpdateProblem($response_data,$id_client){
        $con = new Connection();
        $response = $this->getMaciInputProblem($id_client);
        $response_data = $con->getRealEscapeString($response_data);
        $id_client = $con->getRealEscapeString($id_client);
        
        $query =
            "INSERT INTO `maci_input` (`id_maci_input`, `response_data`, `id_client`) 
            VALUES (NULL, '$response_data', $id_client )";

        if($response != null){
            $query =
                "UPDATE maci_input
                SET 
                    response_data      = '$response_data'
                WHERE id_client       = $id_client";
        
        }
        echo $query;
        return $con->execute_query($query);
    }
    
    public function getAll($hash = '',$limitInit = 0, $limitOrder = 0)
    {
        $limitquery = "";
        $order = "";
        if($limitOrder > 0 && $limitInit > 0){
            $limitquery = "AND question.item_order >= $limitInit AND question.item_order <= $limitOrder";
        }
        if($hash != ''){
            $hash = "INNER JOIN question ON question.id = answer.question_id where codes = '$hash' ";
            $order = "order by question.item_order ASC";
        }
        $query =
            "SELECT *
             FROM  answer $hash $limitquery $order
             "; 
             
        $con = new Connection();
        return mysqli_fetch_all($con->execute_query($query), MYSQLI_ASSOC);
    }

    public function getAnswersTop($codes){
        $query =
            "select GROUP_CONCAT(question.question SEPARATOR ', ') AS response from answer INNER JOIN question ON question.id = answer.question_id where answer.codes = '$codes' and response='4';";

        $con = new Connection();
        $result = $con->execute_query($query);

        if( mysqli_num_rows($result) > 0)
            return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
        else
            return "";
    }
    public function save($question_id, $client_id,$hash)
    {
        $con = new Connection();
        $question_id = $con->getRealEscapeString($question_id);
        $client_id = $con->getRealEscapeString($client_id);
        $query =
            "INSERT INTO `answer` (`id`, `question_id`, `client_id`, `codes`, `response`) 
            VALUES (NULL, '$question_id', $client_id,'$hash', NULL )";
      
        if($con->execute_query($query))
            return $con->getLastInsertedID();
        return false;
    }
    
    public function update($question_id, $client_id,$response,$codes)
    {
        $con = new Connection();

        $query =
            "UPDATE answer
             SET 
                 response      = $response
            WHERE question_id       = $question_id and
                 client_id       = $client_id and
                 codes      = '$codes' ";
     
        return $con->execute_query($query);
    }

    public function checkStatus($codes){
        $con = new Connection();

        $query =
            "SELECT count(*) as count FROM answer
            WHERE codes = '$codes' and response is NULL";
        $result = $con->execute_query($query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
    }

    public function delete($id)
    {
        $query = "DELETE FROM user WHERE id_user = $id ";

        $con = new Connection();
        return $con->execute_query($query);
    }
}