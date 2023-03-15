<?php
$page = "transaction";
include('header.php');
include('navbar.php');
?> 

        <div id="page-wrapper">
            <div class="header"> 
                <h1 class="page-header">Transaksi</h1>
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Transaksi</a></li>
                    <li class="active">Data</li>
                </ol>                   
            </div>
            <div id="page-inner">

                <div class="row">  
                                   
                   <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="card">
                            <div class="card-action">
                                 Data Transaksi
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    
                                    <div class="form-group col-xs-2">
                                      <label for="day">Filter</label>
                                      <select id="day" class="form-control">
                                        <option value='0' selected>All Day</option>
                                        <?php 
                                        for($i=1;$i<=31;$i++){
                                           echo "<option value=".$i.">".$i."</option>";        
                                        }
                                        ?>
                                      </select>
                                    </div>
                                    <div class="form-group col-xs-2">
                                      <label for="month">&nbsp;</label>
                                      <select id="month" class="form-control">
                                        <option value='0' selected>All Month</option>
                                        <option value='1'>January</option>
                                        <option value='2'>February</option>
                                        <option value='3'>March</option>
                                        <option value='4'>April</option>
                                        <option value='5'>May</option>
                                        <option value='6'>June</option>
                                        <option value='7'>July</option>
                                        <option value='8'>August</option>
                                        <option value='9'>September</option>
                                        <option value='10'>October</option>
                                        <option value='11'>November</option>
                                        <option value='12'>December</option>
                                      </select>
                                    </div>
                                    <div class="form-group col-xs-2">
                                      <label for="year">&nbsp;</label>
                                      <select id="year" class="form-control">
                                        <option value='0' selected>All Year</option>
                                        <option value='2020'>2020</option>
                                        <option value='2021'>2021</option>
                                      </select>
                                    </div>
                                    <div class ="col-xs-2">
                                        <label for="status">&nbsp;</label>
                                        <select id="status" class="form-control">
                                            <option value='0' selected>All Status</option>
                                            <option value='BOOK'>BOOK</option>
                                            <option value='DP'>DP</option>
                                            <option value='CANCEL'>CANCEL</option>
                                            <option value='LUNAS'>LUNAS</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-2"></div>
                                    <div class ="col-xs-2">

                                        <label for="export_button">&nbsp;</label>
                                        <button type="button" id="export_button" class="btn btn-success btn-icon-sm form-control" onclick="export_trans()" ><i class="fa fa-download"></i> Export </button>
                                        <a href="javascript:void(0)" id="dlbtn" style="display: none;">
                                            <button type="button" id="mine">Export</button>
                                        </a>
                                    </div>                                
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover display" id="transRecord">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>#</th>
                                                <th>ID Booking</th>
                                                <th>Nama Penyewa</th>
                                                <th>Lapangan</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Status</th>
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
<script>
    function export_trans(){
        
        
        table = $('#transRecord').DataTable();
        var search =  table.search();
        var day = $('#day').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var year = $('#status').val();

        $.ajax({
            url: "process.php?process=exportTransaction",
            type: 'post',
            dataType: 'html',
            data: { search: search, day:day, month:month, year:year, status:status },
            success: function(result) {
              console.log(result);
              setTimeout(function() {
                      var dlbtn = document.getElementById("dlbtn");
                      var file = new Blob([result], {type: 'application/octet-stream'});
                      dlbtn.href = URL.createObjectURL(file);
                      dlbtn.download = 'rekap_transaksi.xls';
                      $( "#mine").click();
                    }, 2000);
            }
        });
    }

</script>


<div id="transModal" class="modal fade">
                <div class="modal-dialog">
                    <form method="post" id="transForm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h4 class="modal-title"><i class="fa fa-plus"></i> Update Status</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group"
                                    <label for="transStatus" class="control-label">Status Pembayaran</label>
                                    <select id="transStatus" name="TRANS_STATUS" class="form-control">
                                        <option>Choose..</option>
                                        <option value="CANCEL">CANCEL</option>
                                        <option value="DP">DP</option>
                                    </select>       
                                </div>                  
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="TRANS_ID" id="TRANS_ID" value="" />
                                <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


<?php

include('footer.php');
?>