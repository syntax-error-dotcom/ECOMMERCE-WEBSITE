<?php
class Router {
    private $routes = [];

    public function get($path, $controller) {
        $this->routes[] = [
            'method' => 'GET',
            'path' => $path,
            'controller' => $controller
        ];
    }

    // register a POST route 
    public function post($path, $controller) {
        $this->routes[] = [
            'method' => 'POST',
            'path' => $path,
            'controller' => $controller

        ];

    }


    //match the current URL to a registered route 
    public function resolve($url, $method) {
        foreach($this->routes as $route) {
            if($route['path'] == $url && $route['method'] == $method) {
                //split ProductController@index into class and method
                $parts = explode('@', $route['controller']);
                $controller = $parts[0];
                $action = $parts[1];

                //load all and call the controller
                require_once '../app/controllers/' . $controller . '.php';
                $obj = new $controller();
                $obj->$action();
                return;

            }
        
        }


    }


}



?>
