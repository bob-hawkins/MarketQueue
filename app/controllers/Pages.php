<?php

session_start();

class Pages extends Controller {
    private $pageModel;
    
    public function __construct()
    {
        $this->pageModel = $this->model("Page");
    }

    public function index() {
        // if(!isset($_SESSION["user"])) header("Location: " . APP_URL . "/users/login");
        $this->view("index");
        
    }

}