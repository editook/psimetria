<?php
require_once('../configs.php');
require_once('../connection.php');
require_once('../models/model_calendary.php');
require_once('../services/calendaryService.php');

header('Content-Type: application/json');

$service = new CalendaryService();

$action = $_REQUEST['action'] ?? 'list';

if ($action === 'list') {
    $search = $_GET['search'] ?? '';
    $idUser = $_GET['idUser'] ?? '';
    echo json_encode($service->getAppointments($idUser,$search));
} elseif ($action === 'update_status') {
    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($id && $status) {
        if ($service->updateStatus($id, $status)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo actualizar el estado']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetros faltantes']);
    }
} elseif ($action === 'remove') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        if ($service->deleteAppointment($id)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo eliminar la cita']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'ID faltante']);
    }
} elseif ($action === 'add-calendary') {
    $data = $_POST;
    if ($service->saveAppointment($data)) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'No se pudo agendar la cita']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Acción no encontrada']);
}
