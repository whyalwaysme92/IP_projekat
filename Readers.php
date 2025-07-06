<?php
$connection = new mysqli("localhost", "root", "", "bazag01");

if ($connection->connect_error) {
    die("Neuspela konekcija: " . $connection->connect_error);
}

// Determine sorting method
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'alphabetical';
$orderBy = $sort === 'registration' ? 'DatumRegistracije DESC' : 'Ime ASC';

$query = "SELECT IDkorisnika, Ime, Prezime, Telefon, Email, Adresa, Slika, DatumRegistracije 
          FROM korisnici 
          WHERE Tip = '3' 
          ORDER BY $orderBy";
$result = $connection->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Čitaoci - newS</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style_Readers.css"> 
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

            <div class="Readers">
                <div class="HeadingDiv">
                    <h1>Čitaoci</h1>
                    <!-- Add dropdown for sorting -->
                    <div class="SortOptions" style="margin-top: 10px;">
                        <form method="GET" action="Readers.php">
                            <label for="sort">Sortiraj po:</label>
                            <select name="sort" id="sort" onchange="this.form.submit()">
                                <option value="alphabetical" <?= $sort === 'alphabetical' ? 'selected' : '' ?>>Abecedno</option>
                                <option value="registration" <?= $sort === 'registration' ? 'selected' : '' ?>>Datum registracije</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="AllReaders">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="OneReader">
                            <div class="ReaderImageDiv">
                                <img src="<?= !empty($row['Slika']) ? htmlspecialchars($row['Slika']) : 'images/default-profile.png'; ?>" alt="">
                            </div>
                            <div class="ReaderInformations">
                                <div class="ReaderHeadingDiv">
                                    <a href="#"> <?= htmlspecialchars($row['Ime']) . " " . htmlspecialchars($row['Prezime']); ?> </a>
                                </div>
                                <div class="ReaderEmailDiv">
                                    <a href="mailto:<?= htmlspecialchars($row['Email']); ?>">
                                        <?= htmlspecialchars($row['Email']); ?>
                                    </a>
                                </div>
                                <div class="ReaderPhoneAndAddressDiv">
                                    <div class="PhoneDiv">
                                        <p>Telefon: </p>
                                        <a href="tel:<?= htmlspecialchars($row['Telefon']); ?>">
                                            <?= htmlspecialchars($row['Telefon']); ?>
                                        </a>
                                    </div>
                                    <div class="AddressDiv">
                                        <p class="AddressText">Adresa: <?= htmlspecialchars($row['Adresa']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="ReaderButtons">
                                <a href="UpdateReader.php?id=<?= $row['IDkorisnika']; ?>">
                                    <button>Ažuriraj</button>
                                </a>
                                <a href="DeleteReader.php?id=<?= $row['IDkorisnika']; ?>" onclick="return confirm('Da li ste sigurni?');">
                                    <button>Briši</button>
                                </a>
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
