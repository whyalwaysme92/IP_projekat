<?php
$connection = new mysqli("localhost", "root", "", "bazag01");
if ($connection->connect_error) {
    die("Greška prilikom povezivanja sa bazom: " . $connection->connect_error);
}

// Proveri da li je prosleđen ID korisnika kroz URL
if (!isset($_GET['IDkorisnika']) || !is_numeric($_GET['IDkorisnika'])) {
    die("Greška: ID korisnika nije prosleđen ili nije validan.");
}

$id = intval($_GET['IDkorisnika']);

// Preuzmi podatke o autoru
$userQuery = "SELECT * FROM korisnici WHERE IDkorisnika = $id AND Tip = 2";
$userResult = $connection->query($userQuery);

if ($userResult->num_rows === 0) {
    die("Autor nije pronađen.");
}

$user = $userResult->fetch_assoc();

// Preuzmi sve vesti tog autora
$newsQuery = "SELECT * FROM vesti WHERE IDKorisnika = $id ORDER BY Datum DESC";
$newsResult = $connection->query($newsQuery);
?>


<!DOCTYPE html> 
<html>
<head>
    <title>Podaci o autoru - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_Author.css"> 
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
                    <li><a href="RecentNews.php">Najnovije&nbsp;vesti</a></li>
                    <li><a href="LikedAuthors.php">Omiljeni&nbsp;autori</a></li>
                    <li><a href="AddArticle.php">Unesi&nbsp;vest</a></li>
                    <li><a href="MyNews.php">Moje&nbsp;vesti</a></li>
                    <li><a href="Logout.php">Izloguj&nbsp;se</a></li>
                </ul>
            </div>
        </div> -->

        <?php 
            include 'Navigation.php'; 
        ?>

        <div class="Authors">
            <div class="HeadingDiv">
                <h1>Podaci o autoru</h1>
            </div>
            <div class="AllAuthors">
                <div class="OneAuthorData">
                    <div class="AuthorInformations">
                        <div class="AuthorHeadingDiv">
                        <a href="#"><?= htmlspecialchars($user['Ime'] . ' ' . $user['Prezime']) ?></a>
                        </div>
                        <div class="AuthorEmailDiv">
                            <a href="mailto:<?= htmlspecialchars($user['Email']) ?>"><?= htmlspecialchars($user['Email']) ?></a>
                        </div>
                        <div class="AuthorPhoneAndAddressDiv">
                            <div class="PhoneDiv">
                                <p>Telefon: </p><a href="tel:<?= htmlspecialchars($user['Telefon']) ?>"><?= htmlspecialchars($user['Telefon']) ?></a>
                            </div>
                            <div class="AddressDiv">
                                <p class="AddressText">Adresa: <?= htmlspecialchars($user['Adresa']) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="AuthorImageDiv">
                        <img src="<?= !empty($user['Slika']) ? $user['Slika'] : 'images/default-profile.png' ?>" alt="Profilna slika">
                    </div>
                </div>
            </div>

            <div class="HeadingDiv">
                <h1>Vesti datog autora</h1>
            </div>
            <div class="AllArticles">
                <?php while ($vest = $newsResult->fetch_assoc()): ?>
                    <div class="OneArticle">
                        <div class="ArticleInformations">
                            <div class="ArticleHeadingDiv">
                                <a href="#"><?= htmlspecialchars($vest['Naslov']) ?></a>
                            </div>
                            <div class="ArticleDateDiv">
                                <p><?= (new DateTime($vest['Datum']))->format('d-m-Y') ?></p>
                            </div>
                            <div class="ArticleAbstractDiv">
                                <p><?= htmlspecialchars($vest['Apstrakt']) ?></p>
                            </div>
                        </div>
                        <div class="ArticleImageDiv">
                            <?php if (!empty($vest['PrvaSlikaVesti'])): ?>
                                <img src="<?= htmlspecialchars($vest['PrvaSlikaVesti']) ?>" alt="Slika vesti">
                            <?php endif; ?>
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
