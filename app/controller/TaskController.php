<?php
class TaskController extends controller {
    public function add($project) {
        if(isset($_POST['add-task'])) {
            $Taskname = $_POST['task-name'];
            $description = Validate::Validate($_POST['description']);
            $deadline = Validate::Validate($_POST['deadline']);
            $projectId = $project;
            $this->model('task')->insertTask($Taskname, $description, $deadline, $projectId);
            header('location: http://doini.com/page/taskBoard/'. $project);
        }
    }
    public function Display($projectId){
        return print_r($this->model('task')->getTasks($projectId));
    }
    public function edit() {
        $data = json_decode( file_get_contents("php://input"), true);
        $id = $data['id'];
        $name = validate::Validate($data['name']);
        $description = validate::Validate($data['description']);
        $deadline = $data['deadline'];
        $state = $data['state'];
        $this->model('task')->updateTask($id, $name, $description, $deadline, $state);
    }
    public function search($projectId){
        $data = json_decode( file_get_contents("php://input"), true);
        return print_r($this->model('task')->search($data['input'], $projectId));

    }
    public function delete($id, $projectId) {
        $this->model('task')->deleteTask($id);
        header('location: http://doini.com/page/taskBoard/'. $projectId);
    }
}