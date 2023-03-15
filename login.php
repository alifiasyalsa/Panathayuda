<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Aplikasi Penyewaan Lapangan di Kawasan GOR Panatayudha </title>
<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="assets/css/font-awesome.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="assets/css/login.css">

</head>
<body>

<!-- card HTML -->
<div class="container">
	<div class="row">
  	<div class="col-sm-12">
	<div class="card card-login mx-auto">
			
			<div class="card-body">
				<h4 class="card-title mb-5">GOR <em>PANATAYUDHA</em></h4>
				<form method="post" action="process.php?process=login">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input type="text" class="form-control" name="username" placeholder="Username" required="required">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							<input type="password" class="form-control" name="password" placeholder="Password" required="required">
						</div>
					</div>
					<div class="form-group">
						<button type="submit" name="btn_login" class="btn btn-primary btn-block btn-lg">Sign In</button>
					</div>
					<p class="hint-text"><a href="#">Forgot Password?</a></p>
				</form>
			</div>
			<div class="card-footer">Don't have an account? <a href="#">Create one</a></div>
		</div>
	</div>
	</div>
	</div>
</div>     
</body>
</html>


