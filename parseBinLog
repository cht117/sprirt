<?php
/*
*解析binlog
*/
$file_name = $_SERVER['argv']['1'];
$num = $_SERVER['argv']['2'];

$myfile =  fopen($file_name, "r") or die("Unable to open file!");
$i=$j=0;
while(!feof($myfile)) {

    $line = fgets($myfile);
    if(strpos($line,'UPDATE account.account_order')!== false||$i>0)
    {
        //echo $i.'---'.$line;
        if($i==2)
        {
            $rs = explode('=',$line);
            $order_id = trim($rs['1'],"\n");
        }
        if($i==5)
        {
            $rs = explode('=',$line);
            $pay_method = trim($rs['1'],"\n");
        }
        if($i==17)
        {
            $rs = explode('=',$line);
            $batch_no = trim($rs['1'],"\n");
        }
          $i++;
        if($i>60)
        {
            $sql = "UPDATE `account_order` SET `pay_method`={$pay_method},`batch_no`={$batch_no} WHERE `order_id`={$order_id};";
            file_put_contents('/betradar_xml_before_2013/bingloginfo/p12.sql',$sql."\n",FILE_APPEND);
            $i=0;
            echo $j."\n";
            $j++;
        }
    }
}
