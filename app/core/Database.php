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
  public $conditionalpatternbase;

  private $currentMultiArrayExec = 0;

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
  $this->minimumSupportCount = 5 * 0.01;
  $this->minConfidence = 60 * 0.01;
  $this->supportCount 	= array();
  $this->orderedFrequentItem = array();
  $this->FPTree=array();
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
public function removeByMinimumSupport($supportCount)
{
  $this->minimumSupportCount=$this->minimumSupportCount * $this->totalTransaction;
  $this->supportCount=[];//construck ini dipecah dijadikan array asosiatif
  foreach ($supportCount as $key => $value) {//supportcount diambil valuenya
    if ($value >= $this->minimumSupportCount) {//supportcount yang valuenya sama dengan minimum support
      $this->supportCount[$key]=$value; //pilih this->supportcount key yang valuenya itu
    }
  }
return $this->supportCount;
}

public function orderFrequentItem($frequentItem, $supportCount)
{
  foreach ($frequentItem as $k => $v) {
    $ordered =[];
    foreach ($supportCount as $key => $value) {
      if (isset($v[$key])) { //cek true false yang ada antara frequent item dan supportcount
        $ordered[$key]=$v[$key];
      }
    }
$this->orderedFrequentItem[$k]=$ordered;
  }
  return $this->orderedFrequentItem;
}

public function buildFPTree($orderedFrequentItem)
{
  $FPTree[] 	= array(
    'item'	=> 'null',
    'count'	=> 0,
    'child'	=> null,
  );
  $FPTree2[] 	= array();
  if(is_array($orderedFrequentItem))
  {
    $i 	= 0;
    foreach ($orderedFrequentItem as $orderedFrequentItemKey => $orderedFrequentItemValue) {
      $FPTreeTemp 	= $FPTree[0];
      $FPTreeTempKey 	= array(0);
      foreach ($orderedFrequentItemValue as $itemKey => $itemValue) {
        array_push($FPTreeTempKey, $itemValue);

//switch untuk membuat fp tree dari array multidimensional
//jumlah case dibuat bedasarkan prediksi jumlah banyaknya varian brand yang akan terjadi dalam satu transaksi
        switch ((count($FPTreeTempKey))) {
          case 2:
            if(empty($FPTree[0]['child'][$itemValue]))
            {
              $FPTree[0]['child'][$itemValue] 	= array(
                'item'	=> $itemValue,
                'count'	=> 1,
                'child'	=> null,
              );
            }else{
              $FPTree[0]['child'][$itemValue]['count'] = $FPTree[0]['child'][$itemValue]['count'] + 1;
            }
            
            break;

          case 3:
            if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]))
            {
              $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue] = array(
                'item'	=> $itemValue,
                'count'	=> 1,
                'child'	=> null,
              );
            }else{
              $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$itemValue]['count'] + 1;
            }
            
            break;

          case 4:
            if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]))
            {
              $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue] 	= array(
                'item'	=> $itemValue,
                'count'	=> 1,
                'child'	=> null,
              );
            }else{
              $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$itemValue]['count'] + 1;
            }
            
            break;

          case 5:
            if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]))
            {
              $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue] 	= array(
                'item'	=> $itemValue,
                'count'	=> 1,
                'child'	=> null,
              );
            }else{
              $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$itemValue]['count'] + 1;
            }
            
            break;

            case 6:
              if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$FPTreeTempKey[4]]['child'][$itemValue]))
              {
                $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]][$FPTreeTempKey[4]]['child'][$itemValue] 	= array(
                  'item'	=> $itemValue,
                  'count'	=> 1,
                  'child'	=> null,
                );
              }else{
                $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]][$FPTreeTempKey[4]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]][$FPTreeTempKey[4]]['child'][$itemValue]['count'] + 1;
              }
              
              break;

              case 7:
                if(empty($FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]]['child'][$FPTreeTempKey[4]]['child'][$FPTreeTempKey[5]]['child'][$itemValue]))
                {
                  $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]][$FPTreeTempKey[4]]['child'][$FPTreeTempKey[5]]['child'][$itemValue] 	= array(
                    'item'	=> $itemValue,
                    'count'	=> 1,
                    'child'	=> null,
                  );
                }else{
                  $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]][$FPTreeTempKey[4]]['child'][$FPTreeTempKey[5]]['child'][$itemValue]['count'] = $FPTree[0]['child'][$FPTreeTempKey[1]]['child'][$FPTreeTempKey[2]]['child'][$FPTreeTempKey[3]][$FPTreeTempKey[4]]['child'][$FPTreeTempKey[5]]['child'][$itemValue]['count'] + 1;
                }
                
                break;
          default:

            break;
        }
      }
    }
  }
  $this->FPTree=$FPTree;
  return $this->FPTree;
}

function getChildKey1($FPTree)
{
  function getChildKey($FPTree){
    $result = [];
    if (isset($FPTree['child'])){
      foreach ($FPTree['child'] as $key => $value){
        $result[$key]=getChildKey($value);
      }
    }
    if (empty($result)){
      return 'gak ada array';
    }
    return $result;
  }
  $output = [];
  foreach ($FPTree as $index => $child){
    $output[$index]=getChildKey($child);
  }
return $output;
}

public function searchRec($haystack, $needle, $pathId=Array(), $pathIndex=Array())
{
  foreach($haystack as $index => $item) {
    // add the current path to pathId-array
    $pathId[] = $item['count'];
    // add the current index to pathIndex-array
    $pathIndex[] = $index;
    // check if we have a match
    if($item['item'] == $needle) {
        // return the match
        $returnObject = new stdClass();
        // the current item where we have the match
        $returnObject->match = $item;   
        // path of Id's (1, 11, 112, 1121)
        $returnObject->pathId = $pathId; 
        // path of indexes (0,0,1,..) - you might need this to access the item directly
        $returnObject->pathIndex = $pathIndex; 
        return $returnObject;
    }

    if(isset($item['Children']) && count($item['Children'])>0) {
        // if this item has children, we call the same function (recursively) 
        // again to search inside those children:
        $result =$this->searchRec($item['Children'], $needle, $pathId, $pathIndex);
        if($result) {
            // if that search was successful, return the match-object
            return $result;
        }
    }
}
return false;
}

}
 ?>
