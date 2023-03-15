<?php
class Fields {	
   
	private $fieldsTable = 'field';
	public $FIELD_FIELD_ID;
    public $FIELD_FIELD_NAME;
    public $FIELD_PRICE;
    public $FIELD_SIZE;
    public $FIELD_IMG;
    public $FIELD_DECS;
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listFields(){
		
		$sqlQuery = "SELECT * FROM ".$this->fieldsTable." ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(FIELD_ID LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR FIELD_NAME LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR FIELD_PRICE LIKE "%'.$_POST["search"]["value"].'%") ';
		}
		
		if(!empty($_POST["order"])){
			$orderIndex = $_POST['order']['0']['column'] + 1;// adding "+1" because of error index in the data table 
			$sqlQuery .= 'ORDER BY '.$_POST['columns'][$orderIndex]['data'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY FIELD_ID ASC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->fieldsTable);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allField = $allResult->num_rows;
		
		$displayField = $result->num_rows;
		$fields = array();		
		while ($field = $result->fetch_assoc()) { 				
			$rows = array();			
			$rows[] = $field['FIELD_ID'];
			$rows[] = $field['FIELD_NAME'];
			$rows[] = $field['FIELD_PRICE'];		
			$rows[] = "<img src='assets/images/upload/".$field['FIELD_IMG']."' width='100px' height='100px'/>";
			$rows[] = $field['FIELD_SIZE'];
			$rows[] = $field['FIELD_DESC'];
			$rows[] = '<button type="button" FIELD_NAME="update" FIELD_ID="'.$field["FIELD_ID"].'" class="btn btn-warning btn-xs update">Update</button>&nbsp&nbsp<a href="process.php?process=deleteField&FIELD_ID='.$field["FIELD_ID"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
			$fields[] = $rows;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displayField,
			"iTotalDisplayRecords"	=>  $allField,
			"data"	=> 	$fields
		);
		
		echo json_encode($output);
		
	}
	
	
}
?>