<?php
include("db_connect.php");
$id_lap = $_POST['id_lap'];
$sth = mysqli_query($conn, "SELECT BOOK_ID as id, SCH_TIME as title, SCH_DATE as start from book_schedule WHERE FIELD_ID='$id_lap'");
$rows = array();
while($r = mysqli_fetch_assoc($sth)) {
    $rows[] = $r;
}
print json_encode($rows);
?>