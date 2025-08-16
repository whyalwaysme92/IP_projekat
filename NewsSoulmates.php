<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['IDkorisnika']) || $_SESSION['tip'] === 2) {
    header("Location: LoginPage.php");
    exit();
}

$ulogovaniID = $_SESSION['IDkorisnika'];

$connection = new mysqli("localhost", "root", "", "bazag01");
if ($connection->connect_error) {
    die("Greška prilikom povezivanja sa bazom podataka: " . $connection->connect_error);
}

// Dohvatanje ocena ulogovanog korisnika
$mojeOceneQuery = "SELECT IDVesti, Ocena FROM ocene WHERE IDkorisnika = $ulogovaniID";
$mojeOceneResult = $connection->query($mojeOceneQuery);

$mojeOcene = [];
while ($row = $mojeOceneResult->fetch_assoc()) {
    $mojeOcene[$row['IDVesti']] = $row['Ocena'];
}

// Dohvatanje svih korisnika osim ulogovanog koji su tip 2 ili 3
$query = "SELECT * FROM korisnici WHERE IDkorisnika != $ulogovaniID AND (tip = 2 OR tip = 3)";
$result = $connection->query($query);

$srodneDuse = [];

while ($row = $result->fetch_assoc()) {
    $drugiID = $row['IDkorisnika'];
    $tipKorisnika = $row['tip'];

    // Dohvatanje ocena drugog korisnika
    $drugoQuery = "SELECT IDVesti, Ocena FROM ocene WHERE IDkorisnika = $drugiID";
    $drugoResult = $connection->query($drugoQuery);

    $suma = 0;
    $brojZajednickih = 0;

    while ($ocenaRow = $drugoResult->fetch_assoc()) {
        $idVesti = $ocenaRow['IDVesti'];
        $ocenaDrugi = $ocenaRow['Ocena'];

        if (isset($mojeOcene[$idVesti])) {
            $suma += pow($mojeOcene[$idVesti] - $ocenaDrugi, 2);
            $brojZajednickih++;
        }
    }

    if ($brojZajednickih > 0) {
        $slicnost = round($suma, 2);
        $srodneDuse[] = [
            'IDkorisnika' => $drugiID,
            'tip' => $tipKorisnika,
            'Slicnost' => $slicnost
        ];
    }
}

// Sortiranje po slicnosti
usort($srodneDuse, function ($a, $b) {
    return $a['Slicnost'] <=> $b['Slicnost'];
});

// Uzimaćemo npr. prvih 5 najbližih srodnih duša da bismo prikazali njihove vesti
$topSrodneDuse = array_slice($srodneDuse, 0, 5);

$srodniAutoriIDs = [];
foreach ($topSrodneDuse as $sd) {
    if ($sd['tip'] == 2) { // Samo autori
        $srodniAutoriIDs[] = $sd['IDkorisnika'];
    }
}

// Ako nema srodnih autora, možeš prikazati poruku
if (empty($srodniAutoriIDs)) {
    $srodniAutoriIDs[] = 0; // da ne baci grešku u SQL-u
}

// Dohvatanje vesti od srodnih autora
$idsString = implode(',', $srodniAutoriIDs);

$vestiQuery = "
    SELECT v.*, k.Ime, k.Prezime 
    FROM vesti v 
    JOIN korisnici k ON v.IDkorisnika = k.IDkorisnika 
    WHERE v.IDkorisnika IN ($idsString)
    ORDER BY v.Datum DESC
";

$vestiResult = $connection->query($vestiQuery);

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

        <div class="News">
            <div class="HeadingDiv">
                <h1>Vesti - srodne duše</h1>
            </div>
            <div class="AllArticles">
                <?php if ($vestiResult && $vestiResult->num_rows > 0): ?>
                    <?php while ($vest = $vestiResult->fetch_assoc()): ?>
                        <div class="OneArticle">
                            <div class="ArticleInformations">
                                <div class="ArticleHeadingDiv">
                                    <a href="ShowArticle.php?id=<?= $vest['IDVesti'] ?>"><?= htmlspecialchars($vest['Naslov']) ?></a>
                                </div>
                                <div class="ArticleDateDiv">
                                    <p>Ocena: </p><p><?= number_format((float)$vest['Ocena'], 1) ?></p><p> | </p>
                                    <p><?= date("d-m-Y", strtotime($vest['Datum'])) ?></p>
                                </div>
                                <div class="ArticleAbstractDiv">
                                    <p><?= htmlspecialchars($vest['Apstrakt']) ?></p>
                                </div>
                            </div>
                            <div class="ArticleImageDiv">
                                <img src="<?= htmlspecialchars($vest['PrvaSlikaVesti']) ?>" alt="">
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="padding:20px;">Nema vesti srodnih duša za prikaz.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
    <script src="js/scriptFile.js"></script>
</body>
</html>
