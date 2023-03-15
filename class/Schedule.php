<?php
class Schedule {	
   
	private $scheduleTable = 'schedule';
	public $SCH_ID;
	public $SCH_TIME;
	public $FIELD_ID;
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listSchedule(){
		
		$sqlQuery = "SELECT a.*, b.FIELD_NAME FROM ".$this->scheduleTable." as a join field as b on a.FIELD_ID = b.FIELD_ID ";
		
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(SCH_ID LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR FIELD_NAME LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR SCH_TIME LIKE "%'.$_POST["search"]["value"].'%") ';
		}

		if(!empty($_POST["order"])){
			$orderIndex = $_POST['order']['0']['column'] + 1;// adding "+1" because of error index in the data table 
			$sqlQuery .= 'ORDER BY '.$_POST['columns'][$orderIndex]['data'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY SCH_ID ASC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		
		// die($sqlQuery);
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->scheduleTable);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allSchedule = $allResult->num_rows;
		
		$displaySchedule = $result->num_rows;
		$schedule_ = array();		
		while ($schedule = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $schedule['SCH_ID'];
			$rows[] = $schedule['SCH_TIME'];
			$rows[] = $schedule['FIELD_NAME'];
			$rows[] = '<button type="button" FIELD_NAME="update" SCH_ID="'.$schedule["SCH_ID"].'" class="btn btn-warning btn-xs update">Update</button>&nbsp&nbsp<a href="process.php?process=deleteSchedule&SCH_ID='.$schedule["SCH_ID"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
			$schedule_[] = $rows;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displaySchedule,
			"iTotalDisplayRecords"	=>  $allSchedule,
			"data"	=> 	$schedule_
		);
		
		echo json_encode($output);
		
	}
	
	public function addRecord(){
		
		if($this->FIELD_ID) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->scheduleTable."(`SCH_ID`, `SCH_TIME`, `FIELD_ID`)
			VALUES(?,?,?)");
		
			$this->SCH_ID = htmlspecialchars(strip_tags($this->SCH_ID));
			$this->SCH_TIME = htmlspecialchars(strip_tags($this->SCH_TIME));
			$this->FIELD_ID = htmlspecialchars(strip_tags($this->FIELD_ID));
			
			$stmt->bind_param("iii", $this->SCH_ID, $this->SCH_TIME, $this->FIELD_ID);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}
}
?>