<?php
class Project extends DataBase {
    public function getProjects($userId) {
        $sql = "SELECT * FROM project WHERE `user id` = ?";
        $result = $this->connect()->prepare($sql);
        $result->bindParam(1, $userId);
        $result->execute();
        return $result->fetchAll();
    }
    public function getProject($projectId) {
        $sql = "SELECT * FROM project WHERE `ID` = ?";
        $result = $this->connect()->prepare($sql);
        $result->bindParam(1, $projectId);
        $result->execute();
        return $result->fetch();
    }
    public function insertProject($projectName, $userId) {
        $sql = "INSERT INTO project(`name`, `user id`) VALUE(?, ?)";
        $result = $this->connect()->prepare($sql);
        $result->bindParam(1, $projectName);
        $result->bindParam(2, $userId);
        $result->execute();
    }
    public function updateProject($projectId, $projectName) {
        $sql = "UPDATE project SET `name` = :projectName WHERE `ID` = :projectId;";
        $result = $this->connect()->prepare($sql);
        $result->bindParam('projectName', $projectName, PDO::PARAM_STR);
        $result->bindParam('projectId', $projectId, PDO::PARAM_INT);
        $result->execute();
    }
    public function deleteProject($projectId) {
        $sql = "DELETE FROM project WHERE `ID` = ? ;";
        $result = $this->connect()->prepare($sql);
        $result->bindParam(1, $projectId);
        $result->execute();
    }
}