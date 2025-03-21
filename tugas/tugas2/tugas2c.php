<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .kotak {
        display: inline-block;
        width: 50px;
        height: 50px;
        border: 2px solid black;
        background-color: salmon;
        text-align: center;
        line-height: 50px;
        font-size: 20px;
        margin: -1px;
    }
</style>

<body>
    <?php
    for ($i = 10; $i >= 1; $i--) {
        for ($a = 1; $a <= $i; $a++) {
            echo "<div class='kotak'>$a</div>";
        }
        echo "<br>";
    }

    ?>
</body>

</html>