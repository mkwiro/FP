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

    public function removeMinimumSupport()
    {
        $query="SELECT * FROM fpgrowth";
        $this->db->query($query);
        $this->db->resultSetFP();
        $this->db->countTransaction();
        $this->db->countSupportCount();
        $this->db->orderBySupportCount();
        return $this->db->removeByMinimumSupport($this->db->supportCount);
    }

    public function orderFrequentItemByMinSup()
    {
        $query="SELECT * FROM fpgrowth";
        $this->db->query($query);
        $this->db->resultSetFP();
        $this->db->countTransaction();
        $this->db->countSupportCount();
        $this->db->orderBySupportCount();
        $this->db->removeByMinimumSupport($this->db->supportCount);
        return $this->db->orderFrequentItem($this->db->frequentItem, $this->db->supportCount);
    }

    public function FPTree()
    {
        $query="SELECT * FROM fpgrowth";
        $this->db->query($query);
        $this->db->resultSetFP();
        $this->db->countTransaction();
        $this->db->countSupportCount();
        $this->db->orderBySupportCount();
        $this->db->removeByMinimumSupport($this->db->supportCount);
        $this->db->orderFrequentItem($this->db->frequentItem, $this->db->supportCount);
        return $this->db->buildFPTree($this->db->orderedFrequentItem);
    }
    public function getChildKeys()
    {
        $query="SELECT * FROM fpgrowth";
        $this->db->query($query);
        $this->db->resultSetFP();
        $this->db->countTransaction();
        $this->db->countSupportCount();
        $this->db->orderBySupportCount();
        $this->db->removeByMinimumSupport($this->db->supportCount);
        $this->db->orderFrequentItem($this->db->frequentItem, $this->db->supportCount);
        $this->db->buildFPTree($this->db->orderedFrequentItem);
        return $this->db->getChildKey1($this->db->FPTree);
    }

    public function searchRec()
    {
        $query="SELECT * FROM fpgrowth";
        $this->db->query($query);
        $this->db->resultSetFP();
        $this->db->countTransaction();
        $this->db->countSupportCount();
        $this->db->orderBySupportCount();
        $this->db->removeByMinimumSupport($this->db->supportCount);
        $this->db->orderFrequentItem($this->db->frequentItem, $this->db->supportCount);
        $this->db->buildFPTree($this->db->orderedFrequentItem);
        return $this->db->searchRec($this->db->FPTree, 'DGD');
    }

}


?>