<?php
session_start();
if (!isset($_SESSION['IDkorisnika']) || $_SESSION['tip'] != 2) {
    header("Location: LoginPage.php");
    exit();
}

$connection = new mysqli("localhost", "root", "", "bazag01");
if ($connection->connect_error) {
    die("Greška prilikom povezivanja sa bazom: " . $connection->connect_error);
}

$idCitaoca = $_SESSION['IDkorisnika'];

$query = "
    SELECT k.IDkorisnika AS IDautora, k.Ime, k.Prezime, k.Email, k.Telefon, k.Adresa, k.Slika,
           AVG(o.Ocena) AS ProsecnaOcena
    FROM ocene o
    JOIN vesti v ON o.IDVesti = v.IDVesti
    JOIN korisnici k ON v.IDkorisnika = k.IDkorisnika
    WHERE o.IDkorisnika = ?
      AND k.Tip = 2
    GROUP BY k.IDkorisnika
    ORDER BY ProsecnaOcena DESC
";

$stmt = $connection->prepare($query);
$stmt->bind_param("i", $idCitaoca);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html> 
<html>
<head>
    <title>Omiljeni autori - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_Authors.css"> 
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

            <div class="Authors">
                <div class="HeadingDiv">
                    <h1>Omiljeni autori</h1>
                </div>
                <div class="AllAuthors">
                    <?php while ($author = $result->fetch_assoc()): ?>
                        <div class="OneAuthor">
                            <div class="AuthorImageDiv">
                                <img src="<?= !empty($author['Slika']) ? $author['Slika'] : 'images/default-profile.png' ?>" alt="">
                            </div>
                            <div class="AuthorInformations">
                                <div class="AuthorHeadingDiv">
                                    <a href="Author.php?id=<?= $author['IDautora'] ?>">
                                        <?= htmlspecialchars($author['Ime'] . ' ' . $author['Prezime']) ?>
                                    </a>
                                </div>
                                <div class="AuthorEmailDiv">
                                    <a href="mailto:<?= htmlspecialchars($author['Email']) ?>">
                                        <?= htmlspecialchars($author['Email']) ?>
                                    </a>
                                </div>
                                <div class="AuthorGradeDiv">
                                    <p>Ocena autora: </p><p><?= number_format($author['ProsecnaOcena'], 1) ?></p>
                                </div>
                                <div class="AuthorPhoneAndAddressDiv">
                                    <div class="PhoneDiv">
                                        <p>Telefon: </p>
                                        <a href="tel:<?= htmlspecialchars($author['Telefon']) ?>">
                                            <?= htmlspecialchars($author['Telefon']) ?>
                                        </a>
                                    </div>
                                    <div class="AddressDiv">
                                        <p class="AddressText">Adresa: <?= htmlspecialchars($author['Adresa']) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="AuthorButtons">
                                <button id="Update" style="margin-bottom: 10px;">Izbaci</button>
                                <button>Ubaci</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php if ($result->num_rows === 0): ?>
                        <p style="text-align: center; margin-top: 20px;">Niste ocenili nijednog autora.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$stmt->close();
$connection->close();
?>
