<?php
class Register_Model
{
    function getDeviceType(){
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');

        // Tablets
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobile))/i', $userAgent)) {
            return 'tablet';
        }

        // Móviles
        if (preg_match('/(mobile|iphone|ipod|android.*mobile|blackberry|opera mini|windows phone)/i', $userAgent)) {
            return 'mobile';
        }

        // Escritorio
        return 'desktop';
    }
    function getRandomCipherMethod() {
        $algorithms = ['AES'];
        $keySizes = [128, 192, 256];
        $modes = ['CBC', 'CFB', 'OFB', 'CTR', 'GCM'];

        $algorithm = $algorithms[array_rand($algorithms)];
        $keySize = $keySizes[array_rand($keySizes)];
        $mode = $modes[array_rand($modes)];

        return "{$algorithm}-{$keySize}-{$mode}";
    }
    function getKeyEncripter(){
        return "092V3E23J893EJ92C823";
    }
    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    function base64url_decode($data) {
        $padding = 4 - (strlen($data) % 4);
        if ($padding < 4) {
            $data .= str_repeat('=', $padding);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }
    function encriptar($dato, $clave) {
        $metodo = "AES-256-CBC";
        $ivLongitud = openssl_cipher_iv_length($metodo);
        $iv = openssl_random_pseudo_bytes($ivLongitud);
        $claveHash = hash('sha256', $clave, true);

        $datoEncriptado = openssl_encrypt($dato, $metodo, $claveHash, OPENSSL_RAW_DATA, $iv);

        // Combina IV + encriptado y codifica en base64 url-safe
        return $this->base64url_encode($iv . $datoEncriptado);
    }
    
    function desencriptar($datoCodificado, $clave) {
        $metodo = "AES-256-CBC";
        $ivLongitud = openssl_cipher_iv_length($metodo);
        $claveHash = hash('sha256', $clave, true);

        $datoBinario = $this->base64url_decode($datoCodificado);
        $iv = substr($datoBinario, 0, $ivLongitud);
        $datoEncriptado = substr($datoBinario, $ivLongitud);

        return openssl_decrypt($datoEncriptado, $metodo, $claveHash, OPENSSL_RAW_DATA, $iv);
    }
    /*$datoEncriptado = encriptar($datoOriginal, $clave);
echo "Dato encriptado: " . $datoEncriptado . PHP_EOL;

// Desencriptar el dato
$datoDesencriptado = desencriptar($datoEncriptado, $clave);
echo "Dato desencriptado: " . $datoDesencriptado . PHP_EOL;*/
    public function getById($idUser,$id)
    {
        $query =
        "SELECT client.*,baremo.name,type_question.name as type_question_name,users.full_name as evaluador, type_question.type_show_result as is_show_result
            FROM client
            INNER JOIN baremo
            ON client.baremo_id = baremo.id
             INNER JOIN users
             ON client.belong_id = users.id
            INNER JOIN type_question
            ON client.id_type_question = type_question.id
            where client.id = $id and client.belong_id = $idUser";

        $con = new Connection();
        $result = $con->execute_query($query);

        if( mysqli_num_rows($result) > 0)
            return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
        else
            return null;
    }

    public function getAll($idUser = '',$search = '')
    {
        $query =
            "SELECT client.*,baremo.name,type_question.name as type_question_name
                FROM client
                INNER JOIN baremo
                ON client.baremo_id = baremo.id
                INNER JOIN type_question
                ON client.id_type_question = type_question.id
                where client.belong_id = $idUser";

        if ($search !== "") {
            $query .= " AND (client.id_client LIKE '%$search%' OR type_question.name LIKE '%$search%')";
        }
        $query .= " ORDER BY client.date_create";
        //si es null obtiene todos
        if($idUser == '' && $search == ''){
            $query = "SELECT * FROM client";
        }
        $con = new Connection();
        return mysqli_fetch_all($con->execute_query($query), MYSQLI_ASSOC);
    }

    public function getTotalCompleted($belong_id='',$status='TERMINADO'){
        $where = "";
        if($belong_id!=''){
            $where = " and belong_id='$belong_id'";
        }
        $query = "select count(*) as total FROM client where status = '$status' $where";
        $con = new Connection();
        $result = $con->execute_query($query);

        if( mysqli_num_rows($result) > 0)
            return mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
        else
            return "";
    }

    public function save($belong_id, $id_client, $age, $sex,$baremo_id,$id_type_question,$hash)
    {
        $con = new Connection();
        $belong_id = $con->getRealEscapeString($belong_id);
        $id_client = $con->getRealEscapeString($id_client);
        $age = $con->getRealEscapeString($age);
        $sex = $con->getRealEscapeString($sex);
        $baremo_id = $con->getRealEscapeString($baremo_id);

        $query =
            "INSERT INTO `client` (`id`, `belong_id`, `id_client`, `age`, `sex`, `baremo_id`, `status`, `date_create`,`id_type_question`,`codes`)
             VALUES (NULL, '$belong_id', '$id_client', '$age', '$sex', '$baremo_id', 'PENDIENTE', current_timestamp(),$id_type_question,'$hash')";
       
        if($con->execute_query($query))
            return $con->getLastInsertedID();
        return false;
    }

    public function updateStatus($idUser,$idPatient,$status){
        $con = new Connection();

        $query =
            "UPDATE client
             SET `status`       = '$status'
            WHERE belong_id = $idUser and id=$idPatient";

        return $con->execute_query($query);
    }

    public function updateStatusShowResult(int $id_type,int $status){
        $con = new Connection();

        $query =
            "UPDATE type_question
             SET `type_show_result`       = '$status'
            WHERE id = $id_type ";

        return $con->execute_query($query);
    }

    public function updateClient($id,$id_client,$age,$sex,$id_type_question,$baremo_id){
        
         $con = new Connection();
        $query =
            "UPDATE client
             SET `id_client` = '$id_client',`age`= '$age',`sex`= '$sex',`id_type_question` = '$id_type_question',`baremo_id` = '$baremo_id'
            WHERE id=$id";
    
        return $con->execute_query($query);
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
        $con = new Connection();
        echo $id;
        $query_answer = "DELETE FROM answer WHERE client_id = $id";
        $data =  $con->execute_query($query_answer);

        $query = "DELETE FROM maci_input WHERE id_client = $id ";
        $data = $con->execute_query($query);

        $query = "DELETE FROM client WHERE id = $id ";
        return $con->execute_query($query);

    }
}