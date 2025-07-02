<?php
$connection = new mysqli("localhost", "root", "", "bazag01");
if ($connection->connect_error) {
    die("Greška prilikom povezivanja sa bazom: " . $connection->connect_error);
}

$sql = "SELECT IDVesti, Naslov, Apstrakt, Datum, Ocena, PrvaSlikaVesti 
        FROM vesti 
        ORDER BY Datum DESC";

$result = $connection->query($sql);
?>

<!DOCTYPE html> 
<html>
<head>
    <title>Najnovije vesti - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_News.css"> 
</head>
<body>
    <div class="PageContentDiv">
        <div class="PageContent">
            <div class="Header">
                <div class="HeaderLogoImage">
                    <p>new<span>S</span></p>
                </div>
                <div class="HeaderNavigation">
                    <ul>
                        <li><a href="Admins.php">Naslovna</a></li>
                        <li><a href="RecentNewsAdmins.php">Najnovije&nbsp;vesti</a></li>
                        <li><a href="Authors.php">Autori</a></li>
                        <li><a href="Readers.php">Čitaoci</a></li>
                        <li><a href="Logout.php">Izloguj&nbsp;se</a></li>
                    </ul>
                </div>
            </div>

            <div class="News">
                <div class="HeadingDiv">
                    <h1>Najnovije vesti</h1>
                </div>
                <div class="AllArticles">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $date = new DateTime($row['Datum']);
                            echo '<div class="OneArticle">';
                            echo '<div class="ArticleInformations">';
                            echo '<div class="ArticleHeadingDiv"><a href="Author.php?id=' . htmlspecialchars($row['IDVesti']) . '">' . htmlspecialchars($row['Naslov']) . '</a></div>';
                            echo '<div class="ArticleDateDiv">';
                            echo '<p>Ocena: </p><p>' . htmlspecialchars($row['Ocena']) . '</p><p> | </p>';
                            echo '<p>' . $date->format('d-m-Y') . '</p>';
                            echo '</div>';
                            echo '<div class="ArticleAbstractDiv"><p>' . htmlspecialchars($row['Apstrakt']) . '</p></div>';
                            echo '</div>';
                            echo '<div class="ArticleImageDiv">';
                            if (!empty($row['PrvaSlikaVesti'])) {
                                echo '<img src="' . htmlspecialchars($row['PrvaSlikaVesti']) . '" alt="Slika vesti">';
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>Nema dostupnih vesti.</p>";
                    }
                    $connection->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
