<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$connection = new mysqli("localhost", "root", "", "bazag01");

if ($connection->connect_error) {
    die("Neuspela konekcija: " . $connection->connect_error);
}


if (!isset($sort)) {
    $sort = 'date';
}

if ($sort === 'popularity') {
    $sql = "SELECT IDVesti, Naslov, Apstrakt, Datum, Ocena, PrvaSlikaVesti, DrugaSlikaVesti, Tekst 
            FROM vesti 
            ORDER BY Ocena DESC"; 
} else if ($sort === 'best') {
    $sql = "SELECT IDVesti, Naslov, Apstrakt, Datum, Ocena, PrvaSlikaVesti, DrugaSlikaVesti, Tekst 
            FROM vesti 
            ORDER BY Ocena DESC"; 
} else if ($sort === 'favorite') {
    $sql = "SELECT v.IDVesti, v.Naslov, v.Apstrakt, v.Datum, v.Ocena, v.PrvaSlikaVesti, v.DrugaSlikaVesti, v.Tekst 
            FROM vesti v
            JOIN korisnici k ON v.IDKorisnika = k.IDKorisnika
            WHERE k.IDKorisnika IN (
                SELECT DISTINCT k.IDKorisnika
                FROM korisnici k
                JOIN vesti v ON v.IDKorisnika = k.IDKorisnika
                JOIN ocene o ON o.IDVesti = v.IDVesti
                WHERE o.IDKorisnika = ?
            )
            ORDER BY v.Datum DESC";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $_SESSION['IDkorisnika']);
    $stmt->execute();
    $result = $stmt->get_result();
} else if ($sort === 'date') {
    $sql = "SELECT IDVesti, Naslov, Apstrakt, Datum, Ocena, PrvaSlikaVesti, DrugaSlikaVesti, Tekst 
            FROM vesti 
            ORDER BY Datum DESC"; 
}

if ($sort !== 'favorite') {
    $result = $connection->query($sql);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $date = new DateTime($row['Datum']);
        echo '<div class="OneArticle">';
        echo '<div class="ArticleHeader"> <a href="">' . htmlspecialchars($row['Naslov']) . '</a></div>';
        echo '<div class="ArticleDate"> <p>' . $date->format('Y-m-d') . '</p> <p> | </p></div>';
        #echo '<div class="ArticleAuthor"> <p>' . htmlspecialchars($row['Autor']) . '</p></div>';
        echo '<div class="ArticleGrade"> <p>' . htmlspecialchars($row['Ocena']) . '</p></div>';
        echo '<div class="ArticleText"> <p>' . htmlspecialchars($row['Apstrakt']) . '</p></div>';
        echo '</div>';
    }
} else {
    echo "No news found.";
}


$connection->close();
?>