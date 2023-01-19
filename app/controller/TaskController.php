<?php
class TaskController extends controller {
    public function Display($projectId){
        return print_r($this->model('task')->getTasks($projectId));
    }
    public function delete($id, $projectId) {
        $this->model('task')->deleteTask($id);
        header('location: http://doini.com/page/taskBoard/'. $projectId);
    }
}