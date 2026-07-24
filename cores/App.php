<?php 
class App {
    private $router;


    public function __construct() {
        $this->router = new Router();

        //load the routes
        require_once '..app/routes/web.php';


        $url = $this->getUrl();
        $method = $_SERVER['REQUEST_METHOD'];

        $this->router->resolve($url, $method);
    }

    private function getUrl() {

        if(isset($_GET['url'])) {
            return '/' . rtrim($_GET['url'], '/');

        }
        
        return '/';
    }

}





?>