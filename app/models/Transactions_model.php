<?php
class Transactions_model
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }  
    public function getAllTransactions()
    {
        $query="SELECT * FROM fpgrowth";
        $this->db->query($query);
        return $this->db->resultSetFP();
    }
}


?>