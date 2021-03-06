<?php

//Connect to Database
require('./mysql.php');

session_start();

//check admission
if($_SESSION["islogin"] != true)
	header("Location: login.php");
	
if (isset($_POST['submit']))
{
	if($_SESSION["Card_Account"] != NULL)
	{
		$update = "update credit_card_info set Card_Account = '".$_POST['account']."', Card_Type = '".$_POST['type'].
		"', First_Name = '".$_POST['First_Name']."', Last_Name = '".$_POST['Last_Name']."', Card_Expire = '".$_POST['exp_date']."', Address1 = '".$_POST['Address1'].
		"', Address2 = '".$_POST['Address2']."', City = '".$_POST['City']."', State_USA = '".$_POST['State_USA']."', Zip = '".$_POST['Zip']."' where Username = '".$_SESSION["username"]."'";
		
		$update_check = mysql_query($update) or die("Update failed.");
		header("Location: profile_credit_card_info.php");
	}
	else
	{	
		$insert = "insert into credit_card_info set Username = '".$_SESSION["username"]."', Card_Account = '".$_POST['account']."', Card_Type = '".$_POST['type'].
		"', Card_Holder = '".$_POST['holder']."', Card_Expire = '".$_POST['exp_date']."', Address1 = '".$_POST['Address1'].
		"', Address2 = '".$_POST['Address2']."', City = '".$_POST['City']."', State_USA = '".$_POST['State_USA']."', Zip = '".$_POST['Zip']."'";
		$insert_check = mysql_query($insert) or die("Update failed.");
		header("Location: profile_credit_card_info.php");
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>RUHungry</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
	<header id="header">
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-envelope"></i> URHungry@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle">
			<div class="container" >
				<div class="row" >
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.php"><img src="images/home/mylogo.png" alt="" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-user"></i> Account</a></li>
								<li><a href="checkout.php"><i class="fa fa-crosshairs"></i> Checkout</a></li>
								<li><a href="cart_page.php"><i class="fa fa-shopping-cart"></i> Cart</a></li>
								<?php if($_SESSION["islogin"] == true) echo('<li><a href="logout.php"><i class="fa fa-lock"></i> Logout</a></li>');
									  else echo('<li><a href="login.php"><i class="fa fa-lock"></i> Login</a></li>');
								?>								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	
	<section>
		<div class="container" style="padding-top:50px;">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>My Account</h2>					
							<div class="panel panel-default">
								<div class="panel-heading">									
								</div>
									<div class="panel-body">
										<ul class="nav navbar-nav">
											<li><a href="profile_shipping_addr.php"><i class="fa fa-credit-card"></i> Shipping Address</a></li>
											<li><a href="#"><i class="fa fa-credit-card"></i> Credit Card Information</a></li>
										</ul>
									</div>
							</div>												
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="shipping_address">				
						<div class="shipping_address">
							<h2 class="title text-center">Credit Card Information</h2>
							<table class="table table-bordered">
							   <thead>
								  <tr>
									 <th>Card Number</th>
									 <th>Card Type</th>
									 <th>First Name</th>
									 <th>Last Name</th>									 
									 <th>Expire Date</th>
									 <th>Billing Address</th>
									 <th>Operation</th>
								  </tr>
							   </thead>
							   <tbody>
								  <tr>
									 <?php
										$select = mysql_query("select * from credit_card_info where Username = '".$_SESSION["username"]."'") or die(mysql_error());
										$info = mysql_fetch_array($select);
										if($info['Card_Account'] != NULL)
										$_SESSION["Card_Account"] = $info['Card_Account'];
										echo('<td>'.$info['Card_Account'].'</td>');
										echo('<td>'.$info['Card_Type'].'</td>');
										echo('<td>'.$info['First_Name'].'</td>');
										echo('<td>'.$info['Last_Name'].'</td>');
										echo('<td>'.$info['Card_Expire'].'</td>');
										echo('<td>'.$info['Address1'].' '.$info['Address2'].', '.$info['City'].', '.$info['State_USA'].' '.$info['Zip'].'</td>');
									 ?>
									 <td><a href="javascript:add_edit()">Edit</a></td>
								  </tr>
							   </tbody>
							</table>
							<div class="container" style="padding-top:50px; padding-bottom:270px;" id="div_blank">
							
							</div>
							<div class="container" style="padding-top:50px; padding-bottom:100px; display:none;" id="div_edit">
								<div class="row">
									<div class="col-sm-4">
										<div class="login-form"><!--login form-->
											<h2>Input your new credit card information</h2>
											<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
												<input type="text" name="account" placeholder="Card Number" required="required">
												<input type="text" name="type" placeholder="Card Type" required="required">
												<input type="text" name="First_Name" placeholder="First Name" required="required">
												<input type="text" name="Last_Name" placeholder="Last Name" required="required">												
												<input type="text" name="exp_date" placeholder="Expire Date" required="required">
												<input type="text" name="Address1" placeholder="Address1" required="required">
												<input type="text" name="Address2" placeholder="Address2" required="required">
												<input type="text" name="City" placeholder="City" required="required">
												<input type="text" name="State_USA" placeholder="State" required="required">
												<input type="text" name="Zip" placeholder="Zip" required="required">												
												<button type="submit" value="submit" name="submit" class="btn btn-default">Submit</button>
											</form>											
										</div><!--/login form-->
									</div>							

							</div>
						</div>
						</div>
				</div>
			</div><!--/recommended_items-->					
		</div>
		</div>
	</section>
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-10">
						<div class="companyinfo">
							<h2><span>RUH</span>ungry</h2>
							<p>CS6548 E-Commerce</p>
						</div>
					</div>					
					<div class="col-sm-2">
						<div class="address">
							<img src="images/home/map.png" alt="" />							
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer><!--/Footer-->
	<script>
		function add_edit()
		{
			document.getElementById("div_edit").style.display = "block";
			document.getElementById("div_blank").style.display = "none";
		}
	</script>
</body>
</html>