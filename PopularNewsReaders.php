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
    <body data-user-type="<?php echo (session_status() === PHP_SESSION_NONE) ? 3 : (isset($_SESSION['tip']) ? (int)$_SESSION['tip'] : 3);?>">
        <div class="PageContentDiv">
            <div class="PageContent">
                <!-- <div class="Header">
                    <div class="HeaderLogoImage">
                        <p>new<span>S</span></p>
                    </div>
                    <div class="HeaderNavigation">
                        <ul>
                            <li><a href="ReadersMainPage.php">Naslovna</a></li>
                            <li>
                                <a href="#">Vesti</a>
                                <ul>
                                    <li><a href="RecentNewsReaders.php">Najnovije</a></li>
                                    <li><a href="PopularNewsReaders.php">Najpopularnije</a></li>
                                    <li><a href="NewsFromLikedAuthorsReaders.php">Omiljeni&nbsp;autori</a></li>
                                    <li><a href="NewsSoulmatesReaders.php">Srodne&nbsp;duše</a></li>
                                </ul>
                            </li>
                            <li><a href="LikedAuthorsReaders.php">Omiljeni&nbsp;autori</a></li>
                            <li><a href="Soulmates.php">Srodne&nbsp;duše</a></li>
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
        <script src="js/scriptFile.js"></script>
    </body>
</html>
<?php $connection->close(); ?>
