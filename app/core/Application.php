<?php
class Application {
    private $controller = "PageController";
    private $action = "index";
    private $params = [];

    public function __construct() {
        $this->prepareURL();
        if(file_exists( CONTROLLER . $this->controller . '.php')) {
        
            $this->controller = new $this->controller;
            if(method_exists($this->controller, $this->action)) {
                call_user_func_array([$this->controller, $this->action], $this->params);
            }
        
        }
    }
    protected function prepareURL() {
        
        $request = trim($_SERVER['REQUEST_URI'], '/');
        
        if(!empty($request)) {
        
            $url = explode('/', $request);
            $this->controller = isset($url[0]) ? $url[0] . "Controller" : "PageController";
            $this->action = isset($url[1]) ? $url[1]  : "index";
            unset($url[0], $url[1]);
            $this->params = !empty($url) ? array_values($url) : [];
        
        }
    }
}