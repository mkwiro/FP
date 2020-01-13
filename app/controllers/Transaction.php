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
}
