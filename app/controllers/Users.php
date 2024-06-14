<?php

use Ramsey\Uuid\Uuid;

session_start();

class Users extends Controller {
    protected $regex = "/^\w+@(gmail\.com|yahoo\.com|kabarak\.ac\.ke|hotmail\.com)$/";
    protected $userModel;
    protected $mail;

    public function __construct()
    {
        $this->userModel = $this->model("User");
        $this->mail = new Mail();
    }

    public function register() {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                "name" => filter_var($_POST["name"], FILTER_SANITIZE_SPECIAL_CHARS),
                "email" => filter_var($_POST["email"], FILTER_VALIDATE_EMAIL),
                "password" =>filter_var($_POST["password"], FILTER_DEFAULT),
                "confirm" => filter_var($_POST["confirm"], FILTER_SANITIZE_SPECIAL_CHARS),
                "email_err" => "",
                "password_err" => "",
                "name_err" => "",
                "confirm_err" => ""
            ];

            if(empty($data["name"])) $data["name_err"] = "Kindly fill in your name";
            if(empty($data["email"])) $data["email_err"] = "Enter your valid email address";
            if(empty($data["password"])) $data["password_err"] = "Kindly fill in your password";
            if(empty($data["confirm"])) $data["confirm_err"] = "Kindly fill in your password";

            if(!empty($data["password"]) && !empty($data["confirm"]) && $data["password"] != $data["confirm"]) {
                $data["confirm_err"] = "Passwords does not match";
            }

            if(empty($data["email_err"]) && preg_match($this->regex, $data["email"]) == 0) {
                $data["email_err"] = "Only gmail, yahoo, hotmail and kabarak.ac.ke emails allowed";
            }
            
            if(empty($data["email_err"])){
                if($this->userModel->doesUserExist($data["email"])) $data["email_err"] = "An account with that email already exists";

            }

            if(!empty($data["name_err"]) || !empty($data["email_err"]) || !empty($data["password_err"]) || !empty($data["confirm_err"])) {
        
                $this->view("auth/register", $data);
            } else {
  
                $this->userModel->createUser([
                    "name" => $data["name"],
                    "email" => $data["email"],
                    "password" => $data["password"]
                ]);
                $this->view("auth/login", ["success" => true]);
            }

        } else {
            $data = [
                "name" => "",
                "email" => "",
                "password" => "",
                "confirm" => "",
                "email_err" => "",
                "password_err" => "",
                "name_err" => "",
                "confirm_err" => ""
            ];
            $this->view("auth/register", $data);
        }
    }

    public function login() {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                "email" => filter_var($_POST["email"], FILTER_VALIDATE_EMAIL),
                "password" =>filter_var($_POST["password"], FILTER_DEFAULT),
                "email_err" => "",
                "password_err" => "",
            ];

            if(empty($data["email"])) $data["email_err"] = "Enter your valid email address";
            if(empty($data["password"])) $data["password_err"] = "Kindly fill in your password";


            if(empty($data["email_err"]) && preg_match($this->regex, $data["email"]) == 0) {
                $data["email_err"] = "Only gmail, yahoo, hotmail and kabarak.ac.ke emails allowed";
            }

            // print_r($this->userModel->findUserByEmail($data["email"]));
            if(empty($data["email_err"])){
                if(!$this->userModel->doesUserExist($data["email"])) {
                    $data["email_err"] = "An account with this email does not exist"; 
                }else {
                    $user = $this->userModel->findUserByEmail($data["email"]);
                    if(!password_verify($data["password"], $user->password)){
                        $data["password_err"] = "Invalid credentials";
                    }
                }

            }

            if(!empty($data["email_err"]) || !empty($data["password_err"])) {
        
                $this->view("auth/login", $data);
            } else {
                $_SESSION["user"] = $this->userModel->findUserByEmail($data["email"])->id;
                header("Location: " . APP_URL);
            }
        } else {
            $data = [
                "email" => "",
                "password" => "",
                "email_err" => "",
                "password_err" => "",
            ];
            $this->view("auth/login", $data);
        }
    }

    public function forgot_password() {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                "email" => filter_var($_POST["email"], FILTER_VALIDATE_EMAIL),
                "email_err" => "",
                "r_success" => ""
            ];

            if(empty($data["email"])) $data["email_err"] = "Enter your valid email address";


            if(empty($data["email_err"]) && preg_match($this->regex, $data["email"]) == 0) {
                $data["email_err"] = "Only gmail, yahoo, hotmail and kabarak.ac.ke emails allowed";
            } 

            if(empty($data["email_err"])){
                if(!$this->userModel->doesUserExist($data["email"])) {
                    $data["email_err"] = "An account with this email does not exist"; 
                }else {
                    $reset = Uuid::uuid4()->toString();
                    $this->userModel->setResetToken($reset, $data["email"]);

                    $user = $this->userModel->findUserByEmail($data["email"]);
                    $file = file_get_contents(ROOT . "\\views\pages\auth\mail.php");
                    $file = preg_replace("/name/", $user->username, $file);
                    $file = preg_replace("/APP_URL/", APP_URL, $file);
                    $file = preg_replace("/token/", $reset, $file);

                    $this->mail->sendMail("Password Reset", $user->email, $file);

                }
            }
            if(!empty($data["email_err"])) {
        
                $this->view("auth/forgot_password", $data);
            } else {
                $data["r_success"] = true;
                $this->view("auth/forgot_password", $data);
            }
        } else {
            $data = [
                "email" => "",
                "email_err" => "",
            ];
            $this->view("auth/forgot_password", $data);
        }
    }

    public function reset($token = "") {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                "password" =>filter_var($_POST["password"], FILTER_DEFAULT),
                "token" => filter_var($token, FILTER_SANITIZE_SPECIAL_CHARS),
                "err" => "",
                "password_err" => "",
            ];

            if(empty($data["password"])) $data["password_err"] = "Kindly fill in your password";

            if(empty($data["password_err"])){
                
                $user = $this->userModel->findUserByToken($data["token"]);
                if(!isset($user->email)) $data["err"] = true;
                else {
                    $this->userModel->setPassword(password_hash($data["password"], PASSWORD_ARGON2I), $user->email);
                    $this->userModel->setResetToken(NULL, $user->email);
                }

            }

            if(!empty($data["err"]) || !empty($data["password_err"])) {
        
                $this->view("auth/reset_password", $data);
            } else {
                $_SESSION["reset"] = true; 
                header("Location: " . APP_URL . "/users/login");
            }
        } else {

            $data = [
                "password" => "",
                "password_err" => "",
                "token" => $token
            ];
            $this->view("auth/reset_password", $data);
        }
    }
    
    public function notifications(){
        if(!isset($_SESSION["user"])) return header("Location: " . APP_URL . "/users/login");

        $data = $this->userModel->notifications($_SESSION["user"]);

        $this->view("dashboard/notifications", $data);
    }

    public function signout() {
        session_destroy();

        header("Location: " . APP_URL . "/users/login");
    }
}