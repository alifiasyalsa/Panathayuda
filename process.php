<?php
include('db_connect.php');
include_once 'class/Fields.php';
include_once 'class/Transaction.php';
include_once 'class/Schedule.php';

session_start();
// if (!isset($_SESSION['username'])) {
//     header("location: index.php");
// }


$field = new Fields($conn);
$trans = new Transaction($conn);
$sch = new Schedule($conn);

switch (mysqli_real_escape_string($conn, $_GET['process'])){
	case 'login':
		if (isset($_POST['username']) && isset($_POST['password'])) {
			$username = mysqli_real_escape_string($conn, $_POST['username']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
			$query = "SELECT * FROM USER WHERE username='$username'";
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) > 0) {
                if ($row = mysqli_fetch_assoc($result)) {
                    if ((string)$row['PASSWORD'] == (string)mysqli_real_escape_string($conn, $_POST['password'])) {
                        $_SESSION['username'] = $row['USERNAME'];
                        $_SESSION['user_level'] = $row['USER_LEVEL'];
                        header('Location: dashboard.php');
                    } else {
                        header('Location: login.php?status=wrong-password');
                    }
                }
            } else {
                header('Location: login.php?status=wrong-username');
            }
		}
        mysqli_close($conn);
		break;

	case 'logout':
		session_destroy();
		header('location: index.php');
		break;
	case 'listFields':
		$field->listFields();
		break;
	case 'getField':
		$FIELD_ID = $_POST['id'];
    	$FIELD_NAME = $_POST['fieldName'];
    	$FIELD_PRICE = $_POST['fieldPrice'];
    	$FIELD_SIZE = $_POST['fieldSize'];
    	$FIELD_IMG = $_FILES['fieldImg']['name'];
    	$FIELD_DECS =$_POST['fieldDesc'];

    	$dir = "assets/images/upload/";
    	$allow = array('png','jpg'); //ekstensi file gambar yang bisa diupload 
	  	$x = explode('.', $FIELD_IMG); //memisahkan nama file dengan ekstensi yang diupload
	 	$ekstensi = strtolower(end($x));
	  	$file_tmp = $_FILES['fieldImg']['tmp_name'];   
	  	$rand_number = rand(1,999);
	  	$FIELD_IMG_UPLOAD = $rand_number.'-'.$FIELD_IMG; //menggabungkan angka acak dengan nama file sebenarnya
        if(in_array($ekstensi, $allow) === true)  {     
            move_uploaded_file($file_tmp, $dir.$FIELD_IMG_UPLOAD);
            $query = "UPDATE field SET FIELD_NAME = '$FIELD_NAME', FIELD_PROCE = $FIELD_PRICE, FIELD_SIZE = '$FIELD_SIZE', FIELD_IMG = '$FIELD_IMG_UPLOAD', FIELD_DESC ='$FIELD_DECS' where FIELD_ID = $id";
            if (mysqli_query($conn, $query)) {
			    header("location:field.php");
			} else {
			    $error_msg= myqsqli_error($conn);
			    echo "<script type='text/javascript'>alert('Insert Field fail : $error_msg');</script>";
			}

        } else {     
             //jika file ekstensi tidak jpg dan png maka alert ini yang tampil
            echo "<script>alert('Ekstensi gambar yang boleh hanya jpg atau png.');window.location='field.php';</script>";
        }
		break;
	case 'addField':
		$field_id = "F01";
        $q1 = "SELECT FIELD_ID FROM field ORDER BY FIELD_ID DESC LIMIT 1";
		$result = mysqli_query($conn, $q1);
		if (mysqli_num_rows($result) > 0) {
			if ($row = mysqli_fetch_assoc($result)) {
				$num = (int)(substr($row['FIELD_ID'],1,4));
				$num = $num + 1;
				if($num>9){
					$field_id = 'F'.$num;
				}else{
					$field_id = 'F0'.$num;
				}
			}
		}

		$FIELD_ID = $field_id;
    	$FIELD_NAME = $_POST['fieldName'];
    	$FIELD_PRICE = $_POST['fieldPrice'];
    	$FIELD_SIZE = $_POST['fieldSize'];
    	$FIELD_IMG = $_FILES['fieldImg']['name'];
    	$FIELD_DECS =$_POST['fieldDesc'];


    	$dir = "assets/images/upload/";
    	$allow = array('png','jpg'); //ekstensi file gambar yang bisa diupload 
	  	$x = explode('.', $FIELD_IMG); //memisahkan nama file dengan ekstensi yang diupload
	 	$ekstensi = strtolower(end($x));
	  	$file_tmp = $_FILES['fieldImg']['tmp_name'];   
	  	$rand_number = rand(1,999);
	  	$FIELD_IMG_UPLOAD = $rand_number.'-'.$FIELD_IMG; //menggabungkan angka acak dengan nama file sebenarnya
        if(in_array($ekstensi, $allow) === true)  {     
            move_uploaded_file($file_tmp, $dir.$FIELD_IMG_UPLOAD);
            $query = "INSERT INTO field VALUES('$FIELD_ID', '$FIELD_NAME', $FIELD_PRICE, '$FIELD_SIZE', '$FIELD_IMG_UPLOAD', '$FIELD_DECS')";
            if (mysqli_query($conn, $query)) {
			    header("location:field.php");
			} else {
			    $error_msg= myqsqli_error($conn);
			    echo "<script type='text/javascript'>alert('Insert Field fail : $error_msg');</script>";
			}

        } else {     
             //jika file ekstensi tidak jpg dan png maka alert ini yang tampil
            echo "<script>alert('Ekstensi gambar yang boleh hanya jpg atau png.');window.location='field.php';</script>";
        }
   
        mysqli_close($conn);
		break;	
	case 'deleteField':
		$FIELD_ID = mysqli_real_escape_string($conn, $_GET['FIELD_ID']);
		
		$query = "DELETE from field WHERE FIELD_ID ='".$FIELD_ID."'";
		
        if (mysqli_query($conn, $query)) {
        	header("location:field.php");
        } else {
        	$error_msg= myqsqli_error($conn);
        	echo "<script type='text/javascript'>alert('Delete Field fail : $error_msg');</script>";
        }
        mysqli_close($conn);
		break;
	case 'listTransaction':
		$trans->day = $_POST['day'];
		$trans->month = $_POST['month'];
		$trans->year = $_POST['year'];
		$trans->status = $_POST['status'];
		// $trans->date = 5;
		$trans->listTransaction();
		break;
	case 'cancelTrans':
		// $trans->TRANS_ID = mysqli_real_escape_string($conn, $_GET['TRANS_ID']);
		// $trans->updateStatus();
		$trans_id = mysqli_real_escape_string($conn, $_GET['TRANS_ID']);
		$updateQuery = "UPDATE transaction SET TRANS_STATUS='CANCEL' WHERE TRANS_ID= '$trans_id'";
		if (mysqli_query($conn, $updateQuery)) {
        	header("location:transaction.php");
        } else {
        	header("location:transaction.php");
        }
		break;
	case 'lunasTrans':
		// $trans->TRANS_ID = mysqli_real_escape_string($conn, $_GET['TRANS_ID']);
		// $trans->updateStatus();
		$trans_id = mysqli_real_escape_string($conn, $_GET['TRANS_ID']);
		$updateQuery = "UPDATE transaction SET TRANS_STATUS='LUNAS' WHERE TRANS_ID= '$trans_id'";
		if (mysqli_query($conn, $updateQuery)) {
        	header("location:transaction.php");
        } else {
        	header("location:transaction.php");
        }
		break;
	case 'updateTransStatus':
		// $trans->TRANS_ID = mysqli_real_escape_string($conn, $_GET['TRANS_ID']);
		// $trans->updateStatus();
		$trans_id = $_POST['TRANS_ID'];
		$trans_status = $_POST['TRANS_STATUS'];
		$updateQuery = "UPDATE transaction SET TRANS_STATUS='$trans_status' WHERE TRANS_ID= '$trans_id'";
		if (mysqli_query($conn, $updateQuery)) {
        	header("location:transaction.php");
        } else {
        	header("location:transaction.php");
        }
		break;
	case 'exportTransaction':
		$trans->day = $_POST['day'];
		$trans->month = $_POST['month'];
		$trans->year = $_POST['year'];
		$trans->search = $_POST['search'];
		$trans->status = $_POST['status'];
		$trans->exportTransaction();
		break;
	case 'listSchedule':
		$sch->listSchedule();
		break;
	case 'addSchedule':
		$sch_id = "S001";
        $q1 = "SELECT SCH_ID FROM schedule ORDER BY SCH_ID DESC LIMIT 1";
		$result = mysqli_query($conn, $q1);
		if (mysqli_num_rows($result) > 0) {
			if ($row = mysqli_fetch_assoc($result)) {
				$num = (int)(substr($row['SCH_ID'],1,4));
				$num = $num + 1;
				if($num>99){
					$sch_id = 'S'.$num;
				}else if($num>9){
					$sch_id = 'S0'.$num;
				}else{
					$sch_id = 'S00'.$num;
				}
			}
		}

		$SCH_ID = $sch_id;
		$SCH_TIME = $_POST['startTime']."-".$_POST['finishTime'];
		$FIELD_ID = $_POST['field'];
		
		$query = "INSERT INTO schedule VALUES('$SCH_ID','$FIELD_ID','$SCH_TIME')";
		
        if (mysqli_query($conn, $query)) {
        	header("location:schedule.php");
        } else {
        	$error_msg= myqsqli_error($conn);
        	echo "<script type='text/javascript'>alert('Insert Schedule fail : $error_msg');</script>";
        }
        mysqli_close($conn);
		break;
	case 'deleteSchedule':
		$SCH_ID = mysqli_real_escape_string($conn, $_GET['SCH_ID']);
		
		$query = "DELETE from schedule WHERE SCH_ID ='".$SCH_ID."'";
		
        if (mysqli_query($conn, $query)) {
        	header("location:schedule.php");
        } else {
        	$error_msg= myqsqli_error($conn);
        	echo "<script type='text/javascript'>alert('Delete Schedule fail : $error_msg');</script>";
        }
        mysqli_close($conn);
		break;
	case 'insert-book':
		// query latest bookid
		$id_book = 1;
		$q1 = "SELECT BOOK_ID FROM book_schedule ORDER BY BOOK_ID DESC LIMIT 1";
		$result = mysqli_query($conn, $q1);
		if (mysqli_num_rows($result) > 0) {
			if ($row = mysqli_fetch_assoc($result)) {
				$id_book = (int)($row['BOOK_ID']);
				$id_book = $id_book+1;
			}
		}

        $id_lap = mysqli_real_escape_string($conn, $_POST['id_lap']);
        $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
        $waktu = mysqli_real_escape_string($conn, $_POST['waktu']);

        // Insert to book_schedule
        $inser_book_q = "INSERT INTO book_schedule VALUES($id_book,'$id_lap','$tanggal','$waktu')";
        if (mysqli_query($conn, $inser_book_q)) {
        	echo "<script type='text/javascript'>alert('Insert book success');</script>";
        } else {
        	$error_msg= myqsqli_error($conn);
        	echo "<script type='text/javascript'>alert('Insert book fail : $error_msg');</script>";
        }

        //GET latest trans id
        $id_trans = "T001";
        $q1 = "SELECT TRANS_ID FROM transaction ORDER BY TRANS_ID DESC LIMIT 1";
		$result = mysqli_query($conn, $q1);
		if (mysqli_num_rows($result) > 0) {
			if ($row = mysqli_fetch_assoc($result)) {
				$num = (int)(substr($row['TRANS_ID'],1,4));
				$num = $num + 1;
				if($num>99){
					$id_trans = 'T'.$num;
				}else if($num>9){
					$id_trans = 'T0'.$num;
				}else{
					$id_trans = 'T00'.$num;
				}
			}
		}
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);


        $query = "INSERT INTO transaction VALUES('$id_trans','$id_book','QR','$nama','$phone','$tanggal',$price,'slip','BOOK')";
        if (mysqli_query($conn, $query)) {
        	header("location:confirm.php?id_trans=$id_trans");
        } else {
        	$error_msg= myqsqli_error($conn);
        	echo "<script type='text/javascript'>alert('Insert transaction fail : $error_msg');</script>";
        }
        mysqli_close($conn);
	break;

	case 'insert-book-offline':
		// query latest bookid
		$id_book = 1;
		$q1 = "SELECT BOOK_ID FROM book_schedule ORDER BY BOOK_ID DESC LIMIT 1";
		$result = mysqli_query($conn, $q1);
		if (mysqli_num_rows($result) > 0) {
			if ($row = mysqli_fetch_assoc($result)) {
				$id_book = (int)($row['BOOK_ID']);
				$id_book = $id_book+1;
			}
		}

        $id_lap = mysqli_real_escape_string($conn, $_POST['id_lap']);
        $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
        $waktu = mysqli_real_escape_string($conn, $_POST['waktu']);

        // Insert to book_schedule
        $inser_book_q = "INSERT INTO book_schedule VALUES($id_book,'$id_lap','$tanggal','$waktu')";
        if (mysqli_query($conn, $inser_book_q)) {
        	echo "<script type='text/javascript'>alert('Insert book success');</script>";
        } else {
        	$error_msg= myqsqli_error($conn);
        	echo "<script type='text/javascript'>alert('Insert book fail : $error_msg');</script>";
        }

        //GET latest trans id
        $id_trans = "T001";
        $q1 = "SELECT TRANS_ID FROM transaction ORDER BY TRANS_ID DESC LIMIT 1";
		$result = mysqli_query($conn, $q1);
		if (mysqli_num_rows($result) > 0) {
			if ($row = mysqli_fetch_assoc($result)) {
				$num = (int)(substr($row['TRANS_ID'],1,4));
				$num = $num + 1;
				if($num>99){
					$id_trans = 'T'.$num;
				}else if($num>9){
					$id_trans = 'T0'.$num;
				}else{
					$id_trans = 'T00'.$num;
				}
			}
		}
		$price=0;
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $queryPrice="SELECT FIELD_PRICE FROM field WHERE FIELD_ID='$id_lap";
        $resultPrice = mysqli_query($conn, $queryPrice);
		if (mysqli_num_rows($result) > 0) {
			if ($row = mysqli_fetch_assoc($result)) {
				$price = $row['FIELD_PRICE'];
			}
		}
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);


        $query = "INSERT INTO transaction VALUES('$id_trans','$id_book','QR','$nama','$phone','$tanggal',$price,'slip','LUNAS')";
        if (mysqli_query($conn, $query)) {
        	header("location:book.php?status=Book Berhasil");
        } else {
        	header("location:book.php?status=Book Gagal");
        }
        mysqli_close($conn);
	break;

	case 'insert-review':
		//GET latest review
        $id_review = "R001";
        $q1 = "SELECT REVIEW_ID FROM review ORDER BY REVIEW_ID DESC LIMIT 1";
		$result = mysqli_query($conn, $q1);
		if (mysqli_num_rows($result) > 0) {
			if ($row = mysqli_fetch_assoc($result)) {
				$num = (int)(substr($row['REVIEW_ID'],1,4));
				$num = $num + 1;
				if($num>99){
					$id_review = 'R'.$num;
				}else if($num>9){
					$id_review = 'R0'.$num;
				}else{
					$id_review = 'R00'.$num;
				}
			}
		}
		$id_lap = mysqli_real_escape_string($conn, $_POST['id_lap']);
		$rv_nama = mysqli_real_escape_string($conn, $_POST['rv_nama']);
		$rv_desc = mysqli_real_escape_string($conn, $_POST['rv_desc']);
		$rv_status = "unapproved";
		$query = "INSERT INTO review VALUES('$id_review','$id_lap','$rv_nama','$rv_desc','$rv_status')";
        if (mysqli_query($conn, $query)) {
        	header("location:detail.php?field_id=$id_lap");
        } else {
        	header("location:detail.php?field_id=$id_lap");
        } 
        mysqli_close($conn);
		break;

	case 'approve-review':
		$review_id = mysqli_real_escape_string($conn, $_GET['review_id']);
		$updateQuery = "UPDATE review SET REVIEW_STATUS='approved' WHERE REVIEW_ID='$review_id'";
		if (mysqli_query($conn, $updateQuery)) {
        	header("location:review.php?status=$review_id approved");
        } else {
        	header("location:review.php?status=$review_id approval failed");
        }
		break;

	case 'unapprove-review':
		$review_id = mysqli_real_escape_string($conn, $_GET['review_id']);
		$updateQuery = "UPDATE review SET REVIEW_STATUS='unapproved' WHERE REVIEW_ID='$review_id'";
		if (mysqli_query($conn, $updateQuery)) {
        	header("location:review.php?status=$review_id unapproved");
        } else {
        	header("location:review.php?status=$review_id unapproval failed");
        }
		break;

	case 'insert-user':
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$level = mysqli_real_escape_string($conn, $_POST['level']);
		$full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
		$inserUser = "INSERT INTO USER VALUES('$username','$password','$level','$full_name')";
		if (mysqli_query($conn,$inserUser)) {
			header("location:user.php?status=User berhasil ditambahkan");
		}else{
			header("location:user.php?status=User gagal ditambahkan");
		}
		break;

	case 'delete-user':
		$username = mysqli_real_escape_string($conn,$_GET['username']);
		$deleteUser = "DELETE FROM user WHERE USERNAME='$username'";
		if (mysqli_query($conn,$deleteUser)) {
			header("location:user.php?status=User berhasil dihapus");
		}else{
			header("location:user.php?status=User gagal dihapus");
		}
		break;

	case 'upload-slip-dp':
		$id_trans = mysqli_real_escape_string($conn,$_POST['id_trans']);

		$target_dir = "assets/images/slip-dp/";
		$target_file = $target_dir . $id_trans . basename($_FILES["upload_img"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		  $check = getimagesize($_FILES["upload_img"]["tmp_name"]);
		  if($check !== false) {
		    echo "File is an image - " . $check["mime"] . ".";
		    $uploadOk = 1;
		  } else {
		    echo "File is not an image.";
		    $uploadOk = 0;
		  }
		}

		// Check if file already exists
		if (file_exists($target_file)) {
		  echo "Sorry, file already exists.";
		  $uploadOk = 0;
		}

		// Check file size
		if ($_FILES["upload_img"]["size"] > 500000) {
		  echo "Sorry, your file is too large.";
		  $uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		  $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		  echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		  if (move_uploaded_file($_FILES["upload_img"]["tmp_name"], $target_file)) {
		    $q_update_slip = "UPDATE transaction SET PAYMENT_SLIP = '$target_file' WHERE TRANS_ID='$id_trans'";
		    if (mysqli_query($conn,$q_update_slip)) {
				header("location:upload.php?status=Berhasil Upload Bukti Pembayaran DP");
			}else{
				header("location:upload.php?status=Gagal Upload Bukti Pembayaran DP");
			}
		  } else {
		    echo "Sorry, there was an error uploading your file.";
		  }
		}
		break;

	default:
		# code...
		break;
	}
?>