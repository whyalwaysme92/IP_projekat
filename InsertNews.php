<?php
$connection = new mysqli("localhost", "root", "", "bazag01");

if ($connection->connect_error) {
    die("Neuspela konekcija: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naslov = $_POST['Naslov'] ?? '';
    $datum = $_POST['Datum'] ?? '';
    $apstrakt = $_POST['Apstrakt'] ?? '';
    $tekst = $_POST['Tekst'] ?? '';
    $ocena = 0; 
    
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
    
    $query = "INSERT INTO vesti (Naslov, Datum, Apstrakt, Tekst, PrvaSlikaVesti, DrugaSlikaVesti, Ocena)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param("ssssssi", $naslov, $datum, $apstrakt, $tekst, $prvaSlikaPath, $drugaSlikaPath, $ocena);
        if ($stmt->execute()) {
            header("Location: MyNews.php");
        } else {
            echo "Greška pri unosu vesti: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    echo "Neispravan zahtev.";
}
?>
