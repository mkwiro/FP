<?php
class Transactions_model
{
    private $totaltransactions;
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
    public function SupportCount()
    {
        $query="SELECT * FROM fpgrowth";
        $this->db->query($query);
        $this->db->resultSetFP();
        return $this->db->countSupportCount();
    }
    public function SupportCountOrdered()
    {
        $query="SELECT * FROM fpgrowth";
        $this->db->query($query);
        $this->db->resultSetFP();
        $this->db->countSupportCount();
        return $this->db->orderBySupportCount();
    }

    public function countTotalTransaction()
    {
        $query="SELECT * FROM fpgrowth";
        $this->db->query($query);
        $this->db->resultSetFP();
        return $this->db->countTransaction();
    }

}


?>