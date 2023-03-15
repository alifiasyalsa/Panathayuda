<?php
$page = "schedule";
include('header.php');
include('navbar.php');
?> 
        <div id="page-wrapper">
            <div class="header"> 
                <h1 class="page-header">Schedule</h1>
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Schedule</a></li>
                    <li class="active">Data</li>
                </ol>                   
            </div>
            <div id="page-inner">
               <div class="row">
                <div class="col-md-12">
                    <div class="card col-md-12" style="padding: 0px !important;">
                        <div class="card-action">
                            Tambah Data Schedule
                        </div>
                        <div class="card-content">
                            <form method="post" action="process.php?process=addSchedule">
                                <div class="col-md-6">
                                    <label for="field">Lapangan</label>
                                    <select id="field" name="field" class="form-control">
                                        <option value="0" selected>Choose...</option>
                                        <?php
                                            include('db_connect.php');
                                            $sql = "SELECT * FROM field";
                                            $result = mysqli_query($conn, $sql);
                                            $row_num = 1;
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) { 
                                                    echo "<option value=".$row['FIELD_ID'].">".$row['FIELD_NAME']."</option>";
                                                }
                                            }

                                        ?>
                                    </select>
                                </div>
                               <div class="form-group col-md-2">
                                    <label for="timeStart">Waktu Mulai </label>
                                    <input type="time" class="form-control" id="timeStart" name="startTime">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="timeFinish">Waktu Selesai</label>
                                    <input type="time" class="form-control" id="timeFinish" name="finishTime">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="add_schedule">&nbsp;</label>
                                    <button type="submit" id="add_schedule" class="btn btn-success form-control">Tambah Data</button>
                                </div>
                                        
                            </form>
                        </div>
                    </div>
                </div>
               </div>
                <div class="row">                    
                   <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="card">
                            <div class="card-action">
                                 Kelola Data Schedule
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="scheduleRecords">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Waktu</th>
                                                <th>Nama Lapangan</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                        <!--End Advanced Tables -->
                    </div>
                </div>
                  <!-- /. ROW  -->
<?php
include('footer.php');
?>