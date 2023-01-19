<?php
class ProjectController extends Controller {
    public function display($userId) {
        print_r( $this->model('project')->getProjects($userId) );
    }
    public function add($userId) {
        if(isset($_POST['add'])) {
            $projectName = Validate::Validate($_POST['name']);
            if (empty($projectName)) $projectName = "Untitled";
            $this->model('project')->insertProject($projectName, $userId);
            header('location: http://doini.com/page/dashboard');
        }
        header('location: http://doini.com/page/index');
    }
    public function edit($projectId) {
        if(isset($_POST['edit'])) {
            $projectName = Validate::Validate($_POST['name']);
            if (empty($projectName)) $projectName = "Untitled";
            $this->model('project')->updateProject($projectId, $projectName);
            header('location: http://doini.com/page/dashboard');
        }
        header('location: http://doini.com/page/index');
    }
    public function delete($projectId) {
            $this->model('project')->deleteProject($projectId);
            header('location: http://doini.com/page/dashboard');  
    }
}