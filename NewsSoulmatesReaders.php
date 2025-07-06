<?php
session_start();

if (!isset($_SESSION['IDkorisnika']) || $_SESSION['tip'] === 3) {
    header("Location: LoginPage.php");
    exit();
}

$ulogovaniID = $_SESSION['IDkorisnika'];

$connection = new mysqli("localhost", "root", "", "bazag01");
if ($connection->connect_error) {
    die("Greška prilikom povezivanja sa bazom podataka: " . $connection->connect_error);
}

// Dohvatanje ocena ulogovanog čitaoca
$mojeOceneQuery = "SELECT IDVesti, Ocena FROM ocene WHERE IDkorisnika = $ulogovaniID";
$mojeOceneResult = $connection->query($mojeOceneQuery);
$mojeOcene = [];
while ($row = $mojeOceneResult->fetch_assoc()) {
    $mojeOcene[$row['IDVesti']] = $row['Ocena'];
}

// Dohvatanje svih autora (tip=2)
$autoriQuery = "SELECT * FROM korisnici WHERE tip = 2";
$autoriResult = $connection->query($autoriQuery);

$srodniAutori = [];

while ($autor = $autoriResult->fetch_assoc()) {
    $autorID = $autor['IDkorisnika'];

    // Ocene autora
    $autorOceneQuery = "SELECT IDVesti, Ocena FROM ocene WHERE IDkorisnika = $autorID";
    $autorOceneResult = $connection->query($autorOceneQuery);

    $suma = 0;
    $brojZajednickih = 0;

    while ($ocenaRow = $autorOceneResult->fetch_assoc()) {
        $idVesti = $ocenaRow['IDVesti'];
        $ocenaAutor = $ocenaRow['Ocena'];

        if (isset($mojeOcene[$idVesti])) {
            $suma += pow($mojeOcene[$idVesti] - $ocenaAutor, 2);
            $brojZajednickih++;
        }
    }

    if ($brojZajednickih > 0) {
        $srodniAutori[] = [
            'IDkorisnika' => $autorID,
            'Ime' => $autor['Ime'],
            'Prezime' => $autor['Prezime'],
            'Slicnost' => round($suma, 2)
        ];
    }
}

// Sortiraj po sličnosti (manje je sličnije)
usort($srodniAutori, fn($a, $b) => $a['Slicnost'] <=> $b['Slicnost']);

// Uzmi samo ID-jeve autora za prikaz vesti
$ids = array_column($srodniAutori, 'IDkorisnika');
$vesti = [];
if (count($ids) > 0) {
    $idsString = implode(',', $ids);
    $vestiQuery = "
        SELECT v.*, k.Ime, k.Prezime
        FROM vesti v
        JOIN korisnici k ON v.IDkorisnika = k.IDkorisnika
        WHERE v.IDkorisnika IN ($idsString)
        ORDER BY v.Datum DESC
    ";
    $vestiResult = $connection->query($vestiQuery);
    if ($vestiResult) {
        while ($vest = $vestiResult->fetch_assoc()) {
            $vesti[] = $vest;
        }
    }
}

$connection->close();
?>

<!DOCTYPE html> 
<html>
<head>
    <title>Vesti - srodne duše - newS</title>
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
                        <li><a href="ReadersMainPage.php">Naslovna</a></li>
                        <li>
                            <a href="">Vesti</a>
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
            </div>

            <div class="News">
                <div class="HeadingDiv">
                    <h1>Vesti - srodne duše</h1>
                </div>
                <div class="AllArticles">
                    <?php if (!empty($vesti)): ?>
                        <?php foreach ($vesti as $vest): ?>
                            <div class="OneArticle">
                                <div class="ArticleInformations">
                                    <div class="ArticleHeadingDiv">
                                        <a href="Article.php?id=<?= $vest['IDVesti'] ?>">
                                            <?= htmlspecialchars($vest['Naslov']) ?>
                                        </a>
                                    </div>
                                    <div class="ArticleDateDiv">
                                        <p>Ocena: </p><p><?= number_format($vest['Ocena'], 2) ?></p><p> | </p>
                                    </div>
                                    <div class="ArticleDateDiv">
                                        <p><?= htmlspecialchars($vest['Datum']) ?></p>
                                    </div>
                                    <div class="ArticleAbstractDiv">
                                        <p><?= htmlspecialchars($vest['Apstrakt']) ?></p>
                                    </div>
                                </div>
                                <div class="ArticleImageDiv">
                                    <img src="<?= htmlspecialchars($vest['PrvaSlikaVesti']) ?>" alt="">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nema vesti srodnih duša.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
