<?php
session_start();

$connection = new mysqli("localhost", "root", "", "bazag01");
if ($connection->connect_error) {
    die("Greška prilikom povezivanja sa bazom: " . $connection->connect_error);
}

$korisnikId = $_SESSION['IDkorisnika'];


$sql = "SELECT v.IDVesti, v.Naslov, v.Datum, v.Apstrakt, v.PrvaSlikaVesti, k.Ime, k.Prezime, AVG(o.Ocena) AS ProsecnaOcena
        FROM ocene o
        JOIN vesti v ON o.IDVesti = v.IDVesti
        JOIN korisnici k ON v.IDKorisnika = k.IDKorisnika
        WHERE o.IDKorisnika = ?
        GROUP BY v.IDKorisnika
        ORDER BY ProsecnaOcena DESC";

$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $korisnikId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html> 
<html>
    <head>
        <title>Vesti omiljenih autora - newS</title>
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
                            <li><a href="AuthorsMainPage.php">Naslovna</a></li>
                            <li>
                                <a href="#">Vesti</a>
                                <ul>
                                    <li><a href="RecentNews.php">Najnovije</a></li>
                                    <li><a href="PopularNews.php">Najpopularnije</a></li>
                                    <li><a href="NewsFromLikedAuthors.php">Omiljeni&nbsp;autori</a></li>
                                    <li><a href="NewsSoulmates.php">Srodne&nbsp;duše</a></li>
                                </ul>
                            </li>
                            <li><a href="LikedAuthors.php">Omiljeni&nbsp;autori</a></li>
                            <li><a href="SoulmatesAuthors.php">Srodne&nbsp;duše</a></li>
                            <li><a href="AddArticle.php">Unesi&nbsp;vest</a></li>
                            <li><a href="MyNews.php">Moje&nbsp;vesti</a></li>
                            <li><a href="Logout.php">Izloguj&nbsp;se</a></li>
                        </ul>
                    </div>
                </div>
        
                <div class="News">
                    <div class="HeadingDiv">
                        <h1>Vesti omiljenih autora</h1>
                    </div>
                    <div class="AllArticles">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="OneArticle">
                                <div class="ArticleInformations">
                                    <div class="ArticleHeadingDiv">
                                        <a href="#"><?= htmlspecialchars($row['Naslov']) ?></a>
                                    </div>
                                    <div class="ArticleDateDiv">
                                        <p>Autor: </p><p><?= htmlspecialchars($row['Ime'] . ' ' . $row['Prezime']) ?></p><p> | </p>
                                        <p>Prosečna ocena autora: </p><p><?= number_format($row['ProsecnaOcena'], 1) ?></p><p> | </p>
                                    </div>
                                    <div class="ArticleDateDiv">
                                        <p><?= (new DateTime($row['Datum']))->format('d-m-Y') ?></p>
                                    </div>
                                    <div class="ArticleAbstractDiv">
                                        <p><?= htmlspecialchars($row['Apstrakt']) ?></p>
                                    </div>
                                </div>
                                <div class="ArticleImageDiv">
                                    <img src="<?= htmlspecialchars($row['PrvaSlikaVesti']) ?>" alt="">
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
$connection->close();
?>
