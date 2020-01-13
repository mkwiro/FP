<?php 

class FPGrowth
{
    public $frequentItem;
    public $minimumSupportCount;
    public $minConfidence;
    public $supportCount;
    public $orderedFrequentItem;
    public $FPTree;
    function __construct()
    {
        $this->frequentItem=array();
        $this->minimumSupportCount = 3;
        $this->minConfidence=60 * 0.01;
        $this->supportCount = array();
        $this->orderedFrequentItem=array();
    }
    //get transaksi array
  public function set($t)
  {
 if(is_array($t))
  {
$this->frequentItem[] = $t;
}
  }


  
}
?>
