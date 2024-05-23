<?php
class RecordController {
    private $recordModel;

    public function __construct($recordModel) {
        $this->recordModel = $recordModel;
    }
    public function handleRequest($method) {
        switch ($method) {
            case 'GET':
                return $this->handleGET();
            case 'POST':
                return $this->handlePOST();
            case 'PUT':
                return $this->handlePUT();
            case 'DELETE':
                return $this->handleDELETE();
            default:
                return ['error' => 'Método no permitido'];
        }
    }

    private function handleGET() {
        try {
            if (isset($_GET['id_record'])) {
                $id_record = $_GET['id_record'];
                $record = $this->getRecordByID($id_record);
                return $record;
            } else {
                // Obtener todos los usuarios
                return $this->getAllRecords();
            }
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    private function handlePOST() {
        $date_record = isset($_POST['date_record']) ? $_POST['date_record'] : null;
        $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : null;
        $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : null;
        $affair = isset($_POST['affair']) ? $_POST['affair'] : null;
        $responsible = isset($_POST['responsible']) ? $_POST['responsible'] : null;
        $privacy = isset($_POST['privacy']) ? $_POST['privacy'] : null;
        $relationship_record = isset($_POST['relationship_record']) ? $_POST['relationship_record'] : null; 
        
        if($relationship_record == ''){
            $relationship_record = null;
        }
    
        $result = $this->createRecord($date_record, $start_time, $end_time, $affair, $responsible, $privacy, $relationship_record);
    
        if ($result > 0) {
            header("Location: actas.php");
            die();
        } else {
            return ['error' => 'Error al insertar el registro.'];
        }}
        


    private function handlePUT() {
        parse_str(file_get_contents("php://input"), $_PUT);
        $id_record = isset($_PUT['id_record']) ? $_PUT['id_record'] : null;
        $date_record = isset($_PUT['date_record']) ? $_PUT['date_record'] : null;
        $start_time = isset($_PUT['start_time']) ? $_PUT['start_time'] : null;
        $end_time = isset($_PUT['end_time']) ? $_PUT['end_time'] : null;
        $affair = isset($_PUT['affair']) ? $_PUT['affair'] : null;
        $responsible = isset($_PUT['responsible']) ? $_PUT['responsible'] : null;
        $privacy = isset($_PUT['privacy']) ? $_PUT['privacy'] : null;
        $relationship_record = isset($_PUT['relationship_record']) ? $_PUT['relationship_record'] : null;

        $result = $this->updateRecord($id_record, $date_record, $start_time, $end_time, $affair, $responsible, $privacy, $relationship_record);
        return ['success' => $result > 0];
    }

    private function handleDELETE() {
        parse_str(file_get_contents("php://input"), $_DELETE);
        $id_record = isset($_DELETE['id_record']) ? $_DELETE['id_record'] : null;
        $result = $this->deleteRecord($id_record);
        return ['success' => $result > 0];
    }


    public function createRecord($date_record, $start_time, $end_time, $affair, $responsible, $privacy, $relationship_record) {
        return $this->recordModel->createRecord($date_record, $start_time, $end_time, $affair, $responsible, $privacy, $relationship_record);
    }

    public function getAllRecords() {
        return $this->recordModel->getAllRecords();
    }
    public function getRecordByID($id_record) {
        return $this->recordModel->getRecordByID($id_record);
    }

    public function updateRecord($id_record, $date_record, $start_time, $end_time, $affair, $responsible, $privacy, $relationship_record) {
        return $this->recordModel->updateRecord($id_record, $date_record, $start_time, $end_time, $affair, $responsible, $privacy, $relationship_record);
    }

    public function deleteRecord($id_record) {
        return $this->recordModel->deleteRecord($id_record);
    }
}
?>
