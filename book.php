<?php
$page = "book";
include('header.php');
include('navbar.php');

?> 
        <div id="page-wrapper">
            <div class="header"> 
                <h1 class="page-header">Booking</h1>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Book</a></li>
					<li class="active">Tambah Booking</li>
				</ol> 					
            </div>
            <div id="page-inner">
                <div class="row">                    
                   <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="card">
                            <div class="card-action">
                                 Tambah Booking
                            </div>
                            <div class="card-content">
                                <form class="row" method="post" action="process.php?process=insert-book-offline">
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
                                                    <label for="id_lap">Lapangan : </label>
                                                    <select class="form-control" id="id_lap" name="id_lap">
                                                    <?php
                                                    include('db_connect.php');
                                                    $sql = "SELECT * FROM field";
                                                    $result = mysqli_query($conn, $sql);
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                                            <option <?php echo "value='$row[FIELD_ID]'";; ?>><?php echo "$row[FIELD_NAME]";; ?></option>  
                                                    <?php 
                                                        }
                                                    }
                                                    ?>
                                                        
                                                    </select>
                                                    <!-- <input type="text" class="form-control" id="lapangan" <?php echo "value='$field_name'"; ?>disabled> --><!-- 
                                                    <input name="id_lap" type="hidden" class="form-control" id="id_lap" <?php echo "value='$field_id'"; ?>> -->
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
                                        <input type="hidden" name="price" value="0">
                                        <input type="submit" class="btn btn-danger btn-lg btn-block" value="Pesan" disabled id="submit_book">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--End Advanced Tables -->
                    </div>
                </div>
				  <!-- /. ROW  -->
<?php
include('footer.php');
?>