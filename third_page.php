<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "jcairline_db";
$port = 3307;
$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed. Please try again later.");
}

$flightID = isset($_GET['LentoID']) ? intval($_GET['LentoID']) : 0;
$flight = null; // Initialize the $flight variable to null

if ($flightID > 0) {
    $sql = "SELECT * FROM lennot WHERE LentoID = $flightID";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $flight = $result->fetch_assoc();
    } else {
        error_log("No flight found for ID: $flightID");
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="../sivusto/styles/maksu.css">
    <script>
        function updatePrice() {
            const ticketCount = document.getElementById('tickets').value || 0;
            const pricePerTicket = <?php echo $flight ? $flight['LipunHinta'] : 0; ?>;
            const totalPrice = ticketCount * pricePerTicket;
            document.getElementById('price').textContent = `Hinta: ${totalPrice.toFixed(2)} €`;
        }

        function submitForm() {
            document.getElementById('paymentForm').submit();
        }
    </script>
</head>
<body>
    <header>
        <div class="redBox">
            <a href="index.php" class="jcairlineText" style="text-decoration: none;">
                JC airline
            </a>
        </div>
        <img class="bannerImg" src="../sivusto/img/image 3.png" alt="Banner Image">
    </header>

    <div class="container">
        <div class="leftPanel">
            <form id="paymentForm" action="process_payment.php" method="POST">
                <div class="lineInputs">
                    <p class="FirstnameLastname">Kokonimi:</p>
                    <input type="text" name="firstname" required>
                </div>

                <div class="lineInputs">
                    <p class="address">Osoite:</p>
                    <input type="text" name="address" required>
                </div>

                <div class="lineInputs">
                    <p class="Phonenumber">Puhelin numero:</p>
                    <input type="text" name="phonenumber" required>
                </div>

                <div class="lineInputs">
                    <p class="eMail">Sähköposti:</p>
                    <input type="email" name="email" required>
                </div>

                <div class="lineInputs">
                    <p class="tickets">Lippujen määrä:</p>
                    <input type="number" id="tickets" name="ticket_count" min="1" max="<?php echo $flight ? $flight['VapaatPaikat'] : 1; ?>" oninput="updatePrice()" required>
                </div>

                <input type="hidden" name="LentoID" value="<?php echo $flightID; ?>">
            </form>
        </div>

        <div class="rightPanel" >
            <?php if ($flight): ?>
                <div class="rightPanelContent">
                    <p class="country">Kohdemaa: <?php echo htmlspecialchars($flight['Kohdemaa']); ?></p>
                    <p class="flightType">Lennon tyyppi: <?php echo htmlspecialchars($flight['Aika']); ?></p>
                    <p class="parture">Lähtö: Suomi, Helsinki</p>
                    <p class="departure">Määränpää: <?php echo htmlspecialchars($flight['Kaupunki']); ?></p>
                </div>

                <div style="display: flex;">
                    <p id="price" class="price" style="color: black;">Hinta: 0.00 €</p>
                    <button type="button" class="payBtn" onclick="submitForm()">Maksa</button>
                </div>
                
            <?php else: ?>
                <p>Invalid flight selection.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <div class="footerParagraphs">
            <p>Yhteystiedot</p>
            <p>Lentotie 37</p>
            <p>47333, Helsinki</p>
            <p>JC@airline.com</p>
            <p>+358 44 912 8432</p>
        </div>
    </footer>
</body>
</html>
