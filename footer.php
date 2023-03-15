
           <footer><p>All right reserved. Template by: <a href="https://webthemez.com/admin-template/">WebThemez.com</a></p></footer>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    </div>
            
    
    <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->

    <!-- jQuery Js -->
    <!-- <script src="assets/js/jquery-1.10.2.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="assets/materialize/js/materialize.min.js"></script>
	
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
	
	
	<script src="assets/js/easypiechart.js"></script>
	<script src="assets/js/easypiechart-data.js"></script>
	
	 <script src="assets/js/Lightweight-Chart/jquery.chart.js"></script>
	<!-- DATA TABLE SCRIPTS -->

    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>

  

   <!-- Bootstrap Js -->
   <script src="assets/js/bootstrap.min.js"></script>
   
    <script type="text/javascript">
$(document).ready(function() {

    var fieldRecords = $('#fieldRecord').DataTable({
        "lengthChange": true,
        "processing":true,
        "serverSide":true,          
        'serverMethod': 'post',     
        "order":[],
        "ajax":{
            url:"process.php?process=listFields",
            type:"POST",
            data:{process:'listFields'},
            dataType:"json"
        },
        "columnDefs":[
            {
                "targets":[6],
                "orderable":false,
            },
            {"data" : ""}
        ],
        "pageLength": 10
    }); 

    //open update  modal
    $("#fieldRecords").on('click', '.update', function(){
        var id = $(this).attr("id"); //id ditempel di buttonnya

        $.ajax({
            url:'process.php?process=getField',
            method:"POST",
            data:{id:id},
            dataType:"json",
            success:function(data){
                $('#recordModal').modal('show');
                $('#id').val(id);
                $('#fieldName').val(data.FIELD_NAME);
                $('#fieldSize').val(data.FIELD_SIZE);
                $('#fieldPrice').val(data.FIELD_PRICE);              
                $('#fieldImg').val(data.FIELD_IMG);   
                $('#fieldDesc').val(data.FIELD_DESC);   
                $('.modal-title').html("<i class='fa fa-plus'></i> Edit Records");
                $('#action').val('updateRecord');
                $('#save').val('Save');
            }
        })
        $('#fieldModal').modal('show');
        $('#TRANS_ID').val(id);
        $('.modal-title').html("<i class='fa fa-plus'></i> Edit Field");
        $('#action').val('updateRecord');

    });

    //save  update
    $("#fieldModal").on('submit','#fieldForm', function(event){
        event.preventDefault();
        $('#save').attr('disabled','disabled');
        var formData = $(this).serialize();
        $.ajax({
            url:"process.php?process=updateField",
            method:"POST",
            data:formData,
            success:function(data){             
                $('#fieldForm')[0].reset();
                $('#fieldModal').modal('hide');                
                $('#save').attr('disabled', false);
                fieldRecords.ajax.reload();
            }
        })
    });

    var scheduleRecords = $('#scheduleRecords').DataTable({
        "lengthChange": true,
        "processing":true,
        "serverSide":true,          
        'serverMethod': 'post',     
        "order":[],
        "ajax":{
            url:"process.php?process=listSchedule",
            type:"POST",
            data:{process:'listSchedule'},
            dataType:"json"
        },
        "columnDefs":[
            {
                "targets":[3],
                "orderable":false,
            },
            {"data" : ""}
        ],
        "pageLength": 10
    }); 

    function format (d) {
    // `d` is the original data object for the row
        return '<table class="col-md-5 col-sm-5 border-bottom">'+
            '<tr>'+
                
                '<td>QR Code:</td>'+
                '<td>'+d.QR_CODE+'</td>'+
            '</tr>'+
            '<tr>'+
                
                '<td>Telepon:</td>'+
                '<td>'+d.TRANS_PHONE+'</td>'+
            '</tr>'+
            '<tr>'+
                
                '<td>Tanggal Transaksi:</td>'+
                '<td>'+d.TRANS_DATE+'</td>'+
            '</tr>'+
            '<tr>'+
                
                '<td>Total Harga:</td>'+
                '<td>'+d.PAYMENT_TOTAL+'</td>'+
            '</tr>'+
            '<tr>'+
                
                '<td class="last">Slip Pembayaran:</td>'+
                '<td class="last">'+d.PAYMENT_SLIP+'</td>'+
            '</tr>'+
        '</table>';
    }

     // on change filter
    $('#day').change(function(){
        transRecord.draw();
    });
    $('#month').change(function(){
        transRecord.draw();
    });

    $('#year').change(function(){
        transRecord.draw();
    });

    $('#status').change(function(){
        transRecord.draw();
    });
    //datatable transaction
    var transRecord = $('#transRecord').DataTable( {
        "lengthChange": false,
        "processing":true,
        "serverSide":true,          
        'serverMethod': 'post',    
        "order":[[1, 'asc']],
        "stateSave": true,
        // "dom": '<"toolbar">frtip',
        "ajax":{
            url:"process.php?process=listTransaction",
            data: function(data){
              // Read values
              var day = $('#day').val();
              var month = $('#month').val();
              var year = $('#year').val();
              var status = $('#status').val();
       
              // Append to data
              data.day = day;
              data.month = month;
              data.year = year;
              data.status = status;
            },
            type:"POST",
            dataType:"json"
        },
        "columns": [
            {
                "className":'details-control',
                "orderable":false,
                "data":null,
                "defaultContent": '<i class="fa fa-caret-down"></i>'
            },
            { "data": "TRANS_ID" },
            { "data": "BOOK_ID" },
            { "data": "TRANS_NAME" },
            { "data": "FIELD_NAME" },
            { "data": "SCH_DATE" },
            { "data": "SCH_TIME" },
            { "data": "TRANS_STATUS" },
            { 
                "orderable":false,
                "data": "PAYMENT_STATUS"
            },
        ],
        
    } );

    // detail transaction
    $('#transRecord tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = transRecord.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    } );

    //open update status modal
    $("#transRecord").on('click', '.update', function(){
        var id = $(this).attr("id"); //id ditempel di buttonnya
        $('#transModal').modal('show');
        $('#TRANS_ID').val(id);
        $('.modal-title').html("<i class='fa fa-plus'></i> Edit Records");
        $('#action').val('updateRecord');

    });

    //save status update
    $("#transModal").on('submit','#transForm', function(event){
        event.preventDefault();
        $('#save').attr('disabled','disabled');
        var formData = $(this).serialize();
        $.ajax({
            url:"process.php?process=updateTransStatus",
            method:"POST",
            data:formData,
            success:function(data){             
                $('#transForm')[0].reset();
                $('#transModal').modal('hide');                
                $('#save').attr('disabled', false);
                transRecord.ajax.reload();
            }
        })
    }); 
  
} );     
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
        $('#tableReview').DataTable({
            "scrollX": true
        });
    });
    </script>
    <script type="text/javascript">
        //GET SELECTED DATE
        $(document).ready(function() {
            $("#id_lap").change(function(){
                var tanggal = document.getElementById('tanggal_sewa');
                tanggal.value="";
                $("#sel_tanggal").empty();
                var bt = document.getElementById('submit_book');
                bt.disabled = true;
            }),
            $("#tanggal_sewa").change(function() {
                var bt = document.getElementById('submit_book');
                var opt = document.getElementById('sel_tanggal');
                opt.disabled = false;
                bt.disabled = false;
                $("#sel_tanggal").empty();
                var date = $(this).val();
                var selectLap = document.getElementById("id_lap");
                var field_id = selectLap.value;
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
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script> 
 
</body>

</html>