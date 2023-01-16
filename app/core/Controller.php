<?php
class Controller {
    protected $view;
    protected $model;

    public function view($viewFile, $viewTitle, $viewData = []) {
        $this->view = new View($viewFile, $viewTitle, $viewData);
        return $this->view;
    }
    public function model($modelName) {
        if(file_exists(MODEL . $modelName . '.php')) {
            $this->model = new $modelName;
        }
        return $this->model;
    }
}