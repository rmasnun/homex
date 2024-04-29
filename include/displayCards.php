<?php
session_start();
include("config.php");

// Check if user is logged in
if(!isset($_SESSION['uid'])) {
    // Redirect user to login page or handle unauthorized access
    header("Location: login.php");
    exit(); // Stop further execution
}

// Get the userid from session
$userid = $_SESSION['uid'];

// Query to select all cards for the specific userid
$query = "SELECT * FROM cards WHERE userid = '$userid'";
$result = mysqli_query($con, $query);

// Check if query executed successfully
if($result) {
    // Check if there are cards for the user
    if(mysqli_num_rows($result) > 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Cards</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Saved Cards</h2>
        <div class="row">
<?php
        // Fetch and display card information
        while($row = mysqli_fetch_assoc($result)) {
?>
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <span id="targeth5" style="display: None";><?php echo $row['cardNumber']; ?></span>
                        <h5 class="card-title">Card Number: <?php echo $row['cardNumber']; ?></h5>
                        <p class="card-text">Expiration Date: <?php echo $row['expiryDate']; ?></p>
                        <!-- Display other card details as needed -->
                        <span id="cardTypeDisplay"></span>
                    </div>
                </div>
            </div>
<?php
        }
?>
        </div>
    </div>
</body>
<script>
    // Function to introduce a delay
    function delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

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
    async function updateCardTypeDisplay() {
        console.log("function starting");
        await delay(0);
        console.log("function running");
        var cardNumber = document.getElementById('targeth5').textContent.trim(); // Get the text content of the hidden span element
        console.log(cardNumber);
        var cardTypeDisplay = document.getElementById('cardTypeDisplay');
        var cardType = detectCardType(cardNumber);
        cardTypeDisplay.textContent = cardType !== '' ? 'Card Type: ' + cardType : '';
    }
    updateCardTypeDisplay();

</script>
</html>
<?php
    } else {
        echo "No cards found for this user.";
    }
} else {
    echo "Error: " . mysqli_error($con);
}

// Close the connection
mysqli_close($con);
?>
