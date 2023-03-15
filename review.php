<?php
$page = "review";
include('header.php');
include('navbar.php');
?> 
        <div id="page-wrapper">
            <div class="header"> 
                <h1 class="page-header">Review</h1>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Review</a></li>
					<li class="active">Data</li>
				</ol> 					
            </div>
            <div id="page-inner">
                <div class="row">                    
                   <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="card">
                            <div class="card-action">
                                 Kelola Data Review
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="tableReview">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Lapangan</th>
                                                <th>Nama Reviewer</th>
                                                <th>Review</th>
                                                <th>Status</th>
                                                <th>Process</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include('db_connect.php');
                                                $sql = "SELECT * FROM review LEFT JOIN field ON(review.FIELD_ID = field.FIELD_ID) ORDER BY review.FIELD_ID DESC";
                                                $result = mysqli_query($conn, $sql);
                                                $row_num = 1;
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo"$row_num";?></td>
                                                        <td><?php echo"$row[FIELD_NAME]";?></td>
                                                        <td><?php echo"$row[REVIEW_NAME]";?></td>
                                                        <td><?php echo"$row[REVIEW_DESC]";?></td>
                                                        <td><?php echo"$row[REVIEW_STATUS]";?></td>
                                                        <?php if($row['REVIEW_STATUS']=='unapproved'){ ?>
                                                        <td><a <?php echo"href='process.php?process=approve-review&review_id=$row[REVIEW_ID]'"; ?> class="btn btn-success btn-xs">Approve</a></td>
                                                        <?php }else{ ?>
                                                        <td><a <?php echo"href='process.php?process=unapprove-review&review_id=$row[REVIEW_ID]'"; ?>class="btn btn-danger btn-xs">Unapprove</a></td>
                                                        <?php } ?>
                                                    </tr>
                                            <?php 
                                                    $row_num++; 
                                                    }
                                                }
                                            ?>
                                        </tbody>
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