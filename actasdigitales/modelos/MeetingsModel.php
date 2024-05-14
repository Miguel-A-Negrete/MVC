<?php
class MeetingModel {
    private $pdo;
    private $tableName = 'meetings';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createMeeting($title, $date, $start_time, $end_time) {
        $query = "INSERT INTO {$this->tableName} (title, date, start_time, end_time) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$title, $date, $start_time, $end_time]);
        return $stmt->rowCount(); 
    }
    
    public function getAllMeetings() {
        $query = "SELECT * FROM {$this->tableName}";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMeetingByID($meeting_id) {
        $query = "SELECT * FROM {$this->tableName} WHERE meeting_id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$meeting_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
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
