<?php
$connection = new mysqli("localhost", "root", "", "bazag01");
if ($connection->connect_error) {
    die("Greška prilikom povezivanja sa bazom: " . $connection->connect_error);
}

$sql = "SELECT v.IDVesti, v.Naslov, v.Datum, v.Apstrakt, v.PrvaSlikaVesti, AVG(o.Ocena) AS ProsecnaOcena
        FROM vesti v
        JOIN ocene o ON v.IDVesti = o.IDVesti
        GROUP BY v.IDVesti
        ORDER BY ProsecnaOcena DESC";

$result = $connection->query($sql);
?>
<!DOCTYPE html> 
<html>
    <head>
        <title>Najpopularnije vesti - newS</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style_News.css"> 
    </head>
    <body>
        <div class="PageContentDiv">
            <div class="PageContent">
                <!-- <div class="Header">
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
                </div> -->
        
                <?php 
                    include 'Navigation.php'; 
                ?>

                <div class="News">
                    <div class="HeadingDiv">
                        <h1>Najpopularnije vesti</h1>
                    </div>
                    <div class="AllArticles">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="OneArticle">
                                <div class="ArticleInformations">
                                    <div class="ArticleHeadingDiv">
                                        <a href="#"><?= htmlspecialchars($row['Naslov']) ?></a>
                                    </div>
                                    <div class="ArticleDateDiv">
                                        <p>Ocena: </p><p><?= number_format($row['ProsecnaOcena'], 1) ?></p><p> | </p>
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
<?php $connection->close(); ?>
