<?php
include "mysql.php";
include "cart_add.php";
session_start();

$con = mysql_connect("localhost","root","toor");
if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
mysql_select_db("ruhungry", $con);
$tempname=$_SESSION["username"];
function getAddressInfo()
{	
$tempname=$_SESSION["username"];
	$sql_select = "SELECT * FROM shipping_address WHERE Username = '$tempname'";
	$result = mysql_query($sql_select);
	while($row = mysql_fetch_array($result))
	{

		$output = '<button id="'.$row['shipping_ID'].'"style="display:block;" value="'.$row['shipping_ID'].' type="button" onclick="setAddress(\''.$row['shipping_address'].'\')">'.$row['shipping_address'].'</button>';
		print $output;
	}
}
function getBillInfo()
{
$tempname=$_SESSION["username"];
	$sql_select = "SELECT * FROM credit_card_hotlist WHERE Username = '$tempname'";
	$result = mysql_query($sql_select);
	while($row = mysql_fetch_array($result))
	{

		$output = '<button id="'.$row['Card_ID'].'"style="display:block;" value="'.$row['Card_ID'].' type="button" onclick="setBill(\''.$row['Card_Account'].'| |'.$row['Card_Type'].'| |'.$row['Card_Holder'].'| |'.$row['Card_Expire'].'| |'.$row['Bill_Address'].'| |'.'\')">'.$row['Card_Account'].'</button>';
		print $output;
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
	<script type="text/javascript">
	function pay()
	{
		
	}
	function setAddress(Adres)
	{
		var Address=Adres.split('| |',7);
		document.getElementById("Ship_First_Name").value=Address[0];
		document.getElementById("Ship_Last_Name").value=Address[1];
		document.getElementById("Ship_Address1").value=Address[2];
		document.getElementById("Ship_Address2").value=Address[3];
		document.getElementById("Ship_City").value=Address[4];
		document.getElementById("Ship_State").value=Address[5];
		document.getElementById("Ship_Zip").value=Address[6];
	}
	function setBill(Card)
	{
		var Bill=Card.split('| |',11);
		document.getElementById("Bill_Number").value=Bill[0];
		document.getElementById("Bill_Holder").value=Bill[2];
		document.getElementById("Bill_Expire").value=Bill[3];
		document.getElementById("Bill_Type").value=Bill[1];
		document.getElementById("Bill_First_Name").value=Bill[4];
		document.getElementById("Bill_Last_Name").value=Bill[5];
		document.getElementById("Bill_Address1").value=Bill[6];
		document.getElementById("Bill_Address2").value=Bill[7];
		document.getElementById("Bill_City").value=Bill[8];
		document.getElementById("Bill_State").value=Bill[9];
		document.getElementById("Bill_Zip").value=Bill[10];


	}
	function copyTo()
	{
		document.getElementById("Bill_First_Name").value=document.getElementById("Ship_First_Name").value;
		document.getElementById("Bill_Last_Name").value=document.getElementById("Ship_Last_Name").value;
		document.getElementById("Bill_Address1").value=document.getElementById("Ship_Address1").value;
		document.getElementById("Bill_Address2").value=document.getElementById("Ship_Address2").value;
		document.getElementById("Bill_City").value=document.getElementById("Ship_City").value;
		document.getElementById("Bill_State").value=document.getElementById("Ship_State").value;
		document.getElementById("Bill_Zip").value=document.getElementById("Ship_Zip").value;

	}
	function saveAddress()
	{
		var alertMessage ="";
    	if (document.getElementById("Ship_First_Name").value.length<1)
    		alertMessage+="First Name cannot be empty!\n\n";
    	if (document.getElementById("Ship_Address1").value.length<1)
    		alertMessage+="Address1 cannot be empty!\n\n";
    	if (document.getElementById("Ship_City").value.length<1)
    		alertMessage+="City cannot be empty!\n\n";
    	if (document.getElementById("Ship_State").value.length<1)
    		alertMessage+="State cannot be empty!\n\n";
    	if (document.getElementById("Ship_Zip").value.length!=5 || isNaN(document.getElementById("Ship_Zip").value))
    		alertMessage+="Zip must be 5 digits!\n\n";
    	// if (!(/\S+@\S+\.\S+/.test(uname)))
    	// 	alertMessage+="Username should be a valid email.\n(i.e. <text>@<text>.<text>)\n\n";
    	// if (pword.length<1)
    	// 	alertMessage+="Password cannot be blank.\n\n";
    	if (alertMessage.length>1)
    		alert(alertMessage);
    	else
    	{
			document.getElementById("Ship_Info").submit();
		}
	}
	function saveCard()
	{
		var alertMessage ="";
		if (document.getElementById("Bill_First_Name").value.length<1)
    		alertMessage+="First Name cannot be empty!\n\n";
    	if (document.getElementById("Bill_Address1").value.length<1)
    		alertMessage+="Address1 cannot be empty!\n\n";
    	if (document.getElementById("Bill_City").value.length<1)
    		alertMessage+="City cannot be empty!\n\n";
    	if (document.getElementById("Bill_State").value.length<1)
    		alertMessage+="State cannot be empty!\n\n";
    	if (document.getElementById("Bill_Zip").value.length!=5 || isNaN(document.getElementById("Bill_Zip").value))
    		alertMessage+="Zip must be 5 digits!\n\n";
    	if (document.getElementById("Bill_Number").value.length!=16 || isNaN(document.getElementById("Bill_Number").value))
    		alertMessage+="Card Number must be 16 digits!\n\n";
    	if (alertMessage.length>1)
    		alert(alertMessage);
    	else
    	{
			document.getElementById("Bill_Info").submit();
		}
	}
    // function checkLogin()
    // {
    // 	var uname = document.getElementById("uname").value;
    // 	var pword = document.getElementById("pword").value;
    // 	var alertMessage ="";
    // 	if (uname.length<4)
    // 		alertMessage+="Username should be longer than three characters.\n\n";
    // 	if (!(/\S+@\S+\.\S+/.test(uname)))
    // 		alertMessage+="Username should be a valid email.\n(i.e. <text>@<text>.<text>)\n\n";
    // 	if (pword.length<1)
    // 		alertMessage+="Password cannot be blank.\n\n";
    // 	if (alertMessage.length>1)
    // 		alert(alertMessage);
    // 	else
    // 	{
    // 		document.getElementById("btnSubmit").style.display = "none";
    // 		document.getElementById("formLogin").submit();
    // 	}
    // }
    </script>
	<header id="header">

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
								<li><a href="profile_shipping_addr.php"><i class="fa fa-user"></i> Account</a></li>
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
	</header>

	<section id="cart_items" style="padding-top:30px">
<!-- 
			<div class="step-one">
				<h2 class="heading">Step1</h2>
			</div>
			<div class="checkout-options">
				<h3>New User</h3>
				<p>Checkout options</p>
				<ul class="nav">
					<li>
						<label><input type="checkbox"> Register Account</label>
					</li>
					<li>
						<label><input type="checkbox"> Guest Checkout</label>
					</li>
					<li>
						<a href=""><i class="fa fa-times"></i>Cancel</a>
					</li>
				</ul>
			</div><!--/checkout-options-->

			<!-- <div class="register-req">
				<p>Please use Register And Checkout to easily get access to your order history, or use Checkout as Guest</p>
			</div><!--/register-req-->
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="index.php">Home</a></li>
				  <li class="active">Checkout</li>
				</ol>
			</div>			
			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-3">
						<div class="shopper-info">
							<p>Shipping Information</p>
							<form id="Ship_Info" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
								<input id="Ship_First_Name" name="Ship_First_Name" type="text" placeholder="First Name" value="<?php echo $_POST['Ship_First_Name'] ?>">
								<input id="Ship_Last_Name" name="Ship_Last_Name" type="text" placeholder="Last Name" value="<?php echo $_POST['Ship_Last_Name'] ?>">
								<input id="Ship_Address1" name="Ship_Address1" type="text" placeholder="Address1" value="<?php echo $_POST['Ship_Address1'] ?>">
								<input id="Ship_Address2" name="Ship_Address2" type="text" placeholder="Address2" value="<?php echo $_POST['Ship_Address2'] ?>">
								<input id="Ship_City" name="Ship_City" type="text" placeholder="City" value="<?php echo $_POST['Ship_City'] ?>">
								<input id="Ship_State" name="Ship_State" type="text" placeholder="State" value="<?php echo $_POST['Ship_State'] ?>">
								<input id="Ship_Zip" name="Ship_Zip" type="text" placeholder="Zip" value="<?php echo $_POST['Ship_Zip'] ?>">
								<!-- <input id="Ship_Submit" name="Ship_Submit" type="text" placeholder=""style="display:none;"> -->
								<button id="btn_Ship_Submit" name="btn_Ship_Submit" type="button" onclick="saveAddress()" >Save to Address Book</button>
						    	<button id="btn_Ship_Reset" type="button" onclick="reset()" value="Reset">Reset</button>
						    	<button id="btn_copyTo" type="button" onclick="copyTo()" value="copyTo">Copy to billing address</button>
						    	<p><?php
						    	if(isset($_POST['Ship_Last_Name']))
								{
									$sql="INSERT INTO shipping_address (Shipping_Address, Username)
								VALUES
								('$_POST[Ship_First_Name]| |$_POST[Ship_Last_Name]| |$_POST[Ship_Address1]| |$_POST[Ship_Address2]| |$_POST[Ship_City]| |$_POST[Ship_State]| |$_POST[Ship_Zip]','$tempname')";
									if (!mysql_query($sql,$con))
											die('Error: ' . mysql_error());
									else echo "<script>alert('Success!')</script>";
								}
						    	?></p>
						    	
							</form>
							<p>Choose from address book:</p>
							<?php getAddressInfo() ?>
							<!-- <a class="btn btn-primary" href="">Get Quotes</a>
							<a class="btn btn-primary" href="">Continue</a> -->
						</div>
					</div>
					<div class="col-sm-7 clearfix">
						<div class="bill-to">
						<p>Bill To</p>
							<div class="form-one">
								<form id="Bill_Info" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
									<input id="Bill_First_Name" name="Bill_First_Name" type="text" placeholder="First Name" value="<?php echo $_POST['Bill_First_Name'] ?>">
									<input id="Bill_Last_Name" name="Bill_Last_Name" type="text" placeholder="Last Name" value="<?php echo $_POST['Bill_Last_Name'] ?>">
									<input id="Bill_Address1" name="Bill_Address1" type="text" placeholder="Address1" value="<?php echo $_POST['Bill_Address1'] ?>">
									<input id="Bill_Address2" name="Bill_Address2" type="text" placeholder="Address2" value="<?php echo $_POST['Bill_Address2'] ?>">
									<input id="Bill_City" name="Bill_City" type="text" placeholder="City" value="<?php echo $_POST['Bill_City'] ?>">
									<input id="Bill_State" name="Bill_State" type="text" placeholder="State" value="<?php echo $_POST['Bill_State'] ?>">
									<input id="Bill_Zip" name="Bill_Zip" type="text" placeholder="Zip" value="<?php echo $_POST['Bill_Zip'] ?>">
									<select id="Bill_Type" name="Bill_Type" value="<?php echo $_POST['Bill_Type'] ?>">
										<option>Visa</option>
										<option>Mastercard</option>
										<option>Other</option>
									</select>
									<input id="Bill_Number" name="Bill_Number" type="text" placeholder="Card Number" value="<?php echo $_POST['Bill_Number'] ?>">
									<input id="Bill_Holder" name="Bill_Holder" type="text" placeholder="Card Holder" value="<?php echo $_POST['Bill_Holder'] ?>">
									<input id="Bill_Expire" name="Bill_Expire" type="text" placeholder="Expire Date" value="<?php echo $_POST['Bill_Expire'] ?>">
									<!-- <input id="Bill_Type" name="Bill_Type" type="text" placeholder="Card Type"> -->
									
									<button id="btn_Bill_Submit" type="button" onclick="saveCard()" name="btn_Bill_Submit" value="saveCard">Save to Card Book</button>
						    		<button id="btn_Bill_Reset" type="button" onclick="reset()" value="Reset">Reset</button>
						    		<p><?php
						    		if(isset($_POST['Bill_Number']))
									{
										$sql="INSERT INTO credit_card_hotlist (Card_Account,Card_Type,Card_Holder,Card_Expire,Bill_Address, Username)
									VALUES
									('$_POST[Bill_Number]','$_POST[Bill_Type]','$_POST[Bill_Holder]','$_POST[Bill_Expire]','$_POST[Bill_First_Name]| |$_POST[Bill_Last_Name]| |$_POST[Bill_Address1]| |$_POST[Bill_Address2]| |$_POST[Bill_City]| |$_POST[Bill_State]| |$_POST[Bill_Zip]','$tempname')";
										if (!mysql_query($sql,$con))
												die('Error: ' . mysql_error());
										else echo "<script>alert('Success!')</script>";
									}
						    		?></p>
								</form>
								<p>Choose from card book:</p>
								<?php getBillInfo() ?>
							</div>
							<!-- <div class="form-two">
								<form>
									<input type="text" placeholder="Zip / Postal Code *">
									<select>
										<option>-- Country --</option>
										<option>United States</option>
										<option>Bangladesh</option>
										<option>UK</option>
										<option>India</option>
										<option>Pakistan</option>
										<option>Ucrane</option>
										<option>Canada</option>
										<option>Dubai</option>
									</select>
									<select>
										<option>-- State / Province / Region --</option>
										<option>United States</option>
										<option>Bangladesh</option>
										<option>UK</option>
										<option>India</option>
										<option>Pakistan</option>
										<option>Ucrane</option>
										<option>Canada</option>
										<option>Dubai</option>
									</select>
									<input type="password" placeholder="Confirm password">
									<input type="text" placeholder="Phone *">
									<input type="text" placeholder="Mobile Phone">
									<input type="text" placeholder="Fax">
								</form>
							</div> -->
						</div>
					</div>
				</div>
			</div>
			<div class="review-payment">
				<h2>Review & Payment</h2>
			</div>

			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php 
							$username = $_SESSION['username'];
							checkCart($username);
					?>
						<!-- <tr>
							<td class="cart_product">
								<a href=""><img src="images/cart/one.png" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">Colorblock Scuba</a></h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>$59</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_up" href=""> + </a>
									<input class="cart_quantity_input" type="text" name="quantity" value="1" autocomplete="off" size="2">
									<a class="cart_quantity_down" href=""> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">$59</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
							</td>
						</tr>

						<tr>
							<td class="cart_product">
								<a href=""><img src="images/cart/two.png" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">Colorblock Scuba</a></h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>$59</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_up" href=""> + </a>
									<input class="cart_quantity_input" type="text" name="quantity" value="1" autocomplete="off" size="2">
									<a class="cart_quantity_down" href=""> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">$59</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<tr>
							<td class="cart_product">
								<a href=""><img src="images/cart/three.png" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">Colorblock Scuba</a></h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>$59</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_up" href=""> + </a>
									<input class="cart_quantity_input" type="text" name="quantity" value="1" autocomplete="off" size="2">
									<a class="cart_quantity_down" href=""> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">$59</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;</td>
							<td colspan="2">
								<table class="table table-condensed total-result">
									<tr>
										<td>Cart Sub Total</td>
										<td>$59</td>
									</tr>
									<tr>
										<td>Exo Tax</td>
										<td>$2</td>
									</tr>
									<tr class="shipping-cost">
										<td>Shipping Cost</td>
										<td>Free</td>
									</tr>
									<tr>
										<td>Total</td>
										<td><span>$61</span></td>
									</tr>
								</table>
							</td>
						</tr> -->
					</tbody>
				</table>
			</div>
			<div class="payment-options">
				<button id="btn_pay" name="btn_pay" onclick="pay()" >PAY</button>
					<!-- <span>
						<label><input type="checkbox"> Direct Bank Transfer</label>
					</span>
					<span>
						<label><input type="checkbox"> Check Payment</label>
					</span>
					<span>
						<label><input type="checkbox"> Paypal</label>
					</span> -->
			</div>
		</div>
		</div>
	</section> <!--/#cart_items-->


    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
<?php mysql_close($con) ?>