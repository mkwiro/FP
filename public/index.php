<?php


require '../app/init.php';

$app = new App;

require 'transaction.php';
require 'FPGrowth.php';


$fpgrowth 	= new FPGrowth();
// Input transaction / frequent 1-item
foreach ($transactions as $key => $transaction) {
  $fpgrowth->set($transaction);
}
//menampilkan Frequent Item
$fpgrowth->get();
//menghitung support countSupportCount
$fpgrowth->countSupportCount();
// Menampilkan item support count
echo "Item | Support Count not ordered";
$fpgrowth->getSupportCount();
//mengurutkan dan menampilkan supportcount yang sudah diurutkan abjad dan besar nilainya
echo "Item | Support Count ordered";
$fpgrowth->orderBySupportCount();
$fpgrowth->getSupportCount();
echo "Remove By Minimum Support";
$fpgrowth->removeByMinimumSupport($fpgrowth->supportCount);
$fpgrowth->getSupportCount();
//seleksi dan mengurutkan  frequentitem berdasarkan supportcount yang sudah disortir
//dengan minimum support
echo "Frequent Item ordered by support count";
$fpgrowth->orderFrequentItem($fpgrowth->frequentItem, $fpgrowth->supportCount);
$fpgrowth->getOrderedFrequentItem();
//FP Tree
echo "FP Tree";
$fpgrowth->FPTree= $fpgrowth->buildFPTree($fpgrowth->orderedFrequentItem);
$fpgrowth->getFPTree();


 ?>
