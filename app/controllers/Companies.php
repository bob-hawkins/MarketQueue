<?php

session_start();

class Companies extends Controller {

    protected $companyModel;
    protected $sms;

    public function __construct()
    {
        $this->companyModel = $this->model("Company");
        $this->sms = new Sms;
    }


    public function stocks($param = "") {
        
        if(!isset($_SESSION["user"])) return header("Location: " . APP_URL . "/users/login");

        $stocks = $this->companyModel->getStocks($_SESSION["user"]);
        
        if(empty($param)) {
            

            return $this->view("dashboard/stocks", $stocks);
        } // Will return here

        if($param == "edit"){

            if($_SERVER["REQUEST_METHOD"] != "POST") return header("Location: " . APP_URL . "/companies/stocks");

            if(empty($_POST["name"]) || empty($_POST["price"])){
                
                    $_SESSION["err"] = "Both the name and the price should not be empty";
                

                return header("Location: " . APP_URL . "/companies/stocks");
                
            }

            $this->companyModel->editStock($_POST["id"], [
                "name" => $_POST["name"],
                "price" => $_POST["price"]
            ]);

                $_SESSION["success"] = "The stock has been successfully edited";
            

            header("Location: " . APP_URL . "/companies/stocks");

        } else if($param == "create") {
            if($_SERVER["REQUEST_METHOD"] != "POST") return header("Location: " . APP_URL . "/companies/stocks");

            if(empty($_POST["name"]) || empty($_POST["price"])){
                
                    $_SESSION["err"] = "Both the name and the price must be entered";
                

                return header("Location: " . APP_URL . "/companies/stocks");
                
            }

            $this->companyModel->saveStock($_SESSION["user"], [
                "name" => $_POST["name"],
                "price" => $_POST["price"]
            ]);

                $_SESSION["success"] = "The stock has been successfully created";

                header("Location: " . APP_URL . "/companies/stocks");

        } else require_once "../app/views/pages/404.php";
    }

    public function advertisements($send = "") {
        if(!isset($_SESSION["user"])) return header("Location: " . APP_URL . "/users/login");
        
        if(empty($send)) {

            return $this->view("dashboard/advertisements");
        }

        if($_SERVER["REQUEST_METHOD"] != "POST" || $send != "send") return header("Location: " . APP_URL . "/companies/advertisements");

        // $this->sms->send();

        if(empty($_POST["limit"]) || empty($_POST["advert"])){
                
            $_SESSION["err"] = "All the fields must be filled";

            return header("Location: " . APP_URL . "/companies/advertisements");
        
        }
        // send($to, $message, $model, $id)
        $customers = $this->companyModel->getCustomers($_SESSION["user"]);

        $this->view("success");

        foreach($customers as $customer) {
            $customer->p_history = array_map("intval", explode(",", $customer->p_history));
            $last = $customer->p_history[count($customer->p_history) - 1];

            if($last >= $_POST["limit"]) {
                
                $this->sms->send($customer->contact, $_POST["advert"], $this->companyModel, $_SESSION["user"]);
            }
        }

        // header("Location: " . APP_URL);
    }

    public function customers($param="") {
        if(!isset($_SESSION["user"])) return header("Location: " . APP_URL . "/users/login");

        $customers = $this->companyModel->getCustomers($_SESSION["user"]);

        if(empty($param)) {
            
            return $this->view("dashboard/customers", $customers);
        }

        if($_SERVER["REQUEST_METHOD"] != "POST") return header("Location: " . APP_URL . "/companies/customers");


            if(empty($_POST["name"]) || empty($_POST["contact"]) || empty($_POST["hist"])){
                
                    $_SESSION["err"] = "All the fields must be filled";
                

                return header("Location: " . APP_URL . "/companies/customers");
                
            }

            $this->companyModel->saveCustomer($_SESSION["user"], [
                "name" => $_POST["name"],
                "contact" => $_POST["contact"],
                "hist" => $_POST["hist"]
            ]);

                $_SESSION["success"] = "You have successfully added a customer";

                header("Location: " . APP_URL . "/companies/customers");

    }
}