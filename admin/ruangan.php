<?php
include("../koneksi.php");
session_start();

if (isset($_SESSION['username']) && $_SESSION['role'] != "Admin") {
    header("location:../index.php");
} elseif (!isset($_SESSION['username'])) {
    header("location:../index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b3f6ad813f.js" crossorigin="anonymous"></script>

    <style> 
    .table-responsive { width: 70%; margin: 0 auto; border-collapse: collapse; } 
    .table-responsive th, .table-light td { text-align: center; } 
    .container { margin-top: 1rem; display: flex; justify-content: center; } 
    </style>

</head>

<body>
    <?php include("menu-admin.php"); ?>
    <div class="table-responsive">
        <h3 align="left" class="pt-4">Data Ruangan</h3>
        <form action="ruangan.php" method="get">
            <table align="right">
                <tr><a href="ruangan_tambah.php" class="btn btn-primary" style="margin: 10px; margin-left:0px;">Tambah Data +</a></tr>
                <tr>
                    <td>Cari</td>
                    <td>:</td>
                    <td><input class="form-control" type="text" name="cari" placeholder="Cari Data"></td>
                    <td><input class="btn btn-primary" type="submit" value="Cari"></td>
                </tr>
            </table>
        </form>

        <div class="container mt-1">
        <table class="table table-bordered">
            <tr class="table-light" style="text-align:center;">
                <th>No</th>
                <th>Nama Ruangan</th>
                <th>Tempat</th>
                <th>Kapasitas</th>
                <th>Aksi</th>
            </tr>
            <?php
            include('../koneksi.php');


            $halaman        = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
            $halaman_awal   = ($halaman > 1) ? ($halaman * 4) - 4 : 0;

            $sebelum        = $halaman - 1;
            $setelah        = $halaman + 1;

            $datas           = mysqli_query($koneksi, "select * from ruangan");
            $jumlah_data    = mysqli_num_rows($datas);
            $total_halaman  = ceil($jumlah_data / 5);


            if (isset($_GET['cari'])) {
                $cari = $_GET['cari'];
                $sql = mysqli_query($koneksi, "SELECT * from ruangan where nama_ruangan like '%" . $cari . "%'");
            } else {
                $sql   = mysqli_query($koneksi, "select * from ruangan limit $halaman_awal, 4");
            }
            $nomor          = $halaman_awal + 1;
            $no = 1;

            while ($data = mysqli_fetch_array($sql)) {
            ?>
                <tr style="text-align:center;">
                    <td width="1" align="center"><?php echo $no++; ?></td>
                    <td><?php echo $data['nama_ruangan']; ?></td>
                    <td><?php echo $data['tempat']; ?></td>
                    <td><?php echo $data['kapasitas']; ?></td>
                    <td width="1">
                        <div style="display: flex; justify-content: center; row; gap: 8px;">
                            <a href="ruangan_ubah.php?no=<?php echo $data['no']; ?>" class="btn btn-info" style="align-content: center; padding-left: 8px; padding-right: 8px;">Ubah <img src="../gambar/edit.png" alt="edit"></a>
                            <a href="ruangan_hapus.php?no=<?php echo $data['no']; ?>" class="btn btn-danger" style="align-content: center; padding-left: 8px; padding-right: 8px;">Hapus <img src="../gambar/hapus.png" alt="hapus"></a>
                            <a href="ruangan_detail.php?no=<?php echo $data['no']; ?>" class="btn btn-warning" style="align-content: center; padding-left: 8px; padding-right: 8px;">Detail <img src="../gambar/detail.png" alt="detail"></a>
                        </div>                    
                    </td>
                </tr>
            <?php } ?>
        </table>
        </div>            

        <nav>
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" <?php if ($halaman > 1) {
                                                echo "href='?halaman=$sebelum'";
                                            } ?>>Previous</a>
                </li>
                <?php
                for ($x = 1; $x <= $total_halaman; $x++) {
                ?>
                    <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"> <?php echo $x; ?></a></li>
                <?php
                }
                ?>
                <li class="page-item">
                    <a class="page-link" <?php if ($halaman < $total_halaman) {
                                                echo "href='?halaman=$setelah'";
                                            } ?>>Next</a>
                </li>
            </ul>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>