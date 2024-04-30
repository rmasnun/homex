<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");
$error="";
$msg="";
if(isset($_POST['add']))
{
	$cardNumber=$_POST['cardNumber'];
	$expiryDate=$_POST['expiryDate'];
	$cvv=$_POST['cvv'];
	$billingAddress=$_POST['billingAddress'];
	$phoneNumber=$_POST['phoneNumber'];
  $userid = $_SESSION['uid'];

	$query = "SELECT * FROM cards where cardNumber='$cardNumber'";
	$res=mysqli_query($con, $query);
	$num=mysqli_num_rows($res);

	if($num == 1)
	{
		$error = "<p class='alert alert-warning'>This card is already used</p> ";
	}
	else
	{

		if(!empty($cardNumber) && !empty($expiryDate) && !empty($cvv) && !empty($billingAddress) && !empty($phoneNumber))
		{

			$sql="INSERT INTO cards (cardNumber, userid, expiryDate,cvv,billingAddress, phoneNumber) VALUES ('$cardNumber', '$userid', '$expiryDate','$cvv','$billingAddress', '$phoneNumber')";
			$result=mysqli_query($con, $sql);
			   if($result){
				   $msg = "<p class='alert alert-success'>Card Added Successfully</p> ";
           header("Location: profile.php");
			   }
			   else{
				   $error = "<p class='alert alert-warning'>Card additon unsuccessful. Please try again later</p> ";
			   }
		}else{
			$error = "<p class='alert alert-warning'>Please Fill all the fields</p>";
		}
	}

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Meta Tags -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="images/favicon.ico">

<!--	Fonts
	========================================================-->
<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

<!--	Css Link
	========================================================-->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/layerslider.css">
<link rel="stylesheet" type="text/css" href="css/color.css">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/login.css">

<!--	Title
	=========================================================-->
<title>PropertyHub - Real Estate Template</title>
</head>
<body>

<!--	Page Loader
=============================================================
<div class="page-loader position-fixed z-index-9999 w-100 bg-white vh-100">
	<div class="d-flex justify-content-center y-middle position-relative">
	  <div class="spinner-border" role="status">
		<span class="sr-only">Loading...</span>
	  </div>
	</div>
</div>
-->


<div id="page-wrapper">
    <div class="row">
        <!--	Header start  -->
		<?php include("include/header.php");?>
        <!--	Header end  -->

        <!--	Banner   --->
        <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>ADD Card info</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Register</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
         <!--	Banner   --->

  <?php include("include/displayCards.php");?>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Credit Card Information</h4>
            <form method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="cardNumber">Card Number</label>
                <input name="cardNumber" type="text" class="form-control" id="cardNumber" placeholder="Enter card number" autocomplete="off">
                <small name="cardType" id="cardType" class="form-text text-muted"></small>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="expiryDate">Expiration Date</label>
                  <input name="expiryDate" type="text" class="form-control" id="expiryDate" placeholder="MM/YY">
                </div>
                <div class="form-group col-md-6">
                  <label for="cvv">CVV</label>
                  <input name="cvv" type="text" class="form-control" id="cvv" placeholder="CVV">
                </div>
              </div>
              <div class="form-group">
                <label for="billingAddress">Billing Address</label>
                <input name="billingAddress" type="text" class="form-control" id="billingAddress" placeholder="Enter billing address">
              </div>
              <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <input name="phoneNumber" type="text" class="form-control" id="phoneNumber" placeholder="Enter phone number">
              </div>
              <button name="add" value="add" type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Function to detect credit card type based on card number
    function detectCardType(cardNumber) {
      var cardType = '';
      // Array of card types and their corresponding patterns
      var cardPatterns = [
        { type: 'Visa', pattern: /^4/ },
        { type: 'MasterCard', pattern: /^5[1-5]/ },
        { type: 'American Express', pattern: /^3[47]/ },
        { type: 'Discover', pattern: /^6(?:011|5[0-9]{2})/ },
        { type: 'Diners Club', pattern: /^3(?:0[0-5]|[68][0-9])/ },
        { type: 'JCB', pattern: /^(?:2131|1800|35\d{3})/ }
      ];
      // Loop through card patterns to find a match
      cardPatterns.forEach(function (card) {
        if (card.pattern.test(cardNumber)) {
          cardType = card.type;
        }
      });
      return cardType;
    }

    // Function to update card type display
    function updateCardTypeDisplay() {
      var cardNumberInput = document.getElementById('cardNumber');
      var cardTypeDisplay = document.getElementById('cardType');
      var cardNumber = cardNumberInput.value.replace(/\s/g, ''); // Remove spaces
      var cardType = detectCardType(cardNumber);
      cardTypeDisplay.textContent = cardType !== '' ? 'Card Type: ' + cardType : '';
    }

    // Event listener for card number input
    document.getElementById('cardNumber').addEventListener('input', updateCardTypeDisplay);
  </script>
</body>
</html>


