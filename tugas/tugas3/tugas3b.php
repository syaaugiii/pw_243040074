<?php
function urutanangka($angka) {
    $x = 1; 
    for ($i = 1; $i <= $angka; $i++) { 
        for ($j = 1; $j <= $i; $j++) { 
            echo $x . " "; 
            $x++; 
        }
        echo "<br>";
    }
}

urutanangka(5); 
?>