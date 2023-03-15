<?php
include('db_connect.php');

$field_id = $_GET['field_id'];
$sql = "SELECT * FROM field WHERE FIELD_ID='$field_id'";
$result = mysqli_query($conn, $sql);
$field_name = '';
$field_desc = '';
$field_img = '';
$field_price = 0;
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $field_name = $row['FIELD_NAME'];
        $field_desc = $row['FIELD_DESC'];
        $field_img = $row['FIELD_IMG'];
        $field_price = $row['FIELD_PRICE'];
    }
}
$sql = "SELECT * FROM review WHERE FIELD_ID='$field_id' AND REVIEW_STATUS='approved' ORDER BY REVIEW_ID DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$rv_nama = '';
$rv_desc = '';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rv_nama = $row['REVIEW_NAME'];
        $rv_desc = $row['REVIEW_DESC'];
    }
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

    <!-- FullCalendar css -->
    <link rel="stylesheet" href="vendor/fullcalendar/main.css">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/font-awesome.css">
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
                        <li class="nav-item" >
                            <a class="nav-link" href="home.php">Home</a>
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

    <div class="container" style="padding-top: 80px;">
        <div class="row" style="padding-top: 20px;">
            <div class="col-md-12">
                <img <?php echo "src='$field_img'"; ?> class="img-detail">
                <div class="section-heading sh-detail">
                    <h2><?php echo "$field_name"; ?></h2>
                </div>
                <b>Booking <?php echo "$field_name"; ?></b>
            </div>

            <div class="col-md-12 form-booking">
                <form class="row" method="post" action="process.php?process=insert-book">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_penyewa">Nama Penyewa : </label>
                            <input name="nama" type="text" class="form-control" id="nama_penyewa" placeholder="Masukkan Nama Anda" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_tlp">Nomor Telepon : </label>
                                    <input name="phone" type="tel" class="form-control" id="no_tlp" placeholder="Nomor Telepon Anda" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lapangan">Lapangan : </label>
                                    <input type="text" class="form-control" id="lapangan" <?php echo "value='$field_name'"; ?>disabled>
                                    <input name="id_lap" type="hidden" class="form-control" id="id_lap" <?php echo "value='$field_id'"; ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal_sewa">Tanggal Sewa : </label>
                            <?php
                            $tomorrow = date("Y-m-d", strtotime("tomorrow"));
                            $nextweek = date("Y-m-d", strtotime("+1 week"));
                            ?>
                            <input name="tanggal" type="date" class="form-control" id="tanggal_sewa" placeholder="Pilih Tanggal Sewa" <?php echo "min='$tomorrow' max='$nextweek'"; ?> required>
                        </div>
                        <div class="form-group">
                            <label for="Waktu Sewa">Waktu Sewa : </label>
                            <select class="form-control" id='sel_tanggal' name="waktu">
                                <option>Pilih Sesi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <small class="note-detail">
                            <b>*Note :</b>
                            <br />Jika anda ingin melakukan booking untuk 2 sesi, maka anda perlu melakukan pemesanan
                            secara terpisah (satu persatu)
                        </small>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="price" <?php echo "value='$field_price'"; ?>>
                        <input type="submit" class="btn btn-danger btn-lg btn-block" value="Pesan" disabled id="submit_book">
                    </div>
                </form>
            </div>

            <div class="col-md-12 jadwal-lapangan">
                <b>Jadwal Lapangan 1</b>
                <div id='calendar'></div>
            </div>
        </div>
    </div>

    <div class="best-features" id="about">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="deskripsi-detail">
                        <b>Deskripsi <?php echo "$field_name"; ?></b>
                        <p><?php echo "$field_desc"; ?></p>
                        <div class="desc-det-img row">
                            <div class="col-md-1 icon-big">
                                <i class="fa fa-arrows-alt fa-lg"></i>
                            </div>
                            <div class="col-md-5">
                                <b>Luas Lapangan</b>
                                <p>20.111 m<sup>2</sup></p>
                            </div>
                            <div class="col-md-1 icon-big">
                                <i class="fa fa-dollar fa-lg"></i>
                            </div>
                            <div class="col-md-5">
                                <b>Harga Sewa</b>
                                <p>Rp. <?php echo number_format($field_price, 0, ',', '.');
                                        ?>,- / sesi</p>
                            </div>
                        </div>
                        <b>Latest Review</b>
                        <p>"<?php echo "$rv_desc"; ?>"</p>
                        <p>-<?php echo "$rv_nama"; ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-review">
                        <h3><b>Berikan Review Anda</b></h3>
                        <form method="post" action="process.php?process=insert-review">
                            <div class="form-group">
                                <label for="nama_review">Nama : </label>
                                <input name="rv_nama" type="text" class="form-control" id="nama_review" placeholder="Masukkan Nama Anda">
                            </div>
                            <div class="form-group">
                                <label for="review">Review : </label>
                                <textarea name="rv_desc" class="form-control" id="review"></textarea>
                            </div>
                            <input name="id_lap" type="hidden" <?php echo "value='$field_id'"; ?>>
                            <input type="submit" class="btn btn-danger btn-lg btn-block" value="Pesan">
                        </form>
                    </div>
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

    <!-- FullCalendar JS -->
    <script src="vendor/fullcalendar/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var field_id = document.getElementById("id_lap").value;
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {
                    url: 'get_events.php',
                    method: 'POST',
                    extraParams: {
                      id_lap: field_id,
                    },
                    failure: function(e) {
                      alert('there was an error while fetching events!'+e.message);
                    },
                    color: 'yellow',   // a non-ajax option
                    textColor: 'black' // a non-ajax option
                  }
            });
            calendar.render();
        });
    </script>


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
    <script type="text/javascript">
        //GET SELECTED DATE
        $(document).ready(function() {
            $("#tanggal_sewa").change(function() {
                var bt = document.getElementById('submit_book');
                var opt = document.getElementById('sel_tanggal');
                opt.disabled = false;
                bt.disabled = false;
                $("#sel_tanggal").empty();
                var date = $(this).val();
                var field_id = document.getElementById("id_lap").value;
                $.ajax({
                    type: 'POST',
                    url: 'get_date.php',
                    data: {
                        tanggal: date,
                        id_lap: field_id
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        var jsonData = JSON.parse(data);
                        if (jsonData.length == 0) {
                            bt.disabled = true;
                            $("#sel_tanggal").append("<option value='penuh'>Penuh</option>");
                            opt.disabled = true;
                        }
                        for (var i = 0; i < jsonData.length; i++) {
                            var obj = jsonData[i];
                            console.log(obj.sch_time);
                            $("#sel_tanggal").append("<option value='" + obj.sch_time + "'>" + obj.sch_time + "</option>");
                        }
                    },
                    error: function(xhr, status, error) {

                    },
                    dataType: 'text'
                });
            });
        });
    </script>



</body>

</html>