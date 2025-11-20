<?php
include("koneksi.php");

if (!isset($_GET['id'])) {
    die("Error: ID tidak ditemukan!");
}

$id = $_GET['id'];

$sql = "SELECT * FROM data_barang WHERE id_barang = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Error: Data tidak ditemukan dalam database.");
}

if (isset($_POST['submit'])) {

    $nama     = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok       = $_POST['stok'];
    $gambar     = $data['gambar']; 

    if (!empty($_FILES['file_gambar']['name'])) {
        $upload_dir = "gambar/";
        $tmp_name = $_FILES['file_gambar']['tmp_name'];
        $filename = $_FILES['file_gambar']['name'];

        move_uploaded_file($tmp_name, $upload_dir . $filename);
        $gambar = $filename; 
    }


    $sql_update = "UPDATE data_barang SET 
                    nama='$nama',
                    kategori='$kategori',
                    harga_jual='$harga_jual',
                    harga_beli='$harga_beli',
                    stok='$stok',
                    gambar='$gambar'
                   WHERE id_barang=$id";

    mysqli_query($conn, $sql_update);


    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ubah Barang</title>
</head>
<body>

<h1>Ubah Barang</h1>

<form action="" method="post" enctype="multipart/form-data">

    Nama Barang
    <input type="text" name="nama" value="<?= $data['nama']; ?>"><br><br>

    Kategori
    <select name="kategori">
        <option value="Elektronik"  <?= $data['kategori']=='Elektronik'?'selected':''; ?>>Elektronik</option>
        <option value="Komputer"    <?= $data['kategori']=='Komputer'?'selected':''; ?>>Komputer</option>
        <option value="Handphone"   <?= $data['kategori']=='Handphone'?'selected':''; ?>>Handphone</option>
    </select><br><br>

    Harga Jual
    <input type="text" name="harga_jual" value="<?= $data['harga_jual']; ?>"><br><br>

    Harga Beli
    <input type="text" name="harga_beli" value="<?= $data['harga_beli']; ?>"><br><br>

    Stok
    <input type="number" name="stok" value="<?= $data['stok']; ?>"><br><br>

    Gambar Saat Ini:<br>
    <img src="gambar/<?= $data['gambar']; ?>" width="80"><br><br>

    Upload Gambar Baru (opsional)
    <input type="file" name="file_gambar"><br><br>

    <button type="submit" name="submit">Simpan</button>
</form>

</body>
</html>
