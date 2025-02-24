<?php

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
} else {
    $sql = "SELECT IDVesti, Naslov, Apstrakt, Datum, Ocena, PrvaSlikaVesti, DrugaSlikaVesti, Tekst 
            FROM vesti 
            ORDER BY Datum DESC"; 
} 


$result = $connection->query($sql);

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