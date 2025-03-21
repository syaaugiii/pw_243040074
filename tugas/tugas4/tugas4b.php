<?php
$pekar = ["Motherboard", "Processor", "Hard Disk", "PC Coller", "VGA Card", "SSD"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h2>Macam-macam perangkat keras komputer</h2>
<ol>
    <?php foreach ( $pekar as $a) : ?>
        <li><?php echo $a ?></li>
    <?php  endforeach ;?>
</ol>

<?php 
$pekar[] = "Card Reader";
$pekar[] = "Modem"; 
sort($pekar);
?>

<h2>Macam-macam perangkat keras komputer baru</h2>
<ol>
    <?php foreach ( $pekar as $a) : ?>
        <li><?php echo $a ?></li>
    <?php  endforeach ;?>
</ol>


</body>
</html>