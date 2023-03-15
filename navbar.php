    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle waves-effect waves-dark" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand waves-effect waves-dark" href="dashboard.php"><b>GOR <em>PANATAYUDHA</em></b></a>
				
			<div id="sideNav" href=""><i class="material-icons dp48">toc</i></div>
	        </div>

            <ul class="nav navbar-top-links navbar-right"> 
				  <li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown1"><i class="fa fa-user fa-fw"></i> <b><?=$user;?></b> <i class="material-icons right">arrow_drop_down</i></a></li>
            </ul>
        </nav>
<!-- Dropdown Structure -->
        <ul id="dropdown1" class="dropdown-content"> 
            <li><a href="process.php?process=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
        </ul>

       <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a class="<?php echo ($page == "dashboard" ? "active-menu" : "")?> waves-effect waves-dark" href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="user.php" class="<?php echo ($page == "user" ? "active-menu" : "")?> waves-effect waves-dark"><i class="fa fa-desktop"></i>User</a>
                    </li>
                    <li>
                        <a href="field.php" class="<?php echo ($page == "field" ? "active-menu" : "")?> waves-effect waves-dark"><i class="fa fa-desktop"></i>Lapangan</a>
                    </li>
                    <li>
                        <a href="schedule.php" class="<?php echo ($page == "schedule" ? "active-menu" : "")?> waves-effect waves-dark"><i class="fa fa-dashboard"></i>Jadwal</a>
                    </li>
                    <li>
                        <a href="book.php" class="<?php echo ($page == "book" ? "active-menu" : "")?> waves-effect waves-dark"><i class="fa fa-book"></i>Book</a>
                    </li>
                     <li>
                        <a href="transaction.php" class="<?php echo ($page == "transaction" ? "active-menu" : "")?> waves-effect waves-dark"><i class="fa fa-money"></i>Transaksi</a>
                    </li>
                    <li>
                        <a href="review.php" class="<?php echo ($page == "review" ? "active-menu" : "")?> waves-effect waves-dark"><i class="fa fa-eye"></i>Review</a>
                    </li>
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->