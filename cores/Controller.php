<?php
class Controller {

    //loads file new data
    public function view($view, $data = []) {
        //extract turns array keys into variables
        //so $data['products'] becomes $products in view
        extract($data);
        
        require_once '../app/views/' . $view . '.php';
    }

    //loads model file
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
 
    }

}


?>