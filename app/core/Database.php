<?php
/**
 * data base fp growth
 */
class Database
{
  //database
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $db_name = DB_NAME;

  private $dbh;
  private $stmt;

  //fpgrowth
  public $totalTransaction;
  public $frequentItem;
  public $minimumSupportCount;
  public $minConfidence;
  public $supportCount;
  public $orderedFrequentItem;
  public $FPTree;

  public function __construct()
  {
    //data source name
    //disi koneksi ke PDO
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;
  //cek koneksi dengan try tray catch
  //option Database

  $option=[
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ];

  try {
    $this->dbh = new PDO($dsn, $this->user, $this->pass, );
  } catch (PDOException $e) { //catch kalau gagal kirim error ke e
    echo "Connection Failed:";
    die($e->getMessage()); //kirim message error
  }

  //fpgrowth
  $this->frequentItem = array();
  $this->totalTransaction = array();
  $this->minimumSupportCount = 100;
  $this->minConfidence = 60 * 0.01;
  $this->supportCount 	= array();
  $this->orderedFrequentItem = array();
  }

//func query SQL
public function query($query)
{
  $this->stmt =$this->dbh->prepare($query);
}
//fungsi bind tipe data otomatis
public function bind($param, $value, $type =null)
{
  if (is_null($type)) {
    switch (true) {
      case is_int($value):
        $type = PDO::PARAM_INT;
        break;
      case is_bool($value):
        $type = PDO::PARAM_BOOL;
        break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
      default:
        $type = PDO::PARAM_STR;
        break;
    }
  }
//bind untuk menghindari sql injection
  $this->stmt->bindValue($param, $value, $type);
}

//eksekusi query
public function execute( )
{
  $this->stmt->execute();
}

//fetchall banyak data
public function resultSet()
{
  $this->execute();
  return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
}

//fecth 1 data
public function single()
{
  $this->execute();
  return $this->stmt->fetch(PDO::FETCH_ASSOC);
}


public function rowCount()
{
  return $this->stmt->rowCount();
}


//FP Growth database fetch
public function resultSetFP()
{
  $this->execute();
  $frequentItem = $this->stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

  foreach ($frequentItem as $key => $value) {
    foreach ($value as $i => $v) {
        foreach ($v as $b) {
            $frequentItem[$key][$b] = $b;
        }
        unset($frequentItem[$key][$i]);
    }
}
//set hasil database ke array frequent item
 if(is_array($frequentItem)){
   $this->frequentItem=$frequentItem;
 }
 return $this->frequentItem;
}
//menghitung jumlah semua transaksi
public function countTransaction()
{
  foreach($this->frequentItem as $key => $value){
    if(empty($this->totalTransaction)){
      $this->totalTransaction=1;
    }else{
      $this->totalTransaction=$this->totalTransaction +1;
    }
  }
  return $this->totalTransaction;
}
//fungsi menghitung supportcount setiap brand dalam transaksi
public function countSupportCount()
{
  foreach ($this->frequentItem as $key => $value) {
    foreach ($value as $k => $v) {
      if (empty($this->supportCount[$v])) {
        $this->supportCount[$v]=1;
      }else {
        $this->supportCount[$v]= $this->supportCount[$v] +1;
      }
    }
}
return $this->supportCount;
}

//mengurutkan supportcount
public function orderBySupportCount()
{
  ksort($this->supportCount);
  arsort($this->supportCount);
  return $this->supportCount;
}
//remove supportcount berdasarkan minimum support
public function removeByMinimumSupport($a)
{
  var_dump($a);
  $this->supportCount=[];//construck ini dipecah dijadikan array asosiatif
  foreach ($a as $key => $value) {//supportcount diambil valuenya
    if ($value >= $this->minimumSupportCount) {//supportcount yang valuenya sama dengan minimum support
      var_dump($this->minimumSupportCount);
      $this->supportCount[$key]=$value; //pilih this->supportcount key yang valuenya itu
      var_dump($this->supportCount);
    }
  }
return $this->supportCount;
}

}


 ?>
