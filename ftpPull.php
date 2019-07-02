<?php
$conn = ftp_connect('ftp.example.com');
ftp_login($conn,'username','password');
ftp_chdir($conn,'statscopy');
$buffer = ftp_rawlist($conn,".");
$base_dir = "/betradar_xml/";
$stats_copy = "/flood/stats_copy/";
echo "\n".date('Y-m-d H:i:s')." start!\n";
if(is_array($buffer))
{
    foreach($buffer as $file)
    {
        //由于效率问题只下载足球相关的文件
        if(strpos($file,'Soccer')||strpos($file,'Basketball'))
        {
            $file = substr($file,49);
            $time = substr($file,0,12);
            $time = strtotime($time)+7*3600;
            $sub_dir = date('Y-m-d',$time);
            $file_name = substr($file,13);
            $tmp = explode('_',$file_name);
            $file_old = $stats_copy.$file_name;
            //echo $file_old."\n";
            if(file_exists($file_old)==false)
            {
                echo $file_name."---new--".date('Y-m-d H:i:s',$time)."---".date('Y-m-d H:i:s')."\n";
                ftp_get($conn,"/snatch/data/".$file_name,$file_name,FTP_ASCII);
                //ftp_get($conn,$stats_copy.$file_name,$file_name,FTP_ASCII);
            if(file_exists("/snatch/data/".$file_name))
                {
                  echo $file_name."---new--".date('Y-m-d H:i:s',$time)."---".date('Y-m-d H:i:s')."\n";
                ftp_get($conn,"/snatch/data/".$file_name,$file_name,FTP_ASCII);
                //ftp_get($conn,$stats_copy.$file_name,$file_name,FTP_ASCII);
            if(file_exists("/snatch/data/".$file_name))
                {
                    echo '-.-.';
                    copy("/snatch/data/".$file_name,$stats_copy.$file_name);
                }
            }
            else
            {
                $time_diff = $time-filemtime($file_old);
                if($time_diff>80)
                {
                     echo $file_name."-----".date('Y-m-d H:i:s',$time)."---".date('Y-m-d H:i:s')."\n";
                    ftp_get($conn,"/snatch/data/".$file_name,$file_name,FTP_ASCII);
                    //ftp_get($conn,$stats_copy.$file_name,$file_name,FTP_ASCII);
                    copy("/snatch/data/".$file_name,$stats_copy.$file_name);
                }
            }
        }
    }
    echo "\n".date('Y-m-d H:i:s')." end!\n";
ftp_close($conn);
                                          
