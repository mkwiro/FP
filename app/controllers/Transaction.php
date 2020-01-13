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

    public function countAllTransaction()
    {
    $data['judul']='Total Transaksi';
    $data['transactions']= $this->model('Transactions_model')->countTotalTransaction();
    $this->view('templates/header', $data);
    $this->view('transaction/countalltransaction', $data);
    $this->view('templates/footer');
    }


}
