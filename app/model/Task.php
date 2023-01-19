<?php
class Task extends DataBase {
    public function getTasks($projectId) {
        $sql = "SELECT * FROM task WHERE project = :projectId ;";
        $result = $this->connect()->prepare($sql);
        $result->bindParam('projectId', $projectId);
        $result->execute();
        return json_encode($result->fetchAll());
    }
    public function insertTask($name, $description, $deadline, $projectId) {
        $sql = "INSERT INTO task(`name`, `description`, `deadline`, `projectId`) 
                VALUES(?, ?, ?, ? );";
        $result = $this->connect()->prepare($sql);
        $result->bindParam(1, $name);
        $result->bindParam(2, $description);
        $result->bindParam(3, $deadline);
        $result->bindParam(4, $projectId);
        $result->execute();
    }
    public function updateTask($taskId, $name, $description, $deadline) {
        $sql = "UPDATE task SET name = ? , description = ? , deadline = ? WHERE ID = ?";
        $result = $this->connect()->prepare($sql);
        $result->bindParam(1, $name);
        $result->bindParam(2, $description);
        $result->bindParam(3, $deadline);
        $result->bindParam(4, $taskId);
        $result->execute();
    }
    public function deleteTask($taskId) {
        $sql = "DELETE FROM task WHERE ID = :taskId ;";
        $result = $this->connect()->prepare($sql);
        $result->bindParam('taskId', $taskId);
        $result->execute();
    }
}