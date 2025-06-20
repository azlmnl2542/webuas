<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "jogjaistimewa23";
$dbname = "webuas";
// Create connection 
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
}

if (isset($_POST['btn_login'])) {
    $data_email = $_POST['email'];
    $data_password = md5($_POST['password']);

    $sql = "SELECT * FROM penulis WHERE email='$data_email' AND password='$data_password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['idpenulis'] = $row['id_penulis'];
            $_SESSION['email'] = $data_email;
            $_SESSION['password'] = $data_password;
        }
        header('location:index.php');
    } else {
        echo "0 results";
    }
}
if (isset($_POST['btn_hapus_artikel'])) {
    $id_hapus = $_POST['id_hapus_artikel'];
    // sql to delete a record
    $sql_hapus_artikel = "DELETE FROM artikel WHERE id_artikel IN (
    select id_artikel 
    from kontributor 
    where id_kontributor = '$id_hapus'
    )";
    $sql_hapus_kontributor = "DELETE FROM kontributor 
    WHERE id_kontributor = '$id_hapus'";

    if (mysqli_query($conn, $sql_hapus_artikel)) {
        if (mysqli_query($conn, $sql_hapus_kontributor)) {
            header('location:artikel.php');
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
if (isset($_POST['btn_simpan'])) {

    $target_dir = "gambar/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek Gambar Asli atau Palsu
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Cek ketersediaan file
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Cek Ukuran
    if ($_FILES["gambar"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Format yang diizinkan
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["gambar"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }


    $data_tanggal = $_POST['tanggal'];
    $data_judul = $_POST['judul'];
    $data_isi = $_POST['isi'];
    $data_kategori = $_POST['kategori'];
    $data_gambar = $target_file;

    $sql = "INSERT INTO artikel (tanggal, judul, isi, gambar) VALUES ('$data_tanggal', '$data_judul', '$data_isi', '$data_gambar')";

    if (mysqli_query($conn, $sql)) {
        $sql = "SELECT * FROM artikel order by id_artikel DESC Limit 1";
        $result = mysqli_query($conn, $sql);
        $data_id_artikel = "";
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $data_id_artikel = $row['id_artikel'];
            }
        } else {
            echo "0 results";
        }
        $data_id_penulis = $_SESSION['idpenulis'];
        $sql = "INSERT INTO Kontributor (id_penulis, id_kategori, id_artikel) VALUES ('$data_id_penulis', '$data_kategori', '$data_id_artikel')";

        if (mysqli_query($conn, $sql)) {
            header('location:artikel.php');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
    }
}

if (isset($_POST['btn_ubah_artikel'])) {
    $target_dir = "gambar/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek Gambar Asli atau Palsu
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Cek ketersediaan file
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Cek Ukuran
    if ($_FILES["gambar"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Format yang diizinkan
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["gambar"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $data_tanggal = $_POST['tanggal'];
    $data_judul = $_POST['judul'];
    $data_isi = $_POST['isi'];
    $data_kategori = $_POST['kategori'];
    $data_gambar = $target_file;
    $id_ubah = $_POST['id_kontributor_ubah'];

    $sql_update_artikel = "UPDATE artikel 
    inner join kontributor on artikel.id_artikel = kontributor.id_artikel
    set
    artikel.judul = '$data_judul',
    artikel.isi = '$data_isi',
    artikel.gambar = '$data_gambar'
    where
    kontributor.id_kontributor = '$id_ubah'";
    $sql_update_kontributor = "UPDATE kontributor
    set
    id_kategori = '$data_kategori'
    where
    id_kontributor = '$id_ubah'";
    if (mysqli_query($conn, $sql_update_artikel)) {
        if (mysqli_query($conn, $sql_update_kontributor)) {
            header('location:artikel.php');
        } else {
        }
    } else {
    }
}
if (isset($_POST['btn_simpan_kategori'])) {
    $data_nama = $_POST['nama'];
    $data_keterangan = $_POST['keterangan'];

    $sql = "INSERT INTO kategori (nama_kategori, keterangan) VALUES ('$data_nama', '$data_keterangan')";

    if (mysqli_query($conn, $sql)) {
        header('location:kategori.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
if (isset($_POST['btn_ubah_kategori'])) {
    $data_nama = $_POST['nama'];
    $data_keterangan = $_POST['keterangan'];
    $id_update = $_POST['id_kategori_update'];

    $sql = "UPDATE kategori SET nama_kategori='$data_nama', keterangan='$data_keterangan' WHERE id_kategori='$id_update'";

    if (mysqli_query($conn, $sql)) {
        header('location:kategori.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
if (isset($_POST['btn_hapus_kategori'])) {
    $id_hapus = $_POST['id_hapus_kategori'];

    // sql to delete a record
    $sql = "DELETE FROM kategori WHERE id_kategori='$id_hapus'";

    if ($conn->query($sql) === TRUE) {
        header('location:kategori.php');
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

if (isset($_POST['btn_ubah_penulis'])) {
    $data_nama = $_POST['nama'];
    $data_email = $_POST['email'];
    $data_password = md5($_POST['password']);
    $id_update = $_POST['id_penulis_update'];

    $sql = "UPDATE penulis SET nama_penulis='$data_nama', email='$data_email', password='$data_password' WHERE id_penulis='$id_update'";

    if (mysqli_query($conn, $sql)) {
        header('location:penulis.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if (isset($_POST['btn_hapus_penulis'])) {
    $id_hapus = $_POST['id_hapus_penulis'];

    // sql to delete a record
    $sql = "DELETE FROM penulis WHERE id_penulis='$id_hapus'";

    if ($conn->query($sql) === TRUE) {
        header('location:penulis.php');
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

if (isset($_POST['btn_simpan_penulis'])) {
    $data_nama = $_POST['nama'];
    $data_email = $_POST['email'];
    $data_password = md5($_POST['password']);

    $sql = "INSERT INTO penulis (nama_penulis, email, password) VALUES ('$data_nama', '$data_email', '$data_password')";

    if (mysqli_query($conn, $sql)) {
        header('location:penulis.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

function potong_artikel($isi_artikel, $jml_karakter) {
    // Pastikan tidak melebihi panjang string
    $panjang = strlen($isi_artikel);
    if ($jml_karakter >= $panjang) {
        $jml_karakter = $panjang - 1;
    }

    // Cegah error jika ternyata $jml_karakter < 0
    if ($jml_karakter < 0) {
        $jml_karakter = 0;
    }

    // Cari spasi terdekat ke belakang
    while($jml_karakter > 0 && $isi_artikel[$jml_karakter] != " ") {
        --$jml_karakter;
    }

    $potongan_isi_artikel = substr($isi_artikel, 0, $jml_karakter);
    $isi_artikel_terpotong = $potongan_isi_artikel . " ...";
    return $isi_artikel_terpotong;
}

// terjemah Hari
function hariIndonesia($namaHari)
{
    $hari = $namaHari;
    switch ($hari) {
        case "Sunday":
            $hari = "Minggu";
            return $hari;
            break;
        case "Monday":
            $hari = "Senin";
            return $hari;
            break;
        case "Tuesday":
            $hari = "Selasa";
            return $hari;
            break;
        case "Wednesday":
            $hari = "Rabu";
            return $hari;
            break;
        case "Thursday":
            $hari = "Kamis";
            return $hari;
            break;
        case "Friday":
            $hari = "Jumat";
            return $hari;
            break;
        case "Saturday":
            $hari = "Sabtu";
            return $hari;
            break;
        default:
            $hari = "nama hari";
    }
}

// nama Bulan

function namaBulan($bulan)
{
    $nama_bulan = $bulan;
    switch ($nama_bulan) {
        case "01":
            $nama_bulan = "Januari";
            return $nama_bulan;
            break;
        case "02":
            $nama_bulan = "februari";
            return $nama_bulan;
            break;
        case "03":
            $nama_bulan = "Maret";
            return $nama_bulan;
            break;
        case "04":
            $nama_bulan = "April";
            return $nama_bulan;
            break;
        case "05":
            $nama_bulan = "Mei";
            return $nama_bulan;
            break;
        case "06":
            $nama_bulan = "Juni";
            return $nama_bulan;
            break;
        case "07":
            $nama_bulan = "Juli";
            return $nama_bulan;
            break;
        case "08":
            $nama_bulan = "Agustus";
            return $nama_bulan;
            break;
        case "09":
            $nama_bulan = "September";
            return $nama_bulan;
            break;
        case "10":
            $nama_bulan = "Oktober";
            return $nama_bulan;
            break;
        case "11":
            $nama_bulan = "November";
            return $nama_bulan;
            break;
        case "12":
            $nama_bulan = "Desember";
            return $nama_bulan;
            break;
        default:
            $nama_bulan = "Bulan tidak ditemukan";
    }
}
