<?php


function removeold(){
$php_todays_date = getdate();
$php_unix_timestamp = mktime($php_todays_date['hours'],$php_todays_date['minutes'],$php_todays_date['seconds'],$php_todays_date['mon'],$php_todays_date['mday'],$php_todays_date['year']);
$php_todays_date_unix_timestamp = $php_unix_timestamp;
foreach (glob("temp/*.pdf") as $filename)
        {
          if ($php_todays_date_unix_timestamp < (filemtime($filename)+3600))
             {
				//echo filemtime($filename).'</br>';
             }
          else
             {
              // print "File is older than 1 sec - ".$filename." ".date("M-d-Y",filemtime($filename))."<br>";
               $php_status = unlink($filename);
             }
        }
}
?> 