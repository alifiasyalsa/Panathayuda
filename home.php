<?php
include('db_connect.php');
$sql = "SELECT field.FIELD_ID,field.FIELD_NAME,field.FIELD_DESC,field.FIELD_IMG,SUM(IF(review.REVIEW_STATUS = 'approved',1,0)) as REVIEW_COUNT FROM field LEFT JOIN review ON(field.FIELD_ID = review.FIELD_ID) GROUP BY field.FIELD_ID ";
$result = mysqli_query($conn, $sql);
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
        <a class="navbar-brand" href="home.php">
          <h2>Gor <em>Panatayudha</em></h2>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active" id="nav_home">
              <a class="nav-link" href="home.php">Home
                <!-- <span class="sr-only">(current)</span> -->
              </a>
            </li>
            <li class="nav-item" id="nav_lapangan">
              <a class="nav-link" href="#lapangan">Lapangan</a>
            </li>
            <li class="nav-item" id="nav_about">
              <a class="nav-link" href="#about">About Us</a>
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

  <!-- Page Content -->
  <!-- Banner Starts Here -->
  <div class="banner header-text">
    <div class="owl-banner owl-carousel">
      <div class="banner-item-01">
        <div class="text-content">
          <h4>Booking Lapangan</h4>
          <h2>Jadi lebih mudah !</h2>
        </div>
      </div>
      <!-- <div class="banner-item-02">
          <div class="text-content">
            <h4>Flash Deals</h4>
            <h2>Get your best products</h2>
          </div>
        </div>
        <div class="banner-item-03">
          <div class="text-content">
            <h4>Last Minute</h4>
            <h2>Grab last minute deals</h2>
          </div>
        </div> -->
    </div>
  </div>
  <!-- Banner Ends Here -->

  <div class="latest-products" id="lapangan">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>List Lapangan</h2>
            <!-- <a href="products.html">view all products <i class="fa fa-angle-right"></i></a> -->
          </div>
        </div>
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="col-md-4">
              <div class="product-item">
                <?php echo "<a href='detail.php?field_id=$row[FIELD_ID]'><img src='$row[FIELD_IMG]' alt=''></a>"; ?>
                <div class="down-content">
                  <?php echo "<a href='detail.php?field_id=$row[FIELD_ID]'><h4>$row[FIELD_NAME]</h4></a>"; ?>
                  <p><?php echo "$row[FIELD_DESC]"; ?></p>
                  <ul class="stars">
                    <li></li>
                    <!--    <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li> -->
                  </ul>
                  <span>Reviews (<?php echo "$row[REVIEW_COUNT]"; ?>)</span>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          echo "No result";
        }
        ?>
      </div>
    </div>
  </div>

  <div class="best-features" id="about">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-heading">
            <h2>About Us</h2>
          </div>
        </div>
        <div class="col-md-6">
          <div class="left-content">
            <p>Lokasi Kawasan GOR Panatayudha cukup strategis yaitu di Jalan Jenderal Ahmad Yani, Kabupaten Karawang sehingga mudah diakses oleh masyarakat. 
            Luas Kawasan GOR Panatayudha adalah 15.750 m². </p>
            <p>Kawasan GOR Panatayudha terdiri dari Gedung Olahraga (GOR) Panatayudha yang didalamnya terdapat 3 (tiga) lapangan untuk aktivitas olahraga bulutangkis, tenis meja, taekwondo, karate, dan pencak silat dengan kapasitas 1000 orang penonton. </p>
            <p>Kegiatan operasional di Kawasan GOR Panatayudha berupa kegiatan penyewaan lapangan yang buka setiap hari dengan jam operasional dari pukul 07.00 sampai pukul 22.00. 
            Fasilitas pendukung di Kawasan GOR Panatayudha antara lain masjid, toilet, area parkir, kios-kios makanan, panggung, dan ruang kantor sekretariat.</p>
            <h4>GOR PANATAYUDHA</h4>
            <div class="row contact-about">
              <div class="col-md-1">
                <i class="fa fa-map-marker"></i>
              </div>
              <div class="col-md-9">
                <a href="https://goo.gl/maps/anXnc6JASX6RQKEK6">
                  <p><u>Kawasan GOR Panatayudha Kabupaten Karawang, Jalan Jenderal Ahmad Yani, Kecamatan Karawang Barat, Kabupaten Karawang, Jawa Barat 40302.</u></p>
                </a>
              </div>
            </div>
            <div class="row contact-about">
              <div class="col-md-1">
                <i class="fa fa-phone "></i>
              </div>
              <div class="col-md-9">
                <p>0857-7493-4066</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="right-image">
            <img src="assets/images/about-img.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- <div class="call-to-action">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="inner-content">
              <div class="row">
                <div class="col-md-8">
                  <h4>Creative &amp; Unique <em>Sixteen</em> Products</h4>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque corporis amet elite author nulla.</p>
                </div>
                <div class="col-md-4">
                  <a href="#" class="filled-button">Purchase Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->


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

  <script>
    $(document).ready(function() {
      var nav_home = document.getElementById('nav_home');
      var nav_lapangan = document.getElementById('nav_lapangan');
      var nav_about = document.getElementById('nav_about');
      $(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 500 && scroll < 1000) {
          nav_home.classList.remove('active');
          nav_lapangan.classList.add('active');
          nav_about.classList.remove('active');
        } else if (scroll >= 1000) {
          nav_home.classList.remove('active');
          nav_lapangan.classList.remove('active');
          nav_about.classList.add('active');
        } else {
          nav_home.classList.add('active');
          nav_lapangan.classList.remove('active');
          nav_about.classList.remove('active');
        }
      });
    });
  </script>


</body>

</html>