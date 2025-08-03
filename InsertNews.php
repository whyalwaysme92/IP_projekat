<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$connection = new mysqli("localhost", "root", "", "bazag01");

if ($connection->connect_error) {
    die("Neuspela konekcija: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naslov = $_POST['Naslov'] ?? '';
    $datum = $_POST['Datum'] ?? '';
    $apstrakt = $_POST['Apstrakt'] ?? '';
    $tekst = $_POST['Tekst'] ?? '';
    $ocena = 0.0; // Default ocena, može se kasnije promeniti ako je potrebno
    
    $IDkorisnika = $_SESSION['IDkorisnika'] ?? null;

    $prvaSlika = $_FILES['PrvaSlikaVesti']['name'] ?? '';
    $drugaSlika = $_FILES['DrugaSlikaVesti']['name'] ?? '';
    
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $prvaSlikaPath = $targetDir . basename($prvaSlika);
    $drugaSlikaPath = $targetDir . basename($drugaSlika);
    
    move_uploaded_file($_FILES['PrvaSlikaVesti']['tmp_name'], $prvaSlikaPath);
    move_uploaded_file($_FILES['DrugaSlikaVesti']['tmp_name'], $drugaSlikaPath);
    
    $query = "INSERT INTO vesti (Naslov, Apstrakt, Tekst, PrvaSlikaVesti, DrugaSlikaVesti, Ocena, IDkorisnika)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param("sssssdi", $naslov, $apstrakt, $tekst, $prvaSlikaPath, $drugaSlikaPath, $ocena, $IDkorisnika);
        if ($stmt->execute()) {
            header("Location: MyNews.php");
            exit();
        } else {
            echo "Greška pri unosu vesti: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    echo "Neispravan zahtev.";
}
?>
