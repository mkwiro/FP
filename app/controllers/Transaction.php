<?php
class Transaction extends Controller
{
    public function index()
    {
        $data['judul']='Transaksi';
        $data['transactions'] = $this->model('Transactions_model')->getAllTransactions();
        $this->view('templates/header', $data);
        $this->view('transaction/index', $data);
        $this->view('templates/footer');
    }

    public function supportCountNotOrdered()
    {
        $data['judul']='Support Count Not Ordered';
        $data['transactions']=$this->model('Transactions_model')->SupportCount();
        $this->view('templates/header', $data);
        $this->view('transaction/supportcountnotordered', $data);
        $this->view('templates/footer');
    }
    public function supportCountOrdered()
    {
        $data['judul']='Support Count Not Ordered';
        $data['transactions']=$this->model('Transactions_model')->supportCountOrdered();
        $this->view('templates/header', $data);
        $this->view('transaction/supportcountordered', $data);
        $this->view('templates/footer');
    }
    public function countTotalTransaction()
    {
        $data['judul']='Support Count Not Ordered';
        $data['transactions']=$this->model('Transactions_model')->countTotalTransaction();
        $this->view('templates/header', $data);
        $this->view('transaction/counttotaltransaction', $data);
        $this->view('templates/footer');
    }
    public function removeMinimumSupport()
    {
    $data['judul']='Remove Minimum Support';
    $data['transactions']= $this->model('Transactions_model')->removeMinimumSupport();
    $this->view('templates/header', $data);
    $this->view('transaction/removeminimumsupport', $data);
    $this->view('templates/footer');
    }
    public function orderFrequentItemByMinSup()
    {
    $data['judul']='Remove Minimum Support';
    $data['transactions']= $this->model('Transactions_model')->orderFrequentItemByMinSup();
    $this->view('templates/header', $data);
    $this->view('transaction/orderfrequentitembyminsup', $data);
    $this->view('templates/footer');
    }
    public function FPTree()
    {
    $data['judul']='Remove Minimum Support';
    $data['transactions']= $this->model('Transactions_model')->FpTree();
    $this->view('templates/header', $data);
    $this->view('transaction/fptree', $data);
    $this->view('templates/footer');
    }
    public function conPatternBase()
    {
    $data['judul']='Remove Minimum Support';
    $data['transactions']= $this->model('Transactions_model')->conPatternBase();
    $this->view('templates/header', $data);
    $this->view('transaction/conpatternbase', $data);
    $this->view('templates/footer');
    }
    public function getChildKeys()
    {
    $data['judul']='getChildKeys';
    $data['transactions']= $this->model('Transactions_model')->getChildKeys();
    $this->view('templates/header', $data);
    $this->view('transaction/getchildkeys', $data);
    $this->view('templates/footer');
    }
    public function searchRecord()
    {
    $data['judul']='search Record';
    $data['transactions']= $this->model('Transactions_model')->searchRec();
    $this->view('templates/header', $data);
    $this->view('transaction/searchrecord', $data);
    $this->view('templates/footer');
    }

}
