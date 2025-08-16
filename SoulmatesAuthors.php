<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['IDkorisnika'])) {
    header("Location: LoginPage.php");
    exit();
}

if ($_SESSION['tip'] != 2) { // Provera da je autor
    header("Location: LoginPage.php");
    exit();
}

$ulogovaniID = $_SESSION['IDkorisnika'];

$connection = new mysqli("localhost", "root", "", "bazag01");
if ($connection->connect_error) {
    die("Greška prilikom povezivanja sa bazom podataka: " . $connection->connect_error);
}

// Dohvatanje svih korisnika osim ulogovanog autora koji su tip 2 ili 3 (autori i čitaoci)
$query = "SELECT * FROM korisnici WHERE IDkorisnika != $ulogovaniID AND (tip = 2 OR tip = 3)";
$result = $connection->query($query);

// Dohvatanje ocena ulogovanog autora
$mojeOceneQuery = "SELECT IDVesti, Ocena FROM ocene WHERE IDkorisnika = $ulogovaniID";
$mojeOceneResult = $connection->query($mojeOceneQuery);

$mojeOcene = [];
while ($row = $mojeOceneResult->fetch_assoc()) {
    $mojeOcene[$row['IDVesti']] = $row['Ocena'];
}

$srodneDuse = [];

while ($row = $result->fetch_assoc()) {
    $drugiID = $row['IDkorisnika'];
    $drugoIme = $row['Ime'];
    $drugoPrezime = $row['Prezime'];
    $drugiEmail = $row['Email'];
    $drugiTelefon = $row['Telefon'];
    $drugaAdresa = $row['Adresa'];
    $slika = $row['Slika']; // putanja do slike iz baze

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
            'Ime' => $drugoIme,
            'Prezime' => $drugoPrezime,
            'Email' => $drugiEmail,
            'Telefon' => $drugiTelefon,
            'Adresa' => $drugaAdresa,
            'Slika' => $slika,
            'Slicnost' => $slicnost
        ];
    }
}

// Sortiranje po slicnosti (od najmanje ka vecoj)
usort($srodneDuse, function ($a, $b) {
    return $a['Slicnost'] <=> $b['Slicnost'];
});
?>

<!DOCTYPE html>
<html>
<head>
    <title>Čitaoci i autori - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_Readers.css"> 
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

        <div class="Readers">
            <div class="HeadingDiv">
                <h1>Srodne duše</h1>
            </div>
            <div class="AllReaders">
                <?php foreach ($srodneDuse as $reader): ?>
                    <div class="OneReader">
                        <div class="ReaderImageDiv">
                            <img src="<?= htmlspecialchars($reader['Slika']) ?>" alt="User Image">
                        </div>
                        <div class="ReaderInformations">
                            <div class="ReaderHeadingDiv">
                                <a href="#"><?= htmlspecialchars($reader['Ime'] . ' ' . $reader['Prezime']) ?></a>
                            </div>
                            <div class="ReaderEmailDiv">
                                <a href="mailto:<?= htmlspecialchars($reader['Email']) ?>"><?= htmlspecialchars($reader['Email']) ?></a>
                                <p> | Sličnost: </p><p><?= $reader['Slicnost'] ?></p>
                            </div>
                            <div class="ReaderPhoneAndAddressDiv">
                                <div class="PhoneDiv">
                                    <p>Telefon: </p><a href="tel:<?= htmlspecialchars($reader['Telefon']) ?>"><?= htmlspecialchars($reader['Telefon']) ?></a>
                                </div>
                                <div class="AddressDiv">
                                    <p class="AddressText">Adresa: <?= htmlspecialchars($reader['Adresa']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="ReaderButtons">
                            <button id="Update">Izbaci</button><button>Ubaci</button>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($srodneDuse)): ?>
                    <p style="padding: 20px;">Nema pronađenih srodnih duša.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
    <script src="js/scriptFile.js"></script>
</body>
</html>
