<?php

echo "<h4>Menghitung luas lingkaran</h4>";
function hitungluaslingkaran($r) {
   return pi() * pow($r,2);
}
$r = 10;
echo "jari-jari = $r<br>";
echo "Luas Lingkaran = ";
echo hitungluaslingkaran(10);
echo " cm²";
echo "<hr>";


 echo "<h4>Menghitung luas lingkaran</h4>";
 function hitungkelilinglingkaran($r) {
    return 2 * pi() * $r;
 }

$r = 20;
echo "jari-jari = $r<br>";
echo "keliling Lingkaran = ";
echo hitungkelilinglingkaran(20);
echo " cm";
echo "<hr>";

?> 