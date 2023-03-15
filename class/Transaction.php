<?php
date_default_timezone_set('Asia/Jakarta');
class Transaction {	
   
	private $transTable = 'transaction';
	private $bookTable = 'book_schedule';
	private $fieldTable = 'field';
	public $TRANS_ID;
	public $BOOK_ID;
	public $QR_CODE;
	public $TRANS_NAME;
	public $TRANS_PHONE;
	public $TRANS_DATE;
	public $PAYMENT_TOTAL; 
	public $PAYMENT_SLIP;
	public $status;
	public $SCH_DATE;
	public $SCH_TIME;
	public $FIELD_NAME;
	public $day;
	public $month;
	public $year;
	public $search;

	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listTransaction(){

		$sqlQuery = "SELECT 
						a.*,
						b.SCH_DATE, 
						b.SCH_TIME,
						c.FIELD_NAME
					 FROM ".$this->transTable." as a 
					 JOIN ".$this->bookTable." as b 
					 	ON a.BOOK_ID = b.BOOK_ID
					 JOIN ".$this->fieldTable." as c
					    ON b.FIELD_ID = c.FIELD_ID ";

		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(a.TRANS_ID LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR a.BOOK_ID LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR a.TRANS_NAME LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR c.FIELD_NAME LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR b.SCH_DATE LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR b.SCH_TIME LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR a.TRANS_STATUS LIKE "%'.$_POST["search"]["value"].'%"';
			$sqlQuery .= ' OR a.TRANS_DATE LIKE "%'.$_POST["search"]["value"].'%"';
			// die($sqlQuery);
			
			if($this->day != '0'){ $sqlQuery .= ' and DAY(b.SCH_DATE) ='.$this->day.' '; }
			if($this->month != '0'){ $sqlQuery .= ' and MONTH(b.SCH_DATE) ='.$this->month.' '; }
			if($this->year != '0'){ $sqlQuery .= ' and YEAR(b.SCH_DATE) ='.$this->year.' '; } 
			// if($this->status != '0'){ $sqlQuery .= ' and a.TRANS_STATUS ='.$this->status.' '; } 
			$sqlQuery .= ' ) ';	
			
		}else{
			if($this->day != '0'){
				$sqlQuery .= ' where DAY(b.SCH_DATE) ='.$this->day.' ';
				if($this->month != '0'){ $sqlQuery .= ' and MONTH(b.SCH_DATE) ='.$this->month.' '; }
				if($this->year != '0'){$sqlQuery .= ' and YEAR(b.SCH_DATE) ='.$this->year.' ';}
				// die($sqlQuery);
			}
			else if($this->month != '0'){
				$sqlQuery .= ' where MONTH(b.SCH_DATE) ='.$this->month.' ';
				if($this->year != '0'){$sqlQuery .= ' and YEAR(b.SCH_DATE) ='.$this->year.' ';}
			}
			else if($this->year != '0'){
				$sqlQuery .= ' where YEAR(b.SCH_DATE) ='.$this->year.' ';
			}

			// if($this->status != '0'){ $sqlQuery .= ' and a.TRANS_STATUS ='.$this->status.' '; } 
			
		} 


		if(!empty($_POST["order"])){
			$orderIndex = $_POST['order']['0']['column'];
			$sqlQuery .= 'ORDER BY '.$_POST['columns'][$orderIndex]['data'].' '.$_POST['order']['0']['dir'].' ';
			
		} else {
			$sqlQuery .= 'ORDER BY TRANS_ID ASC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		
		// die($sqlQuery);
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->transTable);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allTrans = $allResult->num_rows;
		
		$displayTrans = $result->num_rows;
		$trans_ = array();		

		while ($trans = $result->fetch_assoc()) {
			$rows = array();			
			$rows['TRANS_ID'] = $trans['TRANS_ID'];
			$rows['BOOK_ID'] = $trans['BOOK_ID'];
			$rows['TRANS_NAME'] = $trans['TRANS_NAME'];		
			$rows['FIELD_NAME'] = $trans['FIELD_NAME'];		
			$rows['SCH_DATE'] = $trans['SCH_DATE'];	
			$rows['SCH_TIME'] = $trans['SCH_TIME'];	
			$rows['TRANS_STATUS'] = $trans['TRANS_STATUS'];
			$rows['QR_CODE'] = $trans['QR_CODE'];
			$rows['TRANS_PHONE'] = $trans['TRANS_PHONE'];
			$rows['TRANS_DATE'] = $trans['TRANS_DATE'];
			$rows['PAYMENT_TOTAL'] = $trans['PAYMENT_TOTAL'];
			$rows['PAYMENT_SLIP'] = $trans['PAYMENT_SLIP'];

			($rows['TRANS_STATUS'] == "LUNAS" || $rows['TRANS_STATUS'] == "CANCEL" )? $status = " disabled" : $status = "";
			$id = $rows['TRANS_ID'];
			// $rows['PAYMENT_STATUS'] = '<button type="button" name="update" id="'.$rows["TRANS_ID"].'" class="btn btn-warning btn-xs update"'.$status.'>Update</button>';
			$now = (new \DateTime())->format('Y-m-d H:i:s');
			$confirmLimitTime = date('Y-m-d H:i:s', strtotime( '+1 hour', strtotime($rows['TRANS_DATE'])));
			// echo $confirmLimitTime;
			// die();
			// if($now >= $confirmLimitTime && $rows['TRANS_STATUS'] == "BOOK" || $rows['TRANS_STATUS'] == "CANCEL" ){
			// 	$rows['PAYMENT_STATUS'] = "<a href='process.php?process=cancelTrans&TRANS_ID=".$id."' class='btn btn-sm btn-warning update'".$status.">Cancel</a>";
			if($now >= $confirmLimitTime && $rows['TRANS_STATUS'] == "BOOK" || $rows['TRANS_STATUS'] == "CANCEL" ){
				$rows['PAYMENT_STATUS'] = '<button type="button" name="update" id="'.$rows['TRANS_ID'].'" class="btn btn-warning btn-xs update" '.$status.'>Update Status</button>';
			}else if($rows['TRANS_STATUS'] == "DP" || $rows['TRANS_STATUS'] == "LUNAS"){
				$rows['PAYMENT_STATUS'] = "<a href='process.php?process=lunasTrans&TRANS_ID=".$id."' class='btn btn-sm btn-primary' ".$status.">Lunas</a>";
			}else{
				$rows['PAYMENT_STATUS'] = "Menunggu Konfirmasi"; // kurang dari batas waktu konfirmasi dan belum melakukan cancel
			}
			
			
			$trans_[] = $rows;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displayTrans,
			"iTotalDisplayRecords"	=>  $allTrans,
			"data"	=> 	$trans_
		);
		
		echo json_encode($output);
		
	}
	
	public function exportTransaction(){
		

		$sqlQuery = "SELECT 
						a.*,
						b.SCH_DATE, 
						b.SCH_TIME,
						c.FIELD_NAME
					 FROM ".$this->transTable." as a 
					 JOIN ".$this->bookTable." as b 
					 	ON a.BOOK_ID = b.BOOK_ID
					 JOIN ".$this->fieldTable." as c
					    ON b.FIELD_ID = c.FIELD_ID ";

		if($this->search != null){
			$sqlQuery .= 'where(a.TRANS_ID LIKE "%'.$this->search.'%" ';
			$sqlQuery .= ' OR a.BOOK_ID LIKE "%'.$this->search.'%" ';
			$sqlQuery .= ' OR a.TRANS_NAME LIKE "%'.$this->search.'%" ';
			$sqlQuery .= ' OR c.FIELD_NAME LIKE "%'.$this->search.'%" ';
			$sqlQuery .= ' OR b.SCH_DATE LIKE "%'.$this->search.'%" ';
			$sqlQuery .= ' OR b.SCH_TIME LIKE "%'.$this->search.'%" ';
			$sqlQuery .= ' OR a.TRANS_STATUS LIKE "%'.$this->search.'%"';
			// die($sqlQuery);
			
			if($this->day != '0'){ $sqlQuery .= ' and DAY(b.SCH_DATE) ='.$this->day.' '; }
			if($this->month != '0'){ $sqlQuery .= ' and MONTH(b.SCH_DATE) ='.$this->month.' '; }
			if($this->year != '0'){ $sqlQuery .= ' and YEAR(b.SCH_DATE) ='.$this->year.' '; } 
			// if($this->status != '0'){ $sqlQuery .= ' and a.TRANS_STATUS ='.$this->status.' '; } 
			$sqlQuery .= ' ) ';	
			
		}else{
			if($this->day != '0'){
				$sqlQuery .= ' where DAY(b.SCH_DATE) ='.$this->day.' ';
				if($this->month != '0'){ $sqlQuery .= ' and MONTH(b.SCH_DATE) ='.$this->month.' '; }
				if($this->year != '0'){$sqlQuery .= ' and YEAR(b.SCH_DATE) ='.$this->year.' ';}
				// die($sqlQuery);
			}
			else if($this->month != '0'){
				$sqlQuery .= ' where MONTH(b.SCH_DATE) ='.$this->month.' ';
				if($this->year != '0'){$sqlQuery .= ' and YEAR(b.SCH_DATE) ='.$this->year.' ';}
			}
			else if($this->year != '0'){
				$sqlQuery .= ' where YEAR(b.SCH_DATE) ='.$this->year.' ';
			}

			// if($this->status != '0'){ $sqlQuery .= ' and a.TRANS_STATUS ='.$this->status.' '; } 
			
		} 

		

		$columnHeader = '';
		$columnHeader = "ID Transaksi". "\t" ."ID Booking". "\t" ."QR Code". "\t" ."Nama Penyewa". "\t" ."No Telepon". "\t" ."Tangal Transaksi". "\t" ."Harga Total". "\t" ."Bukti Pembayaran". "\t" ."Status". "\t" ."Tanggal Booking". "\t" ."Waktu Booking". "\t" ."Lapangan". "\t";

		
		$qry = mysqli_query($this->conn, $sqlQuery);
		$setData = '';
		while($row= mysqli_fetch_row($qry))
		{
			$rowData = '';  
		    foreach ($row as $value) {  
		        $value = '"' . $value . '"' . "\t";  
		        $rowData .= $value;  
		    }  
		    $setData .= trim($rowData) . "\n"; 
		}
		header("Content-type: application/octet-stream");  
		header("Content-Disposition: attachment; filename=rekap_transaksi.xls");  
		header("Pragma: no-cache");  
		header("Expires: 0");  
		echo ucwords($columnHeader) . "\n" . $setData . "\n"; 
		
	
		
	}

	public function updateStatus(){
			// echo $this->TRANS_ID;
			$sqlQuery = "UPDATE ".$this->transTable." SET TRANS_STATUS = 'LUNAS' WHERE TRANS_ID =".$this->TRANS_ID.'';	
			die($sqlQuery);
			if (mysqli_query($conn, $updateQuery)) {
	        	header("location:transaction.php");
	        } else {
	        	header("location:transaction.php");
	        }
	}
}
?>