<?php
include_once '../conexion/DB.php';
class RecordModel {
    private $pdo;
    private $tableName = 'records';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createRecord($id_record, $date_record, $start_time, $end_time, $affair, $responsible, $privacy, $relationship_record) {
        $query = "INSERT INTO {$this->tableName} (id_record, date_record, start_time, end_time, affair, responsible, privacy, relationship_record) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_record, $date_record, $start_time, $end_time, $affair, $responsible, $privacy, $relationship_record]);
        return $stmt->rowCount(); 
    }
    
    public function getAllRecords() {
        $query = "SELECT * FROM {$this->tableName}";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecordByID($id_record) {
        $query = "SELECT * FROM {$this->tableName} WHERE id_record = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id_record]);
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