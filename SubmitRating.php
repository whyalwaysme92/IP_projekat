<?php
session_start();

if (!isset($_SESSION['IDkorisnika'])) {
    http_response_code(403);
    echo "Niste prijavljeni.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['IDkorisnika'];
    $articleId = isset($_POST['article_id']) ? intval($_POST['article_id']) : 0;
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

    if ($articleId > 0 && $rating >= 1 && $rating <= 5) {
        $connection = new mysqli("localhost", "root", "", "bazag01");
        if ($connection->connect_error) {
            http_response_code(500);
            echo "Greška sa bazom.";
            exit;
        }

        // Check if rating already exists
        $stmt = $connection->prepare("SELECT Ocena FROM ocene WHERE IDkorisnika = ? AND IDVesti = ?");
        $stmt->bind_param("ii", $userId, $articleId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Update existing rating
            $stmt->close();
            $update = $connection->prepare("UPDATE ocene SET Ocena = ? WHERE IDkorisnika = ? AND IDVesti = ?");
            $update->bind_param("iii", $rating, $userId, $articleId);
            $update->execute();
            $update->close();
        } else {
            // Insert new rating
            $stmt->close();
            $insert = $connection->prepare("INSERT INTO ocene (IDkorisnika, IDVesti, Ocena) VALUES (?, ?, ?)");
            $insert->bind_param("iii", $userId, $articleId, $rating);
            $insert->execute();
            $insert->close();
        }

        $connection->close();

        // Update average rating for the article
        include 'UpdateAverageRatings.php';

        echo "Uspešno ste ocenili vest!";
    } else {
        http_response_code(400);
        echo "Neispravni podaci.";
    }
} else {
    http_response_code(405);
    echo "Dozvoljen je samo POST zahtev.";
}
?>
