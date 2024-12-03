<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "jcairline_db";
$port = 3307;
$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tilaajanNimi = $conn->real_escape_string($_POST['firstname']);
$tilaajanOsoite = $conn->real_escape_string($_POST['address']);
$tilaajanPuh = $conn->real_escape_string($_POST['phonenumber']);
$tilaajanEmail = $conn->real_escape_string($_POST['email']);
$lippujenMaara = intval($_POST['ticket_count']);
$LentoID = intval($_POST['LentoID']);

$sql = "SELECT * FROM lennot WHERE LentoID = $LentoID";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $flight = $result->fetch_assoc();
    $kaupunki = $flight['Kaupunki'];
    $totalPrice = $flight['LipunHinta'] * $lippujenMaara;

    $ajankohta = date("Y-m-d H:i:s");

    $insertSQL = "INSERT INTO kuitti (kaupunki, lippujenMaara, tilaajanNimi, ajankohta, tilaajanOsoite, tilaajanEmail, tilaajanPuh) 
                  VALUES ('$kaupunki', $lippujenMaara, '$tilaajanNimi', '$ajankohta', '$tilaajanOsoite', '$tilaajanEmail', '$tilaajanPuh')";

    if ($conn->query($insertSQL)) {
        header("Location: index.php?payment_success=1");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid flight.";
}

$conn->close();
?>
