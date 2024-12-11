<?php
session_start();
error_reporting(0);
include('../includes/config.php');
$useremail = $_SESSION['login'];
$sql = "SELECT tblvehicles.PricePerDay, DATEDIFF(tblbooking.ToDate, tblbooking.FromDate) as totaldays 
        FROM tblbooking 
        JOIN tblvehicles ON tblbooking.VehicleId = tblvehicles.id 
        WHERE tblbooking.userEmail = :useremail 
        ORDER BY tblbooking.id DESC 
        LIMIT 1"; // Adjust as needed for multiple bookings

$query = $dbh->prepare($sql);
$query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

$totalPrice = 0;
if ($result) {
    $totalPrice = $result->PricePerDay * $result->totaldays;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
          content="width=device-width, initial-scale=1.0">
    <title>Online Payment-Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">

        <form id="paymentForm" action="../my-booking.php">

            <div class="row">

                <div class="col">
                    <h3 class="title">
                        Billing Address
                    </h3>

                    <div class="inputBox">
                        <label for="name">
                              Price
                          </label>
                          <input type="text" id="price" placeholder="Total Price" value="<?php echo htmlentities($totalPrice); ?> Rs." required disabled>

                    </div>

                    <div class="inputBox">
                        <label for="email">
                              Email:
                          </label>
                        <input type="text" id="email" 
                               placeholder="Enter email address" 
                               required>
                    </div>

                    <div class="inputBox">
                        <label for="address">
                              Address:
                          </label>
                        <input type="text" id="address" 
                               placeholder="Enter address" 
                               required>
                    </div>

                    <div class="inputBox">
                        <label for="city">
                              City:
                          </label>
                        <input type="text" id="city" 
                               placeholder="Enter city" 
                               required>
                    </div>

                    <div class="flex">

                        <div class="inputBox">
                            <label for="state">
                                  State:
                              </label>
                            <input type="text" id="state" 
                                   placeholder="Enter state" 
                                   required>
                        </div>

                        <div class="inputBox">
                            <label for="zip">
                                  Zip Code:
                              </label>
                            <input type="number" id="zip" 
                                   placeholder="123 456" 
                                   required>
                        </div>

                    </div>

                </div>
                <div class="col">
                    <h3 class="title">Payment</h3>

                    <div class="inputBox">
                        <label for="name">
                              Card Accepted:
                          </label>
                        <img src=
"https://media.geeksforgeeks.org/wp-content/uploads/20240715140014/Online-Payment-Project.webp" 
                             alt="credit/debit card image">
                    </div>

                    <div class="inputBox">
                        <label for="cardName">
                              Name On Card:
                          </label>
                        <input type="text" id="cardName" 
                               placeholder="Enter card name" 
                               required>
                    </div>

                    <div class="inputBox">
                        <label for="cardNum">
                              Credit Card Number:
                          </label>
                        <input type="text" id="cardNum" 
                               placeholder="1111-2222-3333-4444" 
                               maxlength="19" required>
                    </div>

                    <div class="inputBox">
                        <label for="">Exp Month:</label>
                        <select name="" id="">
                            <option value="">Choose month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>


                    <div class="flex">
                        <div class="inputBox">
                            <label for="">Exp Year:</label>
                            <select name="" id="">
                                <option value="">Choose Year</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                            </select>
                        </div>

                        <div class="inputBox">
                            <label for="cvv">CVV</label>
                            <input type="number" id="cvv" 
                                   placeholder="1234" required>
                        </div>
                    </div>

                </div>

            </div>

            <input type="submit"  value="Proceed to Checkout" 
                   class="submit_btn">
        </form>

    </div>
    <script>
        let cardNumInput = 
    document.querySelector('#cardNum')

cardNumInput.addEventListener('keyup', () => {
    let cNumber = cardNumInput.value
    cNumber = cNumber.replace(/\s/g, "")

    if (Number(cNumber)) {
        cNumber = cNumber.match(/.{1,4}/g)
        cNumber = cNumber.join(" ")
        cardNumInput.value = cNumber
    }
})
    </script>
    <script>
        // Get the form element
let form = document.getElementById('paymentForm');

// Add event listener to the form
form.addEventListener('submit', function(event) {
    // Prevent default form submission
    event.preventDefault();

    // Display alert
    alert('Payment submitted successfully!');

    window.location.href = '../my-booking.php';
});
    </script>
</body>

</html>
