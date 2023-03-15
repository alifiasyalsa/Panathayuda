<?php
include('db_connect.php');
include('assets/lib/phpqrcode/qrlib.php');
if (isset($_GET['id_trans'])) {
    $id_trans = $_GET['id_trans'];
    $sql = "SELECT * FROM transaction as t INNER JOIN book_schedule as b ON(t.BOOK_ID=b.BOOK_ID) WHERE TRANS_ID='$id_trans'";
    $result = mysqli_query($conn, $sql);
    $nama = '';
    $tanggal = '';
    $waktu = '';
    $harga = 0;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nama = $row['TRANS_NAME'];
            $tanggal = $row['SCH_DATE'];
            $waktu = $row['SCH_TIME'];
            $harga = $row['PAYMENT_TOTAL'];
        }
    }
} else {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Aplikasi Penyewaan Lapangan di Kawasan GOR Panatayudha</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--

TemplateMo 546 Sixteen Clothing

https://templatemo.com/tm-546-sixteen-clothing

-->

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <header class="">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <h2>Gor <em>Panatayudha</em></h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="home.php">Home
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="home.php#lapangan">Lapangan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="home.php#about">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="upload.php">Upload DP</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container-fluid" style="padding-top: 80px;">
        <div class="row">
            <div class="col-md-12 confirm-bg">
                <div class="confirm-contain">
                    <div class="row" style="height:100%;">
                        <div class="col-md-5" style="height:100%;">
                            <div class="qr-box">
                                <?php
                                $filename = 'assets/images/qrcode/' . $id_trans . '.png';
                                QRcode::png($id_trans, $filename, QR_ECLEVEL_L, 10);
                                ?>
                                <img <?php echo "src='$filename'"; ?> height="100%">
                            </div>
                        </div>
                        <div class="col-md-7" style="height: 100%;">
                            <div class="confirm-desc">
                                <h4><b>Book Berhasil !</b></h4>
                                <p>Nama Penyewa : <?php echo "$nama"; ?></p>
                                <p>Jadwal Sewa : <?php $date = date_create($tanggal);
                                                    echo date_format($date, "D, d F Y "); ?> Sesi 1 (<?php echo "$waktu"; ?>)</p>
                                <p class="last-p-confirm">Total Pembayaran : Rp. <?php echo number_format($harga, 0, ',', '.');
                                                                                    ?>,- (DP Rp. <?php echo number_format($harga / 2, 0, ',', '.');
                                                ?>,-)</p>
                                <b>Screenshot halaman ini sekarang !</b>
                                <p>Selanjutnya anda perlu melakukan pembayaran biaya DP booking lapangan
                                    dengan melakukan transfer ke nomor rekening 152913201 (BRI, A.N. Fulan Keren).
                                    Setelah transfer DP, untuk pelunasan pembayaran anda melakukan pelunasan ke
                                    petugas di dinas dengan terlebih dahulu menunjukkan QR Code pada halaman ini.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-content">
                        <p>Copyright &copy; 2021 Aplikasi Penyewaan Lapangan di Kawasan GOR Panatayudha.

                            - Design: <a rel="nofollow noopener" href="https://templatemo.com" target="_blank">TemplateMo</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/isotope.js"></script>
    <script src="assets/js/accordions.js"></script>


    <script language="text/Javascript">
        cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
        function clearField(t) { //declaring the array outside of the
            if (!cleared[t.id]) { // function makes it static and global
                cleared[t.id] = 1; // you could use true and false, but that's more typing
                t.value = ''; // with more chance of typos
                t.style.color = '#fff';
            }
        }
    </script>


</body>

</html>