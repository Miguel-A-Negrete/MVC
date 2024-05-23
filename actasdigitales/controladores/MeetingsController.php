<?php
class MeetingController {
    private $meetingModel;

    public function __construct($meetingModel) {
        $this->meetingModel = $meetingModel;
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
        if(isset($_GET['action']) && $_GET['action'] == 'participantsForMeeting'){
            return $this->getParticipantsForMeeting();
        }
        try {
            if (isset($_GET['meeting_id'])) {
                $id_meeting = $_GET['meeting_id'];
                $meeting = $this->getMeetingByID($id_meeting);
                return $meeting;
            } else {
                // Obtener todos los usuarios
                return $this->getAllMeetings();
            }
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    private function handlePOST() {
        $title = $_POST['title'];
        $date = $_POST['date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
    
        $result = $this->createMeeting($title, $date, $start_time, $end_time);
    
        if ($result > 0) {
            echo'<script type="text/javascript">
            alert("Reunión agregada");
            window.location.href="../reuniones.php";
            </script>';
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


    public function createMeeting($title, $date, $start_time, $end_time) {
        return $this->meetingModel->createMeeting($title, $date, $start_time, $end_time);
    }

    public function getAllMeetings() {
        return $this->meetingModel->getAllMeetings();
    }
    public function getMeetingByID($meeting_id) {
        return $this->meetingModel->getMeetingByID($meeting_id);
    }

    private function getParticipantsForMeeting(){
        return $this->meetingModel->getParticipantsForMeeting();
    }

    public function updateRecord($id_record, $date_record, $start_time, $end_time, $affair, $responsible, $privacy, $relationship_record) {
        return $this->recordModel->updateRecord($id_record, $date_record, $start_time, $end_time, $affair, $responsible, $privacy, $relationship_record);
    }

    public function deleteRecord($id_record) {
        return $this->recordModel->deleteRecord($id_record);
    }
}
?>

