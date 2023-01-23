<?php
class Task extends DataBase {
    public function getTasks($projectId) {
        $sql = "SELECT * FROM task WHERE project = :projectId ORDER BY deadline ASC ;";
        $result = $this->connect()->prepare($sql);
        $result->bindParam('projectId', $projectId);
        $result->execute();
        return json_encode( $result->fetchAll() );
    }
    public function insertTask($name, $description, $deadline, $projectId) {
        $sql = "INSERT INTO task(`name`, `description`, `deadline`, `project`) 
                VALUES(?, ?, ?, ? );";
        $result = $this->connect()->prepare($sql);
        $result->bindParam(1, $name);
        $result->bindParam(2, $description);
        $result->bindParam(3, $deadline);
        $result->bindParam(4, $projectId);
        $result->execute();
    }
    public function updateTask($taskId, $name, $description, $deadline, $state) {
        $sql = "UPDATE task SET name = ? , description = ? , deadline = ?, state = ?  WHERE ID = ?";
        $result = $this->connect()->prepare($sql);
        $result->bindParam(1, $name);
        $result->bindParam(2, $description);
        $result->bindParam(3, $deadline);
        $result->bindParam(4, $state);
        $result->bindParam(5, $taskId);
        $result->execute();
    }
    public function deleteTask($taskId) {
        $sql = "DELETE FROM task WHERE ID = :taskId ;";
        $result = $this->connect()->prepare($sql);
        $result->bindParam('taskId', $taskId);
        $result->execute();
    }
    public function search($input, $projectId) {
        $sql = "SELECT * FROM task WHERE project = :projectId AND( name LIKE  '%$input%' OR description LIKE '%$input%') ORDER BY deadline ASC ;";
        $result = $this->connect()->prepare($sql);
        $result->bindParam(':projectId', $projectId);
        $result->execute();
        return json_encode( $result->fetchAll() );
    }
}