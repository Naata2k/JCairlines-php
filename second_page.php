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

$destination = isset($_GET['destination']) ? $conn->real_escape_string($_GET['destination']) : '';

$sql = "
    SELECT * 
    FROM lennot 
    WHERE Kohdemaa LIKE '%$destination%' OR Kaupunki LIKE '%$destination%'
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../sivusto/styles/lennot.css">
</head>
<body>
    <header>
        <div class="redBox">
        <a href="index.php" class="jcairlineText" style="text-decoration: none;">
            JC airline
        </a>
        </div>
        <img class="bannerImg" src="../sivusto/img/image 3.png" alt="">
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
    <h1>Vapaat lennot</h1>
    
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php
                $country = strtolower(trim($row['Kohdemaa'])); 
                $imageFile = "./img/default.png"; 
                if ($country === 'ruotsi') {
                    $imageFile = "./img/ruotsi.png";
                } elseif ($country === 'islanti') {
                    $imageFile = "./img/islanti.png";
                } elseif ($country === 'norja') {
                    $imageFile = "./img/norja.png";
                } elseif ($country === 'suomi') {
                    $imageFile = "./img/suomi.png";
                } elseif ($country === 'tanska') {
                    $imageFile = "./img/tanska.png";
                }
            ?>
            <div class="redCanvas">
                <img src="<?php echo $imageFile; ?>" alt="<?php echo htmlspecialchars($row['Kohdemaa']); ?>">
                <div>
                    <h2><?php echo htmlspecialchars($row['Kaupunki']); ?></h2>
                    <p>Lennon tyyppi: <?php echo htmlspecialchars($row['Aika']); ?></p>
                </div>
                <hr>
                <div>
                    <p>Kone: <?php echo htmlspecialchars($row['Kone']); ?></p>
                    <p>Lipun hinta: <?php echo htmlspecialchars(number_format($row['LipunHinta'], 2)); ?>€</p>
                    <p>Paikkoja vapaana: <?php echo htmlspecialchars($row['VapaatPaikat']); ?></p>
                </div>
                <hr>
                <div>
                    <a href="third_page.php?LentoID=<?php echo $row['LentoID']; ?>" style="text-decoration: none; color: inherit;">
                        <p style="font-size: 1.5rem; color: white; text-align: center;">Valitse lento</p>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Lentoja ei löytynyt kohteeseen "<?php echo htmlspecialchars($destination); ?>"</p>
    <?php endif; ?>
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

<?php
$conn->close();
?>
