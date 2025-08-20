<?php
class Baremo_Model
{
   

    public function getById($id)
    {
        $query =
            "SELECT *
             FROM baremo
             WHERE id = $id";

        $con = new Connection();
        $result = $con->execute_query($query);

        if( mysqli_num_rows($result) > 0)
            return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
        else
            return null;
    }

    public function getAll($id = '')
    {
        $where = "";
        if($id != ''){
            /*const rangos = {
					1: [1, 4],
					2: [5, 37],
					3: [38, 45]
				};
            */
            if($id == '1'){
                $where = " where id>=1 and id<=4";
            }
            if($id == '2'){
                $where = " where id>=5 and id<=37";
            }
            if($id == '3'){
                $where = " where id>=38 and id<=45";
            }
            
        }
        $query =
            "SELECT *
             FROM baremo $where
             ";

        $con = new Connection();
        return mysqli_fetch_all($con->execute_query($query), MYSQLI_ASSOC);
    }

    public function save($question_id, $client_id, $response,$hash)
    {
        $con = new Connection();
        $question_id = $con->getRealEscapeString($question_id);
        $client_id = $con->getRealEscapeString($client_id);
        $response = $con->getRealEscapeString($response);

        $query =
            "INSERT INTO `baremo` (`id`, `question_id`, `client_id`, `response`, `hash`) 
            VALUES (NULL, '$question_id', '$client_id', '$response','$hash')";

        if($con->execute_query($query))
            return $con->getLastInsertedID();
        return false;
    }
    
    public function update($id, $name, $type, $email, $login)
    {
        $con = new Connection();
        $name = $con->getRealEscapeString($name);
        $type = $con->getRealEscapeString($type);
        $email = $con->getRealEscapeString($email);
        $login = $con->getRealEscapeString($login);

        $query =
            "UPDATE baremo
             SET name_user       = '$name',
                 type_user       = '$type',
                 email_user      = '$email',
                 login_user      = '$login'
            WHERE id_user = $id";

        return $con->execute_query($query);
    }

    public function delete($id)
    {
        $query = "DELETE FROM baremo WHERE id_user = $id ";

        $con = new Connection();
        return $con->execute_query($query);
    }
}