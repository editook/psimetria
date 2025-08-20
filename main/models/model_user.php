<?php
class User_Model
{
    public function getEmpty()
    {
        $user = array(
            'id' => '',
            'name_user' => '',
            'type_user' => '',
            'active' => ''
        );
        return $user;
    }

    public function getById($id)
    {
        $query =
            "SELECT *
             FROM users
             WHERE id = $id ";

        $con = new Connection();
        $result = $con->execute_query($query);

        if( mysqli_num_rows($result) > 0)
            return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
        else
            return null;
    }

    //------------------------------------------------------------------
    public function getValidatedByLoginByPassword($login, $password)
    {
        if( empty($login) )
            return null;

        $con = new Connection();
        $login = $con->getRealEscapeString($login);
        $password = $con->getRealEscapeString($password);

        $query =
            "SELECT *
             FROM users
             WHERE name_user = '$login'";

        $result = $con->execute_query($query);

        if( mysqli_num_rows($result) > 0)
        {
            $user = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
            if( empty($user['password_user']) && empty($password) )
                return $user;
            else if( $this->_equalPasswords($password, $user['password_user'], base64_decode($user['salt_user'])) )
                return $user;
            else
                return null;
        }
        else
            return null;
    }

    private function _equalPasswords($userInputPassword, $userStoredPassword, $salt)
    {
        if (strcmp($userStoredPassword, $this->_getEncryptPassword($userInputPassword, $salt)) == 0)
            return true;

        return false;
    }

    private function _getSalt()
    {
        //return mcrypt_create_iv(30);
        return random_bytes(30);
    }

    private function _getEncryptPassword($password, $salt)
    {
        return hash('sha256', $salt . $password);
    }

    function updatePassword($idUser, $newPassword)
    {
        $con = new Connection();
        $newPassword = $con->getRealEscapeString($newPassword);

        $salt = $this->_getSalt();
        $encryptedPassword = $this->_getEncryptPassword($newPassword, $salt);

        $query =
            "UPDATE users
             SET password_user = '$encryptedPassword',
                salt_user = '". base64_encode($salt) ."'
            WHERE id = $idUser";

        return $con->execute_query($query);
    }
    //------------------------------------------------------------------
    public function getByNameExceptId($name, $exceptId='')
    {
        $con = new Connection();
        $name = $con->getRealEscapeString($name);

        $where = '';
        if( !empty($exceptId) )
            $where = " AND id <> $exceptId ";

        $query =
            "SELECT *
             FROM user
             WHERE name_user = '$name' 
             $where ";

        $con = new Connection();
        $result = $con->execute_query($query);

        if( mysqli_num_rows($result) > 0)
            return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
        else
            return null;
    }

    public function getAllByType($type)
    {
        $query =
            "SELECT *
             FROM users
             WHERE type_user = '$type'
             ORDER BY date_create ASC
             ";

        $con = new Connection();
        return mysqli_fetch_all($con->execute_query($query), MYSQLI_ASSOC);
    }

    public function getAll($limit=9999, $offset=0)
    {
        $query =
            "SELECT *
             FROM user
             ORDER BY name_user
             LIMIT $limit
             OFFSET $offset ORDER BY date_create ASC";

        $con = new Connection();
        return mysqli_fetch_all($con->execute_query($query), MYSQLI_ASSOC);
    }

    public function search($search, $limit=9999, $offset=0)
    {
        $query =
            "SELECT *
             FROM users
             WHERE name_user LIKE '%$search%'
             ORDER BY name_user
             LIMIT $limit
             OFFSET $offset";

        $con = new Connection();
        return mysqli_fetch_all($con->execute_query($query), MYSQLI_ASSOC);
    }

    public function save($fullname, $name_user, $password)
    {
        $con = new Connection();
        $name_user = $con->getRealEscapeString($name_user);
        $fullname = $con->getRealEscapeString($fullname);
        $password = $con->getRealEscapeString($password);

        $salt = $this->_getSalt();
        $encryptedPassword = $this->_getEncryptPassword($password, $salt);


        $query =
            "INSERT INTO `users` (`id`, `full_name`, `name_user`, `password_user`, `salt_user`, `type_user`, `date_create`, `active`) 
            VALUES (NULL, '$fullname', '$name_user', '$encryptedPassword', '". base64_encode($salt)."', 'CLIENTE', current_timestamp(), '1')";

        if($con->execute_query($query))
            return $con->getLastInsertedID();
        return false;
    }

    public function update($id, $full_name, $name_user, $active)
    {
        $con = new Connection();
        $full_name = $con->getRealEscapeString($full_name);
        $name_user = $con->getRealEscapeString($name_user);
        $active = $con->getRealEscapeString($active);

        $query =
            "UPDATE users
             SET full_name       = '$full_name',
                 name_user       = '$name_user',
                 active      = '$active'
            WHERE id = $id";

        return $con->execute_query($query);
    }

    public function delete($id)
    {
        $query = "DELETE FROM users WHERE id = $id ";

        $con = new Connection();
        return $con->execute_query($query);
    }
}