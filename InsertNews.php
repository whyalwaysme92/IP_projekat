<?php
session_start();
require_once "db_connection.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naslov = $_POST['naslov'] ?? '';
    $datum = $_POST['datum'] ?? '';
    $apstrakt = $_POST['apstrakt'] ?? '';
    $tekst = $_POST['tekst'] ?? '';
    $ocena = 0; 
    
    $prvaSlika = $_FILES['prva_slika']['name'] ?? '';
    $drugaSlika = $_FILES['druga_slika']['name'] ?? '';
    
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $prvaSlikaPath = $targetDir . basename($prvaSlika);
    $drugaSlikaPath = $targetDir . basename($drugaSlika);
    
    move_uploaded_file($_FILES['prva_slika']['tmp_name'], $prvaSlikaPath);
    move_uploaded_file($_FILES['druga_slika']['tmp_name'], $drugaSlikaPath);
    
    $query = "INSERT INTO vesti (Naslov, Datum, Apstrakt, Tekst, PrvaSlikaVesti, DrugaSlikaVesti, Ocena)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssssssi", $naslov, $datum, $apstrakt, $tekst, $prvaSlikaPath, $drugaSlikaPath, $ocena);
        if ($stmt->execute()) {
            echo "Uspešno dodata vest!";
        } else {
            echo "Greška pri unosu vesti: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
} else {
    echo "Neispravan zahtev.";
}
?>
