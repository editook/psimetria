<?php
class Calendary_Model
{
    public function getEmpty()
    {
        return array(
            'id' => '',
            'id_patient' => '',
            'date' => '',
            'hora' => '',
            'nota' => '',
            'duracion' => '',
            'color' => '',
            'estado' => ''
        );
    }

    public function getById($id)
    {
        $query = "SELECT c.*, p.nombre, p.apellidos, p.sexo, p.telefono 
                  FROM calendary c 
                  JOIN paciente p ON c.id_patient = p.id 
                  WHERE c.id = $id";

        $con = new Connection();
        $result = $con->execute_query($query);

        if (mysqli_num_rows($result) > 0)
            return mysqli_fetch_assoc($result);
        else
            return null;
    }

    public function update($calendary, $paciente)
    {
        $con = new Connection();
        
        $queryCita = "UPDATE calendary 
                      SET date = '{$calendary['date']}', 
                          hora = '{$calendary['hora']}', 
                          nota = '{$calendary['nota']}', 
                          duracion = {$calendary['duracion']}, 
                          color = '{$calendary['color']}', 
                          estado = '{$calendary['estado']}' 
                      WHERE id = {$calendary['id']}";
        
        $queryPaciente = "UPDATE paciente 
                          SET nombre = '{$paciente['nombre']}', 
                              apellidos = '{$paciente['apellidos']}', 
                              sexo = '{$paciente['sexo']}', 
                              telefono = '{$paciente['telefono']}' 
                          WHERE id = {$calendary['id_patient']}";

        $res1 = $con->execute_query($queryCita);
        $res2 = $con->execute_query($queryPaciente);

        return ($res1 && $res2);
    }

    public function getAll($search = '')
    {
        $con = new Connection();
        $where = "";
        if ($search != '') {
            $searchEscaped = $con->getRealEscapeString($search);
            $where = " WHERE p.nombre LIKE '%$searchEscaped%' OR p.apellidos LIKE '%$searchEscaped%' ";
        }

        $query = "SELECT c.*, p.nombre, p.apellidos, p.sexo, p.telefono 
                  FROM calendary c 
                  JOIN paciente p ON c.id_patient = p.id 
                  $where";

        return mysqli_fetch_all($con->execute_query($query), MYSQLI_ASSOC);
    }

    public function save($calendary, $paciente)
    {
        $con = new Connection();

        // 1. Guardar Paciente
        $nombre = $con->getRealEscapeString($paciente['nombre']);
        $apellidos = $con->getRealEscapeString($paciente['apellidos']);
        $sexo = $con->getRealEscapeString($paciente['sexo']);
        $telefono = $con->getRealEscapeString($paciente['telefono']);

        $queryPaciente = "INSERT INTO paciente (nombre, apellidos, sexo, telefono) 
                          VALUES ('$nombre', '$apellidos', '$sexo', '$telefono')";

        if (!$con->execute_query($queryPaciente)) return false;
        $idPatient = $con->getLastInsertedID();

        // 2. Guardar Cita
        $date = $con->getRealEscapeString($calendary['date']);
        $hora = $con->getRealEscapeString($calendary['hora']);
        $nota = $con->getRealEscapeString($calendary['nota']);
        $duracion = (int)$calendary['duracion'];
        $color = $con->getRealEscapeString($calendary['color']);
        $estado = $con->getRealEscapeString($calendary['estado']);

        $queryCita = "INSERT INTO calendary (id_patient, date, hora, nota, duracion, color, estado) 
                      VALUES ($idPatient, '$date', '$hora', '$nota', $duracion, '$color', '$estado')";

        return $con->execute_query($queryCita);
    }

    public function delete($id)
    {
        $query = "DELETE FROM calendary WHERE id = $id";
        $con = new Connection();
        return $con->execute_query($query);
    }
}