<?php
class PageController extends controller
{
    public function __construct()
    {
        session_start();
    }
    public function index()
    {
        if(isset($_SESSION['user-id'])) {
            header('location: http://doini.com/page/dashboard');
        }
        $this->view('visitor/index', 'Doini Home')->render();
    }
    public function login()
    {
        if(isset($_SESSION['user-id'])) {
            header('location: http://doini.com/page/dashboard');
        }
        $this->model('user');
        if (isset($_POST['login'])) {
            $userName = validate::Validate($_POST['user-name']);
            $password = validate::Validate($_POST['password']);
            if (empty($userName)) {
                $this->view('visitor/index', 'Home', ['message' => 'Empty user name']);
                $this->view->render();
            } else if (empty($password)) {
                $this->view('visitor/index', 'Home', ['message' => 'Empty password']);
                $this->view->render();
            } else if (!$this->model->getUser($userName)) {
                $this->view('visitor/index', 'Home', ['message' => 'Incorrect user name .']);
                $this->view->render();
            } else if (!password_verify($password, $this->model->getUser($userName)['password'])) {
                $this->view('visitor/index', 'Home', ['message' => 'Incorrect password .']);
                $this->view->render();
            } else {
                $_SESSION['user-id'] = $this->model->getUser($userName)['ID'];
                $_SESSION['user-name'] = $this->model->getUser($userName)['name'];
                header('location: http://doini.com/page/dashboard');
            }
        }
    }
    public function signup()
    {
        if(isset($_SESSION['user-id'])) {
            header('location: http://doini.com/page/dashboard');
        }
        $this->model('user');
        if(isset($_POST['sign-up'])) {
            $userName = validate::Validate($_POST['user-name']);
            $password = validate::Validate($_POST['password']);
            if(empty($userName)) {
                $this->view('visitor/index', 'Home', ['message' =>'user name is required']);
                $this->view->render();
            } else if(empty($password)) {
                $this->view('visitor/index', 'Home', ['message' =>'password is required']);
                $this->view->render();
                return;
            }
            if(strlen($userName) <= 3) {
                $this->view('visitor/index', 'Home', ['message' =>'user name must be more than 3 characters.']);
                $this->view->render();
            }
            else if(strlen($password) <= 3) {
                $this->view('visitor/index', 'Home', ['message' =>'password must be more than 3 characters.']);
                $this->view->render();
            }
            else if($this->model->getUser($userName)) {
                $this->view('visitor/index', 'Home', ['message' =>'this user name is already taken.']);
                $this->view->render();
            }
            else {

                $this->model->insertUser($userName, password_hash($password, PASSWORD_BCRYPT));
                $_SESSION['user-id'] = $this->model->getUser($userName)['ID'];
                $_SESSION['user-name'] = $this->model->getUser($userName)['name'];
                header('location: http://doini.com/page/dashboard');
            }
        }
    }
    public function logout(){
        session_destroy();
        header('location: http://doini.com/page/index');
    }
    public function dashboard() {
        if(isset($_SESSION['user-id'])) {
            $this->view('user/pages/dashboard', 'dashboard', ['projects' => $this->model('project')->getProjects($_SESSION['user-id'])])->render();
        }else  header('location: http://doini.com/page/index');
    }
    public function taskBoard($projectId) {
        if(isset($_SESSION['user-id'])) {
            $this->view('user/pages/taskBoard', 'TaskBoard', ['project' => $this->model('project')->getProject($projectId)])->render();
        }else  header('location: http://doini.com/page/index');

    }
    public function editProject($projectId) {
        if ($_SESSION['user-id'])
            $this->view('user/pages/editProject', 'Edit project', ['project-info' => $this->model('project')->getProject($projectId)])->render();
        else  header('location: http://doini.com/page/index');

    }
}
