<?php
class PageController extends controller
{
    public function index()
    {
        $this->view('pages/index', 'Doini Home')->render();
    }
    public function login()
    {
        $this->model('user');
        if (isset($_POST['login'])) {
            $userName = $this->Validate($_POST['user-name']);
            $password = $this->Validate($_POST['password']);
            if (empty($userName)) {
                $this->view('pages/index', 'login', ['message' => 'Empty user name']);
                $this->view->render();
            } else if (empty($password)) {
                $this->view('pages/index', 'login', ['message' => 'Empty password']);
                $this->view->render();
            } else if (!$this->model->getUser($userName)) {
                $this->view('pages/index', 'login', ['message' => 'Incorrect user name .']);
                $this->view->render();
            } else if (!password_verify($password, $this->model->getUser($userName)['password'])) {
                $this->view('pages/index', 'login', ['message' => 'Incorrect password .']);
                $this->view->render();
            } else {
                $_SESSION['user'] = true;
                header('location: http://doini.com/page/index');
            }
        }
    }
    public function signup()
    {
        $this->model('user');
        if(isset($_POST['sign-up'])) {
            $userName = $this->Validate($_POST['user-name']);
            $password = $this->Validate($_POST['password']);
            if(empty($userName)) {
                $this->view('pages/index', 'Sign Up', ['message' =>'user name is required']);
                $this->view->render();
            } else if(empty($password)) {
                $this->view('pages/index', 'Sign Up', ['message' =>'password is required']);
                $this->view->render();
                return;
            }
            if(strlen($userName) <= 3) {
                $this->view('pages/index', 'Sign Up', ['message' =>'user name must be more than 3 characters.']);
                $this->view->render();
            }
            else if(strlen($password) <= 3) {
                $this->view('pages/index', 'Sign Up', ['message' =>'password must be more than 3 characters.']);
                $this->view->render();
            }
            else if($this->model->getUser($userName)) {
                $this->view('pages/index', 'Sign Up', ['message' =>'this user name is already taken.']);
                $this->view->render();
            }
            else {

                $this->model->insertUser($userName, password_hash($password, PASSWORD_BCRYPT));
                $_SESSION['user'] = true;
                header('location: http://doini.com/page/index');
            }
        }
    }
    public function Validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
