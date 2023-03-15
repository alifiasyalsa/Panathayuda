<?php
$page = "user";
include('header.php');
include('navbar.php');
?> 
        <div id="page-wrapper">
            <div class="header"> 
                <h1 class="page-header">User</h1>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">User</a></li>
					<li class="active">Data</li>
				</ol> 					
            </div>
            <div id="page-inner">
                <div class="row">      
                <div class="col-md-12">                    
                    <div class="card">
                        <div class="card-action">
                             Tambah User
                        </div>
                        <div class="card-content">
                            <form method="post" action="process.php?process=insert-user">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="full_name">Nama:</label>
                                        <input name="full_name" type="text" class="form-control" id="full_name" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="level">Level:</label>
                                        <select class="form-control" name="level">
                                            <option value="pengelola">Pengelola</option>
                                            <option value="pengawas">Pengawas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="username">Username:</label>
                                        <input name="username" type="text" class="form-control" id="username" placeholder="Masukkan username" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="password">Password:</label>
                                        <input name="password" type="password" class="form-control" id="password" placeholder="Masukkan password" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <input type="submit" name="submit" class="btn btn-success" value="Tambah User">
                                    </div>                                    
                                </div>
                            </form>
                        </div>
                    </div>    
                </div> 
         
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="card">
                            <div class="card-action">
                                 Kelola Data User
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="tableReview">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Username</th>
                                                <th>Nama</th>
                                                <th>Level</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                include('db_connect.php');
                                                $sql = "SELECT * FROM user";
                                                $result = mysqli_query($conn, $sql);
                                                $row_num = 1;
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo"$row_num";?></td>
                                                        <td><?php echo"$row[USERNAME]";?></td>
                                                        <td><?php echo"$row[FULL_NAME]";?></td>
                                                        <td><?php echo"$row[USER_LEVEL]";?></td>
                                                        <td><a class="btn btn-danger btn-xs"<?php echo"href='process.php?process=delete-user&username=$row[USERNAME]'";?>>HAPUS</a></td>
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