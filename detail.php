<?php
require 'admin/function.php';

$data_id_kontributor = $_GET['id_kontributor'];
$data_id_kategori = $_GET['id_kategori']; 

// Query utama untuk detail artikel
$sql = "SELECT 
            kontributor.id_kontributor,
            kontributor.id_kategori,
            artikel.tanggal,
            artikel.judul,
            artikel.isi,
            penulis.nama_penulis,
            kategori.nama_kategori,
            artikel.gambar
        FROM kontributor
        JOIN artikel ON kontributor.id_artikel = artikel.id_artikel
        JOIN penulis ON kontributor.id_penulis = penulis.id_penulis
        JOIN kategori ON kontributor.id_kategori = kategori.id_kategori
        WHERE kontributor.id_kontributor = '$data_id_kontributor' 
        AND kontributor.id_kategori = '$data_id_kategori'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Cek apakah data ditemukan
if(!$row){
    echo "<h1>Data Tidak Ditemukan di Database.</h1>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Detail Artikel</title>
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>

<!-- Artikel Detail -->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <h1><?php echo $row['judul']; ?></h1>
            <p class="text-muted">Ditulis pada <?php echo $row['tanggal']; ?> oleh <?php echo $row['nama_penulis']; ?></p>
            <a href="kategori.php?id_kategori=<?php echo $row['id_kategori']; ?>" class="badge bg-secondary"><?php echo $row['nama_kategori']; ?></a>
            <img src="admin/<?php echo $row['gambar']; ?>" class="img-fluid mt-3 mb-3" alt="Gambar Artikel">
            <p><?php echo $row['isi']; ?></p>
            <button onclick="history.back()" class="btn btn-outline-primary">Kembali</button>
        </div>

        <!-- Artikel Terkait -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Artikel Terkait</div>
                <div class="list-group list-group-flush">
                    <?php
                    $sql_terkait = "SELECT 
                                        kontributor.id_kontributor,
                                        kontributor.id_kategori,
                                        artikel.judul
                                    FROM kontributor
                                    JOIN artikel ON kontributor.id_artikel = artikel.id_artikel
                                    WHERE kontributor.id_kategori = '$data_id_kategori' 
                                    AND kontributor.id_kontributor < '$data_id_kontributor'
                                    ORDER BY kontributor.id_kontributor DESC
                                    LIMIT 5";

                    $result_terkait = mysqli_query($conn, $sql_terkait);

                    if(mysqli_num_rows($result_terkait) > 0){
                        while($terkait = mysqli_fetch_assoc($result_terkait)){
                            ?>
                            <a href="detail.php?id_kontributor=<?php echo $terkait['id_kontributor']; ?>&id_kategori=<?php echo $terkait['id_kategori']; ?>" class="list-group-item list-group-item-action">
                                <?php echo $terkait['judul']; ?>
                            </a>
                            <?php
                        }
                    } else {
                        echo "<p class='list-group-item'>Tidak ada artikel terkait.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
