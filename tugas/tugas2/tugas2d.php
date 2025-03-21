<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .catur {
        display: grid;
        grid-template-columns: repeat(5, 90px);
        grid-template-rows: repeat(5, 90px);
        width: 450px;
        height: 450px;
        border: 2px solid black;
    }

    .square {
        width: 90px;
        height: 90px;
    }

    .black {
        background-color: black;
    }

    .white {
        background-color: white;
    }
</style>

<body>
    <div class="catur">
        <?php
        for ($row = 0; $row < 5; $row++) {
            for ($col = 0; $col < 5; $col++) {
                $color = ($row + $col) % 2 === 0 ? 'black' : 'white';
                echo "<div class='square $color'></div>";
            }
        }
        ?>
    </div>
</body>

</html>