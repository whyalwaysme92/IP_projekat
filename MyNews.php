<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['IDkorisnika'])) {
    // Nije ulogovan - redirektuj na login stranicu ili pokaži grešku
    header("Location: Login.php");
    exit();
}

$connection = new mysqli("localhost", "root", "", "bazag01");
if ($connection->connect_error) {
    die("Greška prilikom povezivanja sa bazom: " . $connection->connect_error);
}

$id = (int)$_SESSION['IDkorisnika'];  // sigurnije je kastovati u int pre upita

// Dohvati vesti koje pripadaju ulogovanom korisniku (autoru)
$sql = "SELECT * FROM vesti WHERE IDkorisnika = $id ORDER BY Datum DESC";
$result = $connection->query($sql);
?>

<!DOCTYPE html> 
<html>
<head>
    <title>Moje vesti - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_MyNews.css"> 
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
                            <a href="">Vesti</a>
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

            <div class="MyNews">
                <div class="HeadingDiv">
                    <h1>Moje vesti</h1>
                </div>
                <div class="AllMyArticles">
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($vest = $result->fetch_assoc()) {
                            ?>
                            <div class="OneArticle">
                                <div class="ArticleImageDiv">
                                    <?php if (!empty($vest['PrvaSlikaVesti'])): ?>
                                        <img src="<?= htmlspecialchars($vest['PrvaSlikaVesti']) ?>" alt="">
                                    <?php else: ?>
                                        <img src="images/default-news.jpg" alt="">
                                    <?php endif; ?>
                                </div>
                                <div class="ArticleInformations">
                                    <div class="ArticleHeadingDiv">
                                    <a href="ShowArticle.php?id=<?= urlencode($vest['IDVesti']) ?>">
                                        <?= htmlspecialchars($vest['Naslov']) ?>
                                    </a>
                                    </div>
                                    <div class="ArticleDateDiv">
                                        <p><?= (new DateTime($vest['Datum']))->format('d-m-Y') ?></p>
                                    </div>
                                    <div class="ArticleAbstractDiv">
                                        <p><?= htmlspecialchars($vest['Apstrakt']) ?></p>
                                    </div>
                                </div>
                                <div class="ArticleButtons">
                                <a href="UpdateArticle.php?id=<?= $vest['IDVesti']; ?>">
                                        <button id="Update">Ažuriraj</button>
                                    </a>
                                    <a href="DeleteArticle.php?id=<?= urlencode($vest['IDVesti']) ?>" >
                                        <button>Briši</button>
                                    </a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p>Nemate unetih vesti.</p>";
                    }
                    $connection->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="js/scriptFile.js"></script>
</body>
</html>
