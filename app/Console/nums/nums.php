<?php
$a=[];
for ($i=0;$i<20000;$i++) {
    $a[$i]=$i;
    echo $i."\n";
}
shuffle($a);
$str = serialize($a);
$myfile = fopen("nums.txt", "w");
fwrite($myfile, $str);
fclose($myfile);
