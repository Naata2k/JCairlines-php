<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "jcairline_db";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JC Airline</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@160..700&family=Reem+Kufi:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../sivusto/styles/style.css">
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('payment_success')) {
                alert("Matkasi on tilattu ja maksaminen onnistui. Kiitos kun valitsit JC Airlinesin.");
            }
        }
    </script>
</head>

<body>
    <header>
        <div class="redBox">
            <p class="jcairlineText">JC airline</p>
        </div>
        <img class="bannerImg" src="../sivusto/img/image 1.png" alt="">
    </header>

    <div class="searchBox">
        <p>Varaa lento</p>
        <form action="second_page.php" method="GET">
            <div class="search">
                <input placeholder="Lentosi määränpää" type="text" name="destination" required>
                <button type="submit">
                    <p>Search</p>
                </button>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="contentParagraphs">
            <p class="p1">JC Airlines - Rohkeasti Eri Tavalla</p>
            <p class="p2">JC Airlinesin arvot perustuvat vahvaan palveluasenteeseen, rohkeuteen olla erilainen ja aidosti välittämiseen. Meille jokainen matkustaja on tärkeä, ja haluamme tarjota henkilökohtaista ja ystävällistä palvelua järkevään hintaan. Lennot voi varata helposti 24/7 silloin, kun se sinulle parhaiten sopii.</p>
        </div>
        <div class="imgContainer">
            <img src="../sivusto/img/image 2.png" alt="">
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
