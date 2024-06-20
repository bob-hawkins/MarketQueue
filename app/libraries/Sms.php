<?php
// require_once 'HTTP/Request2.php';

class Sms {
    protected $request;

    public function __construct()
    {
        $this->request = new HTTP_Request2();
        $this->request->setUrl(INFOBIP_BASE_URL);
        $this->request->setMethod(HTTP_Request2::METHOD_POST);
        $this->request->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $this->request->setHeader(array(
            'Authorization' => 'App ' . INFOBIP_AUTH_TOKEN,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ));
        

    }

    public function send($to, $message, $model, $id)
    {
        $body = json_encode([
            "messages" => [
                [
                    "destinations" => $to,
                    "from" => "MarketQueue",
                    "text" => $message
                ]
            ]
        ]);
    
        $this->request->setBody($body);

        try {
            $response = $this->request->send();
            if ($response->getStatus() == 200) {
                $model->notify($id, "The SMS was successfully delivered");
            }
            else {

                $model->notify($id, $response->getReasonPhrase());
            }
        }
        catch(HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

