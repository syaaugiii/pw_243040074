<?php
$mahasiswa = [
    [
        "nama" => "Ilham Syaugi",
        "nrp" => "243040074",
        "email" => "syawgy@gmail.com",
        "jurusan" => "Teknik Informatika"
    ],
    [
        "nama" => "Try Noer Arreva",
        "nrp" => "246010073",
        "email" => "reva121417@gmail.com",
        "jurusan" => "Teknik Informatika"
    ],
    [
        "nama" => "Raja Edgar Rizky Penandino",
        "nrp" => "243060019",
        "email" => "edgarraja706@gmail.com",
        "jurusan" => "Teknik Perancangan Wilayah Dan Kota"
    ],
    [
        "nama" => "Archie Bani Pratama",
        "nrp" => "246010045",
        "email" => "achuakss@gmail.com",
        "jurusan" => "Desain Komunikasi Visual"
    ],
    [
        "nama" => "Ghrisvy Tausyah",
        "nrp" => "243040091",
        "email" => "wibugris@gmail.com",
        "jurusan" => "Teknik Informatika"
    ],
    [
        "nama" => "Afsal Prima",
        "nrp" => "243040092",
        "email" => "afsalmahasiswa@gmail.com",
        "jurusan" => "Teknik Informatika"
    ],
    [
        "nama" => "Yanto Alhadi",
        "nrp" => "243040095",
        "email" => "yanto45@gmail.com",
        "jurusan" => "Teknik Industri"
    ],
    [
        "nama" => "Bagas Kara",
        "nrp" => "248040098",
        "email" => "bagass@gmail.com",
        "jurusan" => "Kedokteran"
    ],
    [
        "nama" => "Titan Ristina",
        "nrp" => "248040060",
        "email" => "ristina@gmail.com",
        "jurusan" => "Kedokteran"
    ],
    [
        "nama" => "Ikmal Ijlal Syahid",
        "nrp" => "246040001",
        "email" => "ikmull@gmail.com",
        "jurusan" => "Teknik Sipil"
    ],
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
</head>

<body>
    <h2>Daftar Mahasiswa</h2>

    <?php foreach ($mahasiswa as $mhs) : ?>
        <ul>
            <li>Nama: <?= $mhs["nama"]; ?></li>
            <li>NRP: <?= $mhs["nrp"]; ?></li>
            <li>Email: <?= $mhs["email"]; ?></li>
            <li>Jurusan: <?= $mhs["jurusan"]; ?></li>
        </ul>
    <?php endforeach; ?>

</body>

</html>