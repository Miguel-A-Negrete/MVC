<?php
class ParticipantModel {
    private $pdo;
    private $tableName = 'meeting_participants';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createMeeting($meeting_id, $title, $date, $start_time, $end_time) {
        $query = "INSERT INTO {$this->tableName} (meeting_id, title, date, start_time, end_time) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$meeting_id, $title, $date, $start_time, $end_time]);
        return $stmt->rowCount(); 
    }
    
    public function getAllParticipants() {
        $query = "SELECT * FROM {$this->tableName}";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getParticipantByID($meeting_id) {
        $query = "SELECT * FROM {$this->tableName} WHERE meeting_id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$meeting_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    

    public function updateRecord($id_record, $date_record, $start_time, $end_time, $affair, $responsible, $privacy, $relationship_record) {

        $query = "UPDATE {$this->tableName} SET date_record = ?, start_time = ?, end_time = ?, affair = ?, responsible = ?, privacy = ?, relationship_record = ?";
        $params = [$date_record, $start_time, $end_time, $affair, $responsible, $privacy, $relationship_record];

        $query .= " WHERE id_record = ?";
        $params[] = $id_record;

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function deleteRecord($id_record) {
        $query = "DELETE FROM {$this->tableName} WHERE id_record = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_record]);
        return $stmt->rowCount(); 
    }
}
?>
