<?php

class Company {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getStocks($id) {
        $this->db->query("SELECT * FROM stocks WHERE company_id = :id");
        $this->db->bind(":id", $id);
            // $result = $this->userModel->execute();
        $result = $this->db->fetchAll();
        return $result;
    }

    public function notify($id, $message) {
        $this->db->query("INSERT INTO notifications(user_id, message) VALUES (:id, :message)");
        $this->db->bind(":id", $id);
        $this->db->bind(":message", $message);

        $this->db->execute();
    }

    public function getCustomers($id) {
        $this->db->query("SELECT * FROM customers WHERE company_id = :id");
        $this->db->bind(":id", $id);
            // $result = $this->userModel->execute();
        $result = $this->db->fetchAll();
        return $result;
    }

    public function saveStock($id, $data){

        $this->db->query("INSERT INTO stocks(name, price, company_id) VALUES (:name, :price, :company_id)");
        $this->db->bind(":company_id", $id);
        $this->db->bind(":name", $data["name"]);
        $this->db->bind(":price", $data["price"]);

        $this->db->execute();
    }

    public function saveCustomer($id, $data){

        $this->db->query("INSERT INTO customers(name, contact, p_history, company_id) VALUES (:name, :contact, :hist, :company_id)");
        $this->db->bind(":company_id", $id);
        $this->db->bind(":name", $data["name"]);
        $this->db->bind(":contact", $data["contact"]);
        $this->db->bind(":hist", $data["hist"]);

        $this->db->execute();
    }

    public function editStock($id, $data) {

        if(!empty($data["name"]) && !empty($data["price"])){

            $this->db->query("UPDATE stocks SET name = :name,  price = :price WHERE id = :id");
            $this->db->bind(":id", $id);
            $this->db->bind(":name", $data["name"]);
            $this->db->bind(":price", $data["price"]);
            $this->db->execute();

        }

    }
}