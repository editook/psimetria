<?php
class Question_Model
{

    public function getById($id)
    {
        $query =
            "SELECT *
             FROM question
             WHERE id = $id ";

        $con = new Connection();
        $result = $con->execute_query($query);

        if( mysqli_num_rows($result) > 0)
            return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
        else
            return null;
    }

    public function getAll($id_type_question,$hash='')
    {
      if($hash != ''){
        $hash = "'codes' = '$hash' and"; 
      }
        $query =
            "SELECT *
             FROM question where $hash type_question_id = $id_type_question order by item_order asc
             ";
    
        echo $query;
        $con = new Connection();
        return mysqli_fetch_all($con->execute_query($query), MYSQLI_ASSOC);
    }

    
    public function getAllTypeQuestion(){
        $query =
            "SELECT *
             FROM type_question
             ";

        $con = new Connection();
        return mysqli_fetch_all($con->execute_query($query), MYSQLI_ASSOC);
    }
    public function save($name, $type, $email, $login)
    {
        $con = new Connection();
        $name = $con->getRealEscapeString($name);
        $type = $con->getRealEscapeString($type);
        $email = $con->getRealEscapeString($email);
        $login = $con->getRealEscapeString($login);

        $query =
            "INSERT INTO user (name_user, type_user, email_user, login_user)
            VALUES ('$name', '$type', '$email', '$login');";

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
            "UPDATE user
             SET name_user       = '$name',
                 type_user       = '$type',
                 email_user      = '$email',
                 login_user      = '$login'
            WHERE id_user = $id";

        return $con->execute_query($query);
    }

    public function delete($id)
    {
        $query = "DELETE FROM user WHERE id_user = $id ";

        $con = new Connection();
        return $con->execute_query($query);
    }
}