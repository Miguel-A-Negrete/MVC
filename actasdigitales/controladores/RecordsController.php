<?php
class RecordController {
    private $recordModel;

    public function __construct($recordModel) {
        $this->recordModel = $recordModel;
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
