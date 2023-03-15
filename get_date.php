<?php
include("db_connect.php");
if(isset($_POST['tanggal'])){
   $tanggal= mysqli_real_escape_string($conn,$_POST['tanggal']); // department id
   $id_lap= mysqli_real_escape_string($conn,$_POST['id_lap']);
}

   // echo "<script type='text/javascript'>alert('$tanggal$id_lap');</script>";
	$date_arr = array();
   $dateQuery = "SELECT schedule.SCH_TIME FROM schedule WHERE schedule.SCH_TIME NOT IN (SELECT book_schedule.SCH_TIME FROM book_schedule WHERE book_schedule.SCH_DATE ='$tanggal' AND book_schedule.FIELD_ID ='$id_lap') AND FIELD_ID = '$id_lap'";

   $result = mysqli_query($conn,$dateQuery);

   while( $row = mysqli_fetch_array($result) ){
      // $sch_id = $row['SCH_ID'];
      $sch_time = $row['SCH_TIME'];

      $date_arr[] = array("sch_time" => $sch_time);
   }

// encoding array to json format
echo json_encode($date_arr);

?>