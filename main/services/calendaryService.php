<?php

require_once('../models/model_calendary.php');
class CalendaryService
{
    private $calendaryModel;

    public function __construct()
    {
        $this->calendaryModel = new Calendary_Model();
    }

    public function getAppointments(int $idUser,$search = '')
    {
        return $this->calendaryModel->getAll($idUser,$search);
    }

    public function saveAppointment($data)
    {
        $paciente = [
            'nombre' => $data['nombre_paciente'],
            'apellidos' => $data['apellido_paciente'],
            'sexo' => $data['sexo'],
            'telefono' => $data['telefono']
        ];

        $cita = [
            'id_user' => $data['idUser'],
            'date' => $data['date'],
            'hora' => $data['hora'],
            'nota' => $data['nota'],
            'duracion' => $data['duracion'],
            'color' => $data['color'],
            'estado' => $data['estado']
        ];

        return $this->calendaryModel->save($cita, $paciente);
    }

    public function deleteAppointment($id)
    {
        return $this->calendaryModel->delete($id);
    }

    public function updateAppointment($id, $data)
    {
        $paciente = [
            'nombre' => $data['nombre_paciente'],
            'apellidos' => $data['apellido_paciente'],
            'sexo' => $data['sexo'],
            'telefono' => $data['telefono']
        ];

        $cita = array_merge($data, ['id' => $id]);

        return $this->calendaryModel->update($cita, $paciente);
    }

    public function updateStatus($id, $status)
    {
        return $this->calendaryModel->updateStatus($id, $status);
    }
}
