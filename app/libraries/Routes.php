<?php
    /*
    * This registers the routes to be used in the app.
    * It creates the URL and loads the associated controller.
    * URL FORMAT - controller/method/<optional params>
     */

class Routes {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $doesMethodExist = true;
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();

        if(file_exists("../app/controllers/" . ucwords($url[0]) . ".php")){
            $this->currentController = ucwords($url[0]);

            unset($url[0]);
        } else {
            require_once "../app/views/pages/404.php";
            return;
        }

        require_once "../app/controllers/" . $this->currentController . ".php";

        $this->currentController = new $this->currentController;

        if(isset($url[1])){
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
            } else {
                $this->doesMethodExist = false;
            }
            unset($url[1]);
        } else {
            require_once "../app/views/pages/404.php";
            return;
        }

        $this->params = $url ? array_values($url) : [];

        if($this->doesMethodExist) {
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        } else {
            require_once "../app/views/pages/404.php";
        }

        
    }

    public function getUrl() {
        if(isset($_GET["route"])){
            $url = rtrim($_GET["route"], "/");
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/", $url);
            return $url;
        }

        return [
            0 => $this->currentController,
            1 => $this->currentMethod,
            2 => $this->params
        ];
    }
}