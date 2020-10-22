<?php

class Pages {
    public function __construct()
    {
        //echo 'paginas cargadas';        
    }

    public function index() 
    {
        echo 'index';
    }

    public function about($id = null) 
    {
        echo $id;
    }
}